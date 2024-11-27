/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ 20:
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

var __webpack_unused_export__;
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var f=__webpack_require__(540),k=Symbol.for("react.element"),l=Symbol.for("react.fragment"),m=Object.prototype.hasOwnProperty,n=f.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,p={key:!0,ref:!0,__self:!0,__source:!0};
function q(c,a,g){var b,d={},e=null,h=null;void 0!==g&&(e=""+g);void 0!==a.key&&(e=""+a.key);void 0!==a.ref&&(h=a.ref);for(b in a)m.call(a,b)&&!p.hasOwnProperty(b)&&(d[b]=a[b]);if(c&&c.defaultProps)for(b in a=c.defaultProps,a)void 0===d[b]&&(d[b]=a[b]);return{$$typeof:k,type:c,key:e,ref:h,props:d,_owner:n.current}}__webpack_unused_export__=l;exports.jsx=q;__webpack_unused_export__=q;


/***/ }),

/***/ 287:
/***/ ((__unused_webpack_module, exports) => {

/**
 * @license React
 * react.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var l=Symbol.for("react.element"),n=Symbol.for("react.portal"),p=Symbol.for("react.fragment"),q=Symbol.for("react.strict_mode"),r=Symbol.for("react.profiler"),t=Symbol.for("react.provider"),u=Symbol.for("react.context"),v=Symbol.for("react.forward_ref"),w=Symbol.for("react.suspense"),x=Symbol.for("react.memo"),y=Symbol.for("react.lazy"),z=Symbol.iterator;function A(a){if(null===a||"object"!==typeof a)return null;a=z&&a[z]||a["@@iterator"];return"function"===typeof a?a:null}
var B={isMounted:function(){return!1},enqueueForceUpdate:function(){},enqueueReplaceState:function(){},enqueueSetState:function(){}},C=Object.assign,D={};function E(a,b,e){this.props=a;this.context=b;this.refs=D;this.updater=e||B}E.prototype.isReactComponent={};
E.prototype.setState=function(a,b){if("object"!==typeof a&&"function"!==typeof a&&null!=a)throw Error("setState(...): takes an object of state variables to update or a function which returns an object of state variables.");this.updater.enqueueSetState(this,a,b,"setState")};E.prototype.forceUpdate=function(a){this.updater.enqueueForceUpdate(this,a,"forceUpdate")};function F(){}F.prototype=E.prototype;function G(a,b,e){this.props=a;this.context=b;this.refs=D;this.updater=e||B}var H=G.prototype=new F;
H.constructor=G;C(H,E.prototype);H.isPureReactComponent=!0;var I=Array.isArray,J=Object.prototype.hasOwnProperty,K={current:null},L={key:!0,ref:!0,__self:!0,__source:!0};
function M(a,b,e){var d,c={},k=null,h=null;if(null!=b)for(d in void 0!==b.ref&&(h=b.ref),void 0!==b.key&&(k=""+b.key),b)J.call(b,d)&&!L.hasOwnProperty(d)&&(c[d]=b[d]);var g=arguments.length-2;if(1===g)c.children=e;else if(1<g){for(var f=Array(g),m=0;m<g;m++)f[m]=arguments[m+2];c.children=f}if(a&&a.defaultProps)for(d in g=a.defaultProps,g)void 0===c[d]&&(c[d]=g[d]);return{$$typeof:l,type:a,key:k,ref:h,props:c,_owner:K.current}}
function N(a,b){return{$$typeof:l,type:a.type,key:b,ref:a.ref,props:a.props,_owner:a._owner}}function O(a){return"object"===typeof a&&null!==a&&a.$$typeof===l}function escape(a){var b={"=":"=0",":":"=2"};return"$"+a.replace(/[=:]/g,function(a){return b[a]})}var P=/\/+/g;function Q(a,b){return"object"===typeof a&&null!==a&&null!=a.key?escape(""+a.key):b.toString(36)}
function R(a,b,e,d,c){var k=typeof a;if("undefined"===k||"boolean"===k)a=null;var h=!1;if(null===a)h=!0;else switch(k){case "string":case "number":h=!0;break;case "object":switch(a.$$typeof){case l:case n:h=!0}}if(h)return h=a,c=c(h),a=""===d?"."+Q(h,0):d,I(c)?(e="",null!=a&&(e=a.replace(P,"$&/")+"/"),R(c,b,e,"",function(a){return a})):null!=c&&(O(c)&&(c=N(c,e+(!c.key||h&&h.key===c.key?"":(""+c.key).replace(P,"$&/")+"/")+a)),b.push(c)),1;h=0;d=""===d?".":d+":";if(I(a))for(var g=0;g<a.length;g++){k=
a[g];var f=d+Q(k,g);h+=R(k,b,e,f,c)}else if(f=A(a),"function"===typeof f)for(a=f.call(a),g=0;!(k=a.next()).done;)k=k.value,f=d+Q(k,g++),h+=R(k,b,e,f,c);else if("object"===k)throw b=String(a),Error("Objects are not valid as a React child (found: "+("[object Object]"===b?"object with keys {"+Object.keys(a).join(", ")+"}":b)+"). If you meant to render a collection of children, use an array instead.");return h}
function S(a,b,e){if(null==a)return a;var d=[],c=0;R(a,d,"","",function(a){return b.call(e,a,c++)});return d}function T(a){if(-1===a._status){var b=a._result;b=b();b.then(function(b){if(0===a._status||-1===a._status)a._status=1,a._result=b},function(b){if(0===a._status||-1===a._status)a._status=2,a._result=b});-1===a._status&&(a._status=0,a._result=b)}if(1===a._status)return a._result.default;throw a._result;}
var U={current:null},V={transition:null},W={ReactCurrentDispatcher:U,ReactCurrentBatchConfig:V,ReactCurrentOwner:K};function X(){throw Error("act(...) is not supported in production builds of React.");}
exports.Children={map:S,forEach:function(a,b,e){S(a,function(){b.apply(this,arguments)},e)},count:function(a){var b=0;S(a,function(){b++});return b},toArray:function(a){return S(a,function(a){return a})||[]},only:function(a){if(!O(a))throw Error("React.Children.only expected to receive a single React element child.");return a}};exports.Component=E;exports.Fragment=p;exports.Profiler=r;exports.PureComponent=G;exports.StrictMode=q;exports.Suspense=w;
exports.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED=W;exports.act=X;
exports.cloneElement=function(a,b,e){if(null===a||void 0===a)throw Error("React.cloneElement(...): The argument must be a React element, but you passed "+a+".");var d=C({},a.props),c=a.key,k=a.ref,h=a._owner;if(null!=b){void 0!==b.ref&&(k=b.ref,h=K.current);void 0!==b.key&&(c=""+b.key);if(a.type&&a.type.defaultProps)var g=a.type.defaultProps;for(f in b)J.call(b,f)&&!L.hasOwnProperty(f)&&(d[f]=void 0===b[f]&&void 0!==g?g[f]:b[f])}var f=arguments.length-2;if(1===f)d.children=e;else if(1<f){g=Array(f);
for(var m=0;m<f;m++)g[m]=arguments[m+2];d.children=g}return{$$typeof:l,type:a.type,key:c,ref:k,props:d,_owner:h}};exports.createContext=function(a){a={$$typeof:u,_currentValue:a,_currentValue2:a,_threadCount:0,Provider:null,Consumer:null,_defaultValue:null,_globalName:null};a.Provider={$$typeof:t,_context:a};return a.Consumer=a};exports.createElement=M;exports.createFactory=function(a){var b=M.bind(null,a);b.type=a;return b};exports.createRef=function(){return{current:null}};
exports.forwardRef=function(a){return{$$typeof:v,render:a}};exports.isValidElement=O;exports.lazy=function(a){return{$$typeof:y,_payload:{_status:-1,_result:a},_init:T}};exports.memo=function(a,b){return{$$typeof:x,type:a,compare:void 0===b?null:b}};exports.startTransition=function(a){var b=V.transition;V.transition={};try{a()}finally{V.transition=b}};exports.unstable_act=X;exports.useCallback=function(a,b){return U.current.useCallback(a,b)};exports.useContext=function(a){return U.current.useContext(a)};
exports.useDebugValue=function(){};exports.useDeferredValue=function(a){return U.current.useDeferredValue(a)};exports.useEffect=function(a,b){return U.current.useEffect(a,b)};exports.useId=function(){return U.current.useId()};exports.useImperativeHandle=function(a,b,e){return U.current.useImperativeHandle(a,b,e)};exports.useInsertionEffect=function(a,b){return U.current.useInsertionEffect(a,b)};exports.useLayoutEffect=function(a,b){return U.current.useLayoutEffect(a,b)};
exports.useMemo=function(a,b){return U.current.useMemo(a,b)};exports.useReducer=function(a,b,e){return U.current.useReducer(a,b,e)};exports.useRef=function(a){return U.current.useRef(a)};exports.useState=function(a){return U.current.useState(a)};exports.useSyncExternalStore=function(a,b,e){return U.current.useSyncExternalStore(a,b,e)};exports.useTransition=function(){return U.current.useTransition()};exports.version="18.3.1";


/***/ }),

/***/ 540:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



if (true) {
  module.exports = __webpack_require__(287);
} else {}


/***/ }),

/***/ 848:
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



if (true) {
  module.exports = __webpack_require__(20);
} else {}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};

;// ./assets/src/js/components/ModulaGallerySearch.js
var useEffect = wp.element.useEffect;
var ModulaGallerySearch = function ModulaGallerySearch(props) {
  var onIdChange = props.onIdChange,
    id = props.id,
    options = props.options,
    galleries = props.galleries;
  useEffect(function () {
    var galleriesArray = [];
    if (galleries != undefined && 0 == galleriesArray.length) {
      galleries.forEach(function (gallery) {
        galleriesArray.push({
          value: gallery.id,
          label: gallery.title.rendered
        });
      });
    }
    jQuery('.modula-gallery-input').selectize({
      valueField: 'value',
      labelField: 'label',
      searchField: ['label', 'value'],
      create: false,
      maxItems: 1,
      placeholder: 'Search for a gallery...',
      preload: true,
      allowEmptyOptions: true,
      closeAfterSelect: true,
      options: options.concat(galleriesArray),
      render: {
        option: function option(item, escape) {
          return '<div>' + '<span className="title">' + item.label + '<span className="name"> (#' + escape(item.value) + ')</span>' + '</div>';
        }
      },
      load: function load(query, callback) {
        if (!query.length) {
          return callback();
        }
        jQuery.ajax({
          url: modulaVars.ajaxURL,
          type: 'GET',
          data: {
            action: 'modula_get_gallery',
            nonce: modulaVars.nonce,
            term: query
          },
          success: function success(res) {
            callback(res);
          }
        });
      },
      onChange: function onChange(value) {
        onIdChange(value);
      }
    });
  }, []);
  return /*#__PURE__*/React.createElement("input", {
    className: "modula-gallery-input",
    defaultValue: '0' == id ? '' : id
  });
};
/* harmony default export */ const components_ModulaGallerySearch = (ModulaGallerySearch);
;// ./assets/src/js/components/inspector.js


/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var Fragment = wp.element.Fragment;
var InspectorControls = wp.blockEditor.InspectorControls;
var _wp$components = wp.components,
  Button = _wp$components.Button,
  PanelBody = _wp$components.PanelBody;

/**
 * Inspector controls
 */
var Inspector = function Inspector(props) {
  var attributes = props.attributes,
    galleries = props.galleries,
    onIdChange = props.onIdChange;
  var id = attributes.id,
    currentSelectize = attributes.currentSelectize;
  return /*#__PURE__*/React.createElement(Fragment, null, /*#__PURE__*/React.createElement(InspectorControls, null, /*#__PURE__*/React.createElement(PanelBody, {
    title: __('Gallery Settings', 'modula-best-grid-gallery'),
    initialOpen: true
  }, galleries.length > 0 && /*#__PURE__*/React.createElement(Fragment, null, /*#__PURE__*/React.createElement(components_ModulaGallerySearch, {
    id: id,
    key: id,
    value: id,
    options: currentSelectize,
    onIdChange: onIdChange,
    galleries: galleries
  }), id != 0 && /*#__PURE__*/React.createElement(Button, {
    target: "_blank",
    href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
    isSecondary: true
  }, __('Edit gallery'))))));
};
/* harmony default export */ const inspector = (wp.components.withFilters('modula.ModulaInspector')(Inspector));
;// ./assets/src/js/utils/icons.js
var icons = {};
icons.modula = /*#__PURE__*/React.createElement("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  x: "0px",
  y: "0px",
  viewBox: "364 242.9 312.2 357"
}, /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("path", {
  d: "M528.1,242.9c8.5,16.9,17,33.8,25.6,50.6c13.4,26.4,26.9,52.7,39.9,79.7c-41.8-23.3-83.6-46.7-125.4-70.1 c0.3-1.9,1.7-2.6,2.7-3.5c17.7-17.7,35.4-35.4,53.1-53c1.1-1.1,2.6-2,3.1-3.7C527.4,242.9,527.8,242.9,528.1,242.9z"
}), /*#__PURE__*/React.createElement("path", {
  d: "M602.3,463.3c11.3-6.9,22.6-13.9,33.9-20.8c5.5-3.4,11.1-6.7,16.5-10.3c2.2-1.4,2.9-1.1,3.5,1.5 c6.4,25.3,13,50.6,19.6,75.8c0.6,2.2,1,3.7-2.4,3.5c-46.7-2.1-93.5-4.1-140.2-6.1c-0.2,0-0.3-0.1-0.5-0.2c0.5-1.7,2.1-2,3.3-2.7 c20-12.3,39.9-24.7,60-36.8c3.4-2.1,5.1-3.7,4.8-8.5c-1.4-21.3-1.8-42.6-2.6-63.9c-0.9-24.1-1.8-48.3-2.8-72.4 c-0.2-6.1-0.2-6.1,5.5-4.6c23.8,6.2,47.6,12.5,71.5,18.5c3.9,1,4.2,1.9,2.1,5.4c-23.4,38.5-46.7,77.1-70,115.7c-1,1.7-2,3.4-3,5.1 C601.7,462.8,602,463,602.3,463.3z"
}), /*#__PURE__*/React.createElement("path", {
  d: "M372.8,326.9c48,2.6,95.8,5.1,143.9,7.7c-0.9,2-2.5,2.3-3.7,3.1c-38.6,23.2-77.3,46.4-115.9,69.6c-3,1.8-4.3,2.6-5.4-1.9 c-5.9-24.9-12.2-49.7-18.3-74.6C373.1,329.6,373,328.4,372.8,326.9z"
}), /*#__PURE__*/React.createElement("path", {
  d: "M517.6,599.9c-23.2-43.7-45.9-86.6-69.2-130.5c2.3,1.2,3.5,1.8,4.7,2.4c39.8,21.5,79.5,43.1,119.3,64.5 c3.2,1.7,4.1,2.5,1,5.6c-17.7,17.8-35.2,35.9-52.8,53.9C519.7,596.9,518.9,598.2,517.6,599.9z"
}), /*#__PURE__*/React.createElement("path", {
  d: "M364.9,505.1c26.6-40.5,53.1-80.8,79.7-121.3c1.3,1.3,0.9,2.5,0.9,3.6c0,46-0.1,92-0.1,137.9c0,3.1-0.2,4.5-4,3.3 c-24.9-7.7-49.9-15.2-74.9-22.8C366,505.8,365.7,505.5,364.9,505.1z"
})));
icons.remove = /*#__PURE__*/React.createElement("svg", {
  width: "24",
  height: "24",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, /*#__PURE__*/React.createElement("path", {
  d: "M13 11.9l3.3-3.4-1.1-1-3.2 3.3-3.2-3.3-1.1 1 3.3 3.4-3.5 3.6 1 1L12 13l3.5 3.5 1-1z"
}));
icons.replace = /*#__PURE__*/React.createElement("svg", {
  width: "24",
  height: "24",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, /*#__PURE__*/React.createElement("path", {
  d: "M20.1 5.1L16.9 2 6.2 12.7l-1.3 4.4 4.5-1.3L20.1 5.1zM4 20.8h8v-1.5H4v1.5z"
}));
icons.chevronLeft = /*#__PURE__*/React.createElement("svg", {
  width: "24",
  height: "24",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, /*#__PURE__*/React.createElement("path", {
  d: "M14.6 7l-1.2-1L8 12l5.4 6 1.2-1-4.6-5z"
}));
icons.chevronRight = /*#__PURE__*/React.createElement("svg", {
  width: "24",
  height: "24",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, /*#__PURE__*/React.createElement("path", {
  d: "M10.6 6L9.4 7l4.6 5-4.6 5 1.2 1 5.4-6z"
}));
icons.twitter = /*#__PURE__*/React.createElement("svg", {
  "aria-hidden": "true",
  "data-prefix": "fab",
  "data-icon": "twitter",
  className: "svg-inline--fa fa-twitter fa-w-16",
  role: "img",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 512 512"
}, /*#__PURE__*/React.createElement("path", {
  fill: "currentColor",
  d: "M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
}));
icons.facebook = /*#__PURE__*/React.createElement("svg", {
  "aria-hidden": "true",
  "data-prefix": "fab",
  "data-icon": "facebook-f",
  className: "svg-inline--fa fa-facebook-f fa-w-9",
  role: "img",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 264 512"
}, /*#__PURE__*/React.createElement("path", {
  fill: "currentColor",
  d: "M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"
}));
icons.whatsapp = /*#__PURE__*/React.createElement("svg", {
  "aria-hidden": "true",
  focusable: "false",
  preserveAspectRatio: "xMidYMid meet",
  viewBox: "0 0 1536 1600"
}, /*#__PURE__*/React.createElement("path", {
  d: "M985 878q13 0 97.5 44t89.5 53q2 5 2 15q0 33-17 76q-16 39-71 65.5T984 1158q-57 0-190-62q-98-45-170-118T476 793q-72-107-71-194v-8q3-91 74-158q24-22 52-22q6 0 18 1.5t19 1.5q19 0 26.5 6.5T610 448q8 20 33 88t25 75q0 21-34.5 57.5T599 715q0 7 5 15q34 73 102 137q56 53 151 101q12 7 22 7q15 0 54-48.5t52-48.5zm-203 530q127 0 243.5-50t200.5-134t134-200.5t50-243.5t-50-243.5T1226 336t-200.5-134T782 152t-243.5 50T338 336T204 536.5T154 780q0 203 120 368l-79 233l242-77q158 104 345 104zm0-1382q153 0 292.5 60T1315 247t161 240.5t60 292.5t-60 292.5t-161 240.5t-240.5 161t-292.5 60q-195 0-365-94L0 1574l136-405Q28 991 28 780q0-153 60-292.5T249 247T489.5 86T782 26z",
  fill: "currentColor"
}));
icons.pinterest = /*#__PURE__*/React.createElement("svg", {
  "aria-hidden": "true",
  "data-prefix": "fab",
  "data-icon": "pinterest-p",
  className: "svg-inline--fa fa-pinterest-p fa-w-12",
  role: "img",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 384 512"
}, /*#__PURE__*/React.createElement("path", {
  fill: "currentColor",
  d: "M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"
}));
icons.linkedin = /*#__PURE__*/React.createElement("svg", {
  "aria-hidden": "true",
  focusable: "false",
  "data-prefix": "fab",
  "data-icon": "linkedin-in",
  className: "svg-inline--fa fa-linkedin-in fa-w-14",
  role: "img",
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 448 512"
}, /*#__PURE__*/React.createElement("path", {
  fill: "currentColor",
  d: "M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"
}));
icons.email = /*#__PURE__*/React.createElement("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "24",
  height: "24",
  viewBox: "0 0 24 24"
}, /*#__PURE__*/React.createElement("path", {
  d: "M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z",
  fill: "currentColor"
}));
icons.chevronRightFancy = /*#__PURE__*/React.createElement("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  fill: "currentColor",
  className: "bi bi-chevron-right",
  viewBox: "0 0 16 16"
}, /*#__PURE__*/React.createElement("path", {
  fillRule: "evenodd",
  d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
}));
/* harmony default export */ const utils_icons = (icons);
;// ./assets/src/js/components/ModulaGalleryImageInner.js

var ModulaGalleryImageInner_Fragment = wp.element.Fragment;
var ModulaGalleryImageInner = function ModulaGalleryImageInner(props) {
  var settings = props.settings,
    img = props.img,
    hideTitle = props.hideTitle,
    hideDescription = props.hideDescription,
    hideSocial = props.hideSocial,
    index = props.index;
  var effectArray = ['tilt_1', 'tilt_3', 'tilt_7'],
    overlayArray = ['tilt_3', 'tilt_7'],
    svgArray = ['tilt_1', 'tilt_7'],
    jtgBody = ['lily', 'centered-bottom', 'sadie', 'ruby', 'bubba', 'dexter', 'chico', 'ming'];
  return [/*#__PURE__*/React.createElement(ModulaGalleryImageInner_Fragment, {
    key: index
  }, effectArray.includes(settings.effect) && /*#__PURE__*/React.createElement("div", {
    className: "tilter__deco tilter__deco--shine"
  }, /*#__PURE__*/React.createElement("div", null)), overlayArray.includes(settings.effect) && /*#__PURE__*/React.createElement("div", {
    className: "tilter__deco tilter__deco--overlay"
  }), svgArray.includes(settings.effect) && /*#__PURE__*/React.createElement("div", {
    className: "tilter__deco tilter__deco--lines"
  }), /*#__PURE__*/React.createElement("div", {
    className: "figc"
  }, /*#__PURE__*/React.createElement("div", {
    className: "figc-inner"
  }, '0' == settings.hide_title && !hideTitle && /*#__PURE__*/React.createElement("div", {
    className: 'jtg-title'
  }, " ", img.title, " "), /*#__PURE__*/React.createElement("div", {
    className: jtgBody.includes(settings.effect) ? 'jtg-body' : ''
  }, '0' == settings.hide_description && !hideDescription && /*#__PURE__*/React.createElement("p", {
    className: "description"
  }, ' ', 0 != img.description.length && img.description, ' '), !hideSocial && '1' == settings.enableSocial && /*#__PURE__*/React.createElement("div", {
    className: "jtg-social"
  }, '1' == settings.enableTwitter && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-twitter",
    href: "#"
  }, ' ', "$", utils_icons.twitter, ' '), '1' == settings.enableFacebook && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-facebook",
    href: "#"
  }, ' ', "$", utils_icons.facebook, ' '), '1' == settings.enableWhatsapp && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-whatsapp",
    href: "#"
  }, ' ', "$", utils_icons.whatsapp, ' '), '1' == settings.enableLinkedin && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-linkedin",
    href: "#"
  }, ' ', "$", utils_icons.linkedin, ' '), '1' == settings.enablePinterest && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-pinterest",
    href: "#"
  }, ' ', "$", utils_icons.pinterest, ' '), '1' == settings.enableEmail && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-email",
    href: "#"
  }, ' ', "$", utils_icons.email, ' '))))))];
};
/* harmony default export */ const components_ModulaGalleryImageInner = (ModulaGalleryImageInner);
;// ./assets/src/js/components/ModulaGalleryImage.js

var ModulaGalleryImage = function ModulaGalleryImage(props) {
  var _props$attributes = props.attributes,
    settings = _props$attributes.settings,
    effectCheck = _props$attributes.effectCheck;
  var img = props.img,
    index = props.index;
  var itemClassNames = "modula-item effect-".concat(settings.effect);
  if (settings.type === 'slider') {
    itemClassNames = 'modula-item f-carousel__slide';
  }
  var renderMedia = function renderMedia() {
    if (!img.video_template || img.video_template !== '1' || !img.video_type) {
      // Return image element if video_template is not defined or is not '1'
      return /*#__PURE__*/React.createElement("img", {
        className: "modula-image pic",
        "data-id": img.id,
        "data-full": img.src,
        "data-src": img.src,
        "data-valign": "middle",
        "data-halign": "center",
        src: img.src
      });
    } else if (img.video_template == '1' && 'undefined' != typeof img.video_thumbnail && '' != img.video_thumbnail) {
      // Return image thumbnail of video
      return /*#__PURE__*/React.createElement("img", {
        className: "modula-image pic",
        "data-id": img.id,
        "data-full": img.src,
        "data-src": img.video_thumbnail,
        "data-valign": "middle",
        "data-halign": "center",
        src: img.video_thumbnail
      });
    } else if (img.video_type === 'hosted') {
      // Return video element if video_type is 'hosted'
      return /*#__PURE__*/React.createElement("div", {
        className: "video-sizer"
      }, /*#__PURE__*/React.createElement("video", {
        controls: true
      }, /*#__PURE__*/React.createElement("source", {
        src: img.src,
        type: "video/mp4"
      }), "Your browser does not support the video tag."));
    } else if (img.video_type === 'iframe') {
      // Return iframe element if video_type is 'iframe'
      return /*#__PURE__*/React.createElement("div", {
        className: "video-sizer"
      }, /*#__PURE__*/React.createElement("iframe", {
        src: img.src,
        frameBorder: "0",
        allow: "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture",
        allowFullScreen: true
      }));
    }
  };
  return /*#__PURE__*/React.createElement("div", {
    className: itemClassNames,
    "data-width": img['data-width'] ? img['data-width'] : '2',
    "data-height": img['data-height'] ? img['data-height'] : '2'
  }, /*#__PURE__*/React.createElement("div", {
    className: "modula-item-overlay"
  }), /*#__PURE__*/React.createElement("div", {
    className: "modula-item-content"
  }, renderMedia(), settings.type !== 'slider' && /*#__PURE__*/React.createElement(components_ModulaGalleryImageInner, {
    settings: settings,
    img: img,
    index: index,
    key: index,
    hideTitle: effectCheck && effectCheck.title ? false : true,
    hideDescription: effectCheck && effectCheck.description ? false : true,
    hideSocial: effectCheck && effectCheck.social ? false : true,
    effectCheck: effectCheck
  })));
};
/* harmony default export */ const components_ModulaGalleryImage = (wp.components.withFilters('modula.ModulaGalleryImage')(ModulaGalleryImage));
;// ./assets/src/js/components/ModulaStyle.js
var ModulaStyle = function ModulaStyle(props) {
  var id = props.id,
    settings = props.settings;
  var style = "";
  if ('grid' == settings.type) {
    if ('automatic' != settings.grid_type) {
      style += "#jtg-".concat(id, ".modula-gallery .modula-item, .modula-gallery .modula-grid-sizer { width: calc(").concat(100 / settings.grid_type, "% - ").concat(settings.gutter - settings.gutter / settings.grid_type, "px) !important}");
    }
  }
  if ('0' != settings.borderSize) {
    style += "#jtg-".concat(id, " .modula-item {\n\t\t\tborder: ").concat(settings.borderSize, "px solid ").concat(settings.borderColor, ";\n\t\t}");
  }
  if ('0' != settings.borderRadius) {
    style += "#jtg-".concat(id, " .modula-item {\n\t\t\tborder-radius: ").concat(settings.borderRadius, "px;\n\t\t}");
  }
  if ('0' != settings.shadowSize) {
    style += "#jtg-".concat(id, " .modula-item {\n\t\t\tbox-shadow: ").concat(settings.shadowColor, " 0px 0px ").concat(settings.shadowSize, "px;\n\t\t}");
  }
  if ('#ffffff' != settings.socialIconColor) {
    style += "#jtg-".concat(id, " .modula-item .jtg-social a {\n\t\t\tcolor: ").concat(settings.socialIconColor, ";\n\t\t}");
  }
  if ('16' != settings.socialIconSize) {
    style += "#jtg-".concat(id, " .modula-item .jtg-social svg {\n\t\t\theight: ").concat(settings.socialIconSize, "px;\n\t\t\twidth: ").concat(settings.socialIconSize, "px;\n\t\t}");
  }
  if ('10' != settings.socialIconPadding) {
    style += "#jtg-".concat(id, " .modula-item .jtg-social a:not(:last-child) {\n\t\t\tmargin-right: ").concat(settings.socialIconPadding, "px;\n\t\t}");
  }
  style += "#jtg-".concat(id, " .modula-item .caption {\n\t\tbackground-color: ").concat(settings.captionColor, ";\n\t}");
  if ('' != settings.captionColor) {
    style += "#jtg-".concat(id, " .modula-item .figc {\n\t\t\tcolor: ").concat(settings.captionColor, ";\n\t\t}");
  }
  if ('' != settings.titleFontSize && '0' != settings.titleFontSize) {
    style += "#jtg-".concat(id, " .modula-item .figc .jtg-title {\n\t\t\tfont-size: ").concat(settings.titleFontSize, "px;\n\t\t}");
  }
  if ('' != settings.captionFontSize && '0' != settings.captionFontSize) {
    style += "#jtg-".concat(id, " .modula-item .figc p.description {\n\t\t\tfont-size: ").concat(settings.captionFontSize, "px;\n\t\t}");
  }
  style += "#jtg-".concat(id, " .modula-items .figc p.description {\n\t\t\tcolor: ").concat(settings.captionColor, ";\n\t}");
  if ('' != settings.titleColor) {
    style += "#jtg-".concat(id, " .modula-items .figc .jtg-title {\n\t\t\tcolor: ").concat(settings.titleColor, ";\n\t\t}");
  } else {
    style += "#jtg-".concat(id, " .modula-items .figc .jtg-title {\n\t\t\tcolor: ").concat(settings.captionColor, ";\n\t\t}");
  }
  style += "#jtg-".concat(id, ".modula-gallery .modula-item > a, #jtg-").concat(id, ".modula-gallery .modula-item, #jtg-").concat(id, ".modula-gallery .modula-item-content > a:not(.modula-no-follow){\n\t\tcursor: ").concat(settings.cursor, ";\n\t}");

  // SEE ABOUT LOADED EFFECT IF WE NEED TO ADD OR NOTTTTTTTTTTTTTT #REMINDER

  if ('custom-grid' != settings.type || 'slider' != settings.type) {
    style += "#jtg-".concat(id, " {\n\t\twidth: ").concat(settings.width, ";\n\t\tmargin : 0 auto;\n\t\t}");
    if (props.imagesCount == 0) {
      style += "#jtg-".concat(id, " .modula-items {\n\t\t\t\theight: 100px;\n\t\t\t}");
    } else {
      if ('grid' != settings.type && 'slider' != settings.type && 'bnb' != settings.type) {
        style += "#jtg-".concat(id, " .modula-items {\n\t\t\t\theight: ").concat(settings.height[0], "px;\n\t\t\t}");
      } else if ('slider' == settings.type) {
        style += "#jtg-".concat(id, " .modula-items {\n\t\t\t\theight: auto;\n\t\t\t}");
      }
    }
  }
  if (undefined != settings.style && 0 != settings.style.length) {
    style += "".concat(settings.style);
  }

  //RESPONSIVE FIXES
  var mobileStyle = "";
  if ('' != settings.mobileTitleFontSize && 0 != settings.mobileTitleFontSize) {
    mobileStyle += "#jtg-".concat(id, " .modula-item .figc .jtg-title {\n\t\t\tfont-size: ").concat(settings.mobileTitleFontSize, "px\n\t\t}");
  }
  mobileStyle += "#jtg-".concat(id, " .modula-items .figc p.description {\n\t\tcolor: ").concat(settings.captionColor, ";\n\t\tfont-size: ").concat(settings.mobileCaptionFontSize, "px;\n\t}");
  style += "@media screen and (max-width:480px){\n\t\t".concat(mobileStyle, "\n\t\t}");
  if ('none' == settings.effect) {
    style += "#jtg-".concat(id, " .modula-items .modula-item:hover img {\n\t\t\topacity: 1;\n\t\t}");
  }
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item .modula-item-overlay,   #jtg-").concat(id, ".modula .modula-items .modula-item.effect-layla,   #jtg-").concat(id, ".modula .modula-items .modula-item.effect-ruby,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-bubba,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-sarah,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-milo,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-julia,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-hera,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-winston,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-selena,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-terry,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-phoebe,  #jtg-").concat(id, ".modula .modula-items} .modula-item.effect-apollo,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-steve,  #jtg-").concat(id, ".modula .modula-items .modula-item.effect-ming{ \n\t\tbackground-color: ").concat(settings.hoverColor, ";\n\t}");
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item.effect-oscar {\n\t\tbackground: -webkit-linear-gradient(45deg, ").concat(settings.hoverColor, " 0, #9b4a1b 40%, ").concat(settings.hoverColor, " 100%);\n\t\tbackground: linear-gradient(45deg, ").concat(settings.hoverColor, " 0, #9b4a1b 40%, ").concat(settings.hoverColor, " 100%);\n\t}");
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item.effect-roxy {\n\t\tbackground: -webkit-linear-gradient(45deg, ").concat(settings.hoverColor, " 0, #05abe0 100%);\n\t\tbackground: linear-gradient(45deg, ").concat(settings.hoverColor, " 0, #05abe0 100%);\n\t}");
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item.effect-dexter {\n\t\tbackground: -webkit-linear-gradient(top, ").concat(settings.hoverColor, " 0, rgba(104,60,19,1) 100%);\n\t\tbackground: linear-gradient(top, ").concat(settings.hoverColor, " 0, rgba(104,60,19,1) 100%);\n\t}");
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item.effect-jazz {\n\t\tbackground: -webkit-linear-gradient(-45deg, ").concat(settings.hoverColor, " 0, #f33f58 100%);\n\t\tbackground: linear-gradient(-45deg, ").concat(settings.hoverColor, " 0, #f33f58 100%);\n\t}");
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item.effect-lexi {\n\t\tbackground: -webkit-linear-gradient(-45deg, ").concat(settings.hoverColor, " 0, #fff 100%);\n\t\tbackground: linear-gradient(-45deg, ").concat(settings.hoverColor, " 0, #fff 100%);\n\t}");
  style += "#jtg-".concat(id, ".modula .modula-items .modula-item.effect-duke {\n\t\tbackground: -webkit-linear-gradient(-45deg, ").concat(settings.hoverColor, " 0, #cc6055 100%);\n\t\tbackground: linear-gradient(-45deg, ").concat(settings.hoverColor, " 0, #cc6055 100%);\n\t}");
  if (settings.hoverOpacity <= 100 && 'none' != settings.effect) {
    style += "#jtg-".concat(id, ".modula .modula-items .modula-item:hover img {\n\t\t\topacity: ").concat(1 - settings.hoverOpacity / 100, " ;\n\t\t}");
  }
  if ('default' != settings.titleFontWeight) {
    style += "#jtg-".concat(id, ".modula .modula-items .modula-item .jtg-title {\n\t\t\tfont-weight : ").concat(settings.titleFontWeight, ";\n\t\t}");
  }
  if ('default' != settings.captionFontWeight) {
    style += "#jtg-".concat(id, ".modula .modula-items .modula-item p.description {\n\t\t\tfont-weight : ").concat(settings.captionFontWeight, ";\n\t\t}");
  }
  style += "#jtg-".concat(id, ".modula-gallery .modula-item.effect-terry .jtg-social a:not(:last-child) {\n\t\tmargin-bottom: ").concat(settings.socialIconPadding, "px;\n\t}");
  if ('slider' == settings['type']) {
    if ('true' == jQuery('[aria-label=Settings]').attr('aria-expanded')) {
      style += "#jtg-".concat(id, " {\n\t\t\t\t\twidth: 800px;\n\t\t\t\t\t}");
    } else {
      style += "#jtg-".concat(id, " {\n\t\t\twidth: 1100px;\n\t\t\t}");
    }
    style += "#jtg-".concat(id, " .modula-items {\n\t\theight: auto;\n\t\t}");
    style += "#jtg-".concat(id, " .modula-item {\n\t\tbackground-color: transparent;\n\t\ttransform: none;\n\t\t}");
  }
  if (undefined != settings['filters'] && settings['filters'].length > 1) {
    style += "#jtg-".concat(id, ".modula-gallery .filters {\n\t\t\ttext-align: ").concat(settings['filterTextAlignment'], ";\n\t\t}");
  }
  if ('bnb' == settings['type']) {
    style += "#jtg-".concat(id, ".modula.modula-gallery-bnb .modula_bnb_main_wrapper{flex-basis: calc( 50% - ") + settings.gutter / 2 + "px );}";
    style += "#jtg-".concat(id, ".modula.modula-gallery-bnb .modula_bnb_items_wrapper{flex-basis: calc( 50% - ") + settings.gutter / 2 + "px );gap: " + settings.gutter + "px;}";
  }
  style += "#jtg-".concat(id, ".modula.modula-gallery.modula-gallery-initialized .modula-item-content{opacity:1;}");
  return /*#__PURE__*/React.createElement("style", {
    dangerouslySetInnerHTML: {
      __html: "\n      \t\t\t\t".concat(style, "\n    \t\t\t\t")
    }
  });
};
/* harmony default export */ const components_ModulaStyle = (ModulaStyle);
;// ./assets/src/js/components/ModulaItemsExtraComponent.js
var ModulaItemsExtraComponent = function ModulaItemsExtraComponent(props) {
  return null;
};
/* harmony default export */ const components_ModulaItemsExtraComponent = (wp.components.withFilters('modula.ModulaItemsExtraComponent')(ModulaItemsExtraComponent));
;// ./assets/src/js/components/ModulaGallery.js
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
var _wp$element = wp.element,
  ModulaGallery_Fragment = _wp$element.Fragment,
  ModulaGallery_useEffect = _wp$element.useEffect,
  useRef = _wp$element.useRef;



var ModulaGallery = function ModulaGallery(props) {
  var _props$attributes = props.attributes,
    images = _props$attributes.images,
    jsConfig = _props$attributes.jsConfig,
    id = _props$attributes.id;
  var settings = props.settings,
    checkHoverEffect = props.checkHoverEffect,
    modulaRun = props.modulaRun,
    modulaCarouselRun = props.modulaCarouselRun;
  var galleryRef = useRef(null);
  ModulaGallery_useEffect(function () {
    if (galleryRef.current) {
      galleryRef.current = true;
      return;
    }
    if (settings !== undefined) {
      checkHoverEffect(settings.effect);
    }
    if ('slider' !== settings.type) {
      modulaRun(jsConfig);
    } else {
      modulaCarouselRun(id);
    }
  }, []);
  var galleryClassNames = 'modula modula-gallery ';
  var itemsClassNames = 'modula-items';
  if (settings.type == 'creative-gallery') {
    galleryClassNames += 'modula-creative-gallery';
  } else if (settings.type == 'custom-grid') {
    galleryClassNames += 'modula-custom-grid';
  } else if (settings.type == 'slider') {
    galleryClassNames = 'modula-slider';
  } else if (settings.type == 'bnb') {
    galleryClassNames += 'modula-gallery-bnb';
  } else {
    galleryClassNames += 'modula-columns';
    itemsClassNames += ' grid-gallery';
    if (settings.grid_type == 'automatic') {
      itemsClassNames += ' justified-gallery';
    }
  }
  return /*#__PURE__*/React.createElement(ModulaGallery_Fragment, null, /*#__PURE__*/React.createElement(components_ModulaStyle, {
    id: id,
    settings: settings
  }), /*#__PURE__*/React.createElement("div", {
    id: "jtg-".concat(id),
    className: "".concat(galleryClassNames, " ").concat(props.attributes.modulaDivClassName != undefined ? props.attributes.modulaDivClassName : ''),
    "data-config": JSON.stringify(jsConfig)
  }, settings.type == 'grid' && 'automatic' != settings.grid_type && /*#__PURE__*/React.createElement("div", {
    className: "modula-grid-sizer"
  }, " "), /*#__PURE__*/React.createElement(components_ModulaItemsExtraComponent, _extends({}, props, {
    position: 'top'
  })), /*#__PURE__*/React.createElement("div", {
    className: itemsClassNames
  }, images.length > 0 && /*#__PURE__*/React.createElement(ModulaGallery_Fragment, null, settings.type === 'bnb' ? /*#__PURE__*/React.createElement(ModulaGallery_Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: "modula_bnb_main_wrapper"
  }, /*#__PURE__*/React.createElement(components_ModulaGalleryImage, _extends({}, props, {
    img: images[0],
    key: images[0].id,
    index: 0
  }))), /*#__PURE__*/React.createElement("div", {
    className: "modula_bnb_items_wrapper"
  }, images.slice(1).map(function (img, index) {
    return /*#__PURE__*/React.createElement(components_ModulaGalleryImage, _extends({}, props, {
      img: img,
      key: img.id,
      index: index + 1
    }));
  }))) : images.map(function (img, index) {
    return img.id ? /*#__PURE__*/React.createElement(components_ModulaGalleryImage, _extends({}, props, {
      img: img,
      key: img.id,
      index: index
    })) : null;
  }))), /*#__PURE__*/React.createElement(components_ModulaItemsExtraComponent, _extends({}, props, {
    position: 'bottom'
  }))));
};
/* harmony default export */ const components_ModulaGallery = (wp.components.withFilters('modula.modulaGallery')(ModulaGallery));
// EXTERNAL MODULE: ./node_modules/react/index.js
var react = __webpack_require__(540);
;// ./node_modules/@wordpress/hooks/build-module/validateNamespace.js
/**
 * Validate a namespace string.
 *
 * @param {string} namespace The namespace to validate - should take the form
 *                           `vendor/plugin/function`.
 *
 * @return {boolean} Whether the namespace is valid.
 */
function validateNamespace(namespace) {
  if ('string' !== typeof namespace || '' === namespace) {
    // eslint-disable-next-line no-console
    console.error('The namespace must be a non-empty string.');
    return false;
  }
  if (!/^[a-zA-Z][a-zA-Z0-9_.\-\/]*$/.test(namespace)) {
    // eslint-disable-next-line no-console
    console.error('The namespace can only contain numbers, letters, dashes, periods, underscores and slashes.');
    return false;
  }
  return true;
}
/* harmony default export */ const build_module_validateNamespace = (validateNamespace);
//# sourceMappingURL=validateNamespace.js.map
;// ./node_modules/@wordpress/hooks/build-module/validateHookName.js
/**
 * Validate a hookName string.
 *
 * @param {string} hookName The hook name to validate. Should be a non empty string containing
 *                          only numbers, letters, dashes, periods and underscores. Also,
 *                          the hook name cannot begin with `__`.
 *
 * @return {boolean} Whether the hook name is valid.
 */
function validateHookName(hookName) {
  if ('string' !== typeof hookName || '' === hookName) {
    // eslint-disable-next-line no-console
    console.error('The hook name must be a non-empty string.');
    return false;
  }
  if (/^__/.test(hookName)) {
    // eslint-disable-next-line no-console
    console.error('The hook name cannot begin with `__`.');
    return false;
  }
  if (!/^[a-zA-Z][a-zA-Z0-9_.-]*$/.test(hookName)) {
    // eslint-disable-next-line no-console
    console.error('The hook name can only contain numbers, letters, dashes, periods and underscores.');
    return false;
  }
  return true;
}
/* harmony default export */ const build_module_validateHookName = (validateHookName);
//# sourceMappingURL=validateHookName.js.map
;// ./node_modules/@wordpress/hooks/build-module/createAddHook.js
/**
 * Internal dependencies
 */



/**
 * @callback AddHook
 *
 * Adds the hook to the appropriate hooks container.
 *
 * @param {string}               hookName      Name of hook to add
 * @param {string}               namespace     The unique namespace identifying the callback in the form `vendor/plugin/function`.
 * @param {import('.').Callback} callback      Function to call when the hook is run
 * @param {number}               [priority=10] Priority of this hook
 */

/**
 * Returns a function which, when invoked, will add a hook.
 *
 * @param {import('.').Hooks}    hooks    Hooks instance.
 * @param {import('.').StoreKey} storeKey
 *
 * @return {AddHook} Function that adds a new hook.
 */
function createAddHook(hooks, storeKey) {
  return function addHook(hookName, namespace, callback, priority = 10) {
    const hooksStore = hooks[storeKey];
    if (!build_module_validateHookName(hookName)) {
      return;
    }
    if (!build_module_validateNamespace(namespace)) {
      return;
    }
    if ('function' !== typeof callback) {
      // eslint-disable-next-line no-console
      console.error('The hook callback must be a function.');
      return;
    }

    // Validate numeric priority
    if ('number' !== typeof priority) {
      // eslint-disable-next-line no-console
      console.error('If specified, the hook priority must be a number.');
      return;
    }
    const handler = {
      callback,
      priority,
      namespace
    };
    if (hooksStore[hookName]) {
      // Find the correct insert index of the new hook.
      const handlers = hooksStore[hookName].handlers;

      /** @type {number} */
      let i;
      for (i = handlers.length; i > 0; i--) {
        if (priority >= handlers[i - 1].priority) {
          break;
        }
      }
      if (i === handlers.length) {
        // If append, operate via direct assignment.
        handlers[i] = handler;
      } else {
        // Otherwise, insert before index via splice.
        handlers.splice(i, 0, handler);
      }

      // We may also be currently executing this hook.  If the callback
      // we're adding would come after the current callback, there's no
      // problem; otherwise we need to increase the execution index of
      // any other runs by 1 to account for the added element.
      hooksStore.__current.forEach(hookInfo => {
        if (hookInfo.name === hookName && hookInfo.currentIndex >= i) {
          hookInfo.currentIndex++;
        }
      });
    } else {
      // This is the first hook of its type.
      hooksStore[hookName] = {
        handlers: [handler],
        runs: 0
      };
    }
    if (hookName !== 'hookAdded') {
      hooks.doAction('hookAdded', hookName, namespace, callback, priority);
    }
  };
}
/* harmony default export */ const build_module_createAddHook = (createAddHook);
//# sourceMappingURL=createAddHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createRemoveHook.js
/**
 * Internal dependencies
 */



/**
 * @callback RemoveHook
 * Removes the specified callback (or all callbacks) from the hook with a given hookName
 * and namespace.
 *
 * @param {string} hookName  The name of the hook to modify.
 * @param {string} namespace The unique namespace identifying the callback in the
 *                           form `vendor/plugin/function`.
 *
 * @return {number | undefined} The number of callbacks removed.
 */

/**
 * Returns a function which, when invoked, will remove a specified hook or all
 * hooks by the given name.
 *
 * @param {import('.').Hooks}    hooks             Hooks instance.
 * @param {import('.').StoreKey} storeKey
 * @param {boolean}              [removeAll=false] Whether to remove all callbacks for a hookName,
 *                                                 without regard to namespace. Used to create
 *                                                 `removeAll*` functions.
 *
 * @return {RemoveHook} Function that removes hooks.
 */
function createRemoveHook(hooks, storeKey, removeAll = false) {
  return function removeHook(hookName, namespace) {
    const hooksStore = hooks[storeKey];
    if (!build_module_validateHookName(hookName)) {
      return;
    }
    if (!removeAll && !build_module_validateNamespace(namespace)) {
      return;
    }

    // Bail if no hooks exist by this name.
    if (!hooksStore[hookName]) {
      return 0;
    }
    let handlersRemoved = 0;
    if (removeAll) {
      handlersRemoved = hooksStore[hookName].handlers.length;
      hooksStore[hookName] = {
        runs: hooksStore[hookName].runs,
        handlers: []
      };
    } else {
      // Try to find the specified callback to remove.
      const handlers = hooksStore[hookName].handlers;
      for (let i = handlers.length - 1; i >= 0; i--) {
        if (handlers[i].namespace === namespace) {
          handlers.splice(i, 1);
          handlersRemoved++;
          // This callback may also be part of a hook that is
          // currently executing.  If the callback we're removing
          // comes after the current callback, there's no problem;
          // otherwise we need to decrease the execution index of any
          // other runs by 1 to account for the removed element.
          hooksStore.__current.forEach(hookInfo => {
            if (hookInfo.name === hookName && hookInfo.currentIndex >= i) {
              hookInfo.currentIndex--;
            }
          });
        }
      }
    }
    if (hookName !== 'hookRemoved') {
      hooks.doAction('hookRemoved', hookName, namespace);
    }
    return handlersRemoved;
  };
}
/* harmony default export */ const build_module_createRemoveHook = (createRemoveHook);
//# sourceMappingURL=createRemoveHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createHasHook.js
/**
 * @callback HasHook
 *
 * Returns whether any handlers are attached for the given hookName and optional namespace.
 *
 * @param {string} hookName    The name of the hook to check for.
 * @param {string} [namespace] Optional. The unique namespace identifying the callback
 *                             in the form `vendor/plugin/function`.
 *
 * @return {boolean} Whether there are handlers that are attached to the given hook.
 */
/**
 * Returns a function which, when invoked, will return whether any handlers are
 * attached to a particular hook.
 *
 * @param {import('.').Hooks}    hooks    Hooks instance.
 * @param {import('.').StoreKey} storeKey
 *
 * @return {HasHook} Function that returns whether any handlers are
 *                   attached to a particular hook and optional namespace.
 */
function createHasHook(hooks, storeKey) {
  return function hasHook(hookName, namespace) {
    const hooksStore = hooks[storeKey];

    // Use the namespace if provided.
    if ('undefined' !== typeof namespace) {
      return hookName in hooksStore && hooksStore[hookName].handlers.some(hook => hook.namespace === namespace);
    }
    return hookName in hooksStore;
  };
}
/* harmony default export */ const build_module_createHasHook = (createHasHook);
//# sourceMappingURL=createHasHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createRunHook.js
/**
 * Returns a function which, when invoked, will execute all callbacks
 * registered to a hook of the specified type, optionally returning the final
 * value of the call chain.
 *
 * @param {import('.').Hooks}    hooks          Hooks instance.
 * @param {import('.').StoreKey} storeKey
 * @param {boolean}              returnFirstArg Whether each hook callback is expected to return its first argument.
 * @param {boolean}              async          Whether the hook callback should be run asynchronously
 *
 * @return {(hookName:string, ...args: unknown[]) => undefined|unknown} Function that runs hook callbacks.
 */
function createRunHook(hooks, storeKey, returnFirstArg, async) {
  return function runHook(hookName, ...args) {
    const hooksStore = hooks[storeKey];
    if (!hooksStore[hookName]) {
      hooksStore[hookName] = {
        handlers: [],
        runs: 0
      };
    }
    hooksStore[hookName].runs++;
    const handlers = hooksStore[hookName].handlers;

    // The following code is stripped from production builds.
    if (false) {}
    if (!handlers || !handlers.length) {
      return returnFirstArg ? args[0] : undefined;
    }
    const hookInfo = {
      name: hookName,
      currentIndex: 0
    };
    async function asyncRunner() {
      try {
        hooksStore.__current.add(hookInfo);
        let result = returnFirstArg ? args[0] : undefined;
        while (hookInfo.currentIndex < handlers.length) {
          const handler = handlers[hookInfo.currentIndex];
          result = await handler.callback.apply(null, args);
          if (returnFirstArg) {
            args[0] = result;
          }
          hookInfo.currentIndex++;
        }
        return returnFirstArg ? result : undefined;
      } finally {
        hooksStore.__current.delete(hookInfo);
      }
    }
    function syncRunner() {
      try {
        hooksStore.__current.add(hookInfo);
        let result = returnFirstArg ? args[0] : undefined;
        while (hookInfo.currentIndex < handlers.length) {
          const handler = handlers[hookInfo.currentIndex];
          result = handler.callback.apply(null, args);
          if (returnFirstArg) {
            args[0] = result;
          }
          hookInfo.currentIndex++;
        }
        return returnFirstArg ? result : undefined;
      } finally {
        hooksStore.__current.delete(hookInfo);
      }
    }
    return (async ? asyncRunner : syncRunner)();
  };
}
/* harmony default export */ const build_module_createRunHook = (createRunHook);
//# sourceMappingURL=createRunHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createCurrentHook.js
/**
 * Returns a function which, when invoked, will return the name of the
 * currently running hook, or `null` if no hook of the given type is currently
 * running.
 *
 * @param {import('.').Hooks}    hooks    Hooks instance.
 * @param {import('.').StoreKey} storeKey
 *
 * @return {() => string | null} Function that returns the current hook name or null.
 */
function createCurrentHook(hooks, storeKey) {
  return function currentHook() {
    var _currentArray$at$name;
    const hooksStore = hooks[storeKey];
    const currentArray = Array.from(hooksStore.__current);
    return (_currentArray$at$name = currentArray.at(-1)?.name) !== null && _currentArray$at$name !== void 0 ? _currentArray$at$name : null;
  };
}
/* harmony default export */ const build_module_createCurrentHook = (createCurrentHook);
//# sourceMappingURL=createCurrentHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createDoingHook.js
/**
 * @callback DoingHook
 * Returns whether a hook is currently being executed.
 *
 * @param {string} [hookName] The name of the hook to check for.  If
 *                            omitted, will check for any hook being executed.
 *
 * @return {boolean} Whether the hook is being executed.
 */

/**
 * Returns a function which, when invoked, will return whether a hook is
 * currently being executed.
 *
 * @param {import('.').Hooks}    hooks    Hooks instance.
 * @param {import('.').StoreKey} storeKey
 *
 * @return {DoingHook} Function that returns whether a hook is currently
 *                     being executed.
 */
function createDoingHook(hooks, storeKey) {
  return function doingHook(hookName) {
    const hooksStore = hooks[storeKey];

    // If the hookName was not passed, check for any current hook.
    if ('undefined' === typeof hookName) {
      return hooksStore.__current.size > 0;
    }

    // Find if the `hookName` hook is in `__current`.
    return Array.from(hooksStore.__current).some(hook => hook.name === hookName);
  };
}
/* harmony default export */ const build_module_createDoingHook = (createDoingHook);
//# sourceMappingURL=createDoingHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createDidHook.js
/**
 * Internal dependencies
 */


/**
 * @callback DidHook
 *
 * Returns the number of times an action has been fired.
 *
 * @param {string} hookName The hook name to check.
 *
 * @return {number | undefined} The number of times the hook has run.
 */

/**
 * Returns a function which, when invoked, will return the number of times a
 * hook has been called.
 *
 * @param {import('.').Hooks}    hooks    Hooks instance.
 * @param {import('.').StoreKey} storeKey
 *
 * @return {DidHook} Function that returns a hook's call count.
 */
function createDidHook(hooks, storeKey) {
  return function didHook(hookName) {
    const hooksStore = hooks[storeKey];
    if (!build_module_validateHookName(hookName)) {
      return;
    }
    return hooksStore[hookName] && hooksStore[hookName].runs ? hooksStore[hookName].runs : 0;
  };
}
/* harmony default export */ const build_module_createDidHook = (createDidHook);
//# sourceMappingURL=createDidHook.js.map
;// ./node_modules/@wordpress/hooks/build-module/createHooks.js
/* wp:polyfill */
/**
 * Internal dependencies
 */








/**
 * Internal class for constructing hooks. Use `createHooks()` function
 *
 * Note, it is necessary to expose this class to make its type public.
 *
 * @private
 */
class _Hooks {
  constructor() {
    /** @type {import('.').Store} actions */
    this.actions = Object.create(null);
    this.actions.__current = new Set();

    /** @type {import('.').Store} filters */
    this.filters = Object.create(null);
    this.filters.__current = new Set();
    this.addAction = build_module_createAddHook(this, 'actions');
    this.addFilter = build_module_createAddHook(this, 'filters');
    this.removeAction = build_module_createRemoveHook(this, 'actions');
    this.removeFilter = build_module_createRemoveHook(this, 'filters');
    this.hasAction = build_module_createHasHook(this, 'actions');
    this.hasFilter = build_module_createHasHook(this, 'filters');
    this.removeAllActions = build_module_createRemoveHook(this, 'actions', true);
    this.removeAllFilters = build_module_createRemoveHook(this, 'filters', true);
    this.doAction = build_module_createRunHook(this, 'actions', false, false);
    this.doActionAsync = build_module_createRunHook(this, 'actions', false, true);
    this.applyFilters = build_module_createRunHook(this, 'filters', true, false);
    this.applyFiltersAsync = build_module_createRunHook(this, 'filters', true, true);
    this.currentAction = build_module_createCurrentHook(this, 'actions');
    this.currentFilter = build_module_createCurrentHook(this, 'filters');
    this.doingAction = build_module_createDoingHook(this, 'actions');
    this.doingFilter = build_module_createDoingHook(this, 'filters');
    this.didAction = build_module_createDidHook(this, 'actions');
    this.didFilter = build_module_createDidHook(this, 'filters');
  }
}

/** @typedef {_Hooks} Hooks */

/**
 * Returns an instance of the hooks object.
 *
 * @return {Hooks} A Hooks instance.
 */
function createHooks() {
  return new _Hooks();
}
/* harmony default export */ const build_module_createHooks = (createHooks);
//# sourceMappingURL=createHooks.js.map
;// ./node_modules/@wordpress/hooks/build-module/index.js
/**
 * Internal dependencies
 */


/** @typedef {(...args: any[])=>any} Callback */

/**
 * @typedef Handler
 * @property {Callback} callback  The callback
 * @property {string}   namespace The namespace
 * @property {number}   priority  The namespace
 */

/**
 * @typedef Hook
 * @property {Handler[]} handlers Array of handlers
 * @property {number}    runs     Run counter
 */

/**
 * @typedef Current
 * @property {string} name         Hook name
 * @property {number} currentIndex The index
 */

/**
 * @typedef {Record<string, Hook> & {__current: Set<Current>}} Store
 */

/**
 * @typedef {'actions' | 'filters'} StoreKey
 */

/**
 * @typedef {import('./createHooks').Hooks} Hooks
 */

const defaultHooks = build_module_createHooks();
const {
  addAction,
  addFilter,
  removeAction,
  removeFilter,
  hasAction,
  hasFilter,
  removeAllActions,
  removeAllFilters,
  doAction,
  doActionAsync,
  applyFilters,
  applyFiltersAsync,
  currentAction,
  currentFilter,
  doingAction,
  doingFilter,
  didAction,
  didFilter,
  actions,
  filters
} = defaultHooks;

//# sourceMappingURL=index.js.map
;// ./node_modules/tslib/tslib.es6.mjs
/******************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */
/* global Reflect, Promise, SuppressedError, Symbol, Iterator */

var extendStatics = function(d, b) {
  extendStatics = Object.setPrototypeOf ||
      ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
      function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
  return extendStatics(d, b);
};

function __extends(d, b) {
  if (typeof b !== "function" && b !== null)
      throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
  extendStatics(d, b);
  function __() { this.constructor = d; }
  d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
}

var __assign = function() {
  __assign = Object.assign || function __assign(t) {
      for (var s, i = 1, n = arguments.length; i < n; i++) {
          s = arguments[i];
          for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
      }
      return t;
  }
  return __assign.apply(this, arguments);
}

function __rest(s, e) {
  var t = {};
  for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
      t[p] = s[p];
  if (s != null && typeof Object.getOwnPropertySymbols === "function")
      for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
          if (e.indexOf(p[i]) < 0 && Object.prototype.propertyIsEnumerable.call(s, p[i]))
              t[p[i]] = s[p[i]];
      }
  return t;
}

function __decorate(decorators, target, key, desc) {
  var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
  if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
  else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
  return c > 3 && r && Object.defineProperty(target, key, r), r;
}

function __param(paramIndex, decorator) {
  return function (target, key) { decorator(target, key, paramIndex); }
}

function __esDecorate(ctor, descriptorIn, decorators, contextIn, initializers, extraInitializers) {
  function accept(f) { if (f !== void 0 && typeof f !== "function") throw new TypeError("Function expected"); return f; }
  var kind = contextIn.kind, key = kind === "getter" ? "get" : kind === "setter" ? "set" : "value";
  var target = !descriptorIn && ctor ? contextIn["static"] ? ctor : ctor.prototype : null;
  var descriptor = descriptorIn || (target ? Object.getOwnPropertyDescriptor(target, contextIn.name) : {});
  var _, done = false;
  for (var i = decorators.length - 1; i >= 0; i--) {
      var context = {};
      for (var p in contextIn) context[p] = p === "access" ? {} : contextIn[p];
      for (var p in contextIn.access) context.access[p] = contextIn.access[p];
      context.addInitializer = function (f) { if (done) throw new TypeError("Cannot add initializers after decoration has completed"); extraInitializers.push(accept(f || null)); };
      var result = (0, decorators[i])(kind === "accessor" ? { get: descriptor.get, set: descriptor.set } : descriptor[key], context);
      if (kind === "accessor") {
          if (result === void 0) continue;
          if (result === null || typeof result !== "object") throw new TypeError("Object expected");
          if (_ = accept(result.get)) descriptor.get = _;
          if (_ = accept(result.set)) descriptor.set = _;
          if (_ = accept(result.init)) initializers.unshift(_);
      }
      else if (_ = accept(result)) {
          if (kind === "field") initializers.unshift(_);
          else descriptor[key] = _;
      }
  }
  if (target) Object.defineProperty(target, contextIn.name, descriptor);
  done = true;
};

function __runInitializers(thisArg, initializers, value) {
  var useValue = arguments.length > 2;
  for (var i = 0; i < initializers.length; i++) {
      value = useValue ? initializers[i].call(thisArg, value) : initializers[i].call(thisArg);
  }
  return useValue ? value : void 0;
};

function __propKey(x) {
  return typeof x === "symbol" ? x : "".concat(x);
};

function __setFunctionName(f, name, prefix) {
  if (typeof name === "symbol") name = name.description ? "[".concat(name.description, "]") : "";
  return Object.defineProperty(f, "name", { configurable: true, value: prefix ? "".concat(prefix, " ", name) : name });
};

function __metadata(metadataKey, metadataValue) {
  if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(metadataKey, metadataValue);
}

function __awaiter(thisArg, _arguments, P, generator) {
  function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
  return new (P || (P = Promise))(function (resolve, reject) {
      function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
      function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
      function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
      step((generator = generator.apply(thisArg, _arguments || [])).next());
  });
}

function __generator(thisArg, body) {
  var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g = Object.create((typeof Iterator === "function" ? Iterator : Object).prototype);
  return g.next = verb(0), g["throw"] = verb(1), g["return"] = verb(2), typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
  function verb(n) { return function (v) { return step([n, v]); }; }
  function step(op) {
      if (f) throw new TypeError("Generator is already executing.");
      while (g && (g = 0, op[0] && (_ = 0)), _) try {
          if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
          if (y = 0, t) op = [op[0] & 2, t.value];
          switch (op[0]) {
              case 0: case 1: t = op; break;
              case 4: _.label++; return { value: op[1], done: false };
              case 5: _.label++; y = op[1]; op = [0]; continue;
              case 7: op = _.ops.pop(); _.trys.pop(); continue;
              default:
                  if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                  if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                  if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                  if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                  if (t[2]) _.ops.pop();
                  _.trys.pop(); continue;
          }
          op = body.call(thisArg, _);
      } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
      if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
  }
}

var __createBinding = Object.create ? (function(o, m, k, k2) {
  if (k2 === undefined) k2 = k;
  var desc = Object.getOwnPropertyDescriptor(m, k);
  if (!desc || ("get" in desc ? !m.__esModule : desc.writable || desc.configurable)) {
      desc = { enumerable: true, get: function() { return m[k]; } };
  }
  Object.defineProperty(o, k2, desc);
}) : (function(o, m, k, k2) {
  if (k2 === undefined) k2 = k;
  o[k2] = m[k];
});

function __exportStar(m, o) {
  for (var p in m) if (p !== "default" && !Object.prototype.hasOwnProperty.call(o, p)) __createBinding(o, m, p);
}

function __values(o) {
  var s = typeof Symbol === "function" && Symbol.iterator, m = s && o[s], i = 0;
  if (m) return m.call(o);
  if (o && typeof o.length === "number") return {
      next: function () {
          if (o && i >= o.length) o = void 0;
          return { value: o && o[i++], done: !o };
      }
  };
  throw new TypeError(s ? "Object is not iterable." : "Symbol.iterator is not defined.");
}

function __read(o, n) {
  var m = typeof Symbol === "function" && o[Symbol.iterator];
  if (!m) return o;
  var i = m.call(o), r, ar = [], e;
  try {
      while ((n === void 0 || n-- > 0) && !(r = i.next()).done) ar.push(r.value);
  }
  catch (error) { e = { error: error }; }
  finally {
      try {
          if (r && !r.done && (m = i["return"])) m.call(i);
      }
      finally { if (e) throw e.error; }
  }
  return ar;
}

/** @deprecated */
function __spread() {
  for (var ar = [], i = 0; i < arguments.length; i++)
      ar = ar.concat(__read(arguments[i]));
  return ar;
}

/** @deprecated */
function __spreadArrays() {
  for (var s = 0, i = 0, il = arguments.length; i < il; i++) s += arguments[i].length;
  for (var r = Array(s), k = 0, i = 0; i < il; i++)
      for (var a = arguments[i], j = 0, jl = a.length; j < jl; j++, k++)
          r[k] = a[j];
  return r;
}

function __spreadArray(to, from, pack) {
  if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
      if (ar || !(i in from)) {
          if (!ar) ar = Array.prototype.slice.call(from, 0, i);
          ar[i] = from[i];
      }
  }
  return to.concat(ar || Array.prototype.slice.call(from));
}

function __await(v) {
  return this instanceof __await ? (this.v = v, this) : new __await(v);
}

function __asyncGenerator(thisArg, _arguments, generator) {
  if (!Symbol.asyncIterator) throw new TypeError("Symbol.asyncIterator is not defined.");
  var g = generator.apply(thisArg, _arguments || []), i, q = [];
  return i = Object.create((typeof AsyncIterator === "function" ? AsyncIterator : Object).prototype), verb("next"), verb("throw"), verb("return", awaitReturn), i[Symbol.asyncIterator] = function () { return this; }, i;
  function awaitReturn(f) { return function (v) { return Promise.resolve(v).then(f, reject); }; }
  function verb(n, f) { if (g[n]) { i[n] = function (v) { return new Promise(function (a, b) { q.push([n, v, a, b]) > 1 || resume(n, v); }); }; if (f) i[n] = f(i[n]); } }
  function resume(n, v) { try { step(g[n](v)); } catch (e) { settle(q[0][3], e); } }
  function step(r) { r.value instanceof __await ? Promise.resolve(r.value.v).then(fulfill, reject) : settle(q[0][2], r); }
  function fulfill(value) { resume("next", value); }
  function reject(value) { resume("throw", value); }
  function settle(f, v) { if (f(v), q.shift(), q.length) resume(q[0][0], q[0][1]); }
}

function __asyncDelegator(o) {
  var i, p;
  return i = {}, verb("next"), verb("throw", function (e) { throw e; }), verb("return"), i[Symbol.iterator] = function () { return this; }, i;
  function verb(n, f) { i[n] = o[n] ? function (v) { return (p = !p) ? { value: __await(o[n](v)), done: false } : f ? f(v) : v; } : f; }
}

function __asyncValues(o) {
  if (!Symbol.asyncIterator) throw new TypeError("Symbol.asyncIterator is not defined.");
  var m = o[Symbol.asyncIterator], i;
  return m ? m.call(o) : (o = typeof __values === "function" ? __values(o) : o[Symbol.iterator](), i = {}, verb("next"), verb("throw"), verb("return"), i[Symbol.asyncIterator] = function () { return this; }, i);
  function verb(n) { i[n] = o[n] && function (v) { return new Promise(function (resolve, reject) { v = o[n](v), settle(resolve, reject, v.done, v.value); }); }; }
  function settle(resolve, reject, d, v) { Promise.resolve(v).then(function(v) { resolve({ value: v, done: d }); }, reject); }
}

function __makeTemplateObject(cooked, raw) {
  if (Object.defineProperty) { Object.defineProperty(cooked, "raw", { value: raw }); } else { cooked.raw = raw; }
  return cooked;
};

var __setModuleDefault = Object.create ? (function(o, v) {
  Object.defineProperty(o, "default", { enumerable: true, value: v });
}) : function(o, v) {
  o["default"] = v;
};

function __importStar(mod) {
  if (mod && mod.__esModule) return mod;
  var result = {};
  if (mod != null) for (var k in mod) if (k !== "default" && Object.prototype.hasOwnProperty.call(mod, k)) __createBinding(result, mod, k);
  __setModuleDefault(result, mod);
  return result;
}

function __importDefault(mod) {
  return (mod && mod.__esModule) ? mod : { default: mod };
}

function __classPrivateFieldGet(receiver, state, kind, f) {
  if (kind === "a" && !f) throw new TypeError("Private accessor was defined without a getter");
  if (typeof state === "function" ? receiver !== state || !f : !state.has(receiver)) throw new TypeError("Cannot read private member from an object whose class did not declare it");
  return kind === "m" ? f : kind === "a" ? f.call(receiver) : f ? f.value : state.get(receiver);
}

function __classPrivateFieldSet(receiver, state, value, kind, f) {
  if (kind === "m") throw new TypeError("Private method is not writable");
  if (kind === "a" && !f) throw new TypeError("Private accessor was defined without a setter");
  if (typeof state === "function" ? receiver !== state || !f : !state.has(receiver)) throw new TypeError("Cannot write private member to an object whose class did not declare it");
  return (kind === "a" ? f.call(receiver, value) : f ? f.value = value : state.set(receiver, value)), value;
}

function __classPrivateFieldIn(state, receiver) {
  if (receiver === null || (typeof receiver !== "object" && typeof receiver !== "function")) throw new TypeError("Cannot use 'in' operator on non-object");
  return typeof state === "function" ? receiver === state : state.has(receiver);
}

function __addDisposableResource(env, value, async) {
  if (value !== null && value !== void 0) {
    if (typeof value !== "object" && typeof value !== "function") throw new TypeError("Object expected.");
    var dispose, inner;
    if (async) {
      if (!Symbol.asyncDispose) throw new TypeError("Symbol.asyncDispose is not defined.");
      dispose = value[Symbol.asyncDispose];
    }
    if (dispose === void 0) {
      if (!Symbol.dispose) throw new TypeError("Symbol.dispose is not defined.");
      dispose = value[Symbol.dispose];
      if (async) inner = dispose;
    }
    if (typeof dispose !== "function") throw new TypeError("Object not disposable.");
    if (inner) dispose = function() { try { inner.call(this); } catch (e) { return Promise.reject(e); } };
    env.stack.push({ value: value, dispose: dispose, async: async });
  }
  else if (async) {
    env.stack.push({ async: true });
  }
  return value;
}

var _SuppressedError = typeof SuppressedError === "function" ? SuppressedError : function (error, suppressed, message) {
  var e = new Error(message);
  return e.name = "SuppressedError", e.error = error, e.suppressed = suppressed, e;
};

function __disposeResources(env) {
  function fail(e) {
    env.error = env.hasError ? new _SuppressedError(e, env.error, "An error was suppressed during disposal.") : e;
    env.hasError = true;
  }
  var r, s = 0;
  function next() {
    while (r = env.stack.pop()) {
      try {
        if (!r.async && s === 1) return s = 0, env.stack.push(r), Promise.resolve().then(next);
        if (r.dispose) {
          var result = r.dispose.call(r.value);
          if (r.async) return s |= 2, Promise.resolve(result).then(next, function(e) { fail(e); return next(); });
        }
        else s |= 1;
      }
      catch (e) {
        fail(e);
      }
    }
    if (s === 1) return env.hasError ? Promise.reject(env.error) : Promise.resolve();
    if (env.hasError) throw env.error;
  }
  return next();
}

function __rewriteRelativeImportExtension(path, preserveJsx) {
  if (typeof path === "string" && /^\.\.?\//.test(path)) {
      return path.replace(/\.(tsx)$|((?:\.d)?)((?:\.[^./]+?)?)\.([cm]?)ts$/i, function (m, tsx, d, ext, cm) {
          return tsx ? preserveJsx ? ".jsx" : ".js" : d && (!ext || !cm) ? m : (d + ext + "." + cm.toLowerCase() + "js");
      });
  }
  return path;
}

/* harmony default export */ const tslib_es6 = ({
  __extends,
  __assign,
  __rest,
  __decorate,
  __param,
  __esDecorate,
  __runInitializers,
  __propKey,
  __setFunctionName,
  __metadata,
  __awaiter,
  __generator,
  __createBinding,
  __exportStar,
  __values,
  __read,
  __spread,
  __spreadArrays,
  __spreadArray,
  __await,
  __asyncGenerator,
  __asyncDelegator,
  __asyncValues,
  __makeTemplateObject,
  __importStar,
  __importDefault,
  __classPrivateFieldGet,
  __classPrivateFieldSet,
  __classPrivateFieldIn,
  __addDisposableResource,
  __disposeResources,
  __rewriteRelativeImportExtension,
});

;// ./node_modules/lower-case/dist.es2015/index.js
/**
 * Source: ftp://ftp.unicode.org/Public/UCD/latest/ucd/SpecialCasing.txt
 */
var SUPPORTED_LOCALE = {
    tr: {
        regexp: /\u0130|\u0049|\u0049\u0307/g,
        map: {
            İ: "\u0069",
            I: "\u0131",
            İ: "\u0069",
        },
    },
    az: {
        regexp: /\u0130/g,
        map: {
            İ: "\u0069",
            I: "\u0131",
            İ: "\u0069",
        },
    },
    lt: {
        regexp: /\u0049|\u004A|\u012E|\u00CC|\u00CD|\u0128/g,
        map: {
            I: "\u0069\u0307",
            J: "\u006A\u0307",
            Į: "\u012F\u0307",
            Ì: "\u0069\u0307\u0300",
            Í: "\u0069\u0307\u0301",
            Ĩ: "\u0069\u0307\u0303",
        },
    },
};
/**
 * Localized lower case.
 */
function localeLowerCase(str, locale) {
    var lang = SUPPORTED_LOCALE[locale.toLowerCase()];
    if (lang)
        return lowerCase(str.replace(lang.regexp, function (m) { return lang.map[m]; }));
    return lowerCase(str);
}
/**
 * Lower case as a function.
 */
function lowerCase(str) {
    return str.toLowerCase();
}
//# sourceMappingURL=index.js.map
;// ./node_modules/no-case/dist.es2015/index.js

// Support camel case ("camelCase" -> "camel Case" and "CAMELCase" -> "CAMEL Case").
var DEFAULT_SPLIT_REGEXP = [/([a-z0-9])([A-Z])/g, /([A-Z])([A-Z][a-z])/g];
// Remove all non-word characters.
var DEFAULT_STRIP_REGEXP = /[^A-Z0-9]+/gi;
/**
 * Normalize the string into something other libraries can manipulate easier.
 */
function noCase(input, options) {
    if (options === void 0) { options = {}; }
    var _a = options.splitRegexp, splitRegexp = _a === void 0 ? DEFAULT_SPLIT_REGEXP : _a, _b = options.stripRegexp, stripRegexp = _b === void 0 ? DEFAULT_STRIP_REGEXP : _b, _c = options.transform, transform = _c === void 0 ? lowerCase : _c, _d = options.delimiter, delimiter = _d === void 0 ? " " : _d;
    var result = replace(replace(input, splitRegexp, "$1\0$2"), stripRegexp, "\0");
    var start = 0;
    var end = result.length;
    // Trim the delimiter from around the output string.
    while (result.charAt(start) === "\0")
        start++;
    while (result.charAt(end - 1) === "\0")
        end--;
    // Transform each token independently.
    return result.slice(start, end).split("\0").map(transform).join(delimiter);
}
/**
 * Replace `re` in the input string with the replacement value.
 */
function replace(input, re, value) {
    if (re instanceof RegExp)
        return input.replace(re, value);
    return re.reduce(function (input, re) { return input.replace(re, value); }, input);
}
//# sourceMappingURL=index.js.map
;// ./node_modules/pascal-case/dist.es2015/index.js


function pascalCaseTransform(input, index) {
    var firstChar = input.charAt(0);
    var lowerChars = input.substr(1).toLowerCase();
    if (index > 0 && firstChar >= "0" && firstChar <= "9") {
        return "_" + firstChar + lowerChars;
    }
    return "" + firstChar.toUpperCase() + lowerChars;
}
function pascalCaseTransformMerge(input) {
    return input.charAt(0).toUpperCase() + input.slice(1).toLowerCase();
}
function pascalCase(input, options) {
    if (options === void 0) { options = {}; }
    return noCase(input, __assign({ delimiter: "", transform: pascalCaseTransform }, options));
}
//# sourceMappingURL=index.js.map
;// ./node_modules/@wordpress/compose/build-module/utils/create-higher-order-component/index.js
/**
 * External dependencies
 */

/**
 * Given a function mapping a component to an enhanced component and modifier
 * name, returns the enhanced component augmented with a generated displayName.
 *
 * @param mapComponent Function mapping component to enhanced component.
 * @param modifierName Seed name from which to generated display name.
 *
 * @return Component class with generated display name assigned.
 */
function createHigherOrderComponent(mapComponent, modifierName) {
  return Inner => {
    const Outer = mapComponent(Inner);
    Outer.displayName = hocName(modifierName, Inner);
    return Outer;
  };
}

/**
 * Returns a displayName for a higher-order component, given a wrapper name.
 *
 * @example
 *     hocName( 'MyMemo', Widget ) === 'MyMemo(Widget)';
 *     hocName( 'MyMemo', <div /> ) === 'MyMemo(Component)';
 *
 * @param name  Name assigned to higher-order component's wrapper component.
 * @param Inner Wrapped component inside higher-order component.
 * @return       Wrapped name of higher-order component.
 */
const hocName = (name, Inner) => {
  const inner = Inner.displayName || Inner.name || 'Component';
  const outer = pascalCase(name !== null && name !== void 0 ? name : '');
  return `${outer}(${inner})`;
};
//# sourceMappingURL=index.js.map
;// ./node_modules/@wordpress/compose/build-module/utils/debounce/index.js
/**
 * Parts of this source were derived and modified from lodash,
 * released under the MIT license.
 *
 * https://github.com/lodash/lodash
 *
 * Copyright JS Foundation and other contributors <https://js.foundation/>
 *
 * Based on Underscore.js, copyright Jeremy Ashkenas,
 * DocumentCloud and Investigative Reporters & Editors <http://underscorejs.org/>
 *
 * This software consists of voluntary contributions made by many
 * individuals. For exact contribution history, see the revision history
 * available at https://github.com/lodash/lodash
 *
 * The following license applies to all parts of this software except as
 * documented below:
 *
 * ====
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * A simplified and properly typed version of lodash's `debounce`, that
 * always uses timers instead of sometimes using rAF.
 *
 * Creates a debounced function that delays invoking `func` until after `wait`
 * milliseconds have elapsed since the last time the debounced function was
 * invoked. The debounced function comes with a `cancel` method to cancel delayed
 * `func` invocations and a `flush` method to immediately invoke them. Provide
 * `options` to indicate whether `func` should be invoked on the leading and/or
 * trailing edge of the `wait` timeout. The `func` is invoked with the last
 * arguments provided to the debounced function. Subsequent calls to the debounced
 * function return the result of the last `func` invocation.
 *
 * **Note:** If `leading` and `trailing` options are `true`, `func` is
 * invoked on the trailing edge of the timeout only if the debounced function
 * is invoked more than once during the `wait` timeout.
 *
 * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
 * until the next tick, similar to `setTimeout` with a timeout of `0`.
 *
 * @param {Function}                   func             The function to debounce.
 * @param {number}                     wait             The number of milliseconds to delay.
 * @param {Partial< DebounceOptions >} options          The options object.
 * @param {boolean}                    options.leading  Specify invoking on the leading edge of the timeout.
 * @param {number}                     options.maxWait  The maximum time `func` is allowed to be delayed before it's invoked.
 * @param {boolean}                    options.trailing Specify invoking on the trailing edge of the timeout.
 *
 * @return Returns the new debounced function.
 */
const debounce = (func, wait, options) => {
  let lastArgs;
  let lastThis;
  let maxWait = 0;
  let result;
  let timerId;
  let lastCallTime;
  let lastInvokeTime = 0;
  let leading = false;
  let maxing = false;
  let trailing = true;
  if (options) {
    leading = !!options.leading;
    maxing = 'maxWait' in options;
    if (options.maxWait !== undefined) {
      maxWait = Math.max(options.maxWait, wait);
    }
    trailing = 'trailing' in options ? !!options.trailing : trailing;
  }
  function invokeFunc(time) {
    const args = lastArgs;
    const thisArg = lastThis;
    lastArgs = undefined;
    lastThis = undefined;
    lastInvokeTime = time;
    result = func.apply(thisArg, args);
    return result;
  }
  function startTimer(pendingFunc, waitTime) {
    timerId = setTimeout(pendingFunc, waitTime);
  }
  function cancelTimer() {
    if (timerId !== undefined) {
      clearTimeout(timerId);
    }
  }
  function leadingEdge(time) {
    // Reset any `maxWait` timer.
    lastInvokeTime = time;
    // Start the timer for the trailing edge.
    startTimer(timerExpired, wait);
    // Invoke the leading edge.
    return leading ? invokeFunc(time) : result;
  }
  function getTimeSinceLastCall(time) {
    return time - (lastCallTime || 0);
  }
  function remainingWait(time) {
    const timeSinceLastCall = getTimeSinceLastCall(time);
    const timeSinceLastInvoke = time - lastInvokeTime;
    const timeWaiting = wait - timeSinceLastCall;
    return maxing ? Math.min(timeWaiting, maxWait - timeSinceLastInvoke) : timeWaiting;
  }
  function shouldInvoke(time) {
    const timeSinceLastCall = getTimeSinceLastCall(time);
    const timeSinceLastInvoke = time - lastInvokeTime;

    // Either this is the first call, activity has stopped and we're at the
    // trailing edge, the system time has gone backwards and we're treating
    // it as the trailing edge, or we've hit the `maxWait` limit.
    return lastCallTime === undefined || timeSinceLastCall >= wait || timeSinceLastCall < 0 || maxing && timeSinceLastInvoke >= maxWait;
  }
  function timerExpired() {
    const time = Date.now();
    if (shouldInvoke(time)) {
      return trailingEdge(time);
    }
    // Restart the timer.
    startTimer(timerExpired, remainingWait(time));
    return undefined;
  }
  function clearTimer() {
    timerId = undefined;
  }
  function trailingEdge(time) {
    clearTimer();

    // Only invoke if we have `lastArgs` which means `func` has been
    // debounced at least once.
    if (trailing && lastArgs) {
      return invokeFunc(time);
    }
    lastArgs = lastThis = undefined;
    return result;
  }
  function cancel() {
    cancelTimer();
    lastInvokeTime = 0;
    clearTimer();
    lastArgs = lastCallTime = lastThis = undefined;
  }
  function flush() {
    return pending() ? trailingEdge(Date.now()) : result;
  }
  function pending() {
    return timerId !== undefined;
  }
  function debounced(...args) {
    const time = Date.now();
    const isInvoking = shouldInvoke(time);
    lastArgs = args;
    lastThis = this;
    lastCallTime = time;
    if (isInvoking) {
      if (!pending()) {
        return leadingEdge(lastCallTime);
      }
      if (maxing) {
        // Handle invocations in a tight loop.
        startTimer(timerExpired, wait);
        return invokeFunc(lastCallTime);
      }
    }
    if (!pending()) {
      startTimer(timerExpired, wait);
    }
    return result;
  }
  debounced.cancel = cancel;
  debounced.flush = flush;
  debounced.pending = pending;
  return debounced;
};
//# sourceMappingURL=index.js.map
// EXTERNAL MODULE: ./node_modules/react/jsx-runtime.js
var jsx_runtime = __webpack_require__(848);
;// ./node_modules/@wordpress/components/build-module/higher-order/with-filters/index.js
/**
 * WordPress dependencies
 */




const ANIMATION_FRAME_PERIOD = 16;

/**
 * Creates a higher-order component which adds filtering capability to the
 * wrapped component. Filters get applied when the original component is about
 * to be mounted. When a filter is added or removed that matches the hook name,
 * the wrapped component re-renders.
 *
 * @param hookName Hook name exposed to be used by filters.
 *
 * @return Higher-order component factory.
 *
 * ```jsx
 * import { withFilters } from '@wordpress/components';
 * import { addFilter } from '@wordpress/hooks';
 *
 * const MyComponent = ( { title } ) => <h1>{ title }</h1>;
 *
 * const ComponentToAppend = () => <div>Appended component</div>;
 *
 * function withComponentAppended( FilteredComponent ) {
 * 	return ( props ) => (
 * 		<>
 * 			<FilteredComponent { ...props } />
 * 			<ComponentToAppend />
 * 		</>
 * 	);
 * }
 *
 * addFilter(
 * 	'MyHookName',
 * 	'my-plugin/with-component-appended',
 * 	withComponentAppended
 * );
 *
 * const MyComponentWithFilters = withFilters( 'MyHookName' )( MyComponent );
 * ```
 */
function withFilters(hookName) {
  return createHigherOrderComponent(OriginalComponent => {
    const namespace = 'core/with-filters/' + hookName;

    /**
     * The component definition with current filters applied. Each instance
     * reuse this shared reference as an optimization to avoid excessive
     * calls to `applyFilters` when many instances exist.
     */
    let FilteredComponent;

    /**
     * Initializes the FilteredComponent variable once, if not already
     * assigned. Subsequent calls are effectively a noop.
     */
    function ensureFilteredComponent() {
      if (FilteredComponent === undefined) {
        FilteredComponent = applyFilters(hookName, OriginalComponent);
      }
    }
    class FilteredComponentRenderer extends react.Component {
      constructor(props) {
        super(props);
        ensureFilteredComponent();
      }
      componentDidMount() {
        FilteredComponentRenderer.instances.push(this);

        // If there were previously no mounted instances for components
        // filtered on this hook, add the hook handler.
        if (FilteredComponentRenderer.instances.length === 1) {
          addAction('hookRemoved', namespace, onHooksUpdated);
          addAction('hookAdded', namespace, onHooksUpdated);
        }
      }
      componentWillUnmount() {
        FilteredComponentRenderer.instances = FilteredComponentRenderer.instances.filter(instance => instance !== this);

        // If this was the last of the mounted components filtered on
        // this hook, remove the hook handler.
        if (FilteredComponentRenderer.instances.length === 0) {
          removeAction('hookRemoved', namespace);
          removeAction('hookAdded', namespace);
        }
      }
      render() {
        return /*#__PURE__*/(0,jsx_runtime.jsx)(FilteredComponent, {
          ...this.props
        });
      }
    }
    FilteredComponentRenderer.instances = [];

    /**
     * Updates the FilteredComponent definition, forcing a render for each
     * mounted instance. This occurs a maximum of once per animation frame.
     */
    const throttledForceUpdate = debounce(() => {
      // Recreate the filtered component, only after delay so that it's
      // computed once, even if many filters added.
      FilteredComponent = applyFilters(hookName, OriginalComponent);

      // Force each instance to render.
      FilteredComponentRenderer.instances.forEach(instance => {
        instance.forceUpdate();
      });
    }, ANIMATION_FRAME_PERIOD);

    /**
     * When a filter is added or removed for the matching hook name, each
     * mounted instance should re-render with the new filters having been
     * applied to the original component.
     *
     * @param updatedHookName Name of the hook that was updated.
     */
    function onHooksUpdated(updatedHookName) {
      if (updatedHookName === hookName) {
        throttledForceUpdate();
      }
    }
    return FilteredComponentRenderer;
  }, 'withFilters');
}
//# sourceMappingURL=index.js.map
;// ./assets/src/js/components/edit.js
function edit_extends() { return edit_extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, edit_extends.apply(null, arguments); }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
/**
 * Internal dependencies
 */





/**
 * WordPress dependencies
 */
var edit_ = wp.i18n.__;
var edit_wp$element = wp.element,
  edit_Fragment = edit_wp$element.Fragment,
  edit_useEffect = edit_wp$element.useEffect,
  useState = edit_wp$element.useState;
var withSelect = wp.data.withSelect;
var edit_wp$components = wp.components,
  edit_Button = edit_wp$components.Button,
  Spinner = edit_wp$components.Spinner,
  ToolbarGroup = edit_wp$components.ToolbarGroup,
  ToolbarItem = edit_wp$components.ToolbarItem;
var BlockControls = wp.blockEditor.BlockControls;
var compose = wp.compose.compose;
var ModulaEdit = function ModulaEdit(props) {
  var attributes = props.attributes,
    galleries = props.galleries,
    setAttributes = props.setAttributes;
  var id = attributes.id,
    images = attributes.images,
    status = attributes.status,
    settings = attributes.settings,
    jsConfig = attributes.jsConfig,
    galleryId = attributes.galleryId,
    currentGallery = attributes.currentGallery,
    currentSelectize = attributes.currentSelectize;

  // Check when the alignmnent is changed so we can resize the instance
  var _useState = useState(props.attributes.align),
    _useState2 = _slicedToArray(_useState, 2),
    alignmentCheck = _useState2[0],
    setAlignment = _useState2[1];

  // Check when id is changed and it is not a component rerender . Saves unnecessary fetch requests
  var _useState3 = useState(id),
    _useState4 = _slicedToArray(_useState3, 2),
    idCheck = _useState4[0],
    setIdCheck = _useState4[1];
  edit_useEffect(function () {
    if (id !== 0) {
      _onIdChange(id);
    }
  }, []);
  edit_useEffect(function () {
    //Grab the instance and set it as atribute to access it when we want
    jQuery(document).on('modula_api_after_init', function (event, inst) {
      props.setAttributes({
        instance: inst
      });
    });
    if (props.attributes.instance != undefined && settings != undefined && settings.type == 'grid') {
      props.attributes.instance.reset(props.attributes.instance);
    }
  });
  var _onIdChange = function onIdChange(id) {
    if (isNaN(id) || '' == id) {
      return;
    }
    id = parseInt(id);
    wp.apiFetch({
      path: "wp/v2/modula-gallery/".concat(id)
    }).then(function (res) {
      setAttributes({
        currentGallery: res
      });
      setAttributes({
        currentSelectize: [{
          value: id,
          label: '' === res.title.rendered ? "Unnamed" : escapeHtml(res.title.rendered)
        }]
      });
      setAttributes({
        id: id,
        images: res.modulaImages
      });
      if (idCheck != id || undefined == settings) {
        getSettings(id);
      }
    });
  };
  function escapeHtml(text) {
    return text.replace('&#8217;', "'").replace('&#8220;', '"').replace('&#8216;', "'");
  }
  var getSettings = function getSettings(id) {
    fetch("".concat(modulaVars.restURL, "wp/v2/modula-gallery/").concat(id)).then(function (res) {
      return res.json();
    }).then(function (result) {
      var settings = result;
      setAttributes({
        status: 'loading'
      });
      jQuery.ajax({
        type: 'POST',
        data: {
          action: 'modula_get_jsconfig',
          nonce: modulaVars.nonce,
          settings: settings.modulaSettings
        },
        url: modulaVars.ajaxURL,
        success: function success(result) {
          var galleryId = Math.floor(Math.random() * 999);
          setAttributes({
            galleryId: galleryId,
            settings: settings.modulaSettings,
            jsConfig: result,
            status: 'ready'
          });
        }
      });
    });
  };
  var modulaRun = function modulaRun(checker) {
    if (checker != undefined) {
      setAttributes({
        status: 'ready'
      });
      var modulaGalleries = jQuery('.modula.modula-gallery');
      jQuery.each(modulaGalleries, function () {
        var modulaID = jQuery(this).attr('id'),
          modulaSettings = jQuery(this).data('config');
        modulaSettings.lazyLoad = 0;
        jQuery(this).modulaGallery(modulaSettings);
      });
    }
  };
  var modulaCarouselRun = function modulaCarouselRun(id) {
    id = "jtg-".concat(id);
    setAttributes({
      status: 'ready'
    });
    var modulaSliders = jQuery('.modula-slider');
    if (modulaSliders.length > 0 && 'function' == typeof ModulaCarousel) {
      var config = jQuery("#".concat(id)).data('config'),
        main = jQuery("#".concat(id)).find('.modula-items');
      new ModulaCarousel(main[0], config.slider_settings);
    } else if (modulaSliders.length > 0 && 'undefined' != typeof jQuery.fn.slick) {
      var _config = jQuery("#".concat(id)).data('config'),
        _main = jQuery("#".concat(id)).find('.modula-items');
      _main.slick(_config.slider_settings);
    }
  };
  var checkHoverEffect = function checkHoverEffect(effect) {
    jQuery.ajax({
      type: 'POST',
      data: {
        action: 'modula_check_hover_effect',
        nonce: modulaVars.nonce,
        effect: effect
      },
      url: modulaVars.ajaxURL,
      success: function success(result) {
        setAttributes({
          effectCheck: result
        });
      }
    });
  };
  var selectOptions = function selectOptions() {
    var options = [{
      value: 0,
      label: edit_('select a gallery', 'modula-best-grid-gallery')
    }];
    galleries.forEach(function (_ref) {
      var title = _ref.title,
        id = _ref.id;
      if (title.rendered.length == 0) {
        options.push({
          value: id,
          label: edit_('Unnamed Gallery', 'modula-best-grid-gallery') + id
        });
      } else {
        options.push({
          value: id,
          label: title.rendered
        });
      }
    });
    return options;
  };
  var blockControls = /*#__PURE__*/React.createElement(BlockControls, null, images && images.length > 0 && /*#__PURE__*/React.createElement(ToolbarGroup, null, /*#__PURE__*/React.createElement(ToolbarItem, null, /*#__PURE__*/React.createElement(edit_Button, {
    label: edit_('Edit gallery', 'modula-best-grid-gallery'),
    icon: "edit",
    href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
    target: "_blank"
  }))));
  if (id == 0 && 'none' === attributes.galleryType) {
    return /*#__PURE__*/React.createElement(edit_Fragment, null, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__content"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__logo"
    }), /*#__PURE__*/React.createElement("div", {
      className: "modula-button-group"
    }, galleries.length == 0 && /*#__PURE__*/React.createElement("p", null, ' ', edit_('Sorry no galleries found', 'modula-best-grid-gallery'), ' '), galleries.length > 0 && /*#__PURE__*/React.createElement(edit_Button, {
      className: "modula-button",
      target: "_blank",
      onClick: function onClick(e) {
        setAttributes({
          status: 'ready',
          id: 0,
          galleryType: 'gallery'
        });
      }
    }, edit_('Display An Existing Gallery', 'modula-best-grid-gallery'), utils_icons.chevronRightFancy), !attributes.proInstalled && galleries.length > 0 && /*#__PURE__*/React.createElement(edit_Button, {
      href: "https://wp-modula.com/pricing/?utm_source=modula-lite&utm_campaign=upsell",
      className: "modula-button-upsell",
      isSecondary: true,
      target: "_blank"
    }, edit_('Upgrade to PRO to create galleries using a preset ( fastest way )', 'modula-best-grid-gallery'))))));
  }
  if (status === 'loading') {
    return /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__content"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__logo"
    }), /*#__PURE__*/React.createElement(Spinner, null)));
  }
  if (id == 0 || images.length === 0) {
    return /*#__PURE__*/React.createElement(edit_Fragment, {
      key: "233"
    }, /*#__PURE__*/React.createElement(inspector, edit_extends({
      onIdChange: function onIdChange(id) {
        return _onIdChange(id);
      },
      selectOptions: selectOptions
    }, props)), /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__content"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__logo"
    }), galleries.length > 0 && /*#__PURE__*/React.createElement(edit_Fragment, null, /*#__PURE__*/React.createElement(components_ModulaGallerySearch, {
      id: id,
      key: id,
      value: id,
      options: currentSelectize,
      onIdChange: _onIdChange,
      galleries: galleries
    }), id != 0 && /*#__PURE__*/React.createElement(edit_Button, {
      target: "_blank",
      href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
      isPrimary: true
    }, edit_('Edit Gallery'))))));
  }
  if (settings) {
    return /*#__PURE__*/React.createElement(edit_Fragment, {
      key: "1"
    }, blockControls, /*#__PURE__*/React.createElement(inspector, edit_extends({
      onIdChange: function onIdChange(id) {
        _onIdChange(id);
      }
    }, props)), /*#__PURE__*/React.createElement(components_ModulaGallery, edit_extends({}, props, {
      settings: settings,
      jsConfig: jsConfig,
      modulaRun: modulaRun,
      modulaCarouselRun: modulaCarouselRun,
      checkHoverEffect: checkHoverEffect,
      galleryId: galleryId
    })));
  }
  return null;
};
var applyWithSelect = withSelect(function (select, props) {
  var _select = select('core'),
    getEntityRecords = _select.getEntityRecords;
  var query = {
    post_status: 'publish',
    per_page: 5
  };
  return {
    galleries: getEntityRecords('postType', 'modula-gallery', query) || []
  };
});
var applyWithFilters = withFilters('modula.ModulaEdit')(ModulaEdit);
/* harmony default export */ const edit = (compose(applyWithSelect)(ModulaEdit));
;// ./assets/src/js/wp-modula-gutenberg.js
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * Internal dependencies
 */


// import style from '../scss/modula-gutenberg.scss';

/**
 * WordPress dependencies
 */
var wp_modula_gutenberg_ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var ModulaGutenberg = /*#__PURE__*/function () {
  function ModulaGutenberg() {
    _classCallCheck(this, ModulaGutenberg);
    this.registerBlock();
  }
  return _createClass(ModulaGutenberg, [{
    key: "registerBlock",
    value: function registerBlock() {
      this.blockName = 'modula/gallery';
      this.blockAttributes = {
        id: {
          type: 'number',
          "default": 0
        },
        images: {
          type: 'array',
          "default": []
        },
        status: {
          type: 'string',
          "default": 'ready'
        },
        galleryId: {
          type: 'number',
          "default": 0
        },
        defaultSettings: {
          type: 'object',
          "default": []
        },
        galleryType: {
          type: 'string',
          "default": 'none'
        },
        // Attribute for current gallery
        currentGallery: {
          type: 'object',
          "default": {}
        },
        // Attribute for current gallery option in selectize
        currentSelectize: {
          type: 'array',
          "default": []
        },
        proInstalled: {
          type: 'boolean',
          "default": 'true' === modulaVars.proInstalled
        }
      };
      registerBlockType(this.blockName, {
        title: modulaVars.gutenbergTitle,
        icon: utils_icons.modula,
        description: wp_modula_gutenberg_('Make your galleries stand out.', 'modula-best-grid-gallery'),
        keywords: [wp_modula_gutenberg_('gallery'), wp_modula_gutenberg_('modula'), wp_modula_gutenberg_('images')],
        category: 'common',
        supports: {
          align: true,
          customClassName: false
        },
        attributes: this.blockAttributes,
        // getEditWrapperProps() {
        // 	return {
        // 		'data-align': 'full'
        // 	};
        // },
        edit: edit,
        save: function save() {
          // Rendering in PHP
          return null;
        }
      });
    }
  }]);
}();
var modulaGutenberg = new ModulaGutenberg();
/******/ })()
;