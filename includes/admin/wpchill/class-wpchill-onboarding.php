<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPChill_Onboarding' ) ) {
	//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
	class WPChill_Onboarding {

		public static $instance;

		private $args;
		private $slug;
		private $page;

		public function __construct( $args ) {
			if ( ! is_admin() || wp_doing_cron() || wp_doing_ajax() ) {
				return;
			}

			add_action( 'admin_menu', array( $this, 'add_page' ) );
			add_action( 'admin_head', array( $this, 'hide_page_from_menu' ) );
			add_action( 'admin_init', array( $this, 'maybe_render_page' ) );

			$this->args = $args;
			$this->slug = isset( $args['slug'] ) ? $args['slug'] : 'wpchill';
			$this->page = $this->slug . '-onboarding-page';

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

			if ( ! class_exists( 'WPChill_Rest_Api' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'class-wpchill-rest-api.php';
			}
			new WPChill_Rest_Api();
		}

		// public static function get_instance() {

		//  if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPChill_Onboarding ) ) {
		//      self::$instance = new WPChill_Onboarding();
		//  }

		//  return self::$instance;
		// }


		/**
		 * Adds a dashboard page for our setup wizard.
		 *
		 * @since 2.13.0
		 *
		 * @return void
		 */
		public function add_page() {
			add_dashboard_page( '', '', 'manage_options', $this->page, '' );
		}

		/**
		 * Hide the dashboard page from the menu.
		 *
		 * @since 2.13.0
		 *
		 * @return void
		 */
		public function hide_page_from_menu() {
			remove_submenu_page( 'index.php', $this->page );
		}

		/**
		 * Checks to see if we should load the setup wizard.
		 *
		 * @since 1.8.12
		 *
		 * @return void
		 */
		public function maybe_render_page() {
			if ( wp_doing_ajax() || wp_doing_cron() ) {
				return;
			}

			if (
				! isset( $_GET['page'] ) || // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				sanitize_text_field( wp_unslash( $_GET['page'] ) ) !== $this->page || // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				! current_user_can( 'manage_options' )
			) {
				return;
			}

			set_current_screen();

			// Remove an action in the Gutenberg plugin ( not core Gutenberg ) which throws an error.
			//remove_action( 'admin_print_styles', 'gutenberg_block_editor_admin_print_styles' );

			// If we are redirecting, clear the transient so it only happens once.
			$this->admin_scripts();
			$this->render_page();
		}

		/**
		 * Hide the dashboard page from the menu.
		 *
		 * @since 2.13.0
		 *
		 * @return void
		 */
		public function render_page() {
			?>
			<!DOCTYPE html>
			<html <?php language_attributes(); ?> dir="ltr">
			<head>
				<meta charset="<?php bloginfo( 'charset' ); ?>">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>
				<?php
				// translators: %s is the plugin name.
				printf( esc_html__( '%s Onboarding Wizard', 'envira-gallery-lite' ), isset( $this->args['name'] ) ? $this->args['name'] : 'WPChill' );
				?>
				</title>
			</head>
				<body>
					<div id="wpchill-onboarding-root">

					</div>
				<?php
				do_action( 'admin_footer', '' );
				do_action( 'admin_print_footer_scripts' );
				?>
				</body>
			</html>
			<?php
			exit;
		}

		public function admin_scripts() {

			if (
				! isset( $_GET['page'] ) || // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				sanitize_text_field( wp_unslash( $_GET['page'] ) ) !== $this->page || // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				! current_user_can( 'manage_options' )
			) {
				return;
			}

			$wpchill_path = plugin_dir_path( __FILE__ );
			$wpchill_url  = plugin_dir_url( __FILE__ );

			$asset_file = require $wpchill_path . 'scripts/onboarding/onboarding.asset.php';
			$enqueue    = array(
				'handle'       => 'wpchill-onboarding',
				'dependencies' => $asset_file['dependencies'],
				'version'      => $asset_file['version'],
				'script'       => $wpchill_url . 'scripts/onboarding/onboarding.js',
				'style'        => $wpchill_url . 'scripts/onboarding/onboarding.css',
			);

			wp_enqueue_script(
				$enqueue['handle'],
				$enqueue['script'],
				$enqueue['dependencies'],
				$enqueue['version'],
				true
			);

			wp_enqueue_style(
				$enqueue['handle'],
				$enqueue['style'],
				array( 'wp-components' ),
				$enqueue['version']
			);

			wp_localize_script(
				$enqueue['handle'],
				'modulaOnboarding',
				array(
					'logo' => plugin_dir_url( __FILE__ ) . 'icons/wpchill-logo.jpg',
				),
			);
		}
	}
}
