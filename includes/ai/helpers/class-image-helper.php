<?php
namespace Modula\Ai\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image_Helper {
	/**
	 * Update media library images in batch from gallery image data
	 *
	 * @param array $images Array of gallery images
	 * @return void
	 */
	public static function batch_update_images( $images ) {
		global $wpdb;

		if ( empty( $images ) ) {
			return;
		}

		$post_updates = array();
		$meta_updates = array();

		foreach ( $images as $image ) {
			if ( ! isset( $image['id'] ) ) {
				continue;
			}

			$title       = isset( $image['title'] ) ? $image['title'] : '';
			$description = isset( $image['description'] ) ? $image['description'] : '';

			// Update post data (title, caption, description)
			$post_updates[] = $wpdb->prepare(
				'(%d, %s, %s, %s)',
				$image['id'],
				$title,
				$description,
				$description
			);

			// Update alt text
			if ( isset( $image['alt'] ) ) {
				// First delete any existing meta for this key to prevent duplicates
				$meta_updates[] = $wpdb->prepare(
					"DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_wp_attachment_image_alt'",
					$image['id']
				);
				// Then add the new meta value
				$meta_updates[] = $wpdb->prepare(
					"INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) VALUES (%d, '_wp_attachment_image_alt', %s)",
					$image['id'],
					$image['alt']
				);
			}
		}

		if ( ! empty( $post_updates ) ) {
			$query = "INSERT INTO {$wpdb->posts} (ID, post_title, post_excerpt, post_content) VALUES " .
					implode( ',', $post_updates ) .
					' ON DUPLICATE KEY UPDATE post_title = VALUES(post_title), 
					post_excerpt = VALUES(post_excerpt), 
					post_content = VALUES(post_content)';
			//phpcs:ignore WordPress.DB
			$wpdb->query( $query );
		}

		if ( ! empty( $meta_updates ) ) {
			// Execute each meta update query separately since we're doing DELETE + INSERT
			foreach ( $meta_updates as $query ) {
				//phpcs:ignore WordPress.DB
				$wpdb->query( $query );
			}
		}

		// Clean post cache for all updated images
		foreach ( $images as $image ) {
			if ( isset( $image['id'] ) ) {
				clean_post_cache( $image['id'] );
			}
		}
	}
}
