<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Features
 */

$features = array(
	'post-formats'   => array(
		'label'      => esc_html__( 'Images per gallery', 'modula-gallery' ),
		'modula'     => '20',
		'modula-pro' => esc_html__( 'Unlimited', 'modula-gallery' ),
	),
	'slider-layouts' => array(
		'label'      => esc_html__( 'Filters', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'news-ticker'    => array(
		'label'      => esc_html__( 'Reload page on filter click', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'banner-ads'     => array(
		'label'      => esc_html__( 'Change Filter Text', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'video-widgets'  => array(
		'label'      => esc_html__( 'Multiple Included LightBox Scripts', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'color-schemes'  => array(
		'label'      => esc_html__( 'Image Loaded Effects', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'typography'     => array(
		'label'      => esc_html__( 'Image Hoever Effects', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'updates'        => array(
		'label'      => esc_html__( 'Feature & Security Updates', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'suppoprt'       => array(
		'label'      => esc_html__( 'Priority Support', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
);
?>
<div class="featured-section features">
	<table class="free-pro-table">
		<thead>
		<tr>
			<th></th>
			<th>LITE</th>
			<th>PRO</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $features as $feature ): ?>
			<tr>
				<td class="feature">
					<h3>
						<?php echo esc_html($feature['label']); ?>
					</h3>
				</td>
				<td class="modula-feature">
					<?php echo wp_kses_post($feature['modula']); ?>
				</td>
				<td class="modula-pro-feature">
					<?php echo wp_kses_post($feature['modula-pro']); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td></td>
			<td colspan="2" class="text-right">
				<a href="https://www.wp-modula.com/?utm_source=worg&utm_medium=about-page&utm_campaign=upsell" target="_blank"
				   class="button button-primary button-hero"><span class="dashicons dashicons-cart"></span> <?php echo __( 'Get Modula Pro!', 'modula-gallery' ) ?></a>
			</td>
		</tr>
		</tbody>
	</table>
</div>