<?php
namespace Modula\Ai;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/autoload.php';

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

		$this->include_action_scheduler();
	}

	/**
	 * Include Action Scheduler.
	 *
	 * @return void
	 */
	public function include_action_scheduler() {
		require_once MODULA_PATH . 'includes/libraries/action-scheduler/action-scheduler.php';
	}
}
