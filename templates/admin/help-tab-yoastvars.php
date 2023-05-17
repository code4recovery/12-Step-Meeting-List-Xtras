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
<h3>Yoast SEO Variables</h3>
<p> Allows you to add useful Yoast replacements tokens to your meeting page SEO Title & Description. (only works with 12 Step Meeting List Legacy UI)</p>
<small><strong><em>* Requires the <a class="tw-text-c4r-blue hover:tw-underline" target="_blank" href="https://wordpress.org/plugins/wordpress-seo/">Yoast SEO plugin</a></em></strong></small>
<h4>Instructions:</h4>
<ol>
    <li>In the WordPress admin, navigate to <a href="<?php echo home_url() ?>/wp-admin/admin.php?page=wpseo_page_settings">Settings</a> under the Yoast menu</li>
    <li>Under Content Types, click Meetings</li>
    <li>Add any of the replacement tokens (including the 2 percent signs on either side) to your SEO Title or Meta Desciription.</li>
</ol>
<h4>Available Replacement Tokens</h4>
<div style="display: flex; flex-direction: row; gap: 1rem;">
    <div style="width: 50%;float:left:">
        <ul>
            <li><code>%%tsml_meetingdate%%</code>: Adds the day & time of a meeting using the same format as your meetings pages (i.e. Sunday 5:30 pm).</li>
            <li><code>%%tsml_city%%</code>: Adds the meeting location city.</li>
            <li><code>%%tsml_state%%</code>: Adds the meeting location state.</li>
            <li><code>%%tsml_citystate%%</code>: Adds the meeting location city & state (i.e. Nashville, TN).</li>
            <li><code>%%tsml_group%%</code>: Adds the group name.</li>
        </ul>
    </div>
    <div style="width:50%;float:left:">
        <p><em>Yoast Content Type: Meetings</em></p>
        <img alt="Yoast Content Type: Meetings" style="width: 100%" src="<?php echo $data->plugin_url ?>screenshot-8.png">
    </div>
</div>
