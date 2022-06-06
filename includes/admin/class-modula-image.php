<?php

/**
 * 
 */
class Modula_Image {
	
	function __construct() {}

	/**
	 * Helper method to return the image size depending on image orientation( landscape/portrait ).
	 *
	 * @param int    $id The image ID.
	 * @param string $type
	 * @param array  $sizes
	 * @param        $crop
	 *
	 * @return WP_Error|string Return WP_Error on error, array of data on success.
	 * @since 2.0.0
	 *
	 */
	public function get_image_size( $id, $type = 'creative-gallery', $sizes = array(), $crop = false ) {

		$image_full = wp_get_attachment_image_src( $id, 'full' );

		if ( $image_full ) {

			$return = array(
				'url' => $image_full[0],
			);

			$gallery_types = array( 'creative-gallery','custom-grid','grid' );

			if( in_array( $type, $gallery_types ) ) {

				if ( is_array( $sizes ) && ! empty( $sizes ) ) {

					if ( ! $crop ){

						$ratio  = (float)( (int)$image_full[1] / (int)$image_full[2] );
						$width  = absint($sizes['width']);
						$height = absint($sizes['height']);

                        if (0 == $width || 0 == $height) {
                            if (0 == $width) {
                                $width = $height * $ratio;
                            } else {
                                $height = $width / $ratio;
                            }
                        } elseif ( $sizes['width'] / $sizes['height'] != $image_full[1] / $image_full[2] ) {

							if ( $sizes['width'] <= $sizes['height']   ){
								$height = $sizes['width'] / $ratio;
							} else {
								$width = $sizes['height'] * $ratio;
							}

						}

                        if ( $width > $image_full[1] || $height > $image_full[2] ) {
                            $return['width']  = $image_full[1];
                            $return['height'] = $image_full[2];
                        }else{
                            $return['width']  = (int)$width;
                            $return['height'] = (int)$height;
                        }

						
					} else {

                        if ( $sizes['width'] > $image_full[1] || $sizes['height'] > $image_full[2] ) {
                            $return['width']  = $image_full[1];
                            $return['height'] = $image_full[2];
                        }else{
                            $return['width']  = $sizes['width'];
                            $return['height'] = $sizes['height'];
                        }

					}

				} else {

					$image_sizes = wp_get_attachment_image_src( $id, $sizes );

					if ( $image_sizes ){
						$return['width']     = $image_sizes[1];
						$return['height']    = $image_sizes[2];
						$return['thumb_url'] = $image_sizes[0];
					}

				}
			} else {
				$return = apply_filters( "modula_resize_image_{$type}", $return, $id, $sizes, $crop );
			}

			return $return;

		}else{
			return new WP_Error( 'modula-gallery-error-no-url', esc_html__( 'No image with this ID.', 'modula-best-grid-gallery' ) );
		}

	}

	/**
     * Helper method to return common information about an image.
     *
     * @since 2.0.0
     *
     * @param array $args      List of resizing args to expand for gathering info.
     * @return WP_Error|string Return WP_Error on error, array of data on success.
     */
    public function get_image_info( $args ) {

        // Unpack arguments.
        list( $url, $width, $height, $crop, $align, $quality, $retina, $data ) = $args;

        // Return an error if no URL is present.
        if ( empty( $url ) ) {
            return new WP_Error( 'modula-gallery-error-no-url', esc_html__( 'No image URL specified for cropping.', 'modula-best-grid-gallery' ) );
        }

        // Get the image file path.
        $urlinfo       = parse_url( $url );
        $wp_upload_dir = wp_upload_dir();

        // Interpret the file path of the image.
        if ( preg_match( '/\/[0-9]{4}\/[0-9]{2}\/.+$/', $urlinfo['path'], $matches ) ) {
            $file_path = $wp_upload_dir['basedir'] . $matches[0];
        } else {
            $pathinfo    = parse_url( $url );
            // $uploads_dir = is_multisite() ? '/files/' : '/wp-content/';
            $uploads_dir = is_multisite() ? '/files/' : '/' . str_replace( ABSPATH, '', WP_CONTENT_DIR ) . '/';
            $file_path   = ABSPATH . str_replace( dirname( isset( $_SERVER['SCRIPT_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ) : '' ) . '/', '', strstr( $pathinfo['path'], $uploads_dir ) );
            $file_path   = preg_replace( '/(\/\/)/', '/', $file_path );
        }

        // Attempt to stream and import the image if it does not exist based on URL provided.
        if ( ! file_exists( $file_path ) ) {
            return new WP_Error( 'modula-gallery-error-no-file', esc_html__( 'No file could be found for the image URL specified.', 'modula-best-grid-gallery' ) );
        }

        // Attempt to stream and import the image if it does not exist based on URL provided.
        if ( ! file_exists( $file_path ) ) {
            return new WP_Error( 'modula-gallery-error-no-file', esc_html__( 'No file could be found for the image URL specified.', 'modula-best-grid-gallery' ) );
        }

        // Get original image size.
        $size = @getimagesize( $file_path );

        // If no size data obtained, return an error.
        if ( ! $size ) {
            return new WP_Error( 'modula-gallery-error-no-size', esc_html__( 'The dimensions of the original image could not be retrieved for cropping.', 'modula-best-grid-gallery' ) );
        }

        // Set original width and height.
        list( $orig_width, $orig_height, $orig_type ) = $size;

        // Generate width or height if not provided.
        if ( $width && ! $height ) {
            $height = floor( $orig_height * ($width / $orig_width) );
        } else if ( $height && ! $width ) {
            $width = floor( $orig_width * ($height / $orig_height) );
        } else if ( ! $width && ! $height ) {
            return new WP_Error( 'modula-gallery-error-no-size', esc_html__( 'The dimensions of the original image could not be retrieved for cropping.', 'modula-best-grid-gallery' ) );
        }

        // Allow for different retina image sizes.
        $retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

        // Destination width and height variables
        $dest_width  = $width * $retina;
        $dest_height = $height * $retina;

        // Some additional info about the image.
        $info = pathinfo( $file_path );
        $dir  = $info['dirname'];
        $ext  = $info['extension'];
        $name = wp_basename( $file_path, ".$ext" );

        // Suffix applied to filename
        $suffix = "${dest_width}x${dest_height}";

        // Set alignment information on the file.
        if ( $crop ) {
            $suffix .= ( $align ) ? "_${align}" : "_c";
        }

        // Get the destination file name
        $dest_file_name = "${dir}/${name}-${suffix}.${ext}";

        // Return the info.
        $info = array(
            'dir'            => $dir,
            'name'           => $name,
            'ext'            => $ext,
            'suffix'         => $suffix,
            'orig_width'     => $orig_width,
            'orig_height'    => $orig_height,
            'orig_type'      => $orig_type,
            'dest_width'     => $dest_width,
            'dest_height'    => $dest_height,
            'file_path'      => $file_path,
            'dest_file_name' => $dest_file_name,
        );

        return $info;

    }

	/**
     * Method for cropping & resize images.
     *
     * @since 2.0.0
     *
     * @global object $wpdb The $wpdb database object.
     *
     * @param string $url      The URL of the image to resize.
     * @param int $width       The width for cropping the image.
     * @param int $height      The height for cropping the image.
     * @param bool $crop       Whether or not to crop the image (default yes).
     * @param string $align    The crop position alignment.
     * @param bool $retina     Whether or not to make a retina copy of image.
     * @param array $data      Array of gallery data (optional).
     * @param bool $force_overwrite      Forces an overwrite even if the thumbnail already exists (useful for applying watermarks)
     * @return WP_Error|string Return WP_Error on error, URL of resized image on success.
     */
    public function resize_image( $url, $width = null, $height = null, $crop = false, $align = 'c', $quality = 100, $retina = false, $data = array(), $force_overwrite = false ) {

        global $wpdb;
        $upload_dir = wp_upload_dir();

        // Get common vars.
        $args   = array( $url, $width, $height, $crop, $align, $quality, $retina, $data );

        // Filter args
        $args = apply_filters( 'modula_gallery_resize_image_args', $args );

        // Don't resize images that don't belong to this site's URL
        // Strip ?lang=fr from blog's URL - WPML adds this on
        // and means our next statement fails
        if ( is_multisite() ) {
            $site_url = preg_replace( '/\?.*/', '', network_site_url() );
        } else {
            $site_url = preg_replace( '/\?.*/', '', get_bloginfo( 'url' ) );
        }

        // WPML check - if there is a /fr or any domain in the url, then remove that from the $site_url
        if ( defined('ICL_LANGUAGE_CODE') ) {
            if ( strpos( $site_url, '/'.ICL_LANGUAGE_CODE ) !== false ) {
                $site_url = str_replace( '/'.ICL_LANGUAGE_CODE, '', $site_url );
            }
        }

        if ( strpos( $url, $site_url ) === false ) {
            return $url;
        }

	    // Get image info
        $common = $this->get_image_info( $args );

        // Unpack variables if an array, otherwise return WP_Error.
        if ( is_wp_error( $common ) ) {
            return $common;
        } else {
            extract( $common );
        }

        // If the destination width/height values are the same as the original, don't do anything.
        if ( !$force_overwrite && $orig_width === $dest_width && $orig_height === $dest_height ) {
	        return array(
		        'resized_url' => $url,
		        'image_info'  => $common
	        );
        }

	    // If the file doesn't exist yet, we need to create it.
        if ( ! file_exists( $dest_file_name ) || ( file_exists( $dest_file_name ) && $force_overwrite ) ) {

            // We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
            $_wp_attached_file = str_replace( $upload_dir['baseurl'] . '/' , '', $url );
            $get_attachment = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_wp_attached_file' AND meta_value='%s'", $_wp_attached_file ) );

            // Load the WordPress image editor.
            $editor = wp_get_image_editor( $file_path );

            // If an editor cannot be found, the user needs to have GD or Imagick installed.
            if ( is_wp_error( $editor ) ) {
                return new WP_Error( 'modula-gallery-error-no-editor', esc_html__( 'No image editor could be selected. Please verify with your webhost that you have either the GD or Imagick image library compiled with your PHP install on your server.', 'modula-best-grid-gallery' ) );
            }

            // Set the image editor quality.
            $editor->set_quality( $quality );

            // If cropping, process cropping.
            if ( $crop ) {
                $src_x = $src_y = 0;
                $src_w = $orig_width;
                $src_h = $orig_height;

                $cmp_x = $orig_width / $dest_width;
                $cmp_y = $orig_height / $dest_height;

                // Calculate x or y coordinate and width or height of source
                if ( $cmp_x > $cmp_y ) {
                    $src_w = round( $orig_width / $cmp_x * $cmp_y );
                    $src_x = round( ($orig_width - ($orig_width / $cmp_x * $cmp_y)) / 2 );
                } else if ( $cmp_y > $cmp_x ) {
                    $src_h = round( $orig_height / $cmp_y * $cmp_x );
                    $src_y = round( ($orig_height - ($orig_height / $cmp_y * $cmp_x)) / 2 );
                }

                // Positional cropping.
                if ( $align && $align != 'c' ) {
                    if ( strpos( $align, 't' ) !== false || strpos( $align, 'tr' ) !== false || strpos( $align, 'tl' ) !== false ) {
                        $src_y = 0;
                    }

                    if ( strpos( $align, 'b' ) !== false || strpos( $align, 'br' ) !== false || strpos( $align, 'bl' ) !== false ) {
                        $src_y = $orig_height - $src_h;
                    }

                    if ( strpos( $align, 'l' ) !== false ) {
                        $src_x = 0;
                    }

                    if ( strpos ( $align, 'r' ) !== false ) {
                        $src_x = $orig_width - $src_w;
                    }
                }

                // Crop the image.
                $editor->crop( $src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height );
            } else {
                // Just resize the image.
                $editor->resize( $dest_width, $dest_height );
            }

            // Save the image.
            $saved = $editor->save( $dest_file_name );

            // Print possible out of memory errors.
            if ( is_wp_error( $saved ) ) {
                @unlink( $dest_file_name );
                return $saved;
            }

            // Add the resized dimensions and alignment to original image metadata, so the images
            // can be deleted when the original image is delete from the Media Library.
            if ( $get_attachment ) {
                $metadata = wp_get_attachment_metadata( $get_attachment );

                if ( isset( $metadata['image_meta'] ) ) {

                    $md = $suffix;

                    if( ! isset( $metadata['image_meta']['resized_images'] ) ) {
                        $metadata['image_meta']['resized_images'] = array();
                    }
                    
                    $metadata['image_meta']['resized_images'][] = $md;
                    wp_update_attachment_metadata( $get_attachment, $metadata );
                }
            }

            // Set the resized image URL.
            $resized_url = str_replace( basename( $url ), basename( $saved['path'] ), $url );
        } else {
            // Set the resized image URL.
            $resized_url = str_replace( basename( $url ), basename( $dest_file_name ), $url );
        }

	    $return = array(
		    'resized_url' => $resized_url,
		    'image_info'  => $common
	    );
        // Return the resized image URL.
        return $return;

    }

}