/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/gallery/components/Galleries/Gallery.jsx":
/*!*********************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Gallery.jsx ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Gallery: function() { return /* binding */ Gallery; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var swr__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! swr */ "./node_modules/swr/core/dist/index.mjs");
/* harmony import */ var _utils_fetcher__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../utils/fetcher */ "./blocks/gallery/utils/fetcher.js");
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _Gallery_Image__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./Gallery/Image */ "./blocks/gallery/components/Galleries/Gallery/Image.jsx");
/* harmony import */ var _Gallery_module_scss__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./Gallery.module.scss */ "./blocks/gallery/components/Galleries/Gallery.module.scss");








const Gallery = () => {
  const {
    attributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_3__["default"])();
  const {
    data,
    error,
    isLoading
  } = (0,swr__WEBPACK_IMPORTED_MODULE_1__["default"])(`/wp/v2/modula-gallery/${attributes.galleryId}`, _utils_fetcher__WEBPACK_IMPORTED_MODULE_2__.fetcher);
  const images = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useMemo)(() => {
    if (isLoading || error || !data) {
      return [];
    }
    if (!Array.isArray(data.modulaImages)) {
      return [];
    }
    return data.modulaImages.map(image => ({
      id: image.id,
      src: image.thumbnail
    }));
  }, [data, error, isLoading]);
  if (isLoading) {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Spinner, null);
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: _Gallery_module_scss__WEBPACK_IMPORTED_MODULE_7__["default"].galleryContainer
  }, images.map(image => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Gallery_Image__WEBPACK_IMPORTED_MODULE_6__.Image, {
    className: _Gallery_module_scss__WEBPACK_IMPORTED_MODULE_7__["default"].galleryItem,
    key: `${attributes.galleryId}-${image.id}`,
    id: image.id,
    src: image.src
  })));
};

/***/ }),

/***/ "./blocks/gallery/components/Galleries/Gallery/Image.jsx":
/*!***************************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Gallery/Image.jsx ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Image: function() { return /* binding */ Image; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Image_module_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Image.module.scss */ "./blocks/gallery/components/Galleries/Gallery/Image.module.scss");
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");



const Image = ({
  id,
  src
}) => {
  const {
    attributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_2__["default"])();
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    id: id,
    className: _Image_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].image,
    style: {
      backgroundImage: `url(${src})`,
      '--columns': attributes.galleryColumns
    }
  });
};

/***/ }),

/***/ "./blocks/gallery/components/Galleries/Masonry.jsx":
/*!*********************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Masonry.jsx ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Masonry: function() { return /* binding */ Masonry; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var swr__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! swr */ "./node_modules/swr/core/dist/index.mjs");
/* harmony import */ var _utils_fetcher__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../utils/fetcher */ "./blocks/gallery/utils/fetcher.js");
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _Masonry_Image__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./Masonry/Image */ "./blocks/gallery/components/Galleries/Masonry/Image.jsx");
/* harmony import */ var react_masonry__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! react-masonry */ "./node_modules/react-masonry/dist/index.js");
/* harmony import */ var _Masonry_module_scss__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./Masonry.module.scss */ "./blocks/gallery/components/Galleries/Masonry.module.scss");









const Masonry = () => {
  const {
    attributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_3__["default"])();
  const {
    data,
    error,
    isLoading
  } = (0,swr__WEBPACK_IMPORTED_MODULE_1__["default"])(`/wp/v2/modula-gallery/${attributes.galleryId}`, _utils_fetcher__WEBPACK_IMPORTED_MODULE_2__.fetcher);
  const images = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useMemo)(() => {
    if (isLoading || error || !data) {
      return [];
    }
    if (!Array.isArray(data.modulaImages)) {
      return [];
    }
    return data.modulaImages.map(image => ({
      id: image.id,
      src: image.thumbnail,
      orientation: image.orientation
    }));
  }, [data, error, isLoading]);
  if (isLoading) {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Spinner, null);
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: _Masonry_module_scss__WEBPACK_IMPORTED_MODULE_8__["default"].galleryContainer
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_masonry__WEBPACK_IMPORTED_MODULE_7__.Masonry, null, images.map((image, index) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Masonry_Image__WEBPACK_IMPORTED_MODULE_6__.Image, {
    key: index,
    index: index,
    id: image.id,
    orientation: image.orientation,
    src: image.src
  }))));
};

/***/ }),

/***/ "./blocks/gallery/components/Galleries/Masonry/Image.jsx":
/*!***************************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Masonry/Image.jsx ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Image: function() { return /* binding */ Image; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Image_module_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Image.module.scss */ "./blocks/gallery/components/Galleries/Masonry/Image.module.scss");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);

/* eslint-disable jsx-a11y/alt-text */


const Image = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.forwardRef)(({
  id,
  src,
  orientation,
  ...props
}, ref) => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ref: ref,
    className: _Image_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].imageContainer,
    style: {
      ...props.style,
      width: 'calc(25% - 10px)',
      height: orientation === 'landscape' ? '200px' : '400px'
    }
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: _Image_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].image,
    style: {
      backgroundImage: `url(${src})`
    }
  }));
});

/***/ }),

/***/ "./blocks/gallery/components/ImportExistingSplash.jsx":
/*!************************************************************!*\
  !*** ./blocks/gallery/components/ImportExistingSplash.jsx ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _Galleries_Gallery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Galleries/Gallery */ "./blocks/gallery/components/Galleries/Gallery.jsx");
/* harmony import */ var _Galleries_Masonry__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Galleries/Masonry */ "./blocks/gallery/components/Galleries/Masonry.jsx");





const ImportExistingSplash = () => {
  const {
    attributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_1__["default"])();
  const {
    galleryType
  } = attributes;
  // you don't need to translate debug logs :P
  if (galleryType === 'creative') {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalText, null, "Rendering creative gallery: ", attributes.galleryId), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Galleries_Gallery__WEBPACK_IMPORTED_MODULE_3__.Gallery, null));
  }
  if (galleryType === 'masonry') {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalText, null, "Rendering masonry gallery: ", attributes.galleryId), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Galleries_Masonry__WEBPACK_IMPORTED_MODULE_4__.Masonry, null));
  }
  if (galleryType === 'custom-grid') {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalText, null, "Rendering custom grid: ", attributes.galleryId), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Galleries_Gallery__WEBPACK_IMPORTED_MODULE_3__.Gallery, null));
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalText, null, "Unknown gallery type: ", galleryType);
};
/* harmony default export */ __webpack_exports__["default"] = (ImportExistingSplash);

/***/ }),

/***/ "./blocks/gallery/components/InitialSplash.jsx":
/*!*****************************************************!*\
  !*** ./blocks/gallery/components/InitialSplash.jsx ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/icons */ "./blocks/gallery/utils/icons.jsx");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _hooks_usePostCreator__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../hooks/usePostCreator */ "./blocks/gallery/hooks/usePostCreator.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__);








const InitialSplash = () => {
  const {
    createPost,
    loading,
    data
  } = (0,_hooks_usePostCreator__WEBPACK_IMPORTED_MODULE_6__.usePostCreator)();
  const {
    step,
    incrementStep,
    decrementStep,
    setAttributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_5__["default"])();
  const createPostCb = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_7__.useCallback)(async () => {
    // @todo bonus points - you can get the Page/Post title and
    // create the gallery using a title like : "Gallery from {title} {postType}"
    // you can send the title to createPost - check its signature
    const result = await createPost();
    const {
      id
    } = result;
    setAttributes({
      galleryId: id
    });
  }, [createPost, setAttributes]);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Placeholder, {
    icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.BlockIcon, {
      icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_utils_icons__WEBPACK_IMPORTED_MODULE_1__.ModulaIcon, null)
    }),
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Modula Gallery Block', 'random-image'),
    instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Create a new gallery or choose from an existing one.', 'modula-best-grid-gallery')
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    isBusy: loading,
    variant: "primary",
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Add New Gallery', 'modula-best-grid-gallery'),
    onClick: createPostCb
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Add New Gallery', 'modula-best-grid-gallery')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    onClick: incrementStep,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert Existing Gallery', 'modula-best-grid-gallery')
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Insert Existing Gallery', 'modula-best-grid-gallery')));
};
/* harmony default export */ __webpack_exports__["default"] = (InitialSplash);

/***/ }),

/***/ "./blocks/gallery/components/InspectorControls.jsx":
/*!*********************************************************!*\
  !*** ./blocks/gallery/components/InspectorControls.jsx ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   InspectorControls: function() { return /* binding */ InspectorControls; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components_shared_GallerySelector__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/shared/GallerySelector */ "./blocks/gallery/components/shared/GallerySelector.jsx");






const InspectorControls = () => {
  const {
    attributes,
    setAttributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_3__["default"])();
  const {
    galleryType,
    galleryColumns,
    galleryLightbox,
    rowHeight,
    lastRow,
    titleColor,
    titleFontSize,
    titleVisibility,
    captionColor,
    captionFontSize,
    captionVisibility
  } = attributes;
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
    group: 'settings'
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Panel, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Modula Settings', 'modula-best-grid-gallery'),
    initialOpen: true
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_shared_GallerySelector__WEBPACK_IMPORTED_MODULE_5__.GallerySelector, null), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Gallery Type', 'modula-best-grid-gallery'),
    value: galleryType || 'creative',
    onChange: value => setAttributes({
      galleryType: value
    }),
    options: [{
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Creative', 'modula-best-grid-gallery'),
      value: 'creative'
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Masonry', 'modula-best-grid-gallery'),
      value: 'masonry'
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Custom grid', 'modula-best-grid-gallery'),
      value: 'custom-grid'
    }]
  }), galleryType === 'masonry' && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Columns', 'modula-best-grid-gallery'),
    value: galleryColumns,
    onChange: value => setAttributes({
      galleryColumns: Number(value)
    }),
    options: [{
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('One Column', 'modula-best-grid-gallery'),
      value: 1
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Two Columns', 'modula-best-grid-gallery'),
      value: 2
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Three Columns', 'modula-best-grid-gallery'),
      value: 3
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Four Columns', 'modula-best-grid-gallery'),
      value: 4
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Five Columns', 'modula-best-grid-gallery'),
      value: 5
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Six Columns', 'modula-best-grid-gallery'),
      value: 6
    }
    // {
    // 	label: __(
    // 		'Automatic ',
    // 		'modula-best-grid-gallery'
    // 	),
    // 	value: 'modula-automatic-columns',
    // },
    ]
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Row Height', 'modula-best-grid-gallery'),
    type: "number",
    onChange: value => setAttributes({
      rowHeight: value
    }),
    value: rowHeight
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.CheckboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Enable last row', 'modula-best-grid-gallery'),
    checked: lastRow,
    onChange: value => {
      setAttributes({
        lastRow: Boolean(value)
      });
    }
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Lightbox Settings', 'modula-best-grid-gallery'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.RadioControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Enable Lightbox', 'modula-best-grid-gallery'),
    onChange: value => setAttributes({
      galleryLightbox: Boolean(value)
    }),
    selected: galleryLightbox,
    options: [{
      label: 'Enable',
      value: 'enabled'
    }, {
      label: 'Disable',
      value: 'disabled'
    }]
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Image Title Settings', 'modula-best-grid-gallery'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalText, null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Pick a color for the gallery title.', 'modula-best-grid-gallery')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ColorPicker, {
    color: titleColor,
    onChange: value => {
      setAttributes({
        titleColor: value
      });
    },
    enableAlpha: true,
    defaultValue: "#000"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.FontSizePicker, {
    __nextHasNoMarginBottom: true,
    fontSizes: [{
      name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Small', 'modula-best-grid-gallery'),
      slug: 'small',
      size: 12
    }, {
      name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Medium', 'modula-best-grid-gallery'),
      slug: 'medium',
      size: 18
    }, {
      name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Big', 'modula-best-grid-gallery'),
      slug: 'big',
      size: 26
    }],
    value: titleFontSize,
    withSlider: true,
    disabledCustomFontSizes: false,
    fallbackFontSize: '16',
    onChange: value => setAttributes({
      titleFontSize: Number(value)
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.RadioControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show/Hide title', 'modula-best-grid-gallery'),
    selected: titleVisibility,
    onChange: value => setAttributes({
      titleVisibility: String(value)
    }),
    options: [{
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Visible', 'modula-best-grid-gallery'),
      value: 'visible'
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Hidden', 'modula-best-grid-gallery'),
      value: 'hidden'
    }]
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Panel, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Image Caption Settings', 'modula-best-grid-gallery'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalText, null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Pick a color for the gallery caption.', 'modula-best-grid-gallery')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.ColorPicker, {
    color: captionColor,
    onChange: value => {
      setAttributes({
        captionColor: value
      });
    },
    enableAlpha: true,
    defaultValue: "#000"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.FontSizePicker, {
    __nextHasNoMarginBottom: true,
    fontSizes: [{
      name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Small', 'modula-best-grid-gallery'),
      slug: 'small',
      size: 12
    }, {
      name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Medium', 'modula-best-grid-gallery'),
      slug: 'medium',
      size: 18
    }, {
      name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Big', 'modula-best-grid-gallery'),
      slug: 'big',
      size: 26
    }],
    value: captionFontSize,
    withSlider: true,
    disabledCustomFontSizes: false,
    fallbackFontSize: '16',
    onChange: value => setAttributes({
      captionFontSize: Number(value)
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.RadioControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Show/Hide Caption', 'modula-best-grid-gallery'),
    selected: captionVisibility,
    onChange: value => setAttributes({
      captionVisibility: String(value)
    }),
    options: [{
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Visible', 'modula-best-grid-gallery'),
      value: 'visible'
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Hidden', 'modula-best-grid-gallery'),
      value: 'hidden'
    }]
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Socials', 'modula-best-grid-gallery'),
    initialOpen: false
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Hover Effects', 'modula-best-grid-gallery'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.RangeControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Hover Effect Opacity', 'modula-best-grid-gallery'),
    value: '50',
    allowReset: true
    //onChange={(value) => setColumns(value)}
    ,
    min: 0,
    initialPosition: 100,
    max: 100
  }))));
};

/***/ }),

/***/ "./blocks/gallery/components/UiBlock.jsx":
/*!***********************************************!*\
  !*** ./blocks/gallery/components/UiBlock.jsx ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   UiBlock: function() { return /* binding */ UiBlock; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _InitialSplash__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./InitialSplash */ "./blocks/gallery/components/InitialSplash.jsx");
/* harmony import */ var _ImportExistingSplash__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ImportExistingSplash */ "./blocks/gallery/components/ImportExistingSplash.jsx");





const UiBlock = () => {
  const {
    attributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_2__["default"])();
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps)({
    className: 'modula-splash-container'
  });
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, attributes.galleryId > 0 ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ImportExistingSplash__WEBPACK_IMPORTED_MODULE_4__["default"], null) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_InitialSplash__WEBPACK_IMPORTED_MODULE_3__["default"], null));
};

/***/ }),

/***/ "./blocks/gallery/components/shared/GallerySelector.jsx":
/*!**************************************************************!*\
  !*** ./blocks/gallery/components/shared/GallerySelector.jsx ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   GallerySelector: function() { return /* binding */ GallerySelector; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var swr__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! swr */ "./node_modules/swr/core/dist/index.mjs");
/* harmony import */ var _utils_fetcher__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../utils/fetcher */ "./blocks/gallery/utils/fetcher.js");
/* harmony import */ var _hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../hooks/useBlockContext */ "./blocks/gallery/hooks/useBlockContext.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__);







const GallerySelector = () => {
  const {
    attributes,
    setAttributes
  } = (0,_hooks_useBlockContext__WEBPACK_IMPORTED_MODULE_5__["default"])();
  const {
    galleryId
  } = attributes;
  const {
    data,
    error,
    isLoading
  } = (0,swr__WEBPACK_IMPORTED_MODULE_3__["default"])('/wp/v2/modula-gallery', _utils_fetcher__WEBPACK_IMPORTED_MODULE_4__.fetcher);
  const options = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useMemo)(() => {
    if (isLoading) {
      return [{
        value: 0,
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Fetching Galleries', 'modula-best-grid-gallery')
      }];
    }
    if (error) {
      return [{
        value: 0,
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Error', 'modula-best-grid-gallery')
      }];
    }
    if (!data) {
      return [{
        value: 0,
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('No galleries found', 'modula-best-grid-gallery')
      }];
    }
    return data.map(post => {
      return {
        value: post.id,
        label: post.title.rendered
      };
    });
  }, [data, error, isLoading]);
  const onChangeCb = val => {
    const keysToSync = ['blockColor', 'blockBackground', 'fontSize'];
    const gallery = data.find(post => post.id === Number(val));
    setAttributes({
      galleryId: Number(val)
    });
    if (!gallery?.modulaSettings) {
      return;
    }
    const selectedSettings = Object.keys(gallery.modulaSettings).filter(key => keysToSync.includes(key)).reduce((obj, key) => {
      obj[key] = gallery.modulaSettings[key];
      return obj;
    }, {});
    setAttributes(selectedSettings);
  };
  if (isLoading) {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Spinner, null);
  }
  if (error) {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Error!', 'modula-best-grid-gallery'));
  }
  if (!options.length) {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('No Galleries found :(', 'modula-best-grid-gallery')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
      variant: "primary",
      onClick: undefined,
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Click here to create a new gallery', 'modula-best-grid-gallery')
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Click here to create a new gallery', 'modula-best-grid-gallery'))));
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Choose a gallery', 'modula-best-grid-gallery'),
    value: galleryId,
    onChange: onChangeCb,
    options: [{
      value: 0,
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Select a gallery')
    }, ...options]
  });
};

/***/ }),

/***/ "./blocks/gallery/context/BlockContext.jsx":
/*!*************************************************!*\
  !*** ./blocks/gallery/context/BlockContext.jsx ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   BlockProvider: function() { return /* binding */ BlockProvider; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _reducer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./reducer */ "./blocks/gallery/context/reducer.js");
/* harmony import */ var _state__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./state */ "./blocks/gallery/context/state.js");
/* harmony import */ var _hooks_useAfterSave__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../hooks/useAfterSave */ "./blocks/gallery/hooks/useAfterSave.js");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5__);






const BlockContext = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createContext)();
const BlockProvider = ({
  children,
  initialValues,
  attributes,
  setAttributes
}) => {
  const isAfterSave = (0,_hooks_useAfterSave__WEBPACK_IMPORTED_MODULE_4__.useAfterSave)();
  const mergedInitialState = {
    ..._state__WEBPACK_IMPORTED_MODULE_3__.initialState,
    ...initialValues
  };
  const [state, dispatch] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useReducer)(_reducer__WEBPACK_IMPORTED_MODULE_2__.reducer, mergedInitialState);
  const incrementStep = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useCallback)(() => {
    dispatch({
      type: 'INCREMENT_STEP'
    });
  }, []);
  const decrementStep = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useCallback)(() => {
    dispatch({
      type: 'DECREMENT_STEP'
    });
  }, []);
  const goToStep = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useCallback)(step => {
    dispatch({
      type: 'GO_TO_STEP',
      payload: Number(step)
    });
  }, []);
  const saveGalleryPost = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useCallback)(async () => {
    try {
      const response = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_5___default()({
        path: `/wp/v2/modula-gallery/${attributes.galleryId}`,
        method: 'POST',
        data: {
          modulaSettings: {
            ...attributes
          }
        }
      });
      console.log(response);
    } catch (err) {
      console.log(err);
    }
  }, [attributes]);
  const value = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => {
    return {
      // Wp core stuff
      attributes,
      setAttributes,
      // State management
      incrementStep,
      decrementStep,
      goToStep,
      // Exposed state
      step: state.step
    };
  }, [attributes, setAttributes, incrementStep, decrementStep, goToStep, state.step]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    if (isAfterSave) {
      saveGalleryPost();
    }
  }, [isAfterSave, saveGalleryPost]);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(BlockContext.Provider, {
    value: value
  }, children);
};
/* harmony default export */ __webpack_exports__["default"] = (BlockContext);

/***/ }),

/***/ "./blocks/gallery/context/reducer.js":
/*!*******************************************!*\
  !*** ./blocks/gallery/context/reducer.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   reducer: function() { return /* binding */ reducer; }
/* harmony export */ });
const reducer = (state, action) => {
  switch (action.type) {
    case 'INCREMENT_STEP':
      return {
        ...state,
        step: state.step + 1
      };
    case 'DECREMENT_STEP':
      return {
        ...state,
        step: state.step > 0 ? state.step - 1 : 0
      };
    case 'GO_TO_STEP':
      return {
        ...state,
        step: action.step
      };
    default:
      return state;
  }
};

/***/ }),

/***/ "./blocks/gallery/context/state.js":
/*!*****************************************!*\
  !*** ./blocks/gallery/context/state.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initialState: function() { return /* binding */ initialState; }
/* harmony export */ });
const initialState = {
  step: 0
};

/***/ }),

/***/ "./blocks/gallery/edit.js":
/*!********************************!*\
  !*** ./blocks/gallery/edit.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ Edit; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./blocks/gallery/editor.scss");
/* harmony import */ var _context_BlockContext__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./context/BlockContext */ "./blocks/gallery/context/BlockContext.jsx");
/* harmony import */ var _components_InspectorControls__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/InspectorControls */ "./blocks/gallery/components/InspectorControls.jsx");
/* harmony import */ var _components_UiBlock__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/UiBlock */ "./blocks/gallery/components/UiBlock.jsx");





function Edit({
  attributes,
  setAttributes
}) {
  const initialValues = {
    blockBackground: '#000000'
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_context_BlockContext__WEBPACK_IMPORTED_MODULE_2__.BlockProvider, {
    initialValues: initialValues,
    attributes: attributes,
    setAttributes: setAttributes
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_UiBlock__WEBPACK_IMPORTED_MODULE_4__.UiBlock, null), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_InspectorControls__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, null));
}

/***/ }),

/***/ "./blocks/gallery/hooks/useAfterSave.js":
/*!**********************************************!*\
  !*** ./blocks/gallery/hooks/useAfterSave.js ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useAfterSave: function() { return /* binding */ useAfterSave; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);


const useAfterSave = () => {
  const [isPostSaved, setIsPostSaved] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const isPostSavingInProgress = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useRef)(false);
  const {
    isSavingPost,
    isAutosavingPost
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(__select => {
    return {
      isSavingPost: __select('core/editor').isSavingPost(),
      isAutosavingPost: __select('core/editor').isAutosavingPost()
    };
  });
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if ((isSavingPost || isAutosavingPost) && !isPostSavingInProgress.current) {
      setIsPostSaved(false);
      isPostSavingInProgress.current = true;
    }
    if (!(isSavingPost || isAutosavingPost) && isPostSavingInProgress.current) {
      setIsPostSaved(true);
      isPostSavingInProgress.current = false;
    }
  }, [isSavingPost, isAutosavingPost]);
  return isPostSaved;
};

/***/ }),

/***/ "./blocks/gallery/hooks/useBlockContext.js":
/*!*************************************************!*\
  !*** ./blocks/gallery/hooks/useBlockContext.js ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _context_BlockContext__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../context/BlockContext */ "./blocks/gallery/context/BlockContext.jsx");


const useBlockContext = () => {
  const context = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_context_BlockContext__WEBPACK_IMPORTED_MODULE_1__["default"]);
  if (!context) {
    throw new Error('useBlockContext must be used within a BlockContextProvider');
  }
  return context;
};
/* harmony default export */ __webpack_exports__["default"] = (useBlockContext);

/***/ }),

/***/ "./blocks/gallery/hooks/usePostCreator.js":
/*!************************************************!*\
  !*** ./blocks/gallery/hooks/usePostCreator.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   usePostCreator: function() { return /* binding */ usePostCreator; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);



const usePostCreator = (postType = 'modula-gallery') => {
  const [loading, setLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [error, setError] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const [data, setData] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const createPost = async (postData = {}) => {
    const newPost = {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('New Gallery', 'modula-best-grid-gallery'),
      content: '',
      status: 'publish',
      ...postData
    };
    setLoading(true);
    try {
      const response = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_1___default()({
        path: `/wp/v2/${postType}`,
        method: 'POST',
        data: newPost
      });
      setData(response);
      setLoading(false);
      return response;
    } catch (err) {
      setError(err);
    } finally {
      setLoading(false);
    }
  };
  return {
    loading,
    error,
    data,
    createPost
  };
};

/***/ }),

/***/ "./blocks/gallery/index.js":
/*!*********************************!*\
  !*** ./blocks/gallery/index.js ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils/icons */ "./blocks/gallery/utils/icons.jsx");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./blocks/gallery/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./edit */ "./blocks/gallery/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./block.json */ "./blocks/gallery/block.json");
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
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_3__["default"],
  icon: (0,_utils_icons__WEBPACK_IMPORTED_MODULE_1__.ModulaIcon)(),
  deprecated: [{
    attributes: {
      id: {
        type: 'number',
        default: 0
      },
      images: {
        type: 'array',
        default: []
      },
      status: {
        type: 'string',
        default: 'ready'
      },
      galleryId: {
        type: 'number',
        default: 0
      },
      defaultSettings: {
        type: 'object',
        default: []
      },
      galleryType: {
        type: 'string',
        default: 'none'
      },
      currentGallery: {
        type: 'object',
        default: {}
      },
      currentSelectize: {
        type: 'array',
        default: []
      }
    },
    save() {
      return null;
    }
  }]
});

/***/ }),

/***/ "./blocks/gallery/utils/fetcher.js":
/*!*****************************************!*\
  !*** ./blocks/gallery/utils/fetcher.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   fetcher: function() { return /* binding */ fetcher; }
/* harmony export */ });
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);

const fetcher = url => _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
  path: url
});

/***/ }),

/***/ "./blocks/gallery/utils/icons.jsx":
/*!****************************************!*\
  !*** ./blocks/gallery/utils/icons.jsx ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ChevronLeftIcon: function() { return /* binding */ ChevronLeftIcon; },
/* harmony export */   ChevronRightFancyIcon: function() { return /* binding */ ChevronRightFancyIcon; },
/* harmony export */   ChevronRightIcon: function() { return /* binding */ ChevronRightIcon; },
/* harmony export */   EmailIcon: function() { return /* binding */ EmailIcon; },
/* harmony export */   FacebookIcon: function() { return /* binding */ FacebookIcon; },
/* harmony export */   LinkedInIcon: function() { return /* binding */ LinkedInIcon; },
/* harmony export */   ModulaIcon: function() { return /* binding */ ModulaIcon; },
/* harmony export */   PinterestIcon: function() { return /* binding */ PinterestIcon; },
/* harmony export */   RemoveIcon: function() { return /* binding */ RemoveIcon; },
/* harmony export */   ReplaceIcon: function() { return /* binding */ ReplaceIcon; },
/* harmony export */   TwitterIcon: function() { return /* binding */ TwitterIcon; },
/* harmony export */   WhatsAppIcon: function() { return /* binding */ WhatsAppIcon; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

const ModulaIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    x: "0px",
    y: "0px",
    viewBox: "364 242.9 312.2 357"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M528.1,242.9c8.5,16.9,17,33.8,25.6,50.6c13.4,26.4,26.9,52.7,39.9,79.7c-41.8-23.3-83.6-46.7-125.4-70.1 c0.3-1.9,1.7-2.6,2.7-3.5c17.7-17.7,35.4-35.4,53.1-53c1.1-1.1,2.6-2,3.1-3.7C527.4,242.9,527.8,242.9,528.1,242.9z"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M602.3,463.3c11.3-6.9,22.6-13.9,33.9-20.8c5.5-3.4,11.1-6.7,16.5-10.3c2.2-1.4,2.9-1.1,3.5,1.5 c6.4,25.3,13,50.6,19.6,75.8c0.6,2.2,1,3.7-2.4,3.5c-46.7-2.1-93.5-4.1-140.2-6.1c-0.2,0-0.3-0.1-0.5-0.2c0.5-1.7,2.1-2,3.3-2.7 c20-12.3,39.9-24.7,60-36.8c3.4-2.1,5.1-3.7,4.8-8.5c-1.4-21.3-1.8-42.6-2.6-63.9c-0.9-24.1-1.8-48.3-2.8-72.4 c-0.2-6.1-0.2-6.1,5.5-4.6c23.8,6.2,47.6,12.5,71.5,18.5c3.9,1,4.2,1.9,2.1,5.4c-23.4,38.5-46.7,77.1-70,115.7 c-1,1.7-2,3.4-3,5.1C601.7,462.8,602,463,602.3,463.3z"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M372.8,326.9c48,2.6,95.8,5.1,143.9,7.7c-0.9,2-2.5,2.3-3.7,3.1c-38.6,23.2-77.3,46.4-115.9,69.6c-3,1.8-4.3,2.6-5.4-1.9 c-5.9-24.9-12.2-49.7-18.3-74.6C373.1,329.6,373,328.4,372.8,326.9z"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M517.6,599.9c-23.2-43.7-45.9-86.6-69.2-130.5c2.3,1.2,3.5,1.8,4.7,2.4c39.8,21.5,79.5,43.1,119.3,64.5 c3.2,1.7,4.1,2.5,1,5.6c-17.7,17.8-35.2,35.9-52.8,53.9C519.7,596.9,518.9,598.2,517.6,599.9z"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M364.9,505.1c26.6-40.5,53.1-80.8,79.7-121.3c1.3,1.3,0.9,2.5,0.9,3.6c0,46-0.1,92-0.1,137.9c0,3.1-0.2,4.5-4,3.3 c-24.9-7.7-49.9-15.2-74.9-22.8C366,505.8,365.7,505.5,364.9,505.1z"
  })));
};
const RemoveIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "24",
    height: "24",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    role: "img",
    "aria-hidden": "true"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M19 6H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm-1 10H6a1 1 0 0 1 0-2h12a1 1 0 0 1 0 2z"
  }));
};
const ReplaceIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "24",
    height: "24",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    role: "img",
    "aria-hidden": "true",
    focusable: "false"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M20.1 5.1L16.9 2 6.2 12.7l-1.3 4.4 4.5-1.3L20.1 5.1zM4 20.8h8v-1.5H4v1.5z"
  }));
};
const ChevronLeftIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "24",
    height: "24",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    role: "img",
    "aria-hidden": "true",
    focusable: "false"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M14.6 7l-1.2-1L8 12l5.4 6 1.2-1-4.6-5z"
  }));
};
const ChevronRightIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "24",
    height: "24",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    role: "img",
    "aria-hidden": "true",
    focusable: "false"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M10.6 6L9.4 7l4.6 5-4.6 5 1.2 1 5.4-6z"
  }));
};
const TwitterIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    "aria-hidden": "true",
    "data-prefix": "fab",
    "data-icon": "twitter",
    className: "svg-inline--fa fa-twitter fa-w-16",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 512 512"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
  }));
};
const FacebookIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    "aria-hidden": "true",
    "data-prefix": "fab",
    "data-icon": "facebook-f",
    className: "svg-inline--fa fa-facebook-f fa-w-9",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 264 512"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"
  }));
};
const WhatsAppIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    "aria-hidden": "true",
    focusable: "false",
    preserveAspectRatio: "xMidYMid meet",
    viewBox: "0 0 1536 1600"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M985 878q13 0 97.5 44t89.5 53q2 5 2 15q0 33-17 76q-16 39-71 65.5T984 1158q-57 0-190-62q-98-45-170-118T476 793q-72-107-71-194v-8q3-91 74-158q24-22 52-22q6 0 18 1.5t19 1.5q19 0 26.5 6.5T610 448q8 20 33 88t25 75q0 21-34.5 57.5T599 715q0 7 5 15q34 73 102 137q56 53 151 101q12 7 22 7q15 0 54-48.5t52-48.5zm-203 530q127 0 243.5-50t200.5-134t134-200.5t50-243.5t-50-243.5T1226 336t-200.5-134T782 152t-243.5 50T338 336T204 536.5T154 780q0 203 120 368l-79 233l242-77q158 104 345 104zm0-1382q153 0 292.5 60T1315 247t161 240.5t60 292.5t-60 292.5t-161 240.5t-240.5 161t-292.5 60q-195 0-365-94L0 1574l136-405Q28 991 28 780q0-153 60-292.5T249 247T489.5 86T782 26z",
    fill: "currentColor"
  }));
};
const PinterestIcon = () => {
  (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    "aria-hidden": "true",
    "data-prefix": "fab",
    "data-icon": "pinterest-p",
    className: "svg-inline--fa fa-pinterest-p fa-w-12",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 384 512"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"
  }));
};
const LinkedInIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    "aria-hidden": "true",
    focusable: "false",
    "data-prefix": "fab",
    "data-icon": "linkedin-in",
    className: "svg-inline--fa fa-linkedin-in fa-w-14",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 448 512"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"
  }));
};
const EmailIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "24",
    height: "24",
    viewBox: "0 0 24 24"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z",
    fill: "currentColor"
  }));
};
const ChevronRightFancyIcon = () => {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    width: "16",
    height: "16",
    fill: "currentColor",
    className: "bi bi-chevron-right",
    viewBox: "0 0 16 16"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fillRule: "evenodd",
    d: "M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
  }));
};


/***/ }),

/***/ "./node_modules/client-only/index.js":
/*!*******************************************!*\
  !*** ./node_modules/client-only/index.js ***!
  \*******************************************/
/***/ (function() {



/***/ }),

/***/ "./blocks/gallery/components/Galleries/Gallery.module.scss":
/*!*****************************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Gallery.module.scss ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"galleryContainer":"jM3AhXxJkvrWgUNU9Ofs"});

/***/ }),

/***/ "./blocks/gallery/components/Galleries/Gallery/Image.module.scss":
/*!***********************************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Gallery/Image.module.scss ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"image":"GnILeVOQV13weqBNNBPn"});

/***/ }),

/***/ "./blocks/gallery/components/Galleries/Masonry.module.scss":
/*!*****************************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Masonry.module.scss ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"galleryContainer":"cgt92h_Pw_KUIHq8sMrO"});

/***/ }),

/***/ "./blocks/gallery/components/Galleries/Masonry/Image.module.scss":
/*!***********************************************************************!*\
  !*** ./blocks/gallery/components/Galleries/Masonry/Image.module.scss ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"image":"DLS4SKjAea3yZImHL0fV","imageContainer":"n1jAlHtO5QzyJKGTfnkD"});

/***/ }),

/***/ "./blocks/gallery/editor.scss":
/*!************************************!*\
  !*** ./blocks/gallery/editor.scss ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/gallery/style.scss":
/*!***********************************!*\
  !*** ./blocks/gallery/style.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/react/cjs/react-jsx-runtime.development.js":
/*!*****************************************************************!*\
  !*** ./node_modules/react/cjs/react-jsx-runtime.development.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";
/**
 * @license React
 * react-jsx-runtime.development.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



if (true) {
  (function() {
'use strict';

var React = __webpack_require__(/*! react */ "react");

// ATTENTION
// When adding new symbols to this file,
// Please consider also adding to 'react-devtools-shared/src/backend/ReactSymbols'
// The Symbol used to tag the ReactElement-like types.
var REACT_ELEMENT_TYPE = Symbol.for('react.element');
var REACT_PORTAL_TYPE = Symbol.for('react.portal');
var REACT_FRAGMENT_TYPE = Symbol.for('react.fragment');
var REACT_STRICT_MODE_TYPE = Symbol.for('react.strict_mode');
var REACT_PROFILER_TYPE = Symbol.for('react.profiler');
var REACT_PROVIDER_TYPE = Symbol.for('react.provider');
var REACT_CONTEXT_TYPE = Symbol.for('react.context');
var REACT_FORWARD_REF_TYPE = Symbol.for('react.forward_ref');
var REACT_SUSPENSE_TYPE = Symbol.for('react.suspense');
var REACT_SUSPENSE_LIST_TYPE = Symbol.for('react.suspense_list');
var REACT_MEMO_TYPE = Symbol.for('react.memo');
var REACT_LAZY_TYPE = Symbol.for('react.lazy');
var REACT_OFFSCREEN_TYPE = Symbol.for('react.offscreen');
var MAYBE_ITERATOR_SYMBOL = Symbol.iterator;
var FAUX_ITERATOR_SYMBOL = '@@iterator';
function getIteratorFn(maybeIterable) {
  if (maybeIterable === null || typeof maybeIterable !== 'object') {
    return null;
  }

  var maybeIterator = MAYBE_ITERATOR_SYMBOL && maybeIterable[MAYBE_ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL];

  if (typeof maybeIterator === 'function') {
    return maybeIterator;
  }

  return null;
}

var ReactSharedInternals = React.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED;

function error(format) {
  {
    {
      for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
        args[_key2 - 1] = arguments[_key2];
      }

      printWarning('error', format, args);
    }
  }
}

function printWarning(level, format, args) {
  // When changing this logic, you might want to also
  // update consoleWithStackDev.www.js as well.
  {
    var ReactDebugCurrentFrame = ReactSharedInternals.ReactDebugCurrentFrame;
    var stack = ReactDebugCurrentFrame.getStackAddendum();

    if (stack !== '') {
      format += '%s';
      args = args.concat([stack]);
    } // eslint-disable-next-line react-internal/safe-string-coercion


    var argsWithFormat = args.map(function (item) {
      return String(item);
    }); // Careful: RN currently depends on this prefix

    argsWithFormat.unshift('Warning: ' + format); // We intentionally don't use spread (or .apply) directly because it
    // breaks IE9: https://github.com/facebook/react/issues/13610
    // eslint-disable-next-line react-internal/no-production-logging

    Function.prototype.apply.call(console[level], console, argsWithFormat);
  }
}

// -----------------------------------------------------------------------------

var enableScopeAPI = false; // Experimental Create Event Handle API.
var enableCacheElement = false;
var enableTransitionTracing = false; // No known bugs, but needs performance testing

var enableLegacyHidden = false; // Enables unstable_avoidThisFallback feature in Fiber
// stuff. Intended to enable React core members to more easily debug scheduling
// issues in DEV builds.

var enableDebugTracing = false; // Track which Fiber(s) schedule render work.

var REACT_MODULE_REFERENCE;

{
  REACT_MODULE_REFERENCE = Symbol.for('react.module.reference');
}

function isValidElementType(type) {
  if (typeof type === 'string' || typeof type === 'function') {
    return true;
  } // Note: typeof might be other than 'symbol' or 'number' (e.g. if it's a polyfill).


  if (type === REACT_FRAGMENT_TYPE || type === REACT_PROFILER_TYPE || enableDebugTracing  || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || enableLegacyHidden  || type === REACT_OFFSCREEN_TYPE || enableScopeAPI  || enableCacheElement  || enableTransitionTracing ) {
    return true;
  }

  if (typeof type === 'object' && type !== null) {
    if (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || // This needs to include all possible module reference object
    // types supported by any Flight configuration anywhere since
    // we don't know which Flight build this will end up being used
    // with.
    type.$$typeof === REACT_MODULE_REFERENCE || type.getModuleId !== undefined) {
      return true;
    }
  }

  return false;
}

function getWrappedName(outerType, innerType, wrapperName) {
  var displayName = outerType.displayName;

  if (displayName) {
    return displayName;
  }

  var functionName = innerType.displayName || innerType.name || '';
  return functionName !== '' ? wrapperName + "(" + functionName + ")" : wrapperName;
} // Keep in sync with react-reconciler/getComponentNameFromFiber


function getContextName(type) {
  return type.displayName || 'Context';
} // Note that the reconciler package should generally prefer to use getComponentNameFromFiber() instead.


function getComponentNameFromType(type) {
  if (type == null) {
    // Host root, text node or just invalid type.
    return null;
  }

  {
    if (typeof type.tag === 'number') {
      error('Received an unexpected object in getComponentNameFromType(). ' + 'This is likely a bug in React. Please file an issue.');
    }
  }

  if (typeof type === 'function') {
    return type.displayName || type.name || null;
  }

  if (typeof type === 'string') {
    return type;
  }

  switch (type) {
    case REACT_FRAGMENT_TYPE:
      return 'Fragment';

    case REACT_PORTAL_TYPE:
      return 'Portal';

    case REACT_PROFILER_TYPE:
      return 'Profiler';

    case REACT_STRICT_MODE_TYPE:
      return 'StrictMode';

    case REACT_SUSPENSE_TYPE:
      return 'Suspense';

    case REACT_SUSPENSE_LIST_TYPE:
      return 'SuspenseList';

  }

  if (typeof type === 'object') {
    switch (type.$$typeof) {
      case REACT_CONTEXT_TYPE:
        var context = type;
        return getContextName(context) + '.Consumer';

      case REACT_PROVIDER_TYPE:
        var provider = type;
        return getContextName(provider._context) + '.Provider';

      case REACT_FORWARD_REF_TYPE:
        return getWrappedName(type, type.render, 'ForwardRef');

      case REACT_MEMO_TYPE:
        var outerName = type.displayName || null;

        if (outerName !== null) {
          return outerName;
        }

        return getComponentNameFromType(type.type) || 'Memo';

      case REACT_LAZY_TYPE:
        {
          var lazyComponent = type;
          var payload = lazyComponent._payload;
          var init = lazyComponent._init;

          try {
            return getComponentNameFromType(init(payload));
          } catch (x) {
            return null;
          }
        }

      // eslint-disable-next-line no-fallthrough
    }
  }

  return null;
}

var assign = Object.assign;

// Helpers to patch console.logs to avoid logging during side-effect free
// replaying on render function. This currently only patches the object
// lazily which won't cover if the log function was extracted eagerly.
// We could also eagerly patch the method.
var disabledDepth = 0;
var prevLog;
var prevInfo;
var prevWarn;
var prevError;
var prevGroup;
var prevGroupCollapsed;
var prevGroupEnd;

function disabledLog() {}

disabledLog.__reactDisabledLog = true;
function disableLogs() {
  {
    if (disabledDepth === 0) {
      /* eslint-disable react-internal/no-production-logging */
      prevLog = console.log;
      prevInfo = console.info;
      prevWarn = console.warn;
      prevError = console.error;
      prevGroup = console.group;
      prevGroupCollapsed = console.groupCollapsed;
      prevGroupEnd = console.groupEnd; // https://github.com/facebook/react/issues/19099

      var props = {
        configurable: true,
        enumerable: true,
        value: disabledLog,
        writable: true
      }; // $FlowFixMe Flow thinks console is immutable.

      Object.defineProperties(console, {
        info: props,
        log: props,
        warn: props,
        error: props,
        group: props,
        groupCollapsed: props,
        groupEnd: props
      });
      /* eslint-enable react-internal/no-production-logging */
    }

    disabledDepth++;
  }
}
function reenableLogs() {
  {
    disabledDepth--;

    if (disabledDepth === 0) {
      /* eslint-disable react-internal/no-production-logging */
      var props = {
        configurable: true,
        enumerable: true,
        writable: true
      }; // $FlowFixMe Flow thinks console is immutable.

      Object.defineProperties(console, {
        log: assign({}, props, {
          value: prevLog
        }),
        info: assign({}, props, {
          value: prevInfo
        }),
        warn: assign({}, props, {
          value: prevWarn
        }),
        error: assign({}, props, {
          value: prevError
        }),
        group: assign({}, props, {
          value: prevGroup
        }),
        groupCollapsed: assign({}, props, {
          value: prevGroupCollapsed
        }),
        groupEnd: assign({}, props, {
          value: prevGroupEnd
        })
      });
      /* eslint-enable react-internal/no-production-logging */
    }

    if (disabledDepth < 0) {
      error('disabledDepth fell below zero. ' + 'This is a bug in React. Please file an issue.');
    }
  }
}

var ReactCurrentDispatcher = ReactSharedInternals.ReactCurrentDispatcher;
var prefix;
function describeBuiltInComponentFrame(name, source, ownerFn) {
  {
    if (prefix === undefined) {
      // Extract the VM specific prefix used by each line.
      try {
        throw Error();
      } catch (x) {
        var match = x.stack.trim().match(/\n( *(at )?)/);
        prefix = match && match[1] || '';
      }
    } // We use the prefix to ensure our stacks line up with native stack frames.


    return '\n' + prefix + name;
  }
}
var reentry = false;
var componentFrameCache;

{
  var PossiblyWeakMap = typeof WeakMap === 'function' ? WeakMap : Map;
  componentFrameCache = new PossiblyWeakMap();
}

function describeNativeComponentFrame(fn, construct) {
  // If something asked for a stack inside a fake render, it should get ignored.
  if ( !fn || reentry) {
    return '';
  }

  {
    var frame = componentFrameCache.get(fn);

    if (frame !== undefined) {
      return frame;
    }
  }

  var control;
  reentry = true;
  var previousPrepareStackTrace = Error.prepareStackTrace; // $FlowFixMe It does accept undefined.

  Error.prepareStackTrace = undefined;
  var previousDispatcher;

  {
    previousDispatcher = ReactCurrentDispatcher.current; // Set the dispatcher in DEV because this might be call in the render function
    // for warnings.

    ReactCurrentDispatcher.current = null;
    disableLogs();
  }

  try {
    // This should throw.
    if (construct) {
      // Something should be setting the props in the constructor.
      var Fake = function () {
        throw Error();
      }; // $FlowFixMe


      Object.defineProperty(Fake.prototype, 'props', {
        set: function () {
          // We use a throwing setter instead of frozen or non-writable props
          // because that won't throw in a non-strict mode function.
          throw Error();
        }
      });

      if (typeof Reflect === 'object' && Reflect.construct) {
        // We construct a different control for this case to include any extra
        // frames added by the construct call.
        try {
          Reflect.construct(Fake, []);
        } catch (x) {
          control = x;
        }

        Reflect.construct(fn, [], Fake);
      } else {
        try {
          Fake.call();
        } catch (x) {
          control = x;
        }

        fn.call(Fake.prototype);
      }
    } else {
      try {
        throw Error();
      } catch (x) {
        control = x;
      }

      fn();
    }
  } catch (sample) {
    // This is inlined manually because closure doesn't do it for us.
    if (sample && control && typeof sample.stack === 'string') {
      // This extracts the first frame from the sample that isn't also in the control.
      // Skipping one frame that we assume is the frame that calls the two.
      var sampleLines = sample.stack.split('\n');
      var controlLines = control.stack.split('\n');
      var s = sampleLines.length - 1;
      var c = controlLines.length - 1;

      while (s >= 1 && c >= 0 && sampleLines[s] !== controlLines[c]) {
        // We expect at least one stack frame to be shared.
        // Typically this will be the root most one. However, stack frames may be
        // cut off due to maximum stack limits. In this case, one maybe cut off
        // earlier than the other. We assume that the sample is longer or the same
        // and there for cut off earlier. So we should find the root most frame in
        // the sample somewhere in the control.
        c--;
      }

      for (; s >= 1 && c >= 0; s--, c--) {
        // Next we find the first one that isn't the same which should be the
        // frame that called our sample function and the control.
        if (sampleLines[s] !== controlLines[c]) {
          // In V8, the first line is describing the message but other VMs don't.
          // If we're about to return the first line, and the control is also on the same
          // line, that's a pretty good indicator that our sample threw at same line as
          // the control. I.e. before we entered the sample frame. So we ignore this result.
          // This can happen if you passed a class to function component, or non-function.
          if (s !== 1 || c !== 1) {
            do {
              s--;
              c--; // We may still have similar intermediate frames from the construct call.
              // The next one that isn't the same should be our match though.

              if (c < 0 || sampleLines[s] !== controlLines[c]) {
                // V8 adds a "new" prefix for native classes. Let's remove it to make it prettier.
                var _frame = '\n' + sampleLines[s].replace(' at new ', ' at '); // If our component frame is labeled "<anonymous>"
                // but we have a user-provided "displayName"
                // splice it in to make the stack more readable.


                if (fn.displayName && _frame.includes('<anonymous>')) {
                  _frame = _frame.replace('<anonymous>', fn.displayName);
                }

                {
                  if (typeof fn === 'function') {
                    componentFrameCache.set(fn, _frame);
                  }
                } // Return the line we found.


                return _frame;
              }
            } while (s >= 1 && c >= 0);
          }

          break;
        }
      }
    }
  } finally {
    reentry = false;

    {
      ReactCurrentDispatcher.current = previousDispatcher;
      reenableLogs();
    }

    Error.prepareStackTrace = previousPrepareStackTrace;
  } // Fallback to just using the name if we couldn't make it throw.


  var name = fn ? fn.displayName || fn.name : '';
  var syntheticFrame = name ? describeBuiltInComponentFrame(name) : '';

  {
    if (typeof fn === 'function') {
      componentFrameCache.set(fn, syntheticFrame);
    }
  }

  return syntheticFrame;
}
function describeFunctionComponentFrame(fn, source, ownerFn) {
  {
    return describeNativeComponentFrame(fn, false);
  }
}

function shouldConstruct(Component) {
  var prototype = Component.prototype;
  return !!(prototype && prototype.isReactComponent);
}

function describeUnknownElementTypeFrameInDEV(type, source, ownerFn) {

  if (type == null) {
    return '';
  }

  if (typeof type === 'function') {
    {
      return describeNativeComponentFrame(type, shouldConstruct(type));
    }
  }

  if (typeof type === 'string') {
    return describeBuiltInComponentFrame(type);
  }

  switch (type) {
    case REACT_SUSPENSE_TYPE:
      return describeBuiltInComponentFrame('Suspense');

    case REACT_SUSPENSE_LIST_TYPE:
      return describeBuiltInComponentFrame('SuspenseList');
  }

  if (typeof type === 'object') {
    switch (type.$$typeof) {
      case REACT_FORWARD_REF_TYPE:
        return describeFunctionComponentFrame(type.render);

      case REACT_MEMO_TYPE:
        // Memo may contain any component type so we recursively resolve it.
        return describeUnknownElementTypeFrameInDEV(type.type, source, ownerFn);

      case REACT_LAZY_TYPE:
        {
          var lazyComponent = type;
          var payload = lazyComponent._payload;
          var init = lazyComponent._init;

          try {
            // Lazy may contain any component type so we recursively resolve it.
            return describeUnknownElementTypeFrameInDEV(init(payload), source, ownerFn);
          } catch (x) {}
        }
    }
  }

  return '';
}

var hasOwnProperty = Object.prototype.hasOwnProperty;

var loggedTypeFailures = {};
var ReactDebugCurrentFrame = ReactSharedInternals.ReactDebugCurrentFrame;

function setCurrentlyValidatingElement(element) {
  {
    if (element) {
      var owner = element._owner;
      var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
      ReactDebugCurrentFrame.setExtraStackFrame(stack);
    } else {
      ReactDebugCurrentFrame.setExtraStackFrame(null);
    }
  }
}

function checkPropTypes(typeSpecs, values, location, componentName, element) {
  {
    // $FlowFixMe This is okay but Flow doesn't know it.
    var has = Function.call.bind(hasOwnProperty);

    for (var typeSpecName in typeSpecs) {
      if (has(typeSpecs, typeSpecName)) {
        var error$1 = void 0; // Prop type validation may throw. In case they do, we don't want to
        // fail the render phase where it didn't fail before. So we log it.
        // After these have been cleaned up, we'll let them throw.

        try {
          // This is intentionally an invariant that gets caught. It's the same
          // behavior as without this statement except with a better message.
          if (typeof typeSpecs[typeSpecName] !== 'function') {
            // eslint-disable-next-line react-internal/prod-error-codes
            var err = Error((componentName || 'React class') + ': ' + location + ' type `' + typeSpecName + '` is invalid; ' + 'it must be a function, usually from the `prop-types` package, but received `' + typeof typeSpecs[typeSpecName] + '`.' + 'This often happens because of typos such as `PropTypes.function` instead of `PropTypes.func`.');
            err.name = 'Invariant Violation';
            throw err;
          }

          error$1 = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, 'SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED');
        } catch (ex) {
          error$1 = ex;
        }

        if (error$1 && !(error$1 instanceof Error)) {
          setCurrentlyValidatingElement(element);

          error('%s: type specification of %s' + ' `%s` is invalid; the type checker ' + 'function must return `null` or an `Error` but returned a %s. ' + 'You may have forgotten to pass an argument to the type checker ' + 'creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and ' + 'shape all require an argument).', componentName || 'React class', location, typeSpecName, typeof error$1);

          setCurrentlyValidatingElement(null);
        }

        if (error$1 instanceof Error && !(error$1.message in loggedTypeFailures)) {
          // Only monitor this failure once because there tends to be a lot of the
          // same error.
          loggedTypeFailures[error$1.message] = true;
          setCurrentlyValidatingElement(element);

          error('Failed %s type: %s', location, error$1.message);

          setCurrentlyValidatingElement(null);
        }
      }
    }
  }
}

var isArrayImpl = Array.isArray; // eslint-disable-next-line no-redeclare

function isArray(a) {
  return isArrayImpl(a);
}

/*
 * The `'' + value` pattern (used in in perf-sensitive code) throws for Symbol
 * and Temporal.* types. See https://github.com/facebook/react/pull/22064.
 *
 * The functions in this module will throw an easier-to-understand,
 * easier-to-debug exception with a clear errors message message explaining the
 * problem. (Instead of a confusing exception thrown inside the implementation
 * of the `value` object).
 */
// $FlowFixMe only called in DEV, so void return is not possible.
function typeName(value) {
  {
    // toStringTag is needed for namespaced types like Temporal.Instant
    var hasToStringTag = typeof Symbol === 'function' && Symbol.toStringTag;
    var type = hasToStringTag && value[Symbol.toStringTag] || value.constructor.name || 'Object';
    return type;
  }
} // $FlowFixMe only called in DEV, so void return is not possible.


function willCoercionThrow(value) {
  {
    try {
      testStringCoercion(value);
      return false;
    } catch (e) {
      return true;
    }
  }
}

function testStringCoercion(value) {
  // If you ended up here by following an exception call stack, here's what's
  // happened: you supplied an object or symbol value to React (as a prop, key,
  // DOM attribute, CSS property, string ref, etc.) and when React tried to
  // coerce it to a string using `'' + value`, an exception was thrown.
  //
  // The most common types that will cause this exception are `Symbol` instances
  // and Temporal objects like `Temporal.Instant`. But any object that has a
  // `valueOf` or `[Symbol.toPrimitive]` method that throws will also cause this
  // exception. (Library authors do this to prevent users from using built-in
  // numeric operators like `+` or comparison operators like `>=` because custom
  // methods are needed to perform accurate arithmetic or comparison.)
  //
  // To fix the problem, coerce this object or symbol value to a string before
  // passing it to React. The most reliable way is usually `String(value)`.
  //
  // To find which value is throwing, check the browser or debugger console.
  // Before this exception was thrown, there should be `console.error` output
  // that shows the type (Symbol, Temporal.PlainDate, etc.) that caused the
  // problem and how that type was used: key, atrribute, input value prop, etc.
  // In most cases, this console output also shows the component and its
  // ancestor components where the exception happened.
  //
  // eslint-disable-next-line react-internal/safe-string-coercion
  return '' + value;
}
function checkKeyStringCoercion(value) {
  {
    if (willCoercionThrow(value)) {
      error('The provided key is an unsupported type %s.' + ' This value must be coerced to a string before before using it here.', typeName(value));

      return testStringCoercion(value); // throw (to help callers find troubleshooting comments)
    }
  }
}

var ReactCurrentOwner = ReactSharedInternals.ReactCurrentOwner;
var RESERVED_PROPS = {
  key: true,
  ref: true,
  __self: true,
  __source: true
};
var specialPropKeyWarningShown;
var specialPropRefWarningShown;
var didWarnAboutStringRefs;

{
  didWarnAboutStringRefs = {};
}

function hasValidRef(config) {
  {
    if (hasOwnProperty.call(config, 'ref')) {
      var getter = Object.getOwnPropertyDescriptor(config, 'ref').get;

      if (getter && getter.isReactWarning) {
        return false;
      }
    }
  }

  return config.ref !== undefined;
}

function hasValidKey(config) {
  {
    if (hasOwnProperty.call(config, 'key')) {
      var getter = Object.getOwnPropertyDescriptor(config, 'key').get;

      if (getter && getter.isReactWarning) {
        return false;
      }
    }
  }

  return config.key !== undefined;
}

function warnIfStringRefCannotBeAutoConverted(config, self) {
  {
    if (typeof config.ref === 'string' && ReactCurrentOwner.current && self && ReactCurrentOwner.current.stateNode !== self) {
      var componentName = getComponentNameFromType(ReactCurrentOwner.current.type);

      if (!didWarnAboutStringRefs[componentName]) {
        error('Component "%s" contains the string ref "%s". ' + 'Support for string refs will be removed in a future major release. ' + 'This case cannot be automatically converted to an arrow function. ' + 'We ask you to manually fix this case by using useRef() or createRef() instead. ' + 'Learn more about using refs safely here: ' + 'https://reactjs.org/link/strict-mode-string-ref', getComponentNameFromType(ReactCurrentOwner.current.type), config.ref);

        didWarnAboutStringRefs[componentName] = true;
      }
    }
  }
}

function defineKeyPropWarningGetter(props, displayName) {
  {
    var warnAboutAccessingKey = function () {
      if (!specialPropKeyWarningShown) {
        specialPropKeyWarningShown = true;

        error('%s: `key` is not a prop. Trying to access it will result ' + 'in `undefined` being returned. If you need to access the same ' + 'value within the child component, you should pass it as a different ' + 'prop. (https://reactjs.org/link/special-props)', displayName);
      }
    };

    warnAboutAccessingKey.isReactWarning = true;
    Object.defineProperty(props, 'key', {
      get: warnAboutAccessingKey,
      configurable: true
    });
  }
}

function defineRefPropWarningGetter(props, displayName) {
  {
    var warnAboutAccessingRef = function () {
      if (!specialPropRefWarningShown) {
        specialPropRefWarningShown = true;

        error('%s: `ref` is not a prop. Trying to access it will result ' + 'in `undefined` being returned. If you need to access the same ' + 'value within the child component, you should pass it as a different ' + 'prop. (https://reactjs.org/link/special-props)', displayName);
      }
    };

    warnAboutAccessingRef.isReactWarning = true;
    Object.defineProperty(props, 'ref', {
      get: warnAboutAccessingRef,
      configurable: true
    });
  }
}
/**
 * Factory method to create a new React element. This no longer adheres to
 * the class pattern, so do not use new to call it. Also, instanceof check
 * will not work. Instead test $$typeof field against Symbol.for('react.element') to check
 * if something is a React Element.
 *
 * @param {*} type
 * @param {*} props
 * @param {*} key
 * @param {string|object} ref
 * @param {*} owner
 * @param {*} self A *temporary* helper to detect places where `this` is
 * different from the `owner` when React.createElement is called, so that we
 * can warn. We want to get rid of owner and replace string `ref`s with arrow
 * functions, and as long as `this` and owner are the same, there will be no
 * change in behavior.
 * @param {*} source An annotation object (added by a transpiler or otherwise)
 * indicating filename, line number, and/or other information.
 * @internal
 */


var ReactElement = function (type, key, ref, self, source, owner, props) {
  var element = {
    // This tag allows us to uniquely identify this as a React Element
    $$typeof: REACT_ELEMENT_TYPE,
    // Built-in properties that belong on the element
    type: type,
    key: key,
    ref: ref,
    props: props,
    // Record the component responsible for creating this element.
    _owner: owner
  };

  {
    // The validation flag is currently mutative. We put it on
    // an external backing store so that we can freeze the whole object.
    // This can be replaced with a WeakMap once they are implemented in
    // commonly used development environments.
    element._store = {}; // To make comparing ReactElements easier for testing purposes, we make
    // the validation flag non-enumerable (where possible, which should
    // include every environment we run tests in), so the test framework
    // ignores it.

    Object.defineProperty(element._store, 'validated', {
      configurable: false,
      enumerable: false,
      writable: true,
      value: false
    }); // self and source are DEV only properties.

    Object.defineProperty(element, '_self', {
      configurable: false,
      enumerable: false,
      writable: false,
      value: self
    }); // Two elements created in two different places should be considered
    // equal for testing purposes and therefore we hide it from enumeration.

    Object.defineProperty(element, '_source', {
      configurable: false,
      enumerable: false,
      writable: false,
      value: source
    });

    if (Object.freeze) {
      Object.freeze(element.props);
      Object.freeze(element);
    }
  }

  return element;
};
/**
 * https://github.com/reactjs/rfcs/pull/107
 * @param {*} type
 * @param {object} props
 * @param {string} key
 */

function jsxDEV(type, config, maybeKey, source, self) {
  {
    var propName; // Reserved names are extracted

    var props = {};
    var key = null;
    var ref = null; // Currently, key can be spread in as a prop. This causes a potential
    // issue if key is also explicitly declared (ie. <div {...props} key="Hi" />
    // or <div key="Hi" {...props} /> ). We want to deprecate key spread,
    // but as an intermediary step, we will use jsxDEV for everything except
    // <div {...props} key="Hi" />, because we aren't currently able to tell if
    // key is explicitly declared to be undefined or not.

    if (maybeKey !== undefined) {
      {
        checkKeyStringCoercion(maybeKey);
      }

      key = '' + maybeKey;
    }

    if (hasValidKey(config)) {
      {
        checkKeyStringCoercion(config.key);
      }

      key = '' + config.key;
    }

    if (hasValidRef(config)) {
      ref = config.ref;
      warnIfStringRefCannotBeAutoConverted(config, self);
    } // Remaining properties are added to a new props object


    for (propName in config) {
      if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
        props[propName] = config[propName];
      }
    } // Resolve default props


    if (type && type.defaultProps) {
      var defaultProps = type.defaultProps;

      for (propName in defaultProps) {
        if (props[propName] === undefined) {
          props[propName] = defaultProps[propName];
        }
      }
    }

    if (key || ref) {
      var displayName = typeof type === 'function' ? type.displayName || type.name || 'Unknown' : type;

      if (key) {
        defineKeyPropWarningGetter(props, displayName);
      }

      if (ref) {
        defineRefPropWarningGetter(props, displayName);
      }
    }

    return ReactElement(type, key, ref, self, source, ReactCurrentOwner.current, props);
  }
}

var ReactCurrentOwner$1 = ReactSharedInternals.ReactCurrentOwner;
var ReactDebugCurrentFrame$1 = ReactSharedInternals.ReactDebugCurrentFrame;

function setCurrentlyValidatingElement$1(element) {
  {
    if (element) {
      var owner = element._owner;
      var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
      ReactDebugCurrentFrame$1.setExtraStackFrame(stack);
    } else {
      ReactDebugCurrentFrame$1.setExtraStackFrame(null);
    }
  }
}

var propTypesMisspellWarningShown;

{
  propTypesMisspellWarningShown = false;
}
/**
 * Verifies the object is a ReactElement.
 * See https://reactjs.org/docs/react-api.html#isvalidelement
 * @param {?object} object
 * @return {boolean} True if `object` is a ReactElement.
 * @final
 */


function isValidElement(object) {
  {
    return typeof object === 'object' && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
  }
}

function getDeclarationErrorAddendum() {
  {
    if (ReactCurrentOwner$1.current) {
      var name = getComponentNameFromType(ReactCurrentOwner$1.current.type);

      if (name) {
        return '\n\nCheck the render method of `' + name + '`.';
      }
    }

    return '';
  }
}

function getSourceInfoErrorAddendum(source) {
  {
    if (source !== undefined) {
      var fileName = source.fileName.replace(/^.*[\\\/]/, '');
      var lineNumber = source.lineNumber;
      return '\n\nCheck your code at ' + fileName + ':' + lineNumber + '.';
    }

    return '';
  }
}
/**
 * Warn if there's no key explicitly set on dynamic arrays of children or
 * object keys are not valid. This allows us to keep track of children between
 * updates.
 */


var ownerHasKeyUseWarning = {};

function getCurrentComponentErrorInfo(parentType) {
  {
    var info = getDeclarationErrorAddendum();

    if (!info) {
      var parentName = typeof parentType === 'string' ? parentType : parentType.displayName || parentType.name;

      if (parentName) {
        info = "\n\nCheck the top-level render call using <" + parentName + ">.";
      }
    }

    return info;
  }
}
/**
 * Warn if the element doesn't have an explicit key assigned to it.
 * This element is in an array. The array could grow and shrink or be
 * reordered. All children that haven't already been validated are required to
 * have a "key" property assigned to it. Error statuses are cached so a warning
 * will only be shown once.
 *
 * @internal
 * @param {ReactElement} element Element that requires a key.
 * @param {*} parentType element's parent's type.
 */


function validateExplicitKey(element, parentType) {
  {
    if (!element._store || element._store.validated || element.key != null) {
      return;
    }

    element._store.validated = true;
    var currentComponentErrorInfo = getCurrentComponentErrorInfo(parentType);

    if (ownerHasKeyUseWarning[currentComponentErrorInfo]) {
      return;
    }

    ownerHasKeyUseWarning[currentComponentErrorInfo] = true; // Usually the current owner is the offender, but if it accepts children as a
    // property, it may be the creator of the child that's responsible for
    // assigning it a key.

    var childOwner = '';

    if (element && element._owner && element._owner !== ReactCurrentOwner$1.current) {
      // Give the component that originally created this child.
      childOwner = " It was passed a child from " + getComponentNameFromType(element._owner.type) + ".";
    }

    setCurrentlyValidatingElement$1(element);

    error('Each child in a list should have a unique "key" prop.' + '%s%s See https://reactjs.org/link/warning-keys for more information.', currentComponentErrorInfo, childOwner);

    setCurrentlyValidatingElement$1(null);
  }
}
/**
 * Ensure that every element either is passed in a static location, in an
 * array with an explicit keys property defined, or in an object literal
 * with valid key property.
 *
 * @internal
 * @param {ReactNode} node Statically passed child of any type.
 * @param {*} parentType node's parent's type.
 */


function validateChildKeys(node, parentType) {
  {
    if (typeof node !== 'object') {
      return;
    }

    if (isArray(node)) {
      for (var i = 0; i < node.length; i++) {
        var child = node[i];

        if (isValidElement(child)) {
          validateExplicitKey(child, parentType);
        }
      }
    } else if (isValidElement(node)) {
      // This element was passed in a valid location.
      if (node._store) {
        node._store.validated = true;
      }
    } else if (node) {
      var iteratorFn = getIteratorFn(node);

      if (typeof iteratorFn === 'function') {
        // Entry iterators used to provide implicit keys,
        // but now we print a separate warning for them later.
        if (iteratorFn !== node.entries) {
          var iterator = iteratorFn.call(node);
          var step;

          while (!(step = iterator.next()).done) {
            if (isValidElement(step.value)) {
              validateExplicitKey(step.value, parentType);
            }
          }
        }
      }
    }
  }
}
/**
 * Given an element, validate that its props follow the propTypes definition,
 * provided by the type.
 *
 * @param {ReactElement} element
 */


function validatePropTypes(element) {
  {
    var type = element.type;

    if (type === null || type === undefined || typeof type === 'string') {
      return;
    }

    var propTypes;

    if (typeof type === 'function') {
      propTypes = type.propTypes;
    } else if (typeof type === 'object' && (type.$$typeof === REACT_FORWARD_REF_TYPE || // Note: Memo only checks outer props here.
    // Inner props are checked in the reconciler.
    type.$$typeof === REACT_MEMO_TYPE)) {
      propTypes = type.propTypes;
    } else {
      return;
    }

    if (propTypes) {
      // Intentionally inside to avoid triggering lazy initializers:
      var name = getComponentNameFromType(type);
      checkPropTypes(propTypes, element.props, 'prop', name, element);
    } else if (type.PropTypes !== undefined && !propTypesMisspellWarningShown) {
      propTypesMisspellWarningShown = true; // Intentionally inside to avoid triggering lazy initializers:

      var _name = getComponentNameFromType(type);

      error('Component %s declared `PropTypes` instead of `propTypes`. Did you misspell the property assignment?', _name || 'Unknown');
    }

    if (typeof type.getDefaultProps === 'function' && !type.getDefaultProps.isReactClassApproved) {
      error('getDefaultProps is only used on classic React.createClass ' + 'definitions. Use a static property named `defaultProps` instead.');
    }
  }
}
/**
 * Given a fragment, validate that it can only be provided with fragment props
 * @param {ReactElement} fragment
 */


function validateFragmentProps(fragment) {
  {
    var keys = Object.keys(fragment.props);

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];

      if (key !== 'children' && key !== 'key') {
        setCurrentlyValidatingElement$1(fragment);

        error('Invalid prop `%s` supplied to `React.Fragment`. ' + 'React.Fragment can only have `key` and `children` props.', key);

        setCurrentlyValidatingElement$1(null);
        break;
      }
    }

    if (fragment.ref !== null) {
      setCurrentlyValidatingElement$1(fragment);

      error('Invalid attribute `ref` supplied to `React.Fragment`.');

      setCurrentlyValidatingElement$1(null);
    }
  }
}

function jsxWithValidation(type, props, key, isStaticChildren, source, self) {
  {
    var validType = isValidElementType(type); // We warn in this case but don't throw. We expect the element creation to
    // succeed and there will likely be errors in render.

    if (!validType) {
      var info = '';

      if (type === undefined || typeof type === 'object' && type !== null && Object.keys(type).length === 0) {
        info += ' You likely forgot to export your component from the file ' + "it's defined in, or you might have mixed up default and named imports.";
      }

      var sourceInfo = getSourceInfoErrorAddendum(source);

      if (sourceInfo) {
        info += sourceInfo;
      } else {
        info += getDeclarationErrorAddendum();
      }

      var typeString;

      if (type === null) {
        typeString = 'null';
      } else if (isArray(type)) {
        typeString = 'array';
      } else if (type !== undefined && type.$$typeof === REACT_ELEMENT_TYPE) {
        typeString = "<" + (getComponentNameFromType(type.type) || 'Unknown') + " />";
        info = ' Did you accidentally export a JSX literal instead of a component?';
      } else {
        typeString = typeof type;
      }

      error('React.jsx: type is invalid -- expected a string (for ' + 'built-in components) or a class/function (for composite ' + 'components) but got: %s.%s', typeString, info);
    }

    var element = jsxDEV(type, props, key, source, self); // The result can be nullish if a mock or a custom function is used.
    // TODO: Drop this when these are no longer allowed as the type argument.

    if (element == null) {
      return element;
    } // Skip key warning if the type isn't valid since our key validation logic
    // doesn't expect a non-string/function type and can throw confusing errors.
    // We don't want exception behavior to differ between dev and prod.
    // (Rendering will throw with a helpful message and as soon as the type is
    // fixed, the key warnings will appear.)


    if (validType) {
      var children = props.children;

      if (children !== undefined) {
        if (isStaticChildren) {
          if (isArray(children)) {
            for (var i = 0; i < children.length; i++) {
              validateChildKeys(children[i], type);
            }

            if (Object.freeze) {
              Object.freeze(children);
            }
          } else {
            error('React.jsx: Static children should always be an array. ' + 'You are likely explicitly calling React.jsxs or React.jsxDEV. ' + 'Use the Babel transform instead.');
          }
        } else {
          validateChildKeys(children, type);
        }
      }
    }

    if (type === REACT_FRAGMENT_TYPE) {
      validateFragmentProps(element);
    } else {
      validatePropTypes(element);
    }

    return element;
  }
} // These two functions exist to still get child warnings in dev
// even with the prod transform. This means that jsxDEV is purely
// opt-in behavior for better messages but that we won't stop
// giving you warnings if you use production apis.

function jsxWithValidationStatic(type, props, key) {
  {
    return jsxWithValidation(type, props, key, true);
  }
}
function jsxWithValidationDynamic(type, props, key) {
  {
    return jsxWithValidation(type, props, key, false);
  }
}

var jsx =  jsxWithValidationDynamic ; // we may want to special case jsxs internally to take advantage of static children.
// for now we can ship identical prod functions

var jsxs =  jsxWithValidationStatic ;

exports.Fragment = REACT_FRAGMENT_TYPE;
exports.jsx = jsx;
exports.jsxs = jsxs;
  })();
}


/***/ }),

/***/ "./node_modules/react/jsx-runtime.js":
/*!*******************************************!*\
  !*** ./node_modules/react/jsx-runtime.js ***!
  \*******************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";


if (false) {} else {
  module.exports = __webpack_require__(/*! ./cjs/react-jsx-runtime.development.js */ "./node_modules/react/cjs/react-jsx-runtime.development.js");
}


/***/ }),

/***/ "./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim.development.js":
/*!**********************************************************************************************!*\
  !*** ./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim.development.js ***!
  \**********************************************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";
/**
 * @license React
 * use-sync-external-store-shim.development.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



if (true) {
  (function() {

          'use strict';

/* global __REACT_DEVTOOLS_GLOBAL_HOOK__ */
if (
  typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ !== 'undefined' &&
  typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart ===
    'function'
) {
  __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart(new Error());
}
          var React = __webpack_require__(/*! react */ "react");

var ReactSharedInternals = React.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED;

function error(format) {
  {
    {
      for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
        args[_key2 - 1] = arguments[_key2];
      }

      printWarning('error', format, args);
    }
  }
}

function printWarning(level, format, args) {
  // When changing this logic, you might want to also
  // update consoleWithStackDev.www.js as well.
  {
    var ReactDebugCurrentFrame = ReactSharedInternals.ReactDebugCurrentFrame;
    var stack = ReactDebugCurrentFrame.getStackAddendum();

    if (stack !== '') {
      format += '%s';
      args = args.concat([stack]);
    } // eslint-disable-next-line react-internal/safe-string-coercion


    var argsWithFormat = args.map(function (item) {
      return String(item);
    }); // Careful: RN currently depends on this prefix

    argsWithFormat.unshift('Warning: ' + format); // We intentionally don't use spread (or .apply) directly because it
    // breaks IE9: https://github.com/facebook/react/issues/13610
    // eslint-disable-next-line react-internal/no-production-logging

    Function.prototype.apply.call(console[level], console, argsWithFormat);
  }
}

/**
 * inlined Object.is polyfill to avoid requiring consumers ship their own
 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is
 */
function is(x, y) {
  return x === y && (x !== 0 || 1 / x === 1 / y) || x !== x && y !== y // eslint-disable-line no-self-compare
  ;
}

var objectIs = typeof Object.is === 'function' ? Object.is : is;

// dispatch for CommonJS interop named imports.

var useState = React.useState,
    useEffect = React.useEffect,
    useLayoutEffect = React.useLayoutEffect,
    useDebugValue = React.useDebugValue;
var didWarnOld18Alpha = false;
var didWarnUncachedGetSnapshot = false; // Disclaimer: This shim breaks many of the rules of React, and only works
// because of a very particular set of implementation details and assumptions
// -- change any one of them and it will break. The most important assumption
// is that updates are always synchronous, because concurrent rendering is
// only available in versions of React that also have a built-in
// useSyncExternalStore API. And we only use this shim when the built-in API
// does not exist.
//
// Do not assume that the clever hacks used by this hook also work in general.
// The point of this shim is to replace the need for hacks by other libraries.

function useSyncExternalStore(subscribe, getSnapshot, // Note: The shim does not use getServerSnapshot, because pre-18 versions of
// React do not expose a way to check if we're hydrating. So users of the shim
// will need to track that themselves and return the correct value
// from `getSnapshot`.
getServerSnapshot) {
  {
    if (!didWarnOld18Alpha) {
      if (React.startTransition !== undefined) {
        didWarnOld18Alpha = true;

        error('You are using an outdated, pre-release alpha of React 18 that ' + 'does not support useSyncExternalStore. The ' + 'use-sync-external-store shim will not work correctly. Upgrade ' + 'to a newer pre-release.');
      }
    }
  } // Read the current snapshot from the store on every render. Again, this
  // breaks the rules of React, and only works here because of specific
  // implementation details, most importantly that updates are
  // always synchronous.


  var value = getSnapshot();

  {
    if (!didWarnUncachedGetSnapshot) {
      var cachedValue = getSnapshot();

      if (!objectIs(value, cachedValue)) {
        error('The result of getSnapshot should be cached to avoid an infinite loop');

        didWarnUncachedGetSnapshot = true;
      }
    }
  } // Because updates are synchronous, we don't queue them. Instead we force a
  // re-render whenever the subscribed state changes by updating an some
  // arbitrary useState hook. Then, during render, we call getSnapshot to read
  // the current value.
  //
  // Because we don't actually use the state returned by the useState hook, we
  // can save a bit of memory by storing other stuff in that slot.
  //
  // To implement the early bailout, we need to track some things on a mutable
  // object. Usually, we would put that in a useRef hook, but we can stash it in
  // our useState hook instead.
  //
  // To force a re-render, we call forceUpdate({inst}). That works because the
  // new object always fails an equality check.


  var _useState = useState({
    inst: {
      value: value,
      getSnapshot: getSnapshot
    }
  }),
      inst = _useState[0].inst,
      forceUpdate = _useState[1]; // Track the latest getSnapshot function with a ref. This needs to be updated
  // in the layout phase so we can access it during the tearing check that
  // happens on subscribe.


  useLayoutEffect(function () {
    inst.value = value;
    inst.getSnapshot = getSnapshot; // Whenever getSnapshot or subscribe changes, we need to check in the
    // commit phase if there was an interleaved mutation. In concurrent mode
    // this can happen all the time, but even in synchronous mode, an earlier
    // effect may have mutated the store.

    if (checkIfSnapshotChanged(inst)) {
      // Force a re-render.
      forceUpdate({
        inst: inst
      });
    }
  }, [subscribe, value, getSnapshot]);
  useEffect(function () {
    // Check for changes right before subscribing. Subsequent changes will be
    // detected in the subscription handler.
    if (checkIfSnapshotChanged(inst)) {
      // Force a re-render.
      forceUpdate({
        inst: inst
      });
    }

    var handleStoreChange = function () {
      // TODO: Because there is no cross-renderer API for batching updates, it's
      // up to the consumer of this library to wrap their subscription event
      // with unstable_batchedUpdates. Should we try to detect when this isn't
      // the case and print a warning in development?
      // The store changed. Check if the snapshot changed since the last time we
      // read from the store.
      if (checkIfSnapshotChanged(inst)) {
        // Force a re-render.
        forceUpdate({
          inst: inst
        });
      }
    }; // Subscribe to the store and return a clean-up function.


    return subscribe(handleStoreChange);
  }, [subscribe]);
  useDebugValue(value);
  return value;
}

function checkIfSnapshotChanged(inst) {
  var latestGetSnapshot = inst.getSnapshot;
  var prevValue = inst.value;

  try {
    var nextValue = latestGetSnapshot();
    return !objectIs(prevValue, nextValue);
  } catch (error) {
    return true;
  }
}

function useSyncExternalStore$1(subscribe, getSnapshot, getServerSnapshot) {
  // Note: The shim does not use getServerSnapshot, because pre-18 versions of
  // React do not expose a way to check if we're hydrating. So users of the shim
  // will need to track that themselves and return the correct value
  // from `getSnapshot`.
  return getSnapshot();
}

var canUseDOM = !!(typeof window !== 'undefined' && typeof window.document !== 'undefined' && typeof window.document.createElement !== 'undefined');

var isServerEnvironment = !canUseDOM;

var shim = isServerEnvironment ? useSyncExternalStore$1 : useSyncExternalStore;
var useSyncExternalStore$2 = React.useSyncExternalStore !== undefined ? React.useSyncExternalStore : shim;

exports.useSyncExternalStore = useSyncExternalStore$2;
          /* global __REACT_DEVTOOLS_GLOBAL_HOOK__ */
if (
  typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ !== 'undefined' &&
  typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop ===
    'function'
) {
  __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop(new Error());
}
        
  })();
}


/***/ }),

/***/ "./node_modules/use-sync-external-store/shim/index.js":
/*!************************************************************!*\
  !*** ./node_modules/use-sync-external-store/shim/index.js ***!
  \************************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";


if (false) {} else {
  module.exports = __webpack_require__(/*! ../cjs/use-sync-external-store-shim.development.js */ "./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim.development.js");
}


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/react-masonry/dist/index.js":
/*!**************************************************!*\
  !*** ./node_modules/react-masonry/dist/index.js ***!
  \**************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Masonry: function() { return /* binding */ ft; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
var k=Object.defineProperty,q=Object.defineProperties;var G=Object.getOwnPropertyDescriptors;var h=Object.getOwnPropertySymbols;var P=Object.prototype.hasOwnProperty,v=Object.prototype.propertyIsEnumerable;var w=(t,o,e)=>o in t?k(t,o,{enumerable:!0,configurable:!0,writable:!0,value:e}):t[o]=e,l=(t,o)=>{for(var e in o||(o={}))P.call(o,e)&&w(t,e,o[e]);if(h)for(var e of h(o))v.call(o,e)&&w(t,e,o[e]);return t},c=(t,o)=>q(t,G(o));var R=(t,o)=>{var e={};for(var n in t)P.call(t,n)&&o.indexOf(n)<0&&(e[n]=t[n]);if(t!=null&&h)for(var n of h(t))o.indexOf(n)<0&&v.call(t,n)&&(e[n]=t[n]);return e};var I=t=>t.right-t.left<5||t.bottom&&t.bottom-t.top<5,J=({spotsList:t,usedSpot:o})=>t.some(e=>e!==o&&o.left===e.left),K=({position:t,spot:o,stone:e})=>{if(t.left>o.left&&o.right>=t.left&&t.top+e.height>o.top){if(o.bottom&&o.bottom<t.top)return o;let n=l({},o);return n.right=t.left,n}return null},Q=({position:t,stone:o,spot:e})=>{if(t.left+o.width>e.left&&t.top>=e.top){if(e.bottom&&e.bottom<t.top||e.right<t.left)return e;let n=l({},e);return n.bottom=t.top,n}return null},V=({stone:t,position:o,spotsList:e,optimalSpot:n})=>{let r=l({},n);return r.left=o.left+t.width,I(r)||J({usedSpot:r,spotsList:e})?null:r},M=({spots:t,position:o,optimalSpot:e,stone:n})=>t.map((r,i,s)=>{if(r===e)return V({stone:n,position:o,optimalSpot:e,spotsList:s});let u=K({position:o,spot:r,stone:n});if(u)return u;let p=Q({position:o,stone:n,spot:r});return p||r});function W(t,o){for(let e=0,n=o.length;e<n;e++){let r=o[e];if(t(r))return r}return null}var x=(t,o)=>o.filter(t),T=(t,o)=>[...o].sort(t);var X=(t,o)=>t.top===o.top?t.left<o.left?-1:1:t.top<o.top?-1:1,H=t=>T(X,t);var C=({availableSpots:t,optimalSpot:o,containerSize:e,stone:n})=>{let i={right:e,top:o.top+n.height,left:o.left};o.bottom&&(i.bottom=o.bottom);for(let s=0,u=t.length;s<u;s+=1){let p=t[s];if(i.left<p.left&&i.top<p.top){i.right=p.left;break}}return i},Y=(t,o)=>{let e=t.right-t.left>=o.width;if(!t.bottom)return e;let n=t.bottom-t.top>=o.height;return e&&n},E=({availableSpots:t,stone:o})=>W(e=>Y(e,o),t);function L({stone:t,availableSpots:o,containerSize:e}){let n=E({availableSpots:o,stone:t}),r={left:n.left,top:n.top},i=C({optimalSpot:n,availableSpots:o.filter(p=>p!==n),stone:t,containerSize:e}),s=[...o,i],u=M({spots:s,position:r,optimalSpot:n,stone:t});return s=[...x(Boolean,u)],s=H(s),{position:r,availableSpots:s}}var z=({stones:t,containerSize:o})=>{let e={positions:[],containerHeight:0,availableSpots:[]};if(!t.length)return e;let n=0,r=[],i=[{top:0,left:0,right:o}];for(let s of t){let u=L({availableSpots:i,stone:s,containerSize:o}),p=u.position.top+s.height;n<p&&(n=p),r.push(u.position),i=u.availableSpots}return{availableSpots:i,positions:r,containerHeight:n}};var D=t=>t.reduce((o,e)=>{if(!e)return o;let n=e.getBoundingClientRect();return o.push({width:n.width,height:n.height}),o},[]),B=({boxesRefs:t,wrapperRef:o,children:e,windowWidth:n,wrapperWidth:r})=>{let[{positions:i,containerHeight:s,stones:u,availableSpots:p},a]=(0,react__WEBPACK_IMPORTED_MODULE_0__.useState)({positions:[],containerHeight:null,stones:[],availableSpots:[]});return (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(()=>{var m,d;let S=D(t.current),b=(d=(m=o.current)==null?void 0:m.offsetWidth)!=null?d:0;if(b===null)return;let y=z({stones:S,containerSize:b});a(c(l({},y),{stones:S}))},[e,t,o,n,r]),{positions:i,containerHeight:s,stones:u,availableSpots:p}};var tt=t=>({fade:`${t}ms opacity ease`,fadeMove:`
    ${t}ms opacity ease,
    ${t}ms top ease,
    ${t}ms left ease
  `,move:`
    ${t}ms top ease,
    ${t}ms left ease
  `}),ot=({transition:t,transitionDuration:o})=>t?{transition:tt(o)[t]}:null,et=t=>t?c(l({},t),{opacity:1}):{opacity:0,top:0,left:0},j=({style:t,position:o,transition:e,transitionDuration:n})=>l(l(c(l({},t),{position:"absolute"}),et(o)),ot({transition:e,transitionDuration:n}));function F(t,o,e){let n;return function(...r){n&&clearTimeout(n),n=setTimeout(function(){n=null,e||t.apply(null,r)},o),e&&!n&&t.apply(null,r)}}var O=()=>{let[t,o]=(0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(),e=(0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(F(o,300));return (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(()=>{let n=()=>{e.current(window.innerWidth)};return window.addEventListener("resize",n),()=>{window.removeEventListener("resize",n)}},[]),t};var $=t=>{let[o,e]=(0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);return (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(()=>{let n=new ResizeObserver(r=>{for(let i of r)e(i.contentRect.width)});return t.current&&n.observe(t.current),()=>{n.disconnect()}},[t]),o};var ft=s=>{var u=s,{children:t,style:o,transition:e=!1,transitionDuration:n=500,transitionStep:r=50}=u,i=R(u,["children","style","transition","transitionDuration","transitionStep"]);let p=(0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)([]),a=(0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null),S=O(),b=$(a),{positions:y,containerHeight:m}=B({boxesRefs:p,wrapperRef:a,children:t,windowWidth:S,wrapperWidth:b}),d=l({minHeight:m!=null?m:0,position:"relative"},o);return (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div",c(l({ref:a,style:d},i),{children:react__WEBPACK_IMPORTED_MODULE_0__.Children.map(t,(f,g)=>{if(typeof f!="object"||!f||!("type"in f))return f;let N={style:j({style:f.props.style,position:y[g],transition:e,transitionDuration:n}),ref:U=>p.current[g]=U};return (0,react__WEBPACK_IMPORTED_MODULE_0__.cloneElement)(f,l(l({},f.props),N))})}))};


/***/ }),

/***/ "./node_modules/swr/_internal/dist/index.mjs":
/*!***************************************************!*\
  !*** ./node_modules/swr/_internal/dist/index.mjs ***!
  \***************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   INFINITE_PREFIX: function() { return /* binding */ INFINITE_PREFIX; },
/* harmony export */   IS_REACT_LEGACY: function() { return /* binding */ IS_REACT_LEGACY; },
/* harmony export */   IS_SERVER: function() { return /* binding */ IS_SERVER; },
/* harmony export */   OBJECT: function() { return /* binding */ OBJECT; },
/* harmony export */   SWRConfig: function() { return /* binding */ SWRConfig; },
/* harmony export */   SWRGlobalState: function() { return /* binding */ SWRGlobalState; },
/* harmony export */   UNDEFINED: function() { return /* binding */ UNDEFINED; },
/* harmony export */   cache: function() { return /* binding */ cache; },
/* harmony export */   compare: function() { return /* binding */ compare; },
/* harmony export */   createCacheHelper: function() { return /* binding */ createCacheHelper; },
/* harmony export */   defaultConfig: function() { return /* binding */ defaultConfig; },
/* harmony export */   defaultConfigOptions: function() { return /* binding */ defaultConfigOptions; },
/* harmony export */   getTimestamp: function() { return /* binding */ getTimestamp; },
/* harmony export */   hasRequestAnimationFrame: function() { return /* binding */ hasRequestAnimationFrame; },
/* harmony export */   initCache: function() { return /* binding */ initCache; },
/* harmony export */   internalMutate: function() { return /* binding */ internalMutate; },
/* harmony export */   isDocumentDefined: function() { return /* binding */ isDocumentDefined; },
/* harmony export */   isFunction: function() { return /* binding */ isFunction; },
/* harmony export */   isPromiseLike: function() { return /* binding */ isPromiseLike; },
/* harmony export */   isUndefined: function() { return /* binding */ isUndefined; },
/* harmony export */   isWindowDefined: function() { return /* binding */ isWindowDefined; },
/* harmony export */   mergeConfigs: function() { return /* binding */ mergeConfigs; },
/* harmony export */   mergeObjects: function() { return /* binding */ mergeObjects; },
/* harmony export */   mutate: function() { return /* binding */ mutate; },
/* harmony export */   noop: function() { return /* binding */ noop; },
/* harmony export */   normalize: function() { return /* binding */ normalize; },
/* harmony export */   preload: function() { return /* binding */ preload; },
/* harmony export */   preset: function() { return /* binding */ preset; },
/* harmony export */   rAF: function() { return /* binding */ rAF; },
/* harmony export */   revalidateEvents: function() { return /* binding */ events; },
/* harmony export */   serialize: function() { return /* binding */ serialize; },
/* harmony export */   slowConnection: function() { return /* binding */ slowConnection; },
/* harmony export */   stableHash: function() { return /* binding */ stableHash; },
/* harmony export */   subscribeCallback: function() { return /* binding */ subscribeCallback; },
/* harmony export */   useIsomorphicLayoutEffect: function() { return /* binding */ useIsomorphicLayoutEffect; },
/* harmony export */   useSWRConfig: function() { return /* binding */ useSWRConfig; },
/* harmony export */   withArgs: function() { return /* binding */ withArgs; },
/* harmony export */   withMiddleware: function() { return /* binding */ withMiddleware; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");


// Shared state between server components and client components
const noop = ()=>{};
// Using noop() as the undefined value as undefined can be replaced
// by something else. Prettier ignore and extra parentheses are necessary here
// to ensure that tsc doesn't remove the __NOINLINE__ comment.
// prettier-ignore
const UNDEFINED = /*#__NOINLINE__*/ noop();
const OBJECT = Object;
const isUndefined = (v)=>v === UNDEFINED;
const isFunction = (v)=>typeof v == 'function';
const mergeObjects = (a, b)=>({
        ...a,
        ...b
    });
const isPromiseLike = (x)=>isFunction(x.then);

// use WeakMap to store the object->key mapping
// so the objects can be garbage collected.
// WeakMap uses a hashtable under the hood, so the lookup
// complexity is almost O(1).
const table = new WeakMap();
// counter of the key
let counter = 0;
// A stable hash implementation that supports:
// - Fast and ensures unique hash properties
// - Handles unserializable values
// - Handles object key ordering
// - Generates short results
//
// This is not a serialization function, and the result is not guaranteed to be
// parsable.
const stableHash = (arg)=>{
    const type = typeof arg;
    const constructor = arg && arg.constructor;
    const isDate = constructor == Date;
    let result;
    let index;
    if (OBJECT(arg) === arg && !isDate && constructor != RegExp) {
        // Object/function, not null/date/regexp. Use WeakMap to store the id first.
        // If it's already hashed, directly return the result.
        result = table.get(arg);
        if (result) return result;
        // Store the hash first for circular reference detection before entering the
        // recursive `stableHash` calls.
        // For other objects like set and map, we use this id directly as the hash.
        result = ++counter + '~';
        table.set(arg, result);
        if (constructor == Array) {
            // Array.
            result = '@';
            for(index = 0; index < arg.length; index++){
                result += stableHash(arg[index]) + ',';
            }
            table.set(arg, result);
        }
        if (constructor == OBJECT) {
            // Object, sort keys.
            result = '#';
            const keys = OBJECT.keys(arg).sort();
            while(!isUndefined(index = keys.pop())){
                if (!isUndefined(arg[index])) {
                    result += index + ':' + stableHash(arg[index]) + ',';
                }
            }
            table.set(arg, result);
        }
    } else {
        result = isDate ? arg.toJSON() : type == 'symbol' ? arg.toString() : type == 'string' ? JSON.stringify(arg) : '' + arg;
    }
    return result;
};

// Global state used to deduplicate requests and store listeners
const SWRGlobalState = new WeakMap();

const EMPTY_CACHE = {};
const INITIAL_CACHE = {};
const STR_UNDEFINED = 'undefined';
// NOTE: Use the function to guarantee it's re-evaluated between jsdom and node runtime for tests.
const isWindowDefined = typeof window != STR_UNDEFINED;
const isDocumentDefined = typeof document != STR_UNDEFINED;
const hasRequestAnimationFrame = ()=>isWindowDefined && typeof window['requestAnimationFrame'] != STR_UNDEFINED;
const createCacheHelper = (cache, key)=>{
    const state = SWRGlobalState.get(cache);
    return [
        // Getter
        ()=>!isUndefined(key) && cache.get(key) || EMPTY_CACHE,
        // Setter
        (info)=>{
            if (!isUndefined(key)) {
                const prev = cache.get(key);
                // Before writing to the store, we keep the value in the initial cache
                // if it's not there yet.
                if (!(key in INITIAL_CACHE)) {
                    INITIAL_CACHE[key] = prev;
                }
                state[5](key, mergeObjects(prev, info), prev || EMPTY_CACHE);
            }
        },
        // Subscriber
        state[6],
        // Get server cache snapshot
        ()=>{
            if (!isUndefined(key)) {
                // If the cache was updated on the client, we return the stored initial value.
                if (key in INITIAL_CACHE) return INITIAL_CACHE[key];
            }
            // If we haven't done any client-side updates, we return the current value.
            return !isUndefined(key) && cache.get(key) || EMPTY_CACHE;
        }
    ];
} // export { UNDEFINED, OBJECT, isUndefined, isFunction, mergeObjects, isPromiseLike }
;

/**
 * Due to the bug https://bugs.chromium.org/p/chromium/issues/detail?id=678075,
 * it's not reliable to detect if the browser is currently online or offline
 * based on `navigator.onLine`.
 * As a workaround, we always assume it's online on the first load, and change
 * the status upon `online` or `offline` events.
 */ let online = true;
const isOnline = ()=>online;
// For node and React Native, `add/removeEventListener` doesn't exist on window.
const [onWindowEvent, offWindowEvent] = isWindowDefined && window.addEventListener ? [
    window.addEventListener.bind(window),
    window.removeEventListener.bind(window)
] : [
    noop,
    noop
];
const isVisible = ()=>{
    const visibilityState = isDocumentDefined && document.visibilityState;
    return isUndefined(visibilityState) || visibilityState !== 'hidden';
};
const initFocus = (callback)=>{
    // focus revalidate
    if (isDocumentDefined) {
        document.addEventListener('visibilitychange', callback);
    }
    onWindowEvent('focus', callback);
    return ()=>{
        if (isDocumentDefined) {
            document.removeEventListener('visibilitychange', callback);
        }
        offWindowEvent('focus', callback);
    };
};
const initReconnect = (callback)=>{
    // revalidate on reconnected
    const onOnline = ()=>{
        online = true;
        callback();
    };
    // nothing to revalidate, just update the status
    const onOffline = ()=>{
        online = false;
    };
    onWindowEvent('online', onOnline);
    onWindowEvent('offline', onOffline);
    return ()=>{
        offWindowEvent('online', onOnline);
        offWindowEvent('offline', onOffline);
    };
};
const preset = {
    isOnline,
    isVisible
};
const defaultConfigOptions = {
    initFocus,
    initReconnect
};

const IS_REACT_LEGACY = !react__WEBPACK_IMPORTED_MODULE_0__.useId;
const IS_SERVER = !isWindowDefined || 'Deno' in window;
// Polyfill requestAnimationFrame
const rAF = (f)=>hasRequestAnimationFrame() ? window['requestAnimationFrame'](f) : setTimeout(f, 1);
// React currently throws a warning when using useLayoutEffect on the server.
// To get around it, we can conditionally useEffect on the server (no-op) and
// useLayoutEffect in the browser.
const useIsomorphicLayoutEffect = IS_SERVER ? react__WEBPACK_IMPORTED_MODULE_0__.useEffect : react__WEBPACK_IMPORTED_MODULE_0__.useLayoutEffect;
// This assignment is to extend the Navigator type to use effectiveType.
const navigatorConnection = typeof navigator !== 'undefined' && navigator.connection;
// Adjust the config based on slow connection status (<= 70Kbps).
const slowConnection = !IS_SERVER && navigatorConnection && ([
    'slow-2g',
    '2g'
].includes(navigatorConnection.effectiveType) || navigatorConnection.saveData);

const serialize = (key)=>{
    if (isFunction(key)) {
        try {
            key = key();
        } catch (err) {
            // dependencies not ready
            key = '';
        }
    }
    // Use the original key as the argument of fetcher. This can be a string or an
    // array of values.
    const args = key;
    // If key is not falsy, or not an empty array, hash it.
    key = typeof key == 'string' ? key : (Array.isArray(key) ? key.length : key) ? stableHash(key) : '';
    return [
        key,
        args
    ];
};

// Global timestamp.
let __timestamp = 0;
const getTimestamp = ()=>++__timestamp;

const FOCUS_EVENT = 0;
const RECONNECT_EVENT = 1;
const MUTATE_EVENT = 2;
const ERROR_REVALIDATE_EVENT = 3;

var events = {
  __proto__: null,
  ERROR_REVALIDATE_EVENT: ERROR_REVALIDATE_EVENT,
  FOCUS_EVENT: FOCUS_EVENT,
  MUTATE_EVENT: MUTATE_EVENT,
  RECONNECT_EVENT: RECONNECT_EVENT
};

async function internalMutate(...args) {
    const [cache, _key, _data, _opts] = args;
    // When passing as a boolean, it's explicitly used to disable/enable
    // revalidation.
    const options = mergeObjects({
        populateCache: true,
        throwOnError: true
    }, typeof _opts === 'boolean' ? {
        revalidate: _opts
    } : _opts || {});
    let populateCache = options.populateCache;
    const rollbackOnErrorOption = options.rollbackOnError;
    let optimisticData = options.optimisticData;
    const revalidate = options.revalidate !== false;
    const rollbackOnError = (error)=>{
        return typeof rollbackOnErrorOption === 'function' ? rollbackOnErrorOption(error) : rollbackOnErrorOption !== false;
    };
    const throwOnError = options.throwOnError;
    // If the second argument is a key filter, return the mutation results for all
    // filtered keys.
    if (isFunction(_key)) {
        const keyFilter = _key;
        const matchedKeys = [];
        const it = cache.keys();
        for (const key of it){
            if (// Skip the special useSWRInfinite and useSWRSubscription keys.
            !/^\$(inf|sub)\$/.test(key) && keyFilter(cache.get(key)._k)) {
                matchedKeys.push(key);
            }
        }
        return Promise.all(matchedKeys.map(mutateByKey));
    }
    return mutateByKey(_key);
    async function mutateByKey(_k) {
        // Serialize key
        const [key] = serialize(_k);
        if (!key) return;
        const [get, set] = createCacheHelper(cache, key);
        const [EVENT_REVALIDATORS, MUTATION, FETCH, PRELOAD] = SWRGlobalState.get(cache);
        const startRevalidate = ()=>{
            const revalidators = EVENT_REVALIDATORS[key];
            if (revalidate) {
                // Invalidate the key by deleting the concurrent request markers so new
                // requests will not be deduped.
                delete FETCH[key];
                delete PRELOAD[key];
                if (revalidators && revalidators[0]) {
                    return revalidators[0](MUTATE_EVENT).then(()=>get().data);
                }
            }
            return get().data;
        };
        // If there is no new data provided, revalidate the key with current state.
        if (args.length < 3) {
            // Revalidate and broadcast state.
            return startRevalidate();
        }
        let data = _data;
        let error;
        // Update global timestamps.
        const beforeMutationTs = getTimestamp();
        MUTATION[key] = [
            beforeMutationTs,
            0
        ];
        const hasOptimisticData = !isUndefined(optimisticData);
        const state = get();
        // `displayedData` is the current value on screen. It could be the optimistic value
        // that is going to be overridden by a `committedData`, or get reverted back.
        // `committedData` is the validated value that comes from a fetch or mutation.
        const displayedData = state.data;
        const currentData = state._c;
        const committedData = isUndefined(currentData) ? displayedData : currentData;
        // Do optimistic data update.
        if (hasOptimisticData) {
            optimisticData = isFunction(optimisticData) ? optimisticData(committedData, displayedData) : optimisticData;
            // When we set optimistic data, backup the current committedData data in `_c`.
            set({
                data: optimisticData,
                _c: committedData
            });
        }
        if (isFunction(data)) {
            // `data` is a function, call it passing current cache value.
            try {
                data = data(committedData);
            } catch (err) {
                // If it throws an error synchronously, we shouldn't update the cache.
                error = err;
            }
        }
        // `data` is a promise/thenable, resolve the final data first.
        if (data && isPromiseLike(data)) {
            // This means that the mutation is async, we need to check timestamps to
            // avoid race conditions.
            data = await data.catch((err)=>{
                error = err;
            });
            // Check if other mutations have occurred since we've started this mutation.
            // If there's a race we don't update cache or broadcast the change,
            // just return the data.
            if (beforeMutationTs !== MUTATION[key][0]) {
                if (error) throw error;
                return data;
            } else if (error && hasOptimisticData && rollbackOnError(error)) {
                // Rollback. Always populate the cache in this case but without
                // transforming the data.
                populateCache = true;
                // Reset data to be the latest committed data, and clear the `_c` value.
                set({
                    data: committedData,
                    _c: UNDEFINED
                });
            }
        }
        // If we should write back the cache after request.
        if (populateCache) {
            if (!error) {
                // Transform the result into data.
                if (isFunction(populateCache)) {
                    const populateCachedData = populateCache(data, committedData);
                    set({
                        data: populateCachedData,
                        error: UNDEFINED,
                        _c: UNDEFINED
                    });
                } else {
                    // Only update cached data and reset the error if there's no error. Data can be `undefined` here.
                    set({
                        data,
                        error: UNDEFINED,
                        _c: UNDEFINED
                    });
                }
            }
        }
        // Reset the timestamp to mark the mutation has ended.
        MUTATION[key][1] = getTimestamp();
        // Update existing SWR Hooks' internal states:
        Promise.resolve(startRevalidate()).then(()=>{
            // The mutation and revalidation are ended, we can clear it since the data is
            // not an optimistic value anymore.
            set({
                _c: UNDEFINED
            });
        });
        // Throw error or return data
        if (error) {
            if (throwOnError) throw error;
            return;
        }
        return data;
    }
}

const revalidateAllKeys = (revalidators, type)=>{
    for(const key in revalidators){
        if (revalidators[key][0]) revalidators[key][0](type);
    }
};
const initCache = (provider, options)=>{
    // The global state for a specific provider will be used to deduplicate
    // requests and store listeners. As well as a mutate function that is bound to
    // the cache.
    // The provider's global state might be already initialized. Let's try to get the
    // global state associated with the provider first.
    if (!SWRGlobalState.has(provider)) {
        const opts = mergeObjects(defaultConfigOptions, options);
        // If there's no global state bound to the provider, create a new one with the
        // new mutate function.
        const EVENT_REVALIDATORS = {};
        const mutate = internalMutate.bind(UNDEFINED, provider);
        let unmount = noop;
        const subscriptions = {};
        const subscribe = (key, callback)=>{
            const subs = subscriptions[key] || [];
            subscriptions[key] = subs;
            subs.push(callback);
            return ()=>subs.splice(subs.indexOf(callback), 1);
        };
        const setter = (key, value, prev)=>{
            provider.set(key, value);
            const subs = subscriptions[key];
            if (subs) {
                for (const fn of subs){
                    fn(value, prev);
                }
            }
        };
        const initProvider = ()=>{
            if (!SWRGlobalState.has(provider)) {
                // Update the state if it's new, or if the provider has been extended.
                SWRGlobalState.set(provider, [
                    EVENT_REVALIDATORS,
                    {},
                    {},
                    {},
                    mutate,
                    setter,
                    subscribe
                ]);
                if (!IS_SERVER) {
                    // When listening to the native events for auto revalidations,
                    // we intentionally put a delay (setTimeout) here to make sure they are
                    // fired after immediate JavaScript executions, which can be
                    // React's state updates.
                    // This avoids some unnecessary revalidations such as
                    // https://github.com/vercel/swr/issues/1680.
                    const releaseFocus = opts.initFocus(setTimeout.bind(UNDEFINED, revalidateAllKeys.bind(UNDEFINED, EVENT_REVALIDATORS, FOCUS_EVENT)));
                    const releaseReconnect = opts.initReconnect(setTimeout.bind(UNDEFINED, revalidateAllKeys.bind(UNDEFINED, EVENT_REVALIDATORS, RECONNECT_EVENT)));
                    unmount = ()=>{
                        releaseFocus && releaseFocus();
                        releaseReconnect && releaseReconnect();
                        // When un-mounting, we need to remove the cache provider from the state
                        // storage too because it's a side-effect. Otherwise, when re-mounting we
                        // will not re-register those event listeners.
                        SWRGlobalState.delete(provider);
                    };
                }
            }
        };
        initProvider();
        // This is a new provider, we need to initialize it and setup DOM events
        // listeners for `focus` and `reconnect` actions.
        // We might want to inject an extra layer on top of `provider` in the future,
        // such as key serialization, auto GC, etc.
        // For now, it's just a `Map` interface without any modifications.
        return [
            provider,
            mutate,
            initProvider,
            unmount
        ];
    }
    return [
        provider,
        SWRGlobalState.get(provider)[4]
    ];
};

// error retry
const onErrorRetry = (_, __, config, revalidate, opts)=>{
    const maxRetryCount = config.errorRetryCount;
    const currentRetryCount = opts.retryCount;
    // Exponential backoff
    const timeout = ~~((Math.random() + 0.5) * (1 << (currentRetryCount < 8 ? currentRetryCount : 8))) * config.errorRetryInterval;
    if (!isUndefined(maxRetryCount) && currentRetryCount > maxRetryCount) {
        return;
    }
    setTimeout(revalidate, timeout, opts);
};
const compare = (currentData, newData)=>stableHash(currentData) == stableHash(newData);
// Default cache provider
const [cache, mutate] = initCache(new Map());
// Default config
const defaultConfig = mergeObjects({
    // events
    onLoadingSlow: noop,
    onSuccess: noop,
    onError: noop,
    onErrorRetry,
    onDiscarded: noop,
    // switches
    revalidateOnFocus: true,
    revalidateOnReconnect: true,
    revalidateIfStale: true,
    shouldRetryOnError: true,
    // timeouts
    errorRetryInterval: slowConnection ? 10000 : 5000,
    focusThrottleInterval: 5 * 1000,
    dedupingInterval: 2 * 1000,
    loadingTimeout: slowConnection ? 5000 : 3000,
    // providers
    compare,
    isPaused: ()=>false,
    cache,
    mutate,
    fallback: {}
}, // use web preset by default
preset);

const mergeConfigs = (a, b)=>{
    // Need to create a new object to avoid mutating the original here.
    const v = mergeObjects(a, b);
    // If two configs are provided, merge their `use` and `fallback` options.
    if (b) {
        const { use: u1, fallback: f1 } = a;
        const { use: u2, fallback: f2 } = b;
        if (u1 && u2) {
            v.use = u1.concat(u2);
        }
        if (f1 && f2) {
            v.fallback = mergeObjects(f1, f2);
        }
    }
    return v;
};

const SWRConfigContext = (0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)({});
const SWRConfig = (props)=>{
    const { value } = props;
    const parentConfig = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(SWRConfigContext);
    const isFunctionalConfig = isFunction(value);
    const config = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(()=>isFunctionalConfig ? value(parentConfig) : value, [
        isFunctionalConfig,
        parentConfig,
        value
    ]);
    // Extend parent context values and middleware.
    const extendedConfig = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(()=>isFunctionalConfig ? config : mergeConfigs(parentConfig, config), [
        isFunctionalConfig,
        parentConfig,
        config
    ]);
    // Should not use the inherited provider.
    const provider = config && config.provider;
    // initialize the cache only on first access.
    const cacheContextRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(UNDEFINED);
    if (provider && !cacheContextRef.current) {
        cacheContextRef.current = initCache(provider(extendedConfig.cache || cache), config);
    }
    const cacheContext = cacheContextRef.current;
    // Override the cache if a new provider is given.
    if (cacheContext) {
        extendedConfig.cache = cacheContext[0];
        extendedConfig.mutate = cacheContext[1];
    }
    // Unsubscribe events.
    useIsomorphicLayoutEffect(()=>{
        if (cacheContext) {
            cacheContext[2] && cacheContext[2]();
            return cacheContext[3];
        }
    }, []);
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(SWRConfigContext.Provider, mergeObjects(props, {
        value: extendedConfig
    }));
};

const INFINITE_PREFIX = '$inf$';

// @ts-expect-error
const enableDevtools = isWindowDefined && window.__SWR_DEVTOOLS_USE__;
const use = enableDevtools ? window.__SWR_DEVTOOLS_USE__ : [];
const setupDevTools = ()=>{
    if (enableDevtools) {
        // @ts-expect-error
        window.__SWR_DEVTOOLS_REACT__ = react__WEBPACK_IMPORTED_MODULE_0__;
    }
};

const normalize = (args)=>{
    return isFunction(args[1]) ? [
        args[0],
        args[1],
        args[2] || {}
    ] : [
        args[0],
        null,
        (args[1] === null ? args[2] : args[1]) || {}
    ];
};

const useSWRConfig = ()=>{
    return mergeObjects(defaultConfig, (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(SWRConfigContext));
};

const preload = (key_, fetcher)=>{
    const [key, fnArg] = serialize(key_);
    const [, , , PRELOAD] = SWRGlobalState.get(cache);
    // Prevent preload to be called multiple times before used.
    if (PRELOAD[key]) return PRELOAD[key];
    const req = fetcher(fnArg);
    PRELOAD[key] = req;
    return req;
};
const middleware = (useSWRNext)=>(key_, fetcher_, config)=>{
        // fetcher might be a sync function, so this should not be an async function
        const fetcher = fetcher_ && ((...args)=>{
            const [key] = serialize(key_);
            const [, , , PRELOAD] = SWRGlobalState.get(cache);
            if (key.startsWith(INFINITE_PREFIX)) {
                // we want the infinite fetcher to be called.
                // handling of the PRELOAD cache happens there.
                return fetcher_(...args);
            }
            const req = PRELOAD[key];
            if (isUndefined(req)) return fetcher_(...args);
            delete PRELOAD[key];
            return req;
        });
        return useSWRNext(key_, fetcher, config);
    };

const BUILT_IN_MIDDLEWARE = use.concat(middleware);

// It's tricky to pass generic types as parameters, so we just directly override
// the types here.
const withArgs = (hook)=>{
    return function useSWRArgs(...args) {
        // Get the default and inherited configuration.
        const fallbackConfig = useSWRConfig();
        // Normalize arguments.
        const [key, fn, _config] = normalize(args);
        // Merge configurations.
        const config = mergeConfigs(fallbackConfig, _config);
        // Apply middleware
        let next = hook;
        const { use } = config;
        const middleware = (use || []).concat(BUILT_IN_MIDDLEWARE);
        for(let i = middleware.length; i--;){
            next = middleware[i](next);
        }
        return next(key, fn || config.fetcher || null, config);
    };
};

// Add a callback function to a list of keyed callback functions and return
// the unsubscribe function.
const subscribeCallback = (key, callbacks, callback)=>{
    const keyedRevalidators = callbacks[key] || (callbacks[key] = []);
    keyedRevalidators.push(callback);
    return ()=>{
        const index = keyedRevalidators.indexOf(callback);
        if (index >= 0) {
            // O(1): faster than splice
            keyedRevalidators[index] = keyedRevalidators[keyedRevalidators.length - 1];
            keyedRevalidators.pop();
        }
    };
};

// Create a custom hook with a middleware
const withMiddleware = (useSWR, middleware)=>{
    return (...args)=>{
        const [key, fn, config] = normalize(args);
        const uses = (config.use || []).concat(middleware);
        return useSWR(key, fn, {
            ...config,
            use: uses
        });
    };
};

setupDevTools();




/***/ }),

/***/ "./node_modules/swr/core/dist/index.mjs":
/*!**********************************************!*\
  !*** ./node_modules/swr/core/dist/index.mjs ***!
  \**********************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   SWRConfig: function() { return /* binding */ SWRConfig; },
/* harmony export */   "default": function() { return /* binding */ useSWR; },
/* harmony export */   mutate: function() { return /* reexport safe */ swr_internal__WEBPACK_IMPORTED_MODULE_3__.mutate; },
/* harmony export */   preload: function() { return /* reexport safe */ swr_internal__WEBPACK_IMPORTED_MODULE_3__.preload; },
/* harmony export */   unstable_serialize: function() { return /* binding */ unstable_serialize; },
/* harmony export */   useSWRConfig: function() { return /* reexport safe */ swr_internal__WEBPACK_IMPORTED_MODULE_3__.useSWRConfig; }
/* harmony export */ });
/* harmony import */ var client_only__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! client-only */ "./node_modules/client-only/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var use_sync_external_store_shim_index_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! use-sync-external-store/shim/index.js */ "./node_modules/use-sync-external-store/shim/index.js");
/* harmony import */ var swr_internal__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! swr/_internal */ "./node_modules/swr/_internal/dist/index.mjs");






const unstable_serialize = (key)=>(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.serialize)(key)[0];

/// <reference types="react/experimental" />
const use = react__WEBPACK_IMPORTED_MODULE_1__.use || ((promise)=>{
    if (promise.status === 'pending') {
        throw promise;
    } else if (promise.status === 'fulfilled') {
        return promise.value;
    } else if (promise.status === 'rejected') {
        throw promise.reason;
    } else {
        promise.status = 'pending';
        promise.then((v)=>{
            promise.status = 'fulfilled';
            promise.value = v;
        }, (e)=>{
            promise.status = 'rejected';
            promise.reason = e;
        });
        throw promise;
    }
});
const WITH_DEDUPE = {
    dedupe: true
};
const useSWRHandler = (_key, fetcher, config)=>{
    const { cache, compare, suspense, fallbackData, revalidateOnMount, revalidateIfStale, refreshInterval, refreshWhenHidden, refreshWhenOffline, keepPreviousData } = config;
    const [EVENT_REVALIDATORS, MUTATION, FETCH, PRELOAD] = swr_internal__WEBPACK_IMPORTED_MODULE_3__.SWRGlobalState.get(cache);
    // `key` is the identifier of the SWR internal state,
    // `fnArg` is the argument/arguments parsed from the key, which will be passed
    // to the fetcher.
    // All of them are derived from `_key`.
    const [key, fnArg] = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.serialize)(_key);
    // If it's the initial render of this hook.
    const initialMountedRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(false);
    // If the hook is unmounted already. This will be used to prevent some effects
    // to be called after unmounting.
    const unmountedRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(false);
    // Refs to keep the key and config.
    const keyRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(key);
    const fetcherRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(fetcher);
    const configRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(config);
    const getConfig = ()=>configRef.current;
    const isActive = ()=>getConfig().isVisible() && getConfig().isOnline();
    const [getCache, setCache, subscribeCache, getInitialCache] = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.createCacheHelper)(cache, key);
    const stateDependencies = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)({}).current;
    const fallback = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(fallbackData) ? config.fallback[key] : fallbackData;
    const isEqual = (prev, current)=>{
        for(const _ in stateDependencies){
            const t = _;
            if (t === 'data') {
                if (!compare(prev[t], current[t])) {
                    if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(prev[t])) {
                        return false;
                    }
                    if (!compare(returnedData, current[t])) {
                        return false;
                    }
                }
            } else {
                if (current[t] !== prev[t]) {
                    return false;
                }
            }
        }
        return true;
    };
    const getSnapshot = (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(()=>{
        const shouldStartRequest = (()=>{
            if (!key) return false;
            if (!fetcher) return false;
            // If `revalidateOnMount` is set, we take the value directly.
            if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(revalidateOnMount)) return revalidateOnMount;
            // If it's paused, we skip revalidation.
            if (getConfig().isPaused()) return false;
            if (suspense) return false;
            if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(revalidateIfStale)) return revalidateIfStale;
            return true;
        })();
        // Get the cache and merge it with expected states.
        const getSelectedCache = (state)=>{
            // We only select the needed fields from the state.
            const snapshot = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.mergeObjects)(state);
            delete snapshot._k;
            if (!shouldStartRequest) {
                return snapshot;
            }
            return {
                isValidating: true,
                isLoading: true,
                ...snapshot
            };
        };
        const cachedData = getCache();
        const initialData = getInitialCache();
        const clientSnapshot = getSelectedCache(cachedData);
        const serverSnapshot = cachedData === initialData ? clientSnapshot : getSelectedCache(initialData);
        // To make sure that we are returning the same object reference to avoid
        // unnecessary re-renders, we keep the previous snapshot and use deep
        // comparison to check if we need to return a new one.
        let memorizedSnapshot = clientSnapshot;
        return [
            ()=>{
                const newSnapshot = getSelectedCache(getCache());
                const compareResult = isEqual(newSnapshot, memorizedSnapshot);
                if (compareResult) {
                    // Mentally, we should always return the `memorizedSnapshot` here
                    // as there's no change between the new and old snapshots.
                    // However, since the `isEqual` function only compares selected fields,
                    // the values of the unselected fields might be changed. That's
                    // simply because we didn't track them.
                    // To support the case in https://github.com/vercel/swr/pull/2576,
                    // we need to update these fields in the `memorizedSnapshot` too
                    // with direct mutations to ensure the snapshot is always up-to-date
                    // even for the unselected fields, but only trigger re-renders when
                    // the selected fields are changed.
                    memorizedSnapshot.data = newSnapshot.data;
                    memorizedSnapshot.isLoading = newSnapshot.isLoading;
                    memorizedSnapshot.isValidating = newSnapshot.isValidating;
                    memorizedSnapshot.error = newSnapshot.error;
                    return memorizedSnapshot;
                } else {
                    memorizedSnapshot = newSnapshot;
                    return newSnapshot;
                }
            },
            ()=>serverSnapshot
        ];
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [
        cache,
        key
    ]);
    // Get the current state that SWR should return.
    const cached = (0,use_sync_external_store_shim_index_js__WEBPACK_IMPORTED_MODULE_2__.useSyncExternalStore)((0,react__WEBPACK_IMPORTED_MODULE_1__.useCallback)((callback)=>subscribeCache(key, (current, prev)=>{
            if (!isEqual(prev, current)) callback();
        }), // eslint-disable-next-line react-hooks/exhaustive-deps
    [
        cache,
        key
    ]), getSnapshot[0], getSnapshot[1]);
    const isInitialMount = !initialMountedRef.current;
    const hasRevalidator = EVENT_REVALIDATORS[key] && EVENT_REVALIDATORS[key].length > 0;
    const cachedData = cached.data;
    const data = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(cachedData) ? fallback : cachedData;
    const error = cached.error;
    // Use a ref to store previously returned data. Use the initial data as its initial value.
    const laggyDataRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(data);
    const returnedData = keepPreviousData ? (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(cachedData) ? laggyDataRef.current : cachedData : data;
    // - Suspense mode and there's stale data for the initial render.
    // - Not suspense mode and there is no fallback data and `revalidateIfStale` is enabled.
    // - `revalidateIfStale` is enabled but `data` is not defined.
    const shouldDoInitialRevalidation = (()=>{
        // if a key already has revalidators and also has error, we should not trigger revalidation
        if (hasRevalidator && !(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(error)) return false;
        // If `revalidateOnMount` is set, we take the value directly.
        if (isInitialMount && !(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(revalidateOnMount)) return revalidateOnMount;
        // If it's paused, we skip revalidation.
        if (getConfig().isPaused()) return false;
        // Under suspense mode, it will always fetch on render if there is no
        // stale data so no need to revalidate immediately mount it again.
        // If data exists, only revalidate if `revalidateIfStale` is true.
        if (suspense) return (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(data) ? false : revalidateIfStale;
        // If there is no stale data, we need to revalidate when mount;
        // If `revalidateIfStale` is set to true, we will always revalidate.
        return (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(data) || revalidateIfStale;
    })();
    // Resolve the default validating state:
    // If it's able to validate, and it should revalidate when mount, this will be true.
    const defaultValidatingState = !!(key && fetcher && isInitialMount && shouldDoInitialRevalidation);
    const isValidating = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(cached.isValidating) ? defaultValidatingState : cached.isValidating;
    const isLoading = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(cached.isLoading) ? defaultValidatingState : cached.isLoading;
    // The revalidation function is a carefully crafted wrapper of the original
    // `fetcher`, to correctly handle the many edge cases.
    const revalidate = (0,react__WEBPACK_IMPORTED_MODULE_1__.useCallback)(async (revalidateOpts)=>{
        const currentFetcher = fetcherRef.current;
        if (!key || !currentFetcher || unmountedRef.current || getConfig().isPaused()) {
            return false;
        }
        let newData;
        let startAt;
        let loading = true;
        const opts = revalidateOpts || {};
        // If there is no ongoing concurrent request, or `dedupe` is not set, a
        // new request should be initiated.
        const shouldStartNewRequest = !FETCH[key] || !opts.dedupe;
        /*
         For React 17
         Do unmount check for calls:
         If key has changed during the revalidation, or the component has been
         unmounted, old dispatch and old event callbacks should not take any
         effect

        For React 18
        only check if key has changed
        https://github.com/reactwg/react-18/discussions/82
      */ const callbackSafeguard = ()=>{
            if (swr_internal__WEBPACK_IMPORTED_MODULE_3__.IS_REACT_LEGACY) {
                return !unmountedRef.current && key === keyRef.current && initialMountedRef.current;
            }
            return key === keyRef.current;
        };
        // The final state object when the request finishes.
        const finalState = {
            isValidating: false,
            isLoading: false
        };
        const finishRequestAndUpdateState = ()=>{
            setCache(finalState);
        };
        const cleanupState = ()=>{
            // Check if it's still the same request before deleting it.
            const requestInfo = FETCH[key];
            if (requestInfo && requestInfo[1] === startAt) {
                delete FETCH[key];
            }
        };
        // Start fetching. Change the `isValidating` state, update the cache.
        const initialState = {
            isValidating: true
        };
        // It is in the `isLoading` state, if and only if there is no cached data.
        // This bypasses fallback data and laggy data.
        if ((0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(getCache().data)) {
            initialState.isLoading = true;
        }
        try {
            if (shouldStartNewRequest) {
                setCache(initialState);
                // If no cache is being rendered currently (it shows a blank page),
                // we trigger the loading slow event.
                if (config.loadingTimeout && (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(getCache().data)) {
                    setTimeout(()=>{
                        if (loading && callbackSafeguard()) {
                            getConfig().onLoadingSlow(key, config);
                        }
                    }, config.loadingTimeout);
                }
                // Start the request and save the timestamp.
                // Key must be truthy if entering here.
                FETCH[key] = [
                    currentFetcher(fnArg),
                    (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.getTimestamp)()
                ];
            }
            [newData, startAt] = FETCH[key];
            newData = await newData;
            if (shouldStartNewRequest) {
                // If the request isn't interrupted, clean it up after the
                // deduplication interval.
                setTimeout(cleanupState, config.dedupingInterval);
            }
            // If there're other ongoing request(s), started after the current one,
            // we need to ignore the current one to avoid possible race conditions:
            //   req1------------------>res1        (current one)
            //        req2---------------->res2
            // the request that fired later will always be kept.
            // The timestamp maybe be `undefined` or a number
            if (!FETCH[key] || FETCH[key][1] !== startAt) {
                if (shouldStartNewRequest) {
                    if (callbackSafeguard()) {
                        getConfig().onDiscarded(key);
                    }
                }
                return false;
            }
            // Clear error.
            finalState.error = swr_internal__WEBPACK_IMPORTED_MODULE_3__.UNDEFINED;
            // If there're other mutations(s), that overlapped with the current revalidation:
            // case 1:
            //   req------------------>res
            //       mutate------>end
            // case 2:
            //         req------------>res
            //   mutate------>end
            // case 3:
            //   req------------------>res
            //       mutate-------...---------->
            // we have to ignore the revalidation result (res) because it's no longer fresh.
            // meanwhile, a new revalidation should be triggered when the mutation ends.
            const mutationInfo = MUTATION[key];
            if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(mutationInfo) && // case 1
            (startAt <= mutationInfo[0] || // case 2
            startAt <= mutationInfo[1] || // case 3
            mutationInfo[1] === 0)) {
                finishRequestAndUpdateState();
                if (shouldStartNewRequest) {
                    if (callbackSafeguard()) {
                        getConfig().onDiscarded(key);
                    }
                }
                return false;
            }
            // Deep compare with the latest state to avoid extra re-renders.
            // For local state, compare and assign.
            const cacheData = getCache().data;
            // Since the compare fn could be custom fn
            // cacheData might be different from newData even when compare fn returns True
            finalState.data = compare(cacheData, newData) ? cacheData : newData;
            // Trigger the successful callback if it's the original request.
            if (shouldStartNewRequest) {
                if (callbackSafeguard()) {
                    getConfig().onSuccess(newData, key, config);
                }
            }
        } catch (err) {
            cleanupState();
            const currentConfig = getConfig();
            const { shouldRetryOnError } = currentConfig;
            // Not paused, we continue handling the error. Otherwise, discard it.
            if (!currentConfig.isPaused()) {
                // Get a new error, don't use deep comparison for errors.
                finalState.error = err;
                // Error event and retry logic. Only for the actual request, not
                // deduped ones.
                if (shouldStartNewRequest && callbackSafeguard()) {
                    currentConfig.onError(err, key, currentConfig);
                    if (shouldRetryOnError === true || (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isFunction)(shouldRetryOnError) && shouldRetryOnError(err)) {
                        if (isActive()) {
                            // If it's inactive, stop. It will auto-revalidate when
                            // refocusing or reconnecting.
                            // When retrying, deduplication is always enabled.
                            currentConfig.onErrorRetry(err, key, currentConfig, (_opts)=>{
                                const revalidators = EVENT_REVALIDATORS[key];
                                if (revalidators && revalidators[0]) {
                                    revalidators[0](swr_internal__WEBPACK_IMPORTED_MODULE_3__.revalidateEvents.ERROR_REVALIDATE_EVENT, _opts);
                                }
                            }, {
                                retryCount: (opts.retryCount || 0) + 1,
                                dedupe: true
                            });
                        }
                    }
                }
            }
        }
        // Mark loading as stopped.
        loading = false;
        // Update the current hook's state.
        finishRequestAndUpdateState();
        return true;
    }, // `setState` is immutable, and `eventsCallback`, `fnArg`, and
    // `keyValidating` are depending on `key`, so we can exclude them from
    // the deps array.
    //
    // FIXME:
    // `fn` and `config` might be changed during the lifecycle,
    // but they might be changed every render like this.
    // `useSWR('key', () => fetch('/api/'), { suspense: true })`
    // So we omit the values from the deps array
    // even though it might cause unexpected behaviors.
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [
        key,
        cache
    ]);
    // Similar to the global mutate but bound to the current cache and key.
    // `cache` isn't allowed to change during the lifecycle.
    // eslint-disable-next-line react-hooks/exhaustive-deps
    const boundMutate = (0,react__WEBPACK_IMPORTED_MODULE_1__.useCallback)(// Use callback to make sure `keyRef.current` returns latest result every time
    (...args)=>{
        return (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.internalMutate)(cache, keyRef.current, ...args);
    }, // eslint-disable-next-line react-hooks/exhaustive-deps
    []);
    // The logic for updating refs.
    (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.useIsomorphicLayoutEffect)(()=>{
        fetcherRef.current = fetcher;
        configRef.current = config;
        // Handle laggy data updates. If there's cached data of the current key,
        // it'll be the correct reference.
        if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(cachedData)) {
            laggyDataRef.current = cachedData;
        }
    });
    // After mounted or key changed.
    (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.useIsomorphicLayoutEffect)(()=>{
        if (!key) return;
        const softRevalidate = revalidate.bind(swr_internal__WEBPACK_IMPORTED_MODULE_3__.UNDEFINED, WITH_DEDUPE);
        // Expose revalidators to global event listeners. So we can trigger
        // revalidation from the outside.
        let nextFocusRevalidatedAt = 0;
        const onRevalidate = (type, opts = {})=>{
            if (type == swr_internal__WEBPACK_IMPORTED_MODULE_3__.revalidateEvents.FOCUS_EVENT) {
                const now = Date.now();
                if (getConfig().revalidateOnFocus && now > nextFocusRevalidatedAt && isActive()) {
                    nextFocusRevalidatedAt = now + getConfig().focusThrottleInterval;
                    softRevalidate();
                }
            } else if (type == swr_internal__WEBPACK_IMPORTED_MODULE_3__.revalidateEvents.RECONNECT_EVENT) {
                if (getConfig().revalidateOnReconnect && isActive()) {
                    softRevalidate();
                }
            } else if (type == swr_internal__WEBPACK_IMPORTED_MODULE_3__.revalidateEvents.MUTATE_EVENT) {
                return revalidate();
            } else if (type == swr_internal__WEBPACK_IMPORTED_MODULE_3__.revalidateEvents.ERROR_REVALIDATE_EVENT) {
                return revalidate(opts);
            }
            return;
        };
        const unsubEvents = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.subscribeCallback)(key, EVENT_REVALIDATORS, onRevalidate);
        // Mark the component as mounted and update corresponding refs.
        unmountedRef.current = false;
        keyRef.current = key;
        initialMountedRef.current = true;
        // Keep the original key in the cache.
        setCache({
            _k: fnArg
        });
        // Trigger a revalidation
        if (shouldDoInitialRevalidation) {
            if ((0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(data) || swr_internal__WEBPACK_IMPORTED_MODULE_3__.IS_SERVER) {
                // Revalidate immediately.
                softRevalidate();
            } else {
                // Delay the revalidate if we have data to return so we won't block
                // rendering.
                (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.rAF)(softRevalidate);
            }
        }
        return ()=>{
            // Mark it as unmounted.
            unmountedRef.current = true;
            unsubEvents();
        };
    }, [
        key
    ]);
    // Polling
    (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.useIsomorphicLayoutEffect)(()=>{
        let timer;
        function next() {
            // Use the passed interval
            // ...or invoke the function with the updated data to get the interval
            const interval = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isFunction)(refreshInterval) ? refreshInterval(getCache().data) : refreshInterval;
            // We only start the next interval if `refreshInterval` is not 0, and:
            // - `force` is true, which is the start of polling
            // - or `timer` is not 0, which means the effect wasn't canceled
            if (interval && timer !== -1) {
                timer = setTimeout(execute, interval);
            }
        }
        function execute() {
            // Check if it's OK to execute:
            // Only revalidate when the page is visible, online, and not errored.
            if (!getCache().error && (refreshWhenHidden || getConfig().isVisible()) && (refreshWhenOffline || getConfig().isOnline())) {
                revalidate(WITH_DEDUPE).then(next);
            } else {
                // Schedule the next interval to check again.
                next();
            }
        }
        next();
        return ()=>{
            if (timer) {
                clearTimeout(timer);
                timer = -1;
            }
        };
    }, [
        refreshInterval,
        refreshWhenHidden,
        refreshWhenOffline,
        key
    ]);
    // Display debug info in React DevTools.
    (0,react__WEBPACK_IMPORTED_MODULE_1__.useDebugValue)(returnedData);
    // In Suspense mode, we can't return the empty `data` state.
    // If there is an `error`, the `error` needs to be thrown to the error boundary.
    // If there is no `error`, the `revalidation` promise needs to be thrown to
    // the suspense boundary.
    if (suspense && (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(data) && key) {
        // SWR should throw when trying to use Suspense on the server with React 18,
        // without providing any initial data. See:
        // https://github.com/vercel/swr/issues/1832
        if (!swr_internal__WEBPACK_IMPORTED_MODULE_3__.IS_REACT_LEGACY && swr_internal__WEBPACK_IMPORTED_MODULE_3__.IS_SERVER) {
            throw new Error('Fallback data is required when using suspense in SSR.');
        }
        // Always update fetcher and config refs even with the Suspense mode.
        fetcherRef.current = fetcher;
        configRef.current = config;
        unmountedRef.current = false;
        const req = PRELOAD[key];
        if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(req)) {
            const promise = boundMutate(req);
            use(promise);
        }
        if ((0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(error)) {
            const promise = revalidate(WITH_DEDUPE);
            if (!(0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.isUndefined)(returnedData)) {
                promise.status = 'fulfilled';
                promise.value = true;
            }
            use(promise);
        } else {
            throw error;
        }
    }
    return {
        mutate: boundMutate,
        get data () {
            stateDependencies.data = true;
            return returnedData;
        },
        get error () {
            stateDependencies.error = true;
            return error;
        },
        get isValidating () {
            stateDependencies.isValidating = true;
            return isValidating;
        },
        get isLoading () {
            stateDependencies.isLoading = true;
            return isLoading;
        }
    };
};
const SWRConfig = swr_internal__WEBPACK_IMPORTED_MODULE_3__.OBJECT.defineProperty(swr_internal__WEBPACK_IMPORTED_MODULE_3__.SWRConfig, 'defaultValue', {
    value: swr_internal__WEBPACK_IMPORTED_MODULE_3__.defaultConfig
});
/**
 * A hook to fetch data.
 *
 * @link https://swr.vercel.app
 * @example
 * ```jsx
 * import useSWR from 'swr'
 * function Profile() {
 *   const { data, error, isLoading } = useSWR('/api/user', fetcher)
 *   if (error) return <div>failed to load</div>
 *   if (isLoading) return <div>loading...</div>
 *   return <div>hello {data.name}!</div>
 * }
 * ```
 */ const useSWR = (0,swr_internal__WEBPACK_IMPORTED_MODULE_3__.withArgs)(useSWRHandler);




/***/ }),

/***/ "./blocks/gallery/block.json":
/*!***********************************!*\
  !*** ./blocks/gallery/block.json ***!
  \***********************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"modula/gallery","version":"0.1.0","title":"Modula Gallery","category":"media","icon":"smiley","description":"Make your galleries stand out.","supports":{"html":false,"reusable":true,"multiple":true,"align":true,"anchor":true,"customClassName":true},"keywords":["gallery","modula","images"],"textdomain":"modula-best-grid-gallery","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","render":"file:./render.php","viewScript":"file:./view.js","attributes":{"images":{"type":"array","default":[]},"galleryId":{"type":"number","default":0},"galleryColumns":{"type":"number","default":1},"galleryType":{"type":"string","default":"creative"},"galleryLightbox":{"type":"string","default":"enabled"},"rowHeight":{"type":"string","default":""},"lastRow":{"type":"boolean","default":false},"galleryTitle":{"type":"string","default":""},"titleColor":{"type":"string"},"titleFontSize":{"type":"number","default":16},"titleVisibility":{"type":"string","default":"visible"},"captionColor":{"type":"string"},"captionFontSize":{"type":"number","default":16},"captionVisibility":{"type":"string","default":"visible"}}}');

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