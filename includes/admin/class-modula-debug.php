<?php


class Modula_Debug {

	/**
	 * Holds the class object.
	 *
	 * @since 2.4.2
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Modula_Debug constructor.
	 *
	 * @since 2.4.2
	 */
	function __construct() {
		// Add Modula's debug information
		add_filter( 'debug_information', array( $this, 'modula_debug_information' ), 60, 1 );
	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Debug object.
	 * @since 2.4.2
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !( self::$instance instanceof Modula_Debug ) ) {
			self::$instance = new Modula_Debug();
		}

		return self::$instance;

	}

	/**
	 * Modula Debug Info
	 *
	 * @param $info
	 *
	 * @return mixed
	 * @since 2.4.2
	 */
	public function modula_debug_information($info){

		$troubleshoot_opt = get_option( 'modula_troubleshooting_option' );
		$grid_type = '';
		$lightboxes = '';

		if ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'gridtypes' ] ) && !empty( $troubleshoot_opt[ 'gridtypes' ] ) ) {
			foreach ( $troubleshoot_opt[ 'gridtypes' ] as $type ) {
				$grid_type .= '{' . $type . '}';
			}
		}

		if ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lightboxes' ] ) && !empty( $troubleshoot_opt[ 'lightboxes' ] ) ) {
			foreach ( $troubleshoot_opt[ 'lightboxes' ] as $lightbox ) {
				$lightboxes .= '{' . $lightbox . '}';
			}
		}

		$info[ 'modula' ] = array(
			'label'  => __( 'Modula plugin' ),
			'fields' => apply_filters( 'modula_debug_information', array(
					'core_version'             => array(
						'label' => __( 'Core Version', 'modula-best-grid-gallery' ),
						'value' => MODULA_LITE_VERSION,
						'debug' => 'Core version ' . MODULA_LITE_VERSION,
					),
					'requested_php'            => array(
						'label' => __( 'Minimum PHP' ),
						'value' => 5.6,
						'debug' => ( (float)5.6 > (float)phpversion() ) ? 'PHP minimum version not met' : 'PHP minimum version met',
					),
					'requested_wp'             => array(
						'label' => __( 'Minimum WP', 'modula-best-grid-gallery' ),
						'value' => 5.2,
						'debug' => ( (float)get_bloginfo( 'version' ) < (float)5.2 ) ? 'WordPress minimum version not met.Current version: ' . get_bloginfo( 'version' ) : 'Wordpress minimum version met. Current version: ' . get_bloginfo( 'version' ),
					),
					'galleries_number'         => array(
						'label' => __( 'Total galleries', 'modula-best-grid-gallery' ),
						'value' => count( Modula_Helper::get_galleries() ) - 1,
						'debug' => 'Total number of galleries: ' . ( count( Modula_Helper::get_galleries() ) - 1 )
					),
					'track_data'               => array(
						'label' => __( 'Track data', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'track_data' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'track_data' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? 'Track data enabled' : 'Track data disabled'
					),
					'enqueue_files'            => array(
						'label' => __( 'Enqueue Modula\'s assets everywhere', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? 'Enqueue files everywhere' : 'Enqueue files disabled'
					),
					'grid_type'                => array(
						'label' => __( 'General grid type enqueued', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'gridtypes' ] ) && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && !empty( $troubleshoot_opt[ 'gridtypes' ] ) ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'gridtypes' ] ) && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && !empty( $troubleshoot_opt[ 'gridtypes' ] ) ) ? 'Enqueue files for: ' . $grid_type : 'No grid type selected'
					),
					'lightboxes'               => array(
						'label' => __( 'Lightboxes everywhere', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lightboxes' ] ) && !empty( $troubleshoot_opt[ 'lightboxes' ] ) ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lightboxes' ] ) && !empty( $troubleshoot_opt[ 'lightboxes' ] ) ) ? 'Enqueue files for: ' . $lightboxes : 'No lightbox selected'
					),
					'modula_lazyload'          => array(
						'label' => __( 'Enable general lazyload', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lazy_load' ] ) && '1' == $troubleshoot_opt[ 'lazy_load' ] ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lazy_load' ] ) && '1' == $troubleshoot_opt[ 'lazy_load' ] ) ? 'General lazyload enabled: ' : 'No general lazyload'
					),
					'modula_edit_gallery_link' => array(
						'label' => __( '"Edit gallery" link', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'disable_edit' ] ) && '1' == $troubleshoot_opt[ 'disable_edit' ] ) ? __( 'Disabled', 'modula-best-grid-gallery' ) : __( 'Enabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'disable_edit' ] ) && '1' == $troubleshoot_opt[ 'disable_edit' ] ) ? 'Edit gallery link disabled: ' : 'Edit gallery link enabled'
					),
				)
			)
		);

		return $info;
	}
}

$modula_Debug = Modula_Debug::get_instance();