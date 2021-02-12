/* anime.js */
(function(u,r){"function"===typeof define&&define.amd?define([],r):"object"===typeof module&&module.exports?module.exports=r():u.anime=r()})(this,function(){var u={duration:1E3,delay:0,loop:!1,autoplay:!0,direction:"normal",easing:"easeOutElastic",elasticity:400,round:!1,begin:void 0,update:void 0,complete:void 0},r="translateX translateY translateZ rotate rotateX rotateY rotateZ scale scaleX scaleY scaleZ skewX skewY".split(" "),y,f={arr:function(a){return Array.isArray(a)},obj:function(a){return-1<
Object.prototype.toString.call(a).indexOf("Object")},svg:function(a){return a instanceof SVGElement},dom:function(a){return a.nodeType||f.svg(a)},num:function(a){return!isNaN(parseInt(a))},str:function(a){return"string"===typeof a},fnc:function(a){return"function"===typeof a},und:function(a){return"undefined"===typeof a},nul:function(a){return"null"===typeof a},hex:function(a){return/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(a)},rgb:function(a){return/^rgb/.test(a)},hsl:function(a){return/^hsl/.test(a)},
col:function(a){return f.hex(a)||f.rgb(a)||f.hsl(a)}},D=function(){var a={},b={Sine:function(a){return 1-Math.cos(a*Math.PI/2)},Circ:function(a){return 1-Math.sqrt(1-a*a)},Elastic:function(a,b){if(0===a||1===a)return a;var d=1-Math.min(b,998)/1E3,g=a/1-1;return-(Math.pow(2,10*g)*Math.sin(2*(g-d/(2*Math.PI)*Math.asin(1))*Math.PI/d))},Back:function(a){return a*a*(3*a-2)},Bounce:function(a){for(var b,d=4;a<((b=Math.pow(2,--d))-1)/11;);return 1/Math.pow(4,3-d)-7.5625*Math.pow((3*b-2)/22-a,2)}};["Quad",
"Cubic","Quart","Quint","Expo"].forEach(function(a,e){b[a]=function(a){return Math.pow(a,e+2)}});Object.keys(b).forEach(function(c){var e=b[c];a["easeIn"+c]=e;a["easeOut"+c]=function(a,b){return 1-e(1-a,b)};a["easeInOut"+c]=function(a,b){return.5>a?e(2*a,b)/2:1-e(-2*a+2,b)/2};a["easeOutIn"+c]=function(a,b){return.5>a?(1-e(1-2*a,b))/2:(e(2*a-1,b)+1)/2}});a.linear=function(a){return a};return a}(),z=function(a){return f.str(a)?a:a+""},E=function(a){return a.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase()},
F=function(a){if(f.col(a))return!1;try{return document.querySelectorAll(a)}catch(b){return!1}},A=function(a){return a.reduce(function(a,c){return a.concat(f.arr(c)?A(c):c)},[])},t=function(a){if(f.arr(a))return a;f.str(a)&&(a=F(a)||a);return a instanceof NodeList||a instanceof HTMLCollection?[].slice.call(a):[a]},G=function(a,b){return a.some(function(a){return a===b})},R=function(a,b){var c={};a.forEach(function(a){var d=JSON.stringify(b.map(function(b){return a[b]}));c[d]=c[d]||[];c[d].push(a)});
return Object.keys(c).map(function(a){return c[a]})},H=function(a){return a.filter(function(a,c,e){return e.indexOf(a)===c})},B=function(a){var b={},c;for(c in a)b[c]=a[c];return b},v=function(a,b){for(var c in b)a[c]=f.und(a[c])?b[c]:a[c];return a},S=function(a){a=a.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(a,b,c,m){return b+b+c+c+m+m});var b=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(a);a=parseInt(b[1],16);var c=parseInt(b[2],16),b=parseInt(b[3],16);return"rgb("+a+","+c+","+b+")"},
T=function(a){a=/hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/g.exec(a);var b=parseInt(a[1])/360,c=parseInt(a[2])/100,e=parseInt(a[3])/100;a=function(a,b,c){0>c&&(c+=1);1<c&&--c;return c<1/6?a+6*(b-a)*c:.5>c?b:c<2/3?a+(b-a)*(2/3-c)*6:a};if(0==c)c=e=b=e;else var d=.5>e?e*(1+c):e+c-e*c,g=2*e-d,c=a(g,d,b+1/3),e=a(g,d,b),b=a(g,d,b-1/3);return"rgb("+255*c+","+255*e+","+255*b+")"},p=function(a){return/([\+\-]?[0-9|auto\.]+)(%|px|pt|em|rem|in|cm|mm|ex|pc|vw|vh|deg)?/.exec(a)[2]},I=function(a,b,c){return p(b)?
b:-1<a.indexOf("translate")?p(c)?b+p(c):b+"px":-1<a.indexOf("rotate")||-1<a.indexOf("skew")?b+"deg":b},w=function(a,b){if(b in a.style)return getComputedStyle(a).getPropertyValue(E(b))||"0"},U=function(a,b){var c=-1<b.indexOf("scale")?1:0,e=a.style.transform;if(!e)return c;for(var d=/(\w+)\((.+?)\)/g,g=[],m=[],f=[];g=d.exec(e);)m.push(g[1]),f.push(g[2]);e=f.filter(function(a,c){return m[c]===b});return e.length?e[0]:c},J=function(a,b){if(f.dom(a)&&G(r,b))return"transform";if(f.dom(a)&&(a.getAttribute(b)||
f.svg(a)&&a[b]))return"attribute";if(f.dom(a)&&"transform"!==b&&w(a,b))return"css";if(!f.nul(a[b])&&!f.und(a[b]))return"object"},K=function(a,b){switch(J(a,b)){case "transform":return U(a,b);case "css":return w(a,b);case "attribute":return a.getAttribute(b)}return a[b]||0},L=function(a,b,c){if(f.col(b))return b=f.rgb(b)?b:f.hex(b)?S(b):f.hsl(b)?T(b):void 0,b;if(p(b))return b;a=p(a.to)?p(a.to):p(a.from);!a&&c&&(a=p(c));return a?b+a:b},M=function(a){var b=/-?\d*\.?\d+/g;return{original:a,numbers:z(a).match(b)?
z(a).match(b).map(Number):[0],strings:z(a).split(b)}},V=function(a,b,c){return b.reduce(function(b,d,g){d=d?d:c[g-1];return b+a[g-1]+d})},W=function(a){a=a?A(f.arr(a)?a.map(t):t(a)):[];return a.map(function(a,c){return{target:a,id:c}})},N=function(a,b,c,e){"transform"===c?(c=a+"("+I(a,b.from,b.to)+")",b=a+"("+I(a,b.to)+")"):(a="css"===c?w(e,a):void 0,c=L(b,b.from,a),b=L(b,b.to,a));return{from:M(c),to:M(b)}},X=function(a,b){var c=[];a.forEach(function(e,d){var g=e.target;return b.forEach(function(b){var l=
J(g,b.name);if(l){var q;q=b.name;var h=b.value,h=t(f.fnc(h)?h(g,d):h);q={from:1<h.length?h[0]:K(g,q),to:1<h.length?h[1]:h[0]};h=B(b);h.animatables=e;h.type=l;h.from=N(b.name,q,h.type,g).from;h.to=N(b.name,q,h.type,g).to;h.round=f.col(q.from)||h.round?1:0;h.delay=(f.fnc(h.delay)?h.delay(g,d,a.length):h.delay)/k.speed;h.duration=(f.fnc(h.duration)?h.duration(g,d,a.length):h.duration)/k.speed;c.push(h)}})});return c},Y=function(a,b){var c=X(a,b);return R(c,["name","from","to","delay","duration"]).map(function(a){var b=
B(a[0]);b.animatables=a.map(function(a){return a.animatables});b.totalDuration=b.delay+b.duration;return b})},C=function(a,b){a.tweens.forEach(function(c){var e=c.from,d=a.duration-(c.delay+c.duration);c.from=c.to;c.to=e;b&&(c.delay=d)});a.reversed=a.reversed?!1:!0},Z=function(a){if(a.length)return Math.max.apply(Math,a.map(function(a){return a.totalDuration}))},O=function(a){var b=[],c=[];a.tweens.forEach(function(a){if("css"===a.type||"transform"===a.type)b.push("css"===a.type?E(a.name):"transform"),
a.animatables.forEach(function(a){c.push(a.target)})});return{properties:H(b).join(", "),elements:H(c)}},aa=function(a){var b=O(a);b.elements.forEach(function(a){a.style.willChange=b.properties})},ba=function(a){O(a).elements.forEach(function(a){a.style.removeProperty("will-change")})},ca=function(a,b){var c=a.path,e=a.value*b,d=function(d){d=d||0;return c.getPointAtLength(1<b?a.value+d:e+d)},g=d(),f=d(-1),d=d(1);switch(a.name){case "translateX":return g.x;case "translateY":return g.y;case "rotate":return 180*
Math.atan2(d.y-f.y,d.x-f.x)/Math.PI}},da=function(a,b){var c=Math.min(Math.max(b-a.delay,0),a.duration)/a.duration,e=a.to.numbers.map(function(b,e){var f=a.from.numbers[e],l=D[a.easing](c,a.elasticity),f=a.path?ca(a,l):f+l*(b-f);return f=a.round?Math.round(f*a.round)/a.round:f});return V(e,a.to.strings,a.from.strings)},P=function(a,b){var c;a.currentTime=b;a.progress=b/a.duration*100;for(var e=0;e<a.tweens.length;e++){var d=a.tweens[e];d.currentValue=da(d,b);for(var f=d.currentValue,m=0;m<d.animatables.length;m++){var l=
d.animatables[m],k=l.id,l=l.target,h=d.name;switch(d.type){case "css":l.style[h]=f;break;case "attribute":l.setAttribute(h,f);break;case "object":l[h]=f;break;case "transform":c||(c={}),c[k]||(c[k]=[]),c[k].push(f)}}}if(c)for(e in y||(y=(w(document.body,"transform")?"":"-webkit-")+"transform"),c)a.animatables[e].target.style[y]=c[e].join(" ");a.settings.update&&a.settings.update(a)},Q=function(a){var b={};b.animatables=W(a.targets);b.settings=v(a,u);var c=b.settings,e=[],d;for(d in a)if(!u.hasOwnProperty(d)&&
"targets"!==d){var g=f.obj(a[d])?B(a[d]):{value:a[d]};g.name=d;e.push(v(g,c))}b.properties=e;b.tweens=Y(b.animatables,b.properties);b.duration=Z(b.tweens)||a.duration;b.currentTime=0;b.progress=0;b.ended=!1;return b},n=[],x=0,ea=function(){var a=function(){x=requestAnimationFrame(b)},b=function(b){if(n.length){for(var e=0;e<n.length;e++)n[e].tick(b);a()}else cancelAnimationFrame(x),x=0};return a}(),k=function(a){var b=Q(a),c={};b.tick=function(a){b.ended=!1;c.start||(c.start=a);c.current=Math.min(Math.max(c.last+
a-c.start,0),b.duration);P(b,c.current);var d=b.settings;d.begin&&c.current>=d.delay&&(d.begin(b),d.begin=void 0);c.current>=b.duration&&(d.loop?(c.start=a,"alternate"===d.direction&&C(b,!0),f.num(d.loop)&&d.loop--):(b.ended=!0,b.pause(),d.complete&&d.complete(b)),c.last=0)};b.seek=function(a){P(b,a/100*b.duration)};b.pause=function(){ba(b);var a=n.indexOf(b);-1<a&&n.splice(a,1)};b.play=function(a){b.pause();a&&(b=v(Q(v(a,b.settings)),b));c.start=0;c.last=b.ended?0:b.currentTime;a=b.settings;"reverse"===
a.direction&&C(b);"alternate"!==a.direction||a.loop||(a.loop=1);aa(b);n.push(b);x||ea()};b.restart=function(){b.reversed&&C(b);b.pause();b.seek(0);b.play()};b.settings.autoplay&&b.play();return b};k.version="1.1.1";k.speed=1;k.list=n;k.remove=function(a){a=A(f.arr(a)?a.map(t):t(a));for(var b=n.length-1;0<=b;b--)for(var c=n[b],e=c.tweens,d=e.length-1;0<=d;d--)for(var g=e[d].animatables,k=g.length-1;0<=k;k--)G(a,g[k].target)&&(g.splice(k,1),g.length||e.splice(d,1),e.length||c.pause())};k.easings=D;
k.getValue=K;k.path=function(a){a=f.str(a)?F(a)[0]:a;return{path:a,value:a.getTotalLength()}};k.random=function(a,b){return Math.floor(Math.random()*(b-a+1))+a};return k});

/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2016, Codrops
 * http://www.codrops.com
 */
;(function(window) {

    'use strict';

    // Helper vars and functions.
    function extend( a, b ) {
        for( var key in b ) { 
            if( b.hasOwnProperty( key ) ) {
                a[key] = b[key];
            }
        }
        return a;
    }

    // from http://www.quirksmode.org/js/events_properties.html#position
    function getMousePos(e) {
        var posx = 0, posy = 0;
        if (!e) var e = window.event;
        if (e.pageX || e.pageY)     {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        return { x : posx, y : posy }
    }

    /**
     * TiltFx obj.
     */
    function TiltFx(el, options) {
        this.DOM = {};
        this.DOM.el = el;
        this.options = extend({}, this.options);
        extend(this.options, options);
        this._init();
    }

    TiltFx.prototype.options = {
        movement: {
            imgWrapper : {
                translation : {x: 0, y: 0, z: 0},
                rotation : {x: -5, y: 5, z: 0},
                reverseAnimation : {
                    duration : 1200,
                    easing : 'easeOutElastic',
                    elasticity : 600
                }
            },
            lines : {
                translation : {x: 10, y: 10, z: [0,10]},
                reverseAnimation : {
                    duration : 1000,
                    easing : 'easeOutExpo',
                    elasticity : 600
                }
            },
            caption : {
                translation : {x: 20, y: 20, z: 0},
                rotation : {x: 0, y: 0, z: 0},
                reverseAnimation : {
                    duration : 1500,
                    easing : 'easeOutElastic',
                    elasticity : 600
                }
            },
            /*
            overlay : {
                translation : {x: 10, y: 10, z: [0,50]},
                reverseAnimation : {
                    duration : 500,
                    easing : 'easeOutExpo'
                }
            },
            */
            shine : {
                translation : {x: 50, y: 50, z: 0},
                reverseAnimation : {
                    duration : 1200,
                    easing : 'easeOutElastic',
                    elasticity: 600
                }
            }
        }
    };

    /**
     * Init.
     */
    TiltFx.prototype._init = function() {
        this.DOM.animatable = {};
        this.DOM.animatable.imgWrapper = this.DOM.el.querySelector('.modula .modula-item.effect-tilt_1, .modula-effects-preview .modula-item.effect-tilt_1,.modula .modula-item.effect-tilt_2, .modula-effects-preview .modula-item.effect-tilt_2,.modula .modula-item.effect-tilt_3, .modula-effects-preview .modula-item.effect-tilt_3,.modula .modula-item.effect-tilt_4, .modula-effects-preview .modula-item.effect-tilt_4,.modula .modula-item.effect-tilt_5, .modula-effects-preview .modula-item.effect-tilt_5,.modula .modula-item.effect-tilt_6, .modula-effects-preview .modula-item.effect-tilt_6,.modula .modula-item.effect-tilt_7, .modula-effects-preview .modula-item.effect-tilt_7,.modula .modula-item.effect-tilt_8, .modula-effects-preview .modula-item.effect-tilt_8');
        this.DOM.animatable.lines = this.DOM.el.querySelector('.modula .modula-item.effect-tilt_1 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_1 .tilter__deco--lines,.modula .modula-item.effect-tilt_2 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_2 .tilter__deco--lines,.modula .modula-item.effect-tilt_3 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_3 .tilter__deco--lines,.modula .modula-item.effect-tilt_4 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_4 .tilter__deco--lines,.modula .modula-item.effect-tilt_5 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_5 .tilter__deco--lines,.modula .modula-item.effect-tilt_6 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_6 .tilter__deco--lines,.modula .modula-item.effect-tilt_7 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_7 .tilter__deco--lines,.modula .modula-item.effect-tilt_8 .tilter__deco--lines, .modula-effects-preview .modula-item.effect-tilt_8 .tilter__deco--lines');
        this.DOM.animatable.caption = this.DOM.el.querySelector('.modula .modula-item.effect-tilt_1 .figc, .modula-effects-preview .modula-item.effect-tilt_1 .figc,.modula .modula-item.effect-tilt_2 .figc, .modula-effects-preview .modula-item.effect-tilt_2 .figc,.modula .modula-item.effect-tilt_3 .figc, .modula-effects-preview .modula-item.effect-tilt_3 .figc,.modula .modula-item.effect-tilt_4 .figc, .modula-effects-preview .modula-item.effect-tilt_4 .figc,.modula .modula-item.effect-tilt_5 .figc, .modula-effects-preview .modula-item.effect-tilt_5 .figc,.modula .modula-item.effect-tilt_6 .figc, .modula-effects-preview .modula-item.effect-tilt_6 .figc,.modula .modula-item.effect-tilt_7 .figc, .modula-effects-preview .modula-item.effect-tilt_7 .figc,.modula .modula-item.effect-tilt_8 .figc, .modula-effects-preview .modula-item.effect-tilt_8 .figc');
        this.DOM.animatable.overlay = this.DOM.el.querySelector('.modula .modula-item.effect-tilt_1 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_1 .tilter__deco--overlay,.modula .modula-item.effect-tilt_2 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_2 .tilter__deco--overlay,.modula .modula-item.effect-tilt_3 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_3 .tilter__deco--overlay,.modula .modula-item.effect-tilt_4 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_4 .tilter__deco--overlay,.modula .modula-item.effect-tilt_5 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_5 .tilter__deco--overlay,.modula .modula-item.effect-tilt_6 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_6 .tilter__deco--overlay,.modula .modula-item.effect-tilt_7 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_7 .tilter__deco--overlay,.modula .modula-item.effect-tilt_8 .tilter__deco--overlay,.modula-effects-preview .modula-item.effect-tilt_8 .tilter__deco--overlay');
        this.DOM.animatable.shine = this.DOM.el.querySelector('.modula .modula-item.effect-tilt_1 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_1 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_2 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_2 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_3 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_3 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_4 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_4 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_5 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_5 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_6 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_6 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_7 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_7 .tilter__deco--shine > div,.modula .modula-item.effect-tilt_8 .tilter__deco--shine > div,.modula-effects-preview .modula-item.effect-tilt_8 .tilter__deco--shine > div');
        this._initEvents();
    };

    /**
     * Init/Bind events.
     */
    TiltFx.prototype._initEvents = function() {
        var self = this;
        
        this.mouseenterFn = function() {
            for(var key in self.DOM.animatable) {
                anime.remove(self.DOM.animatable[key]);
            }
        };
        
        this.mousemoveFn = function(ev) {
            requestAnimationFrame(function() { self._layout(ev); });
        };
        
        this.mouseleaveFn = function(ev) {
            requestAnimationFrame(function() {
                for(var key in self.DOM.animatable) {
                    if( self.options.movement[key] == undefined ) {continue;}
                    anime({
                        targets: self.DOM.animatable[key],
                        duration: self.options.movement[key].reverseAnimation != undefined ? self.options.movement[key].reverseAnimation.duration || 0 : 1,
                        easing: self.options.movement[key].reverseAnimation != undefined ? self.options.movement[key].reverseAnimation.easing || 'linear' : 'linear',
                        elasticity: self.options.movement[key].reverseAnimation != undefined ? self.options.movement[key].reverseAnimation.elasticity || null : null,
                        scaleX: 1,
                        scaleY: 1,
                        scaleZ: 1,
                        translateX: 0,
                        translateY: 0,
                        translateZ: 0,
                        rotateX: 0,
                        rotateY: 0,
                        rotateZ: 0
                    });
                }
            });
        };

        this.DOM.el.addEventListener('mousemove', this.mousemoveFn);
        this.DOM.el.addEventListener('mouseleave', this.mouseleaveFn);
        this.DOM.el.addEventListener('mouseenter', this.mouseenterFn);
    };

    TiltFx.prototype._layout = function(ev) {
        // Mouse position relative to the document.
        var mousepos = getMousePos(ev),
            // Document scrolls.
            docScrolls = {left : document.body.scrollLeft + document.documentElement.scrollLeft, top : document.body.scrollTop + document.documentElement.scrollTop},
            bounds = this.DOM.el.getBoundingClientRect(),
            // Mouse position relative to the main element (this.DOM.el).
            relmousepos = { x : mousepos.x - bounds.left - docScrolls.left, y : mousepos.y - bounds.top - docScrolls.top };

        // Movement settings for the animatable elements.
        for(var key in this.DOM.animatable) {
            if( this.DOM.animatable[key] == undefined || this.options.movement[key] == undefined ) {
                continue;
            }
            var t = this.options.movement[key] != undefined ? this.options.movement[key].translation || {x:0,y:0,z:0} : {x:0,y:0,z:0},
                r = this.options.movement[key] != undefined ? this.options.movement[key].rotation || {x:0,y:0,z:0} : {x:0,y:0,z:0},
                setRange = function (obj) {
                    for(var k in obj) {
                        if( obj[k] == undefined ) {
                            obj[k] = [0,0];
                        }
                        else if( typeof obj[k] === 'number' ) {
                            obj[k] = [-1*obj[k],obj[k]];
                        }
                    }
                };

            setRange(t);
            setRange(r);
            
            var transforms = {
                translation : {
                    x: (t.x[1]-t.x[0])/bounds.width*relmousepos.x + t.x[0],
                    y: (t.y[1]-t.y[0])/bounds.height*relmousepos.y + t.y[0],
                    z: (t.z[1]-t.z[0])/bounds.height*relmousepos.y + t.z[0],
                },
                rotation : {
                    x: (r.x[1]-r.x[0])/bounds.height*relmousepos.y + r.x[0],
                    y: (r.y[1]-r.y[0])/bounds.width*relmousepos.x + r.y[0],
                    z: (r.z[1]-r.z[0])/bounds.width*relmousepos.x + r.z[0]
                }
            };

            this.DOM.animatable[key].style.WebkitTransform = this.DOM.animatable[key].style.transform = 'translateX(' + transforms.translation.x + 'px) translateY(' + transforms.translation.y + 'px) translateZ(' + transforms.translation.z + 'px) rotateX(' + transforms.rotation.x + 'deg) rotateY(' + transforms.rotation.y + 'deg) rotateZ(' + transforms.rotation.z + 'deg)';
        }
    };

    window.TiltFx = TiltFx;

})(window);

(function () {
    var tiltSettings = [
        {},
        {
            movement: {
                imgWrapper: {
                    translation: {x: 10, y: 10, z: 30},
                    rotation: {x: 0, y: -10, z: 0},
                    reverseAnimation: {duration: 200, easing: 'easeOutQuad'}
                },
                lines: {
                    translation: {x: 10, y: 10, z: [0, 70]},
                    rotation: {x: 0, y: 0, z: -2},
                    reverseAnimation: {duration: 2000, easing: 'easeOutExpo'}
                },
                caption: {
                    rotation: {x: 0, y: 0, z: 2},
                    reverseAnimation: {duration: 200, easing: 'easeOutQuad'}
                },
                overlay: {
                    translation: {x: 10, y: -10, z: 0},
                    rotation: {x: 0, y: 0, z: 2},
                    reverseAnimation: {duration: 2000, easing: 'easeOutExpo'}
                },
                shine: {
                    translation: {x: 100, y: 100, z: 0},
                    reverseAnimation: {duration: 200, easing: 'easeOutQuad'}
                }
            }
        },
        {
            movement: {
                imgWrapper: {
                    rotation: {x: -5, y: 10, z: 0},
                    reverseAnimation: {duration: 900, easing: 'easeOutCubic'}
                },
                caption: {
                    translation: {x: 30, y: 30, z: [0, 40]},
                    rotation: {x: [0, 15], y: 0, z: 0},
                    reverseAnimation: {duration: 1200, easing: 'easeOutExpo'}
                },
                overlay: {
                    translation: {x: 10, y: 10, z: [0, 20]},
                    reverseAnimation: {duration: 1000, easing: 'easeOutExpo'}
                },
                shine: {
                    translation: {x: 100, y: 100, z: 0},
                    reverseAnimation: {duration: 900, easing: 'easeOutCubic'}
                }
            }
        },
        {
            movement: {
                imgWrapper: {
                    rotation: {x: -5, y: 10, z: 0},
                    reverseAnimation: {duration: 50, easing: 'easeOutQuad'}
                },
                caption: {
                    translation: {x: 20, y: 20, z: 0},
                    reverseAnimation: {duration: 200, easing: 'easeOutQuad'}
                },
                overlay: {
                    translation: {x: 5, y: -5, z: 0},
                    rotation: {x: 0, y: 0, z: 6},
                    reverseAnimation: {duration: 1000, easing: 'easeOutQuad'}
                },
                shine: {
                    translation: {x: 50, y: 50, z: 0},
                    reverseAnimation: {duration: 50, easing: 'easeOutQuad'}
                }
            }
        },
        {
            movement: {
                imgWrapper: {
                    translation: {x: 0, y: -8, z: 0},
                    rotation: {x: 3, y: 3, z: 0},
                    reverseAnimation: {duration: 1200, easing: 'easeOutExpo'}
                },
                lines: {
                    translation: {x: 15, y: 15, z: [0, 15]},
                    reverseAnimation: {duration: 1200, easing: 'easeOutExpo'}
                },
                overlay: {
                    translation: {x: 0, y: 8, z: 0},
                    reverseAnimation: {duration: 600, easing: 'easeOutExpo'}
                },
                caption: {
                    translation: {x: 10, y: -15, z: 0},
                    reverseAnimation: {duration: 900, easing: 'easeOutExpo'}
                },
                shine: {
                    translation: {x: 50, y: 50, z: 0},
                    reverseAnimation: {duration: 1200, easing: 'easeOutExpo'}
                }
            }
        },
        {
            movement: {
                lines: {
                    translation: {x: -5, y: 5, z: 0},
                    reverseAnimation: {duration: 1000, easing: 'easeOutExpo'}
                },
                caption: {
                    translation: {x: 15, y: 15, z: 0},
                    rotation: {x: 0, y: 0, z: 3},
                    reverseAnimation: {duration: 1500, easing: 'easeOutElastic', elasticity: 700}
                },
                overlay: {
                    translation: {x: 15, y: -15, z: 0},
                    reverseAnimation: {duration: 500, easing: 'easeOutExpo'}
                },
                shine: {
                    translation: {x: 50, y: 50, z: 0},
                    reverseAnimation: {duration: 500, easing: 'easeOutExpo'}
                }
            }
        },
        {
            movement: {
                imgWrapper: {
                    translation: {x: 5, y: 5, z: 0},
                    reverseAnimation: {duration: 800, easing: 'easeOutQuart'}
                },
                caption: {
                    translation: {x: 10, y: 10, z: [0, 50]},
                    reverseAnimation: {duration: 1000, easing: 'easeOutQuart'}
                },
                shine: {
                    translation: {x: 50, y: 50, z: 0},
                    reverseAnimation: {duration: 800, easing: 'easeOutQuart'}
                }
            }
        },
        {
            movement: {
                lines: {
                    translation: {x: 40, y: 40, z: 0},
                    reverseAnimation: {duration: 1500, easing: 'easeOutElastic'}
                },
                caption: {
                    translation: {x: 20, y: 20, z: 0},
                    rotation: {x: 0, y: 0, z: -5},
                    reverseAnimation: {duration: 1000, easing: 'easeOutExpo'}
                },
                overlay: {
                    translation: {x: -30, y: -30, z: 0},
                    rotation: {x: 0, y: 0, z: 3},
                    reverseAnimation: {duration: 750, easing: 'easeOutExpo'}
                },
                shine: {
                    translation: {x: 100, y: 100, z: 0},
                    reverseAnimation: {duration: 750, easing: 'easeOutExpo'}
                }
            }
        }];

    function init() {
        var idx = 0;
        [].slice.call(document.querySelectorAll('.modula .modula-item.effect-tilt_1, .modula-effects-preview .modula-item.effect-tilt_1,.modula .modula-item.effect-tilt_2, .modula-effects-preview .modula-item.effect-tilt_2,.modula .modula-item.effect-tilt_3, .modula-effects-preview .modula-item.effect-tilt_3,.modula .modula-item.effect-tilt_4, .modula-effects-preview .modula-item.effect-tilt_4,.modula .modula-item.effect-tilt_5, .modula-effects-preview .modula-item.effect-tilt_5,.modula .modula-item.effect-tilt_6, .modula-effects-preview .modula-item.effect-tilt_6,.modula .modula-item.effect-tilt_7, .modula-effects-preview .modula-item.effect-tilt_7,.modula .modula-item.effect-tilt_8, .modula-effects-preview .modula-item.effect-tilt_8')).forEach(function (el, pos) {
            idx = pos % 2 === 0 ? idx + 1 : idx;
            new TiltFx(el, tiltSettings[idx - 1]);
        });
    }
        init();
})();