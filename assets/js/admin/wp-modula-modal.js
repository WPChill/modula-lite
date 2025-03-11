wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

(function( $, modula ){

    var modulaModal = Backbone.Model.extend( {

        defaults: {
            'item': false,
        },

        initialize: function( args ){

            var modalView = new modula.modal['view']({
                'model': this,
                'childViews' : args.childViews
            });
            
            var wpMediaView = new wp.media.view.Modal( {
                controller: {
                    trigger: function() {
                    }
                }
            } );

            this.set( 'wpMediaView', wpMediaView );
            this.set( 'modulaModal', modalView );

            // Add flag for API status
            this.isApiConfigured = false;

        },

        open: function( $item ) {
            var wpMediaView = this.get( 'wpMediaView' ),
                modulaModal = this.get( 'modulaModal' );

            // Set the current item
            this.set( 'item', $item );
            // Render Modula View
            modulaModal.render();
            // Append modulaModalView to wpMediaView
            wpMediaView.content( modulaModal );
            // Open wpMediaView
            wpMediaView.open();

        }

    } );

    var modulaModalView = Backbone.View.extend( {
        /**
        * The Tag Name and Tag's Class(es)
        */
        tagName:    'div',
        className:  'edit-attachment-frame mode-select hide-menu hide-router modula-edit-popup',

        /**
        * Template
        * - The template to load inside the above tagName element
        */
        template:   wp.template( 'modula-image-editor' ),

        /**
        * Events
        * - Functions to call when specific events occur
        */
        events: {
            'click .edit-media-header .left':               'loadPreviousItem',
            'click .edit-media-header .right':              'loadNextItem',

            'keyup input':                                  'updateItem',
            'keyup textarea':                               'updateItem',
            'change input':                                 'updateItem',
            'change textarea':                              'updateItem',
            'blur textarea':                                'updateItem',
            'change select':                                'updateItem',

            'click .actions a.modula-gallery-meta-submit':       'saveItem',
            'click .actions a.modula-gallery-meta-submit-close': 'saveItemAndClose',

            'keyup input#link-search':                      'searchLinks',
            'click div.query-results li':                   'insertLink',

            'click #modula-ai-report-generate-button':      'generateReport',
            'click #modula-alt-button-apply':               'applyReport',
            'click #modula-caption-button-apply':           'applyReport',
            'click #modula-title-button-apply':             'applyReport',
        },

        /**
        * Initialize
        *
        * @param object model   ModulaImage Backbone Model
        */
        initialize: function( args ) {

            // Define loading and loaded events, which update the UI with what's happening.
            this.on( 'loading', this.loading, this );
            this.on( 'loaded',  this.loaded, this );

            // Change item when model updates his attribute
            this.listenTo( this.model, 'change:item', this.changeItem );

            // Child Views
            this.childViews = args.childViews;


            // Set some flags
            this.is_loading = false;
            this.search_timer = '';
            this.item = false;


            // Add event listeners for AI report generation
            this.on('ai:report:loading', this.onReportLoading, this);
            this.on('ai:report:success', this.onReportSuccess, this);
            this.on('ai:report:error', this.onReportError, this);
        },

        changeItem: function(){
            this.item = this.model.get( 'item' );
        },

        /**
        * Render
        * - Binds the model to the view, so we populate the view's fields and data
        */
        render: function() {

            // Get the current item from model if not exist.
            if ( ! this.item ) {
                this.item = this.model.get( 'item' );
            }

            this.checkApiStatus();

            // Get current Index.
            this.attachment_index = modula.Items.indexOf( this.item );

            // Get HTML
            if ( this.item ) {
                this.$el.html( this.template( this.item.toJSON() ) );

                // Check API status when modal opens

                // Generate Child Views
                if ( this.childViews.length > 0 ) {
                    this.childViews.forEach( function ( view ) {
                        // Init with model
                        var childView = new view( {
                            model: this.model
                        } );

                        // Render view within our main view
                        this.$el.find( 'div.modula-addons' ).append( childView.render().el );
                    }, this );
                }
            }

            // Enable / disable the buttons depending on the index
            if ( this.attachment_index == 0 ) {
                // Disable left button
                this.$el.find( 'button.left' ).addClass( 'disabled' );
            }
            if ( this.attachment_index == ( modula.Items.length - 1 ) ) {
                // Disable right button
                this.$el.find( 'button.right' ).addClass( 'disabled' );
            }
            // Hide / show the url input based on gallery settings.
            if ( modula.Settings.get('lightbox') != 'external-url' ) {
                this.$el.find( '.setting.modula-link' ).addClass('modula-hide');
            }else{
                this.$el.find( '.setting.modula-link' ).removeClass('modula-hide');
            }

            // Return
            return this;
        },

        /**
        * Renders an error using
        * wp.media.view.ModulaGalleryError
        */
        renderError: function( error ) {

            // Define model
            var model = {};
            model.error = error;

            // Define view
            var view = new wp.media.view.ModulaGalleryError( {
                model: model
            } );

            // Return rendered view
            return view.render().el;

        },

        /**
        * Tells the view we're loading by displaying a spinner
        */
        loading: function() {

            // Set a flag so we know we're loading data
            this.is_loading = true;

            // Show the spinner
            this.$el.find( '.spinner' ).css( 'visibility', 'visible' );

        },

        /**
        * Hides the loading spinner
        */
        loaded: function( response ) {

            // Set a flag so we know we're not loading anything now
            this.is_loading = false;

            // Hide the spinner
            this.$el.find( '.spinner' ).css( 'visibility', 'hidden' );

            // Display the error message, if it's provided
            if ( typeof response !== 'undefined' ) {
                this.$el.find( 'div.media-toolbar' ).after( this.renderError( response ) );
            }

        },

        /**
        * Load the previous model in the collection
        */
        loadPreviousItem: function() {
            var item;

            // Decrement the index
            this.attachment_index--;

            // Get the model at the new index from the collection
            item = modula.Items.at( this.attachment_index );
            this.model.set( 'item', item );

            // Re-render the view
            this.render();
        },

        /**
        * Load the next model in the collection
        */
        loadNextItem: function() {
            var item;

            // Increment the index
            this.attachment_index++;

            // Get the model at the new index from the collection
            item = modula.Items.at( this.attachment_index );
            this.model.set( 'item', item );
            
            // Re-render the view
            this.render();
        },

        /**
        * Updates the model based on the changed view data
        */
        updateItem: function( event ) {

            // Check if the target has a name. If not, it's not a model value we want to store
            if ( event.target.name == '' ) {
                return;
            }

            // Update the model's value, depending on the input type
            if ( event.target.type == 'checkbox' ) {
                value = ( event.target.checked ? event.target.value : 0 );
            } else {
                value = event.target.value;
            }

            // Update the model
            this.item.set( event.target.name, value );

        },

        /**
        * Saves the image metadata
        */
        saveItem: function( event ) {
            var view,
                self = this,
                item = this.model.get( 'item' );

            event.preventDefault();

            // Tell the View we're loading
            this.trigger( 'loading' );

            // Get item view and render it.
            view = this.item.get( 'view' );
            view.render();

            // Show the user the 'saved' notice for 1.5 seconds
            var saved = this.$el.find( '.saved' );
            saved.fadeIn();

            wp.Modula.Save.saveImages( function(){
                // Tell the view we've finished successfully
                self.trigger( 'loaded loaded:success' );
                saved.fadeOut();
            });

        },

        saveItemAndClose: function ( event ){
            var view,
                self = this;

            event.preventDefault();

            // Tell the View we're loading
            this.trigger( 'loading' );

            clearInterval( wp.Modula.Save.updateInterval );
            wp.Modula.Save.saveImages( function(){
                // Get item view and render it.
                view = self.model.get( 'wpMediaView' );
                view.close();
            });

        },

        /**
        * Searches Links
        */
        searchLinks: function( event ) {
        },

        /**
        * Inserts the clicked link into the URL field
        */
        insertLink: function( event ) {
        },

        /**
        * Generates the alt text for the image
        */
        generateReport: async function( event ) {
            event.preventDefault();

            // If API is not configured, redirect to settings
            if (!this.isApiConfigured) {
                window.location.href = modulaHelper.settings_url;
                return;
            }

            var action = event.target.dataset.action || 'generate';
            if ('undefined' === typeof wp.apiFetch) {
                return;
            }

            // Trigger loading event
            this.trigger('ai:report:loading');

            try {
                var result = await wp.apiFetch({
                    path: '/modula-ai-image-descriptor/v1/generate-alt-text/',
                    method: 'POST',
                    data: {
                        id: 'single',
                        attachment_id: this.item.get('id'),
                        action: action
                    }
                });

                // Trigger success event with the result
                this.trigger('ai:report:success', result);
            } catch (error) {
                // Trigger error event if the request fails
                this.trigger('ai:report:error', error);
            }
        },

        // Add these new methods after initialize
        onReportLoading: function() {
            // Add loading state to the button
            var $button = this.$el.find('#modula-ai-report-generate-button');
            $button.addClass('loading').prop('disabled', true);
            $button.text(modulaHelper.strings.generating_alt_text);

            this.item.set('report', {});
        },

        onReportSuccess: function(result) {
            var $button = this.$el.find('#modula-ai-report-generate-button');
            $button.removeClass('loading').prop('disabled', false);
            $button.text(modulaHelper.strings.alt_text_generated);

            setTimeout(() => {
                $button.text(modulaHelper.strings.refresh_report);
            }, 2500)

            // Update the report
            this.item.set('report', result);

            // Update the alt text
            this.item.set('alt', result.altText);
            this.$el.find('input[name="alt"]').val(result.altText);

            // Update the caption
            this.item.set('description', result.caption);
            this.$el.find('textarea[name="description"]').val(result.caption);

            // Update the title
            this.item.set('title', result.title);
            this.$el.find('input[name="title"]').val(result.title);

            
        },

        onReportError: function(error) {
            var $button = this.$el.find('#modula-ai-report-generate-button');
            $button.removeClass('loading').prop('disabled', false);

            // Handle error state
            console.error('AI Report generation failed:', error);

            // Update the report
            this.item.set('report', {});
        },

        checkApiStatus: async function() {
            const self = this;
            try {
                const response = await wp.apiFetch({
                    path: '/modula-ai-image-descriptor/v1/ai-settings',
                    method: 'GET'
                });
        
                const $button = this.$el.find('#modula-ai-report-generate-button');
                const isKeyValid = response?.readonly?.valid_key ?? false;
                
                if (!isKeyValid) {
                    $button.text(modulaHelper.strings.configure_api_key || 'Configure API Key');
                    $button.addClass('configure-api');
                    self.isApiConfigured = false;
                } else {
                    self.isApiConfigured = true;
                    $button.removeClass('configure-api');
                }
            } catch (error) {
                console.error('API check failed:', error);
                const $button = self.$el.find('#modula-ai-report-generate-button');
                $button.text(modulaHelper.strings.configure_api_key || 'Configure API Key');
                $button.addClass('configure-api');
                self.isApiConfigured = false;
            }
        }
    } );


    modula.modal = {
        'model' : modulaModal,
        'view' : modulaModalView
    };

}( jQuery, wp.Modula ))
