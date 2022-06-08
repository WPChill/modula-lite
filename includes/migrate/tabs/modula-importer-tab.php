<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Assume everything is false.
$sources   = false;
$galleries = false;

$migrate = isset($_GET['migration']) ? sanitize_text_field( wp_unslash( $_GET['migration'] ) ) : false;
$delete  = isset($_GET['delete']) ? sanitize_text_field( wp_unslash( $_GET['delete'] ) )  : false;

$modula_importer = Modula_Importer::get_instance();
$sources         = $modula_importer->get_sources();

$sources = apply_filters('modula_importable_galleries', $sources);
?>

    <div class="row">
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php esc_html_e('Gallery source', 'modula-best-grid-gallery'); ?>
                    <div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span>
                        <div class="tab-header-description modula-tooltip-content">
                            <?php esc_html_e('Select from which source would you like to migrate the gallery.', 'modula-best-grid-gallery') ?>
                            <?php esc_html_e('Migrating galleries will also replace the shortcode of the gallery with the new Modula shortcode in pages and posts.', 'modula-best-grid-gallery') ?>
                        </div>
                    </div>
                </th>
                <td>
                    <select name="modula_select_gallery_source" id="modula_select_gallery_source">
                        <option value="none"><?php echo ($sources && count($sources) > 0) ? esc_html('Select gallery source', 'modula-best-grid-gallery') : esc_html('No galleries detected', 'modula-best-grid-gallery'); ?></option>
                        <?php
                        if ($sources) {
                            foreach ($sources as $source => $label) {
                                echo '<option value="' . esc_attr($source) . '"> ' . esc_html($label) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- Select all checkbox-->
    <div class="row select-all-wrapper hide">
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php echo esc_html__('Gallery database entries.', 'modula-best-grid-gallery'); ?>
                    <div class="tab-header-tooltip-container modula-tooltip"><span>[?]</span>
                        <div class="tab-header-description modula-tooltip-content">
                            <?php esc_html_e('Check this if you want to delete remnants or data entries in the database from the migrated galleries.', 'modula-best-grid-gallery') ?>
                        </div>
                    </div>
                </th>
                <td>
                    <div>
                        <label for="delete-old-entries"
                               data-id="delete-old-entries" >
                            <input type="checkbox" name="delete-old-entries"
                                   id="delete-old-entries"
                                   value="" />
                            <?php echo esc_html__('Delete old gallery entries.', 'modula-best-grid-gallery'); ?>
                        </label>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="update-complete">
        <?php
        if ($migrate && !$delete) {
            echo '<h3>' . esc_html__('All done, good job! All galleries have been migrated.', 'modula-best-grid-gallery') . '</h3>';
        }

        if ($migrate && $delete) {
            echo '<h3>' . esc_html__('All done, good job! All galleries have been migrated and old entries have been deleted.', 'modula-best-grid-gallery') . '</h3>';
        }

        ?>
    </div>
<?php
if ($sources) {
    foreach ($sources as $source => $label) {
        ?>

        <div id="modula-<?php echo esc_attr($source); ?>-importer" class="row modula-importer-row hide">
            <div id="modula_importer_<?php echo esc_attr($source); ?>" class="modula-importer-wrapper" source="<?php echo esc_attr($source); ?>">
                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row" valign="top">
                            <?php echo esc_html('Galleries to import', 'modula-best-grid-gallery'); ?>
                        </th>
                        <td>
                            <div class="modula-importer-checkbox-wrapper">
                                <a href="#select_all"
                                   class="modula-all-selection"><?php esc_html_e( 'Select all', 'modula-best-grid-gallery' ); ?></a>
                                / <a href="#deselect_all"
                                     class="modula-all-selection"><?php esc_html_e( 'Deselect all', 'modula-best-grid-gallery' ); ?></a>
                            </div>
                            <div class="modula-found-galleries"></div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" valign="top">
                        </th>
                        <td>
                            <div>
                                <?php submit_button(__('Migrate', 'modula-best-grid-gallery'), 'primary', 'modula-importer-submit-' . $source, false); ?>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}
?>