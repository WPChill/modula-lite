<?php $uninstall_options = get_option('modula_uninstall_option');
$delete_options = isset($uninstall_options['delete_options']) ? $uninstall_options['delete_options'] : false;
$delete_cpt = isset($uninstall_options['delete_cpt']) ? $uninstall_options['delete_cpt'] : false;
$delete_transients = isset($uninstall_options['delete_transients']) ? $uninstall_options['delete_transients'] : false;
?>
<div class="row">
    <h1 class="wp-clearfix"><?php echo esc_html__('Uninstall Modula options', 'modula-best-grid-gallery'); ?></h1>
    <p><?php echo esc_html__('Select what you want to be deleted if you uninstall Modula.','modula-best-grid-gallery'); ?></p>
    <p class="description alert"><?php _e('CAUTION. THIS <strong>CAN NOT</strong> BE UNDONE!','modula-best-grid-gallery'); ?></p>

    <form id="modula_uninstall_option" method="post">
        <table class="form-table">
            <tbody>
            <!-- If Envira gallery plugin is installed and active and there are galleries created -->
            <tr valign="top">
                <th  scope="row" valign="top">
                    <?php echo esc_html__('Delete modula set options','modula-best-grid-gallery'); ?>
                </th>
                <td>
                    <div class="wrap modula">
                        <div class="">
                            <div class="modula-toggle">
                                <input class="modula-toggle__input" type="checkbox"
                                       data-setting="modula_uninstall_option[delete_options]"
                                       id="modula_uninstall_option[delete_options]" name="modula_uninstall_option[delete_options]"
                                       value="1" <?php echo checked(1, $delete_options, false); ?>>
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
                    <?php echo esc_html__('Delete modula set transients','modula-best-grid-gallery'); ?>
                </th>
                <td>
                    <div class="wrap modula">
                        <div class="">
                            <div class="modula-toggle">
                                <input class="modula-toggle__input" type="checkbox"
                                       data-setting="modula_uninstall_option[delete_transients]"
                                       id="modula_uninstall_option[delete_transients]" name="modula_uninstall_option[delete_transients]"
                                       value="1" <?php echo checked(1, $delete_transients, false); ?>>
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
                    <?php echo __('Delete <code>modula-gallery</code> custom post type','modula-best-grid-gallery'); ?>
                </th>
                <td>
                    <div class="wrap modula">
                        <div class="">
                            <div class="modula-toggle">
                                <input class="modula-toggle__input" type="checkbox"
                                       data-setting="modula_uninstall_option[delete_cpt]"
                                       id="modula_uninstall_option[delete_cpt]" name="modula_uninstall_option[delete_cpt]"
                                       value="1" <?php echo checked(1, $delete_cpt, false); ?>>
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
                        <?php submit_button(__('Save', 'modula-importer'), 'primary', 'modula-uninstall-submit', false); ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
