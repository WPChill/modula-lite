<?php
/**
 * Uninstall procedure.
 *
 * @since 2.1.7
 */

if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();

$uninstall_option = get_option('modula_uninstall_option');
/**
 * Leave no trace.
 */
// Delete options
if ('1' == $uninstall_option['delete_options']) {
    // filter for options to be added by Modula's add-ons
    $options_array = apply_filters('modula_uninstall_options',array('modula_uninstall_option','modula_troubleshooting_option','modula-checks','modula_version','widget_modula_gallery_widget'));

    foreach($options_array as $db_option){
        delete_option($db_option);
    }

}

// Delete transients
if ('1' == $uninstall_option['delete_transients']) {
    // filter for transients to be added by Modula's add-ons
    $transients_array = apply_filters('modula_uninstall_transients',array('modula_all_extensions','modula-galleries','modula_pro_licensed_extensions'));

    foreach($transients_array as $db_transient){
        delete_transient($db_transient);
    }
  
}

// Delete custom post type
if ('1' == $uninstall_option['delete_cpt']) {
    global $wpdb;

    // filter for post types, mainly for Modula Albums
    $post_types = apply_filters('modula_uninstall_post_types',array('modula-gallery'));
    $galleries = get_posts( array ( 'post_type' => $post_types , 'posts_per_page' => -1 ) );
    $id_in     = '(';
    $i         = 1;

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
