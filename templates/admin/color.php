<?php
/**
 * Color picker field template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<input id="<?php echo $data->slug ?>_settings[<?php echo $data->id ?>]" class="all-options <?php echo $data->id ?> <?php echo $data->slug ?>-<?php echo $data->id ?>" name="<?php echo $data->slug ?>_settings[<?php echo $data->id ?>]" type="text" value="<?php echo $data->color ?>">
<br/><small class="description"><?php _e( $data->description, $data->slug ); ?></small>
