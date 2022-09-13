<?php
// WPChill Welcome Class
require_once MODULA_PATH . 'includes/submodules/banner/class-wpchill-welcome.php';

if ( ! class_exists( 'WPChill_Welcome' ) ) {
	return;
}

$welcome = WPChill_Welcome::get_instance();
?>
<div id="wpchill-welcome">

	<div class="container">

		<div class="hero features">

			<div class="mascot">
				<img src="<?php echo esc_attr( MODULA_URL ); ?>assets/images/logo-dark.png" alt="<?php esc_attr_e( 'Modula Logo', 'modula-best-grid-gallery' ); ?>">
			</div>
			<div class="block">
				<?php $welcome->display_heading( esc_html__( 'Thank you for installing Modula', 'modula-best-grid-gallery' ) ); ?>
				<?php $welcome->display_subheading( esc_html__( 'You\'re just a few steps away from creating your first fully customizable gallery to showcase your images (or videos) with the easiest to use WordPress gallery plugin on the market.', 'modula-best-grid-gallery' ) ); ?>
			</div>
			<div class="wpchill-text-center">
				<div class="button-wrap-single">
					<?php $welcome->display_button( esc_html__( 'Read our step-by-step guide to get started', 'modula-best-grid-gallery' ), 'https://modula.helpscoutdocs.com/article/264-how-to-create-your-first-gallery', true, '#2a9d8f' ); ?>
				</div>
			</div>
			<?php $welcome->display_empty_space(); ?>

			<img src="<?php echo esc_url( MODULA_URL ); ?>assets/images/banner.png" alt="<?php esc_attr_e( 'Watch how to', 'modula-best-grid-gallery' ); ?>" class="video-thumbnail">

			<?php $welcome->horizontal_delimiter(); ?>
			<div class="block">
			<?php $welcome->display_heading( esc_html__( 'Features&Add-ons', 'modula-best-grid-gallery' ) ); ?>
				<?php $welcome->layout_start( 2, 'feature-list clear' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Gallery features', 'modula-best-grid-gallery' ), esc_html__( '4 image loading effects, animations, lightbox gallery, filterable galleries, and 43 image hover effects;', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-defaults.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Grid types', 'modula-best-grid-gallery' ), esc_html__( 'Showcase your images in 4 stunning grid types: creative, custom, slider, and masonry.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-grid-types.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Social sharing', 'modula-best-grid-gallery' ), esc_html__( 'Add social sharing buttons to your images and allow visitors to share your artwork on their social channels;', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-social.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Video integration', 'modula-best-grid-gallery' ), esc_html__( 'Make the most out of your galleries and add videos too.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-video.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Image protection', 'modula-best-grid-gallery' ), esc_html__( 'Add a watermark to your images, password-protect your galleries, and enable right-click protection', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-protection.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Image optimization', 'modula-best-grid-gallery' ), esc_html__( 'Improve page load speed, SEO ranking, and user experience by using the Speed Up and Deeplink extension as well as by adding title, caption and alt text to your images.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-speedup.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Albums creation', 'modula-best-grid-gallery' ), esc_html__( 'With the Albums extension, you can organize and display multiple galleries into albums.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-albums.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Brand exposure', 'modula-best-grid-gallery' ), esc_html__( 'Using the Modula Whitelabel extension, you’ll be able to replace any occurrence of Modula with your brand name and logo. You can also add your logo as a watermark on pictures.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-whitelabel.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Data display', 'modula-best-grid-gallery' ), esc_html__( 'Showcase data (camera model, aperture, ISO, shutter speed, lens, focal length, and date) from your image directly into your gallery with our EXIF extension.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-exif.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Zoom in', 'modula-best-grid-gallery' ), esc_html__( 'Allow visitors to see your work in detail and admire each piece of your artwork up close in the Lightbox', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-zoom.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'User role limitations', 'modula-best-grid-gallery' ), esc_html__( 'Admins decide which user roles can create, edit, and remove galleries and albums, as well as defaults/presets.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-roles.png', true, '#2a9d8f' ); ?>
				<?php $welcome->display_extension( esc_html__( 'Pagination', 'modula-best-grid-gallery' ), esc_html__( 'Use our Pagination extension to split your gallery images over multiple pages that are easily navigable for your users.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/addons/modula-pagination.png', true, '#2a9d8f' ); ?>
				<?php $welcome->layout_end(); ?>		
				<div class="wpchill-text-center">
					<div class="button-wrap-single clear">
						<div class="right">
							<?php $welcome->display_button( esc_html__( 'Upgrade Now', 'modula-best-grid-gallery' ), 'https://wp-modula.com/pricing/?utm_source=welcome_banner&utm_medium=upgradenow&utm_campaign=welcome_banner&utm_content=first_button', true, '#E76F51' ); ?>
						</div>
					</div>
				</div>
			</div>
			<?php $welcome->horizontal_delimiter(); ?>
			<div class="block">
				<div class="testimonials">
					<div class="clear">
						<?php $welcome->display_heading( esc_html__( 'Happy users Modula', 'modula-best-grid-gallery' ) ); ?>
						<?php $welcome->display_testimonial( esc_html__( 'Modula is the best gallery plugin for WordPress I’ve ever used. It’s fast, easy to get started, and has some killer features. It’s also super customizable. As a developer I appreciate that for my clients. As a user, I appreciate that I don’t need to add any code.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/joe-casabona.webp', 'Joe Casabona' ); ?>
						<?php $welcome->display_testimonial( esc_html__( 'Finally a beautiful looking image gallery plugin with a development team that actually cares about web performance. If you’re looking to showcase your images, without sacrificing quality and care about the speed of your website, this is the plugin for you.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ) . 'assets/images/Brian-Jackson-116x116-1.jpg', 'Brian Jackson' ); ?>
					</div>
				</div><!-- testimonials -->

				<div class="button-wrap clear">
					<div class="left">
						<?php $welcome->display_button( esc_html__( 'Start Adding Galleries', 'modula-best-grid-gallery' ), esc_url( admin_url( 'edit.php?post_type=modula-gallery' ) ), true, '#2a9d8f' ); ?>
					</div>
					<div class="right">
						<?php $welcome->display_button( esc_html__( 'Upgrade Now', 'modula-best-grid-gallery' ), 'https://wp-modula.com/pricing/?utm_source=welcome_banner&utm_medium=upgradenow&utm_campaign=welcome_banner&utm_content=second_button', true, '#E76F51' ); ?>
					</div>
				</div>

			</div>
		</div><!-- hero -->
	</div><!-- container -->
</div><!-- wpchill welcome -->
<?php
