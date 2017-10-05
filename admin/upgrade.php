<?php
$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'getting_started';
wp_enqueue_style( 'welcome', plugin_dir_url( __FILE__ ) . 'welcome-screen/assets/welcome.css' );
?>

<div class="wrap about-wrap modula-wrap">
	<h1><?php echo esc_html__( 'Modula - Why you should be upgrading', 'modula-gallery' ); ?></h1>

	<p class="about-text">
		<?php echo esc_html__( 'Introducing one of the most powerful gallery system ever made for WordPress. Modula is an exquisite WordPress Gallery Plugin perfectly fit for any needs. We\'ve outlined below the PRO features.', 'modula-gallery' ) ?>
	</p>
	<div class="wp-badge"></div>

	<h2 class="nav-tab-wrapper wp-clearfix">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=modula-lite-gallery-upgrade&tab=getting_started' ) ); ?>" class="nav-tab <?php echo $active_tab == 'getting_started' ? 'nav-tab-active' : ''; ?>"><?php _e( 'What&#8217;s included with PRO' ); ?></a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=modula-lite-gallery-upgrade&tab=comparison_table' ) ); ?>" class="nav-tab <?php echo $active_tab == 'comparison_table' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Comparison Table: Lite vs PRO' ); ?></a>
	</h2>

	<?php
	switch ( $active_tab ) {
		case 'getting_started':
			require_once plugin_dir_path( __FILE__ ) . 'welcome-screen/sections/getting-started.php';
			break;
		case 'comparison_table':
			require_once plugin_dir_path( __FILE__ ) . 'welcome-screen/sections/comparison-table.php';
			break;
	}
	?>

</div> <!--/.about-wrap-->