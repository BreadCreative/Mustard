=== YITH WooCommerce Multi-step Checkout ===

Contributors: yithemes
Tags: woocommerce, multi-step checkout, woocommerce multistep checkout, woocommerce checkout, shop checkout, multistep, multi step, multi-step, wc, wc checkout, wc multi-step checkout, wc multistep checkout, yit, yith, yithemes
Requires at least: 4.0
Tested up to: 4.7.2
Stable tag: 1.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Make your checkout page fluid with YITH WooCommerce Multi-step Checkout, a plugin that helps make checkout faster, tidier and more user-frienldy

== Description ==

Do you know benefits of a multi-step checkout page in an e-commerce? Your customers will be able to purchase in a few moves and they will add all other information required at a later stage. This reduces dramatically the percentage of users who abandon the cart and this means that your sales will increase. To allow you to change your shop and adapt it to this pattern, YIThemes has developed a tool that you cannot do without: YITH WooCommerce Multi-step Checkout. Download it now, it's free!

Main Feature:

It splits default WooCommerce checkout page into multiple consecutive steps

== Installation ==

1. Unzip the downloaded zip file.
2. Upload the plugin folder into the `wp-content/plugins/` directory of your WordPress site.
3. Activate `YITH WooCommerce Multi-step Checkout` from Plugins page

== Frequently Asked Questions ==

Is the plugin compatible with my theme?

This plugin has been realised using only WooCommerce standard templates. If your theme is using WooCommerce standard hooks and actions, the plugin will work well.


== Screenshots ==

1. Step 1: Login
2. Step 2: Billing Details
3. Step 3: Shipping Details
4. Step 4: Order Information
5. Step 4: Coupon code box
6. Step 5: Payment Information
7. Place Order: Error Information
8. Checkout Timeline
9. Admin: Enable Multi-step Checkout

== Changelog ==

= 1.4.0 - Released on Feb 24, 2017 =

* New: Support to WooCoomerce 2.7-beta3

= 1.3.12 - Released on Jan 09, 2017 =

* Fix: Previous button issue if returning customer login box option disabled

= 1.3.11 - Released on Jan 09, 2017 =

* Fix: Customers can't use points for discount with WooCommerce Points and Rewards
* Fix: Storefront compatibility file doesn't exists
* Fix: TheRetailer compatibility file doesn't exists

= 1.3.10 - Released on Dec 28, 2016 =

* Added: Support to WooCommerce Points ad Rewards

= 1.3.9 - Released on Dec 05, 2016 =

* Added: Support to WordPress 4.7

= 1.3.8 - Released on Nov 29, 2016 =

* Fixed: Unable to deactivate free version
* Fixed: No label on next button if user are not logged in

= 1.3.7 - Released on Nov 23, 2016 =

* Added: Support to The Retailer theme
* Added: Support to Storefront theme
* Added: Payment section header
* Fixed: Removed duplicate alt class in next/prev button
* Fixed: Order Info and Payments tab don't show up after plugin update

= 1.3.6 - Release on Nov 09, 2016 =

* Added: Support to Avada 5
* Added: Support to WooCommerce SecureSubmit Payment Gateway plugin
* Added: Support to WooCommerce CurabillCw Payment Gateway plugin
* Added: Support to WooCommerce PostFinanceCw Payment Gateway plugin
* Added: Support to WooCommerce BarclaycardCw Payment Gateway plugin
* Added: Option to change the label for next button in login step
* Tweak: Prevent duplicate payments id in for-checkout php DOM
* Fixed: Missing $checkout object in woocommerce_before_checkout_shipping_form action
* Fixed: Empty Shipping tab
* Fixed: Empty Order review and Payment tab on Avada 5.0.3

= 1.3.5 - Released on Oct 17, 2016 =

* Added: yith_wcms_form_checkout_login_message hook for return customer message on login step
* Tweak: Add support to deprecated method WC()->cart->get_checkout_url()
* Tweak: Removed old options record
* Fixed: No address filled in after login at step


= 1.3.4 - Released on Aug 31, 2016 =

* Tweak: Update plugin core framework

= 1.3.3 - Released on Jul 20, 2016 =

* Added: Support to Avada theme Version 4.0.x
* Added: Support to WooCommerce checkout add-ons
* Tweak: Code revision for increase performance
* Fixed: Timeline Style issue on mobile device
* Fixed: Blank screen on Payment tab
* Fixed: Blank screen on Payment tab with some payment gateway

= 1.3.2 - Released on May 25, 2016 =

* Fixed: Billing address are shown in login step

= 1.3.1 - Released on May 24, 2016 =

* Added: Support to WooCommerce 2.6-beta-2
* Fixed: Unable to click on next step wityh guest checkout enabled
* Fixed: Unable to remove returning customer login reminder on the "Checkout" page

= 1.3.0 - Released on May 05, 2016 =

* Added: Support to YITH WooCommerce Gift Cards
* Tweak: Cached javascript file doesn't reload after plugin update
* Fixed: Translation problem in login form

= 1.2.1 - Released on Apr 14, 2016 =

* Added: Support to WordPress 4.5
* Updated: Language Files

= 1.2.0 - Released on Apr 04, 2016 =

* Added: Support to WooCommerce Ship to Multiple Addresses
* Fixed: Duplicated coupon box with Avada Theme
* Fixed: Unable to go to next step for not logged in users with Chrome browser

= 1.1.2 - Released on Feb 02, 2016 =

* Added: yith_wcms_load_checkout_template_from_plugin hook to enable main template overriding by theme
* Added: Support to WooCommerce Gateway Stripe plugin
* Fixed: Place order button text doesn't work

= 1.1.1 - Released on Jan 12, 2016 =

* Updated: Plugin core framework

= 1.1.0 - Released on Jan 08, 2016 =

* Added: Support to WooCommerce 2.5-RC1
* Added: Support to WordPress 4.4.1
* Added: wpml-config.xml file for WPML Support
* Tweak: Plugin core framework
* Updated: All language files

= 1.0.10 - Released on Oct 30, 2015 =

* Fixed: issue in paying old unpaid orders

= 1.0.9 - Released on Oct 23, 2015 =

* Added: Spanish translation (by Daniel Aparisi)
* Tweak: Performance improved with new plugin core 2.0

= 1.0.8 - Released on Oct 09, 2015 =

* Fixed: Fatal error on form-checkout.php template if overwrite by theme

= 1.0.7 - Released on Sept 18, 2015 =

* Added: Italian translation (By Lidia Cirrone)
* Fixed: jQuery Issue With Payment Methods

= 1.0.6 - Released on Aug 25, 2015 =

* Fixed: Navigation button issue with WooCommerce 2.4 and Wordpress 4.3

= 1.0.5 - Released on Aug 11, 2015 =

* Added: Support to WooCommerce 2.4

= 1.0.4 - Released on Aug 07, 2015 =

* Fixed: Next button missing

= 1.0.3 - Released on Jul 29, 2015 =

* Fixed: Missing "multistep.min.js" file in assets/js

= 1.0.2 - Released on Jul 24, 2015 =

* Fixed: Warning on checkout login page

= 1.0.1 - Released on Jul 22, 2015 =

* Fixed: minor bugs in frontend

= 1.0.0 - Released on Jul 07, 2015 =

* Initial release

== Translators ==

= Available Languages =
* English (Default)
* Spanish

If you have created your own language pack, or have an update for an existing one, you can send [gettext PO and MO file](http://codex.wordpress.org/Translating_WordPress "Translating WordPress")
[use](http://yithemes.com/contact/ "Your Inspiration Themes"), so we can bundle it into YITH WooCommerce Multi-step Checkout.

== Upgrade notice ==

= 1.0.10 =

Paying old unpaid orders

= 1.0.6 = 

Navigation button issue with WooCommerce 2.4 and Wordpress 4.3

= 1.0.0 =

Initial release