<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
if ( ! class_exists( 'WPChill_Upsells' ) ) {

	class WPChill_Upsells {

		/**
		 * Holds the class object.
		 *
		 * @since 1.0.0
		 *
		 * @var object
		 */
		public static $instance;

		/**
		 * The slug of the CPT.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $cpt_slug = 'modula-gallery';

		/**
		 * The server from which we get our info
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $remote_server = 'https://wp-modula.com/wp-json/';
		/**
		 * The plugin's page basename
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $plugin_page_basename = 'modula-gallery_page_modula';

		/**
		 * The license key meta
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $license_key_meta = 'modula_pro_license_key';

		/**
		 * The license key status
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $license_key_meta_status = 'modula_pro_license_status';

		/**
		 * The name of the plugin.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		public $plugin_name = 'WPChill Client';

		/**
		 * Route namespace
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $namespace = 'wpchill/v1/';

		/**
		 * Package route
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $package_route = 'get-packages';

		/**
		 * Upgrade route
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $upgrade_route = 'get-upgrade';

		/**
		 * The license key
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $license_key = '';

		/**
		 * The pricing page
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $pricing_page = 'https://wp-modula.com/pricing/';

		/**
		 * The PRO version class
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $pro_version_class = 'Modula_PRO';

		/**
		 * Our packages
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $packages = array();

		/**
		 * The lite vs premium page action
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $lite_vs_premium_page = 'modula_lite_vs_premium_page';

		/**
		 * The lite vs premium page title filter
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		private $lite_vs_premium_page_title = 'modula_lite_vs_premium_page_title';

		/**
		 * Primary class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$this->check_for_upgrades();
			add_action( $this->lite_vs_premium_page, array( $this, 'lite_vs_premium' ), 30, 2 );
			add_filter( $this->lite_vs_premium_page_title, array( $this, 'lite_vs_premium_page_title' ), 30 );

		}

		/**
		 * Returns the singleton instance of the class.
		 *
		 * @return object The WPChill_Upsells object.
		 * @since 1.0.0
		 *
		 */
		public static function get_instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPChill_Upsells ) ) {
				self::$instance = new WPChill_Upsells();
			}

			return self::$instance;

		}

		/**
		 * Fetch all packages
		 *
		 * @since 1.0.0
		 */
		public function fetch_packages() {

			// Lets get the transient
			$packages_transient = get_transient( 'wpchill_all_packages' );

			// If the transient exists then we will not make another call to the main server
			if ( $packages_transient && ! empty( $packages_transient ) ) {
				$this->packages = $packages_transient;

				return;
			}

			// Transient doesn't exist so we make the call
			$response = wp_remote_get( $this->remote_server . $this->namespace . $this->package_route );

			if ( ! is_wp_error( $response ) ) {

				// Decode the data that we got.
				$data = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $data ) && is_array( $data ) ) {
					$this->packages = $data;
					set_transient( 'wpchill_all_packages', $this->packages, '86400' );
				}

			}

		}

		/**
		 * Fectch current client package and give upgrades
		 *
		 * @since 1.0.0
		 */
		public function fetch_current_package() {

			// Lets get the transient
			$packages_transient = get_transient( 'wpchill_upgradable_packages' );

			// If the transient exists then we will not make another call to the main server
			if ( $packages_transient && ! empty( $packages_transient ) ) {
				$this->packages = $packages_transient;

				return;
			}

			// Transient doesn't exist so we make the call
			$url      = preg_replace( '/\?.*/', '', get_bloginfo( 'url' ) );
			$response = wp_remote_get( $this->remote_server . $this->namespace . $this->upgrade_route . '?license=' . $this->license_key . '&url=' . $url );

			if ( ! is_wp_error( $response ) ) {

				// Decode the data that we got.
				$data = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $data ) && is_array( $data ) ) {
					// Set our packages
					$this->packages = $data;
					// Set our transient so that we won't make calls each time user enters a Modula page
					set_transient( 'wpchill_upgradable_packages', $this->packages, '86400' );
				}
			}
		}

		/**
		 * Lets check for license
		 *
		 * @return bool
		 *
		 * @since 1.0.0
		 */
		public function check_for_license() {

			$license_status = get_option( $this->license_key_meta_status );

			// There is no license or license is not valid anymore, so we get all packages
			if ( ! $license_status || 'valid' != $license_status->license ) {
				return false;
			}

			return true;
		}

		/**
		 * Check if license is active and if there are packages to update to
		 *
		 * @since 1.0.0
		 */
		public function check_for_upgrades() {

			// If there is no license, or license invalid or the PRO version is not installed
			// We should retrieve all the packages
			if ( ! $this->check_for_license() || ! class_exists( $this->pro_version_class ) ) {
				$this->fetch_packages();
			} else {
				$this->fetch_current_package();
			}
		}

		/**
		 * Check to see if addon is in our upgrade list
		 *
		 * @param $addon
		 *
		 * @return bool
		 *
		 * @since 1.0.0
		 */
		public function is_upgradable_addon( $addon = false ) {

			if ( ! $addon ) {
				return false;
			}

			if ( ! empty( $this->packages ) ) {
				if ( isset( $this->packages['upsell_packages'] ) ) {
					$packages = $this->packages['upsell_packages'];
				} else {
					$packages = $this->packages;
				}
				foreach ( $packages as $package ) {

					if ( isset( $package['extensions'][ $addon ] ) ) {
						return true;
					}
				}
			}

			return false;
		}

		/**
		 * Get our packages
		 *
		 * @return string
		 *
		 * @since 1.0.0
		 */
		public function get_packages() {

			return $this->packages;
		}

		/**
		 * Sort packages based on price
		 *
		 * @return int
		 * @since 1.0.0
		 *
		 */
		public static function sort_data_by_price( $a, $b ) {
			if ( ! isset( $a['upgrade_price'], $b['upgrade_price'] ) ) {
				return - 1;
			}
			if ( $a['upgrade_price'] == $b['upgrade_price'] ) {
				return 0;
			}

			return $a['upgrade_price'] > $b['upgrade_price'] ? - 1 : 1;
		}

		/**
		 * The Current Package vs Upgrade Package page
		 *
		 * @param $addons
		 * @param $pro_features
		 *
		 * @since 1.0.0
		 */
		public function lite_vs_premium( $addons, $pro_features ) {

			$upsell_packages = array();

			$lite_plan['modula-lite'] = array(
					'name' => esc_html__( 'Modula - LITE', 'modula-best-grid-gallery' ),
			);

			$packages = $this->get_packages();

			if ( isset( $packages['current_package'] ) && ! empty( $package['current_package'] ) ) {
				$lite_plan = $packages['current_package'];
			}

			if ( isset( $packages['upsell_packages'] ) ) {
				$upsell_packages = $packages['upsell_packages'];
			}

			// Lets sort them by price, higher is better
			uasort( $upsell_packages, array( 'WPChill_Upsells', 'sort_data_by_price' ) );

			$all_packages = array_merge( $upsell_packages, $lite_plan );

			// Make the size of the element based on number of addons
			if ( count( $upsell_packages ) > 0 ) {
				echo '<style>.wpchill-pricing-package {width:' . ( intval( 100 / ( count( $upsell_packages ) + 2 ) ) - 1 ) . '%}</style>';
			}
			?>

			<div class="wpchill-plans-table">
				<div class="wpchill-pricing-package wpchill-empty">
					<!--This is an empty div so that we can have an empty corner-->
				</div>
				<?php
				foreach ( $all_packages as $slug => $package ) { ?>
					<div class="wpchill-pricing-package wpchill-title">
						<!--Usually the names are "Plugin name - Package" so we make the explode -->
						<p><?php echo esc_html__( isset( explode( '-', $package['name'] )[1] ) ? explode( '-', $package['name'] )[1] : $package['name'] ); ?></p>
						<?php

						// Lets display the price and other info about our packages
						if ( isset( $package['upgrade_price'] ) && 'modula-lite' != $slug ) {
							?>
							<p><?php echo esc_html__( 'Upgrade now for only', 'modula-best-grid-gallery' ) ?></p>
							<p class="wpchill-price"><?php echo ( isset( $package['upgrade_price'] ) ) ? '<sup>$</sup><strong>' . esc_html( $package['upgrade_price'] ) . '</strong><sup>.00</sup>' : ' '; ?>
							<p class="description"><?php echo ( isset( $package['excerpt'] ) ) ? esc_html( $package['excerpt'] ) : ' '; ?></p>
							<a href="<?php echo esc_url( $this->pricing_page ); ?>" target="_blank"
							   class="button button-primary"><?php echo esc_html__( 'Upgrade', '' ); ?></a>
						<?php } ?>

					</div>
				<?php } ?>
			</div>
			<?php
			// Pro features are features that are present in the PRO version of the plugin
			// And not in extensions / addons
			if ( ! empty( $pro_features ) ) {
				foreach ( $pro_features as $pro_feature ) {
					?>
					<div class="wpchill-plans-table">
						<div class="wpchill-pricing-package feature-name">
							<?php echo esc_html( $pro_feature['title'] ); ?>
							<?php
							// Tooltip the description if any
							if ( isset( $pro_feature['description'] ) ) {
								?>
								<div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span>
									<div class="tab-header-description modula-tooltip-content"><?php echo wp_kses_post( $pro_feature['description'] ) ?></div>
								</div>
								<?php
							}
							?>
						</div>

						<?php
						// Now let's go through our packages
						foreach ( $all_packages as $slug => $upsell ) { ?>
							<div class="wpchill-pricing-package">
								<?php
								// We need the LITE version because if there is no license key / current package the LITE will be a package also
								if ( 'modula-lite' != $slug ) {
									echo '<span class="dashicons dashicons-saved"></span>';
								} else {
									echo '<span class="dashicons dashicons-no-alt"></span>';
								}
								?>
							</div>
						<?php } ?>
					</div>
				<?php }
			}
			// Now lets loop through each addon described in LITE version of the plugin
			foreach ( $addons as $key => $addon ) {
				?>
				<div class="wpchill-plans-table">
					<div class="wpchill-pricing-package feature-name">
						<?php echo esc_html( $addon['title'] ); ?>
						<?php
						if ( isset( $addon['description'] ) ) {
							?>
							<div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span>
								<div class="tab-header-description modula-tooltip-content"><?php echo wp_kses_post( $addon['description'] ) ?></div>
							</div>
							<?php
						}
						?>
					</div>

					<?php
					// Need to check if each package if the addon is contained
					foreach ( $all_packages as $slug => $upsell ) { ?>

						<div class="wpchill-pricing-package">
							<?php
							if ( isset( $upsell['extensions'][ $key ] ) ) {
								echo '<span class="dashicons dashicons-saved"></span>';
							} else {
								echo '<span class="dashicons dashicons-no-alt"></span>';
							}
							?>
						</div>
					<?php } ?>
				</div>
			<?php }
		}

		/**
		 * The LITE vs Premium page title
		 *
		 * @param $menu
		 *
		 * @return mixed
		 *
		 * @since 1.0.0
		 */
		public function lite_vs_premium_page_title( $menu ) {

			// Check for license and current package
			if ( ! $this->check_for_license() || ! isset( $this->packages['current_package'] ) || empty( $this->packages['current_package'] ) ) {
				return $menu;
			}

			// We made it here, so license is active and there is a current package
			// If no upsells are present means that the client has the highest package
			if ( empty( $this->packages['upsell_packages'] ) ) {
				return array();
			}

			// We call the main plugin class where the menu is set so that we can call the methods of that class
			$plugin_menu_class = new Modula_admin();

			// This is the case for Modula - see Modula LITE path : includes/admin/class-modula-admin.php around line 90
			return array(
					'page_title' => esc_html__( 'Upgrade', 'modula-best-grid-gallery' ),
					'menu_title' => esc_html__( 'Upgrade', 'modula-best-grid-gallery' ),
					'capability' => 'manage_options',
					'menu_slug'  => 'modula-lite-vs-pro',
					'function'   => array( $plugin_menu_class, 'lite_vs_pro' ),
					'priority'   => 100,
			);
		}

	}

	WPChill_Upsells::get_instance();
}