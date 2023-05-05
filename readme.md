# 12 Step Meeting List Xtras

This plugin provides some extra settings, templates, fields, shortcodes & other goodies for the 12 Step Meeting List plugin. 

It started as a catch-all plugin for the tweaks I wanted while building the district & area websites I was working on, but over time. I thought it might be helpful to others so here it is.

*Hope you enjoy!*  
## Features
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
4. **Yoast SEO Variables**: Allows you to add useful Yoast replacements tokens to your meeting page SEO Title & Description. *(only works with 12 Step Meeting List Legacy UI)*
   > **%%tsml_meetingdate%%**: Adds the day & time of a meeting (i.e. Sunday 5:30 pm).

   > **%%tsml_city%%**: Adds the meeting location city

   > **%%tsml_state%%**: Adds the meeting location state

   > **%%tsml_citystate%%**: Adds the meeting location city & state (i.e. Nashville, TN)

   > **%%tsml_group%%**: Adds the group name
5. **Disable Meetings Page**: This disables the main /meetings page, in case you are using one of our blocks or a shortcode on another page (like your homepage) and don't want the meetings page indexed by search engines.
6. **Schema.org markup**: This adds structured json data to your meeting pages (and group pages if you use them) to improve SEO. The data is not visible to users. It is only in the source of your page to provide better context to Search Engines. Each meeting uses the [LocalBusiness](https://schema.org/LocalBusiness) type and uses the meeting info (name, location, virtual info, etc.) to fill in the data.

## Installation
The best way to install this plugin is via [its home page](https://wordpress.org/plugins/12-step-meeting-list/) in the WordPress Plugin Directory.

## Support
Need help? Please [open a new discussion](https://github.com/anchovie91471/tsmlxtras/discussions).

## Settings
![](screenshot-1.png)
## Wordpress Block Editor (Gutenberg)
![](screenshot-2.png)
![](screenshot-3.png)
![](screenshot-6.png)
![](screenshot-7.png)
## [tsmlx] Shorcode Preview
![](screenshot-4.png)
![](screenshot-5.png)
## Yoost Replacement Tokens
![](screenshot-8.png)