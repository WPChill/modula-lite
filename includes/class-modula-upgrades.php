<?php

class Modula_Upgrades {

	// Here will be all actions needed after an update.
	private $upgrades = array();
	private $isNotice = false;

	private $upgrades_key = 'modula_completed_upgrades';
	private $completed_upgrades = array();

	function __construct() {
		$upgrades = array(
			'modula_v2' => array(
				'notice'   => esc_html__( 'Modula needs to upgrade the database, click %shere%s to start the upgrade.', 'modula-best-grid-gallery' ),
				'id'       => 'modula-upgrade-v2',
				'version'  => '2.0.0',
				'compare'  => '<',
				'title'    => esc_html__( 'Modula V2 Upgrade', 'modula-best-grid-gallery' ),
				'callback' => 'modula_upgrade_v2',
			),
		);
		$this->upgrades = apply_filters( 'modula_upgrades', $upgrades );
	}

	/**
	 * Grabs the instance of the upgrades class
	 *
	 * @return Modula_Upgrades
	 */
	public static function get_instance() {
		static $inst;
		if ( ! $inst ) {
			$inst = new Modula_Upgrades();
		}
		return $inst;
	}

	public function initialize_admin() {

		add_action( 'admin_notices', array( $this, 'show_upgrade_notices' ) );
		add_action( 'admin_menu', array( $this, 'add_subpages' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'admin_footer', array( $this, 'dismiss_notices_script' ), 99 );

		// Ajax to get all galleries
		add_action( 'wp_ajax_modula-get-old-galleries', array( $this, 'get_old_galleries' ), 20 );
		add_action( 'wp_ajax_modula-upgrade-gallery', array( $this, 'upgrade_gallery' ), 20 );
		add_action( 'wp_ajax_modula-complete-upgrade', array( $this, 'set_upgrade_complete' ), 20 );
		add_action( 'wp_ajax_modula-dismiss-upgrade', array( $this, 'dismiss_notice' ), 20 );

	}

	public function check_on_activate() {
		
		// Check if is a new 2.0.0 install or an old install
        $version       = get_option( 'modula_version', array() );
		$first_install =  empty( $version );
		$upgrade       = false;

		if(!empty($version) && $version['current_version'] !== MODULA_LITE_VERSION ){
		    $upgrade = true;
        }

		if ( empty( $version ) ) {
			if ( ! $this->check_upgrade_complete( 'modula_v2' ) && $this->check_old_db() ) {
				$version['upgraded_from'] = '1.3.1';
				$version['current_version'] = MODULA_LITE_VERSION;
			}else{
				$version['upgraded_from'] = MODULA_LITE_VERSION;
				$version['current_version'] = MODULA_LITE_VERSION;
			}
		}else{
			$version['upgraded_from'] = $version['current_version'];
			$version['current_version'] = MODULA_LITE_VERSION;
		}

		update_option( 'modula_version', $version );

		do_action( 'modula_on_activation_check', $version, $upgrade, $first_install );

	}

	/**
	 * Display Upgrade Notices
	 *
	 * @since 2.0.0
	 * @return void
	*/
	public function show_upgrade_notices() {

		$version = get_option( 'modula_version' );
		foreach ( $this->upgrades as $key => $upgrade ) {

			if ( ! isset( $version['upgraded_from'] ) || ! isset( $upgrade['version'] ) || ! isset( $upgrade['compare'] ) ) {
				return;
			}

			if ( version_compare( $version['upgraded_from'], $upgrade['version'], $upgrade['compare'] ) && ! $this->check_upgrade_complete( $key ) ) {
				$this->isNotice = true;
				printf(
					'<div class="notice modula-upgrade-notice updated" style="position:relative;margin-top:20px;"><p>' . esc_html( $upgrade['notice'] ) . '</p><a href="#" style="text-decoration:none" class="notice-dismiss" data-key="' . esc_attr( $key ) . '"></a></div>',
					'<a href="' . esc_url( admin_url( 'options.php?page=' . $upgrade['id'] ) ) . '">',
					'</a>'
				);
			}

		}

	}

	/**
	 * Create Pages for each upgrades
	 *
	 * @since 2.0.0
	 * @return void
	*/
	public function add_subpages() {
		foreach ( $this->upgrades as $key => $upgrade ) {
			add_submenu_page( null, $upgrade['title'], $upgrade['title'], 'manage_options', $upgrade['id'], array( $this, $upgrade['callback'] ) );
		}
	}



	/* Helper Functions */
	private function check_upgrade_complete( $key ) {
		if ( empty( $this->completed_upgrades ) ) {
			$this->completed_upgrades = get_option( $this->upgrades_key, array() );
		}

		return in_array( $key, $this->completed_upgrades );
	}

	/* Function to check if old db exist */
	private function check_old_db() {

		global $wpdb;
		$table_name = $wpdb->prefix.'modula';
		if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
		    return false;
		} else {
			return true;
		}

	}

	public function admin_scripts( $hook ) {
		if ( 'admin_page_modula-upgrade-v2' == $hook ) {
			wp_enqueue_script( 'modula-upgrade', MODULA_URL . 'assets/js/admin/modula-upgrade.js', array( 'jquery' ), '2.0.0', true );
			$args = array(
				'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
				'get_galleries_nonce'     => wp_create_nonce( 'modula-get-galleries-nonce' ),
				'upgrade_gallery_nonce'   => wp_create_nonce( 'modula-upgrade-gallery-nonce' ),
				'upgrade_complete_nonce'  => wp_create_nonce( 'modula-upgrade-complete-nonce' ),
			);
			wp_localize_script( 'modula-upgrade', 'modulaUpgraderHelper', $args );
		}
	}

	/* Pages functions */
	public function modula_upgrade_v2() {

		global $wpdb;
		$table_name = $wpdb->prefix.'modula';
		$galleries = $wpdb->get_var( "SELECT COUNT(Id) as galleries FROM $table_name" );

		if ( '0' == $galleries ) {

			echo '<div class="wrap" style="text-align:center;margin-top:70px;"><h1>' . esc_html__( 'Hooray you don\'t have any Modula galleries to upgrade.', 'modula-best-grid-gallery' ) . '</h1>';
			echo '<p class="about-text">' . esc_html__( 'It seems like you didn\'t create any galleries with Modula', 'modula-best-grid-gallery' ) . '</p>';
			echo '<a href="' . esc_url( admin_url( 'post-new.php?post_type=modula-gallery' ) ) . '" class="button button-primary button-hero">' . esc_html__( 'Create a gallery now !', 'modula-best-grid-gallery' ) . '</a>';
			echo '</div>';

		}else{

			$tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'import-all';

			echo '<div class="wrap"><h1>' . esc_html__( 'Upgrade to Modula V2', 'modula-best-grid-gallery' ) . '</h1>';
			echo '<p class="about-text">' . esc_html__( 'Since Modula V2.0.0 we changed how we stored data about your galleries so in order to have all the old galleries you need to run this updater.', 'modula-best-grid-gallery' ) . '</p>';
			echo '<p class="about-text"><strong>' . esc_html__( 'Please don\'t close this window.', 'modula-best-grid-gallery' ) . '</strong></p>';

			// Tabs
			echo '<h2 class="nav-tab-wrapper wp-clearfix">';
			echo '<a href="' . esc_url( admin_url( 'options.php?page=modula-upgrade-v2' ) ) . '" class="nav-tab ' . ( 'import-all' == $tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Import All', 'modula-best-grid-gallery' ) . '</a>';
			echo '<a href="' . esc_url( admin_url( 'options.php?page=modula-upgrade-v2&tab=custom-import' ) ) . '" class="nav-tab ' . ( 'custom-import' == $tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Custom Import', 'modula-best-grid-gallery' ) . '</a>';
			echo '</h2>';


			echo '<div class="modula-upgrader-progress-bar-container" style="display:none;width: 90%;border-radius: 50px;height: 40px;border: 1px solid #e5e5e5;box-shadow: 0 1px 1px rgba(0,0,0,.04);background: #fff;position: relative;text-align: center;line-height: 40px;font-size: 20px;"><div class="modula-upgrader-progress-bar" style="width: 0%;height: 100%;background: #008ec2;border-radius: 50px;position: absolute;left: 0;top: 0;"></div><span style="z-index: 9;position: relative;">0%</span></div>';
			echo '<div class="modula-ajax-output"></div>';

			echo '<div id="modula-upgrade-v2">';

			if ( 'import-all' == $tab ) {
				echo '<p>' . esc_html__( 'This will import all your galleries.', 'modula-best-grid-gallery' ) . '</p>';
				echo '<a href="#" id="modula-upgrade-v2" class="button button-primary">' . esc_html__( 'Start upgrade', 'modula-best-grid-gallery' ) . '</a>';
			}elseif ( 'custom-import' == $tab ) {

				global $wpdb;
				$galleries_query = 'SELECT * FROM ' . $wpdb->prefix . 'modula';
				$galleries       = $wpdb->get_results( $galleries_query );

				echo '<h3>' . esc_html__( 'Select wich galleries you want to import.', 'modula-best-grid-gallery' ) . '</h3>';

				foreach ( $galleries as $gallery ) {

					echo '<label style="width:30%;padding-right:3%;"><input type="checkbox" class="modula-gallery-to-upgrade" value="' . absint( $gallery->Id ) . '">';
					$config = json_decode( $gallery->configuration, true );
					echo esc_html( $config['name'] ) . ' (' . absint( $gallery->Id ) . ')';
					echo '</label>';

				}

				echo '<p><a href="#" id="modula-custom-upgrade-v2" class="button button-primary">' . esc_html__( 'Start importing', 'modula-best-grid-gallery' ) . '</a></p>';

			}

			echo '</div>';


			echo '</div>';

		}

	}

	/* Ajax Calls */
	public function get_old_galleries() {
		// Run a security check first.
		check_admin_referer( 'modula-get-galleries-nonce', 'nonce' );
		global $wpdb;

		$galleries_query = 'SELECT * FROM ' . $wpdb->prefix . 'modula';
		$galleries       = $wpdb->get_results( $galleries_query );
		$galleries_ids   = array();

		foreach ( $galleries as $gallery ) {
			$galleries_ids[] = $gallery->Id;
		}

		echo json_encode( array(
			'status'        => 'succes',
			'galleries_ids' => $galleries_ids,
		) );
		die;
	}

	public function upgrade_gallery() {

		// Run a security check first.
		check_admin_referer( 'modula-upgrade-gallery-nonce', 'nonce' );

		$gallery_ID = isset( $_POST['gallery_id'] ) ? absint( $_POST['gallery_id'] ) : 0;

		// Check if we already have imported this gallery
		$post_args = array(
			'post_type' => 'modula-gallery',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key'     => 'modula-id',
					'value'   => $gallery_ID,
				),
			),
		);

		$post_galleries = new WP_Query( $post_args );

		if ( $post_galleries->post_count > 0 ) {
			echo json_encode( array(
				'status'  => 'succes',
				'message' => sprintf( esc_html__( 'The gallery with ID: %s was already imported', 'modula-best-grid-gallery' ), $gallery_ID ),
			) );
			die();
		}

		global $wpdb;
		$galleries_query = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "modula WHERE Id = %d", $gallery_ID );

		$gallery = $wpdb->get_row( $galleries_query );

		if ( $gallery ) {

			$id = $gallery->Id;
			$config = json_decode( $gallery->configuration, true );

			$images_query = "SELECT * FROM {$wpdb->prefix}modula_images WHERE gid={$id} ORDER BY sortOrder";
			$images = $wpdb->get_results( $images_query, ARRAY_A );

			// Insert the gallery post
			$galery_data = array(
				'post_type' => 'modula-gallery',
				'post_status' => 'publish',
			);

			if ( isset( $config['name'] ) ) {
				$galery_data['post_title'] = $config['name'];
			}

			$gallery_id = wp_insert_post( $galery_data );

			/* Parse gallery settings. The toggles have another values now. */
			$modula_settings = $config;
			foreach ( $toggles as $toggle ) {
				$modula_settings[ $toggle ] = ( 'T' == $modula_settings[ $toggle ] ) ? 1 : 0;
			}

			// In modula 2.0 the hoverEffect it's renamed to effect.
			$modula_settings[ 'effect' ] = $modula_settings['hoverEffect'];
			unset( $modula_settings['hoverEffect'] );

			$modula_settings[ 'enableSocial' ] = (isset($modula_settings['disableSocial']) && '1' == $modula_settings['disableSocial']) ? 0 : 1;
			unset( $modula_settings['disableSocial'] );

            $default_gallery_settings = array(
                'type'                      => 'creative-gallery',
                'width'                     => '100%',
                'height'                    => '800',
                'img_size'                  => 300,
                'margin'                    => '10',
                'randomFactor'              => '50',
                'lightbox'                  => 'fancybox',
                'shuffle'                   => 0,
                'captionColor'              => '#ffffff',
                'hide_title'                => 1,
                'hide_description'          => 0,
                'captionFontSize'           => '14',
                'titleFontSize'             => '16',
                'enableFacebook'            => 0,
                'enablePinterest'           => 0,
				'enableTwitter'             => 0,
				'enableWhatsapp'            => 0,
				'enableEmail'               => 0,
                'filterClick'               => 0,
				'socialIconColor'           => '#ffffff',
				'socialIconSize'            => 16,
				'socialIconPadding'         => 20,
                'loadedScale'               => '100',
                'inView'                    => '100',
                'effect'                    => 'pufrobo',
                'borderColor'               => '#ffffff',
                'borderRadius'              => '0',
                'borderSize'                => '0',
                'shadowColor'               => '#ffffff',
                'shadowSize'                => 0,
                'script'                    => '',
                'style'                     => '',
                'columns'                   => 6,
                'gutter'                    => 10,
                'helpergrid'                => 0,
            );

			if ( isset( $modula_settings['filters'] ) ) {
				$modula_settings['filters'] = explode( '|', $modula_settings['filters'] );
			}

			$modula_settings = wp_parse_args( $modula_settings, $default_gallery_settings );

			add_post_meta( $gallery_id, 'modula-settings', $modula_settings, true );

			// Add images to gallery
			$new_images = array();
			require_once MODULA_PATH . 'includes/admin/class-modula-image.php';

			$img_size = absint( $modula_settings['img_size'] );
			$resizer = new Modula_Image();

			foreach ( $images as $image ) {

				$sizes = $resizer->get_image_size( $image['imageId'], $img_size, $modula_settings );
				if ( ! is_wp_error( $sizes ) ) {
					$resizer->resize_image( $sizes['url'], $sizes['width'], $sizes['height'] );
				}

				$new_images[] = array(
					'id'          => absint($image['imageId']),
					'alt'         => '',
					'title'       => sanitize_text_field($image['title']),
					'description' => $image['description'],
					'halign'      => sanitize_text_field($image['halign']),
					'valign'      => sanitize_text_field($image['valign']),
					'link'        => esc_url_raw($image['link']),
					'target'      => '_blank' == $image['target'] ? 1: 0,
					'filters'     => str_replace( '|', ',', $image['filters'] ),
				);

			}

			add_post_meta( $gallery_id, 'modula-images', $new_images, true );
			add_post_meta( $gallery_id, 'modula-id', $id, true );

			echo json_encode( array(
				'status'  => 'succes',
				'message' => sprintf( __( '%s gallery was imported', 'modula-best-grid-gallery' ), $config['name'] ),
			) );
			die;

		}else{

			echo json_encode( array(
				'status'  => 'succes',
				'message' => sprintf( __( 'The gallery with ID: %s failed to import', 'modula-best-grid-gallery' ), $gallery_ID ),
			) );
			die;

		}

	}

	public function set_upgrade_complete() {

		// Run a security check first.
		check_admin_referer( 'modula-upgrade-complete-nonce', 'nonce' );

		$completed = get_option( $this->upgrades_key, array() );
		$completed['modula_v2'] = true;
		update_option( $this->upgrades_key, $completed );

		echo json_encode( array(
			'status'  => 'succes',
			'message' => sprintf( __( 'All Done!', 'modula-best-grid-gallery' ), $gallery_ID ),
		) );
		die;

	}

	public function dismiss_notice(){

		check_admin_referer( 'modula-dismiss-upgrade', 'nonce' );

		if ( ! isset( $_POST['key'] ) ) {
			wp_send_json_error( 'no key' );
			die();
		}

		$upgrades = get_option( $this->upgrades_key, array() );
		$upgrades_key = sanitize_text_field( $_POST['key'] );
		$completed[ $upgrades_key ] = true;
		update_option( $this->upgrades_key, $completed );

		wp_send_json_success();
		die();

	}

	public function dismiss_notices_script(){
		if ( $this->isNotice ) {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('.modula-upgrade-notice .notice-dismiss').click(function( evt ){
						evt.preventDefault();

						var key = $(this).data('key');
						$.ajax({
							url:      "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>",
				            type:     'POST',
				            dataType: 'json',
				            data: {
				                action: 'modula-dismiss-upgrade',
				                key: key,
				                nonce:  '<?php echo wp_create_nonce( 'modula-dismiss-upgrade' ) ?>',
				            },
				            success: function( response ) {
				            	if ( response.success ) {
				            		location.reload();
				            	}
				            }
						});

					});
				});
			</script>
			<?php
		}
	}
}