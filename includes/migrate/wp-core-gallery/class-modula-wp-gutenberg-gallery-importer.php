<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_WP_Gutenberg_Gallery_Importer {

	/**
	 * Holds the class object.
	 *
	 * @var object
	 *
	 * @since 2.2.7
	 */
	public static $instance;

	/**
	 * Primary class constructor.
	 *
	 * @since 2.2.7
	 */
	public function __construct() {

		// Add AJAX
		add_action( 'wp_ajax_modula_importer_wp_gutenberg_gallery_import', array( $this, 'wp_core_gallery_import' ) );
	}

	/**
	 * Get all posts/pages that have wp core galleries
	 *
	 * @return mixed
	 *
	 * @since 2.2.7
	 */
	public function get_gutenberg_galleries() {
		global $wpdb;
		$return_galleries = array();

		$post_types = get_post_types(
			array(
				'show_in_menu' => true,
				'public'       => true,
			)
		);

		$post_in = implode( "','", $post_types );
		$sql     = $wpdb->prepare( "SELECT ID, post_title, post_content FROM {$wpdb->posts} WHERE post_type IN ('$post_in') AND post_content LIKE %s", '%wp:gallery%' );
		$posts   = $wpdb->get_results( $sql );

		if ( ! empty( $posts ) ) {
			$i = 1;
			foreach ( $posts as $post ) {
				$content = $post->post_content;

				// RegEx pentru a găsi blocurile de galerie Gutenberg
				preg_match_all( '/<!-- wp:gallery[\s\S]*?<!-- \/wp:gallery -->/', $content, $gallery_blocks );

				if ( ! empty( $gallery_blocks[0] ) ) {
					foreach ( $gallery_blocks[0] as $gallery_block ) {
						// RegEx pentru a extrage fiecare imagine din galerie
						preg_match_all( '/"id":(\d+)/', $gallery_block, $image_ids );

						if ( ! empty( $image_ids[1] ) ) {
							$return_galleries[ $i ] = array(
								'title'     => '#' . $i . ' from ' . $post->post_title,
								'images'    => count( $image_ids[1] ),
								'image_ids' => $image_ids[1],
								'page_id'   => $post->ID,
								'gal_nr'    => $i,
							);
							++$i;
						}
					}
				}
			}
		}

		return ! empty( $return_galleries ) ? array( 'valid_galleries' => $return_galleries ) : false;
	}



	/**
	 * Replace WP Core gallery and create Modula gallery
	 *
	 * @param array $galery_atts
	 *
	 * @since 2.2.7
	 */
	public function wp_core_gallery_import( $gallery_atts = array() ) {
		global $wpdb;
		$modula_importer = Modula_Importer::get_instance();

		// Set max execution time so we don't timeout
		ini_set( 'max_execution_time', 0 );
		set_time_limit( 0 );

		// Dacă nu avem parametrii, luăm datele din AJAX
		if ( empty( $gallery_atts ) ) {
			check_ajax_referer( 'modula-importer', 'nonce' );

			if ( ! isset( $_POST['id'] ) ) {
				$this->modula_import_result( false, esc_html__( 'No gallery data received', 'modula-best-grid-gallery' ) );
			}

			$post_data    = json_decode( wp_unslash( $_POST['id'] ), true );
			$gallery_atts = array(
				'id'        => absint( $post_data['id'] ),
				'image_ids' => array_map( 'absint', $post_data['image_ids'] ),
			);
		}

		if ( empty( $gallery_atts['image_ids'] ) ) {
			$this->modula_import_result( false, esc_html__( 'No images found in gallery', 'modula-best-grid-gallery' ) );
		}

		$modula_images = array();
		foreach ( $gallery_atts['image_ids'] as $image ) {
			$img = get_post( $image );
			if ( $img ) {
				$modula_images[] = array(
					'id'          => absint( $image ),
					'alt'         => sanitize_text_field( get_post_meta( $image, '_wp_attachment_image_alt', true ) ),
					'title'       => sanitize_text_field( $img->post_title ),
					'description' => wp_filter_post_kses( $img->post_content ),
					'halign'      => 'center',
					'valign'      => 'middle',
					'link'        => '',
					'target'      => '',
					'width'       => 2,
					'height'      => 2,
					'filters'     => '',
				);
			}
		}

		if ( count( $modula_images ) == 0 ) {
			$this->modula_import_result( false, esc_html__( 'No valid images found in gallery', 'modula-best-grid-gallery' ) );
		}

		// Setează metadatele Modula Gallery
		$modula_settings = Modula_CPT_Fields_Helper::get_defaults();

		// Creează galeria Modula
		$modula_gallery_id = wp_insert_post(
			array(
				'post_type'   => 'modula-gallery',
				'post_status' => 'publish',
				'post_title'  => isset( $_POST['gallery_title'] ) ? sanitize_text_field( $_POST['gallery_title'] ) : '',
			)
		);

		// Atașează metadatele
		update_post_meta( $modula_gallery_id, 'modula-settings', $modula_settings );
		update_post_meta( $modula_gallery_id, 'modula-images', $modula_images );

		$this->modula_import_result( true, wp_kses_post( '<i class="imported-check dashicons dashicons-yes"></i>' ) );
	}

	/**
	 * Returns result
	 *
	 * @param $success
	 * @param $message
	 *
	 * @since 2.2.7
	 */
	public function modula_import_result( $success, $message ) {
		echo json_encode(
			array(
				'success' => (bool) $success,
				'message' => (string) $message,
			)
		);
		die;
	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @since 2.2.7
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_WP_Gutenberg_Gallery_Importer ) ) {
			self::$instance = new Modula_WP_Gutenberg_Gallery_Importer();
		}

		return self::$instance;
	}
}

// Load the class.
$wp_core_importer = Modula_WP_Gutenberg_Gallery_Importer::get_instance();
