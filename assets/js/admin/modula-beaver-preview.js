jQuery(function ($) {
    $('.fl-builder-content').on('fl-builder.layout-rendered', beaver_gallery_preview);

    function beaver_gallery_preview() {

        var modula_gallery = $('.modula-gallery');

        if (modula_gallery.length > 0) {

            modula_gallery.each(function(){

                var gal = jQuery( this );
                var modulaSettings = gal.data( 'config' ),
                    modulaInstance = gal.data( 'plugin_modulaGallery' );

                if ( modulaInstance ) {
                    modulaInstance.destroy();
                    gal.data( 'plugin_modulaGallery', null );
                }

                gal.modulaGallery( modulaSettings );
            });
        }
    }
});