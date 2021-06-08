wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;
wp.Modula.modalChildViews = 'undefined' === typeof( wp.Modula.modalChildViews ) ? [] : wp.Modula.modalChildViews;
wp.Modula.previewer = 'undefined' === typeof( wp.Modula.previewer ) ? {} : wp.Modula.previewer;
wp.Modula.modal = 'undefined' === typeof( wp.Modula.modal ) ? {} : wp.Modula.modal;
wp.Modula.items = 'undefined' === typeof( wp.Modula.items ) ? {} : wp.Modula.items;
wp.Modula.upload = 'undefined' === typeof( wp.Modula.upload ) ? {} : wp.Modula.upload;

(function( $ ){

	// Here we will have all gallery's items.
	if(wp.Modula.items['collection']){
		wp.Modula.Items = new wp.Modula.items['collection']();
	}

	// Settings related objects.
	wp.Modula.Settings = new wp.Modula.settings['model']( modulaHelper.settings );

	// Modula conditions
	wp.Modula.Conditions = new modulaGalleryConditions();

	// Initiate Modula Resizer
	if ( 'undefined' == typeof wp.Modula.Resizer &&  wp.Modula.previewer['resizer']) {
		wp.Modula.Resizer = new wp.Modula.previewer['resizer']();
	}
	
	// Initiate Gallery View
	if(wp.Modula.previewer['view']){
		wp.Modula.GalleryView = new wp.Modula.previewer['view']({
			'el' : $( '#modula-uploader-container' ),
		});
	}

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
	if(wp.Modula.upload['uploadHandler']){
		new wp.Modula.upload['uploadHandler']();
	}


	// Copy shortcode functionality
    $('.copy-modula-shortcode').click(function (e) {
        e.preventDefault();
        var gallery_shortcode = $(this).parent().find('input');
        gallery_shortcode.focus();
        gallery_shortcode.select();
        document.execCommand("copy");
        $(this).next('span').text('Shortcode copied');
    });

	jQuery( document ).on( "keydown.autocomplete", '.modula-link input[name="link"]', function() {

		var url = modulaHelper.ajax_url + "?action=modula_autocomplete&nonce="+modulaHelper._wpnonce;
		jQuery(this).autocomplete({
			source: url,
			delay: 500,
			minLength: 3
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )  
				.data( "item.autocomplete", item )  
				.append( `
				<div class="modula-autocomplete-results">
				<p> ${item.label} </p> <span> <code> ${item.type} </code> </span>
				<p style="color: #555; font-size: 11px;"> ${item.value} </p>
				</div>
				` )  
				.appendTo( ul );  
		};  
	} );


	$('#modula-image-loaded-effects ').on('click','#test-scaling-preview',function (e) {
		e.preventDefault();
		var val     = $('input[data-setting="loadedScale"]').val();
		var targets = $('#modula-image-loaded-effects .modula-item');
		targets.css('transform', 'scale(' + val / 100 + ')');
		setTimeout(function () {
			targets.removeAttr('style')
		}, 600)
	});

	// Dismiss notice
	$('body').on('click','#modula-lightbox-upgrade .notice-dismiss',function (e) {

		e.preventDefault();
		var notice = $(this).parent();

		var data = {
			'action': 'modula_lbu_notice',
			'nonce' : modulaHelper._wpnonce
		};

		$.post(modulaHelper.ajax_url, data, function (response) {
			// Redirect to plugins page
			notice.remove();
		});
	});

	// Save on CTRL/Meta Key + S
	$( document ).keydown( function ( e ) {
		if ( ( e.keyCode === 115 || e.keyCode === 83 ) && ( e.ctrlKey || e.metaKey ) && !( e.altKey ) ) {
			e.preventDefault();
			$( '#publish' ).click();
			return false;
		}
	} );



	$( 'tr[data-container="emailMessage"] td .modula-placeholders' ).on('click', 'span', function(){
		let input = $( 'textarea[data-setting="emailMessage"]');
		let placeholder = $(this).attr('data-placeholder') ;
		input.val( function( index, value ){
			value += placeholder;
			return value;
		})
	})

	/** Remember last tab on update */
	// search for modula in hash so we won't do the function on every hash
	if( window.location.hash.length != 0 && window.location.hash.indexOf('modula') ) {
		var modulaTabHash = window.location.hash.split( '#!' )[1];
		$( '.modula-tabs,.modula-tabs-content' ).find( '.active-tab' ).removeClass( 'active-tab' );
		$( '.modula-tabs' ).find( '.' + modulaTabHash ).addClass( 'active-tab' );
		$( '#' + modulaTabHash ).addClass( 'active-tab').trigger('modula-current-tab');
		var postAction = $( "#post" ).attr('action');
		if( postAction ) {
			postAction = postAction.split( '#' )[0];
			$( '#post' ).attr( 'action', postAction + window.location.hash );
		}
	}

	var inputs = $('#modula-hover-effect .modula-hover-effect-item input[type="radio"]');
	$( '#modula-hover-effect .modula-hover-effect-item' ).on( 'click',function () {
		let input = $( this ).find( 'input[type="radio"]' );

		if ( input.length > 0 ) {
			input.prop( "checked", false );
			input.prop( "checked", true );
		}
	} );

})(jQuery);