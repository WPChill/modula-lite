<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.','modula-gallery')); }

if(empty($tg_subtitle))
{
	$tg_subtitle = "Import galleries";
}

?>
<?php include("header.php"); ?>

<div id="modula-wizard" >
	<h2>  <?php _e('Import galleries','modula-gallery');  ?> </h2>
	<form action="#" method="post" onsubmit="return false;">
		<?php wp_nonce_field('Modula', 'Modula'); ?>

		<fieldset data-step="1">
			<div class="row">
				<div class="input-field">
					<p>Select an external source from which you want to import existing galleries</p>
					<select class="import-source">
						<option value=""><?php _e('Choose a source', 'modula-gallery') ?></option>
						<?php if(class_exists( "Envira_Gallery_Lite" ) || class_exists( "Envira_Gallery" )) : ?>
							<option>Envira</option>
						<?php endif ?>
						<?php if(class_exists( "nggGallery" )) : ?>
							<option>NextGen</option>
						<?php endif ?>
					</select>
				</div>
			</div>
		</fieldset>
		<fieldset data-step="2" data-branch="galleries">
			<div class="field">
				<h5><?php _e('List of galleries','modula-gallery')?></h5>
				<div id="external-galleries">
					<ul></ul>
					<button class="waves-effect button-bg green lighten-3 waves-light btn js-select-all">Select all</button>
				</div>
			</div>
		</fieldset>
		<fieldset data-step="3" data-save="true">
				<h5>You are going to import <strong class="galleries-count"></strong> galleries.</h5>
		</fieldset>

		<footer class="page-footer">
			<div class="progress loading hide">
				<div class="indeterminate"></div>
			</div>

			<a class="waves-effect waves-yellow btn-flat prev"><?php _e('Previous','modula-gallery')?></a>
			<a class="waves-effect waves-green btn-flat next"><?php _e('Next','modula-gallery')?></a>
		</footer>

	</form>
	<div id="success" class="modal">
		<div class="modal-content">
			<h4><?php _e('Success!','modula-gallery')?></h4>
			<p><?php _e('All selected galleries have been imported!','modula-gallery')?></p>
			<p>Go to the <a href="?page=ModulaLite-admin">dashboard page</a> and copy the shortcode to paste inside your pages and posts</p>
		</div>
		<div class="modal-'footer">
			<a href="?page=ModulaLite-admin" id="modal-close" class="waves-effect waves-green btn-flat modal-action"><?php _e('Close','modula-gallery')?></a>
		</div>
	</div>

	<div id="error" class="modal">
		<div class="modal-content">
			<h4><?php _e('Error!','modula-gallery')?></h4>
			<p><?php _e('For some reason it was not possible to import one or more galleries','modula-gallery')?></p>
		</div>
		<div class="modal-footer">
			<a href="?page=ModulaLite-admin" class="waves-effect waves-green btn-flat modal-action"><?php _e('Close','modula-gallery')?></a>
		</div>
	</div>
</div>
