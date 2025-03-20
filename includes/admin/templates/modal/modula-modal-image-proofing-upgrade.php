<div class="modula-modal__overlay image-proofing">
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
						<h2><?php esc_html_e( 'Modula Image Proofing', 'modula-best-grid-gallery' ); ?></h2>
						<h4 class="modula-upsell-description-modal"><?php esc_html_e( 'Getting your clients to select images is now simple and easy. Modula Image Proofing gives you everything you need to make the process quick and hassle-free.', 'modula-best-grid-gallery' ); ?></h4>
						
						<div class="modula-instagram-upsell-youtube-wrap">
							<a href="https://www.youtube.com/watch?v=ryAoetJaYbs" target="_BLANK" class="modula-instagram-upsell-youtube-link">
								<img class="modula-instagram-upsell-youtube-img" src="<?php echo esc_url( MODULA_URL . 'assets/images/upsells/upsell-embed-modula-image-proofing.png' ); ?>" />
							</a>
							<p class="modula-instagram-upsell-youtube-notice"><?php esc_html_e( 'Clicking the above image will open the video in a new tab.', 'modula-best-grid-gallery' ); ?></p>
						</div>

						<p>Why Use Modula Image Proofing?</p>
						<ul class="modula-upsells-list-modal">
							<li><strong>Easy to Create Galleries:</strong> Build professional proofing galleries in just a few clicks.</li>
							<li><strong>Simple Invitations:</strong> Share a unique invite link or send an email to your clients.</li>
							<li><strong>Quick Notifications:</strong> Get an email as soon as your client submits their selections.</li>
							<li><strong>Clear Communication:</strong> Clients can add notes to explain exactly what they need.</li>
							<li><strong>Work Together Easily:</strong> Let one or more clients select images from your gallery.</li>
							<li><strong>Stay in Control:</strong> Set a limit on how many images clients can choose.</li>
							<li><strong>Protect Your Work:</strong> Use watermarks, right-click protection, or password protection to keep your images safe.</li>
						</ul>
						<p>With Modula Image Proofing, getting client approvals has never been easier!</p>

						<div class="modula-upsell-modal-buttons-wrap">
							<?php

							$buttons = '<a target="_blank" href="https://wp-modula.com/free-vs-pro/?utm_source=modula-lite&utm_medium=link&utm_campaign=upsell&utm_term=lite-vs-pro"  class="button">' . esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ) . '</a>';
							$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=popup&utm_campaign=modula-image-licensing" class="button-primary button">' . esc_html__( 'Get Premium!', 'modula-best-grid-gallery' ) . '</a>';

							echo apply_filters( 'modula_upsell_buttons', $buttons, 'image-licensing' );

							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

