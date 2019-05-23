<?php

/**
 * Class Modula Upsells
 */
class Modula_Upsells {
	
	function __construct() {
		
		/* Hooks */
		add_filter( 'modula_general_tab_content', array( $this, 'general_tab_upsell' ) );
		add_filter( 'modula_hover-effect_tab_content', array( $this, 'hovereffects_tab_upsell' ) );
		add_filter( 'modula_image-loaded-effects_tab_content', array( $this, 'loadingeffects_tab_upsell' ) );
		add_filter( 'modula_video_tab_content', array( $this, 'video_tab_upsell' ) );
		add_filter( 'modula_speedup_tab_content', array( $this, 'speedup_tab_upsell' ) );
		add_filter( 'modula_filters_tab_content', array( $this, 'filters_tab_upsell' ) );

	}

	public function generate_upsell_box( $title, $description, $tab ) {

		$upsell_box = '<div class="modula-upsell">';
		$upsell_box .= '<h2>' . esc_html( $title ) . '</h2>';
		$upsell_box .= '<p class="modula-upsell-description">' . esc_html( $description ) . '</p>';
		$upsell_box .= '<p>';
		$upsell_box .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=' . $tab . '-tab&utm_campaign=litevspro#lite-vs-pro"  class="button">' . esc_html__( 'See LITE vs PRO Differences', 'modula-best-grid-gallery' ) . '</a>';
		$upsell_box .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=' . $tab . '-tab&utm_campaign=upsell" class="button-primary button">' . esc_html__( 'Get Modula Pro!', 'modula-best-grid-gallery' ) . '</a>';
		$upsell_box .= '</p>';
		$upsell_box .= '</div>';

		return $upsell_box;
	}

	public function general_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking for even more control and even more powerful galleries?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Pro today to get access to 5 more lightboxes, extra styles and more...', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'general' );

		return $tab_content;
	}

	public function loadingeffects_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Not enough control?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Pro today to unlock the ability to scale an image, and add horizontal/vertical slides...', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'loadingeffects' );

		return $tab_content;

	}

	public function hovereffects_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Need a new hover effect?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Pro today to unlock 11 more hover effects...', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'hovereffects' );

		return $tab_content;

	}

	public function video_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Trying to add a video to your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Adding a video gallery with both self-hosted videos and videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'video' );

		return $tab_content;

	}

	public function speedup_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to make your gallery load faster ?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them and serving them from StackPath’s content delivery network.', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'speedup' );

		return $tab_content;

	}

	public function filters_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to add filters to your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Ugrade to Modula Pro today and get access to filters and separate the images in your gallery.', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'filters' );

		return $tab_content;

	}

}
