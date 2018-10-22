<?php

define( "MODULA_DB_MODE", 1 );
define( "MODULA_WP_MODE", 2 );

if ( ! class_exists( "ModulaLiteFE" ) ) {
	class ModulaLiteFE {

		private $defaultValues;

		public function __construct( $db, $id, $defaultValues ) {
			$this->gallery       = new stdClass();
			$this->db            = $db;
			$this->wp_images     = array();
			$this->images        = array();
			$this->id            = $id;
			$this->defaultValues = $defaultValues;
			$this->init();
		}

		public function init() {
			$this->gallery = $this->db->getGalleryById( $this->id );
			foreach ( $this->defaultValues as $k => $v ) {
				if ( ! isset( $this->gallery->$k ) ) {
					$this->gallery->$k = $v;
				}
			}

			$this->gallery->mode = MODULA_DB_MODE;

			if ( ! empty( $_GET["debug"] ) ) {
				print "<!--\n";
				print "Gallery id: $this->id\n";
				print "settings:\n";
				print_r( $this->gallery );
				print "\n-->\n";
			}

			if ( ! $this->gallery->hasResizedImages ) {
				$images = $this->db->getImagesByGalleryId( $this->id );
				$images = ModulaLiteTools::check_and_resize( $images, $this->gallery->img_size );
				foreach ( $images as $img ) {
					$this->db->editImage( $img->Id, (array) $img );
				}
				$this->gallery->hasResizedImages = true;
				$this->db->editGallery( $this->id, (array) $this->gallery );
			}

			$this->images = $this->loadModulaImages();

			$ids = array();
			$idx = 0;
			foreach ( $this->images as $img ) {
				$ids[] = $img->imageId < 0 ? $img->imageId - ( $idx ++ ) : $img->imageId;
			}

			if ( count( $this->images ) > 0 && $this->gallery->importedFrom != 'NextGen' ) {
				$this->loadWPImages( $ids );
			}
		}

		public function loadWPImages( $ids ) {
			$args = array(
				'post_type'      => 'attachment',
				'posts_per_page' => -1,
				'include'        => $ids,
				'suppress_filters' => 0,
			);

			$this->wp_images = get_posts( $args );
			foreach ( $this->wp_images as $att ) {
				$att->url = get_attachment_link( $att->ID );

				if ( $this->gallery->mode == MODULA_DB_MODE ) {
					//$this->images[$att->ID]->imagePath = $att->guid;
					$this->images[ $att->ID ]->url = $att->url;
					$this->images[ $att->ID ]->alt = get_post_meta( $att->ID, '_wp_attachment_image_alt', true );
				}
			}
		}

		public function initByImageIds( $ids ) {
			$this->imageIds      = $ids;
			$this->gallery->mode = MODULA_WP_MODE;
			$this->loadWPImages( $ids );

			foreach ( $this->wp_images as $att ) {
				$image            = new stdClass();
				$image->imageId   = $att->ID;
				$image->url       = $att->url;
				$image->Id        = $att->ID;
				$image->imagePath = $att->guid;
				$image->link      = get_post_meta( $att->ID, "_modula_link", true );
				$image->alt       = get_post_meta( $att->ID, '_wp_attachment_image_alt', true );

				switch ( $this->gallery->wp_field_caption ) {
					case 'title':
						$image->description = $att->post_title;
						break;
					case 'caption':
						$image->description = $att->post_excerpt;
						break;
					case 'description':
						$image->description = $att->post_content;
						break;
				}
				$this->images[ $image->imageId ] = $image;
			}

		}

		public function getGallery() {
			return $this->gallery;
		}

		private function getLightboxClass( $image ) {
			if ( ! empty( $image->link ) ) {
				return '';
			}

			if ( empty( $this->gallery->lightbox ) ) {
				return '';
			}

			return 'modula-lightbox';
		}

		private function getHoverEffect( $code ) {
			global $ob_ModulaLite;
			foreach ( $ob_ModulaLite->hoverEffects as $effect ) {
				if ( $effect->code == $code ) {
					return $effect;
				}
			}
		}

		private function getLink( $image ) {
			if ( ! empty( $image->link ) ) {
				return "href='" . $image->link . "'";
			}

			if ( empty( $this->gallery->lightbox ) ) {
				return '';
			}

			if ( $this->gallery->lightbox == 'attachment-page' ) {
				return "href='" . $image->url . "'";
			}

			return "href='" . wp_get_attachment_url( $image->imageId ) . "'";
		}

		private function getTarget( $image ) {
			if ( ! empty( $image->target ) ) {
				return "target='" . $image->target . "'";
			}

			// if($this->gallery->blank == 'T')
			// 	return "target='_blank'";

			return '';
		}

		private function getdef( $value, $default ) {
			if ( $value == null || empty( $value ) ) {
				return $default;
			}

			return $value;
		}

		private function toRGB( $Hex ) {

			if ( substr( $Hex, 0, 1 ) == "#" ) {
				$Hex = substr( $Hex, 1 );
			}

			$R = substr( $Hex, 0, 2 );
			$G = substr( $Hex, 2, 2 );
			$B = substr( $Hex, 4, 2 );

			$R = hexdec( $R );
			$G = hexdec( $G );
			$B = hexdec( $B );

			$RGB['R'] = $R;
			$RGB['G'] = $G;
			$RGB['B'] = $B;

			$RGB[0] = $R;
			$RGB[1] = $G;
			$RGB[2] = $B;

			return $RGB;

		}

		static public function slugify( $text ) {
			$text = preg_replace( '~[^\\pL\d]+~u', '-', $text );
			$text = trim( $text, '-' );
			$text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );
			$text = strtolower( $text );
			$text = preg_replace( '~[^-\w]+~', '', $text );

			if ( empty( $text ) ) {
				return 'n-a';
			}

			return $text;
		}

		private function v( $name ) {
			switch ( $this->mode ) {
				default:
				case MODULA_DB_MODE:
					return $this->gallery->$name;
					break;
				case MODULA_WP_MODE:
					return $this->settings[ $name ];
			}
		}

		public function render() {
			$rid = rand( 1, 1000 );

			if ( $this->gallery->shuffle == 'T' ) {
				shuffle( $this->images );
			}

			$gallery = $this->gallery;

			$html = "";

			$html .= "<style>";

			if ( $this->gallery->borderSize ) {
				$html .= "#jtg-$this->id$rid .item { border: " . $this->gallery->borderSize . "px solid " . $this->gallery->borderColor . "; }";
			}

			if ( $this->gallery->borderRadius ) {
				$html .= "#jtg-$this->id$rid .item { border-radius: " . $this->gallery->borderRadius . "px; }";
			}

			if ( $this->gallery->shadowSize ) {
				$html .= "#jtg-$this->id$rid .item { box-shadow: " . $this->gallery->shadowColor . " 0px 0px " . $this->gallery->shadowSize . "px; }";
			}

			if ( $this->gallery->socialIconColor ) {
				$html .= "#jtg-$this->id$rid .item .jtg-social a { color: " . $this->gallery->socialIconColor . " }";
			}

			$html .= "#jtg-$this->id$rid .item .caption { background-color: " . $this->gallery->captionColor . ";  }";

			$html .= "#jtg-$this->id$rid .item .figc { color: " . $this->gallery->captionColor . "; font-size: " . $this->gallery->captionFontSize . "px; }";

			$html .= "#jtg-$this->id$rid .item .figc h2.jtg-title {  font-size: " . $this->gallery->titleFontSize . "px; }";

			$html .= "#jtg-$this->id$rid .item { transform: scale(" . $gallery->loadedScale / 100 . ") translate(" . $gallery->loadedHSlide . 'px,' . $gallery->loadedVSlide . "px) rotate(" . $gallery->loadedRotate . "deg); }";

			$html .= "#jtg-$this->id$rid .items { width:" . $this->gallery->width . "; height:" . $this->gallery->height . "px; }";

			$html .= "#jtg-$this->id$rid .items .figc p.description { color:" . $this->gallery->captionColor . "; }";


			if ( strlen( $this->gallery->style ) ) {
				$html .= $this->gallery->style;
			}

			$html .= "</style>\n";

			$id   = $this->id;
			$html .= "<a name='$id'> </a>";
			$html .= "<div class='modula' id='jtg-$this->id$rid'>";

			$html .= "<div class='items'>";

			foreach ( array_slice( $this->images, 0, 40 / 2 ) as $image ) {

				$title = in_array( $this->gallery->lightbox, array(
					'prettyphoto',
					'fancybox',
					'swipebox',
					'lightbox2'
				) ) ? "title" : "data-title";
				$rel   = $this->gallery->lightbox == "prettyphoto" ? "prettyPhoto[jtg-$this->id$rid]" : "jtg-$this->id$rid";

				$hoverEffect = $this->getHoverEffect( $this->gallery->hoverEffect );

				/*if(empty($image->title) && empty($image->description) &&
					!$this->gallery->enableTwitter && !$this->gallery->enableFacebook &&
					!$this->gallery->enablePinterest & !$this->gallery->enableGplus)
				{
					$hoverEffect = $this->getHoverEffect('none');
				}*/

				$hasTitle = empty( $image->title ) ? 'notitle' : '';

				$imgUrl     = $image->imagePath;
				$image->alt = isset( $image->alt ) ? $image->alt : '';

				$html       .= "<div class=\"item " . $hasTitle . " effect-" . $hoverEffect->code . "\">";
				$html       .= "<a $title='$image->description' " . ( $this->gallery->lightbox == "lightbox2" && empty( $image->link ) ? "data-lightbox='$rel'" : "" ) . " rel='$rel' " . $this->getTarget( $image ) . " class='tile-inner " . ( $this->getLightboxClass( $image ) ) . "' " . $this->getLink( $image ) . "></a>";
				$html       .= "<img data-valign='$image->valign' alt='$image->alt' data-halign='$image->halign' class='pic' src='$imgUrl' data-src='$imgUrl' />";
				$html       .= "<div class=\"figc\">";
				$html       .= "<div class=\"figc-inner\">";
				if ( $this->gallery->hoverEffect != 'none' && ! empty( $image->title ) && 'T' != $this->gallery->hide_title ) {
					$html .= "<h2 class='jtg-title'>" . $image->title . "</h2>";
				}

				if ( ( $this->gallery->hoverEffect != 'none' && ! empty( $image->description ) )  && 'T' != $this->gallery->hide_description ) {
					$html .= "<p class=\"description\">";
					$html .= $image->description;
					$html .= "</p>";
				}
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</div>";
			}


			$html .= "</div>";
			$html .= "</div>";

			$html .= "<script type='text/javascript'>";
			$html .= "jQuery('#jtg-$this->id$rid').modulaGallery({";

			if ( strlen( $this->gallery->script ) ) {
				$html .= "onComplete: function () { " . stripslashes( $this->gallery->script ) . "},";
			}

			$html .= "resizer: '" . plugins_url( 'modula-best-grid-gallery/image.php', '' ) . "',";
			$html .= "margin: " . $this->gallery->margin . ",";
			// $html .= "\t\tkeepArea: " . ($this->gallery->keepArea == "T" ? "true" : "false") . ",\n";
			$html .= "enableTwitter: " . ( $this->gallery->enableTwitter == "T" ? "true" : "false" ) . ",";
			$html .= "enableFacebook: " . ( $this->gallery->enableFacebook == "T" ? "true" : "false" ) . ",";
			$html .= "enablePinterest: " . ( $this->gallery->enablePinterest == "T" ? "true" : "false" ) . ",";
			$html .= "enableGplus: " . ( $this->gallery->enableGplus == "T" ? "true" : "false" ) . ",";
			$html .= "randomFactor: " . ( $this->gallery->randomFactor / 100 ) . ",";
			$html .= "});";
			$html .= "</script>";


			if ( ! empty( $_GET["debug"] ) ) {
				return $html;
			}

			return str_replace( array( "\n", "\t" ), "", $html );
		}

		public function useCaptions() {
			if ( $this->gallery->wp_field_caption == "none" && $this->gallery->wp_field_title == "none" ) {
				return false;
			}

			return true;
		}

		public function loadModulaImages() {
			$images = array();
			$idx    = 0;
			foreach ( $this->db->getImagesByGalleryId( $this->id ) as $img ) {
				$images[ $img->imageId < 0 ? $img->imageId - ( $idx ++ ) : $img->imageId ] = $img;
			}

			return $images;
		}
	}
}
?>