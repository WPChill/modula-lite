<?php

namespace ElementorModula\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Modula_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'modula_elementor_gallery';
	}

	public function get_title() {
		return apply_filters( 'modula_elementor_name', esc_html__( 'Modula', 'modula-best-grid-gallery' ));
	}

	public function get_icon() {
		return 'eicon-elementor-square';
	}

	public function get_categories() {
		return array( 'general' );

	}

	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'modula-best-grid-gallery' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
            'modula_gallery_select',
            array(
                'label'   => esc_html__( 'Select/Search Gallery', 'modula-best-grid-gallery' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => \Modula_Helper::get_galleries(), // will be loaded through ajax
                'default' => 'none',
            )
        );


		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$gallery_id = $settings['modula_gallery_select'];
		if ( 'none' != $gallery_id ) {
			echo do_shortcode( '[Modula id="' . esc_attr( $gallery_id ) . '"]' );
		}

	}

}