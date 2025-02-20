<?php
namespace Modula\Ai;

use Modula\Ai\Admin_Area\Admin_Area;
use Modula\Ai\Admin_Area\Rest_Api;
use Modula\Ai\Optimizer\Optimizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image_Descriptor {
	/**
	 * Constructor for the Image_Descriptor class.
	 */
	public function __construct() {
		$this->_register_gallery_actions();

		new Rest_Api();
		new Admin_Area();
	}

	private function _register_gallery_actions() {
		$posts = get_posts(
			array(
				'post_type'      => 'modula-gallery',
				'posts_per_page' => -1,
			)
		);

		foreach ( $posts as $post ) {
			Optimizer::get_instance( (string) $post->ID );
		}
	}
}
