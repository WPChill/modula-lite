<div class='modula-modal__overlay video'>
	<div class="modula-modal__frame <?php
	echo esc_attr( $settings['classes'] ); ?>" <?php
	     if ( $settings['dismissible'] ) : ?>data-modula-modal-dismissible data-modula-modal-id="<?php
	echo esc_attr( $id ); ?>"<?php
	endif; ?>>
		<div class="modula-modal__header">
			<button class="modula-modal__dismiss">
				<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">
					<path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path>
				</svg>
			</button>
		</div>
		<div class="modula-modal__body">
			<div class="modula-upsells-carousel-wrapper-modal">
				<div class="modula-upsells-carousel-modal">
					<div class="modula-upsell-modal modula-upsell-item-modal">
						<h2>
							<?php
							esc_html_e( 'Video', 'modula-best-grid-gallery' );
							?>
						</h2>
						<h4 class="modula-upsell-description-modal">
							<?php
							esc_html_e( 'Trying to add a video to your gallery?', 'modula-best-grid-gallery' );
							?>
						</h4>
						<p><?php esc_html_e( 'Adding a video gallery with self-hosted videos or videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' ); ?></p>
						<div class="modula-upsell-modal-buttons-wrap">
							<?php
							$buttons         = '<a target="_blank" href="https://wp-modula.com/free-vs-pro/?utm_source=modula-lite&utm_medium=link&utm_campaign=upsell&utm_term=lite-vs-pro"  class="button">' . esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ) . '</a>';
							$buttons         .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=popup&utm_campaign=video" class="button-primary button">' . esc_html__( 'Get Premium!', 'modula-best-grid-gallery' ) . '</a>';

							echo wp_kses_post( apply_filters( 'modula_upsell_buttons', $buttons, 'video' ) );

							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

