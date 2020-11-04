<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Beaver_Block extends FLBuilderModule {

    public function __construct() {
        parent::__construct ( apply_filters( 'modula_beaver_construct', array(
            'name'            => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' ),
            'description'     => esc_html__( 'A block for Modula Gallery', 'modula-best-grid-gallery' ),
            'category'        => esc_html__( 'Modula', 'modula-best-grid-gallery' ),
            'icon'            => 'format-image.svg',
            'dir'             => MODULA_PATH . 'includes/modula-beaver-block/',
            'url'             => MODULA_URL . 'includes/modula-beaver-block/',
            'partial_refresh' => true,
        )));
    }
}

FLBuilder::register_module('Modula_Beaver_Block', apply_filters( 'modula_beaver_module', array(
    'modula_gallery' => array(
        'title'    => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' ),
        'sections' => array(
            'modula_gallery_section' => array(
                'title'  => esc_html__( 'Select the Modula Gallery you want', 'modula-best-grid-gallery' ),
                'fields' => array(
                    'modula_gallery_select' => array(
                        'type'    => 'select',
                        'label'   => esc_html__( 'Select Modula Gallery', 'modula-best-grid-gallery' ),
                        'default' => 'none',
                        'options' => Modula_Helper::get_galleries(),
                    )
                )
            )
        )
    )
)));

