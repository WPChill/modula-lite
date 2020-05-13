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
        add_filter( 'modula_cpt_metaboxes',array( $this, 'albums_upsell_meta' ) );

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
	            $upsell_box .= '<div class="modula-tooltip"><span>[?]</span>';
	            $upsell_box .= '<div class="modula-tooltip-content">' . esc_html( $feature['tooltip']) . '</div>';
	            $upsell_box .= '</div>';
	            $upsell_box .= "<p>" . esc_html($feature['feature']) . "</p>";
	            $upsell_box .= '</li>';
	            
	        }
	        $upsell_box .= '</ul>';
		}

		$upsell_box .= '<p class="modula-upsell-description">' . esc_html( $description ) . '</p>';
		$upsell_box .= '<p>';
		$upsell_box .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=' . $tab . '-tab&utm_campaign=litevspro#lite-vs-pro"  class="button">' . esc_html__( 'See LITE vs PRO Differences', 'modula-best-grid-gallery' ) . '</a>';
		$upsell_box .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=' . $tab . '-tab&utm_campaign=upsell" class="button-primary button">' . esc_html__( 'Get Modula Pro!', 'modula-best-grid-gallery' ) . '</a>';
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
		$upsell_description = esc_html__( 'Adding a video gallery with both self-hosted videos and videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' );

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
                'tooltip' => esc_html__('Enable this to allow loop navigation inside lightbox','modula-lightboxes'),
                'feature' => esc_html__('Loop Navigation','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Toggle on to show the image title in the lightbox above the caption.','modula-lightboxes'),
                'feature' => esc_html__('Show Image Title','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Toggle on to show the image caption in the lightbox.','modula-lightboxes'),
                'feature' => esc_html__('Show Image Caption','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Select the position of the caption and title inside the lightbox.','modula-lightboxes'),
                'feature' => esc_html__('Title and Caption Position','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Enable or disable keyboard/mousewheel navigation inside lightbox','modula-lightboxes'),
                'feature' => esc_html__('Keyboard/mousewheel Navigation','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Display the toolbar which contains the action buttons on top right corner.','modula-lightboxes'),
                'feature' => esc_html__('Toolbar','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Close the slide if user clicks/double clicks on slide( not image ).','modula-lightboxes'),
                'feature' => esc_html__('Close on slide click / double click','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Display the counter at the top left corner.','modula-lightboxes'),
                'feature' => esc_html__('Infobar','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Open the lightbox automatically in Full Screen mode.','modula-lightboxes'),
                'feature' => esc_html__('Auto start in Fullscreen','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Place the thumbnails at the bottom of the lightbox. This will automatically put `y` axis for thumbnails.','modula-lightboxes'),
                'feature' => esc_html__('Thumbnails at bottom ','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Select vertical or horizontal scrolling for thumbnails','modula-lightboxes'),
                'feature' => esc_html__('Thumb axis','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Display thumbnails on lightbox opening.','modula-lightboxes'),
                'feature' => esc_html__('Auto start thumbnail ','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Choose the lightbox transition effect between slides.','modula-lightboxes'),
                'feature' => esc_html__('Transition Effect ','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Allow panning/swiping','modula-lightboxes'),
                'feature' => esc_html__('Allow Swiping ','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Toggle ON to show all images','modula-lightboxes'),
                'feature' => esc_html__('Show all images ','modula-lightboxes'),
            ),
            array(
                'tooltip' => esc_html__('Choose the open/close animation effect of the lightbox','modula-lightboxes'),
                'feature' => esc_html__('Open/Close animation','modula-lightboxes') ,
            ),
            array(
                'tooltip' => esc_html__('Set the lightbox background color','modula-lightboxes'),
                'feature' => esc_html__('Lightbox background color','modula-lightboxes'),
            ));

		$tab_content .= $this->generate_upsell_box( $title, $description, 'lightboxes', $features );
        return $tab_content;

    }

    public function misc_tab_upsell( $tab_content ) {

        $upsell_title       = esc_html__( 'Looking to add deeplink functionality to your lightboxe or protect your images from stealing?', 'modula-best-grid-gallery' );
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

	public function meta_boxes_setup() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
  		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ),10 );

	}

	public function add_meta_boxes() {
		add_meta_box(
		    'modula-sorting-upsell',      // Unique ID
		    esc_html__('Sorting Upsells', 'modula-best-grid-gallery'),    // Title
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
                    <h2><?php esc_html_e( 'Looking for gallery sorting?' , 'modula-best-grid-gallery' ) ?></h2>
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
                           href="https://wp-modula.com/pricing/?utm_source=modula-lite&amp;utm_medium=sorting-metabox&amp;utm_campaign=litevspro#lite-vs-pro"
                           class="button"><?php esc_html_e( 'See LITE vs PRO Differences' , 'modula-best-grid-gallery' ) ?></a>
                        <a target="_blank"
                           style="margin-top:10px;"
                           href="https://wp-modula.com/pricing/?utm_source=modula-lite&amp;utm_medium=sorting-metabox&amp;utm_campaign=upsell"
                           class="button-primary button"><?php esc_html_e( 'Get Modula Pro!' , 'modula-best-grid-gallery' ) ?></a>
                    </p>
                </div>
            </div>
        </div>
		<?php
	}

}
