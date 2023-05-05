<?php
/**
 * WYSIWYG text editor field template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<?php wp_editor( $data->content, $data->id, $settings = [
	'textarea_rows' => '10',
	'media_buttons' => FALSE,
	'textarea_name' => $data->slug . '_settings[' . $data->id . ']',
] ); ?>
<br/><small class="description"><?php _e( $data->description, $data->slug ); ?></small>
