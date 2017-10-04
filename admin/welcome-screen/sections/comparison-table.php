<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Features
 */

$features = array(
	'post-formats'   => array(
		'label'      => 'Images per gallery',
		'modula'     => '20',
		'modula-pro' => 'Unlimited',
	),
	'slider-layouts' => array(
		'label'      => 'Filters',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'news-ticker'    => array(
		'label'      => 'Reload page on filter click',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'banner-ads'     => array(
		'label'      => 'Change Filter Text',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'video-widgets'  => array(
		'label'      => 'Multiple Included LightBox Scripts',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'color-schemes'  => array(
		'label'      => 'Image Loaded Effects',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'typography'     => array(
		'label'      => 'Image Hoever Effects',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'updates'        => array(
		'label'      => 'Feature & Security Updates',
		'modula'     => '<span class="dashicons dashicons-no-alt"></span>',
		'modula-pro' => '<span class="dashicons dashicons-yes"></span>',
	),
	'suppoprt'       => array(
		'label'      => 'Priority Support',
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
				   class="button button-primary button-hero"><span class="dashicons dashicons-cart"></span> Get Modula Pro!</a>
			</td>
		</tr>
		</tbody>
	</table>
</div>