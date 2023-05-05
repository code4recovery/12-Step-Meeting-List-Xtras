=== 12 Step Meeting List Xtras ===
Contributors: reflctngod
Donate link: https://bustedspring.com
Tags: 12 step meetings, aa, na, alanon, 12 step meeting list
Requires at least: 4.0
Tested up to: 4.8
Stable tag: trunk
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Extra settings, templates, fields, shortcodes & other goodies for the 12 Step Meeting List plugin.

== Description ==

This plugin includes a bunch of tweaks I needed for my district and area websites that I thought might be helpful to others. Hope you enjoy it!

**NOTE:** *Requires the 12 Step Meeting List plugin.*

## Plugin features include:

1. **Group Unique ID field**: Use to store a group's GSO ID or any other unique ID that you find useful.
2. **Block editor (Gutenberg) blocks**: Add blocks with the new Wordpress Gutenberg editor and control styles with the block editor's built-in styling capabilities. Blocks include:
    * **12 Step Meeting List Xtras Meeting Table**: An accordion style table of all meetings.
      * Meetings are grouped by the day of the week, with the current day listed first.
      * Each meeting can be clicked on to see the address, online meeting info & 7th Tradition donation links.
      * This is a very condensed design for smaller service entities like districts or intergroups with very few meetings that don't need all the filters and search provided with TSML.
      * Colors are set in the settings for this plugin, but can be overridden by the Block editor. Choose colors for text, background & links as well as font size, font weight & font case.

    * **Main Meetings UI**: This is the meeting list from the 12 Step Meeting List plugin that you typically see on your https://mywebsite.com/meetings page.
      * This block relies heavily on custom javascript or react.js, (depending on whether you choose TSML UI or Legacy UI in your TSML settings) so there is no preview & styling is not possible because the TSML UI comes with it's own styles, but you can add it and it will appear on your page on the front-end.
    * **Next (Upcoming) Meetings**: Show a table of next (X) meetings and choose colors for text, background & links as well as font size, font weight & font case.
    * **Meeting Types List**: Show a list of links to all meeting types (open, closed, book study, etc) used on your site and choose colors for text, background & links as well as font size, font weight & font case.
    * **Regions List**: Show a list of links to all regions used on your site, with or without a count of meetings in that region) and choose colors for text, background & links as well as font size, font weight & font case.
3. **Shortcodes**: Use the [tsmlx] shortcode to display the 12 Step Meeting List Xtras Meeting Table (described above under Block Editor blocks.
    * Add text above and below the meeting table with a full rich text editor.
4. **Yoast SEO Variables**: Add Yoast replacements tokens to your meeting page SEO Title & Description. *(only works with 12 Step Meeting List Legacy UI)*
   > **%%tsml_meetingdate%%**: Adds the day & time of a meeting (i.e. Sunday 5:30 pm).

   > **%%tsml_city%%**: Adds the meeting location city

   > **%%tsml_state%%**: Adds the meeting location state

   > **%%tsml_citystate%%**: Adds the meeting location city & state (i.e. Nashville, TN)

   > **%%tsml_group%%**: Adds the group name
5. **Disable Meetings Page**: This disables the main /meetings page, in case you are using one of our blocks or a shortcode on another page (like your homepage) and don't want the meetings page indexed by search engines.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to the Meetings->TSMLXtras Settings screen to configure the plugin

== Frequently Asked Questions ==


== Screenshots ==

1. Plugin Settings Page
2. Gutengerg blocks
3. Gutengerg blocks

== Changelog ==


== Upgrade Notice ==

