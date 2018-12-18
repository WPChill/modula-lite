<div class="<?php echo esc_attr(implode( ' ', $data->item_classes )) ?>"<?php echo Modula_Helper::generate_attributes( $data->item_attributes ) ?> >

	<?php do_action( 'modula_item_before_link', $data ); ?>

	<?php if ( 'no-link' != $data->lightbox ): ?>
		<a<?php echo Modula_Helper::generate_attributes( $data->link_attributes ) ?> class="<?php echo esc_attr(implode( ' ', $data->link_classes )) ?>"></a>
	<?php endif ?>

	<?php do_action( 'modula_item_after_link', $data ); ?>

	<img class='<?php echo esc_attr(implode( ' ', $data->img_classes )) ?>'<?php echo Modula_Helper::generate_attributes( $data->img_attributes ) ?>/>

	<?php do_action( 'modula_item_after_image', $data ); ?>

</div>