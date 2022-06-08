<?php


class Modula_Admin_Helpers {

	/**
	 * Holds the class object.
	 *
	 * @since 2.5.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Modula_Admin_Helpers constructor.
	 *
	 * @since 2.5.0
	 */
	function __construct() {

		$this->load_hooks();

		if ( is_admin() ) {
			$this->load_admin_hooks();
		}
	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Admin_Helpers object.
	 * @since 2.5.0
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !( self::$instance instanceof Modula_Admin_Helpers ) ) {
			self::$instance = new Modula_Admin_Helpers();
		}

		return self::$instance;

	}

	/**
	 * Load our public hooks
	 *
	 * @since 2.5.3
	 */
	public function load_hooks(){

	}

	/**
	 * Load our admin hooks
	 */
	public function load_admin_hooks() {

		add_action( 'in_admin_header', array( $this, 'modula_page_header' ) );

		add_filter( 'modula_page_header', array( $this, 'page_header_locations' ) );
	}

	/**
	 * Display the Modula Admin Page Header
	 *
	 * @param bool $extra_class
	 */
	public static function modula_page_header($extra_class = '') {

		// Only display the header on pages that belong to Modula
		if ( ! apply_filters( 'modula_page_header', false ) ) {
			return;
		}
		?>
		<div class="modula-page-header <?php echo ( $extra_class ) ? esc_attr( $extra_class ) : ''; ?>">
			<div class="modula-header-logo">
				<img src="<?php echo esc_url( MODULA_URL . 'assets/images/logo-dark.webp' ); ?>" class="modula-logo">
			</div>
			<div class="modula-status-bar">
			</div>
			<div class="modula-header-links">
				<a href="<?php echo esc_url( admin_url('edit.php?post_type=modula-gallery&page=modula-about-page') ); ?>"
				   class="button button-secondary"><span
							class="dashicons dashicons-admin-plugins"></span><?php esc_html_e( 'About', 'modula-best-grid-gallery' ); ?>
				</a>
				<a href="https://modula.helpscoutdocs.com/" target="_blank" id="get-help"
				   class="button button-secondary"><span
							class="dashicons dashicons-external"></span><?php esc_html_e( 'Documentation', 'modula-best-grid-gallery' ); ?>
				</a>
				<a class="button button-secondary"
				   href="https://wp-modula.com/contact-us/" target="_blank"><span
							class="dashicons dashicons-email-alt"></span><?php echo esc_html__( 'Contact us for support!', 'modula-best-grid-gallery' ); ?>
				</a>
			</div>
		</div>
		<?php
	}

	/**
	 * Set the Modula header locations
	 *
	 * @param $return
	 *
	 * @return bool|mixed
	 * @since 2.5.3
	 */
	public function page_header_locations( $return ) {

		$current_screen = get_current_screen();

		if ( 'modula-gallery' === $current_screen->post_type ) {
			return true;
		}

		return $return;
	}

	/**
	 * Tab navigation display
	 *
	 * @param $tabs
	 * @param $active_tab
	 */
	public static function modula_tab_navigation( $tabs, $active_tab ) {

		if ( $tabs ) {

			$i = count( $tabs );
			$j = 1;

			foreach ( $tabs as $tab_id => $tab ) {

				$last_tab = ( $i == $j ) ? ' last_tab' : '';
				$active   = ( $active_tab == $tab_id ? ' nav-tab-active' : '' );
				$j++;

				if ( isset( $tab[ 'url' ] ) ) {
					// For Extensions and Gallery list tabs
					$url = $tab[ 'url' ];
				} else {
					// For Settings tabs
					$url = admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=' . $tab_id );
				}

				echo '<a href="' . esc_url( $url ) . '" class="nav-tab' . esc_attr($active) . esc_attr($last_tab) . '" ' . ( isset( $tab[ 'target' ] ) ? 'target="' . esc_attr($tab[ 'target' ]) . '"' : '' ) . '>';

				if ( isset( $tab[ 'icon' ] ) ) {
					echo '<span class="dashicons ' . esc_attr( $tab[ 'icon' ] ) . '"></span>';
				}

				// For Extensions and Gallery list tabs
				if ( isset( $tab[ 'name' ] ) ) {
					echo esc_html( $tab[ 'name' ] );
				}

				// For Settings tabs
				if ( isset( $tab[ 'label' ] ) ) {
					echo esc_html( $tab[ 'label' ] );
				}

				if ( isset( $tab[ 'badge' ] ) ) {
					echo '<span class="modula-badge">' . esc_html($tab[ 'badge' ]) . '</span>';
				}

				echo '</a>';
			}
		}
	}

}

$modula_admin_helpers = Modula_Admin_Helpers::get_instance();