<?php
$issues = array(
    'fix'     => array(
        esc_html__( 'Update conditional fields', 'modula-best-grid-gallery' ),
        esc_html__( 'Fix hover effects', 'modula-best-grid-gallery' ),
        esc_html__( 'Fix for elementor opening another lightbox', 'modula-best-grid-gallery' ),
        esc_html__( 'Overflowing admin bar fix', 'modula-best-grid-gallery' ),
        esc_html__('Modula image files upload/select improvement','modula-best-grid-gallery'),
        esc_html__('Fix classic editor popup for no galleries','modula-best-grid-gallery'),
        esc_html__('Fix selecting a gallery in Elementor widget','modula-best-grid-gallery')
    ),
    'feature' => array(
        esc_html__( 'Replaced packery & masonry scripts with isotope script', 'modula-best-grid-gallery' ),
        esc_html__( 'Changed lightbox to FancyBox from Lightbox2', 'modula-best-grid-gallery' ),
        esc_html__( 'Modula admin UI improvement and update', 'modula-best-grid-gallery' ),
        esc_html__( 'Added inview load functionality', 'modula-best-grid-gallery' ),
        esc_html__( 'Added new gallery type - columns', 'modula-best-grid-gallery' ),
        esc_html__( 'Added ALT text for the image inside the lightbox', 'modula-best-grid-gallery' ),
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
