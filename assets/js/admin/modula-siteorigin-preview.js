jQuery(function ($) {
    $(window).load(function () {
        // set timeout to let the editor preview load completely
        setTimeout(function () {
            gallery_preview();
            block_preview_image_click();
        }, 600);
    });

    /**
     * Reinitiate the Modula Gallery when editing the post and nonlive preview
     */
    function gallery_preview() {

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

    /**
     * Prevent lightbox openinng when
     */
    function block_preview_image_click() {
        $('.modula-gallery a.tile-inner').click(function (e) {
            e.preventDefault();
        });
    }
});