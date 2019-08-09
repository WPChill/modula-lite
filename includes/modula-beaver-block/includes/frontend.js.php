/**
 * This file should contain frontend JavaScript that
 * will be applied to individual module instances.
 *
 * You have access to three variables in this file:
 *
 * $module An instance of your module class.
 * $id The module's ID.
 * $settings The module's settings.
 *
 * Example:
 */


var $gallery = jQuery('.modula-gallery');
if ($gallery.length > 0) {
    var galleryID = $gallery.attr('id'),
        modulaSettings = $gallery.data('config'),
        modulaInstance = jQuery('#' + galleryID).data('plugin_modulaGallery');
console.log(galleryID,modulaInstance);
    if (modulaInstance) {
        modulaInstance.destroy();
        jQuery('#' + galleryID).data('plugin_modulaGallery', null);
    }

    //jQuery('#' + galleryID).modulaGallery(modulaSettings);

}