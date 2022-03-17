<?php
$issues = array(
	'added'   => array(
    ),
	'changed' => array(
    ),
	'fixed'   => array(
        esc_html__( 'Sanitization and preparation for WP Core galleries import', 'modula-best-grid-gallery' ),
        esc_html__( 'Metaboxes forever opened and arrows hidden', 'modula-best-grid-gallery' ),
        esc_html__( 'Custom Posts Gutenberg block - now available everywhere Gutenberg is', 'modula-best-grid-gallery' ),
        esc_html__( 'React warnings', 'modula-best-grid-gallery' ),
        esc_html__( 'Blank links in accesibility reports', 'modula-best-grid-gallery' ),
	)
);

$status = array(
	'fixed'   => esc_html__( 'Fixed', 'modula-best-grid-gallery' ),
	'added'   => esc_html__( 'Added', 'modula-best-grid-gallery' ),
	'changed' => esc_html__( 'Changed', 'modula-best-grid-gallery' ),
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

            <h2><?php printf(esc_html__('Version %s addressed %s fixes, %s enhancements and %s changes.', 'modula-best-grid-gallery'), MODULA_LITE_VERSION,count($issues['fixed']) ,count($issues['added']),count($issues['changed'])); ?></h2>
            <?php if (!empty($issues)) { ?>
            <ul class="modula-about-list">
                <?php
				foreach ( $issues as $key => $iss ) {
					foreach ( $iss as $is ) {
						echo "<li class='$key'>$status[$key]: $is</li>";
					}
				}
				?>
            </ul>

            <?php } ?>
        </div>
    </div>
</div>
