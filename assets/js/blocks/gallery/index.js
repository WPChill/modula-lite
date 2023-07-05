/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/blocks/gallery/edit.js":
/*!**********************************************!*\
  !*** ./assets/src/js/blocks/gallery/edit.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ModulaEdit: () => (/* binding */ ModulaEdit),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _lib_inspector__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./lib/inspector */ "./assets/src/js/blocks/gallery/lib/inspector.js");
/* harmony import */ var _components_ModulaGallery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../components/ModulaGallery */ "./assets/src/js/components/ModulaGallery.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components_ModulaGallerySearch__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../components/ModulaGallerySearch */ "./assets/src/js/components/ModulaGallerySearch.js");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _utils_network__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../../utils/network */ "./assets/src/js/utils/network.js");
/* harmony import */ var _utils_utility__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../../utils/utility */ "./assets/src/js/utils/utility.js");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./editor.scss */ "./assets/src/js/blocks/gallery/editor.scss");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _extends() { _extends = Object.assign ? Object.assign.bind() : function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _iterableToArrayLimit(arr, i) { var _i = null == arr ? null : "undefined" != typeof Symbol && arr[Symbol.iterator] || arr["@@iterator"]; if (null != _i) { var _s, _e, _x, _r, _arr = [], _n = !0, _d = !1; try { if (_x = (_i = _i.call(arr)).next, 0 === i) { if (Object(_i) !== _i) return; _n = !1; } else for (; !(_n = (_s = _x.call(_i)).done) && (_arr.push(_s.value), _arr.length !== i); _n = !0); } catch (err) { _d = !0, _e = err; } finally { try { if (!_n && null != _i["return"] && (_r = _i["return"](), Object(_r) !== _r)) return; } finally { if (_d) throw _e; } } return _arr; } }
function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }










var equal = __webpack_require__(/*! fast-deep-equal */ "./node_modules/fast-deep-equal/index.js");

var ModulaEdit = function ModulaEdit(props) {
  var postType = 'modula-gallery';
  var _props$attributes = props.attributes,
    id = _props$attributes.id,
    galleryId = _props$attributes.galleryId,
    images = _props$attributes.images,
    status = _props$attributes.status,
    settings = _props$attributes.settings,
    jsConfig = _props$attributes.jsConfig,
    currentGallery = _props$attributes.currentGallery,
    currentSelectize = _props$attributes.currentSelectize,
    attributes = props.attributes,
    setAttributes = props.setAttributes;
  var _useEntityRecords = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__.useEntityRecords)('postType', postType),
    galleries = _useEntityRecords.records,
    hasResolved = _useEntityRecords.hasResolved;
  var blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)();

  // Check when the alignment is changed so we can resize the instance
  var _useState = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useState)(props.attributes.align),
    _useState2 = _slicedToArray(_useState, 2),
    alignmentCheck = _useState2[0],
    setAlignment = _useState2[1];

  // Check when id is changed and it is not a component rerender . Saves unnecessary fetch requests
  var _useState3 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useState)(id),
    _useState4 = _slicedToArray(_useState3, 2),
    idCheck = _useState4[0],
    setIdCheck = _useState4[1];

  // Set a unique gallery id if not set.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useEffect)(function () {
    if (galleryId == "0") {
      setAttributes({
        galleryId: Math.floor(Math.random() * 999)
      });
    }
  }, [galleryId, setAttributes]);

  // Check whether to sync block settings with gallery CPT. i.e. if post settings have been updated.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useEffect)(function () {
    var getData = /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var imagesData, settingsData, jsConfigData, compareImages, compareSettings;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return (0,_utils_network__WEBPACK_IMPORTED_MODULE_8__.getImagesMeta)(id);
            case 2:
              imagesData = _context.sent;
              _context.next = 5;
              return (0,_utils_network__WEBPACK_IMPORTED_MODULE_8__.getGalleryCptData)(id, setAttributes);
            case 5:
              settingsData = _context.sent;
              _context.next = 8;
              return (0,_utils_network__WEBPACK_IMPORTED_MODULE_8__.getJsConfig)(settingsData);
            case 8:
              jsConfigData = _context.sent;
              // Only update block attributes if the gallery data has changed (i.e. been edited on the gallery CPT).
              compareImages = equal(images, imagesData);
              compareSettings = equal(settings, settingsData.modulaSettings); //console.log('Compare images:', compareImages);
              //console.log('Compare settings:', compareSettings);
              if (compareImages === false || compareSettings === false) {
                console.log('Syncing data...');
                setAttributes({
                  images: imagesData,
                  settings: settingsData.modulaSettings,
                  jsConfig: jsConfigData.jsConfig
                });
              }
            case 12:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }));
      return function getData() {
        return _ref.apply(this, arguments);
      };
    }();

    // Don't try and sync data if the gallery id hasn't been set yet.
    if (id !== 0) {
      getData();
    }
  }, []);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useEffect)(function () {
    //Grab the instance and set it as attribute to access it when we want
    jQuery(document).on('modula_api_after_init', function (event, inst) {
      props.setAttributes({
        instance: inst
      });
    });
    if (props.attributes.instance != undefined && settings != undefined && settings.type == 'grid') {
      props.attributes.instance.reset(props.attributes.instance);
    }
  });
  if (!hasResolved) {
    return /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement("div", {
      style: {
        textAlign: "center"
      }
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.Spinner, null)));
  }

  // Important! This should only be defined after 'galleries' has resolved.
  var options = (0,_utils_utility__WEBPACK_IMPORTED_MODULE_9__.generateSelectOptions)(id, galleries);
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
  var modulaSlickRun = function modulaSlickRun(id) {
    id = "jtg-".concat(id);
    setAttributes({
      status: 'ready'
    });
    var modulaSliders = jQuery('.modula-slider');
    if (modulaSliders.length > 0 && 'undefined' != typeof jQuery.fn.slick) {
      var config = jQuery("#".concat(id)).data('config'),
        nav = jQuery("#".concat(id)).find('.modula-slider-nav'),
        main = jQuery("#".concat(id)).find('.modula-items');
      main.slick(config.slider_settings);
      if (nav.length) {
        var navConfig = nav.data('config'),
          currentSlide = main.slick('slickCurrentSlide');
        nav.on('init', function (event, slick) {
          nav.find('.slick-slide[data-slick-index="' + currentSlide + '"]').addClass('is-active');
        });
        nav.slick(navConfig);
        main.on('afterChange', function (event, slick, currentSlide) {
          nav.slick('slickGoTo', currentSlide);
          var currrentNavSlideElem = '.slick-slide[data-slick-index="' + currentSlide + '"]';
          nav.find('.slick-slide.is-active').removeClass('is-active');
          nav.find(currrentNavSlideElem).addClass('is-active');
        });
        nav.on('click', '.slick-slide', function (event) {
          event.preventDefault();
          var goToSingleSlide = jQuery(this).data('slick-index');
          main.slick('slickGoTo', goToSingleSlide);
        });
      }
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
  var blockControls = /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.BlockControls, null, images && images.length > 0 && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.ToolbarGroup, null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.ToolbarItem, null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.Button, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Edit gallery', 'modula-best-grid-gallery'),
    icon: "edit",
    href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
    target: "_blank"
  }))));
  if (id == 0) {
    return /*#__PURE__*/React.createElement(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.Fragment, null, /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__content"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__logo"
    }), /*#__PURE__*/React.createElement("div", {
      className: "modula-button-group"
    }, galleries.length == 0 && /*#__PURE__*/React.createElement("p", null, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Sorry no galleries found', 'modula-best-grid-gallery'), ' '), galleries.length > 0 && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("p", null, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Display An Existing Gallery', 'modula-best-grid-gallery'), ' '), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.SelectControl, {
      value: id,
      options: options,
      onChange: function onChange(val) {
        (0,_utils_utility__WEBPACK_IMPORTED_MODULE_9__.galleryIdUpdated)(val, setAttributes);
      },
      __nextHasNoMarginBottom: true
    })), undefined == props.attributes.proInstalled && galleries.length > 0 && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.Button, {
      href: "https://wp-modula.com/pricing/?utm_source=modula-lite&utm_campaign=upsell",
      className: "modula-button-upsell",
      variant: "secondary",
      target: "_blank"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Upgrade to PRO to create galleries using a preset ( fastest way )', 'modula-best-grid-gallery')))))));
  }
  if (status === 'loading') {
    return /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__content"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__logo"
    }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.Spinner, null))));
  }
  if (id == 0 || images.length === 0) {
    return /*#__PURE__*/React.createElement(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.Fragment, {
      key: "233"
    }, /*#__PURE__*/React.createElement(_lib_inspector__WEBPACK_IMPORTED_MODULE_2__["default"], {
      attributes: attributes,
      setAttributes: setAttributes,
      galleries: galleries,
      options: options
    }), /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__content"
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula-block-preview__logo"
    }), galleries.length > 0 && /*#__PURE__*/React.createElement(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.Fragment, null, /*#__PURE__*/React.createElement(_components_ModulaGallerySearch__WEBPACK_IMPORTED_MODULE_5__["default"], {
      id: id,
      key: id,
      value: id,
      options: currentSelectize,
      onIdChange: onIdChange,
      galleries: galleries
    }), id != 0 && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.Button, {
      target: "_blank",
      href: modulaVars.adminURL + 'post.php?post=' + id + '&action=edit',
      variant: "primary"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Edit Gallery')))))));
  }
  if (settings) {
    return /*#__PURE__*/React.createElement(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.Fragment, {
      key: "1"
    }, blockControls, /*#__PURE__*/React.createElement("div", blockProps, /*#__PURE__*/React.createElement(_components_ModulaGallery__WEBPACK_IMPORTED_MODULE_3__["default"], _extends({}, props, {
      settings: settings,
      jsConfig: jsConfig,
      modulaRun: modulaRun,
      modulaSlickRun: modulaSlickRun,
      checkHoverEffect: checkHoverEffect,
      galleryId: galleryId
    }))), /*#__PURE__*/React.createElement(_lib_inspector__WEBPACK_IMPORTED_MODULE_2__["default"], {
      attributes: attributes,
      setAttributes: setAttributes,
      galleries: galleries,
      options: options
    }));
  }
  return null;
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.withFilters)('modula.ModulaEdit')(ModulaEdit));

/***/ }),

/***/ "./assets/src/js/blocks/gallery/index.js":
/*!***********************************************!*\
  !*** ./assets/src/js/blocks/gallery/index.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./assets/src/js/blocks/gallery/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./assets/src/js/blocks/gallery/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./assets/src/js/blocks/gallery/block.json");
/* harmony import */ var _utils_icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../utils/icons */ "./assets/src/js/utils/icons.js");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_3__.name, {
  icon: _utils_icons__WEBPACK_IMPORTED_MODULE_4__["default"].modula,
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"]
});

/***/ }),

/***/ "./assets/src/js/blocks/gallery/lib/inspector.js":
/*!*******************************************************!*\
  !*** ./assets/src/js/blocks/gallery/lib/inspector.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _utils_utility__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../utils/utility */ "./assets/src/js/utils/utility.js");




var Inspector = function Inspector(props) {
  var _props$attributes = props.attributes,
    id = _props$attributes.id,
    images = _props$attributes.images,
    attributes = props.attributes,
    setAttributes = props.setAttributes,
    options = props.options,
    galleries = props.galleries;
  return /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
    key: "modula-gallery-settings-sidebar"
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Gallery Settings'),
    initialOpen: true
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelRow, null, /*#__PURE__*/React.createElement("div", {
    style: {
      width: '100%'
    }
  }, /*#__PURE__*/React.createElement("h2", {
    style: {
      margin: "0.5em 0"
    }
  }, "Select Gallery"), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
    value: id,
    options: options,
    onChange: function onChange(val) {
      (0,_utils_utility__WEBPACK_IMPORTED_MODULE_3__.galleryIdUpdated)(val, setAttributes);
    },
    __nextHasNoMarginBottom: true
  }))), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelRow, null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    target: "_blank",
    href: "".concat(modulaVars.adminURL, "post.php?post=").concat(id, "&action=edit"),
    variant: "secondary"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Edit Gallery')))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Inspector);

/***/ }),

/***/ "./assets/src/js/components/ModulaGallery.js":
/*!***************************************************!*\
  !*** ./assets/src/js/components/ModulaGallery.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ModulaGallery: () => (/* binding */ ModulaGallery),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ModulaGalleryImage__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModulaGalleryImage */ "./assets/src/js/components/ModulaGalleryImage.js");
/* harmony import */ var _ModulaStyle__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModulaStyle */ "./assets/src/js/components/ModulaStyle.js");
/* harmony import */ var _ModulaItemsExtraComponent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ModulaItemsExtraComponent */ "./assets/src/js/components/ModulaItemsExtraComponent.js");
function _extends() { _extends = Object.assign ? Object.assign.bind() : function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }




var ModulaGallery = function ModulaGallery(props) {
  var _props$attributes = props.attributes,
    images = _props$attributes.images,
    jsConfig = _props$attributes.jsConfig,
    id = _props$attributes.id;
  var settings = props.settings,
    checkHoverEffect = props.checkHoverEffect,
    modulaRun = props.modulaRun,
    modulaSlickRun = props.modulaSlickRun;
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {
    if (settings !== undefined) {
      checkHoverEffect(settings.effect);
    }
    if ('slider' !== settings.type) {
      modulaRun(jsConfig);
    } else {
      modulaSlickRun(id);
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
  } else {
    galleryClassNames += 'modula-columns';
    itemsClassNames += ' grid-gallery';
    if (settings.grid_type == 'automatic') {
      itemsClassNames += ' justified-gallery';
    }
  }
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(_ModulaStyle__WEBPACK_IMPORTED_MODULE_2__["default"], {
    id: id,
    settings: settings
  }), /*#__PURE__*/React.createElement("div", {
    id: "jtg-".concat(id),
    className: "".concat(galleryClassNames, " ").concat(props.attributes.modulaDivClassName != undefined ? props.attributes.modulaDivClassName : ''),
    "data-config": JSON.stringify(jsConfig)
  }, settings.type == 'grid' && 'automatic' != settings.grid_type && /*#__PURE__*/React.createElement("div", {
    className: "modula-grid-sizer"
  }, " "), /*#__PURE__*/React.createElement(_ModulaItemsExtraComponent__WEBPACK_IMPORTED_MODULE_3__["default"], _extends({}, props, {
    position: 'top'
  })), /*#__PURE__*/React.createElement("div", {
    className: itemsClassNames
  }, images.length > 0 && images.map(function (img, index) {
    return /*#__PURE__*/React.createElement(_ModulaGalleryImage__WEBPACK_IMPORTED_MODULE_1__["default"], _extends({}, props, {
      img: img,
      key: index
    }));
  })), /*#__PURE__*/React.createElement(_ModulaItemsExtraComponent__WEBPACK_IMPORTED_MODULE_3__["default"], _extends({}, props, {
    position: 'bottom'
  }))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (wp.components.withFilters('modula.modulaGallery')(ModulaGallery));

/***/ }),

/***/ "./assets/src/js/components/ModulaGalleryImage.js":
/*!********************************************************!*\
  !*** ./assets/src/js/components/ModulaGalleryImage.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ModulaGalleryImageInner__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModulaGalleryImageInner */ "./assets/src/js/components/ModulaGalleryImageInner.js");

var ModulaGalleryImage = function ModulaGalleryImage(props) {
  var _props$attributes = props.attributes,
    settings = _props$attributes.settings,
    effectCheck = _props$attributes.effectCheck;
  var img = props.img,
    index = props.index;
  return /*#__PURE__*/React.createElement("div", {
    className: "modula-item effect-".concat(settings.effect),
    "data-width": img['data-width'] ? img['data-width'] : '2',
    "data-height": img['data-height'] ? img['data-height'] : '2'
  }, /*#__PURE__*/React.createElement("div", {
    className: "modula-item-overlay"
  }), /*#__PURE__*/React.createElement("div", {
    className: "modula-item-content"
  }, /*#__PURE__*/React.createElement("img", {
    className: "modula-image pic",
    "data-id": img.id,
    "data-full": img.src,
    "data-src": img.src,
    "data-valign": "middle",
    "data-halign": "center",
    src: img.src
  }), 'slider' !== settings.type && /*#__PURE__*/React.createElement(_ModulaGalleryImageInner__WEBPACK_IMPORTED_MODULE_0__["default"], {
    settings: settings,
    img: img,
    index: index,
    hideTitle: undefined != effectCheck && effectCheck.title == true ? false : true,
    hideDescription: undefined != effectCheck && effectCheck.description == true ? false : true,
    hideSocial: undefined != effectCheck && effectCheck.social == true ? false : true,
    effectCheck: effectCheck
  })));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (wp.components.withFilters('modula.ModulaGalleryImage')(ModulaGalleryImage));

/***/ }),

/***/ "./assets/src/js/components/ModulaGalleryImageInner.js":
/*!*************************************************************!*\
  !*** ./assets/src/js/components/ModulaGalleryImageInner.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _utils_icons__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/icons */ "./assets/src/js/utils/icons.js");

var Fragment = wp.element.Fragment;
var ModulaGalleryImageInner = function ModulaGalleryImageInner(props) {
  var settings = props.settings,
    img = props.img,
    hideTitle = props.hideTitle,
    hideDescription = props.hideDescription,
    hideSocial = props.hideSocial;
  var effectArray = ['tilt_1', 'tilt_3', 'tilt_7'],
    overlayArray = ['tilt_3', 'tilt_7'],
    svgArray = ['tilt_1', 'tilt_7'],
    jtgBody = ['lily', 'centered-bottom', 'sadie', 'ruby', 'bubba', 'dexter', 'chico', 'ming'];
  return /*#__PURE__*/React.createElement(Fragment, null, effectArray.includes(settings.effect) && /*#__PURE__*/React.createElement("div", {
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
  }, " ", 0 != img.description.length && img.description, " "), !hideSocial && '1' == settings.enableSocial && /*#__PURE__*/React.createElement("div", {
    className: "jtg-social"
  }, '1' == settings.enableTwitter && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-twitter",
    href: "#"
  }, ' ', "$", _utils_icons__WEBPACK_IMPORTED_MODULE_0__["default"].twitter, ' '), '1' == settings.enableFacebook && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-facebook",
    href: "#"
  }, ' ', "$", _utils_icons__WEBPACK_IMPORTED_MODULE_0__["default"].facebook, ' '), '1' == settings.enableWhatsapp && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-whatsapp",
    href: "#"
  }, ' ', "$", _utils_icons__WEBPACK_IMPORTED_MODULE_0__["default"].whatsapp, ' '), '1' == settings.enableLinkedin && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-linkedin",
    href: "#"
  }, ' ', "$", _utils_icons__WEBPACK_IMPORTED_MODULE_0__["default"].linkedin, ' '), '1' == settings.enablePinterest && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-pinterest",
    href: "#"
  }, ' ', "$", _utils_icons__WEBPACK_IMPORTED_MODULE_0__["default"].pinterest, ' '), '1' == settings.enableEmail && /*#__PURE__*/React.createElement("a", {
    className: "modula-icon-email",
    href: "#"
  }, ' ', "$", _utils_icons__WEBPACK_IMPORTED_MODULE_0__["default"].email, ' '))))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ModulaGalleryImageInner);

/***/ }),

/***/ "./assets/src/js/components/ModulaGallerySearch.js":
/*!*********************************************************!*\
  !*** ./assets/src/js/components/ModulaGallerySearch.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ModulaGallerySearch: () => (/* binding */ ModulaGallerySearch),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ModulaGallerySearch);

/***/ }),

/***/ "./assets/src/js/components/ModulaItemsExtraComponent.js":
/*!***************************************************************!*\
  !*** ./assets/src/js/components/ModulaItemsExtraComponent.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ModulaItemsExtraComponent: () => (/* binding */ ModulaItemsExtraComponent),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var ModulaItemsExtraComponent = function ModulaItemsExtraComponent(props) {
  return null;
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (wp.components.withFilters('modula.ModulaItemsExtraComponent')(ModulaItemsExtraComponent));

/***/ }),

/***/ "./assets/src/js/components/ModulaStyle.js":
/*!*************************************************!*\
  !*** ./assets/src/js/components/ModulaStyle.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
      if ('grid' != settings.type && 'slider' != settings.type) {
        style += "#jtg-".concat(id, " .modula-items {\n\t\t\t\theight: ").concat(settings.height, "px;\n\t\t\t}");
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
    if ("true" == jQuery("[aria-label=Settings]").attr('aria-expanded')) {
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
  return /*#__PURE__*/React.createElement("style", {
    dangerouslySetInnerHTML: {
      __html: "\n      \t\t\t\t".concat(style, "\n    \t\t\t\t")
    }
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ModulaStyle);

/***/ }),

/***/ "./assets/src/js/utils/icons.js":
/*!**************************************!*\
  !*** ./assets/src/js/utils/icons.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (icons);

/***/ }),

/***/ "./assets/src/js/utils/network.js":
/*!****************************************!*\
  !*** ./assets/src/js/utils/network.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getGalleryCptData: () => (/* binding */ getGalleryCptData),
/* harmony export */   getImagesMeta: () => (/* binding */ getImagesMeta),
/* harmony export */   getJsConfig: () => (/* binding */ getJsConfig),
/* harmony export */   getSettings: () => (/* binding */ getSettings)
/* harmony export */ });
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utility__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utility */ "./assets/src/js/utils/utility.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }


var getImagesMeta = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(id) {
    var response;
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          _context.prev = 0;
          _context.next = 3;
          return _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
            path: "/modula/v1/gallery-images/".concat(id)
          });
        case 3:
          response = _context.sent;
          return _context.abrupt("return", response.images);
        case 7:
          _context.prev = 7;
          _context.t0 = _context["catch"](0);
          return _context.abrupt("return", "Error: ".concat(_context.t0));
        case 10:
        case "end":
          return _context.stop();
      }
    }, _callee, null, [[0, 7]]);
  }));
  return function getImagesMeta(_x) {
    return _ref.apply(this, arguments);
  };
}();
var getJsConfig = /*#__PURE__*/function () {
  var _ref2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(settings) {
    var response;
    return _regeneratorRuntime().wrap(function _callee2$(_context2) {
      while (1) switch (_context2.prev = _context2.next) {
        case 0:
          _context2.prev = 0;
          _context2.next = 3;
          return _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
            path: "/modula/v1/gallery-js-config",
            method: 'POST',
            data: {
              settings: settings.modulaSettings
            }
          });
        case 3:
          response = _context2.sent;
          return _context2.abrupt("return", response);
        case 7:
          _context2.prev = 7;
          _context2.t0 = _context2["catch"](0);
          return _context2.abrupt("return", "Error: ".concat(_context2.t0));
        case 10:
        case "end":
          return _context2.stop();
      }
    }, _callee2, null, [[0, 7]]);
  }));
  return function getJsConfig(_x2) {
    return _ref2.apply(this, arguments);
  };
}();
var getGalleryCptData = /*#__PURE__*/function () {
  var _ref3 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3(id, setAttributes) {
    var response;
    return _regeneratorRuntime().wrap(function _callee3$(_context3) {
      while (1) switch (_context3.prev = _context3.next) {
        case 0:
          _context3.prev = 0;
          _context3.next = 3;
          return _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
            path: "/wp/v2/modula-gallery/".concat(id)
          });
        case 3:
          response = _context3.sent;
          setAttributes({
            currentGallery: response
          });
          setAttributes({
            currentSelectize: [{
              value: id,
              label: '' === response.title.rendered ? "Unnamed" : (0,_utility__WEBPACK_IMPORTED_MODULE_1__.escapeHtml)(response.title.rendered)
            }]
          });
          return _context3.abrupt("return", response);
        case 9:
          _context3.prev = 9;
          _context3.t0 = _context3["catch"](0);
          return _context3.abrupt("return", "Error: ".concat(_context3.t0));
        case 12:
        case "end":
          return _context3.stop();
      }
    }, _callee3, null, [[0, 9]]);
  }));
  return function getGalleryCptData(_x3, _x4) {
    return _ref3.apply(this, arguments);
  };
}();
var getSettings = /*#__PURE__*/function () {
  var _ref4 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4(id, setAttributes) {
    var settings, jsConfig;
    return _regeneratorRuntime().wrap(function _callee4$(_context4) {
      while (1) switch (_context4.prev = _context4.next) {
        case 0:
          _context4.next = 2;
          return getGalleryCptData(id, setAttributes);
        case 2:
          settings = _context4.sent;
          _context4.next = 5;
          return getJsConfig(settings);
        case 5:
          jsConfig = _context4.sent;
          return _context4.abrupt("return", {
            settings: settings,
            jsConfig: jsConfig.js_config
          });
        case 7:
        case "end":
          return _context4.stop();
      }
    }, _callee4);
  }));
  return function getSettings(_x5, _x6) {
    return _ref4.apply(this, arguments);
  };
}();

/***/ }),

/***/ "./assets/src/js/utils/utility.js":
/*!****************************************!*\
  !*** ./assets/src/js/utils/utility.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   escapeHtml: () => (/* binding */ escapeHtml),
/* harmony export */   galleryIdUpdated: () => (/* binding */ galleryIdUpdated),
/* harmony export */   generateSelectOptions: () => (/* binding */ generateSelectOptions)
/* harmony export */ });
/* harmony import */ var _network__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./network */ "./assets/src/js/utils/network.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

var generateSelectOptions = function generateSelectOptions(id, galleries) {
  var options = galleries.map(function (page, i) {
    return {
      label: page.title.rendered ? escapeHtml(page.title.rendered) : '(no title)',
      value: page.id
    };
  });
  if (id === 0) {
    options.unshift({
      label: 'Select Gallery...',
      value: '-1'
    });
  }
  return options;
};
var galleryIdUpdated = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(val, setAttributes) {
    var images, _yield$getSettings, settings, jsConfig;
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) switch (_context.prev = _context.next) {
        case 0:
          _context.next = 2;
          return (0,_network__WEBPACK_IMPORTED_MODULE_0__.getImagesMeta)(val);
        case 2:
          images = _context.sent;
          _context.next = 5;
          return (0,_network__WEBPACK_IMPORTED_MODULE_0__.getSettings)(val, setAttributes);
        case 5:
          _yield$getSettings = _context.sent;
          settings = _yield$getSettings.settings;
          jsConfig = _yield$getSettings.jsConfig;
          setAttributes({
            id: parseInt(val, 10),
            images: images,
            settings: settings.modulaSettings,
            jsConfig: jsConfig
          });
        case 9:
        case "end":
          return _context.stop();
      }
    }, _callee);
  }));
  return function galleryIdUpdated(_x, _x2) {
    return _ref.apply(this, arguments);
  };
}();

// export const syncSettings = async (val, setAttributes) => {
// 	const images = await getImagesMeta(val);
// 	const { settings, jsConfig } = await getSettings(val, setAttributes);
// 	setAttributes({
// 		images: images,
// 		settings: settings.modulaSettings,
// 	})
// }

var escapeHtml = function escapeHtml(text) {
  return text.replace("&#8217;", "'").replace("&#8220;", '"').replace("&#8216;", "'");
};

/***/ }),

/***/ "./node_modules/fast-deep-equal/index.js":
/*!***********************************************!*\
  !*** ./node_modules/fast-deep-equal/index.js ***!
  \***********************************************/
/***/ ((module) => {



// do not edit .js files directly - edit src/index.jst



module.exports = function equal(a, b) {
  if (a === b) return true;

  if (a && b && typeof a == 'object' && typeof b == 'object') {
    if (a.constructor !== b.constructor) return false;

    var length, i, keys;
    if (Array.isArray(a)) {
      length = a.length;
      if (length != b.length) return false;
      for (i = length; i-- !== 0;)
        if (!equal(a[i], b[i])) return false;
      return true;
    }



    if (a.constructor === RegExp) return a.source === b.source && a.flags === b.flags;
    if (a.valueOf !== Object.prototype.valueOf) return a.valueOf() === b.valueOf();
    if (a.toString !== Object.prototype.toString) return a.toString() === b.toString();

    keys = Object.keys(a);
    length = keys.length;
    if (length !== Object.keys(b).length) return false;

    for (i = length; i-- !== 0;)
      if (!Object.prototype.hasOwnProperty.call(b, keys[i])) return false;

    for (i = length; i-- !== 0;) {
      var key = keys[i];

      if (!equal(a[key], b[key])) return false;
    }

    return true;
  }

  // true if both NaN, false otherwise
  return a!==a && b!==b;
};


/***/ }),

/***/ "./assets/src/js/blocks/gallery/editor.scss":
/*!**************************************************!*\
  !*** ./assets/src/js/blocks/gallery/editor.scss ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/src/js/blocks/gallery/style.scss":
/*!*************************************************!*\
  !*** ./assets/src/js/blocks/gallery/style.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./assets/src/js/blocks/gallery/block.json":
/*!*************************************************!*\
  !*** ./assets/src/js/blocks/gallery/block.json ***!
  \*************************************************/
/***/ ((module) => {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"modula/gallery","version":"0.1.0","title":"Modula Gallery","category":"modula-gallery","description":"Make your galleries stand out.","keywords":["modula","gallery","images"],"supports":{"html":false,"align":true,"customClassName":false},"attributes":{"id":{"type":"number","default":0},"images":{"type":"array","default":[]},"status":{"type":"string","default":"ready"},"galleryId":{"type":"number","default":"0"},"defaultSettings":{"type":"object","default":[]},"galleryType":{"type":"string","default":"none"},"currentGallery":{"type":"object","default":{}},"currentSelectize":{"type":"array","default":[]}},"textdomain":"modula-best-grid-gallery","editorScript":["file:./index.js","modula-gutenberg"],"editorStyle":["file:./index.css"],"style":"file:./style-index.css","render":"file:./render.php"}');

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
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
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
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
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
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
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
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
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
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["gallery/style-index"], () => (__webpack_require__("./assets/src/js/blocks/gallery/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map