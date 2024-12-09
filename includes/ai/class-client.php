<?php
namespace Modula\Ai;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Client {
	/**
	 * Instance of the Image_Descriptor class.
	 *
	 * Handles communication with the AI image description service
	 * to generate alt text and descriptions for gallery images.
	 *
	 * @var Image_Descriptor
	 */
	public $image_descriptor;

	/**
	 * Instance of the Rest_Api class.
	 *
	 * @var Rest_Api
	 */
	public $rest_api;

	/**
	 * Constructor for the Client class.
	 *
	 * Initializes the Image_Descriptor instance.
	 */
	public function __construct() {
		$this->image_descriptor = new Image_Descriptor();
		$this->rest_api         = new Rest_Api();
	}
}
