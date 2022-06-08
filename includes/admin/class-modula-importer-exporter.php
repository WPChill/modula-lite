<?php

/**
 * Class Modula_Exporter
 *
 * exports galleries along with their images
 *
 * @since 2.36
 */
class Modula_Importer_Exporter {

	protected $processed_attachments = array();
	protected $processed_galleries   = array();

	public function __construct() {

		// Export Images with galleries
		add_action( 'export_wp', array( $this, 'check_if_we_need_to_import_images' ) );

		// Importer images
		add_action( 'import_start', array( $this, 'start_import' ), 10 );
		add_action( 'import_end', array( $this, 'change_meta_on_import' ), 10 );

	}

	public function start_import(){

		add_filter( 'wp_import_post_terms', array( $this, 'save_att_imported' ), 10, 3 );

	}

	public function check_if_we_need_to_import_images( $args ){

		if ( 'modula-gallery' == $args['content'] ) {
			add_action( 'rss2_head', array( $this, 'export_images' ), 99 );
		}

	}

	public function export_images(){
		global $wpdb;

		$already_exported = array();

		$query = "SELECT meta_value FROM {$wpdb->postmeta}, {$wpdb->posts} WHERE meta_key = 'modula-images' AND post_id=ID AND post_type='modula-gallery'";
		$metas = $wpdb->get_col( $query );

		foreach ( $metas as $meta ) {
			$images = maybe_unserialize( $meta );
			if ( is_array( $images ) ) {
				foreach ( $images as $image ) {

					if ( in_array( $image['id'], $already_exported ) ) {
						continue;
					}else{
						$already_exported[] = $image['id'];
					}

					$post = get_post( $image['id'] );
					setup_postdata( $post );

					/** This filter is documented in wp-includes/feed.php */
					$title = apply_filters( 'the_title_rss', $post->post_title );
					/**
					 * Filters the post content used for WXR exports.
					 *
					 * @since 2.5.0
					 *
					 * @param string $post_content Content of the current post.
					 */
					$content = wxr_cdata( apply_filters( 'the_content_export', $post->post_content ) );
					/**
					 * Filters the post excerpt used for WXR exports.
					 *
					 * @since 2.6.0
					 *
					 * @param string $post_excerpt Excerpt for the current post.
					 */
					$excerpt = wxr_cdata( apply_filters( 'the_excerpt_export', $post->post_excerpt ) );

					?>

					<item>
						<title><?php echo esc_html( $title ); ?></title>
						<link><?php the_permalink_rss(); ?></link>
						<pubDate><?php echo esc_html( mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ), false ) ); ?></pubDate>
						<dc:creator><?php echo wxr_cdata( get_the_author_meta( 'login' ) ); ?></dc:creator>
						<guid isPermaLink="false"><?php the_guid(); ?></guid>
						<description></description>
						<content:encoded><?php echo $content; ?></content:encoded>
						<excerpt:encoded><?php echo $excerpt; ?></excerpt:encoded>
						<wp:post_id><?php echo intval( $post->ID ); ?></wp:post_id>
						<wp:post_date><?php echo wxr_cdata( $post->post_date ); ?></wp:post_date>
						<wp:post_date_gmt><?php echo wxr_cdata( $post->post_date_gmt ); ?></wp:post_date_gmt>
						<wp:comment_status><?php echo wxr_cdata( $post->comment_status ); ?></wp:comment_status>
						<wp:ping_status><?php echo wxr_cdata( $post->ping_status ); ?></wp:ping_status>
						<wp:post_name><?php echo wxr_cdata( $post->post_name ); ?></wp:post_name>
						<wp:status><?php echo wxr_cdata( $post->post_status ); ?></wp:status>
						<wp:post_parent><?php echo intval( $post->post_parent ); ?></wp:post_parent>
						<wp:menu_order><?php echo intval( $post->menu_order ); ?></wp:menu_order>
						<wp:post_type><?php echo wxr_cdata( $post->post_type ); ?></wp:post_type>
						<wp:post_password><?php echo wxr_cdata( $post->post_password ); ?></wp:post_password>
						<?php	if ( $post->post_type == 'attachment' ) : ?>
							<wp:attachment_url><?php echo wxr_cdata( wp_get_attachment_url( $post->ID ) ); ?></wp:attachment_url>
						<?php endif; ?>
						<?php
						$postmeta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id = %d", $post->ID ) );
						foreach ( $postmeta as $meta ) :
							/**
							 * Filters whether to selectively skip post meta used for WXR exports.
							 *
							 * Returning a truthy value to the filter will skip the current meta
							 * object from being exported.
							 *
							 * @since 3.3.0
							 *
							 * @param bool   $skip     Whether to skip the current post meta. Default false.
							 * @param string $meta_key Current meta key.
							 * @param object $meta     Current meta object.
							 */
							if ( apply_filters( 'wxr_export_skip_postmeta', false, $meta->meta_key, $meta ) ) {
								continue;
							}
							?>
							<wp:postmeta>
							<wp:meta_key><?php echo wxr_cdata( $meta->meta_key ); ?></wp:meta_key>
							<wp:meta_value><?php echo wxr_cdata( $meta->meta_value ); ?></wp:meta_value>
							</wp:postmeta>
						<?php endforeach; ?>
						</item>
		<?php
				}
			}
		}

	}

	public function save_att_imported( $terms, $post_id, $post ){

		if ( 'attachment' == $post['post_type'] ) {
			$this->processed_attachments[ $post['post_id'] ] = $post_id;
		}elseif ( 'modula-gallery' == $post['post_type'] ) {
			$this->processed_galleries[ $post['post_id'] ] = $post_id;
		}

		return $terms;

	}

	public function change_meta_on_import(){

		if ( empty( $this->processed_galleries ) ) {
			return;
		}

		foreach ( $this->processed_galleries as $original_post_ID => $post_id ) {
			
			$modula_images = array();
			$gallery_meta = get_post_meta( $post_id, 'modula-images', true );

			if ( is_array( $gallery_meta ) ) {
				foreach ( $gallery_meta as $index => $modula_image ) {
					
					if ( ! isset( $this->processed_attachments[ $modula_image['id'] ] ) ) {
						$modula_images[ $index ] = $modula_image;
						continue;
					}

					if ( $this->processed_attachments[ $modula_image['id'] ] != $modula_image['id'] ) {
						$modula_image['id'] = $this->processed_attachments[ $modula_image['id'] ];
					}

					$modula_images[ $index ] = $modula_image;

				}
			}

			update_post_meta( $post_id, 'modula-images', $modula_images );

		}

		$arr = array(
			'att' => $this->processed_attachments,
			'galleries' => $this->processed_galleries
		);

		$file = MODULA_PATH . 'import_file.txt';
		file_put_contents($file, print_r( $arr, true ), FILE_APPEND );

	}


}

new Modula_Importer_Exporter();

