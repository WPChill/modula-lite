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

		$this->metaboxes = apply_filters( 'modula_cpt_metaboxes', array(
			'modula-preview-gallery' => array(
				'title' => esc_html__( 'Gallery', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_images',
				'context' => 'normal',
			),
			'modula-settings' => array(
				'title' => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_settings',
				'context' => 'normal',
			),
			'modula-shortcode' => array(
				'title' => esc_html__( 'Shortcode', 'modula-best-grid-gallery' ),
				'callback' => 'output_gallery_shortcode',
				'context' => 'side',
			),
		) );

		$this->cpt_name = apply_filters( 'modula_cpt_name', 'modula-gallery' );

		add_action( 'init', array( $this, 'register_cpt' ) );

		/* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'meta_boxes_setup' ) );

		/*  */
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

		foreach ( $this->metaboxes as $metabox_id => $metabox ) {

			if ( 'modula-shortcode' == $metabox_id && 'auto-draft' == $post->post_status ) {
				break;
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
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
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
					$sizes = $this->resizer->get_image_size( $new_image['id'], $img_size, $gallery_type, $grid_sizes );
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
								$modula_settings[ $field_id ] = absint( $_POST['modula-settings'][ $field_id ] );
								break;
							case 'lightbox' :
								if ( in_array( $_POST['modula-settings'][ $field_id ], $lightbox_values ) ) {
									$modula_settings[ $field_id ] = sanitize_text_field( $_POST['modula-settings'][ $field_id ] );
								}else{
									$modula_settings[ $field_id ] = 'lightbox2';
								}
								break;
							case 'enableTwitter' :
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
								$modula_settings[ $field_id ] = sanitize_hex_color( $_POST['modula-settings'][ $field_id ] );
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
		?>

		<div class="notice modula-feedback-notice">
			<p class="modula-feedback-title">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32"><path fill="#f0f5fa" d="M9.3 25.3c-2.4-0.7-4.7-1.4-7.1-2.1 2.4-3.5 4.7-7 7-10.5C9.3 12.9 9.3 24.9 9.3 25.3z"/><path fill="#f0f5fa" d="M9.6 20.1c3.7 2 7.4 3.9 11.1 5.9 -0.1 0.1-5 5-5.2 5.2C13.6 27.5 11.6 23.9 9.6 20.1 9.6 20.2 9.6 20.2 9.6 20.1z"/><path fill="#f0f5fa" d="M22.3 11.9c-3.7-2-7.4-4-11-6 0 0 0 0 0 0 0 0 0 0 0 0 1.7-1.7 3.4-3.3 5.1-5 0 0 0 0 0.1-0.1C18.5 4.5 20.4 8.2 22.3 11.9 22.4 11.9 22.3 11.9 22.3 11.9z"/><path fill="#f0f5fa" d="M4.7 15c-0.6-2.4-1.2-4.7-1.8-7 0.2 0 11.9 0.6 12.7 0.6 0 0 0 0 0 0 0 0 0 0 0 0 -3.6 2.1-7.2 4.2-10.7 6.3C4.8 15 4.8 15 4.7 15z"/><path fill="#f0f5fa" d="M22.9 19.6c-0.2-4.2-0.3-8.3-0.5-12.5 2.4 0.6 4.8 1.2 7.1 1.8C27.4 12.4 25.1 16 22.9 19.6 22.9 19.6 22.9 19.6 22.9 19.6z"/><path fill="#f0f5fa" d="M27.7 16.8c0.6 2.4 1.2 4.7 1.9 7.1 -4.2-0.2-8.5-0.4-12.7-0.5 0 0 0 0 0 0C20.5 21.2 24.1 19 27.7 16.8z"/></svg>
				Modula Image Gallery
			</p>
			<p><?php esc_html_e( 'Do you enjoy using Modula? Please take a minute to suggest a feature or tell us what you think.', 'modula-best-grid-gallery' ); ?></p>
			<a class="button" target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSc5eAZbxGROm_WSntX_3JVji2cMfS3LIbCNDKG1yF_VNe3R4g/viewform"><?php esc_html_e( 'Submit Feedback', 'modula-best-grid-gallery' ); ?></a>
		</div>

		<?php
	}

	public function add_columns( $columns ){

		$date = $columns['date'];
		unset( $columns['date'] );
		$columns['shortcode'] = esc_html__( 'Shortcode', 'modula-best-grid-gallery' );
		$columns['date'] = $date;
		return $columns;

	}

	public function outpu_column( $column, $post_id ){

		if ( 'shortcode' == $column ) {
			$shortcode = '[modula id="' . $post_id . '"]';
			echo '<input type="text" value="' . esc_attr( $shortcode ) . '"  onclick="select()" readonly>';
		}

	}

}
