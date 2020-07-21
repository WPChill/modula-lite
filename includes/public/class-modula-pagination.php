<?php


class Modula_Pagination {
	/**
	 * @since 2.3.4
	 * Modula_Pagination constructor.
	 *
	 */

	public static $instance;

	function __construct() {

		add_filter( 'modula_gallery_images', array( $this, 'images_per_page' ), 15, 2 );
		add_action( 'modula_shortcode_after_items', array( $this, 'navigation_links' ), 15, 3 );
	}

	/**
	 * Return the allowed images/page
	 *
	 * @param $images
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.3.4
	 */
	public function images_per_page( $images, $settings ) {

		$offset = 0;

		if ( isset( $_POST['offset'] ) ) {

			$offset = $_POST['offset'];
		}

		if ( isset( $settings['enable_pagination'] ) && '0' != $settings['enable_pagination'] && '0' != $settings['pagination_number'] ) {
			$images = array_slice( $images, $offset, absint( $settings['pagination_number'] ) );
		}

		return $images;
	}


	/**
	 * Output the navigation links
	 *
	 * @param $settings
	 * @param $item_data
	 * @param $images
	 *
	 * @since 2.3.4
	 */
	function navigation_links( $settings, $item_data, $images ) {
		if ( isset( $settings['enable_pagination'] ) && '0' != $settings['enable_pagination'] && '0' != $settings['pagination_number'] ) {
			echo 'something';
		}
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Pagination object.
	 *
	 * @since 2.2.7
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !(self::$instance instanceof Modula_Pagination) ) {
			self::$instance = new Modula_Pagination();
		}

		return self::$instance;
	}

}

$modula_pagination = Modula_Pagination::get_instance();