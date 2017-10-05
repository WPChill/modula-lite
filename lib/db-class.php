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

	public function update_config( $id, $config ) {
		global $wpdb;

		unset( $config->Id );

		$wpdb->update( $wpdb->ModulaGalleries, array( 'configuration' => $config ), array( 'Id' => $id ) );

	}

	public function getConfig( $id ) {
		$data = $this->getGalleryById( $id );

		return $data;
	}

	public function addGallery( $data ) {
		global $wpdb;

		$data = (array) $data;

		unset( $data['Id'] );

		$configuration = array( 'Id' => '', 'configuration' => json_encode( $data ) );

		$galleryAdded = $wpdb->insert( $wpdb->ModulaGalleries, $configuration );

		return $galleryAdded;
	}

	public function getNewGalleryId() {
		global $wpdb;

		return $wpdb->insert_id;
	}

	public function deleteGallery( $gid ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->ModulaImages WHERE gid = %d", $gid ) );
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->ModulaGalleries WHERE Id = %d", $gid ) );
	}

	public function editGallery( $gid, $data ) {
		global $wpdb;

		$data        = json_encode( $data );
		$imageEdited = $wpdb->update( $wpdb->ModulaGalleries, array( 'configuration' => $data ), array( 'Id' => $gid ) );
		print_r( $wpdb->last_error );

		return $imageEdited;
	}

	public function getIDbyGUID( $guid ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid=%s", $guid ) );
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
			'gid'         => $gid,
			'imagePath'   => $image,
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
				'gid'         => $gid,
				'imagePath'   => $image->imagePath,
				'description' => isset( $image->description ) ? $image->description : '',
				'title'       => isset( $image->title ) ? $image->title : '',
				'imageId'     => $image->imageId,
				'sortOrder'   => 0,
			) );
			$id         = $wpdb->insert_id;
			$wpdb->update( $wpdb->ModulaImages, array( 'sortOrder' => $id ), array( 'Id' => $id ) );
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
		if ( $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->ModulaImages WHERE Id = %d", $id ) ) === false ) {
			return false;
		} else {
			return true;
		}
	}

	public function editImage( $id, $data ) {
		global $wpdb;
		$imageEdited = $wpdb->update( $wpdb->ModulaImages, $data, array( 'Id' => $id ) );

		//print $wpdb->last_query;
		return $imageEdited;
	}

	public function sortImages( $ids ) {
		global $wpdb;
		$index = 1;
		foreach ( $ids as $id ) {
			$data = array( 'sortOrder' => $index++ );
			$wpdb->update( $wpdb->ModulaImages, $data, array( 'Id' => $id ) );
		}

		return true;
	}

	public function getImagesByGalleryId( $gid ) {
		global $wpdb;
		$e            = 22 - 1 - 1;
		$imageResults = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->ModulaImages WHERE gid = %d  ORDER BY sortOrder ASC LIMIT $e", $gid ) );

		return $imageResults;
	}

	public function getGalleryByGalleryId( $gid ) {
		global $wpdb;
		$gallery = $wpdb->get_results( $wpdb->prepare( "SELECT $wpdb->ModulaGalleries.*, $wpdb->ModulaImages.* FROM $wpdb->ModulaGalleries INNER JOIN $wpdb->ModulaImages ON ($wpdb->ModulaGalleries.Id = $wpdb->ModulaImages.gid) WHERE $wpdb->ModulaGalleries.Id = %d ORDER BY sortOrder ASC", $gid ) );

		return $gallery;
	}
}

?>