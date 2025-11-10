<hr class="wp-header-end">
<?php Modula_Admin_Helpers::modula_page_header(); ?>
<div class="modula">
	<?php
		Modula_Admin_Helpers::modula_tab_navigation( $this->tabs, $this->current_tab, $this->current_subtab );
	?>
	<div class="modula-columns">
		<div class="modula-column">
			<?php do_action( "modula_admin_tab_{$this->current_tab}" ); ?>
			<div class="modula-section">
				<?php do_action( "modula_admin_tab_{$this->current_subtab}" ); ?>
			</div>
		</div>
		<div class="modula-column modula-side-tab m-col-4">
			<?php do_action( "modula_side_admin_tab_{$this->current_tab}" ); ?>
			<?php do_action( 'modula_side_admin_tab' ); ?>
		</div>
	</div>

</div>
