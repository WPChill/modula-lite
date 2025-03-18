<?php

/**
 *
 */
class Modula_CPT_Fields_Helper {

	public static function get_tabs() {

		return apply_filters(
			'modula_gallery_tabs',
			array(
				'general'              => array(
					'label'    => esc_html__( 'General', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'General Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-admin-generic',
					'docs_url' => 'https://wp-modula.com/kb/gallery-types-explained/',
					'priority' => 10,
				),
				'lightboxes'           => array(
					'label'    => esc_html__( 'Lightbox &amp; Links', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Lightbox & Links settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-layout',
					'docs_url' => 'https://wp-modula.com/kb/lightbox-links/',
					'priority' => 10,
				),
				'filters'              => array(
					'label'    => esc_html__( 'Filters', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Filters', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-filter',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/how-to-use-filters-in-modula/',
					'priority' => 15,
				),
				'captions'             => array(
					'label'    => esc_html__( 'Captions', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Caption Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-text',
					'docs_url' => 'https://wp-modula.com/kb/modula-caption-configuration/',
					'priority' => 20,
				),
				'social'               => array(
					'label'    => esc_html__( 'Social', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Social Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-admin-links',
					'docs_url' => 'https://wp-modula.com/kb/add-social-share-buttons/',
					'priority' => 30,
				),
				'image-loaded-effects' => array(
					'label'    => esc_html__( 'Loading effects', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Loading Effects Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-image-rotate',
					'docs_url' => 'https://wp-modula.com/kb/modula-loading-effects/',
					'priority' => 40,
				),
				'image_licensing'      => array(
					'label'    => esc_html__( 'Image Licensing', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Image Licensing Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-images-alt2',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/image-licensing-settings/',
					'priority' => 45,
				),
				'hover-effect'         => array(
					'label'    => esc_html__( 'Hover effects', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Hover Effect Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-layout',
					'docs_url' => 'https://wp-modula.com/kb/modula-hover-effects/',
					'priority' => 50,
				),
				'video'                => array(
					'label'    => esc_html__( 'Video', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Video Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-video-alt3',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/modula-video/',
					'priority' => 60,
				),
				'style'                => array(
					'label'    => esc_html__( 'Style', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Style Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-admin-appearance',
					'docs_url' => 'https://wp-modula.com/kb/modula-style-settings/',
					'priority' => 70,
				),
				'speedup'              => array(
					'label'    => esc_html__( 'Speed Up', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Optimize your images', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-dashboard',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/modula-speed-up/ ',
					'priority' => 80,
				),
				'exif'                 => array(
					'label'    => esc_html__( 'EXIF', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Exif Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-camera-alt',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/modula-exif/ ',
					'priority' => 85,
				),
				'download'             => array(
					'label'    => esc_html__( 'Download', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Download Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-download',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/modula-download/',
					'priority' => 86,
				),
				'zoom'                 => array(
					'label'    => esc_html__( 'Zoom', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Zoom Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-search',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/modula-zoom/',
					'priority' => 87,
				),
				'responsive'           => array(
					'label'    => esc_html__( 'Responsive', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Responsive Settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-smartphone',
					'docs_url' => 'https://wp-modula.com/kb/optimize-galleries-for-mobile-tablet-devices/',
					'priority' => 90,
				),
				'misc'                 => array(
					'label'    => esc_html__( 'Misc', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Miscellaneous', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-image-filter',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/right-click-protection/',
					'priority' => 100,
				),
				'slideshow'            => array(
					'label'    => esc_html__( 'Slideshow', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Lightbox slideshow settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-images-alt2',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/lightbox-slideshow/ ',
					'priority' => 110,
				),
				'password_protect'     => array(
					'label'    => esc_html__( 'Pass Protect', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Password protect your galleries', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-shield',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/password-protection-extension/ ',
					'priority' => 120,
				),
				'watermark'            => array(
					'label'    => esc_html__( 'Watermark', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Watermark settings', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-id-alt',
					'badge'    => esc_html__( 'PRO', 'modula-best-grid-gallery' ),
					'docs_url' => 'https://wp-modula.com/kb/modula-watermark/ ',
					'priority' => 130,
				),
				'customizations'       => array(
					'label'    => esc_html__( 'Custom CSS', 'modula-best-grid-gallery' ),
					'title'    => esc_html__( 'Custom CSS', 'modula-best-grid-gallery' ),
					'icon'     => 'dashicons dashicons-admin-tools',
					'docs_url' => 'https://wp-modula.com/kb-cat/custom-css-customizations/',
					'priority' => 140,
				),

			)
		);
	}

	public static function generate_more_help_links() {

		$output = '<p>' . esc_html__( 'Still stuck ?', 'modula-best-grid-gallery' ) . ' <a class="modula-tab-link" href="#" target="_blank"><span class="dashicons dashicons-sos"></span>' . esc_html__( 'Explore our documentation', 'modula-best-grid-gallery' ) . '</a> or <a href="https://wp-modula.com/contact-us/" class="modula-tab-link" target="_blank><span class="dashicons dashicons-email-alt"></span>' . esc_html__( 'Contact our support team.', 'modula-best-grid-gallery' ) . '</a></p>';

		return $output;
	}

	public static function get_fields( $tab ) {

		$fields = apply_filters(
			'modula_gallery_fields',
			array(
				'general'              => array(
					'type'                  => array(
						'name'      => esc_html__( 'Gallery Type', 'modula-best-grid-gallery' ),
						'type'      => 'icon-radio',
						'default'   => 'grid',
						'values'    => array(
							'creative-gallery' => esc_html__( 'Creative', 'modula-best-grid-gallery' ),
							'custom-grid'      => esc_html__( 'Custom', 'modula-best-grid-gallery' ),
							'grid'             => esc_html__( 'Masonry', 'modula-best-grid-gallery' ),
						),
						'disabled'  => array(
							'title'  => esc_html__( 'Gallery types with Premium license', 'modula-best-grid-gallery' ),
							'values' => array(
								'slider' => esc_html__( 'Slider', 'modula-best-grid-gallery' ),
								'video'  => esc_html__( 'Video', 'modula-best-grid-gallery' ),
								'bnb'    => esc_html__( 'BnB', 'modula-best-grid-gallery' ),
							),
						),
						'priority'  => 10,
						'data_type' => 'text',
					),
					'grid_type'             => array(
						'name'      => esc_html__( 'Number of Columns', 'modula-best-grid-gallery' ),
						'type'      => 'select',
						'values'    => array(
							'automatic' => esc_html__( 'Automatic', 'modula-best-grid-gallery' ),
							'1'         => esc_html__( 'One Column(1)', 'modula-best-grid-gallery' ),
							'2'         => esc_html__( 'Two Columns(2)', 'modula-best-grid-gallery' ),
							'3'         => esc_html__( 'Three Columns(3)', 'modula-best-grid-gallery' ),
							'4'         => esc_html__( 'Four Columns(4)', 'modula-best-grid-gallery' ),
							'5'         => esc_html__( 'Five Columns(5)', 'modula-best-grid-gallery' ),
							'6'         => esc_html__( 'Six Columns(6)', 'modula-best-grid-gallery' ),
							'7'         => esc_html__( 'Seven Column(7)', 'modula-best-grid-gallery' ),
							'8'         => esc_html__( 'Eight Columns(8)', 'modula-best-grid-gallery' ),
							'9'         => esc_html__( 'Nine Columns(9)', 'modula-best-grid-gallery' ),
							'10'        => esc_html__( 'Ten Columns(10)', 'modula-best-grid-gallery' ),
							'11'        => esc_html__( 'Eleven Columns(11)', 'modula-best-grid-gallery' ),
							'12'        => esc_html__( 'Twelve Columns(12)', 'modula-best-grid-gallery' ),
						),
						'default'   => 'automatic',
						'priority'  => 26,
						'data_type' => 'text',
					),

					'grid_row_height'       => array(
						'name'      => esc_html__( 'Row Height', 'modula-best-grid-gallery' ),
						'type'      => 'number',
						'after'     => 'px',
						'default'   => 250,
						'is_child'  => true,
						'priority'  => 27,
						'data_type' => 'number',
					),

					'grid_justify_last_row' => array(
						'name'      => esc_html__( 'Last Row Alignment', 'modula-best-grid-gallery' ),
						'type'      => 'select',
						'values'    => array(
							'justify'   => esc_html__( 'Justify', 'modula-best-grid-gallery' ),
							'nojustify' => esc_html__( 'Left', 'modula-best-grid-gallery' ),
							'center'    => esc_html__( 'Center', 'modula-best-grid-gallery' ),
							'right'     => esc_html__( 'Right', 'modula-best-grid-gallery' ),
						),
						'default'   => 'justify',
						'is_child'  => true,
						'priority'  => 28,
						'data_type' => 'text',
					),

					'grid_image_size'       => array(
						'name'      => esc_html__( 'Gallery Images Size', 'modula-best-grid-gallery' ),
						'type'      => 'dimensions-select',
						'values'    => Modula_Helper::get_image_sizes( true ),
						'default'   => 'medium',
						'priority'  => 37,
						'data_type' => 'text',
					),

					'grid_image_dimensions' => array(
						'name'        => esc_html__( 'Width x Height', 'modula-best-grid-gallery' ),
						'type'        => 'image-size',
						'default'     => '600',
						'is_child'    => true,
						'priority'    => 38,
						'placeholder' => array(
							'width'  => __( 'Width', 'modula-best-grid-gallery' ),
							'height' => __( 'Height', 'modula-best-grid-gallery' ),
						),
						'data_type'   => 'number',
					),
					'img_size'              => array(
						'name'      => esc_html__( ' Block size', 'modula-best-grid-gallery' ),
						'type'      => 'text',
						'default'   => 200,
						'is_child'  => true,
						'priority'  => 38,
						'data_type' => 'number',
					),
					'img_crop'              => array(
						'name'      => esc_html__( 'Crop Images', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 1,
						'is_child'  => true,
						'priority'  => 39,
						'data_type' => 'bool',
					),
					'grid_image_crop'       => array(
						'name'      => esc_html__( 'Crop Images', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 39,
						'data_type' => 'bool',
					),
					'gutter'                => array(
						'name'      => esc_html__( 'Space between gallery images', 'modula-best-grid-gallery' ),
						'type'      => 'gutterInput',
						'default'   => 10,
						'priority'  => 30,
						// Attribute specific for gutterInput type fields
						'media'     => 'desktop',
						'data_type' => 'number',
					),
					'tablet_gutter'         => array(
						'name'      => esc_html__( 'Gutter for tablet', 'modula-best-grid-gallery' ),
						'type'      => 'gutterInput',
						'default'   => 10,
						'priority'  => 31,
						// Attribute specific for gutterInput type fields
						'media'     => 'tablet',
						'data_type' => 'number',
					),
					'mobile_gutter'         => array(
						'name'      => esc_html__( 'Gutter for mobile', 'modula-best-grid-gallery' ),
						'type'      => 'gutterInput',
						'default'   => 10,
						'priority'  => 32,
						// Attribute specific for gutterInput type fields
						'media'     => 'mobile',
						'data_type' => 'number',
					),
					'width'                 => array(
						'name'      => esc_html__( 'Gallery width', 'modula-best-grid-gallery' ),
						'type'      => 'text',
						'default'   => '100%',
						'priority'  => 33,
						'data_type' => 'text',
					),
					'height'                => array(
						'name'      => esc_html__( 'Gallery height', 'modula-best-grid-gallery' ),
						'type'      => 'responsiveInput',
						'default'   => array( 800, 800, 800 ),
						'priority'  => 40,
						'data_type' => 'number',
					),
					'randomFactor'          => array(
						'name'      => esc_html__( 'Randomize images', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 0,
						'max'       => 100,
						'step'      => 1,
						'default'   => 50,
						'priority'  => 70,
						'data_type' => 'number',
					),
					'shuffle'               => array(
						'name'      => esc_html__( 'Shuffle images', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'priority'  => 90,
						'data_type' => 'bool',
					),
				),
				'lightboxes'           => array(
					'lightbox'        => array(
						'name'      => esc_html__( 'Image click behavior', 'modula-best-grid-gallery' ),
						'type'      => 'select',
						'default'   => 'fancybox',
						'values'    => array(
							'no-link'      => esc_html__( 'No link', 'modula-best-grid-gallery' ),
							'direct'       => esc_html__( 'Direct link to image', 'modula-best-grid-gallery' ),
							'external-url' => esc_html__( 'External URL', 'modula-best-grid-gallery' ),
							'fancybox'     => esc_html__( 'Open Images in a Lightbox', 'modula-best-grid-gallery' ),

						),
						'priority'  => 1,
						'data_type' => 'text',
					),
					'show_navigation' => array(
						'name'      => esc_html__( 'Show arrows navigation', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 1,
						'priority'  => 2,
						'data_type' => 'bool',
					),
				),
				'captions'             => array(
					'hide_title'            => array(
						'name'      => esc_html__( 'Hide image title', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 1,
						'priority'  => 10,
						'children'  => array( 'titleColor', 'titleFontSize', 'mobileTitleFontSize' ),
						'data_type' => 'bool',
					),
					'titleColor'            => array(
						'name'      => esc_html__( 'Title Color', 'modula-best-grid-gallery' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'is_child'  => true,
						'priority'  => 30,
						'data_type' => 'text',
					),
					'titleFontSize'         => array(
						'name'      => esc_html__( 'Title Font Size', 'modula-best-grid-gallery' ),
						'type'      => 'number',
						'after'     => 'px',
						'default'   => 24,
						'is_child'  => true,
						'priority'  => 40,
						'data_type' => 'number',
					),
					'mobileTitleFontSize'   => array(
						'name'      => esc_html__( 'Mobile Title Font Size', 'modula-best-grid-gallery' ),
						'type'      => 'number',
						'after'     => 'px',
						'default'   => 12,
						'is_child'  => true,
						'priority'  => 40,
						'data_type' => 'number',
					),
					'hide_description'      => array(
						'name'      => esc_html__( 'Hide image caption', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'priority'  => 50,
						'children'  => array( 'captionColor', 'captionFontSize', 'mobileCaptionFontSize' ),
						'data_type' => 'bool',
					),
					'captionColor'          => array(
						'name'      => esc_html__( 'Caption Color', 'modula-best-grid-gallery' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'is_child'  => true,
						'priority'  => 70,
						'data_type' => 'text',
					),
					'captionFontSize'       => array(
						'name'      => esc_html__( 'Caption Font Size', 'modula-best-grid-gallery' ),
						'type'      => 'number',
						'after'     => 'px',
						'default'   => 16,
						'is_child'  => true,
						'priority'  => 80,
						'data_type' => 'number',
					),
					'mobileCaptionFontSize' => array(
						'name'      => esc_html__( 'Caption font size on mobile', 'modula-best-grid-gallery' ),
						'type'      => 'number',
						'after'     => 'px',
						'default'   => 10,
						'is_child'  => true,
						'priority'  => 100,
						'data_type' => 'number',
					),
				),
				'social'               => array(
					'enableSocial'      => array(
						'name'      => esc_html__( 'Enable Social Bar', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'priority'  => 10,
						'children'  => array( 'enableTwitter', 'enableFacebook', 'enableWhatsapp', 'enableLinkedin', 'enablePinterest', 'enableEmail', 'socialIconColor', 'socialIconSize', 'socialIconPadding' ),
						'data_type' => 'bool',
					),
					'enableTwitter'     => array(
						'name'      => esc_html__( 'X', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 10,
						'data_type' => 'bool',
					),
					'enableFacebook'    => array(
						'name'      => esc_html__( 'Facebook', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 20,
						'data_type' => 'bool',
					),
					'enableWhatsapp'    => array(
						'name'      => esc_html__( 'Whatsapp', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 20,
						'data_type' => 'bool',
					),
					'enableLinkedin'    => array(
						'name'      => esc_html__( 'LinkedIn', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 30,
						'data_type' => 'bool',
					),
					'enablePinterest'   => array(
						'name'      => esc_html__( 'Pinterest', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 40,
						'data_type' => 'bool',
					),
					'enableEmail'       => array(
						'name'      => esc_html__( 'Email', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'is_child'  => true,
						'priority'  => 40,
						'children'  => array( 'emailSubject', 'emailMessage' ),
						'parent'    => 'enableSocial',
						'data_type' => 'bool',
					),
					'emailSubject'      => array(
						'name'      => esc_html__( 'Email subject', 'modula-best-grid-gallery' ),
						'type'      => 'text',
						'default'   => esc_html__( 'Check out this awesome image !!', 'modula-best-grid-gallery' ),
						'is_child'  => 'two',
						'priority'  => 41,
						'data_type' => 'text',
					),
					'emailMessage'      => array(
						'name'      => esc_html__( 'Email message', 'modula-best-grid-gallery' ),
						'type'      => 'textarea-placeholder',
						'values'    => array(
							'%%image_link%%'   => esc_html__( 'Image Link', 'modula-best-grid-gallery' ),
							'%%gallery_link%%' => esc_html__( 'Gallery Link', 'modula-best-grid-gallery' ),
						),
						'default'   => esc_html__( 'Here is the link to the image : %%image_link%% and this is the link to the gallery : %%gallery_link%% ', 'modula-best-grid-gallery' ),
						'is_child'  => 'two',
						'priority'  => 42,
						'data_type' => 'text',
					),
					'socialIconColor'   => array(
						'name'      => esc_html__( 'Icons color', 'modula-best-grid-gallery' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'is_child'  => true,
						'priority'  => 50,
						'data_type' => 'text',
					),
					'socialIconSize'    => array(
						'name'      => esc_html__( 'Icons size', 'modula-best-grid-gallery' ),
						'type'      => 'number',
						'after'     => 'px',
						'default'   => 16,
						'is_child'  => true,
						'priority'  => 50,
						'data_type' => 'number',
					),
					'socialIconPadding' => array(
						'name'      => esc_html__( 'Space between icons', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 0,
						'max'       => 20,
						'default'   => 10,
						'is_child'  => true,
						'priority'  => 50,
						'data_type' => 'number',
					),
				),
				'image-loaded-effects' => array(
					'loadedScale' => array(
						'name'      => esc_html__( 'Scale', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 0,
						'max'       => 200,
						'default'   => 100,
						'priority'  => 10,
						'data_type' => 'number',
					),
					'inView'      => array(
						'name'      => esc_html__( 'Load in view', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 0,
						'priority'  => 50,
						'data_type' => 'bool',
					),
				),
				'hover-effect'         => array(
					'effect' => array(
						'name'      => esc_html__( 'Hover effect', 'modula-best-grid-gallery' ),
						'type'      => 'hover-effect',
						'default'   => 'pufrobo',
						'priority'  => 15,
						'data_type' => 'text',
					),

					'cursor' => array(
						'name'      => esc_html__( 'Cursor Icon', 'modula-best-grid-gallery' ),
						'type'      => 'select',
						'default'   => 'zoom-in',
						'priority'  => 12,
						'values'    => array(
							'pointer' => esc_html__( 'Pointer', 'modula-best-grid-gallery' ),
							'zoom-in' => esc_html__( 'Magnifying Glass', 'modula-best-grid-gallery' ),
						),
						'disabled'  => array(
							'title'  => esc_html__( 'Cursors with Premium license', 'modula-best-grid-gallery' ),
							'values' => array(
								'wait'        => esc_html__( 'Loading', 'modula-best-grid-gallery' ),
								'cell'        => esc_html__( 'Cell', 'modula-best-grid-gallery' ),
								'crosshair'   => esc_html__( 'Crosshair', 'modula-best-grid-gallery' ),
								'nesw-resize' => esc_html__( 'Resize 1', 'modula-best-grid-gallery' ),
								'nwse-resize' => esc_html__( 'Resize 2', 'modula-best-grid-gallery' ),
								'custom'      => esc_html__( 'Custom', 'modula-best-grid-gallery' ),
							),
						),
						'data_type' => 'text',
					),
				),
				'style'                => array(
					'borderSize'   => array(
						'name'      => esc_html__( 'Image border size', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 0,
						'max'       => 10,
						'default'   => 0,
						'priority'  => 10,
						'data_type' => 'number',
					),
					'borderRadius' => array(
						'name'      => esc_html__( 'Image border radius', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 0,
						'max'       => 100,
						'default'   => 0,
						'priority'  => 20,
						'data_type' => 'number',
					),
					'borderColor'  => array(
						'name'      => esc_html__( 'Image border color', 'modula-best-grid-gallery' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'priority'  => 30,
						'data_type' => 'text',
					),
					'shadowSize'   => array(
						'name'      => esc_html__( 'Image shadow size', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 0,
						'max'       => 20,
						'default'   => 0,
						'priority'  => 40,
						'data_type' => 'number',
					),
					'shadowColor'  => array(
						'name'      => esc_html__( 'Image shadow color', 'modula-best-grid-gallery' ),
						'type'      => 'color',
						'default'   => '#ffffff',
						'priority'  => 50,
						'data_type' => 'text',
					),
				),
				'speedup'              => array(
					'lazy_load' => array(
						'name'      => esc_html__( 'Lazy Load', 'modula-best-grid-gallery' ),
						'type'      => 'toggle',
						'default'   => 1,
						'priority'  => 1,
						'data_type' => 'bool',
					),
				),
				'responsive'           => array(
					'enable_responsive' => array(
						'name'      => wp_kses_post( __( 'Custom responsiveness <br> (nr. of columns)', 'modula-best-grid-gallery' ) ),
						'type'      => 'toggle',
						'default'   => 0,
						'priority'  => 10,
						'children'  => array( 'tablet_columns', 'mobile_columns' ),
						'data_type' => 'bool',
					),
					'tablet_columns'    => array(
						'name'      => esc_html__( 'On tablet', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 1,
						'max'       => 6,
						'step'      => 1,
						'default'   => 2,
						'priority'  => 20,
						'data_type' => 'number',
					),
					'mobile_columns'    => array(
						'name'      => esc_html__( 'On mobile', 'modula-best-grid-gallery' ),
						'type'      => 'ui-slider',
						'min'       => 1,
						'max'       => 6,
						'step'      => 1,
						'default'   => 1,
						'priority'  => 30,
						'data_type' => 'number',
					),
				),
				'customizations'       => array(
					'style' => array(
						'name'      => '',
						'type'      => 'custom_code',
						'syntax'    => 'css',
						'priority'  => 20,
						'data_type' => 'string',
					),
				),
				'hidden'               => array(
					'last_visited_tab' => array(
						'name'      => '',
						'type'      => 'hidden',
						'priority'  => 20,
						'data_type' => 'string',
					),
				),
			)
		);

		// This is set for an incomaptibility with Modula SpeedUP, which deletes this field
		if ( ! isset( $fields['speedup']['lazy_load'] ) ) {
			$fields['speedup']['lazy_load'] = array(
				'name'     => esc_html__( 'Lazy Load', 'modula-best-grid-gallery' ),
				'type'     => 'toggle',
				'default'  => 1,
				'priority' => 0,
			);
		}

		if ( 'all' == $tab ) {
			return $fields;
		}

		if ( isset( $fields[ $tab ] ) ) {
			return $fields[ $tab ];
		} else {
			return array();
		}
	}

	public static function get_defaults() {
		return apply_filters(
			'modula_lite_default_settings',
			array(
				'type'                  => 'grid',
				'width'                 => '100%',
				'height'                => 800,
				'randomFactor'          => 50,
				'lightbox'              => 'fancybox',
				'show_navigation'       => 1,
				'shuffle'               => 0,
				'titleColor'            => '#ffffff',
				'captionColor'          => '#ffffff',
				'hide_title'            => 1,
				'hide_description'      => 0,
				'captionFontSize'       => 14,
				'titleFontSize'         => 16,
				'mobileCaptionFontSize' => 10,
				'mobileTitleFontSize'   => 12,
				'enableSocial'          => 0,
				'enableFacebook'        => 0,
				'enableLinkedin'        => 0,
				'enablePinterest'       => 0,
				'enableTwitter'         => 0,
				'enableWhatsapp'        => 0,
				'enableEmail'           => 0,
				'emailSubject'          => esc_html__( 'Check out this awesome image !!', 'modula-best-grid-gallery' ),
				'emailMessage'          => esc_html__( 'Here is the link to the image : %%image_link%% and this is the link to the gallery : %%gallery_link%% ', 'modula-best-grid-gallery' ),
				'filterClick'           => 0,
				'socialIconColor'       => '#ffffff',
				'socialIconSize'        => 16,
				'socialIconPadding'     => 10,
				'loadedScale'           => 100,
				'inView'                => 100,
				'cursor'                => 'zoom-in',
				'effect'                => 'pufrobo',
				'borderColor'           => '#ffffff',
				'borderRadius'          => '0',
				'borderSize'            => '0',
				'shadowColor'           => '#ffffff',
				'shadowSize'            => 0,
				'script'                => '',
				'style'                 => '',
				'columns'               => 6,
				'gutter'                => 10,
				'mobile_gutter'         => 10,
				'tablet_gutter'         => 10,
				'lazy_load'             => 1,
				'grid_type'             => 'automatic',
				'grid_image_size'       => 'medium',
				'grid_image_crop'       => 0,
				'grid_image_dimensions' => 600,
				'img_size'              => 200,
				'grid_row_height'       => 250,
				'grid_justify_last_row' => 'justify',
				'enable_responsive'     => 0,
				'last_visited_tab'      => 'modula-general',
			)
		);
	}
}
