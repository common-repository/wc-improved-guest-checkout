=== Improved Guest checkout for WooCommerce ===
Contributors: jasperdragonet
Tags: woocommerce, checkout, confirm email, guest account
Requires at least: 5.7
Tested up to: 5.8.*
Requires PHP: 7.2
Stable tag: 7.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
This plugin extends WooCommerce and require the guest confirm their email and combine orders when using the same email

== Description ==
 
This plugin creates extends WooCommerce by letting the guest user confirm thier email and combine orders when guest users use the same email.

An extra email field is created for guest users in the checkout screen. During the checkout the provided emails are checked if they are corresponding.
This check is done in the front-end by Javascript and in the AJAX call with php.

During the checkout as a guest the guest account is saved so when this customer will create a account later all the old orders are linked to this customer.
In the admin there is a 'created_by_webshop' column that will display yes when the user was a guest and it's created by the system.

 
== Installation ==

1. Download the plugin.
2. Activate the plugin.

 
== Screenshots ==
 
1. A preview of the confirm field
 
== Changelog ==

= 1.5 =
* Tested in WP 5.8

= 1.4 =
* Store the VAT number in the user meta when billing_vat_number is given
* The user field vat_number is added when billing_vat_number is not empty

= 1.3 =
* The confirm email field is now always behind the email field.

= 1.2 =
* Store billing_email_2 in WC session so the value still exists after reload.

= 1.1 =
* Make sure that the confirm email field is next to the email field.

= 1.0 =
* Created Admin Columns
* Extra email field
* Chek on extra email field
* Initial Release.