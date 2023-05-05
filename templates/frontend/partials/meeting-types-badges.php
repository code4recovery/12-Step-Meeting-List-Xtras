<?php
/**
 * Renders meeting types as badges
 */

?>
<?php foreach ( $data->types as $type ) { ?>
	<span class="<?php echo tsml_xtras_get_classes('badge'); ?> <?php echo $data->styles; ?>"><?php _e( $type, '12-step-meeting-list' ); ?></span>
<?php } ?>
