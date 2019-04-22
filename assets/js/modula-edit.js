(function( $ ){
	"use strict";

	$( document ).ready(function(){
		$( '.modula-feedback-notice .notice-dismiss' ).click(function(evt){
			evt.preventDefault();

			var notice = $(this).parent();
			$.ajax({
			  	method: "POST",
			  	url: ajaxurl,
			  	data: { action: "modula-edit-notice" }
			}).done(function( msg ) {
    			notice.remove();
  			});

		});
	});

})(jQuery);