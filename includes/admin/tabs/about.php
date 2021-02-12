<?php
$issues = array(
	'fixed'     => array(
		esc_html( 'Powered by links appear 2 times', 'modula-best-grid-gallery' ),
		esc_html__( 'Gutenberg alignment issue when trying to make full width', 'modula-best-grid-gallery' ),
		esc_html__( 'Elementor compatibility', 'modula-best-grid-gallery' ),
		esc_html__( 'Selecting a gallery with no images in Gutenberg', 'modula-best-grid-gallery' ),
		esc_html__( 'Modula\'s galleries not being displayed properly in preview in Gutenberg', 'modula-best-grid-gallery' ),
		esc_html__( 'Modula\'s gallery selector not being displayed properly in it\'s Gutenberg\'s block', 'modula-best-grid-gallery' ),
		esc_html__( 'Avada theme compatibility issue regarding color pickers', 'modula-best-grid-gallery' ),
		esc_html__( 'Multiple same gallery in page issue', 'modula-best-grid-gallery' ),
		esc_html__( 'JS error in admin when cycling through gallery\'s images', 'modula-best-grid-gallery' ),
		esc_html__( 'Lazy load incompatibility with Site Ground Optimizer plugin and Avada lazy loading', 'modula-best-grid-gallery' ),
		esc_html__( 'Conflict where ResizeSensor was declared as global. Now it has been personalized ', 'modula-best-grid-gallery' ),
		esc_html__( 'Incompatibility with some themes, where the resize reset of Modula wasn\'t working correctly', 'modula-best-grid-gallery' ),
		esc_html__( 'Modula\'s instance not being reset on tab switch', 'modula-best-grid-gallery' ),
		esc_html__( 'Custom CSS\'s tab editor was not showing correctly if the last tab was the Custom CSS tab', 'modula-best-grid-gallery' ),
	),
	'added' => array(
			esc_html__('Only allow certain users to the Extensions page','modula-best-grid-gallery'),
			esc_html__('Responsive gutters','modula-best-grid-gallery'),
			esc_html__('Added debug info using WordPress\' Site Health + added an export option to export single galleries, used for both debugging and export/import operations','modula-best-grid-gallery'),
			esc_html__('FREE vs Premium page','modula-best-grid-gallery'),
			esc_html__('Srcset and sizes for galleries images for both declared sizes and custom sizes','modula-best-grid-gallery'),
			esc_html__('Custom size and WordPress image sizes selection for galleries grid thumbnail','modula-best-grid-gallery'),
	),
	'changed' => array(
			esc_html__('Social share now gives image URL instead of page URL and title/caption of image','modula-best-grid-gallery'),
			esc_html__('Extensions page and how it works','modula-best-grid-gallery'),
			esc_html__('Hover effects tab had been given an UI update','modula-best-grid-gallery'),
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

            <h2><?php printf(esc_html__('Version %s addressed %s fixes, %s enhancements and %s changes.', 'modula-best-grid-gallery'), MODULA_LITE_VERSION,count($issues['fixed']) ,count($issues['added']),count($issues['changed'])); ?></h2>
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
