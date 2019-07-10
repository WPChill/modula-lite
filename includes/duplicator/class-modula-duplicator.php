<?php

class Modula_Duplicator {

	public function __construct() {
		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	private function define_admin_hooks() {
		add_filter( 'post_row_actions', array( $this, 'duplicate_gallery_link' ), 10, 2 );
		add_action( 'admin_action_modula_duplicate_gallery_save_as_new_post', 'modula_duplicate_gallery_save_as_new_post' );
		add_action( 'modula_duplicate_gallery', 'modula_duplicate_gallery_copy_post_meta_info', 10, 2 );
	}

	private function load_dependencies() {
		require_once MODULA_PATH . 'includes/duplicator/modula-duplicator-functions.php';
	}

	/**
	 * Add the link to action list for post_row_actions
	 */
	public function duplicate_gallery_link( $actions, $post ) {

		if ( 'modula-gallery' != get_post_type( $post ) ) {
			return $actions;
		}

		$actions['duplicate_modula'] = '<a href="' . modula_duplicate_gallery_get_clone_post_link( $post->ID, 'display', false ) . '" title="' . esc_attr__( "Duplicate this gallery", 'modula-best-grid-gallery' ) . '">' . esc_html__( 'Duplicate gallery', 'modula-best-grid-gallery' ) . '</a>';

		return $actions;
	}
}

new Modula_Duplicator();