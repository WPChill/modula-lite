<div class="wrap modula about-wrap">
	<h1><?php esc_html_e( 'Modula', 'modula-best-grid-gallery' ) ?> <?php echo esc_html($this->version) ?></h1>
	<p class="about-text"><?php esc_html_e( 'Modula is now installed and ready to use! Get ready to build something beautiful. We hope you enjoy it! We want to make sure you have the best experience using our plugin and that is why we gathered here all the necessary information for you. We hope you will enjoy using Modula, as much as we enjoy creating great products.', 'modula-best-grid-gallery' ) ?></p>
	<div class="wp-badge"><?php esc_html_e( 'Version', 'modula-best-grid-gallery' ) ?> <?php echo esc_html($this->version) ?></div>
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