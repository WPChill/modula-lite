<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Modula_Gallery_Upload
 *
 * Handles the fast gallery creation from uploaded .zip file
 * or from a choosen folder with images that reside on the server
 *
 * @since 2.11.0
 */

class Modula_Gallery_Upload {


	/**
	 * Holds the class object.
	 *
	 * @var Modula_Gallery_Upload
	 *
	 * @since 2.11.0
	 */
	public static $instance = null;

	/**
	 * Defines the default directory for the media browser.
	 *
	 * @var string
	 */
	public $default_dir = null;

	/**
	 * Holds the uploaded error files.
	 *
	 * @var array
	 *
	 * @since 2.11.0
	 */
	public $uploaded_error_files = array();

	/**
	 * Holds the uploaded files meta key.
	 *
	 * @var string
	 *
	 * @since 2.11.0
	 */
	public $uploaded_error_files_meta = 'modula_uploaded_error_files';

	/**
	 * Class constructor.
	 *
	 * @since 2.11.0
	 */
	private function __construct() {
		// Set the default directory for the media browser.
		add_action( 'admin_init', array( $this, 'set_default_browser_dir' ), 15 );
		// Add the Browser button.
		add_action( 'modula_gallery_media_select_option', array( $this, 'add_folder_browser_button' ), 20 );
		// Create the media browser.
		add_action( 'media_upload_modula_file_browser', array( $this, 'media_browser' ) );
		// AJAX list files.
		add_action( 'wp_ajax_modula_list_folders', array( $this, 'ajax_list_folders' ) );
		// Add required scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		// AJAX check paths.
		add_action( 'wp_ajax_modula_check_paths', array( $this, 'ajax_check_paths' ) );
		// AJAX check files from paths.
		add_action( 'wp_ajax_modula_check_files', array( $this, 'ajax_check_files' ) );
		// AJAX function to import images from a folder.
		add_action( 'wp_ajax_modula_import_file', array( $this, 'ajax_import_file' ) );
		// AJAX function to update the gallery modula-images post meta.
		add_action( 'wp_ajax_modula_add_images_ids', array( $this, 'ajax_modula_add_images_ids' ) );
		// Add the Upload zip button.
		add_action( 'modula_gallery_media_select_option', array( $this, 'add_upload_zip_button' ), 40 );
		// Change the upload dir for the zip file.
		add_filter( 'upload_dir', array( $this, 'zip_upload_dir' ) );
		// AJAX to unzip the uploaded zip file.
		add_action( 'wp_ajax_modula_unzip_file', array( $this, 'ajax_unzip_file' ) );
	}

	/**
	 * Create an instance of the class
	 *
	 * @return Modula_Gallery_Upload
	 *
	 * @since 2.11.0
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_Gallery_Upload ) ) {
			self::$instance = new Modula_Gallery_Upload();
		}

		return self::$instance;
	}

	/**
	 * Check if the user has the rights to upload files.
	 *
	 * @return bool
	 *
	 * @since 2.11.0
	 */
	public function check_user_upload_rights() {
		// Include the pluggable file if it's not already included. Seems to be a problem
		// when checking the current user capabilities.
		if ( ! function_exists( 'wp_get_current_user' ) ) {
			include_once ABSPATH . 'wp-includes/pluggable.php';
		}
		// Check if the user has the rights to upload files and edit posts.
		if ( ! current_user_can( 'upload_files' ) || ! current_user_can( 'edit_posts' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Set the default directory for the media browser. By default, it's the uploads directory.
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function set_default_browser_dir() {
		$uploads           = wp_upload_dir();
		$this->default_dir = apply_filters( 'modula_gallery_upload_default_dir', $uploads['basedir'] );
	}

	/**
	 * Output the Upload from folder button.
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function add_folder_browser_button() {
		?>
		<li id="modula-uploader-folder-browser">
			<?php esc_html_e( 'From Folder', 'modula-best-grid-gallery' ); ?>
		</li>
		<?php
	}

	/**
	 * Returns a listing of all folders in the specified folder.
	 *
	 * @access public
	 *
	 * @param  string  $folder  (default: '')
	 * @param  boolean $recursive  (default: false)
	 *
	 * @return array|bool

	 * @since 2.11.0
	 */
	public function list_folders( $folder = '', $recursive = false ) {
		// If no folder is specified, return false
		if ( ! $this->check_folder( $folder ) ) {
			return false;
		}

		// A listing of all files and dirs in $folder, excepting . and ..
		// By default, the sorted order is alphabetical in ascending order
		$files = array_diff( scandir( $folder ), array( '..', '.' ) );

		$modula_folders = array();

		foreach ( $files as $file ) {
			if ( ! is_dir( $folder . '/' . $file ) ) {
				continue;
			}
			$modula_folders[] = array(
				'path' => $folder . '/' . $file,
			);
			if ( $recursive ) {
				$subfolders = $this->list_folders( $folder . '/' . $file );
				if ( ! empty( $subfolders ) ) {
					$modula_folders = array_merge( $modula_folders, $subfolders );
				}
			}
		}

		return $modula_folders;
	}

	/**
	 * Multi-byte-safe pathinfo replacement.
	 *
	 * @param $filepath
	 *
	 * @return mixed
	 *
	 * @since 2.11.0
	 */
	public function mb_pathinfo( $filepath ) {
		$ret = array();
		preg_match(
			'%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im',
			$filepath,
			$m
		);
		if ( isset( $m[1] ) ) {
			$ret['dirname'] = $m[1];
		}
		if ( isset( $m[2] ) ) {
			$ret['basename'] = $m[2];
		}
		if ( isset( $m[5] ) ) {
			$ret['extension'] = $m[5];
		}
		if ( isset( $m[3] ) ) {
			$ret['filename'] = $m[3];
		}

		return $ret;
	}

	/**
	 * List browser folders
	 *
	 * @access public
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_list_folders() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights
		if ( ! $this->check_user_upload_rights() ) {
			wp_send_json_error( __( 'You do not have the rights to upload files.', 'modula-best-grid-gallery' ) );
		}

		if ( ! isset( $_POST['path'] ) ) {
			wp_send_json_error( __( 'No path was provided.', 'modula-best-grid-gallery' ) );
		}
		$checked = false;
		if ( ! empty( $_POST['input-checked'] ) && 'true' === $_POST['input-checked'] ) {
			$checked = true;
		}

		$path = sanitize_text_field( wp_unslash( $_POST['path'] ) );
		// List all files
		$files = $this->list_folders( $path );
		foreach ( $files as $found_file ) {
			// Multi-byte-safe pathinfo
			$file = $this->mb_pathinfo( $found_file['path'] );
			echo '<li><input type="checkbox" value="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '" ' . checked( $checked, true, false ) . '><a href="#" class="folder" data-path="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '">' . esc_html( $file['basename'] ) . '</a></li>';
		}

		die();
	}

	/**
	 * Media browser, for the folder upload functionality
	 *
	 * @access public
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function media_browser() {
		// If we have paths, show them in the file browser
		if ( ! empty( $this->default_dir ) ) {
			$this->enqueue_browser_scripts();
			echo '<!DOCTYPE html><html lang="en">';
			echo '<head><title>' . esc_html__( 'Modula folder browser', 'modula-best-grid-gallery' ) . '</title>';
			echo '<meta charset="utf-8" />';
			// print_emoji_styles is deprecated and triggers a PHP warning.
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			do_action('admin_print_styles'); // phpcs:ignore
			do_action('admin_print_scripts'); // phpcs:ignore
			do_action('admin_head'); // phpcs:ignore
			// re-add print_emoji_styles.
			add_action( 'admin_print_styles', 'print_emoji_styles' );
			echo '</head><body class="wp-core-ui" id="modula_browser">';
			echo '<input type="hidden" value="' . absint($_GET['post_id']) . '" name="post_ID" id="post_ID">'; // phpcs:ignore 
			echo '<p>' . esc_html__( 'Select a folder to upload images from', 'modula-best-grid-gallery' ) . '</p>';
			echo '<ul class="modula_file_browser">';
			// Cycle through paths and list files.
			// Get folders based on path.
			$files = $this->list_folders( $this->default_dir );
			if ( ! empty( $files ) ) {
				// Cycle through files.
				foreach ( $files as $found_file ) {
					$file = pathinfo( $found_file['path'] );
					echo '<li><input type="checkbox" value="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '"><a href="#" class="folder" data-path="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '">' . esc_html( $file['basename'] ) . '</a></li>';
				}
			}
			echo '</ul>';
			echo '<div class="modula-browser-footer">';
			echo '<div class="modula-browser-footer__actions">';
			// Add input checkbox to keep or delete the files from the folders.
			echo '<div class="modula-browser-footer__column text-left">';
			echo '<label for="keep_files"><input type="checkbox" id="delete_files" value="true">' . esc_html__( 'Delete files from folder after upload', 'modula-best-grid-gallery' ) . '</label>';
			echo '</div>';
			echo '<div class="modula-browser-footer__column text-right">';
			echo '<a href="#" class="button button-primary disabled" id="modula_create_gallery">' . esc_html__( 'Create gallery from folders', 'modula-best-grid-gallery' ) . '</a>';
			echo '</div>';
			echo '</div>';
			echo '<div class="modula-browser-footer__progress">';
			echo '<div id="modula-progress"><div id="modula-progress-text">' . esc_html__( 'Import files from a folder', 'modula-best-grid-gallery' ) . '</div></div>';
			echo '</div>';
			do_action('admin_print_footer_styles'); // phpcs:ignore 
			do_action('admin_print_footer_scripts'); // phpcs:ignore
			do_action('admin_footer'); // phpcs:ignore
			echo '<script>const modulaBrowser = new ModulaGalleryUpload();modulaBrowser.fileBrowser(); modulaBrowser.progressMode = new ModulaProgress("modula-progress", true); modulaBrowser.progressMode.display();</script>';
			echo '</body></html>';
		}
	}

	/**
	 * Enqueue required admin scripts
	 *
	 * @param string $hook The current admin page
	 * @return void
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}
		$current_screen = get_current_screen();
		if ( 'modula-gallery' !== $current_screen->post_type ) {
			return;
		}
		$this->required_scripts();
		wp_enqueue_style( 'media-upload' );
		wp_enqueue_style( 'thickbox' );
	}

	/**
	 * Enqueue browser scripts
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function enqueue_browser_scripts() {
		wp_enqueue_style( 'common' );
		// Enqueue Dashicons.
		wp_enqueue_style( 'dashicons' );
		// Enqueue buttons styles.
		wp_enqueue_style( 'buttons' );
		// Enqueue the Modula Gallery Upload script.
		$this->required_scripts();
	}

	/**
	 * Paths validation
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_check_paths() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights
		if ( ! $this->check_user_upload_rights() ) {
			wp_send_json_error( __( 'You do not have the rights to upload files.', 'modula-best-grid-gallery' ) );
		}

		if ( ! isset( $_POST['paths'] ) ) {
			wp_send_json_error( __( 'No paths were provided.', 'modula-best-grid-gallery' ) );
		}
		if ( isset( $_POST['post_ID'] ) ) {
			$this->uploaded_error_files = $this->get_uploaded_error_files( absint( $_POST['post_ID'] ) );
		}
		// Sanitize the paths.
		$paths   = json_decode( wp_unslash( $_POST['paths'] ), true );
		$folders = array();
		if ( is_array( $paths ) ) {
			foreach ( $paths as $path ) {
				if ( $this->check_folder( $path ) ) {
					// Add folder path to the array
					$folders[] = $path;
				} else {
					$this->uploaded_error_files['folders'][] = $path;
				}
			}
		} elseif ( $this->check_folder( $paths ) ) {
			// Add folder path to the array
			$folders[] = $paths;
		} else {
			$this->uploaded_error_files['folders'][] = $paths;
		}

		$prev_uploaded_files = $this->get_uploaded_error_files( absint( $_POST['post_ID'] ) );
		$uploaded_files      = array_merge( $prev_uploaded_files, $this->uploaded_error_files );
		$this->update_uploaded_error_files( absint( $_POST['post_ID'] ), $uploaded_files );
		// If no valid paths were provided, return an error
		if ( empty( $folders ) ) {
			wp_send_json_error( __( 'No valid paths were provided.', 'modula-best-grid-gallery' ) );
		}
		// Return the files
		wp_send_json_success( $folders );
	}

	/**
	 * Check for empty or non folders
	 *
	 * @param string $folder
	 * @return void
	 */
	public function check_folder( $folder ) {
		// If no folder is specified, return false
		if ( empty( $folder ) ) {
			return false;
		}
		// If not dir, return false
		if ( ! is_dir( $folder ) ) {
			return false;
		}
		// If the folder does not exist, return false
		$files_folders = scandir( $folder );
		if ( ! $files_folders ) {
			return false;
		}
		return true;
	}

	/**
	 * Returns a listing of all files in the specified folder.
	 *
	 * @param string $folder
	 * @return array|bool
	 *
	 * @since 2.11.0
	 */
	public function get_files( $folder ) {

		// A listing of all files and dirs in $folder, excepting . and ..
		// By default, the sorted order is alphabetical in ascending order
		$files = array_diff( scandir( $folder ), array( '..', '.' ) );

		$modula_files = array();
		foreach ( $files as $file ) {
			if ( is_dir( $folder . '/' . $file ) ) {
				continue;
			}
			$file_path = $folder . '/' . $file;
			if ( ! $this->check_file( $file_path ) ) {
				continue;
			}
			$modula_files[] = $file_path;
		}

		return $modula_files;
	}

	/**
	 * Define allowed mime types for the gallery upload
	 *
	 * @return array
	 *
	 * @since 2.11.0
	 */
	public function define_allowed_mime_types() {
		// Define the allowed mime types.
		$allowed_mime_types = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'png'          => 'image/png',
			'gif'          => 'image/gif',
			'bmp'          => 'image/bmp',
			'tiff'         => 'image/tiff',
			'tif'          => 'image/tiff',
			'webp'         => 'image/webp',
		);

		// Get WP's default allowed mime types.
		$wp_allowed_mime_types = get_allowed_mime_types();
		// Get mime types that are present in the default allowed mime types and the ones we defined.
		$allowed_mime_types = array_intersect_key( $allowed_mime_types, $wp_allowed_mime_types );

		return apply_filters( 'modula_gallery_upload_allowed_mime_types', $allowed_mime_types );
	}

	/**
	 * File validation
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_check_files() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights
		if ( ! $this->check_user_upload_rights() ) {
			wp_send_json_error( __( 'You do not have the rights to upload files.', 'modula-best-grid-gallery' ) );
		}

		if ( ! isset( $_POST['paths'] ) || empty( $_POST['paths'] ) ) {
			wp_send_json_error( __( 'No paths were provided.', 'modula-best-grid-gallery' ) );
		}

		$paths = json_decode( wp_unslash( $_POST['paths'] ) );
		$files = array();
		if ( is_array( $paths ) ) {
			$paths = array_map( 'sanitize_text_field', $paths );
			// Cycle through paths and get files.
			foreach ( $paths as $path ) {
				$files = array_merge( $files, $this->get_files( $path ) );
			}
		} else {
			$paths = sanitize_text_field( $paths );
			$files = $this->get_files( $paths );
		}

		// If no valid paths were provided, return an error
		if ( empty( $files ) ) {
			wp_send_json_error( __( 'No valid files were provided.', 'modula-best-grid-gallery' ) );
		}
		// Return the files
		wp_send_json_success( $files );
	}

	/**
	 * File validation
	 *
	 * @param string $file
	 * @return bool
	 *
	 * @since 2.11.0
	 */
	public function check_file( $file ) {
		// Check if the file exists
		if ( ! file_exists( $file ) ) {
			return false;
		}
		// Check file mime type
		$allowed_mime_types = $this->define_allowed_mime_types();
		$file_info          = wp_check_filetype( $file, $allowed_mime_types );
		if ( ! $file_info || ! $file_info['ext'] || ! $file_info['type'] ) {
			return false;
		}
		return true;
	}

	/**
	 * Import file from a folder to the media library
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_import_file() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights
		if ( ! $this->check_user_upload_rights() ) {
			wp_send_json_error( __( 'You do not have the rights to upload files.', 'modula-best-grid-gallery' ) );
		}

		if ( ! isset( $_POST['file'] ) || empty( $_POST['file'] ) ) {
			wp_send_json_error( __( 'No files were provided.', 'modula-best-grid-gallery' ) );
		}

		$file        = wp_unslash( $_POST['file'] );
		$delete_file = 'false' === sanitize_text_field( wp_unslash( $_POST['delete_files'] ) ) ? false : true;

		$attachment_id = $this->upload_image( $file, $delete_file );
		if ( ! $attachment_id ) {
			$prev_uploaded_files       = $this->get_uploaded_error_files( absint( $_POST['post_ID'] ) );
			$uploaded_files['files'][] = $_POST['file'];
			$this->update_uploaded_error_files( absint( $_POST['post_ID'] ), array_merge( $prev_uploaded_files, $uploaded_files ) );
			wp_send_json_error( __( 'The file could not be uploaded.', 'modula-best-grid-gallery' ) );
		}
		// Return the image ID
		wp_send_json_success( $attachment_id );
	}

	/**
	 * Upload image to the media library
	 *
	 * @param string $file_path The path to the file
	 * @return int The attachment ID
	 *
	 * @since 2.11.0
	 */
	public function upload_image( $file_path, $delete_file ) {
		// Include the media functions file.
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		$attachment_id = false;
		if ( $delete_file ) {
			// Add the file to the media library.
			$attachment_id = media_handle_sideload(
				array(
					'name'     => basename( $file_path ),
					'tmp_name' => $file_path,
				),
				0
			);
			// If the file was added successfully, return the attachment ID.
			if ( is_wp_error( $attachment_id ) ) {
				$this->uploaded_error_files['files'][] = $file_path;
				return false;
			}
		} else {
			$attachment_id = $this->handle_sideload_without_deleting(
				array(
					'name'     => basename( $file_path ),
					'tmp_name' => $file_path,
				)
			);
			if ( is_wp_error( $attachment_id ) ) {
				$this->uploaded_error_files['files'][] = $file_path;
				return false;
			}
		}
		// Return the attachment ID.
		return $attachment_id;
	}

	/**
	 * Update the gallery modula-images post meta
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_modula_add_images_ids() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights
		if ( ! $this->check_user_upload_rights() ) {
			wp_send_json_error( __( 'You do not have the rights to upload files.', 'modula-best-grid-gallery' ) );
		}

		if ( ! isset( $_POST['galleryID'] ) || empty( $_POST['galleryID'] ) ) {
			wp_send_json_error( __( 'No gallery ID was provided.', 'modula-best-grid-gallery' ) );
		}

		if ( ! isset( $_POST['ids'] ) || empty( $_POST['ids'] ) ) {
			wp_send_json_error( __( 'No images were provided.', 'modula-best-grid-gallery' ) );
		}

		$gallery_id    = absint( $_POST['galleryID'] );
		$images        = wp_unslash( $_POST['ids'] );
		$images        = explode( ',', $images );
		$modula_images = array();

		// Cycle through images and sanitize them
		foreach ( $images as $image_id ) {
			$attachment                 = get_post( $image_id );
			$image                      = array(
				'id'          => absint( $image_id ),
				'alt'         => sanitize_text_field( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ),
				'title'       => sanitize_text_field( $attachment->post_title ),
				'description' => wp_filter_post_kses( $attachment->post_content ),
				'halign'      => 'center',
				'valign'      => 'middle',
				'link'        => '',
				'target'      => '',
				'width'       => 2,
				'height'      => 2,
				'filters'     => '',
				'url'         => wp_get_attachment_image_url( $image_id, 'full' ),
			);
			$modula_images[ $image_id ] = $this->sanitize_image( $image );
		}

		$this->notify_upload_errors( $gallery_id );

		$notice = array(
			'title'   => esc_html__( 'Import process completed.', 'modula-best-grid-gallery' ),
			'message' => sprintf( _n( 'Finished importing %d image.', 'Finished importing %d images.', count( $modula_images ), 'modula-best-grid-gallery' ), count( $modula_images ) ),
			'status'  => 'success',
			'source'  => array(
				'slug' => 'modula',
				'name' => 'Modula',
			),
			'timed'   => 5000,
		);

		WPChill_Notifications::add_notification( 'zip-import', $notice );

		// Return the image ID
		wp_send_json_success( $modula_images );
	}

	/**
	 * Image sanitization function
	 *
	 * @param array $image
	 * @return array
	 *
	 * @since 2.11.0
	 */
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
				'hide_title',
				'url',
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
					case 'hide_title':
						if ( isset( $image[ $attribute ] ) ) {
							$new_image[ $attribute ] = absint( $image[ $attribute ] );
						} else {
							$new_image[ $attribute ] = 0;
						}
						break;
					case 'halign':
						if ( in_array( $image[ $attribute ], array( 'left', 'right', 'center' ), true ) ) {
							$new_image[ $attribute ] = $image[ $attribute ];
						} else {
							$new_image[ $attribute ] = 'center';
						}
						break;
					case 'valign':
						if ( in_array( $image[ $attribute ], array( 'top', 'bottom', 'middle' ), true ) ) {
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

	/**
	 * Enqueue modula browser specific required scripts
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function required_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		// Enqueue Modula browser styles.
		wp_enqueue_style( 'modula-browser', MODULA_URL . 'assets/css/admin/modula-browser.css', array(), MODULA_LITE_VERSION );
		// Load the wp.i18n script.
		wp_enqueue_script( 'wp-i18n' );
		// Enqueue the progress class script.
		wp_enqueue_script( 'modula-progress', MODULA_URL . 'assets/js/admin/modula-progress' . $suffix . '.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		// Enqueue the gallery upload script
		wp_enqueue_script( 'modula-gallery-upload', MODULA_URL . 'assets/js/admin/modula-gallery-upload' . $suffix . '.js', array( 'jquery', 'media-upload', 'backbone' ), MODULA_LITE_VERSION, true );
		// Localize the script
		wp_localize_script(
			'modula-gallery-upload',
			'modulaGalleryUpload',
			array(
				'browseFolder'          => __( 'Browse for a folder', 'modula-best-grid-gallery' ),
				'noSubfolders'          => __( 'No subfolders found', 'modula-best-grid-gallery' ),
				'security'              => wp_create_nonce( 'list-files' ),
				'ajaxUrl'               => admin_url( 'admin-ajax.php' ),
				'noFoldersSelected'     => __( 'No folder(s) selected', 'modula-best-grid-gallery' ),
				'updatingGallery'       => __( 'Updating gallery. Please wait...', 'modula-best-grid-gallery' ),
				'galleryUpdated'        => __( 'Gallery updated. Syncronizing gallery view...', 'modula-best-grid-gallery' ),
				'startFolderValidation' => __( 'Validating folder(s). Please wait...', 'modula-best-grid-gallery' ),
			)
		);
	}

	/**
	 * Get the uploaded files for a gallery
	 *
	 * @param int $post_id The gallery ID
	 * @return array
	 *
	 * @since 2.11.0
	 */
	public function get_uploaded_error_files( $post_id ) {
		$fiels = get_post_meta( $post_id, $this->uploaded_error_files_meta, true );
		if ( ! $fiels ) {
			return array(
				'folders' => array(),
				'files'   => array(),
			);
		}
		return get_post_meta( $post_id, $this->uploaded_error_files_meta, true );
	}

	/**
	 * Update the uploaded files for a gallery
	 *
	 * @param int $post_id The gallery ID
	 * @param array $files The uploaded files
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function update_uploaded_error_files( $post_id, $files ) {
		update_post_meta( $post_id, $this->uploaded_error_files_meta, $files );
	}

	/**
	 * Add the required scripts for the media browser
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function upload_error_notice() {
		$screen = get_current_screen();
		if ( 'modula-gallery' !== $screen->post_type ) {
			return;
		}
		$uploaded_files = $this->get_uploaded_error_files( get_the_ID() );
		if ( ! empty( $uploaded_files ) ) {
			?>
			<div class="modula-notice notice notice-error is-dismissible" target-type="post_meta" notice-target="<?php echo esc_attr( $this->uploaded_error_files_meta ); ?>">
				<p><?php esc_html_e( 'Some files could not be uploaded. Please check the following paths:', 'modula-best-grid-gallery' ); ?></p>
				<ul>
					<?php
					if ( ! empty( $uploaded_files['folders'] ) ) {
						foreach ( $uploaded_files['folders'] as $folder ) {
							echo '<li>' . esc_html( $folder ) . '</li>';
						}
					}
					if ( ! empty( $uploaded_files['files'] ) ) {
						foreach ( $uploaded_files['files'] as $file ) {
							echo '<li>' . esc_html( $file ) . '</li>';
						}
					}
					?>
				</ul>
			</div>
			<?php
		}
	}

	/**
	 * Handle sideload without deleting the original file
	 *
	 * @param array $file_array The file array
	 * @return int|WP_Error The attachment ID or a WP_Error object
	 *
	 * @since 2.11.0
	 */
	public function handle_sideload_without_deleting( $file_array ) {
		// Step 1: Copy the original file to a temporary location
		$temp_file = wp_tempnam( $file_array['name'] );
		if ( ! $temp_file ) {
			return new WP_Error( 'temp_file_creation_failed', __( 'Could not create temporary file.', 'modula-best-grid-gallery' ) );
		}

		if ( ! copy( $file_array['tmp_name'], $temp_file ) ) {
			return new WP_Error( 'file_copy_failed', __( 'Could not copy file to temporary location.', 'modula-best-grid-gallery' ) );
		}

		// Step 2: Update the file array to point to the temporary file
		$file_array['tmp_name'] = $temp_file;

		// Step 3: Use media_handle_sideload to handle the copied file
		$attachment_id = media_handle_sideload( $file_array, 0 );

		// Step 4: Ensure the original file remains intact
		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $temp_file ); // Clean up the temporary file if there was an error
		}

		return $attachment_id;
	}

	/**
	 * Output the Upload from folder button.
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function add_upload_zip_button() {
		?>
		<li id="modula-upload-zip-browser">
			<?php esc_html_e( 'From ZIP', 'modula-best-grid-gallery' ); ?>
		</li>
		<?php
	}

	/**
	 * upload_dir function.
	 *
	 * @access public
	 *
	 * @param mixed $pathdata
	 *
	 * @return array
	 */
	public function zip_upload_dir( $pathdata ) {
		// We don't process form we just modify the upload path for our custom post type.
		// phpcs:ignore
		if (! isset($_POST['type']) || ! isset($_POST['action']) || 'modula-gallery' !== $_POST['type'] || 'modula_upload_zip' !== $_POST['action']) {
			return $pathdata;
		}
		// Check if the user has the rights to upload files.
		if ( ! $this->check_user_upload_rights() ) {
			// Send an error response
			echo json_encode(
				array(
					'error'   => true,
					'message' => __( 'You do not have the rights to upload files or edit galleries.', 'modula-best-grid-gallery' ),
				)
			);
			http_response_code( 403 ); // Set HTTP status code to 403 (Forbidden)
			exit;
		}

		// Check if the file was provided.
		if ( empty( $_POST['name'] ) ) {
			// Send an error response
			echo json_encode(
				array(
					'error'   => true,
					'message' => __( 'No file was provided.', 'modula-best-grid-gallery' ),
				)
			);
			http_response_code( 400 ); // Set HTTP status code to 400 (Bad Request)
			exit;
		}
		$file_type = wp_check_filetype( $_POST['name'] );
		// Check if the file is a zip file.
		if ( empty( $file_type['type'] ) || 'application/zip' !== $file_type['type'] ) {
			// Send an error response
			echo json_encode(
				array(
					'error'   => true,
					'message' => __( 'The file is not a zip file.', 'modula-best-grid-gallery' ),
				)
			);
			http_response_code( 400 ); // Set HTTP status code to 400 (Bad Request)
			exit;
		}
		// Now, let's modify the path.
		if ( empty( $pathdata['subdir'] ) ) {
			$pathdata['path']   = $pathdata['path'] . '/modula_zip_upload';
			$pathdata['url']    = $pathdata['url'] . '/modula_zip_upload';
			$pathdata['subdir'] = '/modula_zip_upload';
		} else {
			$new_subdir = '/modula_zip_upload' . $pathdata['subdir'];

			$pathdata['path']   = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['path'] );
			$pathdata['url']    = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['url'] );
			$pathdata['subdir'] = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['subdir'] );
		}

		return $pathdata;
	}

	/**
	 * Handle the file unzip process
	 *
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_unzip_file() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights.
		if ( ! $this->check_user_upload_rights() ) {
			wp_send_json_error( __( 'You do not have the rights to upload files.', 'modula-best-grid-gallery' ) );
		}
		if ( empty( $_POST['fileID'] ) ) {
			wp_send_json_error( __( 'No file was provided.', 'modula-best-grid-gallery' ) );
		}

		// Get the file ID.
		$file_id = absint( $_POST['fileID'] );
		// Get the file path.
		$file = get_attached_file( $file_id );

		// Validate that this is actually a zip file
		if ( ! class_exists( 'ZipArchive' ) ) {
			wp_delete_attachment( $file_id, true );
			wp_send_json_error( __( 'ZIP extension is not installed on the server.', 'modula-best-grid-gallery' ) );
		}

		$zip        = new ZipArchive();
		$zip_opened = $zip->open( $file );
		if ( $zip_opened !== true ) {
			wp_delete_attachment( $file_id, true );
			wp_send_json_error( __( 'Could not open ZIP file.', 'modula-best-grid-gallery' ) );
		}

		// Get allowed mime types
		$allowed_mime_types = $this->define_allowed_mime_types();

		// Check each file in the zip
		$valid_files = true;
		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
			$stat      = $zip->statIndex( $i );
			$file_name = basename( $stat['name'] );

			// Skip directories
			if ( substr( $file_name, -1 ) === '/' ) {
				continue;
			}

			// Check file extension against allowed mime types
			$file_type = wp_check_filetype( $file_name, $allowed_mime_types );
			if ( empty( $file_type['type'] ) ) {
				$valid_files = false;
				break;
			}
		}

		$zip->close();

		if ( ! $valid_files ) {
			wp_delete_attachment( $file_id, true );
			wp_send_json_error( __( 'ZIP file contains invalid or disallowed file types. Only image files are permitted.', 'modula-best-grid-gallery' ) );
		}

		// Get the base path.
		$base       = pathinfo( $file, PATHINFO_DIRNAME );
		$file_name  = pathinfo( $file, PATHINFO_FILENAME );
		$timestamp  = time();
		$unzip_path = $base . '/' . $file_name . $timestamp;

		// Set the WP_Filesystem.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();

		// Unzip the file.
		$response = unzip_file( $file, $unzip_path );
		if ( is_wp_error( $response ) ) {
			wp_delete_attachment( $file_id, true );
			wp_send_json_error( $response->get_error_message() );
		}

		// Delete the original zip file
		wp_delete_attachment( $file_id, true );

		$folders = array( $unzip_path );
		// Check if the folder has subfolders.
		$subfolders = $this->list_folders( $unzip_path, true );
		if ( ! empty( $subfolders ) ) {
			foreach ( $subfolders as $subfolder ) {
				// Add the subfolder path to the folders array.
				$folders[] = $subfolder['path'];
			}
		}

		// Send the unzip path.
		wp_send_json_success( $folders );
	}

	/**
	 * Error notification for upload errors during the upload process
	 *
	 * @param int $gallery_id The ID of the gallery
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function notify_upload_errors( $gallery_id ) {
		if ( ! class_exists( 'Modula_Notifications' ) ) {
			return;
		}
		$uploaded_files = $this->get_uploaded_error_files( $gallery_id );

		// Return if there are no errors
		if ( ! $uploaded_files || ( empty( $uploaded_files['folders'] ) && empty( $uploaded_files['files'] ) ) ) {
			return;
		}
		ob_start();
		?>
		<p><?php echo wp_kses_post( sprintf( __( 'Some files could not be uploaded in <a href="%1$s" target="_blank">gallery ID %2$s</a>. Please check the following paths:', 'modula-best-grid-gallery' ), esc_url( admin_url( 'post.php?post=' . absint( $gallery_id ) . '&action=edit#!modula-general' ) ), $gallery_id ) ); ?></p>
		<ul>
			<?php
			if ( ! empty( $uploaded_files['folders'] ) ) {
				foreach ( $uploaded_files['folders'] as $folder ) {
					echo '<li>' . esc_html( $folder ) . '</li>';
				}
			}
			if ( ! empty( $uploaded_files['files'] ) ) {
				foreach ( $uploaded_files['files'] as $file ) {
					echo '<li>' . esc_html( $file ) . '</li>';
				}
			}
			?>
		</ul>
		<?php
		$message = ob_get_clean();
		$notice  = array(
			'title'   => esc_html__( 'Error importing images', 'modula-best-grid-gallery' ),
			'message' => $message,
			'status'  => 'error',
			'source'  => array(
				'slug' => 'modula',
				'name' => 'Modula',
			),
		);

		WPChill_Notifications::add_notification( 'error-uploading-images-' . get_the_ID(), $notice );
		// Clear the uploaded files, since the notification was added.
		$this->update_uploaded_error_files( $gallery_id, array() );
	}
}

Modula_Gallery_Upload::get_instance();
