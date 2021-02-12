<?php

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Ajax_Migrator {

	/**
	 * Holds the class object.
	 *
	 * @since 2.3.3
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Primary class constructor.
	 *
	 * @since 2.3.3
	 */
	public function __construct() {

		add_action( 'wp_ajax_modula_ajax_import_images', array( $this, 'ajax_import_images' ) );
	}

	/**
	 * Import chunks of images at a time
	 *
	 * @return bool
	 */
	public function ajax_import_images() {

		check_ajax_referer( 'modula-importer', 'nonce' );

		// Exit if no id
		if ( !isset( $_POST['id'] ) ) {
			return false;
		}

		// Exit if no source
		if ( !isset( $_POST['source'] ) ) {
			return false;
		}

		$source          = $_POST['source'];
		$response        = array();
		$gallery_id      = absint( $_POST['id'] );
		$chunk           = absint( $_POST['chunk'] );
		$modula_importer = Modula_Importer::get_instance();
		// Get the images
		$images = $modula_importer->prepare_images( $source, $gallery_id );
		// Initialize $images variable
		$attachments = array();
		// we slice the images in chunks so that the AJAX will do the rest
		$images = array_slice( $images, $chunk, 5 );

		if ( is_array( $images ) && count( $images ) > 0 ) {
			// Exit if plugin that uses media library for images
			if ( in_array( $source, apply_filters( 'modula_ajax_migrated_galleries', array( 'nextgen' ) ) ) ) {

				global $wpdb;
				// Add each image to Media Library
				foreach ( $images as $image ) {
					// Store image in WordPress Media Library
					switch ( $source ) {
						case 'nextgen':
							$sql        = $wpdb->prepare( "SELECT path, title, galdesc, pageid 
    						FROM " . $wpdb->prefix . "ngg_gallery
    						WHERE gid = %d
    						LIMIT 1", $gallery_id );
							$gallery    = $wpdb->get_row( $sql );
							$attachment = $this->add_image_to_library( $gallery->path, $image->filename, $image->description, $image->alttext );
							break;
					}

					if ( $attachment !== false ) {
						// Add to array of attachments
						$attachments[] = $attachment;
					}
				}
			}

			$response['attachments'] = $attachments;

			// If array smaller than 5 we reached the end of the array
			if ( count( $images ) < 5 ) {
				$response['end_of_array'] = 'end_of_array';
			}

		} else {
			// If there are no images in the array we reached the end of it
			$response['end_of_array'] = 'end_of_array';
		}

		echo json_encode( $response );
		wp_die();

	}


	/**
	 * Add image to library
	 *
	 * @param $source_path
	 * @param $source_file
	 * @param $description
	 * @param $alt
	 *
	 * @return mixed
	 *
	 * @since 2.3.3
	 */
	public function add_image_to_library( $source_path, $source_file, $description, $alt ) {

		global $wpdb;
		$sql = $wpdb->prepare(
			"SELECT * FROM $wpdb->posts WHERE guid LIKE %s",
			'%/' . $source_file
		);

		$queried = $wpdb->get_results( $sql );

		if ( count( $queried ) > 0 ) {
			return array(
				'ID'      => $queried[0]->ID,
				'title'   => $queried[0]->post_title,
				'alt'     => get_post_meta( $queried[0]->ID, '_wp_attachment_image_alt', true ),
				'caption' => $queried[0]->post_content
			);
		}

		// Get full path and filename
		// Seems like in some scenarios the $sourche_path contains the ABSPATH also
		if ( strpos( $source_path, ABSPATH ) !== false ){
			$source_file_path = $source_path . '/' . $source_file;
		} else {
			$source_file_path = ABSPATH . $source_path . '/' . $source_file;
		}

		// Get WP upload dir
		$uploadDir = wp_upload_dir();

		// Create destination file paths and URLs
		$destination_file      = wp_unique_filename( $uploadDir['path'], $source_file );
		$destination_file_path = $uploadDir['path'] . '/' . $destination_file;
		$destination_url       = $uploadDir['url'] . '/' . $destination_file;

		// Check file is valid
		$wp_filetype = wp_check_filetype( $source_file, null );
		extract( $wp_filetype );

		if ( (!$type || !$ext) && !current_user_can( 'unfiltered_upload' ) ) {
			return false;
		}

		$result = copy( $source_file_path, $destination_file_path );

		if ( !$result ) {

			return false;
		}

		// Set file permissions
		$stat  = stat( $destination_file_path );
		$perms = $stat['mode'] & 0000666;
		chmod( $destination_file_path, $perms );

		// Apply upload filters
		$return = apply_filters( 'wp_handle_upload', array(
			'file' => $destination_file_path,
			'url'  => $destination_url,
			'type' => $type,
		) );

		// Construct the attachment array
		$attachment = array(
			'post_mime_type' => sanitize_text_field( $type ),
			'guid'           => esc_url_raw( $destination_url ),
			'post_title'     => sanitize_text_field( $alt ),
			'post_name'      => sanitize_text_field( $alt ),
			'post_content'   => wp_filter_post_kses( $description ),
		);

		// Save as attachment
		$attachmentID = wp_insert_attachment( $attachment, $destination_file_path );

		// Update attachment metadata
		if ( !is_wp_error( $attachmentID ) ) {
			$metadata = wp_generate_attachment_metadata( $attachmentID, $destination_file_path );
			wp_update_attachment_metadata( $attachmentID, wp_generate_attachment_metadata( $attachmentID, $destination_file_path ) );
		}

		update_post_meta( $attachmentID, '_wp_attachment_image_alt', $alt );
		$attachment               = get_post( $attachmentID );
		$attachment->post_excerpt = $description;
		wp_update_post( $attachment );

		// Return attachment data
		return array(
			'ID'      => $attachmentID,
			'src'     => $destination_url,
			'title'   => $alt,
			'alt'     => $alt,
			'caption' => $description,
		);

	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Importer object.
	 *
	 * @since 2.3.3
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !(self::$instance instanceof Modula_Ajax_Migrator) ) {
			self::$instance = new Modula_Ajax_Migrator();
		}

		return self::$instance;
	}
}

$modula_ajax_migrator = Modula_Ajax_Migrator::get_instance();