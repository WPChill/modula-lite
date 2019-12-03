<?php

$troubleshooting_options = get_option('modula_troubleshooting_option');
$enqueue_files           = isset($troubleshooting_options['enqueue_files']) ? $troubleshooting_options['enqueue_files'] : false;
$pass_protect            = isset($troubleshooting_options['pass_protect']) ? $troubleshooting_options['pass_protect'] : false;
$download_protect        = isset($troubleshooting_options['download_protect']) ? $troubleshooting_options['download_protect'] : false;
$deeplink                = isset($troubleshooting_options['deeplink']) ? $troubleshooting_options['deeplink'] : false;
$grid_type               = isset($troubleshooting_options['grid_type']) ? $troubleshooting_options['grid_type'] : false;
$lightbox                = isset($troubleshooting_options['lightbox']) ? $troubleshooting_options['lightbox'] : false;

$subfield_class = ($enqueue_files) ? '' : 'hide';

?>
<div class="row">
    <h1 class="wp-clearfix"><?php echo esc_html__('Select Modula\'s CSS files and/or JS files to be enqueued on all pages.', 'modula-best-grid-gallery'); ?></h1>
    <p><?php echo esc_html__('If you have problems with displaying or running Modula Galleries you might want to enqueue Modula CSS and JS in all pages.', 'modula-best-grid-gallery'); ?></p>
    <form id="modula_troubleshooting_option" method="post">
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php echo esc_html__('Enqueue CSS & JS files on all pages', 'modula-best-grid-gallery'); ?>
                </th>
                <td>
                    <div class="wrap modula">
                        <div class="">
                            <div class="modula-toggle">
                                <input class="modula-toggle__input master-toggle" type="checkbox"
                                       data-setting="modula_troubleshooting_option[enqueue_files]"
                                       id="modula_troubleshooting_option"
                                       name="modula_troubleshooting_option[enqueue_files]"
                                       value="1" <?php echo checked(1, $enqueue_files, false); ?>>
                                <div class="modula-toggle__items">
                                    <span class="modula-toggle__track"></span>
                                    <span class="modula-toggle__thumb"></span>
                                    <svg class="modula-toggle__off" width="6" height="6" aria-hidden="true" role="img"
                                         focusable="false"
                                         viewBox="0 0 6 6">
                                        <path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
                                    </svg>
                                    <svg class="modula-toggle__on" width="2" height="6" aria-hidden="true" role="img"
                                         focusable="false"
                                         viewBox="0 0 2 6">
                                        <path d="M0 0h2v6H0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
            foreach ($troubleshooting_fields as $ts_field) {
                ?>
                <tr valign="top" data-settings="subfields" class="troubleshoot-subfield <?php echo $subfield_class; ?>">
                    <th scope="row" valign="top">
                        <?php echo esc_html($ts_field['name']); ?>
                    </th>
                    <td>
                        <div class="wrap modula">
                            <div class="">
                                <?php if ('select' == $ts_field['type']) { ?>
                                    <div class="modula-select">
                                        <select name="modula_troubleshooting_option[<?php echo $ts_field['data_settings']; ?>]">
                                            <?php
                                            foreach ($ts_field['values'] as $value => $name) {
                                                echo "<option value='{$value}' " . selected($troubleshooting_options[$ts_field['data_settings']], $value, false) . ">{$name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>

                                <?php if ('toggle' == $ts_field['type']) { ?>
                                    <div class="modula-toggle">
                                        <input class="modula-toggle__input" type="checkbox"
                                               data-setting="modula_troubleshooting_option[<?php echo $ts_field['data_settings']; ?>]"
                                               id="modula_troubleshooting_option[<?php echo $ts_field['data_settings']; ?>]"
                                               name="modula_troubleshooting_option[<?php echo $ts_field['data_settings']; ?>]"
                                               value="1" <?php echo isset($troubleshooting_options[$ts_field['data_settings']]) ? checked(1, $troubleshooting_options[$ts_field['data_settings']], false) : ''; ?>>
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
