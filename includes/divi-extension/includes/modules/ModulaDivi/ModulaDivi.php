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

		$this->name   = esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' );
		add_action( 'et_fb_enqueue_assets', array( $this, 'enqueue_scripts' ), 99 );

		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' ),
				),
			),
		);

		$this->advanced_fields = array(
			'text'              => false,
			'borders'           => false,
			'max_width'         => false,
			'margin_padding'    => false,
			'button'            => false,
			'link_options'      => false,
			'module-text'       => false,
			'filters'           => false,
			'animation'         => false,
			'hover_transitions' => false
		);
	}

	public function get_fields() {

		return array(
			'gallery_select' => array(
				'label'            => esc_html__( 'Select Gallery', 'modula-best-grid-gallery' ),
				'type'             => 'select',
				'description'      => esc_html__( 'Content entered here will appear inside the module.', 'modula-best-grid-gallery' ),
				'toggle_slug'      => 'main_content',
				'options'          => Modula_Helper::get_galleries(),
				'default'          => 'none',
				'computed_affects' => array(
					'__gallery',
				),
			),
			'modula_images'  => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'Modula_Divi_Module', 'render_images' ),
				'computed_depends_on' => array(
					'gallery_select',
				),
				'computed_minimum'    => array(
					'gallery_select',
				),
			),
		);
	}

	static function render_images( $args = array(), $conditional_tags = array(), $current_page = array() ) {

		$defaults = [
			'gallery_select' => 'none',
		];

		$args    = wp_parse_args( $args, $defaults );
		$gallery = get_post( $args['gallery_select'] );

		if ( 'none' != $args['gallery_select'] ) {
			if ( 'modula-gallery' != $gallery->post_type ) {
				return esc_html__( 'Selected ID is not a Modula gallery', 'modula-best-grid-gallery' );
			} else {
				return do_shortcode( '[modula id="' . absint( $args['gallery_select'] ) . '"]' );
			}
		} else {
			return __( 'No galleries selected', 'modula-best-grid-gallery' );
		}

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

		return do_shortcode( '[modula id="' . absint( $gallery_id ) . '"]' );
	}

	static function enqueue_scripts( $args = array(), $conditional_tags = array(), $current_page = array() ) {

		wp_register_style( 'modula-fancybox', MODULA_URL . 'assets/css/front/fancybox.css', null, MODULA_LITE_VERSION );
		wp_register_style( 'modula', MODULA_URL . 'assets/css/front.css', null, MODULA_LITE_VERSION );

		// Scripts necessary for some galleries
		wp_register_script( 'modula-isotope-packery', MODULA_URL . 'assets/js/front/isotope-packery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-isotope', MODULA_URL . 'assets/js/front/isotope.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-grid-justified-gallery', MODULA_URL . 'assets/js/front/justifiedGallery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-fancybox', MODULA_URL . 'assets/js/front/fancybox.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-lazysizes', MODULA_URL . 'assets/js/front/lazysizes.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

		// @todo: minify all css & js for a better optimization.
		wp_register_script( 'modula', MODULA_URL . 'assets/js/front/jquery-modula.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

		wp_enqueue_style( 'modula-fancybox' );
		wp_enqueue_style( 'modula' );

		wp_enqueue_script( 'modula-isotope' );
		wp_enqueue_script( 'modula-isotope-packery' );
		wp_enqueue_script( 'modula-grid-justified-gallery' );
		wp_enqueue_script( 'modula-lazysizes' );
		wp_enqueue_script( 'modula' );

		do_action( 'modula_divi_builder_sripts_after_modula' );

	}

}

new Modula_Divi_Module;
