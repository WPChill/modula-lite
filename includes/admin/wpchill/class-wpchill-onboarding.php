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
			add_action( 'modula_rest_api_register_routes', array( $this, 'rest_api_register_routes' ) );

			if ( ! class_exists( 'WPChill_Rest_Api' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'class-wpchill-rest-api.php';
			}

			new WPChill_Rest_Api();
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
				printf( esc_html__( '%s onboarding', 'modula-best-grid-gallery' ), isset( $this->args['name'] ) ? esc_html( $this->args['name'] ) : 'WPChill' );
				?>
				</title>
			</head>
				<body class="modula-best-grid-gallery">
					<div id="wpchill-onboarding-root"></div>
				<?php
				do_action( 'admin_footer', '' ); //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				do_action( 'admin_print_footer_scripts' ); //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
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

			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );

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
				'wpchillOnboarding',
				array(
					'slug'            => $this->slug,
					'logo'            => isset( $this->args['logo'] ) ? $this->args['logo'] : 0,
					'welcome'         => isset( $this->args['texts'] ) && isset( $this->args['texts']['welcome'] ) ? $this->args['texts']['welcome'] : 0,
					'welcomeMessage'  => isset( $this->args['texts'] ) && isset( $this->args['texts']['welcomeMessage'] ) ? $this->args['texts']['welcomeMessage'] : 0,
					'thankYou'        => isset( $this->args['texts'] ) && isset( $this->args['texts']['thankYou'] ) ? $this->args['texts']['thankYou'] : 0,
					'thankYouMessage' => isset( $this->args['texts'] ) && isset( $this->args['texts']['thankYouMessage'] ) ? $this->args['texts']['thankYouMessage'] : 0,
					'thankYouLinks'   => isset( $this->args['links'] ) ? $this->args['links'] : array(),
				),
			);

			wp_enqueue_style( 'common' );
			wp_enqueue_media();
		}

		public function rest_api_register_routes( $instance ) {

			$namespace = 'wpchill/v1';

			register_rest_route(
				$namespace,
				'/onboarding/data',
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_onboarding_data' ),
					'permission_callback' => array( $instance, '_permissions_check' ),
					'args'                => array(
						'source' => array(
							'type'     => 'string',
							'required' => false,
						),
					),
				)
			);

			register_rest_route(
				$namespace,
				'/onboarding/recommended',
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_onboarding_recommended' ),
					'permission_callback' => array( $instance, '_permissions_check' ),
					'args'                => array(
						'source' => array(
							'type'     => 'string',
							'required' => false,
						),
					),
				)
			);

			register_rest_route(
				$namespace,
				'/onboarding/save-step',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'save_onboarding_step' ),
					'permission_callback' => array( $instance, '_permissions_check' ),
				)
			);

			register_rest_route(
				$namespace,
				'/onboarding/install-plugins',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'install_plugins' ),
					'permission_callback' => array( $instance, '_permissions_check' ),
				)
			);

			register_rest_route(
				$namespace,
				'/onboarding/check-license',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'license_action' ),
					'permission_callback' => array( $instance, '_permissions_check' ),
				)
			);
		}

		public function get_onboarding_data( $request ) {

			$source = $request->get_param( 'source' );

			if ( ! $source ) {
				return rest_ensure_response( false );
			}

			$defaults = array(
				'about-you' => array(
					'role'           => 'photographer',
					'email'          => get_option( 'admin_email', '' ),
					'helpUnderstand' => true,
					'agreeEmails'    => false,
				),
			);

			$saved = get_option( $source . '_onboarding_data', array() );

			$data = array_replace_recursive( $defaults, $saved );

			$data['license_key']    = get_option( 'modula_pro_license_key', false );
			$data['license_status'] = get_option( 'modula_pro_license_status', false );

			return rest_ensure_response( $data );
		}

		public function save_onboarding_step( $request ) {

			$key    = $request->get_param( 'key' );
			$source = $request->get_param( 'source' );
			$data   = $request->get_param( 'data' );

			$saved = get_option( $source . '_onboarding_data', array() );

			$saved[ $key ] = $data;

			update_option( $source . '_onboarding_data', $saved );
			return rest_ensure_response( array( 'success' => true ) );
		}

		public function get_onboarding_recommended( $request ) {

			$source = $request->get_param( 'source' );

			include_once ABSPATH . 'wp-admin/includes/plugin.php';

			$plugins = array(
				array(
					'slug'        => 'modula-best-grid-gallery',
					'title'       => 'Modula Image Gallery',
					'description' => 'Create beautiful, responsive photo galleries with Modula — the fastest gallery plugin for WordPress.',
				),
				array(
					'slug'        => 'download-monitor',
					'title'       => 'Download Monitor',
					'description' => 'Easily manage and track your downloadable files with Download Monitor.',
				),
				array(
					'slug'        => 'strong-testimonials',
					'title'       => 'Strong Testimonials',
					'description' => 'Collect and display customer testimonials beautifully on your site.',
				),
				array(
					'slug'        => 'kali-forms',
					'title'       => 'Kali Forms',
					'description' => 'Build modern contact forms, surveys, and more — fast and easy with Kali Forms.',
				),
				array(
					'slug'        => 'rsvp',
					'title'       => 'RSVP and Event Management',
					'description' => 'Manage event RSVPs, guest lists, and confirmations with ease using RSVP plugin.',
				),
				array(
					'slug'        => 'filr',
					'title'       => 'Filr',
					'description' => 'Organize, protect, and share files easily on your WordPress website with Filr.',
				),
				array(
					'slug'        => 'content-protector',
					'title'       => 'Passster',
					'description' => 'Protect your content with passwords or reCAPTCHA using Passster.',
				),
				array(
					'slug'        => 'reviveso',
					'title'       => 'Revive.so',
					'description' => 'Use AI to automatically rewrite and enhance your content for SEO and readability.',
				),
			);

			$installed_plugins = get_plugins();
			$recommended       = array();

			foreach ( $plugins as $plugin ) {
				$slug = $plugin['slug'];

				if ( $slug === $source ) {
					continue;
				}

				$status      = 'not-installed';
				$plugin_file = '';

				// Check if plugin is installed
				foreach ( $installed_plugins as $file => $data ) {
					if ( strpos( $file, $slug . '/' ) === 0 || strpos( $file, $slug . '.php' ) !== false ) {
						$plugin_file = $file;
						break;
					}
				}

				// Determine status
				if ( $plugin_file && is_plugin_active( $plugin_file ) ) {
					$status = 'active';
				} elseif ( $plugin_file ) {
					$status = 'installed';
				}

				$recommended[] = array(
					'slug'        => $slug,
					'title'       => $plugin['title'],
					'description' => $plugin['description'],
					'status'      => $status,
				);
			}

			return rest_ensure_response(
				array(
					'recommended' => array_values( $recommended ), // reset keys
				)
			);
		}


		public function install_plugins( $request ) {
			$plugins = $request->get_param( 'plugins' );

			if ( empty( $plugins ) || ! is_array( $plugins ) ) {
				return rest_ensure_response(
					array(
						'success' => false,
						'message' => __( 'No plugins provided for installation.', 'wpchill' ),
					)
				);
			}

			// Load required WordPress files.
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			include_once ABSPATH . 'wp-admin/includes/file.php';
			include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			WP_Filesystem();

			$results = array();

			foreach ( $plugins as $slug ) {
				$slug = sanitize_key( $slug );

				// Check if the plugin is already installed.
				$installed_plugins = get_plugins();
				$plugin_file       = '';

				foreach ( $installed_plugins as $file => $data ) {
					if ( strpos( $file, $slug . '/' ) === 0 || strpos( $file, $slug . '.php' ) !== false ) {
						$plugin_file = $file;
						break;
					}
				}

				// If the plugin is already active, skip it.
				if ( $plugin_file && is_plugin_active( $plugin_file ) ) {
					$results[ $slug ] = array(
						'status'  => 'already-active',
						'message' => sprintf( __( 'Plugin %s is already active.', 'wpchill' ), $slug ),
					);
					continue;
				}

				// If the plugin is installed but inactive, try to activate it.
				if ( $plugin_file && ! is_plugin_active( $plugin_file ) ) {
					$activate = activate_plugin( $plugin_file );

					if ( is_wp_error( $activate ) ) {
						$results[ $slug ] = array(
							'status'  => 'activation-failed',
							'message' => $activate->get_error_message(),
						);
						continue;
					}

					$results[ $slug ] = array(
						'status'  => 'activated',
						'message' => sprintf( __( 'Plugin %s activated successfully.', 'wpchill' ), $slug ),
					);
					continue;
				}

				// If the plugin is not installed, fetch its info and install it.
				$api = plugins_api(
					'plugin_information',
					array(
						'slug'   => $slug,
						'fields' => array( 'sections' => false ),
					)
				);

				if ( is_wp_error( $api ) ) {
					$results[ $slug ] = array(
						'status'  => 'install-failed',
						'message' => sprintf( __( 'Could not fetch information for %s.', 'wpchill' ), $slug ),
					);
					continue;
				}

				$upgrader  = new Plugin_Upgrader( new Automatic_Upgrader_Skin() );
				$installed = $upgrader->install( $api->download_link );

				if ( is_wp_error( $installed ) || ! $installed ) {
					$results[ $slug ] = array(
						'status'  => 'install-failed',
						'message' => sprintf( __( 'Installation failed for %s.', 'wpchill' ), $slug ),
					);
					continue;
				}

				// Refresh plugin list and find the new file.
				$installed_plugins = get_plugins();
				$plugin_file       = '';

				foreach ( $installed_plugins as $file => $data ) {
					if ( strpos( $file, $slug . '/' ) === 0 || strpos( $file, $slug . '.php' ) !== false ) {
						$plugin_file = $file;
						break;
					}
				}

				if ( ! $plugin_file ) {
					$results[ $slug ] = array(
						'status'  => 'not-found-after-install',
						'message' => sprintf( __( 'Plugin file not found for %s after installation.', 'wpchill' ), $slug ),
					);
					continue;
				}

				// Try to activate the newly installed plugin.
				$activate = activate_plugin( $plugin_file );

				if ( is_wp_error( $activate ) ) {
					$results[ $slug ] = array(
						'status'  => 'activation-failed',
						'message' => $activate->get_error_message(),
					);
					continue;
				}

				$results[ $slug ] = array(
					'status'  => 'installed-and-activated',
					'message' => sprintf( __( 'Plugin %s installed and activated successfully.', 'wpchill' ), $slug ),
				);
			}

			return rest_ensure_response(
				array(
					'success' => true,
					'results' => $results,
				)
			);
		}

		public function license_action( WP_REST_Request $request ) {
			$url         = $request->get_param( 'url' );
			$license_key = $request->get_param( 'license_key' );
			$site_url    = $request->get_param( 'site_url' );
			$action      = $request->get_param( 'action' );

			if ( empty( $url ) || ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
				return rest_ensure_response(
					array(
						'success' => false,
						'message' => 'Invalid or missing URL parameter.',
					)
				);
			}

			if ( empty( $license_key ) ) {
				return rest_ensure_response(
					array(
						'success' => false,
						'message' => 'Missing license_key parameter.',
					)
				);
			}

			if ( empty( $site_url ) || ! filter_var( $site_url, FILTER_VALIDATE_URL ) ) {
				return rest_ensure_response(
					array(
						'success' => false,
						'message' => 'Invalid or missing site_url parameter.',
					)
				);
			}

			if ( empty( $action ) ) {
				return rest_ensure_response(
					array(
						'success' => false,
						'message' => 'Missing action parameter.',
					)
				);
			}

			$transient_key = 'wpchill_license_' . md5( $license_key . '|' . $action );

			$cached = get_transient( $transient_key );

			if ( $cached ) {
				$this->save_license_options_if_valid( $license_key, $cached );

				return rest_ensure_response(
					array(
						'success' => true,
						'results' => $cached,
						'cached'  => true,
					)
				);
			}

			$body = array(
				'license_key' => $license_key,
				'url'         => $site_url,
				'action'      => $action,
			);

			$args = array(
				'headers' => array( 'Content-Type' => 'application/json' ),
				'body'    => wp_json_encode( $body ),
				'timeout' => 20,
				'method'  => 'POST',
			);

			$response = wp_remote_post( $url, $args );

			if ( is_wp_error( $response ) ) {
				return rest_ensure_response(
					array(
						'success' => false,
						'message' => $response->get_error_message(),
					)
				);
			}

			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			set_transient( $transient_key, $data, DAY_IN_SECONDS );

			$this->save_license_options_if_valid( $license_key, $data );

			return rest_ensure_response(
				array(
					'success' => true,
					'results' => $data,
					'cached'  => false,
				)
			);
		}
		private function save_license_options_if_valid( $license_key, $data ) {

			if ( ! $data || empty( $data['success'] ) ) {
				return;
			}

			update_option( 'modula_pro_license_key', $license_key );

			$save          = new stdClass();
			$save->success = (bool) $data['success'];
			$save->license = ( isset( $data['status'] ) && $data['status'] === 'active' )
				? 'valid'
				: 'invalid';

			if ( isset( $data['expiration'] ) ) {
				$save->expires = gmdate( 'Y-m-d H:i:s', (int) $data['expiration'] );
			}

			update_option( 'modula_pro_license_status', $save );
		}
	}
}
