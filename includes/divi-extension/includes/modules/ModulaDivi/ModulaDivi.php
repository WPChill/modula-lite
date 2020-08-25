<?php

class Modula_Divi_Module extends ET_Builder_Module {

	public $slug       = 'modula_gallery';
	public $vb_support = 'on';

	protected $module_credits
		= array(
			'module_uri' => 'https://wp-modula.com',
			'author'     => 'WPChill',
			'author_uri' => 'http://wpchill.com',
		);

	public function init() {
		$this->name = esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' );
	}

	public function get_fields() {

		return array(
			'gallery_select' => array(
				'label'       => esc_html__( 'Select Gallery', 'modula-best-grid-gallery' ),
				'type'        => 'select',
				'description' => esc_html__( 'Content entered here will appear inside the module.', 'modula-best-grid-gallery' ),
				'toggle_slug' => 'main_content',
				'options'     => Modula_Helper::get_galleries(),
				'default'     => 'none'
			),
			'modula_images'  => array(
				'type'              => 'computed',
				'computed_callback' => array( $this, 'render_images' ),
			)
		);
	}

	public function render_images() {
		return 'soooomething';
	}

	public function render( $attrs, $content = null, $render_slug ) {

		$gallery_id = $post_type = $this->props['gallery_select'];
		$gallery    = get_post( $gallery_id );

		if ( !$gallery ) {
			return esc_html__( 'There are no Modula galleries', 'modula-best-grid-gallery' );
		}

		if ( 'modula-gallery' != $gallery->post_type ) {
			return esc_html__( 'Selected ID is not a Modula gallery', 'modula-best-grid-gallery' );
		}

		return do_shortcode( '[modula id="' . absint( $gallery_id ) . '"] asd' );
	}

}

new Modula_Divi_Module;
