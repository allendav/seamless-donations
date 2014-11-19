<?php
/**
  * Seamless Donations (Dgx-Donate) IPN Handler class
  * Copyright 2013 Allen Snook (email: allendav@allendav.com)
  * GPL2
  */ 

// Load WordPress
include "../../../wp-config.php";

// Load Seamless Donations Core
include_once "./dgx-donate.php";

class Dgx_Donate_IPN_Handler {

	var $chat_back_url  = "tls://www.paypal.com";
	var $host_header    = "Host: www.paypal.com\r\n";
	var $post_data      = array();
	var $session_id     = '';
	var $transaction_id = '';

	public function __construct() {
		dgx_donate_debug_log( '----------------------------------------' );
		dgx_donate_debug_log( 'IPN processing start' );

		// Grab all the post data
		$post = file_get_contents( 'php://input' );
		parse_str( $post, $data );
		$this->post_data = $data;

		// Set up for production or test
		$this->configure_for_production_or_test();

		// Extract the session and transaction IDs from the POST
		$this->get_ids_from_post();

		if ( ! empty( $this->session_id ) ) {
			$response = $this->reply_to_paypal();

			if ( "VERIFIED" == $response ) {
				$this->handle_verified_ipn();
			} else if ( "INVALID" == $response ) {
				$this->handle_invalid_ipn();
			} else {
				$this->handle_unrecognized_ipn( $response );
			}
		} else {
			dgx_donate_debug_log( 'Null IPN (Empty session id).  Nothing to do.' );
		}

		dgx_donate_debug_log( 'IPN processing complete' );
	}

	function configure_for_production_or_test() {
		if ( "SANDBOX" == get_option( 'dgx_donate_paypal_server' ) ) {
			$this->chat_back_url = "tls://www.sandbox.paypal.com";
			$this->host_header   = "Host: www.sandbox.paypal.com\r\n";
		}
	}

	function get_ids_from_post() {
		$this->session_id = isset( $this->post_data[ "custom" ] ) ? $this->post_data[ "custom" ] : '';
		$this->transaction_id = isset( $this->post_data[ "txn_id" ] ) ? $this->post_data[ "txn_id" ] : '';
	}

	function reply_to_paypal() {
		$request_data = $this->post_data;
		$request_data['cmd'] = '_notify-validate';
		$request = http_build_query( $request_data );

		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= $this->host_header;
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen( $request ) . "\r\n\r\n";

		$response = '';

		$fp = fsockopen( $this->chat_back_url, 443, $errno, $errstr, 30 );
		if ( $fp ) {
			fputs( $fp, $header . $request );

			$done = false;
			do {
				if ( feof( $fp ) ) {
					$done = true;
				} else {
					$response = fgets( $fp, 1024 );
					$done = in_array( $response, array( "VERIFIED", "INVALID" ) );
				}
			} while ( ! $done );
		} else {
			dgx_donate_debug_log( "IPN failed ( unable to open chatbackurl, url = {$this->chat_back_url}, errno = $errno, errstr = $errstr )" );
		}
		fclose ($fp);

		return $response;
	}

	function handle_verified_ipn() {
		$payment_status = $this->post_data["payment_status"];

		dgx_donate_debug_log( "IPN VERIFIED for session ID {$this->session_id}" );
		dgx_donate_debug_log( "Payment status = {$payment_status}" );

		if ( "Completed" == $payment_status ) {
			// Check if we've already logged a transaction with this same transaction id 
			$donation_id = get_donations_by_meta( '_dgx_donate_transaction_id', $this->transaction_id, 1 );

			if ( 0 == count( $donation_id ) ) {
				// We haven't seen this transaction ID already

				// See if a donation for this session ID already exists
				$donation_id = get_donations_by_meta( '_dgx_donate_session_id', $this->session_id, 1 );

				if ( 0 == count( $donation_id ) ) {
					// We haven't seen this session ID already

					// Retrieve the data from transient
					$donation_form_data = get_transient( $this->session_id );
	
					if ( ! empty( $donation_form_data ) ) {
						// Create a donation record
						$donation_id = dgx_donate_create_donation_from_transient_data( $donation_form_data );
						dgx_donate_debug_log( "Created donation {$donation_id} from form data in transient for sessionID {$this->session_id}" );

						// Clear the transient
						delete_transient( $this->session_id );
					} else {
						// We have a session_id but no transient (the admin might have
						// deleted all previous donations in a recurring donation for
						// some reason) - so we will have to create a donation record
						// from the data supplied by PayPal

						$donation_id = dgx_donate_create_donation_from_paypal_data( $this->post_data );
						dgx_donate_debug_log( "Created donation {$donation_id} from PayPal data (no transient data found)" );
					}
				} else {
					// We have seen this session ID already, create a new donation record for this new transaction

					// But first, flatten the array returned by get_donations_by_meta for _dgx_donate_session_id
					$donation_id = $donation_id[0];
					
					$old_donation_id = $donation_id;
					$donation_id = dgx_donate_create_donation_from_donation( $old_donation_id );
					dgx_donate_debug_log( "Created donation {$donation_id} (recurring donation, donor data copied from donation {$old_donation_id}" );
				}
			} else {
				// We've seen this transaction ID already - ignore it
				$donation_id = '';
				dgx_donate_debug_log( "Transaction ID {$this->transaction_id} already handled - ignoring" );
			}

			if ( ! empty( $donation_id ) )  {
				// Update the raw paypal data
				update_post_meta( $donation_id, '_dgx_donate_transaction_id', $this->transaction_id );
				update_post_meta( $donation_id, '_dgx_donate_payment_processor', 'PAYPALSTD' );
				update_post_meta( $donation_id, '_dgx_donate_payment_processor_data', $this->post_data );
				// save the currency of the transaction
				$currency_code = $this->post_data['mc_currency'];
				dgx_donate_debug_log( "Payment currency = {$currency_code}" );
				update_post_meta( $donation_id, '_dgx_donate_donation_currency', $currency_code );
			}

			// @todo - send different notification for recurring?

			// Send admin notification
			dgx_donate_send_donation_notification( $donation_id );
			// Send donor notification
			dgx_donate_send_thank_you_email( $donation_id );
		}
	}

	function handle_invalid_ipn() {
		dgx_donate_debug_log( "IPN failed (INVALID) for sessionID {$this->session_id}" );
	}

	function handle_unrecognized_ipn( $paypal_response ) {
		dgx_donate_debug_log( "IPN failed (unrecognized response) for sessionID {$this->session_id}" );
		dgx_donate_debug_log( $paypal_response );
	}
}

$dgx_donate_ipn_responder = new Dgx_Donate_IPN_Handler();

/**
  * We cannot send nothing, so send back just a simple content-type message
  */

echo "content-type: text/plain\n\n";
