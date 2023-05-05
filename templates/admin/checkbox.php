<?php
/**
 * Checkbox field template.
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<div class="form-control">
	<input id="<?php echo $data->slug ?>_settings[<?php echo $data->id ?>]" name="<?php echo $data->slug ?>_settings[<?php echo $data->id ?>]" type="checkbox" <?php echo $data->checked ?>/>
	<small class="description"><?php _e( $data->description, $data->slug ); ?></small>
</div>
