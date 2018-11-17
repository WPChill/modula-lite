<?php
/**
 * Plugin Name: Modula
 * Plugin URI: https://wp-modula.com/
 * Description: Modula is one of the best & most creative WordPress gallery plugins. Use it to create a great grid or
 * masonry image gallery.
 * Author: Macho Themes
 * Version: 1.3.3
 * Author URI: https://www.machothemes.com/
 */

define( 'MODULA_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'MODULA_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

define( 'MODULA_VERSION', '1.3.3' );
define( 'MODULA_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'MODULA_PREVIOUS_PLUGIN_VERSION', '1.3.2' );
define( 'MODULA_FILE_', __FILE__ );

function modula_lite_create_db_tables() {
	include_once( WP_PLUGIN_DIR . '/modula-best-grid-gallery/lib/install-db.php' );
	modula_lite_install_db();
}

if ( ! class_exists( "ModulaLite" ) ) {
	class ModulaLite {

		private $loadedData;
		private $fields = array();

		private $version = "1.3.3";

		private $defaultValues = array(
			'width'            => 100,
			'height'           => 800,
			'img_size'         => 500,
			'margin'           => 10,
			'filters'          => '',
			'filterClick'      => 'F',
			'allFilterLabel'   => 'All',
			'lightbox'         => 'lightbox2',
			'shuffle'          => 'F',
			'captionColor'     => '#ffffff',
			'wp_field_caption' => 'caption',
			'wp_field_title'   => 'title',
			'captionFontSize'  => 14,
			'titleFontSize'    => 16,
			'enableTwitter'    => 'T',
			'enableFacebook'   => 'T',
			'enableGplus'      => 'T',
			'enablePinterest'  => 'T',
			'socialIconColor'  => '#ffffff',
			'loadedScale'      => 100,
			'loadedRotate'     => 0,
			'loadedHSlide'     => 0,
			'loadedVSlide'     => 0,
			'borderSize'       => 0,
			'borderRadius'     => 0,
			'borderColor'      => '#ffffff',
			'shadowSize'       => 0,
			'shadowColor'      => '#ffffff',
			'style'            => '',
			'script'           => '',
			'randomFactor'     => 50,
			'hoverColor'       => '#000000',
			'hoverOpacity'     => '50',
			'hoverEffect'      => 'pufrobo',
			'hasResizedImages' => false,
			'importedFrom'     => '',
			'hide_title'       => false,
			'hide_description' => false,
		);

		public function __construct() {
			$this->plugin_name = plugin_basename( __FILE__ );
			$this->plugin_url  = plugins_url( '', __FILE__ );
			$this->define_constants();
			$this->define_db_tables();
			$this->define_hover_effects();
			$this->ModulaDB = $this->create_db_conn();

			require_once 'lib/class-modula-feedback.php';
			new Modula_Feedback( __FILE__ );

			add_filter( 'widget_text', 'do_shortcode' );
			add_filter( 'mce_buttons', array( $this, 'editor_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'register_editor_plugin' ) );

			add_action( 'init', array( $this, 'create_textdomain' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_gallery_scripts' ) );

			add_action( 'admin_menu', array( $this, 'add_gallery_admin_menu' ) );

			add_shortcode( 'Modula', array( $this, 'gallery_shortcode_handler' ) );
			add_filter( 'the_content', array( $this, 'shortcode_empty_paragraph_fix' ), 99 );
			
			add_action( 'wp_ajax_modula_save_gallery', array( $this, 'save_gallery' ) );
			add_action( 'wp_ajax_modula_save_image', array( $this, 'save_image' ) );
			add_action( 'wp_ajax_modula_add_image', array( $this, 'add_image' ) );
			add_action( 'wp_ajax_modula_list_images', array( $this, 'list_images' ) );
			add_action( 'wp_ajax_modula_sort_images', array( $this, 'sort_images' ) );
			add_action( 'wp_ajax_modula_delete_image', array( $this, 'delete_image' ) );
			add_action( 'wp_ajax_modula_resize_images', array( $this, 'resize_images' ) );
			add_action( 'wp_ajax_modula_delete_gallery', array( $this, 'delete_gallery' ) );
			add_action( 'wp_ajax_modula_clone_gallery', array( $this, 'clone_gallery' ) );
			add_action( 'wp_ajax_modula_create_gallery', array( $this, 'create_gallery' ) );
			add_action( 'wp_ajax_mtg_shortcode_editor', array( $this, 'mtg_shortcode_editor' ) );
			add_action( 'wp_ajax_modula_get_config', array( $this, 'get_config' ) );
			add_action( 'wp_ajax_modula_update_config', array( $this, 'update_config' ) );
			add_action( 'wp_ajax_modula_get_ext_galleries', array( $this, 'get_ext_galleries' ) );
			add_action( 'wp_ajax_modula_do_import_galleries', array( $this, 'do_import_galleries' ) );

			add_filter( 'plugin_row_meta', array( $this, 'register_links' ), 10, 2 );
			add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );

			// Enqueue Fancybox for Modula 2.0 Page
			add_action( 'admin_enqueue_scripts', array( $this, 'modula_beta_scripts' ) );


			// Set fields
			$this->fields[ __( 'General', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-settings",
				"fields" => array(
					"name"           => array(
						"name"        => esc_html__( 'Name', 'modula-gallery' ),
						"type"        => "text",
						"description" => esc_html__( 'Name of the gallery, for internal use.', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"description"    => array(
						"name"        => esc_html__( 'Description', 'modula-gallery' ),
						"type"        => "text",
						"description" => esc_html__( 'This description is for internal use.', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"width"          => array(
						"name"        => esc_html__( 'Width', 'modula-gallery' ),
						"type"        => "text",
						"description" => esc_html__( 'Width of the gallery (i.e.: 100% or 500px)', 'modula-gallery' ),
						"mu"          => "px or %",
						"excludeFrom" => array(),
					),
					"height"         => array(
						"name"        => esc_html__( 'Height', 'modula-gallery' ),
						"type"        => "number",
						"description" => esc_html__( 'Height of the gallery in pixels', 'modula-gallery' ),
						"mu"          => "px",
						"excludeFrom" => array(),
					),
					"img_size"       => array(
						"name"        => esc_html__( 'Minimum image size', 'modula-gallery' ),
						"type"        => "number",
						"description" => esc_html__( 'Minimum width or height of the images', 'modula-gallery' ),
						"mu"          => "px or %",
						"excludeFrom" => array(),
					),
					"margin"         => array(
						"name"        => esc_html__( 'Margin', 'modula-gallery' ),
						"type"        => "number",
						"description" => esc_html__( 'Margin between images', 'modula-gallery' ),
						"mu"          => "px",
						"excludeFrom" => array(),
					),
					"randomFactor"   => array(
						"name"        => esc_html__( 'Random factor', 'modula-gallery' ),
						"type"        => "ui-slider",
						"description" => "",
						"min"         => 0,
						"max"         => 100,
						"mu"          => "%",
						"default"     => 20,
						"excludeFrom" => array(),
					),
					"filters"        => array(
						"name"        => esc_html__( 'Filters', 'modula-gallery' ),
						"type"        => "PRO_FEATURE",
						"description" => esc_html__( 'Add your own filters here. Each image can have one or more filters.', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"filterClick"    => array(
						"name"        => esc_html__( 'Reload Page on filter click', 'modula-gallery' ),
						"type"        => "PRO_FEATURE",
						"description" => esc_html__( 'Turn this feature ON if you want to use filters with most lightboxes', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"allFilterLabel" => array(
						"name"        => esc_html__( 'Text for "All" filter', 'modula-gallery' ),
						"type"        => "PRO_FEATURE",
						"description" => esc_html__( 'Write here the label for the "All" filter', 'modula-gallery' ),
						"default"     => "All",
						"excludeFrom" => array(),
					),
					"lightbox"       => array(
						"name"        => esc_html__( 'Lightbox &amp; Links', 'modula-gallery' ),
						"type"        => "select",
						"description" => esc_html__( 'Define here what happens when user click on the images.', 'modula-gallery' ),
						"values"      => array(
							"Link"       => array( 
								"|" . esc_html__( 'No link', 'modula-gallery' ),
								"direct|" . esc_html__( 'Direct link to image', 'modula-gallery' ),
								"|" . esc_html__( 'Attachment page', 'modula-gallery' )
							),
							"Lightboxes" => array( "lightbox2|Lightbox" ),
						),
						"disabled"    => array(
							"Lightboxes with PRO license" => array(
								"magnific|Magnific popup",
								"prettyphoto|PrettyPhoto",
								"fancybox|FancyBox",
								"swipebox|SwipeBox",
								"lightbox2|Lightbox",
							),
						),
						"excludeFrom" => array(),
					),
					"shuffle"        => array(
						"name"        => esc_html__( 'Shuffle images', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Flag it if you want to shuffle the gallery at each page load', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
				),
			);
			$this->fields[ esc_html__( 'Captions', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-comment-text-outline",
				"fields" => array(
					"captionColor"     => array(
						"name"        => esc_html__( 'Caption color', 'modula-gallery' ),
						"type"        => "color",
						"description" => esc_html__( 'Color of the caption.', 'modula-gallery' ),
						"default"     => "#ffffff",
						"excludeFrom" => array(),
					),
					"wp_field_caption" => array(
						"name"        => esc_html__( 'Populate caption from', 'modula-gallery' ),
						"type"        => "select",
						"description" => __( '<strong>This field is used ONLY when images are added to the gallery. </strong> If you don\'t want to automatically populate the caption field select <i>Don\'t Populate</i>', 'modula-gallery' ),
						"values"      => array(
							"Field" => array(
								"none|" . esc_html__( 'Don\'t Populate', 'modula-gallery' ),
								"title|" . esc_html__( 'WP Image title', 'modula-gallery' ),
								"caption|" . esc_html__( 'WP Image caption', 'modula-gallery' ),
								"description|" . esc_html__( 'WP Image description', 'modula-gallery' ),
							),
						),
						"excludeFrom" => array( "shortcode" ),
					),
					"wp_field_title"   => array(
						"name"        => esc_html__( 'Populate title from', 'modula-gallery' ),
						"type"        => "select",
						"description" => __( '<strong>This field is used ONLY when images are added to the gallery. </strong> If you don\'t want to automatically populate the title field select <i>Don\'t Populate</i>', 'modula-gallery' ),
						"values"      => array(
							"Field" => array(
								"none|" . esc_html__( 'Don\'t Populate', 'modula-gallery' ),
								"title|" . esc_html__( 'WP Image title', 'modula-gallery' ),
								"description|" . esc_html__( 'WP Image description', 'modula-gallery' ),
							),
						),
						"excludeFrom" => array( "shortcode" ),
					),
					"hide_title"        => array(
						"name"        => esc_html__( 'Image Title', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Hide image title from frontend', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"hide_description"        => array(
						"name"        => esc_html__( 'Image Description', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Hide image description from frontend', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"captionFontSize"  => array(
						"name"        => esc_html__( 'Caption Font Size', 'modula-gallery' ),
						"type"        => "number",
						"description" => "",
						"mu"          => "px",
						"excludeFrom" => array(),
					),
					"titleFontSize"    => array(
						"name"        => esc_html__( 'Title Font Size', 'modula-gallery' ),
						"type"        => "number",
						"description" => "",
						"mu"          => "px",
						"excludeFrom" => array(),
					),
				),
			);

			$this->fields[ esc_html__( 'Social', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-link-variant",
				"fields" => array(
					"enableTwitter"   => array(
						"name"        => esc_html__( 'Add Twitter icon', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Enable Twitter Sharing', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"enableFacebook"  => array(
						"name"        => esc_html__( 'Add Facebook icon', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Enable Facebook Sharing', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"enableGplus"     => array(
						"name"        => esc_html__( 'Add Google Plus icon', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Enable Google Plus Sharing', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"enablePinterest" => array(
						"name"        => esc_html__( 'Add Pinterest  icon', 'modula-gallery' ),
						"type"        => "toggle",
						"default"     => "T",
						"description" => esc_html__( 'Enable Pinterest Sharing', 'modula-gallery' ),
						"excludeFrom" => array(),
					),
					"socialIconColor" => array(
						"name"        => esc_html__( 'Color of social sharing icons', 'modula-gallery' ),
						"type"        => "color",
						"description" => esc_html__( 'Set the color of the social sharing icons', 'modula-gallery' ),
						"default"     => "#ffffff",
						"excludeFrom" => array(),
					),
				),

			);
			$this->fields[ esc_html__( 'Image loaded effects', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-reload",
				"fields" => array(
					"loadedScale"  => array(
						"name"        => esc_html__( 'Scale', 'modula-gallery' ),
						"description" => esc_html__( 'Choose a value below 100% for a zoom-in effect. Choose a value over 100% for a zoom-out effect', 'modula-gallery' ),
						"type"        => "ui-slider",
						"min"         => 0,
						"max"         => 200,
						"mu"          => "%",
						"default"     => 100,
						"excludeFrom" => array(),
					),
					"loadedRotate" => array(
						"name"        => esc_html__( 'Rotate', 'modula-gallery' ),
						"description" => "",
						"type"        => "PRO_FEATURE",
						"min"         => - 180,
						"max"         => 180,
						"default"     => 0,
						"mu"          => "deg",
						"excludeFrom" => array(),
					),
					"loadedHSlide" => array(
						"name"        => esc_html__( 'Horizontal slide', 'modula-gallery' ),
						"description" => "",
						"type"        => "PRO_FEATURE",
						"min"         => - 100,
						"max"         => 100,
						"mu"          => "px",
						"default"     => 0,
						"excludeFrom" => array(),
					),
					"loadedVSlide" => array(
						"name"        => esc_html__( 'Vertical slide', 'modula-gallery' ),
						"description" => "",
						"type"        => "PRO_FEATURE",
						"min"         => - 100,
						"max"         => 100,
						"mu"          => "px",
						"default"     => 0,
						"excludeFrom" => array(),
					),

				),
			);
			$this->fields[ esc_html__( 'Hover effect', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-blur",
				"fields" => array(
					"Effect" => array(
						"name"        => esc_html__( 'Effect', 'modula-gallery' ),
						"description" => esc_html__( 'Select an hover effect', 'modula-gallery' ),
						"type"        => "hover-effect",
						"excludeFrom" => array(),
					),
				),
			);
			$this->fields[ esc_html__( 'Style', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-format-paint",
				"fields" => array(
					"borderSize"   => array(
						"name"        => esc_html__( 'Border Size', 'modula-gallery' ),
						"type"        => "ui-slider",
						"description" => "",
						"mu"          => "px",
						"min"         => 0,
						"max"         => 10,
						"default"     => 0,
						"excludeFrom" => array(),
					),
					"borderRadius" => array(
						"name"        => esc_html__( 'Border Radius', 'modula-gallery' ),
						"type"        => "ui-slider",
						"description" => "",
						"mu"          => "px",
						"min"         => 0,
						"max"         => 100,
						"default"     => 0,
						"excludeFrom" => array(),
					),
					"borderColor"  => array(
						"name"        => esc_html__( 'Border Color', 'modula-gallery' ),
						"type"        => "color",
						"description" => "",
						"default"     => "#ffffff",
						"excludeFrom" => array(),
					),
					"shadowSize"   => array(
						"name"        => esc_html__( 'Shadow Size', 'modula-gallery' ),
						"type"        => "ui-slider",
						"description" => "",
						"mu"          => "px",
						"min"         => 0,
						"max"         => 20,
						"default"     => 0,
						"excludeFrom" => array(),
					),
					"shadowColor"  => array(
						"name"        => esc_html__( 'Shadow Color', 'modula-gallery' ),
						"type"        => "color",
						"description" => "",
						"default"     => "#ffffff",
						"excludeFrom" => array(),
					),

				),
			);
			$this->fields[ esc_html__( 'Customizations', 'modula-gallery' ) ] = array(
				"icon"   => "mdi mdi-puzzle",
				"fields" => array(
					"script" => array(
						"name"        => esc_html__( 'Custom scripts', 'modula-gallery' ),
						"type"        => "textarea",
						"description" => esc_html__( 'This script will be called after the gallery initialization. Useful for custom lightboxes.', 'modula-gallery' ) . "
	                        <br />
	                        <br />
	                        <strong>Write just the code without using the &lt;script&gt;&lt;/script&gt; tags</strong>",
						"excludeFrom" => array( "shortcode" ),
					),
					"style"  => array(
						"name"        => esc_html__( 'Custom css', 'modula-gallery' ),
						"type"        => "textarea",
						"description" => '<strong>' . esc_html__( 'Write just the code without using the &lt;style&gt;&lt;/style&gt; tags', 'modula-gallery' ) . '</strong>',
						"excludeFrom" => array( "shortcode" ),
					),
				),
			);

		}

		public function modula_beta_scripts( $hook ) {

			if ( 'modula_page_modula-lite-gallery-v2' != $hook ) {
				return;
			}

			wp_enqueue_script( 'modula-fancybox', plugins_url() . '/modula-best-grid-gallery/admin/fancybox/jquery.fancybox.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'modula-fancybox', plugins_url() . '/modula-best-grid-gallery/admin/fancybox/jquery.fancybox.min.css' );

		}

		//Define textdomain
		public function create_textdomain() {
			$plugin_dir = basename( dirname( __FILE__ ) );
			load_plugin_textdomain( 'modula-gallery', false, $plugin_dir . '/lib/languages' );
		}

		function define_hover_effects() {
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'None', 'none', false, false, 0 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Pufrobo', 'pufrobo', true, true, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Fluid Up', '', true, true, 0 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Hide', '', true, true, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Quiet', '', true, false, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Catinelle', '', false, false, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Reflex', '', true, true, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Curtain', '', true, false, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Lens', '', true, true, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Appear', '', true, false, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Crafty', '', true, true, 0 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Seemo', '', true, false, 4 );
			$this->hoverEffects[] = new ModulaLiteHoverEffect( 'Comodo', '', true, false, 4 );
		}

		public function get_ext_galleries() {
			header( "Content-type: application/json" );

			global $wpdb;

			if ( check_admin_referer( "Modula", "Modula" ) ) {
				$res = array( "success" => 0 );

				$source = $_POST['source'];
				if ( $source ) {
					$res['success']   = 1;
					$res['galleries'] = array();

					switch ( $source ) {
						case 'Envira':
							$galleries = get_posts( array(
								                        'post_type'      => 'envira',
								                        'posts_per_page' => 1000,
							                        ) );
							foreach ( $galleries as $g ) {
								$item                = array();
								$item['id']          = $g->ID;
								$item['title']       = $g->post_title;
								$res['galleries'] [] = $item;
							}
							break;
						case 'NextGen':
							$galleries = $wpdb->get_results( "SELECT title, gid FROM $wpdb->nggallery" );
							foreach ( $galleries as $g ) {
								$item                = array();
								$item['id']          = $g->gid;
								$item['title']       = $g->title;
								$res['galleries'] [] = $item;
							}
							break;
					}
				}

				echo json_encode( $res );
			}
			die();
		}

		public function admin_footer( $text ) {
			global $current_screen;
			if ( ! empty( $current_screen->id ) && strpos( $current_screen->id, 'modula-lite' ) !== false ) {
				$url  = 'https://wordpress.org/support/plugin/modula-best-grid-gallery/reviews/?rate=5#new-post';
				$text = sprintf( __( 'Please rate <strong>Modula Gallery</strong> <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank">WordPress.org</a> to help us spread the word. Thank you, on behalf of the Modula team!', 'modula-gallery' ), $url, $url );
			}

			return $text;
		}

		public function do_import_galleries() {
			global $wpdb;

			header( "Content-type: application/json" );
			if ( check_admin_referer( "Modula", "Modula" ) ) {
				$res    = array( "success" => 0 );
				$source = $_POST['source'];
				$ids    = explode( ",", $_POST['ids'] );
				switch ( $source ) {
					case 'Envira':
						foreach ( $ids as $id ) {
							$gallery = get_post( $id );
							$meta    = get_post_meta( $id );
							$data    = unserialize( $meta['_eg_gallery_data'][0] );

							$g   = array(
								'name'             => $data['config']['title'],
								'description'      => 'Imported from Envira (' . $id . ') on ' . date( 'M, d Y' ),
								'margin'           => $data['config']['gutter'],
								'hasResizedImages' => true,
								'importedFrom'     => 'Envira',
							);
							$gdb = array_merge( $this->defaultValues, $g );

							$saved = $this->ModulaDB->addGallery( $gdb );
							$newId = $this->ModulaDB->getNewGalleryId();

							if ( $newId && count( $data['gallery'] ) ) {
								$images = array();
								//TODO only active images
								foreach ( $data['gallery'] as $item ) {
									$toAdd              = new stdClass();
									$toAdd->imageId     = $this->ModulaDB->getIDbyGUID( $item['src'] );
									$toAdd->title       = $item['title'];
									$toAdd->description = $item['caption'];
									$toAdd->imagePath   = $item['src'];

									$images [] = $toAdd;
								}
								$imgResult = $this->ModulaDB->addImages( $newId, $images );
							}
						}
						$res['success'] = 1;
						break;
					case 'NextGen':
						foreach ( $ids as $id ) {
							$gallery = $wpdb->get_row( $wpdb->prepare( "SELECT title, gid, path FROM $wpdb->nggallery WHERE gid=%s", $id ) );

							$dbimages = $wpdb->get_results( $wpdb->prepare( "SELECT filename, description, alttext FROM $wpdb->nggpictures WHERE exclude <> 1 AND galleryid=%s", $id ) );

							$g   = array(
								'name'             => $gallery->title,
								'description'      => 'Imported from NextGet (' . $id . ') on ' . date( 'M, d Y' ),
								'hasResizedImages' => true,
								'importedFrom'     => 'NextGen',
							);
							$gdb = array_merge( $this->defaultValues, $g );

							$saved = $this->ModulaDB->addGallery( $gdb );
							$newId = $this->ModulaDB->getNewGalleryId();

							if ( $newId && count( $dbimages ) ) {
								$images = array();
								foreach ( $dbimages as $item ) {
									$toAdd              = new stdClass();
									$toAdd->imageId     = - 1;
									$toAdd->title       = $item->alttext;
									$toAdd->description = $item->description;
									$toAdd->imagePath   = plugins_url( 'image.php', __FILE__ ) . "?w=" . $this->defaultValues['img_size'] . "&src=" . $gallery->path . "/" . $item->filename;

									$images [] = $toAdd;
								}
								$imgResult = $this->ModulaDB->addImages( $newId, $images );

							}
						}
						$res['success'] = 1;
						break;
				}

				echo json_encode( $res );
			}
			die();
		}

		public function register_links( $links, $file ) {
			$base = plugin_basename( __FILE__ );
			if ( $file == $base ) {
				$links[] = '<a href="admin.php?page=modula-lite-admin" title="' . esc_html__( 'Modula Grid Gallery Dashboard', 'modula-gallery' ) . '">' . esc_html__( 'Dashboard', 'modula-gallery' ) . '</a>';
				$links[] = '<a href="https://twitter.com/MachoThemez" title="@MachoThemez on Twitter">Twitter</a>';
				$links[] = '<a href="https://www.facebook.com/machothemes" title="MachoThemes on Facebook">Facebook</a>';
			}

			return $links;

		}

		//delete gallery
		function delete_gallery() {
			if ( check_admin_referer( "Modula", "Modula" ) ) {
				$id = intval( $_POST['gid'] );
				$this->ModulaDB->deleteGallery( $id );
			}

			die();
		}

		public function update_config() {
			if ( check_admin_referer( "Modula", "Modula" ) ) {
				$id     = $_POST['id'];
				$config = stripslashes( $_POST['config'] );

				$this->ModulaDB->update_config( $id, $config );
			}

			die();
		}

		public function get_config() {
			if ( check_admin_referer( "Modula", "Modula" ) ) {
				$id = $_POST['id'];

				$data = $this->ModulaDB->getConfig( $id );

				print json_encode( $data );

			}

			die();
		}

		//add gallery

		function create_gallery() {
			if ( check_admin_referer( "Modula", "Modula" ) ) {
				$data                     = $this->defaultValues;
				$data["name"]             = $_POST['name'];
				$data["description"]      = $_POST['description'];
				$data["width"]            = $_POST['width'];
				$data["height"]           = $_POST['height'];
				$data["img_size"]         = intval( $_POST['img_size'] );
				$data["hasResizedImages"] = true;

				$this->ModulaDB->addGallery( $data );
				$id = $this->ModulaDB->getLastGalleryId()->Id;

				if ( $id > 0 && array_key_exists( 'images', $_POST ) && strlen( $_POST['images'] ) ) {
					$enc_images = stripslashes( $_POST["images"] );
					$images     = array_splice( json_decode( $enc_images ), 0, 11 + 9 );
					ModulaLiteTools::check_and_resize( $images, $data['img_size'] );
					$result = $this->ModulaDB->addImages( $id, $images );
				}
				print $id;
			}
			die;
		}

		//clone gallery
		function clone_gallery() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				$sourceId = intval( $_POST['gid'] );
				$g        = $this->ModulaDB->getGalleryById( $sourceId, $this->defaultValues );
				$g->name  .= "(copy)";
				$this->ModulaDB->addGallery( $g );
				$id     = $this->ModulaDB->getNewGalleryId();
				$images = $this->ModulaDB->getImagesByGalleryId( $sourceId );

				foreach ( $images as &$image ) {
					$image->Id  = null;
					$image->gid = $id;
				}

				$this->ModulaDB->addImages( $id, $images );
			}

			die();
		}


		//Define constants
		public function define_constants() {
			if ( ! defined( 'Modula_PLUGIN_BASENAME' ) ) {
				define( 'Modula_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

			if ( ! defined( 'Modula_PLUGIN_NAME' ) ) {
				define( 'Modula_PLUGIN_NAME', trim( dirname( Modula_PLUGIN_BASENAME ), '/' ) );
			}

			if ( ! defined( 'Modula_PLUGIN_DIR' ) ) {
				define( 'Modula_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . Modula_PLUGIN_NAME );
			}
		}

		//delete Gallery


		//Define DB tables
		public function define_db_tables() {
			global $wpdb;

			$wpdb->ModulaGalleries = $wpdb->prefix . 'modula';
			$wpdb->ModulaImages    = $wpdb->prefix . 'modula_images';
		}


		public function create_db_conn() {
			require( 'lib/db-class.php' );
			$ModulaDB = ModulaLiteDB::getInstance();

			return $ModulaDB;
		}

		public function editor_button( $buttons ) {
			array_push( $buttons, 'separator', 'mtg_shortcode_editor' );

			return $buttons;
		}

		public function register_editor_plugin( $plugin_array ) {
			$plugin_array['mtg_shortcode_editor'] = plugins_url( '/admin/scripts/editor-plugin.js', __file__ );

			return $plugin_array;
		}

		public function mtg_shortcode_editor() {
			$css_path  = plugins_url( 'assets/css/admin.css', __FILE__ );
			$admin_url = admin_url();

			$galleries = $this->ModulaDB->getGalleries(); //load all galleries

			include 'admin/include/tinymce-galleries.php';
			die();
		}

		//Add gallery scripts
		public function add_gallery_scripts() {
			wp_enqueue_script( 'jquery' );

			wp_register_script( 'modula', plugins_url() . '/modula-best-grid-gallery/scripts/jquery.modula.js', array( 'jquery' ) );
			wp_enqueue_script( 'modula' );

			wp_register_style( 'modula_stylesheet', plugins_url() . '/modula-best-grid-gallery/scripts/modula.css', null, $this->version );
			wp_enqueue_style( 'modula_stylesheet' );

			wp_register_style( 'effects_stylesheet', plugins_url() . '/modula-best-grid-gallery/scripts/effects.css', null, $this->version );
			wp_enqueue_style( 'effects_stylesheet' );

			wp_register_script( 'lightbox2_script', plugins_url() . '/modula-best-grid-gallery/lightbox/lightbox2/js/lightbox.min.js', array( 'jquery' ), $this->version, true );
			wp_register_style( 'lightbox2_stylesheet', plugins_url() . '/modula-best-grid-gallery/lightbox/lightbox2/css/lightbox.min.css' );
		}

		//Admin Section - register scripts and styles
		public function gallery_admin_init() {
			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}

			wp_enqueue_script( 'jquery' );

			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );

			wp_register_style( 'materialize', plugins_url() . '/modula-best-grid-gallery/admin/css/materialize.css' );
			wp_enqueue_style( 'materialize' );

			wp_register_style( 'styles', plugins_url() . '/modula-best-grid-gallery/admin/css/style.css' );
			wp_enqueue_style( 'styles' );

			wp_register_style( 'effects', plugins_url() . '/modula-best-grid-gallery/scripts/effects.css' );
			wp_enqueue_style( 'effects' );

			wp_register_script( 'materialize', plugins_url() . '/modula-best-grid-gallery/admin/scripts/materialize.js', array( 'jquery' ) );

			wp_register_script( 'modula', plugins_url() . '/modula-best-grid-gallery/admin/scripts/modula-admin.js', array(
				'materialize',
				'jquery',
				'media-upload',
				'thickbox',
			), false, false );

			wp_enqueue_script( 'modula' );

			wp_register_style( 'materialdesign-icons', plugins_url() . '/modula-best-grid-gallery/admin/css/materialdesignicons.css' );
			wp_enqueue_style( 'materialdesign-icons' );

			wp_enqueue_style( 'thickbox' );

			$tg_db_version = '1.0';
			$installed_ver = get_option( "Modula_db_version" );

			if ( $installed_ver != $tg_db_version ) {
				modula_lite_create_db_tables();
				update_option( "Modula_db_version", $tg_db_version );
			}
		}


		//Create Admin Menu
		public function add_gallery_admin_menu() {
			$overview = add_menu_page( esc_html__( 'Manage Galleries', 'modula-gallery' ), esc_html__( 'Modula', 'modula-gallery' ), 'edit_posts', 'modula-lite-admin', array(
				$this,
				'add_overview',
			), plugins_url() . '/modula-best-grid-gallery/admin/icon.png' );


			if ( ! get_option( "Modula_skip_fix" ) && get_option( "Modula_db_version" ) && count( $this->ModulaDB->getGalleries() ) > 0 ) {

				$imageUrl = null;
				foreach ( $this->ModulaDB->getGalleries() as $gallery ) {
					$gid    = $gallery->Id;
					$images = $this->ModulaDB->getImagesByGalleryId( $gid );
					if ( count( $images ) > 0 ) {
						$imageUrl = $images[0]->imagePath;
						break;
					}
				}

				if ( $imageUrl ) {
					if ( strncmp( strtolower( $imageUrl ), strtolower( site_url() ), strlen( site_url() ) ) != 0 ) {
						$fix = add_submenu_page( 'modula-lite-admin', __( 'Modula >> Fix', 'modula-gallery' ), '❗️ ' . __( 'Fix', 'modula-gallery' ), 'edit_posts', 'modula-lite-gallery-fix', array(
							$this,
							'fix',
						) );
						add_action( 'load-' . $fix, array( $this, 'gallery_admin_init' ) );
					}
				}
			} else {
				add_option( 'Modula_skip_fix', true );
			}

			$add_gallery  = add_submenu_page( 'modula-lite-admin', __( 'Modula - Add Gallery', 'modula-gallery' ), __( 'Add Gallery', 'modula-gallery' ), 'edit_posts', 'modula-lite-add', array(
				$this,
				'add_gallery',
			) );
			$edit_gallery = add_submenu_page( NULL, __( 'Modula - Edit Gallery', 'modula-gallery' ), __( 'Edit Gallery', 'modula-gallery' ), 'edit_posts', 'modula-lite-edit', array(
				$this,
				'edit_gallery',
			) );
			$upgrade      = add_submenu_page( 'modula-lite-admin', __( 'Modula - Upgrade to PRO', 'modula-gallery' ), __( 'Upgrade to PRO', 'modula-gallery' ), 'edit_posts', 'modula-lite-gallery-upgrade', array(
				$this,
				'upgrade',
			) );
			$v2 = add_submenu_page( 'modula-lite-admin', __( 'Try Modula 2.0', 'modula-gallery' ), __( 'Try Modula 2.0', 'modula-gallery' ), 'edit_posts', 'modula-lite-gallery-v2', array(
				$this,
				'new_modula',
			) );


			add_action( 'load-' . $overview, array( $this, 'gallery_admin_init' ) );
			add_action( 'load-' . $add_gallery, array( $this, 'gallery_admin_init' ) );
			add_action( 'load-' . $edit_gallery, array( $this, 'gallery_admin_init' ) );
			add_action( 'load-' . $upgrade, array( $this, 'gallery_admin_init' ) );

		}

		//Create Admin Pages
		public function add_overview() {
			include( "admin/overview.php" );
		}

		public function upgrade() {
			include( "admin/upgrade.php" );
		}

		public function add_gallery() {
			include( "admin/add-gallery.php" );
		}

		public function new_modula() {
			include( "admin/modula-v2.php" );
		}

		public function fix() {
			global $wpdb;
			include( "admin/fix.php" );
		}

		public function delete_image() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				foreach ( explode( ",", $_POST["id"] ) as $id ) {
					$this->ModulaDB->deleteImage( intval( $id ) );
				}
			}
			die();
		}

		public function add_image() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				$gid              = intval( $_POST['galleryId'] );
				$this->loadedData = $this->ModulaDB->getGalleryById( $gid, $this->defaultValues );
				$prev             = $this->ModulaDB->getImagesByGalleryId( $gid );

				$enc_images = stripslashes( $_POST["enc_images"] );
				$images     = json_decode( $enc_images );

				$d      = 18 + log10( 100 );
				$images = array_slice( $images, 0, $d - count( $prev ) );
				$images = ModulaLiteTools::check_and_resize( $images, $this->loadedData->img_size );
				$result = $this->ModulaDB->addImages( $gid, $images );

				header( "Content-type: application/json" );
				if ( $result === false ) {
					print "{\"success\":false}";
				} else {
					print "{\"success\":true}";
				}
			}
			die();
		}

		public function sort_images() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				$result = $this->ModulaDB->sortImages( explode( ',', $_POST['ids'] ) );

				header( "Content-type: application/json" );
				if ( $result === false ) {
					print "{\"success\":false}";
				} else {
					print "{\"success\":true}";
				}
			}
			die();
		}

		public function save_image() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				$result = false;
				// $type = $_POST['type'];
				$imageUrl     = esc_url( $_POST['img_url'] );
				$imageCaption = stripslashes( $_POST['description'] );
				$title        = stripslashes( $_POST['title'] );
				$target       = $_POST['target'];
				$link         = isset( $_POST['link'] ) ? stripslashes( $_POST['link'] ) : null;
				$imageId      = intval( $_POST['img_id'] );
				$sortOrder    = intval( $_POST['sortOrder'] );
				$halign       = $_POST['halign'];
				$valign       = $_POST['valign'];

				$data = array(
					"target"      => $target,
					"link"        => $link,
					"imageId"     => $imageId,
					"description" => $imageCaption,
					'title'       => $title,
					"halign"      => $halign,
					"valign"      => $valign,
					"sortOrder"   => $sortOrder,
				);

				if ( ! empty( $_POST['id'] ) ) {
					$imageId = intval( $_POST['id'] );
					$result  = $this->ModulaDB->editImage( $imageId, $data );
				} else {
					$data["gid"] = intval( $_POST['galleryId'] );
					$result      = $this->ModulaDB->addFullImage( $data );
				}

				header( "Content-type: application/json" );

				if ( $result === false ) {
					print "{\"success\":false}";
				} else {
					print "{\"success\":true}";
				}

			}
			die();
		}

		public function list_images() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				$gid     = intval( $_POST["gid"] );
				$gallery = $this->ModulaDB->getGalleryById( $gid, $this->defaultValues );

				$imageResults = $this->ModulaDB->getImagesByGalleryId( $gid );

				include( 'admin/include/image-list.php' );
			}
			die();
		}

		private function checkboxVal( $field ) {
			if ( isset( $_POST[ $field ] ) ) //return 'checked';
			{
				return 'T';
			}

			//return '';
			return 'F';
		}

		public function save_gallery() {
			if ( check_admin_referer( 'Modula', 'Modula' ) ) {
				$galleryName        = stripslashes( $_POST['tg_name'] );
				$galleryDescription = stripslashes( $_POST['tg_description'] );
				$slug               = strtolower( str_replace( " ", "", $galleryName ) );
				$margin             = intval( $_POST['tg_margin'] );
				$shuffle            = $this->checkboxVal( 'tg_shuffle' );
				$width              = $_POST['tg_width'];
				$height             = $_POST['tg_height'];
				$enableTwitter      = $this->checkboxVal( 'tg_enableTwitter' );
				$enableFacebook     = $this->checkboxVal( 'tg_enableFacebook' );
				$enableGplus        = $this->checkboxVal( 'tg_enableGplus' );
				$enablePinterest    = $this->checkboxVal( 'tg_enablePinterest' );
				$lightbox           = $_POST['tg_lightbox'];
				$wp_field_caption   = $_POST['tg_wp_field_caption'];
				$wp_field_title     = $_POST['tg_wp_field_title'];
				$hide_title         = $this->checkboxVal( 'tg_hide_title' );
				$hide_description   = $this->checkboxVal( 'tg_hide_description' );
				$captionColor       = $_POST['tg_captionColor'];
				$borderSize         = intval( $_POST['tg_borderSize'] );
				$loadedScale        = intval( $_POST['tg_loadedScale'] );
				$loadedRotate       = intval( $_POST['tg_loadedRotate'] );
				$loadedVSlide       = intval( $_POST['tg_loadedVSlide'] );
				$loadedHSlide       = intval( $_POST['tg_loadedHSlide'] );
				$socialIconColor    = $_POST['tg_socialIconColor'];
				$hoverEffect        = $_POST['tg_hoverEffect'];
				$titleFontSize      = intval( $_POST['tg_titleFontSize'] );
				$captionFontSize    = intval( $_POST['tg_captionFontSize'] );
				$borderColor        = $_POST['tg_borderColor'];
				$borderRadius       = intval( $_POST['tg_borderRadius'] );
				$shadowColor        = $_POST['tg_shadowColor'];
				$shadowSize         = intval( $_POST['tg_shadowSize'] );
				$style              = $_POST['tg_style'];
				$script             = $_POST['tg_script'];

				$id = isset( $_POST['ftg_gallery_edit'] ) ? intval( $_POST['ftg_gallery_edit'] ) : 0;

				$data = array(
					'name'             => $galleryName,
					'slug'             => $slug,
					'description'      => $galleryDescription,
					'lightbox'         => $lightbox,
					'img_size'         => intval( $_POST['tg_img_size'] ),
					'hasResizedImages' => true,
					'wp_field_caption' => $wp_field_caption,
					'wp_field_title'   => $wp_field_title,
					'hide_title'       => $hide_title,
					'hide_description' => $hide_description,
					'margin'           => $margin,
					'randomFactor'     => $_POST['tg_randomFactor'],
					'shuffle'          => $shuffle,
					'enableTwitter'    => $enableTwitter,
					'enableFacebook'   => $enableFacebook,
					'enableGplus'      => $enableGplus,
					'enablePinterest'  => $enablePinterest,
					'captionColor'     => $captionColor,
					'hoverEffect'      => $hoverEffect,
					'borderSize'       => $borderSize,
					'loadedScale'      => $loadedScale,
					'loadedHSlide'     => $loadedHSlide,
					'loadedVSlide'     => $loadedVSlide,
					'loadedRotate'     => $loadedRotate,
					'socialIconColor'  => $socialIconColor,
					'captionFontSize'  => $captionFontSize,
					'titleFontSize'    => $titleFontSize,
					'borderColor'      => $borderColor,
					'borderRadius'     => $borderRadius,
					'shadowSize'       => $shadowSize,
					'shadowColor'      => $shadowColor,
					'width'            => $width,
					'height'           => $height,
					'style'            => $style,
					'script'           => $script,
				);

				header( "Content-type: application/json" );
				if ( $id > 0 ) {
					$result = $this->ModulaDB->editGallery( $id, $data );

					if ( intval( $this->loadedData->img_size ) != $data['img_size'] ) {
						$images = $this->ModulaDB->getImagesByGalleryId( $id );
						$images = ModulaLiteTools::check_and_resize( $images, $data['img_size'] );

						foreach ( $images as $img ) {
							$this->ModulaDB->editImage( $img->Id, (array) $img );
						}
					}

					$this->loadedData = $this->ModulaDB->getGalleryById( $id, $this->defaultValues );
				} else {
					$result = $this->ModulaDB->addGallery( $data );
					$id     = $this->ModulaDB->getNewGalleryId();
				}

				if ( $result ) {
					print "{\"success\":true,\"id\":" . $id . "}";
				} else {
					print "{\"success\":false}";
				}
			}
			die();
		}

		public function edit_gallery() {
			if ( isset( $_GET['galleryId'] ) ) {
				$this->loadedData   = $this->ModulaDB->getGalleryById( intval( $_GET['galleryId'] ), $this->defaultValues );
				$modula_fields      = $this->fields;
				$modula_parent_page = "dashboard";

				include( "admin/edit-gallery.php" );
			} else {
				$redir    = true;
				$nobanner = true;
				include( "admin/overview.php" );
			}
		}

		public function list_thumbnail_sizes() {
			global $_wp_additional_image_sizes;
			$sizes = array();
			foreach ( get_intermediate_image_sizes() as $s ) {
				$sizes[ $s ] = array( 0, 0 );
				if ( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ) {
					$sizes[ $s ][0] = get_option( $s . '_size_w' );
					$sizes[ $s ][1] = get_option( $s . '_size_h' );
				} else {
					if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) ) {
						$sizes[ $s ] = array(
							$_wp_additional_image_sizes[ $s ]['width'],
							$_wp_additional_image_sizes[ $s ]['height'],
						);
					}
				}
			}

			return $sizes;
		}

		public function gallery_shortcode_handler( $atts ) {
			require_once( 'lib/gallery-class.php' );
			global $Modula;

			if ( class_exists( 'ModulaLiteFE' ) ) {
				$Modula = new ModulaLiteFE( $this->ModulaDB, $atts['id'], $this->defaultValues );

				$settings = $Modula->getGallery();
				switch ( $settings->lightbox ) {
					case "lightbox2":
						wp_enqueue_style( 'lightbox2_stylesheet' );
						wp_enqueue_script( 'lightbox2_script' );
						wp_add_inline_script( 'lightbox2_script', 'jQuery(document).ready(function(){lightbox.option({albumLabel: "' . esc_html__( 'Image %1 of %2', 'modula-gallery' ) . '"});});' );
						break;
				}

				return $Modula->render();
			} else {
				return esc_html__( 'Gallery not found.', 'modula-gallery' );
			}
		}

		public function shortcode_empty_paragraph_fix( $content ) {

	        $array = array (
	            '<p>[Modula' => '[Modula' ,
	            '<p>[/Modula' => '[/Modula',
	            'Modula]</p>' => 'Modula]',
	            'Modula]<br />' => 'Modula]'
	        );

	        $content = strtr( $content, $array );

		    return $content;
		}

	}

	class ModulaLiteHoverEffect {

		var $name;
		var $code;
		var $allowTitle;
		var $allowSubtitle;
		var $maxSocial;

		public function __construct( $name, $code, $allowTitle, $allowSubtitle, $maxSocial ) {
			$this->name          = $name;
			$this->code          = $code;
			$this->allowTitle    = $allowTitle;
			$this->allowSubtitle = $allowSubtitle;
			$this->maxSocial     = $maxSocial;
		}
	}
}

class ModulaLiteTools {

	public static function get_image_size_links( $id ) {
		$result  = array();
		$sizes   = get_intermediate_image_sizes();
		$sizes[] = 'full';

		foreach ( $sizes as $size ) {
			$image = wp_get_attachment_image_src( $id, $size );

			if ( ! empty( $image ) && ( true == $image[3] || 'full' == $size ) ) {
				$result["$image[1]x$image[2]"] = $image[0];
			}
		}

		return $result;
	}

	public static function resize_image( $id, $img_size ) {
		$file   = get_attached_file( $id );
		$editor = wp_get_image_editor( $file );
		$size   = $editor->get_size();
		if ( $size["width"] > $size["height"] ) {
			$editor->resize( 10000, $img_size );
		} else {
			$editor->resize( $img_size, 10000 );
		}
		$path_parts = pathinfo( $file );
		$filename   = $path_parts['dirname'] . "/" . $path_parts['filename'] . "-" . $img_size . "x" . $img_size . "." . $path_parts["extension"];

		if ( ! file_exists( $filename ) ) {
			$editor->save( $filename );
		}

		return basename( $filename );
	}

	public static function check_and_resize( &$images, $size ) {
		foreach ( $images as &$img ) {
			$metadata = wp_get_attachment_metadata( $img->imageId );

			if ( $img->imageId > 0 ) {
				$uploads  = wp_get_upload_dir();
				$file     = get_post_meta( $img->imageId, '_wp_attached_file', true );
				$baseurl  = $uploads['baseurl'] . '/' . str_replace( basename( $file ), "", $file );
				$res_name = ModulaLiteTools::resize_image( $img->imageId, $size );

				if ( ! ( array_key_exists( "image_meta", $metadata ) && array_key_exists( "resized_images", $metadata["image_meta"] ) && in_array( $size . "x" . $size, $metadata["image_meta"]["resized_images"] ) ) ) {
					if ( isset( $metadata['image_meta'] ) ) {
						$md                                         = $size . 'x' . $size;
						$metadata['image_meta']['resized_images'][] = $md;
						wp_update_attachment_metadata( $img->imageId, $metadata );
					}
				}

				$img->imagePath = $baseurl . $res_name;
			} else {
				$img->imagePath = preg_replace( "/w=(\d+)/", "w=" . $size, $img->imagePath );
			}
		}

		return $images;
	}
}

if ( class_exists( "ModulaLite" ) ) {
	global $ob_ModulaLite;
	$ob_ModulaLite = new ModulaLite();
}

function modula_lite_check_for_review() {

	if ( ! is_admin() ) {
		return;
	}

	require_once MODULA_PLUGIN_DIR_PATH . 'lib/class-modula-review.php';

	Modula_Review::get_instance( array(
	    'slug' => 'modula-best-grid-gallery',
	    'messages' => array(
	    	'notice'  => __( "Hey, I noticed you have created %s galleries - that's awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.<br><br><strong>~ Cristian Raiber</strong>,<br><strong>CEO Modula</strong>.", 'modula-gallery' ),
			'rate'    => __( 'Ok, you deserve it', 'modula-gallery' ),
			'rated'   => __( 'I already did', 'modula-gallery' ),
			'no_rate' => __( 'No, not good enough', 'modula-gallery' ),
	    ),
	) );

}
modula_lite_check_for_review();

// Add compatibility with AO
add_filter('autoptimize_filter_js_exclude','modula_lite_override_jsexclude',90,1);
function modula_lite_override_jsexclude( $exclude ) {
	if ( is_array( $exclude ) ) {
		$exclude[] = 'jquery.modula.js';
	}else{
		$exclude .= ", jquery.modula.js";
	}
	return $exclude;
}

// Beta Testing.
add_action( 'admin_notices', 'modula_beta_notices' );
add_action( 'wp_ajax_modula_beta_testing', 'modula_beta_ajax' );
add_action( 'admin_print_footer_scripts', 'modula_beta_ajax_script', 99 );

function modula_beta_notices() {

	$options = get_option( 'modula-checks', array() );

	if ( isset( $options['beta-testing'] ) ) {
		return;
	}
	?>
	<style type="text/css">
		#modula-beta-testing-info {
			display: inline-block;
			margin-left: 15px;
		}
	</style>
	<div id="modula-beta-testing" class="notice notice-success is-dismissible">
		<h3>Try Modula 2.0 !!</h3>
		<p>We’ve been working on an awesome update to Modula over the last few months and can’t wait to release it to the public. But, before that can happen, we need the help of amazing users in the WordPress community (just like you) to improve Modula 2.0’s first beta.</p>
		<p class="actions">
			<a id="modula-beta-testing-dwn" href="https://machothemes.com/downloads/modula-2.0.0.zip" target="_blank" class="button button-primary modula-beta-testing-button"><?php echo __( 'Download Modula 2.0 Beta', 'modula-gallery' ); ?></a>
			<a id="modula-beta-testing-info" href="<?php echo admin_url( 'admin.php?page=modula-lite-gallery-v2' ) ?>" target="_blank" class="modula-beta-testing-button"><?php echo __( 'Find more', 'modula-gallery' ); ?></a>
		</p>
	</div>
	<?php
}

function modula_beta_ajax() {

	check_ajax_referer( 'modula-beta-testing', 'security' );

	$options = get_option( 'modula-checks', array() );
	$options['beta-testing'] = 1;

	update_option( 'modula-checks', $options );

	wp_die( 'ok' );

}

function modula_beta_ajax_script() {

	$ajax_nonce = wp_create_nonce( "modula-beta-testing" );

	?>

	<script type="text/javascript">
		jQuery( document ).ready( function( $ ){

			$( '.modula-beta-testing-button' ).click( function( evt ){
				var href = $(this).attr('href'),
					id = $(this).attr('id');

				var data = {
					action: 'modula_beta_testing',
					security: '<?php echo $ajax_nonce; ?>',
				};

				$.post( '<?php echo admin_url( 'admin-ajax.php' ) ?>', data, function( response ) {
					$( '#modula-beta-testing' ).slideUp( 'fast', function() {
						$( this ).remove();
					} );
				});

			} );

		});
	</script>

	<?php
}

/* RollBack functionality */
require MODULA_PLUGIN_DIR_PATH . '/lib/class-modula-plugin-rollback.php';
require MODULA_PLUGIN_DIR_PATH . '/lib/class-modula-rollback.php';

/**
 * Insert Rollback link for plugin in plugins page
 */

function modula_lite_rollback_link( $links ) {

	$links['rollback'] = sprintf( '<a href="%s" class="modula-rollback-button">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=modula_rollback' ), 'modula_rollback' ), __( 'Rollback version', 'modula-gallery' ) );

	return $links;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'modula_lite_rollback_link' );
