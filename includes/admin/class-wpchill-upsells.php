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
		 * @since 2.5.2
		 *
		 * @var object
		 */
		public static $instance;

		/**
		 * The server from which we get our info
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $shop_url = '';

		/**
		 * Plugin slug
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $slug = '';

		/**
		 * The license key meta
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $license_key_meta;

		/**
		 * The license key status
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $license_key_meta_status;

		/**
		 * The license key
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $license_key = '';

		/**
		 * The PRO version class
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $pro_version_class = 'Modula_PRO';

		/**
		 * Our packages
		 *
		 * @since 2.5.2
		 *
		 * @var string
		 */
		private $packages = array();

		/**
		 * URL endpoints
		 *
		 * @since 2.5.2
		 *
		 * @var array
		 */
		private $endpoints = array(
			'checkout'      => 'checkout',
			'pricing'       => 'pricing',
			'base'          => 'wp-json/wpchill/v1/'
		);

		/**
		 * Primary class constructor.
		 *
		 * $args : array
		 *
		 * @since 2.5.2
		 */
		public function __construct( $args ) {

			if ( ! isset( $args['slug'] ) ) {
				return;
			}

			if ( ! isset( $args['shop_url'] ) ) {
				return;
			}

			$this->slug     = $args['slug'];
			$this->shop_url = $args['shop_url'];

			if ( isset( $args['license'] ) && ! empty( $args['license'] ) ) {
				
				if ( isset( $args['license']['key'] ) ) {
					$this->license_key_meta = $args['license']['key'];
				}

				if ( isset( $args['license']['status'] ) ) {
					$this->license_key_meta_status = $args['license']['status'];
				}

			}

			if ( isset( $args['endpoints'] ) && ! empty( $args['endpoints'] ) ) {
				$this->endpoints = wp_parse_args( $args['endpoints'], $this->endpoints );
			}

			$this->check_for_upgrades();

		}

		/**
		 * Returns the singleton instance of the class.
		 *
		 * @return object The WPChill_Upsells object.
		 * @since 2.5.2
		 *
		 */
		public static function get_instance( $args ) {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPChill_Upsells ) ) {
				self::$instance = new WPChill_Upsells( $args );
			}

			return self::$instance;

		}

		/**
		 * Get transient names based on plugin slug
		 *
		 * @since 1.0.0
		 */
		public function get_transient( $name ){
			return $this->slug . '_' . $name;
		}

		/**
		 * Get REST API route
		 *
		 * @since 1.0.0
		 */
		public function get_route( $name ){
			return trailingslashit($this->shop_url) . trailingslashit( $this->endpoints['base'] ) . $name;
		}

		/**
		 * Fetch all packages
		 *
		 * @since 2.5.2
		 */
		public function fetch_packages() {

			// Lets get the transient
			$packages_transient = get_transient( $this->get_transient( 'all_packages' ) );

			// If the transient exists then we will not make another call to the main server
			if ( $packages_transient && ! empty( $packages_transient ) ) {
				$this->packages = $packages_transient;

				return;
			}

			// Transient doesn't exist so we make the call
			$response = wp_remote_get( $this->get_route( 'package_route' ) );

			if ( ! is_wp_error( $response ) ) {

				// Decode the data that we got.
				$data = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $data ) && is_array( $data ) ) {
					$this->packages = $data;
					set_transient( $this->get_transient( 'all_packages' ), $this->packages, '86400' );
				}

			}

		}

		/**
		 * Fectch current client package and give upgrades
		 *
		 * @since 2.5.2
		 */
		public function fetch_current_package() {

			// Lets get the transient
			$packages_transient = get_transient( $this->get_transient( 'upgradable_packages' ) );

			// If the transient exists then we will not make another call to the main server
			if ( $packages_transient && ! empty( $packages_transient ) ) {
				$this->packages = $packages_transient;

				return;
			}

			// Transient doesn't exist so we make the call
			$url         = preg_replace( '/\?.*/', '', get_bloginfo( 'url' ) );
			$license_key = get_option( $this->license_key_meta );
			$query_var = 'upgrade_route?license=' . $license_key . '&url=' . $url;
			$response  = wp_remote_get( $this->get_route( $query_var )  );

			if ( ! is_wp_error( $response ) ) {

				// Decode the data that we got.
				$data = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $data ) && is_array( $data ) ) {
					// Set our packages
					$this->packages = $data;
					// Set our transient so that we won't make calls each time user enters a Modula page
					set_transient( $this->get_transient( 'upgradable_packages' ), $this->packages, '86400' );
				}
			}
		}

		/**
		 * Lets check for license
		 *
		 * @return bool
		 *
		 * @since 2.5.2
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
		 * @since 2.5.2
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
		 * @since 2.5.2
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
		 * @since 2.5.2
		 */
		public function get_packages() {

			return $this->packages;
		}

		/**
		 * Sort packages based on price
		 *
		 * @return int
		 * @since 2.5.2
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
		 * @since 2.5.2
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
				// Let's do the sites and priority rows
				$sites    = '';
				$priority = '';
				foreach ( $all_packages as $slug => $package ) {

					if ( ! empty( $package['extra_features'] ) ) {
						foreach ( $package['extra_features'] as $key => $value ) {
							if ( 'sites' == $key ) {
								$sites .= '<div class="wpchill-pricing-package">' . $value . '</div>';
							} else {
								$priority .= '<div class="wpchill-pricing-package">' . $value . '</div>';
							}

						}
					} else {
						$sites .= '<div class="wpchill-pricing-package">-</div>';
						$priority .= '<div class="wpchill-pricing-package"><a href="https://wordpress.org/support/plugin/modula-best-grid-gallery/" target="_blank">wp.org</a></div>';
					}

					?>
					<div class="wpchill-pricing-package wpchill-title wpchill-<?php echo esc_attr( $slug ) ?>">
						<!--Usually the names are "Plugin name - Package" so we make the explode -->
						<p class="wpchill-name"><strong><?php echo esc_html__( isset( explode( '-', $package['name'] )[1] ) ? explode( '-', $package['name'] )[1] : $package['name'] ); ?></strong></p>
						<?php

						// Lets display the price and other info about our packages
						if ( isset( $package['upgrade_price'] ) && 'modula-lite' != $slug ) {
							$price = number_format( $package['upgrade_price'], 2 );
							$price_parts = explode( '.', $price );

							$checkout_page = trailingslashit( $this->shop_url ) . $this->endpoints['checkout'];
							$url = add_query_arg( array(
								'edd_action'   => 'add_to_cart',
								'download_id'  => $package['id'],
								'utm_source'   => 'upsell',
								'utm_medium'   => 'litevspro',
								'utm_campaign' => $slug,
							), $checkout_page );

							$buy_button = apply_filters(
								'wpchill-upsells-buy-button', 
								array( 'url' => $url, 'label' => esc_html__( 'Buy Now', 'modula-best-grid-gallery' ) ),
								$slug,
								$package,
								$this
							);

							?>
							<p class="wpchill-price"><?php echo '<sup>$</sup><strong>' . esc_html( $price_parts[0] ) . '</strong><sup>.' . esc_html( $price_parts[1] ) . '</sup>'; ?>
							<p class="description"><?php echo ( isset( $package['excerpt'] ) ) ? esc_html( $package['excerpt'] ) : ' '; ?></p>
							<a href="<?php echo esc_url( $buy_button['url'] ); ?>" target="_blank" class="button button-primary">
								<?php echo $buy_button['label']; ?>
							</a>
						<?php } ?>

					</div>
				<?php } ?>
			</div>

			<div class="wpchill-plans-table">
				<div class="wpchill-pricing-package feature-name">
					<?php echo esc_html__( 'Sites', 'modula-best-grid-gallery' ); ?>
				</div>
				<?php echo $sites; ?>
			</div>

			<div class="wpchill-plans-table">
				<div class="wpchill-pricing-package feature-name">
					<?php echo esc_html__( 'Support', 'modula-best-grid-gallery' ); ?>
				</div>
				<?php echo $priority; ?>
			</div>
			<?php

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
		}

		/**
		 * The LITE vs Premium page title
		 *
		 * @param $menu
		 *
		 * @return mixed
		 *
		 * @since 2.5.2
		 */
		public function lite_vs_premium_page_title( $links ) {

			// Check for license and current package
			if ( ! $this->check_for_license() || ! isset( $this->packages['current_package'] ) || empty( $this->packages['current_package'] ) ) {
				return $links;
			}

			// We made it here, so license is active and there is a current package
			// If no upsells are present means that the client has the highest package
			if ( empty( $this->packages['upsell_packages'] ) ) {
				if ( isset( $links['freevspro'] ) ) {
					unset( $links['freevspro'] );
				}
				return $links;
			}

			if ( isset( $links['freevspro'] ) ) {
				$links['freevspro']['page_title'] = esc_html__( 'Upgrade', 'modula-best-grid-gallery' );
				$links['freevspro']['menu_title'] = esc_html__( 'Upgrade', 'modula-best-grid-gallery' );
			}

			return $links;
		}

		/**
		 * Delete our set transients
		 *
		 * @since 2.5.2
		 */
		public function delete_transients() {
			delete_transient( $this->get_transient( 'upgradable_packages' ) );
			delete_transient( $this->get_transient( 'all_packages' ) );
		}

		/**
		 * Add the smart upsells transients to deletion
		 *
		 * @param $transients
		 *
		 * @return mixed
		 *
		 * @since 2.5.3
		 */
		public function smart_upsells_transients( $transients ) {

			$transients[] = $this->get_transient( 'upgradable_packages' );
			$transients[] = $this->get_transient( 'all_packages' );

			return $transients;
		}

	}

}