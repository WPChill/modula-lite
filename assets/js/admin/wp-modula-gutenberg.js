/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};

;// CONCATENATED MODULE: ./assets/src/js/components/ModulaGallerySearch.js
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
;// CONCATENATED MODULE: ./assets/src/js/components/inspector.js


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
;// CONCATENATED MODULE: ./assets/src/js/utils/icons.js
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
;// CONCATENATED MODULE: ./assets/src/js/components/ModulaGalleryImageInner.js

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
;// CONCATENATED MODULE: ./assets/src/js/components/ModulaGalleryImage.js

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
;// CONCATENATED MODULE: ./assets/src/js/components/ModulaStyle.js
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
;// CONCATENATED MODULE: ./assets/src/js/components/ModulaItemsExtraComponent.js
var ModulaItemsExtraComponent = function ModulaItemsExtraComponent(props) {
  return null;
};
/* harmony default export */ const components_ModulaItemsExtraComponent = (wp.components.withFilters('modula.ModulaItemsExtraComponent')(ModulaItemsExtraComponent));
;// CONCATENATED MODULE: ./assets/src/js/components/ModulaGallery.js
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) { ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } } return n; }, _extends.apply(null, arguments); }
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
;// CONCATENATED MODULE: ./assets/src/js/components/edit.js
function edit_extends() { return edit_extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) { ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } } return n; }, edit_extends.apply(null, arguments); }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) { n[e] = r[e]; } return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0) { ; } } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
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
      jQuery.ajax({
        type: 'POST',
        data: {
          action: 'modula_get_gallery_meta',
          id: id,
          nonce: modulaVars.nonce
        },
        url: modulaVars.ajaxURL,
        success: function success(result) {
          return onGalleryLoaded(id, result);
        }
      });
    });
  };
  function escapeHtml(text) {
    return text.replace('&#8217;', "'").replace('&#8220;', '"').replace('&#8216;', "'");
  }
  var onGalleryLoaded = function onGalleryLoaded(id, result) {
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
var applyWithFilters = wp.components.withFilters('modula.ModulaEdit');
/* harmony default export */ const edit = (compose(applyWithSelect, applyWithFilters)(ModulaEdit));
;// CONCATENATED MODULE: ./assets/src/js/wp-modula-gutenberg.js
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
  _createClass(ModulaGutenberg, [{
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
  return ModulaGutenberg;
}();
var modulaGutenberg = new ModulaGutenberg();
/******/ })()
;