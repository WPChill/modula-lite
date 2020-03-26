wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;
wp.Modula.modalChildViews = 'undefined' === typeof( wp.Modula.modalChildViews ) ? [] : wp.Modula.modalChildViews;
wp.Modula.previewer = 'undefined' === typeof( wp.Modula.previewer ) ? {} : wp.Modula.previewer;
wp.Modula.modal = 'undefined' === typeof( wp.Modula.modal ) ? {} : wp.Modula.modal;
wp.Modula.items = 'undefined' === typeof( wp.Modula.items ) ? {} : wp.Modula.items;
wp.Modula.upload = 'undefined' === typeof( wp.Modula.upload ) ? {} : wp.Modula.upload;

jQuery( document ).ready( function( $ ){

	// Here we will have all gallery's items.
	wp.Modula.Items = new wp.Modula.items['collection']();
	
	// Settings related objects.
	wp.Modula.Settings = new wp.Modula.settings['model']( modulaHelper.settings );

	// Modula conditions
	wp.Modula.Conditions = new modulaGalleryConditions();

	// Initiate Modula Resizer
	if ( 'undefined' == typeof wp.Modula.Resizer ) {
		wp.Modula.Resizer = new wp.Modula.previewer['resizer']();
	}
	
	// Initiate Gallery View
	wp.Modula.GalleryView = new wp.Modula.previewer['view']({
		'el' : $( '#modula-uploader-container' ),
	});

	// Modula edit item modal.
	wp.Modula.EditModal = new wp.Modula.modal['model']({
		'childViews' : wp.Modula.modalChildViews
	});

	// Here we will add items for the gallery to collection.
	if ( 'undefined' !== typeof modulaHelper.items ) {
		$.each( modulaHelper.items, function( index, image ){
			var imageModel = new wp.Modula.items['model']( image );
		});
	}

	// Initiate Modula Gallery Upload
	new wp.Modula.upload['uploadHandler']();

	// Copy shortcode functionality
    $('.copy-modula-shortcode').click(function (e) {
        e.preventDefault();
        var gallery_shortcode = $(this).parent().find('input');
        gallery_shortcode.focus();
        gallery_shortcode.select();
        document.execCommand("copy");
        $(this).next('span').text('Shortcode copied');
    });

	$('#modula-image-loaded-effects ').on('click','#test-scaling-preview',function (e) {
		e.preventDefault();
		var val     = $('input[data-setting="loadedScale"]').val();
		var targets = $('#modula-image-loaded-effects .modula-item');
		targets.css('transform', 'scale(' + val / 100 + ')');
		setTimeout(function () {
			targets.removeAttr('style')
		}, 600)
	});

	$(document).keydown(function(e) {
		if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
		{
			e.preventDefault();
			$( '#publish' ).click();
			return false;
		}
		return true; });

});