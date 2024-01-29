<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 */
class Modula {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function __construct() {
		$this->set_offer();
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'divi_extensions_init', array( $this, 'initialize_divi_extension' ) );

		// Gallery 'srcset' management.
		add_action( 'modula_before_gallery', array( $this, 'disable_wp_srcset' ) );
		add_action( 'modula_after_gallery', array( $this, 'enable_wp_srcset' ) );

	}

	private function load_dependencies() {

		require_once MODULA_PATH . 'includes/libraries/class-modula-template-loader.php';
		require_once MODULA_PATH . 'includes/helper/class-modula-helper.php';
		require_once MODULA_PATH . 'includes/admin/class-modula-image.php';
		require_once MODULA_PATH . 'includes/class-modula-script-manager.php';
		require_once MODULA_PATH . 'includes/public/modula-helper-functions.php';
		require_once MODULA_PATH . 'includes/troubleshoot/class-modula-troubleshooting.php';

		require_once MODULA_PATH . 'includes/admin/class-modula-cpt.php';
		// WPChill Upsells
		require_once MODULA_PATH . 'includes/admin/class-wpchill-upsells.php';
		require_once MODULA_PATH . 'includes/admin/class-modula-upsells.php';
		require_once MODULA_PATH . 'includes/admin/class-modula-admin.php';

		require_once MODULA_PATH . 'includes/public/class-modula-shortcode.php';
		require_once MODULA_PATH . 'includes/class-modula-gutenberg.php';

		require_once MODULA_PATH . 'includes/elementor/class-modula-elementor-check.php';

		require_once MODULA_PATH . 'includes/duplicator/class-modula-duplicator.php';

		require_once MODULA_PATH . 'includes/modula-beaver-block/class-modula-beaver.php';
		require_once MODULA_PATH . 'includes/widget/class-modula-widget.php';

		// Get the grid system
		require_once MODULA_PATH . 'includes/grid/class-modula-grid.php';

		// Backward Compatibility
		require_once MODULA_PATH . 'includes/class-modula-backward-compatibility.php';

		// Licensing
		require_once MODULA_PATH . 'includes/class-modula-licensing.php';

		// Compatibility with other plugins/themes
		require_once MODULA_PATH . 'includes/compatibility/class-modula-compatibility.php';

		if ( is_admin() ) {
			require_once MODULA_PATH . 'includes/admin/class-modula-readme-parser.php'; //added by Cristi in 2.7.8
			require_once MODULA_PATH . 'includes/admin/class-modula-importer-exporter.php';
			require_once MODULA_PATH . 'includes/class-modula-upgrades.php';
			require_once MODULA_PATH . 'includes/libraries/class-modula-review.php';
			require_once MODULA_PATH . 'includes/uninstall/class-modula-uninstall.php';
			require_once MODULA_PATH . 'includes/migrate/class-modula-importer.php';
			require_once MODULA_PATH . 'includes/migrate/class-modula-ajax-migrator.php';
			// Admin Helpers
			require_once MODULA_PATH . 'includes/admin/class-modula-admin-helpers.php';
			// The Modula Addons
			require_once MODULA_PATH . 'includes/admin/class-modula-addons.php';
			// Modula Debug Class
			require_once MODULA_PATH . 'includes/admin/class-modula-debug.php';
			require_once MODULA_PATH . 'includes/admin/class-modula-onboarding.php';

			require_once MODULA_PATH . 'includes/admin/class-modula-dashboard.php';
		}
	}

	/**
	 * Add Modula Gallery Divi block
	 */
	public function initialize_divi_extension() {
		require_once MODULA_PATH . 'includes/divi-extension/includes/DiviExtension.php';
	}

	public function set_locale() {

		$modula_lang = dirname( MODULA_FILE ) . '/languages/';

		if ( get_user_locale() !== get_locale() ) {

			unload_textdomain( 'modula-best-grid-gallery' );
			$locale = apply_filters( 'plugin_locale', get_user_locale(), 'modula-best-grid-gallery' );

			$lang_ext  = sprintf( '%1$s-%2$s.mo', 'modula-best-grid-gallery', $locale );
			$lang_ext1 = WP_LANG_DIR . "/modula-best-grid-gallery/modula-best-grid-gallery-{$locale}.mo";
			$lang_ext2 = WP_LANG_DIR . "/plugins/modula-best-grid-gallery/{$lang_ext}";

			if ( file_exists( $lang_ext1 ) ) {
				load_textdomain( 'modula-best-grid-gallery', $lang_ext1 );

			} elseif ( file_exists( $lang_ext2 ) ) {
				load_textdomain( 'modula-best-grid-gallery', $lang_ext2 );

			} else {
				load_plugin_textdomain( 'modula-best-grid-gallery', false, $modula_lang );
			}
		} else {
			load_plugin_textdomain( 'modula-best-grid-gallery', false, $modula_lang );
		}
	}

	private function define_admin_hooks() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 20 );
		add_action( 'admin_init', array( $this, 'admin_start' ), 20 );
		add_action( 'admin_menu', array( $this, 'dashboard_start' ), 20 );

		add_action( 'init', array( $this, 'set_locale' ) );

		// SiteOrigin Widget
		add_action( 'widgets_init', array( $this, 'modula_load_widget' ) );

		// Classic editor button for Modula Gallery
		add_filter( 'mce_buttons', array( $this, 'editor_button' ) );
		add_filter( 'mce_external_plugins', array( $this, 'register_editor_plugin' ) );
		add_action( 'wp_ajax_modula_shortcode_editor', array( $this, 'modula_shortcode_editor' ) );

		// Allow other mime types to be uploaded
		add_filter( 'upload_mimes', array( $this, 'modula_upload_mime_types' ) );
		add_filter( 'file_is_displayable_image', array( $this, 'modula_webp_display' ), 10, 2 );

		// Initiate modula cpts
		new Modula_CPT();

	}

	public function dashboard_start() {

		$links = array(
			'partners'      => 'https://wp-modula.com/parteners.json',
			'documentation' => 'https://wp-modula.com/knowledge-base/',
			'pricing'       => 'https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=dashboard-page&utm_campaign=upsell',
			'extensions'    => admin_url( 'edit.php?post_type=modula-gallery&page=modula-addons' ),
			'lite_vs_pro'   => admin_url( 'edit.php?post_type=modula-gallery&page=modula-lite-vs-pro' ),
			'support'       => 'https://wordpress.org/support/plugin/modula-best-grid-gallery/',
			'fbcommunity'   => 'https://www.facebook.com/groups/wpmodula/'

		);

		new Modula_Dashboard(
			MODULA_FILE,
			'modula-gallery',
			MODULA_URL . 'assets/images/dashboard/',
			$links,
			'modula_page_header'
		);
	}

	public function admin_start() {

		if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
			return;
		}

		new Modula_Upsells();

		$upgrades = Modula_Upgrades::get_instance();
		$upgrades->initialize_admin();
	}

	private function define_public_hooks() {

	}

	/* Enqueue Admin Scripts */
	public function admin_scripts( $hook ) {

		global $id, $post;

		// Get current screen.
		$screen = get_current_screen();

		// Set the post_id
		$post_id = isset( $post->ID ) ? $post->ID : (int) $id;

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		$modula_helper = array(
			'items'    => array(),
			'settings' => array(),
			'strings'  => array(
				'limitExceeded' => '',
			),
			'id'       => $post_id,
			'_wpnonce' => wp_create_nonce( 'modula-ajax-save' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		);

		if ( 'post-new.php' == $hook || 'post.php' == $hook ) {

			// Check if is modula custom post type
			if ( 'modula-gallery' !== $screen->post_type ) {
				return;
			}

			if ( apply_filters( 'modula_disable_drag_cpt_box', true ) ) {

				//returns modula CPT metaboxes to the default position.
				add_filter( 'get_user_option_meta-box-order_modula-gallery', '__return_empty_string' );
				add_filter( 'get_user_option_closedpostboxes_modula-gallery', '__return_empty_string' );
				add_filter( 'admin_body_class', array( $this, 'no_drag_classes' ), 15, 1 );

			}

			/*
			 CPT Styles & Scripts */
			// Media Scripts
			wp_enqueue_media(
				array(
					'post' => $post_id,
				)
			);

			// Get all items from current gallery.
			$images = get_post_meta( $post_id, 'modula-images', true );

			if ( is_array( $images ) && ! empty( $images ) ) {
				foreach ( $images as $image ) {
					if ( ! is_numeric( $image['id'] ) || 'attachment' !== get_post_type( $image['id'] ) ) {
						continue;
					}

					$attachment = wp_prepare_attachment_for_js( $image['id'] );
					$image_url  = wp_get_attachment_image_src( $image['id'], 'large' );
					$image_full = wp_get_attachment_image_src( $image['id'], 'full' );

					$image['full']        = $image_full[0];
					$image['thumbnail']   = $image_url[0];
					$image['orientation'] = ( isset( $attachment['orientation'] ) ) ? $attachment['orientation'] : '';

					$modula_helper['items'][] = apply_filters( 'modula_image_properties', $image );

				}
			}

			// Get current gallery settings.
			$settings = get_post_meta( $post_id, 'modula-settings', true );
			$settings = apply_filters( 'modula_backbone_settings', $settings );

			if ( is_array( $settings ) ) {
				$modula_helper['settings'] = wp_parse_args( $settings, Modula_CPT_Fields_Helper::get_defaults() );
			} else {
				$modula_helper['settings'] = Modula_CPT_Fields_Helper::get_defaults();
			}

			wp_enqueue_style( 'wp-color-picker' );
			// Enqueue Code Editor for Custom CSS
			wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
			wp_enqueue_style( 'modula-jquery-ui', MODULA_URL . 'assets/css/admin/jquery-ui' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_style( 'modula-cpt-style', MODULA_URL . 'assets/css/admin/modula-cpt' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_style( 'modula-pro-effects', MODULA_URL . 'assets/css/admin/effects' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_script( 'modula-resize-senzor', MODULA_URL . 'assets/js/admin/resizesensor' . $suffix . '.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-packery', MODULA_URL . 'assets/js/admin/packery' . $suffix . '.js', array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-widget',
				'jquery-ui-droppable',
				'jquery-ui-resizable',
				'jquery-ui-draggable'
			), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-settings', MODULA_URL . 'assets/js/admin/wp-modula-settings' . $suffix . '.js', array(
				'jquery',
				'jquery-ui-slider',
				'wp-color-picker',
				'jquery-ui-sortable'
			), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-pro-tilt', MODULA_URL . 'assets/js/admin/modula-pro-tilt' . $suffix . '.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

			wp_enqueue_script( 'modula-save', MODULA_URL . 'assets/js/admin/wp-modula-save' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-items', MODULA_URL . 'assets/js/admin/wp-modula-items' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-modal', MODULA_URL . 'assets/js/admin/wp-modula-modal' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-upload', MODULA_URL . 'assets/js/admin/wp-modula-upload' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-gallery', MODULA_URL . 'assets/js/admin/wp-modula-gallery' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-conditions', MODULA_URL . 'assets/js/admin/wp-modula-conditions' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );

			do_action( 'modula_scripts_before_wp_modula' );

			wp_enqueue_script( 'modula', MODULA_URL . 'assets/js/admin/wp-modula' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
			$modula_helper = apply_filters( 'modula_helper_properties', $modula_helper );
			wp_localize_script( 'modula', 'modulaHelper', $modula_helper );

			do_action( 'modula_scripts_after_wp_modula' );

		} elseif ( 'modula-gallery_page_modula' == $hook ) {
			// Check if is modula custom post type
			if ( 'modula-gallery' !== $screen->post_type ) {
				return;
			}

			wp_enqueue_style( 'modula-welcome-style', MODULA_URL . 'assets/css/admin/welcome' . $suffix . '.css', null, MODULA_LITE_VERSION );
		} elseif ( 'modula-gallery_page_modula-addons' == $hook ) {
			// Check if is modula custom post type
			if ( 'modula-gallery' !== $screen->post_type ) {
				return;
			}

			wp_enqueue_style( 'modula-notices-style', MODULA_URL . 'assets/css/admin/modula-notices' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_style( 'modula-welcome-style', MODULA_URL . 'assets/css/admin/addons' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_script( 'modula-addon', MODULA_URL . 'assets/js/admin/modula-addon' . $suffix . '.js', array(
				'jquery',
				'updates'
			), MODULA_LITE_VERSION, true );

			wp_localize_script( 'modula-addon', 'modulaAddons', array(
				// Add addon slug to verify addon's slug in wp-plugin-install-success action
				'free_addons'       => apply_filters( 'modula_free_extensions_install', array() ),
				'installing_text'   => esc_html__( 'Installing addon...', 'modula-best-grid-gallery' ),
				'activated_text'    => esc_html__( 'Addon activated!', 'modula-best-grid-gallery' ),
				'deactivated_text'  => esc_html__( 'Addon deactivated!', 'modula-best-grid-gallery' ),
				'activating_text'   => esc_html__( 'Activating addon...', 'modula-best-grid-gallery' ),
				'deactivating_text' => esc_html__( 'Deactivating addon...', 'modula-best-grid-gallery' )
			) );

		} elseif ( 'modula-gallery_page_modula-lite-vs-pro' == $hook ) {

			wp_enqueue_style( 'modula-header-style', MODULA_URL . 'assets/css/admin/modula-header' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_style( 'modula-welcome-style', MODULA_URL . 'assets/css/admin/welcome' . $suffix . '.css', null, MODULA_LITE_VERSION );
		} else {

			wp_enqueue_style( 'modula-header-style', MODULA_URL . 'assets/css/admin/modula-header' . $suffix . '.css', null, MODULA_LITE_VERSION );
			wp_enqueue_style( 'modula-notices-style', MODULA_URL . 'assets/css/admin/modula-notices' . $suffix . '.css', null, MODULA_LITE_VERSION );

		}

		wp_enqueue_script( 'modula-edit-screen', MODULA_URL . 'assets/js/admin/modula-edit' . $suffix . '.js', array(), MODULA_LITE_VERSION, true );
		wp_localize_script( 'modula-edit-screen', 'modulaHelper', $modula_helper );
		wp_enqueue_style( 'modula-notices-style', MODULA_URL . 'assets/css/admin/modula-notices' . $suffix . '.css', null, MODULA_LITE_VERSION );
		wp_enqueue_style( 'modula-edit-style', MODULA_URL . 'assets/css/admin/edit' . $suffix . '.css', null, MODULA_LITE_VERSION );

	}

	/**
	 * Filters the maximum image width to be included in a 'srcset' attribute.
	 *
	 * @return int
	 *
	 */
	public function disable_wp_responsive_images() {
		return 1;
	}

	/**
	 * Disables the srcset when lazy loading is enabled.
	 *
	 * @return bool
	 * @since 2.7.5
	 */
	public function disable_lazy_srcset( $return, $image, $context, $attachment_id ) {

		if ( preg_match( '/data-source="modula"/i', $image ) ) {
			return false;
		}

		return $return;
	}

	/**
	 * Prevents WP from adding srcsets to modula gallery images if srcsets are disabled.
	 *
	 * @param $settings
	 *
	 * @return void
	 *
	 */
	public function disable_wp_srcset( $settings ) {
		$troubleshoot_opt = get_option( 'modula_troubleshooting_option' );
		if ( isset( $troubleshoot_opt['disable_srcset'] ) && '1' == $troubleshoot_opt['disable_srcset'] ) {
			add_filter( 'max_srcset_image_width', array( $this, 'disable_wp_responsive_images' ), 999 );
		}

		if ( isset( $settings['lazy_load'] ) && '1' === $settings['lazy_load'] ) {
			add_filter( 'wp_img_tag_add_srcset_and_sizes_attr', array( $this, 'disable_lazy_srcset' ), 999, 4 );
		}
	}

	/**
	 * Allows WP to add srcsets to other content after the gallery was created.
	 *
	 * @param $settings
	 *
	 * @return void
	 *
	 */
	public function enable_wp_srcset( $settings ) {
		remove_filter( 'max_srcset_image_width', array( $this, 'disable_wp_responsive_images' ), 999 );
	}

	// Register and load the widget
	public function modula_load_widget() {
		register_widget( 'Modula_Widget' );
	}

	/**
	 * @param $buttons
	 *
	 * @return mixed
	 *
	 * Add tinymce button
	 */
	public function editor_button( $buttons ) {
		array_push( $buttons, 'separator', 'modula_shortcode_editor' );

		return $buttons;
	}

	/**
	 * @param $plugin_array
	 *
	 * @return mixed
	 *
	 * Add plugin editor script
	 */
	public function register_editor_plugin( $plugin_array ) {
		$plugin_array['modula_shortcode_editor'] = MODULA_URL . 'assets/js/admin/editor-plugin.js';

		return $plugin_array;
	}

	/**
	 * Display galleries selection
	 */
	public function modula_shortcode_editor() {
		$css_path  = MODULA_URL . 'assets/css/admin/edit.css';
		$admin_url = admin_url();
		$galleries = Modula_Helper::get_galleries();
		include 'admin/tinymce-galleries.php';
		wp_die();

	}

	/**
	 * @param $mimes
	 *
	 * @return mixed
	 *
	 * @since 2.2.4
	 * Allow WebP image type to be uploaded
	 */
	public function modula_upload_mime_types( $mimes ) {

		$mimes['webp'] = 'image/webp';

		return $mimes;
	}

	/**
	 * @param $result
	 * @param $path
	 *
	 * @return bool
	 *
	 * @since 2.2.4
	 * Enable thumbnail/preview for WebP image types.
	 */
	function modula_webp_display( $result, $path ) {
		if ( $result === false && IMAGETYPE_WEBP ) {
			$displayable_image_types = array( IMAGETYPE_WEBP );
			$info                    = @getimagesize( $path );

			if ( empty( $info ) ) {
				$result = false;
			} elseif ( ! in_array( $info[2], $displayable_image_types ) ) {
				$result = false;
			} else {
				$result = true;
			}
		}

		return $result;
	}

	/**
	 * Add the `modula-no-drag` class to body so we know when to hide the arrows
	 *
	 * @param String $classes The classes of the body, a space-separated string of class names instead of an array
	 *
	 * @return String
	 *
	 * @since 2.6.3
	 */
	public function no_drag_classes( $classes ) {

		$classes .= ' modula-no-drag';

		return $classes;
	}

	/**
	 * Adds the filters and actions to add modula offers display by month
	 *
	 * @since 2.7.9
	 */
	private function set_offer(){
		$month = date('m');

		if ( 11 == $month ) { 
			add_filter( 'modula_upsell_buttons', array( $this, 'bf_buttons' ) , 15, 2 );
			add_action( 'admin_print_styles', array( $this, 'footer_bf_styles' ), 999 );
		}
		if ( 12 == $month ) { 
			add_filter( 'modula_upsell_buttons', array( $this, 'xmas_buttons' ) , 15, 2 );
			add_action( 'admin_print_styles', array( $this, 'footer_xmas_styles' ), 999 );
		}
	}

	/**
	 * Replaces upsells button with Black Friday text buttons
	 *
	 * @since 2.7.9
	 */
	public function bf_buttons( $buttons, $campaign ){
		preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $buttons, $matches);

		$buttons =  '<a target="_blank" href="' . esc_url( $matches[2][0] ) . '" class="button">' . esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .=  '<a target="_blank" href="' . esc_url( $matches[2][1] ) . '" style="margin-top:10px;" class="wpchill-bf-upsell button">' . esc_html__( '40% OFF for Black Friday', 'modula-best-grid-gallery' ) . '</a>';
		return $buttons;
	}

	/**
	 * Replaces upsells button with Christmas text buttons
	 *
	 * @since 2.7.9
	 */
	public function xmas_buttons( $buttons, $campaign ){
		preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $buttons, $matches);

		$buttons =  '<a target="_blank" href="' . esc_url( $matches[2][0] ) . '" class="button">' . esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .=  '<a target="_blank" href="' . esc_url( $matches[2][1] ) . '" style="margin-top:10px;" class="wpchill-xmas-upsell button">' . esc_html__( '25% OFF for Christmas', 'modula-best-grid-gallery' ) . '</a>';
		return $buttons;
	}

	/**
	 * Echoes Black Friday script to footer
	 *
	 * @since 2.7.9
	 */
	public function footer_bf_styles(){

		$css = '<style>
		.modula-upsell,
		#poststuff .modula-upsell h2,
		.modula-modal__overlay .modula-modal__frame,
		.modula-settings-tab-upsell {
			color: #fff;
			background-color: #000;
		}
		.modula-upsell p,
		.modula-upsell p.modula-upsell-description,
		.modula-modal__overlay .modula-modal__frame h2,
		.modula-settings-tab-upsell h3,
		.modula-settings-tab-upsell p {
			color: #fff;
		}
		.wpchill-bf-upsell.button {
			background-color: #f8003e;
			border: none;
			color: #fff;
			font-weight: 600;
		}
		.wpchill-bf-upsell.button:hover {
			background-color: red;
			border: none;
			color: #fff;
			font-weight: 600;
		}
		.modula-tooltip .modula-tooltip-content{
			background-color: #fff;
			color: #000;
		}
		.modula-settings-tab-upsell{
			margin-top: 10px;
		}
		</style>';
		echo $css;
	}

	/**
	 * Echoes Christmas style to footer
	 *
	 * @since 2.7.9
	 */
	public function footer_xmas_styles(){

		$css = '<style>
		.modula-upsell::before,
		.modula-settings-tab-upsell::before,
		.modula-modal__overlay .modula-modal__frame::before{
			content: "";
			position: absolute;
			width: 100%;
			height: 50px;
			background-image: url(' . MODULA_URL . 'assets/images/upsells/x-mas.jpg' .');
			background-position-x: 15px;
			left: 0;
			top: 0;
			background-size: contain;
			z-index: 0;
		}

		.wpchill-xmas-upsell.button {
			background-color: #f8003e;
			border: none;
			color: #fff;
			font-weight: 600;
		}
		.wpchill-xmas-upsell.button:hover {
			background-color: red;
			border: none;
			color: #fff;
			font-weight: 600;
		}
		.modula-settings-tab-upsell,
		.modula-upsell{
			position: relative;
			padding-top: 50px;
		}
		.modula-settings-tab-upsell{
			margin-top: 10px;
		}
		.modula-upsell{
			background-color: #fff;
		}
		#modula-settings .modula-upsell{
			padding-top: 70px;
		}

		</style>';
		echo $css;
	}
}
