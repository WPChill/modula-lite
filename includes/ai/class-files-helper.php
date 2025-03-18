<?php
namespace Modula\AI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Files_Helper {
	/** @var Files_Helper */
	private static $instance;

	/**
	 * Retrieves the singleton instance of the Files_Helper class.
	 *
	 * @return Files_Helper The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) || ! ( self::$instance instanceof Files_Helper ) ) {
			self::$instance = new Files_Helper();
		}

		return self::$instance;
	}

	/**
	 * Updates the filename of an attachment.
	 *
	 * @param int $attachment_id The attachment ID.
	 * @param string $new_filename The new filename.
	 * @return bool True if successful, false otherwise.
	 */
	public function update_filename( $attachment_id, $new_filename ) {
		if ( ! $new_filename ) {
			return false;
		}

		$metadata = wp_get_attachment_metadata( $attachment_id );
		if ( ! $metadata || ! isset( $metadata['file'] ) ) {
			return false;
		}

		$upload_directory_data = wp_get_upload_dir();
		$file_root_directories = explode( '/', $metadata['file'] );
		$old_filename          = end( $file_root_directories );
		$file_root             = str_replace( $old_filename, '', $metadata['file'] );
		$src                   = $upload_directory_data['basedir'] . '/' . $metadata['file'];

		if ( ! file_exists( $src ) ) {
			return false;
		}

		$new_metadata = $this->process_file_update( $attachment_id, $src, $old_filename, $new_filename, $metadata, $file_root, $upload_directory_data['basedir'] );
		if ( ! $new_metadata ) {
			return false;
		}

		return $this->finalize_update( $attachment_id, $new_metadata, $new_metadata['unique_new_filename'] );
	}

	/**
	 * Handles the processing of the file update, including renaming and metadata adjustment.
	 */
	private function process_file_update( $attachment_id, $src, $old_filename, $new_filename, $metadata, $file_root, $base_dir ) {
		$old_filename_without_extension = pathinfo( $old_filename, PATHINFO_FILENAME );
		$extension                      = pathinfo( $new_filename, PATHINFO_EXTENSION );
		$new_filename_without_extension = pathinfo( $new_filename, PATHINFO_FILENAME );

		// Find a unique filename in the target directory
		$unique_new_filename = $this->find_unique_filename( $base_dir . '/' . $file_root, $new_filename_without_extension, $extension );
		$destination         = $base_dir . '/' . $file_root . $unique_new_filename;

		$wp_filesystem = $this->get_wp_filesystem();
		if ( ! $wp_filesystem || ! $wp_filesystem->move( $src, $destination ) ) {
			return false;
		}

		$old_url = wp_get_attachment_url( $attachment_id );
		$new_url = str_replace( $old_filename_without_extension, pathinfo( $unique_new_filename, PATHINFO_FILENAME ), $old_url );

		$this->update_postmetas( $old_url, $new_url );
		$this->update_posts( $old_url, $new_url );

		// Update metadata for all sizes using the unique new filename
		$new_metadata                        = $metadata;
		$new_metadata['file']                = $file_root . $unique_new_filename; // Use the unique filename
		$new_metadata['unique_new_filename'] = $unique_new_filename;
		foreach ( $metadata['sizes'] as $key => $size ) {
			$src_by_size         = $base_dir . '/' . $file_root . $size['file'];
			$new_file_by_size    = str_replace( $old_filename_without_extension, pathinfo( $unique_new_filename, PATHINFO_FILENAME ), $size['file'] );
			$destination_by_size = $base_dir . '/' . $file_root . $new_file_by_size;

			$wp_filesystem = $this->get_wp_filesystem();
			if ( file_exists( $src_by_size ) && $wp_filesystem && $wp_filesystem->move( $src_by_size, $destination_by_size ) ) {
				$new_metadata['sizes'][ $key ]['file'] = $new_file_by_size;

				$old_url = wp_get_attachment_image_src( $attachment_id, $key )[0];
				$new_url = str_replace( $old_filename_without_extension, pathinfo( $unique_new_filename, PATHINFO_FILENAME ), $old_url );

				$this->update_postmetas( $old_url, $new_url );
				$this->update_posts( $old_url, $new_url );
			}
		}

		return $new_metadata;
	}

	/**
	 * Updates post meta to reflect the new image URLs.
	 */
	private function update_postmetas( $old_url, $new_url ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_value LIKE %s", $old_url, $new_url, '%' . $wpdb->esc_like( $old_url ) . '%' ) );
	}

	/**
	 * Updates posts to replace old image URLs with new ones.
	 */
	private function update_posts( $old_url, $new_url ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_content = REPLACE(post_content, %s, %s) WHERE post_content LIKE %s", $old_url, $new_url, '%' . $wpdb->esc_like( $old_url ) . '%' ) );
	}

	/**
	 * Finalizes the update process by updating the attachment metadata and file path.
	 */
	private function finalize_update( $attachment_id, $new_metadata, $new_filename_without_extension ) {
		// Store the original metadata and file path before updating
		$original_metadata  = wp_get_attachment_metadata( $attachment_id );
		$original_file_path = get_attached_file( $attachment_id );

		wp_update_attachment_metadata( $attachment_id, $new_metadata );
		update_attached_file( $attachment_id, $new_metadata['file'] );

		// Update the post title and slug based on the new filename
		wp_update_post(
			array(
				'ID'         => $attachment_id,
				'post_title' => $new_filename_without_extension,
				'post_name'  => sanitize_title( $new_filename_without_extension ),
			)
		);

		// Save the original metadata and file path as post meta for potential rollback
		update_post_meta( $attachment_id, '_old_wp_attachment_metadata', $original_metadata );
		update_post_meta( $attachment_id, '_old_wp_attached_file', $original_file_path );

		return true;
	}

	/**
	 * Finds a unique filename by appending a numeric suffix if the original filename already exists.
	 *
	 * @param string $directory The directory to check in.
	 * @param string $filename The initial filename to check.
	 * @param string $extension The file extension.
	 * @return string Returns a unique filename with numeric suffix if necessary.
	 */
	private function find_unique_filename( $directory, $filename, $extension ) {
		$base_filename = $filename;
		$i             = 1;

		// Check if the full filename exists, and append a suffix until it doesn't
		while ( file_exists( $directory . '/' . $filename . '.' . $extension ) ) {
			$filename = $base_filename . '-' . $i;
			++$i;
		}

		return $filename . '.' . $extension;
	}

	/**
	 * Gets the WordPress filesystem object.
	 *
	 * @return object|false The WordPress filesystem object or false if not available.
	 */
	private function get_wp_filesystem() {
		global $wp_filesystem;
		if ( ! $wp_filesystem ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}
		return $wp_filesystem;
	}
}
