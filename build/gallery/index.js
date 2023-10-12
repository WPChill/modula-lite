/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/gallery/edit.js":
/*!********************************!*\
  !*** ./blocks/gallery/edit.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Edit: function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./blocks/gallery/editor.scss");


const {
  Fragment,
  useEffect,
  useState
} = wp.element;
const {
  withSelect
} = wp.data;
const {
  Button,
  Spinner,
  ToolbarGroup,
  ToolbarItem
} = wp.components;
const {
  BlockControls
} = wp.blockEditor;
const {
  compose
} = wp.compose;


function Edit(props) {
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)();
  const {
    attributes,
    galleries,
    setAttributes
  } = props;
  const {
    id,
    images,
    status,
    settings,
    jsConfig,
    galleryId,
    currentGallery,
    currentSelectize
  } = attributes;

  // Check when the alignmnent is changed so we can resize the instance
  const [alignmentCheck, setAlignment] = useState(props.attributes.align);

  // Check when id is changed and it is not a component rerender . Saves unnecessary fetch requests
  const [idCheck, setIdCheck] = useState(id);
  useEffect(() => {
    if (id !== 0) {
      onIdChange(id);
    }
  }, []);
  useEffect(() => {
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
  const onIdChange = id => {
    if (isNaN(id) || '' == id) {
      return;
    }
    id = parseInt(id);
    wp.apiFetch({
      path: `wp/v2/modula-gallery/${id}`
    }).then(res => {
      setAttributes({
        currentGallery: res
      });
      setAttributes({
        currentSelectize: [{
          value: id,
          label: '' === res.title.rendered ? `Unnamed` : escapeHtml(res.title.rendered)
        }]
      });
      jQuery.ajax({
        type: 'POST',
        data: {
          action: 'modula_get_gallery_meta',
          id: id,
          nonce: modulaVars.nonce
        },
        url: modulaVars.ajaxURL,
        success: result => onGalleryLoaded(id, result)
      });
    });
  };
  function escapeHtml(text) {
    return text.replace('&#8217;', "'").replace('&#8220;', '"').replace('&#8216;', "'");
  }
  const onGalleryLoaded = (id, result) => {
    if (result.success === false) {
      setAttributes({
        id: id,
        status: 'ready'
      });
      return;
    }
    if (idCheck != id || undefined == settings) {
      getSettings(id);
    }
    setAttributes({
      id: id,
      images: result,
      status: 'ready'
    });
  };
  const getSettings = id => {
    fetch(`${modulaVars.restURL}wp/v2/modula-gallery/${id}`).then(res => res.json()).then(result => {
      let settings = result;
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
        success: result => {
          let galleryId = Math.floor(Math.random() * 999);
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
  const modulaRun = checker => {
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
  const modulaSlickRun = id => {
    id = `jtg-${id}`;
    setAttributes({
      status: 'ready'
    });
    const modulaSliders = jQuery('.modula-slider');
    if (modulaSliders.length > 0 && 'undefined' != typeof jQuery.fn.slick) {
      let config = jQuery(`#${id}`).data('config'),
        nav = jQuery(`#${id}`).find('.modula-slider-nav'),
        main = jQuery(`#${id}`).find('.modula-items');
      main.slick(config.slider_settings);
      if (nav.length) {
        let navConfig = nav.data('config'),
          currentSlide = main.slick('slickCurrentSlide');
        nav.on('init', function (event, slick) {
          nav.find('.slick-slide[data-slick-index="' + currentSlide + '"]').addClass('is-active');
        });
        nav.slick(navConfig);
        main.on('afterChange', function (event, slick, currentSlide) {
          nav.slick('slickGoTo', currentSlide);
          let currrentNavSlideElem = '.slick-slide[data-slick-index="' + currentSlide + '"]';
          nav.find('.slick-slide.is-active').removeClass('is-active');
          nav.find(currrentNavSlideElem).addClass('is-active');
        });
        nav.on('click', '.slick-slide', function (event) {
          event.preventDefault();
          let goToSingleSlide = jQuery(this).data('slick-index');
          main.slick('slickGoTo', goToSingleSlide);
        });
      }
    }
  };
  const checkHoverEffect = effect => {
    jQuery.ajax({
      type: 'POST',
      data: {
        action: 'modula_check_hover_effect',
        nonce: modulaVars.nonce,
        effect: effect
      },
      url: modulaVars.ajaxURL,
      success: result => {
        setAttributes({
          effectCheck: result
        });
      }
    });
  };
  const selectOptions = () => {
    let options = [{
      value: 0,
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('select a gallery', 'modula-best-grid-gallery')
    }];
    galleries.forEach(function ({
      title,
      id
    }) {
      if (title.rendered.length == 0) {
        options.push({
          value: id,
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Unnamed Gallery', 'modula-best-grid-gallery') + id
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
  const blockControls = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BlockControls, null, images && images.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToolbarGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToolbarItem, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Edit gallery', 'modula-best-grid-gallery'),
    icon: "edit",
    href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
    target: "_blank"
  }))));
  if (id == 0 && 'none' === attributes.galleryType) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview__content"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview__logo"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-button-group"
    }, galleries.length == 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Sorry no galleries found', 'modula-best-grid-gallery'), ' '), galleries.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: "modula-button",
      target: "_blank",
      onClick: e => {
        setAttributes({
          status: 'ready',
          id: 0,
          galleryType: 'gallery'
        });
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Display An Existing Gallery', 'modula-best-grid-gallery'), icons.chevronRightFancy), undefined == props.attributes.proInstalled && galleries.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      href: "https://wp-modula.com/pricing/?utm_source=modula-lite&utm_campaign=upsell",
      className: "modula-button-upsell",
      isSecondary: true,
      target: "_blank"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Upgrade to PRO to create galleries using a preset ( fastest way )', 'modula-best-grid-gallery'))))));
  }
  if (status === 'loading') {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview__content"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview__logo"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null)));
  }
  if (id == 0 || images.length === 0) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, {
      key: "233"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Inspector, {
      onIdChange: id => onIdChange(id),
      selectOptions: selectOptions,
      ...props
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview__content"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "modula-block-preview__logo"
    }), galleries.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ModulaGallerySearch, {
      id: id,
      key: id,
      value: id,
      options: currentSelectize,
      onIdChange: onIdChange,
      galleries: galleries
    }), id != 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      target: "_blank",
      href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
      isPrimary: true
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Edit Gallery'))))));
  }
  if (settings) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, {
      key: "1"
    }, blockControls, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Inspector, {
      onIdChange: id => {
        onIdChange(id);
      },
      ...props
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ModulaGallery, {
      ...props,
      settings: settings,
      jsConfig: jsConfig,
      modulaRun: modulaRun,
      modulaSlickRun: modulaSlickRun,
      checkHoverEffect: checkHoverEffect,
      galleryId: galleryId
    }));
  }
  return null;
}
const applyWithSelect = withSelect((select, props) => {
  const {
    getEntityRecords
  } = select('core');
  const query = {
    post_status: 'publish',
    per_page: 5
  };
  return {
    galleries: getEntityRecords('postType', 'modula-gallery', query) || []
  };
});
const applyWithFilters = wp.components.withFilters('modula.Edit');
/* harmony default export */ __webpack_exports__["default"] = (compose(applyWithSelect, applyWithFilters)(Edit));

/***/ }),

/***/ "./blocks/gallery/index.js":
/*!*********************************!*\
  !*** ./blocks/gallery/index.js ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./blocks/gallery/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/gallery/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./blocks/gallery/block.json");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */



/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_3__.name, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"]
});

/***/ }),

/***/ "./blocks/gallery/editor.scss":
/*!************************************!*\
  !*** ./blocks/gallery/editor.scss ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/gallery/style.scss":
/*!***********************************!*\
  !*** ./blocks/gallery/style.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./blocks/gallery/block.json":
/*!***********************************!*\
  !*** ./blocks/gallery/block.json ***!
  \***********************************/
/***/ (function(module) {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"modula/gallery","version":"0.1.0","title":"Modula Gallery","category":"media","icon":"smiley","description":"Make your galleries stand out.","supports":{"html":false,"align":true,"customClassName":false},"keywords":["gallery","modula","images"],"textdomain":"modula-best-grid-gallery","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","render":"file:./render.php","viewScript":"file:./view.js","attributes":{"id":{"type":"number","default":0},"images":{"type":"array","default":[]},"status":{"type":"string","default":"ready"},"galleryId":{"type":"number","default":0},"defaultSettings":{"type":"object","default":[]},"galleryType":{"type":"string","default":"none"},"currentGallery":{"type":"object","default":{}},"currentSelectize":{"type":"array","default":[]}}}');

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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"gallery/index": 0,
/******/ 			"gallery/style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkmodula_best_grid_gallery"] = self["webpackChunkmodula_best_grid_gallery"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["gallery/style-index"], function() { return __webpack_require__("./blocks/gallery/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map