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

	public function __construct() {

		$this->labels = apply_filters( 'modula_cpt_labels', array(
			'name'                  => esc_html__( 'Galleries', 'modula-best-grid-gallery' ),
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
			'not_found'             => esc_html__( 'Not found', 'modula-best-grid-gallery' ),
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
		) );

		$this->args = apply_filters( 'modula_cpt_args', array(
			'label'                 => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' ),
			'description'           => esc_html__( 'Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.', 'modula-best-grid-gallery' ),
			'supports'              => array( 'title' ),
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 25,
			'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32"><path fill="#f0f5fa" d="M9.3 25.3c-2.4-0.7-4.7-1.4-7.1-2.1 2.4-3.5 4.7-7 7-10.5C9.3 12.9 9.3 24.9 9.3 25.3z"/><path fill="#f0f5fa" d="M9.6 20.1c3.7 2 7.4 3.9 11.1 5.9 -0.1 0.1-5 5-5.2 5.2C13.6 27.5 11.6 23.9 9.6 20.1 9.6 20.2 9.6 20.2 9.6 20.1z"/><path fill="#f0f5fa" d="M22.3 11.9c-3.7-2-7.4-4-11-6 0 0 0 0 0 0 0 0 0 0 0 0 1.7-1.7 3.4-3.3 5.1-5 0 0 0 0 0.1-0.1C18.5 4.5 20.4 8.2 22.3 11.9 22.4 11.9 22.3 11.9 22.3 11.9z"/><path fill="#f0f5fa" d="M4.7 15c-0.6-2.4-1.2-4.7-1.8-7 0.2 0 11.9 0.6 12.7 0.6 0 0 0 0 0 0 0 0 0 0 0 0 -3.6 2.1-7.2 4.2-10.7 6.3C4.8 15 4.8 15 4.7 15z"/><path fill="#f0f5fa" d="M22.9 19.6c-0.2-4.2-0.3-8.3-0.5-12.5 2.4 0.6 4.8 1.2 7.1 1.8C27.4 12.4 25.1 16 22.9 19.6 22.9 19.6 22.9 19.6 22.9 19.6z"/><path fill="#f0f5fa" d="M27.7 16.8c0.6 2.4 1.2 4.7 1.9 7.1 -4.2-0.2-8.5-0.4-12.7-0.5 0 0 0 0 0 0C20.5 21.2 24.1 19 27.7 16.8z"/></svg>'),
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'rewrite'               => false,
			'show_in_rest'          => true,
		) );

		$this->metaboxes = array(
			'modula-preview-gallery' => array(
				'title'    => esc_html__( 'Gallery', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_images',
				'context'  => 'normal',
				'priority' => 10,
			),
			'modula-settings' => array(
				'title'    => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_settings',
				'context'  => 'normal',
				'priority' => 20,
			),
			'modula-shortcode' => array(
				'title'    => esc_html__( 'Shortcode', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_shortcode',
				'context'  => 'side',
				'priority' => 10,
			),
		);

		$this->cpt_name = apply_filters( 'modula_cpt_name', 'modula-gallery' );

		add_action( 'init', array( $this, 'register_cpt' ) );

		/* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'admin_menu', array($this, 'replace_submit_meta_box') );
		
		add_filter( 'views_edit-modula-gallery', array( $this, 'add_extensions_tab' ), 10, 1 );

		// Post Table Columns
		add_filter( "manage_{$this->cpt_name}_posts_columns", array( $this, 'add_columns' ) );
		add_action( "manage_{$this->cpt_name}_posts_custom_column" , array( $this, 'outpu_column' ), 10, 2 );

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

		$args = $this->args;
		$args['labels'] = $this->labels;

		register_post_type( $this->cpt_name, $args );

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

    public function output_upsell_albums() {
        ?>
        <div class="modula-upsells-carousel-wrapper">
            <div class="modula-upsells-carousel">
                <div class="modula-upsell modula-upsell-item">
                    <h2><?php esc_html_e( 'Modula Albums' , 'modula-best-grid-gallery' ) ?></h2>
                    <h4 class="modula-upsell-description"><?php esc_html_e( 'Get the Modula Albums add-on to create wonderful albums from your galleries.' , 'modula-best-grid-gallery' ) ?></h4>
                    <ul class="modula-upsells-list">
                        <li>Redirect to a gallery or a custom URL with the standalone functionality</li>
                        <li>Arrange your albums using columns or the custom grid</li>
                        <li>Hover effects</li>
                        <li>Fully compatible with all the other Modula extensions </li>
                        <li>Premium support</li>
                    </ul>
                    <p>
                        <a target="_blank"
                           href="https://wp-modula.com/pricing/?utm_source=modula-lite&amp;utm_medium=albums-metabox&amp;utm_campaign=litevspro#lite-vs-pro"
                           class="button"><?php esc_html_e( 'See LITE vs PRO Differences' , 'modula-best-grid-gallery' ) ?></a>
                        <a target="_blank"
                           style="margin-top:10px;"
                           href="https://wp-modula.com/pricing/?utm_source=modula-lite&amp;utm_medium=albums-metabox&amp;utm_campaign=upsell"
                           class="button-primary button"><?php esc_html_e( 'Get Modula Pro!' , 'modula-best-grid-gallery' ) ?></a>
                    </p>
                </div>
            </div>
        </div>
        <?php
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

		// We need to resize our images
		$images = get_post_meta( $post_id, 'modula-images', true );
		if ( $images && is_array( $images ) ) {
			if ( isset( $_POST['modula-settings']['img_size'] ) && apply_filters( 'modula_resize_images', true, $_POST['modula-settings'] ) ) {

				$gallery_type = isset( $_POST['modula-settings']['type'] ) ? sanitize_text_field($_POST['modula-settings']['type']) : 'creative-gallery';
				$img_size = absint( $_POST['modula-settings']['img_size'] );
				
				foreach ( $images as $image ) {
					$grid_sizes = array(
						'width' => isset( $image['width'] ) ? absint( $image['width'] ) : 1,
						'height' => isset( $image['height'] ) ? absint( $image['height'] ) : 1,
					);
					$sizes = $this->resizer->get_image_size( $image['id'], $img_size, $gallery_type, $grid_sizes );
					if ( ! is_wp_error( $sizes ) ) {
						$this->resizer->resize_image( $sizes['url'], $sizes['width'], $sizes['height'] );
					}

				}

			}
		}

		if ( isset( $_POST['modula-settings'] ) ) {

			$fields_with_tabs = Modula_CPT_Fields_Helper::get_fields( 'all' );

			// Here we will save all our settings
			$modula_settings = array();

			// We will save only our settings.
			foreach ( $fields_with_tabs as $tab => $fields ) {

				// We will iterate throught all fields of current tab
				foreach ( $fields as $field_id => $field ) {

					if ( isset( $_POST['modula-settings'][ $field_id ] ) ) {

						// Values for selects
						$lightbox_values = apply_filters( 'modula_lightbox_values', array( 'no-link', 'direct', 'lightbox2', 'attachment-page' ) );
						$effect_values   = apply_filters( 'modula_effect_values', array( 'none', 'pufrobo' ) );
						$cursor_value    = apply_filters( 'modula_cursor_values', array( 'pointer', 'zoom-in') );

						switch ( $field_id ) {
							case 'description':
								$modula_settings[ $field_id ] = wp_filter_post_kses( $_POST['modula-settings'][ $field_id ] );
								break;
							case 'height':
							case 'img_size':
							case 'margin':
							case 'randomFactor':
							case 'captionFontSize':
							case 'titleFontSize':
							case 'loadedScale':
							case 'borderSize':
							case 'borderRadius':
							case 'shadowSize':
							case 'socialIconSize':
							case 'socialIconPadding':
								$modula_settings[ $field_id ] = absint( $_POST['modula-settings'][ $field_id ] );
								break;
							case 'lightbox' :
								if ( in_array( $_POST['modula-settings'][ $field_id ], $lightbox_values ) ) {
									$modula_settings[ $field_id ] = sanitize_text_field( $_POST['modula-settings'][ $field_id ] );
								}else{
									$modula_settings[ $field_id ] = 'lightbox2';
								}
								break;
							case 'disableSocial':
							case 'enableTwitter' :
							case 'enableWhatsapp':
							case 'enableFacebook' :
							case 'enableGplus' :
							case 'enablePinterest' :
							case 'shuffle' :
								if ( isset( $_POST['modula-settings'][ $field_id ] ) ) {
									$modula_settings[ $field_id ] = '1';
								}else{
									$modula_settings[ $field_id ] = '0';
								}
								break;
							case 'captionColor':
							case 'socialIconColor':
							case 'borderColor':
							case 'shadowColor':
								$modula_settings[ $field_id ] = Modula_Helper::sanitize_rgba_colour( $_POST['modula-settings'][ $field_id ] );
								break;
                            case 'lightbox_background_color':
                                $modula_settings[ $field_id ] = Modula_Helper::sanitize_rgba_colour( $_POST['modula-settings'][ $field_id ] );
                                break;
                            case 'lightbox_popup_opacity' :
                                $modula_settings[ $field_id ] =  $_POST['modula-settings'][ $field_id ];
                                break;
							case 'Effect' :
								if ( in_array( $_POST['modula-settings'][ $field_id ], $effect_values ) ) {
									$modula_settings[ $field_id ] = $_POST['modula-settings'][ $field_id ];
								}else{
									$modula_settings[ $field_id ] = 'pufrobo';
								}
								break;
							default:
								if( is_array( $_POST['modula-settings'][ $field_id ] ) ){
									$sanitized = array_map( 'sanitize_text_field', $_POST['modula-settings'][ $field_id ] );
									$modula_settings[ $field_id ] = apply_filters( 'modula_settings_field_sanitization', $sanitized, $_POST['modula-settings'][ $field_id ] ,$field_id, $field );
								}else{
									$modula_settings[ $field_id ] = apply_filters( 'modula_settings_field_sanitization', sanitize_text_field( $_POST['modula-settings'][ $field_id ] ), $_POST['modula-settings'][ $field_id ] ,$field_id, $field );
								}

								break;
						}

					}else{
						if ( 'toggle' == $field['type'] ) {
							$modula_settings[ $field_id ] = '0';
						}else{
							$modula_settings[ $field_id ] = '';
						}
					}

				}

			}

			// Save the value of helpergrid
			if ( isset( $_POST['modula-settings']['helpergrid'] ) ) {
				$modula_settings['helpergrid'] = 1;
			}else{
				$modula_settings['helpergrid'] = 0;
			}

			// Add settings to gallery meta
			update_post_meta( $post_id, 'modula-settings', $modula_settings );

		}

	}

	public function add_extensions_tab( $views ) {
		$this->display_feedback_notice();
		$this->display_extension_tab();
		return $views;
	}

	public function display_extension_tab() {
	?>
		<h2 class="nav-tab-wrapper">
			<?php
			$tabs = array(
				'galleries' => array(
					'name' => $this->labels['name'],
					'url'  => admin_url( 'edit.php?post_type=' . $this->cpt_name ),
				),
				'extensions' => array(
					'name' => __( 'Extensions', 'modula-best-grid-gallery' ),
					'url'  => admin_url( 'edit.php?post_type=' . $this->cpt_name . '&page=modula-addons' ),
				),
			);
			$tabs       = apply_filters( 'modula_add_edit_tabs', $tabs );
			$active_tab = 'galleries';
			foreach( $tabs as $tab_id => $tab ) {
				$active = ( $active_tab == $tab_id ? ' nav-tab-active' : '' );
				echo '<a href="' . esc_url( $tab['url'] ) . '" class="nav-tab' . $active . '">';
				echo esc_html( $tab['name'] );
				echo '</a>';
			}
			?>

			<a href="<?php echo admin_url( 'post-new.php?post_type=' . $this->cpt_name ); ?>" class="page-title-action">
				<?php esc_html_e( 'Add New', 'modula-best-grid-gallery' ); ?>
			</a>
		</h2>
		<br />
		<?php
	}

	public function display_feedback_notice() {

		$modula_options = get_option( 'modula-checks', array() );
		if ( isset( $modula_options['edit-notice'] ) ) {
			return;
		}

		$galleries = get_posts( 'post_type=modula-gallery' );
		if ( count( $galleries ) == 0 ) {
			return;
		}

		?>

		<div class="notice modula-feedback-notice">
			<p class="modula-feedback-title">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32"><path fill="#f0f5fa" d="M9.3 25.3c-2.4-0.7-4.7-1.4-7.1-2.1 2.4-3.5 4.7-7 7-10.5C9.3 12.9 9.3 24.9 9.3 25.3z"/><path fill="#f0f5fa" d="M9.6 20.1c3.7 2 7.4 3.9 11.1 5.9 -0.1 0.1-5 5-5.2 5.2C13.6 27.5 11.6 23.9 9.6 20.1 9.6 20.2 9.6 20.2 9.6 20.1z"/><path fill="#f0f5fa" d="M22.3 11.9c-3.7-2-7.4-4-11-6 0 0 0 0 0 0 0 0 0 0 0 0 1.7-1.7 3.4-3.3 5.1-5 0 0 0 0 0.1-0.1C18.5 4.5 20.4 8.2 22.3 11.9 22.4 11.9 22.3 11.9 22.3 11.9z"/><path fill="#f0f5fa" d="M4.7 15c-0.6-2.4-1.2-4.7-1.8-7 0.2 0 11.9 0.6 12.7 0.6 0 0 0 0 0 0 0 0 0 0 0 0 -3.6 2.1-7.2 4.2-10.7 6.3C4.8 15 4.8 15 4.7 15z"/><path fill="#f0f5fa" d="M22.9 19.6c-0.2-4.2-0.3-8.3-0.5-12.5 2.4 0.6 4.8 1.2 7.1 1.8C27.4 12.4 25.1 16 22.9 19.6 22.9 19.6 22.9 19.6 22.9 19.6z"/><path fill="#f0f5fa" d="M27.7 16.8c0.6 2.4 1.2 4.7 1.9 7.1 -4.2-0.2-8.5-0.4-12.7-0.5 0 0 0 0 0 0C20.5 21.2 24.1 19 27.7 16.8z"/></svg>
				Modula Image Gallery
			</p>
			<p><?php esc_html_e( 'Do you enjoy using Modula? Please take a minute to suggest a feature or tell us what you think.', 'modula-best-grid-gallery' ); ?></p>
			<a class="button" target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSc5eAZbxGROm_WSntX_3JVji2cMfS3LIbCNDKG1yF_VNe3R4g/viewform"><?php esc_html_e( 'Submit Feedback', 'modula-best-grid-gallery' ); ?></a>
			<a href="#" class="notice-dismiss"></a>
		</div>

		<?php
	}

	public function add_columns( $columns ){

		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'modula-best-grid-gallery' );
		$columns['limit']     = esc_html__('Images', 'modula-best-grid-gallery');
		$columns['date'] = $date;
		return $columns;

	}

	public function outpu_column( $column, $post_id ){

		if ( 'shortcode' == $column ) {
			$shortcode = '[modula id="' . $post_id . '"]';
			echo '<div class="modula-copy-shortcode">';
            echo '<input type="text" value="' . esc_attr($shortcode) . '"  onclick="select()" readonly>';
            echo '<a href="#" title="' . esc_attr__('Copy shortcode','modula-best-grid-gallery') . '" class="copy-modula-shortcode button button-primary dashicons dashicons-format-gallery" style="width:40px;"></a><span></span>';
            echo '</div>';
		}

		if ( 'limit' == $column) {
			$images = get_post_meta( $post_id, 'modula-images', true );
			$images_count = is_array( $images ) ? count( $images ) : 0;

			$padlock = '<svg id="padlock" style="margin:7px 12px 0 0; width:12px;position:relative;top:2px" viewBox="0 0 217.81886 310.38968" xmlns="http://www.w3.org/2000/svg">
			<g transform="translate(-1550.3 -1495.4)">
			 <path d="m1659.3 1495.5c-0.9683 0.01-1.9372 0.021-2.9063 0.062-44.496 0.284-84.418 39.853-84.531 84.469-0.5035 10.517 0.1466 21.042 0.031 31.563h-21.438c0.5678 46.226-1.1556 92.56 0.9062 138.72 4.4359 29.724 31.126 56.603 62.25 55.156 34.078-0.066 68.262 1.0541 102.28-0.6876 31.934-5.5024 54.359-38.293 51.938-70.031 0.3669-41.041-0.035-82.083 0.125-123.12-7.1142-0.1818-14.23 0.139-21.344-0.094 0.5401-24.99 1.715-52.307-12.531-73.969-15.406-25.706-44.767-42.255-74.781-42.062zm0.4062 35.688c25.281 0.3463 50.259 21.283 49.531 47.625 0.5019 10.922 0.8363 21.85 1.0626 32.781-34.011-0.02-68.021 0.053-102.03-0.063 0.1057-17.098-4.4827-35.793 4.875-51.187 8.4966-16.311 25.48-28.793 44.125-29.125 0.8153-0.032 1.622-0.043 2.4375-0.031z" fill="#fff" opacity=".98"/>
			 <path d="m1657.1 1501.5c-44.13 1.1108-79.312 37.031-79.312 81.438v34.625h-21.344v117.75h0.031c-0.031 0.8505-0.031 1.7033-0.031 2.5625 0 34.197 25.051 61.719 56.187 61.719h93.094c31.136 0 56.219-27.522 56.219-61.719 0-0.859-0.032-1.7123-0.063-2.5625h0.063v-117.75h-21.313v-34.625c0-45.111-36.295-81.438-81.406-81.438-0.7049 0-1.4245-0.018-2.125 0zm-0.375 23.75c0.5355-0.013 1.0865 0 1.625 0 25.79-0.6025 51.139 18.477 56.406 43.812 0.8967 16.166 1.4017 32.319 1.6876 48.5h-114.31c-0.027-7.7372-0.063-15.456-0.2187-23.188-6.5279-33.085 21.075-68.332 54.812-69.125zm2.375 135.38c1.2168 0 2.4472 0.095 3.6875 0.2812 13.23 1.9847 22.36 14.301 20.375 27.531-0.9138 6.092-4.0565 11.334-8.4375 15l8.4688 53.094h-48l8.4374-53.094c-6.2414-5.2417-9.7038-13.536-8.4062-22.188 1.7986-11.99 12.112-20.593 23.875-20.625z" opacity=".98"/> </g></svg> ';
		   
			$image_limit    = '<span>' . $images_count . ' / 20' . '</span>';
			$image_limit    = apply_filters( 'modula_output_image', $image_limit, $images_count );

			echo $image_limit;
			
		}


	}

	public function dismiss_edit_notice(){

		$modula_options = get_option( 'modula-checks', array() );
		$modula_options['edit-notice'] = 1;
		update_option( 'modula-checks', $modula_options );
		die( '1' );

	}
	

	public function replace_submit_meta_box() {
		global $post;
		$post_type = 'modula-gallery';
		remove_meta_box( 'submitdiv', $post_type, 'side' );
		add_meta_box( 'submitdiv', __( 'Publish' ), array($this, 'post_submit_meta_box'), $post_type, 'side', 'high' );
		
	}

	public function post_submit_meta_box() {
		global $action, $post;
		$post_type = $post->post_type; // get current post_type
		$post_type_object = get_post_type_object($post_type);
		$can_publish = current_user_can($post_type_object->cap->publish_posts);
		?>
		<div class="submitbox" id="submitpost">

<div id="minor-publishing">

	<?php // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key ?>
<div style="display:none;">
	<?php submit_button( __( 'Save' ), '', 'save' ); ?>
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
<input <?php echo $private_style; ?> type="submit" name="save" id="save-post" value="<?php esc_attr_e( 'Save Draft' ); ?>" class="button" />
<span class="spinner"></span>
<?php } elseif ( 'pending' == $post->post_status && $can_publish ) { ?>
<input type="submit" name="save" id="save-post" value="<?php esc_attr_e( 'Save as Pending' ); ?>" class="button" />
<span class="spinner"></span>
<?php } ?>
</div>
	<?php if ( is_post_type_viewable( $post_type_object ) ) : ?>
<div id="preview-action">
		<?php
		$preview_link = esc_url( get_preview_post_link( $post ) );
		if ( 'publish' == $post->post_status ) {
			$preview_button_text = __( 'Preview Changes' );
		} else {
			$preview_button_text = __( 'Preview' );
		}

		$preview_button = sprintf(
			'%1$s<span class="screen-reader-text"> %2$s</span>',
			$preview_button_text,
			/* translators: Accessibility text. */
			__( '(opens in a new tab)' )
		);
		?>
<a class="preview button" href="<?php echo $preview_link; ?>" target="wp-preview-<?php echo (int) $post->ID; ?>" id="post-preview"><?php echo $preview_button; ?></a>
<input type="hidden" name="wp-preview" id="wp-preview" value="" />
</div>
<?php endif; // public post type ?>
	<?php
	/**
	 * Fires before the post time/date setting in the Publish meta box.
	 *
	 * @since 4.4.0
	 *
	 * @param WP_Post $post WP_Post object for the current post.
	 */
	do_action( 'post_submitbox_minor_actions', $post );
	?>
<div class="clear"></div>
</div><!-- #minor-publishing-actions -->

<div id="misc-publishing-actions">

<div class="misc-pub-section misc-pub-post-status">
	<?php _e( 'Status:' ); ?> <span id="post-status-display">
			<?php

			switch ( $post->post_status ) {
				case 'private':
					_e( 'Privately Published' );
					break;
				case 'publish':
					_e( 'Published' );
					break;
				case 'future':
					_e( 'Scheduled' );
					break;
				case 'pending':
					_e( 'Pending Review' );
					break;
				case 'draft':
				case 'auto-draft':
					_e( 'Draft' );
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
<a href="#post_status" <?php echo $private_style; ?> class="edit-post-status hide-if-no-js" role="button"><span aria-hidden="true"><?php _e( 'Edit' ); ?></span> <span class="screen-reader-text"><?php _e( 'Edit status' ); ?></span></a>

<div id="post-status-select" class="hide-if-js">
<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ( 'auto-draft' == $post->post_status ) ? 'draft' : $post->post_status ); ?>" />
<label for="post_status" class="screen-reader-text"><?php _e( 'Set status' ); ?></label>
<select name="post_status" id="post_status">
		<?php if ( 'publish' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php _e( 'Published' ); ?></option>
<?php elseif ( 'private' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'private' ); ?> value='publish'><?php _e( 'Privately Published' ); ?></option>
<?php elseif ( 'future' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'future' ); ?> value='future'><?php _e( 'Scheduled' ); ?></option>
<?php endif; ?>
<option<?php selected( $post->post_status, 'pending' ); ?> value='pending'><?php _e( 'Pending Review' ); ?></option>
		<?php if ( 'auto-draft' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'auto-draft' ); ?> value='draft'><?php _e( 'Draft' ); ?></option>
<?php else : ?>
<option<?php selected( $post->post_status, 'draft' ); ?> value='draft'><?php _e( 'Draft' ); ?></option>
<?php endif; ?>
</select>
<a href="#post_status" class="save-post-status hide-if-no-js button"><?php _e( 'OK' ); ?></a>
<a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel"><?php _e( 'Cancel' ); ?></a>
</div>

<?php } ?>
</div><!-- .misc-pub-section -->

<div class="misc-pub-section misc-pub-visibility" id="visibility">
	<?php _e( 'Visibility:' ); ?> <span id="post-visibility-display">
							<?php

							if ( 'private' == $post->post_status ) {
								$post->post_password = '';
								$visibility          = 'private';
								$visibility_trans    = __( 'Private' );
							} elseif ( ! empty( $post->post_password ) ) {
								$visibility       = 'password';
								$visibility_trans = __( 'Password protected' );
							} elseif ( $post_type == 'post' && is_sticky( $post->ID ) ) {
								$visibility       = 'public';
								$visibility_trans = __( 'Public, Sticky' );
							} else {
								$visibility       = 'public';
								$visibility_trans = __( 'Public' );
							}

							echo esc_html( $visibility_trans );
							?>
</span>
	<?php if ( $can_publish ) { ?>
<a href="#visibility" class="edit-visibility hide-if-no-js" role="button"><span aria-hidden="true"><?php _e( 'Edit' ); ?></span> <span class="screen-reader-text"><?php _e( 'Edit visibility' ); ?></span></a>

<div id="post-visibility-select" class="hide-if-js">
<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php echo esc_attr( $post->post_password ); ?>" />
		<?php if ( $post_type == 'post' ) : ?>
<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky" <?php checked( is_sticky( $post->ID ) ); ?> />
<?php endif; ?>
<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php echo esc_attr( $visibility ); ?>" />
<input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php checked( $visibility, 'public' ); ?> /> <label for="visibility-radio-public" class="selectit"><?php _e( 'Public' ); ?></label><br />
		<?php if ( $post_type == 'post' && current_user_can( 'edit_others_posts' ) ) : ?>
<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php checked( is_sticky( $post->ID ) ); ?> /> <label for="sticky" class="selectit"><?php _e( 'Stick this post to the front page' ); ?></label><br /></span>
<?php endif; ?>
<input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php checked( $visibility, 'password' ); ?> /> <label for="visibility-radio-password" class="selectit"><?php _e( 'Password protected' ); ?></label><br />
<span id="password-span"><label for="post_password"><?php _e( 'Password:' ); ?></label> <input type="text" name="post_password" id="post_password" value="<?php echo esc_attr( $post->post_password ); ?>"  maxlength="255" /><br /></span>
<input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked( $visibility, 'private' ); ?> /> <label for="visibility-radio-private" class="selectit"><?php _e( 'Private' ); ?></label><br />

<p>
	<a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php _e( 'OK' ); ?></a>
	<a href="#visibility" class="cancel-post-visibility hide-if-no-js button-cancel"><?php _e( 'Cancel' ); ?></a>
</p>
</div>
<?php } ?>

</div><!-- .misc-pub-section -->

	<?php
	/* translators: Publish box date string. 1: Date, 2: Time. See https://secure.php.net/date */
	$date_string = __( '%1$s at %2$s' );
	/* translators: Publish box date format, see https://secure.php.net/date */
	$date_format = _x( 'M j, Y', 'publish box date format' );
	/* translators: Publish box time format, see https://secure.php.net/date */
	$time_format = _x( 'H:i', 'publish box time format' );

	if ( 0 != $post->ID ) {
		if ( 'future' == $post->post_status ) { // scheduled for publishing at a future date
			/* translators: Post date information. %s: Date on which the post is currently scheduled to be published. */
			$stamp = __( 'Scheduled for: %s' );
		} elseif ( 'publish' == $post->post_status || 'private' == $post->post_status ) { // already published
			/* translators: Post date information. %s: Date on which the post was published. */
			$stamp = __( 'Published on: %s' );
		} elseif ( '0000-00-00 00:00:00' == $post->post_date_gmt ) { // draft, 1 or more saves, no date specified
			$stamp = __( 'Publish <b>immediately</b>' );
		} elseif ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
			/* translators: Post date information. %s: Date on which the post is to be published. */
			$stamp = __( 'Schedule for: %s' );
		} else { // draft, 1 or more saves, date specified
			/* translators: Post date information. %s: Date on which the post is to be published. */
			$stamp = __( 'Publish on: %s' );
		}
		$date = sprintf(
			$date_string,
			date_i18n( $date_format, strtotime( $post->post_date ) ),
			date_i18n( $time_format, strtotime( $post->post_date ) )
		);
	} else { // draft (no saves, and thus no date specified)
		$stamp = __( 'Publish <b>immediately</b>' );
		$date  = sprintf(
			$date_string,
			date_i18n( $date_format, strtotime( current_time( 'mysql' ) ) ),
			date_i18n( $time_format, strtotime( current_time( 'mysql' ) ) )
		);
	}

	if ( ! empty( $args['args']['revisions_count'] ) ) :
		?>
<div class="misc-pub-section misc-pub-revisions">
		<?php
		/* translators: Post revisions heading. %s: The number of available revisions. */
		printf( __( 'Revisions: %s' ), '<b>' . number_format_i18n( $args['args']['revisions_count'] ) . '</b>' );
		?>
	<a class="hide-if-no-js" href="<?php echo esc_url( get_edit_post_link( $args['args']['revision_id'] ) ); ?>"><span aria-hidden="true"><?php _ex( 'Browse', 'revisions' ); ?></span> <span class="screen-reader-text"><?php _e( 'Browse revisions' ); ?></span></a>
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
		<span aria-hidden="true"><?php _e( 'Edit' ); ?></span>
		<span class="screen-reader-text"><?php _e( 'Edit date and time' ); ?></span>
	</a>
	<fieldset id="timestampdiv" class="hide-if-js">
		<legend class="screen-reader-text"><?php _e( 'Date and time' ); ?></legend>
		<?php touch_time( ( $action === 'edit' ), 1 ); ?>
	</fieldset>
</div><?php // /misc-pub-section ?>
<?php endif; ?>

	<?php if ( 'draft' === $post->post_status && get_post_meta( $post->ID, '_customize_changeset_uuid', true ) ) : ?>
	<div class="notice notice-info notice-alt inline">
		<p>
			<?php
			echo sprintf(
				/* translators: %s: URL to the Customizer. */
				__( 'This draft comes from your <a href="%s">unpublished customization changes</a>. You can edit, but there&#8217;s no need to publish now. It will be published automatically with those changes.' ),
				esc_url(
					add_query_arg(
						'changeset_uuid',
						rawurlencode( get_post_meta( $post->ID, '_customize_changeset_uuid', true ) ),
						admin_url( 'customize.php' )
					)
				)
			);
			?>
		</p>
	</div>
	<?php endif; ?>

	<?php
	/**
	 * Fires after the post time/date setting in the Publish meta box.
	 *
	 * @since 2.9.0
	 * @since 4.4.0 Added the `$post` parameter.
	 *
	 * @param WP_Post $post WP_Post object for the current post.
	 */
	do_action( 'post_submitbox_misc_actions', $post );
	?>
</div>
<div class="clear"></div>
</div>

<div id="major-publishing-actions">
	<?php
	/**
	 * Fires at the beginning of the publishing actions section of the Publish meta box.
	 *
	 * @since 2.7.0
	 * @since 4.9.0 Added the `$post` parameter.
	 *
	 * @param WP_Post|null $post WP_Post object for the current post on Edit Post screen,
	 *                           null on Edit Link screen.
	 */
	do_action( 'post_submitbox_start', $post );
	?>
<div id="delete-action">
	<?php
	if ( current_user_can( 'delete_post', $post->ID ) ) {
		if ( ! EMPTY_TRASH_DAYS ) {
			$delete_text = __( 'Delete Permanently' );
		} else {
			$delete_text = __( 'Move to Trash' );
		}
		?>
<a class="submitdelete deletion" href="<?php echo get_delete_post_link( $post->ID ); ?>"><?php echo $delete_text; ?></a>
													<?php
	}
	?>
</div>

<div id="publishing-action">
<span class="spinner"></span>
	<?php
	if ( ! in_array( $post->post_status, array( 'publish', 'future', 'private' ) ) || 0 == $post->ID ) {
		if ( $can_publish ) :
			if ( ! empty( $post->post_date_gmt ) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) :
				?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php echo esc_attr_x( 'Schedule', 'post action/button label' ); ?>" />
				<?php submit_button( _x( 'Schedule', 'post action/button label' ), 'primary large', 'publish', false ); ?>
	<?php	else : ?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update ') . 'modula-gallery';; ?>" />
		<?php submit_button( __( 'Save Gallery', 'modula-best-grid-gallery' ), 'primary large', 'publish', false ); ?>
		<?php
	endif;
	else :
		?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Submit for Review' ); ?>" />
		<?php submit_button( __( 'Submit for Review' ), 'primary large', 'publish', false ); ?>
		<?php
		endif;
	} else {
		?>
		
		<input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php esc_attr_e( 'Update Gallery', 'modula-best-grid-gallery' ). 'modula-gallery'; ?>" />
		<?php
	}
	?>
</div>
<div class="clear"></div>
</div>
</div> <?php
	  } 
	}



