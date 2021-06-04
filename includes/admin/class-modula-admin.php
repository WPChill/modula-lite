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

		add_action( 'wp_ajax_modula_save_images', array( $this, 'save_images' ) );
		add_action( 'wp_ajax_modula_save_image', array( $this, 'save_image' ) );
		add_action( 'modula_scripts_before_wp_modula', array( $this, 'add_autosuggest_scripts' ) );
		add_action( 'wp_ajax_modula_autocomplete', array( $this, 'autocomplete_url' ) );
		add_action( 'delete_attachment', array( $this, 'delete_resized_image' ) );

		add_action( 'wp_ajax_modula_lbu_notice', array( $this, 'modula_lbu_notice' ) );
		add_action( 'wp_ajax_modula_modal_upgrade', array( $this, 'modula_get_modal_upgrade') );

		add_action( 'admin_init', array( $this, 'register_affiliate_link' ) );
		add_filter( 'modula_admin_page_tabs', array( $this, 'add_affiliate_tab' ) );
		add_action( 'modula_admin_tab_affiliate', array( $this, 'show_affiliate_tab' ) );

	}

	public function delete_resized_image( $post_id ) {

		$post = get_post( $post_id );

		if ( 'attachment' !== $post->post_type ) {
			return false;
		}

		// Get the metadata
		$metadata = wp_get_attachment_metadata( $post_id );
		if ( ! $metadata ) {
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

		$this->tabs = apply_filters( 'modula_admin_page_tabs', array() );

		$links = array(
			array(
				'page_title' => esc_html__( 'Import/Export', 'modula-best-grid-gallery' ),
				'menu_title' => esc_html__( 'Import/Export', 'modula-best-grid-gallery' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'modula-import-export',
				'function'   => array( $this, 'import_export_doc' ),
				'priority'   => 35,
			),
			'freevspro' => array(
				'page_title' => esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ),
				'menu_title' => esc_html__( 'Free vs Premium', 'modula-best-grid-gallery' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'modula-lite-vs-pro',
				'function'   => array( $this, 'lite_vs_pro' ),
				'priority'   => 100,
			),
		);
		if ( ! class_exists( 'Modula_PRO' ) ) {
			$links[] =
					array(
						'page_title' => esc_html__( 'Albums', 'modula-best-grid-gallery' ),
						'menu_title' => esc_html__( 'Albums', 'modula-best-grid-gallery' ),
						'capability' => 'manage_options',
						'menu_slug'  => '#modula-albums',
						'function'   => array( $this, 'modula_albums' ),
						'priority'   => 25,
					);
		}
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

		// Sort menu items based on priority
		uasort( $this->menu_links, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		if ( ! empty( $this->menu_links ) ) {
			foreach ( $this->menu_links as $link ) {
				if(!empty($link)){
					add_submenu_page( 'edit.php?post_type=modula-gallery', $link['page_title'], $link['menu_title'], $link['capability'], $link['menu_slug'], $link['function'], $link['priority'] );
				}
			}
		}

	}

	public function show_submenu() {

		// Get current tab
		if ( isset( $_GET['modula-tab'] ) && isset( $this->tabs[ $_GET['modula-tab'] ] ) ) {
			$this->current_tab = $_GET['modula-tab'];
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
			$active_tab = $_GET['tab'];
		}
		?>
		<div class="wrap">

		<?php Modula_Admin_Helpers::modula_page_header(); ?>

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
				$offset        = ( 7 * 24 * 60 * 60 );

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

					echo $dt->format( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );

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
			?>
			<div class="modula-addons-container">
				<?php $addons->render_addons(); ?>
			</div>
			<?php
		} else {
			do_action( "modula_exntesion_{$active_tab}_tab" );
		}

	}

	public function show_general_tab() {
		include 'tabs/general.php';
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

	public function save_images() {

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
		$images     = json_decode( stripslashes( $_POST['images'] ), true );
		$new_images = array();

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$new_images[] = $this->sanitize_image( $image );
			}
		}

		update_post_meta( $gallery_id, 'modula-images', $new_images );
		wp_send_json( array( 'status' => 'succes' ) );

	}

	public function save_image() {

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

		$image      = json_decode( stripslashes( $_POST['image'] ), true );
		$old_images = get_post_meta( $gallery_id, 'modula-images', true );

		foreach ( $old_images as $key => $old_image ) {
			if ( $old_image['id'] == $image['id'] ) {
				$old_images[ $key ] = $this->sanitize_image( $image );
			}
		}

		update_post_meta( $gallery_id, 'modula-images', $old_images );
		wp_send_json( array( 'status' => 'succes' ) );

	}

	public function admin_custom_css() {
		?>
		<style type="text/css">
			a#modula-uninstall-link {color: #FF0000 !important;font-weight:bold;}
			li#menu-posts-modula-gallery .wp-submenu li a[href$="modula-addons"] {color: #52ad3a;}
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
			<?php Modula_Admin_Helpers::modula_page_header(); ?>
		<div class="wrap">
			<h3><?php esc_html_e( 'Import Galleries', 'modula-best-grid-gallery' ); ?></h3>
			<p><?php esc_html_e( 'In order to import exported galleries head over to "Tools -> Import" or click', 'modula-best-grid-gallery' ); ?>
				<a href="<?php echo admin_url( 'import.php' ); ?>"><?php esc_html_e( 'here.', 'modula-best-grid-gallery' ); ?></a>
			</p>
			<p><?php echo '<a href="' . esc_url( 'https://wordpress.org/plugins/wordpress-importer/' ) . '" target="_blank">' . esc_html__( 'Install WordPress Importer', 'modula-best-grid-gallery' ) . '</a>' . esc_html__( '( if not installed ). If installed, click on WordPress "Run importer". After that select the export file you desire and click "Upload file and import".', 'modula-best-grid-gallery' ); ?></p>
			<br/>
			<h3><?php esc_html_e( 'Export Galleries', 'modula-best-grid-gallery' ); ?></h3>
			<p><?php esc_html_e( 'In order to export Modula galleries head over to "Tools -> Export" or click', 'modula-best-grid-gallery' ); ?>
				<a href="<?php echo admin_url( 'export.php' ); ?>"><?php esc_html_e( 'here.', 'modula-best-grid-gallery' ); ?></a>
			</p>
			<p><?php echo esc_html__( 'Select "Galleries" and click "Download Export File". An export file will be created and downloaded, which will be used to import the galleries somewhere else.', 'modula-best-grid-gallery' ); ?></p>
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
	 * Show the modal to upgrade
	 *
	 * @since 2.3.0
	 */
	public function modula_get_modal_upgrade() {

		require MODULA_PATH . '/includes/admin/templates/modal/modula-modal-upgrade.php';
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

	public function register_affiliate_link() {

		register_setting( 'modula_affiliate', 'modula_affiliate' );

	}


	public function add_affiliate_tab( $tabs ) {

		$tabs['affiliate'] = array(
			'label'    => esc_html__( 'Earn Money', 'modula-best-grid-gallery' ),
			'priority' => 100,
		);
		return $tabs;
	}

	public function show_affiliate_tab() {
		include MODULA_PATH . 'includes/admin/tabs/affiliate-options.php';
	}

	/**
	 *  Add LITE vs PRO page
	 *
	 * @since 2.5.0
	 */
	public function lite_vs_pro() {

		Modula_Admin_Helpers::modula_page_header();

		$addons = array(
				'modula-whitelabel' => array(
				'title'       => esc_html__( 'White Label', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Want to use Modula but brand it with your own logo, external URLs and remove all mentions that aren\'t related to your brand? This extension helps you achieve this.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-defaults' => array(
				'title'       => esc_html__( 'Defaults', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Speed up your gallery creation process by starting from a pre-saved default. Save any gallery\'s settings as a default and reuse them indefinitely. Got a bunch of galleries you want to apply a default to? That\'s possible too with this extension.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-zoom' => array(
				'title'       => esc_html__( 'Zoom', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Adds zoom functionality to images, when opened in the lightbox, to allow up close viewing.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-download' => array(
				'title'       => esc_html__( 'Download', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Give your users the ability to download your images, galleries or albums with an easy to use shortcode.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-exif' => array(
				'title'       => esc_html__( 'EXIF', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'The EXIF Addon for Modula allows you to edit & display EXIF metadata in your lightboxes.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-watermark' => array(
				'title'       => esc_html__( 'Watermark', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Protect your photos by adding custom watermarks in Modula Gallery.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-deeplink' => array(
				'title'       => esc_html__( 'SEO Deeplink', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Full SEO control over your galleries. Create a unique and indexable URL for each Modula Gallery item.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-roles' => array(
				'title'       => esc_html__( 'Role Management', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Granular control over which user roles can add, edit or update galleries on your website. Add permissions to an existing user role or remove them by simply checking a checkbox.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-pagination' => array(
				'title'       => esc_html__( 'Pagination', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Modula Pagination allows you to display your gallery images in a paginated way.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-albums' => array(
				'title'       => esc_html__( 'Gallery Albums', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Give your galleries a place to call home with the Albums addon. Create albums, add galleries, manage cover photos, show gallery titles and even image counts in this superb add-on!', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-speedup' => array(
				'title'       => esc_html__( 'SpeedUp', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them through ShortPixel and serve them from StackPath\'s content delivery network.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-password-protect' => array(
				'title'       => esc_html__( 'Password Protect Galleries', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Password protect your galleries. This is a perfect solution for exclusive client galleries!', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-protection' => array(
				'title'       => esc_html__( 'Right-click Protection', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'The Modula Protection extension allows you to easily prevent your visitors from downloading your images with right-click protection. Use this extension to retain full ownership of your creative work.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-advanced-shortcodes' => array(
				'title'       => esc_html__( 'Advanced Shortcode', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Allows you to dynamically link to specific galleries without creating pages for them by using URLs with query strings.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-slider' => array(
				'title'       => esc_html__( 'Convert Gallery to Slider', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Create a slider from Modula Images.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-video' => array(
				'title'       => esc_html__( 'Video', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Adding a video gallery with both self-hosted videos and videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
			'modula-slideshow' => array(
				'title'       => esc_html__( 'Lightbox Slideshow', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Convert the gallery\'s lightbox view into a stunning slideshow.', 'modula-best-grid-gallery' ),
				'lite'        => '<span class="dashicons dashicons-no-alt"></span>',
				'pro'         => '<span class="dashicons dashicons-yes"></span></i>',
			),
		);

		$pro_features = array(
			'gallery-filters' => array(
				'title'       => esc_html__( 'Gallery Filters', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Let visitors filter your gallery items with a single click', 'modula-best-grid-gallery' ),
			),
			'gallery-sorting' => array(
				'title'       => esc_html__( 'Gallery Sorting', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Multiple choices for sorting out images from your gallery: manual, date created, date modified, alphabetically, reverse or random', 'modula-best-grid-gallery' ),
			)
		);

		echo '<div class="modula wrap lite-vs-pro-section about-wrap">';

		do_action('modula_lite_vs_premium_page',$addons,$pro_features);

		echo '</div>';

	}

	public function modula_albums() {
		return;
	}

}

new Modula_Admin();
