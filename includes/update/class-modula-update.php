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
                    <div class="button-wrap-single">
                        <?php $welcome->display_button( esc_html__( 'Read our step-by-step guide to get started', 'modula-best-grid-gallery' ), 'https://modula.helpscoutdocs.com/article/264-how-to-create-your-first-gallery', true, '#2a9d8f' ); ?>
                    </div>
                    <div class="block">
                        <?php $welcome->layout_start( 2, 'feature-list clear' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Gallery features', 'modula-best-grid-gallery' ), esc_html__( '4 image loading effects, animations, lightbox gallery, filterable galleries, and 43 image hover effects;', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-defaults.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Grid types', 'modula-best-grid-gallery' ), esc_html__( 'Showcase your images in 4 stunning grid types: creative, custom, slider, and masonry.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-grid-types.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Social sharing', 'modula-best-grid-gallery' ), esc_html__( 'Add social sharing buttons to your images and allow visitors to share your artwork on their social channels;', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-social.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Video integration', 'modula-best-grid-gallery' ), esc_html__( 'Make the most out of your galleries and add videos too.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-video.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Image protection', 'modula-best-grid-gallery' ), esc_html__( 'Add a watermark to your images, password-protect your galleries, and enable right-click protection', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-protection.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Image optimization', 'modula-best-grid-gallery' ), esc_html__( 'Improve page load speed, SEO ranking, and user experience by using the Speed Up and Deeplink extension as well as by adding title, caption and alt text to your images.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-speedup.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Albums creation', 'modula-best-grid-gallery' ), esc_html__( 'With the Albums extension, you can organize and display multiple galleries into albums.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-albums.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Brand exposure', 'modula-best-grid-gallery' ), esc_html__( 'Using the Modula Whitelabel extension, you’ll be able to replace any occurrence of Modula with your brand name and logo. You can also add your logo as a watermark on pictures.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-whitelabel.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Data display', 'modula-best-grid-gallery' ), esc_html__( 'Showcase data (camera model, aperture, ISO, shutter speed, lens, focal length, and date) from your image directly into your gallery with our EXIF extension.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-exif.png", true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'Zoom in', 'modula-best-grid-gallery' ), esc_html__( 'Allow visitors to see your work in detail and admire each piece of your artwork up close in the Lightbox', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). 'assets/images/addons/modula-zoom.png', true, '#2a9d8f' ); ?>
                        <?php $welcome->display_extension( esc_html__( 'User role limitations', 'modula-best-grid-gallery' ), esc_html__( 'Admins decide which user roles can create, edit, and remove galleries and albums, as well as defaults/presets.', 'modula-best-grid-gallery' ),  esc_attr( MODULA_URL ). "assets/images/addons/modula-roles.png", true, '#2a9d8f' ); ?>
						<?php $welcome->layout_end(); ?>
                    
                    
                        <div class="testimonials">
                            <div class="block clear">
                                <?php $welcome->display_heading( esc_html__( 'Happy users Modula', 'modula-best-grid-gallery' ) ); ?>
                            
                                <?php $welcome->display_testimonial( esc_html__( 'Modula is the best gallery plugin for WordPress I’ve ever used. It’s fast, easy to get started, and has some killer features. It’s also super customizable. As a developer I appreciate that for my clients. As a user, I appreciate that I don’t need to add any code.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ). "assets/images/joe-casabona.webp", 'Joe Casabona'); ?>
                                <?php $welcome->display_testimonial( esc_html__( 'Finally a beautiful looking image gallery plugin with a development team that actually cares about web performance. If you’re looking to showcase your images, without sacrificing quality and care about the speed of your website, this is the plugin for you.', 'modula-best-grid-gallery' ), esc_attr( MODULA_URL ). "assets/images/Brian-Jackson-116x116-1.jpg", 'Brian Jackson'); ?>
                            </div>
                        </div><!-- testimonials -->
   
						<div class="button-wrap clear">
							<div class="left">
                                <?php $welcome->display_button( esc_html__( 'Start Adding Galleries', 'modula-best-grid-gallery' ), esc_url( admin_url( 'edit.php?post_type=modula-gallery' ) ), true, '#2a9d8f' ); ?>
							</div>
							<div class="right">
                                <?php $welcome->display_button( esc_html__( 'Upgrade Now', 'modula-best-grid-gallery' ), 'https://wp-modula.com/pricing/?utm_source=welcome_banner&utm_medium=upgradenow&utm_campaign=welcome_banner', true, '#E76F51' ); ?>
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