<?php
namespace Modula\ImageSEO\Optimizer;

use Modula\Ai\Ai_Helper;
use Modula\Ai\Debug;
use Modula\Ai\Lock;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Processor {
	use Debug;
	use Lock;

	public $debug      = true;
	public $batch_size = 10;
	public $lock_name;
	public $data_option;
	public $status_option;

	public $default_report = array(
		'total'     => 0,
		'optimized' => 0,
		'failed'    => 0,
		'remaining' => 0,
		'skipped'   => 0,
	);

	protected static $instances = array();
	protected $post_id;

	protected $ai_helper;
	protected $gallery_helper;
	public static function get_instance( $post_id ) {
		if ( ! isset( self::$instances[ $post_id ] ) ||
		! ( self::$instances[ $post_id ] instanceof Processor ) ) {
			self::$instances[ $post_id ] = new Processor( $post_id );
		}

		return self::$instances[ $post_id ];
	}

	public function __construct( $post_id ) {
		$this->post_id       = $post_id;
		$this->debug_option  = 'modula_ai_optimizer_debug_' . $post_id;
		$this->debug_lock    = 'modula_ai_optimizer_debug_lock_' . $post_id;
		$this->lock_name     = 'modula_ai_optimizer_lock_' . $post_id;
		$this->data_option   = 'modula_ai_optimizer_data_' . $post_id;
		$this->status_option = 'modula_ai_optimizer_status_' . $post_id;

		$this->ai_helper      = Ai_Helper::get_instance();
		$this->gallery_helper = Gallery_Helper::get_instance();
	}

	public function process_image( $image_id ) {
		$images = array( $this->ai_helper->create_api_image( $image_id ) );
		$result = $this->ai_helper->send_request_to_api( $images, true );
		if ( $result instanceof \Exception ) {
			$this->log_api_error( $result );
			return;
		}

		if ( ! isset( $result['batchId'] ) ) {
			return;
		}

		return $result['batchId'];
	}

	public function stop_manually() {
		update_option( $this->status_option, 'idle' );
		delete_option( $this->data_option );

		$notice = array(
			'title'   => __( 'Optimizer stopped', 'modula-best-grid-gallery' ),
			'message' => __( 'Bulk optimizer stopped manually', 'modula-best-grid-gallery' ),
			'status'  => 'info',
		);

		Modula_Notification::add_notice( 'modula-bulk-optimizer-stopped', $notice );

		$this->write_debug( __( 'Bulk optimizer stopped manually', 'modula-best-grid-gallery' ) );
	}

	public function create_initial_data( $action ) {
		// Get gallery images
		$images = $this->gallery_helper->get_gallery_report( $this->post_id );

		// Create the data array
		$ids = 'without' === $action ? $images['images_without_alt_ids'] : $images['all_image_ids'];

		$data = array(
			'ids'                      => $ids,
			'optimized_ids'            => array(),
			'failed_ids'               => array(),
			'total_batches'            => ceil( count( $ids ) / $this->batch_size ),
			'batch_sent_to_processing' => array(),
			'processed_and_received'   => array(),
		);

		return $data;
	}

	public function create_initial_report( $data ) {
		$report = array(
			'total'     => count( $data['ids'] ),
			'optimized' => 0,
			'remaining' => count( $data['ids'] ),
			'failed'    => 0,
			'skipped'   => 0,
		);

		if ( empty( $data['ids'] ) ) {
			$this->write_debug( __( 'No images to process', 'modula-best-grid-gallery' ) );

			return $report;
		}

		return $report;
	}

	public function write_initial_data( $data ) {
		update_option( $this->data_option, $data );
		update_option( $this->status_option, 'running' );
	}

	public function schedule_first_batch() {
		\as_schedule_single_action(
			time(),
			'process_image_batch_' . $this->post_id,
			array(
				'batchNumber' => 0,
				'timestamp'   => time(),
			)
		);
	}

	public function process_image_batch( $batch_number, $timestamp ) {
		// Check if the batch can be processed
		if ( ! $this->acquire_lock( $this->lock_name ) ) {
			$this->write_debug( __( 'Lock already acquired', 'modula-best-grid-gallery' ) );
			// Reschedule the batch
			$this->reschedule_batch( $batch_number, $timestamp );
			return;
		}

		// Check if the API limits have been reached
		if ( $this->ai_helper->check_api_limits() ) {
			$this->write_debug( __( 'API limits reached', 'modula-best-grid-gallery' ) );
			$notice = array(
				'title'   => __( 'API limits reached', 'modula-best-grid-gallery' ),
				'message' => __( 'API limits reached', 'modula-best-grid-gallery' ),
				'status'  => 'warning',
			);

			Modula_Notification::add_notice( 'modula-api-limit-reached', $notice );
			$this->handle_limit_reached();
			$this->release_lock( $this->lock_name );
			return;
		}

		// Check if the batch can be processed
		$data = $this->prepare_batch_data( $batch_number );
		if ( empty( $data ) ) {
			$this->write_debug( __( 'No images to optimize', 'modula-best-grid-gallery' ) );
			$notice = array(
				'title'   => __( 'No images to optimize', 'modula-best-grid-gallery' ),
				'message' => __( 'No images to optimize', 'modula-best-grid-gallery' ),
				'status'  => 'warning',
			);

			Modula_Notification::add_notice( 'modula-no-images-to-optimize', $notice );
			update_option( $this->status_option, 'idle' );
			$this->release_lock( $this->lock_name );
			return;
		}

		// Send the batch to the API
		$result = $this->send_batch_to_api( $data );
		if ( $result instanceof \Exception ) {
			$this->log_api_error( $result );
			$this->release_lock( $this->lock_name );
			return;
		}

		// Update the batch status and schedule the next batch
		$this->update_batch_status( $result, $batch_number );
		$this->schedule_next_batch( $batch_number, $timestamp );
		// Release the lock
		$this->release_lock( $this->lock_name );
	}

	public function handle_limit_reached() {
		$notice = array(
			'title'   => __( 'Limit reached', 'modula-best-grid-gallery' ),
			'message' => __( 'You have reached the limit of images to optimize', 'modula-best-grid-gallery' ),
			'status'  => 'warning',
		);

		Modula_Notification::add_notice( 'modula-image-limit-reached', $notice );

		update_option( $this->status_option, 'idle' );
		$this->write_debug( __( 'Limit exceeded, processing stopped.', 'modula-best-grid-gallery' ) );
	}

	private function prepare_batch_data( $batch_number ) {
		$image_data = get_option( $this->data_option );
		if ( ! isset( $image_data['ids'] ) ) {
			return array();
		}

		$start = $batch_number * $this->batch_size;
		$end   = min( $start + $this->batch_size, count( $image_data['ids'] ) ) - 1;

		$batch_ids = array_slice( $image_data['ids'], $start, $this->batch_size );

		$this->write_debug(
			array(
				__( 'Processing batch number:', 'modula-best-grid-gallery' ) . ' ' . $batch_number,
				__( 'Start index:', 'modula-best-grid-gallery' ) . ' ' . $start,
				__( 'End index:', 'modula-best-grid-gallery' ) . ' ' . $end,
				__( 'Current batch IDs:', 'modula-best-grid-gallery' ) . ' ' . implode( ', ', $batch_ids ),
			)
		);

		$notice = array(
			'title'   => __( 'Batch processing', 'modula-best-grid-gallery' ),
			'message' => sprintf(
				/* translators: %1$d is the batch number, %2$d is the total number of batches */
				__( 'Processing batch %1$d of %2$d', 'modula-best-grid-gallery' ),
				$batch_number + 1,
				$image_data['total_batches']
			),
			'status'  => 'info',
		);

		Modula_Notification::add_notice( 'modula-processing-batch-' . ( $batch_number + 1 ), $notice );

		return array_filter(
			$batch_ids,
			function ( $id ) {
				return $this->is_valid_image_type( $id );
			}
		);
	}

	private function is_valid_image_type( $id ) {
		$url       = wp_get_attachment_url( $id );
		$extension = pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION );

		if ( ! in_array( $extension, array( 'png', 'jpg', 'jpeg', 'webp' ), true ) ) {
			$this->write_debug( __( 'Unsupported file format:', 'modula-best-grid-gallery' ) . ' ' . $extension );
			return false;
		}
		return true;
	}

	private function send_batch_to_api( $batch_data ) {
		$images = array_map(
			function ( $id ) {
				return $this->ai_helper->create_api_image( $id );
			},
			$batch_data
		);

		return $this->ai_helper->send_request_to_api( $images );
	}

	private function schedule_next_batch( $batch_number, $timestamp ) {
		$data  = get_option( $this->data_option );
		$total = count( $data['ids'] );
		$end   = min( ( $batch_number + 1 ) * $this->batch_size, $total ) - 1;
		$this->write_debug( __( 'Schedule check image batch with index 0', 'modula-best-grid-gallery' ) );

		\as_schedule_single_action(
			time() + 5,
			'check_image_batch_' . $this->post_id,
			array( 'batch_number' => $batch_number )
		);

		if ( $end < $total - 1 ) {
			$this->write_debug( __( 'Schedule next batch with index:', 'modula-best-grid-gallery' ) . ' ' . ( $batch_number + 1 ) );

			\as_schedule_single_action(
				time() + 10,
				'process_image_batch_' . $this->post_id,
				array(
					'batch_number' => $batch_number + 1,
					'timestamp'    => $timestamp,
				)
			);
		}
	}

	private function log_api_error( $exception ) {
		$notice = array(
			'title'   => __( 'Something went wrong, processing stopped.', 'modula-best-grid-gallery' ),
			'message' => $exception->getMessage(),
			'status'  => 'danger',
		);

		Modula_Notification::add_notice( 'modula-log-api-error-' . $this->post_id, $notice );

		update_option( $this->status_option, 'idle' );

		$this->write_debug( __( 'API Error: ', 'modula-best-grid-gallery' ) . $exception->getMessage() );
	}

	private function update_batch_status( $result, $batch_number ) {
		$data = get_option( $this->data_option );

		$data['batch_ids'][]                = $result[0]['batchId'];
		$data['batch_sent_to_processing'][] = $batch_number;

		update_option( $this->data_option, $data );
		$this->write_debug( __( 'Batch', 'modula-best-grid-gallery' ) . ' ' . $batch_number . __( ' updated with ID ', 'modula-best-grid-gallery' ) . $result[0]['batchId'] );
	}

	private function reschedule_batch( $batch_number, $timestamp ) {
		return \as_schedule_single_action(
			time() + 10,
			'process_image_batch_' . $this->post_id,
			array(
				'batch_number' => $batch_number,
				'timestamp'    => $timestamp,
			)
		);
	}
}
