<?php

class Modula_Update {

    /**
     * Holds the class object.
     *
     * @since 2.2.4
     *
     * @var object
     */
    public static $instance;


    /**
     * Primary class constructor.
     *
     * @since 2.2.4
     */
    public function __construct() {

        add_filter('modula_admin_page_link', array($this, 'modula_about_menu'),25,1);
        add_filter('submenu_file', array($this, 'remove_about_submenu_item'));
    }


	/**
	 * Add the About submenu
	 *
	 * @param $links
	 *
	 * @return mixed
	 * @since 2.2.4
	 *
	 */
    function modula_about_menu($links) {

        // Register the hidden submenu.
	    $links[] = array(
		    'page_title' => esc_html__( 'About', 'modula-best-grid-gallery' ),
		    'menu_title'=> esc_html__( 'About', 'modula-best-grid-gallery' ),
		    'capability' => 'manage_options',
		    'menu_slug' => 'modula-about-page',
		    'function' => array($this, 'about_page'),
		    'priority' => 45
	    );
        return $links;
    }

    /**
     * @param $submenu_file
     * @return mixed
     *
     * Remove the About submenu
     */
    function remove_about_submenu_item($submenu_file) {

        remove_submenu_page('edit.php?post_type=modula-gallery', 'modula-about-page');

        return $submenu_file;
    }


    /**
     * Returns the singleton instance of the class.
     *
     * @return object The Modula_Update object.
     * @since 2.2.4
     *
     */
    public static function get_instance() {
        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Update)) {
            self::$instance = new Modula_Update();
        }
        return self::$instance;
    }


    /**
     * Add activation hook. Need to be this way so that the About page can be created and accessed
     * @param $check
     * @since 2.2.4
     *
     */
    public function modula_on_activation($check) {

        if ($check) {
            add_action('activated_plugin', array($this, 'redirect_on_activation'));
        }
    }

    /**
     * Redirect to About page when activated
     *
     * @param $plugin
     * @since 2.2.4
     */
    public function redirect_on_activation($plugin) {

        if (MODULA_FILE == $plugin) {
            exit(wp_redirect(admin_url('edit.php?post_type=modula-gallery&page=modula-about-page')));
        }
    }


    /**
     * @since 2.2.4
     * Display About page
     */
    public function about_page() {

        // WPChill Welcome Class
        require_once MODULA_PATH . 'includes/admin/about/class-wpchill-welcome.php';
        $welcome = WPChill_Welcome::get_instance();
        ?>
		<div id="wpchill-welcome">

			<div class="container">

				<div class="hero features">

					<div class="mascot">
						<img src="<?php echo esc_attr( MODULA_URL ); ?>assets/images/logo-dark.png" alt="<?php esc_attr_e( 'Strong Testimonials Mascot', 'strong-testimonials' ); ?>">
					</div>

					<div class="block">
                        <?php $welcome->display_heading( 'Thank you for installing Modula' ); ?>
						<?php $welcome->display_subheading( 'You\'re just a few steps away from creating your first fully customizable gallery to showcase your images (or videos) with the easiest to use WordPress gallery plugin on the market.' ); ?>
                        <?php $welcome->display_subheading( 'Read our step-by-step guide to get started.' ); ?>
                    </div>
                    <div class="button-wrap-single">
                        <?php $welcome->display_button( 'Read our step-by-step guide to get started', 'https://modula.helpscoutdocs.com/article/264-how-to-create-your-first-gallery', true, '#2a9d8f' ); ?>
                    </div>
                    <div class="block">
                        <?php $welcome->layout_start( 2, 'feature-list clear' ); ?>
                        <?php $welcome->display_extension( 'Gallery features', '4 image loading effects, animations, lightbox gallery, filterable galleries, and 43 image hover effects;',  esc_attr( MODULA_URL ). "assets/images/addons/modula-defaults.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Grid types', 'Showcase your images in 4 stunning grid types: creative, custom, slider, and masonry.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-grid-types.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Social sharing', 'Add social sharing buttons to your images and allow visitors to share your artwork on their social channels;',  esc_attr( MODULA_URL ). "assets/images/addons/modula-social.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Video integration', 'Make the most out of your galleries and add videos too.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-video.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Image protection', 'Add a watermark to your images, password-protect your galleries, and enable right-click protection',  esc_attr( MODULA_URL ). "assets/images/addons/modula-protection.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Image optimization', ' Improve page load speed, SEO ranking, and user experience by using the Speed Up and Deeplink extension as well as by adding title, caption and alt text to your images.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-speedup.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Albums creation', 'With the Albums extension, you can organize and display multiple galleries into albums.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-albums.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Brand exposure', 'Using the Modula Whitelabel extension, you’ll be able to replace any occurrence of Modula with your brand name and logo. You can also add your logo as a watermark on pictures.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-whitelabel.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Data display', 'Showcase data (camera model, aperture, ISO, shutter speed, lens, focal length, and date) from your image directly into your gallery with our EXIF extension.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-exif.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'Zoom in', ' Allow visitors to see your work in detail and admire each piece of your artwork up close in the Lightbox',  esc_attr( MODULA_URL ). 'assets/images/addons/modula-zoom.png', true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( 'User role limitations', 'Admins decide which user roles can create, edit, and remove galleries and albums, as well as defaults/presets.',  esc_attr( MODULA_URL ). "assets/images/addons/modula-roles.png", true, '#2a9d8f' ); ?>
						<?php $welcome->layout_end(); ?>

						<div class="button-wrap clear">
							<div class="left">
                                <?php $welcome->display_button( 'Start Adding Galleries', esc_url( admin_url( 'edit.php?post_type=modula-gallery' ) ), true, '#2a9d8f' ); ?>
							</div>
							<div class="right">
                                <?php $welcome->display_button( 'Upgrade Now', 'https://wp-modula.com/pricing/?utm_source=welcome_banner&utm_medium=upgradenow&utm_campaign=welcome_banner', true, '#E76F51' ); ?>
							</div>
						</div>
					</div>
				</div><!-- hero -->
			</div><!-- container -->
		</div><!-- wpchill welcome -->
		<?php
    }

}

$modula_update = Modula_Update::get_instance();