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
		add_action( 'wp_ajax_modula_list_files', array( $this, 'ajax_list_files' ) );
		// Add required scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
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
	* Returns a listing of all files in the specified folder and all subdirectories up to 100 levels deep.
	* The depth of the recursiveness can be controlled by the $levels param.
	*
	* @access public
	*
	* @param  string  $folder  (default: '')
	*
	* @return array|bool

	* @since 2.11.0
	*/
	public function list_files( $folder = '' ) {
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

		// A listing of all files and dirs in $folder, excepting . and ..
		// By default, the sorted order is alphabetical in ascending order
		$files = array_diff( scandir( $folder ), array( '..', '.' ) );

		$dlm_files = array();

		foreach ( $files as $file ) {
			if ( ! is_dir( $folder . '/' . $file ) ) {
				continue;
			}
			$dlm_files[] = array(
				'path' => $folder . '/' . $file,
			);
		}

		return $dlm_files;
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
	 * List browser files
	 *
	 * @access public
	 * @return void
	 *
	 * @since 2.11.0
	 */
	public function ajax_list_files() {
		// Check Nonce
		check_ajax_referer( 'list-files', 'security' );

		// Check user rights
		if ( ! $this->check_user_upload_rights() ) {
			die();
		}

		if ( ! isset( $_POST['path'] ) ) {
			die();
		}

		$path = sanitize_text_field( wp_unslash( $_POST['path'] ) );
		// List all files
		$files = $this->list_files( $path );
		foreach ( $files as $found_file ) {
			// Multi-byte-safe pathinfo
			$file = $this->mb_pathinfo( $found_file['path'] );
			echo '<li><a href="#" class="folder" data-path="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '">' . esc_html( $file['basename'] ) . '</a></li>';
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
			echo '<!DOCTYPE html><html lang="en"><head><title>' . esc_html__( 'Modula folder browser', 'modula-best-grid-gallery' ) . '</title>';
			// print_emoji_styles is deprecated and triggers a PHP warning.
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			do_action( 'admin_print_styles' ); // phpcs:ignore
			do_action( 'admin_print_scripts' ); // phpcs:ignore
			do_action( 'admin_head' ); // phpcs:ignore
			// re-add print_emoji_styles.
			add_action( 'admin_print_styles', 'print_emoji_styles' );

			echo '<meta charset="utf-8" /></head><body>';

			echo '<ul class="modula_file_browser">';
			// Cycle through paths and list files.
			// Get files based on path.
			$files = $this->list_files( $this->default_dir, 1 );
			if ( ! empty( $files ) ) {
				// Cycle through files.
				foreach ( $files as $found_file ) {
					$file = pathinfo( $found_file['path'] );
					echo '<li><a href="#" class="folder" data-path="' . esc_attr( trailingslashit( $file['dirname'] ) ) . esc_attr( $file['basename'] ) . '">' . esc_html( $file['basename'] ) . '</a></li>';
				}
			}
			echo '</ul>';
			?>
			<script type="text/javascript">
				jQuery(function () {
					jQuery('.modula_file_browser').on('click', 'a', function () {

						var $link   = jQuery(this);
						var $parent = $link.closest('li');
						if ($link.is('.folder_open')) {
							$parent.find('ul').remove();
							$link.removeClass('folder_open');
						} else {
							$link.after('<ul class="load_tree loading"></ul>');

							var data = {
								action  : 'modula_list_files',
								path    : jQuery(this).attr('data-path'),
								security: '<?php echo esc_js( wp_create_nonce( 'list-files' ) ); ?>'
							};

							jQuery.post('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', data, function (response) {

								$link.addClass('folder_open');

								if (response) {
									$parent.find('.load_tree').html(response);
								} else {
									$parent.find('.load_tree').html('<li class="nofiles"><?php echo esc_html__( 'No files found', 'modula-best-grid-gallery' ); ?></li>');
								}
								$parent.find('.load_tree').removeClass('load_tree loading');

							});
						}
						return false;
					});
				});
			</script>
			<?php
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
			)
		);
		wp_enqueue_style( 'media-upload' );
		wp_enqueue_style( 'thickbox' );
	}
}

Modula_Gallery_Upload::get_instance();
