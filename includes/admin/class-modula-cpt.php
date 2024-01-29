<?php

/**
 * The cpt plugin class.
 *
 * This is used to define the custom post type that will be used for galleries
 *
 * @since      2.0.0
 */
class Modula_CPT {

	private $labels    = array();
	private $args      = array();
	private $metaboxes = array();
	private $cpt_name;
	private $builder;
	private $resizer;

	public function __construct() {

		$this->cpt_name = apply_filters( 'modula_cpt_name', 'modula-gallery' );

		add_action( 'init', array( $this, 'register_cpt' ) );
		//Bring the settings in Rest
		add_action( 'rest_api_init', array( $this, 'register_post_meta_rest') );

		/* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'admin_menu', array( $this, 'replace_submit_meta_box' ) );

		add_filter( 'views_edit-modula-gallery', array( $this, 'add_extensions_tab_onboarding' ), 10, 1 );
		// Post Table Columns
		add_filter( "manage_{$this->cpt_name}_posts_columns", array( $this, 'add_columns' ) );
		add_action( "manage_{$this->cpt_name}_posts_custom_column", array( $this, 'outpu_column' ), 10, 2 );

		add_filter( 'submenu_file', array( $this, 'remove_add_new_submenu_item' ) );

		// Add the last visited tab to link
		add_filter( 'get_edit_post_link', array( $this, 'modula_remember_tab' ), 2, 99 );
		add_action( 'wp_ajax_modula_remember_tab', array( $this, 'modula_remember_tab_save' ) );

		/* Load Fields Helper */
		require_once MODULA_PATH . 'includes/admin/class-modula-cpt-fields-helper.php';

		/* Load Builder */
		require_once MODULA_PATH . 'includes/admin/class-modula-field-builder.php';
		$this->builder = Modula_Field_Builder::get_instance();

		/* Initiate Image Resizer */
		$this->resizer = new Modula_Image();

		// Ajax for removing notices
		add_action( 'wp_ajax_modula-edit-notice', array( $this, 'dismiss_edit_notice' ) );

	}

	public function register_cpt() {

		$this->labels = apply_filters( 'modula_cpt_labels', array(
			'name'                  => esc_html__( 'Modula Galleries', 'modula-best-grid-gallery' ),
			'singular_name'         => esc_html__( 'Gallery', 'modula-best-grid-gallery' ),
			'menu_name'             => esc_html__( 'Modula', 'modula-best-grid-gallery' ),
			'name_admin_bar'        => esc_html__( 'Modula', 'modula-best-grid-gallery' ),
			'archives'              => esc_html__( 'Item Archives', 'modula-best-grid-gallery' ),
			'attributes'            => esc_html__( 'Item Attributes', 'modula-best-grid-gallery' ),
			'parent_item_colon'     => esc_html__( 'Parent Item:', 'modula-best-grid-gallery' ),
			'all_items'             => esc_html__( 'Galleries', 'modula-best-grid-gallery' ),
			'add_new_item'          => esc_html__( 'Add New Item', 'modula-best-grid-gallery' ),
			'add_new'               => esc_html__( 'Add New', 'modula-best-grid-gallery' ),
			'new_item'              => esc_html__( 'New Item', 'modula-best-grid-gallery' ),
			'edit_item'             => esc_html__( 'Edit Item', 'modula-best-grid-gallery' ),
			'update_item'           => esc_html__( 'Update Item', 'modula-best-grid-gallery' ),
			'view_item'             => esc_html__( 'View Item', 'modula-best-grid-gallery' ),
			'view_items'            => esc_html__( 'View Items', 'modula-best-grid-gallery' ),
			'search_items'          => esc_html__( 'Search Item', 'modula-best-grid-gallery' ),
			'not_found'             => '<a href="'.admin_url('post-new.php?post_type=modula-gallery').'">'.esc_html__( 'Add your first gallery ','modula-best-grid-gallery').'</a>'.esc_html__('now or check out our ','modula-best-grid-gallery'). '<a href="'.esc_url('https://wp-modula.com/knowledge-base/').'" target="_blank">'.esc_html__('documentation ','modula-best-grid-gallery').'</a>'.esc_html__('if you need help figuring things out.', 'modula-best-grid-gallery' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'modula-best-grid-gallery' ),
			'featured_image'        => esc_html__( 'Featured Image', 'modula-best-grid-gallery' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'modula-best-grid-gallery' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'modula-best-grid-gallery' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'modula-best-grid-gallery' ),
			'insert_into_item'      => esc_html__( 'Insert into item', 'modula-best-grid-gallery' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'modula-best-grid-gallery' ),
			'items_list'            => esc_html__( 'Items list', 'modula-best-grid-gallery' ),
			'items_list_navigation' => esc_html__( 'Items list navigation', 'modula-best-grid-gallery' ),
			'filter_items_list'     => esc_html__( 'Filter items list', 'modula-best-grid-gallery' ),
		), $this->labels );

		$this->args = apply_filters( 'modula_cpt_args', array(
			'label'               => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' ),
			'description'         => esc_html__( 'Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.', 'modula-best-grid-gallery' ),
			'supports'            => array( 'title' ),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 25,
			'menu_icon'           => MODULA_URL . 'assets/images/modula.png',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'rewrite'             => false,
			'show_in_rest'        => true,
		) );

		$this->metaboxes = array(
			'modula-preview-gallery' => array(
				'title'    => esc_html__( 'Gallery', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_images',
				'context'  => 'normal',
				'priority' => 10,
			),
			'modula-settings'        => array(
				'title'    => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_settings',
				'context'  => 'normal',
				'priority' => 20,
			),
			'modula-shortcode'       => array(
				'title'    => esc_html__( 'Shortcode', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_shortcode',
				'context'  => 'side',
				'priority' => 10,
			),
		);

		$args           = $this->args;
		$args['labels'] = $this->labels;

		register_post_type( $this->cpt_name, $args );

	}

	/**
	 * Rest field for modula settings
	 *
	 * @since 2.5.0
	 */
	public function register_post_meta_rest() {
		register_rest_field( 'modula-gallery', 'modulaSettings', array(
			'get_callback' => function( $post_arr ) {
				return get_post_meta( $post_arr['id'], 'modula-settings', true );
			},
		) );
	}

	/**
	 * Remove Add New link from menu item
	 *
	 * @param $submenu_file
	 *
	 * @return mixed
	 *
	 * @since 2.3.4
	 */
	public function remove_add_new_submenu_item( $submenu_file ) {
		remove_submenu_page( 'edit.php?post_type=modula-gallery', 'post-new.php?post_type=modula-gallery' );

		return $submenu_file;
	}

	public function meta_boxes_setup() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 2 );
	}

	public function add_meta_boxes() {

		global $post;
		$this->metaboxes = apply_filters( 'modula_cpt_metaboxes', $this->metaboxes );

		// Sort tabs based on priority.
		uasort( $this->metaboxes, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		foreach ( $this->metaboxes as $metabox_id => $metabox ) {

			if ( 'modula-shortcode' == $metabox_id && 'auto-draft' == $post->post_status ) {
				continue;
			}

			add_meta_box(
				$metabox_id,      // Unique ID
				$metabox['title'],    // Title
				array( $this, $metabox['callback'] ),   // Callback function
				'modula-gallery',         // Admin page (or post type)
				$metabox['context'],         // Context
				'high'         // Priority
			);
		}

	}

	public function output_gallery_images() {
		$this->builder->render( 'gallery' );
	}

	public function output_gallery_settings() {
		$this->builder->render( 'settings' );
	}

	public function output_gallery_shortcode( $post ) {
		$this->builder->render( 'shortcode', $post );
	}

	public function save_meta_boxes( $post_id, $post ) {

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) || 'modula-gallery' != $post_type->name ) {
			return $post_id;
		}

		if ( isset( $_POST['modula-settings'] ) ) {

			$fields_with_tabs = Modula_CPT_Fields_Helper::get_fields( 'all' );

			// Here we will save all our settings
			$modula_settings = array();

			// We will save only our settings.
			foreach ( $fields_with_tabs as $tab => $fields ) {

				// We will iterate through all fields of current tab
				foreach ( $fields as $field_id => $field ) {

					if ( isset( $_POST['modula-settings'][$field_id] ) ) {
						
						// Values for selects
						$lightbox_values = apply_filters( 'modula_lightbox_values', array( 'no-link', 'direct', 'fancybox', 'external-url' ) );
						$effect_values   = apply_filters( 'modula_effect_values', array( 'none', 'pufrobo' ) );
						$cursor_value    = apply_filters( 'modula_cursor_values', array( 'pointer', 'zoom-in' ) );

						switch ( $field_id ) {
							case 'description':
								$modula_settings[$field_id] = wp_filter_post_kses( $_POST['modula-settings'][$field_id] );
								break;
							case 'randomFactor':
							case 'captionFontSize':
							case 'titleFontSize':
							case 'loadedScale':
							case 'inView':
							case 'borderSize':
							case 'borderRadius':
							case 'shadowSize':
							case 'socialIconSize':
							case 'socialIconPadding':
								$modula_settings[$field_id] = absint( $_POST['modula-settings'][$field_id] );
								break;
							case 'lightbox' :
								if ( in_array( $_POST['modula-settings'][$field_id], $lightbox_values ) ) {
									$modula_settings[$field_id] = sanitize_text_field( wp_unslash( $_POST['modula-settings'][$field_id] ) );
								} else {
									$modula_settings[$field_id] = 'fancybox';
								}
								break;
							case 'enableSocial':
							case 'enableTwitter' :
							case 'enableWhatsapp':
							case 'enableFacebook' :
							case 'enablePinterest' :
							case 'enableEmail':
							case 'emailSubject':
								$modula_settings[$field_id] = sanitize_text_field( wp_unslash( $_POST['modula-settings'][$field_id] ) );
								break;
							case 'imageMessage':
								$modula_settings[$field_id] = sanitize_text_field( wp_unslash( $_POST['modula-settings'][$field_id] ) );
								break;
							case 'galleryMessage':
								$modula_settings[$field_id] = sanitize_text_field( wp_unslash( $_POST['modula-settings'][$field_id] ) );
								break;
							case 'shuffle' :
								if ( isset( $_POST['modula-settings'][$field_id] ) ) {
									$modula_settings[$field_id] = '1';
								} else {
									$modula_settings[$field_id] = '0';
								}
								break;
							case 'captionColor':
							case 'socialIconColor':
							case 'borderColor':
							case 'shadowColor':
								$modula_settings[$field_id] = Modula_Helper::sanitize_rgba_colour( wp_unslash( $_POST['modula-settings'][$field_id] ) );
								break;
							case 'effect' :
								if ( in_array( $_POST['modula-settings'][$field_id], $effect_values ) ) {
									$modula_settings[$field_id] = $_POST['modula-settings'][$field_id];
								} else {
									$modula_settings[$field_id] = 'pufrobo';
								}
								break;
							case 'gutterInput' :
								$modula_settings[$field_id] = absint( $_POST['modula-settings'][$field_id] );
								break;
							case 'height' :
								$modula_settings[$field_id] = array_map( 'absint', $_POST['modula-settings'][$field_id] );
								break;
							default:
								$data_type = isset( $field['data_type'] ) ? $field['data_type'] : 'default';
								switch ( $data_type ) {
									case 'text':
										if( is_array( $_POST['modula-settings'][$field_id] ) ){
											$modula_settings[$field_id] = array_map( 'sanitize_text_field', wp_unslash( $_POST['modula-settings'][$field_id] ) );
										}else{
											$modula_settings[$field_id] = sanitize_text_field( wp_unslash( $_POST['modula-settings'][$field_id] ) );
										}
										break;
									case 'number':
										if( is_array( $_POST['modula-settings'][$field_id] ) ){
											$modula_settings[$field_id] = array_map( 'absint', $_POST['modula-settings'][$field_id] );
										}else{

											$modula_settings[$field_id] = absint( $_POST['modula-settings'][$field_id] );
										}
										break;
									case 'bool':

										if( is_array( $_POST['modula-settings'][$field_id] ) ){
											$modula_settings[$field_id] = array_map( 'rest_sanitize_boolean', $_POST['modula-settings'][$field_id] );
										}else{
											$modula_settings[$field_id] = rest_sanitize_boolean( $_POST['modula-settings'][$field_id] );
										}
										break;
									default:
									if ( is_array( $_POST['modula-settings'][$field_id] ) ) {
										$sanitized                  = array_map( 'sanitize_text_field', wp_unslash( $_POST['modula-settings'][$field_id] ) );
										$modula_settings[$field_id] = apply_filters( 'modula_settings_field_sanitization', $sanitized, wp_unslash( $_POST['modula-settings'][$field_id] ), $field_id, $field );
									} else {
										$modula_settings[$field_id] = apply_filters( 'modula_settings_field_sanitization', sanitize_text_field( wp_unslash( $_POST['modula-settings'][$field_id] ) ), $_POST['modula-settings'][$field_id], $field_id, $field );
									}
									break;
								}

							break;
						}

					} else {
						if ( 'toggle' == $field['type'] ) {
							$modula_settings[$field_id] = '0';
						} else if ( 'hidden' == $field['type'] ) {

							$hidden_set = get_post_meta( $post_id, 'modula-settings', true );
							if ( isset( $hidden_set['last_visited_tab'] ) && '' != $hidden_set['last_visited_tab'] ) {
								$modula_settings[$field_id] = $hidden_set['last_visited_tab'];
							} else {
								$modula_settings[$field_id] = 'modula-general';
							}

						} else {
							$modula_settings[$field_id] = '';
						}
					}

				}

			}

			// Save the value of helpergrid
			if ( isset( $_POST['modula-settings']['helpergrid'] ) ) {
				$modula_settings['helpergrid'] = 1;
			} else {
				$modula_settings['helpergrid'] = 0;
			}

			// Add settings to gallery meta
			update_post_meta( $post_id, 'modula-settings', $modula_settings );

		}

		if ( isset( $_POST['modula-images'] ) ) {
			
			$old_images = get_post_meta( $post_id, 'modula-images', true );
			$images     = json_decode( stripslashes( $_POST['modula-images'] ), true );
			$new_images = array();
	
			if ( is_array( $images ) ) {
				foreach ( $images as $image ) {
					$new_images[] = $this->sanitize_image( $image );
				}
			}
			update_post_meta( $post_id, 'modula-images', $new_images );
		}

	}

	private function sanitize_image( $image ) {

		$new_image = array();

		// This list will not contain id because we save our images based on image id.
		$image_attributes = apply_filters(
			'modula_gallery_image_attributes',
			array(
				'id',
				'alt',
				'title',
				'description',
				'halign',
				'valign',
				'link',
				'target',
				'width',
				'height',
				'togglelightbox',
			)
		);

		foreach ( $image_attributes as $attribute ) {
			if ( isset( $image[ $attribute ] ) ) {

				switch ( $attribute ) {
					case 'alt':
						$new_image[ $attribute ] = sanitize_text_field( $image[ $attribute ] );
						break;
					case 'width':
					case 'height':
						$new_image[ $attribute ] = absint( $image[ $attribute ] );
						break;
					case 'title':
					case 'description':
						$new_image[ $attribute ] = wp_filter_post_kses( $image[ $attribute ] );
						break;
					case 'link':
						$new_image[ $attribute ] = esc_url_raw( $image[ $attribute ] );
						break;
					case 'target':
						if ( isset( $image[ $attribute ] ) ) {
							$new_image[ $attribute ] = absint( $image[ $attribute ] );
						} else {
							$new_image[ $attribute ] = 0;
						}
						break;
					case 'togglelightbox':
						if ( isset( $image[ $attribute ] ) ) {
							$new_image[ $attribute ] = absint( $image[ $attribute ] );
						} else {
							$new_image[ $attribute ] = 0;
						}
						break;
					case 'halign':
						if ( in_array( $image[ $attribute ], array( 'left', 'right', 'center' ) ) ) {
							$new_image[ $attribute ] = $image[ $attribute ];
						} else {
							$new_image[ $attribute ] = 'center';
						}
						break;
					case 'valign':
						if ( in_array( $image[ $attribute ], array( 'top', 'bottom', 'middle' ) ) ) {
							$new_image[ $attribute ] = $image[ $attribute ];
						} else {
							$new_image[ $attribute ] = 'middle';
						}
						break;
					default:
						$new_image[ $attribute ] = apply_filters( 'modula_image_field_sanitization', sanitize_text_field( $image[ $attribute ] ), $image[ $attribute ], $attribute );
						break;
				}
			} else {
				$new_image[ $attribute ] = '';
			}
		}

		return $new_image;

	}

	public function add_extensions_tab_onboarding( $views ) {

		$query = new WP_Query(array(
			'post_type' => 'modula-gallery',
			'post_status' => array( 'publish', 'future', 'trash', 'draft', 'inherit', 'pending', 'private' ),
		));

		$this->display_extension_tab();

		if( !$query->have_posts() ){
			global $wp_list_table;
			$wp_list_table = new Modula_Onboarding();
			return array();
		}
		return $views;
	}

	public function display_extension_tab() {
		?>
		<h2 class="nav-tab-wrapper">
			<?php
			$tabs = array(
					'galleries'       => array(
							'name'     => $this->labels[ 'name' ],
							'url'      => admin_url( 'edit.php?post_type=' . $this->cpt_name ),
							'priority' => '1'
					),
					'suggest_feature' => array(
							'name'     => esc_html__( 'Suggest a feature', 'modula-best-grid-gallery' ),
							'icon'     => 'dashicons-external',
							'url'      => 'https://docs.google.com/forms/d/e/1FAIpQLSc5eAZbxGROm_WSntX_3JVji2cMfS3LIbCNDKG1yF_VNe3R4g/viewform',
							'target'   => '_blank',
							'priority' => '10'
					),
			);

			if ( current_user_can( 'install_plugins' ) ) {
				$tabs[ 'extensions' ] = array(
						'name'     => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
						'url'      => admin_url( 'edit.php?post_type=modula-gallery&page=modula-addons' ),
						'priority' => '5',
				);
			}

			$tabs = apply_filters( 'modula_add_edit_tabs', $tabs );

			uasort( $tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

			Modula_Admin_Helpers::modula_tab_navigation( $tabs, 'galleries' );
			?>


		</h2>
		<br/>
		<?php
	}

	public function add_columns( $columns ) {

		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'modula-best-grid-gallery' );
		$columns['date']      = $date;
		return $columns;

	}

	public function outpu_column( $column, $post_id ) {

		if ( 'shortcode' == $column ) {
			$shortcode = '[modula id="' . $post_id . '"]';
			echo '<div class="modula-copy-shortcode">';
			echo '<input type="text" value="' . esc_attr( $shortcode ) . '"  onclick="select()" readonly>';
			echo '<a href="#" title="' . esc_attr__( 'Copy shortcode', 'modula-best-grid-gallery' ) . '" class="copy-modula-shortcode button button-primary dashicons dashicons-format-gallery" style="width:40px;"></a><span></span>';
			echo '</div>';
		}

	}

	public function dismiss_edit_notice() {

		$modula_options                = get_option( 'modula-checks', array() );
		$modula_options['edit-notice'] = 1;
		update_option( 'modula-checks', $modula_options );
		die( '1' );

	}

	public function replace_submit_meta_box() {
		global $post;
		$post_type = 'modula-gallery';
		remove_meta_box( 'submitdiv', $post_type, 'side' );
		add_meta_box( 'submitdiv', __( 'Publish', 'modula-best-grid-gallery' ), array( $this, 'post_submit_meta_box' ), $post_type, 'side', 'high' );

	}

	public function post_submit_meta_box() {
		global $action, $post;
		$post_type        = $post->post_type; // get current post_type
		$post_type_object = get_post_type_object( $post_type );
		$can_publish      = current_user_can( $post_type_object->cap->publish_posts );
		?>
		<div class="submitbox" id="submitpost">

			<div id="minor-publishing">

				<?php // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key ?>
				<div style="display:none;">
					<?php submit_button( __( 'Save', 'modula-best-grid-gallery' ), '', 'save' ); ?>
				</div>

				<div id="minor-publishing-actions">
					<div id="save-action">
						<?php
						if ( 'publish' != $post->post_status && 'future' != $post->post_status && 'pending' != $post->post_status ) {
							$private_style = '';
							if ( 'private' == $post->post_status ) {
								$private_style = 'style="display:none"';
							}
							?>
							<input <?php echo $private_style; ?> type="submit" name="save" id="save-post"
							                                     value="<?php esc_attr_e( 'Save Draft', 'modula-best-grid-gallery' ); ?>"
							                                     class="button"/>
							<span class="spinner"></span>
						<?php } elseif ( 'pending' == $post->post_status && $can_publish ) { ?>
							<input type="submit" name="save" id="save-post"
							       value="<?php esc_attr_e( 'Save as Pending', 'modula-best-grid-gallery' ); ?>" class="button"/>
							<span class="spinner"></span>
						<?php } ?>
					</div>
					<?php if ( is_post_type_viewable( $post_type_object ) ) : ?>
						<div id="preview-action">
							<?php
							$preview_link =  get_preview_post_link( $post );
							if ( 'publish' == $post->post_status ) {
								$preview_button_text = esc_html__( 'Preview Changes', 'modula-best-grid-gallery' );
							} else {
								$preview_button_text = esc_html__( 'Preview', 'modula-best-grid-gallery' );
							}

							$preview_button = sprintf(
								'%1$s<span class="screen-reader-text"> %2$s</span>',
								$preview_button_text,
								/* translators: Accessibility text. */
								esc_html__( '(opens in a new tab)', 'modula-best-grid-gallery' )
							);
							?>
							<a class="preview button" href="<?php echo esc_url( $preview_link ); ?>"
							   target="wp-preview-<?php echo (int)$post->ID; ?>"
							   id="post-preview"><?php echo wp_kses_post( $preview_button ); ?></a>
							<input type="hidden" name="wp-preview" id="wp-preview" value=""/>
						</div>
					<?php endif; // public post type ?>
					<?php
					/**
					 * Fires before the post time/date setting in the Publish meta box.
					 *
					 * @param WP_Post $post WP_Post object for the current post.
					 *
					 * @since 4.4.0
					 *
					 */
					do_action( 'post_submitbox_minor_actions', $post );
					?>
					<div class="clear"></div>
				</div><!-- #minor-publishing-actions -->

				<div id="misc-publishing-actions">

					<div class="misc-pub-section misc-pub-post-status">
						<?php _e( 'Status:', 'modula-best-grid-gallery' ); ?> <span id="post-status-display">
			<?php

			switch ( $post->post_status ) {
				case 'private':
					esc_html_e( 'Privately Published', 'modula-best-grid-gallery' );
					break;
				case 'publish':
					esc_html_e( 'Published', 'modula-best-grid-gallery' );
					break;
				case 'future':
					esc_html_e( 'Scheduled', 'modula-best-grid-gallery' );
					break;
				case 'pending':
					esc_html_e( 'Pending Review', 'modula-best-grid-gallery' );
					break;
				case 'draft':
				case 'auto-draft':
					esc_html_e( 'Draft', 'modula-best-grid-gallery' );
					break;
			}
			?>
</span>
						<?php
						if ( 'publish' == $post->post_status || 'private' == $post->post_status || $can_publish ) {
							$private_style = '';
							if ( 'private' == $post->post_status ) {
								$private_style = 'style="display:none"';
							}
							?>
							<a href="#post_status" <?php echo $private_style; ?> class="edit-post-status hide-if-no-js"
							   role="button"><span aria-hidden="true"><?php esc_html_e( 'Edit', 'modula-best-grid-gallery' ); ?></span> <span
										class="screen-reader-text"><?php esc_html_e( 'Edit status', 'modula-best-grid-gallery' ); ?></span></a>

							<div id="post-status-select" class="hide-if-js">
								<input type="hidden" name="hidden_post_status" id="hidden_post_status"
								       value="<?php echo esc_attr( ('auto-draft' == $post->post_status) ? 'draft' : $post->post_status ); ?>"/>
								<label for="post_status" class="screen-reader-text"><?php esc_html_e( 'Set status', 'modula-best-grid-gallery' ); ?></label>
								<select name="post_status" id="post_status">
									<?php if ( 'publish' == $post->post_status ) : ?>
										<option<?php selected( $post->post_status, 'publish' ); ?>
												value='publish'><?php esc_html_e( 'Published', 'modula-best-grid-gallery' ); ?></option>
									<?php elseif ( 'private' == $post->post_status ) : ?>
										<option<?php selected( $post->post_status, 'private' ); ?>
												value='publish'><?php esc_html_e( 'Privately Published', 'modula-best-grid-gallery' ); ?></option>
									<?php elseif ( 'future' == $post->post_status ) : ?>
										<option<?php selected( $post->post_status, 'future' ); ?>
												value='future'><?php esc_html_e( 'Scheduled', 'modula-best-grid-gallery' ); ?></option>
									<?php endif; ?>
									<option<?php selected( $post->post_status, 'pending' ); ?>
											value='pending'><?php esc_html_e( 'Pending Review', 'modula-best-grid-gallery' ); ?></option>
									<?php if ( 'auto-draft' == $post->post_status ) : ?>
										<option<?php selected( $post->post_status, 'auto-draft' ); ?>
												value='draft'><?php esc_html_e( 'Draft', 'modula-best-grid-gallery' ); ?></option>
									<?php else : ?>
										<option<?php selected( $post->post_status, 'draft' ); ?>
												value='draft'><?php esc_html_e( 'Draft', 'modula-best-grid-gallery' ); ?></option>
									<?php endif; ?>
								</select>
								<a href="#post_status"
								   class="save-post-status hide-if-no-js button"><?php esc_html_e( 'OK', 'modula-best-grid-gallery' ); ?></a>
								<a href="#post_status"
								   class="cancel-post-status hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'modula-best-grid-gallery' ); ?></a>
							</div>

						<?php } ?>
					</div><!-- .misc-pub-section -->

					<div class="misc-pub-section misc-pub-visibility" id="visibility">
						<?php esc_html_e( 'Visibility:', 'modula-best-grid-gallery' ); ?> <span id="post-visibility-display">
							<?php

							if ( 'private' == $post->post_status ) {
								$post->post_password = '';
								$visibility          = 'private';
								$visibility_trans    = __( 'Private', 'modula-best-grid-gallery' );
							} elseif ( !empty( $post->post_password ) ) {
								$visibility       = 'password';
								$visibility_trans = __( 'Password protected', 'modula-best-grid-gallery' );
							} elseif ( $post_type == 'post' && is_sticky( $post->ID ) ) {
								$visibility       = 'public';
								$visibility_trans = __( 'Public, Sticky', 'modula-best-grid-gallery' );
							} else {
								$visibility       = 'public';
								$visibility_trans = __( 'Public', 'modula-best-grid-gallery' );
							}

							echo esc_html( $visibility_trans );
							?>
</span>
						<?php if ( $can_publish ) { ?>
							<a href="#visibility" class="edit-visibility hide-if-no-js" role="button"><span
										aria-hidden="true"><?php esc_html_e( 'Edit', 'modula-best-grid-gallery' ); ?></span> <span
										class="screen-reader-text"><?php esc_html_e( 'Edit visibility', 'modula-best-grid-gallery' ); ?></span></a>

							<div id="post-visibility-select" class="hide-if-js">
								<input type="hidden" name="hidden_post_password" id="hidden-post-password"
								       value="<?php echo esc_attr( $post->post_password ); ?>"/>
								<?php if ( $post_type == 'post' ) : ?>
									<input type="checkbox" style="display:none" name="hidden_post_sticky"
									       id="hidden-post-sticky"
									       value="sticky" <?php checked( is_sticky( $post->ID ) ); ?> />
								<?php endif; ?>
								<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility"
								       value="<?php echo esc_attr( $visibility ); ?>"/>
								<input type="radio" name="visibility" id="visibility-radio-public"
								       value="public" <?php checked( $visibility, 'public' ); ?> /> <label
										for="visibility-radio-public"
										class="selectit"><?php esc_html_e( 'Public', 'modula-best-grid-gallery' ); ?></label><br/>
								<?php if ( $post_type == 'post' && current_user_can( 'edit_others_posts' ) ) : ?>
									<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox"
									                              value="sticky" <?php checked( is_sticky( $post->ID ) ); ?> /> <label
												for="sticky"
												class="selectit"><?php esc_html_e( 'Stick this post to the front page', 'modula-best-grid-gallery' ); ?></label><br/></span>
								<?php endif; ?>
								<input type="radio" name="visibility" id="visibility-radio-password"
								       value="password" <?php checked( $visibility, 'password' ); ?> /> <label
										for="visibility-radio-password"
										class="selectit"><?php esc_html_e( 'Password protected', 'modula-best-grid-gallery' ); ?></label><br/>
								<span id="password-span"><label for="post_password"><?php _e( 'Password:', 'modula-best-grid-gallery' ); ?></label> <input
											type="text" name="post_password" id="post_password"
											value="<?php echo esc_attr( $post->post_password ); ?>"
											maxlength="255"/><br/></span>
								<input type="radio" name="visibility" id="visibility-radio-private"
								       value="private" <?php checked( $visibility, 'private' ); ?> /> <label
										for="visibility-radio-private"
										class="selectit"><?php esc_html_e( 'Private', 'modula-best-grid-gallery' ); ?></label><br/>

								<p>
									<a href="#visibility"
									   class="save-post-visibility hide-if-no-js button"><?php esc_html_e( 'OK', 'modula-best-grid-gallery' ); ?></a>
									<a href="#visibility"
									   class="cancel-post-visibility hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'modula-best-grid-gallery' ); ?></a>
								</p>
							</div>
						<?php } ?>

					</div><!-- .misc-pub-section -->

					<?php
					/* translators: Publish box date string. 1: Date, 2: Time. See https://secure.php.net/date */
					$date_string = __( '%1$s at %2$s', 'modula-best-grid-gallery' );
					/* translators: Publish box date format, see https://secure.php.net/date */
					$date_format = _x( 'M j, Y', 'publish box date format', 'modula-best-grid-gallery' );
					/* translators: Publish box time format, see https://secure.php.net/date */
					$time_format = _x( 'H:i', 'publish box time format', 'modula-best-grid-gallery' );

					if ( 0 != $post->ID ) {
						if ( 'future' == $post->post_status ) { // scheduled for publishing at a future date
							/* translators: Post date information. %s: Date on which the post is currently scheduled to be published. */
							$stamp = __( 'Scheduled for: %s', 'modula-best-grid-gallery' );
						} elseif ( 'publish' == $post->post_status || 'private' == $post->post_status ) { // already published
							/* translators: Post date information. %s: Date on which the post was published. */
							$stamp = __( 'Published on: %s', 'modula-best-grid-gallery' );
						} elseif ( '0000-00-00 00:00:00' == $post->post_date_gmt ) { // draft, 1 or more saves, no date specified
							$stamp = __( 'Publish <b>immediately</b>', 'modula-best-grid-gallery' );
						} elseif ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
							/* translators: Post date information. %s: Date on which the post is to be published. */
							$stamp = __( 'Schedule for: %s', 'modula-best-grid-gallery' );
						} else { // draft, 1 or more saves, date specified
							/* translators: Post date information. %s: Date on which the post is to be published. */
							$stamp = __( 'Publish on: %s', 'modula-best-grid-gallery' );
						}
						$date = sprintf(
							$date_string,
							date_i18n( $date_format, strtotime( $post->post_date ) ),
							date_i18n( $time_format, strtotime( $post->post_date ) )
						);
					} else { // draft (no saves, and thus no date specified)
						$stamp = __( 'Publish <b>immediately</b>', 'modula-best-grid-gallery' );
						$date  = sprintf(
							$date_string,
							date_i18n( $date_format, strtotime( current_time( 'mysql' ) ) ),
							date_i18n( $time_format, strtotime( current_time( 'mysql' ) ) )
						);
					}

					if ( !empty( $args['args']['revisions_count'] ) ) :
						?>
						<div class="misc-pub-section misc-pub-revisions">
							<?php
							/* translators: Post revisions heading. %s: The number of available revisions. */
							printf( esc_html__( 'Revisions: %s', 'modula-best-grid-gallery' ), '<b>' . esc_html( number_format_i18n( $args['args']['revisions_count'] ) ) . '</b>' );
							?>
							<a class="hide-if-no-js"
							   href="<?php echo esc_url( get_edit_post_link( $args['args']['revision_id'] ) ); ?>"><span
										aria-hidden="true"><?php esc_html( _ex( 'Browse', 'revisions', 'modula-best-grid-gallery' ) ); ?></span> <span
										class="screen-reader-text"><?php esc_html_e( 'Browse revisions', 'modula-best-grid-gallery' ); ?></span></a>
						</div>
					<?php
					endif;

					if ( $can_publish ) : // Contributors don't get to choose the date of publish
						?>
						<div class="misc-pub-section curtime misc-pub-curtime">
						<span id="timestamp">
		<?php printf( $stamp, '<b>' . $date . '</b>' ); ?>
	</span>
						<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" role="button">
							<span aria-hidden="true"><?php esc_html_e( 'Edit', 'modula-best-grid-gallery' ); ?></span>
							<span class="screen-reader-text"><?php esc_html_e( 'Edit date and time', 'modula-best-grid-gallery' ); ?></span>
						</a>
						<fieldset id="timestampdiv" class="hide-if-js">
							<legend class="screen-reader-text"><?php esc_html_e( 'Date and time', 'modula-best-grid-gallery' ); ?></legend>
							<?php touch_time( ($action === 'edit'), 1 ); ?>
						</fieldset>
						</div><?php // /misc-pub-section
						?>
					<?php endif; ?>

					<?php if ( 'draft' === $post->post_status && get_post_meta( $post->ID, '_customize_changeset_uuid', true ) ) : ?>
						<div class="notice notice-info notice-alt inline">
							<p>
								<?php
								echo wp_kses_post( sprintf(
								/* translators: %s: URL to the Customizer. */
									__( 'This draft comes from your <a href="%s">unpublished customization changes</a>. You can edit, but there&#8217;s no need to publish now. It will be published automatically with those changes.', 'modula-best-grid-gallery' ),
									esc_url(
										add_query_arg(
											'changeset_uuid',
											rawurlencode( get_post_meta( $post->ID, '_customize_changeset_uuid', true ) ),
											admin_url( 'customize.php' )
										)
									)
								) );
								?>
							</p>
						</div>
					<?php endif; ?>

					<?php
					/**
					 * Fires after the post time/date setting in the Publish meta box.
					 *
					 * @param WP_Post $post WP_Post object for the current post.
					 *
					 * @since 4.4.0 Added the `$post` parameter.
					 *
					 * @since 2.9.0
					 */
					do_action( 'post_submitbox_misc_actions', $post );
					?>
				</div>
				<div class="clear"></div>
			</div>
			<?php do_action('modula_cpt_publish_actions'); ?>
			<div class="modula-shortcuts">
				<?php esc_html_e( 'Want a faster and easier way to save galleries? Use our Keyboard shortcut:', 'modula-best-grid-gallery' ); ?>
				<strong>CTRL/CMD + S</strong>
			</div>
			<div id="major-publishing-actions">
				<?php
				/**
				 * Fires at the beginning of the publishing actions section of the Publish meta box.
				 *
				 * @param WP_Post|null $post WP_Post object for the current post on Edit Post screen,
				 *                           null on Edit Link screen.
				 *
				 * @since 4.9.0 Added the `$post` parameter.
				 *
				 * @since 2.7.0
				 */
				do_action( 'post_submitbox_start', $post );
				?>
				<div id="delete-action">
					<?php
					if ( current_user_can( 'delete_post', $post->ID ) ) {
						if ( !EMPTY_TRASH_DAYS ) {
							$delete_text = __( 'Delete Permanently', 'modula-best-grid-gallery' );
						} else {
							$delete_text = __( 'Move to Trash', 'modula-best-grid-gallery' );
						}
						?>
						<a class="submitdelete deletion"
						   href="<?php echo esc_url( get_delete_post_link( $post->ID ) ); ?>"><?php echo esc_html( $delete_text ); ?></a>
						<?php
					}
					?>
				</div>
				<div id="publishing-action">
					<span class="spinner"></span>

					<?php
					if ( !in_array( $post->post_status, array( 'publish', 'future', 'private' ) ) || 0 == $post->ID ) {
						if ( $can_publish ) :
							if ( !empty( $post->post_date_gmt ) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) :
								?>
								<input name="original_publish" type="hidden" id="original_publish"
								       value="<?php echo esc_attr_x( 'Schedule', 'post action/button label', 'modula-best-grid-gallery' ); ?>"/>
								<?php submit_button( _x( 'Schedule', 'post action/button label', 'modula-best-grid-gallery' ), 'primary large', 'publish', false ); ?>

							<?php elseif ( in_array( $post->post_status, array( 'draft' ) ) || 0 == $post->ID ) : ?>
								<input name="original_publish" type="hidden" id="original_publish"
								       value="<?php esc_attr_e( 'Update ', 'modula-best-grid-gallery' ) . 'modula-gallery'; ?>"/>
								<?php submit_button( __( 'Publish Gallery', 'modula-best-grid-gallery' ), 'primary large', 'publish', false ); ?>

							<?php else : ?>
								<input name="original_publish" type="hidden" id="original_publish"
								       value="<?php esc_attr_e( 'Update ', 'modula-best-grid-gallery' ) . 'modula-gallery'; ?>"/>
								<?php submit_button( __( 'Save Gallery', 'modula-best-grid-gallery' ), 'primary large', 'publish', false ); ?>
							<?php
							endif;
						else :
							?>
							<input name="original_publish" type="hidden" id="original_publish"
							       value="<?php esc_attr_e( 'Submit for Review', 'modula-best-grid-gallery' ); ?>"/>
							<?php submit_button( __( 'Submit for Review', 'modula-best-grid-gallery' ), 'primary large', 'publish', false ); ?>
						<?php
						endif;
					} else {
						?>

						<input name="save" type="submit" class="button button-primary button-large" id="publish"
						       value="<?php esc_attr_e( 'Update Gallery', 'modula-best-grid-gallery' ) . 'modula-gallery'; ?>"/>
						<?php
					}
					?>
				</div>
				<div class="clear"></div>
			</div>
		</div> <?php
	}

	/**
	 * Add the last visited settings tab to edit link
	 *
	 * @param $link
	 * @param $id
	 *
	 * @return string
	 * @since 2.4.0
	 */
	public function modula_remember_tab( $link, $id ) {

		if ( 'modula-gallery' != get_post_type( $id ) ) {
			return $link;
		}

		$settings = get_post_meta( $id, 'modula-settings', true );

		if ( isset( $settings['last_visited_tab'] ) && '' != $settings['last_visited_tab'] ) {
			$link = $link . '#!' . $settings['last_visited_tab'];
		} else {
			$link = $link . '#!modula-general';
		}

		return $link;
	}

	/**
	 * Save the tab
	 */
	public function modula_remember_tab_save() {

		$nonce = $_POST['nonce'];
		if ( !wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

		// Check if post exists and is modula-gallery CPT
		if ( ! get_post_type( $id ) || 'modula-gallery' !== get_post_type( $id ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		$settings                     = wp_parse_args( get_post_meta( $id, 'modula-settings', true ), Modula_CPT_Fields_Helper::get_defaults() );
		$settings['last_visited_tab'] = isset( $_POST['tab'] ) ? sanitize_text_field( wp_unslash( $_POST['tab'] ) ) : '';

		update_post_meta( $id, 'modula-settings', $settings );
		die();

	}

	public function output_upsell_albums() {
		$buttons = '<a target="_blank" href="' . esc_url( admin_url('edit.php?post_type=modula-gallery&page=modula-lite-vs-pro') ) . '" class="button">' . esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=albums-metabox&utm_campaign=modula-albums" class="button-primary button">' . esc_html__( 'Get Premium!', 'modula-best-grid-gallery' ) . '</a>';

		?>
		<div class="modula-upsells-carousel-wrapper">
			<div class="modula-upsells-carousel">
				<div class="modula-upsell modula-upsell-item">
					<h4 class="modula-upsell-description"><?php esc_html_e( 'Get the Modula Albums add-on to create wonderful albums from your galleries.', 'modula-best-grid-gallery' ) ?></h4>
					<ul class="modula-upsells-list">
						<li>Redirect to a gallery or a custom URL with the standalone functionality</li>
						<li>Arrange your albums using columns or the custom grid</li>
						<li>Hover effects</li>
						<li>Fully compatible with all the other Modula extensions</li>
						<li>Premium support</li>
						<li>Shuffle galleries inside an album on page refresh</li>
						<li>Shuffle album cover images (randomly pick a cover image from the gallery)</li>
					</ul>
					<p>
						<?php echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-albums' ); ?>
					</p>
				</div>
			</div>
		</div>
		<?php
	}
}


