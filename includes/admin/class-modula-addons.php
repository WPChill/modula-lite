<?php

class Modula_Addons {

	public $addons = array();

	public $free_addons = array();

	function __construct() {
		// Add ajax action to reload extensions
		add_action( 'wp_ajax_modula_reload_extensions', array( $this, 'reload_extensions' ), 20 );
		add_filter( 'modula_free_extensions', array( $this, 'check_for_release' ), 999 );

		// Add free
		$this->free_addons = apply_filters( 'modula_free_extensions', array(
			'modula-foo-migrator' => array(
				'slug' => 'modula-foo-migrator',
				'name' => __( 'Migrate away from FooGallery', 'modula-best-grid-gallery' ),
				'image' => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
				'description'   => esc_html__('Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'moudla-best-grid-gallery')
			),
			'modula-nextgen-migrator' => array(
				'slug' => 'modula-nextgen-migrator',
				'name' => __( 'Migrate away from NextGEN', 'modula-best-grid-gallery' ),
				'image' => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
				'description'   => esc_html__('Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'moudla-best-grid-gallery')
			),
			'modula-envira-migrator' => array(
				'slug' => 'modula-envira-migrator',
				'name' => __( 'Migrate away from Envira', 'modula-best-grid-gallery' ),
				'image' => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
				'description'   => esc_html__('Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'moudla-best-grid-gallery')
			),
			'modula-photoblocks-gallery-migrator' => array(
				'slug' => 'modula-photoblocks-gallery-migrator',
				'name' => __( 'Migrate away from PhotoBlocks', 'modula-best-grid-gallery' ),
				'image' => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
				'description'   => esc_html__('Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'moudla-best-grid-gallery')
			),
			'modula-final-tiles-migrator' => array(
				'slug' => 'modula-final-tiles-migrator',
				'name' => __( 'Migrate away from Final Tiles', 'modula-best-grid-gallery' ),
				'image' => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
				'description'   => esc_html__('Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'moudla-best-grid-gallery')
			)
		) );
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
				set_transient( 'modula_all_extensions', $data, 30 * DAY_IN_SECONDS );
			}
		}

	    return apply_filters( 'modula_addons', $addons );

	}

	public function render_addons() {

		$this->addons = $this->check_for_addons();

		$addons_images = array(
			'modula-whitelabel', 'modula-roles', 'modula-defaults', 'modula-zoom', 'modula-download', 'modula-exif', 'modula-albums', 'modula-slider', 'modula-password-protect', 'modula-watermark', 'modula-deeplink', 'modula-speedup', 'modula-video','modula-advanced-shortcodes','modula-slideshow','modula-protection', 'modula-fullscreen'
		);

		$addons = apply_filters( 'modula_package_sortage', $this->addons );

		if ( ! empty( $addons ) ) {
			foreach ( $addons as $addon ) {

				$this->render_addon_top( $addon, $addons_images );
				echo '<div class="modula-addon-actions">';

				echo apply_filters( 'modula_addon_settings_link','', $addon );
				echo apply_filters( "modula_addon_button_action", '<a href="' . esc_url( MODULA_PRO_STORE_UPGRADE_URL . '/?utm_source=modula-lite&utm_campaign=extensions-page&utm_medium='. esc_attr( $addon['slug'] ) ).'" target="_blank" class="button primary-button">' . esc_html__( 'Upgrade to unlock this feature', 'modula-best-grid-gallery' ) . '</a>', $addon );

				echo '</div>'; // .modula-addon-actions
				echo '</div>';


			}
		}
	}

	/**
	 * Function to render our free extensions
	 *
	 * @since 2.5.5
	 */
	public function render_free_addons() {

		if ( ! empty( $this->free_addons ) ) {

			foreach ( $this->free_addons as $addon ) {

				$slug        = $addon['slug'];
				$plugin_path = $slug . '/' . $slug . '.php';

				if ( 'modula-foo-migrator' === $slug ) {
					$plugin_path = $slug . '/migrate-away-from-foogallery.php';
				}

				if ( 'modula-nextgen-migrator' === $slug ) {
					$plugin_path = $slug . '/migrate-away-from-nextgen.php';
				}

				$activate_url = add_query_arg(
					array(
						'action'        => 'activate',
						'plugin'        => rawurlencode( $plugin_path ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin_path ),
					),
					admin_url( 'plugins.php' )
				);

				$deactivate_url = add_query_arg(
					array(
						'action'        => 'deactivate',
						'plugin'        => rawurlencode( $plugin_path ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $plugin_path ),
					),
					admin_url( 'plugins.php' )
				);

				if ( ! function_exists( 'get_plugin_data' ) || ! function_exists( 'is_plugin_active' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$action = 'install';

				if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
					$action = 'activate';
				}

				if ( is_plugin_active( $plugin_path ) ) {
					$action = 'installed';
				}

				$this->render_addon_top( $addon );
				echo '<div class="modula-free-addon-actions">';

				echo '<div class="modula-toggle">';
				echo '<input class="modula-toggle__input" type="checkbox" name="modula-free-addons" data-action="' . esc_attr( $action ) . '" data-activateurl="' . esc_url( $activate_url ) . '" data-deactivateurl="' . esc_url( $deactivate_url ) . '" value="1"  data-slug="' . esc_attr( $slug ) . '" ' . checked( 'installed', $action, false ) . '>';
				echo '<div class="modula-toggle__items">';
				echo '<span class="modula-toggle__track"></span>';
				echo '<span class="modula-toggle__thumb"></span>';
				echo '<svg class="modula-toggle__off" width="6" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 6 6"><path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>';
				echo '<svg class="modula-toggle__on" width="2" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 2 6"><path d="M0 0h2v6H0z"></path></svg>';
				echo '</div>';
				echo '</div>';
				echo '<span class="modula-action-texts"></span>';

				echo '</div>'; // .modula-free-addon-actions
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

	/**
	 * Check if there are free addons
	 *
	 * @return bool
	 * @since 2.5.5
	 */
	public function check_free_addons() {

		return !empty( $this->free_addons );
	}

	/**
	 * Render the top markup for addons
	 */
	public function render_addon_top( $addon = false, $addons_images = false ) {

		if ( ! $addon ) {
			return;
		}

		if( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		$plugin_data = false;

		if(file_exists(WP_PLUGIN_DIR .'/' . $addon['slug'] . '/' . $addon['slug'] . '.php') ){
			$plugin_data = get_plugin_data( WP_PLUGIN_DIR .'/' . $addon['slug'] . '/' . $addon['slug'] . '.php' );
		}

		$image = ( $addons_images && in_array( $addon[ 'slug' ], $addons_images ) ) ? MODULA_URL . 'assets/images/addons/' . $addon[ 'slug' ] . '.png' : MODULA_URL . 'assets/images/modula-logo.jpg';
		
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
	}

	/**
	 * Check if the free addons were released
	 */
	public function check_for_release( $addons ) {
		return $addons;
	}
}

$addons = new Modula_Addons();
