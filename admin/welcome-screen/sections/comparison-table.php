<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Features
 */

$features = array(
	'post-formats'   => array(
		'label'      => __( 'Images per gallery', 'modula-gallery' ),
		'modula'     => '20',
		'modula-pro' => __( 'Unlimited', 'modula-gallery' ),
	),
	'slider-layouts' => array(
		'label'      => __( 'Filters', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'news-ticker'    => array(
		'label'      => __( 'Reload page on filter click', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'banner-ads'     => array(
		'label'      => __( 'Change Filter Text', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'video-widgets'  => array(
		'label'      => __( 'Multiple Included LightBox Scripts', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'color-schemes'  => array(
		'label'      => __( 'Image Loaded Effects', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'typography'     => array(
		'label'      => __( 'Image Hoever Effects', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'updates'        => array(
		'label'      => __( 'Feature & Security Updates', 'modula-gallery' ),
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'suppoprt'       => array(
		'label'      => __( 'Priority Support', 'modula-gallery' ),
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
						<?php echo $feature['label']; ?>
					</h3>
				</td>
				<td class="modula-feature">
					<?php echo $feature['modula']; ?>
				</td>
				<td class="modula-pro-feature">
					<?php echo $feature['modula-pro']; ?>
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