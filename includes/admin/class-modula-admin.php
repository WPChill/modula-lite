<?php

/**
 * 
 */
class Modula_Admin {

	private $tabs;
	private $version = '2.0.0';
	private $current_tab = 'general';
	
	function __construct() {

		// Register our submenus
		add_action( 'admin_menu', array( $this, 'register_submenus' ) );

		// Show general tab
		add_action( 'modula_admin_tab_general', array( $this, 'show_general_tab' ) );

	}

	public function register_submenus() {

		add_submenu_page( 'edit.php?post_type=modula-gallery', esc_html__( 'Modula', 'modula-best-grid-gallery' ), esc_html__( 'Modula', 'modula-best-grid-gallery' ), 'manage_options', 'modula', array( $this, 'show_submenu' ) );
		add_submenu_page( 'edit.php?post_type=modula-gallery', esc_html__( 'Addons', 'modula-best-grid-gallery' ), esc_html__( 'Addons', 'modula-best-grid-gallery' ), 'manage_options', 'modula-addons', array( $this, 'show_addons' ) );

	}

	public function show_submenu() {
		$this->tabs = apply_filters( 'modula_admin_page_tabs', array(
			'general' => array(
				'label'    => esc_html__( 'General', 'modula-best-grid-gallery' ),
				'priority' => 10
			),
		) );

		// Sort tabs based on priority.
		uasort( $this->tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		// Get current tab
		if ( isset( $_GET['modula-tab'] ) && isset( $this->tabs[ $_GET['modula-tab'] ] ) ) {
			$this->current_tab = $_GET['modula-tab'];
		}

		include 'tabs/modula.php';
	}

	public function show_addons() {
		require_once MODULA_PATH . 'includes/admin/class-modula-addons.php';

		include 'tabs/addons.php';

		$addons = new Modula_Addons();
		echo '<div class="modula-addons-container">';
		$addons->render_addons();
		echo '</div>';
	}

	private function generate_url( $tab ) {
		return admin_url( 'edit.php?post_type=modula-gallery&page=modula&modula-tab=' . $tab );
	}

	public function show_general_tab() {
		include 'tabs/general.php';
	}
}

new Modula_Admin();