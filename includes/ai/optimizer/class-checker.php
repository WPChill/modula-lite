<?php
namespace Modula\Ai\Optimizer;

use Modula\Ai\Debug;
use Modula\Ai\Lock;
use Modula_Notification;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Checker {
	use Debug;
	use Lock;

	const REPORT = '_modula_ai_report';

	public $debug = true;
	public $lock_name;
	public $data_option;
	public $status_option;
	public $report_option;

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

	public static function get_instance( $post_id ) {
		if ( ! isset( self::$instances[ $post_id ] ) ||
		! ( self::$instances[ $post_id ] instanceof Checker ) ) {
			self::$instances[ $post_id ] = new Checker( $post_id );
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
		$this->report_option = 'modula_ai_optimizer_report_' . $post_id;

		$this->ai_helper = Ai_Helper::get_instance();
	}

	public function check_single_image( $batch_id ) {
		$items = $this->ai_helper->get_items_by_batch_id( $batch_id );
		if ( $items instanceof Exception ) {
			error_log( $items->getMessage() );

			return false;
		}

		$image         = $items[0];
		$attachment_id = $image['internalId'];

		// $this->get_service( 'Alt' )->updateAlt( $attachment_id, $image['altText'] );
		update_post_meta( $attachment_id, self::REPORT, $image );

		return true;
	}

	public function get_report() {
		$report = get_option( $this->report_option, $this->default_report );

		return $report;
	}

	public function get_status() {
		$data   = get_option( $this->data_option, false );
		$report = $this->get_report();

		if ( ! $data ) {
			return array(
				'status' => 'idle',
				'report' => $report,
			);
		}

		$report['total']     = count( $data['ids'] );
		$report['optimized'] = count( $data['optimized_ids'] );
		$report['failed']    = count( $data['failed_ids'] ?? array() );
		$report['remaining'] = $report['total'] - $report['optimized'] - $report['failed'];
		$report['skipped']   = $report['failed'];

		return array(
			'status' => get_option( $this->status_option, 'idle' ),
			'report' => $report,
		);
	}

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

		Modula_Notification::add_notice( 'modula-batch-processed-' . ( $batch_number + 1 ), $notice );
		$this->release_lock( $this->lock_name );

		\as_schedule_single_action(
			time() + 10,
			'check_optimizer_finished_' . $this->post_id,
			array()
		);
	}

	public function check_optimizer_finished() {
		if ( ! $this->has_processed_all() ) {
			\as_schedule_single_action(
				time() + 10,
				'check_optimizer_finished_' . $this->post_id,
				array()
			);
			return;
		}

		$this->write_debug( __( 'All batches processed', 'modula-best-grid-gallery' ) );

		$notice = array(
			'title'   => __( 'All batches processed', 'modula-best-grid-gallery' ),
			'message' => __( 'All images have been optimized', 'modula-best-grid-gallery' ),
			'status'  => 'success',
		);

		Modula_Notification::add_notice( 'modula-all-batches-processed', $notice );
		$this->finalize_processing();
	}

	private function reschedule_batch( $batch_number ) {
		$this->write_debug( __( 'Rescheduling batch number:', 'modula-best-grid-gallery' ) . ' ' . $batch_number );
		\as_schedule_single_action(
			time() + 5,
			'check_image_batch_' . $this->post_id,
			array(
				'batch_number' => $batch_number,
			)
		);
	}

	private function is_image_data_available() {
		return get_option( $this->data_option, false ) !== false;
	}

	private function is_batch_sent_to_processing( $batch_number ) {
		$data = get_option( $this->data_option );
		return in_array( $batch_number, $data['batch_sent_to_processing'], true );
	}

	private function get_batch_id( $batch_number ) {
		$data = get_option( $this->data_option );
		return $data['batch_ids'][ $batch_number ] ?? null;
	}

	private function handle_missing_batch_id( $batch_number ) {
		$notice = array(
			'title'   => __( 'Batch ID not found', 'modula-best-grid-gallery' ),
			'message' => __( 'Batch ID not found for batch number: ', 'modula-best-grid-gallery' ) . $batch_number,
			'status'  => 'danger',
		);

		Modula_Notification::add_notice( 'modula-batch-id-missing-' . $batch_number, $notice );
		update_option( $this->status_option, 'idle' );

		$this->write_debug( __( 'Batch ID not found for batch number: ', 'modula-best-grid-gallery' ) . $batch_number );
	}

	private function handle_batch_data_error( $exception, $batch_number ) {
		$notice = array(
			'title'   => __( 'Batch Data Error', 'modula-best-grid-gallery' ),
			'message' => $exception->getMessage(),
			'status'  => 'danger',
		);

		Modula_Notification::add_notice( 'modula-batch-data-error-' . $batch_number, $notice );

		$this->write_debug( $exception->getMessage() );
		update_option( $this->status_option, 'idle' );
	}

	private function all_images_processed( $batch_data ) {
		foreach ( $batch_data as $image ) {
			if ( ! $image['resolved'] && ! $image['failed'] ) {
				return false;
			}
		}
		return true;
	}

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
	}

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
		$this->update_in_gallery(
			$attachment_id,
			$image['altText'],
			$image['caption'],
			$image['title']
		);
		if ( ! $skip_alt ) {
			// $this->get_service( 'Alt' )->updateAlt( $image['internalId'], $image['altText'] );
			$this->write_debug( $image['internalId'] . ': ' . $image['altText'] );
		}

		if ( $optimize_filename && ! $skip_filename ) {
			$extension = $this->extract_extension( $image['imageUrl'] );

			// $this->get_service( 'UpdateFile' )->updateFilename(
			//  $image['internalId'],
			//  sprintf( '%s.%s', $image['filename'], $extension )
			// );
			$this->write_debug( $image['internalId'] . ': ' . $image['filename'] . '.' . $extension );
		}

		$optimized[] = $image['internalId'];
	}

	private function handle_failed_image( $image, &$report, &$failed ) {
		$notice = array(
			'title'   => __( 'Failed image update', 'modula-best-grid-gallery' ),
			'message' => $image['failureDetails'],
			'status'  => 'error',
		);

		Modula_Notification::add_notice( $this->report_option, $notice );

		$this->write_debug(
			array(
				__( 'Failed image:', 'modula-best-grid-gallery' ) . ' ' . $image['internalId'],
				$image['failureDetails'],
			)
		);
		$failed[] = $image['internalId'];
	}

	private function update_in_gallery( $attachment_id, $alt_text, $caption, $title ) {
		$gallery = get_post_meta( $this->post_id, 'modula-images', true );
		if ( ! $gallery ) {
			return;
		}

		foreach ( $gallery as $key => $image ) {
			if ( (int) $image['id'] === (int) $attachment_id ) {
				$gallery[ $key ]['alt']         = $alt_text;
				$gallery[ $key ]['description'] = $caption;
				$gallery[ $key ]['title']       = $title;
				break;
			}
		}

		update_post_meta( $this->post_id, 'modula-images', $gallery );
	}

	public function extract_extension( $url ): string {
		return pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION );
	}

	public function has_processed_all() {
		$image_data = get_option( $this->data_option );
		return count( $image_data['processed_and_received'] ) >= $image_data['total_batches'];
	}

	private function finalize_processing() {
		update_option( $this->status_option, 'idle' );
		$this->write_debug( __( 'Finalizing entire batch processing.', 'modula-best-grid-gallery' ) );
	}
}
