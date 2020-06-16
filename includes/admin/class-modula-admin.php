<?php

/**
 *
 */
class Modula_Admin {

	private $tabs;
	private $menu_links;
	private $version = '2.0.0';
	private $current_tab = 'general';

	function __construct() {

		// Register our submenus
		add_action( 'admin_menu', array( $this, 'register_submenus' ) );

		// Show general tab
		add_action( 'modula_admin_tab_general', array( $this, 'show_general_tab' ) );

		// Add CSS to admin menu
		add_action( 'admin_head', array( $this, 'admin_custom_css' ) );

		add_action( 'wp_ajax_modula_save_images', array( $this, 'save_images' ) );
		add_action( 'wp_ajax_modula_save_image', array( $this, 'save_image' ) );
		add_action( 'modula_scripts_before_wp_modula', array( $this,  'add_autosuggest_scripts') );
		add_action( 'wp_ajax_modula_autocomplete', array( $this, 'autocomplete_url'));
		add_action( 'delete_attachment', array( $this, 'delete_resized_image') ) ;

		add_action( 'admin_notices', array( $this, 'modula_upgrade_lightbox_notice' ) );
		add_action( 'wp_ajax_modula_lbu_notice', array( $this, 'modula_lbu_notice' ) );
		add_action( 'wp_ajax_modula_lbu_notice_2', array( $this, 'modula_lbu_notice_2' ) );

		// Announce users about the lightbox change
		add_filter( 'modula_lightboxes_tab_content', array( $this, 'lightbox_change_announcement' ) );


	}

	public function delete_resized_image( $post_id ) {

		$post = get_post( $post_id );

		if ( 'attachment' !== $post->post_type ) {
			return false;
		}

		// Get the metadata
		$metadata =  wp_get_attachment_metadata( $post_id );
		if ( ! $metadata ) {
			return;
		}
		$info     = pathinfo( $metadata['file'] );
		$uploads  = wp_upload_dir();
		$filename = $info['filename'];
		$file_dir = $uploads['basedir'] .'/'. $info['dirname'];
		$ext      = $info['extension'];

		if ( ! isset( $metadata['image_meta']['resized_images'] ) ) {
			return;
		}

		if ( count( $metadata['image_meta']['resized_images'] ) > 0 ) {

			foreach ( $metadata['image_meta']['resized_images'] as $value ) {
				$size = "-" . $value;

				// Format the files in the appropriate format
				$file = $file_dir . '/' . $filename . $size . '.' . $ext;
				// Delete found files
				wp_delete_file_from_directory( $file, $file_dir);

			}

		}

	}

	public function register_submenus() {

		$this->tabs       = apply_filters( 'modula_admin_page_tabs', array() );

		$links = array(
			array(
				'page_title' => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
				'menu_title' => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
				'capability' => 'manage_options',
				'menu_slug' => 'modula-addons',
				'function' => array( $this, 'show_addons' ),
				'priority' => 99
			),
			array(
				'page_title' => esc_html__( 'Import/Export', 'modula-best-grid-gallery' ),
				'menu_title' => esc_html__( 'Import/Export', 'modula-best-grid-gallery' ),
				'capability' => 'manage_options',
				'menu_slug' => 'modula-import-export',
				'function' => array( $this, 'import_export_doc' ),
				'priority' => 35
			)
		);

		if ( ! empty( $this->tabs ) ) {
			$links[] = array(
					'page_title' => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
					'menu_title' => esc_html__( 'Settings', 'modula-best-grid-gallery' ),
					'capability' => 'manage_options',
					'menu_slug' => 'modula',
					'function' => array( $this, 'show_submenu' ),
					'priority' => 30
			);
		}

		$this->menu_links = apply_filters( 'modula_admin_page_link', $links );

		// Sort tabs based on priority.
		uasort( $this->tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		// Sort menu items based on priority
		uasort( $this->menu_links, array( 'Modula_Helper', 'sort_data_by_priority' ) );


		if(!empty($this->menu_links)){
			foreach($this->menu_links as $link){
				add_submenu_page( 'edit.php?post_type=modula-gallery',$link['page_title'],$link['menu_title'],$link['capability'],$link['menu_slug'],$link['function'],$link['priority']);
			}
		}

	}

	public function show_submenu() {

		// Get current tab
		if ( isset( $_GET['modula-tab'] ) && isset( $this->tabs[ $_GET['modula-tab'] ] ) ) {
			$this->current_tab = $_GET['modula-tab'];
		}else{

			$tabs = array_keys( $this->tabs );
			$this->current_tab = $tabs[0];

		}

		include 'tabs/modula.php';
	}

	public function show_addons() {
		require_once MODULA_PATH . 'includes/admin/class-modula-addons.php';

		$tabs = array(
			'extensions' => array(
				'name' => esc_html__( 'Extensions', 'modula-best-grid-gallery' ),
				'url'  => admin_url( 'edit.php?post_type=modula-gallery&page=modula-addons' ),
			),
		);
		$tabs       = apply_filters( 'modula_exntesions_tabs', $tabs );
		$active_tab = 'extensions';
		if ( isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ) {
			$active_tab = $_GET['tab'];
		}
		?>
		<div class="wrap">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach( $tabs as $tab_id => $tab ) {
				$active = ( $active_tab == $tab_id ? ' nav-tab-active' : '' );
				echo '<a href="' . esc_url( $tab['url'] ) . '" class="nav-tab' . $active . '">';
				echo esc_html( $tab['name'] );
				echo '</a>';
			}
			?>

		</h2>
		<?php

		if ( 'extensions' == $active_tab ) {
			$addons = new Modula_Addons();
			?>
			<h1 style="margin-bottom: 20px; display: inline-block;"><?php esc_html_e( 'Extensions', 'modula-best-grid-gallery' ); ?></h1>
			<a id="modula-reload-extensions" class="button button-primary" style="margin: 10px 0 0 30px;" data-nonce="<?php echo esc_attr( wp_create_nonce( 'modula-reload-extensions' ) ); ?>"><?php esc_html_e( 'Reload Extensions', 'modula-best-grid-gallery' ); ?></a>
			<div class="modula-addons-container">
				<?php $addons->render_addons(); ?>
			</div>
			<?php
		}else{
			do_action( "modula_exntesion_{$active_tab}_tab" );
		}


	}

	private function generate_url( $tab ) {
		return admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=' . $tab );
	}

	public function show_general_tab() {
		include 'tabs/general.php';
	}

	private function sanitize_image( $image ){

		$new_image = array();

		// This list will not contain id because we save our images based on image id.
		$image_attributes = apply_filters( 'modula_gallery_image_attributes', array(
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
		) );

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
					case 'description' :
						$new_image[ $attribute ] = wp_filter_post_kses( $image[ $attribute ] );
						break;
					case 'link' :
						$new_image[ $attribute ] = esc_url_raw( $image[ $attribute ] );
						break;
					case 'target':
						if ( isset( $image[ $attribute ] ) ) {
							$new_image[ $attribute ] = absint( $image[ $attribute ] );
						}else{
							$new_image[ $attribute ] = 0;
						}
						break;
					case 'halign' :
						if ( in_array( $image[ $attribute ], array( 'left', 'right', 'center' ) ) ) {
							$new_image[ $attribute ] = $image[ $attribute ];
						}else{
							$new_image[ $attribute ] = 'center';
						}
						break;
					case 'valign' :
						if ( in_array( $image[ $attribute ], array( 'top', 'bottom', 'middle' ) ) ) {
							$new_image[ $attribute ] = $image[ $attribute ];
						}else{
							$new_image[ $attribute ] = 'middle';
						}
						break;
					default:
						$new_image[ $attribute ] = apply_filters( 'modula_image_field_sanitization', sanitize_text_field( $image[ $attribute ] ), $image[ $attribute ], $attribute );
						break;
				}

			}else{
				$new_image[ $attribute ] = '';
			}
		}

		return $new_image;

	}

	public function save_images(){

		$nonce = $_POST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
		    wp_send_json( array( 'status' => 'failed' ) );
		}

		if ( ! isset( $_POST['gallery'] ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		$gallery_id = absint( $_POST['gallery'] );

		if ( 'modula-gallery' != get_post_type( $gallery_id ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		if ( ! isset( $_POST['images'] ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		$old_images = get_post_meta( $gallery_id, 'modula-images', true );
		$images     = json_decode( stripslashes($_POST['images']), true );
		$new_images = array();

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$new_images[] = $this->sanitize_image( $image );
			}
		}

		update_post_meta( $gallery_id, 'modula-images', $new_images );
		wp_send_json( array( 'status' => 'succes' ) );

	}

	public function save_image(){

		$nonce = $_POST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
		    wp_send_json( array( 'status' => 'failed' ) );
		}

		if ( ! isset( $_POST['gallery'] ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		$gallery_id = absint( $_POST['gallery'] );

		if ( 'modula-gallery' != get_post_type( $gallery_id ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		if ( ! isset( $_POST['image'] ) ) {
			wp_send_json( array( 'status' => 'failed' ) );
		}

		$image      = json_decode( stripslashes($_POST['image']), true );
		$old_images = get_post_meta( $gallery_id, 'modula-images', true );

		foreach ( $old_images as $key => $old_image ) {
			if ( $old_image['id'] == $image['id'] ) {
				$old_images[ $key ] = $this->sanitize_image( $image );
			}
		}

		update_post_meta( $gallery_id, 'modula-images', $old_images );
		wp_send_json( array( 'status' => 'succes' ) );

	}

	public function admin_custom_css(){
		?>
		<style type="text/css">
			a#modula-uninstall-link {color: #FF0000 !important;font-weight:bold;}
			li#menu-posts-modula-gallery .wp-submenu li a[href$="modula-addons"] {color: #52ad3a;}
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
            <h3><?php esc_html_e('Import Galleries','modula-best-grid-gallery'); ?></h3>
            <p><?php esc_html_e('In order to import exported galleries head over to "Tools -> Import" or click','modula-best-grid-gallery'); ?> <a href="<?php echo admin_url('import.php'); ?>"><?php  esc_html_e('here.','modula-best-grid-gallery'); ?></a></p>
            <p><?php echo '<a href="'.esc_url('https://wordpress.org/plugins/wordpress-importer/').'" target="_blank">'.esc_html__('Install Wordpress Importer','modula-best-grid-gallery').'</a>'.esc_html__('( if not installed ). If installed, click on Wordpress "Run importer". After that select the export file you desire and click "Upload file and import".','modula-best-grid-gallery'); ?></p>
        </div>
        <br />
        <h3><?php esc_html_e('Export Galleries','modula-best-grid-gallery'); ?></h3>
        <p><?php esc_html_e('In order to export Modula galleries head over to "Tools -> Export" or click','modula-best-grid-gallery'); ?> <a href="<?php echo admin_url('export.php'); ?>"><?php  esc_html_e('here.','modula-best-grid-gallery'); ?></a></p>
        <p><?php echo esc_html__('Select "Galleries" and click "Download Export File". An export file will be created and downloaded, which will be used to import the galleries somewhere else.','modula-best-grid-gallery'); ?></p>
        </div>
        <?php

    }


	/**
	 * Add notice showing new grid type and FancyBox new default lightbox
	 *
	 * @since 2.3.0
	 */
	public function modula_upgrade_lightbox_notice() {

		$modula_checks  = get_option( 'modula-checks', array() );
		$current_screen = get_current_screen();

		if ( isset( $modula_checks['lbu_notice'] ) ) {
			return;
		}

		?>
		<div id="modula-lightbox-upgrade" class="notice modula-cutsom-notice modula-lightbox-upgrade-notice">
			<svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" classs="modula-logo-background"><path fill="#f0f5fa" d="M9.3 25.3c-2.4-0.7-4.7-1.4-7.1-2.1 2.4-3.5 4.7-7 7-10.5C9.3 12.9 9.3 24.9 9.3 25.3z"/><path fill="#f0f5fa" d="M9.6 20.1c3.7 2 7.4 3.9 11.1 5.9 -0.1 0.1-5 5-5.2 5.2C13.6 27.5 11.6 23.9 9.6 20.1 9.6 20.2 9.6 20.2 9.6 20.1z"/><path fill="#f0f5fa" d="M22.3 11.9c-3.7-2-7.4-4-11-6 0 0 0 0 0 0 0 0 0 0 0 0 1.7-1.7 3.4-3.3 5.1-5 0 0 0 0 0.1-0.1C18.5 4.5 20.4 8.2 22.3 11.9 22.4 11.9 22.3 11.9 22.3 11.9z"/><path fill="#f0f5fa" d="M4.7 15c-0.6-2.4-1.2-4.7-1.8-7 0.2 0 11.9 0.6 12.7 0.6 0 0 0 0 0 0 0 0 0 0 0 0 -3.6 2.1-7.2 4.2-10.7 6.3C4.8 15 4.8 15 4.7 15z"/><path fill="#f0f5fa" d="M22.9 19.6c-0.2-4.2-0.3-8.3-0.5-12.5 2.4 0.6 4.8 1.2 7.1 1.8C27.4 12.4 25.1 16 22.9 19.6 22.9 19.6 22.9 19.6 22.9 19.6z"/><path fill="#f0f5fa" d="M27.7 16.8c0.6 2.4 1.2 4.7 1.9 7.1 -4.2-0.2-8.5-0.4-12.7-0.5 0 0 0 0 0 0C20.5 21.2 24.1 19 27.7 16.8z"/></svg>
			<p class="modula-feedback-title">
				<?php echo esc_html( 'Hi there !', 'modula-best-grid-gallery' ); ?> 👋
			</p>
			<p><?php echo esc_html( 'We want to take a moment to announce a small change in Modula: we made the decision to make FancyBox the official Modula lightbox. We are aware that switching to another lightbox can be problematic for some users. With this in mind, if you want to use the old lightbox library please press the read more button. Thank you for understanding', 'modula-best-grid-gallery' ); ?></p>
			<a class="button button-primary button-hero" target="_blank" href="https://wp-modula.com/introducing-modula-2-3-0/"><?php esc_html_e( 'Read more about this', 'modula-best-grid-gallery' ); ?></a>
			<a href="#" class="notice-dismiss"></a>
		</div>

		<?php
	}


	/**
	 * Update modula-checks option for lightbox upgrade notice 1
	 *
	 * @since 2.3.0
	 */
	public function modula_lbu_notice() {

		$nonce = $_POST['nonce'];

		if ( !wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
			wp_send_json_error();
			die();
		}

		$modula_checks               = get_option( 'modula-checks', array() );
		$modula_checks['lbu_notice'] = '1';

		update_option( 'modula-checks', $modula_checks );
		wp_die();

	}

	/**
	 * Update modula-checks option for lightbox upgrade notice 2
	 *
	 * @since 2.3.0
	 */
	public function modula_lbu_notice_2() {

		$nonce = $_POST['nonce'];

		if ( !wp_verify_nonce( $nonce, 'modula-ajax-save' ) ) {
			wp_send_json_error();
			die();
		}

		$modula_checks                 = get_option( 'modula-checks', array() );
		$modula_checks['lbu_notice_2'] = '1';

		update_option( 'modula-checks', $modula_checks );
		wp_die();

	}

	/**
	 * Announce users about the lightbox change
	 *
	 * @param $tab_content
	 *
	 * @return mixed
	 *
	 * @since 2.3.0
	 */
	public function lightbox_change_announcement($tab_content){
		global $post;

		$gal_settings  = get_post_meta( $post->ID, 'modula-settings', true );
		$modula_checks = get_option( 'modula-checks', array() );
		$current_l     = array( 'fancybox', 'no-link', 'attachment-page', 'direct' );
		$old_galleries = array(
			'lightbox2'    => 'Lightbox',
			'magnific'     => 'Magnific Gallery',
			'swipebox'     => 'SwipeBox',
			'lightgallery' => 'LightGallery',
			'prettyphoto'  => 'PrettyPhoto'
		);

		if( isset( $gal_settings['lightbox'] ) && ! class_exists( 'Modula_Lightboxes' ) ){
			if ( !in_array( $gal_settings['lightbox'], $current_l ) && !isset( $modula_checks['lbu_notice_2'] ) ) {

				$tab_content .= '<div id="lightbox-upgrade-notice" class="lightbox-announcement modula-upsell">';
				$tab_content .= '<p>Hi there! We want to take a moment to announce a small change in Modula: we made the decision to make FancyBox the official Modula lightbox. We are aware you used ' . $old_galleries[$gal_settings['lightbox']] . ' before and switching to another lightbox can be problematic for some users. With this in mind, if you want to use the old lightbox library please follow this <a href="https://wp-modula.com/introducing-modula-2-3-0/" target="_blank">link</a>. Thank you for understanding!</p><a href="#" class="notice-dismiss"></a>';
				$tab_content .= '</div>';
			}
		}

		return $tab_content;
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

		if ( ! wp_verify_nonce( $nonce,'modula-ajax-save' ) ) {
			die();
		}

		$suggestions = array();
		$term = sanitize_text_field( $_GET['term']);

		$loop = new WP_Query( 's=' . $term);
		while( $loop->have_posts() ) {
			$loop->the_post();
			$suggestion['label'] = get_the_title();
			$suggestion['type']  = get_post_type();
			$suggestion['value'] = get_permalink();
			$suggestions[] = $suggestion;
		}

		echo json_encode( $suggestions );
		exit();
	}

}

new Modula_Admin();