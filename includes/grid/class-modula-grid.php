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

		// Add grid settings to js config
		add_filter( 'modula_gallery_settings', array( $this, 'js_grid_config' ), 10, 2 );

		// Action for adding grid sizer
		add_action( 'modula_shortcode_before_items', array( $this, 'modula_grid_sizer' ), 10 );

		// Filter for $css
		add_filter( 'modula_shortcode_css', array( $this, 'generate_grid_css' ), 10, 3 );

		add_filter('modula_gallery_template_data',array($this,'template_data_config'),15,1);

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

				$css .= "#{$gallery_id}.modula-gallery .modula-item, .modula-gallery .modula-grid-sizer { width: calc(" . 100 / $settings['grid_type'] . "% - " . (absint( $settings['gutter'] ) - absint( $settings['gutter'] ) / absint( $settings['grid_type'] )) . "px) !important ; } ";

				if ( '1' == $settings['enable_responsive'] ) {
					$css .= "@media (max-width: 992px) { #{$gallery_id}.modula-gallery .modula-item, .modula-grid .modula-grid-sizer {width: calc(" . 100 / $settings['tablet_columns'] . "% - ". (absint( $settings['gutter'] ) - absint( $settings['gutter'] ) / absint( $settings['tablet_columns'])) ."px ) !important ; } }";

					$css .= "@media (max-width: 576px) { #{$gallery_id}.modula-gallery .modula-item, .modula-grid .modula-grid-sizer {width: calc(" . 100 / $settings['mobile_columns'] . "% - ". (absint( $settings['gutter'] ) - absint( $settings['gutter'] ) / absint( $settings['mobile_columns'])) ."px ) !important ; } }";

				}

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