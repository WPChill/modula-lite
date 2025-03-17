<?php
$defaults = apply_filters(
	'modula_troubleshooting_defaults',
	array(
		'image_licensing'          => 'none',
		'display_with_description' => false,
	)
);

$image_attrib_options = get_option( 'modula_image_licensing_option', array() );
$licenses             = Modula_Helper::get_image_licenses();

if ( empty( $image_attrib_options ) || ! isset( $image_attrib_options['image_licensing'] ) || ! isset( $licenses[ $image_attrib_options['image_licensing'] ] ) ) {
	if ( isset( $image_attrib_options['image_licensing'] ) && ! isset( $licenses[ $image_attrib_options['image_licensing'] ] ) ) {
		// the license no longer exists? unset and to get default with parse_args.
		unset( $image_attrib_options['image_licensing'] );
	}
	$image_attrib_options = wp_parse_args( $image_attrib_options, $defaults );
}

$image_attrib_fields = array(
	'misc_settings'            => array(
		'label'    => esc_html__( 'Licensing settings', 'modula-best-grid-gallery' ),
		'type'     => 'heading',
		'priority' => 0,
	),
	'image_licensing_author'   => array(
		'label'    => esc_html__( 'Author', 'modula-best-grid-gallery' ),
		'type'     => 'text',
		'priority' => 10,
	),
	'image_licensing_company'  => array(
		'label'    => esc_html__( 'Company', 'modula-best-grid-gallery' ),
		'type'     => 'text',
		'priority' => 20,
	),
	'image_licensing'          => array(
		'label'    => esc_html__( 'Choose license type', 'modula-best-grid-gallery' ),
		'type'     => 'icon-radio',
		'values'   => Modula_Helper::get_image_licenses(),
		'priority' => 30,
	),
	'display_with_description' => array(
		'label'    => esc_html__( 'Display licensing under gallery', 'modula-best-grid-gallery' ),
		'type'     => 'toggle',
		'priority' => 40,
	),
);

$image_attrib_fields = apply_filters( 'modula_image_licensing_fields', $image_attrib_fields );

uasort( $image_attrib_fields, array( 'Modula_Helper', 'sort_data_by_priority' ) );

?>
<div class="row">
	<form id="modula_image_licensing_option" method="post">
		<?php $nonce = wp_create_nonce( 'modula_image_licensing_option_post' ); ?>
		<input type="hidden" name="nonce" value="<?php echo esc_attr( $nonce ); ?>" />
		<table class="form-table">
			<tbody>
			<?php
			foreach ( $image_attrib_fields as $key => $ts_field ) {
				?>
				<tr valign="top">
					<th scope="row" style="width:300px;" valign="top" >
						<?php
						echo ( 'heading' == $ts_field['type'] ) ? '<h2>' . esc_html( $ts_field['label'] ) . '</h2>' : esc_html( $ts_field['label'] );

						if ( isset( $ts_field['description'] ) & 'heading' === $ts_field['type'] ) {
							echo '<p style="font-weight:normal;">' . esc_html( $ts_field['description'] ) . '</p>';
						}
						?>
					</th>
					<?php if ( 'heading' != $ts_field['type'] ) { ?>
					<td>
						<div class="wrap modula"> 
							<div class="">
								<!-- Checkbox Toggles -->
								<?php if ( 'toggle' == $ts_field['type'] ) { ?>
									<div class="modula-toggle">
										<input class="modula-toggle__input" type="checkbox"
												data-setting="modula_image_licensing_option[
												<?php
												echo esc_attr( $key );
												?>
												]"
												id="modula_image_licensing_option-
												<?php
												echo esc_attr( $key );
												?>
												"
												name="modula_image_licensing_option[
												<?php
												echo esc_attr( $key );
												?>
												]"
												value="1" 
												<?php
												( isset( $image_attrib_options[ $key ] ) ) ? checked( 1, $image_attrib_options[ $key ], true ) : '';
												?>
												>
										<div class="modula-toggle__items">
											<span class="modula-toggle__track"></span>
											<span class="modula-toggle__thumb"></span>
											<svg class="modula-toggle__off" width="6" height="6" aria-hidden="true"
												role="img"
												focusable="false"
												viewBox="0 0 6 6">
												<path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
											</svg>
											<svg class="modula-toggle__on" width="2" height="6" aria-hidden="true"
												role="img"
												focusable="false"
												viewBox="0 0 2 6">
												<path d="M0 0h2v6H0z"></path>
											</svg>
										</div>
									</div>
								<?php } ?>
								<!-- Text Inputs -->
								<?php if ( 'text' == $ts_field['type'] ) { ?>
										<input class="modula-toggle__input" type="text"
											data-setting="modula_image_licensing_option[<?php echo esc_attr( $key ); ?>]"
											id="modula_image_licensing_option-<?php echo esc_attr( $key ); ?>"
											name="modula_image_licensing_option[<?php echo esc_attr( $key ); ?>]"
											value="<?php echo isset( $image_attrib_options[ $key ] ) ? esc_attr( $image_attrib_options[ $key ] ) : ''; ?> " >
								<?php } ?>

							<!-- Text Inputs -->
								<?php if ( 'icon-radio' == $ts_field['type'] ) { ?>
									<?php

									$ccs = Modula_Helper::get_image_licenses();

									?>
									<div class="modula-image-licensing-radio-wrapper">
										<?php foreach ( $ts_field['values'] as $val_key => $val ) : ?>
											
												<input
												<?php echo ( $val_key == $image_attrib_options[ $key ] ) ? 'checked="checked"' : ''; ?>
												<?php
												if ( ! isset( $ccs[ $val_key ] ) ) {
													continue;
												}


													$cc = $ccs[ $val_key ];
												?>
												id="modula_image_licensing_license_<?php echo esc_attr( $val_key ); ?>"
												class="modula_image_licensing_radio_input" 
												type="radio" 
												name="modula_image_licensing_option[<?php echo esc_attr( $key ); ?>]" 
												data-setting="modula_image_licensing_option[<?php echo esc_attr( $key ); ?>]" 
												value="<?php echo esc_attr( $val_key ); ?>">

												<label class="modula-image-licensing-radio-icon" for="modula_image_licensing_license_<?php echo esc_attr( $val_key ); ?>">
													<?php if ( isset( $cc['image'] ) && '' != $cc['image'] ) : ?>
														<img alt="Creative Commons License" style="border-width:0" src="<?php echo esc_url( $cc['image'] ); ?>"/>
													<?php endif; ?>
													<?php if ( isset( $cc['license'] ) && '' != $cc['license'] ) : ?>
														<span class="modula-image-licensing-radio-name"><?php printf( __( 'This work is licensed under a %s' ), esc_html( $cc['name'] ) ); ?></span>
													<?php else : ?>
														<span class="modula-image-licensing-radio-name"><?php esc_html_e( 'None', 'modula-best-grid-gallery' ); ?></span>
													<?php endif; ?>
												</label>
										   
										<?php endforeach; ?>
									</div>
								<?php } ?>

							</div>
						</div>
					</td>
					<?php } ?>
				</tr>
				<?php
			}
			?>
			<tr valign="top">
				<td>
					<div>
						<?php submit_button( __( 'Save', 'modula-best-grid-gallery' ), 'primary', 'modula-image-licensing-submit', false ); ?>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</form>
</div>
