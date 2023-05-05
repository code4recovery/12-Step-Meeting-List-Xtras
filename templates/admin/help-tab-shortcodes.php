<?php
/**
 * Settings help tab template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<h3>12 Step Meeting List Xtras - Shortcode</h3>
<h4>Instructions:</h4>
<p>Use the shortcode <strong>[tsmlx]</strong> on any page to display a list of
    meetings in an accordion style table. Meetings are grouped by the day of the week, with the current day listed first. Each meeting can be clicked on to see the address, online meeting info & 7th Tradition donation links.</p>
<h4>Parameters</h4>
<p>You can control the output of the shortcode with these parameters:</p>
<ul><li>[tsmlx <strong>show_footer=false</strong>]: Hide the text below the meeting list</li></ul>
<ul><li>[tsmlx <strong>show_header=false</strong>]: Hide the text above the meeting list</li></ul>
<p><em>Coming soon: We're working on the ability to list meetings by group. [tsmlx group=group_id]</em></p>
<div style="display: flex; flex-direction: row; gap: 1rem;">
    <div style="width: 50%;float:left:">
        <p><em>All meetings closed</em></p>
        <img alt="All meetings closed" style="width: 100%;" src="<?php echo $data->plugin_url ?>screenshot-4.png">
    </div>
    <div style="width:50%;float:left:">
        <p><em>One meeting open</em></p>
        <img alt="One meeting open" style="width: 100%" src="<?php echo $data->plugin_url ?>screenshot-5.png">
    </div>
</div>
