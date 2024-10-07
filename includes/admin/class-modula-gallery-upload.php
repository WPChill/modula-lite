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
	 * Class constructor.
	 *
	 * @since 2.11.0
	 */
	private function __construct() {
		// Set the default directory for the media browser.
		add_action( 'admin_init', array( $this, 'set_default_browser_dir' ), 15 );
		// Add the Browser button.
		add_action( 'modula_gallery_media_select_option', array( $this, 'add_folder_browser_button' ), 15 );
		// Create the media browser.
		add_action( 'media_upload_modula_file_browser', array( $this, 'media_browser' ) );
		// AJAX list files.
		add_action( 'wp_ajax_modula_list_files', array( $this, 'ajax_list_folders' ) );
		// Add required scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		// AJAX check paths.
		add_action( 'wp_ajax_modula_check_paths', array( $this, 'ajax_check_paths' ) );
		// AJAX check files from paths.
		add_action( 'wp_ajax_modula_check_files', array( $this, 'ajax_check_files' ) );
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
		<?php esc_html_e( 'Upload from folder', 'modula-best-grid-gallery' ); ?>
		</li>
		<?php
	}

	/**
	* Returns a listing of all folders in the specified folder.
	*
	* @access public
	*
	* @param  string  $folder  (default: '')
	*
	* @return array|bool

	* @since 2.11.0
	*/
	public function list_folders( $folder = '' ) {
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
			die();
		}

		if ( ! isset( $_POST['path'] ) ) {
			die();
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
			do_action( 'admin_print_styles' ); // phpcs:ignore
			do_action( 'admin_print_scripts' ); // phpcs:ignore
			do_action( 'admin_head' ); // phpcs:ignore
			// re-add print_emoji_styles.
			add_action( 'admin_print_styles', 'print_emoji_styles' );
			echo '</head><body class="wp-core-ui">';
			echo '<p>' . esc_html__( 'Select a folder to upload images from', 'modula-best-grid-gallery' ) . '</p>';
			echo '<ul class="modula_file_browser">';
			// Cycle through paths and list files.
			// Get folders based on path.
			$files = $this->list_folders( $this->default_dir, 1 );
			if ( ! empty( $files ) ) {
				// Cycle through files.
				foreach ( $files as $found_file ) {
					$file = pathinfo( $found_file['path'] );
					echo '<li><input type="checkbox" value="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '"><a href="#" class="folder" data-path="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '">' . esc_html( $file['basename'] ) . '</a></li>';
				}
			}
			echo '</ul>';
			echo '<a href="#" class="button button-primary" id="modula_create_gallery">' . esc_html__( 'Create gallery from folders', 'modula-best-grid-gallery' ) . '</a>';
			do_action( 'admin_print_footer_styles' ); // phpcs:ignore 
			do_action( 'admin_print_footer_scripts' ); // phpcs:ignore
			do_action( 'admin_footer' ); // phpcs:ignore
			echo '<script>const modulaBrowser = new ModulaBrowseForFile();modulaBrowser.fileBrowser(); </script>';
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
		// Enqueue the gallery upload script
		wp_enqueue_script( 'modula-gallery-upload', MODULA_URL . 'assets/js/admin/modula-gallery-upload.js', array( 'jquery', 'media-upload' ), MODULA_LITE_VERSION, true );
		// Localize the script
		wp_localize_script(
			'modula-gallery-upload',
			'modulaGalleryUpload',
			array(
				'browseFolder' => __( 'Browse for a folder', 'modula-best-grid-gallery' ),
				'noSubfolders' => __( 'No subfolders found', 'modula-best-grid-gallery' ),
				'security'     => wp_create_nonce( 'list-files' ),
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			)
		);
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
		// Enqueue Modula browser styles.
		wp_enqueue_style( 'modula-browser', MODULA_URL . 'assets/css/admin/modula-browser.css', array(), MODULA_LITE_VERSION );
		// Enqueue Dashicons.
		wp_enqueue_style( 'dashicons' );
		// Enqueue buttons styles.
		wp_enqueue_style( 'buttons' );
		// Enqueue the Modula Gallery Upload script.
		wp_enqueue_script( 'modula-gallery-upload', MODULA_URL . 'assets/js/admin/modula-gallery-upload.js', array( 'jquery', 'media-upload' ), MODULA_LITE_VERSION, true );
		// Localize the script
		wp_localize_script(
			'modula-gallery-upload',
			'modulaGalleryUpload',
			array(
				'browseFolder' => __( 'Browse for a folder', 'modula-best-grid-gallery' ),
				'noSubfolders' => __( 'No subfolders found', 'modula-best-grid-gallery' ),
				'security'     => wp_create_nonce( 'list-files' ),
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			)
		);
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

		$paths   = wp_unslash( $_POST['paths'] );
		$folders = array();
		if ( is_array( $paths ) ) {
			$paths = array_map( 'sanitize_text_field', $paths );
			foreach ( $paths as $path ) {
				if ( $this->check_folder( $path ) ) {
					// Add folder path to the array
					$folders[] = $path;
				}
			}
		} else {
			$paths = sanitize_text_field( $paths );
			if ( $this->check_folder( $paths ) ) {
				// Add folder path to the array
				$folders[] = $paths;
			}
		}

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

		$paths = wp_unslash( $_POST['paths'] );
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
}

Modula_Gallery_Upload::get_instance();
