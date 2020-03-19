wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

(function( $, modula ){

    var modulaSettings = Backbone.Model.extend({
    	initialize: function( args ){
            var model = this;
            $.each( args, function( att, value ){
                model.set( att, value );
            });

      		var view = new modula.settings['view']({
      			model: this,
      			el: $( '#modula-settings' )
      		});

      		this.set( 'view', view );

        },
    });

    var modulaSettingsView = Backbone.View.extend({

    	events: {
    		// Tabs specific events
    		'click .modula-tab':     'changeTab',
            'click .modula-tab > *': 'changeTabFromChild',

    		// Settings specific events
            'keyup input':         'updateModel',
            'keyup textarea':      'updateModel',
            'change input':        'updateModel',
            'change textarea':     'updateModel',
            'blur textarea':       'updateModel',
            'change select':       'updateModel',
        },

        initialize: function( args ) {
        	this.initializeLite();
        },

        initializeLite: function(){

            this.tabs          = this.$el.find( '.modula-tabs .modula-tab' );
            this.tabContainers = this.$el.find( '.modula-tabs-content > div' );
            this.sliders       = this.$el.find( '.modula-ui-slider' );
            this.colorPickers  = this.$el.find( '.modula-color' );
            this.customEditors = this.$el.find( '.modula-code-editor' );

            // initialize 3rd party scripts
            this.initSliders();
            this.initColorPickers();
            this.initCustomCSS();
            this.initSlickSlider();

        },

        updateModel: function( event ) {
        	var value, setting;

        	// Check if the target has a data-field. If not, it's not a model value we want to store
            if ( undefined === event.target.dataset.setting ) {
                return;
            }

            setting = event.target.dataset.setting;

            // Update the model's value, depending on the input type
            if ( event.target.type == 'checkbox' ) {
                value = ( event.target.checked ? event.target.value : 0 );
            } else {
                value = event.target.value;
            }

            // Update the model
            this.model.set( setting, value );

        },

        changeTab: function ( event ) {

        	var currentTab = jQuery( event.target ).data( 'tab' );

            if ( this.tabContainers.filter( '#' + currentTab ).length < 1 ) {
                return;
            }

    		this.tabs.removeClass( 'active-tab' );
    		this.tabContainers.removeClass( 'active-tab' );
    		jQuery( event.target ).addClass( 'active-tab' );
    		this.tabContainers.filter( '#' + currentTab ).addClass( 'active-tab' ).trigger( 'modula-current-tab' );

        },

        changeTabFromChild: function ( event ) {

            var currentTab = jQuery( event.target ).parent().data( 'tab' );

            if ( this.tabContainers.filter( '#' + currentTab ).length < 1 ) {
                return;
            }

            this.tabs.removeClass( 'active-tab' );
            this.tabContainers.removeClass( 'active-tab' );
            jQuery( event.target ).parent().addClass( 'active-tab' );
            this.tabContainers.filter( '#' + currentTab ).addClass( 'active-tab' );

        },

        initSliders: function() {

        	if ( this.sliders.length > 0 ) {
    			this.sliders.each( function( $index, $slider ) {
                    var input = jQuery( $slider ).parent().find( '.modula-ui-slider-input' ),
                        max = input.data( 'max' ),
                        min = input.data( 'min' ),
                        step = input.data( 'step' ),
                        value = parseInt( input.val(), 10 );

                    jQuery( $slider ).slider({
                        value: value,
                        min: min,
                        max: max,
                        step: step,
                        range: 'min',
                        slide: function( event, ui ) {
                            input.val( ui.value ).trigger( 'change' );
                        }
                    });
                });
    		}

        },

        initColorPickers: function() {
        	if ( this.colorPickers.length > 0 ) {
                this.colorPickers.each( function( $index, colorPicker ) {
                	//@todo: we need to find a solution to trigger a change event on input.
                    jQuery( colorPicker ).wpColorPicker();
                });
            }
        },

        initCustomCSS: function() {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            if ( this.customEditors.length > 0 ) {
                this.customEditors.each( function( $index, customEditorContainer ) {
                    var syntax          = $( customEditorContainer ).data( 'syntax' ),
                        id              = '#' + $( customEditorContainer ).find( '.modula-custom-editor-field' ).attr( 'id' ),
                        currentSettings = _.extend(
                            {},
                            editorSettings.codemirror,
                            {
                                mode: syntax,
                            }
                        );

                    var editor =  wp.codeEditor.initialize( $( id ), currentSettings );

                    $( customEditorContainer ).parents( '.modula-tab-content' ).on( 'modula-current-tab',function(){
                        editor.codemirror.refresh();
                    });
                });
            }
        },
        initSlickSlider: function() {

            $('#modula-hover-effect').on('modula-current-tab', function () {
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

	            if ( 'none' == wp.Modula.Settings.get('effect') || 'pufrobo' == wp.Modula.Settings.get('effect') ) {
		            var data = {
			            action: 'modula_hover_preview_action',
			            images: jQuery.parseJSON($images),
			            effect: wp.Modula.Settings.get('effect'),
			            socials: $socials_settings,
			            nonce: modulaGalleryConditionsHelper.nonce
		            };

		            jQuery.ajax({
			            method: 'POST',
			            url: modulaGalleryConditionsHelper.ajaxURL,
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
				            prevArrow: '<a href="#" class="slick-prev"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="#fff" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg></a>',
				            nextArrow: '<a href="#" class="slick-next"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="#fff" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg></a>',
			            });
		            });
	            }
            });

	        $('#modula-image-loaded-effects').on('modula-current-tab', function () {
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

		        var data = {
			        action: 'modula_loaded_preview_action',
			        images: jQuery.parseJSON($images),
			        socials: $socials_settings,
			        nonce: modulaGallerySettingsHelper.nonce
		        };

		        jQuery.ajax({
			        method: 'POST',
			        url: modulaGallerySettingsHelper.ajaxURL,
			        data: data,
			        cache: false,
		        }).done(function (data) {
			        jQuery('#modula-image-loaded-effects .modula-effects-preview.modula').html(data);
		        });
	        });
        }
       
    });

    modula.settings = {
        'model' : modulaSettings,
        'view' : modulaSettingsView
    };

}( jQuery, wp.Modula ))

