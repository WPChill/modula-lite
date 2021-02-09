<?php

/**
 * Class Modula Upsells
 */
class Modula_Upsells {
	
	function __construct() {
		
		/* Hooks */
		add_filter( 'modula_general_tab_content', array( $this, 'general_tab_upsell' ) );
		add_filter( 'modula_hover-effect_tab_content', array( $this, 'hovereffects_tab_upsell' ),15,1 );
		add_filter( 'modula_image-loaded-effects_tab_content', array( $this, 'loadingeffects_tab_upsell' ),15,1 );
		add_filter( 'modula_video_tab_content', array( $this, 'video_tab_upsell' ) );
		add_filter( 'modula_speedup_tab_content', array( $this, 'speedup_tab_upsell' ) );
		add_filter( 'modula_filters_tab_content', array( $this, 'filters_tab_upsell' ) );
        add_filter( 'modula_lightboxes_tab_content', array( $this, 'lightboxes_tab_upsell' ) );
        add_filter( 'modula_misc_tab_content', array( $this, 'misc_tab_upsell' ) );
        add_filter( 'modula_password_protect_tab_content', array( $this, 'password_protect_tab_upsell' ) );
        add_filter( 'modula_watermark_tab_content', array( $this, 'watermark_tab_upsell' ) );
        add_filter( 'modula_slideshow_tab_content', array( $this, 'slideshow_tab_upsell' ) );
		add_filter( 'modula_download_tab_content', array( $this, 'download_tab_upsell' ) );
		add_filter( 'modula_exif_tab_content', array( $this, 'exif_tab_upsell' ) );
		add_filter( 'modula_zoom_tab_content', array( $this, 'zoom_tab_upsell' ) );
        add_filter( 'modula_cpt_metaboxes',array( $this, 'albums_upsell_meta' ) );

        // Add modula roles to tab
        add_filter( 'modula_admin_page_tabs', array( $this, 'add_roles_upsell' ) );
        add_action( 'modula_admin_tab_roles', array( $this, 'render_roles_upsell_tab' ) );

        // Add modula whitelabel upsell
        add_action( 'modula_side_admin_tab', array( $this, 'render_whitelabel_upsell' ) );
        add_action( 'modula_side_admin_tab', array( $this, 'render_roles_upsell' ) );

		/* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'meta_boxes_setup' ) );

	}


    /**
     * Add Albums Upsell Metabox
     *
     * @param $met
     * @return mixed
     * @since 2.2.7
     */
    public function albums_upsell_meta( $met ) {

        $met['modula-albums-upsell'] = array(
            'title'    => esc_html__( 'Albums Upsell', 'modula-best-grid-gallery' ),
            'callback' => 'output_upsell_albums',
            'context'  => 'normal',
            'priority' => 5,
        );

        return $met;
    }

	public function generate_upsell_box( $title, $description, $tab, $features = array() ) {

		$upsell_box = '<div class="modula-upsell">';
		$upsell_box .= '<h2>' . esc_html( $title ) . '</h2>';

		if ( ! empty( $features ) ) {
			$upsell_box .= '<ul class="modula-upsell-features">';
	        foreach( $features as $feature ) {

	            $upsell_box .= '<li>';
                if ( isset( $feature['tooltip'] ) && '' != $feature['tooltip'] ) {
                    $upsell_box .= '<div class="modula-tooltip"><span>[?]</span>';
                    $upsell_box .= '<div class="modula-tooltip-content">' . esc_html( $feature['tooltip']) . '</div>';
                    $upsell_box .= '</div>';
                    $upsell_box .= "<p>" . esc_html($feature['feature']) . "</p>";
                }else{
                    $upsell_box .= '<span class="modula-check dashicons dashicons-yes"></span>' . esc_html($feature['feature']);
                }
	            
	            $upsell_box .= '</li>';
	            
	        }
	        $upsell_box .= '</ul>';
		}

		$campaign = $tab;
		$pro_simple = array('filters','hovereffects','loadingeffects','general','misc','lightboxes');
		if ( !in_array($tab,$pro_simple)) {
			$campaign = 'modula-' . $tab;

			if('password' == $tab){
				$campaign = 'modula-password-protect';
			}
		}

		$upsell_box .= '<p class="modula-upsell-description">' . esc_html( $description ) . '</p>';
		$upsell_box .= '<p>';
		$upsell_box .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium='.$tab.'-tab&utm_campaign='.$campaign.'#lite-vs-pro"  class="button">' . esc_html__( 'See Free vs Premium Differences', 'modula-best-grid-gallery' ) . '</a>';
		$upsell_box .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=' . $tab . '_tab_upsell-tab&utm_campaign='.$campaign.'" class="button-primary button">' . esc_html__( 'Get Modula Pro!', 'modula-best-grid-gallery' ) . '</a>';
		$upsell_box .= '</p>';
		$upsell_box .= '</div>';

		return $upsell_box;
	}

	public function general_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking for even more control and even more powerful galleries?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Pro today to get access to Fancybox Lightbox extra options, extra styles and more...', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'general' );

		return $tab_content;
	}

	public function loadingeffects_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Not enough control?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Pro today to unlock the ability to scale an image, and add horizontal/vertical slides...', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'loadingeffects' );

		return $tab_content;

	}

	public function hovereffects_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Need new hover effects and cursors ?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Pro today to unlock 41 more hover effects and custom cursors...', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'hovereffects' );

		return $tab_content;

	}

	public function video_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Trying to add a video to your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Adding a video gallery with self-hosted videos or videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'video' );

		return $tab_content;

	}

	public function speedup_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to make your gallery load faster ?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them and serving them from StackPath’s content delivery network.', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'speedup' );

		return $tab_content;

	}

	public function filters_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to add filters to your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Ugrade to Modula Pro today and get access to filters and separate the images in your gallery.', 'modula-best-grid-gallery' );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'filters' );

		return $tab_content;

	}

	public function lightboxes_tab_upsell($tab_content) {

		$title       = esc_html__( 'Looking to add more functionality to your lightbox?', 'modula-best-grid-gallery' );
        $description = esc_html__( 'Ugrade to Modula Pro today and get access to a impressive number of options and settings for your lightbox, everything from toolbar buttons to animations and transitions.', 'modula-best-grid-gallery' );
        $tab = 'lightboxes';

		$features = array(
            array(
                'tooltip' => esc_html__('Enable this to allow loop navigation inside lightbox','modula-best-grid-gallery'),
                'feature' => esc_html__('Loop Navigation','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Toggle on to show the image title in the lightbox above the caption.','modula-best-grid-gallery'),
                'feature' => esc_html__('Show Image Title','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Toggle on to show the image caption in the lightbox.','modula-best-grid-gallery'),
                'feature' => esc_html__('Show Image Caption','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Select the position of the caption and title inside the lightbox.','modula-best-grid-gallery'),
                'feature' => esc_html__('Title and Caption Position','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Enable or disable keyboard navigation inside lightbox','modula-best-grid-gallery'),
                'feature' => esc_html__('Keyboard Navigation','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Enable or disable mousewheel navigation inside lightbox','modula-best-grid-gallery'),
                'feature' => esc_html__('Mousewheel Navigation','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Display the toolbar which contains the action buttons on top right corner.','modula-best-grid-gallery'),
                'feature' => esc_html__('Toolbar','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Close the slide if user clicks/double clicks on slide( not image ).','modula-best-grid-gallery'),
                'feature' => esc_html__('Close on slide click','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Display the counter at the top left corner.','modula-best-grid-gallery'),
                'feature' => esc_html__('Infobar','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Open the lightbox automatically in Full Screen mode.','modula-best-grid-gallery'),
                'feature' => esc_html__('Auto start in Fullscreen','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Place the thumbnails at the bottom of the lightbox. This will automatically put `y` axis for thumbnails.','modula-best-grid-gallery'),
                'feature' => esc_html__('Thumbnails at bottom ','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Select vertical or horizontal scrolling for thumbnails','modula-best-grid-gallery'),
                'feature' => esc_html__('Thumb axis','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Display thumbnails on lightbox opening.','modula-best-grid-gallery'),
                'feature' => esc_html__('Auto start thumbnail ','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Choose the lightbox transition effect between slides.','modula-best-grid-gallery'),
                'feature' => esc_html__('Transition Effect ','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Allow panning/swiping','modula-best-grid-gallery'),
                'feature' => esc_html__('Allow Swiping ','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Toggle ON to show all images','modula-best-grid-gallery'),
                'feature' => esc_html__('Show all images ','modula-best-grid-gallery'),
            ),
            array(
                'tooltip' => esc_html__('Choose the open/close animation effect of the lightbox','modula-best-grid-gallery'),
                'feature' => esc_html__('Open/Close animation','modula-best-grid-gallery') ,
            ),
            array(
                'tooltip' => esc_html__('Set the lightbox background color','modula-best-grid-gallery'),
                'feature' => esc_html__('Lightbox background color','modula-best-grid-gallery'),
            ),
            array(
	            'tooltip' => esc_html__('Allow your visitors to share their favorite images from inside the lightbox','modula-best-grid-gallery'),
	            'feature' => esc_html__('Lightbox social share','modula-best-grid-gallery'),
            ));

		$tab_content .= $this->generate_upsell_box( $title, $description, 'lightboxes', $features );
        return $tab_content;

    }

    public function misc_tab_upsell( $tab_content ) {

        $upsell_title       = esc_html__( 'Looking to add deeplink functionality to your lightbox or protect your images from stealing?', 'modula-best-grid-gallery' );
        $upsell_description = esc_html__( 'Ugrade to Modula Pro today and get access to Modula Protection and Modula Deeplink add-ons and increase the functionality and copyright your images.', 'modula-best-grid-gallery' );

        $tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'misc' );

        return $tab_content;

    }

    public function password_protect_tab_upsell( $tab_content ) {

        $upsell_title       = esc_html__( 'Looking to protect your galleries with a password ?', 'modula-best-grid-gallery' );
        $upsell_description = esc_html__( 'Ugrade to Modula Pro today and get access to Modula Password Protect add-on and protect your galleries with a password.', 'modula-best-grid-gallery' );

        $tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'password' );

        return $tab_content;

    }

    public function watermark_tab_upsell( $tab_content ) {

        $upsell_title       = esc_html__( 'Looking to watermark your galleries?', 'modula-best-grid-gallery' );
        $upsell_description = esc_html__( 'Ugrade to Modula Pro today and get access to Modula Watermark add-on and add a watermark to your gallery images.', 'modula-best-grid-gallery' );

        $tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'watermark' );

        return $tab_content;

    }

    public function slideshow_tab_upsell( $tab_content ) {

        $upsell_title       = esc_html__( 'Want to make slideshows from your gallery?', 'modula-best-grid-gallery' );
        $upsell_description = esc_html__( 'Ugrade to Modula Pro today and get access to Modula Slidfeshow add-on allows you to turn your gallery\'s lightbox into a stunning slideshow.', 'modula-best-grid-gallery' );

        $tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'slideshow' );

        return $tab_content;

    }

	public function zoom_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to add zoom functionality to your lightbox?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( "With the Modula ZOOM extension you'll be able to allow your users to zoom in on your photos, using different zoom effects, making sure every little detail of your photo doesn't go unnoticed.", 'modula-best-grid-gallery' );

        $features           = array(
            array(
                'feature' => 'Zoom in effect on images, inside the lightbox',
            ),
            array(
                'feature' => 'Multiple zooming effects, such as: basic, lens and inner',
            ),
            array(
                'feature' => "Control the zoom effect's shape, size, tint and opacity",
            ),
            array(
                'feature' => "Impress your potential clients with detail rich images that don't go unnoticed",
            ),
        );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'zoom', $features );

		return $tab_content;

	}

	public function exif_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to add EXIF image info functionality to your lightbox?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( "With the Modula EXIF extension you'll be able to enrich your photos with the following metadata: camera model, lens, shutter speed, aperture, ISO and the date the photography was taken. More so, by using this extension, you can edit your EXIF metadata on the go, or add it to images that are missing it. ", 'modula-best-grid-gallery' );
        $features           = array(
            array(
                'feature' => 'EXIF data is automatically read and displayed',
            ),
            array(
                'feature' => 'Manually add EXIF data on images that are missing it',
            ),
            array(
                'feature' => 'Control how you display your EXIF data in lighboxes',
            ),
            array(
                'feature' => 'On-the go editing for EXIF metadata',
            ),
        );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'exif', $features );

		return $tab_content;

	}

	public function download_tab_upsell( $tab_content ) {

		$upsell_title       = esc_html__( 'Looking to add download functionality to your lightbox?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Give your users the ability to download your images, galleries or albums with an easy to use shortcode.', 'modula-best-grid-gallery' );

        $features           = array(
            array(
                'feature' => 'Download entire galleries, albums or a single photo',
            ),
            array(
                'feature' => 'Select the image sizes the user can download (thumbnail, full size, or custom)',
            ),
            array(
                'feature' => 'Comes with a powerful shortcode that you can use to render the button anywhere',
            ),
        );

		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'download', $features );

		return $tab_content;

	}

	public function meta_boxes_setup() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
  		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ),10 );

	}

	public function add_meta_boxes() {
		add_meta_box(
			'modula-defaults-upsell',      // Unique ID
			esc_html__('Modula Defaults Addon', 'modula-best-grid-gallery'),    // Title
			array( $this, 'output_defaults_upsell' ),   // Callback function
			'modula-gallery',         // Admin page (or post type)
			'side',         // Context
			'high'         // Priority
		);

    	add_meta_box(
		    'modula-sorting-upsell',      // Unique ID
		    esc_html__('Gallery sorting', 'modula-best-grid-gallery'),    // Title
		    array( $this, 'output_sorting_upsell' ),   // Callback function
		    'modula-gallery',         // Admin page (or post type)
		    'side',         // Context
		    'default'         // Priority
		);
	}

	public function output_sorting_upsell(){
		?>
        <div class="modula-upsells-carousel-wrapper">
            <div class="modula-upsells-carousel">
                <div class="modula-upsell modula-upsell-item">
                    <p class="modula-upsell-description"><?php esc_html_e( 'Upgrade to Modula Pro today to get access to 7 sorting options.' , 'modula-best-grid-gallery' ) ?></p>
                    <ul class="modula-upsells-list">
                        <li>Date created - newest first</li>
                        <li>Date created - oldest first</li>
                        <li>Date modified - most recent first</li>
                        <li>Date modified - most recent last</li>
                        <li>Title alphabetically</li>
                        <li>Title reverse</li>
                        <li>Random</li>
                    </ul>
                    <p>
                        <a target="_blank"
                           href="https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium=sorting-metabox&utm_campaign=modula-sorting#lite-vs-pro"
                           class="button"><?php esc_html_e( 'See Free vs Premium Differences' , 'modula-best-grid-gallery' ) ?></a>
                        <a target="_blank"
                           style="margin-top:10px;"
                           href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=sorting-metabox&utm_campaign=modula-sorting"
                           class="button-primary button"><?php esc_html_e( 'Get Modula Pro!' , 'modula-best-grid-gallery' ) ?></a>
                    </p>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Output the Defaults Upsell metabox
	 *
	 * @since 2.4.0
	 */
	public function output_defaults_upsell() {
		?>
		<div class="modula-upsells-carousel-wrapper">
			<div class="modula-upsells-carousel">
				<div class="modula-upsell modula-upsell-item">
                    <p class="modula-upsell-description">Easily create galleries with the same settings:</p>
                    <ul class="modula-upsells-list">
                        <li>Create default galleries using the desired settings.</li>
                        <li>Add a new gallery and select a default preset previously created. Then add your images.</li>
                        <li>Save your galleries</li>
                    </ul>
                    <p>
                        <a target="_blank"
                           href="https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium=defaults-metabox&utm_campaign=modula-defaults#lite-vs-pro"
                           class="button"><?php esc_html_e( 'See Free vs Premium Differences', 'modula-best-grid-gallery' ) ?></a>
                        <a target="_blank"
                           style="margin-top:10px;"
                           href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=defaults-metabox&utm_campaign=modula-defaults"
                           class="button-primary button"><?php esc_html_e( 'Get Modula Pro!', 'modula-best-grid-gallery' ) ?></a>
                    </p>
				</div>
			</div>
		</div>
		<?php
	}

    // Add modula roles
    public function add_roles_upsell( $tabs ) {

        $tabs[ 'roles' ] = array(
            'label'    => esc_html__( 'Roles', 'modula-roles' ),
            'badge'    => 'PRO',
            'priority' => 120,
        );

        return $tabs;

    }

    public function render_roles_upsell_tab(){
        ?>

        <div class="modula-settings-upsell">
            <p><?php esc_html_e( 'Gain even more control over how your galleries are handled with Modula User Roles. It allows admins to assign user roles that they find appropriate, giving as much access as they think it’s necessary to other users to edit or remove galleries, albums and defaults or presets.', 'modula-best-grid-gallery' ) ?></p>
            <p style="text-align:center">
                <a target="_blank"
                   href="https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium=defaults-metabox&utm_campaign=modula-defaults#lite-vs-pro"
                   class="button"><?php esc_html_e( 'See Free vs Premium Differences', 'modula-best-grid-gallery' ) ?></a>
                <a target="_blank"
                   style="margin-top:10px;"
                   href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=defaults-metabox&utm_campaign=modula-defaults"
                   class="button-primary button"><?php esc_html_e( 'Get Modula Pro!', 'modula-best-grid-gallery' ) ?></a>
            </p>
        </div>

        <?php
    }

    public function render_roles_upsell(){
        ?>

        <div class="modula-settings-upsell">
            <h3><?php esc_html_e( 'Modula Roles', 'modula-best-grid-gallery' ) ?></h3>
            <p><?php esc_html_e( 'Gain even more control over how your galleries are handled with Modula User Roles. It allows admins to assign user roles that they find appropriate, giving as much access as they think it’s necessary to other users to edit or remove galleries, albums and defaults or presets.', 'modula-best-grid-gallery' ) ?></p>
            <p style="text-align:center">
                <a target="_blank"
                   href="https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium=defaults-metabox&utm_campaign=modula-defaults#lite-vs-pro"
                   class="button"><?php esc_html_e( 'See Free vs Premium Differences', 'modula-best-grid-gallery' ) ?></a>
                <a target="_blank"
                   style="margin-top:10px;"
                   href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=defaults-metabox&utm_campaign=modula-defaults"
                   class="button-primary button"><?php esc_html_e( 'Get Modula Pro!', 'modula-best-grid-gallery' ) ?></a>
            </p>
        </div>

        <?php
    }

    public function render_whitelabel_upsell(){
        ?>

        <div class="modula-upsell">
            <h3><?php esc_html_e( 'Modula Whitelabel', 'modula-best-grid-gallery' ) ?></h3>
            <p class="modula-upsell-content"><?php esc_html_e( 'You’re one step closer to becoming a renowned professional! Modula’s brand new Whitelabel addon gives agencies the advantage of replacing every occurrence of the plugin with their brand name and logo, seamlessly integrating the whole Modula pack into their product.', 'modula-best-grid-gallery' ); ?></p>
            <p>
                <a target="_blank"
                   href="https://wp-modula.com/pricing/?utm_source=lite-vs-pro&utm_medium=defaults-metabox&utm_campaign=modula-defaults#lite-vs-pro"
                   class="button"><?php esc_html_e( 'See Free vs Premium Differences', 'modula-best-grid-gallery' ) ?></a>
                <a target="_blank"
                   style="margin-top:10px;"
                   href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=defaults-metabox&utm_campaign=modula-defaults"
                   class="button-primary button"><?php esc_html_e( 'Get Modula Pro!', 'modula-best-grid-gallery' ) ?></a>
            </p>
        </div>

        <?php
    }

}
