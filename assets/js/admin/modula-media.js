jQuery(document).ready(function($) {

	var Button = wp.media.view.Button,
	AddToGalleryBtn;

	AddToGalleryBtn = Button.extend({
		initialize: function() {
			Button.prototype.initialize.apply( this, arguments );
			if ( this.options.filters ) {
				this.options.filters.model.on( 'change', this.filterChange, this );
			}
			this.controller.on( 'selection:toggle', this.toggleDisabled, this );
			this.controller.on( 'select:activate', this.toggleDisabled, this );
		},

		toggleDisabled: function() {
			this.model.set( 'disabled', ! this.controller.state().get( 'selection' ).length );
		},

		render: function() {
			Button.prototype.render.apply( this, arguments );
			if ( this.controller.isModeActive( 'select' ) ) {
				this.$el.addClass( 'delete-selected-button' );
			} else {
				this.$el.addClass( 'delete-selected-button hidden' );
			}
			this.toggleDisabled();

			return this;
		}
	});

	ModulaGallerySelector = wp.media.View.extend({
		className: 'view-switch wp-modula-gallery-selector',
		template: wp.template( 'modula-gallery-selector'),
		initialize: function() {
			this.controller.on( 'selection:toggle', this.toggleDisabled, this );
			this.controller.on( 'select:activate', this.toggleDisabled, this );
			this.controller.on( 'select:deactivate', this.toggleDisabled, this );
		},
		toggleDisabled: function() {

			if ( this.controller.isModeActive( 'select' ) ) {
				this.$el.show();
			} else {
				this.$el.hide();
			}

			if( 0 == this.controller.state().get( 'selection' ).length ){
				this.$el.find('select').prop("disabled", true);
			}else{
				this.$el.find('select').prop("disabled", false);
			}
			
		},
		render: function() {

			this.$el.html( this.template( modulaGalleries ) );
			if ( this.controller.isModeActive( 'select' ) ) {
				this.$el.addClass( 'view-switch wp-modula-gallery-selector' );

			} else {
				this.$el.addClass( 'view-switch wp-modula-gallery-selector hidden' );
			}
			this.toggleDisabled();

			return this;
		}
	});

	wp.media.view.modulaGallerySelector = ModulaGallerySelector;
	wp.media.view.addToGalleryBtn       = AddToGalleryBtn;

	var originalAttachmentsBrowser = wp.media.view.AttachmentsBrowser;

	wp.media.view.AttachmentsBrowser = originalAttachmentsBrowser.extend({
		createToolbar: function() {
			originalAttachmentsBrowser.prototype.createToolbar.apply(this, arguments);

			var toolbar = this.toolbar,
				filters = this.toolbar.get('filters');

			toolbar.set( 'modulaGallerySelector', new ModulaGallerySelector({
				filters: filters,
				style: 'primary',
				controller: this.controller,
				priority: -181
			}).render() );

			toolbar.set('addToGalleryBtn', new wp.media.view.addToGallery({
				filters: filters,
				style: 'primary',
				text: 'Add to Modula Gallery',
				controller: this.controller,
				priority: -180,
				click: function() {
					var selected = [],
						selection = this.controller.state().get( 'selection' ),
						library = this.controller.state().get( 'library' );

					if ( ! selection.length ) {
						return;
					}

					selection.each( function( model ) {
						if ( 'trash' !== model.get( 'status' ) ) {
							selected.push( model );
						}
					} );

					if ( selected.length ) {
						$.when.apply( null, selected ).then( _.bind( function() {
							library._requery( true );
							this.controller.trigger( 'selection:action:done' );
						}, this ) );
					} else {
						this.controller.trigger( 'selection:action:done' );
					}
				}
			}).render() );
		}
	});
});
