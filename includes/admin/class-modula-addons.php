<?php

class Modula_Addons {

	public $addons = array();

	function __construct() {
		$this->addons = $this->check_for_addons();

		// Add ajax action to reload extensions
		add_action( 'wp_ajax_modula_reload_extensions', array( $this, 'reload_extensions' ), 20 );
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

		$addons_images = array(
			'modula-whitelabel', 'modula-roles', 'modula-defaults', 'modula-zoom', 'modula-download', 'modula-exif', 'modula-albums', 'modula-slider', 'modula-password-protect', 'modula-watermark', 'modula-deeplink', 'modula-speedup', 'modula-video','modula-advanced-shortcodes','modula-slideshow','modula-protection'
		);

		$addons = apply_filters( 'modula_package_sortage', $this->addons );

		if ( ! empty( $addons ) ) {
			foreach ( $addons as $addon ) {

				if( ! function_exists( 'get_plugin_data' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$plugin_data = false;

				if(file_exists(WP_PLUGIN_DIR .'/' . $addon['slug'] . '/' . $addon['slug'] . '.php') ){
					$plugin_data = get_plugin_data( WP_PLUGIN_DIR .'/' . $addon['slug'] . '/' . $addon['slug'] . '.php' );
				}

				$image = ( in_array( $addon[ 'slug' ], $addons_images ) ) ? MODULA_URL . 'assets/images/addons/' . $addon[ 'slug' ] . '.png' : MODULA_URL . 'assets/images/modula-logo.jpg';
				echo '<div class="modula-addon">';
				echo '<div class="modula-addon-box">';

				if ( !isset( $addon['image'] ) || '' == $addon['image'] ){
					echo '<div><img src="' . esc_url( apply_filters( 'modula_admin_default_addon_image', esc_attr( $image ) ) ) . '"></div>';
				} else {
					echo '<div><img src="' . esc_url( $addon['image'] ) . '"></div>';
				}

				echo '<div class="modula-addon-content">';
				echo '<h3>' . esc_html( $addon['name'] ) . '</h3>';
				echo ( isset( $addon['version'] ) ) ? '<span class="modula-addon-version">' . esc_html( 'V ' . $addon['version'] ) . '</span>' : '';
				echo '<div class="modula-addon-description">' . wp_kses_post( $addon['description'] ) . '</div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="modula-addon-info">';
				do_action('modula_addon_info',$addon, $plugin_data);
				echo ( isset( $addon['url'] ) && '' != $addon['url'] ) ? '<a href="' . esc_url( $addon['url'] ) . '" target="_blank" >' . esc_html( 'Read more ' ) . '</a>' : '';
				echo '</div>';
				echo '<div class="modula-addon-actions">';
				echo apply_filters( 'modula_addon_settings_link','', $addon );
				echo apply_filters( "modula_addon_button_action", '<a href="' . esc_url( MODULA_PRO_STORE_UPGRADE_URL . '/?utm_source=modula-lite&utm_campaign=upsell&utm_medium='. esc_attr( $addon['slug'] ) ).'" target="_blank" class="button primary-button">' . esc_html__( 'Upgrade to unlock this feature', 'modula-best-grid-gallery' ) . '</a>', $addon );
				echo '</div>';
				echo '</div>';


			}
		}
	}

	/**
	 * Reload addons in the Extensions tab
	 *
	 * @moved here from class-modula.php file in version 2.5.0
	 */
	public function reload_extensions() {
		// Run a security check first.
		check_admin_referer( 'modula-reload-extensions', 'nonce' );

		delete_transient( 'modula_all_extensions' );
		delete_transient( 'modula_pro_licensed_extensions' );

		$this->addons = $this->check_for_addons();

		die;
	}

}

$addons = new Modula_Addons();
