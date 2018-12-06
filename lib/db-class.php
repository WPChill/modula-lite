<?php

class ModulaLiteDB {

	private static $pInstance;

	private function __construct() {
	}

	public static function getInstance() {
		if ( ! self::$pInstance ) {
			self::$pInstance = new ModulaLiteDB();
		}

		return self::$pInstance;
	}

	public function query() {
		return "Test";
	}

	public function sanitize_config( $config ) {

		if ( ! is_array( $config ) ) {
			$config = json_decode( $config );
		}

		$fields = array(
			'name',
			'description',
			'width',
			'height',
			'img_size',
			'margin',
			'randomFactor',
			'lightbox',
			'shuffle',
			'captionColor',
			'wp_field_caption',
			'wp_field_title',
			'hide_title',
			'hide_description',
			'captionFontSize',
			'titleFontSize',
			'enableTwitter',
			'enableFacebook',
			'enableGplus',
			'enablePinterest',
			'socialIconColor',
			'loadedScale',
			'Effect',
			'borderSize',
			'borderRadius',
			'borderColor',
			'shadowSize',
			'shadowColor',
			'script',
			'style'
		);

		$new_config = array();
		$lightbox_values = array( '', 'direct', 'lightbox2' );
		$checkboxes_values = array( 'T', 'F' );
		$effect_values = array( 'none', 'pufrobo' );
		foreach ( $fields as $field ) {
			if ( isset( $config[ $field ] ) ) {
				
				switch ( $field ) {
					case 'description':
						$new_config[ $field ] = wp_filter_post_kses( $config[ $field ] );
						break;

					case 'height':
					case 'img_size':
					case 'margin':
					case 'randomFactor':
					case 'captionFontSize':
					case 'titleFontSize':
					case 'loadedScale':
					case 'borderSize':
					case 'borderRadius':
					case 'shadowSize':
						$new_config[ $field ] = absint( $config[ $field ] );
						break;

					case 'lightbox' :
						if ( in_array( $config[ $field ], $lightbox_values ) ) {
							$new_config[ $field ] = $config[ $field ];
						}else{
							$new_config[ $field ] = 'lightbox2';
						}
						break;

					case 'shuffle' :
						if ( in_array( $config[ $field ], $checkboxes_values ) ) {
							$new_config[ $field ] = $config[ $field ];
						}else{
							$new_config[ $field ] = 'F';
						}
						break;

					case 'enableTwitter' :
					case 'enableFacebook' :
					case 'enableGplus' :
					case 'enablePinterest' :
						if ( in_array( $config[ $field ], $checkboxes_values) ) {
							$new_config[ $field ] = $config[ $field ];
						}else{
							$new_config[ $field ] = 'T';
						}
						break;

					case 'captionColor':
					case 'socialIconColor':
					case 'borderColor':
					case 'shadowColor':
						$new_config[ $field ] = sanitize_hex_color( $config[ $field ] );
						break;

					case 'Effect' :
						if ( in_array( $config[ $field ], $effect_values ) ) {
							$new_config[ $field ] = $config[ $field ];
						}else{
							$new_config[ $field ] = 'pufrobo';
						}
						break;

					default:
						$new_config[ $field ] = sanitize_text_field( $config[ $field ] );
						break;
				}

			}
			
		}

		return $new_config;
	}

	public function update_config( $id, $config ) {
		global $wpdb;

		unset( $config->Id );

		$config = $this->sanitize_config( $config );
		$wpdb->update( $wpdb->ModulaGalleries, array( 'configuration' => $config ), array( 'Id' => absint($id) ) );

	}

	public function getConfig( $id ) {
		$data = $this->getGalleryById( $id );

		return $data;
	}

	public function addGallery( $data ) {
		global $wpdb;

		$data = (array) $data;

		unset( $data['Id'] );

		$config = $this->sanitize_config( $data );
		$configuration = array( 'Id' => '', 'configuration' => json_encode( $config ) );

		$galleryAdded = $wpdb->insert( $wpdb->ModulaGalleries, $configuration );

		return $galleryAdded;
	}

	public function getNewGalleryId() {
		global $wpdb;

		return $wpdb->insert_id;
	}

	public function deleteGallery( $gid ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->ModulaImages WHERE gid = %d", absint($gid) ) );
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->ModulaGalleries WHERE Id = %d", absint($gid) ) );
	}

	public function editGallery( $gid, $data ) {
		global $wpdb;

		$config      = $this->sanitize_config( $data );
		$config      = json_encode( $config );
		$imageEdited = $wpdb->update( $wpdb->ModulaGalleries, array( 'configuration' => $config ), array( 'Id' => absint($gid) ) );

		return $imageEdited;
	}

	public function getIDbyGUID( $guid ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid=%s", ($guid) ) );
	}

	public function getGalleryById( $id, $default = null ) {
		global $wpdb;
		$gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->ModulaGalleries WHERE Id = %s", $id ) );
		$data    = json_decode( $gallery->configuration );
		if ( $default ) {
			foreach ( $default as $k => $v ) {
				if ( ! isset( $data->$k ) ) {
					$data->$k = $v;
				}
			}
		}

		$data->id = $id;

		return $data;
	}

	public function getLastGalleryId() {
		global $wpdb;
		$galleryResults = $wpdb->get_results( "SELECT Id FROM $wpdb->ModulaGalleries ORDER BY Id DESC LIMIT 1" );

		return $galleryResults[0];
	}

	public function getGalleries() {
		global $wpdb;
		$galleryResults = $wpdb->get_results( "SELECT * FROM $wpdb->ModulaGalleries" );

		return $galleryResults;
	}

	public function addImage( $gid, $image ) {
		global $wpdb;
		$imageAdded = $wpdb->insert( $wpdb->ModulaImages, array(
			'gid'         => absint($gid),
			'imagePath'   => esc_url_raw($image),
			'title'       => "",
			'description' => "",
			'sortOrder'   => 0,
		) );

		return $imageAdded;
	}

	public function addImages( $gid, $images ) {
		global $wpdb;
		foreach ( $images as $image ) {
			$imageAdded = $wpdb->insert( $wpdb->ModulaImages, array(
				'gid'         => absint( $gid ),
				'imagePath'   => esc_url_raw( $image->imagePath ),
				'description' => isset( $image->description ) ? wp_filter_post_kses( $image->description ) : '',
				'title'       => isset( $image->title ) ? sanitize_text_field( $image->title ) : '',
				'imageId'     => absint( $image->imageId ),
				'sortOrder'   => 0,
			) );
			$id         = $wpdb->insert_id;
			$wpdb->update( $wpdb->ModulaImages, array( 'sortOrder' => absint( $id ) ), array( 'Id' => absint( $id ) ) );
		}

		return true;
	}

	public function addFullImage( $data ) {
		global $wpdb;
		$imageAdded = $wpdb->insert( $wpdb->ModulaImages, $data );

		return $imageAdded;
	}

	public function deleteImage( $id ) {
		global $wpdb;
		if ( $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->ModulaImages WHERE Id = %d", absint($id) ) ) === false ) {
			return false;
		} else {
			return true;
		}
	}

	public function editImage( $id, $data ) {
		global $wpdb;
		$imageEdited = $wpdb->update( $wpdb->ModulaImages, $data, array( 'Id' => absint($id) ) );

		//print $wpdb->last_query;
		return $imageEdited;
	}

	public function sortImages( $ids ) {
		global $wpdb;
		$index = 1;
		foreach ( $ids as $id ) {
			$data = array( 'sortOrder' => $index++ );
			$wpdb->update( $wpdb->ModulaImages, $data, array( 'Id' => absint($id) ) );
		}

		return true;
	}

	public function getImagesByGalleryId( $gid ) {
		global $wpdb;
		$e            = 20;
		$imageResults = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->ModulaImages WHERE gid = %d  ORDER BY sortOrder ASC LIMIT $e", absint($gid) ) );

		return $imageResults;
	}

	public function getGalleryByGalleryId( $gid ) {
		global $wpdb;
		$gallery = $wpdb->get_results( $wpdb->prepare( "SELECT $wpdb->ModulaGalleries.*, $wpdb->ModulaImages.* FROM $wpdb->ModulaGalleries INNER JOIN $wpdb->ModulaImages ON ($wpdb->ModulaGalleries.Id = $wpdb->ModulaImages.gid) WHERE $wpdb->ModulaGalleries.Id = %d ORDER BY sortOrder ASC", absint($id) ) );

		return $gallery;
	}
}
