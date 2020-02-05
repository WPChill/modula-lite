<?php
$issues = array(
    'feature' => array(
        esc_html__( 'Added Uninstall options to remove data entries from DB', 'modula-best-grid-gallery' ),
        esc_html__( 'Added troubleshooting options to enqueue CSS and JS files everywhere', 'modula-best-grid-gallery' ),
        esc_html__( 'Added support for WebP files', 'modula-best-grid-gallery' ),
        esc_html__( 'Added WhatsApp as social icon', 'modula-best-grid-gallery' ),
        esc_html__( 'Added numbers to hover effects', 'modula-best-grid-gallery' ),
        esc_html__( 'Added cursor controls', 'modula-best-grid-gallery' ),
        esc_html__( 'Added social icons size and gutter', 'modula-best-grid-gallery' )
    ),
    'fix'     => array(
        esc_html__( 'Fix max-width issue with Twenty Twenty theme', 'modula-best-grid-gallery' ),
        esc_html__( 'Fix menu entry colouring bug', 'modula-best-grid-gallery' ),
        esc_html__( 'Fix modula-item background', 'modula-best-grid-gallery' ),
        esc_html__( 'Re-worded "Update" button', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed copy shortcode button design bug', 'modula-best-grid-gallery' )
    ),
    'removal' => array(
        esc_html__( 'Removed settings for default title and caption', 'modula-best-grid-gallery' )
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

                <h2><?php printf(esc_html__('Version %s addressed %s bug and implemented %s features.', 'modula-best-grid-gallery'), MODULA_LITE_VERSION, count($issues['fix']), count($issues['feature'])); ?></h2>
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
