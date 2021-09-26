( function( $ ){
	"use strict";

	$( document ).ready(function(){
		$('#modula-reload-extensions').click(function(evt){
			evt.preventDefault();
			$( this ).addClass( 'updating-message' );

			$.ajax({
			  	method: "POST",
			  	url: ajaxurl,
			  	data : { action: "modula_reload_extensions", nonce: $( this ).data('nonce') },
			}).done(function( msg ) {
		    	location.reload();
		  	});
		});
	});

})( jQuery );


(function( wp, $ ) {
	'use strict';
	if ( ! wp ) {
		return;
	}

	jQuery( '.modula-free-addon-actions a' ).click( function ( e ) {
		e.preventDefault();

		var slug = jQuery( this ).data( 'slug' );
		var action = jQuery( this ).data( 'action' );

		if ( 'install' == action ) {
			wp.updates.installPlugin( {
				slug: slug
			} );
		}
	} );
})( window.wp, jQuery );