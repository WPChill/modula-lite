<?php
namespace Modula\Ai\Optimizer;

use Modula\Ai\Ai_Helper;
use Modula\Ai\Debug;
use Modula\Ai\Gallery_Helper;
use Modula\Ai\Lock;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Processor {
	use Debug;
	use Lock;

	/** @var string */
	const REPORT = '_modula_ai_report';

	/** @var bool */
	public $debug = true;
	/** @var int */
	public $batch_size = 10;
	/** @var string */
	public $lock_name;
	/** @var string */
	public $data_option;
	/** @var string */
	public $status_option;

	/** @var array */
	public $default_report = array(
		'total'     => 0,
		'optimized' => 0,
		'failed'    => 0,
		'remaining' => 0,
		'skipped'   => 0,
	);

	/** @var array */
	protected static $instances = array();
	/** @var int */
	protected $post_id;

	/** @var Ai_Helper */
	protected $ai_helper;
	/** @var Gallery_Helper */
	protected $gallery_helper;

	/**
	 * Retrieves the singleton instance of the Processor class.
	 *
	 * @param int $post_id The ID of the post.
	 * @return Processor The singleton instance.
	 */
	public static function get_instance( $post_id ) {
		if ( ! isset( self::$instances[ $post_id ] ) ||
		! ( self::$instances[ $post_id ] instanceof Processor ) ) {
			self::$instances[ $post_id ] = new Processor( $post_id );
		}

		return self::$instances[ $post_id ];
	}

	/**
	 * Constructor for the Processor class.
	 *
	 * @param int $post_id The ID of the post.
	 */
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

	/**
	 * Processes a single image.
	 *
	 * @param int $image_id The ID of the image.
	 * @return string|null The batch ID if successful, null otherwise.
	 */
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

		update_post_meta( $image_id, self::REPORT, $result );

		return $result;
	}

	/**
	 * Stops the optimizer manually.
	 */
	public function stop_manually() {
		update_option( $this->status_option, 'idle' );
		delete_option( $this->data_option );

		$notice = array(
			'title'   => __( 'Optimizer stopped', 'modula-best-grid-gallery' ),
			'message' => __( 'Bulk optimizer stopped manually', 'modula-best-grid-gallery' ),
			'status'  => 'info',
		);

		\Modula_Notifications::add_notification( 'modula-bulk-optimizer-stopped-' . $this->post_id, $notice );

		$this->write_debug( __( 'Bulk optimizer stopped manually', 'modula-best-grid-gallery' ) );
	}

	/**
	 * Creates initial data for the optimizer.
	 *
	 * @param string $action The action to perform.
	 * @return array The initial data.
	 */
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

	/**
	 * Creates initial report for the optimizer.
	 *
	 * @param array $data The initial data.
	 * @return array The initial report.
	 */
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

	/**
	 * Writes initial data to the database.
	 *
	 * @param array $data The initial data.
	 */
	public function write_initial_data( $data ) {
		update_option( $this->data_option, $data );
		update_option( $this->status_option, 'running' );
	}

	/**
	 * Schedules the first batch.
	 */
	public function schedule_first_batch() {
		\as_schedule_single_action(
			time(),
			'mai_process_image_batch_' . $this->post_id,
			array(
				'batchNumber' => 0,
				'timestamp'   => time(),
			)
		);
	}

	/**
	 * Processes a batch of images.
	 *
	 * @param int $batch_number The batch number.
	 * @param int $timestamp The timestamp.
	 */
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

			Modula_Notifications::add_notification( 'modula-api-limit-reached-' . $this->post_id, $notice );
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

			\Modula_Notifications::add_notification( 'modula-no-images-to-optimize-' . $this->post_id, $notice );
			update_option( $this->status_option, 'idle' );
			$this->release_lock( $this->lock_name );
			return;
		}

		// Check the images if they have been optimized
		$optimized_images = $this->check_optimized_images( $data );

		$this->write_debug( __( 'Optimized images: ', 'modula-best-grid-gallery' ) . implode( ', ', $optimized_images ) );

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

	/**
	 * Checks if the images have been optimized.
	 *
	 * @param array $data The data.
	 * @return array The optimized images.
	 */
	private function check_optimized_images( $data ) {
		$optimized_images = array();

		foreach ( $data as $id ) {
			$optimized = $this->ai_helper->check_if_optimized( $id );
			$this->write_debug( $id . ': ' . ( is_array( $optimized ) ? wp_json_encode( $optimized ) : $optimized ) );

			if ( $optimized ) {
				$optimized_images[] = $id;
			}
		}

		return $optimized_images;
	}

		/**
		 * Handles the limit reached error.
		 */
	public function handle_limit_reached() {
		$notice = array(
			'title'   => __( 'Limit reached', 'modula-best-grid-gallery' ),
			'message' => __( 'You have reached the limit of images to create reports.', 'modula-best-grid-gallery' ),
			'status'  => 'warning',
		);

		\Modula_Notifications::add_notification( 'modula-image-limit-reached-' . $this->post_id, $notice );

		update_option( $this->status_option, 'idle' );
		$this->write_debug( __( 'Limit exceeded, processing stopped.', 'modula-best-grid-gallery' ) );
	}

		/**
		 * Prepares the batch data.
		 *
		 * @param int $batch_number The batch number.
		 * @return array The batch data.
		 */
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

		\Modula_Notifications::add_notification( 'modula-processing-batch-' . $this->post_id . '-' . ( $batch_number + 1 ), $notice );

		return array_filter(
			$batch_ids,
			function ( $id ) {
				return $this->is_valid_image_type( $id );
			}
		);
	}

		/**
		 * Checks if the image type is valid.
		 *
		 * @param int $id The ID of the image.
		 * @return bool True if the image type is valid, false otherwise.
		 */
	private function is_valid_image_type( $id ) {
		$url       = wp_get_attachment_url( $id );
		$extension = pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION );

		if ( ! in_array( $extension, array( 'png', 'jpg', 'jpeg', 'webp' ), true ) ) {
			$this->write_debug( __( 'Unsupported file format:', 'modula-best-grid-gallery' ) . ' ' . $extension );
			return false;
		}
		return true;
	}

		/**
		 * Sends a batch of images to the API.
		 *
		 * @param array $batch_data The batch data.
		 * @return array The result from the API.
		 */
	private function send_batch_to_api( $batch_data ) {
		$images = array_map(
			function ( $id ) {
				return $this->ai_helper->create_api_image( $id );
			},
			$batch_data
		);

		return $this->ai_helper->send_request_to_api( $images );
	}

		/**
		 * Schedules the next batch.
		 *
		 * @param int $batch_number The batch number.
		 * @param int $timestamp The timestamp.
		 */
	private function schedule_next_batch( $batch_number, $timestamp ) {
		$data  = get_option( $this->data_option );
		$total = count( $data['ids'] );
		$end   = min( ( $batch_number + 1 ) * $this->batch_size, $total ) - 1;

		$this->write_debug( __( 'Schedule check image batch with number: ', 'modula-best-grid-gallery' ) . $batch_number );

		\as_schedule_single_action(
			time() + 5,
			'mai_check_image_batch_' . $this->post_id,
			array( 'batch_number' => $batch_number )
		);

		if ( $end < $total - 1 ) {
			$this->write_debug( __( 'Schedule next batch with number: ', 'modula-best-grid-gallery' ) . ( $batch_number + 1 ) );

			\as_schedule_single_action(
				time() + 10,
				'mai_process_image_batch_' . $this->post_id,
				array(
					'batch_number' => $batch_number + 1,
					'timestamp'    => $timestamp,
				)
			);
		} else {
			// This is the last batch, schedule the final check
			$this->write_debug( __( 'Last batch processed, scheduling final check', 'modula-best-grid-gallery' ) );
			\as_schedule_single_action(
				time() + 15,
				'mai_check_optimizer_finished_' . $this->post_id,
				array()
			);
		}
	}

		/**
		 * Logs an API error.
		 *
		 * @param \Exception $exception The exception.
		 */
	private function log_api_error( $exception ) {
		$notice = array(
			'title'   => __( 'Something went wrong, processing stopped.', 'modula-best-grid-gallery' ),
			'message' => $exception->getMessage(),
			'status'  => 'danger',
		);

		\Modula_Notifications::add_notification( 'modula-log-api-error-' . $this->post_id, $notice );

		update_option( $this->status_option, 'idle' );

		$this->write_debug( __( 'API Error: ', 'modula-best-grid-gallery' ) . $exception->getMessage() );
	}

		/**
		 * Updates the batch status.
		 *
		 * @param array $result The result from the API.
		 * @param int $batch_number The batch number.
		 */
	private function update_batch_status( $result, $batch_number ) {
		$data = get_option( $this->data_option );

		$data['batch_ids'][]                = $result[0]['batchId'];
		$data['batch_sent_to_processing'][] = $batch_number;

		update_option( $this->data_option, $data );
		$this->write_debug( __( 'Batch', 'modula-best-grid-gallery' ) . ' ' . $batch_number . __( ' updated with ID ', 'modula-best-grid-gallery' ) . $result[0]['batchId'] );
	}

		/**
		 * Reschedules the batch.
		 *
		 * @param int $batch_number The batch number.
		 * @param int $timestamp The timestamp.
		 */
	private function reschedule_batch( $batch_number, $timestamp ) {
		return \as_schedule_single_action(
			time() + 10,
			'mai_process_image_batch_' . $this->post_id,
			array(
				'batch_number' => $batch_number,
				'timestamp'    => $timestamp,
			)
		);
	}
}
