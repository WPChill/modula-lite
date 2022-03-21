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

/**
 * Function to install/activate/deactivate Modula's free addons
 */
(function( wp, $ ) {
	'use strict';
	if ( ! wp ) {
		return;
	}

	function mdulaActivatePlugin( url, text_wrapper, action ) {
	    $.ajax( {
	      	async: true,
	      	type: 'GET',
	      	dataType: 'html',
	      	url: url,
	      	success: function() {

				if ( 'activate' === action ) {
					if ( !text_wrapper && 'undefined' !== typeof slug ) {
						text_wrapper = jQuery( 'input[data-slug="' + slug + '"]' ).parents( '.modula-free-addon-actions' ).find( 'span.modula-action-texts' );
					}
	
					text_wrapper.text( modulaAddons.activated_text );
				} else {
					if ( !text_wrapper && 'undefined' !== typeof slug ) {
						text_wrapper = jQuery( 'input[data-slug="' + slug + '"]' ).parents( '.modula-free-addon-actions' ).find( 'span.modula-action-texts' );
					}

					text_wrapper.text( modulaAddons.deactivated_text );
				}
				
	      	}
	    });
	}

	$( '.modula-free-addons-container .modula-toggle__input' ).on( 'change', function ( e ) {

		var activate_url   = $( this ).data( 'activateurl' ),
		    deactivate_url = $( this ).data( 'deactivateurl' ),
		    action         = $( this ).data( 'action' ),
		    text_wrapper   = $( this ).parents( '.modula-free-addon-actions' ).find( 'span.modula-action-texts' ),
		    slug           = $( this ).data( 'slug' );

		e.preventDefault();

		if ( 'install' === action ) {

			text_wrapper.text( modulaAddons.installing_text );

			const args = {
				slug: slug,
				success: (response) => {
					if ( !text_wrapper && 'undefined' !== typeof slug ) {
						text_wrapper = jQuery( 'input[data-slug="' + slug + '"]' ).parents( '.modula-free-addon-actions' ).find( 'span.modula-action-texts' );
					}

					text_wrapper.text( modulaAddons.activated_text );
					mdulaActivatePlugin( activate_url, text_wrapper, 'activate' );
				}	
			};

			wp.updates.installPlugin(args);

		} else if ( 'activate' === action ) {

			text_wrapper.text( modulaAddons.activating_text );
			mdulaActivatePlugin( activate_url, text_wrapper, action );
		} else if ( 'installed' === action ) {

			text_wrapper.text( modulaAddons.deactivating_text );
			mdulaActivatePlugin( deactivate_url,text_wrapper, action );
		}

	});


	jQuery( document ).on( 'wp-plugin-install-success', function ( response, data ) {

		if ( jQuery.inArray( data.slug, modulaAddons.free_addons ) > -1 ) {

			mdulaActivatePlugin( data.activateUrl, false, 'activate');
		}
	} );

})( window.wp, jQuery );