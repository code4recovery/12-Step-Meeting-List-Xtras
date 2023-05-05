<?php
/**
 * Image picker field template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<div id="<?php echo $data->slug ?>-image-container">
	<?php
	if ( intval( $data->image_id ) > 0 ) {
		// Change with the image size you want to use
		$image = wp_get_attachment_image( $data->image_id, 'medium', FALSE, [ 'id' => $data->slug . '-preview-image' ] );
	} else {
		// Some default image
		$image = '<img id="' . $data->slug . '-preview-image" src="' . $data->plugin_url . 'assets/svg/AA-fat.svg" />';
	}
	echo $image; ?>
</div>
<input type="hidden" name="<?php echo $data->slug ?>_settings[<?php echo $data->id ?>]" id="<?php echo $data->slug ?>_image_id" value="<?php echo esc_attr( $data->image_id ); ?>" class="regular-text"/>
<input type='button' class="button-primary" value="<?php esc_attr_e( 'Select a image', $data->slug ); ?>" id="<?php echo $data->slug ?>_media_manager"/>
<br/><small class="description"><?php _e( $data->description, $data->slug ); ?></small>