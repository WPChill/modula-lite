<?php
$issues = array(
    'fix'     => array(
        esc_html__( 'Fixed Captions', 'modula-best-grid-gallery' ),
        esc_html__( 'Fixed security issue', 'modula-best-grid-gallery' ),
    ),
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

                <h2><?php printf(esc_html__('Version %s addressed %s bugs', 'modula-best-grid-gallery'), MODULA_LITE_VERSION, count( $issues['fix'] ) ); ?></h2>
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
