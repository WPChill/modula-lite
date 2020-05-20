jQuery( '.modula-link input[name="link"]' ).live( "keydown.autocomplete", function() {
	let url = autocompleteUrl.url + "?action=modula_autocomplete";
	jQuery(this).autocomplete({
		source: url,
		delay: 500,
		minLength: 3
	})
} );