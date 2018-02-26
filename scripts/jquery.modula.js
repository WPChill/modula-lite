// Place any jQuery/helper plugins in here.
/*
 *  Project: jQuery Modula 2
 *  Version: 1.0
 *  Description: Artistic gallery
 *  Author: Macho Themes
 */

function tg_getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
}

// Compatibility with WPBakery Page Builder
jQuery(document).on( 'vc-full-width-row-single', function( event, element ){
    if( jQuery( element.el ).find( '.modula' ).length > 0 ){
        jQuery( window ).trigger( 'modula-update' );
    }
});

; (function ($, window, document, undefined) {


    // Create the defaults once
    var pluginName = 'modulaGallery',
        defaults = {
            resizer: '/',
            margin: 10,
            keepArea: true,
            enableTwitter: false,
            enableFacebook: false,
            enableGplus: false,
            enablePinterest: false
        };

    // The actual plugin constructor
    function Plugin(element, options) {
        this.element = element;
        this.$element = $(element);
        this.$itemsCnt = this.$element.find(".items");
        this.$items = this.$itemsCnt.find(".item");

        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.tiles = [];
        this.$tilesCnt = null;
        this.completed = false;
        this.lastWidth = 0;
        this.resizeTO = 0;
        this.init();
    }

    Plugin.prototype.createGrid = function () {
        var plugin = this;
        
        for (var i = 0; i < this.$items.not(".jtg-hidden").length; i++)
            this.tiles.push(plugin.getSlot());
        
        this.tiles.sort(function (x, y) {
            return x.position - y.position;
        });

        this.$items.not(".jtg-hidden").each(function (i, item) {
            var slot = plugin.tiles[i];
            
            $(item)
		   		.data('size', slot)
		   		.addClass('tiled')
		   		.addClass(slot.width > slot.height ? 'tile-h' : 'tile-v')
                .data('position');
        });

        //apply css
        this.$items.each(function (i, item) {
            $(item).css($(item).data('size'));
            $(item).find(".figc").css({
	            width: $(item).data('size').width,
	            height: $(item).data('size').height
            });
        });

        this.completed = true;
    }

    Plugin.prototype.getSlot = function () {

        if (this.tiles.length == 0) {
            var tile = {
                top: 0,
                left: 0,
                width: this.$itemsCnt.width(),
                height: this.$itemsCnt.height(),
                area: this.$itemsCnt.width() * this.$itemsCnt.height(),
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
            maxTileData.width = Math.floor((maxTileData.width / 2) + 
                (randomMaxDelta * (Math.random() - .5)));

            tile = {
                top: maxTileData.top,
                left: maxTileData.left + maxTileData.width + this.options.margin,
                width: maxTileData.prevWidth - maxTileData.width - this.options.margin,
                height: maxTileData.height
            }

        } else {
            var randomMaxDelta = maxTileData.height / 2 * this.options.randomFactor;
            
            maxTileData.prevHeight = maxTileData.height;
            maxTileData.height = Math.floor((maxTileData.height / 2) + 
                (randomMaxDelta * (Math.random() - .5)));

            tile = {
                left: maxTileData.left,
                top: maxTileData.top + maxTileData.height + this.options.margin,
                width: maxTileData.width,
                height: maxTileData.prevHeight - maxTileData.height - this.options.margin
            }
        }

        tile.area = tile.width * tile.height;
        tile.position = tile.top * 1000 + tile.left;

        maxTileData.position = maxTileData.top * 1000 + maxTileData.left;

        this.tiles[maxTileIdx] = maxTileData;
        this.tiles[maxTileIdx].area = maxTileData.width * maxTileData.height;
        
        return tile;
    }

    Plugin.prototype.reset = function () {
        var instance = this;
        instance.tiles = [];
        instance.createGrid();
        instance.$itemsCnt.find('.pic').each(function (i, o) {
            instance.placeImage(i);
        });
        instance.lastWidth = instance.$itemsCnt.width();
    }

    Plugin.prototype.onResize = function (instance) {
        if (instance.lastWidth == instance.$itemsCnt.width())
            return;

        clearTimeout(instance.resizeTO);
        instance.resizeTO = setTimeout(function () {

            if (instance.options.keepArea) {
                var area = instance.$itemsCnt.data('area');
                instance.$itemsCnt.height(area / instance.$itemsCnt.width());
            }

            instance.reset();

        }, 100);
    }

    Plugin.prototype.placeImage = function (index) {

        var $tile = this.$items.eq(index);
        var $image = $tile.find('.pic');

        var tSize = $tile.data('size');
        var iSize = $image.data('size');


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

        if (tRatio > iRatio) {
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
    }

    Plugin.prototype.loadImage = function (index) {
        var instance = this;
        var source = instance.$items.eq(index).find('.pic');
        var img = new Image();
        img.onerror = function () {
            console.log("error loading image [" + index + "] : " + this.src);   
            if (index + 1 < instance.$items.length)
                instance.loadImage(index + 1);
        }
        img.onload = function () {
            source.data('size', { width: this.width, height: this.height });
            instance.placeImage(index);
			
			instance.$items.eq(index).addClass("tg-loaded");
            if (index + 1 < instance.$items.length)
                instance.loadImage(index + 1);
        }

        var original_src = source.data('src');
        img.src = original_src;
        source.attr("src", original_src);
    }

    Plugin.prototype.setupFilters = function () {
        
        var filterClick = $('#filterClick').val();
        var instance = this;
        instance.$element.delegate(".filters a", "click", function (e) {
            if(filterClick != "T")
            {                
                e.preventDefault();
            }
			
			if($(this).hasClass("selected"))
				return;
				
			instance.$element.find(".filters a").removeClass("selected");
			$(this).addClass("selected");
			
            var filter = $(this).attr("href").substr(1);
            if (filter) {
                instance.$items.removeClass('jtg-hidden');
                instance.$items.show();
                instance.$items.not("." + filter).addClass("jtg-hidden").hide();                
            } else {
                instance.$items.removeClass('jtg-hidden');
                instance.$items.show();
            }

            instance.reset();
        });
    };

    Plugin.prototype.init = function () {
     
        var instance = this;
        
        var current_filter = tg_getURLParameter('jtg-filter');

        if(current_filter != null)
        {
            instance.$element.find(".filters a").removeClass('selected');
            instance.$element.find(".filters a").each(function(){
              
                if($(this).data('filter') == current_filter)
                {
                    $(this).addClass('selected');
                }
            })
        }   

        var hash = window.location.hash;

        this.$itemsCnt.css({
            position: 'relative',
            zIndex: 1
        });
        
        this.$items.addClass("tile");
        this.$items.find(".pic").removeAttr("src");

        if (this.options.width) {
            this.$itemsCnt.width(this.options.width);
        }

        if (this.options.height) {
            this.$itemsCnt.height(this.options.height);
        }

        this.$itemsCnt.data('area', this.$itemsCnt.width() * this.$itemsCnt.height());

        this.lastWidth = this.$itemsCnt.width();
        this.createGrid();

        this.loadImage(0);

        var instance = this;
        $(window).resize(function () {
            instance.onResize(instance);
        });

        $(window).on( 'modula-update', function () {
            instance.onResize(instance);
        });

        this.setupFilters();
        this.setupSocial();
        
        if(this.options.onComplete)
        	this.options.onComplete();

        if(hash != "" && hash != "#" && current_filter == null) {
           var hash_class = hash.replace('#', '.');           

            var filters = [];

                 instance.$element.find(".filters a").each(function(){
                    filters.push($(this).attr('href'));
                 })
                 filters.shift();

                 $('.filters a').each(function() {
                    $(this).removeClass('selected');
                    if($(this).attr('href') == hash)
                    {
                        $(this).addClass('selected');
                    }
                 })


                 if( $.inArray(hash, filters) >= 0)
                 {
                    instance.$items.addClass('jtg-hidden').hide();
                 }               
                 
                 hash_class = hash_class.replace('.','');
                 instance.$items.each(function(){
                    if($(this).hasClass(hash_class))
                    {
                        $(this).removeClass('jtg-hidden');
                        $(this).show();
                    }
                });
        }
    };

    Plugin.prototype.setupSocial = function () {
        if (this.options.enableTwitter || this.options.enableFacebook ||
            this.options.enableGplus || this.options.enablePinterest) {

            this.$items.each(function (i, tile) {
                var $tile = $(tile);
                $tile.append("<div class='jtg-social' />");
            });
        }

        if (this.options.enableTwitter)
            setupTwitter(this.$items, this);
        if (this.options.enableFacebook)
            setupFacebook(this.$items, this);
        if (this.options.enableGplus)
            setupGplus(this.$items, this);
        if (this.options.enablePinterest)
            setupPinterest(this.$items, this);
    }

    var addSocialIcon = function ($tiles, cssClass, name) {
        $tiles.find(".jtg-social").each(function (i, tile) {
            var $tile = $(tile);

            var tw = $("<a class='" + cssClass + "' href='#'></a>");
            $tile.append(tw);
        });
    }

    //credits James Padolsey http://james.padolsey.com/
    var qualifyURL = function (url) {
        var img = document.createElement('img');
        img.src = url; // set string url
        url = img.src; // get qualified url
        img.src = null; // no server request
        return url;
    }

    var setupTwitter = function ($tiles, plugin) {
        addSocialIcon($tiles, "icon modula-icon-twitter", "Twitter");
        $tiles.find(".modula-icon-twitter").click(function (e) {
            e.preventDefault();
            var $caption = $(this).parents(".tile:first").find(".caption");
            var text = plugin.options.twitterText || document.title;
            if (!plugin.options.twitterText && $caption.length == 1 && $caption.text().length > 0)
                text = $.trim($caption.text());
            var w = window.open("https://twitter.com/intent/tweet?url=" + encodeURI(location.href.split('#')[0]) + "&text=" + encodeURI(text), "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
            w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            return false;
        });
    }

    var setupFacebook = function ($tiles, plugin) {
        addSocialIcon($tiles, "icon modula-icon-facebook", "Facebook");
        $tiles.find(".modula-icon-facebook").click(function (e) {
            e.preventDefault();

            var image = $(this).parents(".tile:first").find(".pic");

            var $caption = $(this).parents(".tile:first").find(".caption");
            var text = plugin.options.facebookText || document.title;
            if (!plugin.options.facebookText && $caption.length == 1 && $caption.text().length > 0)
                text = $.trim($caption.text());

            var src = image.attr("src");
            var url = "https://www.facebook.com/dialog/feed?app_id=1614610388804595&"+
                            "link="+encodeURIComponent(location.href)+"&" +
                            "display=popup&"+
                            "name="+encodeURIComponent(document.title)+"&"+
                            "caption=&"+
                            "description="+encodeURIComponent(text)+"&"+
                            "picture="+encodeURIComponent(qualifyURL(src))+"&"+
                            "ref=share&"+
                            "actions={%22name%22:%22View%20the%20gallery%22,%20%22link%22:%22"+encodeURIComponent(location.href)+"%22}&"+
                            "redirect_uri=http://modula.greentreelabs.net/facebook_redirect.html";

            var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
            w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            return false;
        });
    }

    var setupPinterest = function ($tiles, plugin) {
        addSocialIcon($tiles, "icon modula-icon-pinterest", "Pinterest");
        $tiles.find(".modula-icon-pinterest").click(function (e) {
            e.preventDefault();

            var image = $(this).parents(".tile:first").find(".pic");

            var $caption = $(this).parents(".tile:first").find(".caption");
            var text = plugin.options.facebookText || document.title;
            if (!plugin.options.facebookText && $caption.length == 1 && $caption.text().length > 0)
                text = $.trim($caption.text());

            var url = "http://pinterest.com/pin/create/button/?url=" + encodeURI(location.href) + "&description=" + encodeURI(text);

            if (image.length == 1) {
                var src = image.attr("src");
                url += ("&media=" + qualifyURL(src));
            }

            var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
            w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            return false;
        });
    }

    var setupGplus = function ($tiles, plugin) {
        addSocialIcon($tiles, "icon modula-icon-google-plus", "G+");
        $tiles.find(".modula-icon-google-plus").click(function (e) {
            e.preventDefault();

            var url = "https://plus.google.com/share?url=" + encodeURI(location.href);

            var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
            w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            return false;
        });
    }

    $.fn[pluginName] = function (options) {
        var args = arguments;

        if (options === undefined || typeof options === 'object') {
            return this.each(function () {

                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
                }
            });

        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {

            var returns;

            this.each(function () {
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

}(jQuery, window, document));