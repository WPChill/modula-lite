<?php

function modula_generate_image_links( $item_data, $item, $settings ) {

	if ( ! apply_filters( 'modula_resize_images', true, $settings, $item_data ) ) {
		return $item_data;
	}

	$gallery_type      = isset( $settings['type'] ) ? $settings['type'] : 'creative-gallery';
	$allowed_galleries = array( 'creative-gallery', 'custom-grid', 'grid' );

	if ( ! in_array( $gallery_type, $allowed_galleries ) ) {
		return $item_data;
	}

	// If the image is not resized we will try to resized it now
	// This is safe to call every time, as resize_image() will check if the image already exists, preventing thumbnails from being generated every single time.
	$resizer = new Modula_Image();

	if ( 'custom' == $settings['grid_image_size'] ) {

		if ( 'custom-grid' == $settings['type'] ) {
			$grid_sizes = array(
				'width'  => absint( $settings['img_size'] ) * absint( $item['width'] ),
				'height' => absint( $settings['img_size'] ) * absint( $item['height'] ),
			);
		} else {
			$grid_sizes = array(
				'width'  => $settings['grid_image_dimensions']['width'],
				'height' => $settings['grid_image_dimensions']['height'],
			);
		}
	} else {
		$grid_sizes = $settings['grid_image_size'];
	}

	$crop = false;

	if ( 'custom' == $settings['grid_image_size'] ) {
		if ( 'custom-grid' == $settings['type'] ) {
			$settings['img_crop'] = isset( $settings['img_crop'] ) ? $settings['img_crop'] : 1;
			$crop                 = boolval( $settings['img_crop'] );
		} else {
			$crop = boolval( $settings['grid_image_crop'] );
		}
	}

	$sizes = $resizer->get_image_size( $item['id'], $gallery_type, $grid_sizes, $crop );

	if ( is_wp_error( $sizes ) ) {
		return $item_data;
	}

	$original_image = false;

	if ( 'full' === $grid_sizes ) {
		$original_image = wp_get_original_image_url( $item['id'] );
	}

	$resized    = $resizer->resize_image( $sizes['url'], $sizes['width'], $sizes['height'], $crop );
	$image_info = false;

	// If we couldn't resize the image we will return the full image.
	if ( is_wp_error( $resized ) ) {
		$resized = $sizes['url'];
	}
	// Let's check if resize gives us both URL and image info
	// Also, if resized_url is available, image_info should be available
	if ( isset( $resized['resized_url'] ) ) {
		$image_url  = $resized['resized_url'];
		$image_info = $resized['image_info'];
	} else {
		$image_url = $resized;
	}

	$item_data['img_attributes']['width']  = $sizes['width'];
	$item_data['img_attributes']['height'] = $sizes['height'];
	$item_data['image_full']               = $sizes['url'];
	$item_data['image_url']                = ( isset( $sizes['thumb_url'] ) ) ? $sizes['thumb_url'] : $image_url;
	// If thumb_url exists it means we are in predefined sizes.
	$item_data['img_attributes']['src']      = $original_image ? $original_image : ( ( isset( $sizes['thumb_url'] ) ) ? $sizes['thumb_url'] : $image_url );
	$item_data['img_attributes']['data-src'] = $original_image ? $original_image : ( ( isset( $sizes['thumb_url'] ) ) ? $sizes['thumb_url'] : $image_url );
	$item_data['image_info']                 = $image_info;

	return $item_data;
}

function modula_check_lightboxes_and_links( $item_data, $item, $settings ) {

	// Create link attributes like : title/rel
	if ( class_exists( '\Elementor\Plugin' ) ) {
		$item_data['link_attributes']['data-elementor-open-lightbox'] = 'no';
	}

	// ADA Compliance. Makes tag focusable using tab key.
	$item_data['link_attributes']['tabindex'] = 0;

	$caption = '';

	if ( isset( $item['description'] ) && '' != $item['description'] ) {

		$caption = $item['description'];
	} else {
		$caption = wp_get_attachment_caption( $item['id'] );
	}

	$item_data['img_attributes']['data-caption'] = $caption;

	if ( '' == $settings['lightbox'] || 'no-link' == $settings['lightbox'] ) {

		return $item_data;
	}

	if ( 'external-url' == $settings['lightbox'] || 'attachment-page' === $settings['lightbox'] ) {

		$item_data['link_attributes']['class'][]    = 'modula-simple-link';
		$item_data['item_classes'][]                = 'modula-simple-link';
		$item_data['link_attributes']['aria-label'] = esc_html__( 'Open external link', 'modula-best-grid-gallery' );
		if ( '' != $item['link'] ) {
			$item_data['link_attributes']['href'] = $item['link'];
			if ( isset( $item['target'] ) && '1' == $item['target'] ) {
				$item_data['link_attributes']['target'] = '_blank';
			}
		} else {
			$item_data['link_attributes']['href'] = get_attachment_link( $item['id'] );
		}
	} elseif ( 'direct' == $settings['lightbox'] ) {
		$item_data['link_attributes']['href']       = $item_data['image_full'];
		$item_data['link_attributes']['class'][]    = 'modula-simple-link';
		$item_data['item_classes'][]                = 'modula-simple-link';
		$item_data['link_attributes']['aria-label'] = esc_html__( 'Open image', 'modula-best-grid-gallery' );

	} else {
		if ( modula_href_required() ) {
			$item_data['link_attributes']['href'] = $item_data['image_full'];
		}
		$item_data['link_attributes']['rel']          = $settings['gallery_id'];
		$item_data['link_attributes']['data-caption'] = $caption;
		$item_data['link_attributes']['aria-label']   = esc_html__( 'Open image in lightbox', 'modula-best-grid-gallery' );
		$item_data['link_attributes']['role']         = 'button';

	}

	return $item_data;
}

function modula_check_hover_effect( $item_data, $item, $settings ) {

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

	$item_data['item_attributes']['data-width']  = $item['width'];
	$item_data['item_attributes']['data-height'] = $item['height'];

	return $item_data;
}

function modula_enable_lazy_load( $item_data, $item, $settings ) {

	if ( '1' != $settings['lazy_load'] && apply_filters( 'modula_lazyload_compatibility_item', true ) ) {
		return $item_data;
	}

	if ( 'grid' == $settings['type'] && 'automatic' == $settings['grid_type'] ) {

		// Fix for lazyload scripts when working with Automatic Grid
		if ( ! apply_filters( 'modula_lazyload_compatibility_item', true ) ) {
			$item_data['img_classes'][] = 'lazyloaded';
			return $item_data;
		}
	}

	if ( isset( $item_data['img_classes'] ) && is_array( $item_data['img_classes'] ) ) {
		$item_data['img_classes'][] = 'lazyload';
	}

	if ( isset( $item_data['img_attributes']['src'] ) && apply_filters( 'modula_lazyload_compatibility_item', true ) ) {
		unset( $item_data['img_attributes']['src'] );
	}

	$item_data['img_attributes']['data-source'] = 'modula';

	return $item_data;
}

function modula_add_align_classes( $template_data ) {

	if ( '' != $template_data['settings']['align'] ) {
		$template_data['gallery_container']['class'][] = 'align' . $template_data['settings']['align'];
	}

	return $template_data;
}

function modula_show_schemaorg() {
	global $wp;
	global $post;

	$current_url = is_wp_error( $post ) || empty( $post )
		? home_url( add_query_arg( array(), $wp->request ) )
		: get_the_permalink( $post->ID );
	?>

	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type"   : "ImageGallery",
		"id"      : "<?php echo esc_url( trailingslashit( $current_url ) ); ?>",
		"url"     : "<?php echo esc_url( trailingslashit( $current_url ) ); ?>"
	}

	</script>

	<?php
}

function modula_edit_gallery( $settings ) {

	$troubleshooting_options = get_option( 'modula_troubleshooting_option', array() );
	$troubleshooting_options = wp_parse_args( $troubleshooting_options, array( 'disable_edit' => false ) );

	if ( $troubleshooting_options['disable_edit'] ) {
		return;
	}

	$gallery_id = absint( explode( 'jtg-', $settings['gallery_id'] )[1] );
	edit_post_link( __( 'Edit gallery', 'modula-best-grid-gallery' ), '', '', $gallery_id, 'post-edit-link' );
}

function modula_add_gallery_class( $template_data ) {

	if ( 'custom-grid' == $template_data['settings']['type'] ) {
		$template_data['gallery_container']['class'][] = 'modula-custom-grid';
	} elseif ( 'grid' == $template_data['settings']['type'] ) {
		$template_data['gallery_container']['class'][] = 'modula-columns';
	} elseif ( 'creative-gallery' == $template_data['settings']['type'] ) {
		$template_data['gallery_container']['class'][] = 'modula-creative-gallery';
	}

	return $template_data;
}

function modula_add_scripts( $scripts, $settings ) {

	$needed_scripts = array();

	if ( apply_filters( 'modula_lazyload_compatibility_script', ( '1' == $settings['lazy_load'] ), $settings ) ) {
		$needed_scripts[] = 'modula-lazysizes';
	}

	if ( 'grid' == $settings['type'] && 'automatic' == $settings['grid_type'] ) {
		$needed_scripts[] = 'modula-grid-justified-gallery';
	} else {
		$needed_scripts[] = 'modula-isotope';
		$needed_scripts[] = 'modula-isotope-packery';
	}

	if ( 'fancybox' == $settings['lightbox'] ) {
		$needed_scripts[] = 'modula-fancybox';
		$needed_scripts[] = 'modulaFancybox';
	}

	return array_merge( $needed_scripts, $scripts );
}

/**
 * Add srcset and sizes to images
 *
 * @param $data
 *
 * @since 2.5.2
 * Inspired by wp_image_add_srcset_and_sizes
 */
function modula_sources_and_sizes( $data ) {

	// Lets creat our $image object
	$image = '<img class="' . esc_attr( implode( ' ', $data->img_classes ) ) . '" ' . Modula_Helper::generate_attributes( $data->img_attributes ) . '/>';

	// Check if srcset is disabled for an early return.
	$troubleshoot_opt = get_option( 'modula_troubleshooting_option' );
	if ( isset( $troubleshoot_opt['disable_srcset'] ) && '1' == $troubleshoot_opt['disable_srcset'] ) {
		echo $image;
		return;
	}

	$image_meta = array();
	// Get the imag meta
	if ( isset( $data->link_attributes['data-image-id'] ) ) {
		$image_meta = wp_get_attachment_metadata( $data->link_attributes['data-image-id'] );
	}

	$mime_type = '';

	if ( isset( $image_meta['sizes']['thumbnail']['mime-type'] ) ) {
		$mime_type = $image_meta['sizes']['thumbnail']['mime-type'];
	} elseif ( function_exists( 'mime_content_type' ) && isset( $data->image_info ) && $data->image_info ) {
		$mime_type = mime_content_type( $data->image_info['file_path'] );
	}

	//Add custom size only if it's different than original image size
	if ( ! empty( $data->image_info ) && $data->image_info && ! empty( $image_meta ) && $image_meta['width'] !== $data->img_attributes['width'] && $image_meta['height'] !== $data->img_attributes['height'] ) {
		$image_meta['sizes']['custom'] = array(
			'file'      => $data->image_info['name'] . '-' . $data->image_info['suffix'] . '.' . $data->image_info['ext'],
			'width'     => $data->img_attributes['width'],
			'height'    => $data->img_attributes['height'],
			'mime-type' => $mime_type,
		);
	}
	// Ensure the image meta exists.
	if ( empty( $image_meta['sizes'] ) ) {
		echo $image;
		return;
	}

	$attachment_id = $data->link_attributes['data-image-id'];

	$image_src         = preg_match( '/src="([^"]+)"/', $image, $match_src ) ? $match_src[1] : '';
	list( $image_src ) = explode( '?', $image_src );

	// Return early if we couldn't get the image source.
	if ( ! $image_src ) {
		echo $image;

		return;
	}

	// Bail early if an image has been inserted and later edited.
	if ( preg_match( '/-e[0-9]{13}/', $image_meta['file'], $img_edit_hash ) &&
		strpos( wp_basename( $image_src ), $img_edit_hash[0] ) === false ) {

		echo $image;

		return;
	}

	$width  = preg_match( '/ width="([0-9]+)"/', $image, $match_width ) ? (int) $match_width[1] : 0;
	$height = preg_match( '/ height="([0-9]+)"/', $image, $match_height ) ? (int) $match_height[1] : 0;

	if ( $width && $height ) {
		$size_array = array( $width, $height );
	} else {
		$size_array = wp_image_src_get_dimensions( $image_src, $image_meta, $attachment_id );
		if ( ! $size_array ) {
			echo $image;

			return;
		}
	}

	$srcset = apply_filters( 'modula_template_image_srcset', array(), $data, $image_meta );

	if ( empty( $srcset ) ) {
		if ( ! isset( $data->image_full ) ) {
			$data->image_full = $image_src;
		}
		$srcset = wp_calculate_image_srcset( $size_array, $data->image_full, $image_meta, $attachment_id );
	}

	if ( $srcset ) {
		// Check if there is already a 'sizes' attribute.
		$sizes = strpos( $image, ' data-sizes=' );

		if ( ! $sizes ) {
			$sizes = wp_calculate_image_sizes( $size_array, $image_src, $image_meta, $attachment_id );
		}
	}

	if ( $srcset && $sizes ) {

		// Format the 'srcset' and 'sizes' string and escape attributes.
		// Check if lazy load is enabled and add data-srcset and data-sizes
		if ( $data->lazyLoad ) {
			$attr = sprintf( ' data-srcset="%1$s"', esc_attr( $srcset ) );

			if ( is_string( $sizes ) ) {
				$attr .= sprintf( ' data-sizes="%1$s"', esc_attr( $sizes ) );
			}
		} else {
			$attr = sprintf( ' srcset="%s"', esc_attr( $srcset ) );

			if ( is_string( $sizes ) ) {
				$attr .= sprintf( ' sizes="%s"', esc_attr( $sizes ) );
			}
		}

		// Add the srcset and sizes attributes to the image markup.
		echo preg_replace( '/<img ([^>]+?)[\/ ]*>/', '<img $1' . $attr . ' />', $image );

		return;
	}

	echo $image;
}

/**
 * Checks versions of plugins before we remove href attribute from image link
 *
 *
 * @since 2.7.2
 */
function modula_href_required() {

	if (
		( ( defined( 'MODULA_PRO_VERSION' ) && version_compare( MODULA_PRO_VERSION, '2.6.3', '>=' ) ) || ! defined( 'MODULA_PRO_VERSION' ) ) &&
		( ( defined( 'MODULA_VIDEO_VERSION' ) && version_compare( MODULA_VIDEO_VERSION, '1.0.9', '>=' ) ) || ! defined( 'MODULA_VIDEO_VERSION' ) ) &&
		( ( defined( 'MODULA_SLIDER_VERSION' ) && version_compare( MODULA_SLIDER_VERSION, '1.1.1', '>=' ) ) || ! defined( 'MODULA_SLIDER_VERSION' ) ) &&
		( ( defined( 'MODULA_SPEEDUP_VERSION' ) && version_compare( MODULA_SPEEDUP_VERSION, '1.0.14', '>=' ) ) || ! defined( 'MODULA_SPEEDUP_VERSION' ) ) &&
		( ( defined( 'MODULA_WATERMARK_VERSION' ) && version_compare( MODULA_WATERMARK_VERSION, '1.0.8', '>=' ) ) || ! defined( 'MODULA_WATERMARK_VERSION' ) )
	) {
		return false;
	}

	return true;
}

function modula_mobile_share( $data ){
	if ( $data->hide_socials ){
		return;
	}

	?>
	<div class="jtg-social-mobile">
		<?php if( $data->enableTwitter || $data->enableFacebook || $data->enableWhatsapp || $data->enablePinterest || $data->enableLinkedin || $data->enableEmail ) : ?>
				<a class="modula-icon-share" aria-label="<?php echo esc_html__( 'Click to share', 'modula-best-grid-gallery' ); ?>" href="#"><?php echo Modula_Helper::get_icon( 'share' ) ?></a>
		<?php endif ?>
		<div class="jtg-social-mobile-icons">
			<?php if ( $data->enableTwitter ): ?>
				<a class="modula-icon-twitter" aria-label="<?php echo esc_html__( 'Share on Twitter', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?> href="#"><?php echo Modula_Helper::get_icon( 'twitter' ) ?></a>
			<?php endif ?>
			<?php if ( $data->enableFacebook ): ?>
				<a class="modula-icon-facebook" aria-label="<?php echo esc_html__( 'Share on Facebook', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?>
				href="#"><?php echo Modula_Helper::get_icon( 'facebook' ) ?></a>
			<?php endif ?>
			<?php if ( $data->enableWhatsapp ): ?>
				<a class="modula-icon-whatsapp" aria-label="<?php echo esc_html__( 'Share on Whatsapp', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?>
				href="#"><?php echo Modula_Helper::get_icon( 'whatsapp' ) ?></a>
			<?php endif ?>
			<?php if ( $data->enablePinterest ): ?>
				<a class="modula-icon-pinterest" aria-label="<?php echo esc_html__( 'Share on Pinterest', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?>
				href="#"><?php echo Modula_Helper::get_icon( 'pinterest' ) ?></a>
			<?php endif ?>
			<?php if ( $data->enableLinkedin ): ?>
				<a class="modula-icon-linkedin" aria-label="<?php echo esc_html__( 'Share on LinkedIn', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?>
				href="#"><?php echo Modula_Helper::get_icon( 'linkedin' ) ?></a>
			<?php endif ?>
			<?php if ( $data->enableEmail ): ?>
				<a class="modula-icon-email" aria-label="<?php echo esc_html__( 'Share by Email', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?> href="#"><?php echo Modula_Helper::get_icon( 'email' ) ?></a>
			<?php endif ?>
			<?php do_action('modula_extra_socials',$data); ?>
		</div>
	</div>
	<?php
}
