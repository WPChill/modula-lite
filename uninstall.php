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
    delete_option('modula_troubleshooting_option');
    delete_option('modula-checks');
    delete_option('modula_version');
}

// Delete transients
if ('1' == $uninstall_option['delete_transients']) {
    delete_transient('modula_all_extensions');
    delete_transient('modula-galleries');
    delete_transient('modula_pro_licensed_extensions');
}

// Delete custom post type
if ('1' == $uninstall_option['delete_cpt']) {
    global $wpdb;

    $galleries = get_posts(array('post_type'=>'modula-gallery','posts_per_page' => -1));
    $id_in     = '(';
    $i         = 1;

    foreach ($galleries as $gallery) {
        $id_in .= '\'' . $gallery->ID . '\'';
        if ($i < count($galleries)) {
            $id_in .= ',';
        }
        $i++;
    }

    $id_in .= ')';

    $sql = $wpdb->prepare("DELETE FROM  $wpdb->posts WHERE ID IN $id_in");
    $sql_meta = $wpdb->prepare("DELETE FROM  $wpdb->postmeta WHERE post_id IN $id_in");
    $wpdb->query($sql);
    $wpdb->query($sql_meta);
}
