<div class="<?php echo esc_attr(implode( ' ', $data->item_classes )) ?>"<?php echo Modula_Helper::generate_attributes( $data->item_attributes ) ?> >
	<div class="modula-item-overlay"></div>

	<div class="modula-item-content">

		<?php do_action( 'modula_item_before_link', $data ); ?>
		
		<?php if ( 'no-link' != $data->lightbox ): ?>
			<a<?php echo Modula_Helper::generate_attributes( $data->link_attributes ) ?> class="<?php echo esc_attr(implode( ' ', $data->link_classes )) ?>"></a>
		<?php endif ?>

		<?php
		/**
		 * Hook: modula_item_after_link
		 */
		do_action( 'modula_item_after_link', $data );

		/**
		 *Hook : modula_item_template_image
		 *
		 * @hooked: modula_sources_and_sizes
		 */
		do_action( 'modula_item_template_image', $data );

		/**
		 * Hook: modula_item_after_image
		 */
		do_action( 'modula_item_after_image', $data );
		?>

		<div class="figc<?php echo '' == $data->title ? ' no-title' : '' ?><?php echo '' == $data->description ? ' no-description' : '' ?>">
			<div class="figc-inner">
				<?php if ( ! $data->hide_title ): ?>
					<div class='jtg-title'><?php echo wp_kses_post( $data->title ); ?></div>
				<?php endif ?>
				<?php if ( ! $data->hide_description && '' != $data->description): ?>
					<p class="description"><?php echo wp_kses_post( $data->description ); ?></p>
				<?php endif ?>
				<?php if ( ! $data->hide_socials ): ?>
					<div class="jtg-social">
						<?php if ( $data->enableTwitter ): ?>
							<a class="modula-icon-twitter" aria-label="<?php echo esc_html__( 'Share on X', 'modula-best-grid-gallery' ); ?>" <?php echo ( ! empty( $data->social_attributes ) ) ?  Modula_Helper::generate_attributes( $data->social_attributes ) : ''; ?> href="#"><?php echo Modula_Helper::get_icon( 'twitter' ) ?></a>
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
				<?php endif ?>
			</div>
		</div>

	</div>

</div>