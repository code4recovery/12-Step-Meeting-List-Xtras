<?php
/**
 * Unique group ID field help tab template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<h3>Block editor (Gutenberg) blocks</h3>
<p><strong>Note: This is simply a convenient way to add the same block provided with shortcodes. Using the blocks gives you a preview in the block editor, where shortcodes do not.</strong></p>
<h4>Instructions</h4>
<ul>
    <li>Add "Meeting Blocks" to your page with the WordPress block editor.</li>
    <li>Select which block you want to display with the "Select Block Type" dropdown.</li>
    <li>Display the count of groups by chckeing the "Show Count of Meetings (where applicable)" checkbox.</li>
    <li>Choose color & typeography styles from the settings. (not all blocks use the styles)</li>
</ul>
<h4>Blocks include:</h4>
<div style="display: flex; flex-direction: row; gap: 2rem;">
    <div style="width: 70%;float:left:">
        <ol>
            <li><strong>Xtras Meeting Table:</strong> An accordion style table of all meetings. (see Shortcodes tab for a preview)
                <ul>
                    <li>Meetings are grouped by the day of the week, with the current
                        day listed first.
                    </li>
                    <li>Each meeting can be clicked on to see the address, online
                        meeting info & 7th Tradition donation links.
                    </li>
                    <li>This is a very condensed design for smaller service entities
                        like districts or intergroups with very few meetings that don't
                        need all the filters and search provided with TSML.
                    </li>
                    <li>Colors are set in the settings for this plugin, but can be
                        overridden by the Block editor. Choose colors for text,
                        background & links as well as font size, font weight & font
                        case.
                    </li>
                </ul>
            </li>
            <li><strong>Main Meetings UI:</strong> This is the meeting list from the 12 Step Meeting List plugin that you typically see on your https://mywebsite.com/meetings page.
                <ul><li>This block relies heavily on custom javascript or react.js, (depending on whether you choose TSML UI or Legacy UI in your TSML settings) so there is no preview & styling is not possible because the TSML UI comes with it's own styles, but you can add it and it will appear on your page on the front-end.</li></ul>
            </li>
            <li>
                <strong>Next (Upcoming) Meetings:</strong> Show a table of next (X) meetings and choose colors for text, background & links as well as font size, font weight & font case.
            </li>
            <li>
                <strong>Meeting Types List:</strong> Show a list of links to all meeting types (open, closed, book study, etc) used on your site and choose colors for text, background & links as well as font size, font weight & font case.
            </li>
            <li>
                <strong>Regions List:</strong> Show a list of links to all regions used on your site, with or without a count of meetings in that region) and choose colors for text, background & links as well as font size, font weight & font case.
            </li>
        </ol>
    </div>
    <div style="width:30%;float:left:">
        <p><em>Search block add sidebar for "Meeting Blocks" or look under "Embed" category.</em></p>
        <img alt="Search block add sidebar for Meeting Blocks or look under Embed category" style="width: 100%; margin-bottom: 1rem;" src="<?php echo $data->plugin_url ?>screenshot-6.png">
        <p><em>Meeting Blocks settings example.</em></p>
        <img alt="Meeting Blocks settings example" style="width: 100%" src="<?php echo $data->plugin_url ?>screenshot-7.png">
    </div>
</div>
