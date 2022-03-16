<?php

/**
 * Class Modula Upsells
 */
class Modula_Upsells {

	/**
	 * Holds the upsells object
	 *
	 * @var bool
	 */
	private $wpchill_upsells = false;

	/**
	 * The link for the Free vs PRO page
	 *
	 * @var string
	 */
	private $free_vs_pro_link = '#';

	function __construct() {

		if ( class_exists( 'WPChill_Upsells' ) ) {

			// Initialize WPChill upsell class
			$args = apply_filters( 'modula_upsells_args', array(
					'shop_url' => 'https://wp-modula.com',
					'slug'     => 'modula',
			) );

			$wpchill_upsell = WPChill_Upsells::get_instance( $args );

			// output wpchill lite vs pro page
			add_action( 'modula_lite_vs_premium_page', array( $wpchill_upsell, 'lite_vs_premium' ), 30, 1 );

			add_filter( 'modula_uninstall_transients', array( $wpchill_upsell, 'smart_upsells_transients' ) , 15 );

			$this->wpchill_upsells = $wpchill_upsell;
		}

		// Modula albums modal
		add_action( 'wp_ajax_modula_modal-albums_upgrade', array( $this, 'get_modal_albums_upgrade' ) );

		// Albums Defaults modal
		add_action( 'wp_ajax_modula_modal-albums-defaults_upgrade', array( $this, 'get_modal_albums_defaults_upgrade' ) );

		// Gallery Defaults modal
		add_action( 'wp_ajax_modula_modal-gallery-defaults_upgrade', array( $this, 'get_modal_gallery_defaults_upgrade' ) );

		/* Hooks */
		add_filter( 'modula_general_tab_content', array( $this, 'general_tab_upsell' ) );
		add_filter( 'modula_hover-effect_tab_content', array( $this, 'hovereffects_tab_upsell' ), 15, 1 );
		add_filter( 'modula_image-loaded-effects_tab_content', array( $this, 'loadingeffects_tab_upsell' ), 15, 1 );
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

		// Modula Advanced Shortcodes settings tab upsells
		add_action('modula_admin_tab_compression', array( $this, 'render_speedup_tab' ) );
		add_action('modula_admin_tab_standalone', array( $this, 'render_albums_tab' ) );
		add_action('modula_admin_tab_shortcodes', array( $this, 'render_advanced_shortcodes_tab' ) );
		add_action('modula_admin_tab_watermark', array( $this, 'render_watermark_tab' ) );
		add_action('modula_admin_tab_roles', array( $this, 'render_roles_tab' ) );

		// Remove upsells badge if user's license includes the addon
		add_filter('modula_admin_page_tabs', array($this, 'remove_upsells_badge' ), 999 );

		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon( 'modula-albums' ) ) { 
			add_filter( 'modula_cpt_metaboxes', array( $this, 'albums_upsell_meta' ) );
		}

		// Add modula whitelabel upsell
		if ( ! $this->wpchill_upsells || $this->wpchill_upsells->is_upgradable_addon( 'modula-whitelabel' ) ) {
			add_action( 'modula_side_admin_tab', array( $this, 'render_whitelabel_upsell' ) );
		}

		if ( ! $this->wpchill_upsells || $this->wpchill_upsells->is_upgradable_addon('modula-roles') ) {
			add_action( 'modula_side_admin_tab', array( $this, 'render_roles_upsell' ) );
		}

		/* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'meta_boxes_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'meta_boxes_setup' ) );

		$this->free_vs_pro_link = admin_url('edit.php?post_type=modula-gallery&page=modula-lite-vs-pro');

		// Upgrade to PRO plugin action link
		add_filter( 'plugin_action_links_' . MODULA_FILE, array( $this, 'filter_action_links' ), 60 );


	}

	public function generate_upsell_box( $title, $description, $tab, $features = array() ) {

		$upsell_box = '<h2>' . esc_html( $title ) . '</h2>';

		if ( ! empty( $features ) ) {
			$upsell_box .= '<ul class="modula-upsell-features">';
			foreach ( $features as $feature ) {

				$upsell_box .= '<li>';
				if ( isset( $feature['tooltip'] ) && '' != $feature['tooltip'] ) {
					$upsell_box .= '<div class="modula-tooltip"><span>[?]</span>';
					$upsell_box .= '<div class="modula-tooltip-content">' . esc_html( $feature['tooltip'] ) . '</div>';
					$upsell_box .= '</div>';
					$upsell_box .= "<p>" . esc_html( $feature['feature'] ) . "</p>";
				} else {
					$upsell_box .= '<span class="modula-check dashicons dashicons-yes"></span>' . esc_html( $feature['feature'] );
				}

				$upsell_box .= '</li>';

			}
			$upsell_box .= '</ul>';
		}

		$upsell_box .= '<p class="modula-upsell-description">' . esc_html( $description ) . '</p>';

		return $upsell_box;
	}

	public function general_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking for even more control and even more powerful galleries?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Premium today to get access to Fancybox Lightbox extra options, max images count for desktop and mobile, extra styles and more...', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'general' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=general_tab_upsell-tab&utm_campaign=general" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'general' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;
	}

	public function loadingeffects_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Not enough control?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Premium today to unlock the ability to scale an image, and add horizontal/vertical slides...', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'loadingeffects' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=loadingeffects_tab_upsell-tab&utm_campaign=loadingeffects" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'loadingeffects' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function hovereffects_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Need new hover effects and cursors ?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Upgrade to Modula Premium today to unlock 41 more hover effects and custom cursors...', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'hovereffects' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=hovereffects_tab_upsell-tab&utm_campaign=hovereffects" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'hovereffects' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function video_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-video') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Trying to add a video to your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Adding a video gallery with self-hosted videos or videos from sources like YouTube and Vimeo to your website has never been easier.', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'video' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-video_tab_upsell-tab&utm_campaign=modula-video" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-video' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function speedup_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-speedup') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking to make your gallery load faster ?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them and serving them from StackPath’s content delivery network.', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'speedup' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-speedup_tab_upsell-tab&utm_campaign=modula-speedup" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-speedup' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function filters_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking to add filters to your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to filters and separate the images in your gallery.', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'filters' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=filters_tab_upsell-tab&utm_campaign=filters" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'filters' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function lightboxes_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula') ) {
			return;
		}

		$title       = esc_html__( 'Looking to add more functionality to your lightbox?', 'modula-best-grid-gallery' );
		$description = esc_html__( 'Ugrade to Modula Premium today and get access to a impressive number of options and settings for your lightbox, everything from toolbar buttons to animations and transitions.', 'modula-best-grid-gallery' );
		$tab         = 'lightboxes';

		$features = array(
				array(
						'tooltip' => esc_html__( 'Enable this to allow loop navigation inside lightbox', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Loop Navigation', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Toggle on to show the image title in the lightbox above the caption.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Show Image Title', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Toggle on to show the image caption in the lightbox.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Show Image Caption', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Select the position of the caption and title inside the lightbox.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Title and Caption Position', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Enable or disable keyboard navigation inside lightbox', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Keyboard Navigation', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Enable or disable mousewheel navigation inside lightbox', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Mousewheel Navigation', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Display the toolbar which contains the action buttons on top right corner.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Toolbar', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Close the slide if user clicks/double clicks on slide( not image ).', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Close on slide click', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Display the counter at the top left corner.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Infobar', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Open the lightbox automatically in Full Screen mode.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Auto start in Fullscreen', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Place the thumbnails at the bottom of the lightbox. This will automatically put `y` axis for thumbnails.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Thumbnails at bottom ', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Select vertical or horizontal scrolling for thumbnails', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Thumb axis', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Display thumbnails on lightbox opening.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Auto start thumbnail ', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Choose the lightbox transition effect between slides.', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Transition Effect ', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Allow panning/swiping', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Allow Swiping ', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Toggle ON to show all images', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Show all images ', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Choose the open/close animation effect of the lightbox', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Open/Close animation', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Set the lightbox background color', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Lightbox background color', 'modula-best-grid-gallery' ),
				),
				array(
						'tooltip' => esc_html__( 'Allow your visitors to share their favorite images from inside the lightbox', 'modula-best-grid-gallery' ),
						'feature' => esc_html__( 'Lightbox social share', 'modula-best-grid-gallery' ),
				)
		);

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $title, $description, 'lightboxes', $features );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=lightboxes_tab_upsell-tab&utm_campaign=lightboxes" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'lightboxes' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function misc_tab_upsell( $tab_content ) {

		if ( ! $this->wpchill_upsells->is_upgradable_addon( 'modula-deeplink' ) && ! $this->wpchill_upsells->is_upgradable_addon( 'modula-protection' ) ) {
			return $tab_content;
		}

		if ( $this->wpchill_upsells->is_upgradable_addon( 'modula-deeplink' ) && $this->wpchill_upsells->is_upgradable_addon( 'modula-protection' ) ) {

			$upsell_title       = esc_html__( 'Looking to add deeplink functionality to your lightbox or protect your images from stealing?', 'modula-best-grid-gallery' );
			$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to Modula Protection and Modula Deeplink add-ons and increase the functionality and copyright your images.', 'modula-best-grid-gallery' );

		} elseif ( $this->wpchill_upsells->is_upgradable_addon( 'modula-deeplink' ) && ! $this->wpchill_upsells->is_upgradable_addon( 'modula-protection' ) ) {

			$upsell_title       = esc_html__( 'Looking to add deeplink functionality to your lightbox?', 'modula-best-grid-gallery' );
			$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to Modula Deeplink add-ons and increase the functionality of your images.', 'modula-best-grid-gallery' );

		} else {

			$upsell_title       = esc_html__( 'Looking to  protect your images from stealing?', 'modula-best-grid-gallery' );
			$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to Modula Protection and copyright your images.', 'modula-best-grid-gallery' );

		}

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'misc' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=misc_tab_upsell-tab&utm_campaign=misc" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'misc' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function password_protect_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-password-protect') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking to protect your galleries with a password ?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to Modula Password Protect add-on and protect your galleries with a password.', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'password' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-password_tab_upsell-tab&utm_campaign=modula-password-protect" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-password-protect' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function watermark_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-watermark') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking to watermark your galleries?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to Modula Watermark add-on and add a watermark to your gallery images.', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'watermark' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-watermark_tab_upsell-tab&utm_campaign=modula-watermark" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-watermark' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function slideshow_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-slideshow') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Want to make slideshows from your gallery?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Ugrade to Modula Premium today and get access to Modula Slidfeshow add-on allows you to turn your gallery\'s lightbox into a stunning slideshow.', 'modula-best-grid-gallery' );

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'slideshow' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-slideshow_tab_upsell-tab&utm_campaign=modula-slideshow" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-slideshow' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function zoom_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-zoom') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking to add zoom functionality to your lightbox?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( "With the Modula ZOOM extension you'll be able to allow your users to zoom in on your photos, using different zoom effects, making sure every little detail of your photo doesn't go unnoticed.", 'modula-best-grid-gallery' );

		$features = array(
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

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'zoom', $features );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-zoom_tab_upsell-tab&utm_campaign=modula-zoom" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-zoom' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function exif_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-exif') ) {
			return;
		}

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

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'exif', $features );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-exif_tab_upsell-tab&utm_campaign=modula-exif" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-exif' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function download_tab_upsell( $tab_content ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-download') ) {
			return;
		}

		$upsell_title       = esc_html__( 'Looking to add download functionality to your lightbox?', 'modula-best-grid-gallery' );
		$upsell_description = esc_html__( 'Give your users the ability to download your images, galleries or albums with an easy to use shortcode.', 'modula-best-grid-gallery' );

		$features = array(
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

		$tab_content .= '<div class="modula-upsell">';
		$tab_content .= $this->generate_upsell_box( $upsell_title, $upsell_description, 'download' );

		$tab_content .= '<p>';

		$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
		$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-download_tab_upsell-tab&utm_campaign=modula-download" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

		$buttons = apply_filters( 'modula_upsell_buttons', $buttons, 'modula-download' );

		$tab_content .= $buttons;

		$tab_content .= '</p>';
		$tab_content .= '</div>';

		return $tab_content;

	}

	public function meta_boxes_setup() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10 );

	}

	public function add_meta_boxes() {

		if ( $this->wpchill_upsells &&  $this->wpchill_upsells->is_upgradable_addon('modula-defaults') ) {

			add_meta_box(
				'modula-defaults-upsell',                                             // Unique ID
				esc_html__( 'Modula Defaults Addon', 'modula-best-grid-gallery' ),    // Title
				array( $this, 'output_defaults_upsell' ),                             // Callback function
				'modula-gallery',                                                     // Admin page (or post type)
				'side',                                                               // Context
				'high'         // Priority
			);

		}

		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon('modula') ) {
			add_meta_box(
				'modula-sorting-upsell',                                        // Unique ID
				esc_html__( 'Gallery sorting', 'modula-best-grid-gallery' ),    // Title
				array( $this, 'output_sorting_upsell' ),                        // Callback function
				'modula-gallery',                                               // Admin page (or post type)
				'side',                                                         // Context
				'default'         // Priority
			);
		}
	}

	public function output_sorting_upsell() {
		?>
		<div class="modula-upsells-carousel-wrapper">
			<div class="modula-upsells-carousel">
				<div class="modula-upsell modula-upsell-item">
					<p class="modula-upsell-description"><?php esc_html_e( 'Upgrade to Modula Premium today to get access to 7 sorting options.', 'modula-best-grid-gallery' ) ?></p>
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
						<?php

						$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
						$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=sorting-metabox&utm_campaign=modula-sorting" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

						echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-pro' );

						?>
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
						<?php

						$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
						$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=defaults-metabox&utm_campaign=modula-defaults" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

						echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-defaults' );

						?>
					</p>
				</div>
			</div>
		</div>
		<?php
	}

	// Add modula roles
	public function add_roles_upsell( $tabs ) {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon('modula-roles') ) {
			return $tabs;
		}

		$tabs['roles'] = array(
				'label'    => esc_html__( 'Roles', 'modula-roles' ),
				'badge'    => 'PRO',
				'priority' => 120,
		);

		return $tabs;

	}

	public function render_roles_upsell_tab() {
		?>

		<div class="modula-settings-upsell">
			<p><?php esc_html_e( 'Gain even more control over how your galleries are handled with Modula User Roles. It allows admins to assign user roles that they find appropriate, giving as much access as they think it’s necessary to other users to edit or remove galleries, albums and defaults or presets.', 'modula-best-grid-gallery' ) ?></p>
			<p>
				<?php

				$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
				$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=roles-metabox&utm_campaign=modula-roles" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

				echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-roles' );

				?>
			</p>
		</div>

		<?php
	}

	public function render_roles_upsell() {
		?>

		<div class="modula-settings-upsell">
			<h3><?php esc_html_e( 'Modula Roles', 'modula-best-grid-gallery' ) ?></h3>
			<p><?php esc_html_e( 'Gain even more control over how your galleries are handled with Modula User Roles. It allows admins to assign user roles that they find appropriate, giving as much access as they think it’s necessary to other users to edit or remove galleries, albums and defaults or presets.', 'modula-best-grid-gallery' ) ?></p>
			<p>
				<?php

				$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
				$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=roles-metabox&utm_campaign=modula-roles" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

				echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-whitelabel' );

				?>
			</p>
		</div>

		<?php
	}

	public function render_whitelabel_upsell() {
		?>

		<div class="modula-settings-upsell">
			<h3><?php esc_html_e( 'Modula Whitelabel', 'modula-best-grid-gallery' ) ?></h3>
			<p class="modula-upsell-content"><?php esc_html_e( 'You’re one step closer to becoming a renowned professional! Modula’s brand new Whitelabel addon gives agencies the advantage of replacing every occurrence of the plugin with their brand name and logo, seamlessly integrating the whole Modula pack into their product.', 'modula-best-grid-gallery' ); ?></p>
			<p>
				<?php

				$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
				$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=whitelabel-metabox&utm_campaign=modula-whitelabel" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

				echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-whitelabel' );

				?>
			</p>
		</div>

		<?php
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
				'title'    => esc_html__( 'Modula Albums', 'modula-best-grid-gallery' ),
				'callback' => 'output_upsell_albums',
				'context'  => 'normal',
				'priority' => 5,
		);

		return $met;
	}
	
	/**
	 * Show the albums modal to upgrade
	 *
	 * @since 2.3.0
	 */
	public function get_modal_albums_upgrade() {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon( 'modula-albums' ) ) {
			wp_die();
		}

		require MODULA_PATH . '/includes/admin/templates/modal/modula-modal-albums-upgrade.php';
		wp_die();
	}

	/**
	 * Show the albums modal to upgrade
	 *
	 * @since 2.3.0
	 */
	public function get_modal_albums_defaults_upgrade() {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon( 'modula-defaults' ) ) {
			wp_die();
		}

		require MODULA_PATH . '/includes/admin/templates/modal/modula-modal-albums-defaults-upgrade.php';
		wp_die();

	}

	/**
	 * Show the albums modal to upgrade
	 *
	 * @since 2.3.0
	 */
	public function get_modal_gallery_defaults_upgrade() {

		if ( $this->wpchill_upsells && ! $this->wpchill_upsells->is_upgradable_addon( 'modula-defaults' ) ) {
			wp_die();
		}

		require MODULA_PATH . '/includes/admin/templates/modal/modula-modal-gallery-defaults-upgrade.php';
		wp_die();

	}

	/**
	 * Add the Upgrade to PRO plugin action link
	 *
	 * @param $links
	 *
	 * @return array
	 *
	 * @since 2.6.0
	 */
	public function filter_action_links( $links ) {

		$upgrade = apply_filters( 'modula_upgrade_plugin_action', array(
				'upgrade_available' => true,
				'link'              => '<a  target="_blank" class="modula-lite-vs-pro" href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=plugin_settings&utm_campaign=upsell">' . esc_html__( 'Upgrade to PRO!', 'modula-best-grid-gallery' ) . '</a>'
		) );

		if ( ! $upgrade['upgrade_available'] ) {
			return $links;
		}

		array_unshift( $links, $upgrade['link'] );

		return $links;
	}


    /**
     * Render Speed Up Addon settings tab
     *
     * @since 2.5.6
     */
    public function render_speedup_tab() {
		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon('modula-speedup') ) {
			?>

			<div class="modula-settings-tab-upsell">
				<h3><?php esc_html_e( 'Modula SpeedUp', 'modula-best-grid-gallery' ) ?></h3>
				<p><?php esc_html_e( 'Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them through ShortPixel and serve them from StackPath\'s content delivery network.', 'modula-best-grid-gallery' ) ?></p>
				<p>
					<?php
	
					$buttons =  '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
					$buttons .=  '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-speedup_tab_upsell-tab&utm_campaign=modula-speedup" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';
	
					echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-speedup' );
					?>
				</p>
			</div>
	
			<?php
		}
    }

    /**
     * Render Advanced Shortcodes Addon settings tab
     *
     * @since 2.5.6
     */
    public function render_advanced_shortcodes_tab() {
		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon('modula-advanced-shortcodes') ) {
			?>

			<div class="modula-settings-tab-upsell">
				<h3><?php esc_html_e( 'Modula Advanced Shortcode', 'modula-best-grid-gallery' ) ?></h3>
				<p><?php esc_html_e( 'Allows you to dynamically link to specific galleries without creating pages for them by using URLs with query strings.', 'modula-best-grid-gallery' ) ?></p>
				<p>
					<?php
	
					$buttons =  '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
					$buttons .=  '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=advanced-shortcodes-metabox&utm_campaign=modula-advanced-shortcodes" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';
	
					echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-advanced-shortcodes' );
					?>
				</p>
			</div>
	
			<?php
		}
    }


    /**
     * Render Albums Addon settings tab
     *
     * @since 2.5.6
     */
    public function render_albums_tab() {
		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon('modula-albums') ) {
			?>

			<div class="modula-settings-tab-upsell">
				<h3><?php esc_html_e( 'Modula Albums', 'modula-best-grid-gallery' ) ?></h3>
				<p><?php esc_html_e( 'Give your galleries a place to call home with the Albums addon. Create albums, add galleries, manage cover photos, show gallery titles and even image counts in this superb add-on!', 'modula-best-grid-gallery' ) ?></p>
				<p>
					<?php
	
					$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
					$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-standalone-tab&utm_campaign=modula-albums" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';
	
					echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-albums' );
					?>
				</p>
			</div>
	
			<?php
		}
    }

    /**
     * Render Watermark Addon settings tab
     *
     * @since 2.5.6
     */
    public function render_watermark_tab() {
		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon('modula-watermark') ) {
			?>

			<div class="modula-settings-tab-upsell">
				<h3><?php esc_html_e( 'Modula Watermark', 'modula-best-grid-gallery' ); ?></h3>
				<p><?php esc_html_e( 'Easily protect your photos by adding custom watermarks to your WordPress image galleries with Modula.', 'modula-best-grid-gallery' ); ?></p>
				<p>
					<?php
	
					$buttons =  '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
					$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=modula-watermark_tab_upsell-tab&utm_campaign=modula-watermark" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

					echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-watermark' );
	
					?>
				</p>
			</div>
	
			<?php
		}
    }

    /**
     * Render Roles Addon settings tab
     *
     * @since 2.5.6
     */
    public function render_roles_tab() {
		if ( $this->wpchill_upsells && $this->wpchill_upsells->is_upgradable_addon('modula-roles') ) {
			?>

			<div class="modula-settings-tab-upsell">
				<h3><?php esc_html_e( 'Modula Roles', 'modula-best-grid-gallery' ) ?></h3>
				<p><?php esc_html_e( 'Granular control over which user roles can add, edit or update galleries on your website. Add permissions to an existing user role or remove them by simply checking a checkbox.' ) ?></p>
				<p>
					<?php
	
					$buttons = '<a target="_blank" href="' . esc_url( $this->free_vs_pro_link ) . '" class="button">' . esc_html__( 'Free vs PRO', 'modula-best-grid-gallery' ) . '</a>';
					$buttons .= '<a target="_blank" href="https://wp-modula.com/pricing/?utm_source=upsell&utm_medium=roles-metabox&utm_campaign=modula-roles" style="margin-top:10px;" class="button-primary button">' . esc_html__( 'Get PRO!', 'modula-best-grid-gallery' ) . '</a>';

					echo apply_filters( 'modula_upsell_buttons', $buttons, 'modula-roles' );
					?>
				</p>
			</div>
	
			<?php
		}
    }


	public function remove_upsells_badge( $tabs ){
		$tabs_slugs = array(
			'shortcodes'  => 'modula-advanced-shortcodes',
			'standalone'  => 'modula-albums',
			'watermark'   => 'modula-watermark',
			'compression' => 'modula-speedup',
			'roles'       => 'modula-roles'
		);

		foreach ($tabs as $key => $tab){
			if( isset( $tabs_slugs[$key] ) && $this->wpchill_upsells && !$this->wpchill_upsells->is_upgradable_addon( $tabs_slugs[$key] ) ){
				unset($tabs[$key]['badge']);
			}
		}
	return $tabs;
	}

}
