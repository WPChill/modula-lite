wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

(function( $, modula ){

    var modulaSaveImages = {
        updateInterval: false,

        checkSave: function() {
            var self = this;

            $('#publishing-action .spinner').addClass( 'is-active' );
            $('#publishing-action #publish').attr( 'disabled', 'disabled' );

            if ( ! self.updateInterval ) {
                self.updateInterval = setInterval( $.proxy( self.saveImages, self), 1000);
            }else{
                clearInterval( self.updateInterval );
                self.updateInterval = setInterval( $.proxy( self.saveImages, self), 1000);
            }
        },

    	saveImages: function( callback = false ) {
            var images = [],
                self = this,
                ajaxData;

            clearInterval( self.updateInterval );

            wp.Modula.Items.each( function( item ) {
                var attributes = item.getAttributes();
                images[ attributes['index'] ] = attributes;
            });

            jQuery( '#modula-editor-images' ).val( JSON.stringify( images ) );

            $('#publishing-action .spinner').removeClass( 'is-active' );
            $('#publishing-action #publish').removeAttr( 'disabled' );

            if( typeof callback === "function" ) {
                callback();
            }
        },
    }

    modula.Save = modulaSaveImages;

}( jQuery, wp.Modula ))