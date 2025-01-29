
function ModulaMakeItem( model ) {
	const defaults = {
		'id':          '',
		'title':       '',
		'description': '',
		'alt':         '',
		'link':        '',
		'halign':      'center',
		'valign':      'middle',
		'target':      '',
		'togglelightbox':      '',
		'hide_title':  '',
		'src':         '',
		'type':        'image',
		'width':       2,
		'height':      2,
		'full' :       '',
		'thumbnail':   '',
		'resize':      false,
		'index':       '',
		'orientation': 'landscape'
	};
	new_item = defaults;
	
	new_item.id = model.attributes.id;
	new_item.title = model.attributes.name;
	new_item.description = model.attributes.caption;
	new_item.alt = model.attributes.alt;
	new_item.width = model.attributes.width;
	new_item.width = model.attributes.height;
	new_item.type = model.attributes.type;

	return new_item;
};

jQuery(document).ready(function($) {
	var bulkActionTop = $('#bulk-action-selector-top'),
		bulkActionBottom = $('#bulk-action-selector-bottom'),
		tpl = wp.template( 'modula-gallery-selector');
	if( 'undefined' != typeof modulaGalleries.posts && 0 != modulaGalleries.posts.length ){
		if( 'undefined' != typeof bulkActionTop[0] ){
			modulaGalleries.pos = 'top';
			bulkActionTop.after( tpl( modulaGalleries ) );
		}
	
		if( 'undefined' != typeof bulkActionBottom[0] ){
			modulaGalleries.pos = 'bottom';
			bulkActionBottom.after( tpl( modulaGalleries ) );
		}
	}

	$(document).on('change', '#bulk-action-selector-top, #bulk-action-selector-bottom', function(){
		if( $(this).val() == 'modula_add_to_gallery' ){
			$('#modula_gallery_select_top, #modula_gallery_select_bottom').show();
		}else{
			$('#modula_gallery_select_top, #modula_gallery_select_bottom').hide();
		}
	} );

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
			this.$el.html( this.template( modulaGalleries.posts ) );
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
			if( 'undefined' == typeof modulaGalleries.posts || 0 == modulaGalleries.posts.length ){
				return;
			}
			var toolbar = this.toolbar,
				filters = this.toolbar.get('filters');

			toolbar.set( 'modulaGallerySelector', new ModulaGallerySelector({
				filters: filters,
				style: 'primary',
				controller: this.controller,
				priority: -181
			}).render() );

			toolbar.set('addToGalleryBtn', new wp.media.view.addToGalleryBtn({
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
							selected.push( ModulaMakeItem(model) );
						}
					} );
					
                    if ( selected.length ) {
                        var galleryId = $('#modula_gallery_select').val();
                        var nonce = modulaGalleries.nonce; 

                        $.ajax({
                            url: modulaGalleries.ajax_url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'add_images_to_gallery',
                                selected: JSON.stringify( selected ), 
                                gallery_id: galleryId,
                                nonce: nonce
                            },
                            success: function(response) {
                                if(response.success) {
                                    library._requery( true );
									window.modulaEventBus.emit('modula:media:insert:done');
									$(document).trigger( 'modula:media:insert:done', response.data );
                                    this.controller.trigger( 'selection:action:done' );
                                } else {
                                    alert( modulaGalleries.l10n.ajax_failed + response.data );
                                }
                            }.bind(this),
                            error: function(xhr, status, error) {
                                alert( modulaGalleries.l10n.ajax_failed + error );
                            }
                        });
                    } else {
                        this.controller.trigger( 'selection:action:done' );
                    }
				}
			}).render() );
		}
	});
});