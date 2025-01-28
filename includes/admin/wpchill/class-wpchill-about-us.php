<?php

class WPChill_About_Us {

	private $plugin_cpt;

	public function __construct( $plugin_cpt ) {

		$this->plugin_cpt = $plugin_cpt;

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

		add_filter( 'admin_menu', array( $this, 'add_menu_item' ), 99, 1 );

		// Clear all notices
		add_action( 'in_admin_header', array( $this, 'clear_admin_notices' ), 99 );

		new WPChill_Rest_Api();
	}


	/**
	 * Adds dashboard to addon's admin menu
	 *
	 * @return void
	 *
	 * @since 2.7.5
	 */
	public function add_menu_item() {
		add_submenu_page(
			'edit.php?post_type=' . $this->plugin_cpt,
			esc_html__( 'About Us', 'modula-best-grid-gallery' ),
			esc_html__( 'About Us', 'modula-best-grid-gallery' ),
			'manage_options',
			'wpchill-about-us',
			array(
				$this,
				'dashboard_view',
			),
			999
		);
	}

	public function clear_admin_notices() {

		if ( $this->is_about_us() ) {
			remove_all_actions( 'user_admin_notices' );
			remove_all_actions( 'admin_notices' );
		}
	}

	public function render_content() {
		?>
		<div class="wpchill_container">
			<h1 class="wpchill_title"><?php esc_html_e( 'About WPChill', 'modula-best-grid-gallery' ); ?></h1>
			<img src="<?php echo esc_attr( plugin_dir_url( __FILE__ ) . 'icons/wpchill-logo.jpg' ); ?>" alt="WPChill Logo" class="wpchill_logo">
			<p class="wpchill_tagline"><?php esc_html_e( 'Reliable WordPress Solutions Tailored for You', 'modula-best-grid-gallery' ); ?></p>
			<p class="wpchill_description"><?php esc_html_e( 'At WPChill, our commitment goes beyond just creating WordPress solutions—we\'re dedicated to delivering user-friendly products that help people save time, money, and effort. Every product we offer is built with care, shaped by our experience, and backed by our promise to support our users every step of the way. When you choose WPChill, you\'re not just purchasing a product; you\'re gaining a reliable partner.', 'modula-best-grid-gallery' ); ?></p>
			
			<table class="wpchill_table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Product', 'modula-best-grid-gallery' ); ?></th>
						<th><?php esc_html_e( 'Description', 'modula-best-grid-gallery' ); ?></th>
						<th><?php esc_html_e( 'Website', 'modula-best-grid-gallery' ); ?></th>
						<th><?php esc_html_e( 'Try plugin', 'modula-best-grid-gallery' ); ?></th>
					</tr> 
				</thead>
				<tbody>
					<?php $this->render_rows(); ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	private function render_rows() {

		$addons = array(
			array(
				'name'        => 'Modula',
				'slug'        => 'modula',
				'path'        => 'modula-best-grid-gallery/Modula.php',
				'description' => 'Photo gallery plugin',
				'url'         => 'https://wordpress.org/plugins/modula-best-grid-gallery/',
			),
			array(
				'name'        => 'Download Monitor',
				'slug'        => 'download-monitor',
				'path'        => 'download-monitor/download-monitor.php',
				'description' => 'File manager plugin',
				'url'         => 'https://wordpress.org/plugins/download-monitor/',
			),
			array(
				'name'        => 'Strong Testimonials',
				'slug'        => 'strong-testimonials',
				'path'        => 'strong-testimonials/strong-testimonials.php',
				'description' => 'Testimonial plugin',
				'url'         => 'https://wordpress.org/plugins/strong-testimonials/',
			),
			array(
				'name'        => 'Kali Forms',
				'slug'        => 'kali-forms',
				'path'        => 'kali-forms/kali-forms.php',
				'description' => 'Form builder plugin',
				'url'         => 'https://wordpress.org/plugins/kali-forms/',
			),
			array(
				'name'        => 'Passster',
				'slug'        => 'content-protector',
				'path'        => 'content-protector/content-protector.php',
				'description' => 'Password protection plugin',
				'url'         => 'https://wordpress.org/plugins/content-protector/',
			),
			array(
				'name'        => 'Filr',
				'slug'        => 'filr-protection',
				'path'        => 'filr-protection/filr-protection.php',
				'description' => 'Image SEO plugin',
				'url'         => 'https://wordpress.org/plugins/filr-protection/',
			),
			array(
				'name'        => 'ImageSEO',
				'slug'        => 'imageseo',
				'path'        => 'imageseo/imageseo.php',
				'description' => 'SEO plugin for images',
				'url'         => 'https://wordpress.org/plugins/imageseo/',
			),
			array(
				'name'        => 'Revive.so',
				'slug'        => 'revive-so',
				'path'        => 'revive-so/revive-so.php',
				'description' => 'Revive.so is the ultimate WordPress plugin for content rejuvenation.',
				'url'         => 'https://wordpress.org/plugins/revive-so/',
			),
			array(
				'name'        => 'RSVP and Event Management',
				'slug'        => 'rsvp',
				'path'        => 'rsvp/wp-rsvp.php',
				'description' => 'The RSVP Plugin offers a comprehensive solution for event registration and management, providing an easy way for users to RSVP to your events.',
				'url'         => 'https://wordpress.org/plugins/rsvp/',
			),
			array(
				'name'        => 'Gallery PhotoBlocks',
				'slug'        => 'photoblocks-grid-gallery',
				'path'        => 'photoblocks-grid-gallery/photoblocks.php',
				'description' => 'This is an image and photo gallery plugin perfect to make galleries with justified edges!',
				'url'         => 'https://wordpress.org/plugins/photoblocks-grid-gallery/',
			),
			array(
				'name'        => 'Htaccess File Editor',
				'slug'        => 'htaccess-file-editor',
				'path'        => 'htaccess-file-editor/htaccess-file-editor.php',
				'description' => 'Htaccess File Editor is a fast, safe and simple yet perfect to edit the WordPress site\'s <i>.htaccess</i> file from admin panel. ',
				'url'         => 'https://wordpress.org/plugins/htaccess-file-editor/',
			),
			array(
				'name'        => 'Image Photo Gallery Final Tiles Grid',
				'slug'        => 'final-tiles-grid-gallery-lite',
				'path'        => 'final-tiles-grid-gallery-lite/FinalTilesGalleryLite.php',
				'description' => 'mage Gallery + Photo Gallery + Portfolio Gallery + Tiled Gallery in 1 plugin.',
				'url'         => 'https://wordpress.org/plugins/final-tiles-grid-gallery-lite/',
			),
		);

		foreach ( $addons as $addon ) {
			?>
			<tr>
			<td><?php echo isset( $addon['name'] ) ? esc_html( $addon['name'] ) : ''; ?></td>
			<td><?php echo isset( $addon['description'] ) ? wp_kses_post( $addon['description'] ) : ''; ?></td>
			<td><a target="_BLANK" href="<?php echo isset( $addon['url'] ) ? esc_html( $addon['url'] ) : '#'; ?>"><?php esc_html_e( 'Details', 'modula-best-grid-gallery' ); ?></a></td>
			<td>
			<?php
			$addon_status = $this->is_addon_installed( $addon['path'] );
			if ( 'false' !== $addon_status ) :

				?>
					<button class="button wpchill_install_partener_addon"
							data-slug="<?php echo esc_attr( $addon['slug'] ); ?>"
							data-action="<?php echo( 'install' === $addon_status ? 'install' : 'activate' ); ?>"
							data-plugin="<?php echo esc_attr( $addon['path'] ); ?>">
					<?php 'install' === $addon_status ? esc_html_e( 'Install', 'modula-best-grid-gallery' ) : esc_html_e( 'Activate', 'modula-best-grid-gallery' ); ?>
					</button>
				<?php else : ?>
					<button class="button"
							disabled="disabled"><?php esc_html_e( 'Active', 'modula-best-grid-gallery' ); ?> </button>
				<?php endif; ?>
			</td>
			</tr>
			<?php
		}
	}

	/**
	 * Checks if WP.org addon is installed and/or active
	 * @return string
	 * @since 2.11.12
	 */

	private function is_addon_installed( $plugin_path ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$all_plugins = get_plugins();

		if ( empty( $all_plugins[ $plugin_path ] ) ) {
			return 'install';
		} elseif ( ! is_plugin_active( $plugin_path ) ) {
				return 'activate';
		} else {
			return 'false';
		}
	}

	/**
	 * Remove Add New link from menu item
	 *
	 * @param $submenu_file
	 *
	 * @return mixed
	 *
	 * @since 2.11.12
	 */
	public function dashboard_view() {

		echo '<div id="wpchill_about_us_container">';
		$this->render_content();
		echo '</div>';
	}

	/**
	 * Check if about us page
	 *
	 * @param $return
	 *
	 * @return bool|mixed
	 * @since 2.11.12
	 */

	private function is_about_us() {

		if ( isset( $_GET['page'] ) && 'wpchill-about-us' === $_GET['page'] ) {
			return true;
		}

		return false;
	}


	public function enqueue_scripts() {

		// only load assets on about us page
		if ( ! $this->is_about_us() ) {
			return;
		}

		wp_enqueue_style( 'wpchill-about-us-style', plugin_dir_url( __FILE__ ) . 'assets/css/about-us.css', array(), '1.0.0' );
		wp_enqueue_script(
			'modula-about-us-script',
			plugin_dir_url( __FILE__ ) . 'assets/js/about-us.js',
			array(
				'wp-api-fetch',
				'updates',
			),
			'1.0.0',
			true
		);
	}

	public static function activate_plugin( $plugin_slug ) {

		if ( ! $plugin_slug ) {
			return array(
				'success' => false,
				'message' => 'Plugin slug is missing.',
			);
		}

		if ( ! function_exists( 'activate_plugin' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$result = activate_plugin( $plugin_slug );

		if ( is_wp_error( $result ) ) {
			return array(
				'success' => false,
				'message' => $result->get_error_message(),
			);
		}

		return array(
			'success' => true,
			'message' => 'Plugin activated.',
		);
	}
}

