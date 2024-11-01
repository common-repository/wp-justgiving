=== WP-JustGiving ===
Contributors: samcleathero
Donate link: http://samcleathero.co.uk/wp-justgiving/donate
Tags: justgiving, just, giving, fundraise, fundraising, donate, donations, charity, charities
Requires at least: 3.0.1
Tested up to: 4.3.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to integrate your WordPress site with a JustGiving fundraising page.

== Description ==

**NOTE: This plugin is still in development, and at the moment doesn't do very much. If you have any suggestions for the plugin, please [contact me](http://samcleathero.co.uk/contact).**

This plugin allows you to integrate your WordPress site with a JustGiving fundraising page, via the JustGiving API.

**Current features:**

*   Donations list using `[wpjg_donations]` shortcode.

*   Donation details using `[wpjg_details]` shortcode.

**Planned features:**

*   Sidebar widget with fundraising page information.

*   Shortcode for displaying fundraising page information.

*   Customisable options for displaying donations list and donation details.


To use this plugin, you will need an API key from JustGiving, which can be obtained by signing up
[here](http://apimanagement.justgiving.com).

== Installation ==

1. Upload the `wp-justgiving` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Enter your JustGiving API key and short page name on the 'WP-JustGiving' page in the 'Settings' menu.
4. Add the required shortcodes (currently either `[wpjg_donations]` or `[wpjg_details]`) to your pages.

Note: For the `[wpjg_details]` shortcode to work, a JustGiving donation ID must be provided by appending
`?donationId=XXXXXXXX` to the page URL (obviously replacing the Xs with the ID).

== Frequently Asked Questions ==

= How do I use this plugin? =

Once you've installed the plugin, set it up by providing an API key and short page name on the 'WP-JustGiving' page in
the 'Settings' menu. You can then use the shortcodes (currently either `[wpjg_donations]` or `[wpjg_details]`) on your
pages.

= How do I get an API key? =

Sign up [here](http://apimanagement.justgiving.com).

= What's a short page name? =

This is part of the URL of your JustGiving fundraising page. It is typically a person's name (for example, "John-Smith").

= How does the donation details shortcode work? =

Once you've put the shortcode on a page, append `/?donationId=XXXXXXXX` to the page's URL (replacing the Xs with a JustGiving
donation ID). The page will then display details of the donation.

= This plugin doesn't do want I want. Can you make it please? =

Maybe. I built this plugin for use on a website I was building, so its original use was limited, but I may expand on it in
the future.

== Screenshots ==

Coming soon.

== Changelog ==

= 0.1 =
* Initial beta release.