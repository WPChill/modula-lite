<?php
/**
 * Challenge main class
 *
 * @since 2.6.8
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Modula_Challenge_Modal{


    public function __construct(){

        if( is_admin() && $this->show_challenge() && 1 == get_option( 'modula-challenge', 1 ) ){
            add_action( 'admin_footer', array( $this, 'challenge_render' ), 99 );
            add_action( 'admin_enqueue_scripts', array( $this, 'challenge_scripts' ) );
            add_action( 'wp_ajax_modula_challenge_hide', array( $this, 'modula_challenge_hide' ) );
        }

    }

    public function challenge_render(){

        $new_gallery_url = add_query_arg(
            array(
                'post_type'        => 'modula-gallery',
            ),
            admin_url( 'post-new.php' )
        );

        ?>
        <div class="modula-challenge-wrap">
            <div class="modula-challenge-header">
                <span id="modula-challenge-close" class="dashicons dashicons-no-alt"></span>
                <p><?php echo wp_kses_post( __( 'Start enjoying <strong>Modula</strong> by creating your first gallery.', 'modula-best-grid-gallery' ) ); ?></p>
            </div>
            <div class="modula-challenge-list">
                <p><span class="modula-challenge-marker"></span> <?php esc_html_e( 'Primul lucru din lista', 'modula-best-grid-gallery' ); ?></p>
                <p><span class="modula-challenge-marker"></span> <?php esc_html_e( 'Al 2-lea lucru din lista', 'modula-best-grid-gallery' ); ?></p>
                <p><span class="modula-challenge-marker"></span> <?php esc_html_e( 'Al 3-lea lucru din lista', 'modula-best-grid-gallery' ); ?></p>
                <p><span class="modula-challenge-marker"></span> <?php esc_html_e( 'Al 4-lea lucru din lista', 'modula-best-grid-gallery' ); ?></p>
                <p><span class="modula-challenge-marker"></span> <?php esc_html_e( 'Al 5-lea lucru din lista', 'modula-best-grid-gallery' ); ?></p>
            </div>
            <div class="modula-challenge-footer">
                <img src="<?php echo esc_url( MODULA_URL . 'assets/images/logo-dark.png' ); ?>" class="modula-challenge-logo"/>
                <div>
                    <h3>Modula Challenge</h3>
                    <p><span class="modula-challenge-time">5:00</span> remaining.</p>
                </div>
            </div>
            <div class="modula-challenge-footer-button">
                <a id="modula-challenge-button" href="<?php echo esc_url( $new_gallery_url ); ?>" class="modula-btn modula-challenge-btn"><?php esc_html_e( 'Create First Gallery', 'modula-best-grid-gallery' ); ?></a>
            </div>

        </div>
        <?php
    }

	public function challenge_scripts( $hook ) {

		wp_enqueue_style( 'modula-challenge-style', MODULA_URL . 'assets/css/admin/challenge.css', array(), true );
        wp_enqueue_script( 'modula-challenge-script', MODULA_URL . 'assets/js/admin/challenge.js', array( 'jquery' ), '1.0.0', true );
        $args = array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'modula-challenge' ),
        );
        wp_localize_script( 'modula-challenge-script', 'modulaChallenge', $args );

	}

    public function show_challenge(){
        $args = array(
            'numberposts' => 1,
            'post_status' => 'any, trash',
            'post_type'   => 'modula-gallery'
          );
           
        if( empty( get_posts( $args ) ) ){
            return true;
        }

        return false;
        
    }
    public function modula_challenge_hide(){

		$nonce = '';
		
		if( isset( $_POST['nonce'] ) ){
            
			$nonce = $_POST['nonce'];
		}

		if ( ! wp_verify_nonce( $nonce, 'modula-challenge' ) ) {
			wp_send_json_error();
			die();
		}

		update_option( 'modula-challenge', 0 );
        wp_send_json_success();
		wp_die();
    }

}
new Modula_Challenge_Modal();
?>

