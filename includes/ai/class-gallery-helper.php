<?php
namespace Modula\Ai;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gallery_Helper {
	/**
	 * Class instance.
	 *
	 * @var Gallery_Helper
	 */
	private static $instance;

	/**
	 * Gets the singleton instance of the Gallery_Helper class.
	 *
	 * Ensures only one instance of Gallery_Helper exists at a time by implementing
	 * the singleton pattern.
	 *
	 * @return Gallery_Helper The single instance of the Gallery_Helper class
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) || ! ( self::$instance instanceof Gallery_Helper ) ) {
			self::$instance = new Gallery_Helper();
		}

		return self::$instance;
	}

	/**
	 * Gets the image IDs from a Modula gallery.
	 *
	 * Retrieves all image IDs from a gallery's metadata, filtering out any video entries.
	 * Used to get a clean list of just the image attachments in a gallery.
	 *
	 * @param int $post_id The ID of the gallery post
	 * @return array Array of image attachment IDs from the gallery
	 */
	public function get_image_ids_for_gallery( $post_id ) {
		$gallery = get_post_meta( $post_id, 'modula-images', true );
		$ids     = array();
		if ( ! empty( $gallery ) ) {
			foreach ( $gallery as $image ) {
				// skip videos
				if ( strpos( $image['id'], 'video_' ) !== false ) {
					continue;
				}

				$ids[] = $image['id'];
			}
		}
		return $ids;
	}

	/**
	 * Generates a report about the images in a gallery.
	 *
	 * Analyzes a gallery's images and returns statistics about alt text and ImageSEO usage.
	 * Counts total images, images with/without alt text, and images processed by ImageSEO.
	 *
	 * @param int $post_id The ID of the gallery post
	 * @return array {
	 *     Array containing gallery image statistics
	 *
	 *     @type int      $total_images           Total number of valid images in gallery
	 *     @type int      $images_with_alt        Number of images that have alt text
	 *     @type int      $images_without_alt     Number of images missing alt text
	 *     @type int      $images_with_ai   Number of images processed by ImageSEO
	 *     @type array    $images_without_alt_ids IDs of images missing alt text
	 *     @type array    $all_image_ids         Array of all valid image IDs
	 *     @type string   $status                Current ImageSEO optimization status
	 *     @type int      $timestamp             Unix timestamp of report generation
	 * }
	 */
	public function get_gallery_report( $post_id ) {
		$images                 = $this->get_image_ids_for_gallery( $post_id );
		$total_images           = count( array_filter( $images ) );
		$images_with_alt        = 0;
		$images_without_alt     = 0;
		$images_without_alt_ids = array();
		$images_with_ai         = 0;
		$status                 = get_option( 'modula_ai_optimizer_status_' . $post_id, 'idle' );
		foreach ( $images as $id ) {
			if ( empty( $id ) ) {
				continue;
			}
			$alt_text        = get_post_meta( $id, '_wp_attachment_image_alt', true );
			$imageseo_report = get_post_meta( $id, '_modula_ai_report', true );

			if ( ! empty( $alt_text ) ) {
				++$images_with_alt;
				if ( ! empty( $imageseo_report ) ) {
					++$images_with_ai;
				}
			} else {
				++$images_without_alt;
				$images_without_alt_ids[] = $id;
			}
		}

		return array(
			'total_images'           => $total_images,
			'images_with_alt'        => $images_with_alt,
			'images_without_alt'     => $images_without_alt,
			'images_with_ai'         => $images_with_ai,
			'images_without_alt_ids' => $images_without_alt_ids,
			'all_image_ids'          => array_filter( $images ),
			'status'                 => $status,
			'timestamp'              => time(),
		);
	}
}
