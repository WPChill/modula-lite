<div class="modula-modal__overlay albums-defaults">
	<div class="modula-modal__frame <?php echo esc_attr($settings['classes']); ?>" <?php if ( $settings['dismissible'] ) : ?>data-modula-modal-dismissible data-modula-modal-id="<?php echo esc_attr($id); ?>"<?php endif; ?>>
		<div class="modula-modal__header">
			<button class="modula-modal__dismiss">
				<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg>
			</button>
		</div>
		<div class="modula-modal__body">
			<div class="modula-upsells-carousel-wrapper-modal">
				<div class="modula-upsells-carousel-modal">
					<div class="modula-upsell-modal modula-upsell-item-modal">
						<h2><?php esc_html_e( 'Albums Defaults', 'modula-best-grid-gallery' ); ?></h2>
						<h4 class="modula-upsell-description-modal"><?php esc_html_e( 'Speed up your albums creation process by starting from a pre-saved default. Save any album\'s settings as a default and reuse them indefinitely. Got a bunch of albums you want to apply a default to? That\'s possible too with this extension.', 'modula-best-grid-gallery' ); ?></h4>
					
						<p>
							<?php

							$lite_vs_pro_url = admin_url( 'edit.php?post_type=modula-gallery&page=modula-lite-vs-pro' );
							$buttons = '<a target="_blank" href="' . esc_url( $lite_vs_pro_url ) . '"  class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
							$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=popup&utm_campaign=modula-albums-defaults" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

							echo apply_filters( 'modula_upsell_buttons', $buttons, 'albums' );

							?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

