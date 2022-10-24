<?php
$defaults = apply_filters('modula_troubleshooting_defaults', array(
    'enqueue_files'    => false,
    'pass_protect'     => false,
    'download_protect' => false,
    'deeplink'         => false,
    'gridtypes'        => array(),
    'lightboxes'       => array(),
    'lazy_load'        => false,
    'disable_edit'     => false,
    'track_data'       => false,
    'disable_srcset'   => false
));

$troubleshooting_options = get_option( 'modula_troubleshooting_option', array() );
$troubleshooting_options = wp_parse_args( $troubleshooting_options, $defaults );

$troubleshooting_fields = array(
		'misc_settings'         => array(
				'label'    => esc_html__( 'Miscelaneous settings', 'modula-best-grid-gallery' ),
				'type'     => 'heading',
				'priority' => 0
		),
		'disable_edit'          => array(
				'label'       => esc_html__( 'Disable "Edit gallery" link', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'If you want to disable the "Edit gallery" link from the front-end check this option.', 'modula-best-grid-gallery' ),
				'type'        => 'toggle',
				'priority'    => 10,
		),
		'track_data'            => array(
				'label'       => esc_html__( 'Track Data', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'We would like to track its usage on your site. We don\'t record any sensitive data, only information regarding the WordPress environment and Modula settings, which we will use to help us make improvements.', 'modula-best-grid-gallery' ),
				'type'        => 'toggle',
				'priority'    => 10,
		),
        'disable_srcset'        => array(
				'label'       => esc_html__( 'Disable images srcset', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'If you want to disable the srcset of the front-end images check this option.', 'modula-best-grid-gallery' ),
				'type'        => 'toggle',
				'priority'    => 10,
		),
		'enqueue_files_heaging' => array(
				'label'       => esc_html__( 'Enqueue assets on all pages.', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'If you have problems with displaying or running Modula Galleries you might want to enqueue Modula CSS and JS in all pages.', 'modula-best-grid-gallery' ),
				'type'        => 'heading',
				'priority'    => 10,
		),
		'enqueue_files'         => array(
				'label'       => esc_html__( 'Enqueue Modula assets', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Enqueue CSS & JS files on all pages', 'modula-best-grid-gallery' ),
				'type'        => 'toggle',
				'default'     => 0,
				'priority'    => 10,
		),
		'gridtypes'             => array(
				'label'       => esc_html__( 'Grid Types', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Select which grid type you are using to enqueue scripts and styles', 'modula-best-grid-gallery' ),
				'type'        => 'select',
				'values'      => array(
						'isotope-grid'   => __( 'General Grid ( Creative / Custom / Columns )', 'modula-best-grid-gallery' ),
						'justified-grid' => __( 'Justified Grid', 'modula-best-grid-gallery' )
				),
				'priority'    => 20,
				'class'       => array( 'troubleshoot-subfield' ),

		),
		'lightboxes'            => array(
				'label'       => esc_html__( 'Lightbox & links', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Enqueue Fancybox lightbox scripts and styles everywhere.', 'modula-best-grid-gallery' ),
				'type'        => 'select',
				'values'      => array(
						'fancybox' => esc_html__( 'Fancybox', 'modula-best-grid-gallery' )
				),
				'class'       => array( 'troubleshoot-subfield' ),
				'priority'    => 30,
		),
		'lazy_load'             => array(
				'label'       => esc_html__( 'Lazy Load', 'modula-best-grid-gallery' ),
				'description' => esc_html__( 'Check this if you\'re using Lazyload with your galleries', 'modula-best-grid-gallery' ),
				'type'        => 'toggle',
				'class'       => array( 'troubleshoot-subfield' ),
				'priority'    => 40,
		),
);

$troubleshooting_fields = apply_filters( 'modula_troubleshooting_fields', $troubleshooting_fields );

uasort( $troubleshooting_fields, array( 'Modula_Helper', 'sort_data_by_priority' ) );


?>
<div class="row">
    <form id="modula_troubleshooting_option" method="post">

        <?php
            $nonce = wp_create_nonce( 'modula_troubleshooting_option_post' )
        ?>
        <input type="hidden" name="nonce" value="<?php echo $nonce; ?>" />
        <table class="form-table">
            <tbody>
            <?php
            foreach ($troubleshooting_fields as $key => $ts_field) {
                $class = isset( $ts_field['class'] ) ? $ts_field['class'] : array();
                if ( ! $troubleshooting_options['enqueue_files'] && in_array( 'troubleshoot-subfield', $class ) ) {
                    $class[] = ' hide';
                }

				?>
                <tr valign="top" class="<?php echo esc_attr( implode( ' ', $class ) ) ?>">
					<th scope="row" style="width:300px;" valign="top" <?php echo 'heading' == $ts_field['type'] ? 'colspan="2"' : ''; ?>>
                        <?php
						echo ( 'heading' == $ts_field['type'] ) ? '<h2>' . esc_html( $ts_field['label'] ) . '</h2>' : esc_html( $ts_field['label'] ) ;

                        if ( isset( $ts_field['description'] )  ) {
                        	if('heading' != $ts_field['type']){
								echo '<div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span><div class="tab-header-description modula-tooltip-content">';
								echo wp_kses_post( $ts_field['description'] );
								echo '</div></div>';
							} else {
								echo '<p style="font-weight:normal;">' . esc_html( $ts_field['description'] ) . '</p>';
							}
                        }
                        ?>
                    </th>
					<?php if ('heading' != $ts_field['type']) { ?>
                    <td>
                        <div class="wrap modula"> 
                            <div class="">
                                <?php if ('select' == $ts_field['type']) { ?>
                                    <div class="modula-select">
                                        <?php
                                        foreach ($ts_field['values'] as $value => $label ) {
                                            echo '<label>';
                                            echo '<input type="checkbox" ' . checked( true, in_array( $value, $troubleshooting_options[ $key ] ), false ) . ' name="modula_troubleshooting_option[' . esc_attr( $key ) .'][]" value="' . esc_attr( $value ) . '">';
                                            echo '<span>' . esc_html( $label ) . '</span>';
                                            echo '</label>';
                                        }
                                        ?>
                                    </div>
                                <?php } ?>

                                <?php if ('toggle' == $ts_field['type']) { ?>
                                    <div class="modula-toggle">
                                        <input class="modula-toggle__input" type="checkbox"
                                               data-setting="modula_troubleshooting_option[<?php echo esc_attr($key); ?>]"
                                               id="modula_troubleshooting_option-<?php echo esc_attr($key); ?>"
                                               name="modula_troubleshooting_option[<?php echo esc_attr($key); ?>]"
                                               value="1" <?php  checked(1, $troubleshooting_options[ $key ], true ) ?>>
                                        <div class="modula-toggle__items">
                                            <span class="modula-toggle__track"></span>
                                            <span class="modula-toggle__thumb"></span>
                                            <svg class="modula-toggle__off" width="6" height="6" aria-hidden="true"
                                                 role="img"
                                                 focusable="false"
                                                 viewBox="0 0 6 6">
                                                <path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
                                            </svg>
                                            <svg class="modula-toggle__on" width="2" height="6" aria-hidden="true"
                                                 role="img"
                                                 focusable="false"
                                                 viewBox="0 0 2 6">
                                                <path d="M0 0h2v6H0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
					<?php } ?>
                </tr>
                <?php
            }
            ?>
            <tr valign="top">
                <td>
                    <div>
                        <?php submit_button(__('Save', 'modula-best-grid-gallery'), 'primary', 'modula-troubleshooting-submit', false); ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
