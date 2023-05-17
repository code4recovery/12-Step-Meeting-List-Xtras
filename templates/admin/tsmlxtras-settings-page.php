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
	<h1 class="main-header"><?php echo $data->plugin_name; ?><small class="<?php echo $data->plugin_slug ?>-version tw-text-xs tw-ml-2 tw-text-black/70">Version <?php echo $data->plugin_version; ?></small></h1>
	<div id="poststuff">
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
				<div class="postbox">
					<div class="postbox-header"><h2><?php _e( 'Info', 'tsmlxtras' ); ?></h2></div>
					<div class="inside">
						<p><?php _e( 'This plugin provides some additional settings & displays for the 12 Step Meeting List Plugin', 'tsmlxtras' ); ?></p>
						<p><strong><?php _e( 'See the HELP tab at the top-right for examples & available options.', 'tsmlxtras' ); ?></strong></p>
						<h5>Need Help?</h5>
						<ul>
							<li><a target="_blank" href="https://github.com/code4recovery/12-Step-Meeting-List-Xtras/discussions">Ask a Question</a> </li>
							<li><a target="_blank" href="https://github.com/code4recovery/12-Step-Meeting-List-Xtras"><?php _e( 'Visit the TSML Xtras GitHub', 'tsmlxtras' ); ?></a></li>
						</ul>
					</div> <!-- .inside -->
				</div> <!-- .postbox -->
			</div> <!-- #postbox-container-1 .postbox-container -->
		</div>
	</div>
</div>
