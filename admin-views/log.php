<?php

/* Copyright 2013 Allen Snook (email: allendav@allendav.com) */

class Dgx_Donate_Admin_Log_View {
	function __construct() {
		add_action( 'dgx_donate_menu', array( $this, 'menu_item' ), 15 );
	}
	
	function menu_item() {
		add_submenu_page(
			'dgx_donate_menu_page',
			__( 'Log', 'dgx-donate' ),
			__( 'Log', 'dgx-donate' ),
			'manage_options',
			'dgx_donate_debug_log_page',
			array( $this, 'menu_page' )
		);
	}
	
	function menu_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'dgx-donate' ) );
		}

		// If we have form arguments, we must validate the nonce
		if ( count( $_POST ) ) {
			$nonce = $_POST['dgx_donate_log_nonce'];
			if ( ! wp_verify_nonce($nonce, 'dgx_donate_log_nonce' ) ) {
				wp_die( __( 'You do not have sufficient permissions to access this page.', 'dgx-donate' ) );
			}
		}

		// Save default state
		$log_command = ( isset( $_POST['dgx_donate_log_cmd'] ) ) ? $_POST['dgx_donate_log_cmd'] : '';

		// The only command we do right now is to delete the log
		if ( ! empty( $log_command ) ) {
			delete_option( 'dgx_donate_log' );
			$message = __( 'Log cleared', 'dgx-donate' );
		}

		echo "<div class='wrap'>";
		echo "<div id='icon-edit-pages' class='icon32'></div>";
		echo "<h2>" . __( 'Log', 'dgx-donate' ) . "</h2>";

		// Display any message
		if (!empty($message)) {
			echo "<div id='message' class='updated below-h2'>\n";
			echo "<p>" . esc_html( $message ) . "</p>\n";
			echo "</div>\n";
		}

		$debug_log_content = get_option( 'dgx_donate_log' );

		if ( empty( $debug_log_content ) ) {
			echo "<p>" . esc_html__( 'The log is empty.', 'dgx-donate' ) . "</p>";
		} else {
			echo "<p><pre>";
			foreach ($debug_log_content as $debug_log_entry) {
				echo esc_html( $debug_log_entry ) . "\n";
			}
			echo "</pre></p>";

			// Since there is data in the log, show a clear-log button
			// Set up a nonce
			$nonce = wp_create_nonce( 'dgx_donate_log_nonce' );

			echo "<form method='POST' action=''>";
			echo "<input type='hidden' name='dgx_donate_log_nonce' value='" . esc_attr( $nonce ) . "' />";
			echo "<input type='hidden' name='dgx_donate_log_cmd' value='clear' />";
			echo "<p><input id='submit' class='button' type='submit' value='" . esc_attr__( 'Clear Log', 'dgx-donate' ) . "' name='submit' /></p>";
			echo "</form>";
		}

		do_action( 'dgx_donate_admin_footer' );

		echo "</div>"; 
	}
}

$dgx_donate_admin_log_view = new Dgx_Donate_Admin_Log_View();
