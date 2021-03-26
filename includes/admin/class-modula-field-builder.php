<?php

/**
 *
 */
class Modula_Field_Builder {

	private $settings = array();

	function __construct() {

		/* Add templates for our plugin */
		add_action( 'admin_footer', array( $this, 'print_modula_templates' ) );

	}


	/**
	 * Get an instance of the field builder
	 */
	public static function get_instance() {
		static $inst;
		if ( ! $inst ) {
			$inst = new Modula_Field_Builder();
		}
		return $inst;
	}

	public function get_id(){
		global $id, $post;

        // Get the current post ID. If ajax, grab it from the $_POST variable.
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX && array_key_exists( 'post_id', $_POST ) ) {
            $post_id = absint( $_POST['post_id'] );
        } else {
            $post_id = isset( $post->ID ) ? $post->ID : (int) $id;
        }

        return $post_id;
	}

	/**
     * Helper method for retrieving settings values.
     *
     * @since 2.0.0
     *
     * @global int $id        The current post ID.
     * @global object $post   The current post object.
     * @param string $key     The setting key to retrieve.
     * @param string $default A default value to use.
     * @return string         Key value on success, empty string on failure.
     */
    public function get_setting( $key, $default = false ) {

        // Get config
        if ( empty( $this->settings ) ) {
        	$this->settings = get_post_meta( $this->get_id(), 'modula-settings', true );
        }

        // Check config key exists
        if ( isset( $this->settings[ $key ] ) ) {
            $value = $this->settings[ $key ];
        } else {
            $value = $default ? $default : '';
        }

        return apply_filters( 'modula_admin_field_value', $value, $key, $this->settings );

    }

	public function render( $metabox, $post = false ) {

		switch ( $metabox ) {
			case 'gallery':
				$this->_render_gallery_metabox();
				break;
			case 'settings':
				$this->_render_settings_metabox();
				break;
			case 'shortcode':
				$this->_render_shortcode_metabox( $post );
				break;
			default:
				do_action( "modula_metabox_fields_{$metabox}" );
				break;
		}

	}

	/* Create HMTL for gallery metabox */
	private function _render_gallery_metabox() {

		$images = get_post_meta( $this->get_id(), 'modula-images', true );
		$helper_guidelines = $this->get_setting( 'helpergrid' );
		$max_upload_size = wp_max_upload_size();
                
                if ( ! $max_upload_size ) {
                    $max_upload_size = 0;
                }
                
		echo '<div class="modula-uploader-container">';
		echo '<div class="modula-upload-actions">';
		echo '<div class="upload-info-container">';
		echo '<div class="upload-info">';
                if (current_user_can('upload_files')) {
                    echo sprintf( __( '<b>Drag and drop</b> files here (max %s per file), or <b>drag images around to change their order</b>', 'modula-best-grid-gallery' ), esc_html( size_format( $max_upload_size ) ) );
                    echo '</div>';
                    echo '<div class="upload-progress">';
                    echo '<p class="modula-upload-numbers">' . esc_html__( 'Uploading image', 'modula-best-grid-gallery' ) . ' <span class="modula-current"></span> ' . esc_html__( 'of', 'modula-best-grid-gallery' ) . ' <span class="modula-total"></span>';
                    echo '<div class="modula-progress-bar"><div class="modula-progress-bar-inner"></div></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="buttons">';
                    echo '<a href="#" id="modula-uploader-browser" class="button">' . esc_html__( 'Upload image files', 'modula-best-grid-gallery' ) . '</a><a href="#" id="modula-wp-gallery" class="button button-primary">' . esc_html__( 'Select from Library', 'modula-best-grid-gallery' ) . '</a>';
                    do_action( 'modula_gallery_media_button');
                } else {
                    echo '<b>' . __( 'Drag images around to change their order', 'modula-best-grid-gallery' ) . '</b>';
                    echo '</div>';
                }
		echo '</div>';
		echo '</div>';
		echo '<div id="modula-uploader-container" class="modula-uploader-inline">';
			echo '<div class="modula-error-container"></div>';
			echo '<div class="modula-uploader-inline-content">';
				echo '<h2 class="modula-upload-message"><span class="dashicons dashicons-upload"></span>' . esc_html__( 'Drag & Drop files here!', 'modula-best-grid-gallery' ) . '</h2>';
				echo '<div id="modula-grid" style="display:none"></div>';
			echo '</div>';
			echo '<div id="modula-dropzone-container"><div class="modula-uploader-window-content"><h1>' . esc_html__( 'Drop files to upload', 'modula-best-grid-gallery' ) . '</h1></div></div>';
		echo '</div>';

		// Helper Guildelines Toggle
		echo '<div class="modula-helper-guidelines-container">';

			do_action( 'modula_before_helper_grid' );

			echo '<div class="modula-toggle modula-helper-guidelines-wrapper">';
				echo '<input class="modula-toggle__input" type="checkbox" id="modula-helper-guidelines" name="modula-settings[helpergrid]" data-setting="modula-helper-guidelines" value="1" ' . checked( 1, $helper_guidelines, false ) . '>';
				echo '<div class="modula-toggle__items">';
					echo '<span class="modula-toggle__track"></span>';
					echo '<span class="modula-toggle__thumb"></span>';
					echo '<svg class="modula-toggle__off" width="6" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 6 6"><path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>';
					echo '<svg class="modula-toggle__on" width="2" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 2 6"><path d="M0 0h2v6H0z"></path></svg>';
				echo '</div>';
				echo '<strong class="modula-helper-guidelines-label">' . esc_html__( 'Disable Helper Grid', 'modula-best-grid-gallery' ) . '</strong>';
			echo '</div>';

		do_action( 'modula_after_helper_grid' );

		echo '</div>';

		echo '</div>';
	}

	/* Create HMTL for settings metabox */
	private function _render_settings_metabox() {
		$tabs = Modula_CPT_Fields_Helper::get_tabs();

		// Sort tabs based on priority.
		uasort( $tabs, array( 'Modula_Helper', 'sort_data_by_priority' ) );

		$tabs_html = '';
		$tabs_content_html = '';
		$first = true;

		// Generate HTML for each tab.
		foreach ( $tabs as $tab_id => $tab ) {
			$tab['id'] = $tab_id;
			$tabs_html .= $this->_render_tab( $tab, $first );

			$fields = Modula_CPT_Fields_Helper::get_fields( $tab_id );
			// Sort fields based on priority.
			uasort( $fields, array( 'Modula_Helper', 'sort_data_by_priority' ) );

			$current_tab_content = '<div id="modula-' . esc_attr( $tab['id'] ) . '" class="modula-tab-content' . ( $first ? ' active-tab' : '' ) . '">';

			// Check if our tab have title & description
			if ( isset( $tab['title'] ) || isset( $tab['description'] ) ) {
				$current_tab_content .= '<div class="tab-content-header">';
				$current_tab_content .= '<div class="tab-content-header-title">';
				if ( isset( $tab['title'] ) && '' != $tab['title'] ) {
					$current_tab_content .= '<h2>' . esc_html( $tab['title'] ) . '</h2>';
				}
				if ( isset( $tab['description'] ) && '' != $tab['description'] ) {
					$current_tab_content .= '<div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span>';
					$current_tab_content .= '<div class="tab-header-description modula-tooltip-content">' . wp_kses_post( $tab['description'] ) . '</div>';
					$current_tab_content .= '</div>';
				}
				$current_tab_content .= '</div>';

				$current_tab_content .= '<div class="tab-content-header-actions">';
				$current_tab_content .= apply_filters('modula_admin_documentation_link', '<a href="https://modula.helpscoutdocs.com/" target="_blank" class="">' . esc_html__( 'Documentation', 'modula-best-grid-gallery' ) . '</a>');
				$current_tab_content .= '<span> - or - </span>';
				$current_tab_content .= apply_filters('modula_admin_contact_link', '<a href="https://wp-modula.com/contact-us/" target="_blank" class="">' . esc_html__( 'Get in touch', 'modula-best-grid-gallery' ) . '</a>');
				$current_tab_content .= '</div>';

				$current_tab_content .= '</div>';

			}

			// Generate all fields for current tab
			$current_tab_content .= '<div class="form-table-wrapper">';
			$current_tab_content .= '<table class="form-table"><tbody>';
			foreach ( $fields as $field_id => $field ) {
				$field['id'] = $field_id;
				$current_tab_content .= $this->_render_row( $field );
			}
			$current_tab_content .= '</tbody></table>';
			// Filter to add extra content to a specific tab
			$current_tab_content .= apply_filters( 'modula_' . $tab_id . '_tab_content', '' );
			$current_tab_content .= '</div>';
			$current_tab_content .= '</div>';
			$tabs_content_html .= $current_tab_content;

			if ( $first ) {
				$first = false;
			}

		}

		$html = '<div class="modula-settings-container"><div class="modula-tabs">%s</div><div class="modula-tabs-content">%s</div>';
		printf( $html, $tabs_html, $tabs_content_html );
	}

	/* Create HMTL for shortcode metabox */
	private function _render_shortcode_metabox( $post ) {
		$shortcode = '[modula id="' . $post->ID . '"]';

		do_action( 'modula_admin_before_shortcode_metabox', $post );

		echo '<div class="modula-copy-shortcode">';
        echo '<input type="text" value="' . esc_attr($shortcode) . '"  onclick="select()" readonly>';
		echo '<a href="#" title="' . esc_attr__('Copy shortcode','modula-best-grid-gallery') . '" class="copy-modula-shortcode button button-primary dashicons dashicons-format-gallery" style="width:40px;"></a><span></span>';
		echo '<p class="shortcode-description">' . sprintf( esc_html__( 'You can use this to display your newly created gallery inside a %s post or a page %s', 'modula-best-grid-gallery'), '<u>', '</u>' ) .  '</p>';
        echo '</div>';

        do_action( 'modula_admin_after_shortcode_metabox', $post );
	}

	/* Create HMTL for a tab */
	private function _render_tab( $tab, $first = false ) {
		$icon = '';
		$badge = '';

		if ( isset( $tab['icon'] ) ) {
			$icon = '<i class="' . esc_attr( $tab['icon'] ) . '"></i>';
		}

		if ( isset( $tab['badge'] ) ) {
			$badge = '<sup>' . esc_html( $tab['badge'] ) . '</sup>';
		}
		return '<div class="modula-tab' . ( $first ? ' active-tab' : '' ) . ' modula-' . esc_attr( $tab['id'] ) . '" data-tab="modula-' . esc_attr( $tab['id'] ) . '">' . $icon . wp_kses_post( $tab['label'] ) . $badge . '</div>';
	}

	/* Create HMTL for a row */
	private function _render_row( $field ) {

		$child      = '';
		$field_name = wp_kses_post( $field[ 'name' ] );

		// Generate tooltip
		$tooltip = '';
		if ( isset( $field[ 'description' ] ) && '' != $field[ 'description' ] ) {
			$tooltip .= '<div class="modula-tooltip"><span>[?]</span>';
			$tooltip .= '<div class="modula-tooltip-content">' . wp_kses_post( $field[ 'description' ] ) . '</div>';
			$tooltip .= '</div>';
		}


		if(isset($field['is_child']) && $field['is_child'] && is_bool($field['is_child'])){
			$child = 'child_setting';
		}

		if(isset($field['is_child']) && $field['is_child'] && is_string($field['is_child'])){
			$child = $field['is_child'].'_child_setting';
		}

		$format = '<tr data-container="' . esc_attr( $field['id'] ) . '"><th scope="row" class="'.$child.'"><label>%s</label>%s</th><td>%s</td></tr>';

		// Formats for General Gutter
		if ( 'gutter' == $field[ 'id' ] ) {
			$format = '<tr data-container="' . esc_attr( $field[ 'id' ] ) . '"><th scope="row" class="' . $child . '"><label>%s</label>%s</th><td><span class="dashicons dashicons-desktop"></span>%s<span class="modula_input_suffix">px</span></td>';
		}

		if ( 'tablet_gutter' == $field[ 'id' ] ) {
			$field_name = '<span class="dashicons dashicons-tablet"></span>';
			$tooltip = '';
			$format = '<td>%s%s%s<span class="modula_input_suffix">px</span></td>';
		}

		if ( 'mobile_gutter' == $field[ 'id' ] ) {
			$field_name = '<span class="dashicons dashicons-smartphone"></span>';
			$tooltip = '';
			$format = '<td>%s%s%s<span class="modula_input_suffix">px</span></td></tr>';
		}
		// End formats for General Gutter

		if ( 'textarea' == $field['type'] || 'custom_code' == $field['type'] || 'hover-effect' == $field['type'] ) {
			$format = '<tr data-container="' . esc_attr( $field['id'] ) . '"><td colspan="2" class="'.$child.'"><label class="th-label">%s</label>%s<div>%s</div></td></tr>';
		}

		$format = apply_filters( "modula_field_type_{$field['type']}_format", $format, $field );

		$default = '';

		// Check if our field have a default value
		if ( isset( $field['default'] ) ) {
			$default = $field['default'];
		}

		// Get the current value of the field
		$value = $this->get_setting( $field['id'], $default );

		return sprintf( $format, $tooltip, $field_name, $this->_render_field( $field, $value ) );
	}

	/* Create HMTL for a field */
	private function _render_field( $field, $value = '' ) {
		$html = '';

		switch ( $field['type'] ) {

			case 'image-size':
				$html = '<div class="modula-image-size">';
				$html .= '<input type="text" name="modula-settings[' . esc_attr( $field['id'] ) . '][width]" data-setting="' . esc_attr( $field['id'] ) . '" value="' . ((is_array($value) && isset($value['width'])) ? esc_attr( $value['width'] ) : '') . '">';
				$html .= '<span class="modila-image-size-spacer">x</span>';
				$html .= '<input type="text" name="modula-settings[' . esc_attr( $field['id'] ) . '][height]" data-setting="' . esc_attr( $field['id'] ) . '" value="' . ((is_array($value) && isset($value['height'])) ? esc_attr( $value['height'] ) : '') . '">';
				$html .= '<span class="modila-image-size-spacer">px</span>';
				$html .= '</div>';
				break;
			case 'text':
				$html = '<input type="text" name="modula-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $value ) . '">';

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'. wp_kses_post( $field['afterrow'] ) .'</p>';
				}
				break;
			case 'number':
				$html = '<input type="number"  name="modula-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $value ) . '">';
				if ( isset( $field['after'] ) ) {
					$html .= '<span class="modula-after-input">' . esc_html( $field['after'] ) . '</span>';
				}

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'. wp_kses_post( $field['afterrow'] ) .'</p>';
				}
				break;
			case 'select' :
				$html = '<select name="modula-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '">';

				foreach ( $field['values'] as $key => $option ) {

				    // Fix for single lightbox after Modula update
				    if('lightbox' == $field['id']){
				    	
				        if(is_array($option) && !isset($option[$value])){

				            $value = 'fancybox';
                        }
                    }

					if ( is_array( $option )  && ! empty( $option ) ) {
						$html .= '<optgroup label="' . esc_attr( $key ) . '">';
						foreach ( $option as $key_subvalue => $subvalue ) {
                            $html .= '<option value="' . esc_attr( $key_subvalue ) . '" ' .  selected( $key_subvalue, $value, false )  . '>' . esc_html( $subvalue ) . '</option>';
						}
						$html .= '</optgroup>';
					}else{
						$html .= '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $value, false ) . '>' . esc_html( $option ) . '</option>';
					}
				}

				if ( isset( $field['disabled'] ) && is_array( $field['disabled'] ) && ! empty( $field['disabled']['values'] ) ) {
					$html .= '<optgroup label="' . esc_attr( $field['disabled']['title'] ) . '">';
					foreach ( $field['disabled']['values'] as $key => $disabled ) {
						$html .= '<option value="' . esc_attr( $key ) . '" disabled >' . esc_html( $disabled ) . '</option>';
					}
					$html .= '</optgroup>';
				}
				$html .= '</select>';

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
			case 'ui-slider':
				$min  = isset( $field['min'] ) ? $field['min'] : 0;
				$max  = isset( $field['max'] ) ? $field['max'] : 100;
				$step = isset( $field['step'] ) ? $field['step'] : 1;
				if ( '' === $value ) {
					if ( isset( $field['default'] ) ) {
						$value = $field['default'];
					}else{
						$value = $min;
					}
				}
				$attributes = 'data-min="' . esc_attr( $min ) . '" data-max="' . esc_attr( $max ) . '" data-step="' . esc_attr( $step ) . '"';
				$html .= '<div class="slider-container modula-ui-slider-container">';
					$html .= '<input contenteditable="true" data-setting="' . esc_attr( $field['id'] ) . '"  name="modula-settings[' . esc_attr( $field['id'] ) . ']" type="text" class="rl-slider modula-ui-slider-input" id="input_' . esc_attr( $field['id'] ) . '" value="' . sanitize_text_field( $value ) . '" ' . $attributes . '/>';
					$html .= '<div id="slider_' . esc_attr( $field['id'] ) . '" class="ss-slider modula-ui-slider"></div>';
				$html .= '</div>';
				break;
			case 'color' :
				$html .= '<div class="modula-colorpickers">';
				if ( isset( $field['alpha'] ) && $field['alpha'] ) {
					$html .= '<input id="' . esc_attr( $field['id'] ) . '" class="modula-color" data-alpha="true" data-setting="' . esc_attr( $field['id'] ) . '" name="modula-settings[' . esc_attr( $field['id'] ) . ']" value="' . esc_attr( $value ) . '">';
				}else{
					$html .= '<input id="' . esc_attr( $field['id'] ) . '" class="modula-color" data-setting="' . esc_attr( $field['id'] ) . '" name="modula-settings[' . esc_attr( $field['id'] ) . ']" value="' . esc_attr( $value ) . '">';
				}

				$html .= '</div>';

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
			case "toggle":
				$html .= '<div class="modula-toggle">';
					$html .= '<input class="modula-toggle__input" type="checkbox" data-setting="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" name="modula-settings[' . esc_attr( $field['id'] ) . ']" value="1" ' . checked( 1, $value, false ) . '>';
					$html .= '<div class="modula-toggle__items">';
						$html .= '<span class="modula-toggle__track"></span>';
						$html .= '<span class="modula-toggle__thumb"></span>';
						$html .= '<svg class="modula-toggle__off" width="6" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 6 6"><path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>';
						$html .= '<svg class="modula-toggle__on" width="2" height="6" aria-hidden="true" role="img" focusable="false" viewBox="0 0 2 6"><path d="M0 0h2v6H0z"></path></svg>';
					$html .= '</div>';
				$html .= '</div>';

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'. wp_kses_post($field['afterrow'], array( 'a' => array( 'href' => array() ), 'target' => array() )).'</p>';
				}
				break;
			case "custom_code":
				$html = '<div class="modula-code-editor" data-syntax="' . esc_attr( $field['syntax'] ) . '">';
				$html .= '<textarea data-setting="' . esc_attr( $field['id'] ) . '" name="modula-settings[' . esc_attr( $field['id'] ) . ']" id="modula-' . esc_attr( $field['id'] ) . '-customcode" class="large-text code modula-custom-editor-field"  rows="10" cols="50">' . wp_kses_post($value) . '</textarea>';
				$html .= '</div>';

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
			case "hover-effect":
				$hovers = apply_filters( 'modula_available_hover_effects', array(
					'none'    => esc_html__( 'None', 'modula-best-grid-gallery' ),
					'pufrobo' => esc_html__( 'Pufrobo', 'modula-best-grid-gallery' ),
				) );
				$pro_hovers = apply_filters( 'modula_pro_hover_effects', array(
					'fluid-up'  => esc_html__( 'Fluid Up', 'modula-best-grid-gallery' ),
					'greyscale' => esc_html__( 'Greyscale', 'modula-best-grid-gallery' ),
					'under'     => esc_html__( 'Under Image', 'modula-best-grid-gallery' ),
					'hide'      => esc_html__( 'Hide', 'modula-best-grid-gallery' ),
					'quiet'     => esc_html__( 'Quiet', 'modula-best-grid-gallery' ),
					'catinelle' => esc_html__( 'Catinelle', 'modula-best-grid-gallery' ),
					'reflex'    => esc_html__( 'Reflex', 'modula-best-grid-gallery' ),
					'curtain'   => esc_html__( 'Curtain', 'modula-best-grid-gallery' ),
					'lens'      => esc_html__( 'Lens', 'modula-best-grid-gallery' ),
					'appear'    => esc_html__( 'Appear', 'modula-best-grid-gallery' ),
					'crafty'    => esc_html__( 'Crafty', 'modula-best-grid-gallery' ),
					'seemo'     => esc_html__( 'Seemo', 'modula-best-grid-gallery' ),
					'comodo'    => esc_html__( 'Comodo', 'modula-best-grid-gallery' ),
					'lily'      => esc_html__( 'Lily', 'modula-best-grid-gallery' ),
					'sadie'     => esc_html__( 'Sadie', 'modula-best-grid-gallery' ),
					'honey'     => esc_html__( 'Honey', 'modula-best-grid-gallery' ),
					'layla'     => esc_html__( 'Layla', 'modula-best-grid-gallery' ),
					'zoe'       => esc_html__( 'Zoe', 'modula-best-grid-gallery' ),
					'oscar'     => esc_html__( 'Oscar', 'modula-best-grid-gallery' ),
					'marley'    => esc_html__( 'Marley', 'modula-best-grid-gallery' ),
					'ruby'      => esc_html__( 'Ruby', 'modula-best-grid-gallery' ),
					'roxy'      => esc_html__( 'Roxy', 'modula-best-grid-gallery' ),
					'bubba'     => esc_html__( 'Bubba', 'modula-best-grid-gallery' ),
					'dexter'    => esc_html__( 'Dexter', 'modula-best-grid-gallery' ),
					'sarah'     => esc_html__( 'Sarah', 'modula-best-grid-gallery' ),
					'chico'     => esc_html__( 'Chico', 'modula-best-grid-gallery' ),
					'milo'      => esc_html__( 'Milo', 'modula-best-grid-gallery' ),
					'julia'     => esc_html__( 'Julia', 'modula-best-grid-gallery' ),
					'hera'      => esc_html__( 'Hera', 'modula-best-grid-gallery' ),
					'winston'   => esc_html__( 'Winston', 'modula-best-grid-gallery' ),
					'selena'    => esc_html__( 'Selena', 'modula-best-grid-gallery' ),
					'terry'     => esc_html__( 'Terry', 'modula-best-grid-gallery' ),
					'phoebe'    => esc_html__( 'Phoebe', 'modula-best-grid-gallery' ),
					'apollo'    => esc_html__( 'Apollo', 'modula-best-grid-gallery' ),
					'steve'     => esc_html__( 'Steve', 'modula-best-grid-gallery' ),
					'jazz'      => esc_html__( 'Jazz', 'modula-best-grid-gallery' ),
					'ming'      => esc_html__( 'Ming', 'modula-best-grid-gallery' ),
					'lexi'      => esc_html__( 'Lexi', 'modula-best-grid-gallery' ),
					'duke'      => esc_html__( 'Duke', 'modula-best-grid-gallery' ),
					'tilt_1'    => esc_html__( 'Tilt Effect 1', 'modula-best-grid-gallery' ),
					'tilt_3'    => esc_html__( 'Tilt Effect 2', 'modula-best-grid-gallery' ),
					'tilt_7'    => esc_html__( 'Tilt Effect 3', 'modula-best-grid-gallery' ),

				) );

				$html .= '<p class="description">' . esc_html__( 'Select one of the below hover effects.', 'modula-best-grid-gallery' ) . '</p>';

				// Creates effects preview
				// Check if the PRO hovers are used for preview in LITE or PRO version is active
				if ( $pro_hovers ) {
					$hovers = array_merge( $hovers, $pro_hovers );
				}

				$html .= '<div class="modula-effects-preview modula modula-gallery">';

				$html .= '<div class="modula-effects-wrapper">';

				$effect_array  = array( 'tilt_1', 'tilt_3', 'tilt_7', );
				$overlay_array = array( 'tilt_2', 'tilt_3', 'tilt_7' );
				$svg_array     = array( 'tilt_1', 'tilt_7' );
				$jtg_body      = array( 'lily', 'sadie', 'ruby', 'bubba', 'dexter', 'chico', 'ming' );

				foreach ( $hovers as $key => $name ) {

					$class = array( 'modula-item' );
					$class[] = 'effect-' . $key;
					if ( $pro_hovers && array_key_exists( $key, $pro_hovers ) ) {
						$class[] = 'modula-preview-upsell';
					}

					$effect_elements = Modula_Helper::hover_effects_elements( $key );
					$effect          = '';
					$effect          .= '<div class="clearfix panel-pro-preview modula-hover-effect-item modula-items">';

					if ( ! $pro_hovers || ! array_key_exists( $key, $pro_hovers ) ) {
						$effect .= '<input type="radio" name="modula-settings[effect]" value="' . esc_attr( $key ) . '" ' . checked( $key, $value, false ) . '>';
					}

					$effect .= '<div class="modula-preview-item-container">';
					if ( $pro_hovers && array_key_exists( $key, $pro_hovers ) ) {
						$effect  .= '<span class="modula-preview-badge">' . esc_html__( 'Premium', 'modula-best-grid-gallery' ) . '</span>';
						$class[]  = 'pro-only';
					}
					$effect .= '<div class="' . esc_attr( implode( ' ', $class ) ) . '">';

					if ( 'under' == $key ) {
						$effect .= '<div class="modula-item-image-continer"><img src="' . esc_url( MODULA_URL . '/assets/images/effect.jpg' ) . '" class="pic"></div>';
					} else {
						$effect .= '<img src="' . esc_url( MODULA_URL . '/assets/images/effect.jpg' ) . '" class="pic">';
					}

					if ( in_array( $key, $effect_array ) ) {
						$effect .= '<div class="tilter__deco tilter__deco--shine"><div></div></div>';
						if ( in_array( $key, $overlay_array ) ) {
							$effect .= '<div class="tilter__deco tilter__deco--overlay"></div>';
						}
						if ( in_array( $key, $svg_array ) ) {
							$effect .= '<div class="tilter__deco tilter__deco--lines"></div>';
						}

					}

					if ( 'none' != $key ) {

						$effect .= '<div class="figc"><div class="figc-inner">';

						if ( $effect_elements[ 'title' ] ) {
							$effect .= '<h2 class="jtg-title">Lorem ipsum</h2>';
						}

						if ( in_array( $key, $jtg_body ) ) {
							$effect .= '<div class="jtg-body">';
						}

						if ( $effect_elements[ 'description' ] ) {
							$effect .= '<p class="description">Quisque diam erat, mollisvitae enim eget</p>';
						} else {
							$effect .= '<p class="description"></p>';
						}

						if ( $effect_elements[ 'social' ] ) {
							$effect .= '<div class="jtg-social">';
							$effect .= '<a href="#">' . Modula_Helper::get_icon( 'twitter' ) . '</a>';
							$effect .= '<a href="#">' . Modula_Helper::get_icon( 'facebook' ) . '</a>';
							$effect .= '<a href="#">' . Modula_Helper::get_icon( 'pinterest' ) . '</a>';
							$effect .= '<a href="#">' . Modula_Helper::get_icon( 'linkedin' ) . '</a>';
							$effect .= '</div>';
						}

						if ( in_array( $key, $jtg_body ) ) {
							$effect .= '</div>';
						}

						$effect .= '</div></div>';
					}

					$effect .= '</div>';
					$effect .= '<div class="modula-preview-item-content">';
					$effect .= '<h4>' . $name . '</h4>';
					if ( $effect_elements[ 'title' ] || $effect_elements[ 'description' ] || $effect_elements[ 'social' ] || $effect_elements[ 'scripts' ] ) {
						
						$effect .= '<div class="effect-compatibility">';
						$effect .= '<p class="description">' . esc_html__( 'This effect is compatible with:', 'modula-pro' );

						if ( $effect_elements[ 'title' ] ) {
							$effect .= '<span><strong> ' . esc_html__( 'Title', 'modula-pro' ) . '</strong></span>,';
						}

						if ( $effect_elements[ 'description' ] ) {
							$effect .= '<span><strong> ' . esc_html__( 'Description', 'modula-pro' ) . '</strong></span>,';
						}

						if ( $effect_elements[ 'social' ] ) {
							$effect .= '<span><strong> ' . esc_html__( 'Social Icons', 'modula-pro' ) . '</strong></span>';
						}
						$effect .= '</p>';

						if ( $effect_elements[ 'scripts' ] ) {
							$effect .= '<p class="description">' . esc_html__( 'This effect will add an extra js script to your gallery', 'modula-pro' ) . '</p>';
						} else {
							$effect .= '<p class="description">&nbsp;</p>';
						}

						$effect .= '</div>';

					}
					
					$effect .= '</div>';
					$effect .= '</div>';
					$effect .= '</div>';

					$html .= $effect;
				}

				$html .= '</div></div>';

				// Hook to change how hover effects field is rendered
				$html = apply_filters( "modula_render_hover_effect_field_type", $html, $field );

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
			case 'dimensions-select' :
				$sizes = Modula_Helper::get_image_sizes();
				$html = '<select name="modula-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" class="regular-text">';
				$infos = '';

				foreach ( $sizes as $key => $size ) {

					$html .= '<option value="' . esc_attr( $key ) . '" ' . selected( $key, $value, false ) . '>' . esc_html( ucfirst(str_replace('-', ' ', $key) )) . '</option>';

					$infos .= '<div class="modula-imagesize-info" data-size="' . esc_attr( $key ) . '"><span>' . esc_html__( 'Image Size', 'modula-best-grid-gallery' ) . '</span>: ' . $size['width'] . 'x' . $size['height'];
					$infos .= '. <span>'.esc_html__('Crop','modula-best-grid-gallery').'</span>: ' . ( boolval( $size['crop'] ) ? 'true' : 'false' ) . '</div>';
				}

				$html .= '<option value="full" '. selected( 'full', $value, false ).'>' . __( 'Full', 'modula-best-grid-gallery' ) . '</option>';
				$html .= '<option value="custom" '.selected( 'custom', $value, false ).'>' . __( 'Custom', 'modula-best-grid-gallery' ) . '</option>';
				$html .= '</select>';
				if ( '' != $infos ) {
					$html .= '<div class="modula-imagesizes-infos">' . $infos . '</div>';
				}
				break;
			case 'textarea-placeholder' :
				$html = '<div class="modula-textarea-placeholder">';
				$html .= '<textarea data-setting="' . esc_attr( $field['id'] ) . '" name="modula-settings[' . esc_attr( $field['id'] ) . ']" id="modula-' . esc_attr( $field['id'] ) . '" rows="5" cols="50">' . wp_kses_post( $value ) . '</textarea>';
				$html .= '</div>';
				$html .= '<div class="modula-placeholders">';
				foreach ( $field['values'] as $key => $value ) {
		
					$html .= "<span data-placeholder='" . esc_attr( $key ) . "' class='modula-placeholder-value'>";
					$html .= esc_html__( $value, 'modula-best-grid-gallery' );
					$html .= '</span>';
				}
				$html .= '</div>';
				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
			case 'placeholder' :
				$html = '<input class="modula-placeholder-input" type="text" name="modula-settings[' . esc_attr( $field['id'] ) . ']" data-setting="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $value ) . '">';
				$html .= '<div class="modula-placeholders">';
				foreach ( $field['values'] as $key => $value ) {
		
					$html .= "<span data-placeholder='" . esc_attr( $key ) . "' class='modula-placeholder-value'>";
					$html .= esc_html__( $value, 'modula-best-grid-gallery' );
					$html .= '</span>';
				}
				$html .= '</div>';
				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
			default:
				/* Filter for render custom field types */
				$html = apply_filters( "modula_render_{$field['type']}_field_type", $html, $field, $value );

				if(isset($field['afterrow'])){
					$html .= '<p class="description '.esc_attr($field['id']).'-afterrow">'.esc_html($field['afterrow']).'</p>';
				}
				break;
		}

		return apply_filters( "modula_render_field_type", $html, $field, $value );

	}

	public function print_modula_templates() {
		include 'modula-js-templates.php';
	}

}