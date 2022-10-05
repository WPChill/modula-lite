wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

jQuery.fn.setting_state = function( el, state) {

	if( state == 'off'){
		this.css('opacity', '0.5');
		this.find('input, textarea, select, button').attr('disabled', 'disabled');
	}
	if( state == 'on'){
		this.css('opacity', '1');
		this.find('input, textarea, select, button').removeAttr('disabled');
	}
}; 



var modulaGalleryConditions = Backbone.Model.extend({

	initialize: function( args ){

		var rows = jQuery('.modula-settings-container tr[data-container]');
		var tabs = jQuery('.modula-tabs .modula-tab');
		this.set( 'rows', rows );
		this.set( 'tabs', tabs );
		var imageSizesInfo = jQuery('.modula-settings-container tr[data-container="grid_image_size"] .modula-imagesizes-infos .modula-imagesize-info');

		this.set( 'imagesizes', imageSizesInfo );
		this.initEvents();
		this.initValues();

	},

	initEvents: function(){

		this.listenTo( wp.Modula.Settings, 'change:type', this.changedType );
		this.listenTo( wp.Modula.Settings, 'change:effect', this.changedEffect );
		this.listenTo( wp.Modula.Settings, 'change:lightbox', this.changedLightbox );
		this.listenTo( wp.Modula.Settings, 'change:enableSocial', this.enableSocial );
		this.listenTo( wp.Modula.Settings, 'change:enableEmail', this.enableEmail);
		this.listenTo( wp.Modula.Settings, 'change:enable_responsive', this.changedResponsiveness );
		this.listenTo( wp.Modula.Settings, 'change:hide_title', this.hideTitle);
		this.listenTo( wp.Modula.Settings, 'change:hide_description', this.hideCaption);
		this.listenTo(wp.Modula.Settings, 'change:grid_type', this.changedGridType);
		this.listenTo(wp.Modula.Settings, 'change:grid_image_size', this.changedGridImageSize);

	},

	initValues: function(){

		this.changedType( false, wp.Modula.Settings.get( 'type' ) );

		this.changedLightbox( false, wp.Modula.Settings.get( 'lightbox' ) );
		this.enableSocial (false, wp.Modula.Settings.get('enableSocial') );
		this.enableEmail( false, wp.Modula.Settings.get( 'enableEmail' ) );
		this.changedResponsiveness ( false, wp.Modula.Settings.get('enable_responsive') );
		this.hideTitle ( false, wp.Modula.Settings.get( 'hide_title' ) );
		this.hideCaption ( false, wp.Modula.Settings.get( 'hide_description') );
		this.changedGridType(false, wp.Modula.Settings.get('grid_type'));
		this.changedGridImageSize(false, wp.Modula.Settings.get('grid_image_size'));

	},

	changedType: function( settings, value ){
		var rows = this.get( 'rows' ),
			tabs = this.get( 'tabs' );


		if ( 'custom-grid' == value ) {

			// Show Responsive tab
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_state( this, 'on');
			
			rows.filter( '[data-container="columns"], [data-container="gutter"]' ).setting_state( this, 'on');

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).setting_state( this, 'off');
			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).hide();

			rows.filter('[data-container="maxImagesCount"]').setting_state( this, 'on');

			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').hide();
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').setting_state( this, 'off');
			
		}else if ( 'creative-gallery' == value ) {

			// Hide Responsive tab
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_state( this, 'off');

			rows.filter( '[data-container="columns"]' ).setting_state( this, 'off');

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).setting_state( this, 'on');
			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).show();

			rows.filter('[data-container="height"],  [data-container="gutter"], [data-container="shuffle"], [data-container="showAllOnLightbox"],[data-container="maxImagesCount"]').setting_state( this, 'on');


			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').hide();
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').setting_state( this, 'off');

			
		} else if('grid' == value){

			rows.filter('[data-container="grid_type"], [data-container="width"],[data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"],[data-container="maxImagesCount"]').show();
			rows.filter('[data-container="grid_type"], [data-container="width"],[data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"],[data-container="maxImagesCount"]').setting_state( this, 'on');

			rows.filter('[data-container="height"], [data-container="randomFactor"]').setting_state( this, 'off');
			rows.filter('[data-container="height"], [data-container="randomFactor"]').hide();

			tabs.filter( '[data-tab="modula-responsive"]' ).setting_state( this, 'on');

			this.changedGridType(false, wp.Modula.Settings.get('grid_type'));


		} else {

			rows.filter('[data-container="grid_type"],  [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').setting_state( this, 'off');

			rows.filter('[data-container="randomFactor"]').setting_state( this, 'on');
		}

		// Check image sizes
		this.changedGridImageSize(false, wp.Modula.Settings.get('grid_image_size'));

	},

	changedCursor: function( settings, value ) {
		var cursorBox = jQuery( '.modula-effects-preview > div' );
		cursorBox.css( 'cursor', value);
	},

	changedLightbox: function( settings, value ){
		var rows         = this.get('rows'),
			tabs         = this.get('tabs'),
			link_options = ['no-link', 'direct', 'attachment-page'];

		if ( 'fancybox' == value ) {

			rows.filter('[data-container="show_navigation"]').setting_state( this, 'on');
			tabs.filter('[data-tab="modula-exif"],[data-tab="modula-zoom"]').setting_state( this, 'on');

		} else {

			rows.filter('[data-container="show_navigation"]').setting_state( this, 'off');
			tabs.filter('[data-tab="modula-exif"],[data-tab="modula-zoom"]').setting_state( this, 'off');

		}

	},

	changedEffect: function( settings, value ){

		var hoverBoxes = jQuery( '.modula-effects-preview > div' );

		hoverBoxes.setting_state( this, 'off');
		hoverBoxes.filter( '.panel-' + value ).setting_state( this, 'on');

	},

	enableSocial: function( settings, value){

		var rows = this.get( 'rows' ),
			currentRow = rows.filter('[data-container="enableSocial"]'),
            children  = currentRow.data( 'children' );

        jQuery.each(children, function(index, item) {

            var child = jQuery('[data-container="'+item+'"]');

            if ( 0 == value ) {
            	child.hide();
            }else{
            	child.css('opacity', '1');
                child.find('input, textarea, select, button').removeAttr('disabled');
            	child.show();
            }

        });

		if ( 0 == value ) {

			currentRow.removeClass( 'modula_accordion_open' );

        }else {

			currentRow.addClass( 'modula_accordion_open' );
			this.enableEmail( false, wp.Modula.Settings.get( 'enableEmail' ) );

		}
	},

	enableEmail: function( settings, value ) {
		var rows = this.get( 'rows' ),
			currentRow = rows.filter('[data-container="enableEmail"]'),
            children  = currentRow.data( 'children' );

        jQuery.each(children, function(index, item) {

            var child = jQuery('[data-container="'+item+'"]');

            if ( 0 == value ) {
            	child.hide();
            }else{
            	child.css('opacity', '1');
                child.find('input, textarea, select, button').removeAttr('disabled');
            	child.show();
            }

        });

		if ( 1 == value && 1 == wp.Modula.Settings.get( 'enableSocial') ) {
			currentRow.addClass( 'modula_accordion_open' );
		} else {
			currentRow.removeClass( 'modula_accordion_open' );
		}
	},

	changedResponsiveness: function( settings, value){
		var rows = this.get( 'rows' ),
			currentRow = rows.filter('[data-container="enable_responsive"]'),
            children  = currentRow.data( 'children' );

        jQuery.each(children, function(index, item) {

            var child = jQuery('[data-container="'+item+'"]');

            if ( 1 == value ) {
				child.css('opacity', '1');
                child.find('input, textarea, select, button').removeAttr('disabled');
            	child.show();

            }else{
            	child.hide();
            }

        });

		if( 1 == value ) {
			rows.filter( '[data-container="tablet_columns"],[data-container="mobile_columns"]').setting_state( this, 'on');
			currentRow.addClass( 'modula_accordion_open' );
		}else {
			rows.filter( '[data-container="tablet_columns"],[data-container="mobile_columns"]').setting_state( this, 'off');
			currentRow.removeClass( 'modula_accordion_open' );
		}
	},

	hideTitle: function( settings, value ) {
		var rows = this.get( 'rows' ),
			currentRow = rows.filter('[data-container="hide_title"]'),
            children  = currentRow.data( 'children' );

			currentRow.addClass( 'modula_accordion_reversed' );

        jQuery.each(children, function(index, item) {

            var child = jQuery('[data-container="'+item+'"]');

            if ( 1 == value ) {
            	child.hide();
            }else{
            	child.css('opacity', '1');
                child.find('input, textarea, select, button').removeAttr('disabled');
            	child.show();
            }

        });


		if( 1 == value ) {

			currentRow.removeClass( 'modula_accordion_open' );
		}else {

			currentRow.addClass( 'modula_accordion_open' );
		}
	},

	hideCaption: function( settings, value ) {
		var rows = this.get( 'rows' ),
			currentRow = rows.filter('[data-container="hide_description"]'),
            children  = currentRow.data( 'children' );

			currentRow.addClass( 'modula_accordion_reversed' );

        jQuery.each(children, function(index, item) {

            var child = jQuery('[data-container="'+item+'"]');

            if ( 1 == value ) {
            	child.hide();
            }else{
            	child.css('opacity', '1');
                child.find('input, textarea, select, button').removeAttr('disabled');
            	child.show();
            }

        });

		if( 1 == value ) {

			currentRow.removeClass( 'modula_accordion_open' );
		}else {
			
			currentRow.addClass( 'modula_accordion_open' );
		}
	},

	changedGridType: function (settings, value) {

		var rows = this.get( 'rows' ),
			tabs = this.get( 'tabs' ),
			currentRow = rows.filter('[data-container="grid_type"]'),
            children  = currentRow.data( 'children' );

        jQuery.each(children, function(index, item) {

            var child = jQuery('[data-container="'+item+'"]');

            if ( 'automatic' != value ) {
            	child.hide();
            }else{
            	child.css('opacity', '1');
                child.find('input, textarea, select, button').removeAttr('disabled');
            	child.show();
            }

        });

		if ( 'grid' != wp.Modula.Settings.get('type') ) {

			return;
		}

		if( 'automatic' == value ) {

			rows.filter(' [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"]').setting_state( this, 'on');
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_state( this, 'off');

			
		} else {

			rows.filter(' [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"]').setting_state( this, 'off');
			rows.filter('[data-container="grid_type"],[data-container="gutter"]').setting_state( this, 'on');
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_state( this, 'on');

		}

	},

	changedGridImageSize: function( settings, value ) {

		let rows = this.get( 'rows' ),
			imagesizes = this.get( 'imagesizes' );

		if ( 'custom' == value ) {
			if ( 'custom-grid' == wp.Modula.Settings.get( 'type') ) {
				rows.filter( '[data-container="img_size"], [data-container="img_crop"]').setting_state( this, 'on');
				rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').setting_state( this, 'off');
			}else{
				rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').setting_state( this, 'on');
				rows.filter( '[data-container="img_size"], [data-container="img_crop"]').setting_state( this, 'off');
			}
			
		} else {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"], [data-container="img_size"], [data-container="img_crop"]').setting_state( this, 'off');
		}

		var currentInfo = imagesizes.filter( '[data-size="' + value + '"]' );
		imagesizes.setting_state( this, 'off');
		if ( currentInfo.length > 0 ) {
			currentInfo.setting_state( this, 'on');
		}
	},
});