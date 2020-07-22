<?php


class Modula_Pagination {
	/**
	 * @since 2.3.4
	 * Modula_Pagination constructor.
	 *
	 */

	public static $instance;

	function __construct() {

		add_filter( 'modula_gallery_images', array( $this, 'images_per_page' ), 999, 2 );
		add_action( 'modula_shortcode_after_items', array( $this, 'navigation_links' ), 15, 2 );
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

		if ( !isset( $settings['enable_pagination'] ) || '0' == $settings['enable_pagination'] ) {
			return $images;
		}

		$offset     = 0;
		$pagination = count( $images );

		if ( isset( $_GET['modula-page'] ) ) {
			$offset = absint( $_GET['modula-page'] ) - 1;
		}

		if ( isset( $settings['pagination_number'] ) && '0' != $settings['pagination_number'] ) {
			$offset     = $offset * absint( $settings['pagination_number'] );
			$pagination = absint( $settings['pagination_number'] );
		}

		$images = array_slice( $images, $offset, $pagination );

		return $images;

	}

	/**
	 * Output the navigation links
	 *
	 * @param $settings
	 * @param $item_data
	 *
	 * @since 2.3.4
	 */
	function navigation_links( $settings, $item_data ) {

		$images = apply_filters( 'modula_pagination_links', get_post_meta( str_replace( 'jtg-', '', $settings['gallery_id'] ), 'modula-images', true ), $settings );

		$html = '';

		if ( isset( $settings['enable_pagination'] ) && '0' != $settings['enable_pagination'] && '0' != $settings['pagination_number'] ) {
			$pagination = $settings['pagination_number'];
			$image_nr   = count( $images );
			$page_num   = ceil( $image_nr / $pagination );

			$html   .= '<div class="modula-navigation"><ul class="modula-links-wrapper">';
			$offset = 1;

			if ( isset( $_GET['modula-page'] ) ) {
				$offset = absint( $_GET['modula-page'] );
			}

			for ( $i = 1; $i <= $page_num; $i++ ) {

				$html .= '<li><a href="' . esc_url( '?modula-page=' . $i ) . '" class="' . ($offset == $i ? 'selected' : '') . '">' . absint( $i ) . '</a></li>';
			}

			$html .= '</ul></div>';
		}

		echo $html;
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Pagination object.
	 *
	 * @since 2.3.4
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !(self::$instance instanceof Modula_Pagination) ) {
			self::$instance = new Modula_Pagination();
		}

		return self::$instance;
	}

}

$modula_pagination = Modula_Pagination::get_instance();