<?php
$issues = array(
    'fix'     => array(
        'Fix max-width issue with Twenty Twenty theme',
        'Fix menu entry colouring bug',
        'Fix modula-item background',
        'Re-worded "Update" button'
    ),
    'feature' => array(
        'Added Uninstall options to remove data entries from DB',
        'Added troubleshooting options to enqueue CSS and JS files everywhere',
        'Added support for WebP files',
        'Added WhatsApp as social icon',
        'Added numbers to hover effects',
        'Added cursor controls'
    ),
    'removal' => array(
        'Removed settings for default title and caption'
    )
);
?>
<div class="row modula-about-row">
    <div class="about__container">
        <div class="about__header modula-about-header">
            <div class="about__header-title modula-about-heading">
                <h1>Modula<span><?php echo MODULA_LITE_VERSION; ?></span></h1>
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
