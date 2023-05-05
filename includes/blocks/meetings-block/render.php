<?php
/**
 * Renders all versions of the meetings-block
 * Takes $attributes['blocktype'] and translates it into a function or
 * shortcode to render output
 */

// Set initial vars
$shortcode  = '';
$args       = [];
$blockType  = $attributes['blockType'];

// blockTypes that should be rendered with do_shortcode()
$shortcode_blocks = [ 'tsml_types_list', 'tsmlx' ];

// If we are rendering 12 Step Meeting List's main meetings block, load
// all the assets
if ( $blockType === 'tsml_ui' ) {
	tsml_assets();
}

// Set shortcode for blocks rendered with one
if ( in_array( $blockType, $shortcode_blocks ) ) {
	$shortcode = '[' . $blockType . ']';
}

// Show or hide counts on regions list
if ( $blockType === 'tsmlx_get_regions_list' ) {
	if ( $attributes['showCount'] ) {
		$args['showCount'] = TRUE;
	}
}

$classes = ''
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => $classes ] ) ); ?>>
	<?php
	if ( empty( $shortcode ) ) {
		echo $blockType( $args );
	} else {
		echo do_shortcode( $shortcode );
	}
	?>
</div>
