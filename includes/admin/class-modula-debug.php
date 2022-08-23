<?php


class Modula_Debug {

	/**
	 * Holds the class object.
	 *
	 * @since 2.5.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Modula_Debug constructor.
	 *
	 * @since 2.5.0
	 */
	function __construct() {
		// Add Modula's debug information
		add_filter( 'debug_information', array( $this, 'modula_debug_information' ), 60, 1 );

		add_action( 'admin_init', array( $this, 'modula_export_gallery' ) );

		/* Fire our meta box setup function on the post editor screen. */
		add_action( 'load-post.php', array( $this, 'debug_meta_box_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'debug_meta_box_setup' ) );
	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Debug object.
	 * @since 2.5.0
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !( self::$instance instanceof Modula_Debug ) ) {
			self::$instance = new Modula_Debug();
		}

		return self::$instance;

	}

	/**
	 * Modula Debug Info
	 *
	 * @param $info
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function modula_debug_information($info){

		$troubleshoot_opt = get_option( 'modula_troubleshooting_option' );
		$grid_type = '';
		$lightboxes = '';

		if ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'gridtypes' ] ) && !empty( $troubleshoot_opt[ 'gridtypes' ] ) ) {
			foreach ( $troubleshoot_opt[ 'gridtypes' ] as $type ) {
				$grid_type .= '{' . $type . '}';
			}
		}

		if ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lightboxes' ] ) && !empty( $troubleshoot_opt[ 'lightboxes' ] ) ) {
			foreach ( $troubleshoot_opt[ 'lightboxes' ] as $lightbox ) {
				$lightboxes .= '{' . $lightbox . '}';
			}
		}

		$info[ 'modula' ] = array(
			'label'  => __( 'Modula plugin' ),
			'fields' => apply_filters( 'modula_debug_information', array(
					'core_version'             => array(
						'label' => __( 'Core Version', 'modula-best-grid-gallery' ),
						'value' => MODULA_LITE_VERSION,
						'debug' => 'Core version ' . MODULA_LITE_VERSION,
					),
					'requested_php'            => array(
						'label' => __( 'Minimum PHP' ),
						'value' => 5.6,
						'debug' => ( (float)5.6 > (float)phpversion() ) ? 'PHP minimum version not met' : 'PHP minimum version met',
					),
					'requested_wp'             => array(
						'label' => __( 'Minimum WP', 'modula-best-grid-gallery' ),
						'value' => 5.2,
						'debug' => ( (float)get_bloginfo( 'version' ) < (float)5.2 ) ? 'WordPress minimum version not met.Current version: ' . get_bloginfo( 'version' ) : 'Wordpress minimum version met. Current version: ' . get_bloginfo( 'version' ),
					),
					'galleries_number'         => array(
						'label' => __( 'Total galleries', 'modula-best-grid-gallery' ),
						'value' => count( Modula_Helper::get_galleries() ) - 1,
						'debug' => 'Total number of galleries: ' . ( count( Modula_Helper::get_galleries() ) - 1 )
					),
					'track_data'               => array(
						'label' => __( 'Track data', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'track_data' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'track_data' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? 'Track data enabled' : 'Track data disabled'
					),
					'enqueue_files'            => array(
						'label' => __( 'Enqueue Modula\'s assets everywhere', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && '1' == $troubleshoot_opt[ 'track_data' ] ) ? 'Enqueue files everywhere' : 'Enqueue files disabled'
					),
					'grid_type'                => array(
						'label' => __( 'General grid type enqueued', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'gridtypes' ] ) && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && !empty( $troubleshoot_opt[ 'gridtypes' ] ) ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'gridtypes' ] ) && isset( $troubleshoot_opt[ 'enqueue_files' ] ) && !empty( $troubleshoot_opt[ 'gridtypes' ] ) ) ? 'Enqueue files for: ' . $grid_type : 'No grid type selected'
					),
					'lightboxes'               => array(
						'label' => __( 'Lightboxes everywhere', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lightboxes' ] ) && !empty( $troubleshoot_opt[ 'lightboxes' ] ) ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lightboxes' ] ) && !empty( $troubleshoot_opt[ 'lightboxes' ] ) ) ? 'Enqueue files for: ' . $lightboxes : 'No lightbox selected'
					),
					'modula_lazyload'          => array(
						'label' => __( 'Enable general lazyload', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lazy_load' ] ) && '1' == $troubleshoot_opt[ 'lazy_load' ] ) ? __( 'Enabled', 'modula-best-grid-gallery' ) : __( 'Disabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'lazy_load' ] ) && '1' == $troubleshoot_opt[ 'lazy_load' ] ) ? 'General lazyload enabled: ' : 'No general lazyload'
					),
					'modula_edit_gallery_link' => array(
						'label' => __( '"Edit gallery" link', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'disable_edit' ] ) && '1' == $troubleshoot_opt[ 'disable_edit' ] ) ? __( 'Disabled', 'modula-best-grid-gallery' ) : __( 'Enabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'disable_edit' ] ) && '1' == $troubleshoot_opt[ 'disable_edit' ] ) ? 'Edit gallery link disabled: ' : 'Edit gallery link enabled'
					),
					'modula_disable_srcset' => array(
						'label' => __( 'Disable images srcset', 'modula-best-grid-gallery' ),
						'value' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'disable_srcset' ] ) && '1' == $troubleshoot_opt[ 'disable_srcset' ] ) ? __( 'Disabled', 'modula-best-grid-gallery' ) : __( 'Enabled', 'modula-best-grid-gallery' ),
						'debug' => ( $troubleshoot_opt && isset( $troubleshoot_opt[ 'disable_srcset' ] ) && '1' == $troubleshoot_opt[ 'disable_srcset' ] ) ? 'srcset is disabled: ' : 'srcset is enabled'
					),
				)
			)
		);

		return $info;
	}

	/**
	 * Export single gallery
	 *
	 * @since 2.5.0
	 */
	public function modula_export_gallery(){

		if ( isset( $_GET['modula_single_download'] ) ){

			// WXR_VERSION is declared here
			require_once ABSPATH . 'wp-admin/includes/export.php';

			$post = get_post( absint( $_GET['modula_single_download'] ) );

			if ( !$post || 'modula-gallery' != $post->post_type ){
				return;
			}

			global $wpdb;

			$gallery_name = sanitize_key( $post->post_name );
			if ( !empty( $gallery_name ) ){
				$gallery_name .= '.';
			}
			$date        = gmdate( 'Y-m-d' );
			$wp_filename = $gallery_name . $date . '.xml';

			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=' . $wp_filename );
			header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );

			echo '<?xml version="1.0" encoding="' . esc_html( get_bloginfo( 'charset' ) ) . "\" ?>\n";

			?>
			<!-- This is a WordPress eXtended RSS file generated by WordPress as an export of your site. -->
			<!-- It contains information about your site's posts, pages, comments, categories, and other content. -->
			<!-- You may use this file to transfer that content from one site to another. -->
			<!-- This file is not intended to serve as a complete backup of your site. -->

			<!-- To import this information into a WordPress site follow these steps: -->
			<!-- 1. Log in to that site as an administrator. -->
			<!-- 2. Go to Tools: Import in the WordPress admin panel. -->
			<!-- 3. Install the "WordPress" importer from the list. -->
			<!-- 4. Activate & Run Importer. -->
			<!-- 5. Upload this file using the form provided on that page. -->
			<!-- 6. You will first be asked to map the authors in this export file to users -->
			<!--    on the site. For each author, you may choose to map to an -->
			<!--    existing user on the site or to create a new user. -->
			<!-- 7. WordPress will then import each of the posts, pages, comments, categories, etc. -->
			<!--    contained in this file into your site. -->

			<rss version="2.0"
				 xmlns:excerpt="http://wordpress.org/export/<?php echo esc_html( WXR_VERSION ); ?>/excerpt/"
				 xmlns:content="http://purl.org/rss/1.0/modules/content/"
				 xmlns:wfw="http://wellformedweb.org/CommentAPI/"
				 xmlns:dc="http://purl.org/dc/elements/1.1/"
				 xmlns:wp="http://wordpress.org/export/<?php echo esc_html( WXR_VERSION ); ?>/"
			>

				<channel>
					<title><?php bloginfo_rss( 'name' ); ?></title>
					<link><?php bloginfo_rss( 'url' ); ?></link>
					<description><?php bloginfo_rss( 'description' ); ?></description>
					<pubDate><?php echo esc_html( gmdate( 'D, d M Y H:i:s +0000' ) ); ?></pubDate>
					<language><?php bloginfo_rss( 'language' ); ?></language>
					<wp:wxr_version><?php echo esc_html( WXR_VERSION ); ?></wp:wxr_version>

					<?php

					$title = $post->post_title;

					?>
					<item>
						<title><?php echo esc_html( $title ); ?></title>
						<link><?php the_permalink_rss(); ?></link>
						<pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ), false ); ?></pubDate>
						<dc:creator><?php echo $this->wxr_cdata( get_the_author_meta( 'login' ) ); ?></dc:creator>
						<guid isPermaLink="false"><?php the_guid(); ?></guid>
						<description></description>
						<wp:post_id><?php echo (int)$post->ID; ?></wp:post_id>
						<wp:post_date><?php echo $this->wxr_cdata( $post->post_date ); ?></wp:post_date>
						<wp:post_date_gmt><?php echo $this->wxr_cdata( $post->post_date_gmt ); ?></wp:post_date_gmt>
						<wp:comment_status><?php echo $this->wxr_cdata( $post->comment_status ); ?></wp:comment_status>
						<wp:ping_status><?php echo $this->wxr_cdata( $post->ping_status ); ?></wp:ping_status>
						<wp:post_name><?php echo $this->wxr_cdata( $post->post_name ); ?></wp:post_name>
						<wp:status><?php echo $this->wxr_cdata( $post->post_status ); ?></wp:status>
						<wp:post_parent><?php echo (int)$post->post_parent; ?></wp:post_parent>
						<wp:menu_order><?php echo (int)$post->menu_order; ?></wp:menu_order>
						<wp:post_type><?php echo $this->wxr_cdata( $post->post_type ); ?></wp:post_type>
						<wp:post_password><?php echo $this->wxr_cdata( $post->post_password ); ?></wp:post_password>
						<?php
						$postmeta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id = %d", $post->ID ) );
						foreach ( $postmeta as $meta ) :
							/**
							 * Filters whether to selectively skip post meta used for WXR exports.
							 *
							 * Returning a truthy value from the filter will skip the current meta
							 * object from being exported.
							 *
							 * @param bool   $skip     Whether to skip the current post meta. Default false.
							 * @param string $meta_key Current meta key.
							 * @param object $meta     Current meta object.
							 *
							 * @since 3.3.0
							 *
							 */
							if ( apply_filters( 'wxr_export_skip_postmeta', false, $meta->meta_key, $meta ) ){
								continue;
							}
							?>
							<wp:postmeta>
								<wp:meta_key><?php echo $this->wxr_cdata( $meta->meta_key ); ?></wp:meta_key>
								<wp:meta_value><?php echo $this->wxr_cdata( $meta->meta_value ); ?></wp:meta_value>
							</wp:postmeta>
						<?php
						endforeach;
						?>
					</item>
				</channel>
			</rss>
			<?php
			die();
		}
	}

	/**
	 * Wrap given string in XML CDATA tag.
	 *
	 * @param string $str String to wrap in XML CDATA tag.
	 *
	 * @return string
	 * @since 2.5.0
	 *
	 */
	private	function wxr_cdata( $str ){
		if ( !seems_utf8( $str ) ){
			$str = utf8_encode( $str );
		}
		// $str = ent2ncr(esc_html($str));
		$str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', wp_kses_post( $str ) ) . ']]>';

		return $str;
	}

	/**
	 * Add Debug metabox
	 *
	 * @since 2.5.0
	 */
	public function debug_meta_box_setup() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array( $this, 'add_debug_meta_box' ),10 );

	}

	/**
	 * Add Debug metabox
	 *
	 * @since 2.5.0
	 */
	public function add_debug_meta_box() {
		add_meta_box(
				'modula-debug',      // Unique ID
				esc_html__('Debug gallery', 'modula-best-grid-gallery'),    // Title
				array( $this, 'output_debug_meta' ),   // Callback function
				'modula-gallery',         // Admin page (or post type)
				'side',         // Context
				'low'         // Priority
		);

	}

	/**
	 * Output the Debug Gallery metabox
	 *
	 * @since 2.4.0
	 */
	public function output_debug_meta(){
		?>
		<div class="modula-upsells-carousel-wrapper">
			<div class="modula-upsells-carousel">
				<div class="modula-upsell modula-upsell-item">
					<p class="modula-upsell-description"><?php echo esc_html__( 'Export gallery and send it to Modula\'s support team so that we can debug your problem much easier.', 'modula-best-grid-gallery' ); ?></p>
					<p>
						<a href="<?php echo esc_url( add_query_arg( array(
								'modula_single_download' => absint( get_the_ID() ),
						) ) ); ?>"
						   class="button"><?php esc_html_e( 'Export gallery', 'modula-best-grid-gallery' ) ?></a>

					</p>
					<?php do_action('modula_debug_metabox_content'); ?>
				</div>
			</div>
		</div>
		<?php
	}

}

$modula_Debug = Modula_Debug::get_instance();