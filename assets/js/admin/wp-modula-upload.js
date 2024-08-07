wp.Modula = 'undefined' === typeof wp.Modula ? {} : wp.Modula;

(function ($, modula) {
	var ModulaToolbar = wp.media.view.Toolbar.Select.extend({
		clickSelect: function () {
			var controller = this.controller,
				state = controller.state(),
				selection = state.get('selection');

			controller.close();
			state.trigger('insert', selection).reset();
		},
	});

	var ModulaAttachmentsBrowser = wp.media.view.AttachmentsBrowser.extend({
		createToolbar: function () {
			var LibraryViewSwitcher, Filters, toolbarOptions;

			wp.media.view.AttachmentsBrowser.prototype.createToolbar.call(this);

			this.toolbar.set(
				'modula-error',
				new modula.upload['errorview']({
					controller: this.controller,
					priority: -80,
				})
			);
		},
	});

	var ModulaFrame = wp.media.view.MediaFrame.Select.extend({
		className: 'media-frame modula-media-modal',

		createStates: function () {
			var options = this.options;
			options.library.type = 'image';
			if (this.options.states) {
				return;
			}

			// Add the default states.
			this.states.add([
				// Main states.
				new modula.upload['library']({
					library: wp.media.query(options.library),
					multiple: options.multiple,
					title: options.title,
					priority: 20,
				}),
			]);
		},

		createSelectToolbar: function (toolbar, options) {
			options = options || this.options.button || {};
			options.controller = this;

			toolbar.view = new modula.upload['toolbar'](options);
		},

		browseContent: function (contentRegion) {
			var state = this.state();

			// this.$el.removeClass('hide-toolbar');

			// Browse our library of attachments.
			contentRegion.view = new modula.upload['attachmentsbrowser']({
				// contentRegion.view = new wp.media.view.AttachmentsBrowser({
				controller: this,
				collection: state.get('library'),
				selection: state.get('selection'),
				model: state,
				sortable: state.get('sortable'),
				search: state.get('searchable'),
				filters: state.get('filterable'),
				date: state.get('date'),
				display: state.has('display')
					? state.get('display')
					: state.get('displaySettings'),
				dragInfo: state.get('dragInfo'),

				idealColumnWidth: state.get('idealColumnWidth'),
				suggestedWidth: state.get('suggestedWidth'),
				suggestedHeight: state.get('suggestedHeight'),

				AttachmentView: state.get('AttachmentView'),
			});
		},
	});

	var ModulaSelection = wp.media.model.Selection.extend({
		add: function (models, options) {
			var needed, differences;

			if (!this.multiple) {
				this.remove(this.models);
			}

			if (this.length >= 20) {
				models = [];
				wp.media.frames.modula.trigger('modula:show-error', {
					message: modulaHelper.strings.limitExceeded,
				});
			} else {
				needed = 20 - this.length;

				if (Array.isArray(models) && models.length > 1) {
					// Create an array with elements that we don't have in our selection
					differences = _.difference(
						_.pluck(models, 'cid'),
						_.pluck(this.models, 'cid')
					);
					// Check if we have mode elements that we need
					if (differences.length > needed) {
						// Filter our models, to have only that we don't have already
						models = _.filter(models, function (model) {
							return _.contains(differences, model.cid);
						});
						// Get only how many we need.
						models = models.slice(0, needed);
						wp.media.frames.modula.trigger('modula:show-error', {
							message: modulaHelper.strings.limitExceeded,
						});
					}
				}
			}

			/**
			 * call 'add' directly on the parent class
			 */
			return wp.media.model.Attachments.prototype.add.call(
				this,
				models,
				options
			);
		},
		single: function (model) {
			var previous = this._single;

			// If a `model` is provided, use it as the single model.
			if (model) {
				this._single = model;
			}
			// If the single model isn't in the selection, remove it.
			if (this._single && !this.get(this._single.cid)) {
				delete this._single;
			}

			this._single = this._single || this.last();

			// If single has changed, fire an event.
			if (this._single !== previous) {
				if (previous) {
					previous.trigger('selection:unsingle', previous, this);

					// If the model was already removed, trigger the collection
					// event manually.
					if (!this.get(previous.cid)) {
						this.trigger('selection:unsingle', previous, this);
					}
				}
				if (this._single) {
					this._single.trigger(
						'selection:single',
						this._single,
						this
					);
				}
			}

			if (this.length < 20) {
				wp.media.frames.modula.trigger('modula:hide-error', {
					message: modulaHelper.strings.limitExceeded,
				});
			}

			// Return the single model, or the last model as a fallback.
			return this._single;
		},
	});

	var ModulaLibrary = wp.media.controller.Library.extend({
		initialize: function () {
			var selection = this.get('selection'),
				props;

			if (!this.get('library')) {
				this.set('library', wp.media.query());
			}

			if (!selection) {
				props = selection;

				if (!props) {
					props = this.get('library').props.toJSON();
					props = _.omit(props, 'orderby', 'query');
				}

				this.set(
					'selection',
					new wp.media.model.Selection(null, {
						multiple: this.get('multiple'),
						props: props,
					})
				);
			}

			this.resetDisplays();
		},
	});

	var ModulaError = wp.media.View.extend({
		tagName: 'div',
		className: 'modula-error-container hide',
		errorTimeout: false,
		delay: 400,
		message: '',

		initialize: function () {
			this.controller.on('modula:show-error', this.show, this);
			this.controller.on('modula:hide-error', this.hide, this);

			this.render();
		},

		show: function (e) {
			if ('undefined' !== typeof e.message) {
				this.message = e.message;
			}

			if ('' != this.message) {
				this.render();
				this.$el.removeClass('hide');
			}
		},

		hide: function () {
			this.$el.addClass('hide');
		},

		render: function () {
			var html =
				'<div class="modula-error"><span>' +
				this.message +
				'</span></div>';
			this.$el.html(html);
		},
	});

	var uploadHandler = Backbone.Model.extend({
		uploaderOptions: {
			container: $('#modula-uploader-container'),
			browser: $('#modula-uploader-browser'),
			dropzone: $('#modula-uploader-container'),
		},
		dropzone: $('#modula-dropzone-container'),
		progressBar: $('.modula-progress-bar'),
		containerUploader: $('.modula-upload-actions'),
		errorContainer: $('.modula-error-container'),
		galleryCotainer: $(
			'#modula-uploader-container .modula-uploader-inline-content'
		),
		modula_files_count: 0,
		limitExceeded: false,

		initialize: function () {
			var modulaGalleryObject = this,
				uploader,
				dropzone,
				attachments,
				limitExceeded = false,
				modula_files_count = 0;

			uploader = new wp.Uploader(modulaGalleryObject.uploaderOptions);

			// Uploader events
			// Files Added for Uploading - show progress bar
			uploader.uploader.bind(
				'FilesAdded',
				$.proxy(modulaGalleryObject.filesadded, modulaGalleryObject)
			);

			// File Uploading - update progress bar
			uploader.uploader.bind(
				'UploadProgress',
				$.proxy(modulaGalleryObject.fileuploading, modulaGalleryObject)
			);

			// File Uploaded - add images to the screen
			uploader.uploader.bind(
				'FileUploaded',
				$.proxy(modulaGalleryObject.fileupload, modulaGalleryObject)
			);

			// Files Uploaded - hide progress bar
			uploader.uploader.bind(
				'UploadComplete',
				$.proxy(modulaGalleryObject.filesuploaded, modulaGalleryObject)
			);

			// File Upload Error - show errors
			uploader.uploader.bind('Error', function (up, err) {
				// Show message
				modulaGalleryObject.errorContainer.html(
					'<div class="error fade"><p>' +
						err.file.name +
						': ' +
						err.message +
						'</p></div>'
				);
				up.refresh();
			});

			// Dropzone events
			dropzone = uploader.dropzone;
			dropzone.on('dropzone:enter', modulaGalleryObject.show);
			dropzone.on('dropzone:leave', modulaGalleryObject.hide);

			// Single Image Actions ( Delete/Edit )
			modulaGalleryObject.galleryCotainer.on(
				'click',
				'.modula-delete-image',
				function (e) {
					e.preventDefault();
					$(this).parents('.modula-single-image').remove();
				}
			);

			// Modula WordPress Media Library
			wp.media.frames.modula = new modula.upload['frame']({
				frame: 'select',
				reset: false,
				title: wp.media.view.l10n.addToGalleryTitle,
				button: {
					text: wp.media.view.l10n.addToGallery,
				},
				multiple: 'add',
			});

			// Mark existing Gallery images as selected when the modal is opened
			wp.media.frames.modula.on('open', function () {
				// Get any previously selected images
				var selection = wp.media.frames.modula.state().get('selection');
				selection.reset();

				// Get images that already exist in the gallery, and select each one in the modal
				wp.Modula.Items.each(function (item) {
					var image = wp.media.attachment(item.get('id'));
					selection.add(image ? [image] : []);
				});

				selection.single(selection.last());
			});

			wp.media.frames.modula.on('close', function () {
				wp.media.frames.modula.trigger('modula:hide-error', {
					message: modulaHelper.strings.limitExceeded,
				});
			});

			// Insert into Gallery Button Clicked
			wp.media.frames.modula.on('insert', function (selection) {
				// Get state
				var state = wp.media.frames.modula.state();
				var oldItemsCollection = wp.Modula.Items;

				modula.Items = new modula.items['collection']();

				// Iterate through selected images, building an images array
				selection.each(function (attachment) {
					var attachmentAtts = attachment.toJSON(),
						currentModel = oldItemsCollection.get(
							attachmentAtts['id']
						);

					if (currentModel) {
						wp.Modula.Items.addItem(currentModel);
						oldItemsCollection.remove(currentModel);
					} else {
						modulaGalleryObject.generateSingleImage(attachmentAtts);
					}
				}, this);

				while ((model = oldItemsCollection.first())) {
					model.delete();
				}
			});

			// Open WordPress Media Gallery
			$('#modula-wp-gallery').click(function (e) {
				e.preventDefault();
				// set wp-settings-1 cookie to browse and not upload
				setUserSetting('libraryContent', 'browse');
				// check if modal exists ( already introduced in page )
				var media_modal = $('body .media-modal');
				if (media_modal.length > 0) {
					// click on item browse so we can activate it and look at item browsing
					media_modal.find('#menu-item-browse').click();
				}
				wp.media.frames.modula.open();
			});
			
			// Open WordPress Media Gallery
			$('#modula_gallery_add_action_button').click(function (e) {
				e.preventDefault();
				if( $('#modula_gallery_add_action').hasClass( 'open') ){
					$('#modula_gallery_add_action').hide().removeClass('open');
				}else{
					$('#modula_gallery_add_action').show().addClass('open');
				}
			});
			$('#modula_gallery_add_action li').click(function (e) {
				$('#modula_gallery_add_action').hide().removeClass('open');
			});
		},

		// Uploader Events
		// Files Added for Uploading - show progress bar
		filesadded: function (up, files) {
			var modulaGalleryObject = this;

			// Hide any existing errors
			modulaGalleryObject.errorContainer.html('');

			// Get the number of files to be uploaded
			modulaGalleryObject.modula_files_count = files.length;

			// Set the status text, to tell the user what's happening
			$(
				'.modula-upload-numbers .modula-current',
				modulaGalleryObject.containerUploader
			).text('1');
			$(
				'.modula-upload-numbers .modula-total',
				modulaGalleryObject.containerUploader
			).text(modulaGalleryObject.modula_files_count);

			// Show progress bar
			modulaGalleryObject.containerUploader.addClass('show-progress');
		},

		// File Uploading - update progress bar
		fileuploading: function (up, file) {
			var modulaGalleryObject = this;

			// Update the status text
			$(
				'.modula-upload-numbers .modula-current',
				modulaGalleryObject.containerUploader
			).text(
				modulaGalleryObject.modula_files_count - up.total.queued + 1
			);

			// Update the progress bar
			$(
				'.modula-progress-bar-inner',
				modulaGalleryObject.progressBar
			).css({ width: up.total.percent + '%' });
		},

		// File Uploaded - add images to the screen
		fileupload: function (up, file, info) {
			var modulaGalleryObject = this;
			var response = JSON.parse(info.response);
			modulaGalleryObject.generateSingleImage(response['data']);
		},

		// Files Uploaded - hide progress bar
		filesuploaded: function () {
			var modulaGalleryObject = this;

			setTimeout(function () {
				modulaGalleryObject.containerUploader.removeClass(
					'show-progress'
				);
			}, 1000);
		},

		show: function () {
			var $el = $('#modula-dropzone-container').show();

			// Ensure that the animation is triggered by waiting until
			// the transparent element is painted into the DOM.
			_.defer(function () {
				$el.css({ opacity: 1 });
			});
		},

		hide: function () {
			var $el = $('#modula-dropzone-container').css({ opacity: 0 });

			wp.media.transition($el).done(function () {
				// Transition end events are subject to race conditions.
				// Make sure that the value is set as intended.
				if ('0' === $el.css('opacity')) {
					$el.hide();
				}
			});

			// https://core.trac.wordpress.org/ticket/27341
			_.delay(function () {
				if ('0' === $el.css('opacity') && $el.is(':visible')) {
					$el.hide();
				}
			}, 500);
		},

		generateSingleImage: function (attachment) {
			var data = {
				halign: 'center',
				valign: 'middle',
				link: '',
				target: '',
				togglelightbox: '',
				hideTitle: '',
			};

			if ('undefined' !== typeof attachment['sizes']) {
				data['full'] = attachment['sizes']['full']['url'];
				if ('undefined' != typeof attachment['sizes']['large']) {
					data['thumbnail'] = attachment['sizes']['large']['url'];
				} else {
					data['thumbnail'] = data['full'];
				}
			} else {
				data['full'] = attachment['url'];
				data['thumbnail'] = data['full'];
			}

			data['id'] = attachment['id'];
			data['alt'] = attachment['alt'];
			data['orientation'] = attachment['orientation'];
			data['title'] = attachment['title'];
			data['description'] = attachment['caption'];

			new modula.items['model'](data);
		},
	});

	modula.upload = {
		toolbar: ModulaToolbar,
		attachmentsbrowser: ModulaAttachmentsBrowser,
		frame: ModulaFrame,
		selection: ModulaSelection,
		library: ModulaLibrary,
		errorview: ModulaError,
		uploadHandler: uploadHandler,
	};
})(jQuery, wp.Modula);
