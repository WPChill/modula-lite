( function( $ ){

	"use strict";
	var Modula = {
		settingsMetabox: $( '.modula-settings-container' ),
		initHoverEffects: function() {
			var modulaObject = this,
			    input = modulaObject.settingsMetabox.find( '[name="modula-settings[effect]"]' ),
			    hoverBoxes = modulaObject.settingsMetabox.find( '.modula-effects-preview > div' );

			input.change( function(){
				var effect = $(this).val();
				hoverBoxes.hide();
				hoverBoxes.filter( '.panel-' + effect ).show();
			});
		}
	};



	$( document ).ready( function(){
		// Modula.initHoverEffects();
	});

})( jQuery );