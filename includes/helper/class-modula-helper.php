<?php

/**
 *  Helper Class for Modula Gallery
 */
class Modula_Helper {
	
	/*
	*
	* Generate html attributes based on array
	*
	* @param array atributes
	*
	* @return string
	*
	*/
	public static function generate_attributes( $attributes ) {
		$return = '';
		foreach ( $attributes as $name => $value ) {

			if ( in_array( $name, array( 'alt', 'rel', 'title' ) ) ) {
				$value = wp_strip_all_tags( $value );
			}

			$return .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}

		return $return;

	}

	public static function get_icon( $icon ) {

		switch ( $icon ) {
			case 'facebook':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-9" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512"><path fill="currentColor" d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"></path></svg>';
				break;
			case 'twitter':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>';
				break;
			case 'pinterest':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="pinterest-p" class="svg-inline--fa fa-pinterest-p fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>';
				break;
			case 'google':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="google-plus-g" class="svg-inline--fa fa-google-plus-g fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z"></path></svg>';
				break;
			default:
				$return = apply_filters( 'modula_get_icon', '', $icon );
				return $return;
				break;
		}

	}

	public static function hover_effects_elements( $effect ) {

		$effects_with_title       = apply_filters( 'modula_effects_with_title', array( 'fluid-up', 'hide', 'quiet', 'reflex', 'curtain', 'lens', 'appear', 'crafty', 'seemo', 'comodo', 'pufrobo' ) );
		$effects_with_description = apply_filters( 'modula_effects_with_description', array( 'fluid-up', 'hide', 'reflex', 'lens', 'crafty', 'pufrobo'  ) );
		$effects_with_social      = apply_filters( 'modula_effects_with_social', array( 'comodo', 'seemo', 'appear', 'lens', 'curtain', 'reflex', 'catinelle', 'quiet', 'hide', 'pufrobo' ) );

		return array(
			'title'       => in_array( $effect, $effects_with_title ),
			'description' => in_array( $effect, $effects_with_description ),
			'social'      => in_array( $effect, $effects_with_social ),
		);

	}

	/**
	 * Callback to sort tabs/fields on priority.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public static function sort_data_by_priority( $a, $b ) {
		if ( ! isset( $a['priority'], $b['priority'] ) ) {
			return -1;
		}
		if ( $a['priority'] == $b['priority'] ) {
			return 0;
		}
		return $a['priority'] < $b['priority'] ? -1 : 1;
	}

	public static function get_image_info( $att_id, $what ) {

		$caption = '';

		switch ( $what ) {
			case 'title':
				$caption = get_the_title( $att_id );
				break;
			case 'caption':
				$caption = wp_get_attachment_caption( $att_id );
				break;
			case 'description':
				$caption = get_the_content( $att_id );
				break;
		}

		return $caption;

	}

	public static function get_title( $item, $default_source ){

		$title = isset($item['title']) ? $item['title'] : '';

		if ( '' == $title && 'none' != $default_source ) {
			$title = self::get_image_info( $item['id'],$default_source );
		}

		return $title;

	}

	public static function get_description( $item, $default_source ){
		
		$description = isset($item['description']) ? $item['description'] : '';

		if ( '' == $description && 'none' != $default_source ) {
			$description = self::get_image_info( $item['id'],$default_source );
		}

		return $description;

	}
	
}