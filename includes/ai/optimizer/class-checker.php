<?php
namespace Modula\Ai\Optimizer;

use Modula\Ai\Ai_Helper;
use Modula\Ai\Debug;
use Modula\Ai\Files_Helper;
use Modula\Ai\Lock;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Checker {
	use Debug;
	use Lock;

	/** @var string */
	const REPORT = '_modula_ai_report';

	/** @var bool */
	public $debug = true;
	/** @var string */
	public $lock_name;
	/** @var string */
	public $data_option;
	/** @var string */
	public $status_option;
	/** @var string */
	public $report_option;

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

	/** @var Files_Helper */
	protected $files_helper;

	/**
	 * Retrieves the singleton instance of the Checker class.
	 *
	 * @param int $post_id The ID of the post.
	 * @return Checker The singleton instance.
	 */
	public static function get_instance( $post_id ) {
		if ( ! isset( self::$instances[ $post_id ] ) ||
		! ( self::$instances[ $post_id ] instanceof Checker ) ) {
			self::$instances[ $post_id ] = new Checker( $post_id );
		}

		return self::$instances[ $post_id ];
	}

	/**
	 * Constructor for the Checker class.
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
		$this->report_option = 'modula_ai_optimizer_report_' . $post_id;

		$this->ai_helper    = Ai_Helper::get_instance();
		$this->files_helper = Files_Helper::get_instance();
	}

	/**
	 * Checks a single image.
	 *
	 * @param string $batch_id The batch ID.
	 * @return bool True if the image was checked successfully, false otherwise.
	 */
	public function check_single_image( $batch_id ) {
		$items = $this->ai_helper->get_items_by_batch_id( $batch_id );
		if ( $items instanceof Exception ) {
			error_log( $items->getMessage() );

			return false;
		}

		$image         = $items[0];
		$attachment_id = $image['internalId'];

		$this->update_attachment_info( $attachment_id, $image );
		update_post_meta( $attachment_id, self::REPORT, $image );

		return true;
	}

	/**
	 * Retrieves the report for the current batch.
	 *
	 * @return array The report data.
	 */
	public function get_report() {
		$report = get_option( $this->report_option, $this->default_report );

		return $report;
	}

	/**
	 * Retrieves the status of the current batch.
	 *
	 * @return array The status data.
	 */
	public function get_status() {
		$data   = get_option( $this->data_option, false );
		$report = $this->get_report();

		if ( ! $data || ! is_array( $data ) ) {
			return array(
				'status' => 'idle',
				'report' => $report,
			);
		}

		$report['total']     = isset( $data['ids'] ) && is_array( $data['ids'] ) ? count( $data['ids'] ) : 0;
		$report['optimized'] = isset( $data['optimized_ids'] ) && is_array( $data['optimized_ids'] ) ? count( $data['optimized_ids'] ) : 0;
		$report['failed']    = isset( $data['failed_ids'] ) && is_array( $data['failed_ids'] ) ? count( $data['failed_ids'] ) : 0;
		$report['remaining'] = $report['total'] - $report['optimized'] - $report['failed'];
		$report['skipped']   = $report['failed'];

		return array(
			'status' => get_option( $this->status_option, 'idle' ),
			'report' => $report,
		);
	}

	/**
	 * Checks a batch of images.
	 *
	 * @param int $batch_number The batch number.
	 * @return void
	 */
	public function check_image_batch( $batch_number ) {
		if ( ! $this->acquire_lock( $this->lock_name ) ) {
			$this->write_debug( __( 'Lock already acquired', 'modula-best-grid-gallery' ) );
			$this->reschedule_batch( $batch_number );
			return;
		}

		if ( ! $this->is_image_data_available() ) {
			$this->write_debug( __( 'No images to optimize', 'modula-best-grid-gallery' ) );
			$this->finalize_processing();
			$this->release_lock( $this->lock_name );
			return;
		}

		if ( ! $this->is_batch_sent_to_processing( $batch_number ) ) {
			$this->write_debug( __( 'Batch not sent to processing:', 'modula-best-grid-gallery' ) . ' ' . $batch_number );
			$this->reschedule_batch( $batch_number );
			$this->release_lock( $this->lock_name );
			return;
		}

		$batch_id = $this->get_batch_id( $batch_number );
		if ( is_null( $batch_id ) ) {
			$this->write_debug( __( 'Batch ID not found for batch number:', 'modula-best-grid-gallery' ) . ' ' . $batch_number );
			$this->handle_missing_batch_id( $batch_number );
			$this->release_lock( $this->lock_name );
			return;
		}

		$batch_data = $this->ai_helper->get_items_by_batch_id( $batch_id );
		if ( $batch_data instanceof \Exception ) {
			$this->write_debug( __( 'Error retrieving batch data:', 'modula-best-grid-gallery' ) . ' ' . $batch_data->getMessage() );
			$this->handle_batch_data_error( $batch_data, $batch_number );
			$this->release_lock( $this->lock_name );
			return;
		}

		if ( ! $this->all_images_processed( $batch_data ) ) {
			$this->write_debug( __( 'Not all images processed for batch number:', 'modula-best-grid-gallery' ) . ' ' . $batch_number );
			$this->reschedule_batch( $batch_number );
			$this->release_lock( $this->lock_name );
			return;
		}

		$this->update_image_statuses( $batch_data, $batch_number );
		$this->write_debug( __( 'Finalizing batch processing for batch number: ', 'modula-best-grid-gallery' ) . $batch_number );

		$notice = array(
			'title'   => __( 'Batch processed', 'modula-best-grid-gallery' ),
			'message' => sprintf(
				/* translators: %d is the batch number */
				__( 'Batch %d processed', 'modula-best-grid-gallery' ),
				$batch_number + 1
			),
			'status'  => 'warning',
		);

		Modula_Notifications::add_notification( 'modula-batch-processed-' . $this->post_id . '-' . ( $batch_number + 1 ), $notice );
		$this->release_lock( $this->lock_name );

		\as_schedule_single_action(
			time() + 10,
			'mai_check_optimizer_finished_' . $this->post_id,
			array()
		);
	}

	/**
	 * Checks if all batches have been processed.
	 *
	 * @return void
	 */
	public function check_optimizer_finished() {
		$this->write_debug( __( 'Checking if optimizer is finished...', 'modula-best-grid-gallery' ) );

		if ( ! $this->has_processed_all() ) {
			$this->write_debug( __( 'Not all batches processed yet, rescheduling check...', 'modula-best-grid-gallery' ) );
			\as_schedule_single_action(
				time() + 10,
				'mai_check_optimizer_finished_' . $this->post_id,
				array()
			);
			return;
		}

		$this->write_debug( __( 'All batches processed', 'modula-best-grid-gallery' ) );

		$notice = array(
			'title'   => __( 'Modula AI optimization completed', 'modula-best-grid-gallery' ),
			'message' => __( 'Generated reports for all images.', 'modula-best-grid-gallery' ),
			'status'  => 'success',
		);

		\Modula_Notifications::add_notification( 'modula-all-batches-processed-' . $this->post_id, $notice );
		$this->finalize_processing();
	}

	/**
	 * Reschedules a batch of images.
	 *
	 * @param int $batch_number The batch number.
	 * @return void
	 */
	private function reschedule_batch( $batch_number ) {
		$this->write_debug( __( 'Rescheduling batch number:', 'modula-best-grid-gallery' ) . ' ' . $batch_number );
		\as_schedule_single_action(
			time() + 5,
			'mai_check_image_batch_' . $this->post_id,
			array(
				'batch_number' => $batch_number,
			)
		);
	}

	/**
	 * Checks if image data is available.
	 *
	 * @return bool True if image data is available, false otherwise.
	 */
	private function is_image_data_available() {
		return get_option( $this->data_option, false ) !== false;
	}

	/**
	 * Checks if a batch has been sent to processing.
	 *
	 * @param int $batch_number The batch number.
	 * @return bool True if the batch has been sent to processing, false otherwise.
	 */
	private function is_batch_sent_to_processing( $batch_number ) {
		$data = get_option( $this->data_option );
		return in_array( $batch_number, $data['batch_sent_to_processing'], true );
	}

	/**
	 * Retrieves the batch ID for a given batch number.
	 *
	 * @param int $batch_number The batch number.
	 * @return string|null The batch ID or null if not found.
	 */
	private function get_batch_id( $batch_number ) {
		$data = get_option( $this->data_option );
		return $data['batch_ids'][ $batch_number ] ?? null;
	}

	/**
	 * Handles the case where a batch ID is missing.
	 *
	 * @param int $batch_number The batch number.
	 * @return void
	 */
	private function handle_missing_batch_id( $batch_number ) {
		$notice = array(
			'title'   => __( 'Batch ID not found', 'modula-best-grid-gallery' ),
			'message' => __( 'Batch ID not found for batch number: ', 'modula-best-grid-gallery' ) . $batch_number,
			'status'  => 'danger',
		);

		\Modula_Notifications::add_notification( 'modula-batch-id-missing-' . $this->post_id . '-' . $batch_number, $notice );
		update_option( $this->status_option, 'idle' );

		$this->write_debug( __( 'Batch ID not found for batch number: ', 'modula-best-grid-gallery' ) . $batch_number );
	}

	/**
	 * Handles the case where a batch data error occurs.
	 *
	 * @param \Exception $exception The exception object.
	 * @param int $batch_number The batch number.
	 * @return void
	 */
	private function handle_batch_data_error( $exception, $batch_number ) {
		$notice = array(
			'title'   => __( 'Batch Data Error', 'modula-best-grid-gallery' ),
			'message' => $exception->getMessage(),
			'status'  => 'danger',
		);

		\Modula_Notifications::add_notification( 'modula-batch-data-error-' . $this->post_id . '-' . $batch_number, $notice );

		$this->write_debug( $exception->getMessage() );
		update_option( $this->status_option, 'idle' );
	}

	/**
	 * Checks if all images in a batch have been processed.
	 *
	 * @param array $batch_data The batch data.
	 * @return bool True if all images have been processed, false otherwise.
	 */
	private function all_images_processed( $batch_data ) {
		foreach ( $batch_data as $image ) {
			if ( ! $image['resolved'] && ! $image['failed'] ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Updates the statuses of images in a batch.
	 *
	 * @param array $batch_data The batch data.
	 * @param int $batch_number The batch number.
	 * @return void
	 */
	private function update_image_statuses( $batch_data, $batch_number ) {
		$optimize_filename = false;
		$optimized         = array();
		$failed            = array();

		$report = $this->get_report();
		foreach ( $batch_data as $image ) {
			if ( $image['resolved'] ) {
				$this->handle_resolved_image( $image, $optimize_filename, $optimized );
				continue;
			}

			if ( $image['failed'] ) {
				$this->handle_failed_image( $image, $report, $failed );
				continue;
			}
		}

		$data = get_option( $this->data_option );

		$processed = array_merge( $data['processed_and_received'], array( $batch_number ) );
		$optimized = array_merge( $data['optimized_ids'], $optimized );
		$failed    = array_merge( $data['failed_ids'], $failed );

		$data = array_merge(
			$data,
			array(
				'optimized_ids'          => $optimized,
				'failed_ids'             => $failed,
				'processed_and_received' => $processed,
			)
		);

		$this->write_debug(
			array(
				__( 'Batch processed and received:', 'modula-best-grid-gallery' ) . ' ' . $batch_number,
				__( 'Optimized:', 'modula-best-grid-gallery' ) . ' ' . count( $optimized ),
				__( 'Failed:', 'modula-best-grid-gallery' ) . ' ' . count( $failed ),
			)
		);

		$report['optimized'] += count( $optimized );
		$report['failed']    += count( $failed );

		update_option( $this->data_option, $data );
		update_option( $this->report_option, $report );

		if ( $this->has_processed_all() ) {
			\as_schedule_single_action(
				time() + 10,
				'mai_check_optimizer_finished_' . $this->post_id,
				array()
			);
		}
	}

	/**
	 * Handles a resolved image.
	 *
	 * @param array $image The image data.
	 * @param bool $optimize_filename Whether to optimize the filename.
	 * @param array $optimized The array of optimized images.
	 * @return void
	 */
	private function handle_resolved_image( $image, $optimize_filename, &$optimized ) {
		$attachment_id = $image['internalId'];

		$post_meta = get_post_meta( $attachment_id, self::REPORT, true );

		$skip_alt      = false;
		$skip_filename = false;

		if ( $post_meta ) {
			if ( isset( $post_meta['forced_alt_text'] ) && $post_meta['forced_alt_text'] ) {
				$this->write_debug( __( 'Alt text was manually added for this image, skipping', 'modula-best-grid-gallery' ) );
				$skip_alt         = true;
				$image['altText'] = $post_meta['altText'];
			}

			if ( isset( $post_meta['forced_filename'] ) && $post_meta['forced_filename'] ) {
				$this->write_debug( __( 'Filename was manually added for this image, skipping', 'modula-best-grid-gallery' ) );
				$skip_filename     = true;
				$image['filename'] = $post_meta['filename'];
			}
		}

		update_post_meta( $attachment_id, self::REPORT, $image );

		if ( ! $skip_alt ) {
			$this->update_attachment_info( $attachment_id, $image );
		}

		if ( $optimize_filename && ! $skip_filename ) {
			$extension = $this->extract_extension( $image['imageUrl'] );

			$this->files_helper->update_filename(
				$attachment_id,
				sprintf( '%s.%s', $image['filename'], $extension )
			);

			$this->write_debug( $attachment_id . ': ' . $image['filename'] . '.' . $extension );
		}

		$optimized[] = $attachment_id;
	}

	/**
	 * Handles a failed image.
	 *
	 * @param array $image The image data.
	 * @param array $report The report data.
	 * @param array $failed The array of failed images.
	 * @return void
	 */
	private function handle_failed_image( $image, &$report, &$failed ) {
		$notice = array(
			'title'   => __( 'Failed image update', 'modula-best-grid-gallery' ),
			'message' => $image['failureDetails'],
			'status'  => 'error',
		);

		\Modula_Notifications::add_notification( 'modula-failed-image-update-' . $this->post_id, $notice );

		$this->write_debug(
			array(
				__( 'Failed image:', 'modula-best-grid-gallery' ) . ' ' . $image['internalId'],
				$image['failureDetails'],
			)
		);
		$failed[] = $image['internalId'];
	}

	/**
	 * Updates the alt text and info for an attachment.
	 *
	 * @param int $attachment_id The attachment ID.
	 * @param array $report The report.
	 * @return void
	 */
	private function update_attachment_info( $attachment_id, $report ) {
		$alt      = $report['altText'];
		$metadata = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );

		// Update alt text
		update_post_meta(
			$attachment_id,
			'_wp_attachment_image_alt',
			apply_filters( 'modula_ai_update_alt', $alt, $attachment_id )
		);
		$this->write_debug( $attachment_id . ': ' . $alt );

		// Update metadata if it exists
		if ( is_array( $metadata ) && isset( $metadata['image_meta'] ) ) {
			$metadata['image_meta']['caption'] = $report['caption'] ?? $alt;
			$metadata['image_meta']['title']   = $report['title'] ?? $alt;

			update_post_meta( $attachment_id, '_wp_attachment_metadata', $metadata );

			$post_data = array(
				'ID'           => $attachment_id,
				'post_title'   => $report['title'] ?? $alt,
				'post_name'    => sanitize_title( $report['title'] ?? $alt ),
				'post_excerpt' => $report['caption'] ?? $alt,
			);
			wp_update_post( $post_data );

			$this->write_debug(
				sprintf(
					/* translators: %1$d is the attachment ID, %2$s is the title, %3$s is the caption */
					__( 'Updated metadata for image %1$d - Title: %2$s, Caption: %3$s', 'modula-best-grid-gallery' ),
					$attachment_id,
					$metadata['image_meta']['title'],
					$metadata['image_meta']['caption']
				)
			);
		}
	}

	/**
	 * Extracts the extension from a URL.
	 *
	 * @param string $url The URL.
	 * @return string The extension.
	 */
	public function extract_extension( $url ): string {
		return pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION );
	}

	/**
	 * Checks if all images have been processed.
	 *
	 * @return bool True if all images have been processed, false otherwise.
	 */
	public function has_processed_all() {
		$image_data = get_option( $this->data_option );
		if ( ! $image_data || ! isset( $image_data['processed_and_received'] ) || ! isset( $image_data['total_batches'] ) ) {
			return false;
		}
		return count( array_unique( $image_data['processed_and_received'] ) ) >= $image_data['total_batches'];
	}

	/**
	 * Finalizes the processing of the batch.
	 *
	 * @return void
	 */
	private function finalize_processing() {
		update_option( $this->status_option, 'idle' );
		$this->write_debug( __( 'Finalizing entire batch processing.', 'modula-best-grid-gallery' ) );
	}
}
