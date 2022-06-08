/*
 *  Project: jQuery Modula 2
 *  Version: 1.0
 *  Description: Artistic gallery
 *  Author: Macho Themes
 */
function tg_getURLParameter(name) {
	return (
		decodeURIComponent(
			(new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [ , '' ])[1]
				.replace(/\+/g, '%20')
		) || null
	);
}

// Compatibility with WPBakery Page Builder
jQuery(document).on('vc-full-width-row-single vc-full-width-row', function(event, element) {
	if (jQuery('body').find('.modula').length > 0) {
		jQuery(window).trigger('modula-update');
	}
});

// Compatibility with Elementor
jQuery(window).on('elementor/frontend/init', function () {
	if ( window.elementorFrontend ) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
			if ( jQuery('body').find('.modula').length > 0 ) {
				//jQuery(window).trigger('modula-update');

			}
		});
	}
});

(function($, window, document, undefined) {
	// Create the defaults once
	var pluginName = 'modulaGallery',
		defaults = {
			resizer: '/',
			keepArea: true,
			type: 'creative-gallery',
			columns: 12,
			height: 800,
			desktopHeight: 800,
			mobileHeight: 800,
			tabletHeight: 800,
			gutter: 10,
			desktopGutter: 10,
			mobileGutter: 10,
			tabletGutter: 10,
			enableTwitter: false,
			enableFacebook: false,
			enableWhatsapp: false,
			enablePinterest: false,
			enableLinkedin: false,
			enableEmail: false,
			lazyLoad: 0,
			initLightbox: false,
			lightbox: 'fancybox',
			lightboxOpts: {},
			inView: false
		};

	// The actual plugin constructor
	function Plugin(element, options) {
		this.element = element;
		this.$element = $(element);
		this.$itemsCnt = this.$element.find('.modula-items');
		this.$items = this.$itemsCnt.find('.modula-item');

		this.options = $.extend({}, defaults, options);

		this._defaults = defaults;
		this._name = pluginName;

		this.tiles = [];
		this.$tilesCnt = null;
		this.completed = false;
		this.lastWidth = 0;
		this.resizeTO = 0;
		this.isIsotope = false;
		this.isLazyLoaded = true;

		// Initiate Gallery
		this.init();
	}

	Plugin.prototype.init = function() {
		var instance = this,
			viewport = document.documentElement.clientWidth;

		if (viewport <= 568) {
			this.options.gutter = this.options.mobileGutter;
		} else if (viewport <= 768) {
			this.options.gutter = this.options.tabletGutter;
		} else {
			this.options.gutter = this.options.desktopGutter;
		}

		// Trigger event before init
		$(document).trigger('modula_api_before_init', [ instance ]);

		if ('custom-grid' === this.options.type) {
			this.createCustomGallery();
		} else if ('creative-gallery' == this.options.type) {
			this.createGrid();
		} else if ('grid' == this.options.type) {
			if ('automatic' == this.options.grid_type) {
				this.createAutoGrid();
			} else {
				this.createColumnsGrid();
			}
		}

		// Fix for custom grid elements not organizing correctly on some themes
		// where at first the scrollbar is missing
		if ('custom-grid' === this.options.type && $(window).height() < $('html').height()) {
			instance.onResize(instance);
		}

		$(window).resize(function() {
			instance.onResize(instance);
		});

		const resizeObserver = new ResizeObserver(entries => {

			instance.onResize(instance);
		});
		resizeObserver.observe(instance.$element[0]);

		$(window).on('modula-update', function() {
			instance.onResize(instance);
		});

		$(document).on('lazyloaded', function(evt) {
			var element = $(evt.target),
				parent,
				index;

			if ('modula' == element.data('source')) {
				element.data('size', { width: element.width(), height: element.height() });
				parent = element.parents('.modula-item');
				parent.addClass('tg-loaded');
				index = instance.$items.not('.jtg-hidden').index(parent);
				instance.placeImage(index);

				if (instance.isIsotope) {
					instance.$itemsCnt.modulaisotope('layout');
				}

				if ( 'grid' == instance.options.type ) {
					if ( 'automatic' == instance.options.grid_type ) {
						instance.$itemsCnt.justifiedGallery();
					}
				}

			}
		});

		if (instance.options.inView) {
			jQuery(window).on('DOMContentLoaded load resize scroll', function() {
				if (modulaInViewport(instance.$element)) {
					instance.$element.addClass('modula-loaded-scale');
				}
			});
		}

		// Gives error on front
		/* new ResizeSensor( instance.$element, function() {
		 instance.onResize(instance);
		 });*/

		// Create social links
		this.setupSocial();

		// Add init class
		jQuery(instance.$element).addClass('modula-gallery-initialized');
		// Trigger custom gallery JS
		if (this.options.onComplete) {
			this.options.onComplete();
		}

		// Init lightox
		if ('fancybox' == instance.options['lightbox'] && !instance.options['initLightbox']) {
			this.initLightbox();
		}

		// Trigger event after init
		$(document).trigger('modula_api_after_init', [ instance ]);
	};

	Plugin.prototype.initLightbox = function() {
		var self = this;

		self.$element.on('click', '.modula-no-follow', function(evt) {
			evt.preventDefault();
		});

		self.$element.on('click', '.modula-item-link:not( .modula-simple-link )', function(evt) {
			evt.preventDefault();
			var clickedLink = jQuery(this);
			var links = $.map(self.$items, function(o) {
				if( jQuery(o).find('.modula-item-link:not( .modula-no-follow )').length > 0 ){
					var link = jQuery(o).find('.modula-item-link:not( .modula-simple-link )'),
						image = jQuery(o).find('.pic');
					return {
						src: link.attr('href'),
						opts: {
							$thumb: image.parents('.modula-item'),
							caption: link.data('caption'),
							alt: image.attr('alt'),
							image_id: link.attr('data-image-id')
						},
						current: jQuery(o).is(clickedLink.parents('.modula-item')) ,
					};	
					
				}
				}),
				index = $.map(links,function(element,myIndex){
					if( element.current ){
						return myIndex;
					}
				})[0];

			jQuery.modulaFancybox.open(links, self.options.lightboxOpts, index);
		});
	};

	Plugin.prototype.trunc = function(v) {
		if (Math.trunc) {
			return Math.trunc(v);
		} else {
			v = +v;
			if (!isFinite(v)) return v;

			return v - v % 1 || (v < 0 ? -0 : v === 0 ? v : 0);
		}
	};

	// Create custom grid gallery based on packery.
	Plugin.prototype.createCustomGallery = function() {
		var instance = this,
			size,
			containerWidth = this.$element.find('.modula-items').width(),
			plugin = this,
			columns = this.options.columns,
			viewport = document.documentElement.clientWidth;

		if ('1' == this.options.enableResponsive) {
			if (viewport <= 568) {
				columns = this.options.mobileColumns;
			} else if (viewport <= 768) {
				columns = this.options.tabletColumns;
			}
		}

		if (this.options.gutter > 0) {
			size = (containerWidth - this.options.gutter * (columns - 1)) / columns;
		} else {
			size = Math.floor(containerWidth / columns * 1000) / 1000;
		}

		this.$items.not('.jtg-hidden').each(function(i, item) {
			var slot = {},
				widthColumns,
				heightColumns,
				auxWidth,
				auxHeight;

			widthColumns = $(item).data('width');
			heightColumns = $(item).data('height');

			if (widthColumns > 12) {
				widthColumns = 12;
			}

			if ('1' == plugin.options.enableResponsive) {
				auxWidth = widthColumns;
				auxHeight = heightColumns;

				if (1 == columns) {
					widthColumns = 1;
					heightColumns = widthColumns * auxHeight / auxWidth;
				} else {
					widthColumns = Math.round(columns * auxWidth / 12);
					if (widthColumns < 1) {
						widthColumns = 1;
					}

					heightColumns = Math.round(widthColumns * auxHeight / auxWidth);
					if (heightColumns < 1) {
						heightColumns = 1;
					}
				}
			}

			slot.width = size * widthColumns + plugin.options.gutter * (widthColumns - 1);
			slot.height = Math.round(size) * heightColumns + plugin.options.gutter * (heightColumns - 1);

			$(item)
				.data('size', slot)
				.addClass('tiled')
				.addClass(slot.width > slot.height ? 'tile-h' : 'tile-v')
				.data('position');

			$(item).css($(item).data('size'));
			$(item).find('.figc').css({
				width: $(item).data('size').width,
				height: $(item).data('size').height
			});

			// Load Images
			instance.loadImage(i);
		});

		var packery_args = {
			itemSelector: '.modula-item',
			layoutMode: 'packery',
			packery: {
				gutter: parseInt(plugin.options.gutter)
			}
		};

		this.$itemsCnt.modulaisotope(packery_args);
		this.isIsotope = true;
	};

	// Create Modula default gallery grid
	Plugin.prototype.createGrid = function() {
		var instance = this;

		// if ( this.options.width ) {
		// 	this.$itemsCnt.width(this.options.width);
		// }

		// if ( this.options.height ) {
		// 	this.$itemsCnt.height(this.options.height);
		// }
		var viewport = document.documentElement.clientWidth;

		if (viewport <= 568) {
			instance.options.height = instance.options.mobileHeight;
		} else if (viewport <= 768) {
			instance.options.height = instance.options.tabletHeight;
		} else {
			instance.options.height = instance.options.desktopHeight;
		}

		this.$itemsCnt.data('area', this.$itemsCnt.width() * this.options.height);

		this.lastWidth = this.$itemsCnt.width();

		for (var i = 0; i < this.$items.not('.jtg-hidden').length; i++) {
			this.tiles.push(instance.getSlot());
		}

		this.tiles.sort(function(x, y) {
			return x.position - y.position;
		});

		this.$items.not('.jtg-hidden').each(function(i, item) {
			var slot = instance.tiles[i];

			$(item).data('size', slot);

			$(item).addClass('tiled').addClass(slot.width > slot.height ? 'tile-h' : 'tile-v').data('position');

			$(item).css({
				width: slot.width,
				height: slot.height
			});

			$(item).find('.figc').css({
				width: slot.width,
				height: slot.height
			});

			instance.loadImage(i);
		});

		if (!this.isIsotope) {
			var packery_args = {
				resizesContainer: false,
				itemSelector: '.modula-item',
				layoutMode: 'packery',
				packery: {
					gutter: parseInt(instance.options.gutter)
				}
			};

			this.$itemsCnt.modulaisotope(packery_args);
			this.isIsotope = true;
		}
	};

	Plugin.prototype.createAutoGrid = function() {
		var plugin = this;

		this.$itemsCnt.justifiedGallery({
			rowHeight: this.options.rowHeight,
			margins: this.options.gutter,
			lastRow: this.options.lastRow,
			captions: false,
			border: 0,
			imgSelector: '.pic',
			cssAnimation: true,
			imagesAnimationDuration: 700
		});
	};

	Plugin.prototype.createColumnsGrid = function() {
		var instance = this;

		this.$itemsCnt.modulaisotope({
			// set itemSelector so .grid-sizer is not used in layout
			itemSelector: '.modula-item',
			// percentPosition: true,
			layoutMode: 'packery',
			packery: {
				// use element for option
				gutter: parseInt(this.options.gutter)
			}
		});

		// Load Images
		this.$items.each(function(index, el) {
			instance.loadImage(index);
		});

		this.isIsotope = true;
	}

	Plugin.prototype.getSlot = function () {
		if ( this.tiles.length == 0 ) {

			var tile = {
				top: 0,
				left: 0,
				width: this.$itemsCnt.width(),
				height: this.options.height,
				area: this.$itemsCnt.width() * this.options.height,
				position: 0
			};

			return tile;
		}

		var maxTileIdx = 0;
		for (var i = 0; i < this.tiles.length; i++) {
			var tile = this.tiles[i];
			if (tile.area > this.tiles[maxTileIdx].area) {
				maxTileIdx = i;
			}
		}

		var tile = {};

		var maxTileData = this.tiles[maxTileIdx];

		if (maxTileData.width > maxTileData.height) {
			var randomMaxDelta = maxTileData.width / 2 * this.options.randomFactor;

			maxTileData.prevWidth = maxTileData.width;
			maxTileData.width = Math.floor(maxTileData.width / 2 + randomMaxDelta * (Math.random() - 0.5));

			tile = {
				top: maxTileData.top,
				left: maxTileData.left + maxTileData.width + this.options.gutter,
				width: maxTileData.prevWidth - maxTileData.width - this.options.gutter,
				height: maxTileData.height
			};
		} else {
			var randomMaxDelta = maxTileData.height / 2 * this.options.randomFactor;

			maxTileData.prevHeight = maxTileData.height;
			maxTileData.height = Math.floor(maxTileData.height / 2 + randomMaxDelta * (Math.random() - 0.5));

			tile = {
				left: maxTileData.left,
				top: maxTileData.top + maxTileData.height + this.options.gutter,
				width: maxTileData.width,
				height: maxTileData.prevHeight - maxTileData.height - this.options.gutter
			};
		}

		tile.area = tile.width * tile.height;
		tile.position = tile.top * 1000 + tile.left;

		maxTileData.position = maxTileData.top * 1000 + maxTileData.left;

		this.tiles[maxTileIdx] = maxTileData;
		this.tiles[maxTileIdx].area = maxTileData.width * maxTileData.height;

		return tile;
	};

	Plugin.prototype.reset = function() {
		var instance = this;
		instance.tiles = [];

		if ('custom-grid' === this.options.type) {
			this.createCustomGallery();
		} else if ('creative-gallery' == this.options.type) {
			this.createGrid();
		} else if ('grid' == this.options.type) {
			if ('automatic' == this.options.grid_type) {
				this.createAutoGrid();
			} else {
				this.createColumnsGrid();
			}
		}

		instance.lastWidth = instance.$itemsCnt.width();

		// Trigger event after init
		$(document).trigger('modula_api_reset', [ instance ]);
	};

	Plugin.prototype.onResize = function(instance) {
		if (instance.lastWidth == instance.$itemsCnt.width()) return;

		var viewport = document.documentElement.clientWidth;

		if (viewport <= 568) {
			instance.options.gutter = instance.options.mobileGutter;
		} else if (viewport <= 768) {
			instance.options.gutter = instance.options.tabletGutter;
		} else {
			instance.options.gutter = this.options.desktopGutter;
		}

		clearTimeout(instance.resizeTO);
		instance.resizeTO = setTimeout(function() {
			if (instance.options.keepArea) {
				var area = instance.$itemsCnt.data('area');
				instance.$itemsCnt.height(area / instance.$itemsCnt.width());
			}

			instance.reset();

			if (instance.isIsotope) {
				instance.$itemsCnt
					.modulaisotope({
						packery: {
							gutter: parseInt(instance.options.gutter)
						}
					})
					.modulaisotope('layout');
			}
		}, 100);
	};

	Plugin.prototype.loadImage = function(index) {

		var instance = this,
			source = instance.$items.not('.jtg-hidden').eq(index).find('.pic'),
			size = {};

		if ('0' != instance.options.lazyLoad) {
			instance.placeImage(index);
			return;
		}

		var img = new Image();
		img.onload = function() {
			size = { width: this.width, height: this.height };
			source.data('size', size);
			instance.placeImage(index);
		};

		if ('undefined' != source.attr('src')) {
			img.src = source.attr('src');

		} else {
			img.src = source.data('src');
		}
	};

	Plugin.prototype.placeImage = function(index) {
		if ('grid' == this.options.type) {
			return;
		}

		var $tile = this.$items.not('.jtg-hidden').eq(index);
		var $image = $tile.find('.pic');

		var tSize = $tile.data('size');
		var iSize = $image.data('size');

		if (typeof tSize == 'undefined') {
			return;
		}
		if (typeof iSize == 'undefined') {
			return;
		}

		var tRatio = tSize.width / tSize.height;
		var iRatio = iSize.width / iSize.height;

		var valign = $image.data('valign') ? $image.data('valign') : 'middle';
		var halign = $image.data('halign') ? $image.data('halign') : 'center';

		var cssProps = {
			top: 'auto',
			bottom: 'auto',
			left: 'auto',
			right: 'auto',
			width: 'auto',
			height: 'auto',
			margin: '0',
			maxWidth: '999em'
		};

		var newHeight = tSize.width * iSize.height / iSize.width;

		if (newHeight > tSize.height) {
			cssProps.width = tSize.width;
			cssProps.left = 0;

			switch (valign) {
				case 'top':
					cssProps.top = 0;
					break;
				case 'middle':
					cssProps.top = 0 - (tSize.width * (1 / iRatio) - tSize.height) / 2;
					break;
				case 'bottom':
					cssProps.bottom = 0;
					break;
			}
		} else {
			cssProps.height = tSize.height;
			cssProps.top = 0;

			switch (halign) {
				case 'left':
					cssProps.left = 0;
					break;
				case 'center':
					cssProps.left = 0 - (tSize.height * iRatio - tSize.width) / 2;
					break;
				case 'right':
					cssProps.right = 0;
					break;
			}
		}

		$image.css(cssProps);
		this.$items.not('.jtg-hidden').eq(index).addClass('tg-loaded');
	};

	Plugin.prototype.setupSocial = function() {
		if (this.options.enableTwitter) {
			setupTwitter(this.$items, this);
		}
		if (this.options.enableFacebook) {
			setupFacebook(this.$items, this);
		}
		if (this.options.enablePinterest) {
			setupPinterest(this.$items, this);
		}
		if (this.options.enableLinkedin) {
			setupLinkedIN(this.$items, this);
		}
		if (this.options.enableWhatsapp) {
			setupWhatsapp(this.$items, this);
		}
		if (this.options.enableEmail) {
			setupEmail(this.$items, this);
		}
	};

	Plugin.prototype.destroy = function() {
		if (this.isPackeryActive) {
			this.$itemsCnt.packery('destroy');
			this.isPackeryActive = false;
		}
	};

	//credits James Padolsey http://james.padolsey.com/
	var qualifyURL = function(url) {
		var img = document.createElement('img');
		img.src = url; // set string url
		url = img.src; // get qualified url
		img.src = null; // no server request
		return url;
	};

	var setupTwitter = function($tiles, plugin) {
		$tiles.find('.modula-icon-twitter').click(function(e) {
			e.preventDefault();

			var image = $(this).parents('.modula-item').find('img.pic');
			var $caption = image.data('caption');
			var image_link = image.data('full');
			var $title = image.attr('title');
			var text = document.title;

			if ($title.length > 0) {
				text = $.trim($title);
			} else if ($caption.length > 0) {
				text = $.trim($caption);
			}

			var w = window.open(
				'https://twitter.com/intent/tweet?url=' + encodeURI(image_link) + '&text=' + encodeURI(text),
				'ftgw',
				'location=1,status=1,scrollbars=1,width=600,height=400'
			);
			w.moveTo(screen.width / 2 - 300, screen.height / 2 - 200);
			return false;
		});
	};

	var setupFacebook = function($tiles, plugin) {
		$tiles.find('.modula-icon-facebook').click(function(e) {
			e.preventDefault();

			var image = $(this).parents('.modula-item').find('img.pic');
			var image_link = image.attr('data-full');

			var url = '//www.facebook.com/sharer.php?u=' + image_link;

			var w = window.open(url, 'ftgw', 'location=1,status=1,scrollbars=1,width=600,height=400');
			w.moveTo(screen.width / 2 - 300, screen.height / 2 - 200);
			return false;
		});
	};

	var setupWhatsapp = function($tiles, plugin) {
		$tiles.find('.modula-icon-whatsapp').click(function(e) {
			e.preventDefault();

			var image_link = $(this).parents('.modula-item').find('img.pic').attr('data-full');

			var w = window.open(
				'https://api.whatsapp.com/send?text=' + encodeURI(image_link) + '&preview_url=true',
				'ftgw',
				'location=1,status=1,scrollbars=1,width=600,height=400'
			);
			w.moveTo(screen.width / 2 - 300, screen.height / 2 - 200);
			return false;
		});
	};

	var setupPinterest = function($tiles, plugin) {
		$tiles.find('.modula-icon-pinterest').click(function(e) {
			e.preventDefault();

			var image = $(this).parents('.modula-item').find('img.pic');
			var image_link = image.data('full');
			var $caption = image.data('caption');
			var $title = image.attr('title');

			var text = document.title;

			if ($title.length > 0) {
				text = $.trim($title);
			} else if ($caption.length > 0) {
				text = $.trim($caption);
			}

			var url =
				'http://pinterest.com/pin/create/button/?url=' +
				encodeURI(image_link) +
				'&description=' +
				encodeURI(text);

			if (image.length >= 1) {
				var src = image.attr('data-full');
				url += '&media=' + qualifyURL(src);
			}

			var w = window.open(url, 'ftgw', 'location=1,status=1,scrollbars=1,width=600,height=400');
			w.moveTo(screen.width / 2 - 300, screen.height / 2 - 200);
			return false;
		});
	};

	var setupLinkedIN = function($tiles, plugin) {
		$tiles.find('.modula-icon-linkedin').click(function(e) {
			e.preventDefault();
			var image_link = $(this).parents('.modula-item').find('img.pic').attr('data-full');
			var url = '//linkedin.com/shareArticle?mini=true&url=' + encodeURI(image_link);

			var w = window.open(url, 'ftgw', 'location=1,status=1,scrollbars=1,width=600,height=400');
			w.moveTo(screen.width / 2 - 300, screen.height / 2 - 200);
			return false;
		});
	};

	var setupEmail = function($tiles, plugin) {
		$tiles.find('.modula-icon-email').click(function(e) {
			var subject = encodeURI(plugin.options.email_subject);
			var imageLink = jQuery('.modula-icon-email').parents('.modula-item').find('img.pic').attr('data-full');
			var galleryLink = location.href;

			var emailMessage = encodeURI(
				plugin.options.email_message
					.replace(/%%image_link%%/g, imageLink)
					.replace(/%%gallery_link%%/g, galleryLink)
			);

			var url = 'mailto:?subject=' + subject + '&body=' + emailMessage;
			var w = window.open(url, 'ftgw', 'location=1,status=1,scrollbars=1,width=600,height=400');
			w.moveTo(screen.width / 2 - 300, screen.height / 2 - 200);
			return false;
		});
	};

	$.fn[pluginName] = function(options) {
		var args = arguments;

		if (options === undefined || typeof options === 'object') {
			return this.each(function() {
				if (!$.data(this, 'plugin_' + pluginName)) {
					$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
				}
			});
		} else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
			var returns;

			this.each(function() {
				var instance = $.data(this, 'plugin_' + pluginName);

				// Tests that there's already a plugin-instance
				// and checks that the requested public method exists
				if (instance instanceof Plugin && typeof instance[options] === 'function') {
					// Call the method of our plugin instance,
					// and pass it the supplied arguments.
					returns = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
				}

				// Allow instances to be destroyed via the 'destroy' method
				if (options === 'destroy') {
					$.data(this, 'plugin_' + pluginName, null);
				}
			});

			return returns !== undefined ? returns : this;
		}
	};
})(jQuery, window, document);

jQuery(document).ready(function() {
	var modulaGalleries = jQuery('.modula.modula-gallery');

	jQuery.each(modulaGalleries, function() {
		var modulaSettings = jQuery(this).data('config');

		jQuery(this).modulaGallery(modulaSettings);
	});
});

function modulaInViewport(element) {
	if (typeof jQuery === 'function' && element instanceof jQuery) {
		element = element[0];
	}

	var elementBounds = element.getBoundingClientRect();

	return (
		(elementBounds.top - jQuery(window).height() <= -100 && elementBounds.top - jQuery(window).height() >= -400) ||
		elementBounds.bottom <= jQuery(window).height()
	);
}