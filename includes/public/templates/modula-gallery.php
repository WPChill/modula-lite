<!-- Gallery Container -->
<div <?php echo Modula_Helper::generate_attributes( $data->gallery_container ) ?>>

	<?php do_action( 'modula_shortcode_before_items', $data->settings) ?>

	<!-- Items Container -->
	<div <?php echo Modula_Helper::generate_attributes( $data->items_container ) ?>>
		<?php

		foreach ( $data->images as $image ) {

			$image_object = get_post( $image['id'] );

			$item_is_not_image = ( is_wp_error( $image_object ) || get_post_type( $image_object ) != 'attachment' );

			if ( apply_filters( 'modula_check_item_not_image', $item_is_not_image, $image ) ) {
				continue;
			}
			$full_img_src = esc_url( wp_get_original_image_url( $image['id'] ) );

			// Check per gallery & per image if we should show title.
			$should_hide_title = ( boolval( $data->settings['hide_title'] ) || ( isset( $image['hide_title'] ) && boolval( $image['hide_title'] ) ) );

			// Create array with data in order to send it to image template
			$item_data = array(
				/* Item Elements */
				'title'            => Modula_Helper::get_title( $image, 'title' ),
				'description'      => Modula_Helper::get_description( $image, 'caption' ),
				'lightbox'         => $data->settings['lightbox'],

				/* What to show from elements */
				'hide_title'       => $should_hide_title,
				'hide_description' => boolval( $data->settings['hide_description'] ) ? true : false,
				'hide_socials'     => ! boolval( $data->settings['enableSocial'] ),
				"enableTwitter"    => boolval( $data->settings['enableTwitter'] ),
				"enableWhatsapp"   => boolval( $data->settings['enableWhatsapp'] ),
				"enableFacebook"   => boolval( $data->settings['enableFacebook'] ),
				"enablePinterest"  => boolval( $data->settings['enablePinterest'] ),
				"enableLinkedin"   => boolval( $data->settings['enableLinkedin'] ),
				"enableEmail"      => boolval( $data->settings['enableEmail'] ),
				"lazyLoad"         => boolval( $data->settings['lazy_load'] ),

				/* Item container attributes & classes */
				'item_classes'     => array( 'modula-item' ),
				'item_attributes'  => array(),

				/* Item link attributes & classes */
				'link_classes'     => array( 'tile-inner', 'modula-item-link' ),
				'link_attributes'  => array(
					'data-image-id' => $image['id']
				),

				/* Item img attributes & classes */
				'img_classes'      => array( 'pic', 'wp-image-' . $image['id'] ),

				'img_attributes'    => array(
					'data-valign'   => esc_attr( $image['valign'] ),
					'data-halign'   => esc_attr( $image['halign'] ),
					'alt'           => $image['alt'],
					'data-full'     => $full_img_src,
					'title'         => $image[ 'title' ],
				),
				'social_attributes' => array(
					'data-modula-gallery-id' => preg_replace( '/[^0-9]/', '', $data->gallery_id ),
					'data-modula-item-id'    => absint( $image['id'] ),
					'data-modula-image-src'  => $full_img_src,
				),
			);

			if( isset( $image['togglelightbox'] ) && 1 === $image['togglelightbox'] ){
				$item_data['link_classes'][] = 'modula-simple-link'; //prevent the lightboxification
				$item_data['link_classes'][] = 'modula-no-follow'; //prevent the opening of the image
			}
			// need this to model the image attributes.
      		$image = apply_filters( 'modula_shortcode_image_data', $image, $data->settings );

			// Let's set the data used for the srcset and sizes behaviour.
			// If the image size is custom and cropped, the srcset and sizes should not be set to avoid the browser
			// to load the wrong image. This is particular problematic when using the SpeedUp extension.
			if ( in_array( $data->settings['type'], array( 'creative-gallery', 'grid', 'custom-grid' ) ) ) {
				// Specify if the image size is custom.
				if ( 'custom' === $data->settings['grid_image_size'] ) {
					$item_data['custom_grid'] = true;
				}
				// Custom grid has a different setting name for the image crop.
				if ( 'custom-grid' !== $data->settings['type'] ) {
					// Specify if the image is cropped.
					if ( '1' === $data->settings['grid_image_crop'] ) {
						$item_data['crop'] = true;
					}
				} else {
					// Specify if the image is cropped.
					if ( '1' === $data->settings['img_crop'] ) {
						$item_data['crop'] = true;
					}
				}
			}

			/**
			 * Hook: modula_shortcode_item_data.
			 *
			 * @hooked modula_generate_image_links - 10
			 * @hooked modula_check_lightboxes_and_links - 15
			 * @hooked modula_check_hover_effect - 20
			 * @hooked modula_check_custom_grid - 25
             * @hooked modula_enable_lazy_load - 30
             *
			 */
			$item_data = apply_filters( 'modula_shortcode_item_data', $item_data, $image, $data->settings, $data->images );

			do_action( 'modula_shortcode_before_item', $data->settings, $item_data );
			$data->loader->set_template_data( $item_data );
			$slug = apply_filters( 'modula_item_template_slug', 'items/item' , $data->settings, $image );
			$name = apply_filters( 'modula_item_template_name', $data->settings['effect'] , $data->settings, $image );
			$data->loader->get_template_part( $slug, $name );
			do_action( 'modula_shortcode_after_item', $data->settings, $item_data );
		}

		?>
		
	</div>

	
	<?php

	/**
	 * Hook: modula_shortcode_after_items.
	 *
	 * @hooked modula_edit_gallery - 100
	 * @hooked modula_show_schemaorg - 90
	 * @hooked modula_show_items_schemaorg - 91
	 * @hooked modula_slider_syncing - 85
	 */
	do_action( 'modula_shortcode_after_items', $data->settings, $item_data, $data->images );
	?>

</div>