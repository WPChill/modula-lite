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

		wp_register_script( 'modula-gutenberg', MODULA_URL . 'assets/js/admin/wp-modula-gutenberg.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-data' ) );
		wp_register_style( 'modula-gutenberg', MODULA_URL . 'assets/css/admin/modula-gutenberg.css', array(), true );

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
			apply_filters( 'modula_gutenberg_vars', array(
				'adminURL'       => admin_url(),
				'ajaxURL'        => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'modula_nonce' ),
				'gutenbergTitle' => esc_html( 'Modula Gallery'),
				'gutenbergLogo'  => '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="364 242.9 312.2 357">
				<g>
					<path d="M528.1,242.9c8.5,16.9,17,33.8,25.6,50.6c13.4,26.4,26.9,52.7,39.9,79.7c-41.8-23.3-83.6-46.7-125.4-70.1
						c0.3-1.9,1.7-2.6,2.7-3.5c17.7-17.7,35.4-35.4,53.1-53c1.1-1.1,2.6-2,3.1-3.7C527.4,242.9,527.8,242.9,528.1,242.9z"/>
					<path d="M602.3,463.3c11.3-6.9,22.6-13.9,33.9-20.8c5.5-3.4,11.1-6.7,16.5-10.3c2.2-1.4,2.9-1.1,3.5,1.5
						c6.4,25.3,13,50.6,19.6,75.8c0.6,2.2,1,3.7-2.4,3.5c-46.7-2.1-93.5-4.1-140.2-6.1c-0.2,0-0.3-0.1-0.5-0.2c0.5-1.7,2.1-2,3.3-2.7
						c20-12.3,39.9-24.7,60-36.8c3.4-2.1,5.1-3.7,4.8-8.5c-1.4-21.3-1.8-42.6-2.6-63.9c-0.9-24.1-1.8-48.3-2.8-72.4
						c-0.2-6.1-0.2-6.1,5.5-4.6c23.8,6.2,47.6,12.5,71.5,18.5c3.9,1,4.2,1.9,2.1,5.4c-23.4,38.5-46.7,77.1-70,115.7c-1,1.7-2,3.4-3,5.1
						C601.7,462.8,602,463,602.3,463.3z"/>
					<path d="M372.8,326.9c48,2.6,95.8,5.1,143.9,7.7c-0.9,2-2.5,2.3-3.7,3.1c-38.6,23.2-77.3,46.4-115.9,69.6c-3,1.8-4.3,2.6-5.4-1.9
						c-5.9-24.9-12.2-49.7-18.3-74.6C373.1,329.6,373,328.4,372.8,326.9z"/>
					<path d="M517.6,599.9c-23.2-43.7-45.9-86.6-69.2-130.5c2.3,1.2,3.5,1.8,4.7,2.4c39.8,21.5,79.5,43.1,119.3,64.5
						c3.2,1.7,4.1,2.5,1,5.6c-17.7,17.8-35.2,35.9-52.8,53.9C519.7,596.9,518.9,598.2,517.6,599.9z"/>
					<path d="M364.9,505.1c26.6-40.5,53.1-80.8,79.7-121.3c1.3,1.3,0.9,2.5,0.9,3.6c0,46-0.1,92-0.1,137.9c0,3.1-0.2,4.5-4,3.3
						c-24.9-7.7-49.9-15.2-74.9-22.8C366,505.8,365.7,505.5,364.9,505.1z"/>
				</g>
				</svg>'
			) ),
		);
	}

	public function render_modula_gallery( $atts ) {
		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		if ( ! isset( $atts['align'] ) ) {
			$atts['align'] = '';
		}

		return '[modula id=' . absint($atts['id']) . ' align=' . esc_attr($atts['align']) . ']';
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


