wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

var modulaGalleryConditions = Backbone.Model.extend({

	initialize: function( args ){

		var rows = jQuery('.modula-settings-container tr[data-container]');
		var tabs = jQuery('.modula-tabs .modula-tab');
		this.set( 'rows', rows );
		this.set( 'tabs', tabs );
		
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

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="margin"], [data-container="randomFactor"], [data-container="shuffle"], [data-container="margin"]' ).hide();

			rows.filter(' [data-container="randomFactor"] [data-container="img_size"],[data-container="maxImagesCount"]').show();

			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="grid_image_crop"]').hide();

			
		}else if ( 'creative-gallery' == value ) {

			// Hide Responsive tab
			tabs.filter( '[data-tab="modula-responsive"]' ).hide();

			rows.filter( '[data-container="columns"], [data-container="gutter"]' ).hide();

			rows.filter( '[data-container="width"], [data-container="height"], [data-container="margin"], [data-container="randomFactor"], [data-container="shuffle"]' ).show();

			rows.filter('[data-container="height"], [data-container="margin"], [data-container="randomFactor"], [data-container="shuffle"], [data-container="img_size"], [data-container="showAllOnLightbox"],[data-container="maxImagesCount"]').show();


			// Rows for grid type
			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="grid_image_crop"]').hide();

			
		} else if('grid' == value){

			rows.filter('[data-container="grid_type"], [data-container="width"],[data-container="grid_image_size"],[data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_row_height"], [data-container="grid_justify_last_row"], [data-container="gutter"], [data-container="grid_image_crop"]').show();

			rows.filter('[data-container="height"], [data-container="margin"], [data-container="randomFactor"], [data-container="shuffle"], [data-container="img_size"], [data-container="maxImagesCount"]').hide();

			tabs.filter( '[data-tab="modula-responsive"]' ).show();

			this.changedGridType(false, wp.Modula.Settings.get('grid_type'));

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

		var $images = jQuery('#modula-hover-effect .modula-hover-effects.modula-effects-preview.modula').attr('images');

		var $socials_settings = {
			'twitter': wp.Modula.Settings.get('enableTwitter'),
			'facebook': wp.Modula.Settings.get('enableFacebook'),
			'pinterest': wp.Modula.Settings.get('enablePinterest'),
			'linkedin': wp.Modula.Settings.get('enableLinkedin'),
			'whatsapp': wp.Modula.Settings.get('enableWhatsapp'),
			// seems to be a problem with getting the color
			'social_color': jQuery('#socialIconColor').val(),
			'social_size': wp.Modula.Settings.get('socialIconSize'),
			'social_gutter': wp.Modula.Settings.get('socialIconPadding')
		};


		if('none' == value || 'pufrobo' == value) {
			var data = {
				action: 'modula_hover_preview_action',
				images: jQuery.parseJSON($images),
				effect: value,
				socials: $socials_settings,
				nonce : modulaHelper.hover_helper
			};

			jQuery.ajax({
				method: 'POST',
				url: modulaHelper.ajax_url,
				data: data,
				cache: false,
			}).done(function (data) {
				jQuery('#modula-hover-effect .modula-effects-preview.modula').html(data);

				jQuery('#modula-hover-effect .modula-hover-preview-slider').slick({
					arrows: true,
					pauseOnHover: true,
					slidesPerRow: 1,
					slidesToShow: 2,
					slidesToScroll: 1,
					responsive: [
						{
							breakpoint: 1650,
							settings: {
								slidesPerRow: 1,
								slidesToShow: 1,
								slidesToScroll: 1,
							}
						},
					],
					prevArrow: '<a href="#" class="slick-prev"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="#fff" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg></a>',
					nextArrow: '<a href="#" class="slick-next"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="#fff" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg></a>',
				});
			});
		}

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

			rows.filter('[data-container="margin"],[data-container="grid_image_size"], [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"]').show();
			rows.filter('[data-container="gutter"]').hide();
		} else {

			rows.filter(' [data-container="grid_row_height"], [data-container="grid_max_row_height"], [data-container="grid_justify_last_row"],[data-container="margin"]').hide();

			rows.filter('[data-container="grid_type"], [data-container="grid_image_size"],[data-container="gutter"]').show();
		}

	},

	changedGridImageSize: function( settings, value ) {

		let rows = this.get( 'rows' );

		if (  'grid' != wp.Modula.Settings.get('type') ) {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').hide();
			return;

		}

		if ( 'custom' == value ) {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').show();
		} else {

			rows.filter( '[data-container="grid_image_dimensions"], [data-container="grid_image_crop"]').hide();
		}
	}

});