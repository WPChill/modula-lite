<?php

class Modula_Divi_Block extends ET_Builder_Module {

	public $slug       = 'modula_divi_block';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://wp-modula.com',
		'author'     => 'WPChill',
		'author_uri' => 'https://wp-modula.com',
	);

	public function init() {
		$this->name = esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' );
	}

	public function get_fields() {
		return array(
			'content' => array(
				'label'           => esc_html__( 'Content', 'modula-best-grid-gallery' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'modula-best-grid-gallery' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf( '<h1>%1$s</h1>', $this->props['content'] );
	}
}

new Modula_Divi_Block;
