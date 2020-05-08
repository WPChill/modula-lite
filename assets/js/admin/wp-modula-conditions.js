wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

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
		this.listenTo( wp.Modula.Settings, 'change:disableSocial', this.disableSocial );
		this.listenTo( wp.Modula.Settings, 'change:cursor', this.changedCursor );
		this.listenTo( wp.Modula.Settings, 'change:enable_responsive', this.changedResponsiveness );
		this.listenTo( wp.Modula.Settings, 'change:hide_title', this.hideTitle);
		this.listenTo( wp.Modula.Settings, 'change:hide_description', this.hideCaption);
		this.listenTo(wp.Modula.Settings, 'change:grid_type', this.changedGridType);
		this.listenTo(wp.Modula.Settings, 'change:grid_image_size', this.changedGridImageSize);
	},

	initValues: function(){

		this.changedType( false, wp.Modula.Settings.get( 'type' ) );
		this.changedEffect( false, wp.Modula.Settings.get( 'effect' ) );
		this.changedCursor( false, wp.Modula.Settings.get( 'cursor' ) );
		this.changedLightbox( false, wp.Modula.Settings.get( 'lightbox' ) );
		this.disableSocial (false, wp.Modula.Settings.get('disableSocial') );
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
			tabs.filter( '[data-tab="modula-responsive"]' ).show();
			
			rows.filter( '[data-container="columns"], [data-container="gutter"],[data-container="img_size"]' ).show();

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).hide();

			rows.filter(' [data-container="randomFactor"] [data-container="img_size"],[data-container="maxImagesCount"]').show();

			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="grid_image_crop"]').hide();

			
		}else if ( 'creative-gallery' == value ) {

			// Hide Responsive tab
			tabs.filter( '[data-tab="modula-responsive"]' ).hide();

			rows.filter( '[data-container="columns"]' ).hide();

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="randomFactor"], [data-container="shuffle"]' ).show();

			rows.filter('[data-container="height"],  [data-container="gutter"], [data-container="randomFactor"], [data-container="shuffle"], [data-container="img_size"], [data-container="showAllOnLightbox"],[data-container="maxImagesCount"]').show();


			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="grid_image_crop"]').hide();

			
		} else if('grid' == value){

			rows.filter('[data-container="grid_type"], [data-container="width"],[data-container="grid_image_size"],[data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"], [data-container="grid_image_crop"],[data-container="maxImagesCount"]').show();

			rows.filter('[data-container="height"], [data-container="randomFactor"], [data-container="img_size"]').hide();

			tabs.filter( '[data-tab="modula-responsive"]' ).show();

			this.changedGridType(false, wp.Modula.Settings.get('grid_type'));
			this.changedGridImageSize(false, wp.Modula.Settings.get('grid_image_size'));

		} else {

			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="grid_image_crop"]').hide();
		}

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

			rows.filter('[data-container="show_navigation"]').show();

		} else {

			rows.filter('[data-container="show_navigation"]').hide();

		}

	},

	changedEffect: function( settings, value ){

		var hoverBoxes = jQuery( '.modula-effects-preview > div' );

		hoverBoxes.hide();
		hoverBoxes.filter( '.panel-' + value ).show();

	},

	disableSocial: function( settings, value){
		
		var rows = this.get( 'rows' );

		if ( 1 == value ) {
			rows.filter( '[data-container="enableTwitter"],[data-container="enableWhatsapp"],[data-container="enableFacebook"],[data-container="enableLinkedin"],[data-container="enablePinterest"],[data-container="socialIconColor"], [data-container="socialIconSize"], [data-container="socialIconPadding"]' ).prop('checked',0).hide();
			
        }else {
			rows.filter( '[data-container="enableTwitter"],[data-container="enableWhatsapp"],[data-container="enableFacebook"],[data-container="enableLinkedin"],[data-container="enablePinterest"],[data-container="socialIconColor"],[data-container="socialIconSize"], [data-container="socialIconPadding"]').prop('checked',1).show();
			
        }
	},

	changedResponsiveness: function( settings, value){
		var rows = this.get( 'rows' );

		if( 1 == value ) {
			rows.filter( '[data-container="tablet_columns"],[data-container="mobile_columns"]').show();
		}else {
			rows.filter( '[data-container="tablet_columns"],[data-container="mobile_columns"]').hide();
		}
	},

	hideTitle: function( settings, value ) {
		var rows = this.get( 'rows' );

		if( 1 == value ) {
			rows.filter( '[data-container="titleColor"],[data-container="titleFontSize"],[data-container="mobileTitleFontSize"]').hide();
		}else {
			rows.filter( '[data-container="titleColor"],[data-container="titleFontSize"],[data-container="mobileTitleFontSize"]').show();
		}
	},

	hideCaption: function( settings, value ) {
		var rows = this.get( 'rows' );

		if( 1 == value ) {
			rows.filter( '[data-container="captionColor"],[data-container="captionFontSize"],[data-container="mobileCaptionFontSize"]').hide();
		}else {
			rows.filter( '[data-container="captionColor"],[data-container="captionFontSize"],[data-container="mobileCaptionFontSize"]').show();
		}
	},

	changedGridType: function (settings, value) {

		let rows = this.get('rows');

		if ( 'grid' != wp.Modula.Settings.get('type') ) {

			return;
		}

		if( 'automatic' == value ) {

			rows.filter('[data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"]').show();
		} else {

			rows.filter(' [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"]').hide();

			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"],[data-container="gutter"]').show();
		}

	},

	changedGridImageSize: function( settings, value ) {

		let rows = this.get( 'rows' ),
			imagesizes = this.get( 'imagesizes' );

		if (  'grid' != wp.Modula.Settings.get('type') ) {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').hide();
			return;

		}

		if ( 'custom' == value ) {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').show();
		} else {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').hide();
		}

		var currentInfo = imagesizes.filter( '[data-size="' + value + '"]' );
		imagesizes.hide();
		if ( currentInfo.length > 0 ) {
			currentInfo.show();
		}
	}

});