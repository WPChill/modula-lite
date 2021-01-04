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

    /**
     * Prevent lightbox openinng when
     */
    function block_preview_image_click() {
        $('.modula-gallery a.tile-inner').click(function (e) {
            e.preventDefault();
        });
    }
});