<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$gallery_id = $settings->modula_gallery_select;
if ('none' != $gallery_id) {
    echo do_shortcode('[Modula id="' . $gallery_id . '"]');
} else {
    echo esc_html__( 'No gallery was selected', 'modula-best-grid-gallery' );
}
