<?php
$issues = array(
    'fix'     => array(
        esc_html__( 'Fixed Fancybox always opening, not depending on lightbox & links type', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed lazyload for masonry columns', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed layout rebuild on device orientation change', 'modula-best-grid-gallery' ),
    ),
    'feature' => array(
    )
);
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
            <?php if (!empty($issues)) { ?>

                <h2><?php printf(esc_html__('Version %s addressed %s bugs.', 'modula-best-grid-gallery'), MODULA_LITE_VERSION, count( $issues['fix'] )); ?></h2>
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
