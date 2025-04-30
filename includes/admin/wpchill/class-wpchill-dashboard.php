<?php

/**
 * The cpt plugin class.
 *
 * This is used to define the custom post type that will be used for galleries
 *
 * @since      2.0.0
 */
class WPChill_Dashboard {

	private $menu_slug;
	private $tabs;
	private $version;
	private $plugin_cpt;
	private $images_url;
	private $plugin_link;
	private $header_hook;
	private $readme_parser;
	private $videos;
	private $products;

	public function __construct( $plugin_cpt, $links, $page_header_hook ) {

		$this->version = '1.0.1';

		$this->plugin_cpt    = $plugin_cpt;
		$this->images_url    = plugin_dir_url( __FILE__ ) . 'assets/dashboard/';
		$this->plugin_link   = $links;
		$this->header_hook   = $page_header_hook; // Like modula_page_header, dlm_page_header, wpmtst_page_header
		$this->readme_parser = new WPChill_Modula_Readme_Parser( MODULA_PATH . 'readme.txt' );
		$this->videos        = $this->get_videos();
		$this->products      = $this->get_products();


		$this->menu_slug = 'wpchill-dashboard';
		$this->tabs      = apply_filters(
			$this->plugin_cpt . '_dashboard_tabs',
			array(
				'general'     => array(
					'name' => __( 'Getting Started', 'modula-best-grid-gallery' ),
					'url'  => false,
				),
				'about'       => array(
					'name' => __( 'About us', 'modula-best-grid-gallery' ),
					'url'  => false,
				),
				// 'partners'    => array(
				//  'name' => __( 'Partners', 'modula-best-grid-gallery' ),
				//  'url'  => false,
				// ),
				'extensions'  => array(
					'name' => __( 'Extensions', 'modula-best-grid-gallery' ),
					'url'  => $this->plugin_link['extensions'],
				),
				'lite_vs_pro' => array(
					'name'   => __( 'Free vs. Premium', 'modula-best-grid-gallery' ),
					'url'    => $this->plugin_link['lite_vs_pro'],
					'target' => '_BLANK',
				),
				'changelog'   => array(
					'name'   => __( 'Changelog', 'modula-best-grid-gallery' ),
					'url'    => $this->plugin_link['changelog'],
					'target' => '_BLANK',
				),
			)
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

		add_filter( 'admin_menu', array( $this, 'add_dashboard_menu_items' ), 99, 1 );

		// Clear all notices
		add_action( 'in_admin_header', array( $this, 'clear_admin_notices' ), 99 );

		// Show addon header on dashboard
		add_filter( $this->header_hook, array( $this, 'is_dashboard' ) );

		add_action( 'admin_init', array( $this, 'redirect_to_list_or_dash' ) );
	}


	/**
	 * Adds dashboard to addon's admin menu
	 *
	 * @return void
	 *
	 * @since 2.7.5
	 */
	public function add_dashboard_menu_items() {
		add_submenu_page(
			'edit.php?post_type=' . $this->plugin_cpt,
			esc_html__( 'Welcome', 'modula-best-grid-gallery' ),
			esc_html__( 'Welcome', 'modula-best-grid-gallery' ),
			'manage_options',
			$this->menu_slug,
			array(
				$this,
				'dashboard_view',
			),
			0
		);
		add_submenu_page(
			'edit.php?post_type=' . $this->plugin_cpt,
			esc_html__( 'About Us', 'modula-best-grid-gallery' ),
			esc_html__( 'About Us', 'modula-best-grid-gallery' ),
			'manage_options',
			$this->menu_slug . '&tab=about',
			array(
				$this,
				'dashboard_view',
			),
			999
		);
	}

	public function clear_admin_notices() {

		if ( $this->is_dashboard() ) {
			remove_all_actions( 'user_admin_notices' );
			remove_all_actions( 'admin_notices' );
		}
	}

	public function generate_tab_url( $slug ) {
		if ( isset( $this->tabs[ $slug ] ) ) {
			if ( $this->tabs[ $slug ]['url'] ) {
				return $this->tabs[ $slug ]['url'];
			} else {
				return admin_url( 'edit.php?post_type=' . $this->plugin_cpt . '&page=' . $this->menu_slug . '&tab=' . $slug );
			}
		}
	}


	public function render_header( $active = 'general' ) {

		if ( isset( $_GET['tab'] ) && '' !== $_GET['tab'] ) {
			$active = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}

		?>
		<div id="wpchill_dashboard_header">
			<div class="wpchill_dashboard_header_tabs nosearch">
				<?php foreach ( $this->tabs as $slug => $tab ) : ?>
					<a <?php echo isset( $tab['target'] ) ? 'target="_BLANK"' : ''; ?> href="<?php echo esc_url( $this->generate_tab_url( $slug ) ); ?>"
						class="wpchill_dashboard_header_tab wpchill_dashboard_header_tab_<?php echo $slug; ?> <?php echo( ( $active === $slug ) ? 'tab_active' : '' ); ?>"> <?php echo $tab['name']; ?> </a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	public function _render_search_bar() {
		?>
		<div class="wpchill_dashboard_header_search">
			<input type="text" name="search" class="wpchill_dashboard_search" id="wpchill_dashboard_search"
					placeholder="<?php esc_html_e( 'Search...', 'modula-best-grid-gallery' ); ?>"/>
			<button class="wpchill_dashboard_search_btn"><span class="dashicons dashicons-search"></span></button>
		</div>
		<?php
	}

	public function render_content( $active = 'general' ) {

		if ( isset( $_GET['tab'] ) && '' !== $_GET['tab'] ) {
			$active = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}
		switch ( $active ) {
			case 'general':
				$this->_render_getting_started_content();
				break;
			case 'about':
				$this->_render_about_content();
				break;
			case 'partners':
				$this->_render_partners_content();
				break;
			default:
				do_action( "wpchill_dashboard_tab_{$active}" );
				break;
		}
	}

	public function _render_getting_started_content() {
		?>
		<div class="wpchill_dashboard_content_wrap">
			<div class="wpchill_dashboard_getting_started">
				<div class="wpchill-heading-section">
					<h3><?php esc_html_e( 'Thank you for choosing Modula.', 'modula-best-grid-gallery' ); ?></h3>
					<p> <?php esc_html_e( 'Here are some valuable resources to help you begin with our plugin.', 'modula-best-grid-gallery' ); ?> </p>
				</div>
				<?php if ( defined( 'MODULA_PRO_VERSION' ) ) : ?>
					<div id="modula-license-app"></div>
				<?php endif; ?>
				<div class="wpchill_dashboard_video_grid">
					<?php foreach ( $this->videos as $video ) : ?>
						<div class="wpchill_dashboard_video_card">
							<a class="wpchill_dashboard_video_link" target="_BLANK" href="<?php echo esc_url( $video['video_link'] ); ?>">
								<img src="<?php echo esc_url( $video['video_image'] ); ?>" class="wpchill_dashboard_video_image" >
								<div class="wpchill_dashboard_video_title">
									<span><?php echo esc_html( $video['title'] ); ?></span>
								</div>
								<img src="<?php echo esc_url( $this->images_url . 'yt.png' ); ?>" class="wpchill_dashboard_youtube_icon"/>
								<div class="wpchill_dashboard_video_watch">
									<img src="<?php echo esc_url( $this->images_url . 'yt-long.png' ); ?>" class="wpchill_dashboard_youtube_watch"/>
								</div>
							</a>
							<div class="wpchill_dashboard_video_description">
								<p><?php echo wp_kses_post( $video['description'] ); ?></p>
								<a href="<?php echo esc_url( $video['docu_link'] ); ?>" target="_BLANK" class="wpchill_dashboard_item_button">
									<?php esc_html_e( 'View Documentation', 'modula-best-grid-gallery' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="wpchill_dashboard_grid">
					<div class="wpchill_dashboard_item wpchill_card">
						<div class="wpchill_dashboard_item_head">
							<img src="<?php echo esc_url( $this->images_url ) . 'icons8-book-shelf-96.png'; ?>"
								class="wpchill_dashboard_item_icon"/>
							<h3 class="wpchill_dashboard_item_title"> <?php esc_html_e( 'Documentation', 'modula-best-grid-gallery' ); ?> </h3>
						</div>
						<div class="wpchill_dashboard_item_content">
							<p class="wpchill_dashboard_item_text"> <?php esc_html_e( 'Become familiar with our plugin by reading the documentation.', 'modula-best-grid-gallery' ); ?> </p>
							<a href="<?php echo esc_attr( $this->plugin_link['documentation'] ); ?>" target="_BLANK" class="wpchill_dashboard_item_button">
								<?php esc_html_e( 'View Documentation', 'modula-best-grid-gallery' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
							</a>
						</div>
					</div>
					<div class="wpchill_dashboard_item wpchill_card">
						<div class="wpchill_dashboard_item_head">
							<img src="<?php echo esc_url( $this->images_url ) . 'icons8-services-96.png'; ?>"
								class="wpchill_dashboard_item_icon"/>
							<h3 class="wpchill_dashboard_item_title"> <?php esc_html_e( 'Settings', 'modula-best-grid-gallery' ); ?> </h3>
						</div>
						<div class="wpchill_dashboard_item_content">
							<p class="wpchill_dashboard_item_text"> <?php esc_html_e( 'Explore the full potential of what Modula can offer you.', 'modula-best-grid-gallery' ); ?> </p>
							<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $this->plugin_cpt . '&page=modula' ) ); ?>"
								class="wpchill_dashboard_item_button">
								<?php esc_html_e( 'View Settings', 'modula-best-grid-gallery' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
							</a>
						</div>
					</div>
					<div class="wpchill_dashboard_item wpchill_card">
						<div class="wpchill_dashboard_item_head">
							<img src="<?php echo esc_url( $this->images_url ) . 'icons8-galleries-96.png'; ?>"
								class="wpchill_dashboard_item_icon"/>
							<h3 class="wpchill_dashboard_item_title"> <?php esc_html_e( 'Galleries', 'modula-best-grid-gallery' ); ?> </h3>
						</div>
						<div class="wpchill_dashboard_item_content">
							<p class="wpchill_dashboard_item_text"> <?php esc_html_e( 'Create your amazing gallery using Modula.', 'modula-best-grid-gallery' ); ?> </p>
							<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $this->plugin_cpt ) ); ?>"
								class="wpchill_dashboard_item_button">
								<?php esc_html_e( 'View Extensions', 'modula-best-grid-gallery' ); ?> <span
										class="dashicons dashicons-arrow-right-alt"></span>
							</a>
						</div>
					</div>
					<div class="wpchill_dashboard_item wpchill_card">
						<div class="wpchill_dashboard_item_head">
							<img src="<?php echo esc_url( $this->images_url ) . 'icons8-extensions-96.png'; ?>"
								class="wpchill_dashboard_item_icon"/>
							<h3 class="wpchill_dashboard_item_title"> <?php esc_html_e( 'Extensions', 'modula-best-grid-gallery' ); ?> </h3>
						</div>
						<div class="wpchill_dashboard_item_content">
							<p class="wpchill_dashboard_item_text"> <?php esc_html_e( 'Enhance your Modula experience by installing fantastic extensions.', 'modula-best-grid-gallery' ); ?> </p>
							<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $this->plugin_cpt . '&page=modula-addons' ) ); ?>"
								class="wpchill_dashboard_item_button">
								<?php esc_html_e( 'View Extensions', 'modula-best-grid-gallery' ); ?> <span
										class="dashicons dashicons-arrow-right-alt"></span>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Common use cases -->

			<div class="wpchill_card wpchill_dashboard_use_cases_wrap">
				<h3 class="wpchill_dashboard_item_title">
					<?php esc_html_e( 'Common Use Cases', 'modula-best-grid-gallery' ); ?>
				</h3>
				<div class="wpchill_dashboard_grid_2">
					<div id="wpchill_use_cases_block" class="wpchill_dashboard_use_cases">
						<?php $this->render_common_use_cases( $this->readme_parser ); ?>
					</div>
				</div>
			</div>

			<!-- Call to action/upsell -->
			<div class="wpchill_dashboard_cta_wrap">
				<h2 class="wpchill_dashboard_item_title">
					<span class="wpchill_dashboard_icon wpchill_dashboard_icon_features"></span>
					<?php esc_html_e( 'Need help or advice?', 'modula-best-grid-gallery' ); ?>
				</h2>
				<div class="wpchill_dashboard_default_text">
					<p><?php esc_html_e( 'Got a question or need help with the plugin?  ', 'modula-best-grid-gallery' ); ?></p>
					<p><?php esc_html_e( 'You can always submit a support ticket or ask for help in our friendly Facebook community.', 'modula-best-grid-gallery' ); ?></p>
				</div>

				<a href="<?php echo esc_attr( $this->plugin_link['fbcommunity'] ); ?>" target="_BLANK"
					class="wpchill_dashboard_item_button"> <?php esc_html_e( 'Join Facebook Community', 'modula-best-grid-gallery' ); ?>
				</a>
				<a href="<?php echo esc_attr( $this->plugin_link['support'] ); ?>" target="_BLANK"
					class="wpchill_dashboard_item_button wpchill_dashboard_item_button_ghost"> <?php esc_html_e( 'Submit a Support Ticket', 'modula-best-grid-gallery' ); ?>
				</a>

			</div>
		</div>
		<?php
	}

	public function _render_about_content() {
		?>
		<div class="wpchill_dashboard_about_us_wrapper">

			<!-- About Us -->
			<div class="wpchill_dashboard_about_us" style="display:none;">
				<h1 class="wpchill_dashboard_about_us_title"><?php esc_html_e( 'About Us', 'modula-best-grid-gallery' ); ?></h1>
				<p class="wpchill_dashboard_about_us_text"><?php echo wp_kses_post( __( 'WPChill is a WordPress development studio currently located in Bucharest, Romania. <br> We\'re a handful of friendly developers, marketers & happiness engineers. <br> Say hi 👋', 'modula-best-grid-gallery' ) ); ?></p>
			</div>

			<div class="wpchill_dashboard_about_content">
				<!-- About Us -->
				<div class="wpchill_about_us">
					<div class="wpchill_about_us_content">
						<h2 class="wpchill_about_us_subtitle"><?php esc_html_e( 'Reliable WordPress Solutions Tailored for You', 'modula-best-grid-gallery' ); ?></h2>
						<p class="wpchill_about_us_text"><?php echo wp_kses_post( __( 'At WPChill, our commitment goes beyond just creating WordPress solutions—we\'re dedicated to delivering user-friendly products that help people save time, money, and effort.', 'modula-best-grid-gallery' ) ); ?></p>
						<p class="wpchill_about_us_text"><?php echo wp_kses_post( __( 'Every product we offer is built with care, shaped by our experience, and backed by our promise to support our users every step of the way.', 'modula-best-grid-gallery' ) ); ?></p>
						<p class="wpchill_about_us_text"><?php echo wp_kses_post( __( 'When you choose WPChill, you\'re not just purchasing a product; you\'re gaining a reliable partner.', 'modula-best-grid-gallery' ) ); ?></p>
					</div>
					<div class="wpchill_about_us_logo">
						<img src="<?php echo esc_url( $this->images_url ) . 'wpchill-bear.jpg'; ?>" />
					</div>
				</div>

				<!-- Our Products -->
				<div class="wpchill_our_products">
					<div class="wpchill_products">
						<?php foreach ( $this->products as $product ) : ?>
							<div class="wpchill_product">
								<div class="wpchill_product_wrap">
									<div class="wpchill_product_extended">
										<div class="wpchill_product_content">
											<h5 class="wpchill_product_name"><?php echo wp_kses_post( $product['name'] ); ?></h5>
											<p class="wpchill_product_description"><?php echo wp_kses_post( $product['description'] ); ?></p>
										</div>
										<?php if ( isset( $product['videos'] ) ) : ?>
										<div class="wpchill_product_videos">
											<?php foreach ( $product['videos'] as $video ) : ?>
												<a class="wpchill_product_video" target="_BLANK" href="<?php echo esc_url( $video['link'] ); ?>">
													<img src="<?php echo esc_url( $video['image'] ); ?>" class="wpchill_product_video_image"/>
													<div class="wpchill_product_video_title">
														<span><?php echo esc_html( $video['title'] ); ?></span>
													</div>
													<img src="<?php echo esc_url( $this->images_url . 'yt.png' ); ?>" class="wpchill_dashboard_youtube_icon"/>
													<div class="wpchill_dashboard_video_watch">
														<img src="<?php echo esc_url( $this->images_url . 'yt-long.png' ); ?>" class="wpchill_dashboard_youtube_watch"/>
													</div>
												</a>
											<?php endforeach; ?>
										</div>
										<?php endif; ?>
									</div>
									<div class="wpchill_product_actions">
										<div class="wpchill_product_buttons">
											<a href="<?php echo esc_url( $product['url'] ); ?>" target="_BLANK" class="wpchill_product_button">
												<?php esc_html_e( 'Visit website', 'modula-best-grid-gallery' ); ?>
											</a>
											<?php if ( isset( $product['videos'] ) && is_array( $product['videos'] ) && count( $product['videos'] ) > 0 ) : ?>
												<button class="wpchill_product_learn_more">
													<?php esc_html_e( 'Learm more', 'modula-best-grid-gallery' ); ?>
												</button>
											<?php endif; ?>
										</div>
										<?php
											$addon_status = $this->is_addon_installed( $product['path'] );
											$action       = $addon_status ? $addon_status : 'installed';
											$activate_url = add_query_arg(
												array(
													'action'   => 'activate',
													'plugin'   => rawurlencode( $product['path'] ),
													'plugin_status' => 'all',
													'paged'    => '1',
													'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $product['path'] ),
												),
												admin_url( 'plugins.php' )
											);

											$deactivate_url = add_query_arg(
												array(
													'action'   => 'deactivate',
													'plugin'   => rawurlencode( $product['path'] ),
													'plugin_status' => 'all',
													'paged'    => '1',
													'_wpnonce' => wp_create_nonce( 'deactivate-plugin_' . $product['path'] ),
												),
												admin_url( 'plugins.php' )
											);
										?>
										<div class="wpchill-toggle">
											<span class="wpchill_action_status"></span>
											<label class="">
												<input class="wpchill-toggle__input" type="checkbox" data-slug="<?php echo esc_attr( $product['slug'] ); ?>" data-action="<?php echo esc_attr( $action ); ?>" data-activateurl="<?php echo esc_url( $activate_url ); ?>" data-deactivateurl="<?php echo esc_url( $deactivate_url ); ?>" value="1" <?php checked( 'installed', $action, true ); ?>>
												<div class="wpchill-toggle__items">
													<span class="wpchill-toggle__track"></span>
													<span class="wpchill-toggle__thumb"></span>
													<svg class="wpchill-toggle__off" width="6" height="6" aria-hidden="true"
															role="img"
															focusable="false"
															viewBox="0 0 6 6">
														<path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
													</svg>
													<svg class="wpchill-toggle__on" width="2" height="6" aria-hidden="true"
															role="img"
															focusable="false"
															viewBox="0 0 2 6">
														<path d="M0 0h2v6H0z"></path>
													</svg>
												</div>
											</label>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function _render_partners_content() {
		?>

		<div class="wpchill_dashboard_content_wrap">
			<div class="wpchill-heading-section">
				<h3><?php esc_html_e( 'Our Partners', 'modula-best-grid-gallery' ); ?></h3>
				<p> <?php esc_html_e( 'Other plugins that are known to work great alongside Modula', 'modula-best-grid-gallery' ); ?> </p>
			</div>


			<div class="wpchill-addons-container">
				<?php $this->render_partners(); ?>
			</div>
		</div>


		<?php
	}


	public function render_changelog( $readme ) {

		$year    = '';
		$date    = '';
		$version = '';

		$content = $readme->sections['changelog'];
		$content = preg_split( "/(\r\n|\n|\r)/", strip_tags( $content, '<a>' ) ); // we use strip tags here because the parser adds extra <p> tags

		// Iterate through each line in the changelog.
		foreach ( $content as $line ) {
			// Check if the line contains a version header (e.g., "= 2.7.7 - 14.09.2023 =").
			if ( preg_match( '/= ([\d.]+) - (\d+\.\d+\.\d+) =/', $line, $matches ) ) {
				// Extract the date and version.

				$version = $matches[1];
				$date    = $matches[2];

				// Extract the year from the date.
				$data = explode( '.', $date );
				$year = $data[2]; // year is the last item in the array
				$date = gmdate( 'F', mktime( 0, 0, 0, $data[1], 10 ) ); // turn date numbers into nicenames; ex: xx.09.xxxx turns into September

				// Create a sub-array for the version if it doesn't exist.
				if ( ! isset( $results[ $year ][ $date ][ $version ] ) ) {
					$results[ $year ][ $date ][ $version ] = array();
				}
			} else {
				// If the line is not a version header, it's a change description.
				// Add the change to the current version.
				$results[ $year ][ $date ][ $version ][] = trim( $line );
			}
		}

		echo '<div class="wpchill_dashboard_changelog_wrapper">';
		// Iterate through the result and echo the data.
		foreach ( $results as $year => $year_data ) {
			echo '<h2 class="wpchill_dashboard_changelog_year">' . esc_html( $year ) . '</h2>';

			foreach ( $year_data as $month => $month_data ) {
				echo '<h3 class="wpchill_dashboard_changelog_month">' . esc_html( $month ) . '</h3>';

				foreach ( $month_data as $version => $changes ) {
					echo '<h4 class="wpchill_dashboard_changelog_version">' . esc_html__( 'Version:', 'modula-best-grid-gallery' ) . ' ' . esc_html( $version ) . '</h4>';

					echo '<ul>';
					foreach ( $changes as $change ) {
						echo '<li>' . wp_kses_post( $change ) . '</li>';
					}
					echo '</ul>';
				}
			}
		}
		echo '</div>';
	}

	public function render_partners() {

		$addons = get_transient( 'wpchill_all_partners' );

		if ( false == $addons ) {
			$addons = array();

			$url = $this->plugin_link['partners'];

			// Get data from the remote URL.
			$response = wp_remote_get( $url );

			if ( ! is_wp_error( $response ) ) {

				// Decode the data that we got.
				$data = json_decode( $response['body'], true );
				if ( ! empty( $data ) && is_array( $data ) ) {

					// Store the data for a week.
					set_transient( 'wpchill_all_partners', $data, 7 * DAY_IN_SECONDS );
				}

				$addons = $data;
			}
		}

		if ( ! empty( $addons ) ) {
			foreach ( $addons as $addon ) {
				$addon_path   = isset( $addon['path'] ) ? $addon['path'] : $addon['slug'] . '/' . $addon['slug'] . '.php';
				$addon_status = $this->is_addon_installed( $addon_path );

				echo '<div class="wpchill-addon">';
				echo '<div class="wpchill-addon-box">';

				if ( ! isset( $addon['image'] ) || '' == $addon['image'] ) {
					echo '<div class="wpchill-addon-box-image"><img src="' . esc_url( plugin_dir_url( __FILE__ ) . 'assets/dashboard/blog-default.png' ) . '"></div>';
				} else {
					echo '<div class="wpchill-addon-box-image"><img src="' . esc_url( $addon['image'] ) . '"></div>';
				}

				echo '<div class="wpchill-addon-content">';
				echo '<h3>' . esc_html( $addon['name'] ) . '</h3>';
				echo ( isset( $addon['version'] ) ) ? '<span class="wpchill-addon-version">' . esc_html( 'V ' . $addon['version'] ) . '</span>' : '';
				echo '<div class="wpchill-addon-description">' . wp_kses_post( $addon['description'] ) . '</div>';
				echo '</div>';
				echo '</div>';

				echo '<div class="wpchill-addon-actions">';
				if ( empty( $addon['url'] ) || false === $addon_status ) :
					if ( false !== $addon_status ) :
						$activate_url = add_query_arg(
							array(
								'action'        => 'activate',
								'plugin'        => rawurlencode( $addon_path ),
								'plugin_status' => 'all',
								'paged'         => '1',
								'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $addon_path ),
							),
							admin_url( 'plugins.php' )
						);
						?>
						<button class="button wpchill_install_partener_addon"
								data-slug="<?php echo esc_attr( $addon['slug'] ); ?>"
								data-action="<?php echo( 'install' === $addon_status ? 'install' : 'activate' ); ?>"
								data-activation_url="<?php echo esc_url( $activate_url ); ?>">
								
							<?php
								// translators: %s is the action to be done ( Install or Activate )
								printf( esc_html__( '%s Addon', 'modula-best-grid-gallery' ), ( 'install' === $addon_status ? 'Install' : 'Activate' ) );
							?>
						</button>

					<?php else : ?>
						<button class="button"
								disabled="disabled"><?php esc_html_e( 'Already installed', 'modula-best-grid-gallery' ); ?> </button>
					<?php endif; ?>
				<?php else : ?>
					<a href="<?php echo esc_attr( $addon['url'] ); ?> "
						class="button"><?php esc_html_e( 'Find more', 'modula-best-grid-gallery' ); ?> </a>
				<?php endif; ?>
				</div>
				</div>
				<?php
			}
		}
	}

	/**
	 * Remove Add New link from menu item
	 *
	 * @param $submenu_file
	 *
	 * @return mixed
	 *
	 * @since 2.3.4
	 */
	public function dashboard_view() {

		echo '<div id="wpchill_dashboard_container">';
		$this->render_header();
		$this->render_content();
		echo '</div>';
	}

	/**
	 * Checks if WP.org addon is installed and/or active
	 * @return string
	 * @since 1.0.5
	 */

	public function is_addon_installed( $plugin_path ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$all_plugins = get_plugins();

		if ( empty( $all_plugins[ $plugin_path ] ) ) {
			return 'install';
		} elseif ( ! is_plugin_active( $plugin_path ) ) {
				return 'activate';
		} else {
			return false;
		}
	}

	/**
	 * Check if dashboard page
	 *
	 * @param $return
	 *
	 * @return bool|mixed
	 * @since 2.5.3
	 */

	public function is_dashboard() {

		if ( isset( $_GET['page'] ) && 'wpchill-dashboard' === $_GET['page'] ) {
			return true;
		}

		return false;
	}


	public function enqueue_scripts() {

		// only load assets on dashboard pages
		if ( $this->is_dashboard() ) {
			wp_enqueue_style( 'modula-dashboard-style', plugin_dir_url( __FILE__ ) . 'assets/css/dashboard.css', null, $this->version );
			wp_enqueue_script(
				'modula-dashboard-script',
				plugin_dir_url( __FILE__ ) . 'assets/js/dashboard.js',
				array(
					'jquery',
					'updates',
				),
				$this->version,
				true
			);

			$dashboard_strings = array(
				'installing_plugin' => esc_html__( 'Installing plugin', 'modula-best-grid-gallery' ),
				'activating_plugin' => esc_html__( 'Activating plugin', 'modula-best-grid-gallery' ),
				'installing_text'   => esc_html__( 'Installing...', 'modula-best-grid-gallery' ),
				'activating_text'   => esc_html__( 'Activating...', 'modula-best-grid-gallery' ),
				'deactivating_text' => esc_html__( 'Deactivating...', 'modula-best-grid-gallery' ),
				'activated_text'    => esc_html__( 'Deactivate', 'modula-best-grid-gallery' ),
				'deactivate_text'   => esc_html__( 'Activate', 'modula-best-grid-gallery' ),
				'activated_status'  => esc_html__( 'Activated', 'modula-best-grid-gallery' ),
				'deactivate_status' => esc_html__( 'Dectivated', 'modula-best-grid-gallery' ),
				'openText'          => esc_html__( 'Learn More', 'modula-best-grid-gallery' ),
				'closeText'         => esc_html__( 'Close', 'modula-best-grid-gallery' ),
			);

			wp_localize_script( 'modula-dashboard-script', 'dashboardStrings', $dashboard_strings );

			if ( defined( 'MODULA_PRO_VERSION' ) ) {
				$scripts = Modula\Scripts::get_instance();

				$scripts->load_js_asset(
					'modula-license-app',
					'assets/js/admin/license',
				);

				$scripts->load_css_asset(
					'modula-license-app',
					'assets/js/admin/license',
					array( 'wp-components' )
				);

				wp_add_inline_script(
					'modula-license-app',
					'const modulaData = ' . wp_json_encode(
						array(
							'url'   => MODULA_URL,
							'nonce' => wp_create_nonce( 'modula_license_save' ),
						)
					) . ';',
					'before'
				);
			}
		}
	}


	public function render_common_use_cases( $readme ) {

		$content = $readme->sections['faq'];

		$content = str_replace(
			array(
				'<dl>',
				'</dl>',
				'<dt>',
				'</dt>',
				'<dd>',
				'</dd>',
			),
			array(
				'<div class="wpchill-accordion">',
				'</div><!--/.wpchill-accordion-->',
				'<details><summary class="wpchill-accordion-title"><span>',
				'</span></summary><!--/.wpchill-accordion-title-->',
				'<div class="wpchill-accordion-body">',
				'</div></details>',
			),
			$content
		);

		print_r( $content );
	}


	public function redirect_to_list_or_dash() {
		if ( $this->is_dashboard() && ! isset( $_GET['post_type'] ) ) {
			$url_to_galleries = add_query_arg(
				array(
					'post_type' => 'modula-gallery',
				),
				admin_url( 'edit.php' )
			);
			wp_safe_redirect( $url_to_galleries );
			die();
		}
	}

	private function get_products() {
		$products = array(
			'modula-gallery'  => array(
				'name'        => 'Modula',
				'slug'        => 'modula',
				'path'        => 'modula-best-grid-gallery/Modula.php',
				'description' => 'Easily create stunning, customizable photo galleries and albums with Modula’s powerful features.',
				'url'         => 'https://wp-modula.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
				'videos'      => array(
					array(
						'image' => $this->images_url . 'products/modula.png',
						'link'  => 'https://www.youtube.com/watch?v=FrvpYeYxzpI&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=5',
						'title' => __( 'How to install Modula (LITE & PRO)', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/modula.png',
						'link'  => 'https://www.youtube.com/watch?v=Ah1vHSTEW-c&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=4',
						'title' => __( 'Create Your First Gallery', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/modula.png',
						'link'  => 'https://www.youtube.com/watch?v=PJ3my9NrOWA&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=3',
						'title' => __( 'How to Publish a Gallery', 'modula-best-grid-gallery' ),
					),
				),
			),
			'dlm_download'    => array(
				'name'        => 'Download Monitor',
				'slug'        => 'download-monitor',
				'path'        => 'download-monitor/download-monitor.php',
				'description' => 'Manage, track, and control file downloads on your WordPress site with ease.',
				'url'         => 'https://download-monitor.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
				'videos'      => array(
					array(
						'image' => $this->images_url . 'products/dlm.webp',
						'link'  => 'https://www.youtube.com/watch?v=pYr6TctjMAk&list=PLM2tOjfhVrZfvMiJ3ib1GqvWBpYpBeQaS&index=5',
						'title' => __( 'How to activate premium version and license', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/dlm.webp',
						'link'  => 'https://www.youtube.com/watch?v=9F_IUwA425c&list=PLM2tOjfhVrZfvMiJ3ib1GqvWBpYpBeQaS&index=3',
						'title' => __( 'How to create your first download', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/dlm.webp',
						'link'  => 'https://www.youtube.com/watch?v=xEbliDziMrU&list=PLM2tOjfhVrZfvMiJ3ib1GqvWBpYpBeQaS&index=2',
						'title' => __( 'How to list your download', 'modula-best-grid-gallery' ),
					),
				),
			),
			'wpm-testimonial' => array(
				'name'        => 'Strong Testimonials',
				'slug'        => 'strong-testimonials',
				'path'        => 'strong-testimonials/strong-testimonials.php',
				'description' => 'Collect, manage, and showcase customer reviews beautifully with this flexible testimonial plugin.',
				'url'         => 'https://strongtestimonials.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
				'videos'      => array(
					array(
						'image' => $this->images_url . 'products/st.png',
						'link'  => 'https://www.youtube.com/watch?v=klnNjtFYz_U&list=PLM2tOjfhVrZcgMyoeC_M7yUii1QJW8nfH&index=7',
						'title' => __( 'Install Strong Testimonials Pro', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/st.png',
						'link'  => 'https://www.youtube.com/watch?v=_DmoHH6iE4w&list=PLM2tOjfhVrZcgMyoeC_M7yUii1QJW8nfH&index=5',
						'title' => __( 'Create your first testimonials collection Form', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/st.png',
						'link'  => 'https://www.youtube.com/watch?v=zIb0RQv2-pY&list=PLM2tOjfhVrZcgMyoeC_M7yUii1QJW8nfH&index=4',
						'title' => __( 'Create your first testimonials listing', 'modula-best-grid-gallery' ),
					),
				),
			),
			'kaliforms_forms' => array(
				'name'        => 'Kali Forms',
				'slug'        => 'kali-forms',
				'path'        => 'kali-forms/kali-forms.php',
				'description' => 'Build powerful and user-friendly forms quickly with Kali Forms’ intuitive drag-and-drop builder.',
				'url'         => 'https://kaliforms.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
			),
			'passster'        => array(
				'name'        => 'Passster',
				'slug'        => 'content-protector',
				'path'        => 'content-protector/content-protector.php',
				'description' => 'Increase website and content protection with easy-to-use features like password, CAPTCHA, and user role restrictions.',
				'url'         => 'https://passster.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
				'videos'      => array(
					array(
						'image' => $this->images_url . 'products/passster.png',
						'link'  => 'https://www.youtube.com/watch?v=kK1K1WImvJc&list=PLM2tOjfhVrZdo_H26CV2I-UfdqpDWxo3D&index=4',
						'title' => __( 'How to Install and activate Passster Pro', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/passster.png',
						'link'  => 'https://www.youtube.com/watch?v=kjYklVLVFD8&list=PLM2tOjfhVrZdo_H26CV2I-UfdqpDWxo3D&index=2',
						'title' => __( 'How to protect a page', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/passster.png',
						'link'  => 'https://www.youtube.com/watch?v=tj-2vGLHN3M&list=PLM2tOjfhVrZdo_H26CV2I-UfdqpDWxo3D&index=1',
						'title' => __( 'How to create a protected area', 'modula-best-grid-gallery' ),
					),
				),
			),
			'filr'            => array(
				'name'        => 'Filr',
				'slug'        => 'filr-protection',
				'path'        => 'filr-protection/filr-protection.php',
				'description' => 'Easily build and manage a document library with secure file sharing and advanced access controls.',
				'url'         => 'https://wpdocumentlibrary.com//?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
				'videos'      => array(
					array(
						'image' => $this->images_url . 'products/filr.png',
						'link'  => 'https://www.youtube.com/watch?v=D8F3VtlSQP4&list=PLM2tOjfhVrZd3qpZiBogLE3ii3jyDo3bP&index=5',
						'title' => __( 'Install and activate Filr', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/filr.png',
						'link'  => 'https://www.youtube.com/watch?v=G1D9qXmLwF0&list=PLM2tOjfhVrZd3qpZiBogLE3ii3jyDo3bP&index=1',
						'title' => __( 'How to create files', 'modula-best-grid-gallery' ),
					),
					array(
						'image' => $this->images_url . 'products/filr.png',
						'link'  => 'https://www.youtube.com/watch?v=BlvBVbN2-2w&list=PLM2tOjfhVrZd3qpZiBogLE3ii3jyDo3bP&index=2',
						'title' => __( 'Set up and list your first document library', 'modula-best-grid-gallery' ),
					),
				),
			),
			'imageseo'        => array(
				'name'        => 'ImageSEO',
				'slug'        => 'imageseo',
				'path'        => 'imageseo/imageseo.php',
				'description' => 'Optimize images automatically for better SEO and accessibility with AI-powered metadata and alt text generation.',
				'url'         => 'https://imageseo.io/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
			),
			'rsvp'            => array(
				'name'        => 'RSVP and Event Management',
				'slug'        => 'rsvp',
				'path'        => 'rsvp/wp-rsvp.php',
				'description' => 'Easily create and manage RSVPs, events, and guest lists with this event management solution.',
				'url'         => 'https://rsvpproplugin.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
			),
			'htaccess'        => array(
				'name'        => 'Htaccess File Editor',
				'slug'        => 'htaccess-file-editor',
				'path'        => 'htaccess-file-editor/htaccess-file-editor.php',
				'description' => 'Safely edit your .htaccess file directly from WordPress to improve site performance and security.',
				'url'         => 'https://wpchill.com/?utm_source=modula-gallery&utm_medium=link&utm_campaign=about-us&utm_term=about-us+website+link',
			),
		);

		// Remove current
		if ( isset( $products[ $this->plugin_cpt ] ) ) {
			unset( $products[ $this->plugin_cpt ] );
		}

		return $products;
	}
	private function get_videos() {
		return array(
			array(
				'video_link'  => 'https://www.youtube.com/watch?v=FrvpYeYxzpI&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=5',
				'video_image' => $this->images_url . 'products/modula.png',
				'docu_link'   => 'https://wp-modula.com/kb/install-modula-wordpress-plugin/',
				'description' => 'Become familiar with our plugin by reading the documentation.',
				'title' => __( 'How to install Modula (LITE & PRO) ', 'modula-best-grid-gallery' ),
			),
			array(
				'video_link'  => 'https://www.youtube.com/watch?v=Ah1vHSTEW-c&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=4',
				'video_image' => $this->images_url . 'products/modula.png',
				'docu_link'   => 'https://wp-modula.com/kb/create-your-first-gallery/',
				'description' => 'Become familiar with our plugin by reading the documentation.',
				'title' => __( 'Create Your First Gallery', 'modula-best-grid-gallery' ),
			),
			array(
				'video_link'  => 'https://www.youtube.com/watch?v=PJ3my9NrOWA&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=3',
				'video_image' => $this->images_url . 'products/modula.png',
				'docu_link'   => 'https://wp-modula.com/kb/create-your-first-gallery/',
				'description' => 'Become familiar with our plugin by reading the documentation.',
				'title' => __( 'How to Publish a Gallery', 'modula-best-grid-gallery' ),
			),
			array(
				'video_link'  => 'https://www.youtube.com/watch?v=g9HU_m8xUBk&list=PLM2tOjfhVrZdjZldOxSqmfaGAuSo8pbzm&index=1',
				'video_image' => $this->images_url . 'products/modula.png',
				'docu_link'   => 'https://wp-modula.com/kb/how-to-create-a-gallery-from-zip/',
				'description' => 'Become familiar with our plugin by reading the documentation.',
				'title' => __( 'How to Create a Gallery from a ZIP File', 'modula-best-grid-gallery' ),
			),
		);
	}
}

