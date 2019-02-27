<?php
/** -------------------------------------------------------------------- *\
 * 	edobees modification to address <style> inside <div>.
 *	Feb. 27, 2019 - <edo_mod> is used to mark changes.
 * 	see 'class-modula-shortcode.php' for more information.
\** -------------------------------------------------------------------- */

	// <edo_mod>: add styles to outer <div> item
	$g_settings = $data->g_settings;
	$style = ' style="';

	$style .= 'transform: scale(' . absint($g_settings['loadedScale']) / 100 . '); ';
		
	if( !empty( $g_settings['borderSize'] ) ) {
		$style .= 'border:' . absint($g_settings['borderSize']) . "px solid " .
				 sanitize_hex_color($g_settings['borderColor']) . ';';
	}

	if( !empty( $g_settings['borderRadius'] ) ) {
		$style .= 'border-radius:' . absint($g_settings['borderRadius']) . 'px ;';
	}

	if( !empty( $g_settings['shadowSize'] ) ) {
		$style .= 'box-shadow:' . sanitize_hex_color($g_settings['shadowColor']) . 
				" 0px 0px " . absint($g_settings['shadowSize']) . 'px; ';
	}
	
	$style .= '" ';
?>
<div class="<?php echo esc_attr(implode( ' ', $data->item_classes )) ?>" <?php echo$style;?> <?php echo Modula_Helper::generate_attributes( $data->item_attributes ) ?>>

	<?php do_action( 'modula_item_before_link', $data ); ?>

	<?php if ( 'no-link' != $data->lightbox ): ?>
		<a<?php echo Modula_Helper::generate_attributes( $data->link_attributes ) ?> class="<?php echo esc_attr(implode( ' ', $data->link_classes )) ?>"></a>
	<?php endif ?>

	<?php do_action( 'modula_item_after_link', $data ); ?>

	<img class='<?php echo esc_attr(implode( ' ', $data->img_classes )) ?>'<?php echo Modula_Helper::generate_attributes( $data->img_attributes ) ?>/>

	<?php do_action( 'modula_item_after_image', $data ); ?>

	<div class="figc">
		<div class="figc-inner">
			<?php if ( ! $data->hide_title ): 
				// <edo_mod>: add style to title
				$style = ' style="';
				$style .= 'color:' . sanitize_hex_color($g_settings['captionColor']) .
				'; ';
				if( !empty( $g_settings['titleFontSize'] ) ) {
					$style .= 'font-size:'.absint($g_settings['titleFontSize']).'px; ';
				}								
				$style .= '" ';	?>		
				<h2 class="jtg-title" <?php echo$style;?> >
				<?php echo wp_kses_post( $data->title ); ?></h2>
			<?php endif ?>
			<?php if ( ! $data->hide_description ): 
				// <edo_mod>: add style to description
				$style = ' style="';
				$style .= 'color:' . sanitize_hex_color($g_settings['captionColor']) .
				';font-size:' . absint($g_settings['captionFontSize']) . 'px; ';
				$style .= '" ';			
			?>
				<p class="description" <?php echo$style;?> >
				<?php echo wp_kses_post( $data->description ); ?></p>
			<?php endif ?>
			<?php if ( ! $data->hide_socials ): 
				// <edo_mod>: add style to social
				$style = ' style="';
				if( !empty($g_settings['socialIconColor']) ) {
					$style .= 'color:' . sanitize_hex_color( 
						$g_settings['socialIconColor'] ) . ' ';
				}
				$style .= '" ';									
			?>
			<div class="jtg-social" >
				<?php if ( $data->enableTwitter ): ?>
				<a class="modula-icon-twitter" <?php echo$style;?> href="#"><?php echo Modula_Helper::get_icon( 'twitter' ) ?></a>
				<?php endif ?>
				<?php if ( $data->enableFacebook ): ?>
				<a class="modula-icon-facebook" <?php echo$style;?> href="#"><?php echo Modula_Helper::get_icon( 'facebook' ) ?></a>
				<?php endif ?>
				<?php if ( $data->enableGplus ): ?>
				<a class="modula-icon-google-plus" <?php echo$style;?> href="#"><?php echo Modula_Helper::get_icon( 'google' ) ?></a>
				<?php endif ?>
				<?php if ( $data->enablePinterest ): ?>
				<a class="modula-icon-pinterest" <?php echo$style;?> href="#"><?php echo Modula_Helper::get_icon( 'pinterest' ) ?></a>
				<?php endif ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>