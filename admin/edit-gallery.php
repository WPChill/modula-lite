<?php
if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
	die( _e( 'You are not allowed to call this page directly.', 'modula-gallery' ) );
}

function modula_print_value( $gallery, $field, $default = null ) {
	if ( $gallery == null || $gallery->$field === null ) {
		if ( $default === null ) {
			print "";
		} else {
			print stripslashes( $default );
		}
	} else {
		print stripslashes( $gallery->$field );
	}
}

$galleryResults = $this->ModulaDB->getGalleries();

$gallery     = $this->loadedData;
$tg_subtitle = "Edit Gallery: " . $gallery->name;

include( "header.php" );

?>

<script>
  var modula_wp_caption_field = '<?php modula_print_value( $gallery, "wp_field_caption" )  ?>';
</script>
<div class="container">
	<div class="row collapsible">
		<div class="card-panel light-green lighten-4">
			<span> <?php echo esc_html__( 'Shortcode', 'modula-gallery' ); ?>: </span>
			<input type="text" readonly value="[Modula id='<?php print $gallery->id; ?>']"> </input>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<ul class="collapsible" data-collapsible="accordion">
			<?php foreach ( $modula_fields as $section => $s ): ?>
				<li id="<?php echo strtolower( str_replace( ' ', '-', $section ) ); ?>">
					<div class="collapsible-header white-text  darken-2">
						<i class="<?php echo esc_attr( $s["icon"] ); ?>"></i>
						<span><?php echo esc_html( $section ) ?> </span> <i class="fa fa-chevron-right"></i>
					</div>

					<div class="collapsible-body lighten-5 tab form-fields">

						<input type="hidden" id="wp_caption" value="<?php echo esc_attr( $gallery->wp_field_caption ); ?>">
						<input type="hidden" id="wp_title" value="<?php echo esc_attr( $gallery->wp_field_title ); ?>">

						<form name="gallery_form" id="gallery_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>" method="post">
							<?php wp_nonce_field( 'Modula', 'Modula' ); ?>
							<input type="hidden" name="ftg_gallery_edit" id="gallery-id" value="<?php echo esc_attr( $gallery->id ); ?>"/>
							<table class="widefat post fixed" cellspacing="0">
								</tbody>
							</table>
						</form>

						<table>
							<tbody>
							<?php foreach ( $s["fields"] as $f => $data ) : ?><?php if ( is_array( $data["excludeFrom"] ) && ! in_array( $modula_parent_page, $data["excludeFrom"] ) ) : ?>
								<tr class="row-<?php echo esc_attr( $f ); ?> <?php echo esc_attr( $data["type"] ); ?>">
									<th scope="row">
										<label class="label-text"><?php echo esc_html( $data["name"] ); ?>
											<?php if ( isset( $data["mu"] ) ) : ?>
												(<?php echo esc_html( $data["mu"] ) ?>)
											<?php endif ?>
										</label>
									</th>
									<td>
										<div class="field">
											<?php if ( $data["type"] == "text" ) : ?>
												<div class="text">
													<input type="text" size="30" name="tg_<?php echo esc_attr( $f ); ?>" value="<?php echo esc_attr( $gallery->$f ); ?>"/>
												</div>
											<?php elseif ( $data["type"] == "select" ) : ?>

												<div class="text">
													<select class="browser-default dropdown-menu" name="tg_<?php echo esc_attr( $f ); ?>">
														<?php foreach ( array_keys( $data["values"] ) as $optgroup ) : ?>
															<optgroup label="<?php echo esc_attr( $optgroup ); ?>">
																<?php foreach ( $data["values"][ $optgroup ] as $option ) : ?><?php $v = explode( "|", $option ); ?>
																	<option value="<?php echo esc_attr( $v[0] ); ?>" <?php echo $v[0] == $gallery->$f ? "selected" : "" ?> ><?php echo esc_html( $v[1] ); ?></option>
																<?php endforeach ?>
															</optgroup>
														<?php endforeach ?>
														<?php if ( isset( $data["disabled"] ) ) : ?><?php foreach ( array_keys( $data["disabled"] ) as $optgroup ) : ?>
															<optgroup label="<?php echo esc_attr( $optgroup ); ?>">
																<?php foreach ( $data["disabled"][ $optgroup ] as $option ) : ?>

																	<?php $v = explode( "|", $option ); ?>
																	<option disabled><?php echo esc_html( $v[1] ) ?></option>
																<?php endforeach ?>
															</optgroup>
														<?php endforeach ?>

														<?php endif ?>
													</select>
												</div>
											<?php elseif ( $data["type"] == "toggle" ) : ?>
												<div class="text">
													<input type="checkbox" id="ftg_<?php echo esc_attr( $f ); ?>" name="tg_<?php echo esc_attr( $f ); ?>" value="<?php echo esc_attr( $gallery->$f ); ?>" <?php echo $gallery->$f == 'T' ? 'checked' : '' ?> />
													<label for="ftg_<?php echo esc_attr( $f ); ?>"><?php echo esc_html( $data["description"] ); ?></label>
												</div>

											<?php elseif ( $data["type"] == "ui-slider" || $data['type'] == 'slider' ) : ?>
												<div class="text">
													<label class="effect-description"><?php echo esc_html( $data['description'] ); ?></label>
													<p class="range-field">
														<input name="tg_<?php echo esc_attr( $f ); ?>" value="<?php echo esc_attr( $gallery->$f ); ?>" type="range" min="<?php echo esc_attr( $data["min"] ); ?>" max="<?php echo esc_attr( $data["max"] ); ?>"/>
													</p>
												</div>

											<?php elseif ( $data["type"] == "number" ) : ?>
												<div class="text">
													<input type="text" name="tg_<?php echo esc_attr( $f ); ?>" class="integer-only" value="<?php echo esc_attr( $gallery->$f ); ?>">
												</div>

											<?php elseif ( $data["type"] == "color" ) : ?>
												<div class="text">
													<label class="effect-description effect-color" style="display:none;"> <?php echo esc_html( $data['description'] ); ?></label>
													<input type="text" size="6" data-default-color="<?php echo esc_attr( $data["default"] ); ?>" name="tg_<?php echo esc_attr( $f ); ?>" value="<?php echo esc_attr( $gallery->$f ); ?>" class='pickColor'/>
												</div>
											<?php elseif ( $data["type"] == "PRO_FEATURE" ) : ?>

												<div class="pro-cell">
													<h6><?php echo esc_html__( 'This feature is available only in the PRO version of Modula', 'modula-gallery' ); ?></h6>
													<br/>
													<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=modula-lite-gallery-upgrade&tab=comparison_table' ) ); ?>" target="_blank">
														<?php echo esc_html__( 'See LITE vs PRO Differences', 'modula-gallery' ); ?></a>
													<a class="button button-primary" href="https://wp-modula.com/?utm_source=modulalite_inst&utm_medium=banner&utm_campaign=Modula%20Lite#buy" target="_blank"><span class="dashicons dashicons-cart"></span>
														<?php echo esc_html__( 'Get Modula Pro!', 'modula-gallery' ); ?>
													</a>
												</div>

											<?php elseif ( $data["type"] == "textarea" ) : ?>
												<div class="text">
													<textarea name="tg_<?php echo esc_attr( $f ); ?>"><?php echo esc_html( $gallery->$f ); ?></textarea>
												</div>
											<?php elseif ( $data["type"] == "hover-effect" ): ?>

												<div class="text">
													<label class="effect-description"> <?php print $data['description']; ?> </label>
													<select name="tg_hoverEffect" class="select-effect">
														<?php $hoverEffectIdx = 0 ?>
														<option value="none"><?php echo esc_html__( 'None', 'modula-gallery' ); ?></option>
														<option <?php selected( 'pufrobo', $gallery->hoverEffect ) ?> value="pufrobo">Pufrobo</option>
														<optgroup label="Buy a PRO license to unlock all hover effects">
															<?php foreach ( $this->hoverEffects as $effect ) : if ( 'none' == $effect->code || 'pufrobo' == $effect->code ) { continue; } ?>
																<option disabled value="<?php echo esc_attr( $effect->code ); ?>"><?php echo esc_attr( $effect->name ); ?></option>
															<?php endforeach ?>
														</optgroup>
													</select>
													<a class="all-effects" href="https://wp-modula.com/demo/effects/appear/?utm_source=modulalite_inst&utm_campaign=Modula%20Lite&utm_medium=banner&utm_term=all%20effects" target="_blank"><i class="mdi mdi-comment-alert-outline"></i>
														<?php echo esc_html__( 'Click to see all available effects', 'modula-gallery' ); ?>
													</a>

													<!-- all effects preview -->
													<div class="preview modula">
														<div class="panel panel-pufrobo items clearfix">
															<!-- show preview -->

															<div class="item effect-pufrobo">
																<img src="<?php print plugins_url() ?>/modula-best-grid-gallery/admin/images/effect.jpg" class="pic">
																<div class="figc">
																	<div class="figc-inner">

																		<h2>Lorem ipsum</h2>
																		<p class="description">Quisque diam erat, mollis
																			vitae enim eget</p>
																		<div class="jtg-social">
																			<a class="fa fa-twitter" href="#"></a>
																			<a class="fa fa-facebook" href="#"></a>
																			<a class="fa fa-google-plus" href="#"></a>
																			<a class="fa fa-pinterest" href="#"></a>
																		</div>
																	</div>
																</div>
															</div>

															<div class="effect-compatibility">

																<label class="effect-description"> <?php echo esc_html( 'This effect is compatible with:', 'modula-gallery' ); ?>
																	<span><i class="fa fa-check"></i> <?php echo esc_html( 'Title', 'modula-gallery' ); ?></span>
																	<span><i class="fa fa-check"></i> <?php echo esc_html( 'Subtitle', 'modula-gallery' ); ?> </span>
																	<span><i class="fa fa-check"></i> <?php echo esc_html( 'Social Icons', 'modula-gallery' ); ?> </span>
																</label>

															</div>
														</div>
													</div>
													<input type="hidden" name="ftg_hoverColor" value="#000">
													<input type="hidden" name="ftg_hoverOpacity" value="#.8"> <br/>
													<div class="pro-cell">
														<h6><?php echo esc_html__( 'The PRO version of Modula bundles over 12 different hover effects.', 'modula-gallery' ); ?></h6>
														<br/>
														<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=modula-lite-gallery-upgrade&tab=comparison_table' ) ); ?>" target="_blank">
															<?php echo esc_html__( 'See LITE vs PRO Differences', 'modula-gallery' ); ?>
														</a>
														<a class="button button-primary" href="https://wp-modula.com/?utm_source=modulalite_inst&utm_medium=banner&utm_campaign=Modula%20Lite#buy" target="_blank"><span class="dashicons dashicons-cart"></span>
															<?php echo esc_html__( 'Get Modula Pro!', 'modula-gallery' ); ?>
														</a>
													</div>
												</div>
											<?php endif ?>
											<div class="help">
												<?php _e( $data["description"] ); ?>
											</div>

										</div>
									</td>
								</tr>
							<?php endif ?><?php endforeach ?>

							</tbody>
						</table>
					</div>
				</li>
			<?php endforeach; ?>

			<li id="images">
				<div class="collapsible-header white-text white darken-2">
					<i class="mdi mdi-image-filter"></i>
					<span><?php echo esc_html__( 'Images', 'Modula-gallery' ) ?> </span>
					<i class="fa fa-chevron-right"></i>
				</div>

				<div class="collapsible-body white lighten-5">

					<div class="image-size-section">
						<div>
							<div class="tips">

                            <span class="shortpixel">
                            <img src="<?php echo plugins_url( '', __file__ ) ?>/images/icon-shortpixel.png" alt="ShortPixel">
                          <a target="_blank" href="https://shortpixel.com/h/af/HUOYEBB31472"><?php echo esc_html__( 'We suggest using the ShortPixel image optimization plugin to optimize your images and get the best possible SEO results & load speed..', 'modula-gallery' ) ?></a>
                          </span>

							</div>
						</div>
					</div>

					<div>
						<div class="pro-cell">
							<h6><?php echo esc_html__( 'Add more than 20 images per gallery. Upgrade to PRO', 'modula-gallery' ); ?></h6>
							<br/>
							<a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=modula-lite-gallery-upgrade&tab=comparison_table' ) ); ?>" target="_blank">See
								<?php echo esc_html__( 'LITE vs PRO Differences', 'modula-gallery' ); ?></a>
							<a class="button button-primary" href="https://wp-modula.com/?utm_source=modulalite_inst&utm_medium=banner&utm_campaign=Modula%20Lite#buy" target="_blank"><span class="dashicons dashicons-cart"></span>
								<?php echo esc_html__( 'Get Modula Pro!', 'modula-gallery' ); ?></a>
						</div>

						<div class="actions row">
							<label class="label-text row"><?php echo esc_html__( 'Add Images', 'modula-gallery' ) ?></label>
							<a href="#" class="open-media-panel waves-effect button-bg waves-light btn action"><i class="mdi-image-photo"></i> <?php echo esc_html__( 'Add images', 'modula-gallery' ) ?>
							</a>
						</div>

						<div class="bulk row">
							<label class="label-text row"><?php echo esc_html__( 'Bulk Actions', 'modula-gallery' ) ?></label>
							<div class="options">
								<a class="btn button-bg waves-effect waves-light" href="#" data-action="select"><?php echo esc_html__( 'Select all', 'modula-gallery' ) ?></a>
								<a class="btn button-bg waves-effect waves-light" href="#" data-action="deselect"><?php echo esc_html__( 'Deselect all', 'modula-gallery' ) ?></a>
								<a class="btn button-bg waves-effect waves-light" href="#" data-action="toggle"><?php echo esc_html__( 'Toggle selection', 'modula-gallery' ) ?></a>
								<a class="btn button-bg waves-effect waves-light" href="#" data-action="remove"><?php echo esc_html__( 'Remove', 'modula-gallery' ) ?></a>
							</div>
							<div class="panel">
								<strong></strong>
								<p class="text"></p>
								<p class="buttons">
									<a class="btn deep-orange darken-2 mrm cancel" href="#"><?php echo esc_html__( 'Cancel', 'modula-gallery' ) ?></a>
									<a class="btn green mrm proceed firm" href="#"><?php echo esc_html__( 'Proceed', 'modula-gallery' ) ?></a>
								</p>
							</div>
						</div>

						<div class="row">
							<span class="tip"><?php echo esc_html__( 'Drag images to change order.', 'modula-gallery' ) ?></span>
						</div>

						<div id="image-list"></div>

						<!-- image panel -->
						<div id="image-panel-model" style="display:none">
							<a href="#" class="close" title="Close">X</a>
							<h4> <?php _e( 'Edit Image', 'modula-gallery' ) ?> </h4>
							<div class="clearfix">
								<div class="left">
									<div class="figure"></div>
								</div>
								<div class="editimage-right">
									<div class="field">
										<label><?php echo esc_html__( 'Title', 'modula-gallery' ) ?></label>
										<div class="text">
											<textarea id="item-title" name="title"></textarea>
										</div>
										<label><?php echo esc_html__( 'Caption', 'modula-gallery' ) ?></label>
										<div class="text">
											<textarea id="item-description" name="description"></textarea>
										</div>
									</div>

									<div class="field">
										<label for="alignment"><?php echo esc_html__( 'Alignment', 'modula-gallery' ) ?></label>
										<select name="halign">
											<option><?php _e( 'left', 'modula-gallery' ) ?></option>
											<option selected><?php _e( 'center', 'modula-gallery' ) ?></option>
											<option><?php _e( 'right', 'modula-gallery' ) ?></option>
										</select> <select name="valign">
											<option><?php _e( 'top', 'modula-gallery' ) ?></option>
											<option selected><?php _e( 'middle', 'modula-gallery' ) ?></option>
											<option><?php _e( 'bottom', 'modula-gallery' ) ?></option>
										</select>
									</div>
									<div class="field">
										<label><?php _e( 'Link', 'modula-gallery' ) ?></label>
										<div class="text">
											<!-- <input type="text" name="link" value="" class="text-input row">  -->
											<textarea id="item-link" name="link"></textarea> <select name="target">
												<option value=""><?php echo esc_html__( 'Default target', 'modula-gallery' ) ?></option>
												<option value="_self"><?php echo esc_html__( 'Open in same page', 'modula-gallery' ) ?></option>
												<option value="_blank"><?php echo esc_html__( 'Open in new page', 'modula-gallery' ) ?></option>
											</select>
										</div>
									</div>
									<div class="field filters clearfix"></div>
								</div>
							</div>
							<div class="field buttons">
								<a href="#" data-action="cancel" class="action modal-action modal-close waves-effect waves-yellow btn-flat"><i class="mdi-content-reply"></i> <?php echo esc_html__( 'Cancel', 'modula-gallery' ) ?>
								</a>
								<a href="#" data-action="save" class="action modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-save"></i> <?php echo esc_html__( 'Save', 'modula-gallery' ) ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<a id="edit-gallery" data-tooltip="Update gallery" data-position="top" data-delay="10" class="tooltipped btn-floating btn-large waves-effect waves-light green update-gallery">
	<i class="icon icon-save-disk"> </i> </a>

<div class="preloader-wrapper big active" id="spinner">
	<div class="spinner-layer spinner-blue-only">
		<div class="circle-clipper left">
			<div class="circle"></div>
		</div>
		<div class="gap-patch">
			<div class="circle"></div>
		</div>
		<div class="circle-clipper right">
			<div class="circle"></div>
		</div>
	</div>
</div>

<div id="import-modal" class="modal">
	<div class="modal-content">
		<h3><?php echo esc_html__( 'Import Configuration', 'modula-gallery' ); ?></h3>
		<p><?php echo esc_html__( 'Paste here the configuration code', 'modula-gallery' ); ?></p>
		<textarea> </textarea>

	</div>
	<div class="modal-footer">
		<a id="save" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php _e( 'Import', 'modula-gallery' ) ?></a>

		<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php _e( 'Close', 'modula-gallery' ) ?></a>
	</div>
</div>

<div id="export-modal" class="modal">
	<div class="modal-content">
		<h3><?php echo esc_html__( 'Export Configuration', 'modula-gallery' ); ?></h3>
		<p><?php echo esc_html__( 'Copy the configuration code', 'modula-gallery' ); ?></p>
		<textarea readonly></textarea>
	</div>
	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php _e( 'OK', 'modula-gallery' ) ?></a>
	</div>
</div>

<script>
  (function( $ ) {
    TG.load_images();
    TG.init_gallery();
  })( jQuery );
</script>
