jQuery(function ($) {
    $('.fl-builder-content').on('fl-builder.layout-rendered', beaver_gallery_preview);

    function beaver_gallery_preview() {

        var modula_gallery = $('.modula-gallery');

        if (modula_gallery.length > 0) {
            var galleryID = modula_gallery.attr('id'),
                modulaSettings = modula_gallery.data('config'),
                modulaInstance = jQuery('#' + galleryID).data('plugin_modulaGallery');

            if (modulaInstance) {
                modulaInstance.destroy();
                jQuery('#' + galleryID).data('plugin_modulaGallery', null);
            }

            $('#' + galleryID).modulaGallery(modulaSettings);

        }
    }
});