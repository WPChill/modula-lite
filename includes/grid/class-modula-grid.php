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

		add_filter('modula_gallery_template_data',array($this,'template_data_config'),15,1);

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
	 * Add grid-gallery class to modula-items container
	 *
	 * @param $template_data
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function template_data_config($template_data){

		$settings = $template_data['settings'];

		if('grid' == $settings['type']){
			$template_data['items_container']['class'][] = 'grid-gallery';
		}

		return $template_data;
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

			if ( 'automatic' != $settings['grid_type'] ) {

				$css .= "#{$gallery_id}.modula-gallery .modula-item, .modula-gallery .modula-grid-sizer { width: calc(" . 100 / $settings['grid_type'] . "% - ". absint($settings['gutter']) ."px) !important ; } ";

				if ( 1 == $settings['enable_responsive'] ) {
					$css .= "@media (max-width: 992px) { #{$gallery_id}.modula-gallery .modula-item, .modula-grid .modula-grid-sizer { width: " . 100 / $settings['tablet_columns'] . "%!important ; } }";

					$css .= "@media (max-width: 576px) { #{$gallery_id}.modula-gallery .modula-item, .modula-grid .modula-grid-sizer { width: " . 100 / $settings['mobile_columns'] . "%!important ; } }";

				}

				// $css .= "#{$gallery_id}.modula-gallery .modula-item , #{$gallery_id}.modula-gallery .modula-items {margin-bottom:".$settings['gutter']."px;}";

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