<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php
	if (!isset($attributes['id'])) {
		return;
	}
	if (!isset($attributes['align'])) {
		$atts['align'] = '';
	}

	if (isset($attributes['galleryType']) && 'gallery' !== $attributes['galleryType']) {
		$html = apply_filters('modula_render_defaults_block', 'An error occurred', $attributes);
		echo $html;
	} else {
		echo '[modula id=' . absint($attributes['id']) . ' align=' . esc_attr($attributes['align']) . ']';
	}
	?>
</p>