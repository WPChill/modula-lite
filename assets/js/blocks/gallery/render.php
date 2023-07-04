<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

 // Render callback for the block (not a template file).
 // Note: $block, $attributes, and $content variables are available here. The purpose of $content is to enable access to the block's "inner blocks" (child blocks).

if ( ! isset( $attributes['id'] ) ) {
	return apply_filters( 'modula_render_defaults_block', 'An error occurred', $atts );
}

if ( ! isset( $attributes['align'] ) ) {
	$attributes['align'] = '';
}

echo '<div ' . get_block_wrapper_attributes() . '>';
echo '[modula gallery-id="' . esc_attr( $attributes['galleryId'] ) . '" id="' . absint( $attributes['id'] ) . '" align="' . esc_attr( $attributes['align'] ) . '"]';
echo '</div>';

?>
