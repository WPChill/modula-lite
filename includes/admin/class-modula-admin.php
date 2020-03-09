<?php

/**
 *
 */
class Modula_Admin {

	private $tabs;
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
		add_action( 'delete_attachment', array( $this, 'delete_resized_image') ) ;


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

		$this->tabs = apply_filters( 'modula_admin_page_tabs', array() );

		// Sort tabs based on priority.
		uasort( $this->tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		if ( ! empty( $this->tabs ) ) {
			add_submenu_page( 'edit.php?post_type=modula-gallery', esc_html__( 'Settings', 'modula-best-grid-gallery' ), esc_html__( 'Settings', 'modula-best-grid-gallery' ), 'manage_options', 'modula', array( $this, 'show_submenu' ) );
		}

		add_submenu_page( 'edit.php?post_type=modula-gallery', esc_html__( 'Extensions', 'modula-best-grid-gallery' ), esc_html__( 'Extensions', 'modula-best-grid-gallery' ), 'manage_options', 'modula-addons', array( $this, 'show_addons' ) );

		add_submenu_page( 'edit.php?post_type=modula-gallery', esc_html__( 'Import/Export', 'modula-best-grid-gallery' ), esc_html__( 'Import/Export', 'modula-best-grid-gallery' ), 'manage_options', 'modula-import-export', array( $this, 'import_export_doc' ) );

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
            <p><?php esc_html_e('In order to import exported galleries head over to "Tools -> Import" or click','modula-best-grid-gallery'); ?> <a href="<?php echo admin_url('import.php'); ?>"><?php  esc_html_e('here.','mdula-best-grid-gallery'); ?></a></p>
            <p><?php echo '<a href="'.esc_url('https://wordpress.org/plugins/wordpress-importer/').'" target="_blank">'.esc_html__('Install Wordpress Importer','modula-best-grid-gallery').'</a>'.esc_html__('( if not installed ). If installed, click on Wordpress "Run importer". After that select the export file you desire and click "Upload file and import".','modula-best-grid-gallery'); ?></p>
        </div>
        <br />
        <h3><?php esc_html_e('Export Galleries','modula-best-grid-gallery'); ?></h3>
        <p><?php esc_html_e('In order to export Modula galleries head over to "Tools -> Export" or click','modula-best-grid-gallery'); ?> <a href="<?php echo admin_url('export.php'); ?>"><?php  esc_html_e('here.','mdula-best-grid-gallery'); ?></a></p>
        <p><?php echo esc_html__('Select "Galleries" and click "Download Export File". An export file will be created and downloaded, which will be used to import the galleries somewhere else.','modula-best-grid-gallery'); ?></p>
        </div>
        <?php
    }
}

new Modula_Admin();