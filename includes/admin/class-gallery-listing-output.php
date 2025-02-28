<?php
namespace Modula;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Gallery_Listing_Output
 *
 * @since 2.12.0
 * @package Modula
 */
class Gallery_Listing_Output {
	/** @var string */
	public $cpt_name = 'modula-gallery';

	/**
	 * Constructor for the Gallery_Listing_Output class.
	 *
	 * @param int $post_id The ID of the post.
	 */
	public function __construct() {
		add_filter( "manage_{$this->cpt_name}_posts_columns", array( $this, 'add_columns' ) );
		add_action( "manage_{$this->cpt_name}_posts_custom_column", array( $this, 'output' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'ai_gallery_scripts' ) );
	}

	/**
	 * Enqueue the AI gallery scripts
	 *
	 * @since 2.12.0
	 */
	public function ai_gallery_scripts() {
		$scripts = \Modula\Scripts::get_instance();

		$scripts->load_js_asset(
			'modula-ai-gallery',
			'assets/js/admin/gallery-listing-ai'
		);

		$scripts->load_css_asset(
			'modula-ai-gallery',
			'assets/js/admin/gallery-listing-ai',
			array( 'wp-components' )
		);
	}

	public function add_columns( $columns ) {
		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['modula_ai_optimizer'] = __( 'Modula AI', 'modula-best-grid-gallery' );

		$columns['date'] = $date;

		return $columns;
	}

	/**
	 * Outputs the gallery listing HTML.
	 *
	 * @return void
	 */
	public function output( $column, $post_id ) {
		if ( 'modula_ai_optimizer' !== $column ) {
			return;
		}

		$this->js_data( $post_id );
		echo '<div class="mai-gallery-output" data-post-id="' . absint( $post_id ) . '"></div>';
	}

	/**
	 * Returns the JavaScript data for the gallery listing.
	 *
	 * @param int $post_id The ID of the post.
	 * @return array The JavaScript data.
	 */
	public function js_data( $post_id ) {
		$js_data = array(
			'handle'  => 'modula-ai-gallery',
			'var'     => 'modulaAiGalleryListing',
			'post_id' => $post_id,
			'report'  => $this->convert_to_camel_case( $this->get_gallery_report( $post_id ) ),
		);

		$js_data['report']['modulaAiSettings'] = esc_url( admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=modula_ai' ) );

		wp_add_inline_script(
			$js_data['handle'],
			'var ' . $js_data['var'] . $js_data['post_id'] . ' = ' . wp_json_encode( $js_data['report'] ) . ';',
			'before'
		);
	}

	/**
	 * Retrieves the image IDs for the gallery.
	 *
	 * @param int $post_id The ID of the post.
	 * @return array The image IDs.
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
	 * Retrieves the gallery report.
	 *
	 * @param int $post_id The ID of the post.
	 * @return array The gallery report.
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
			$alt_text  = get_post_meta( $id, '_wp_attachment_image_alt', true );
			$ai_report = get_post_meta( $id, '_modula_ai_report', true );

			if ( ! empty( $alt_text ) ) {
				++$images_with_alt;
				if ( ! empty( $ai_report ) ) {
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

	/**
	 * Converts the options array to camel case.
	 *
	 * @param array $options The options array.
	 * @return array The camel case options array.
	 */
	private function convert_to_camel_case( $options ) {
		$camel_cased = array();

		foreach ( $options as $key => $value ) {
			if ( strpos( $key, '_' ) === -1 ) {
				$camel_cased[ $key ] = $value;
				continue;
			}

			$camel_case_key = lcfirst( str_replace( '_', '', ucwords( $key, '_' ) ) );

			$camel_cased[ $camel_case_key ] = $value;
		}

		return $camel_cased;
	}
}
