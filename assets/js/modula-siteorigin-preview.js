jQuery(function ($) {
    $(window).load(function () {
        setTimeout(function () {
            gallery_preview();
            block_preview_image_click();
        }, 600);
        siteorigin_modula_gallery_change();
    });

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

    function block_preview_image_click(){
        $('.modula-gallery a.tile-inner').click(function(e){
            e.preventDefault();
        });
    }

    function siteorigin_modula_gallery_change() {

        $('#modula_widget_gallery_select').on('change', function () {

            alert('changed');
            var modula_gallery = $('.modula-gallery');

            if (modula_gallery.length > 0) {
                var galleryID = modula_gallery.attr('id'),
                    modulaSettings = modula_gallery.data('config'),
                    modulaInstance = jQuery('#' + galleryID).data('plugin_modulaGallery');

                if (modulaInstance) {
                    modulaInstance.destroy();
                    galleryID = $('#modula_widget_gallery_select').val();
                    jQuery('#' + galleryID).data('plugin_modulaGallery', null);
                }

                $('#' + galleryID).modulaGallery(modulaSettings);

            }
        });
    }

});