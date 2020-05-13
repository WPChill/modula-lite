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