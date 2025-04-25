<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Importer {

	/**
	 * Holds the class object.
	 *
	 * @since 2.2.7
	 *
	 * @var object
	 */
	public static $instance;

	/**
	* Primary class constructor.
	*
	* @since 2.2.7
	*/
	public function __construct() {

		// Add Importer Tab
		add_filter( 'modula_admin_page_main_tabs', array( $this, 'add_importer_tab' ) );

		// Required files
		require_once MODULA_PATH . 'includes/migrate/wp-core-gallery/class-modula-wp-core-gallery-importer.php';

		// Load the plugin.
		$this->init();
	}

	/**
	 * Loads the plugin into WordPress.
	 *
	 * @since 2.2.7
	 */
	public function init() {

		// Load admin only components.
		if ( is_admin() ) {
			add_filter( 'modula_uninstall_db_options', array( $this, 'uninstall_options' ), 16, 1 );
		}
	}

	/**
	 * Add Importer tab
	 *
	 * @param $tabs
	 * @return mixed
	 *
	 * @since 2.2.7
	 */
	public function add_importer_tab( $tabs ) {

		$sources = $this->get_sources();

		if ( empty( $sources ) ) {
			return $tabs;
		}

		$formatted_sources = array(
			array(
				'label' => esc_html__( 'Select gallery source', 'modula-best-grid-gallery' ),
				'value' => '',
			),
		);

		$galleries_fields = array();
		foreach ( $sources as $slug => $label ) {
			$formatted_sources[] = array(
				'label' => $label,
				'value' => $slug,
			);

			$gallery = $this->get_galleries_by_source( $slug );

			if ( ! $gallery['success'] ) {
				$galleries_fields[] = array(
					'type'       => 'paragraph',
					'label'      => esc_html__( 'Galleries to import', 'modula-best-grid-gallery' ),
					'value'      => $gallery['error'],
					'conditions' => array(
						array(
							'field'      => 'gallery_source',
							'comparison' => '===',
							'value'      => $slug,
						),
					),
				);
			}

			$galleries_fields[] = array(
				'type'       => 'checkbox_group',
				'name'       => 'galleries_to_import',
				'label'      => esc_html__( 'Galleries to import', 'modula-best-grid-gallery' ),
				'options'    => isset( $gallery['data'] ) ? $gallery['data'] : array(),
				'conditions' => array(
					array(
						'field'      => 'gallery_source',
						'comparison' => '===',
						'value'      => $slug,
					),
				),
				'nonce'      => wp_create_nonce( 'modula-importer' ),
			);
		}

		$config = array(
			'fields' => array(
				array(
					'type'    => 'select',
					'name'    => 'gallery_source',
					'label'   => esc_html__( 'Gallery source', 'modula-best-grid-gallery' ),
					'default' => '',
					'options' => $formatted_sources,
				),
				array(
					'type'        => 'toggle',
					'name'        => 'gallery_delete_source',
					'label'       => esc_html__( 'Gallery database entries', 'modula-best-grid-gallery' ),
					'default'     => false,
					'conditions'  => array(
						array(
							'field'      => 'gallery_source',
							'comparison' => '!==',
							'value'      => '',
						),
					),
					'description' => esc_html__( 'Delete old gallery entries.', 'modula-best-grid-gallery' ),
				),
			),
		);

		$config['fields'] = array_merge( $config['fields'], $galleries_fields );

		$tabs[] = array(
			'label'   => esc_html__( 'Migrate', 'modula-best-grid-gallery' ),
			'slug'    => 'migrate',
			'subtabs' => array(
				'migrate' => array(
					'label'  => esc_html__( 'Migrate', 'modula-best-grid-gallery' ),
					'config' => $config,
				),
			),
			'save'    => false,
		);

		return $tabs;
	}

	/**
	 * Add migrate DB options to uninstall
	 *
	 * @param $options_array
	 * @return mixed
	 *
	 * @since 2.2.7
	 */
	public function uninstall_options( $options_array ) {
		array_push( $options_array, 'modula_importer' );

		return $options_array;
	}

	/**
	 * Find gallery sources
	 *
	 * @return mixed
	 *
	 * @since 2.2.7
	 */
	public function get_sources() {

		global $wpdb;
		$sources = array();

		// Assume they are none
		$wp_core = false;

		$sql     = 'SELECT COUNT(ID) FROM ' . $wpdb->prefix . "posts WHERE `post_content` LIKE '%[galler%' AND `post_status` = 'publish'";
		$wp_core = $wpdb->get_results( $sql );

		// Need to get this so we can handle the object to check if mysql returned 0
		$wp_core_return = ( null != $wp_core ) ? get_object_vars( $wp_core[0] ) : false;

		// Check to see if there are any entries and insert into array
		if ( $wp_core && null != $wp_core && ! empty( $wp_core ) && $wp_core_return && '0' != $wp_core_return['COUNT(ID)'] ) {
			$sources['wp_core'] = 'WP Core Galleries';
		}

		$sources = apply_filters( 'modula_migrator_sources', $sources );

		if ( ! empty( $sources ) ) {
			return $sources;
		}

		return false;
	}

	public function get_galleries_by_source( $source = false ) {

		if ( ! $source || 'none' == $source ) {
				return array(
					'success' => false,
					'error'   => esc_html__( 'There is no source selected', 'modula-best-grid-gallery' ),
				);
		}

		$import_settings = get_option( 'modula_importer' );
		$import_settings = wp_parse_args( $import_settings, array( 'galleries' => array() ) );
		$galleries       = array();
		$html            = '';

		switch ( $source ) {
			case 'wp_core':
				$gal_source = Modula_WP_Core_Gallery_Importer::get_instance();
				$galleries  = $gal_source->get_galleries();
				break;
			default:
				$galleries = apply_filters( 'modula_source_galleries_' . $source, array() );
				break;
		}

		// Although this isn't necessary, sources have been checked before in tab
		// it is best if we do another check, just to be sure.
		if ( ! isset( $galleries['valid_galleries'] ) && isset( $galleries['empty_galleries'] ) && count( $galleries['empty_galleries'] ) > 0 ) {
			return array(
				'success' => false,
				'error'   => sprintf( esc_html__( 'While we\'ve found %s gallery(ies) we could import , we were unable to find any images associated with it(them). There\'s no content for us to import .', 'modula-best-grid-gallery' ), count( $galleries['empty_galleries'] ) ),
			);
		}

		$data = array();
		foreach ( $galleries['valid_galleries'] as $key => $gallery ) {
			$imported         = false;
			$importing_status = '';
			switch ( $source ) {
				case 'wp_core':
					$value     = wp_json_encode(
						array(
							'id'        => $gallery['page_id'],
							'shortcode' => $gallery['shortcode'],
						)
					);
					$g_gallery = array(
						'id'       => $gallery['page_id'] . '-' . $gallery['gal_nr'],
						'imported' => ( isset( $import_settings['galleries'][ $source ] ) && 'modula-gallery' === $modula_gallery ),
						'title'    => esc_html( $gallery['title'] ),
						'count'    => $gallery['images'],
					);
					break;
				default:
					$g_gallery = apply_filters( 'modula_g_gallery_' . $source, array(), $gallery, $import_settings );
					break;
			}

			$id  = absint( $g_gallery['id'] );
			$val = ( $value ) ? $value : $id;

			$data[] = array(
				'label' => wp_strip_all_tags( $g_gallery['title'] ),
				'value' => $val,
			);
		}

		return array(
			'success' => true,
			'data'    => $data,
		);
	}


	/**
	 * Prepare gallery images
	 *
	 *
	 * @param $source
	 * @param $data
	 *
	 * @return array|bool|object|void 0|array|bool|mixed|object|null
	 *
	 * @since 2.2.7
	 */
	public function prepare_images( $source, $data ) {

		global $wpdb;
		$images = array();

		switch ( $source ) {
			case 'wp_core':
				$images = explode( ',', $data );
				break;
			default:
				$images = apply_filters( 'modula_migrator_images_' . $source, array(), $data );
		}

		if ( $images && ! empty( $images ) ) {
			return $images;
		}

		return false;
	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Importer object.
	 *
	 * @since 2.2.7
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_Importer ) ) {
			self::$instance = new Modula_Importer();
		}

		return self::$instance;
	}
}

$modula_importer = Modula_Importer::get_instance();
