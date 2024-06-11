<?php
class WPChill_Tracking {

	protected $plugin_name;
	protected $tracking_v = '1.0.0';
	protected $optin_option_name;

	const TRACKING_URL = 'https://api.imageseo.com/track';

	public function __construct(
		string $plugin_name,
		string $optin_option_name = 'wpchill_tracking_optin'
	) {
		$this->plugin_name       = $plugin_name;
		$this->optin_option_name = $optin_option_name;

		add_action(
			"wpchill_{$this->plugin_name}_weekly_tracking_event",
			array( $this, 'handle_weekly_event' )
		);

		add_action( 'admin_init', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! is_admin() ) {
			return;
		}

		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		add_filter(
			'modula_troubleshooting_fields',
			array( $this, 'add_tracking_field' ),
			9999999
		);
		add_filter(
			'modula_troubleshooting_defaults',
			array( $this, 'add_tracking_field_default' ),
			9999999
		);
		add_filter(
			'modula_troubleshooting_options_updated',
			array( $this, 'handle_tracking_option_update' )
		);

		$option = get_option( $this->optin_option_name, null );
		$this->add_notice_if_needed( $option );

		if ( $option !== 'true' ) {
			$this->remove_schedules();
			return;
		}

		// Schedule weekly event
		$this->schedule_weekly_event();
	}

	public function add_notice_if_needed( $option ) {
		$user_meta = get_user_meta( get_current_user_id(), 'wpchill_tracking_notice_dismissed', true );

		if ( $user_meta === '1' ) {
			return;
		}

		if ( is_null( $option ) ) {
			// Show admin notice
			add_action( 'admin_notices', array( $this, 'show_notice' ) );
			// Register AJAX actions
			add_action( 'wp_ajax_dismiss_tracking_notice', array( $this, 'dismiss_tracking_notice' ) );
			add_action( 'wp_ajax_optout_tracking_notice', array( $this, 'optout_tracking_notice' ) );
			add_action( 'wp_ajax_agree_tracking_notice', array( $this, 'agree_tracking_notice' ) );
		}
	}

	public function show_notice() {
		?>
		<div class="notice notice-info wpchill-tracking-notice">
			<p><?php _e( "Plugin tracking: clicking on the 'Agree' button below means you'll be allowing Modula to track, anonymously, plugin usage. This includes gallery settings, and general plugin options. NO emails or PERSONAL information is ever sent back to Modula's servers.", 'modula-best-grid-gallery' ); ?></p>
			<p>
				<a href="#" class="button button-primary wpchill-agree-notice" data-action="agree_tracking_notice"><?php _e( 'Agree', 'modula-best-grid-gallery' ); ?></a>
				<a href="#" class="button wpchill-optout-notice" data-action="optout_tracking_notice"><?php _e( 'Disagree', 'modula-best-grid-gallery' ); ?></a>
				<a href="#" class="link wpchill-dismiss-notice" data-action="dismiss_tracking_notice"><?php _e( 'Don\'t show again', 'modula-best-grid-gallery' ); ?></a>
			</p>
		</div>
		<script type="text/javascript">
			document.addEventListener('DOMContentLoaded', function() {
				function wpchillNoticeHandler(e) {
					e.preventDefault();
					fetch(ajaxurl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
						},
						body: new URLSearchParams({
							action: e.target.dataset.action
						})
					}).then(response => response.text()).then(data => {
						document.querySelector('.wpchill-tracking-notice').remove();
					});
				}
				document.querySelector('.wpchill-agree-notice').addEventListener('click', wpchillNoticeHandler);
				document.querySelector('.wpchill-optout-notice').addEventListener('click', wpchillNoticeHandler);
				document.querySelector('.wpchill-dismiss-notice').addEventListener('click', wpchillNoticeHandler);

			});
		</script>
		<?php
	}

	public function dismiss_tracking_notice() {
		update_user_meta( get_current_user_id(), 'wpchill_tracking_notice_dismissed', true );
		wp_die();
	}

	public function agree_tracking_notice() {
		update_option( $this->optin_option_name, 'true' );
		wp_die();
	}

	public function optout_tracking_notice() {
		update_option( $this->optin_option_name, 'optout' );
		wp_die();
	}

	public function remove_schedules() {
		if ( ! wp_next_scheduled( "wpchill_{$this->plugin_name}_weekly_tracking_event" ) ) {
			return;
		}

		wp_clear_scheduled_hook( "wpchill_{$this->plugin_name}_weekly_tracking_event" );
	}

	public function schedule_weekly_event() {
		if ( ! wp_next_scheduled( "wpchill_{$this->plugin_name}_weekly_tracking_event" ) ) {
			wp_schedule_event( time(), 'weekly', "wpchill_{$this->plugin_name}_weekly_tracking_event" );
		}
	}

	public function handle_weekly_event() {
		$identifier = get_option( 'wpchill_tracking_identifier' );

		$trackedData = array(
			'settings' => $this->collect_settings(),
			'misc'     => $this->collect_misc(),
			'plugin'   => $this->plugin_name,
		);

		if ( $identifier ) {
			$trackedData['identifier'] = $identifier;
		}

		$this->send_tracking_request( $trackedData );
	}

	public function send_tracking_request( $trackDto ) {
		$response = wp_remote_post(
			self::TRACKING_URL,
			array(
				'body'    => json_encode( $trackDto ),
				'headers' => array(
					'Content-Type' => 'application/json',
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			// Handle error
			return;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( isset( $data['identifier'] ) ) {
			update_option( 'wpchill_tracking_identifier', $data['identifier'] );
		}
	}

	private function collect_settings() {
		$modula_settings = Modula_CPT_Fields_Helper::get_defaults();
		$galleries       = $this->get_post_type_items( 'modula-gallery' );
		$allSettings     = array();

		foreach ( $galleries as $gallery ) {
			$gallery_settings = get_post_meta( absint( $gallery ), 'modula-settings', true );
			$allSettings[]    = array_merge( $modula_settings, $gallery_settings );
		}

		return $allSettings;
	}

	private function collect_misc() {

		return array(
			'galleries'  => count( $this->get_post_type_items( 'modula-gallery' ) ),
			'extensions' => $this->collect_installed_plugins(),
			'albums'     => count( $this->get_post_type_items( 'modula-album' ) ),
		);
	}
	private function collect_installed_plugins() {
		return array(
			'pro'                 => defined( 'MODULA_PRO_VERSION' ),
			'defaults'            => defined( 'MODULA_DEFAULTS_VERSION' ),
			'video'               => defined( 'MODULA_VIDEO_VERSION' ),
			'image-licensing'     => defined( 'MODULA_IA_VERSION' ),
			'watermark'           => defined( 'MODULA_WATERMARK_VERSION' ),
			'slider'              => defined( 'MODULA_SLIDER_VERSION' ),
			'filters'             => defined( 'MODULA_FILTERS_VERSION' ),
			'albums'              => defined( 'MODULA_ALBUMS_VERSION' ),
			'download'            => defined( 'MODULA_DOWNLOAD_VERSION' ),
			'speedup'             => defined( 'MODULA_SPEEDUP_VERSION' ),
			'password-protect'    => defined( 'MODULA_PASSWORD_PROTECT_VERSION' ),
			'protection'          => defined( 'MODULA_PROTECTION_VERSION' ),
			'zoom'                => defined( 'MODULA_ZOOM_VERSION' ),
			'exif'                => defined( 'MODULA_EXIF_VERSION' ),
			'slideshow'           => defined( 'MODULA_SLIDESHOW_VERSION' ),
			'fullscreen'          => defined( 'MODULA_FULLSCREEN_VERSION' ),
			'pagination'          => defined( 'MODULA_PAGINATION_VERSION' ),
			'whitelabel'          => class_exists( 'Modula_Whitelabel' ),
			'roles'               => defined( 'MODULA_ROLES_VERSION' ),
			'advanced-shortcodes' => defined( 'MODULA_ADVANCED_SHORTCODES_VERSION' ),
			'lightbox-templates'  => defined( 'MODULA_FANCYBOX_TEMPLATES_VERSION' ),
			'upload-positioning'  => defined( 'MODULA_UPLOAD_POSITIONING_VERSION' ),
			'lightboxes'          => defined( 'MODULA_LIGHTBOXES_VERSION' ),
		);
	}

	private function get_post_type_items( $type ) {
		if ( ! $type ) {
			return array();
		}

		$posts = get_posts(
			array(
				'post_type'      => $type,
				'posts_per_page' => -1,
			)
		);
		$arr   = array();
		foreach ( $posts as $post ) {
			$arr[] = $post->ID;
		}
		return $arr;
	}

	public function add_tracking_field( $fields ) {
		return array_merge(
			$fields,
			array(
				'plugin_tracking_heading' => array(
					'label' => esc_html__( 'Plugin analytics.', 'modula-best-grid-gallery' ),
					'type'  => 'heading',
				),
				$this->optin_option_name  => array(
					'label'       => esc_html__( 'Enable plugin usage tracking', 'modula-best-grid-gallery' ),
					'description' => esc_html__( 'By enabling this option, you agree to allow us to collect anonymous usage data to help improve our product. Rest assured that no sensitive information is collected.', 'modula-best-grid-gallery' ),
					'type'        => 'toggle',
				),
			)
		);
	}

	public function add_tracking_field_default( $defaults ) {
		$option = get_option( $this->optin_option_name, null );
		return array_merge(
			$defaults,
			array(
				$this->optin_option_name => $option === 'true' ? 1 : 0,
			)
		);
	}

	public function handle_tracking_option_update( $options ) {
		if ( ! isset( $options[ $this->optin_option_name ] ) ) {
			update_option( $this->optin_option_name, 'optout' );
			return $options;
		}

		$value = $options[ $this->optin_option_name ];
		update_option( $this->optin_option_name, $value === '1' ? 'true' : 'optout' );

		unset( $options[ $this->optin_option_name ] );
		return $options;
	}
}
