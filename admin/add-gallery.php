<?php
if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
	die( _e( 'You are not allowed to call this page directly.', 'modula-gallery' ) );
}

$tg_subtitle = "New Gallery";
?>

<?php include( "header.php" ) ?>


<div id="modula-wizard">
	<h2>  <?php _e( 'Add New Gallery', 'modula-gallery' ); ?> </h2>
	<form action="#" method="post">
		<?php wp_nonce_field( 'Modula', 'Modula' ); ?>
		<input type="hidden" name="enc_images" value=""/>

		<fieldset data-step="1">
			<div class="row">
				<div class="input-field">
					<input name="tg_name" id="name" type="text" class="validate" required="required">
					<label for="name"><?php echo esc_html__( 'Name of the gallery', 'modula-gallery' ) ?></label>
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<input name="tg_description" id="description" type="text" class="validate">
					<label for="description"><?php echo esc_html__( 'Description of the gallery (for internal use)', 'modula-gallery' ) ?></label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<input name="tg_width" id="width" type="text" value="100%">
					<label for="width"><?php echo esc_html__( 'Gallery width', 'modula-gallery' ) ?></label>
				</div>
				<div class="input-field col s6">
					<input name="tg_height" id="height" type="text" value="800">
					<label for="height"><?php echo esc_html__( 'Gallery height in pixels', 'modula-gallery' ) ?></label>
				</div>
			</div>
		</fieldset>
		<fieldset data-step="2" data-branch="images">
			<div class="field">
				<h5><?php echo esc_html__( 'WordPress field for titles:', 'modula-gallery' ) ?></h5>
				<select class="browser-default" name="ftg_wp_field_title">
					<option value="none"><?php echo esc_html__( 'Don\'t use titles', 'modula-gallery' ); ?></option>
					<option value="title" selected><?php echo esc_html__( 'Title', 'modula-gallery' ); ?></option>
					<option value="description"><?php echo esc_html__( 'Description', 'modula-gallery' ); ?></option>
				</select>
			</div>
			<div class="field">
				<h5><?php echo esc_html__( 'WordPress field for captions:', 'modula-gallery' ) ?></h5>
				<select class="browser-default" name="ftg_wp_field_caption">
					<option value="none"><?php echo esc_html( 'Don\'t use captions', 'modula-gallery' ); ?></option>
					<option value="title"><?php echo esc_html( 'Title', 'modula-gallery' ); ?></option>
					<option value="caption" selected><?php echo esc_html( 'Captions', 'modula-gallery' ); ?></option>
					<option value="description"><?php echo esc_html( 'Description', 'modula-gallery' ); ?></option>
				</select>
			</div>
		</fieldset>
		<fieldset data-step="3" data-save="true">
			<div class="field">
				<h5><?php echo esc_html__( 'Image size', 'modula-gallery' ) ?></h5>
				<div class="row">
					<div class="input-field">
						<input name="tg_img_size" id="img_size" type="text" class="validate" required="required" value="500">
						<label for="name"><?php echo esc_html__( 'Minimum width or height of images', 'modula-gallery' ) ?></label>
					</div>
				</div>

				<label class="shortpixel">
					<img src="<?php echo esc_url( plugins_url( '', __file__ ) ); ?>/images/icon-shortpixel.png" alt="ShortPixel">
					<a target="_blank" href="https://shortpixel.com/h/af/HUOYEBB31472"><?php echo esc_html__( 'We suggest using the ShortPixel image optimization plugin to optimize your images and get the best possible SEO results & load speed..', 'modula-gallery' ) ?></a>
				</label>

			</div>
			<div class="field select-images">
				<a class="waves-effect waves-light btn add-images">
					<i class="mdi mdi-plus left"></i> <?php echo esc_html__( 'Add images', 'modula-gallery' ) ?></a>
				<br> <label><?php echo esc_html__( 'You can add images now or later.', 'modula-gallery' ) ?></label>

				<div class="images list-group"></div>
			</div>
		</fieldset>

		<footer class="page-footer">
			<div class="progress loading hide">
				<div class="indeterminate"></div>
			</div>

			<a class="waves-effect waves-yellow btn-flat prev"><?php echo esc_html__( 'Previous', 'modula-gallery' ) ?></a>
			<a class="waves-effect waves-green btn-flat next"><?php echo esc_html__( 'Next', 'modula-gallery' ) ?></a>
		</footer>

	</form>
	<div id="success" class="modal">
		<div class="modal-content">
			<h4><?php echo esc_html__( 'Success!', 'modula-gallery' ) ?></h4>
			<p><?php echo esc_html__( 'Your gallery', 'modula-gallery' ) ?>
				"<span class="gallery-name"></span>" <?php echo esc_html__( 'has been created. Copy the following shortcode:', 'modula-gallery' ) ?>
				<br> <input type="text" class="code"><br>
				<?php echo esc_html__( 'and paste it inside a post or a page. Otherwise click', 'modula-gallery' ) ?>
				<a class='customize'><?php echo esc_html__( 'here', 'modula-gallery' ) ?></a> <?php echo esc_html__( 'to customize
                  the gallery.', 'modula-gallery' ) ?>
			</p>
		</div>
		<div class="modal-'footer">
			<a href="?page=modula-lite-admin" id="modal-close" class="waves-effect waves-green btn-flat modal-action"><?php echo esc_html__( 'Close', 'modula-gallery' ) ?></a>
		</div>
	</div>

	<div id="error" class="modal">
		<div class="modal-content">
			<h4><?php echo esc_html__( 'Error!', 'modula-gallery' ) ?></h4>
			<p><?php echo esc_html__( 'For some reason it was not possible to save your gallery', 'modula-gallery' ) ?></p>
		</div>
		<div class="modal-footer">
			<a href="?page=modula-lite-admin" class="waves-effect waves-green btn-flat modal-action"><?php echo esc_html__( 'Close', 'modula-gallery' ) ?></a>
		</div>
	</div>
</div>
