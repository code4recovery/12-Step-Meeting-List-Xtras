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
<h3>Shortcode</h3>
<h4>Instructions:</h4>
<p>Use the shortcode <code>[tsmlx]</code> on any page to display a list of
    meetings in an accordion style table. Meetings are grouped by the day of the week, with the current day listed first. Each meeting can be clicked on to see the address, online meeting info & 7th Tradition donation links.</p>
<h4>Parameters</h4>
<p>You can control the output of the shortcode with these parameters:</p>
<ul>
	<li><code>[tsmlx <strong>show_footer=false</strong>]</code>: Hide the text below the meeting list</li>
	<li><code>[tsmlx <strong>show_header=false</strong>]</code>: Hide the text above the meeting list</li>
</ul>
<p><em>Coming soon: We're working on the ability to list meetings by group. [tsmlx group=group_id]</em></p>
<h4>Example</h4>
<p class="tw-p-2 tw-bg-black/70 tw-text-white">NOTE: This is just an example using colors we chose. You can customize the colors of your meetings table under <strong>Settings > Colors</strong></p>
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
