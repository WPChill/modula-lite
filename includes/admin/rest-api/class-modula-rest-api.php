<?php

class Modula_Rest_Api {

	private $namespace = 'modula-best-grid-gallery/v1';

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		add_action( 'modula_settings_api_update_modula_roles', array( $this, 'set_capabilities' ) );
	}

	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/general-settings',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/general-settings',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/general-settings-tabs',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_tabs' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/video/youtube',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'youtube_action' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/video/vimeo',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'vimeo_action' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
	}

	public function get_settings() {
		// Retrieve settings
		$settings = get_option( 'modula_settings', array() );
		return new \WP_REST_Response( $settings, 200 );
	}

	public function get_tabs() {
		$subtabs = array(
			'standalone'      => array(
				'label'  => esc_html__( 'Standalone', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => $this->get_config( 'standalone' ),
			),
			'compression'     => array(
				'label'  => esc_html__( 'Performance', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => $this->get_config( 'compression' ),
			),
			'shortcodes'      => array(
				'label'  => esc_html__( 'Advanced Shortcodes', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => $this->get_config( 'shortcodes' ),
			),
			'watermark'       => array(
				'label'  => esc_html__( 'Watermark', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => $this->get_config( 'watermark' ),
			),
			'image_licensing' => array(
				'label'  => esc_html__( 'Image Licensing', 'modula-best-grid-gallery' ),
				'config' => $this->get_config( 'image_licensing' ),
			),
			'roles'           => array(
				'label'  => esc_html__( 'Roles', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => $this->get_config( 'roles' ),
			),
			'imageseo'        => array(
				'label' => esc_html__( 'Image SEO', 'modula-best-grid-gallery' ),
				'badge' => 'PRO',
			),
			'video'           => array(
				'label'  => esc_html__( 'Video', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => $this->get_config( 'video' ),
			),
			'instagram'       => array(
				'label'  => esc_html__( 'Instagram', 'modula-best-grid-gallery' ),
				'badge'  => 'PRO',
				'config' => apply_filters( 'modula_instagram_settings_tab', $this->get_config( 'instagram' ) ),
			),
		);

		$subtabs = apply_filters( 'modula_admin_page_subtabs', $subtabs );

		$tabs = array(
			array(
				'label'   => esc_html__( 'Display', 'modula-best-grid-gallery' ),
				'slug'    => 'display',
				'subtabs' => array(
					'standalone'      => $subtabs['standalone'],
					'shortcodes'      => $subtabs['shortcodes'],
					'image_licensing' => $subtabs['image_licensing'],
				),
			),
			array(
				'label'   => esc_html__( 'Optimization', 'modula-best-grid-gallery' ),
				'slug'    => 'optimization',
				'subtabs' => array(
					'compression' => $subtabs['compression'],
					'imageseo'    => $subtabs['modula_ai'],
				),
			),
			array(
				'label'   => esc_html__( 'Protection', 'modula-best-grid-gallery' ),
				'slug'    => 'protection',
				'subtabs' => array(
					'watermark' => $subtabs['watermark'],
					'roles'     => $subtabs['roles'],
				),
			),
			array(
				'label'   => esc_html__( 'Social Media', 'modula-best-grid-gallery' ),
				'slug'    => 'social_media',
				'subtabs' => array(
					'instagram' => $subtabs['instagram'],
					'video'     => $subtabs['video'],
				),
			),
		);
		$tabs = apply_filters( 'modula_admin_page_main_tabs', $tabs );

		return new \WP_REST_Response( $tabs, 200 );
	}

	public function youtube_action( $request ) {
		$data = $request->get_json_params();

		if ( empty( $data ) || empty( $data['action'] ) ) {
			return new \WP_REST_Response( 'No action to take.', 400 );
		}

		if ( class_exists( 'Modula_Video' ) && ! class_exists( 'Modula_Video_Google_Auth' ) ) {
			require_once WP_PLUGIN_DIR . '/modula-video/includes/admin/class-modula-video-google-auth.php';
		}

		if ( class_exists( 'Modula_Video_Google_Auth' ) ) {
			$youtube_oauth = Modula_Video_Google_Auth::get_instance();
			if ( 'refresh' === $data['action'] ) {
				$youtube_oauth->refresh_token( false );
			} elseif ( 'disconnect' === $data['action'] ) {
				delete_option( Modula_Video_Google_Auth::$accessToken );
				delete_option( Modula_Video_Google_Auth::$refreshToken );
				delete_option( Modula_Video_Google_Auth::$expiryDate );
			}
		}

		return new \WP_REST_Response( true, 200 );
	}

	public function vimeo_action( $request ) {
		$data = $request->get_json_params();

		if ( empty( $data ) || empty( $data['action'] ) ) {
			return new \WP_REST_Response( 'No action to take.', 400 );
		}

		if ( class_exists( 'Modula_Video' ) && ! class_exists( 'Modula_Video_Vimeo_Auth' ) ) {
			require_once WP_PLUGIN_DIR . '/modula-video/includes/admin/class-modula-video-vimeo-auth.php';
		}

		if ( class_exists( 'Modula_Video_Vimeo_Auth' ) ) {
			$youtube_oauth = Modula_Video_Vimeo_Auth::get_instance();
			if ( 'disconnect' === $data['action'] ) {
				delete_option( Modula_Video_Vimeo_Auth::$accessToken );
			}
		}

		return new \WP_REST_Response( true, 200 );
	}

	private function get_config( $subtab = false ) {
		$wpchill_upsell = false;
		if ( class_exists( 'WPChill_Upsells' ) ) {

			// Initialize WPChill upsell class
			$args = apply_filters(
				'modula_upsells_args',
				array(
					'shop_url' => 'https://wp-modula.com',
					'slug'     => 'modula',
				)
			);

			$wpchill_upsell = WPChill_Upsells::get_instance( $args );
		}

		// Get saved values
		$standalone  = get_option( 'modula_standalone', array() );
		$shortcodes  = get_option( 'mas_gallery_link', 'gallery_id' );
		$licensing   = get_option( 'modula_image_licensing_option', array() );
		$compression = get_option( 'modula_speedup', array() );
		$watermark   = get_option( 'modula_watermark', array() );
		$vimeo_creds = get_option( 'modula_video_vimeo_creds', array() );

		$youtube = array();
		$vimeo   = array();
		if ( class_exists( 'Modula_Video' ) ) {
			if ( ! class_exists( 'Modula_Video_Google_Auth' ) ) {
				require_once WP_PLUGIN_DIR . '/modula-video/includes/admin/class-modula-video-google-auth.php';
			}
			if ( ! class_exists( 'Modula_Video_Vimeo_Auth' ) ) {
				require_once WP_PLUGIN_DIR . '/modula-video/includes/admin/class-modula-video-vimeo-auth.php';
			}
		}

		if ( class_exists( 'Modula_Video_Google_Auth' ) ) {
			$youtube_oauth = Modula_Video_Google_Auth::get_instance();
			$youtube       = array(
				'type'        => 'combo',
				'fields'      => array(),
				'group'       => 'yt',
				// translators: %s placeholders are for the opening and closing anchor tags.
				'description' => sprintf( esc_html__( 'If you need step by step instructions on how to connect your account, please read our online %1$sknowledgebase article%2$s on this topic.', 'modula-best-grid-gallery' ), '<a href="https://wp-modula.com/kb/how-to-connect-modula-to-youtube-and-add-video-playlists-to-your-galleries/" target="_blank">', '</a>' ),

			);
			if ( ! $youtube_oauth->get_access_token() ) {
				$youtube['fields'][] = array(
					'type'    => 'button',
					'variant' => 'primary',
					'name'    => 'connect',
					'label'   => esc_html__( 'Connect your account', 'modula-best-grid-gallery' ),
					'text'    => esc_html__( 'Sign in with Google', 'modula-best-grid-gallery' ),
					'href'    => esc_url( $youtube_oauth->create_request_url() ),
				);
			} elseif ( $youtube_oauth->is_token_expired() ) {
				$youtube['fields'][] = array(
					'type'    => 'button',
					'variant' => 'primary',
					'name'    => 'connect',
					'label'   => esc_html__( 'Connect your account', 'modula-best-grid-gallery' ),
					'text'    => esc_html__( 'Refresh token', 'modula-best-grid-gallery' ),
					'api'     => array(
						'path'   => '/modula-best-grid-gallery/v1/video/youtube/',
						'method' => 'POST',
						'data'   => array( 'action' => 'refresh' ),
					),
				);
				$youtube['fields'][] = array(
					'type'    => 'button',
					'variant' => 'primary',
					'name'    => 'connect',
					'text'    => esc_html__( 'Disconnect', 'modula-best-grid-gallery' ),
					'api'     => array(
						'path'   => '/modula-best-grid-gallery/v1/video/youtube/',
						'method' => 'POST',
						'data'   => array( 'action' => 'disconnect' ),
					),
				);
			} else {
				$youtube['fields'][] = array(
					'type'    => 'button',
					'variant' => 'primary',
					'name'    => 'connect',
					'label'   => esc_html__( 'Connect your account', 'modula-best-grid-gallery' ),
					'text'    => esc_html__( 'Disconnect', 'modula-best-grid-gallery' ),
					'api'     => array(
						'path'   => '/modula-best-grid-gallery/v1/video/youtube/',
						'method' => 'POST',
						'data'   => array( 'action' => 'disconnect' ),
					),
				);
			}
		}

		if ( class_exists( 'Modula_Video_Google_Auth' ) ) {
			$vimeo_oauth = Modula_Video_Vimeo_Auth::get_instance();

			if ( ! $vimeo_oauth->get_access_token() ) {
				$redirect_uri = admin_url( '/edit.php?post_type=modula-gallery&page=modula&modula-tab=video&sub=vi&action=save_modula_video_vimeo_token' );
				$client       = ! empty( $vimeo_creds['client_id'] ) ? $vimeo_creds['client_id'] : false;
				$vimeo        = array(
					'type'        => 'button',
					'variant'     => 'primary',
					'name'        => 'connect',
					'label'       => esc_html__( 'Connect your account', 'modula-best-grid-gallery' ),
					'text'        => $client ? esc_html__( 'Connect to Vimeo', 'modula-best-grid-gallery' ) : esc_html__( 'Save your credentials', 'modula-best-grid-gallery' ),
					'href'        => 'https://api.vimeo.com/oauth/authorize?response_type=code&client_id=' . $client . '&redirect_uri=' . rawurlencode( $redirect_uri ) . '&scope=public',
					'disabled'    => ! $client,
					'group'       => 'vi',
					// translators: %s placeholders are for the opening and closing anchor tags.
					'description' => sprintf( esc_html__( 'If you need step by step instructions on how to connect your account, please read our online %1$sknowledgebase article%2$s on this topic.', 'modula-best-grid-gallery' ), '<a href="https://wp-modula.com/kb/how-to-connect-modula-to-vimeo-and-add-video-playlists-to-your-galleries/" target="_blank">', '</a>' ),

				);
			} else {
				$vimeo = array(
					'type'        => 'button',
					'variant'     => 'primary',
					'name'        => 'connect',
					'label'       => esc_html__( 'Connect your account', 'modula-best-grid-gallery' ),
					'text'        => esc_html__( 'Disconnect from Vimeo', 'modula-best-grid-gallery' ),
					'api'         => array(
						'path'   => '/modula-best-grid-gallery/v1/video/vimeo/',
						'method' => 'POST',
						'data'   => array( 'action' => 'disconnect' ),
					),
					'group'       => 'vi',
					// translators: %s placeholders are for the opening and closing anchor tags.
					'description' => sprintf( esc_html__( 'If you need step by step instructions on how to connect your account, please read our online %1$sknowledgebase article%2$s on this topic.', 'modula-best-grid-gallery' ), '<a href="https://wp-modula.com/kb/how-to-connect-modula-to-vimeo-and-add-video-playlists-to-your-galleries/" target="_blank">', '</a>' ),

				);
			}
		}

		$compression_values = array(
			array(
				'label' => esc_html__( 'Lossless Compresion', 'modula-best-grid-gallery' ),
				'value' => 'lossless',
			),
			array(
				'label' => esc_html__( 'Lossy Compresion', 'modula-best-grid-gallery' ),
				'value' => 'lossy',
			),
			array(
				'label' => esc_html__( 'Glossy Compresion', 'modula-best-grid-gallery' ),
				'value' => 'glossy',
			),
			array(
				'label' => esc_html__( 'Disable Compresion', 'modula-best-grid-gallery' ),
				'value' => 'disabled',
			),
		);

		$watermark_values = array(
			array(
				'label' => esc_html__( 'Top left', 'modula-best-grid-gallery' ),
				'value' => 'top_left',
			),
			array(
				'label' => esc_html__( 'Top right', 'modula-best-grid-gallery' ),
				'value' => 'top_right',
			),
			array(
				'label' => esc_html__( 'Bottom right', 'modula-best-grid-gallery' ),
				'value' => 'bottom_right',
			),
			array(
				'label' => esc_html__( 'Bottom left', 'modula-best-grid-gallery' ),
				'value' => 'bottom_left',
			),
			array(
				'label' => esc_html__( 'Center', 'modula-best-grid-gallery' ),
				'value' => 'center',
			),
		);
		$licenses         = array();

		foreach ( Modula_Helper::get_image_licenses() as $slug => $license ) {
			$licenses[] = array(
				'value' => $slug,
				'image' => $license['image'],
				'label' => $license['license'],
				'name'  => $license['name'],
			);
		}

		$configs = array(
			'standalone'      => array(
				'option' => 'modula_standalone',
				'fields' => array(
					array(
						'type'       => 'options_toggle',
						'name'       => 'gallery.enable_rewrite',
						'label'      => 'Enable Galleries Link',
						'default'    => ( isset( $standalone['gallery'] ) && isset( $standalone['gallery']['enable_rewrite'] ) ) ? $standalone['gallery']['enable_rewrite'] : 'disabled',
						'trueValue'  => 'enabled',
						'falseValue' => 'disabled',
					),
					array(
						'type'       => 'text',
						'name'       => 'gallery.slug',
						'label'      => 'Gallery Slug',
						'default'    => ( isset( $standalone['gallery'] ) && isset( $standalone['gallery']['slug'] ) ) ? $standalone['gallery']['slug'] : 'modula-gallery',
						'conditions' => array(
							array(
								'field'      => 'gallery.enable_rewrite',
								'comparison' => '===',
								'value'      => 'enabled',
							),
						),
					),
					array(
						'type'       => 'options_toggle',
						'name'       => 'album.enable_rewrite',
						'label'      => 'Enable Albums Link',
						'default'    => ( isset( $standalone['album'] ) && isset( $standalone['album']['enable_rewrite'] ) ) ? $standalone['album']['enable_rewrite'] : 'disabled',
						'trueValue'  => 'enabled',
						'falseValue' => 'disabled',
					),
					array(
						'type'       => 'text',
						'name'       => 'album.slug',
						'label'      => 'Album Slug',
						'default'    => ( isset( $standalone['album'] ) && isset( $standalone['album']['slug'] ) ) ? $standalone['album']['slug'] : 'modula-gallery',
						'conditions' => array(
							array(
								'field'      => 'album.enable_rewrite',
								'comparison' => '===',
								'value'      => 'enabled',
							),
						),
					),
				),
			),
			'shortcodes'      => array(
				'fields' => array(
					array(
						'type'        => 'text',
						'name'        => 'mas_gallery_link',
						'label'       => 'Gallery link attribute',
						'default'     => $shortcodes,
						'description' => sprintf( 'Add this shortcode <input type="text" readonly="" value="[modula_all_galleries]"> on the page/post/product you want to display your galleries.  Then add at the end of that url :<i> ?%s=[gallery_id], where [gallery_id] is the ID of the gallery. </i>', $shortcodes ),
					),
				),
			),
			'image_licensing' => array(
				'option' => 'modula_image_licensing_option',
				'fields' => array(
					array(
						'type'   => 'combo',
						'fields' => array(
							array(
								'type'    => 'text',
								'name'    => 'image_licensing_author',
								'label'   => 'Author',
								'default' => isset( $licensing['image_licensing_author'] ) ? $licensing['image_licensing_author'] : '',
							),
							array(
								'type'    => 'text',
								'name'    => 'image_licensing_company',
								'label'   => 'Company',
								'default' => isset( $licensing['image_licensing_company'] ) ? $licensing['image_licensing_company'] : '',
							),
						),
					),
					array(
						'type'    => 'ia_radio',
						'name'    => 'image_licensing',
						'label'   => 'Choose license type',
						'default' => isset( $licensing['image_licensing'] ) ? $licensing['image_licensing'] : 'none',
						'options' => $licenses,
					),
					array(
						'type'    => 'toggle',
						'name'    => 'display_with_description',
						'label'   => 'Display licensing under gallery',
						'default' => isset( $licensing['display_with_description'] ) ? $licensing['display_with_description'] : '',
					),
				),
			),
			'compression'     => array(
				'option' => 'modula_speedup',
				'fields' => array(
					array(
						'type'       => 'options_toggle',
						'name'       => 'enable_optimization',
						'label'      => 'Compression',
						'default'    => isset( $compression['enable_optimization'] ) ? $compression['enable_optimization'] : 'enabled',
						'trueValue'  => 'enabled',
						'falseValue' => 'disabled',
					),
					array(
						'type'    => 'select',
						'name'    => 'thumbnail_optimization',
						'label'   => 'Thumbnail Compression',
						'default' => isset( $compression['thumbnail_optimization'] ) ? $compression['thumbnail_optimization'] : 'lossy',
						'options' => $compression_values,
					),
					array(
						'type'    => 'select',
						'name'    => 'lightbox_optimization',
						'label'   => 'Lightbox Compression',
						'default' => isset( $compression['lightbox_optimization'] ) ? $compression['lightbox_optimization'] : 'lossless',
						'options' => $compression_values,
					),
				),
			),
			'watermark'       => array(
				'option' => 'modula_watermark',
				'fields' => array(
					array(
						'type'    => 'image_select',
						'name'    => 'watermark_image',
						'label'   => 'Watermark Image',
						'default' => isset( $watermark['watermark_image'] ) ? $watermark['watermark_image'] : null,
						'src'     => isset( $watermark['watermark_image'] ) ? wp_get_attachment_image_url( absint( $watermark['watermark_image'] ) ) : null,
					),
					array(
						'type'    => 'select',
						'name'    => 'watermark_position',
						'label'   => 'Watermark Position',
						'default' => isset( $watermark['watermark_position'] ) ? $watermark['watermark_position'] : 'bottom_right',
						'options' => $watermark_values,
					),
					array(
						'type'    => 'range_select',
						'name'    => 'watermark_margin',
						'label'   => 'Watermark Margin',
						'default' => isset( $watermark['watermark_margin'] ) ? $watermark['watermark_margin'] : 10,
						'min'     => 0,
						'max'     => 50,
					),
					array(
						'type'   => 'combo',
						'fields' => array(
							array(
								'type'    => 'number',
								'name'    => 'watermark_image_dimension_width',
								'label'   => 'Width',
								'default' => isset( $watermark['watermark_image_dimension_width'] ) ? $watermark['watermark_image_dimension_width'] : 0,
							),
							array(
								'type'    => 'number',
								'name'    => 'watermark_image_dimension_height',
								'label'   => 'Height',
								'default' => isset( $watermark['watermark_image_dimension_height'] ) ? $watermark['watermark_image_dimension_height'] : 0,
							),
						),
					),
					array(
						'type'    => 'toggle',
						'name'    => 'watermark_enable_backup',
						'label'   => 'Enable image backup',
						'default' => isset( $watermark['watermark_enable_backup'] ) ? $watermark['watermark_enable_backup'] : '',
					),
				),
			),
			'roles'           => array(
				'option' => 'modula_roles',
				'fields' => array_merge( $this->get_roles(), $this->get_album_roles() ),
			),
			'instagram'       => array(
				'fields' => array(
					array(
						'type'  => 'button',
						'label' => 'Connect your account',
						'text'  => ! Modula\Instagram\OAuth::get_instance()->get_access_token() ? esc_html__( 'Start connection', 'modula-best-grid-gallery' ) : esc_html__( 'Disconnect', 'modula-best-grid-gallery' ),
						'href'  => ! Modula\Instagram\OAuth::get_instance()->get_access_token() ? esc_url( Modula\Instagram\OAuth::get_instance()->create_request_url() ) : '#',
						'api'   => ! Modula\Instagram\OAuth::get_instance()->get_access_token() ? false : array(
							'path'   => '/modula-instagram/v1/token/disconnect/',
							'method' => 'POST',
							'data'   => array(),
						),
					),
				),
			),
			'video'           => array(
				'submenu' => array(
					'class'   => 'modula_video_submenu',
					'options' => array(
						array(
							'label' => esc_html__( 'YouTube', 'modula-best-grid-gallery' ),
							'value' => 'yt',
						),
						array(
							'label' => esc_html__( 'Vimeo', 'modula-best-grid-gallery' ),
							'value' => 'vi',
						),
					),
				),
				'fields'  => array(
					$youtube,
					array(
						'type'    => 'text',
						'name'    => 'modula_video_vimeo_creds.client_id',
						'label'   => esc_html__( 'Vimeo Client ID', 'modula-best-grid-gallery' ),
						'default' => isset( $vimeo_creds['client_id'] ) ? $vimeo_creds['client_id'] : '',
						'group'   => 'vi',
					),
					array(
						'type'    => 'text',
						'name'    => 'modula_video_vimeo_creds.client_secret',
						'label'   => esc_html__( 'Vimeo Client Secret', 'modula-best-grid-gallery' ),
						'default' => isset( $vimeo_creds['client_secret'] ) ? $vimeo_creds['client_secret'] : '',
						'group'   => 'vi',
					),
					array(
						'type'     => 'text',
						'name'     => 'vimeo_redirect_uri',
						'label'    => esc_html__( 'Vimeo RedirectURI', 'modula-best-grid-gallery' ),
						'default'  => admin_url( '/edit.php?post_type=modula-gallery&page=modula&modula-tab=video&sub=vi&action=save_modula_video_vimeo_token' ),
						'readonly' => true,
						'group'    => 'vi',
					),
					$vimeo,
				),
			),
		);

		if ( class_exists( 'Modula_Albums' ) ) {
			$configs['roles']['submenu'] = array(
				'class'   => 'modula_roles_submenu',
				'options' => array(
					array(
						'label' => esc_html__( 'Gallery', 'modula-best-grid-gallery' ),
						'value' => 'gallery',
					),
					array(
						'label' => esc_html__( 'Album', 'modula-best-grid-gallery' ),
						'value' => 'album',
					),
				),
			);
		}

		if ( $subtab ) {
			if ( isset( $configs[ $subtab ] ) ) {
				return $configs[ $subtab ];
			} else {
				return array();
			}
		}

		return $configs;
	}

	private function get_roles() {

		global $wp_roles;
		$options      = get_option( 'modula_roles' );
		$roles_array  = array();
		$capabilities = array(
			'edit_galleries'          => __( 'View & Edit Own Gallery', 'modula-best-grid-gallery' ),
			'edit_other_galleries'    => __( 'Edit Others Galleries', 'modula-best-grid-gallery' ),
			'publish_galleries'       => __( 'Publish Galleries', 'modula-best-grid-gallery' ),
			'delete_galleries'        => __( 'Delete Own Galleries', 'modula-best-grid-gallery' ),
			'delete_others_galleries' => __( 'Delete Others Galleries', 'modula-best-grid-gallery' ),
			'read_private_galleries'  => __( 'Edit Private Galleries', 'modula-best-grid-gallery' ),
		);

		foreach ( $wp_roles->roles as $key => $wp_role ) {
			if ( 'administrator' === $key ) {
				continue;
			}
			$role       = get_role( $key );
			$role_array = array(
				'type'    => 'role',
				'name'    => $key . '.enabled',
				'label'   => translate_user_role( $wp_role['name'] ),
				'default' => $this->is_role_enabled( $key, $options, $capabilities ),
				'fields'  => array(),
				'group'   => 'gallery',
			);

			foreach ( $capabilities as $capability => $capability_name ) {
				$role_array['fields'][] = array(
					'type'    => 'toggle',
					'name'    => $key . '.' . $capability,
					'label'   => $capability_name,
					'default' => $role->has_cap( $capability ),
				);
			}

			if ( ! in_array( $key, array( 'editor', 'author' ), true ) ) {
				$role_array['fields'][] = array(
					'type'    => 'toggle',
					'name'    => $key . '.upload_files',
					'label'   => __( 'Upload Files', 'modula-best-grid-gallery' ),
					'default' => $role->has_cap( 'upload_files' ),
				);
			}

			$roles_array[] = $role_array;
		}

		return $roles_array;
	}

	private function get_album_roles() {

		if ( ! class_exists( 'Modula_Albums' ) ) {
			return array();
		}

		global $wp_roles;
		$options     = get_option( 'modula_roles' );
		$roles_array = array();

		$album_capabilities = array(
			'edit_albums'          => __( 'View & Edit Own Albums', 'modula-best-grid-gallery' ),
			'edit_others_albums'   => __( 'Edit Others Albums', 'modula-best-grid-gallery' ),
			'publish_albums'       => __( 'Publish Albums', 'modula-best-grid-gallery' ),
			'delete_albums'        => __( 'Delete Own Albums', 'modula-best-grid-gallery' ),
			'delete_others_albums' => __( 'Delete Others Albums', 'modula-best-grid-gallery' ),
			'read_private_albums'  => __( 'Edit Private Albums', 'modula-best-grid-gallery' ),
		);

		foreach ( $wp_roles->roles as $key => $wp_role ) {
			if ( 'administrator' === $key ) {
				continue;
			}
			$role       = get_role( $key );
			$role_array = array(
				'type'    => 'role',
				'name'    => $key . '_album.enabled',
				'label'   => translate_user_role( $wp_role['name'] ),
				'default' => $this->is_role_enabled( $key . '_album', $options, $album_capabilities ),
				'fields'  => array(),
				'group'   => 'album',
			);

			foreach ( $album_capabilities as $capability => $capability_name ) {
				$role_array['fields'][] = array(
					'type'    => 'toggle',
					'name'    => $key . '.' . $capability,
					'label'   => $capability_name,
					'default' => $role->has_cap( $capability ),
				);
			}

			if ( ! in_array( $key, array( 'editor', 'author' ), true ) ) {
				$role_array['fields'][] = array(
					'type'    => 'toggle',
					'name'    => $key . '.upload_files',
					'label'   => __( 'Upload Files', 'modula-best-grid-gallery' ),
					'default' => $role->has_cap( 'upload_files' ),
				);
			}

			$roles_array[] = $role_array;
		}

		return $roles_array;
	}

	private function is_role_enabled( $key, $options, $capabilities ) {
		if ( ! isset( $options[ $key ]['enabled'] ) ) {
			$role = get_role( $key );
			foreach ( $capabilities as $cap => $cap_name ) {
				if ( $role->has_cap( $cap ) ) {
					return true;
				}
			}
		} elseif ( true === boolval( $options[ $key ]['enabled'] ) ) {
				return true;
		}

		return false;
	}

	public function set_capabilities( $settings ) {
		$roles = new Modula_Roles();
		$roles->sanitize_option( $settings );
	}

	public function update_settings( $request ) {
		$settings = $request->get_json_params();

		if ( empty( $settings ) || ! is_array( $settings ) ) {
			return new \WP_REST_Response( 'No settings to save.', 400 );
		}

		foreach ( $settings as $option => $value ) {
			update_option( $option, $value );

			do_action( 'modula_settings_api_update_' . $option, $value );
		}

		return new \WP_REST_Response( $settings, 200 );
	}

	public function settings_permissions_check() {

		// Check if the user has the capability to manage options
		return current_user_can( 'manage_options' );
	}
}
