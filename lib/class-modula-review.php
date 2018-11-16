<?php

class Modula_Review {

	private static $instance;
	private $when = array( 5, 10, 15 );
	private $value;
	private $messages;
	private $link = 'https://wordpress.org/support/plugin/%s/reviews/#new-post';
	private $slug = '';
	private $option_name = '';
	
	function __construct( $args ) {

		if ( isset( $args['slug'] ) ) {
			$this->slug = $args['slug'];
		}

		$this->value = $this->value();

		$this->messages = array(
			'notice'  => __( "Hey, I noticed you have installed our plugin for %s day - that's awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.", 'modula-gallery' ),
			'rate'    => __( 'Ok, you deserve it', 'modula-gallery' ),
			'rated'   => __( 'I already did', 'modula-gallery' ),
			'no_rate' => __( 'No, not good enough', 'modula-gallery' ),
		);

		if ( isset( $args['messages'] ) ) {
			$this->messages = wp_parse_args( $args['messages'], $this->messages );
		}
		
		$this->init();

	}

	public static function get_instance( $args ) {
		if ( NULL === static::$instance ) {
			static::$instance = new static( $args );
		}

		return static::$instance;
	}

	private function init() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'wp_ajax_epsilon_review', array( $this, 'ajax' ) );
		
		if ( $this->check() ) {
			add_action( 'admin_notices', array( $this, 'five_star_wp_rate_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_print_footer_scripts', array( $this, 'ajax_script' ) );
		}

	}

	private function check() {

		$options = get_option( 'modula-checks' );
		$option = isset( $options['givemereview'] ) ? $options['givemereview'] : '';

		if ( 'already-rated' == $option ) {
			return false;
		}

		if ( $this->value == $option ) {
			return false;
		}

		if ( is_array( $this->when ) ) {
			return in_array( $this->value, $this->when );
		}

		return ( $this->when == $this->value );

	}

	private function value() {

		$value = get_transient( 'modula-galleries-review' );

		if ( $value ) {
			return $value;
		}

		global $wpdb;
		$galleries = $wpdb->get_var( 'SELECT count(Id) FROM ' . $wpdb->ModulaGalleries );

		set_transient( 'modula-galleries-review', $galleries, 6 * HOUR_IN_SECONDS );

		return $galleries;

	}

	public function five_star_wp_rate_notice() {

		$url = sprintf( $this->link, $this->slug );

		?>
		<div id="<?php echo $this->slug ?>-epsilon-review-notice" class="notice notice-success is-dismissible">
			<p><?php echo sprintf( wp_kses_post( $this->messages['notice'] ), $this->value ) ; ?></p>
			<p class="actions">
				<a id="epsilon-rate" href="<?php echo esc_url( $url ) ?>" class="button button-primary epsilon-review-button"><?php echo esc_html( $this->messages['rate'] ); ?></a>
				<a id="epsilon-rated" href="#" class="button button-secondary epsilon-review-button"><?php echo esc_html( $this->messages['rated'] ); ?></a>
				<a id="epsilon-no-rate" href="#" class="button button-secondary epsilon-review-button"><?php echo esc_html( $this->messages['no_rate'] ); ?></a>
			</p>
		</div>
		<?php
	}

	public function ajax() {

		check_ajax_referer( 'epsilon-review', 'security' );

		$options = get_option( 'modula-checks', array() );

		if ( isset( $_POST['epsilon-review'] ) ) {
			$options['givemereview'] = 'already-rated';
		}else{
			$options['givemereview'] = $this->value;
		}

		update_option( 'modula-checks', $options );

		wp_die( 'ok' );

	}

	public function enqueue() {
		wp_enqueue_script( 'jquery' );
	}

	public function ajax_script() {

		$ajax_nonce = wp_create_nonce( "epsilon-review" );

		?>

		<script type="text/javascript">
			jQuery( document ).ready( function( $ ){

				$( '.epsilon-review-button' ).click( function( evt ){
					var href = $(this).attr('href'),
						id = $(this).attr('id');

					evt.preventDefault();

					var data = {
						action: 'epsilon_review',
						security: '<?php echo $ajax_nonce; ?>',
					};

					if ( 'epsilon-rated' === id ) {
						data['epsilon-review'] = 1;
					}

					$.post( '<?php echo admin_url( 'admin-ajax.php' ) ?>', data, function( response ) {
						$( '#<?php echo $this->slug ?>-epsilon-review-notice' ).slideUp( 'fast', function() {
							$( this ).remove();
						} );

						if ( 'epsilon-rate' === id ) {
							window.location.href = href;
						}

					});

				} );

			});
		</script>

		<?php
	}
}