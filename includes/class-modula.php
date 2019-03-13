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

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once MODULA_PATH . 'includes/libraries/class-modula-template-loader.php';
		require_once MODULA_PATH . 'includes/helper/class-modula-helper.php';
		require_once MODULA_PATH . 'includes/admin/class-modula-image.php';
		require_once MODULA_PATH . 'includes/public/modula-helper-functions.php';

		require_once MODULA_PATH . 'includes/admin/class-modula-cpt.php';
		require_once MODULA_PATH . 'includes/admin/class-modula-upsells.php';
		require_once MODULA_PATH . 'includes/admin/class-modula-admin.php';

		require_once MODULA_PATH . 'includes/public/class-modula-shortcode.php';
		require_once MODULA_PATH . 'includes/class-modula-gutenberg.php';

		if ( is_admin() ) {

			require_once MODULA_PATH . 'includes/class-modula-upgrades.php';
			// require_once MODULA_PATH . 'includes/admin/class-modula-admin-pointers.php';

			if ( ! class_exists( 'Epsilon_Review' ) ) {
				require_once MODULA_PATH . 'includes/libraries/class-modula-review.php';
			}

			Modula_Review::get_instance( array(
			    'slug' => 'modula-best-grid-gallery',
			    'messages' => array(
			    	'notice'  => esc_html__( "Hey, I noticed you have created %s galleries - that's awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.", 'modula-best-grid-gallery' ),
					'rate'    => esc_html__( 'Ok, you deserve it', 'modula-best-grid-gallery' ),
					'rated'   => esc_html__( 'I already did', 'modula-best-grid-gallery' ),
					'no_rate' => esc_html__( 'No, not good enough', 'modula-best-grid-gallery' ),
			    ),
			) );

		}

	}

	public function set_locale() {
		load_plugin_textdomain( 'modula-best-grid-gallery', false, MODULA_PATH . '/languages' );
	}

	private function define_admin_hooks() {
    
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 20 );
		add_action( 'init', array( $this, 'admin_init' ), 20 );
		add_action( 'wp_ajax_modula-reload-addons', array( $this, 'reload_addons' ), 20 );

		add_action( 'plugins_loaded', array( $this, 'set_locale' ));

		new Modula_CPT();

	}

	public function admin_init() {

		if ( ! is_admin() ) {
			return;
		}

		if ( apply_filters( 'modula_show_upsells', true ) ) {
			new Modula_Upsells();
		}

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

        // Check if is modula custom post type
        if ( 'modula-gallery' !== $screen->post_type ) {
            return;
        }

        // Set the post_id
        $post_id = isset( $post->ID ) ? $post->ID : (int) $id;

		if ( 'post-new.php' == $hook || 'post.php' == $hook ) {

			/* CPT Styles & Scripts */
			// Media Scripts
			wp_enqueue_media( array(
	            'post' => $post_id,
	        ) );

	        $modula_helper = array(
	        	'items' => array(),
	        	'settings' => array(),
	        	'strings' => array(
	        		'limitExceeded' => sprintf( __( 'You excedeed the limit of 20 photos. You can remove an image or %supgrade to pro%s', 'modula-best-grid-gallery' ), '<a href="#" target="_blank">', '</a>' ),
	        	),
	        	'id' => $post_id,
	        	'_wpnonce' => wp_create_nonce( 'modula-ajax-save' ),
	        	'ajax_url' => admin_url( 'admin-ajax.php' ),
	        );

	        // Get all items from current gallery.
	        $images = get_post_meta( $post_id, 'modula-images', true );
	        if ( is_array( $images ) && ! empty( $images ) ) {
	        	foreach ( $images as $image ) {
	        		if ( ! is_numeric( $image['id'] ) ) {
	        			continue;
	        		}

	        		$attachment = wp_prepare_attachment_for_js( $image['id'] );
	        		$image_url  = wp_get_attachment_image_src( $image['id'], 'large' );
					$image_full = wp_get_attachment_image_src( $image['id'], 'full' );

					$image['full']        = $image_full[0];
					$image['thumbnail']   = $image_url[0];
					$image['orientation'] = $attachment['orientation'];

					$modula_helper['items'][] = $image;

	        	}
	        }

	        // Get current gallery settings.
	        $settings = get_post_meta( $post_id, 'modula-settings', true );
	        if ( is_array( $settings ) ) {
	        	$modula_helper['settings'] = wp_parse_args( $settings, Modula_CPT_Fields_Helper::get_defaults() );
	        }else{
	        	$modula_helper['settings'] = Modula_CPT_Fields_Helper::get_defaults();
	        }

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'jquery-ui', MODULA_URL . 'assets/css/jquery-ui.min.css', null, MODULA_LITE_VERSION );
			wp_enqueue_style( 'modula-cpt-style', MODULA_URL . 'assets/css/modula-cpt.css', null, MODULA_LITE_VERSION );

			wp_enqueue_script( 'modula-resize-senzor', MODULA_URL . 'assets/js/resizesensor.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-packery', MODULA_URL . 'assets/js/packery.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-droppable', 'jquery-ui-resizable', 'jquery-ui-draggable' ), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-settings', MODULA_URL . 'assets/js/wp-modula-settings.js', array( 'jquery', 'jquery-ui-slider', 'wp-color-picker', 'jquery-ui-sortable' ), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-items', MODULA_URL . 'assets/js/wp-modula-items.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-modal', MODULA_URL . 'assets/js/wp-modula-modal.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-upload', MODULA_URL . 'assets/js/wp-modula-upload.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-gallery', MODULA_URL . 'assets/js/wp-modula-gallery.js', array(), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-conditions', MODULA_URL . 'assets/js/wp-modula-conditions.js', array(), MODULA_LITE_VERSION, true );

			do_action( 'modula_scripts_before_wp_modula' );

			wp_enqueue_script( 'modula', MODULA_URL . 'assets/js/wp-modula.js', array(), MODULA_LITE_VERSION, true );
			wp_localize_script( 'modula', 'modulaHelper', $modula_helper );

			do_action( 'modula_scripts_after_wp_modula' );

		}elseif ( 'modula-gallery_page_modula' == $hook ) {
			wp_enqueue_style( 'modula-welcome-style', MODULA_URL . 'assets/css/welcome.css', null, MODULA_LITE_VERSION );
		}elseif ( 'modula-gallery_page_modula-addons' == $hook ) {
			wp_enqueue_style( 'modula-welcome-style', MODULA_URL . 'assets/css/addons.css', null, MODULA_LITE_VERSION );
			wp_enqueue_script( 'modula-addon', MODULA_URL . 'assets/js/modula-addon.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		}elseif ( 'edit.php' == $hook  ) {
			wp_enqueue_style( 'modula-welcome-style', MODULA_URL . 'assets/css/edit.css', null, MODULA_LITE_VERSION );
		}

	}

	public function reload_addons() {
		delete_transient( 'modula_addons' );
		die( 'succes' );
	}

}
