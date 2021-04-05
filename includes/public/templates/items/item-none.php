<div class="<?php echo esc_attr(implode( ' ', $data->item_classes )) ?>"<?php echo Modula_Helper::generate_attributes( $data->item_attributes ) ?> >
	<div class="modula-item-content">
		<?php do_action( 'modula_item_before_link', $data ); ?>

		<?php if ( 'no-link' != $data->lightbox ): ?>
			<a<?php echo Modula_Helper::generate_attributes( $data->link_attributes ) ?> class="<?php echo esc_attr(implode( ' ', $data->link_classes )) ?>"></a>
		<?php endif ?>

		<?php do_action( 'modula_item_after_link', $data );

		$image = '<img class="' . esc_attr( implode( ' ', $data->img_classes ) ) . '" ' . Modula_Helper::generate_attributes( $data->img_attributes ) . '/>';

		$image_meta                    = wp_get_attachment_metadata( $data->link_attributes['data-image-id'] );

		if( ! empty( $data->image_info ) ){
			$image_meta['sizes']['custom'] = array(
					'file'      => $data->image_info['name'] . '-' . $data->image_info['suffix'] .'.' . $data->image_info['ext'],
					'width'     => $data->img_attributes['width'],
					'height'    => $data->img_attributes['height'],
					'mime-type' => $image_meta['sizes']['thumbnail']['mime-type']
			);
		}


		echo wp_image_add_srcset_and_sizes( $image, $image_meta, $data->link_attributes['data-image-id'] );

		do_action( 'modula_item_after_image', $data );
		?>
	</div>

</div>