<?php $troubleshooting_options = get_option('modula_troubleshooting_option');
$enqueu_css = isset($troubleshooting_options['enqueue_css']) ? $troubleshooting_options['enqueue_css'] : false;
$enqueue_js = isset($troubleshooting_options['enqueue_js']) ? $troubleshooting_options['enqueue_js'] : false;
?>
<div class="row">
    <h1 class="wp-clearfix"><?php echo esc_html__('Select Modula\'s CSS files and/or JS files to be enqueued on all pages.', 'modula-best-grid-gallery'); ?></h1>
    <p><?php echo esc_html__('If you have problems with displaying or running Modula Galleries you might want to enqueue Modula CSS and JS in all pages.','modula-best-grid-gallery'); ?></p>
    <form id="modula_uninstall_option" method="post">
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th  scope="row" valign="top">
                    <?php echo esc_html__('Enqueue CSS files on all pages','modula-best-grid-gallery'); ?>
                </th>
                <td>
                    <div class="wrap modula">
                        <div class="">
                            <div class="modula-toggle">
                                <input class="modula-toggle__input" type="checkbox"
                                       data-setting="modula_troubleshooting_option[enqueue_css]"
                                       id="modula_troubleshooting_option[enqueue_css]" name="modula_troubleshooting_option[enqueue_css]"
                                       value="1" <?php echo checked(1, $enqueu_css, false); ?>>
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
            <tr valign="top">
                <th  scope="row" valign="top">
                    <?php echo esc_html__('Enqueue JS files on all pages.','modula-best-grid-gallery'); ?>
                </th>
                <td>
                    <div class="wrap modula">
                        <div class="">
                            <div class="modula-toggle">
                                <input class="modula-toggle__input" type="checkbox"
                                       data-setting="modula_troubleshooting_option[enqueue_js]"
                                       id="modula_troubleshooting_option[enqueue_js]" name="modula_troubleshooting_option[enqueue_js]"
                                       value="1" <?php echo checked(1, $enqueue_js, false); ?>>
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
            <tr valign="top">
                <td>
                    <div>
                        <?php submit_button(__('Save', 'modula-importer'), 'primary', 'modula-troubleshooting-submit', false); ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
