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

	// Seems like there are at least 2 id's called modula-style
	if( $('textarea#modula-style').length ) {
		var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
		editorSettings.codemirror = _.extend(
			{},
			editorSettings.codemirror,
			{
				mode: 'css',
			}
		);
		$('.modula-tab[data-tab="modula-customizations"]').click(function(){
			// Only trigger if codemirror doesn't exist already
			if($('textarea#modula-style').next('.CodeMirror').length == 0){
				setTimeout(function(){ var editor =  wp.codeEditor.initialize( $('textarea#modula-style'), editorSettings )},10);
			}
		});

	}

});