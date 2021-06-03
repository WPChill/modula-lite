<?php

class Modula_Uninstall {

    /**
     * @since 2.2.4
     * Modula_Uninstall constructor.
     *
     */
    function __construct() {

        // Deactivation
        add_filter( 'plugin_action_links_' . MODULA_FILE , array (
            $this ,
            'filter_action_links'
        ) );
        add_action( 'admin_footer-plugins.php' , array ( $this , 'add_uninstall_form' ) , 16 );
        add_action( 'wp_ajax_modula_uninstall_plugin' , array ( $this , 'modula_uninstall_plugin' ) );
        add_action('admin_enqueue_scripts',array($this,'uninstall_scripts'));
    }

    /**
     * Enqueue uninstall scripts
     *
     * @since 2.2.5
     */
    public function uninstall_scripts(){

        $current_screen = get_current_screen();
	    if ( in_array( $current_screen->base, array( 'plugins', 'plugins-network' ) ) ) {
            wp_enqueue_style( 'modula-uninstall', MODULA_URL . 'assets/css/admin/uninstall.css' );
            wp_enqueue_script( 'modula-uninstall', MODULA_URL . 'assets/js/admin/modula-uninstall.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
            wp_localize_script( 'modula-uninstall', 'wpModulaUninstall', array(
                'redirect_url' => admin_url( '/plugins.php' ),
                'nonce'        => wp_create_nonce( 'modula_uninstall_plugin' )
            ) );
        }
    }

    /**
     * @param $links
     *
     * @return array
     *
     * @since 2.2.4
     * Set uninstall link
     */
    public function filter_action_links( $links ) {

        $links = array_merge( $links , array (
            '<a onclick="javascript:event.preventDefault();" id="modula-uninstall-link"  class="uninstall-modula" href="#">' . esc_html__( 'Uninstall' , 'modula-best-grid-gallery' ) . '</a>'
        ) );

        return $links;
    }

    /**
     * Form text strings
     * These can be filtered
     * @since 2.2.4
     */
    public function add_uninstall_form() {

        // Get our strings for the form
        $form = $this->get_form_info();

        ?>
        <div class="modula-uninstall-form-bg">
        </div>
        <div class="modula-uninstall-form-wrapper">
            <span class="modula-uninstall-form" id="modula-uninstall-form">
                <div class="modula-uninstall-form-head">
                    <h3><strong><?php echo esc_html( $form['heading'] ); ?></strong></h3>
                    <i class="close-uninstall-form">X</i>
                </div>
        <div class="modula-uninstall-form-body"><p><?php echo wp_kses_post( $form['body'] ); ?></p>

        <?php
        if ( is_array( $form['options'] ) ) {
            ?>
            <div class="modula-uninstall-options">
                <?php
                foreach ( $form['options'] as $key => $option ) {

                    $before_input = '';
                    $after_input  = '';
                    if ( 'delete_all' == $key ) {
                        $before_input = '<strong class="modula-red-text">';
                        $after_input  = '</strong>';
                    }

                    echo ' <p><input type="checkbox" name="' . esc_attr( $key ) . ' " id="' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '"> <label for="' . esc_attr( $key ) . '">' . $before_input . esc_attr( $option['label'] ) . $after_input . '</label><p class="description">' . esc_html( $option['description'] ) . '</p><br>';
                }
                ?>
            </div><!-- .modula-uninstall-options -->
        <?php } ?>
        </div><!-- .modula-uninstall-form-body -->
        <p class="deactivating-spinner"><span
                    class="spinner"></span><?php echo esc_html__( 'Cleaning...', 'modula-best-grid-gallery' ); ?></p>
        <div class="uninstall">
            <p>
                <a id="modula-uninstall-submit-form" class="button button-primary"
                   href="#"><?php echo esc_html__( 'Uninstall', 'modula-best-grid-gallery' ); ?></a>
            </p>
        </div>
            </span>
        </div>
    <?php }

    /*
     * Form text strings
     * These are non-filterable and used as fallback in case filtered strings aren't set correctly
     * @since 2.2.4
     */
    public function get_form_info() {
        $form            = array ();
        $form['heading'] = esc_html__( 'Sorry to see you go' , 'modula-best-grid-gallery' );
        $form['body']    = '<strong class="modula-red-text">' . esc_html__( ' Caution!! This action CANNOT be undone' , 'modula-best-grid-gallery' ) . '</strong>';
        $form['options'] = apply_filters( 'modula_uninstall_options' ,array(
            'delete_all'        => array(
                'label'       => esc_html__( 'Delete all data' , 'modula-best-grid-gallery' ) ,
                'description' => esc_html__( 'Select this to delete all data Modula plugin and it\'s add-ons have set in your database.' , 'modula-best-grid-gallery' )
            ) ,
            'delete_options'    => array(
                'label'       => esc_html__( 'Delete Modula options' , 'modula-best-grid-gallery' ) ,
                'description' => esc_html__( 'Delete options set by Modula plugin and it\'s add-ons  to options table in the database.' , 'modula-best-grid-gallery' )
            ) ,
            'delete_transients' => array (
                'label'       => esc_html__( 'Delete Modula set transients' , 'modula-best-grid-gallery' ) ,
                'description' => esc_html__( 'Delete transients set by Modula plugin and it\'s add-ons  to options table in the database.' , 'modula-best-grid-gallery' )
            ) ,
            'delete_cpt'        => array(
                'label'       => esc_html__( 'Delete modula-gallery custom post type' , 'modula-best-grid-gallery' ) ,
                'description' => esc_html__( 'Delete custom post types set by Modula plugin and it\'s add-ons in the database.' , 'modula-best-grid-gallery' )
            ) ,
            'delete_old_tables' => array(
                'label'       => esc_html__( 'Delete old tables set by Modula Gallery plugin versions 1.x ' , 'modula-best-grid-gallery' ) ,
                'description' => esc_html__( 'Delete old tables set by Modula Gallery plugin versions 1.x in the database.' , 'modula-best-grid-gallery' )
            )
        ) );

        return $form;
    }

    /**
     * @since 2.2.4
     * Modula Uninstall procedure
     */
    public function modula_uninstall_plugin() {

        global $wpdb;
        check_ajax_referer( 'modula_uninstall_plugin' , 'security' );

        $uninstall_option = isset($_POST['options']) ? $_POST['options'] : false;

        // Delete options
        if ( '1' == $uninstall_option['delete_options'] ) {
            // filter for options to be added by Modula's add-ons
            $options_array = apply_filters( 'modula_uninstall_db_options' , array ( 'modula_troubleshooting_option' , 'modula-checks' , 'modula_version' , 'widget_modula_gallery_widget' , 'modula-rate-time' ) );

            foreach ( $options_array as $db_option ) {
                delete_option( $db_option );
            }

        }

        // Delete transients
        if ( '1' == $uninstall_option['delete_transients'] ) {
            // filter for transients to be added by Modula's add-ons
            $transients_array = apply_filters( 'modula_uninstall_transients' , array ( 'modula_all_extensions' , 'modula-galleries' , 'modula_pro_licensed_extensions') );

            foreach ( $transients_array as $db_transient ) {
                delete_transient( $db_transient );
            }

        }

        // Delete custom post type
        if ( '1' == $uninstall_option['delete_cpt'] ) {

            // filter for post types, mainly for Modula Albums
            $post_types = apply_filters( 'modula_uninstall_post_types' , array ( 'modula-gallery' ) );
            $galleries  = get_posts( array( 'post_type' => $post_types , 'posts_per_page' => -1, 'fields' => 'ids' ) );


            if ( is_array( $galleries ) && ! empty( $galleries ) ) {

                $id_in = implode( ',', $galleries );

                $sql      = $wpdb->prepare( "DELETE FROM  $wpdb->posts WHERE ID IN ( $id_in )" );
                $sql_meta = $wpdb->prepare( "DELETE FROM  $wpdb->postmeta WHERE post_id IN ( $id_in )" );
                $wpdb->query( $sql );
                $wpdb->query( $sql_meta );
            }
        }

        // Delete old tables ( `prefix`_modula and `prefix`_modula_images ) from the DB
        if ( '1' == $uninstall_option['delete_old_tables'] ) {
            $modula_table        = $wpdb->prefix . "modula";
            $modula_images_table = $wpdb->prefix . "modula_images";

            $sql_modula_table        = $wpdb->prepare( "DROP TABLE IF EXISTS $modula_table" );
            $sql_modula_images_table = $wpdb->prepare( "DROP TABLE IF EXISTS $modula_images_table" );
            $wpdb->query( $sql_modula_table );
            $wpdb->query( $sql_modula_images_table );

        }

        do_action( 'modula_uninstall' );

        deactivate_plugins( MODULA_FILE );
        wp_die();
    }

}

$modula_uninstall = new Modula_Uninstall();