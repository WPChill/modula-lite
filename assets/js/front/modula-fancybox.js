// Define 'jQuery.modulaFancybox' only if jQuery is enabled
// Compatibility for other modules using the jQuery type.
if ('undefined' !== typeof jQuery) {
    jQuery.modulaFancybox = {
        isMobile: function () {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        },
        isPositionCustom: function (opts) {
            return opts.Thumbs && opts.Thumbs.position !== 'bottom';
        },
        open: function (links, opts, index) {
            opts = opts || {};

            if (!this.isPositionCustom(opts) || this.isMobile()) {
                return modulaFancybox.open(links, opts, index);
            }

            var sidebarPosition = opts.Thumbs.position;
            opts = Object.assign(opts, {
                tpl: {
                    closeButton:
                        '<button data-fancybox-close class="f-button is-close-btn" title="{{CLOSE}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"/></svg></button>',
                    main: '<div class="fancybox__container has-sidebar" role="dialog" aria-modal="true" aria-label="{{MODAL}}" tabindex="-1"><div class= "fancybox__backdrop" ></div><div class="fancybox__carousel"></div><div class="fancybox__footer"></div><div class="fancybox__sidebar ' + sidebarPosition + '"></div></div>',
                },
                Thumbs: Object.assign(opts.Thumbs, {
                    type: 'classic',
                    Carousel: {
                        axis: 'y',
                    },
                    parentEl: function (fb) {
                        var sidebar = fb.instance.container.querySelector('.fancybox__sidebar');
                        if (!sidebar) {
                            sidebar = document.createElement('div');
                            sidebar.className = 'fancybox__sidebar ' + sidebarPosition;
                            fb.instance.container.appendChild(sidebar);
                        }
                        return sidebar;
                    },
                }),
            });

            return modulaFancybox.open(links, opts, index);
        },

    };
}

// Main lightbox object.
var modulaFancybox = {
    open: function (links, opts, index) {
        links.forEach(function (value, index) {
            if (typeof value.opts.caption !== 'undefined') {
                links[index]['caption'] = value.opts.caption;
            }
            if (typeof value.opts.thumb !== 'undefined') {
                links[index]['thumb'] = value.opts.thumb;
            }
        });

        opts.startIndex = index;

        if (typeof opts.Slideshow !== 'undefined') {
            opts.Slideshow.progressParentEl = function (slideshow) {
                return slideshow.instance.container;
            };
        }

        if (typeof opts.Toolbar !== 'undefined' && typeof opts.Toolbar.items !== 'undefined' && typeof opts.Toolbar.items.share !== 'undefined') {
            opts.Toolbar.items.share.click = function () {
                ModulaOpenShare();
            };
        }

        // Define opts.on so we can add events to it.
        opts.on = {};

        // Create a custom trigger for each fancybox event.
        opts.on['*'] = function (fancybox, eventName) {
            // replace . from event name with _ and set custom event.
            jQuery(document).trigger('modula_fancybox_' + eventName.replace(/\./g, '_'), [fancybox, this]);
        };

        // Slide pause on hover event
        opts.on['Carousel.ready Carousel.change'] = function (fancybox, eventName) {

            var options = fancybox.options,
                pauseOnHover = (typeof options.Slideshow !== 'undefined' && typeof options.Slideshow.pauseOnHover !== 'undefined') ? options.Slideshow.pauseOnHover : false,
                autoplay = fancybox.plugins.Slideshow.ref,
                paused = false;

            if ('1' == pauseOnHover) {
                document.querySelector('.modula-fancybox-container .fancybox__slide .fancybox__content').addEventListener('mouseover', function (e) {
                    if (autoplay.state == 'play') {
                        paused = true;
                        autoplay.stop();
                    }
                });

                document.querySelector('.modula-fancybox-container .fancybox__slide .fancybox__content').addEventListener('mouseout', function (e) {
                    if (autoplay.state == 'ready' && paused) {
                        paused = false;
                        autoplay.start();
                    }
                });
            }
        };

        opts.on['init'] = function (fancybox) {
            jQuery(document).trigger('modula_fancybox_lightbox_on_init', [fancybox, this]);
        };

        return new ModulaFancybox(links, opts);
    },
    getInstance: function () {
        return this;
    },
};

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

// Open the share fancybox modal for modula lightbox.
function ModulaOpenShare() {
    var instance = ModulaFancybox.getInstance();
    var current = ModulaFancybox.getSlide();
    var url = (typeof current.opts.image_src !== 'undefined') ? current.opts.image_src : current.src;
    var tpl = "<div class='modula-fancybox-share'><h1>" + instance.options.l10n.SHARE + "</h1><p>";
    var shareBtnTpl = JSON.parse(ModulaShareButtons);

    instance.options.modulaShare.forEach(function (value, index) {
        var rawEmailMessage = instance.options.lightboxEmailMessage.length ?
            instance.options.lightboxEmailMessage : instance.options.l10n.EMAIL;

        var emailMessage = rawEmailMessage
            .replace(/\%%gallery_link%%/g, window.location.href)
            .replace(/\%%image_link%%/g, url);

        var text = (current.opts.alt !== undefined) ?
            current.opts.alt :
            '';

        if (text === '' && current.caption && typeof current.caption !== 'undefined') {
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

    tpl += "</p><p><input class='modula-fancybox-share__input' type='text' value='" + escapeHtml(url) + "' /></p></div>";

    tpl = tpl.template({ url_raw: escapeHtml(url) });

    new ModulaFancybox(
        [{
            src: tpl,
            type: "html",
            width: 640,
            height: 360,
        }],
        {
            mainClass: "modula-fancybox-container",
        }
    );
}

// Replaces placeholders like {placeholder} with the actual values in the given string.
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
