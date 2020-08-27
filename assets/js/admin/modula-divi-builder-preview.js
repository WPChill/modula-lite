jQuery(window).on('et_builder_api_ready',function(){
	var modulaGalleries = jQuery('.modula.modula-gallery');
	jQuery.each(modulaGalleries, function () {

		var modulaID = jQuery(this).attr('id'),
		    modulaSettings = jQuery(this).data('config');

		jQuery('#' + modulaID).modulaGallery(modulaSettings);
	});
});