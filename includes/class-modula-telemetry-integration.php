<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Modula Lite Telemetry Integration
 *
 * Integrates Modula Lite with the WPChill telemetry core.
 * Registers the modula-lite product and handles telemetry events.
 *
 * @package Modula
 * @since 2.12.20
 */
class Modula_Telemetry_Integration {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup WordPress hooks
	 */
	private function setup_hooks() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		// Register data providers via filters
		add_filter( 'wpchill_telemetry_products', array( $this, 'register_product' ) );
		add_filter( 'wpchill_telemetry_extensions', array( $this, 'register_extensions' ) );
		add_filter( 'wpchill_telemetry_themes', array( $this, 'register_themes' ) );
		add_filter( 'wpchill_telemetry_third_party', array( $this, 'register_third_party' ) );
		add_filter( 'wpchill_telemetry_settings', array( $this, 'register_settings' ) );
		add_filter( 'wpchill_telemetry_settings_allowlist', array( $this, 'get_settings_allowlist' ), 10, 2 );

		// Plugin lifecycle events
		add_action( 'activated_plugin', array( $this, 'track_plugin_activated' ) );
		add_action( 'deactivated_plugin', array( $this, 'track_plugin_deactivated' ) );

		// Initialize telemetry after core is loaded
		add_action( 'init', array( $this, 'init_telemetry' ), 20 );
	}

	/**
	 * Initialize telemetry integration
	 */
	public function init_telemetry() {
		// Check if telemetry core is available
		if ( ! class_exists( 'WPChill_Telemetry_Core' ) ) {
			return;
		}

		// Send initial registration if needed
		$this->maybe_send_initial_registration();

		// Send current state if this is a fresh install
		$this->maybe_send_initial_state();

		// Send initial settings if this is a fresh install
		$this->maybe_send_initial_settings();
	}

	/**
	 * Register Modula Lite product
	 *
	 * @param array $products Existing products array
	 * @return array Modified products array
	 */
	public function register_product( $products ) {
		if ( defined( 'MODULA_LITE_VERSION' ) ) {
			$products[] = array(
				'slug'    => 'modula-lite',
				'version' => MODULA_LITE_VERSION,
				'active'  => true,
			);
		}

		return $products;
	}

	/**
	 * Register Modula extensions
	 *
	 * @param array $extensions Existing extensions array
	 * @return array Modified extensions array
	 */
	public function register_extensions( $extensions ) {
		return $extensions;
	}

	/**
	 * Register themes
	 *
	 * @param array $themes Existing themes array
	 * @return array Modified themes array
	 */
	public function register_themes( $themes ) {
		$wp_themes  = wp_get_themes();
		$theme_data = array();

		foreach ( $wp_themes as $theme_slug => $theme ) {
			$theme_data[] = array(
				'slug'    => $theme_slug,
				'name'    => $theme->get( 'Name' ),
				'version' => $theme->get( 'Version' ),
				'active'  => get_stylesheet() === $theme_slug,
			);
		}

		// Limit to 50 themes to avoid payload bloat
		if ( count( $theme_data ) > 50 ) {
			$theme_data = array_slice( $theme_data, 0, 50 );
		}

		return array_merge( $themes, $theme_data );
	}

	/**
	 * Register third-party plugins
	 *
	 * @param array $third_party Existing third-party array
	 * @return array Modified third-party array
	 */
	public function register_third_party( $third_party ) {
		$active_plugins   = get_option( 'active_plugins', array() );
		$filtered_plugins = array();

		foreach ( $active_plugins as $plugin ) {
			$plugin_slug = dirname( $plugin );

			// Skip Modula plugins (they register themselves)
			if ( strpos( $plugin_slug, 'modula' ) !== false ) {
				continue;
			}

			$plugin_data        = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$filtered_plugins[] = array(
				'slug'    => $plugin_slug,
				'name'    => $plugin_data['Name'],
				'version' => $plugin_data['Version'],
				'active'  => true,
			);
		}

		return array_merge( $third_party, $filtered_plugins );
	}

	/**
	 * Register Modula Lite settings
	 *
	 * @param array $settings Existing settings array
	 * @return array Modified settings array
	 */
	public function register_settings( $settings ) {
		$modula_settings = get_option(
			'modula_settings',
			array()
		);

		if ( ! empty( $modula_settings ) ) {
			$settings[] = array(
				'product_slug' => 'modula-lite',
				'settings'     => $modula_settings,
			);
		}

		return $settings;
	}

	/**
	 * Get settings allowlist for Modula Lite
	 *
	 * @param array $allowlist Existing allowlist
	 * @param string $product_slug Product slug
	 * @return array Modified allowlist
	 */
	public function get_settings_allowlist( $allowlist, $product_slug ) {
		if ( 'modula-lite' === $product_slug ) {
			// Use blacklist approach - allow all settings except sensitive ones
			// Return empty array to enable automatic filtering of sensitive keys
			return array();
		}

		return $allowlist;
	}

	/**
	 * Track settings updated event
	 *
	 * @param mixed $old_value Old option value
	 * @param mixed $new_value New option value
	 */
	public function track_settings_updated( $old_value, $new_value ) {
		if ( ! wpchill_telemetry_is_enabled() ) {
			return;
		}

		wpchill_telemetry_send_settings( 'modula-lite', $new_value );
	}

	/**
	 * Track plugin activation
	 *
	 * @param string $plugin Plugin file path
	 */
	public function track_plugin_activated( $plugin ) {
		if ( ! wpchill_telemetry_is_enabled() ) {
			return;
		}

		if ( strpos( $plugin, 'modula' ) !== false ) {
			wpchill_telemetry_send_event(
				'plugin_activated',
				array(
					'plugin' => $plugin,
				)
			);
		}
	}

	/**
	 * Track plugin deactivation
	 *
	 * @param string $plugin Plugin file path
	 */
	public function track_plugin_deactivated( $plugin ) {
		if ( ! wpchill_telemetry_is_enabled() ) {
			return;
		}

		if ( strpos( $plugin, 'modula' ) !== false ) {
			wpchill_telemetry_send_event(
				'plugin_deactivated',
				array(
					'plugin' => $plugin,
				)
			);
		}
	}

	/**
	 * Send initial registration if needed
	 */
	private function maybe_send_initial_registration() {
		$registration_sent = get_option( 'modula_telemetry_registration_sent', false );

		if ( ! $registration_sent ) {
			$result = wpchill_telemetry_register_now( true );
			if ( ! is_wp_error( $result ) ) {
				update_option( 'modula_telemetry_registration_sent', true );
			}
		}
	}

	/**
	 * Send initial state if this is a fresh install
	 */
	private function maybe_send_initial_state() {
		$state_sent = get_option( 'modula_telemetry_initial_state_sent', false );

		if ( ! $state_sent ) {
			$result = wpchill_telemetry_send_state( true, true );
			if ( ! is_wp_error( $result ) ) {
				update_option( 'modula_telemetry_initial_state_sent', true );
			}
		}
	}

	/**
	 * Send initial settings if this is a fresh install
	 */
	private function maybe_send_initial_settings() {
		$settings_sent = get_option( 'modula_telemetry_initial_settings_sent', false );

		if ( ! $settings_sent ) {
			$all_settings = $this->gather_all_settings();
			if ( ! empty( $all_settings ) ) {
				$result = wpchill_telemetry_send_settings( 'modula-lite', $all_settings, true );
				if ( ! is_wp_error( $result ) ) {
					update_option( 'modula_telemetry_initial_settings_sent', true );
				}
			}
		}
	}

	/**
	 * Gather all Modula settings (global + per-gallery)
	 *
	 * @return array All settings data
	 */
	private function gather_all_settings() {
		$settings = array();

		// Global settings
		$global_settings = get_option( 'modula_settings', array() );
		if ( ! empty( $global_settings ) ) {
			$settings['global'] = $global_settings;
		}

		// Per-gallery settings
		$galleries = get_posts(
			array(
				'post_type'      => 'modula-gallery',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		if ( ! empty( $galleries ) ) {
			$gallery_settings = array();
			foreach ( $galleries as $gallery_id ) {
				$gallery_config = get_post_meta( $gallery_id, 'modula-settings', true );
				$images         = get_post_meta( $gallery_id, 'modula-images', true );
				if ( ! empty( $gallery_config ) ) {
					$gallery_settings[ $gallery_id ] = $gallery_config;
				}
				if ( ! empty( $images ) ) {
					$gallery_settings[ $gallery_id ]['images'] = $images;
				}
			}
			if ( ! empty( $gallery_settings ) ) {
				$settings['galleries'] = $gallery_settings;
			}
		}

		return $settings;
	}

	/**
	 * Get telemetry status for debugging
	 *
	 * @return array Telemetry status information
	 */
	public function get_telemetry_status() {
		if ( ! function_exists( 'wpchill_telemetry_get_status' ) ) {
			return array( 'error' => 'Telemetry core not available' );
		}

		return array(
			'enabled'          => wpchill_telemetry_is_enabled(),
			'status'           => wpchill_telemetry_get_status(),
			'registration'     => get_option( 'modula_telemetry_registration_sent', false ),
			'initial_state'    => get_option( 'modula_telemetry_initial_state_sent', false ),
			'initial_settings' => get_option( 'modula_telemetry_initial_settings_sent', false ),
		);
	}
}
