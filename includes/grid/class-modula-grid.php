<?php
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Modula_Grid {

	/**
	 * Holds the class object.
	 *
	 * @since 2.3.0
	 *
	 * @var object
	 */
	public static $instance;


	/**
	 * Primary class constructor.
	 *
	 * @since 2.3.0
	 */
	public function __construct() {

		// Add Grid field
		add_filter( 'modula_gallery_fields', array( $this, 'modula_grid_gallery_type' ), 15, 1 );

		// Add defaults
		add_filter( 'modula_lite_default_settings', array( $this, 'set_defaults' ) );

		// register grid scripts and styles
		add_action( 'wp_enqueue_scripts', array( $this, 'register_grid_scripts' ), 90 );

		// Filter scripts and styles
		add_filter( 'modula_necessary_scripts', array( $this, 'modula_grid_scripts' ), 15, 2 );
		add_filter( 'modula_necessary_styles', array( $this, 'modula_grid_styles' ), 15, 2 );

		// Add image sizes
		add_filter( 'modula_resize_image_grid', array( $this, 'modula_grid_image_sizes' ), 15, 4 );

		// Generate new images' links
		add_filter( 'modula_shortcode_item_data', array( $this, 'change_image_size' ), 6, 3 );

		// Add grid settings to js config
		add_filter( 'modula_gallery_settings', array( $this, 'js_grid_config' ), 10, 2 );

		// Action for adding grid sizer
		add_action( 'modula_shortcode_before_items', array( $this, 'modula_grid_sizer' ), 10 );

		// Filter for $css
		add_filter( 'modula_shortcode_css', array( $this, 'generate_grid_css' ), 10, 3 );

	}

	/**
	 * Register grid scripts and styles
	 *
	 * @since 2.3.0
	 */
	public function register_grid_scripts() {

		// Register grid script
		wp_register_script( 'modula-grid-justified-gallery', MODULA_URL . 'assets/js/jquery.justifiedGallery.min.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

		wp_register_script( 'modula-grid-isotope-js', MODULA_URL . 'assets/js/isotope.pkgd.min.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_style( 'modula-grid-css', MODULA_URL . 'assets/css/front-grid.css' );

		wp_register_style( 'modula-grid-justified-gallery-css', MODULA_URL . 'assets/css/justifiedGallery.min.css' );

	}


	/**
	 * Enqueue grid scripts
	 *
	 * @param $scripts
	 * @param $settings
	 *
	 * @return array
	 *
	 * @since 2.3.0
	 */
	public function modula_grid_scripts( $scripts, $settings ) {

		if ( 'grid' == $settings['type'] ) {

			if ( 'automatic' != $settings['grid_type'] ) {

				$scripts[] = 'modula-grid-isotope-js';
			} else {

				$scripts[] = 'modula-grid-justified-gallery';
			}
		}
		return $scripts;
	}

	/**
	 * Enqueue grid styles
	 *
	 * @param $styles
	 * @param $settings
	 *
	 * @return array
	 *
	 * @since 2.3.0
	 */
	public function modula_grid_styles( $styles, $settings ) {

		if ( 'grid' == $settings['type'] ) {

			$styles[] = 'modula-grid-css';

			if ( 'automatic' == $settings['grid_type'] ) {

				$styles[] = 'modula-grid-justified-gallery-css';
			}
		}

		return $styles;
	}


	/**
	 * Add Modula Grid fields and type
	 *
	 * @param $fields
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function modula_grid_gallery_type( $fields ) {

		$fields['general']['type']['values']['grid'] = esc_html__( 'Columns', 'modula-best-grid-gallery' );

		$grid_fields = array(
			"grid_type" => array(
				"name"        => esc_html__( 'Column Type', 'modula-best-grid-gallery' ),
				"type"        => "select",
				"description" => esc_html__( 'Select the grid type. Automatic will fully fill each row .', 'modula-best-grid-gallery' ),
				'values'      => array(
					'automatic' => esc_html__( 'Automatic', 'modula-best-grid-gallery' ),
					'1'         => esc_html__( 'One Column(1)', 'modula-best-grid-gallery' ),
					'2'         => esc_html__( 'Two Columns(2)', 'modula-best-grid-gallery' ),
					'3'         => esc_html__( 'Three Columns(3)', 'modula-best-grid-gallery' ),
					'4'         => esc_html__( 'Four Columns(4)', 'modula-best-grid-gallery' ),
					'5'         => esc_html__( 'Five Columns(5)', 'modula-best-grid-gallery' ),
					'6'         => esc_html__( 'Six Columns(6)', 'modula-best-grid-gallery' ),
				),
				'default'     => 'automatic',
				'priority'    => 26,
			),

			"grid_row_height" => array(
				"name"        => esc_html__( 'Row Height.', 'modula-best-grid-gallery' ),
				"type"        => "number",
				"after"       => "px",
				"description" => esc_html__( 'Set the height of each row.', 'modula-best-grid-gallery' ),
				"default"     => 150,
				'is_child'    => true,
				"priority"    => 27,
			),

			"grid_justify_last_row" => array(
				"name"        => esc_html__( 'Last Row Alignment', 'modula-best-grid-gallery' ),
				"type"        => "select",
				"description" => esc_html__( 'By selecting justify , the last row of pictures will automatically be resized to fit the full width.', 'modula-best-grid-gallery' ),
				"values"      => array(
					"justify"   => esc_html__( 'Justify', 'modula-best-grid-gallery' ),
					'nojustify' => esc_html__( 'Left', 'modula-best-grid-gallery' ),
					'center'    => esc_html__( 'Center', 'modula-best-grid-gallery' ),
					'right'     => esc_html__( 'Right', 'modula-best-grid-gallery' ),
				),
				"default"     => "justify",
				'is_child'    => true,
				"priority"    => 28,
			),

			"grid_image_size" => array(
				"name"        => esc_html__( 'Image Size', 'modula-best-grid-gallery' ),
				"type"        => "select",
				"description" => esc_html__( 'Select the size of your images. ', 'modula-best-grid-gallery' ),
				'values'      => Modula_Helper::get_image_sizes( true ),
				'default'     => 'medium',
				'priority'    => 37,
			),

			"grid_image_dimensions" => array(
				"name"        => esc_html__( ' Image dimensions', 'modula-best-grid-gallery' ),
				"type"        => "image-size",
				"description" => esc_html__( 'Define image width. If Crop images isn\'t enabled, images will be proportional.', 'modula-best-grid-gallery' ),
				'default'     => '1200',
				'is_child'    => true,
				'priority'    => 38,
			),

			"grid_image_crop" => array(
				"name"        => esc_html__( 'Crop Image ?', 'modula-best-grid-gallery' ),
				"type"        => "toggle",
				"description" => esc_html__( 'If this is enabled, images will be cropped down to exactly the sizes defined above.', 'modula-best-grid-gallery' ),
				'default'     => 0,
				'is_child'    => true,
				'priority'    => 39,
			),


		);

		$fields['general'] = array_merge( $fields['general'], $grid_fields );

		return $fields;

	}

	/**
	 * Add image sizes for grid type
	 *
	 * @param $return
	 * @param $id
	 * @param $img_size
	 * @param $sizes
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function modula_grid_image_sizes( $return, $id, $img_size, $sizes ) {

		$return['width']  = $sizes['width'];
		$return['height'] = $sizes['height'];

		return $return;

	}

	/**
	 * Add params to gallery js_config
	 *
	 * @param $js_config
	 * @param $settings
	 *
	 * @return array
	 *
	 * @since 2.3.0
	 */
	public function js_grid_config( $js_config, $settings ) {
		if ( 'grid' == $settings['type'] ) {

			$js_new_config = array(
				'grid_type' => $settings['grid_type'],
				'rowHeight' => isset( $settings['grid_row_height'] ) ? absint( $settings['grid_row_height'] ) : 640,
				'lastRow'   => isset( $settings['grid_justify_last_row'] ) ? $settings['grid_justify_last_row'] : 'justify',
			);

			$js_config = wp_parse_args( $js_new_config, $js_config );
			if ( isset( $js_config['height'] ) ) {
				unset( $js_config['height'] );
			}

		}
		return $js_config;
	}


	/**
	 * Model image attributes
	 *
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function modula_grid_image_data( $image, $settings ) {

		$grid_size = Modula_Helper::get_image_sizes( false, $settings['grid_image_size'] );

		// check if selected image size is defined
		if ( $grid_size ) {
			$image['width']  = $grid_size['width'];
			$image['height'] = $grid_size['height'];
		} else {
			if ( 'default' == $settings['grid_image_size'] ) {
				$image['width']  = $settings['grid_image_dimensions']['width'];
				$image['height'] = $settings['grid_image_dimensions']['height'];
			} else {
				$image['width']  = 0;
				$image['height'] = 0;
			}
		}

		return $image;
	}

	/**
	 * Modula image attributes
	 *
	 * @param $item_data
	 * @param $item
	 * @param $settings
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function change_image_size( $item_data, $item, $settings ) {

		// We need to change only for gallery type grid
		if ( 'grid' != $settings['type'] ) {
			return $item_data;
		}

		// // Remove modula initial filter
		remove_filter( 'modula_shortcode_item_data', 'modula_generate_image_links', 10 );

		if ( !class_exists( 'Modula_Image' ) ) {
			return $item_data;
		}

		$image_full = wp_get_attachment_image_src( $item['id'], 'full' );
		$image_url  = '';

		if ( 'custom' != $settings['grid_image_size'] ) {


			$thumb = wp_get_attachment_image_src( $item['id'], $settings['grid_image_size'] );

			if ( $thumb ) {

				$item_data['image_url'] = $thumb[0];
				$image_url              = $thumb[0];
				// Add src/data-src attributes to img tag
				$item_data['img_attributes']['src']      = $thumb[0];
				$item_data['img_attributes']['data-src'] = $thumb[0];

			}

			if ( $image_full ) {
				$item_data['image_full'] = $image_full[0];
			}

		} else {

			$width  = $settings['grid_image_dimensions']['width'];
			$height = $settings['grid_image_dimensions']['height'];
			$crop   = boolval( $settings['grid_image_crop'] );

			if ( !$image_full ) {
				return $item_data;
			}

			$resizer   = new Modula_Image();
			$image_url = $resizer->resize_image( $image_full[0], $width, $height, $crop );

			// If we couldn't resize the image we will return the full image.
			if ( is_wp_error( $image_url ) ) {
				$image_url = $image_full[0];
			}


			$item_data['image_full'] = $image_full[0];
			$item_data['image_url']  = $image_url;
			// Add src/data-src attributes to img tag
			$item_data['img_attributes']['src']      = $image_url;
			$item_data['img_attributes']['data-src'] = $image_url;

		}

		if ( $settings['lazy_load'] ) {
			$item_data['img_attributes']['data-lazy'] = $image_url;
			$item_data['img_attributes']['src']       = '';
		}

		return $item_data;

	}

	/**
	 * Set defaults
	 *
	 * @param $defaults
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function set_defaults( $defaults ) {

		$defaults['grid_type']             = '4';
		$defaults['grid_image_size']       = 'medium';
		$defaults['grid_image_crop']       = 0;
		$defaults['grid_image_dimensions'] = '1200';
		$defaults['grid_row_height']       = 150;
		$defaults['grid_justify_last_row'] = 'nojustify';

		return $defaults;
	}


	/**
	 * Grid sizer for columns
	 *
	 * @param $settings
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function modula_grid_sizer( $settings ) {
		if ( 'grid' == $settings['type'] && 'automatic' != $settings['grid_type'] ) {
			echo '<div class="modula-grid-sizer"> </div>';
		}
	}

	/**
	 * Generate Grid Css
	 *
	 * @param $css
	 * @param $gallery_id
	 * @param $settings
	 *
	 * @return string
	 *
	 * @since  2.3.0
	 */
	public function generate_grid_css( $css, $gallery_id, $settings ) {

		if ( 'grid' == $settings['type'] ) {

			$css .= "#{$gallery_id}.modula-gallery {width: " . $settings['width'] . "!important;}";

			if ( 'automatic' != $settings['grid_type'] ) {

				$css .= "#{$gallery_id}.modula-gallery .modula-item, .modula-gallery .modula-grid-sizer { width: " . 100 / $settings['grid_type'] . "%!important ; } ";

				if ( 1 == $settings['enable_responsive'] ) {
					$css .= "@media (max-width: 992px) { #{$gallery_id}.modula-gallery .modula-item, .modula-grid .modula-grid-sizer { width: " . 100 / $settings['tablet_columns'] . "%!important ; } }";

					$css .= "@media (max-width: 576px) { #{$gallery_id}.modula-gallery .modula-item, .modula-grid .modula-grid-sizer { width: " . 100 / $settings['mobile_columns'] . "%!important ; } }";

				}

				$css .= "#{$gallery_id}.modula-gallery .modula-item , #{$gallery_id}.modula-gallery .modula-items { padding-left: " . $settings['gutter'] . "px; padding-right: " . $settings['gutter'] . "px;  padding-top: " . $settings['gutter'] / 2 . "px; padding-bottom: " . $settings['gutter'] / 2 . "px;}";

				$css .= "#{$gallery_id} .modula-items{position:relative;}";

			}
		}

		return $css;
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Grid object.
	 *
	 * @since 2.3.0
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !( self::$instance instanceof Modula_Grid ) ) {
			self::$instance = new Modula_Grid();
		}

		return self::$instance;
	}

}

$modula_grid = Modula_Grid::get_instance();