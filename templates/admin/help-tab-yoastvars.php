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
<h3>12 Step Meeting List Xtras - Yoast SEO Variables</h3>
<p> Allows you to add useful Yoast replacements tokens to your meeting page SEO Title & Description. (only works with 12 Step Meeting List Legacy UI)</p>
<small><strong><em>* Requires the <a target="_blank" href="https://wordpress.org/plugins/wordpress-seo/">Yoast SEO plugin</a></em></strong></small>
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
            <li><strong>%%tsml_meetingdate%%</strong>: Adds the day & time of a meeting (i.e. Sunday 5:30 pm).</li>
            <li><strong>%%tsml_city%%</strong>: Adds the meeting location city.</li>
            <li><strong>%%tsml_state%%</strong>: Adds the meeting location state.</li>
            <li><strong>%%tsml_citystate%%</strong>: Adds the meeting location city & state (i.e. Nashville, TN).</li>
            <li><strong>%%tsml_group%%</strong>: Adds the group name.</li>
        </ul>
    </div>
    <div style="width:50%;float:left:">
        <p><em>Yoast Content Type: Meetings</em></p>
        <img alt="Yoast Content Type: Meetings" style="width: 100%" src="<?php echo $data->plugin_url ?>screenshot-8.png">
    </div>
</div>
