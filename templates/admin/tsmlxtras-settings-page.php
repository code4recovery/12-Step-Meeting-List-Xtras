<?php
/**
 * Plugin settings page template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<div id="tsmlx_settings" class="wrap">
	<h1><?php echo $data->plugin_name; ?> Settings<small
				class="<?php echo $data->plugin_slug ?>-version">
			Version <?php echo $data->plugin_version; ?></small></h1>
	<div id="poststuff">
		<div class="postbox">
			<div class="inside">
				<p><?php _e( 'This plugin provides some additional settings & displays for the 12 Step Meeting List Plugin', 'tsmlxtras' ); ?></p>
                <p><strong><?php _e( 'See the HELP tab at the top-right for examples & available options.', 'tsmlxtras' ); ?></strong></p>
			</div><!-- .inside -->
		</div><!-- .postbox -->
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content -->
			<div id="post-body-content">
				<form method="post" action="options.php">
					<?php
					settings_fields( $data->plugin_slug . '_settings_group' );
					do_settings_sections( $data->plugin_slug . '_settings_page' );
					submit_button();
					?>
				</form>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<h3>
							<span><?php _e( 'About The Plugin', 'tsmlxtras' ); ?></span>
						</h3>
						<div class="inside">
							<p>This plugin was created becuase there were a few
								things about the amazing <a
										href="https://wordpress.org/plugins/12-step-meeting-list/">12
									Step Meeting List</a> plugin I wished were
								different.</p>
							<p>First, I realized the website I was creating for
								my District didn't really have enough meetings
								to merit all the great filters that TSML
								provided, so I created an extra shortcode that
								displays all meetings in an accordion style
								table, grupoed by day of the week.</p>
							<p>As I built out our site, I saw a few other things
								that I felt might be halpful, including a Unique
								ID for groups (to store our GSO or other group
								number), the addition of schema.org structured
								data, and more.</p>
							<p><em>Hope you enjoy it!</em></p>
							<p><a target="_blank" href="https://github.com/anchovie91471/tsmlxtras"><?php _e( 'Visit the TSML Xtras GitHub', 'tsmlxtras' ); ?></a>
							</p>
						</div> <!-- .inside -->
					</div> <!-- .postbox -->
				</div> <!-- .meta-box-sortables -->
			</div> <!-- #postbox-container-1 .postbox-container -->
		</div>
	</div>
</div>
