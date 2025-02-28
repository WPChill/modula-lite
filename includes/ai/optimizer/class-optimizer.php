<?php
namespace Modula\Ai\Optimizer;

use Modula\Ai\Ai_Helper;
use Modula\Ai\Gallery_Helper;
use Modula\Ai\Optimizer\Processor;
use Modula\Ai\Optimizer\Checker;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Optimizer {
	/** @var string */
	const REPORT = '_modula_ai_report';

	/** @var Checker */
	protected $checker;
	/** @var Processor */
	protected $processor;
	/** @var int */
	protected $post_id;

	/** @var bool */
	public $debug = true;
	/** @var string */
	public $debug_option;
	/** @var string */
	public $lock_name;
	/** @var string */
	public $data_option;
	/** @var string */
	public $status_option;

	/** @var array */
	protected static $instances = array();
	/** @var Ai_Helper */
	protected $ai_helper;
	/** @var Gallery_Helper */
	protected $gallery_helper;

	/**
	 * Retrieves the singleton instance of the Optimizer class.
	 *
	 * @param int $post_id The ID of the post.
	 * @return Optimizer The singleton instance.
	 */
	public static function get_instance( $post_id ) {
		if ( ! isset( self::$instances[ $post_id ] ) ||
		! ( self::$instances[ $post_id ] instanceof Optimizer ) ) {
			self::$instances[ $post_id ] = new Optimizer( $post_id );
		}

		return self::$instances[ $post_id ];
	}

	/**
	 * Constructs the Optimizer class.
	 *
	 * @param int $post_id The ID of the post.
	 */
	public function __construct( $post_id ) {
		$this->post_id = $post_id;

		$this->checker   = Checker::get_instance( $post_id );
		$this->processor = Processor::get_instance( $post_id );

		$this->debug_option  = 'modula_ai_optimizer_debug_' . $post_id;
		$this->lock_name     = 'modula_ai_optimizer_lock_' . $post_id;
		$this->data_option   = 'modula_ai_optimizer_data_' . $post_id;
		$this->status_option = 'modula_ai_optimizer_status_' . $post_id;

		$this->ai_helper      = Ai_Helper::get_instance();
		$this->gallery_helper = Gallery_Helper::get_instance();

		add_action( 'init', array( $this, 'add_process_hooks' ) );
	}

	/**
	 * Adds the process hooks.
	 */
	public function add_process_hooks() {
		$process_image_batch_hook      = 'mai_process_image_batch_' . $this->post_id;
		$check_image_batch_hook        = 'mai_check_image_batch_' . $this->post_id;
		$check_optimizer_finished_hook = 'mai_check_optimizer_finished_' . $this->post_id;

		if ( ! has_action( $process_image_batch_hook, array( $this->processor, 'process_image_batch' ) ) ) {
			add_action( $process_image_batch_hook, array( $this->processor, 'process_image_batch' ), 10, 2 );
		}

		if ( ! has_action( $check_image_batch_hook, array( $this->checker, 'check_image_batch' ) ) ) {
			add_action( $check_image_batch_hook, array( $this->checker, 'check_image_batch' ), 10, 1 );
		}

		if ( ! has_action( $check_optimizer_finished_hook, array( $this->checker, 'check_optimizer_finished' ) ) ) {
			add_action( $check_optimizer_finished_hook, array( $this->checker, 'check_optimizer_finished' ), 10, 0 );
		}
	}

	/**
	 * Starts the optimizer.
	 *
	 * @param string $action The action to perform.
	 * @return array The status and report.
	 */
	public function start( $action = 'without' ) {
		// Reset debug log
		$this->processor->reset_debug();

		// Unschedule everything that was running
		\as_unschedule_all_actions( 'mai_process_image_batch_' . $this->post_id );
		\as_unschedule_all_actions( 'mai_check_image_batch_' . $this->post_id );
		\as_unschedule_all_actions( 'mai_check_optimizer_finished_' . $this->post_id );

		$data   = $this->processor->create_initial_data( $action );
		$report = $this->processor->create_initial_report( $data );

		if ( empty( $data['ids'] ) ) {
			$notice = array(
				'title'   => __( 'No images to optimize', 'modula-best-grid-gallery' ),
				'message' => __( 'No images to optimize', 'modula-best-grid-gallery' ),
				'status'  => 'warning',
			);

			\Modula_Notifications::add_notification( 'modula-no-images-to-optimize-' . $this->post_id, $notice );
			return array(
				'status' => 'idle',
				'report' => $report,
			);
		}

		$this->processor->write_initial_data( $data, $report );
		$this->processor->schedule_first_batch();

		$notice = array(
			'title'   => __( 'Modula AI optimization started', 'modula-best-grid-gallery' ),
			'message' => __( 'Modula AI optimization started', 'modula-best-grid-gallery' ),
			'status'  => 'info',
		);

		\Modula_Notifications::add_notification( 'modula-optimizer-started-' . $this->post_id, $notice );

		return array(
			'status' => 'running',
			'report' => $report,
		);
	}

	/**
	 * Stops the optimizer.
	 *
	 * @return array The status and report.
	 */
	public function stop() {
		$this->processor->stop_manually();

		$notice = array(
			'title'   => __( 'Modula AI optimization stopped', 'modula-best-grid-gallery' ),
			'message' => __( 'The process was stopped manually', 'modula-best-grid-gallery' ),
			'status'  => 'warning',
		);
		\Modula_Notifications::add_notification( 'modula-optimizer-stopped-' . $this->post_id, $notice );
		return array(
			'status' => 'idle',
			'report' => $this->checker->get_report(),
		);
	}

	/**
	 * Retrieves the debug data.
	 *
	 * @return array The debug data.
	 */
	public function get_debug() {
		return get_option( $this->debug_option, array() );
	}

	/**
	 * Retrieves the status.
	 *
	 * @return array The status.
	 */
	public function status() {
		return array_merge(
			$this->checker->get_status(),
			$this->ai_helper->convert_to_camel_case(
				$this->gallery_helper->get_gallery_report( $this->post_id )
			)
		);
	}

	/**
	 * Optimizes a single image.
	 *
	 * @param int $image_id The ID of the image.
	 * @return array The result.
	 */
	public function optimize_single( $image_id ) {
		return $this->processor->process_image( $image_id );
	}
}
