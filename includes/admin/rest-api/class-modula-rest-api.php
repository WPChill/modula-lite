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
				'label' => esc_html__( 'Video', 'modula-best-grid-gallery' ),
				'badge' => 'PRO',
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
			array(
				'label' => esc_html__( 'Migrate', 'modula-best-grid-gallery' ),
				'slug'  => 'migrate',
			),

		);
		$tabs = apply_filters( 'modula_admin_page_main_tabs', $tabs );

		return new \WP_REST_Response( $tabs, 200 );
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
						'type'    => 'toggle',
						'name'    => 'gallery.enable_rewrite',
						'label'   => 'Enable Galleries Link',
						'default' => ( isset( $standalone['gallery'] ) && isset( $standalone['gallery']['enable_rewrite'] ) && 'enabled' === $standalone['gallery']['enable_rewrite'] ),
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
								'value'      => true,
							),
						),
					),
					array(
						'type'    => 'toggle',
						'name'    => 'album.enable_rewrite',
						'label'   => 'Enable Albums Link',
						'default' => ( isset( $standalone['album'] ) && isset( $standalone['album']['enable_rewrite'] ) && 'enabled' === $standalone['album']['enable_rewrite'] ),
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
								'value'      => true,
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
						'default' => isset( $compression['watermark_position'] ) ? $compression['watermark_position'] : 'bottom_right',
						'options' => $watermark_values,
					),
					array(
						'type'    => 'range_select',
						'name'    => 'watermark_margin',
						'label'   => 'Watermark Margin',
						'default' => isset( $compression['watermark_margin'] ) ? $compression['watermark_margin'] : 10,
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
								'default' => isset( $compression['watermark_image_dimension_width'] ) ? $compression['watermark_image_dimension_width'] : 0,
							),
							array(
								'type'    => 'number',
								'name'    => 'watermark_image_dimension_height',
								'label'   => 'Height',
								'default' => isset( $compression['watermark_image_dimension_height'] ) ? $compression['watermark_image_dimension_height'] : 0,
							),
						),
					),
					array(
						'type'    => 'toggle',
						'name'    => 'watermark_enable_backup',
						'label'   => 'Enable image backup',
						'default' => isset( $licensing['watermark_enable_backup'] ) ? $licensing['watermark_enable_backup'] : '',
					),
				),
			),
			'roles'           => array(
				'option' => 'modula_roles',
				'fields' => $this->get_roles(),
			),
			'instagram'       => array(
				'fields' => array(
					array(
						'type'  => 'button',
						'text'  => 'Connect your account',
						'label' => ! Modula\Instagram\OAuth::get_instance()->get_access_token() ? esc_html__( 'Start connection', 'modula-best-grid-gallery' ) : esc_html__( 'Disconnect', 'modula-best-grid-gallery' ),
						'href'  => ! Modula\Instagram\OAuth::get_instance()->get_access_token() ? esc_url( Modula\Instagram\OAuth::get_instance()->create_request_url() ) : '#',
					),
				),
			),
		);

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
			);

			foreach ( $capabilities as $capability => $capability_name ) {
				if ( 'edit_gallery' === $capability ) {
					continue;
				}
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
		$roles->sanitize_option( $settings['value'] );
	}

	public function update_settings( $request ) {
		// Update settings
		$settings = $request->get_json_params();

		if ( ! isset( $settings['option'] ) ) {
			return new \WP_REST_Response( 'missing option name', 400 );
		}

		do_action( 'modula_settings_api_update_' . $settings['option'], $settings );

		update_option( $settings['option'], $settings['value'] );
		return new \WP_REST_Response( $settings, 200 );
	}

	public function settings_permissions_check() {
		return true;
		// Check if the user has the capability to manage options
		return current_user_can( 'manage_options' );
	}
}
