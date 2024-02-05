(function ($) {
	'use strict';

	$.modulaFancybox = {
		// Create new instance
		// ===================
		open: function (links, opts, index) {
            $.each(links, function( index, value ) {
                if( 'undefined' != typeof value.opts.caption ){
                    links[index]['caption'] = value.opts.caption;
                }
                if( 'undefined' != typeof value.opts.thumb ){
                    links[index]['thumb'] = value.opts.thumb;
                }
              });
            
            // Set the clicked image index as the opened image in lightbox
            opts.startIndex = index;

            // Set the container for the slide progress animation.
            if( 'undefined' != typeof opts.Slideshow ){
                opts.Slideshow.progressParentEl = (slideshow) => {
                    return slideshow.instance.container;
                };
            }

            // Set the click action for share open.

            if( 'undefined' != typeof opts.Toolbar && 'undefined' != typeof opts.Toolbar.items && 'undefined' != typeof opts.Toolbar.items.share ){
                opts.Toolbar.items.share.click = () => {
                    ModulaOpenShare();
                };
            }

            // Events
            opts.on = {};
            opts.on['*'] = (fancybox, eventName) => {
              //  console.log(`Fancybox eventName: ${eventName}`);
              };
            
            opts.on['Carousel.ready'] = (fancybox, eventName) => {
                var options = fancybox.options,
                    pauseOnHover = ( 'undefined' != typeof options.Slideshow && 'undefined' != typeof options.Slideshow.pauseOnHover ) ? options.Slideshow.pauseOnHover : false,
                    autoplay = fancybox.plugins.Slideshow.ref,
                    paused = false;
                
                if ( '1' == pauseOnHover ) {
                    
                    jQuery( '.modula-fancybox-container .fancybox__slide .fancybox__content' ).on( 'mouseover', function ( e ) {
                        if( autoplay.state == 'play' ){
                            paused = true;
                            autoplay.stop();
                        }
                    } );
        
                    jQuery( '.modula-fancybox-container .fancybox__slide .fancybox__content' ).on( 'mouseout', function ( e ) {
                        if( autoplay.state == 'ready' && paused ){
                            paused = false;
                            autoplay.start();
                        }
                    } );
                }
            };
            
            opts.on['init'] = (fancybox, eventName) => {
                // console.log(`Fancybox eventName: ${eventName}`);
            };
            

			return new ModulaFancybox(
                // Array containing gallery items
                links,
                // Gallery options
                opts
            );
		},
        getInstance: function () {
            return this;
        }

	};

	//// ==========================================================================
	//
	// Share
	// Displays simple form for sharing current url
	//
	// ==========================================================================
	function escapeHtml(string) {
		var entityMap = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#39;',
			'/': '&#x2F;',
			'`': '&#x60;',
			'=': '&#x3D;',
		};

		return String(string).replace(/[&<>"'`=\/]/g, function (s) {
			return entityMap[s];
		});
	}

	function ModulaOpenShare() {
		
		var instance = ModulaFancybox.getInstance(),
			current = ModulaFancybox.getSlide(),
			url = ( 'undefined' != typeof current.opts.image_src ) ? current.opts.image_src : current.src,
			tpl = "<div class='modula-fancybox-share'><h1>"+instance.options.i18n.SHARE+"</h1><p>",
			shareBtnTpl = JSON.parse(ModulaShareButtons);

		$.each(instance.options.modulaShare, function (index, value) {
			var rawEmailMessage = instance.options.lightboxEmailMessage.length
				? instance.options.lightboxEmailMessage
				: 'Here is the link to the image : %%image_link%% and this is the link to the gallery : %%gallery_link%%';
			var emailMessage = rawEmailMessage
				.replace(/\%%gallery_link%%/g, window.location.href)
				.replace(/\%%image_link%%/g, url);

			var text = undefined != current.opts.$thumb.find('img').attr('title')
					? current.opts.$thumb.find('img').attr('title')
					: '';
			if (
				'' == text &&
				current.caption &&
				typeof current.caption !== 'undefined'
			) {
				text = current.caption;
			}

			tpl += shareBtnTpl[value].template({
				media: current.type === 'image' ? encodeURIComponent(url) : '',
				modulaShareUrl: encodeURIComponent(url),
				descr: encodeURIComponent(text),
				subject: encodeURIComponent(instance.options.lightboxEmailSubject),
				emailMessage: encodeURIComponent(emailMessage)
			});
	});

		tpl +=
			"</p><p><input class='modula-fancybox-share__input' type='text' value='{url_raw}' /></p></div>";

		tpl = tpl.template({ url_raw: escapeHtml(url) });
		new ModulaFancybox(
			[
			{
				src: tpl,
				type: "html",
				width: 640,
				height: 360,
			},
			],
			{
				mainClass:"modula-fancybox-container",
			}
		);

	};
	String.prototype.template = function (d) {
		return this.replace(/\{([^\}]+)\}/g, function (m, n) {
			var o = d, p = n.split('|')[0].split('.');
			for (var i = 0; i < p.length; i++) {
				o = typeof o[p[i]] === "function" ? o[p[i]]() : o[p[i]];
				if (typeof o === "undefined" || o === null) return n.indexOf('|') !== -1 ? n.split('|')[1] : m;
			}
			return o;
		});
	};

})(jQuery);