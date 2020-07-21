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
		add_action( 'modula_shortcode_after_items', array( $this, 'navigation_links' ), 15, 2 );
		add_action( 'wp_ajax_modula_pagination', array( $this, 'images_per_page' ) );
		add_action( 'wp_ajax_nopriv_modula_pagination', array( $this, 'images_per_page' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'localized_scripts' ) );
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

		$offset     = 0;
		$pagination = count( $images );

		if ( !isset( $_POST ) || empty( $_POST ) ) {

			if ( !isset( $settings['enable_pagination'] ) || '0' == $settings['enable_pagination'] ) {
				return $images;
			}

			if ( isset( $settings['pagination_number'] ) && '0' != $settings['pagination_number'] ) {
				$pagination = absint( $settings['pagination_number'] );
			}
		} else {

			check_ajax_referer( 'modula-pagination', 'nonce' );

			if ( isset( $_POST['page'] ) ) {
				$offset     = absint( $_POST['page'] ) * absint( $_POST['pagination'] );
				$pagination = $offset + $pagination;
			}
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

		$images = get_post_meta( str_replace( 'jtg-', '', $settings['gallery_id'] ), 'modula-images', true );
		$html   = '';

		if ( isset( $settings['enable_pagination'] ) && '0' != $settings['enable_pagination'] && '0' != $settings['pagination_number'] ) {
			$pagination = $settings['pagination_number'];
			$image_nr   = count( $images );
			$page_num   = ceil( $image_nr / $pagination );

			$html .= '<div class="modula-navigation"><ul class="modula-links-wrapper">';

			for ( $i = 1; $i <= $page_num; $i++ ) {
				$html .= '<li data-offset="' . esc_attr( $i ) . '">' . absint( $i ) . '</li>';
			}

			$html .= '</ul></div>';
		}

		echo $html;
	}

	/**
	 * Enqueue and localization of scripts
	 */
	public function localized_scripts() {
		wp_localize_script( 'modula', 'paginationHelper', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'modula-pagination' )
		) );
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