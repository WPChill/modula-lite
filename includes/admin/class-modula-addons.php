<?php

class Modula_Addons {

	public $addons = array();

	public $free_addons = array();

	/**
	 * Holds the class object.
	 *
	 * @since 2.5.0
	 *
	 * @var object
	 */
	public static $instance;

	public function __construct() {
		// Add ajax action to reload extensions
		add_action( 'wp_ajax_modula_reload_extensions', array( $this, 'reload_extensions' ), 20 );
		add_filter( 'modula_free_extensions', array( $this, 'check_for_release' ), 999 );
		add_action( 'init', array( $this, 'set_free_addons' ) );
	}

	private function check_for_addons() {
		$data = get_transient( 'modula_all_extensions' );
		if ( false !== $data ) {
			return apply_filters( 'modula_addons', $data );
		}

		$err_count = get_transient( 'modula_all_extensions_error_count' );
		$addons    = array();

		if ( $err_count && 5 <= $err_count ) {
			return apply_filters( 'modula_addons', $addons );
		}

		$url = MODULA_PRO_STORE_URL . '/wp-json/mt/v1/get-all-extensions';

		// Get data from the remote URL.
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			set_transient( 'modula_all_extensions_error_count', $err_count ? ++$err_count : 1, 3600 );
			return apply_filters( 'modula_addons', $addons );
		}

		delete_transient( 'modula_all_extensions_error_count' );

		// Decode the data that we got.
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! empty( $data ) && is_array( $data ) ) {
			$addons = $data;
			// Store the data for a week.
			set_transient( 'modula_all_extensions', $data, 30 * DAY_IN_SECONDS );
		}

		return apply_filters( 'modula_addons', $addons );
	}

	public function render_addons() {

		$this->addons = $this->check_for_addons();

		$addons_images = array(
			'modula-whitelabel',
			'modula-roles',
			'modula-defaults',
			'modula-zoom',
			'modula-download',
			'modula-exif',
			'modula-albums',
			'modula-slider',
			'modula-password-protect',
			'modula-watermark',
			'modula-deeplink',
			'modula-speedup',
			'modula-video',
			'modula-advanced-shortcodes',
			'modula-slideshow',
			'modula-protection',
			'modula-fullscreen',
		);

		$addons = apply_filters( 'modula_package_sortage', $this->addons );
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

		/**
		 * Action to do when reloading extensions. Used for extension to hook into this action and reload their data.
		 *
		 * @since 2.8.0
		 */
		do_action( 'modula_reload_extensions' );

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
		return ! empty( $this->free_addons );
	}

	/**
	 * Render the top markup for addons
	 */
	public function render_addon_top( $addon = false, $addons_images = false ) {

		if ( ! $addon ) {
			return;
		}

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_data = false;

		if ( file_exists( WP_PLUGIN_DIR . '/' . $addon['slug'] . '/' . $addon['slug'] . '.php' ) ) {
			$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $addon['slug'] . '/' . $addon['slug'] . '.php' );
		}

		$image = ( $addons_images && in_array( $addon['slug'], $addons_images ) ) ? MODULA_URL . 'assets/images/addons/' . $addon['slug'] . '.png' : MODULA_URL . 'assets/images/modula-logo.jpg';

		echo '<div class="modula-addon">';
		echo '<div class="modula-addon-box">';

		if ( ! isset( $addon['image'] ) || '' == $addon['image'] ) {
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

	public function set_free_addons() {
		// Add free
		$this->free_addons = apply_filters(
			'modula_free_extensions',
			array(
				'modula-foo-migrator'                 => array(
					'slug'        => 'modula-foo-migrator',
					'name'        => __( 'Migrate away from FooGallery', 'modula-best-grid-gallery' ),
					'image'       => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
					'description' => esc_html__( 'Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'modula-best-grid-gallery' ),
				),
				'modula-nextgen-migrator'             => array(
					'slug'        => 'modula-nextgen-migrator',
					'name'        => __( 'Migrate away from NextGEN', 'modula-best-grid-gallery' ),
					'image'       => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
					'description' => esc_html__( 'Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'modula-best-grid-gallery' ),
				),
				'modula-envira-migrator'              => array(
					'slug'        => 'modula-envira-migrator',
					'name'        => __( 'Migrate away from Envira', 'modula-best-grid-gallery' ),
					'image'       => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
					'description' => esc_html__( 'Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'modula-best-grid-gallery' ),
				),
				'modula-photoblocks-gallery-migrator' => array(
					'slug'        => 'modula-photoblocks-gallery-migrator',
					'name'        => __( 'Migrate away from PhotoBlocks', 'modula-best-grid-gallery' ),
					'image'       => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
					'description' => esc_html__( 'Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'modula-best-grid-gallery' ),
				),
				'modula-final-tiles-migrator'         => array(
					'slug'        => 'modula-final-tiles-migrator',
					'name'        => __( 'Migrate away from Final Tiles', 'modula-best-grid-gallery' ),
					'image'       => 'https://wp-modula.com/wp-content/uploads/edd/2021/04/069-refresh.png',
					'description' => esc_html__( 'Want to change your gallery plugin and impress your potential clients with a fully customizable WordPress gallery plugin that\'s fully mobile responsive', 'modula-best-grid-gallery' ),
				),
			)
		);
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Addons object.
	 * @since 2.11.19
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) || ! ( self::$instance instanceof Modula_Addons ) ) {
			self::$instance = new Modula_Addons();
		}

		return self::$instance;
	}
}

$addons = Modula_Addons::get_instance();
