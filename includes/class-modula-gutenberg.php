<?php

class Modula_Gutenberg {

	function __construct() {

		// Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'register_block_type' ) );
		add_action( 'init', array( $this, 'generate_js_vars' ) );
		add_action( 'wp_ajax_modula_get_gallery_meta', array( $this, 'get_gallery_meta' ) );
	}

	public function register_block_type() {

		wp_register_script( 'modula-gutenberg', MODULA_URL . 'assets/js/wp-modula-gutenberg.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-data' ) );
		wp_register_style( 'modula-gutenberg', MODULA_URL . 'assets/css/modula-gutenberg.css', array(), true );

		register_block_type(
			'modula/gallery',
			array(
				'render_callback' => array( $this, 'render_modula_gallery' ),
				'editor_script'   => 'modula-gutenberg',
				'editor_style'    => 'modula-gutenberg',
			)
		);

	}

	public function generate_js_vars() {

		wp_localize_script(
			'modula-gutenberg',
			'modulaVars',
			array(
				'adminURL' => admin_url(),
				'ajaxURL'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'modula_nonce' ),
			)
		);
	}

	public function render_modula_gallery( $atts ) {
		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		if ( ! isset( $atts['align'] ) ) {
			$atts['align'] = '';
		}

		return do_shortcode( '[modula id=' . $atts['id'] . ' align=' . $atts['align'] . ']' );
	}

	public function get_gallery_meta() {

		$id    = $_POST['id'];
		$nonce = $_POST['nonce'];

	 	if ( ! wp_verify_nonce( $nonce, 'modula_nonce' ) ) {
			wp_send_json_error();
			die();
		}

		$images = get_post_meta( $id, 'modula-images', true );

		if ( ! is_array( $images ) ) {
			wp_send_json_error();
			die();
		}

		foreach ( $images as $key => $value ) :
			$image_obj                = wp_get_attachment_image_src( $images[ $key ]['id'], 'large' );
			$images[ $key ]['src']    = $image_obj[0];
			$images[ $key ]['width']  = $image_obj[1];
			$images[ $key ]['height'] = $image_obj[2];
		endforeach;

		echo json_encode( $images );

		die();

	}

}

new Modula_Gutenberg();


