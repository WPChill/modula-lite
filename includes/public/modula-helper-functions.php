<?php

function modula_generate_image_links( $item_data, $item, $settings ){

	$image_full = '';
	$image_url = '';

	// If the image is not resized we will try to resized it now
	// This is safe to call every time, as resize_image() will check if the image already exists, preventing thumbnails from being generated every single time.
	$resizer = new Modula_Image();

	$gallery_type = isset( $settings['type'] ) ? $settings['type'] : 'creative-gallery';
	$grid_sizes = array(
		'width' => isset( $item['width'] ) ? $item['width'] : 1,
		'height' => isset( $item['height'] ) ? $item['height'] : 1,
	);
	$sizes = $resizer->get_image_size( $item['id'], $settings['img_size'], $gallery_type, $grid_sizes );
	$image_full = $sizes['url'];
	$image_url = $resizer->resize_image( $sizes['url'], $sizes['width'], $sizes['height'] );

	// If we couldn't resize the image we will return the full image.
	if ( is_wp_error( $image_url ) ) {
		$image_url = $image_full;
	}

	$item_data['image_full'] = $image_full;
	$item_data['image_url']  = $image_url;

	// Add src/data-src attributes to img tag
	$item_data['img_attributes']['src'] = $image_url;
	$item_data['img_attributes']['data-src'] = $image_url;

	return $item_data;
}

function modula_check_lightboxes_and_links( $item_data, $item, $settings ) {

	// Create link attributes like : title/rel
	$item_data['link_attributes']['href'] = '#';
    // Will comment these lines, maybe in the future we revert to them.
    // For now the settings are disabled
    if ( isset($item['description']) && '' != $item['description'] ) {
    	$caption = $item['description'];
    }else{
    	$caption = wp_get_attachment_caption( $item['id'] );
    }

	if ( '' == $settings['lightbox'] || 'no-link' == $settings['lightbox'] ) {
		$item_data['link_attributes']['href'] = '#';
	}elseif ( 'attachment-page' == $settings['lightbox'] ) {
		if ( '' != $item['link'] ) {
			$item_data['link_attributes']['href'] = $item['link'];
			if ( isset( $item['target'] ) && '1' == $item['target'] ) {
				$item_data['link_attributes']['target'] = '_blank';
			}
		}else{
			$item_data['link_attributes']['href'] = get_attachment_link( $item['id'] );
		}
		
	}else{
		$item_data['link_attributes']['href'] = $item_data['image_full'];
	}

	if ( in_array( $settings['lightbox'], array( 'prettyphoto', 'swipebox' ) ) ) {
		$item_data['link_attributes']['title'] = htmlentities( $caption );
	}elseif ( 'lightgallery' == $settings['lightbox'] ) {
		$item_data['link_attributes']['data-sub-html'] = htmlentities( $caption );
	}else{
		$item_data['link_attributes']['data-title'] = htmlentities($caption);
	}

	if ( 'prettyphoto' == $settings['lightbox'] ) {
		$item_data['link_attributes']['rel'] = 'prettyPhoto[' . $settings['gallery_id'] . ']';
	}elseif ( 'lightbox2' == $settings['lightbox'] ) {
		$item_data['link_attributes']['data-lightbox'] = $settings['gallery_id'];
	}else{
		$item_data['link_attributes']['rel'] = $settings['gallery_id'];
	}

	return $item_data;
}

function modula_check_hover_effect( $item_data, $item, $settings ){

	$hover_effect_elements = Modula_Helper::hover_effects_elements( $settings['effect'] );

	if ( ! $hover_effect_elements['title'] ) {
		$item_data['hide_title'] = true;
	}

	if ( ! $hover_effect_elements['description'] ) {
		$item_data['hide_description'] = true;
	}

	if ( ! $hover_effect_elements['social'] ) {
		$item_data['hide_socials'] = true;
	}

	if ( 'none' != $settings['effect'] ) {
		$item_data['item_classes'][] = 'effect-' . $settings['effect'];
	}

	return $item_data;
}

function modula_check_custom_grid( $item_data, $item, $settings ) {

    if ( 'custom-grid' != $settings['type'] ) {
		return $item_data;
	}

	$item_data['item_attributes']['data-width'] = $item['width'];
	$item_data['item_attributes']['data-height'] = $item['height'];

	return $item_data;

}

function modula_enable_lazy_load( $item_data, $item, $settings ){

	if ( '1' != $settings['lazy_load'] ) {
		return $item_data;
	}

	if ( isset( $item_data['img_classes'] ) && is_array( $item_data['img_classes'] ) ) {
		$item_data['img_classes'][] = 'lazyload';
	}

	if ( isset( $item_data['img_attributes']['src'] ) ) {
		unset( $item_data['img_attributes']['src'] );
	}

	$item_data['img_attributes']['data-source'] = 'modula';

	return $item_data;
}

function modula_add_align_classes( $template_data ){

	if ( '' != $template_data['settings']['align'] ) {
		$template_data['gallery_container']['class'][] = 'align' . $data->settings['align'];
	}

	return $template_data;
}

function modula_show_schemaorg( $settings ){
	global $wp;

	$current_url = home_url(add_query_arg(array(), $wp->request));

	?>

	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type"   : "ImageGallery",
		"id"      : "<?php echo esc_url($current_url); ?>",
		"url"     : "<?php echo esc_url($current_url); ?>"
	}

    </script>

	<?php

}