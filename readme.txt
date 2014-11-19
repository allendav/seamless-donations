=== Seamless Donations ===
Contributors: allendav, designgeneers
Donate link: http://www.allendav.com/
Tags: donation, donations, paypal, donate, non-profit, charity, gifts
Requires at least: 3.4
Tested up to: 4.0
Stable tag: 3.3.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Receive donations (now including repeating donations), track donors and send customized thank you messages with Seamless Donations for WordPress.  Works with PayPal accounts.

== Description ==

Need more than just a PayPal donation button?  Would you like to allow your visitors to donate in honor of
someone?  Invite them to subscribe to your mailing list?  Choose from desginated funds?  Do donations that
automatically repeat each month?  Allow them to mark their donation anonymous?  Track donors and donations?

Seamless Donations by Designgeneers does all this and more - and all you need to do is embed a simple shortcode
and supply your PayPal Website Payments Standard email address to start receiving donations today.

Now supporting donations by US and non-US donors (all donations are in USD - other currencies will be supported soon)

== Installation ==

1. Upload/install the Seamless Donations plugin
2. Activate the plugin
3. Set the email address for PayPal donations in the plugin settings
4. Create a new blank page (e.g. Donate Online)
5. Add the following shortcode to the page : [dgx-donate]
6. That's it - you're now receiving donations!

== Frequently Asked Questions ==

= Does this work with US and non-US PayPal accounts? =

Yes!

= Does this handle US and non-US addresses? =

Yes!

= Does this work with PayPal Website Payments Standard? =

Yes!

= Do I have to pay a monthly fee to PayPal to use this? =

No!  Website Payments Standard has no monthly cost.  They do keep 2-3% of the donation.

= Can I customize the thank you message emailed to donors? =

Yes!

= Can I have multiple emails addresses receive notification when a donation is made? =

Yes!

== Screenshots ==

1. The donation form your visitor sees
2. Optional tribute gift section expanded
3. Dashboard >> Seamless Donations Main Menu
4. Dashboard >> Donations
5. Dashboard >> Donors
6. Dashboard >> Thank You Email Templates

== Changelog ==

= 3.3.0 =
* Changed PayPal IPN reply to use TLS instead of SSL because of the POODLE vulnerability
* Changed PayPal IPN reply to better handle unexpected characters and avoid IPN verification failure - props smarques

= 3.2.4 =
* Fixed: Don't start a PHP session if one has already been started - props nikdow and gingrichdk

= 3.2.3 =
* Fixed: Unwanted extra space in front of Add me to your mailing list prompt

= 3.2.2 =
* Added Currency Support: Brazilian Real, Czech Krona, Danish Krone, Hong Kong Dollar, Hungarian Forint, Israeli New Sheqel
* Added Currency Support: Malaysian Ringit, Mexican Peso, Norwegian Krone, New Zealand Dollar, Philippine Peso, Polish Zloty
* Added Currency Support: Russian Ruble, Singapore Dollar, Swedish Krona, Swiss Franc, Taiwan New Dollar, Thai Bhat, Turkish Lira

= 3.2.1 =
* Added: Occupation field to donation form and to donation detail in admin
* Added: Employer name to donation detail in admin
* Added: Employer and occupation fields to report

= 3.2.0 =
* Added: More control over which parts of the donation form appear

= 3.1.0 =
* Added: Filter for donation item name
* Added IDs for form sections to allow for more styling of the donation form

= 3.0.3 =
* Fixed: A few strings were not properly marked for translation.

= 3.0.2 =
* Fixed: Bug: Removed unused variable that was causing PHP warning

= 3.0.1 =
* Fixed: Bug: Was using admin_print_styles to enqueue admin CSS.  Switched to correct hook - admin_enqueue_scripts

= 3.0.0 =
* Added: Gift Aid checkbox for UK donors
* Fixed: Bug that would cause IPN notifications to not be received

= 2.9.0 =
* Added: Optional employer match section to donation form - props Jamie Summerlin
* Fixed: Javascript error in admin on settings page

= 2.8.2 =
* Fixed: Don't require postal code for countries that don't require postal codes
* Fixed: International tribute gift addresses were not displaying country information in donation details

= 2.8.1 =
* Added: Support for non US currencies: Australian Dollar, Canadian Dollar, Euro, Pound Sterling, and Japanese Yen

= 2.8.0 =
* Added: Support for specifying name for emails to donors (instead of WordPress)
* Added: Automatic textarea height increase for email templates and thank you page
* Fixed: Bug that would allow invalid email address to cause email to donor to not go out (defaults to admin email now)

= 2.7.0 =
* Added: Support for donors located outside the United States

= 2.6.0 =
* Added: Support for repeating donations
* Added: Support for loading scripts in footer
* Added: Greyed out donate button on click
* Added: Prompt to confirm before deleting a donation in admin
* Added: Seamless Donations news feed to main plugin admin page
* Added: Help/FAQ submenu
* Added: Replaced main admin page buttons with Quick Links
* Added: Display of PayPal IPN URL in Settings
* Added: More logging to PayPal IPN for troubleshooting hosts that don't support fsockopen to PayPal on 443
* Fixed: Bug in displaying thank you after completing donation
* Fixed: Changed admin log formatting to make reading, cutting and pasting easier
* Fixed: Major update to admin pages code in support of localization

= 2.5.0 =
* Added support for designated funds
* Fixed: A couple warnings when saving changes to thank you email templates.

= 2.4.4 =
* Fixed: Cleaned up warnings when run with WP_DEBUG

= 2.4.3 =
* Fixed: Changed form submit target to _top most window (in case theme places content in iframes)
* Fixed: Updated plugin URI to point to allendav.com

= 2.4.2 =
* Automatically trim whitespace from PayPal email address to avoid common validation error and improve usability.

= 2.4.1 =
* Changed mail function to use WordPress wp_mail instead of PHP mail - this should help avoid dropped emails

= 2.4.0 =
* Added the ability to export donation information to spreadsheet (CSV - comma separated values)

= 2.3.0 =
* Added a setting to allow you to turn the Tribute Gift section of the form off if you'd like

= 2.2.0 =
* Added the ability to delete a donation (e.g. if you create a test donation)

= 2.1.7 =
* Rolled back change in 2.1.6 for ajax display due to unanticipated problem with search

= 2.1.6 =
* Added ajax error display to aid in debugging certain users not being able to complete donations on their sites

= 2.1.5 =
* Changed plugin name to simply Seamless Donations

= 2.1.4 =
* Added logging, log menu item and log display to help troubleshoot IPN problems

= 2.1.3 =
* Changed PayPal cmd from _cart to _donations to avoid donations getting delayed

= 2.1.2 =
* Removed tax deductible from donation form, since not everyone using the plugin is a charity

= 2.1.1 =
* Added missing states - AK and AL - to donation form
* Added more checks for invalid donation amounts (minimum donation is set to 1.00)
* Added support for WordPress installations using old-style (not pretty) permalinks
* Fix bug that caused memorial gift checkbox to be ignored

= 2.1.0 =
* Added new suggested giving amounts
* Now allows you to choose which suggested giving amounts are displayed on the donation form
* Added ability to change the default state for the donation form

= 2.0.2 =
* Initial release to WordPress.Org repository
