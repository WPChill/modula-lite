<?php
$issues = array(
	'fix'     => array(
		esc_html__( 'Fixed gallery right margin when on full width container', 'modula-best-grid-gallery' ),
		esc_html__( 'Fixed hover effect Pufrobo transition when using Divi builder', 'modula-best-grid-gallery' ),
		esc_html__( 'Fixed Uninstall message appearing on Network Plugins when using Multisite', 'modula-best-grid-gallery' ),
		esc_html__( 'Added Galleries and Suggest a feature tab on Extensions page and updated the extensions page UI. Also added the Suggest a feature tab to galleries list view ', 'modula-best-grid-gallery' ),
		esc_html__( 'Fixed Feedback form getting out of view', 'modula-best-grid-gallery' ),
		esc_html__( 'Fixed overwriting lightbox CSS when using multiple galleries on page', 'modula-best-grid-gallery' ),
	),
	'feature' => array()
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

            <h2><?php printf(esc_html__('Version %s addressed %s fixes.', 'modula-best-grid-gallery'), MODULA_LITE_VERSION, count($issues['fix'])); ?></h2>
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
