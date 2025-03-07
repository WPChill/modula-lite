<?php

class Modula_Review {

	private $value;
	private $messages;
	private $link = 'https://wordpress.org/support/plugin/%s/reviews/#new-post';
	private $slug = 'modula-best-grid-gallery';
	
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! is_admin() ) {
			return;
		}

		$this->messages = array(
			'notice'  => esc_html__( "Hi there! Stoked to see you're using Modula for a few days now - hope you like it! And if you do, please consider rating it. It would mean the world to us.  Keep on rocking!", 'modula-best-grid-gallery' ),
			'rate'    => esc_html__( 'Rate the plugin', 'modula-best-grid-gallery' ),
			'rated'   => esc_html__( 'Remind me later', 'modula-best-grid-gallery' ),
			'no_rate' => esc_html__( 'Don\'t show again', 'modula-best-grid-gallery' ),
		);

		if ( isset( $args['messages'] ) ) {
			$this->messages = wp_parse_args( $args['messages'], $this->messages );
		}

		$this->value = $this->value();

		if ( $this->check() ) {
			add_action( 'admin_notices', array( $this, 'five_star_wp_rate_notice' ) );
			add_action( 'wp_ajax_epsilon_modula_review', array( $this, 'ajax' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_print_footer_scripts', array( $this, 'ajax_script' ) );
		}

	}

	private function check() {

		if ( ! current_user_can('manage_options') ) {
			return false;
		}

		return( time() > $this->value );

	}

	private function value() {

		$value = get_option( 'modula-rate-time', false );

		if ( $value ) {
			return $value;
		}

		$value = time() + DAY_IN_SECONDS;
		update_option( 'modula-rate-time', $value );

		return $value;
	}

	public function five_star_wp_rate_notice() {

		$url            = sprintf( $this->link, $this->slug );
		$url            = apply_filters( 'modula_review_link', $url );
		$this->messages = apply_filters( 'modula_review_messages', $this->messages );

		$notice = array(
			'title'   	  => 'Rate Us',
			'message' 	  => sprintf( esc_html( $this->messages['notice'] ), esc_html( $this->value ) ),
			'status'  	  => 'success',
			'source'  => array(
				'slug' => 'modula',
				'name' => 'Modula',
			),
			'dismissible' => false,
			'timestamp'   => false,
			'actions'     => array(
				array(
					'label'   => esc_html( $this->messages['rated'] ),
					'id'     => 'epsilon-later',
					'class'   => 'epsilon-review-button',
					'dismiss' => true,
					'callback' => 'handleButtonClick',
				),
				array(
					'label'   => esc_html( $this->messages['no_rate'] ),
					'id'     => 'epsilon-no-rate',
					'class'   => 'epsilon-review-button',
					'dismiss' => true,
					'callback' => 'handleButtonClick',
				),
				array(
					'label'   => esc_html( $this->messages['rate'] ),
					'url'     => esc_url( $url ),
					'class'   => 'epsilon-review-button',
					'variant' => 'primary',
					'target'  => '_BLANK',
					'dismiss' => true,
					'callback' => 'handleButtonClick',
				),
			),
		);

		WPChill_Notifications::add_notification( 'five-star-rate', $notice );
	}

	public function enqueue() {
		wp_enqueue_script( 'jquery' );
	}

	public function ajax() {

		check_ajax_referer( 'epsilon-modula-review', 'security' );

		if ( ! isset( $_POST['check'] ) ) {
			wp_die( 'ok' );
		}

		$time = get_option( 'modula-rate-time' );

		if ( 'epsilon-rate' === $_POST['check'] || 'epsilon-no-rate' === $_POST['check'] ) {
			$time = time() + YEAR_IN_SECONDS * 5;
		} else {
			$time = time() + WEEK_IN_SECONDS;
		}

		update_option( 'modula-rate-time', $time );
		wp_die( 'ok' );
	}

	public function ajax_script() {
		$ajax_nonce = wp_create_nonce( "epsilon-modula-review" );
		?>
	
		<script type="text/javascript">

			function handleButtonClick( element ) {
				var data = {
					action: 'epsilon_modula_review',
					security: '<?php echo $ajax_nonce; ?>',
					check: element.url ? 'epsilon-rate' : element.id
				};
	
				jQuery.post('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', data );
			}
		</script>
	
		<?php
	}
}

new Modula_Review();