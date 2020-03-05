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
jQuery(document).on( 'vc-full-width-row-single vc-full-width-row', function( event, element ){
    if( jQuery( 'body' ).find( '.modula' ).length > 0 ){
        jQuery( window ).trigger( 'modula-update' );
    }
});

// Compatibility with Elementor
jQuery( window ).on( 'elementor/frontend/init', function(){
    if ( window.elementorFrontend ) {
        window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
            if( jQuery( 'body' ).find( '.modula' ).length > 0 ){
                jQuery( window ).trigger( 'modula-update' );
            }
        });
    }
});

; (function ($, window, document, undefined) {


    // Create the defaults once
    var pluginName = 'modulaGallery',
        defaults = {
            resizer: '/',
            margin: 10,
            keepArea: true,
            type: 'creative-gallery',
            columns: 12,
            gutter: 10,
            enableTwitter: false,
            enableFacebook: false,
            enableGplus: false,
            enablePinterest: false,
            enableLinkedin: false,
            lazyLoad: 0,
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        this.$element = $(element);
        this.$itemsCnt = this.$element.find(".modula-items");
        this.$items = this.$itemsCnt.find(".modula-item");

        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.tiles = [];
        this.$tilesCnt = null;
        this.completed = false;
        this.lastWidth = 0;
        this.resizeTO = 0;
        this.isPackeryActive = false;

        // Initiate Gallery
        this.init();
    }

    Plugin.prototype.trunc = function ( v ) {

        if ( Math.trunc ) {
            return Math.trunc( v );
        }else{
            v = +v;
            if (!isFinite(v)) return v;
            
            return (v - v % 1)   ||   (v < 0 ? -0 : v === 0 ? v : 0);
        }
    }

    // Create custom grid gallery based on packery.
    Plugin.prototype.createCustomGallery = function () {

    	var size,
    		containerWidth = this.$element.width(),
    		plugin = this,
            columns = this.options.columns,
            viewport = document.documentElement.clientWidth;

        if ( '1' == this.options.enableResponsive ) {

            if ( viewport <= 568 ) {
                columns = this.options.mobileColumns;
            }else if ( viewport <= 768 ) {
                columns = this.options.tabletColumns;
            }

        }

        if ( this.options.gutter > 0 ) {
            size = ( containerWidth - this.options.gutter * ( columns - 1 ) ) / columns;
        }else{
            size = Math.floor( (containerWidth / columns) * 1000 ) / 1000;
        }

    	this.$items.not(".jtg-hidden").each(function (i, item) {
            var slot = {}, widthColumns, heightColumns, auxWidth, auxHeight;

            widthColumns  = $( item ).data( 'width' );
            heightColumns = $( item ).data( 'height' );

            if ( widthColumns > 12 ) {
            	widthColumns = 12;
            }

            if ( '1' == plugin.options.enableResponsive ) {
                auxWidth = widthColumns;
                auxHeight = heightColumns;

                if ( 1 == columns ) {

                    widthColumns = 1;
                    heightColumns = widthColumns * auxHeight / auxWidth;

                }else{

                    widthColumns = Math.round( columns * auxWidth / 12 );
                    if ( widthColumns < 1 ) { widthColumns = 1; }

                    heightColumns = Math.round( widthColumns * auxHeight / auxWidth );
                    if ( heightColumns < 1 ) { heightColumns = 1; }

                }

            }

            slot.width = size * widthColumns + ( plugin.options.gutter * ( widthColumns - 1 ) );
            slot.height = Math.round( size ) * heightColumns + ( plugin.options.gutter * ( heightColumns - 1 ) );

            $(item)
		   		.data('size', slot)
		   		.addClass('tiled')
		   		.addClass(slot.width > slot.height ? 'tile-h' : 'tile-v')
                .data('position');

            $(item).css($(item).data('size'));
            $(item).find(".figc").css({
	            width: $(item).data('size').width,
	            height: $(item).data('size').height
            });

        });

    	if ( this.isPackeryActive ) {
    		this.$itemsCnt.packery( 'destroy' );
    	}

        this.$itemsCnt.packery({
        	itemSelector: '.modula-item',
            gutter: parseInt( plugin.options.gutter ),
            columnWidth: size,
            // rowHeight: size,
            resize: false
        });
        this.isPackeryActive = true;

    }

    // Create Modula default gallery grid
    Plugin.prototype.createGrid = function () {
        var plugin = this;

        if (this.options.width) {
            this.$itemsCnt.width(this.options.width);
        }

        if (this.options.height) {
            this.$itemsCnt.height(this.options.height);
        }

        this.$itemsCnt.data('area', this.$itemsCnt.width() * this.$itemsCnt.height());

        this.lastWidth = this.$itemsCnt.width();
        
        for (var i = 0; i < this.$items.not(".jtg-hidden").length; i++){
            this.tiles.push(plugin.getSlot());
        }
        
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

        if ( 'custom-grid' === instance.options.type ) {
        	instance.createCustomGallery();
            instance.$itemsCnt.packery();
        }else if( 'creative-gallery' == this.options.type ){
            instance.createGrid();
        }

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

        if ( $image.parent() != $tile ) {
            tSize = {
                'width' : $image.parent().width(),
                'height' : $image.parent().height()
            };
        }

        if ( typeof tSize == 'undefined' ) { return; }
        if ( typeof iSize == 'undefined' ) { return; }

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

    Plugin.prototype.loadImage = function(index) {
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

    Plugin.prototype.init = function () {

        var instance = this;

        // Trigger event before init
        $( document ).trigger('modula_api_before_init', [ instance ]  );

        this.$itemsCnt.css({
            position: 'relative',
            zIndex: 1,
            'min-height': '10px'
        });
        
        this.$items.addClass("tile");
        this.$items.find(".pic").removeAttr("src");

        if ( 'custom-grid' === this.options.type ) {
        	this.createCustomGallery();
        }else if( 'creative-gallery' == this.options.type ){
        	this.createGrid();
        }

        // Load Images
        if ( '1' != instance.options.lazyLoad ) {
            this.loadImage(0);
        }

        $(window).resize(function () {
            instance.onResize(instance);
        });

        $(window).on( 'modula-update', function () {
            instance.onResize(instance);
        });

        $( document ).on('lazyloaded', function( evt ){
            var element = $( evt.target ),
                parent, index;

            if ( 'modula' == element.data( 'source' ) ) {
                element.data('size', { width: element.width(), height: element.height() });
                parent = element.parents( '.modula-item' );
                parent.addClass( 'tg-loaded' );
                index = instance.$items.index( parent );
                instance.placeImage(index);
            }

        });

        // Gives error on front
/*        new ResizeSensor( instance.$element, function() {
            instance.onResize(instance);
        });*/

        // Create social links
        this.setupSocial();
        
        // Trigger custom gallery JS
        if(this.options.onComplete) {
        	this.options.onComplete();
        }

        // Trigger event before init
        $( document ).trigger('modula_api_after_init', [ instance ]  );

    };

    Plugin.prototype.setupSocial = function () {
        if (this.options.enableTwitter){
            setupTwitter(this.$items, this);
        }
        if (this.options.enableFacebook){
            setupFacebook(this.$items, this);
        }
        if (this.options.enablePinterest){
            setupPinterest(this.$items, this);
        }
        if (this.options.enableLinkedin){
            setupLinkedIN(this.$items, this);
        }
        if (this.options.enableWhatsapp){
            setupWhatsapp(this.$items, this);
        }
    }

    Plugin.prototype.destroy = function () {

        if ( this.isPackeryActive ) {
            this.$itemsCnt.packery( 'destroy' );
            this.isPackeryActive = false;
        }

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
        $tiles.find(".modula-icon-facebook").click(function (e) {
            e.preventDefault();

            var image = $(this).parents(".tile:first").find(".pic");

            var $caption = $(this).parents(".tile:first").find(".caption");
            var text = plugin.options.facebookText || document.title;
            if (!plugin.options.facebookText && $caption.length == 1 && $caption.text().length > 0)
                text = $.trim($caption.text());

            var src = image.attr("src");
            var url = "//www.facebook.com/sharer.php?u=" + location.href;

            var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
            w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            return false;
        });
    }

    var setupWhatsapp = function ($tiles, plugin) {
        $tiles.find(".modula-icon-whatsapp").click(function (e) {
            e.preventDefault();
            var $caption = $(this).parents(".tile:first").find(".caption");
            var text = plugin.options.whatsappText || document.title;
            if (!plugin.options.whatsappText && $caption.length == 1 && $caption.text().length > 0)
                text = $.trim($caption.text());
            var w = window.open("https://api.whatsapp.com/send?text=" + encodeURI((window.location.href.split("#")[0])) +'&preview_url=true', "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
            w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            return false;
        });
    }

    var setupPinterest = function ($tiles, plugin) {
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

    var setupLinkedIN = function ($tiles, plugin) {
        $tiles.find(".modula-icon-linkedin").click(function (e) {
            e.preventDefault();

            var url = "//linkedin.com/shareArticle?mini=true&url=" +  + encodeURI(location.href);

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

jQuery( document ).ready( function($){
    var modulaGalleries = $('.modula-gallery');
    $.each( modulaGalleries, function(){
        var modulaID = $( this ).attr( 'id' ),
            modulaSettings = $( this ).data( 'config' );

        $( '#' + modulaID ).modulaGallery( modulaSettings );

    });

});
