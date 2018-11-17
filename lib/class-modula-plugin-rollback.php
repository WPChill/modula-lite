<?php

class Modula_Plugin_RollBack {

    public function __construct() {

        /**
         * $_POST action hook
         *
         * @see: https://codex.wordpress.org/Plugin_API/Action_Reference/admin_post_(action)
         *
         */
        add_action( 'admin_post_modula_rollback', array( $this, 'post_rollback' ) );

        /**
         * Hook responsible for loading our Rollback JS script
         */
        add_action( 'admin_enqueue_scripts', array( $this, 'rollback_scripts' ) );

    }

    /**
     * FBFW version rollback.
     *
     * Rollback to previous {plugin} version.
     *
     * Fired by `admin_post_epfw_rollback` action.
     *
     * @since  1.5.0
     * @access public
     */
    public function post_rollback() {

        check_admin_referer( 'modula_rollback' );

        $plugin_slug = basename( MODULA_FILE_, '.php' );

        // check for const defines
        if ( ! defined( 'MODULA_PREVIOUS_PLUGIN_VERSION' ) || ! defined( 'MODULA_PLUGIN_BASE' ) ) {
            wp_die(
                new WP_Error( 'broke', esc_html__( 'Previous plugin version or plugin basename CONST aren\'t defined.', 'epfw' ) )
            );
        }

        if ( class_exists( 'Modula_Rollback' ) ) {
            $rollback = new Modula_Rollback(
                array(
                    'version'     => MODULA_PREVIOUS_PLUGIN_VERSION,
                    'plugin_name' => MODULA_PLUGIN_BASE,
                    'plugin_slug' => $plugin_slug,
                    'package_url' => sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip', 'modula-best-grid-gallery', MODULA_PREVIOUS_PLUGIN_VERSION ),
                )
            );
            $rollback->run();
        }

        wp_die(
            '', __( 'Rollback to Previous Version', 'mfbfw' ), array(
                'response' => 200,
            )
        );
    }

    public function rollback_scripts() {
        wp_enqueue_script('rollback-script', MODULA_PLUGIN_DIR_URL . 'scripts/rollback.js', MODULA_VERSION ); // Load Rollback script
        wp_enqueue_script( 'rollback-script' );
    }

}

new Modula_Plugin_RollBack();
