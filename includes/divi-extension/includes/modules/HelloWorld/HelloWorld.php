<?php

class Modula_Divi_Module extends ET_Builder_Module {

	public $slug       = 'modula_gallery';
	public $vb_support = 'on';

	protected $module_credits = array(
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
				'label'           => esc_html__( 'Select Gallery', 'modula-modula-best-grid-gallery' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'modula-modula-best-grid-gallery' ),
				'toggle_slug'     => 'main_content',
				'options' => Modula_Helper::get_galleries()
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf( '<h1>%1$s</h1>', $this->props['gallery_select'] );
	}
}

new Modula_Divi_Module;
