<!-- Gallery Container -->
<div <?php echo Modula_Helper::generate_attributes( $data->gallery_container ) ?>>

	<?php do_action( 'modula_shortcode_before_items', $data->settings) ?>

	<!-- Items Container -->
	<div <?php echo Modula_Helper::generate_attributes( $data->items_container ) ?>>
		<?php

		foreach ( $data->images as $image ) {

			$image_object = get_post( $image['id'] );
			if ( is_wp_error( $image_object ) || get_post_type( $image_object ) != 'attachment' ) {
				continue;
			}

			// Create array with data in order to send it to image template
			$item_data = array(
				/* Item Elements */
				'title'            => Modula_Helper::get_title( $image, 'title' ),
				'description'      => Modula_Helper::get_description( $image, 'caption' ),
				'lightbox'         => $data->settings['lightbox'],

				/* What to show from elements */
				'hide_title'       => boolval( $data->settings['hide_title'] ) ? true : false,
				'hide_description' => boolval( $data->settings['hide_description'] ) ? true : false,
				'hide_socials'     => !boolval( $data->settings['enableSocial'] ),
				"enableTwitter"    => boolval( $data->settings['enableTwitter'] ),
				"enableWhatsapp"   => boolval( $data->settings['enableWhatsapp'] ),
				"enableFacebook"   => boolval( $data->settings['enableFacebook'] ),
				"enablePinterest"  => boolval( $data->settings['enablePinterest'] ),
				"enableLinkedin"   => boolval( $data->settings['enableLinkedin'] ),
				"enableEmail"      => boolval( $data->settings['enableEmail'] ),
				"lazyLoad"      => boolval( $data->settings['lazy_load'] ),

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
					'data-full'     => esc_url( $image_object->guid ),
					'title'         => $image[ 'title' ],
				),
			);

			if( isset( $image['togglelightbox'] ) && 1 === $image['togglelightbox'] ){
				$item_data['link_classes'][] = 'modula-simple-link'; //prevent the lightboxification
				$item_data['link_classes'][] = 'modula-no-follow'; //prevent the opening of the image
			}
			// need this to model the image attributes
      		$image = apply_filters( 'modula_shortcode_image_data', $image, $data->settings );


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
			$data->loader->get_template_part( 'items/item', $data->settings['effect'] );
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
	 * @hooked modula_slider_syncing - 85
	 */
	do_action( 'modula_shortcode_after_items', $data->settings, $item_data, $data->images );
	?>

</div>