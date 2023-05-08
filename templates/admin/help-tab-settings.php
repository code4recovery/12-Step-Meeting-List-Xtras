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
<h3>12 Step Meeting List Xtras - Settings</h3>
<h4>12 Step Meeting List Settings</h4>
<p class="tw-mt-0">These settings give you some control over the main 12 Step Meeting List plugin that are normally done via code edits. The settings provide the same level of control, but with a UI.</p>
<h5 class="tw-pb-0 tw-underline">TSML columns</h5>
<p class="tw-mt-0">This setting controls how columns appear on your meetings list page. You can change the order & visiblity of each column as well as the heading text (Label) that appears at the top of the table. Change the column order by dragging & dropping columns in a different order and clicking "Save Changes" at the bottom of the page.</p>
<h5 class="tw-pb-0 tw-underline">Show full address</h5>
<p class="tw-mt-0">Check this box to have the meeting list display the full address, including city, state and country.</p>
<h5 class="tw-pb-0 tw-underline">Custom Geocoding Key</h5>
<p class="tw-mt-0">Use your own Google geocoding key by pasting your key in the field. Make sure you’ve enabled the Geocoding API in the Google Cloud Console.</p>
<h5 class="tw-pb-0 tw-underline">Custom meeting page URL</h5>
<p class="tw-mt-0">Change the url of the meeting list page. (The default is yoursite.com/meeings/).</p>
<p class="tw-mt-0"><strong><em>DO NOT USE SLASHES!</em></strong> For example: If you want your meetings page to be <strong>yoursite.com/12-step-meetings/</strong>, simply type <strong>12-step-meetings</strong> in the field.</p>
<h5 class="tw-pb-0 tw-underline">Meeting Types</h5>
<p class="tw-mt-0">Manage your meeting types</p>
<ul>
	<li>Change the order that meeting types appear by dragging & dropping columns in a different order and clicking "Save Changes" at the bottom of the page. <strong><em>The reordering functionality only works for the 12 Step Meeting List Xtras display, not the main /meeting/ page or the widgets created by 12 Step Meeting List.</em></strong></li>
	<li>Change the text for any meeting type by editing the label. For example, you can chennge "English" to "English Speaking". <strong><em>This changes the type label everywhere it appears (meeting list, individual meeting page, meeting edit page, etc).</em></strong></li>
	<li>Remove the meeting type by checking the "Turn Off" checkbox. <strong><em>This removes the type everywhere it appears (meeting list, individual meeting page, meeting edit page, etc).</em></strong></li>
	<li>Delete custom meeting types by clicking the Trash icon. <strong><em>This completely deletes & removes the type everywhere it appears (meeting list, individual meeting page, meeting edit page, etc).</em></strong></li>
</ul>
<h4>Schema Settings</h4>
<p class="tw-mt-0">Schema settings control the placement of schema.org structured data to your meetings pages. Structured data helps search engines better understand data on your page by presenting it in a structured way. This data isn't visible to users, but is contained in your page. <em>We use the LocalBusiness schema type.</em></p>
<p class="tw-mt-0"><strong>Include Schema.org markup</strong>: Toggle on or off to include the structured data.</p>
<p class="tw-mt-0"><strong>Default Image</strong>: A link to this file will be included as a logo element on all meetings. Usually it's best to use your fellowship's logo or other mark that works for ALL meetings.</p>
<h4>Extra Content</h4>
<p class="tw-mt-0">HTML content that is placeed above and below the accordion table if you use the [txmlx] shortcode or block.</p>
<h4>Colors</h4>
<p class="tw-mt-0">Color scheme for the accordion table if you use the [tsmlx] shortcode or block.</p>
<h4>Other Settings</h4>
<p class="tw-mt-0"><strong>Disable meetings page</strong>: This disables the main /meetings page, in case you are using one of our blocks or a shortcode on another page (like your homepage) and don't want the meetings page indexed by search engines.</p>
<p class="tw-mt-0"><strong>Enable unique group ID field</strong>: Toggle this setting to add or remove the Group Number field on your meeting edit pages. The contents of this field is not shown to the user, but is a handy place to store a GSO number or other unique identifier for a group.</p>
<p class="tw-mt-0"><em>NOTE: This field is saved along with other Group data, not specific meeting data ,so changing it will change it for all meetings under that group.</em></p>