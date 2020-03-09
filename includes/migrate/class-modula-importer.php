<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
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
        add_filter('modula_admin_page_tabs', array($this, 'add_importer_tab'));

       // Render Importer tab
        add_action('modula_admin_tab_importer', array($this, 'render_importer_tab'));

        // Include required scripts for import
        add_action('admin_enqueue_scripts', array($this, 'admin_importer_scripts'));

        add_action('admin_menu',array($this,'migrator_menu'));

        // Required files
        require_once MODULA_PATH . 'includes/migrate/nextgen/class-modula-nextgen-importer.php';
        require_once MODULA_PATH . 'includes/migrate/envira/class-modula-envira-importer.php';
        require_once MODULA_PATH . 'includes/migrate/final-tiles/class-modula-final-tiles-importer.php';
        require_once MODULA_PATH . 'includes/migrate/photoblocks/class-modula-photoblocks-importer.php';
        require_once MODULA_PATH . 'includes/migrate/wp-core-gallery/class-modula-wp-core-gallery-importer.php';

        // Load the plugin.
        $this->init();

    }

    /**
     * Add sub-menu entry for Migrate
     */
    public function migrator_menu() {
        add_submenu_page( 'edit.php?post_type=modula-gallery', esc_html__( 'Migrate', 'modula-best-grid-gallery' ), esc_html__( 'Migrate', 'modula-best-grid-gallery' ), 'manage_options', 'edit.php?post_type=modula-gallery&page=modula&modula-tab=importer' );
    }


    /**
     * Loads the plugin into WordPress.
     *
     * @since 2.2.7
     */
    public function init() {

        // Load admin only components.
        if (is_admin()) {
            add_filter('modula_uninstall_db_options',array($this,'uninstall_options'),16,1);
            add_action('wp_ajax_modula_importer_get_galleries',array($this,'get_source_galleries'));
        }

    }


    /**
     * Enqueue import script
     *
     * @since 2.2.7
     */
    public function admin_importer_scripts() {

        $screen = get_current_screen();

        // only enqueue script if we are in Modula Settings page
        if ('modula-gallery' == $screen->post_type && 'modula-gallery_page_modula' == $screen->base ) {

            $ajax_url      = admin_url('admin-ajax.php');
            $nonce         = wp_create_nonce('modula-importer');
            $empty_gallery = esc_html__('Please choose at least one gallery to migrate.', 'modula-best-grid-gallery');

            wp_enqueue_style('modula-importer', MODULA_URL . 'assets/css/modula-importer.css', array(), MODULA_LITE_VERSION);
            wp_enqueue_script('modula-importer', MODULA_URL . 'assets/js/modula-importer.js', array('jquery'), MODULA_LITE_VERSION, true);
            wp_localize_script(
                'modula-importer',
                'modula_importer',
                array(
                    'ajax'                    => $ajax_url,
                    'nonce'                   => $nonce,
                    'importing'               => '<span style="color:green">' . esc_html__(' Migration started...', 'modula-best-grid-gallery') . '</span>',
                    'empty_gallery_selection' => $empty_gallery,
                )
            );
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
    public function add_importer_tab($tabs) {
        $tabs['importer'] = array(
            'label'    => esc_html__('Migrate galleries', 'modula-best-grid-gallery'),
            'priority' => 50,
        );

        return $tabs;
    }


    /**
     * Render Importer tab
     *
     * @since 2.2.7
     */
    public function render_importer_tab() {
        include 'tabs/modula-importer-tab.php';
    }


    /**
     * Add migrate DB options to uninstall
     *
     * @param $options_array
     * @return mixed
     *
     * @since 2.2.7
     */
    public function uninstall_options($options_array){
        array_push($options_array,'modula_importer');

        return $options_array;
    }

    /**
     * Get gallery sources
     *
     * @return mixed
     *
     * @since 2.2.7
     */
    public function get_sources() {

        global $wpdb;
        $sources = array();

        // Assume they are none
        $envira       = false;
        $nextgen      = false;
        $final_tiles  = false;
        $photoblolcks = false;
        $wp_core      = false;

        $envira = $wpdb->get_results(" SELECT COUNT(ID) FROM " . $wpdb->prefix . "posts WHERE post_type ='envira'");

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "ngg_gallery'")) {
            $nextgen = $wpdb->get_results(" SELECT COUNT(gid) FROM " . $wpdb->prefix . "ngg_gallery");
        }

        // Seems like on some servers tables are saved lowercase
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "finaltiles_gallery'")) {
            $final_tiles = $wpdb->get_results(" SELECT COUNT(Id) FROM " . $wpdb->prefix . "finaltiles_gallery");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "FinalTiles_gallery'")) {
            $final_tiles = $wpdb->get_results(" SELECT COUNT(Id) FROM " . $wpdb->prefix . "FinalTiles_gallery");
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "photoblocks'")) {
            $photoblolcks = $wpdb->get_results(" SELECT COUNT(id) FROM " . $wpdb->prefix . "photoblocks");
        }

        $sql     = "SELECT COUNT(ID) FROM " . $wpdb->prefix . "posts WHERE `post_content` LIKE '%[galler%' AND `post_status` = 'publish'";
        $wp_core = $wpdb->get_results($sql);

        // Need to get this so we can handle the object to check if mysql returned 0
        $envira_return = (NULL != $envira) ? get_object_vars($envira[0]) : false;
        $nextgen_return = (NULL != $nextgen) ? get_object_vars($nextgen[0]) : false;
        $final_tiles_return = (NULL != $final_tiles) ? get_object_vars($final_tiles[0]) : false;
        $photoblocks_return = (NULL != $photoblolcks) ? get_object_vars($photoblolcks[0]) : false;
        $wp_core_return = (NULL != $wp_core) ? get_object_vars($wp_core[0]) : false;

        // Check to see if there are any entries and insert into array
        if ($envira && NULL != $envira && !empty($envira) && $envira_return  && '0' != $envira_return['COUNT(ID)']) {
            $sources['envira'] = 'Envira Gallery';
        }
        if ($nextgen && NULL != $nextgen && !empty($nextgen) && $nextgen_return && '0' != $nextgen_return['COUNT(gid)']) {
            $sources['nextgen'] = 'NextGEN Gallery';
        }
        if ($final_tiles && NULL != $final_tiles && !empty($final_tiles) && $final_tiles_return && '0' != $final_tiles_return['COUNT(Id)']) {
            $sources['final_tiles'] = 'Final Tiles Gallery';
        }
        if ($photoblolcks && NULL != $photoblolcks && !empty($photoblolcks) && $photoblocks_return && '0' != $photoblocks_return['COUNT(id)']) {
            $sources['photoblocks'] = 'PhotoBlocks';
        }
        if ($wp_core && NULL != $wp_core && !empty($wp_core) && $wp_core_return && '0' != $wp_core_return['COUNT(ID)'] ) {
            $sources['wp_core'] = 'WP Core Galleries';
        }

        if (!empty($sources)) {
            return $sources;
        }

        return false;
    }


    /**
     * Get galleries for sources
     *
     * @since 2.2.7
     */
    public function get_source_galleries() {

        check_ajax_referer('modula-importer', 'nonce');
        $source = isset($_POST['source']) ? $_POST['source'] : false;

        if (!$source || 'none' == $source) {
            echo esc_html__('There is no source selected', 'modula-best-grid-gallery');
            wp_die();
        }

        $import_settings = get_option('modula_importer');
        $import_settings = wp_parse_args($import_settings, array('galleries' => array()));
        $galleries       = array();
        $html            = '';

        switch ($source) {
            case 'envira' :
                $gal_source = Modula_Envira_Importer::get_instance();
                $galleries  = $gal_source->get_galleries();
                break;
            case 'nextgen':
                $gal_source = Modula_Nextgen_Importer::get_instance();
                $galleries  = $gal_source->get_galleries();
                break;
            case 'final_tiles' :
                $gal_source = Modula_Final_Tiles_Importer::get_instance();
                $galleries  = $gal_source->get_galleries();
                break;
            case 'photoblocks':
                $gal_source = Modula_Photoblocks_Importer::get_instance();
                $galleries  = $gal_source->get_galleries();
                break;
            case 'wp_core':
                $gal_source = Modula_WP_Core_Gallery_Importer::get_instance();
                $galleries  = $gal_source->get_galleries();
                break;
        }


        // Although this isn't necessary, sources have been checked before in tab
        // it is best if we do another check, just to be sure.
        if (!isset($galleries['valid_galleries']) && isset($galleries['empty_galleries']) && count($galleries['empty_galleries']) > 0) {
            printf(esc_html__('While we’ve found %s gallery(ies) we could import , we were unable to find any images associated with it(them). There’s no content for us to import .','modula-best-grid-gallery'),count($galleries['empty_galleries']));
            wp_die();
        }

        foreach ($galleries['valid_galleries'] as $key => $gallery) {
            $imported = false;
            switch ( $source ) {
                case 'envira':
                    $id             = $gallery->ID;
                    $modula_gallery = get_post_type( $import_settings['galleries'][ $source ][ $id ] );

                    if ( isset( $import_settings['galleries'][$source] ) && 'modula-gallery' == $modula_gallery ) {
                        $imported = true;
                    }

                    $title = '<a href="' . admin_url( '/post.php?post=' . $gallery->ID . '&action=edit' ) . '" target="_blank">' . esc_html( $gallery->post_title ) . '</a>';
                    $count = $gal_source->images_count( $gallery->ID );
                    break;
                case 'final_tiles' :
                    $id             = $gallery->Id;
                    $modula_gallery = get_post_type( $import_settings['galleries'][ $source ][ $id ] );
                    if ( isset( $import_settings['galleries'][$source] ) && 'modula-gallery' == $modula_gallery ) {
                        $imported = true;
                    }

                    $ftg_config = json_decode( $gallery->configuration );
                    $title      = '<a href="' . admin_url( 'admin.php?page=ftg-lite-gallery-admin&id=' . $gallery->Id ) . '" target="_blank"> ' . esc_html( $ftg_config->name ) . '</a>';
                    $count      = $gal_source->images_count( $gallery->Id );
                    break;
                case 'nextgen':
                    $id             = $gallery->gid;
                    $modula_gallery = get_post_type( $import_settings['galleries'][ $source ][ $id ] );
                    if ( isset( $import_settings['galleries'][$source] ) && 'modula-gallery' == $modula_gallery ) {
                        $imported = true;
                    }
                    $title = '<a href="' . wp_nonce_url( admin_url( 'admin.php?page=nggallery-manage-gallery&amp;mode=edit&amp;gid=' . $gallery->gid ) ) . '" target="_blank">' . esc_html( $gallery->title ) . '</a>';
                    $count = $gal_source->images_count( $gallery->gid );
                    break;
                case
                'photoblocks':
                    $id             = $gallery->id;
                    $modula_gallery = get_post_type( $import_settings['galleries'][ $source ][ $id ] );
                    if ( isset( $import_settings['galleries'][$source] ) && 'modula-gallery' == $modula_gallery ) {
                        $imported = true;
                    }
                    $title = '<a href="' . admin_url( 'admin.php?page=photoblocks-edit&id=' . $gallery->id ) . '" target="_blank"> ' . esc_html( $gallery->name ) . '</a>';
                    $count = $gal_source->images_count( $gallery->id );
                    break;
                case 'wp_core':
                    $id    = $gallery['page_id'] . '-' . $gallery['gal_nr'];
                    $value = json_encode( array( 'id' => $gallery['page_id'], 'shortcode' => $gallery['shortcode'] ) );
                    $title = '<a href="' . admin_url( '/post.php?post=' . absint( $gallery['page_id'] ) . '&action=edit' ) . '" target="_blank">' . esc_html( $gallery['title'] ) . '</a>';
                    $count = $gallery['images'];
                    break;
                default:
                    $id             = $gallery->ID;
                    $modula_gallery = get_post_type( $import_settings['galleries'][ $source ][ $id ] );

                    if ( isset( $import_settings['galleries'][ $source ] ) && 'modula-gallery' == $modula_gallery ) {
                        $imported = true;
                    }
                    $title = $gallery->post_title;

            }

            // Small fix for wp_core galleries
            $val = ($value) ? $value : $id;

            $html .= '<div class="modula-importer-checkbox-wrapper">' .
                     '<label for="' . esc_attr( $source ) . '-galleries-' . esc_attr( $id ) . '"' .
                     ' data-id="' . esc_attr( $id ) . '" ' . ( $imported ? ' class="imported"' : '' ) . '>' .
                     '<input type="checkbox" name="gallery"' .
                     ' id="' . esc_attr( $source ) . '-galleries-' . esc_attr( $id ) . '"' .
                     ' data-id="'.esc_attr($id).'" value="' . esc_attr( $val ) . '"/>';
           // Title is escaped above
            $html .= $title ;



            if(20 < $count){
                $lite = '<div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span><div class="tab-header-description modula-tooltip-content">';
                $lite .= esc_html__('You currently have ','modula-best-grid-gallery');
                $lite .= absint($count);
                $lite .= esc_html__(' images in your gallery and only 20 will be imported. If you want to import al, please buy the PRO version and import them after that. ','modula-best-grid-gallery');
                $lite .= '</div></div>';
            }

            // Display text on LITE. On PRO version
            $lite = apply_filters( 'modula_lite_migration_text', $lite );
            $html .= $lite;

            $html .= '<span class="modula-importer-gallery-status">';

            if ( $imported ) {
                $html .= '<i class="imported-check dashicons dashicons-yes"></i>';
            }

            $html .= '</span></label></div>';

        }

        echo $html;
        wp_die();
    }


    /**
     * Prepare gallery images
     *
     *
     * @param $source
     * @param $data
     * @return 0|array|bool|mixed|object|null
     *
     * @since 2.2.7
     */
    public function prepare_images($source,$data){

        global $wpdb;
        $images = array();
        $limit = '20';
        $limit = (int)apply_filters('modula_importer_migrate_limit',$limit);

        switch ($source){
            case 'envira':
                $images = get_post_meta($data, '_eg_gallery_data', true);
                $images = array_slice($images['gallery'],0,$limit,true);
                break;
            case 'nextgen':
                // Get images from NextGEN Gallery
                $sql = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "ngg_pictures
    						WHERE galleryid = %d
    						ORDER BY sortorder ASC,
    						imagedate ASC",
                    $data);

                $images = $wpdb->get_results($sql);
                $images = array_slice($images,0,$limit,true);
                break;
            case 'final_tiles':
                // Seems like on some servers tables are saved lowercase
                if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "finaltiles_gallery'")) {
                    // Get images from Final Tiles
                    $sql    = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "finaltiles_gallery_images
    						WHERE gid = %d
    						ORDER BY 'setOrder' ASC",
                        $data);
                    $images = $wpdb->get_results($sql);
                    $images = array_slice($images,0,$limit,true);
                }

                if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "FinalTiles_gallery'")) {
                    // Get images from Final Tiles
                    $sql    = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "FinalTiles_gallery_images
    						WHERE gid = %d
    						ORDER BY 'setOrder' ASC",
                        $data);
                    $images = $wpdb->get_results($sql);
                    $images = array_slice($images,0,$limit,true);
                }
                break;
            case 'photoblocks':
                // Get gallery
                $sql     = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "photoblocks
    						WHERE id = %d LIMIT 1",
                    $data);
                $gallery = $wpdb->get_row($sql);
                $blocks = json_decode($gallery->blocks);
                $blocks = array_slice($blocks,0,$limit,true);
                $gallery->blocks = json_encode($blocks);
                $images = $gallery;
                break;
            case 'wp_core':
                $images         = explode(',', $data);
                $images = array_slice($images,0,$limit,true);
                break;

        }

        if($images){
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

        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Importer)) {
            self::$instance = new Modula_Importer();
        }

        return self::$instance;
    }
}

$modula_importer = Modula_Importer::get_instance();