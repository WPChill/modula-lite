<?php
$issues = array(
	'added'   => array(
        esc_html__( 'Link to Modula\'s about page in the plugin\'s branding header', 'modula-best-grid-gallery' ),
        esc_html__( 'Upsell to Modula PRO in plugins page', 'modula-best-grid-gallery' ),
        esc_html__( 'Mobile Gallery Height setting', 'modula-best-grid-gallery' ),
    ),
	'changed' => array(
        esc_html__( 'Gallery title html element (from h2 to div)', 'modula-best-grid-gallery' ),
        esc_html__( 'Default "Hide Title" setting value to ON', 'modula-best-grid-gallery' ),
        esc_html__( 'Lazy load setting default ON', 'modula-best-grid-gallery' ),
        esc_html__( 'Updated CPT settings conditions', 'modula-best-grid-gallery' ),
        esc_html__( 'Grid Automatic default Row Height from 150 to 250', 'modula-best-grid-gallery' ),
        esc_html__( 'Update settings texts.', 'modula-best-grid-gallery' ),
        esc_html__( 'Last 5 galleries now appear in selectize without searching', 'modula-best-grid-gallery' ),
        esc_html__( 'Import/Export page received a new design', 'modula-best-grid-gallery' ),
        esc_html__( 'Improved Upsells', 'modula-best-grid-gallery' ),
    ),
	'fixed'   => array(
        esc_html__( 'Modula metabox return to default position if previously moved into the sidebar and further prevent dragging the metabox.' ),
        esc_html__( 'Modula gallery display in tabs/accordions', 'modula-best-grid-gallery' ),
        esc_html__( 'Get proper mime type', 'modula-best-grid-gallery' ),
        esc_html__( 'Added tracking db options to uninstall process', 'modula-best-grid-gallery' ),
        esc_html__( 'Unset link image attribute when importing from NextGEN', 'modula-best-grid-gallery' ),
        esc_html__( 'Error when trying to get images that were not imported correctly / do not exist as entries in db', 'modula-best-grid-gallery' ),
        esc_html__( 'Incompatibility with Gutenberg block and widgets', 'modula-best-grid-gallery' ),
        esc_html__( 'Modula Widget before and after args', 'modula-best-grid-gallery' ),
        esc_html__( 'Sharing on LinkedIn', 'modula-best-grid-gallery' ),
        esc_html__( 'Migration from NextGEN galleries replacement for `[nggallery id=”xx″]` shortcode format', 'modula-best-grid-gallery' ),
        esc_html__( 'JavaScript error when Syntax Highlighting is disabled', 'modula-best-grid-gallery' ),
        esc_html__( 'Don\'t enqueue scripts/styles when not needed', 'modula-best-grid-gallery' ),
        esc_html__( 'Mobile/table gutter not working correctly', 'modula-best-grid-gallery' ),
        esc_html__( 'Set a default widht of 100% when there is no value', 'modula-best-grid-gallery' ),
        esc_html__( 'Admin Notice placement in Modula\'s Settings page', 'modula-best-grid-gallery' ),
        esc_html__( 'Compatibility issue with Meow Lightbox', 'modula-best-grid-gallery' ),
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
