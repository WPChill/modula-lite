<?php

class Modula_Addons {

	private $addons = array();

	function __construct() {
		$this->addons = $this->check_for_addons();
	}

	private function check_for_addons() {

		$data = get_transient( 'modula_all_extensions' );
	 	if ( false !== $data ) {
			return $data;
		}

		$addons = array();

		$url = MODULA_PRO_STORE_URL . '/wp-json/mt/v1/get-all-extensions';

		// Get data from the remote URL.
		$response = wp_remote_get( $url );

		if ( ! is_wp_error( $response ) ) {

			// Decode the data that we got.
			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( ! empty( $data ) && is_array( $data ) ) {
				$addons = $data;
				// Store the data for a week.
				set_transient( 'modula_all_extensions', $data, 7 * DAY_IN_SECONDS );
			}
		}

	    return apply_filters( 'modula_addons', $addons );

	}

	public function render_addons() {

		if ( ! empty( $this->addons ) ) {
			foreach ( $this->addons as $addon ) {
				$image = ( '' != $addon['image'] ) ? $addon['image'] : MODULA_URL . 'assets/images/modula-logo.jpg';
				echo '<div class="modula-addon">';
				echo '<div class="modula-addon-box">';
				echo '<div><img src="' . esc_attr( $image ) . '"></div>';
				echo '<div class="modula-addon-content">';
				echo '<h3>' . esc_html( $addon['name'] ) . '</h3>';
				echo '<div class="modula-addon-description">' . wp_kses_post( $addon['description'] ) . '</div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="modula-addon-actions">';
				echo apply_filters( "modula_addon_button_action", '<a href="' . esc_url( MODULA_PRO_STORE_UPGRADE_URL . '?utm_source=modula-lite&utm_campaign=upsell&utm_medium=' . esc_attr( $addon['slug'] ) ) . '" target="_blank" class="button primary-button">' . esc_html__( 'Upgrade to PRO', 'modula-best-grid-gallery' ) . '</a>', $addon );
				echo '</div>';
				echo '</div>';
			}
		}
	}

}
