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

		// Copy shortcode functionality
		$('.copy-modula-shortcode').click(function (e) {
			e.preventDefault();
			var gallery_shortcode = $(this).parent().find('input');
			gallery_shortcode.focus();
			gallery_shortcode.select();
			document.execCommand("copy");
			$(this).next('span').text('Shortcode copied');
			$('.copy-modula-shortcode').not($(this)).parent().find('span').text('');

		});
	});

})(jQuery);