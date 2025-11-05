<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPChill_Telemetry_Core {

	/**
	 * Option names
	 */
	const INSTALL_UUID_OPTION = 'wpchill_telemetry_install_uuid';
	const CONSENT_OPTION      = 'wpchill_telemetry_consent';
	const LAST_SEND_OPTION    = 'wpchill_telemetry_last_send';
	const QUEUE_OPTION        = 'wpchill_telemetry_queue';
	const CLIENT_VERSION      = '1.0.0';

	/**
	 * Default configuration
	 */
	const DEFAULT_BASE_URL     = 'https://telemetry.wpchill.com';
	const DEFAULT_SECRET       = '3c2206da5da51d31b68fe3ecf9440b996';
	const DEFAULT_TIMEOUT      = 3;
	const DEFAULT_BATCH_WINDOW = 10;
	const MAX_QUEUE_SIZE       = 500;
	const MAX_PAYLOAD_SIZE     = 65536;

	/**
	 * Core instance
	 *
	 * @var WPChill_Telemetry_Core
	 */
	private static $instance = null;

	/**
	 * Configuration
	 *
	 * @var array
	 */
	private $config;

	/**
	 * Queue for failed requests
	 *
	 * @var array
	 */
	private $queue;

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_config();
		$this->init_queue();
		$this->setup_hooks();
	}

	/**
	 * Get singleton instance
	 *
	 * @return WPChill_Telemetry_Core
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize configuration
	 */
	private function init_config() {
		$this->config = array(
			'base_url'         => self::DEFAULT_BASE_URL,
			'timeout'          => self::DEFAULT_TIMEOUT,
			'batch_window'     => self::DEFAULT_BATCH_WINDOW,
			'full_state_daily' => true,
			'enabled'          => true,
			'shared_secret'    => self::DEFAULT_SECRET,
		);

		$this->config = apply_filters( 'wpchill_telemetry_config', $this->config );
	}

	/**
	 * Initialize retry queue
	 */
	private function init_queue() {
		$this->queue = get_option( self::QUEUE_OPTION, array() );
	}

	/**
	 * Setup WordPress hooks
	 */
	private function setup_hooks() {
		if ( ! $this->config['enabled'] ) {
			return;
		}

		add_filter( 'cron_schedules', array( $this, 'add_weekly_cron_schedule' ) );

		add_action( 'wpchill_telemetry_weekly_report', array( $this, 'send_weekly_snapshot' ) );
		if ( ! wp_next_scheduled( 'wpchill_telemetry_weekly_report' ) ) {
			wp_schedule_event(
				time(),
				'weekly',
				'wpchill_telemetry_weekly_report'
			);
		}

		add_action( 'wpchill_telemetry_process_queue', array( $this, 'process_queue' ) );
		if ( ! wp_next_scheduled( 'wpchill_telemetry_process_queue' ) ) {
			wp_schedule_event(
				time(),
				'hourly',
				'wpchill_telemetry_process_queue'
			);
		}

		add_action( 'wpchill_telemetry_send_batch', array( $this, 'send_batched_events' ) );

		add_action( 'wp_ajax_wpchill_telemetry_opt_in', array( $this, 'ajax_opt_in' ) );
		add_action( 'wp_ajax_wpchill_telemetry_opt_out', array( $this, 'ajax_opt_out' ) );

		add_action( 'admin_footer', array( $this, 'add_consent_script' ) );
	}

	/**
	 * Get or generate installation UUID
	 *
	 * @return string
	 */
	public function get_install_uuid() {
		$uuid = get_option( self::INSTALL_UUID_OPTION );

		if ( empty( $uuid ) ) {
			$uuid = $this->generate_uuid();
			update_option( self::INSTALL_UUID_OPTION, $uuid );
		}

		return $uuid;
	}

	/**
	 * Generate UUID
	 *
	 * @return string
	 */
	private function generate_uuid() {
		if ( function_exists( 'wp_generate_uuid4' ) ) {
			return wp_generate_uuid4();
		}

		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0x0fff ) | 0x4000,
			wp_rand( 0, 0x3fff ) | 0x8000,
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff )
		);
	}

	/**
	 * Check if telemetry is enabled
	 *
	 * @return bool
	 */
	public function is_enabled() {
		if ( ! $this->config['enabled'] ) {
			return false;
		}

		$consent = get_option( self::CONSENT_OPTION, null );
		if ( null === $consent ) {
			add_action( 'admin_notices', array( $this, 'show_consent_notice' ) );
			return false;
		}

		return $consent;
	}

	/**
	 * Show consent notice
	 */
	public function show_consent_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'plugins', 'toplevel_page_modula' ), true ) ) {
			return;
		}

		?>
		<div class="notice notice-info wpchill-telemetry-consent">
			<p>
			<strong><?php esc_html_e( 'Help us improve Modula!', 'modula-best-grid-gallery' ); ?></strong>
		<?php esc_html_e( 'We\'d like to collect anonymous usage data to improve our plugins. This helps us understand how you use our products and make them better.', 'modula-best-grid-gallery' ); ?>
		<button type="button" class="button button-primary wpchill-telemetry-opt-in" style="margin-left: 10px;"><?php esc_html_e( 'Enable Telemetry', 'modula-best-grid-gallery' ); ?></button>
		<button type="button" class="button button-secondary wpchill-telemetry-opt-out" style="margin-left: 5px;"><?php esc_html_e( 'Disable Telemetry', 'modula-best-grid-gallery' ); ?></button>
			</p>
		</div>
		<?php
	}

	/**
	 * Opt in to telemetry
	 */
	public function opt_in() {
		update_option( self::CONSENT_OPTION, true );
		$this->send_registration();
	}

	/**
	 * Opt out of telemetry
	 */
	public function opt_out() {
		update_option( self::CONSENT_OPTION, false );
		delete_option( self::QUEUE_OPTION );
		delete_option( self::LAST_SEND_OPTION );
	}

	/**
	 * Send registration
	 *
	 * @param bool $blocking Whether to block on response
	 * @return array|WP_Error
	 */
	public function send_registration( $blocking = false ) {
		if ( ! $this->is_enabled() ) {
			return new WP_Error( 'telemetry_disabled', 'Telemetry is disabled' );
		}

		$payload = array(
			'installUuid' => $this->get_install_uuid(),
			'siteUrl'     => $this->get_site_url(),
			'wpVersion'   => $this->get_wp_version(),
			'phpVersion'  => $this->get_php_version(),
		);

		return $this->post( '/register', $payload, $blocking );
	}

	/**
	 * Send state snapshot
	 *
	 * @param bool $full Whether this is a full state update
	 * @param bool $blocking Whether to block on response
	 * @return array|WP_Error
	 */
	public function send_state( $full = false, $blocking = false ) {
		if ( ! $this->is_enabled() ) {
			return new WP_Error( 'telemetry_disabled', 'Telemetry is disabled' );
		}

		$payload  = $this->build_state_payload( $full );
		$endpoint = $full ? '/state?full=true' : '/state';

		return $this->post( $endpoint, $payload, $blocking );
	}

	/**
	 * Send settings
	 *
	 * @param string $product_slug Product slug
	 * @param array $settings Settings array
	 * @param bool $blocking Whether to block on response
	 * @return array|WP_Error
	 */
	public function send_settings( $product_slug, $settings, $blocking = false ) {
		if ( ! $this->is_enabled() ) {
			return new WP_Error( 'telemetry_disabled', 'Telemetry is disabled' );
		}

		$settings = $this->scrub_settings( $product_slug, $settings );
		$payload  = array(
			'installUuid' => $this->get_install_uuid(),
			'productSlug' => $product_slug,
			'settings'    => $settings,
		);

		return $this->post( '/settings', $payload, $blocking );
	}

	/**
	 * Send event
	 *
	 * @param string $name Event name
	 * @param array $props Event properties
	 * @param bool $blocking Whether to block on response
	 * @return array|WP_Error
	 */
	public function send_event( $name, $props = array(), $blocking = false ) {
		if ( ! $this->is_enabled() ) {
			return new WP_Error( 'telemetry_disabled', 'Telemetry is disabled' );
		}

		$payload = array(
			'installUuid' => $this->get_install_uuid(),
			'name'        => $name,
			'props'       => $props,
		);

		if ( ! $blocking ) {
			$this->queue_event( $payload );
			return array(
				'success' => true,
				'queued'  => true,
			);
		}

		return $this->post( '/events', $payload, true );
	}

	/**
	 * Send batch events
	 *
	 * @param array $events Array of events
	 * @param bool $blocking Whether to block on response
	 * @return array|WP_Error
	 */
	public function send_events_batch( $events, $blocking = false ) {
		if ( ! $this->is_enabled() ) {
			return new WP_Error( 'telemetry_disabled', 'Telemetry is disabled' );
		}

		$payload = array(
			'installUuid' => $this->get_install_uuid(),
			'events'      => $events,
		);

		return $this->post( '/events/batch', $payload, $blocking );
	}

	/**
	 * Build state payload
	 *
	 * @param bool $full Whether this is a full state update
	 * @return array
	 */
	private function build_state_payload() {
		$payload = array(
			'installUuid' => $this->get_install_uuid(),
			'wpVersion'   => $this->get_wp_version(),
			'phpVersion'  => $this->get_php_version(),
		);

		$payload['products']          = apply_filters( 'wpchill_telemetry_products', array() );
		$payload['extensions']        = apply_filters( 'wpchill_telemetry_extensions', array() );
		$payload['themes']            = apply_filters( 'wpchill_telemetry_themes', array() );
		$payload['thirdPartyPlugins'] = apply_filters( 'wpchill_telemetry_third_party', array() );

		return $payload;
	}

	/**
	 * Scrub sensitive settings
	 *
	 * @param string $product_slug Product slug
	 * @param array $settings Settings array
	 * @return array
	 */
	private function scrub_settings( $product_slug, $settings ) {
		$allowlist = apply_filters( 'wpchill_telemetry_settings_allowlist', array(), $product_slug );

		if ( ! empty( $allowlist ) ) {
			$filtered = array();
			foreach ( $allowlist as $key ) {
				if ( isset( $settings[ $key ] ) ) {
					$filtered[ $key ] = $settings[ $key ];
				}
			}
			$settings = $filtered;
		}

		$sensitive_patterns = array( '/(license|key|token|secret|password|email)/i' );
		foreach ( $sensitive_patterns as $pattern ) {
			foreach ( $settings as $key => $value ) {
				if ( preg_match( $pattern, $key ) ) {
					unset( $settings[ $key ] );
				}
			}
		}

		$json_size = strlen( wp_json_encode( $settings ) );
		if ( $json_size > self::MAX_PAYLOAD_SIZE ) {
			$settings = array_slice( $settings, 0, count( $settings ) / 2, true );
		}

		return $settings;
	}

	/**
	 * Queue event for batching
	 *
	 * @param array $event Event payload
	 */
	private function queue_event( $event ) {
		$events   = get_option( 'wpchill_telemetry_event_queue', array() );
		$events[] = array_merge( $event, array( 'timestamp' => time() ) );

		if ( count( $events ) > 100 ) {
			$events = array_slice( $events, -100 );
		}

		update_option( 'wpchill_telemetry_event_queue', $events );

		if ( ! wp_next_scheduled( 'wpchill_telemetry_send_batch' ) ) {
			wp_schedule_single_event( time() + $this->config['batch_window'], 'wpchill_telemetry_send_batch' );
		}
	}

	/**
	 * Send batched events
	 */
	public function send_batched_events() {
		$events = get_option( 'wpchill_telemetry_event_queue', array() );
		if ( empty( $events ) ) {
			return;
		}

		$result = $this->send_events_batch( $events, false );
		if ( ! is_wp_error( $result ) && $result['success'] ) {
			delete_option( 'wpchill_telemetry_event_queue' );
		}
	}

	/**
	 * Make HTTP POST request
	 *
	 * @param string $endpoint API endpoint
	 * @param array $payload Request payload
	 * @param bool $blocking Whether to block on response
	 * @return array|WP_Error
	 */
	private function post( $endpoint, $payload, $blocking = false ) {
		$url       = $this->config['base_url'] . '/v1/telemetry' . $endpoint;
		$json_body = wp_json_encode( $payload );

		if ( false === $json_body ) {
			return new WP_Error( 'json_encode_failed', 'Failed to encode payload as JSON' );
		}

		$headers = array(
			'Content-Type' => 'application/json',
			'X-Signature'  => $this->sign_payload( $payload ),
			'X-Timestamp'  => time(),
			'X-Client'     => 'wpchill-telemetry/' . self::CLIENT_VERSION,
		);

		if ( ! $blocking ) {
			$headers['Idempotency-Key'] = $this->get_install_uuid() . '-' . uniqid();
		}

		$response = wp_remote_post(
			$url,
			array(
				'headers'  => $headers,
				'body'     => $json_body,
				'timeout'  => $this->config['timeout'],
				'blocking' => $blocking,
			)
		);

		if ( is_wp_error( $response ) ) {
			if ( ! $blocking ) {
				$this->enqueue_for_retry( $endpoint, $payload );
			}
			return $response;
		}

		if ( ! $blocking ) {
			return array(
				'success' => true,
				'sent'    => true,
			);
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		$body        = wp_remote_retrieve_body( $response );

		if ( $status_code >= 400 ) {
			$this->enqueue_for_retry( $endpoint, $payload );
			return new WP_Error( 'http_error', 'HTTP ' . $status_code . ': ' . $body );
		}

		$decoded_body = json_decode( $body, true );
		if ( null === $decoded_body ) {
			return new WP_Error( 'json_decode_failed', 'Failed to decode response as JSON' );
		}

		update_option( self::LAST_SEND_OPTION, time() );
		return array(
			'success' => true,
			'data'    => $decoded_body,
		);
	}

	/**
	 * Sign payload with HMAC
	 *
	 * @param array $payload Payload to sign
	 * @return string
	 */
	private function sign_payload( $payload ) {
		$json_body = wp_json_encode( $payload );
		return hash_hmac( 'sha256', $json_body, $this->config['shared_secret'] );
	}

	/**
	 * Enqueue failed request for retry
	 *
	 * @param string $endpoint API endpoint
	 * @param array $payload Request payload
	 */
	private function enqueue_for_retry( $endpoint, $payload ) {
		$item = array(
			'endpoint'     => $endpoint,
			'payload'      => $payload,
			'next_attempt' => time() + 900, // 15 minutes
			'retry_count'  => 0,
			'created'      => time(),
		);

		$this->queue[] = $item;

		if ( count( $this->queue ) > self::MAX_QUEUE_SIZE ) {
			$this->queue = array_slice( $this->queue, -self::MAX_QUEUE_SIZE );
		}

		update_option( self::QUEUE_OPTION, $this->queue );
	}

	/**
	 * Process retry queue
	 */
	public function process_queue() {
		$now       = time();
		$processed = 0;

		foreach ( $this->queue as $key => $item ) {
			if ( $item['next_attempt'] > $now ) {
				continue;
			}

			if ( $item['retry_count'] >= 5 ) {
				unset( $this->queue[ $key ] );
				continue;
			}

			$result = $this->post( $item['endpoint'], $item['payload'], true );
			if ( ! is_wp_error( $result ) ) {
				unset( $this->queue[ $key ] );
			} else {
				$item['retry_count']  = (int) $item['retry_count'] + 1;
				$backoff              = min( (int) pow( 2, $item['retry_count'] ) * 60, DAY_IN_SECONDS );
				$item['next_attempt'] = $now + $backoff + wp_rand( 0, 60 ); // small jitter
				$this->queue[ $key ]  = $item;
			}

			++$processed;
		}

		if ( $processed > 0 ) {
			update_option( self::QUEUE_OPTION, $this->queue );
		}
	}

	/**
	 * Send weekly snapshot (state + settings)
	 */
	public function send_weekly_snapshot() {
		$state_result = $this->send_state( true, false );

		$settings = apply_filters( 'wpchill_telemetry_settings', array() );
		if ( ! empty( $settings ) ) {
			foreach ( $settings as $setting_data ) {
				if ( isset( $setting_data['product_slug'], $setting_data['settings'] ) ) {
					$this->send_settings( $setting_data['product_slug'], $setting_data['settings'], false );
				}
			}
		}

		return $state_result;
	}

	/**
	 * Send opportunistic state (weekly)
	 */
	public function maybe_send_opportunistic_state() {
		$last_send = get_option( self::LAST_SEND_OPTION, 0 );
		// 7 days
		if ( time() - $last_send < 604800 ) {
			return;
		}

		$this->send_state( false, false );
	}

	/**
	 * Schedule state send after plugin changes
	 */
	public function schedule_state_send() {
		if ( ! wp_next_scheduled( 'wpchill_telemetry_state_send' ) ) {
			wp_schedule_single_event( time() + 60, 'wpchill_telemetry_state_send' );
		}
	}

	/**
	 * Utility methods
	 */
	private function get_site_url() {
		return get_site_url();
	}

	/**
	 * Get WordPress version
	 *
	 * @return string
	 */
	private function get_wp_version() {
		global $wp_version;
		return $wp_version;
	}

	/**
	 * Get PHP version
	 *
	 * @return string
	 */
	private function get_php_version() {
		return PHP_VERSION;
	}

	/**
	 * Get queue status
	 *
	 * @return array
	 */
	public function get_queue_status() {
		return array(
			'queue_length' => count( $this->queue ),
			'last_send'    => get_option( self::LAST_SEND_OPTION, 0 ),
			'consent'      => get_option( self::CONSENT_OPTION, null ),
		);
	}

	/**
	 * AJAX handler for opt in
	 */
	public function ajax_opt_in() {
		check_ajax_referer( 'wpchill_telemetry_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized' );
		}

		$this->opt_in();
		wp_send_json_success( 'Telemetry enabled' );
	}

	/**
	 * AJAX handler for opt out
	 */
	public function ajax_opt_out() {
		check_ajax_referer( 'wpchill_telemetry_nonce', 'wpchill_telemetry_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized' );
		}

		$this->opt_out();
		wp_send_json_success( 'Telemetry disabled' );
	}

	/**
	 * Add inline script for consent buttons
	 */
	public function add_consent_script() {
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('.wpchill-telemetry-opt-in').on('click', function() {
				var button = $(this);
				button.prop('disabled', true).text('<?php echo esc_js( __( 'Enabling...', 'modula-best-grid-gallery' ) ); ?>');
				
				$.post(ajaxurl, {
					action: 'wpchill_telemetry_opt_in',
					nonce: '<?php echo wp_create_nonce( 'wpchill_telemetry_nonce' ); ?>'
				}, function(response) {
					if (response.success) {
						location.reload();
					}
				});
			});
			
			$('.wpchill-telemetry-opt-out').on('click', function() {
				var button = $(this);
				button.prop('disabled', true).text('<?php echo esc_js( __( 'Disabling...', 'modula-best-grid-gallery' ) ); ?>');
				
				$.post(ajaxurl, {
					action: 'wpchill_telemetry_opt_out',
					nonce: '<?php echo wp_create_nonce( 'wpchill_telemetry_nonce' ); ?>'
				}, function(response) {
					if (response.success) {
						location.reload();
					}
				});
			});
		});
		</script>
		<?php
	}

	/**
	 * Add weekly cron schedule
	 *
	 * @param array $schedules
	 * @return array
	 */
	public function add_weekly_cron_schedule( $schedules ) {
		if ( ! isset( $schedules['weekly'] ) ) {
			$schedules['weekly'] = array(
				'interval' => 7 * DAY_IN_SECONDS,
				'display'  => 'Once Weekly',
			);
			$schedules['2min']   = array(
				'interval' => 120,
				'display'  => 'Every 2 minutes',
			);
		}
		return $schedules;
	}

	/**
	 * Cleanup on uninstall
	 */
	public static function cleanup() {
		wp_clear_scheduled_hook( 'wpchill_telemetry_daily_report' );
		wp_clear_scheduled_hook( 'wpchill_telemetry_process_queue' );
		wp_clear_scheduled_hook( 'wpchill_telemetry_state_send' );
		wp_clear_scheduled_hook( 'wpchill_telemetry_send_batch' );
		wp_clear_scheduled_hook( 'wpchill_telemetry_weekly_report' );

		delete_option( self::INSTALL_UUID_OPTION );
		delete_option( self::CONSENT_OPTION );
		delete_option( self::LAST_SEND_OPTION );
		delete_option( self::QUEUE_OPTION );
		delete_option( 'wpchill_telemetry_event_queue' );
		delete_option( 'wpchill_telemetry_registration_sent' );
	}
}
