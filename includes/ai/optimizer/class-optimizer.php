<?php
namespace Modula\Ai\Optimizer;

use Modula\Ai\Ai_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Optimizer {

	protected $checker;
	protected $processor;
	protected $post_id;

	public $debug = true;
	public $debug_option;
	public $lock_name;
	public $data_option;
	public $status_option;

	protected static $instances = array();
	protected $ai_helper;
	protected $gallery_helper;

	public static function get_instance( $post_id ) {
		if ( ! isset( self::$instances[ $post_id ] ) ||
		! ( self::$instances[ $post_id ] instanceof Optimizer ) ) {
			self::$instances[ $post_id ] = new Optimizer( $post_id );
		}

		return self::$instances[ $post_id ];
	}

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

	public function add_process_hooks() {
		$process_image_batch_hook      = 'process_image_batch_' . $this->post_id;
		$check_image_batch_hook        = 'check_image_batch_' . $this->post_id;
		$check_optimizer_finished_hook = 'check_optimizer_finished_' . $this->post_id;

		if ( ! has_action( $process_image_batch_hook, array( $this, 'process_image_batch' ) ) ) {
			add_action( $process_image_batch_hook, array( $this, 'process_image_batch' ), 10, 2 );
		}

		if ( ! has_action( $check_image_batch_hook, array( $this, 'check_image_batch' ) ) ) {
			add_action( $check_image_batch_hook, array( $this, 'check_image_batch' ), 10, 1 );
		}

		if ( ! has_action( $check_optimizer_finished_hook, array( $this, 'check_optimizer_finished' ) ) ) {
			add_action( $check_optimizer_finished_hook, array( $this, 'check_optimizer_finished' ), 10, 0 );
		}
	}

	public function start( $action = 'without' ) {
		// Reset debug log
		$this->processor->reset_debug();
		Imageseo_Helper::reset_notices();

		// Unschedule everything that was running
		\as_unschedule_all_actions( 'process_image_batch_' . $this->post_id );
		\as_unschedule_all_actions( 'check_image_batch_' . $this->post_id );
		\as_unschedule_all_actions( 'check_optimizer_finished_' . $this->post_id );

		$data   = $this->processor->create_initial_data( $action );
		$report = $this->processor->create_initial_report( $data );

		if ( empty( $data['ids'] ) ) {
			$notice = array(
				'title'   => __( 'No images to optimize', 'modula-best-grid-gallery' ),
				'message' => __( 'No images to optimize', 'modula-best-grid-gallery' ),
				'status'  => 'warning',
			);

			Modula_Notification::add_notice( 'modula-no-images-to-optimize', $notice );
			return array(
				'status' => 'idle',
				'report' => $report,
			);
		}

		$this->processor->write_initial_data( $data, $report );
		$this->processor->schedule_first_batch();

		$notice = array(
			'title'   => __( 'Optimizer started', 'modula-best-grid-gallery' ),
			'message' => __( 'Optimizer started', 'modula-best-grid-gallery' ),
			'status'  => 'info',
		);

		Modula_Notification::add_notice( 'modula-optimizer-started', $notice );

		return array(
			'status' => 'running',
			'report' => $report,
		);
	}

	public function stop() {
		$this->processor->stop_manually();

		$notice = array(
			'title'   => __( 'Optimizer stopped', 'modula-best-grid-gallery' ),
			'message' => __( 'Optimizer stopped manually', 'modula-best-grid-gallery' ),
			'status'  => 'warning',
		);
		Modula_Notification::add_notice( 'modula-optimizer-stopped', $notice );
		return array(
			'status' => 'idle',
			'report' => $this->checker->get_report(),
		);
	}

	public function get_debug() {
		return get_option( $this->debug_option, array() );
	}

	public function status() {
		return array_merge(
			$this->checker->get_status(),
			$this->ai_helper->convert_to_camel_case(
				$this->gallery_helper->get_gallery_report( $this->post_id )
			)
		);
	}

	public function optimize_single( $image_id ) {
		$batch_id = $this->processor->process_image( $image_id );
		if ( ! $batch_id ) {
			return;
		}

		return $this->checker->check_single_image( $batch_id );
	}

	public function process_image_batch( $batch_number, $timestamp ) {
		return $this->processor->process_image_batch( $batch_number, $timestamp );
	}

	public function check_image_batch( $batch_number ) {
		return $this->checker->check_image_batch( $batch_number );
	}

	public function check_optimizer_finished() {
		return $this->checker->check_optimizer_finished();
	}
}
