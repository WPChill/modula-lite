<?php
namespace Modula\Ai\Admin_Area;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin_Area {
	public function __construct() {
		add_filter( 'modula_helper_properties', array( $this, 'add_modula_ai_helper_properties' ) );
	}

	public function add_modula_ai_helper_properties( $helper ) {
		if ( ! isset( $helper['strings'] ) ) {
			$helper['strings'] = array();
		}

		$helper['strings'] = array_merge(
			$helper['strings'],
			array(
				'generating_alt_text'        => esc_html__( 'Generating report', 'modula-best-grid-gallery' ),
				'alt_text_generated'         => esc_html__( 'AI Report generated', 'modula-best-grid-gallery' ),
				'alt_text_generation_failed' => esc_html__( 'Failed to generate report', 'modula-best-grid-gallery' ),
				'generate_report'            => esc_html__( 'Generate AI Report', 'modula-best-grid-gallery' ),
				'configure_api_key'          => esc_html__( 'Configure API Key', 'modula-best-grid-gallery' ),
				'refresh_report'             => esc_html__( 'Refresh AI Report', 'modula-best-grid-gallery' ),
			)
		);

		$helper['settings_url'] = esc_url( admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=modula_ai' ) );

		return $helper;
	}
}
