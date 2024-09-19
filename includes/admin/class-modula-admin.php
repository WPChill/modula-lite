<?php

/**
 *
 */
class Modula_Admin {

	private $tabs;
	private $menu_links;
	private $version     = '2.0.0';
	private $current_tab = 'general';

	function __construct() {

		// Register our submenus
		add_action( 'admin_menu', array( $this, 'register_submenus' ) );

		// Show general tab
		add_action( 'modula_admin_tab_general', array( $this, 'show_general_tab' ) );

		// Add CSS to admin menu
		add_action( 'admin_head', array( $this, 'admin_custom_css' ) );

		add_action( 'modula_scripts_before_wp_modula', array( $this, 'add_autosuggest_scripts' ) );
		add_action( 'wp_ajax_modula_autocomplete', array( $this, 'autocomplete_url' ) );
		add_action( 'delete_attachment', array( $this, 'delete_resized_image' ) );

		add_action( 'wp_ajax_modula_lbu_notice', array( $this, 'modula_lbu_notice' ) );

		add_filter( 'admin_body_class', array( $this, 'add_body_class' ) );

		// Add Importer Tab.
		add_filter( 'modula_admin_page_tabs', array( $this, 'add_imp_exp_tab' ) );

		// Render Importer tab.
		add_action( 'modula_admin_tab_imp_exp', array( $this, 'render_imp_exp_tab' ) );

		add_action( 'modula_admin_tab_image_licensing', array( $this, 'render_image_licensing_tab' ) );
		add_action( 'admin_init', array( $this, 'update_image_licensing_options' ) );

		// WP Media ajax hook to add images to gallery
		add_action( 'wp_ajax_add_images_to_gallery', array( $this, 'add_images_to_gallery_callback' ) );
		
		// WP Media( list view ) add images to gallery bulk action
		add_filter( 'bulk_actions-upload', array( $this, 'modula_media_lib_bulk_actions' ), 15 );
		add_filter( 'handle_bulk_actions-upload', array( $this, 'modula_media_handle_bulk' ), 15, 3 );
		add_filter( 'admin_init', array( $this, 'modula_media_do_bulk' ), 15 );
		add_action( 'admin_notices', array( $this, 'media_add_notice' ) );
	}

	public function delete_resized_image( $post_id ) {

		$post = get_post( $post_id );

		if ( 'attachment' !== $post->post_type ) {
			return false;
		}

		// Get the metadata.
		$metadata = wp_get_attachment_metadata( $post_id );
		if ( ! $metadata ) {
			return;
		}

		if ( !isset($metadata['file'] ) ) {
			return;
		}

		$info     = pathinfo( $metadata['file'] );
		$uploads  = wp_upload_dir();
		$filename = $info['filename'];
		$file_dir = $uploads['basedir'] . '/' . $info['dirname'];
		$ext      = $info['extension'];

		if ( ! isset( $metadata['image_meta']['resized_images'] ) ) {
			return;
		}

		if ( count( $metadata['image_meta']['resized_images'] ) > 0 ) {

			foreach ( $metadata['image_meta']['resized_images'] as $value ) {
				$size = '-' . $value;

				// Format the files in the appropriate format
				$file = $file_dir . '/' . $filename . $size . '.' . $ext;
				// Delete found files
				wp_delete_file_from_directory( $file, $file_dir );

			}
		}

	}

	public function register_submenus() {

		/*
		*  -1 - License
		*  10 - 
		*  20 - Standalone
		*  30 - 
		*  40 - Advanced Shortcodes
		*  50 - Watermark
		*  60 - SpeedUp Settings
		*  70 - Image Licensing
		*  80 - Roles
		*  90 - Misc
		* 100 - Migrate galleries
		* 110 - Import/Export
		*/
		$tabs =  array(
			'standalone' => array(
				'label'    => esc_html__('Standalone', 'modula-best-grid-gallery'),
				'priority' => 20,
				'badge'    => 'PRO'
        	),
        	'compression' => array(
				'label'    => esc_html__('SpeedUp Settings', 'modula-best-grid-gallery'),
				'priority' => 30,
				'badge'    => 'PRO'
        	),
        	'shortcodes' => array(
				'label'    => esc_html__('Advanced Shortcodes', 'modula-best-grid-gallery'),
				'priority' => 40,
				'badge'    => 'PRO'
        	),
        	'watermark' => array(
				'label'    => esc_html__('Watermark', 'modula-best-grid-gallery'),
				'priority' => 50,
				'badge'    => 'PRO'
        	),
        	'image_licensing' => array(
				'label'    => esc_html__('Image Licensing', 'modula-best-grid-gallery'),
				'priority' => 70,
        	),
			'roles' => array(
				'label'    => esc_html__('Roles', 'modula-best-grid-gallery'),
				'priority' => 80,
				'badge'    => 'PRO'
        	),
			'imageseo' => array(
				'label'    => esc_html__('Image SEO', 'modula-best-grid-gallery'),
				'priority' => 85,
				'badge'    => 'PRO'
        	),
			'video' => array(
				'label'    => esc_html__('Video', 'modula-best-grid-gallery'),
				'priority' => 125,
				'badge'    => 'PRO'
			),
		);
		$this->tabs = apply_filters( 'modula_admin_page_tabs', $tabs );

		$links = array(
			'freevspro' => array(
				'page_title' => esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ),
				'menu_title' => esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'modula-lite-vs-pro',
				'function'   => array( $this, 'lite_vs_pro' ),
				'priority'   => 100,
				'hidden'     => true,
			),
		);

		$links['modulaalbums'] = array(
			'page_title' => esc_html__( 'Albums', 'modula-best-grid-gallery' ),
			'menu_title' => esc_html__( 'Albums', 'modula-best-grid-gallery' ),
			'capability' => 'manage_options',
			'menu_slug'  => '#modula-albums',
			'function'   => array( $this, 'modula_albums' ),
			'priority'   => 3,
		);

		$links['moduladefaults'] = array(
			'page_title' => esc_html__( 'Defaults', 'modula-best-grid-gallery' ),
			'menu_title' => esc_html__( 'Defaults', 'modula-best-grid-gallery' ),
			'capability' => 'manage_options',
			'menu_slug'  => '#gallery-defaults',
			'function'   => array( $this, 'modula_gallery_defaults' ),
			'priority'   => 1,
		);

		$links['albumsdefaults'] = array(
			'page_title' => esc_html__( 'Defaults', 'modula-best-grid-gallery' ),
			'menu_title' => esc_html__( 'Defaults', 'modula-best-grid-gallery' ),
			'capability' => 'manage_options',
			'menu_slug'  => '#albums-defaults',
			'function'   => array( $this, 'modula_albums_defaults' ),
			'priority'   => 4,
		);


		if ( current_user_can( 'install_plugins' ) ) {
			$links[] =
				array(
					'page_title' => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
					'menu_title' => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
					'capability' => 'manage_options',
					'menu_slug'  => 'modula-addons',
					'function'   => array( $this, 'show_extension_page_tabs' ),
					'priority'   => 99,
				);
		}

		$links['modulalicense'] = array(
			'page_title' => esc_html__( 'Image Licenses', 'modula-best-grid-gallery'),
			'menu_title' => esc_html__( 'Image Licenses', 'modula-best-grid-gallery' ),
			'capability' => 'manage_options',
			'menu_slug'  => '#modula-licenses',
			'function'   => array( $this, 'modula_licenses' ),
			'priority'   => 28,
		);

		if ( ! empty( $this->tabs ) ) {
			$links[] = array(
				'page_title' => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
				'menu_title' => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'modula',
				'function'   => array( $this, 'show_submenu' ),
				'priority'   => 30,
			);
		}

		$this->menu_links = apply_filters( 'modula_admin_page_link', $links );

		// Sort tabs based on priority.
		uasort( $this->tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		// move pro tabs at the end
		$pro_tabs = array();
		foreach ( $this->tabs as $key => $tab ) {
			if ( isset( $tab['badge'] ) && 'PRO' == $tab['badge'] ) {
				$pro_tabs[ $key ] = $tab;
				unset( $this->tabs[ $key ] );
			}
		}
		$this->tabs = array_merge( $this->tabs, $pro_tabs );

		// Sort menu items based on priority
		uasort( $this->menu_links, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		if ( ! empty( $this->menu_links ) ) {
			foreach ( $this->menu_links as $link ) {
				if ( ! empty( $link ) ) {
					add_submenu_page( ( isset( $link['hidden'] ) && $link['hidden'] ) ? '' : 'edit.php?post_type=modula-gallery', $link['page_title'], $link['menu_title'], $link['capability'], $link['menu_slug'], $link['function'], $link['priority'] );
				}
			}
		}

	}

	public function show_submenu() {

		// Get current tab
		if ( isset( $_GET['modula-tab'] ) && isset( $this->tabs[ $_GET['modula-tab'] ] ) ) {
			$this->current_tab = sanitize_text_field( wp_unslash( $_GET['modula-tab'] ) );
		} else {

			$tabs              = array_keys( $this->tabs );
			$this->current_tab = $tabs[0];

		}

		include 'tabs/modula.php';
	}

	public function show_extension_page_tabs() {

		$tabs = array(
			'galleries'       => array(
				'name'     => esc_html__( 'Galleries', 'modula-best-grid-gallery' ),
				'url'      => admin_url( 'edit.php?post_type=modula-gallery' ),
				'priority' => '1',
			),
			'suggest_feature' => array(
				'name'     => esc_html__( 'Suggest a feature', 'modula-best-grid-gallery' ),
				'icon'     => 'dashicons-external',
				'url'      => 'https://docs.google.com/forms/d/e/1FAIpQLSc5eAZbxGROm_WSntX_3JVji2cMfS3LIbCNDKG1yF_VNe3R4g/viewform',
				'target'   => '_blank',
				'priority' => '10',
			),
		);

		if ( current_user_can( 'install_plugins' ) ) {
			$tabs[ 'extensions' ] = array(
					'name'     => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
					'url'      => admin_url( 'edit.php?post_type=modula-gallery&page=modula-addons' ),
					'priority' => '5',
			);
		}

		$tabs = apply_filters( 'modula_extesions_tabs', $tabs );

		uasort( $tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		$active_tab = 'extensions';
		if ( isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ) {
			$active_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		}
		?>
		<div class="wrap">


		<h2 class="nav-tab-wrapper">
			<?php
			Modula_Admin_Helpers::modula_tab_navigation( $tabs, $active_tab );
			?>
			<?php do_action('modula_extensions_tabs_extra_actions'); ?>
			<div class="reload-extensions-wrapper">
				<?php
				$t_ext_timeout = get_transient( 'timeout_modula_all_extensions' );
				$timezone      = get_option( 'timezone_string' );
				$gmt_offset    = get_option( 'gmt_offset' );
				$offset        = 30 * DAY_IN_SECONDS;

				$dt = new DateTime();


				if ( $t_ext_timeout ) {

					echo '<span class="description last-reloaded-extensions">' . esc_html__( 'Last reload: ', 'modula-best-grid-gallery' );

					if ( $timezone && '' != $timezone && (!$gmt_offset || '' == $gmt_offset )) {
						$dt->setTimezone( new DateTimeZone( $timezone ) );
					}

					if ( $gmt_offset && '' != $gmt_offset ) {
						$offset = $offset - ( (int)$gmt_offset * 60 * 60 );
					}

					$dt->setTimestamp( $t_ext_timeout - $offset );

					echo esc_html( $dt->format( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) );

					echo '</span>';
				}
				?>
				<a id="modula-reload-extensions" class="button button-secondary"
				   data-nonce="<?php echo esc_attr( wp_create_nonce( 'modula-reload-extensions' ) ); ?>"><span
							class="dashicons dashicons-update"></span><?php esc_html_e( 'Reload Extensions', 'modula-best-grid-gallery' ); ?>
				</a>
			</div>

		</h2>
		<?php

		if ( 'extensions' == $active_tab ) {

			$addons = new Modula_Addons();
			$pro_ext = false;

			if(!isset($_GET['extensions']) || 'pro' === $_GET['extensions']){
				$pro_ext = true;
			}

			if( $addons->check_free_addons() ){
			?>
				<div class="modula-subtab-navigation wp-clearfix wrap">
					<ul class="subsubsub">
						<li><a href="<?php echo esc_url( add_query_arg(array('extensions' =>'pro')) ); ?>" class="<?php echo $pro_ext ? 'current' : ''; ?>"><?php esc_html_e( 'PRO', 'modula-best-grid-gallery' ); ?></a> | </li>
						<li><a href="<?php echo esc_url( add_query_arg(array('extensions' =>'free')) ); ?>" class="<?php echo !$pro_ext ? 'current' : ''; ?>"><?php esc_html_e( 'Free', 'modula-best-grid-gallery' ); ?></a></li>
					</ul>
				</div>
			<?php
			 }
			?>

			<div class="modula-addons-container <?php echo !$pro_ext ? 'hidden' : ''; ?>">
				<?php $addons->render_addons(); ?>
			</div>
			<?php if( $addons->check_free_addons() ){ ?>
				<div class="modula-free-addons-container <?php echo $pro_ext ? 'hidden' : ''; ?>">
					<?php $addons->render_free_addons(); ?>
				</div>
				<?php
			}
		} else {
			do_action( "modula_exntesion_{$active_tab}_tab" );
		}

	}

	public function show_general_tab() {
		include 'tabs/general.php';
	}

	public function admin_custom_css() {
		?>
		<style type="text/css">
			li#menu-posts-modula-gallery .wp-submenu li a[href$="modula-lite-vs-pro"] {color: gold;}
		</style>

		<?php
	}


	/**
	 *  Add Import/Export tutorial
	 *
	 * @since 2.2.7
	 */
	public function import_export_doc() { 
		?>
		<div class="wrap">
			<div class="card">
				<h3><?php esc_html_e( 'Import Galleries', 'modula-best-grid-gallery' ); ?></h3>
				<p><?php esc_html_e( 'In order to import exported galleries head over to "Tools -> Import" or click', 'modula-best-grid-gallery' ); ?>
					<a href="<?php echo esc_url( admin_url( 'import.php' ) ); ?>"><?php esc_html_e( 'here.', 'modula-best-grid-gallery' ); ?></a>
				</p>
				<p><?php echo '<a href="' . esc_url( 'https://wordpress.org/plugins/wordpress-importer/' ) . '" target="_blank">' . esc_html__( 'Install WordPress Importer', 'modula-best-grid-gallery' ) . '</a>' . esc_html__( '( if not installed ). If installed, click on WordPress "Run importer". After that select the export file you desire and click "Upload file and import".', 'modula-best-grid-gallery' ); ?></p>
			</div>
			<div class="card">
				<h3><?php esc_html_e( 'Export Galleries', 'modula-best-grid-gallery' ); ?></h3>
				<p><?php esc_html_e( 'In order to export Modula galleries head over to "Tools -> Export" or click', 'modula-best-grid-gallery' ); ?>
					<a href="<?php echo esc_url( admin_url( 'export.php' ) ); ?>"><?php esc_html_e( 'here.', 'modula-best-grid-gallery' ); ?></a>
				</p>
				<p><?php echo esc_html__( 'Select "Galleries" and click "Download Export File". An export file will be created and downloaded, which will be used to import the galleries somewhere else.', 'modula-best-grid-gallery' ); ?></p>
			</div>
		</div>
		<?php

	}

    /**
     * Add Importer tab
     *
     * @param $tabs
     * @return mixed
     *
     * @since 2.2.7
     */
    public function add_imp_exp_tab($tabs) {
        $tabs['imp_exp'] = array(
            'label'    => esc_html__('Import/Export', 'modula-best-grid-gallery'),
            'priority' => 100,
        );

        return $tabs;
    }


    /**
     * Render Importer tab
     *
     * @since 2.2.7
     */
    public function render_imp_exp_tab() {
        $this->import_export_doc();
    }


	/**
	 * Update modula-checks option for lightbox upgrade notice 1
	 *
	 * @since 2.3.0
	 */
	public function modula_lbu_notice() {

		$nonce = '';
		
		if( isset( $_POST['nonce'] ) ){
			$nonce = $_POST['nonce'];
		}


		if ( ! wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
			wp_send_json_error();
			die();
		}

		$modula_checks               = get_option( 'modula-checks', array() );
		$modula_checks['lbu_notice'] = '1';

		update_option( 'modula-checks', $modula_checks );
		wp_die();

	}

	/**
	 * Enqueue jQuery autocomplete script
	 *
	 * /@since 2.3.2
	 */
	public function add_autosuggest_scripts() {

		wp_enqueue_script( 'jquery-ui-autocomplete' );

	}

	public function autocomplete_url() {

		$nonce = $_GET['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
			die();
		}

		$suggestions = array();
		$term        = sanitize_text_field( $_GET['term'] );

		$loop = new WP_Query( 's=' . $term );
		while ( $loop->have_posts() ) {
			$loop->the_post();
			$suggestion['label'] = get_the_title();
			$suggestion['type']  = get_post_type();
			$suggestion['value'] = get_permalink();
			$suggestions[]       = $suggestion;
		}

		echo json_encode( $suggestions );
		exit();
	}

	/**
	 *  Add LITE vs PRO page
	 *
	 * @since 2.5.0
	 */
	public function lite_vs_pro() {

	$pro_features = array(
			'gallery-filters' => array(
				'title'       => esc_html__( 'Gallery Filters', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Let visitors filter your gallery items with a single click', 'modula-best-grid-gallery' ),
			),
			'gallery-sorting' => array(
				'title'       => esc_html__( 'Gallery Sorting', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Multiple choices for sorting out images from your gallery: manual, date created, date modified, alphabetically, reverse or random', 'modula-best-grid-gallery' ),
			),
			'hover-effects' => array(
				'title'       => esc_html__( 'Hover Effects', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Choose from 42 different hover effects.', 'modula-best-grid-gallery' ),
			),
			'loadng-effects' => array(
				'title'       => esc_html__( 'Loading Effects', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Build your own effects with these new customizations', 'modula-best-grid-gallery' ),
			),
		);

		echo '<div class="modula wrap lite-vs-pro-section about-wrap">';

		do_action( 'modula_lite_vs_premium_page', $pro_features );

		echo '</div>';

	}

	public function modula_albums() {
		return;
	}

	public function modula_licenses() {
		return;
	}

	public function modula_gallery_defaults() {
		return;
	}

	public function modula_albums_defaults() {
		return;
	}

	public function add_body_class( $classes ){
		$screen = get_current_screen();

		if ( 'modula-gallery' != $screen->post_type ) {
			return $classes;
		}

		if ( 'post' != $screen->base ) {
			return $classes;
		}

		$classes .= ' single-modula-gallery';
		return $classes;

	}

	public function render_image_licensing_tab() {
		include MODULA_PATH . 'includes/admin/tabs/image-licensing.php';
	}

	/**
	 * Update troubleshooting options.
	 */
	public function update_image_licensing_options() {

		if ( ! isset( $_POST['modula-image-licensing-submit'] ) ) {
			return;
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'modula_image_licensing_option_post' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options    = isset( $_POST['modula_image_licensing_option'] ) ? wp_unslash( $_POST['modula_image_licensing_option'] ) : false;
        $ia_options = array();

        if ( is_array( $options ) && ! empty( $options ) ) {
            foreach ( $options as $option => $value ) {
                if ( is_array( $value ) ) {
                    $ia_options[ $option ] = array_map( 'sanitize_text_field', $value );
                }else{
                    $ia_options[ $option ] = sanitize_text_field( $value );
                }
                
            }
        }

        update_option( 'modula_image_licensing_option', $ia_options );
	}

	/**
	 * Adds images to a specific gallery
	 */
	public function add_images_to_gallery_callback() {
		// Verifică nonce-ul pentru securitate
		check_ajax_referer( 'modula-ajax-save', 'nonce' );
	
		$post_images = isset( $_POST['selected'] ) ? json_decode( stripslashes( $_POST['selected'] ), true ) : array();
		$gallery_id  = isset( $_POST['gallery_id'] ) ? intval( $_POST['gallery_id'] ) : 0;
		$data        = array( 
			'old_images' => array(),
			'counter'    => array( 'added' => 0, 'skipped' => 0 ),
		);

		if ( empty( $post_images ) || $gallery_id <= 0 ) {
			if ( empty( $post_images ) ) {
				wp_send_json_error( esc_html__( 'No images were selected.', 'modula-best-grid-gallery' ) );
			}
			elseif ( $gallery_id <= 0 ) {
				wp_send_json_error( esc_html__( 'You must select a gallery where the images should be added.', 'modula-best-grid-gallery' ) );
			}

			die();
		}

		$data['old_images'] = get_post_meta( $gallery_id, 'modula-images', true );

		if( ! is_array( $data['old_images'] ) ){
			$data['old_images'] = array();
		}
		$current_images = array_column( $data['old_images'], 'id' );
		if ( is_array( $post_images ) ) {
			foreach ( $post_images as $image ) {
				if( ! isset( $image['id'] ) || in_array( $image['id'], $current_images ) ){
					$data['counter']['skipped']++;
					continue;
				}

				if( ! isset( $image['type'] ) || ( isset( $image['type'] ) && 'image' !== $image['type'] ) ){
					$data['counter']['skipped']++;
					continue;
				}

				$data['old_images'][] = Modula_Admin_Helpers::sanitize_image( $image );
				$data['counter']['added']++;
			}
		}

		// Determine singular/plural for 'image'
		$image_text   = ( $data['counter']['added'] === 1 ) ? __( 'image was', 'modula-best-grid-gallery' ) : __( 'images were', 'modula-best-grid-gallery' );
		$skipped_text = ( $data['counter']['skipped'] === 1 ) ? __( 'image was', 'modula-best-grid-gallery' ): __( 'images were', 'modula-best-grid-gallery' );

		// Construct the response message
		$message = apply_filters( 
			'modula_grid_add_images_to_gallery_message', 
			sprintf(
				esc_html__( '%d %s added, and %d %s skipped (already added in the gallery or incorrect extension).', 'modula-best-grid-gallery' ),
				absint( $data['counter']['added'] ),
				esc_html( $image_text ),
				absint( $data['counter']['skipped'] ),
				esc_html( $skipped_text ),
			),
			$post_images,
			$gallery_id,
			$current_images
		);

		$data = apply_filters( 'modula_grid_add_images_to_gallery', $data, $post_images, $gallery_id, $current_images );
		update_post_meta( $gallery_id, 'modula-images', $data['old_images'] );

		wp_send_json_success( esc_html( $message ) );
		die();
	}

	
	
	/**
	 * Add bulk actions to Media Library table
	 *
	 * @param $bulk_actions
	 *
	 * @return mixed
	 * @since 2.8.17
	 */
	public function modula_media_lib_bulk_actions( $bulk_actions ) {
		// Check if there are any posts of the custom post type 'modula-gallery'
		$modula_gallery_count = wp_count_posts( 'modula-gallery' );
	
		// If there are any published or other statuses posts, add the bulk action
		if ( isset( $modula_gallery_count->publish ) && $modula_gallery_count->publish > 0 ) {
			$bulk_actions['modula_add_to_gallery'] = __( 'Add Images to Modula Gallery', 'modula-best-grid-gallery' );
		}
	
		return $bulk_actions;
	}

	/**
	 * Handle our bulk actions
	 *
	 * @param $location
	 * @param $doaction
	 * @param $post_ids
	 *
	 * @return string
	 * @since 2.8.17
	 */
	public function modula_media_handle_bulk( $location, $doaction, $post_ids ) {

		// Only allow admins to do this.
		if ( ! current_user_can( 'manage_options' ) ) {
			return $location;
		}

		if( isset( $_GET['modula_gallery_select_top'] ) && 0 !== absint( $_GET['modula_gallery_select_top'] ) ){
			$gallery_id = absint( $_GET['modula_gallery_select_top'] );
		}elseif( isset( $_GET['modula_gallery_select_bottom'] ) && 0 !== absint( $_GET['modula_gallery_select_bottom'] ) ){
			$gallery_id = absint( $_GET['modula_gallery_select_bottom'] );
		}else{
			return $location;
		}


		if ( 'modula_add_to_gallery' === $doaction ) {
			return admin_url(
				add_query_arg(
					array(
						'modula_bulk_action' => $doaction,
						'gallery_id' => $gallery_id,
						'posts'      => $post_ids,
					), '/upload.php' ) );
		}

		return $location;
	}

	/**
	 * Bulk action for adding images to gallery
	 *
	 * @return void
	 * @since 2.8.17
	 */
	public function modula_media_do_bulk() {
		// If there's no action or posts, bail.
		if ( ! isset( $_GET['modula_bulk_action'] ) || ! isset( $_GET['posts'] ) || ! isset( $_GET['gallery_id'] ) ) {
			return;
		}
		
		// Only allow admins to do this.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		
		$action       = sanitize_text_field( wp_unslash( $_GET['modula_bulk_action'] ) );
		$posts        = array_map( 'absint', $_GET['posts'] );
		$gallery_id   = absint( $_GET['gallery_id'] );
		$redirect_url = admin_url('upload.php');
		$data         = array( 
			'old_images' => array(),
			'counter'    => array( 'added' => 0, 'skipped' => 0 ),
		);

		if ( 'modula-gallery' !== get_post_type( $gallery_id ) ) {
			return;
		}

		if ( 'modula_add_to_gallery' === $action ) {
			
			$data['old_images'] = get_post_meta( $gallery_id, 'modula-images', true );

			if( ! is_array( $data['old_images'] ) ){
				$data['old_images'] = array();
			}
			$current_images = array_column( $data['old_images'], 'id' );

			foreach ( $posts as $post_id ) {

				// If it's allready in gallery, skip it.
				if( ! isset( $post_id ) || in_array( $post_id, $current_images ) ){
					$data['counter']['skipped']++;
					continue;
				}

				$post = get_post( $post_id, ARRAY_A );
				// If it's not an image
				if ( ! isset( $post ) || ! isset( $post['post_mime_type'] ) || false === strpos( $post['post_mime_type'], 'image') ) {
					$data['counter']['skipped']++;
					continue;
				}

				$data['old_images'][] = Modula_Admin_Helpers::sanitize_image( $this->get_modula_image_data( $post ) );
				$data['counter']['added']++;
			}

			$data = apply_filters( 'modula_bulk_add_images_to_gallery', $data, $posts, $gallery_id, $current_images );
			update_post_meta( $gallery_id, 'modula-images', $data['old_images'] );

			$redirect_url = add_query_arg(
				array(
					'modula_media_added' => absint( $data['counter']['added'] ),
					'modula_media_skipped' => absint( $data['counter']['skipped'] ),
				),
				admin_url('upload.php')
			);
		}

		wp_redirect( $redirect_url );
		exit;
	}

	private function get_modula_image_data( $img_data ){

		$new_image = array(
			'id'          => '',
			'title'       => '',
			'description' => '',
			'alt'         => '',
			'link'        => '',
			'halign'      => 'center',
			'valign'      => 'middle',
			'target'      => '',
			'togglelightbox' => '',
			'hide_title'  => '',
			'src'         => '',
			'type'        => 'image',
			'width'       => 2,
			'height'      => 2,
			'full'        => '',
			'thumbnail'   => '',
			'resize'      => false,
			'index'       => '',
			'orientation' => 'landscape'
		);

		$img_metadata = wp_get_attachment_metadata( $img_data['ID'] );

		$new_image['id'] = $img_data['ID'];

		if ( isset( $img_data['post_title'] ) ) {
			$new_image['title'] = $img_data['post_title'];
		}
		
		if ( isset( $img_data['post_excerpt'] ) ) {
			$new_image['description'] = $img_data['post_excerpt'];
		}

		if ( isset( $img_metadata['image_meta'] ) && isset( $img_metadata['image_meta']['orientation'] ) && '0' === $img_metadata['image_meta']['orientation'] ) {
			$new_image['orientation'] = 'portrait';
		}

		return $new_image;
		
	}

	public function media_add_notice() {
		$screen = get_current_screen();
	
		if ( $screen->base !== 'upload' && $screen->base !== 'media_page_upload' ) {
			return;
		}
	
		if( isset( $_GET['modula_media_added'] ) && isset( $_GET['modula_media_skipped'] ) ){
			$added   = absint( $_GET['modula_media_added'] );
			$skipped = absint( $_GET['modula_media_skipped'] );
		}else{
			return;
		}
	
		$added_text = _n('image was', 'images were', $added, 'modula-best-grid-gallery');
		$skipped_text = _n('image was', 'images were', $skipped, 'modula-best-grid-gallery');
	
		$message = apply_filters( 'modula_bulk_add_images_to_gallery_message', sprintf(
			esc_html__( '%d %s added, and %d %s skipped (already added in the gallery or incorrect extension)', 'modula-best-grid-gallery' ),
			$added,
			$added_text,
			$skipped,
			$skipped_text,
		) );
	
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php echo $message; ?></p>
		</div>
		<?php
	}

}

new Modula_Admin();
