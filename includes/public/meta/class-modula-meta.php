<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Meta {

	/**
	 * Holds the class object.
	 *
	 * @since 2.8.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Modula_Meta constructor.
	 *
	 * @since 2.8.0
	 */
	private function __construct() {
		// Add meta information in the head for Rich Snippets
		add_action( 'wp_head', array( $this, 'add_metas' ), - 99999 );
		// Add inline script which holds the meta information
		add_action( 'wp_enqueue_scripts', array( $this, 'meta_information_object' ), 9999 );
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Meta object.
	 * @since 2.8.0
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_Meta ) ) {
			self::$instance = new Modula_Meta();
		}

		return self::$instance;
	}

	/**
	 * Add meta information in the head for Rich Snippets
	 *
	 * @since 2.8.0
	 */
	public function add_metas() {
		// Check if we should add the meta information
		if ( empty( $_GET['modula_image_id'] ) || empty( 'modula_gallery_id' ) ) {
			return;
		}
		// Retrieve the gallery
		$gallery = get_post( $_GET['modula_gallery_id'] );
		// Check if we have the correct post type
		if ( empty( $gallery ) || 'modula-gallery' !== $gallery->post_type ) {
			return;
		}
		// Set variables
		$image_id              = absint( $_GET['modula_image_id'] );
		$gallery_id            = absint( $_GET['modula_gallery_id'] );
		$gallery_images        = get_post_meta( $gallery_id, 'modula-images', true );
		$current_gallery_image = false;

		// Cycle through the gallery images and find the one we need
		foreach ( $gallery_images as $gallery_image ) {
			if ( absint( $gallery_image['id'] ) === absint( $image_id ) ) {
				$current_gallery_image = $gallery_image;
				break;
			}
		}

		// Check if the image is in the gallery
		if ( ! $current_gallery_image ) {
			return;
		}
		global $post;
		$meta_post = $post;

		$author_name    = '';
		$date_published = '';
		// If there's an author, get the name information.
		if ( ! empty( $meta_post ) && $meta_post->post_author ) {
			$user        = get_user_by( 'id', $meta_post->post_author );
			$author_name = $user->first_name . ' ' . $user->last_name;
		}

		// If there's a post, get the date publish information.
		if ( ! empty( $meta_post ) && $meta_post->ID ) {
			// format needs to be 2014-08-12T00:01:56+00:00.
			$date_published = gmdate( 'c', strtotime( $meta_post->post_date ) );
		}

		// If there's a post, get the permalink.
		$social_url = false;
		if ( ! empty( $meta_post ) && $meta_post->ID ) {
			$social_url = get_permalink( $meta_post->ID );
			$social_url .= '?modula_gallery_id=' . intval( $_GET['modula_gallery_id'] );
			$social_url .= '&modula_image_id=' . intval( $_GET['modula_image_id'] );
		}
		// Default to gallery title
		$title = $gallery->post_title;
		// Check if image has title
		if ( ! empty( $current_gallery_image['title'] ) ) {
			$title = $current_gallery_image['title'];
		}
		// Clean Up Title.
		$title = str_replace( '"', '&quot;', $title );
		$title = str_replace(
			array(
				'<br/>',
				'<br>',
				'<br />',
				'</br>',
			),
			' ',
			$title
		);
		$title = wp_strip_all_tags( $title );

		// Set description
		$description = ! empty( $current_gallery_image['description'] ) ? $current_gallery_image['description'] : $meta_post->post_excerpt;
		// Clean Up description.
		$description = str_replace( '"', '&quot;', $description );
		// Description might be empty, so we need to add a space to keep the meta tag.
		if ( empty( $description ) ) {
			$description = '&nbsp;';
		}

		// Get image sizes
		$image_sizes = wp_get_attachment_image_src( $current_gallery_image['id'], 'full' );

		// Set the OG data
		$og_data = apply_filters(
			'modula_og_data',
			array(
				'type'           => 'article',
				'title'          => $title,
				'description'    => ! empty( $current_gallery_image['description'] ) ? $current_gallery_image['description'] : $meta_post->post_excerpt,
				'image'          => wp_get_original_image_url( $current_gallery_image['id'] ),
				'url'            => $social_url,
				'author'         => $author_name,
				'published_date' => $date_published,
				'img_width'      => ! empty( $image_sizes[1] ) ? $image_sizes[1] : '640',
				'img_height'     => ! empty( $image_sizes[2] ) ? $image_sizes[2] : '480',
			)
		);
		include __DIR__ . '/social_meta.php';
	}

	/**
	 * Add inline script which holds the meta information
	 *
	 * @since 2.8.0
	 */
	public function meta_information_object() {
		wp_add_inline_script(
			'modula',
			/**
			 * Filter the jQuery variables.
			 * This filter allows you to add custom variables to the jQuery object in order for the script
			 * to check if the social meta information is available and append it to the social sharing URL.
			 * Items added to this object should be lowercase, in the form of "item_to_add", which corresponds
			 * the social link attribute attached on the "modula_shortcode_item_data" filter.
			 * Example of social link attribute: <a href="#" data-item_to_add="your_value">. In this case, the item_to_add is our custom variable.
			 *
			 * @hook  modula_jquery_vars
			 *
			 * @since 2.8.0
			 */
			'const modulaMetaVars = ' . wp_json_encode( apply_filters( 'modula_jquery_vars', array() ) ) . ';',
			'before'
		);
	}
}

Modula_Meta::get_instance();
