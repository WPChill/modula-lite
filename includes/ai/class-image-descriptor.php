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

	/**
	 * Registers gallery actions only for galleries with scheduled Action Scheduler actions.
	 */
	private function _register_gallery_actions() {
		$post_ids = $this->_get_galleries_with_scheduled_actions();

		foreach ( $post_ids as $post_id ) {
			Optimizer::get_instance( (string) $post_id );
		}

		add_action( 'action_scheduler_before_execute', array( $this, '_lazy_register_optimizer_hooks' ), 10, 1 );
	}

	/**
	 * Lazy-loads Optimizer hooks when an action is about to execute.
	 *
	 * @param int $action_id The action ID that's about to execute.
	 */
	public function _lazy_register_optimizer_hooks( $action_id ) {
		if ( ! class_exists( 'ActionScheduler' ) || ! \ActionScheduler::is_initialized() ) {
			return;
		}

		try {
			$store  = \ActionScheduler::store();
			$action = $store->fetch_action( $action_id );
			$hook   = $action->get_hook();

			$hook_patterns = array(
				'mai_process_image_batch_',
				'mai_check_image_batch_',
				'mai_check_optimizer_finished_',
			);

			foreach ( $hook_patterns as $pattern ) {
				if ( strpos( $hook, $pattern ) === 0 ) {
					$post_id = str_replace( $pattern, '', $hook );
					if ( is_numeric( $post_id ) && $post_id > 0 ) {
						Optimizer::get_instance( (string) $post_id );
					}
					break;
				}
			}
		} catch ( \Exception $e ) {
			return;
		}
	}

	/**
	 * Gets gallery post IDs that have scheduled Action Scheduler actions.
	 * Queries for all actions (not just pending/running) to catch all possible hooks.
	 *
	 * @return array Array of unique post IDs
	 */
	private function _get_galleries_with_scheduled_actions() {
		if ( ! function_exists( 'as_get_scheduled_actions' ) ) {
			return array();
		}

		$post_ids = array();

		if ( ! class_exists( 'ActionScheduler' ) || ! \ActionScheduler::is_initialized() ) {
			return array();
		}

		$store = \ActionScheduler::store();

		$hook_patterns = array(
			'mai_process_image_batch_',
			'mai_check_image_batch_',
			'mai_check_optimizer_finished_',
		);

		$actions = as_get_scheduled_actions(
			array(
				'status'   => array(
					\ActionScheduler_Store::STATUS_PENDING,
					\ActionScheduler_Store::STATUS_RUNNING,
					\ActionScheduler_Store::STATUS_FAILED,
				),
				'per_page' => 1000,
			),
			'ids'
		);

		if ( empty( $actions ) ) {
			return array();
		}

		foreach ( $actions as $action_id ) {
			try {
				$action = $store->fetch_action( $action_id );
				$hook   = $action->get_hook();

				foreach ( $hook_patterns as $pattern ) {
					if ( strpos( $hook, $pattern ) === 0 ) {
						$post_id = str_replace( $pattern, '', $hook );
						if ( is_numeric( $post_id ) && $post_id > 0 ) {
							$post_ids[] = (int) $post_id;
						}
						break;
					}
				}
			} catch ( \Exception $e ) {
				continue;
			}
		}

		return array_unique( $post_ids );
	}
}
