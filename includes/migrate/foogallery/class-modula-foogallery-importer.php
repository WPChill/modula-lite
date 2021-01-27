<?php
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Foogallery_Importer {

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
	 * @since 1.0.0
	 */
	public function __construct() {

		// Add AJAX
		add_action( 'wp_ajax_modula_importer_foogallery_gallery_import', array( $this, 'foogallery_gallery_import' ) );
		add_action( 'wp_ajax_modula_importer_foogallery_gallery_imported_update', array( $this, 'update_imported' ) );

	}


	/**
	 * Get all FooGallery Galleries
	 *
	 * @return mixed
	 *
	 * @since 2.2.7
	 */
	public function get_galleries() {

		global $wpdb;

		$galleries       = $wpdb->get_results( " SELECT * FROM " . $wpdb->prefix . "posts WHERE post_type = 'foogallery' AND post_status = 'publish'" );
		$empty_galleries = array();

		if ( count( $galleries ) != 0 ) {
			foreach ( $galleries as $key => $gallery ) {
				$count = $this->images_count( $gallery->ID );

				if ( $count == 0 ) {
					unset( $galleries[$key] );
					$empty_galleries[$key] = $gallery;
				}
			}

			if ( count( $galleries ) != 0 ) {
				$return_galleries['valid_galleries'] = $galleries;
			}
			if ( count( $empty_galleries ) != 0 ) {
				$return_galleries['empty_galleries'] = $empty_galleries;
			}

			if ( count( $return_galleries ) != 0 ) {
				return $return_galleries;
			}
		}

		return false;
	}


	/**
	 * Get gallery image count
	 *
	 * @param $id
	 *
	 * @return int
	 *
	 * @since 2.2.7
	 */
	public function images_count( $id ) {

		$images = get_post_meta( $id, 'foogallery_attachments', true );
		$count  = count( $images );

		return $count;
	}

	/**
	 * Imports a gallery from FooGallery to Modula
	 *
	 * @param string $gallery_id
	 *
	 * @since 2.2.7
	 */
	public function foogallery_gallery_import( $gallery_id = '' ) {

		global $wpdb;
		$modula_importer = Modula_Importer::get_instance();

		// Set max execution time so we don't timeout
		ini_set( 'max_execution_time', 0 );
		set_time_limit( 0 );

		// If no gallery ID, get from AJAX request
		if ( empty( $gallery_id ) ) {

			// Run a security check first.
			check_ajax_referer( 'modula-importer', 'nonce' );

			if ( !isset( $_POST['id'] ) ) {
				$this->modula_import_result( false, esc_html__( 'No gallery was selected', 'modula-best-grid-gallery' ), false );
			}

			$gallery_id = absint( $_POST['id'] );

		}

		$imported_galleries = get_option( 'modula_importer' );
		// If already migrated don't migrate

		if ( isset( $imported_galleries['galleries']['foogallery'][$gallery_id] ) ) {

			$modula_gallery = get_post_type( $imported_galleries['galleries']['foogallery'][$gallery_id] );

			if ( 'modula-gallery' == $modula_gallery ) {
				// Trigger delete function if option is set to delete
				if ( isset( $_POST['clean'] ) && 'delete' == $_POST['clean'] ) {
					$this->clean_entries( $gallery_id );
				}
				$this->modula_import_result( false, esc_html__( 'Gallery already migrated!', 'modula-best-grid-gallery' ), false );
			}
		}


		// Get all images attached to the gallery
		$modula_images = array();

		// get gallery data so we can get title, description and alt from FooGallery
		$foogallery_gallery_data          = $modula_importer->prepare_images( 'foogallery', $gallery_id );
		$foogallery_settings              = get_post_meta( $gallery_id, '_foogallery_settings', true );
		$foogallery_template              = get_post_meta( $gallery_id, 'foogallery_template', true );
		$foogallery_settings['grid_type'] = $foogallery_template;

		if ( isset( $foogallery_gallery_data ) && count( $foogallery_gallery_data ) > 0 ) {
			foreach ( $foogallery_gallery_data as $imageID ) {

				$image                    = get_post( $imageID );
				$foogallery_image_title   = (!isset( $image->post_title ) || '' != $image->post_title) ? $image->post_title : '';
				$foogallery_image_caption = (!isset( $image->post_content ) || '' != $image->post_content) ? $image->post_content : wp_get_attachment_caption( $imageID );
				$foogallery_image_alt     = get_post_meta( $imageID, '_wp_attachment_image_alt', TRUE );
				$foogallery_image_url     = (get_post_meta( $imageID, '_foogallery_custom_url', TRUE )) ? get_post_meta( $imageID, '_foogallery_custom_url', TRUE ) : '';
				$target                   = (get_post_meta( $imageID, '_foogallery_custom_target', TRUE ) && '_blank' == get_post_meta( $imageID, '_foogallery_custom_target', TRUE )) ? 1 : 0;
				$image_url                = wp_get_attachment_url( $imageID );

				if ( $foogallery_image_url == $image_url ) {
					$foogallery_image_url = '';
				}

				$modula_images[] = apply_filters( 'modula_migrate_image_data', array(
					'id'          => absint( $imageID ),
					'alt'         => sanitize_text_field( $foogallery_image_alt ),
					'title'       => sanitize_text_field( $foogallery_image_title ),
					'description' => wp_filter_post_kses( $foogallery_image_caption ),
					'halign'      => 'center',
					'valign'      => 'middle',
					'link'        => esc_url_raw( $foogallery_image_url ),
					'target'      => absint( $target ),
					'width'       => 2,
					'height'      => 2,
					'filters'     => ''
				), $image, $foogallery_settings, 'foogallery' );
			}
		}

		if ( count( $modula_images ) == 0 ) {
			// Trigger delete function if option is set to delete
			if ( isset( $_POST['clean'] ) && 'delete' == $_POST['clean'] ) {
				$this->clean_entries( $gallery_id );
			}
			$this->modula_import_result( false, esc_html__( 'No images found in gallery. Skipping gallery...', 'modula-best-grid-gallery' ), false );
		}

		$grid             = 'grid';
		$last_row_align   = 'center';
		$grid_type        = 'automatic';
		$gutter           = 10;
		$thumbnail_size   = 300;
		$grid_image_size  = 'medium';
		$thumbnail_size_w = '640';
		$thumbnail_size_h = '480';

		switch ( $foogallery_template ) {
			case 'default':
				$gutter           = $foogallery_settings['default_spacing'];
				$thumbnail_size_w = $foogallery_settings['default_thumbnail_dimensions']['width'];
				$thumbnail_size_h = $foogallery_settings['default_thumbnail_dimensions']['height'];
				$grid_image_size  = 'custom';
				break;
			case 'image-viewer':
				$grid             = 'creative-gallery';
				$thumbnail_size_w = $foogallery_settings['image-viewer_thumbnail_size']['width'];
				$thumbnail_size_h = $foogallery_settings['image-viewer_thumbnail_size']['height'];
				$grid_image_size  = 'custom';
				break;
			case 'justified':
				$gutter = $foogallery_settings['justified_margins'];
				break;
			case 'masonry':
				if ( 'fixed' != $foogallery_settings['masonry_layout'] ) {
					$grid_type = $foogallery_settings['masonry_layout'];
				}
				$thumbnail_size = $foogallery_settings['masonry_thumbnail_width'];
				if ( isset( $foogallery_settings['masonry_layout'] ) && 'fixed' == $foogallery_settings['masonry_layout'] ) {
					$gutter = $foogallery_settings['masonry_gutter_width'];
				}
				break;
			case 'simple_portfolio':
				$thumbnail_size_w = $foogallery_settings['simple_portfolio_thumbnail_dimensions']['width'];
				$thumbnail_size_h = $foogallery_settings['simple_portfolio_thumbnail_dimensions']['height'];
				$grid_image_size  = 'custom';
				break;
			case 'thumbnail':
				$thumbnail_size = $foogallery_settings['thumbnail_thumbnail_dimensions']['width'];
				break;
		}

		if ( isset( $foogallery_settings['justified_last_row'] ) && 'hide' != $foogallery_settings['justified_last_row'] ) {
			$last_row_align = $foogallery_settings['justified_last_row'];
		}

		if ( isset( $foogallery_settings['masonry_layout'] ) && 'fixed' != $foogallery_settings['masonry_layout'] ) {
			$grid_type = str_replace( 'col', '', $foogallery_settings['masonry_layout'] );
		}

		$modula_settings = apply_filters( 'modula_migrate_gallery_data', array(
			'type'                  => $grid,
			'grid_type'             => sanitize_text_field( $grid_type ),
			'gutter'                => absint( $gutter ),
			'grid_row_height'       => ( isset( $foogallery_settings['justified_row_height'] ) ) ? absint( $foogallery_settings['justified_row_height'] ) : '150',
			'grid_justify_last_row' => sanitize_text_field( $last_row_align ),
			'lazy_load'             => ( isset( $foogallery_settings['default_lazyload'] ) && 'disabled' != $foogallery_settings['default_lazyload'] ),
			'grid_image_size'       => sanitize_text_field( $grid_image_size ),
			'grid_image_dimensions' => array(
				'width'  => ( isset( $thumbnail_size ) ) ? sanitize_text_field( $thumbnail_size ) : sanitize_text_field( $thumbnail_size_w ),
				'height' => sanitize_text_field( $thumbnail_size_h )
			)
		), $foogallery_settings, 'foogallery' );

		// Get Modula Gallery defaults, used to set modula-settings metadata
		$modula_settings = wp_parse_args( $modula_settings, Modula_CPT_Fields_Helper::get_defaults() );

		// Create Modula CPT
		$modula_gallery_id = wp_insert_post(
			array(
				'post_type'   => 'modula-gallery',
				'post_status' => 'publish',
				'post_title'  => sanitize_text_field( get_the_title( $gallery_id ) ),
			)
		);

		// Attach meta modula-settings to Modula CPT
		update_post_meta( $modula_gallery_id, 'modula-settings', $modula_settings );
		// Attach meta modula-images to Modula CPT
		update_post_meta( $modula_gallery_id, 'modula-images', $modula_images );

		$foogallery_shortcodes = '[foogallery id="' . $gallery_id . '"]';
		$modula_shortcode      = '[modula id="' . $modula_gallery_id . '"]';

		// Replace Foogallery id shortcode with Modula Shortcode in Posts, Pages and CPTs
		$sql = $wpdb->prepare( "UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content, '%s', '%s')",
		                       $foogallery_shortcodes, $modula_shortcode );
		$wpdb->query( $sql );

		// Trigger delete function if option is set to delete
		if ( isset( $_POST['clean'] ) && 'delete' == $_POST['clean'] ) {
			$this->clean_entries( $gallery_id );
		}

		$this->modula_import_result( true, wp_kses_post( '<i class="imported-check dashicons dashicons-yes"></i>' ), $modula_gallery_id );
	}

	/**
	 * Update imported galleries
	 *
	 *
	 * @since 2.2.7
	 */
	public function update_imported() {

		check_ajax_referer( 'modula-importer', 'nonce' );

		$galleries = $_POST['galleries'];

		$importer_settings = get_option( 'modula_importer' );

		// first check if array
		if ( !is_array( $importer_settings ) ) {
			$importer_settings = array();
		}

		if ( !isset( $importer_settings['galleries']['foogallery'] ) ) {
			$importer_settings['galleries']['foogallery'] = array();
		}

		if ( is_array( $galleries ) && count( $galleries ) > 0 ) {
			foreach ( $galleries as $key => $value ) {
				$importer_settings['galleries']['foogallery'][absint( $key )] = absint( $value );
			}
		}

		// Remember that this gallery has been imported
		update_option( 'modula_importer', $importer_settings );

		// Set url for migration complete
		$url = admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=importer&migration=complete' );

		if ( isset( $_POST['clean'] ) && 'delete' == $_POST['clean'] ) {
			// Set url for migration and cleaning complete
			$url = admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=importer&migration=complete&delete=complete' );
		}

		echo $url;
		wp_die();
	}

	/**
	 * Returns result
	 *
	 * @param $success
	 * @param $message
	 * @param $gallery_id
	 *
	 * @since 2.2.7
	 */
	public function modula_import_result( $success, $message, $gallery_id = false ) {
		echo json_encode( array(
			                  'success'           => (bool)$success,
			                  'message'           => (string)$message,
			                  'modula_gallery_id' => $gallery_id
		                  ) );
		die;
	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @since 2.2.7
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !(self::$instance instanceof Modula_Foogallery_Importer) ) {
			self::$instance = new Modula_Foogallery_Importer();
		}

		return self::$instance;

	}

	/**
	 * Delete old entries from database
	 *
	 * @param $gallery_id
	 *
	 * @since 2.2.7
	 */
	public function clean_entries( $gallery_id ) {
		global $wpdb;
		$sql      = $wpdb->prepare( "DELETE FROM  $wpdb->posts WHERE ID = $gallery_id" );
		$sql_meta = $wpdb->prepare( "DELETE FROM  $wpdb->postmeta WHERE post_id = $gallery_id" );
		$wpdb->query( $sql );
		$wpdb->query( $sql_meta );
	}

}

// Load the class.
$modula_foogallery_importer = Modula_Foogallery_Importer::get_instance();