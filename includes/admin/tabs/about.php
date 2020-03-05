<?php
$issues = array(
    'fix'     => array(
        esc_html__( 'Fixed incompatibility with isotope.js', 'modula-best-grid-gallery' ),
        esc_html__( 'Renamed our registered files name', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed title/caption font size to reflect theme default', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed scroll to top when opening lightbox', 'modula-best-grid-gallery' ),
        esc_html__( 'If Title/Caption is hidden then hide settings also', 'modula-best-grid-gallery' ),
        esc_html__( 'Hide settings if toggle is OFF for custom responsiveness ', 'modula-best-grid-gallery' ),
    ),
    'feature' => array(
        esc_html__( 'Added Migrate functionality. Now it\'s easier to migrate from another gallery to Modula', 'modula-best-grid-gallery' ),
        esc_html__( 'Improved social media icons in preview', 'modula-best-grid-gallery' ),
        esc_html__( 'Delete resized images when deleting attachment', 'modula-best-grid-gallery' ),
        esc_html__( 'Added Import/Export sub-menu entry and tutorial', 'modula-best-grid-gallery' ),
    )
);
?>
<div class="row modula-about-row">
    <div class="about__container">
        <div class="about__header modula-about-header">
            <div class="about__header-title modula-about-heading">
                <h1><?php esc_html_e( 'Modula', 'modula-best-grid-gallery' ) ?><span><?php echo MODULA_LITE_VERSION; ?></span></h1>
            </div>
            <div class="about__header-badge"></div>
            <div class="about__header-text">
                <p><?php esc_html_e('Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.','modula-best-grid-gallery'); ?></p>
            </div>
        </div>
        <div class="modula-about-content">
            <?php if (!empty($issues)) { ?>

                <h2><?php printf(esc_html__('Version %s addressed %s bugs and added %s features', 'modula-best-grid-gallery'), MODULA_LITE_VERSION, count( $issues['fix'] ),count( $issues['feature'] ) ); ?></h2>
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
