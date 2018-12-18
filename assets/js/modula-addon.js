( function( $ ){
	"use strict";

	$( document ).ready(function(){
		$('#modula-force-reload').click(function(evt){
			evt.preventDefault();

			$.ajax({
			  	method: "POST",
			  	url: ajaxurl,
			  	data: { action: 'modula-reload-addons' }
			}).done(function( msg ) {
		    	location.reload();
		  	});
		});
	});

})( jQuery );