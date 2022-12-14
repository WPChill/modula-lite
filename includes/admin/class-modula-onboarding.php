<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if(!class_exists('WP_Posts_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php' );
}

class Modula_Onboarding extends WP_Posts_List_Table
{

	// Your custom list table is here
	public function display() {

		$new_gal_url = admin_url('post-new.php?post_type=modula-gallery');
		?>
		<div class="modula-onboarding-wrapper">

			<div class="modula-onboarding-title">
				<img src="<?php echo esc_url( MODULA_URL ) .'assets/images/onboarding/WPChill Onboarding Wave.png';?>" class="modula-onboarding-title-icon" /> <span><?php esc_html_e( 'Hi, there!', 'modula-best-grid-gallery' ); ?></span>
			</div>
			<div class="modula-onboarding-text-wrap">
				<p><?php esc_html_e( 'With its intuitive interface and wide range of features, Modula makes it easy to create a professional-looking gallery that showcases your photos and videos in the best light. Whether you want to share your work with friends, family, or potential clients, Modula can help you create a gallery that impresses and engages.', 'modula-best-grid-gallery' ); ?></p>
			</div>
			<div class="modula-onboarding-banner-wrap">
				<img src="<?php echo esc_url( MODULA_URL ) .'assets/images/onboarding/Modula onboarding Banner.png';?>" class="modula-onboarding-banner" />
			</div>
			<div class="modula-onboarding-button-wrap">
				<a href="<?php echo esc_url( $new_gal_url ); ?>" class="modula-onboarding-button"><?php esc_html_e( 'Create your first gallery', 'modula-best-grid-gallery' ); ?></a>
			</div>
			<div class="modula-onboarding-doc-wrap">
				<p class="modula-onboarding-doc" ><?php echo sprintf( esc_html__( 'Need help? Check out %s our documentation%s.', 'modula-best-grid-gallery' ),  '<a href="https://modula.helpscoutdocs.com/" target="_blank">','</a>' ); ?></p>
			</div>
		</div>
		<?php
	}
}

