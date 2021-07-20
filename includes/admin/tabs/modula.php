<div class="wrap modula">
	<h2 class="nav-tab-wrapper wp-clearfix">
		<?php
		Modula_Admin_Helpers::modula_tab_navigation($this->tabs,$this->current_tab);
		?>
	</h2>

	<div class="modula-columns">
		<div class="modula-column m-col-8">
			<?php do_action( "modula_admin_tab_{$this->current_tab}" ); ?>
		</div>
		<div class="modula-column modula-side-tab m-col-4">
			<?php do_action( "modula_side_admin_tab_{$this->current_tab}" ); ?>
			<?php do_action( "modula_side_admin_tab" ); ?>
		</div>
	</div>

</div>