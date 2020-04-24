jQuery(function ($) {

    elementorFrontend.hooks.addAction( 'frontend/element_ready/modula_elementor_gallery.default', function( $scope ) {

        var $gallery = $scope.find( '.modula-gallery' );

        if ( $gallery.length > 0 ) {
            var galleryID = $gallery.attr( 'id' ),
                modulaSettings = $gallery.data( 'config' ),
                modulaInstance = jQuery( '#' + galleryID ).data( 'plugin_modulaGallery' );
                
            if ( modulaInstance ) {
                modulaInstance.destroy();
                jQuery( '#' + galleryID ).data( 'plugin_modulaGallery', null );
            }

            $( '#' + galleryID ).modulaGallery( modulaSettings );
        }

    } );

});