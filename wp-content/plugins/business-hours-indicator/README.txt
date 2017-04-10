=== Business Hours Indicator ===
Contributors: maartenbelmans
Donate link: https://www.paypal.me/maartenbelmans
Tags: business hours, opening times, opening hours, open indication, currently open, business hours overview, indicator, closed, open times, closing times
Requires at least: 3.7
Tested up to: 4.7.3
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display your business hours and if you are currently open or closed, with countdown to next opening. Show or hide content only when open/closed.

== Description ==

Display your business hours and if you are currently open or closed, with countdown to next opening. Show or hide content only when open/closed.

* [&raquo; Examples](https://businesshourplugin.maartenbelmans.com/#examples)
* [&raquo; Documentation](https://businesshourplugin.maartenbelmans.com/documentation/)
* [&raquo; Pro Version](https://businesshourplugin.maartenbelmans.com/)
* &raquo; Check out all features below.

This plugin does 4 things:

* Add an indication of being currently open or closed, like on Facebook. This supports countdown to your next opening times.
* Show your business hours on your website.
* Support conditional logic: show or hide content only when open or closed.
* All of this supports multiple business locations.

Just enter your location(s) and opening times in the settings page, and use the provided shortcodes or widgets to display the info
anywhere on your website.

More info [can be found here](http://maartenbelmans.com/businesshoursplugin/)

REQUIREMENTS

* PHP 5.4 or higher
* WordPress 3.7 or higher

**FREE FEATURES**

General features:

* Shortcode to display business hours
* Widget to display business hours
* Shortcode to display if you're currently open/closed
* Widget to display if you're currently open/closed
* Shortcode to display content only when you're open
* Shortcode to display content only when you're closed
* Choose your prefered time zone
* Display times in 12 or 24 hour format
* Enter multiple locations for more businesses (up to 3 in the free version)
* Include special hours such as holidays
* Include vacation hours
* Highlight the current day
* Multi language support: NL, GR, EN, DE, ES, IT, FR, BG, SE, SK included
* And more!

Displaying opening times

* Show the opening hours in a table
* Show the opening hours inline
* Consolidate the output: group days with the same opening hours
* Show/hide holiday hours
* Show/hide vacation hours
* Highlight the current day

Currently open/closed Indication:

* Edit the "we're currently open" message
* Edit the "we're currently closed" message
* Include the current time in the output
* Include the current day in the output
* Add an opening/closing soon warning like "hurry, we're closing in 35 minutes"


**PRO FEATURES**

* Caching features (coming soon)
* SEO features
* Enter unlimited multiple locations for more businesses
* Multiple time slots/day for when you close at noon
* Premium support
* Receive updates & bugfixes
* Show abbreviated days in outputs
* Only show today's opening times
* Customize output with line breaks & separators
* Set how many minutes in advance to show opening/closing soon warning
* More flexibility
* Priority feauture requests.

Find out more about the [pro version here](http://maartenbelmans.com/businesshoursplugin/)

== Installation ==

Installing the Business Hours Indicator plugin is very easy:

1. Install from the WordPress Dashboard > Plugin page
2. Or manually download the plugin and extract to wp-content/plugins/
3. Activate the plugin
4. Go to Wordpress Dashboard > Settings > Business Hours Indicator
5. Enter your location, daily opening hours, and fiddle with more settings if you want
6. Use the shortcode `[mbhi location="my location"]` to display the output on pages or posts
7. Or use the PHP code `do_shortcode('[mbhi location="my location"]')` to display the output anywhere in your theme


== Frequently Asked Questions ==

= Does these shortcodes need extra options? =

Yes, at least 1. You should give it a 'location' attribute. If you don't, the first location is used.

= How can I style the business hours overview? =

The code exposes enough CSS classes to give you many styling options. You can
find all classes [here](https://businesshourplugin.maartenbelmans.com/docs/free-documentation/styling/all-exposed-css-classes/).

== Screenshots ==

1. Various examples of what this plugin can do.
2. Settings screen.
3. Enter opening times for a location.
4. Example of how it could look like on the frontend.

== Changelog ==

= version 2.0.0 =
 * Rewritten the core of the plugin to implement features faster.
 * Fixed a few edge-case bugs.

= Version 1.8.8 =
 * Added Slovak language to translations
 * Verified WP 4.7.1 compatibility

= Version 1.8.7 =
 * Getting rid of closure in favor of normal function. This disables warnings for some versions of WP.

= Version 1.8.6 =
 * Finally added 2 widgets to display (a) your business hours and (b) indication of being currently open/closed.
 * UI changes.

= Version 1.8.5 =
 * Fixed php warning 'invalid foreach'.

= Version 1.8.4 =
 * Added Bulgarian language (special thanks to D. Stoykow)

= Version 1.8.3 =
 * Addition upon 1.8.2

= Version 1.8.2 =

 * Fixed an issue with PHP 5.3/5.4 versions.

= Version 1.8.1 =

 * Fixed an issue where some WooCommerce websites had a faulty system status.

= Version 1.8.0 =

* Bugfixes
* Rewritten frontend
* Updated languages
* Added Swedish language

= Version 1.7.4 =

* Bugfix: when you aren't open for a few days, the frontend gave a silent error.

= Version 1.7.3 =

* Small bugfix in admin javascript where users weren't able to add multiple locations without refreshing the page.

= version 1.7.2 =

* Proper support for the shortcodes in widgets.
* Remove array literals to support php version 5.3.
* Update documentation.
* Fix bug with ifopen/ifclosed shortcodes for multiple locations.

= version 1.7.1 =

* Fixed a bug where do_shortcode() doesn't show content.

= version 1.7 =

* Added a help tab with shortcodes info.
* shortcodes can now override dashboard settings via attributes.
* Added various new functionality for displaying opening hours.

= Version 1.6 =

* Bugfix where holidays couldn't be denoted as 'closed'.

= Version 1.5.1 =

* Bugfix between Woocommerce and this plugin.

= Version 1.5 =

* Added more CSS classes for your styling needs.
* Ability to print a consolidated (= shortened) opening hours table.
* Reorganized and added some settings.

= Version 1.4 =

* Small bugfixes

= Version 1.3 =

* Added [mbhi_ifclosed] shortcode
* Added [mbhi_ifopen] shortcode

= Version 1.2 =

MAJOR CHANGE &mdash; You'll have to re-enter your settings!

* Added locations
* Added vacation/holiday exception
* Changed settings screen
* Added more settings
* Added a new shortcode to display a location's business hours table

= Version 1.1 =

* Code enhancements
* Approximation: include a different sentence when your business is almost opening/closing.

= Version 1.0 =

 * Initial version