<div class="wrap modula">
	<h2 class="nav-tab-wrapper wp-clearfix">
		<?php

		foreach ( $this->tabs as $key => $tab ) {
			$class = 'nav-tab';
			$url = $this->generate_url( $key );

			if ( $key == $this->current_tab ) {
				$class .= ' nav-tab-active';
			}

			echo '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . '">' . esc_html($tab['label']) . '</a>';

		}

		?>
	</h2>
	<?php

	do_action( "modula_admin_tab_{$this->current_tab}" );

	?>
</div>