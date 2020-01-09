<?php

class Modula_Uninstall {

    function __construct() {

        // Deactivation
        add_filter( 'plugin_action_links_' . MODULA_FILE , array (
            $this ,
            'filter_action_links'
        ) );
        add_action( 'admin_footer-plugins.php' , array ( $this , 'goodbye_ajax' ) , 16 );
        add_action( 'wp_ajax_modula_uninstall_plugin' , array ( $this , 'modula_uninstall_plugin' ) );
    }

    /**
     * @param $links
     *
     * @return array
     *
     * Set uninstall link
     */
    public function filter_action_links( $links ) {

        $links = array_merge( $links , array (
            '<a onclick="javascript:event.preventDefault();" id="modula-uninstall-link"  class="uninstall-modula" href="#">' . __( 'Uninstall' , 'modula-best-grid-gallery' ) . '</a>'
        ) );

        return $links;
    }

    /**
     * Form text strings
     * These can be filtered
     * @since 1.0.0
     */
    public function goodbye_ajax() {

        // Get our strings for the form
        $form = $this->get_form_info();

        // Build the HTML to go in the form
        $html = '<div class="epsilon-uninstall-form-head"><strong>' . esc_html( $form['heading'] ) . '</strong></div>';
        $html .= '<div class="epsilon-uninstall-form-body"><p>' . esc_html( $form['body'] ) . '</p>';

        if ( is_array( $form['options'] ) ) {

            $html .= '<div class="epsilon-uninstall-options"><p>';
            foreach ( $form['options'] as $key => $option ) {

                $html .= '<input type="checkbox" name="' . esc_attr( $key ) . ' " id="' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '"> <label for="' . esc_attr( $key ) . '">' . esc_attr( $option ) . '</label><br>';
            }

            $html .= '</div><!-- .epsilon-uninstall-options -->';
        }
        $html .= '</div><!-- .epsilon-uninstall-form-body -->';
        $html .= '<p class="deactivating-spinner"><span class="spinner"></span> ' . __( 'Submitting form' , 'colorlib-404-customizer' ) . '</p>';
        $html .= '<div class="uninstall"><p><a id="epsilon-uninstall-submit-form" class="button button-primary" href="#">' . __( 'Uninstall' , 'colorlib-404-customizer' ) . '</a></p></div>'
        ?>
        <div class="epsilon-uninstall-form-bg"></div>
        <div class="epsilon-uninstall-form-wrapper"><span class="epsilon-uninstall-form"
                                                          id="epsilon-uninstall-form"></span></div>
        <style type="text/css">
            .epsilon-uninstall-form-active .epsilon-uninstall-form-bg {
                background: rgba(0, 0, 0, .5);
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .epsilon-uninstall-form-wrapper {
                position: fixed;
                z-index: 999;
                display: none;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                margin: 0 auto;
            }

            .epsilon-uninstall-form-wrapper .uninstall {
                text-align: center;
            }

            .epsilon-uninstall-form-active .epsilon-uninstall-form-wrapper {
                display: block;
                z-index: 999;
            }

            .epsilon-uninstall-form {
                display: none;
            }

            .epsilon-uninstall-form-active .epsilon-uninstall-form {
                position: absolute;
                bottom: 30px;
                left: 0;
                right: 0;
                margin: 0 auto;
                top: 50%;
                transform: translateY(-50%);
                max-width: 400px;
                background: #fff;
                white-space: normal;
            }

            .epsilon-uninstall-form-head {
                background: #774cce;
                color: #fff;
                padding: 8px 18px;
            }

            .epsilon-uninstall-form-body {
                padding: 8px 18px;
                color: #444;
            }

            .deactivating-spinner {
                display: none;
            }

            .deactivating-spinner .spinner {
                float: none;
                margin: 4px 4px 0 18px;
                vertical-align: bottom;
                visibility: visible;
            }

            .epsilon-uninstall-form-footer {
                padding: 8px 18px;
            }

            .epsilon-uninstall-form-footer p {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .epsilon-uninstall-form.process-response .epsilon-uninstall-form-body,
            .epsilon-uninstall-form.process-response .epsilon-uninstall-form-footer {
                position: relative;
            }

            .epsilon-uninstall-form.process-response .epsilon-uninstall-form-body:after,
            .epsilon-uninstall-form.process-response .epsilon-uninstall-form-footer:after {
                content: "";
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, .5);
            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var uninstall = $("a.uninstall-modula"),
                    formContainer = $('#epsilon-uninstall-form');

                $(uninstall).on("click", function () {

                    var url = uninstall.attr('href');
                    $('body').toggleClass('epsilon-uninstall-form-active');
                    formContainer.fadeIn();
                    formContainer.html('<?php echo $html; ?>');

                    formContainer.on('click', '#epsilon-uninstall-submit-form', function (e) {
                        var selectedOptions = {
                            delete_options: ($('#delete_options').is(':checked')) ? 1 : 0,
                            delete_transients: ($('#delete_transients').is(':checked')) ? 1 : 0,
                            delete_cpt: ($('#delete_cpt').is(':checked')) ? 1 : 0,
                            delete_old_tables: ($('#delete_old_tables').is(':checked')) ? 1 : 0
                        };

                        var data = {
                            'action': 'modula_uninstall_plugin',
                            'security': "<?php echo wp_create_nonce( 'modula_uninstall_plugin' ); ?>",
                            'dataType': "json",
                            'options': selectedOptions
                        };

                        $.post(
                            ajaxurl,
                            data,
                            function (response) {
                                // Redirect to plugins page
                                window.location.href = '<?php echo admin_url( '/plugins.php' ); ?>';
                            }
                        );
                    });

                    formContainer.on('click', '#epsilon-uninstall-plugin', function (e) {
                        e.preventDefault();
                        window.location.href = url;
                    });

                    // If we click outside the form, the form will close
                    $('.epsilon-uninstall-form-bg').on('click', function () {
                        formContainer.fadeOut();
                        $('body').removeClass('epsilon-uninstall-form-active');
                    });
                });
            });
        </script>
    <?php }

    /*
     * Form text strings
     * These are non-filterable and used as fallback in case filtered strings aren't set correctly
     * @since 1.0.0
     */
    public function get_form_info() {
        $form            = array ();
        $form['heading'] = esc_html__( 'Sorry to see you go' , 'modula-best-grid-gallery' );
        $form['body']    = esc_html__( 'Please select below what you want to be deleted from the DataBase.' , 'modula-best-grid-gallery' );
        $form['options'] = array (
            'delete_options'    => esc_html__( 'Delete Modula options' , 'modula-best-grid-gallery' ) ,
            'delete_transients' => esc_html__( 'Delete Modula set transients' , 'modula-best-grid-gallery' ) ,
            'delete_cpt'        => esc_html__( 'Delete modula-gallery custom post type' , 'modula-best-grid-gallery' ) ,
            'delete_old_tables' => esc_html__( 'Delete old tables set by Modula Gallery plugin versions 1.x ' , 'modula-best-grid-gallery' ) ,
        );

        return $form;
    }

    public function modula_uninstall_plugin() {

        global $wpdb;
        check_ajax_referer( 'modula_uninstall_plugin' , 'security' );

        $uninstall_option = $_POST['options'];

        // Delete options
        if ( '1' == $uninstall_option['delete_options'] ) {
            // filter for options to be added by Modula's add-ons
            $options_array = apply_filters( 'modula_uninstall_options' , array ( 'modula_uninstall_option' , 'modula_troubleshooting_option' , 'modula-checks' , 'modula_version' , 'widget_modula_gallery_widget' , 'modula-rate-time' ) );

            foreach ( $options_array as $db_option ) {
                delete_option( $db_option );
            }

        }

        // Delete transients
        if ( '1' == $uninstall_option['delete_transients'] ) {
            // filter for transients to be added by Modula's add-ons
            $transients_array = apply_filters( 'modula_uninstall_transients' , array ( 'modula_all_extensions' , 'modula-galleries' , 'modula_pro_licensed_extensions' ) );

            foreach ( $transients_array as $db_transient ) {
                delete_transient( $db_transient );
            }

        }

        // Delete custom post type
        if ( '1' == $uninstall_option['delete_cpt'] ) {

            // filter for post types, mainly for Modula Albums
            $post_types = apply_filters( 'modula_uninstall_post_types' , array ( 'modula-gallery' ) );
            $galleries  = get_posts( array ( 'post_type' => $post_types , 'posts_per_page' => -1 ) );
            $id_in      = '(';
            $i          = 1;

            if ( is_array( $galleries ) && ! empty( $galleries ) ) {

                foreach ( $galleries as $gallery ) {
                    $id_in .= '\'' . $gallery->ID . '\'';
                    if ( $i < count( $galleries ) ) {
                        $id_in .= ',';
                    }
                    $i++;
                }

                $id_in .= ')';

                $sql      = $wpdb->prepare( "DELETE FROM  $wpdb->posts WHERE ID IN $id_in" );
                $sql_meta = $wpdb->prepare( "DELETE FROM  $wpdb->postmeta WHERE post_id IN $id_in" );
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

        echo 'Uninstalled';
        deactivate_plugins( 'modula-lite/Modula.php' );
        wp_die();
    }

}

$modula_uninstall = new Modula_Uninstall();