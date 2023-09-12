jQuery( function ( $ ) {

	if ( 'undefined' != typeof elementorFrontend.hooks ) {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/modula_elementor_gallery.default', function ( $scope ) {
			var $gallery = $scope.find( '.modula-gallery' );

			if ( $gallery.length > 0 ) {

				$gallery.each(function(){

					var gal = jQuery( this );
					var modulaSettings = gal.data( 'config' ),
					    modulaInstance = gal.data( 'plugin_modulaGallery' );

					if ( modulaInstance ) {
						modulaInstance.destroy();
						gal.data( 'plugin_modulaGallery', null );
					}

					gal.modulaGallery( modulaSettings );
				} );
			}
		});
	}


	jQuery( window ).on( 'elementor/frontend/init', function(){

		elementorFrontend.hooks.addAction( 'frontend/element_ready/modula_elementor_gallery.default', function ( $scope ) {
			var $gallery = $scope.find( '.modula-gallery' );

			if ( $gallery.length > 0 ) {
				$gallery.each(function(){

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
		});

	});	

} );