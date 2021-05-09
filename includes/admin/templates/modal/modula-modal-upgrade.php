<div class="modula-modal__overlay">
	<div class="modula-modal__frame <?php echo $settings['classes']; ?>" <?php if ( $settings['dismissible'] ) : ?>data-modula-modal-dismissible data-modula-modal-id="<?php echo $id; ?>"<?php endif; ?>>
		<div class="modula-modal__header">
			<button class="modula-modal__dismiss">
				<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg>
			</button>
		</div>
		<div class="modula-modal__body">
			<div class="modula-upsells-carousel-wrapper">
				<div class="modula-upsells-carousel">
					<div class="modula-upsell modula-upsell-item">
						<h2><?php esc_html_e( 'Modula Albums', 'modula-best-grid-gallery' ); ?></h2>
						<h4 class="modula-upsell-description"><?php esc_html_e( 'Get the Modula Albums add-on to create wonderful albums from your galleries.', 'modula-best-grid-gallery' ); ?></h4>
						<ul class="modula-upsells-list">
							<li>Redirect to a gallery or a custom URL with the standalone functionality</li>
							<li>Arrange your albums using columns or the custom grid</li>
							<li>Hover effects</li>
							<li>Fully compatible with all the other Modula extensions</li>
							<li>Premium support</li>
							<li>Shuffle galleries inside an album on page refresh</li>
							<li>Shuffle album cover images (randomly pick a cover image from the gallery)</li>
						</ul>
						<p>
							<a target="_blank" href="<?php echo esc_url( 'https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium=albums-metabox&utm_campaign=modula-albums#lite-vs-pro' ); ?>" class="button"><?php esc_html_e( 'See Free vs Premium Differences', 'modula-best-grid-gallery' ); ?></a>
							<a target="_blank" style="margin-top:10px;" href="<?php echo esc_url( 'https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=albums-metabox&utm_campaign=extensions' ); ?>" class="button-primary button"><?php esc_html_e( 'Get Premium!', 'modula-best-grid-gallery' ); ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

