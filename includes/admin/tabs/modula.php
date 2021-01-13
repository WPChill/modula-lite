<div class="wrap modula">
	<?php  Modula_Admin_Helpers::modula_page_header(); ?>
	<h2 class="nav-tab-wrapper wp-clearfix">
		<?php

		$i = count($this->tabs);
		$j = 1;

		foreach ( $this->tabs as $key => $tab ) {
			$class = 'nav-tab';
			$url = $this->generate_url( $key );

			if ( $key == $this->current_tab ) {
				$class .= ' nav-tab-active';
			}

			$last_tab = ( $i == $j ) ? ' last_tab' : '';
			$j++;

			echo '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . $last_tab . '">' . esc_html($tab['label']);

			if ( isset( $tab['badge'] ) ) {
				echo '<span class="modula-badge">' . $tab['badge'] . '</span>';
			}
			echo '</a>';

		}

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