<?php
$issues = array(
    'fix'     => array(
        esc_html__( 'Importing Envira Galleries image size, custom dimensions and gutter.', 'modula-best-grid-gallery' ),
        esc_html__( 'Extensions menu entry always last.', 'modula-best-grid-gallery' ),
        esc_html__( 'Social icons are now disabled by default when creating a new gallery.', 'modula-best-grid-gallery' ),
        esc_html__( 'Some Settings UI updates.', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed JS error when trying to lazy load hidden items.', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed copy shortcode button going under text.', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed lazy load for columns.', 'modula-best-grid-gallery' ),
        esc_html__( 'Multiple translation fixes.', 'modula-best-grid-gallery' ),
    ),
    'feature' => array(
	    esc_html__( 'Added autosuggest URL to image URL field.', 'modula-best-grid-gallery' ),
	    esc_html__( 'Added share via Email.', 'modula-best-grid-gallery' ),
	    esc_html__( 'Added "Save gallery"/"Update gallery" shortcut CTRL/CMD + S', 'modula-best-grid-gallery' ),
	    esc_html__( 'Added functionality to migrate FooGallery plugin galleries.', 'modula-best-grid-gallery' ),
	    esc_html__( 'Preparing Modula for Modula Download, Modula Exif and Modula Zoom add-ons.', 'modula-best-grid-gallery' ),
    )
);
$issues = array();
?>
<div id="modula-about-page" class="row modula-about-row">
    <div class="modula-about__container">
        <div class="modula-about-header">
            <div class="modula-about-heading">
                <h1><?php esc_html_e( 'Modula', 'modula-best-grid-gallery' ) ?> <span><?php echo MODULA_LITE_VERSION; ?></span></h1>
            </div>
            <div class="modula-about__header-text">
                <p><?php esc_html_e('Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.','modula-best-grid-gallery'); ?></p>
            </div>
        </div>
        <div class="modula-about-content">

            <h2><?php printf(esc_html__('Version %s addressed small fixes.', 'modula-best-grid-gallery'), MODULA_LITE_VERSION ); ?></h2>
            <?php if (!empty($issues)) { ?>
            <ul class="modula-about-list">
                <?php
                foreach ($issues as $key => $iss) {
                    foreach ($iss as $is) {
                        echo "<li class='$key'>$is</li>";
                    }
                }
                ?>
            </ul>

            <?php } ?>
        </div>
    </div>
</div>
