<?php

class Modula_Addons {

	private $addons;
	private $upgrade_url = 'https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=video-addon&utm_campaign=upsell';

	function __construct() {

		$this->addons = $this->check_for_addons();

	}

	private function check_for_addons() {

		$addons = array(
			array(
				'image'       => '',
				'name'        => esc_html__( 'Modula Video', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Adding a video gallery with both self-hosted videos and videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' ),
				'slug'        => 'modula-video',
			),
			array(
				'image'       => '',
				'name'        => esc_html__( 'Modula Speed Up', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them and serving them from StackPath’s content delivery network.', 'modula-best-grid-gallery' ),
				'slug'        => 'modula-speedup',
			)
		);

	    return apply_filters( 'modula_addons', $addons );

	}

	public function render_addons() {

		if ( ! empty( $this->addons ) ) {
			foreach ( $this->addons as $addon ) {
				$image = ( '' != $addon['image'] ) ? $addon['image'] : MODULA_URL . 'assets/images/modula-logo.jpg';
				echo '<div class="modula-addon">';
				echo '<div class="modula-addon-box">';
				echo '<img src="' . esc_attr( $image ) . '">';
				echo '<div class="modula-addon-content">';
				echo '<h3>' . esc_html( $addon['name'] ) . '</h3>';
				echo '<div class="modula-addon-description">' . wp_kses_post( $addon['description'] ) . '</div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="modula-addon-actions">';
				echo apply_filters( "modula_addon_button_action", '<a href="' . $this->upgrade_url . '" target="_blank" class="button primary-button">' . esc_html__( 'Upgrade to PRO', 'modula-best-grid-gallery' ) . '</a>', $addon );
				echo '</div>';
				echo '</div>';
			}
		}

		if ( apply_filters( 'modula-show-feature-request', true ) ) {
			echo '<div class="modula-addon">';
			echo '<div class="modula-addon-box">';
			echo '<img src="' . MODULA_URL . 'assets/images/modula-logo.jpg">';
			echo '<div class="modula-addon-content">';
			echo '<h3>' . esc_html__( 'Feature Request', 'modula-best-grid-gallery' ) . '</h3>';
			echo '<div class="modula-addon-description">' . esc_html__( 'Cant\'t find what you’re looking for? Let us know by making a suggestion!', 'modula-best-grid-gallery' ) . '</div>';
			echo '</div>';
			echo '</div>';
			echo '<div class="modula-addon-actions">';
			echo '<a href="https://docs.google.com/forms/d/e/1FAIpQLSc5eAZbxGROm_WSntX_3JVji2cMfS3LIbCNDKG1yF_VNe3R4g/viewform" class="button primary-button" target="_blank">' . esc_html__( 'Send Feature Request', 'modula-best-grid-gallery' ) . '</a>';
			echo '</div>';
			echo '</div>';
		}

	}

}
