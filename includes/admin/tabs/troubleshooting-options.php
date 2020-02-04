<?php
$defaults = apply_filters('modula_troubleshooting_defaults', array(
    'enqueue_files'    => false,
    'pass_protect'     => false,
    'download_protect' => false,
    'deeplink'         => false,
    'gridtypes'        => array(),
    'lightboxes'       => array(),
));
$troubleshooting_options = get_option( 'modula_troubleshooting_option', array() );
$troubleshooting_options = wp_parse_args( $troubleshooting_options, $defaults );

$troubleshooting_fields = array(
    'enqueue_files' => array(
        'label'       => __('Enqueue Modula assets', 'modula-best-grid-gallery'),
        'description' => __('Enqueue CSS & JS files on all pages', 'modula-best-grid-gallery'),
        'type'        => 'toggle',
        'default'     => 0,
        'priority'    => 10,
    ),
    'gridtypes' => array(
        'label'         => __('Grid Types', 'modula-best-grid-gallery'),
        'description'   => __('Select which grid type you are using to enqueue scripts and styles', 'modula-best-grid-gallery'),
        'type'          => 'select',
        'values'        => array( 'custom-grid' => __('Custom Grid', 'modula-best-grid-gallery') ),
        'priority'      => 20,

    ),
    'lightboxes' => array(
        'label'         => __('Lightboxes', 'modula-best-grid-gallery'),
        'description'   => __('Select which lightboxes you are using to enqueue scripts and styles', 'modula-best-grid-gallery'),
        'type'          => 'select',
        'values'        => array( 'lightbox2' => __('Lightbox2', 'modula-best-grid-gallery') ),
        'priority'      => 30,
    ),
    'lazy_load' => array(
        'label'       => __('Lazy Load', 'modula-best-grid-gallery'),
        'description' => __('Check this if you\'re using Lazyload with your galleries', 'modula-best-grid-gallery'),
        'type'        => 'toggle',
        'priority'    => 40,
    )
);

$troubleshooting_fields = apply_filters( 'modula_troubleshooting_fields', $troubleshooting_fields );
$class = 'troubleshoot-subfield';
if ( ! $troubleshooting_options['enqueue_files'] ) {
    $class .= ' hide';
}

?>
<div class="row">
    <h1 class="wp-clearfix"><?php echo esc_html__('Select Modula\'s CSS files and/or JS files to be enqueued on all pages.', 'modula-best-grid-gallery'); ?></h1>
    <p><?php echo esc_html__('If you have problems with displaying or running Modula Galleries you might want to enqueue Modula CSS and JS in all pages.', 'modula-best-grid-gallery'); ?></p>
    <form id="modula_troubleshooting_option" method="post">
        <table class="form-table">
            <tbody>
            <?php
            foreach ($troubleshooting_fields as $key => $ts_field) {
                ?>
                <tr valign="top" class="<?php echo 'enqueue_files' != $key ? $class : '' ?>">
                    <th scope="row" valign="top">
                        <?php 
                        echo esc_html( $ts_field['label'] ); 

                        if ( isset( $ts_field['description'] ) ) {
                            echo '<div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span><div class="tab-header-description modula-tooltip-content">';
                            echo wp_kses_post( $ts_field['description'] );
                            echo '</div></div>';
                        }

                        ?>
                    </th>
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
                                               data-setting="modula_troubleshooting_option[<?php echo $key; ?>]"
                                               id="modula_troubleshooting_option-<?php echo $key; ?>"
                                               name="modula_troubleshooting_option[<?php echo $key; ?>]"
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
