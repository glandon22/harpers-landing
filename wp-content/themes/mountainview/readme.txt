=== Mountainview ===
Contributors: MotoPress
Tags: translation-ready, custom-background, theme-options, custom-menu, threaded-comments
Requires at least: 4.6
Tested up to: 5.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Property owners can use this WordPress theme to rent out unlimited properties and manage direct bookings. Mountainview is bundled with a popular MotoPress Hotel Booking plugin enabling you to list properties in a beautiful way with all amenities, services, photos and other details. The system comes with the real-life search availability form, different booking confirmation modes (including automatic booking confirmations by payment with PayPal) and more.

== Installation ==
1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now. Click Activate.
3. Install required plugins.
4. If you create a new website, you may import sample data in Appearance > Import Demo Data.

== Copyright ==
Mountainview WordPress Theme, Copyright (C) 2019, MotoPress
Mountainview is distributed under the terms of the GNU GPL.

== Frequently Asked Questions ==
= How do I add social icons to menu? =
To add social icons, navigate to WordPress Customizer > Menus > Add Menu > Add Custom links with the appropriate names (e.g. Twitter, Facebook) and links to your social media accounts. In the Display Location menu choose the "Social" menu and save.

== Changelog ==

= 1.3.1, Apr 15 2019 =
* Hotel Booking plugin updated to version 3.3.0.
  * Improved compatibility with WPML plugin.
  * Fixed the bug appeared while calculating the subtotal amount in Price Breakdown when a discount code is applied.
  * Added Hotel Booking Extensions page. Developers may opt-out of displaying this page via "mphb_show_extension_links" filter.
  * Booking Calendar improvements:
    * Tooltip extended with the customer data: full name, email, phone, guests number, imported bookings info.
    * Added a popup option to display the detailed booking information.
  * Bookings table improvements:
    * Added a column with booked accommodations.
    * Added the ability to filter bookings by accommodation type.
    * Added the ability to search bookings by First Name, Last Name, Check-in Date, Check-out Date, Phone, Price, etc.
  * Added a Service option that enables to specify the number of times guest would like to order this service.

= 1.3.0, Feb 14 2019 =
* Hotel Booking plugin updated to version 3.1.0.
  * Added new blocks to Gutenberg.
  * Added option to switch to the new block editor for Accommodation Types and Services in plugin settings.
* Added option to set the Price Breakdown to be unfolded by default.
* Improved design of Accommodation titles in Price Breakdown for better user experience.
* Added styles for Hotel Booking Reviews addon.

= 1.2.0, Jan 15 2019 =
* Added theme support for WordPress 5.0 (Gutenberg).
* Hotel Booking plugin updated to version 3.0.3.

= 1.1.0, Sep 18 2018 =
* Hotel Booking plugin updated to version 3.0.0:
  * Introducing attributes. By using the attributes you are able to define extra accommodation data such as location and type and use these attributes in the search availability form as advanced search filters.
  * Improved the way to display the booking rules in the availability calendar.
  * Added the new payment method to pay on arrival.
  * Added the ability to create fixed amount coupon codes.
  * Added the availability to send multiple emails to notify the administrator and other staff about new booking.
  * Fixed the bug appeared in the Braintree payment method if a few plugins for making payment are set up.
  * Added the ability to set the default country on the checkout page.

= 1.0.0, Aug 2 2018 =
* Hotel Booking plugin updated to version 2.7.6:
  * A new way to display available/unavailable dates in a calendar using a diagonal line (half-booked day). This will properly show your guests that they are able to use the same date as check in/out one.
  * Disabled predefined parameters for Adults and Children on the checkout page to let guests have more perceived control over options they choose.
  * Fixed the issue with booking rules and WPML. Now all translations of accommodations are not displayed in a list and the booking rules are applied to all translations.
  * Fixed the issue with Stripe when creating a booking from the backend.
  * Fixed the issue with the booking rules not applying while checking an accommodation availability with the "Skip search results" enabled.
  * Added a new feature "Guest Management". It is currently in beta and applied only to the frontend. Here are the main options of this feature:
    * Hide "adults" and "children" fields within search availability forms.
    * Disable "children" option for the website (hide "children" field and use Guests label instead).
    * Disable "adults" and "children" options.
  * Replaced "Per adult" label with a more catch-all term "per guest" for Services.
  * Increased the number of digits after comma for setting a per-night price. This will help you set accurate prices for weekly, monthly and custom rates.
  * Improved the way to display a rate pricing on the checkout page: the price is updated automatically based on the number of guests if there are any per-guest price variables.
  * Added the Availability Calendar shortcode.
  * Added sorting parameters to shortcodes.
  * Added all missing currencies to the list of currencies.
* Added the ability to change primary colors.
* Minor improvements in design.

= 0.1.2, Jul 10 2018 =
* Minor bugfixes and improvements.

= 0.1.0, Jul 5 2018 =
* Initial release.

== Credits ==

* Based on Underscores http://underscores.me/, (C) 2012-2016 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html).
* normalize.css http://necolas.github.io/normalize.css/, (C) 2012-2016 Nicolas Gallagher and Jonathan Neal, [MIT](http://opensource.org/licenses/MIT).