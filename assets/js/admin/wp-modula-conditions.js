wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;


	jQuery.fn.setting_off = function() {
		this.css('opacity', '0.5');
		this.find('input, textarea, select, button').attr('disabled', 'disabled');
	}; 
	jQuery.fn.setting_on = function() {
		this.css('opacity', '1');
		this.find('input, textarea, select, button').removeAttr('disabled');
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
		// this.listenTo( wp.Modula.Settings, 'change:cursor', this.changedCursor );
		this.listenTo( wp.Modula.Settings, 'change:enable_responsive', this.changedResponsiveness );
		this.listenTo( wp.Modula.Settings, 'change:hide_title', this.hideTitle);
		this.listenTo( wp.Modula.Settings, 'change:hide_description', this.hideCaption);
		this.listenTo(wp.Modula.Settings, 'change:grid_type', this.changedGridType);
		this.listenTo(wp.Modula.Settings, 'change:grid_image_size', this.changedGridImageSize);

	},

	initValues: function(){

		this.changedType( false, wp.Modula.Settings.get( 'type' ) );
		// this.changedEffect( false, wp.Modula.Settings.get( 'effect' ) );
		// this.changedCursor( false, wp.Modula.Settings.get( 'cursor' ) );
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
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_on();
			
			rows.filter( '[data-container="columns"], [data-container="gutter"]' ).setting_on();

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).setting_off();
			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).hide();

			rows.filter('[data-container="maxImagesCount"]').setting_on();

			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').hide();
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').setting_off();
			
		}else if ( 'creative-gallery' == value ) {

			// Hide Responsive tab
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_off();

			rows.filter( '[data-container="columns"]' ).setting_off();

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).setting_on();
			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).show();

			rows.filter('[data-container="height"],  [data-container="gutter"], [data-container="shuffle"], [data-container="showAllOnLightbox"],[data-container="maxImagesCount"]').setting_on();


			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').hide();
			rows.filter('[data-container="grid_type"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').setting_off();

			
		} else if('grid' == value){

			rows.filter('[data-container="grid_type"], [data-container="width"],[data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"],[data-container="maxImagesCount"]').show();
			rows.filter('[data-container="grid_type"], [data-container="width"],[data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"],[data-container="maxImagesCount"]').setting_on();

			rows.filter('[data-container="height"], [data-container="randomFactor"]').setting_off();
			rows.filter('[data-container="height"], [data-container="randomFactor"]').hide();

			tabs.filter( '[data-tab="modula-responsive"]' ).setting_on();

			this.changedGridType(false, wp.Modula.Settings.get('grid_type'));


		} else {

			rows.filter('[data-container="grid_type"],  [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"]').setting_off();

			rows.filter('[data-container="randomFactor"]').setting_on();
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

			rows.filter('[data-container="show_navigation"]').setting_on();
			tabs.filter('[data-tab="modula-exif"],[data-tab="modula-zoom"]').setting_on();

		} else {

			rows.filter('[data-container="show_navigation"]').setting_off();
			tabs.filter('[data-tab="modula-exif"],[data-tab="modula-zoom"]').setting_off();

		}

	},

	changedEffect: function( settings, value ){

		var hoverBoxes = jQuery( '.modula-effects-preview > div' );

		hoverBoxes.setting_off();
		hoverBoxes.filter( '.panel-' + value ).setting_on();

	},

	enableSocial: function( settings, value){
		
		var rows = this.get( 'rows' );

		if ( 0 == value ) {
			rows.filter( '[data-container="enableTwitter"],[data-container="enableWhatsapp"],[data-container="enableFacebook"],[data-container="enableLinkedin"],[data-container="enablePinterest"], [data-container="enableEmail"], [data-container="emailSubject"], [data-container="emailMessage"]' ).setting_off();

			rows.filter('[data-container="socialIconColor"], [data-container="socialIconSize"],[data-container="socialIconPadding"]').setting_off();
			
        }else {
			rows.filter( '[data-container="enableTwitter"],[data-container="enableWhatsapp"],[data-container="enableFacebook"],[data-container="enableLinkedin"],[data-container="enablePinterest"], [data-container="enableEmail"]').setting_on();

			if( 1 == wp.Modula.Settings.get( 'enableEmail') ) {
				rows.filter('[data-container="emailSubject"], [data-container="emailMessage"]' ).setting_on();
			} else {
				rows.filter('[data-container="emailSubject"], [data-container="emailMessage"]' ).setting_off();
			}

			rows.filter('[data-container="socialIconPadding"],[data-container="socialIconColor"], [data-container="socialIconSize"]').setting_on();
        }
	},

	enableEmail: function( settings, value ) {
		let rows = this.get( 'rows' );

		if ( 1 == value && 1 == wp.Modula.Settings.get( 'enableSocial') ) {
			rows.filter('[data-container="emailSubject"], [data-container="emailMessage"]' ).setting_on();
		} else {
			rows.filter('[data-container="emailSubject"], [data-container="emailMessage"]' ).setting_off();
		}
	},

	changedResponsiveness: function( settings, value){
		var rows = this.get( 'rows' );

		if( 1 == value ) {
			rows.filter( '[data-container="tablet_columns"],[data-container="mobile_columns"]').setting_on();
		}else {
			rows.filter( '[data-container="tablet_columns"],[data-container="mobile_columns"]').setting_off();
		}
	},

	hideTitle: function( settings, value ) {
		var rows = this.get( 'rows' );

		if( 1 == value ) {
			rows.filter( '[data-container="titleColor"],[data-container="titleFontSize"],[data-container="mobileTitleFontSize"]').setting_off();
		}else {
			rows.filter( '[data-container="titleColor"],[data-container="titleFontSize"],[data-container="mobileTitleFontSize"]').setting_on();
		}
	},

	hideCaption: function( settings, value ) {
		var rows = this.get( 'rows' );

		if( 1 == value ) {
			rows.filter( '[data-container="captionColor"],[data-container="captionFontSize"],[data-container="mobileCaptionFontSize"]').setting_off();
		}else {
			rows.filter( '[data-container="captionColor"],[data-container="captionFontSize"],[data-container="mobileCaptionFontSize"]').setting_on();
		}
	},

	changedGridType: function (settings, value) {

		let rows = this.get( 'rows' );
		var tabs = this.get( 'tabs' );

		if ( 'grid' != wp.Modula.Settings.get('type') ) {

			return;
		}

		if( 'automatic' == value ) {

			rows.filter(' [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"]').setting_on();
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_off();
		} else {

			rows.filter(' [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"]').setting_off();

			rows.filter('[data-container="grid_type"],[data-container="gutter"]').setting_on();
			tabs.filter( '[data-tab="modula-responsive"]' ).setting_on();
		}

	},

	changedGridImageSize: function( settings, value ) {

		let rows = this.get( 'rows' ),
			imagesizes = this.get( 'imagesizes' );

		if ( 'custom' == value ) {
			if ( 'custom-grid' == wp.Modula.Settings.get( 'type') ) {
				rows.filter( '[data-container="img_size"], [data-container="img_crop"]').setting_on();
				rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').setting_off();
			}else{
				rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').setting_on();
				rows.filter( '[data-container="img_size"], [data-container="img_crop"]').setting_off();
			}
			
		} else {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"], [data-container="img_size"], [data-container="img_crop"]').setting_off();
		}

		var currentInfo = imagesizes.filter( '[data-size="' + value + '"]' );
		imagesizes.setting_off();
		if ( currentInfo.length > 0 ) {
			currentInfo.setting_on();
		}
	},

});