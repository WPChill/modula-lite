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
    delete_option('modula_uninstall_option');
    delete_option('modula-checks');
    delete_option('modula_version');
}

// Delete transients
if('1' == $uninstall_option['delete_transients']){
    delete_transient('modula_all_extensions');
    delete_transient('modula-galleries');
    delete_transient('modula_pro_licensed_extensions');
}

// Delete custom post type
if('1' == $uninstall_option['delete_cpt']){
    global $wpdb;
    $sql = 'DELETE * FROM ' . $wpdb->prefix . '_posts WHERE `post_type` = "modula-gallery"';
    $wpdb->query($sql);
}
