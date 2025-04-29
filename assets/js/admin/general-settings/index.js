/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@wordpress/icons/build-module/library/check.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/check.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
/**
 * WordPress dependencies
 */


const check = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__.Path, {
    d: "M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"
  })
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (check);
//# sourceMappingURL=check.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/close.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/close.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
/**
 * WordPress dependencies
 */


const close = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_0__.Path, {
    d: "m13.06 12 6.47-6.47-1.06-1.06L12 10.94 5.53 4.47 4.47 5.53 10.94 12l-6.47 6.47 1.06 1.06L12 13.06l6.47 6.47 1.06-1.06L13.06 12Z"
  })
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (close);
//# sourceMappingURL=close.js.map

/***/ }),

/***/ "./apps/general-settings/Content.jsx":
/*!*******************************************!*\
  !*** ./apps/general-settings/Content.jsx ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Content)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _context_useStateContext__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./context/useStateContext */ "./apps/general-settings/context/useStateContext.js");
/* harmony import */ var _query_useTabsQuery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./query/useTabsQuery */ "./apps/general-settings/query/useTabsQuery.js");
/* harmony import */ var _SettingsForm__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./SettingsForm */ "./apps/general-settings/SettingsForm.jsx");
/* harmony import */ var _SaveButton__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./SaveButton */ "./apps/general-settings/SaveButton.jsx");






function Content() {
  const {
    state
  } = (0,_context_useStateContext__WEBPACK_IMPORTED_MODULE_2__["default"])();
  const {
    data,
    isLoading
  } = (0,_query_useTabsQuery__WEBPACK_IMPORTED_MODULE_3__.useTabsQuery)();
  if (!data || isLoading) {
    return null;
  }
  const activeTab = data.find(tab => tab.slug === state.activeTab);
  if (!activeTab || !activeTab.subtabs) {
    return null;
  }
  return /*#__PURE__*/React.createElement("div", {
    className: "modula-page-content"
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Panel, {
    className: "modula-accordion-wrapper",
    header: activeTab.label
  }, Object.entries(activeTab.subtabs).map(([subtabSlug, subtabData]) => {
    if (!subtabData || Object.keys(subtabData).length === 0) {
      return null;
    }
    return /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
      className: "modula-accordion-pannel",
      key: subtabSlug,
      title: /*#__PURE__*/React.createElement("span", {
        className: "modula-accordion-title"
      }, /*#__PURE__*/React.createElement("span", {
        className: "modula-triangle-icon"
      }), /*#__PURE__*/React.createElement("span", null, subtabData.label), subtabData.badge && /*#__PURE__*/React.createElement("span", {
        className: "modula-pro-badge"
      }, " ", subtabData.badge, " ")),
      initialOpen: true
    }, /*#__PURE__*/React.createElement(_SettingsForm__WEBPACK_IMPORTED_MODULE_4__["default"], {
      config: subtabData?.config || {}
    }));
  }), (typeof activeTab.save === 'undefined' || activeTab.save !== false) && /*#__PURE__*/React.createElement(_SaveButton__WEBPACK_IMPORTED_MODULE_5__["default"], null)));
}

/***/ }),

/***/ "./apps/general-settings/FieldRenderer.jsx":
/*!*************************************************!*\
  !*** ./apps/general-settings/FieldRenderer.jsx ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _fields_ToggleField__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./fields/ToggleField */ "./apps/general-settings/fields/ToggleField.jsx");
/* harmony import */ var _fields_ToggleOptionsField__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./fields/ToggleOptionsField */ "./apps/general-settings/fields/ToggleOptionsField.jsx");
/* harmony import */ var _fields_SelectField__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./fields/SelectField */ "./apps/general-settings/fields/SelectField.jsx");
/* harmony import */ var _fields_TextField__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./fields/TextField */ "./apps/general-settings/fields/TextField.jsx");
/* harmony import */ var _fields_NumberField__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./fields/NumberField */ "./apps/general-settings/fields/NumberField.jsx");
/* harmony import */ var _fields_RadioField__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./fields/RadioField */ "./apps/general-settings/fields/RadioField.jsx");
/* harmony import */ var _fields_TextareaField__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./fields/TextareaField */ "./apps/general-settings/fields/TextareaField.jsx");
/* harmony import */ var _fields_RadioGroupField__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./fields/RadioGroupField */ "./apps/general-settings/fields/RadioGroupField.jsx");
/* harmony import */ var _fields_RangeSelect__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./fields/RangeSelect */ "./apps/general-settings/fields/RangeSelect.jsx");
/* harmony import */ var _fields_ImageSelectField__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./fields/ImageSelectField */ "./apps/general-settings/fields/ImageSelectField.jsx");
/* harmony import */ var _fields_ImportCheckboxGroupField__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./fields/ImportCheckboxGroupField */ "./apps/general-settings/fields/ImportCheckboxGroupField.jsx");












const FieldRenderer = ({
  field,
  fieldState,
  handleChange,
  disabled = false
}) => {
  switch (field.type) {
    case 'toggle':
      return /*#__PURE__*/React.createElement(_fields_ToggleField__WEBPACK_IMPORTED_MODULE_1__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val),
        disabled: disabled
      });
    case 'options_toggle':
      return /*#__PURE__*/React.createElement(_fields_ToggleOptionsField__WEBPACK_IMPORTED_MODULE_2__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val),
        trueValue: field.trueValue,
        falseValue: field.falseValue,
        disabled: disabled
      });
    case 'select':
      return /*#__PURE__*/React.createElement(_fields_SelectField__WEBPACK_IMPORTED_MODULE_3__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val),
        disabled: disabled
      });
    case 'text':
      return /*#__PURE__*/React.createElement(_fields_TextField__WEBPACK_IMPORTED_MODULE_4__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val),
        disabled: disabled
      });
    case 'number':
      return /*#__PURE__*/React.createElement(_fields_NumberField__WEBPACK_IMPORTED_MODULE_5__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val),
        disabled: disabled
      });
    case 'radio':
      return /*#__PURE__*/React.createElement(_fields_RadioField__WEBPACK_IMPORTED_MODULE_6__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val)
      });
    case 'textarea':
      return /*#__PURE__*/React.createElement(_fields_TextareaField__WEBPACK_IMPORTED_MODULE_7__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val)
      });
    case 'ia_radio':
      return /*#__PURE__*/React.createElement(_fields_RadioGroupField__WEBPACK_IMPORTED_MODULE_8__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val)
      });
    case 'range_select':
      return /*#__PURE__*/React.createElement(_fields_RangeSelect__WEBPACK_IMPORTED_MODULE_9__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val)
      });
    case 'image_select':
      return /*#__PURE__*/React.createElement(_fields_ImageSelectField__WEBPACK_IMPORTED_MODULE_10__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val)
      });
    case 'checkbox_group':
      return /*#__PURE__*/React.createElement(_fields_ImportCheckboxGroupField__WEBPACK_IMPORTED_MODULE_11__["default"], {
        fieldState: fieldState,
        field: field,
        handleChange: val => handleChange(fieldState, field.name, val)
      });
    default:
      return null;
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (FieldRenderer);

/***/ }),

/***/ "./apps/general-settings/Header.jsx":
/*!******************************************!*\
  !*** ./apps/general-settings/Header.jsx ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Header)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

function Header() {
  // eslint-disable-next-line no-undef
  const logoUrl = 'undefined' !== typeof modulaUrl ? `${modulaUrl}assets/images/logo-dark.webp` : '';
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: "modula-page-header"
  }, /*#__PURE__*/React.createElement("div", {
    className: "modula-header-logo"
  }, /*#__PURE__*/React.createElement("img", {
    src: logoUrl,
    alt: "modula logo",
    className: "modula-logo"
  }))));
}

/***/ }),

/***/ "./apps/general-settings/Navigation.jsx":
/*!**********************************************!*\
  !*** ./apps/general-settings/Navigation.jsx ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Navigation)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _context_useStateContext__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./context/useStateContext */ "./apps/general-settings/context/useStateContext.js");
/* harmony import */ var _context_actions__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./context/actions */ "./apps/general-settings/context/actions.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _query_useTabsQuery__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./query/useTabsQuery */ "./apps/general-settings/query/useTabsQuery.js");






function Navigation() {
  const {
    state,
    dispatch
  } = (0,_context_useStateContext__WEBPACK_IMPORTED_MODULE_2__["default"])();
  const {
    data,
    isLoading
  } = (0,_query_useTabsQuery__WEBPACK_IMPORTED_MODULE_5__.useTabsQuery)();
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useEffect)(() => {
    if (!state.activeTab && 'undefined' !== data && !isLoading) {
      const firstButton = data.find(link => 'undefined' === typeof link.type || link.type === 'button');
      if (firstButton) {
        dispatch((0,_context_actions__WEBPACK_IMPORTED_MODULE_3__.setActiveTab)(firstButton.slug));
      }
    }
  }, [state.activeTab, dispatch, data, isLoading]);
  if ('undefined' === data || isLoading) {
    return;
  }
  return /*#__PURE__*/React.createElement("div", {
    className: "modula-page-navigation"
  }, data.map(({
    label,
    slug,
    type = 'button',
    target = false
  }) => {
    const isLink = type === 'link';
    return /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
      key: slug,
      href: isLink ? slug : undefined,
      target: isLink && target ? '_blank' : undefined,
      rel: isLink && target ? 'noopener noreferrer' : undefined,
      onClick: !isLink ? () => dispatch((0,_context_actions__WEBPACK_IMPORTED_MODULE_3__.setActiveTab)(slug)) : undefined,
      className: `modula-header-button ${state.activeTab === slug ? 'modula-header-button-active' : ''}`
    }, label);
  }));
}

/***/ }),

/***/ "./apps/general-settings/RolesToggle.jsx":
/*!***********************************************!*\
  !*** ./apps/general-settings/RolesToggle.jsx ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ RolesToggle)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);



function RolesToggle({
  submenu,
  form
}) {
  const [active, setActive] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(submenu.options[0]?.value);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    form.setFieldValue('activeToggle', active);
  }, [active, form]);
  const handleClick = key => {
    setActive(key);
  };
  return /*#__PURE__*/React.createElement("div", {
    className: `modula_submenu_toggle_wrapper ${submenu.class || ''}`
  }, submenu.options.map(({
    label,
    value
  }) => /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    key: value,
    variant: active === value ? 'primary' : 'secondary',
    onClick: () => handleClick(value)
  }, label)));
}

/***/ }),

/***/ "./apps/general-settings/SaveButton.jsx":
/*!**********************************************!*\
  !*** ./apps/general-settings/SaveButton.jsx ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SaveButton)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _context_useStateContext__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./context/useStateContext */ "./apps/general-settings/context/useStateContext.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _query_useSettingsMutation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./query/useSettingsMutation */ "./apps/general-settings/query/useSettingsMutation.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _context_actions__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./context/actions */ "./apps/general-settings/context/actions.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__);







function SaveButton() {
  const {
    state,
    dispatch
  } = (0,_context_useStateContext__WEBPACK_IMPORTED_MODULE_1__["default"])();
  const settingsMutation = (0,_query_useSettingsMutation__WEBPACK_IMPORTED_MODULE_3__.useSettingsMutation)();
  const [showNotice, setShowNotice] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useState)(false);
  const isEmpty = Object.keys(state.options || {}).length === 0;
  const handleClick = () => {
    settingsMutation.mutate(state.options, {
      onSuccess: () => {
        // Reset updated but not saved settings.
        dispatch((0,_context_actions__WEBPACK_IMPORTED_MODULE_5__.setOptions)({}));
        setShowNotice(true);
      }
    });
  };
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_6__.useEffect)(() => {
    if (showNotice) {
      const timer = setTimeout(() => setShowNotice(false), 3000);
      return () => clearTimeout(timer);
    }
  }, [showNotice]);
  return /*#__PURE__*/React.createElement("div", {
    className: "modula_save_settings_wrap"
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    className: "modula_save_settings_button",
    onClick: handleClick,
    disabled: settingsMutation.isLoading || isEmpty,
    variant: "primary"
  }, settingsMutation.isLoading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Saving…', 'modula-best-grid-gallery') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Save Changes', 'modula-best-grid-gallery')), showNotice && /*#__PURE__*/React.createElement("div", {
    className: "modula_save_notice slide-in"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Settings saved successfully!', 'modula-best-grid-gallery')));
}

/***/ }),

/***/ "./apps/general-settings/SettingsForm.jsx":
/*!************************************************!*\
  !*** ./apps/general-settings/SettingsForm.jsx ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SettingsForm)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _tanstack_react_form__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @tanstack/react-form */ "./node_modules/@tanstack/react-form/dist/esm/useForm.js");
/* harmony import */ var _tanstack_react_form__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @tanstack/react-form */ "./node_modules/@tanstack/react-form/node_modules/@tanstack/react-store/dist/esm/index.js");
/* harmony import */ var _FieldRenderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FieldRenderer */ "./apps/general-settings/FieldRenderer.jsx");
/* harmony import */ var _ai_settings_ai_settings_form__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ai-settings/ai-settings-form */ "./apps/general-settings/ai-settings/ai-settings-form.jsx");
/* harmony import */ var _fields_ButtonField__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./fields/ButtonField */ "./apps/general-settings/fields/ButtonField.jsx");
/* harmony import */ var _fields_Paragraph__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./fields/Paragraph */ "./apps/general-settings/fields/Paragraph.jsx");
/* harmony import */ var _fields_ComboField__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./fields/ComboField */ "./apps/general-settings/fields/ComboField.jsx");
/* harmony import */ var _fields_RoleField__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./fields/RoleField */ "./apps/general-settings/fields/RoleField.jsx");
/* harmony import */ var _UpsellBlock__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./UpsellBlock */ "./apps/general-settings/UpsellBlock.jsx");
/* harmony import */ var _RolesToggle__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./RolesToggle */ "./apps/general-settings/RolesToggle.jsx");
/* harmony import */ var _context_useStateContext__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./context/useStateContext */ "./apps/general-settings/context/useStateContext.js");
/* harmony import */ var _context_actions__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./context/actions */ "./apps/general-settings/context/actions.js");












function SettingsForm({
  config
}) {
  const {
    state,
    dispatch
  } = (0,_context_useStateContext__WEBPACK_IMPORTED_MODULE_9__["default"])();
  function setDefaultValue(acc, option, name, defaultValue) {
    if (!name) {
      return acc;
    }
    if (name.includes('.')) {
      const [parent, child] = name.split('.');
      if (option) {
        acc[option] = acc[option] || {};
        acc[option][parent] = acc[option][parent] || {};
        acc[option][parent][child] = defaultValue !== null && defaultValue !== void 0 ? defaultValue : '';
      } else {
        acc[parent] = acc[parent] || {};
        acc[parent][child] = defaultValue !== null && defaultValue !== void 0 ? defaultValue : '';
      }
    } else if (option) {
      acc[option] = acc[option] || {};
      acc[option][name] = defaultValue !== null && defaultValue !== void 0 ? defaultValue : '';
    } else {
      acc[name] = defaultValue !== null && defaultValue !== void 0 ? defaultValue : '';
    }
  }
  const {
    option,
    fields = []
  } = config;
  const form = (0,_tanstack_react_form__WEBPACK_IMPORTED_MODULE_11__.useForm)({
    defaultValues: fields.reduce((acc, field) => {
      switch (field.type) {
        case 'combo':
          field.fields.forEach(comboField => {
            setDefaultValue(acc, option, comboField.name, comboField.default);
          });
          break;
        case 'role':
          // Enable role field
          setDefaultValue(acc, option, field.name, field.default);
          // Capabilities
          field.fields.forEach(comboField => {
            setDefaultValue(acc, option, comboField.name, comboField.default);
          });
          break;
        case 'button':
        case 'paragraph':
          // We skip these
          break;
        default:
          setDefaultValue(acc, option, field.name, field.default);
          break;
      }
      return acc;
    }, {})
  });
  const values = form.store.state.values;
  const formValues = option ? values[option] || {} : values;
  const handleSave = (opt, val) => {
    dispatch((0,_context_actions__WEBPACK_IMPORTED_MODULE_10__.setOptions)({
      ...state.options,
      [opt]: val
    }));
  };
  const operators = {
    '===': (a, b) => a === b,
    '!==': (a, b) => a !== b,
    '>': (a, b) => a > b,
    '<': (a, b) => a < b,
    '>=': (a, b) => a >= b,
    '<=': (a, b) => a <= b
  };
  const evaluateConditions = conditions => {
    if (!conditions) {
      return true;
    }
    return conditions.every(({
      field,
      comparison,
      value
    }) => {
      var _val;
      const keys = field.split('.');
      let val = formValues;
      for (const key of keys) {
        val = val?.[key];
      }
      return operators[comparison]((_val = val) !== null && _val !== void 0 ? _val : null, value);
    });
  };
  const handleChange = (fieldState, fieldName, newValue) => {
    fieldState.handleChange(newValue);
    const allValues = form.store.state.values;
    const updatedFormValues = option ? {
      ...allValues[option]
    } : {
      ...allValues
    };
    if (fieldName.includes('.')) {
      const [parent, child] = fieldName.split('.');
      updatedFormValues[parent] = updatedFormValues[parent] || {};
      updatedFormValues[parent][child] = newValue;
    } else {
      updatedFormValues[fieldName] = newValue;
    }
    if (option) {
      handleSave(option, updatedFormValues);
    } else if (fieldName.includes('.')) {
      const [parent] = fieldName.split('.');
      handleSave(parent, updatedFormValues[parent]);
    } else {
      handleSave(fieldName, newValue);
    }
  };
  const activeToggle = (0,_tanstack_react_form__WEBPACK_IMPORTED_MODULE_12__.useStore)(form.store, statex => statex.values.activeToggle) || '';
  if (!config || !fields) {
    return /*#__PURE__*/React.createElement("p", null, "Loading settings...");
  }
  if (fields.length === 0) {
    return /*#__PURE__*/React.createElement("div", {
      className: "modula_no_settings"
    }, "\u2699\uFE0F No settings found.");
  }
  const optionValue = option ? option : 'default';
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("form", {
    className: `modula_options_form modula_${optionValue}_form`
  }, config.submenu && /*#__PURE__*/React.createElement(_RolesToggle__WEBPACK_IMPORTED_MODULE_8__["default"], {
    form: form,
    submenu: config.submenu
  }), fields.map((field, index) => {
    if (!evaluateConditions(field.conditions)) {
      return null;
    }
    if (field.type === 'role') {
      return /*#__PURE__*/React.createElement(_fields_RoleField__WEBPACK_IMPORTED_MODULE_6__.RoleField, {
        key: index,
        option: option,
        mainField: field,
        form: form,
        handleChange: handleChange
      });
    }
    if (field.group && field.group !== activeToggle) {
      return null;
    }
    if (field.type === 'modula_ai') {
      return /*#__PURE__*/React.createElement(_ai_settings_ai_settings_form__WEBPACK_IMPORTED_MODULE_2__["default"], {
        key: index
      });
    }
    if (field.type === 'combo') {
      return /*#__PURE__*/React.createElement("div", {
        key: index,
        className: "modula_field_wrapper"
      }, /*#__PURE__*/React.createElement(_fields_ComboField__WEBPACK_IMPORTED_MODULE_5__.ComboField, {
        option: option,
        field: field,
        form: form,
        handleChange: handleChange,
        evaluateConditions: evaluateConditions
      }));
    }
    if (field.type === 'button') {
      return /*#__PURE__*/React.createElement("div", {
        key: index,
        className: "modula_field_wrapper"
      }, /*#__PURE__*/React.createElement(_fields_ButtonField__WEBPACK_IMPORTED_MODULE_3__["default"], {
        field: field
      }));
    }
    if (field.type === 'paragraph') {
      return /*#__PURE__*/React.createElement("div", {
        key: index,
        className: "modula_field_wrapper"
      }, /*#__PURE__*/React.createElement(_fields_Paragraph__WEBPACK_IMPORTED_MODULE_4__["default"], {
        field: field
      }));
    }
    if (field.type === 'upsell') {
      return /*#__PURE__*/React.createElement(_UpsellBlock__WEBPACK_IMPORTED_MODULE_7__["default"], {
        key: index,
        field: field
      });
    }
    return /*#__PURE__*/React.createElement("div", {
      key: field.name,
      className: `modula_field_wrapper ${field.disabled ? 'modula_disabled_field' : ''}`
    }, /*#__PURE__*/React.createElement("div", {
      className: "modula_field_wrapp"
    }, /*#__PURE__*/React.createElement(form.Field, {
      name: option ? `${option}.${field.name}` : field.name
    }, fieldState => /*#__PURE__*/React.createElement(_FieldRenderer__WEBPACK_IMPORTED_MODULE_1__["default"], {
      field: field,
      fieldState: fieldState,
      handleChange: handleChange,
      disabled: field.disabled || false
    }))));
  })));
}

/***/ }),

/***/ "./apps/general-settings/SettingsPage.jsx":
/*!************************************************!*\
  !*** ./apps/general-settings/SettingsPage.jsx ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SettingsPage)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Header */ "./apps/general-settings/Header.jsx");
/* harmony import */ var _Navigation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Navigation */ "./apps/general-settings/Navigation.jsx");
/* harmony import */ var _Content__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Content */ "./apps/general-settings/Content.jsx");




function SettingsPage() {
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(_Header__WEBPACK_IMPORTED_MODULE_1__["default"], null), /*#__PURE__*/React.createElement(_Navigation__WEBPACK_IMPORTED_MODULE_2__["default"], null), /*#__PURE__*/React.createElement(_Content__WEBPACK_IMPORTED_MODULE_3__["default"], null));
}

/***/ }),

/***/ "./apps/general-settings/UpsellBlock.jsx":
/*!***********************************************!*\
  !*** ./apps/general-settings/UpsellBlock.jsx ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ UpsellBlock)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function UpsellBlock({
  field
}) {
  const {
    label,
    desc,
    buttons = []
  } = field;
  return /*#__PURE__*/React.createElement("div", {
    className: "modula_upsell_field_wrapper"
  }, label && /*#__PURE__*/React.createElement("h3", null, label), desc && /*#__PURE__*/React.createElement("p", {
    dangerouslySetInnerHTML: {
      __html: desc
    }
  }), buttons.length > 0 && /*#__PURE__*/React.createElement("div", {
    className: "modula_upsell_buttons_wrapper"
  }, buttons.map((button, index) => {
    return /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
      key: index,
      href: button.href,
      variant: button.variant || 'primary',
      target: "blank",
      rel: "noopener noreferrer"
    }, button.label);
  })));
}

/***/ }),

/***/ "./apps/general-settings/ai-settings/ai-settings-form.jsx":
/*!****************************************************************!*\
  !*** ./apps/general-settings/ai-settings/ai-settings-form.jsx ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ AiSettingsForm)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _settings_form_claim_credits__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./settings-form/claim-credits */ "./apps/general-settings/ai-settings/settings-form/claim-credits.jsx");
/* harmony import */ var _settings_form_button_action__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./settings-form/button-action */ "./apps/general-settings/ai-settings/settings-form/button-action.jsx");



function AiSettingsForm() {
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: "modula_field_wrapper"
  }, /*#__PURE__*/React.createElement(_settings_form_claim_credits__WEBPACK_IMPORTED_MODULE_1__["default"], null)), /*#__PURE__*/React.createElement("div", {
    className: "modula_field_wrapper"
  }, /*#__PURE__*/React.createElement(_settings_form_button_action__WEBPACK_IMPORTED_MODULE_2__["default"], null)));
}

/***/ }),

/***/ "./apps/general-settings/ai-settings/settings-form/button-action.jsx":
/*!***************************************************************************!*\
  !*** ./apps/general-settings/ai-settings/settings-form/button-action.jsx ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ButtonAction)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4__);





function ButtonAction() {
  const [isLoading, setIsLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useState)(false);
  const [isCleaning, setIsCleaning] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useState)(false);
  const [notification, setNotification] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useState)(null);
  const handleButtonClick = async () => {
    setIsLoading(true);
    setNotification(null);
    try {
      const response = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4___default()({
        path: '/modula-ai-image-descriptor/v1/update-alts-from-image-array',
        method: 'POST'
      });
      if (response.success) {
        setNotification({
          status: 'success',
          message: response.message,
          details: response.data ? `(${response.data.updated_images} images from ${response.data.total_galleries} galleries)` : ''
        });
      } else {
        setNotification({
          status: 'error',
          message: response.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Failed to update gallery images.', 'modula-best-grid-gallery')
        });
      }
    } catch (error) {
      setNotification({
        status: 'error',
        message: error.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('An error occurred while updating gallery images.', 'modula-best-grid-gallery')
      });
    } finally {
      setIsLoading(false);
    }
  };
  const handleCleanupClick = async () => {
    if (!window.confirm((0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Are you sure you want to delete all trash and draft galleries? This action cannot be undone.', 'modula-best-grid-gallery'))) {
      return;
    }
    setIsCleaning(true);
    setNotification(null);
    try {
      const response = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_4___default()({
        path: '/modula-ai-image-descriptor/v1/cleanup-galleries',
        method: 'POST'
      });
      if (response.success) {
        setNotification({
          status: 'success',
          message: response.message,
          details: response.data ? `(${response.data.deleted_posts} galleries and ${response.data.deleted_meta} meta entries)` : ''
        });
      } else {
        setNotification({
          status: 'error',
          message: response.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Failed to cleanup galleries.', 'modula-best-grid-gallery')
        });
      }
    } catch (error) {
      setNotification({
        status: 'error',
        message: error.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('An error occurred while cleaning up galleries.', 'modula-best-grid-gallery')
      });
    } finally {
      setIsCleaning(false);
    }
  };
  return /*#__PURE__*/React.createElement("div", {
    className: "modula-button-action"
  }, notification && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Notice, {
    status: notification.status,
    isDismissible: false,
    className: "modula-notice"
  }, notification.message, notification.details && /*#__PURE__*/React.createElement("span", {
    className: "modula-notice-details"
  }, ' ', notification.details)), /*#__PURE__*/React.createElement("p", {
    className: "modula-description"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('With the latest update, we have changed the way the image information is handled, now the information is retrieved from the Media Library. If you wish to set your previous details for the gallery images, please click the below button.', 'modula-best-grid-gallery')), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    variant: "primary",
    isBusy: isLoading,
    disabled: isLoading,
    onClick: handleButtonClick
  }, isLoading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Processing…', 'modula-best-grid-gallery') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Update Gallery Images', 'modula-best-grid-gallery')), /*#__PURE__*/React.createElement("div", {
    className: "modula-cleanup-section"
  }, /*#__PURE__*/React.createElement("p", {
    className: "modula-description"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Clean up your database by removing all wrongfully created galleries.', 'modula-best-grid-gallery')), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    isDestructive: true,
    isBusy: isCleaning,
    disabled: isCleaning,
    onClick: handleCleanupClick
  }, isCleaning ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Cleaning up…', 'modula-best-grid-gallery') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Cleanup database', 'modula-best-grid-gallery'))));
}

/***/ }),

/***/ "./apps/general-settings/ai-settings/settings-form/claim-credits.jsx":
/*!***************************************************************************!*\
  !*** ./apps/general-settings/ai-settings/settings-form/claim-credits.jsx ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ClaimCredits)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _claim_credits_module_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./claim-credits.module.css */ "./apps/general-settings/ai-settings/settings-form/claim-credits.module.css");
/* harmony import */ var _tanstack_react_form__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @tanstack/react-form */ "./node_modules/@tanstack/react-form/dist/esm/useForm.js");
/* harmony import */ var _query_useSettingsQuery__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../query/useSettingsQuery */ "./apps/general-settings/query/useSettingsQuery.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/check.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/close.js");
/* harmony import */ var _languages__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./languages */ "./apps/general-settings/ai-settings/settings-form/languages.js");
/* harmony import */ var _context_useStateContext__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../context/useStateContext */ "./apps/general-settings/context/useStateContext.js");
/* harmony import */ var _context_actions__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../../context/actions */ "./apps/general-settings/context/actions.js");










function ClaimCredits() {
  const {
    data
  } = (0,_query_useSettingsQuery__WEBPACK_IMPORTED_MODULE_4__.useSettingsQuery)();
  const {
    state,
    dispatch
  } = (0,_context_useStateContext__WEBPACK_IMPORTED_MODULE_6__["default"])();
  const form = (0,_tanstack_react_form__WEBPACK_IMPORTED_MODULE_8__.useForm)({
    defaultValues: {
      modula_ai_api_key: data?.api_key || '',
      modula_ai_language: data?.language || 'en',
      email: data?.readonly?.email,
      first_name: data?.readonly?.first_name,
      last_name: data?.readonly?.last_name,
      valid_key: data?.readonly?.valid_key
    }
  });
  const claimCredits = () => {
    window.open('https://wp-modula.com/my-account', '_blank');
  };
  const handleChange = (val, field) => {
    field.handleChange(val);
    console.error(field);
    dispatch((0,_context_actions__WEBPACK_IMPORTED_MODULE_7__.setOptions)({
      ...state.options,
      [field.name]: val
    }));
  };
  const validKey = data?.readonly?.valid_key;
  return /*#__PURE__*/React.createElement("div", {
    className: _claim_credits_module_css__WEBPACK_IMPORTED_MODULE_3__["default"].container
  }, !validKey && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("p", {
    className: _claim_credits_module_css__WEBPACK_IMPORTED_MODULE_3__["default"].description
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('In order to use this powerful functionality you will first need to claim your credits.', 'modula-best-grid-gallery')), /*#__PURE__*/React.createElement("p", {
    className: _claim_credits_module_css__WEBPACK_IMPORTED_MODULE_3__["default"].description
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('If you already have the api key, use it in the field below or click "Claim Credits" to get a new one.', 'modula-best-grid-gallery'))), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Flex, {
    gap: 4,
    align: "flex-start"
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.FlexItem, {
    style: {
      flex: 2
    }
  }, /*#__PURE__*/React.createElement(form.Field, {
    name: "modula_ai_api_key",
    children: field => /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextControl, {
      __nextHasNoMarginBottom: true,
      __next40pxDefaultSize: true,
      label: /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Flex, {
        justify: "space-between"
      }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.FlexItem, null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Flex, {
        justify: "flex-start",
        gap: 2
      }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.FlexItem, null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('API Key', 'modula-best-grid-gallery')), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.FlexItem, null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
        style: {
          fill: validKey ? 'green' : 'red'
        },
        size: validKey ? 18 : 14,
        icon: validKey ? _wordpress_icons__WEBPACK_IMPORTED_MODULE_9__["default"] : _wordpress_icons__WEBPACK_IMPORTED_MODULE_10__["default"],
        className: "modula-settings-form-valid-key"
      })))), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.FlexItem, null, validKey && /*#__PURE__*/React.createElement(React.Fragment, null, data?.readonly?.credits, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Credits remaining', 'modula-best-grid-gallery')), !validKey && /*#__PURE__*/React.createElement(React.Fragment, null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Invalid API Key', 'modula-best-grid-gallery')))),
      value: field.state.value,
      onChange: val => handleChange(val, field)
    })
  })), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.FlexItem, {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement(form.Field, {
    name: "modula_ai_language",
    children: field => /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SelectControl, {
      __nextHasNoMarginBottom: true,
      __next40pxDefaultSize: true,
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Language used to generate reports', 'modula-best-grid-gallery'),
      value: field.state.value,
      options: _languages__WEBPACK_IMPORTED_MODULE_5__.LANGUAGES,
      onChange: val => handleChange(val, field)
    })
  }))), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalSpacer, {
    marginTop: 4,
    marginBottom: 4
  }), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Flex, {
    justify: "flex-start",
    gap: 4,
    className: _claim_credits_module_css__WEBPACK_IMPORTED_MODULE_3__["default"].buttonContainer
  }, !validKey && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
    variant: "link",
    onClick: claimCredits
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Claim Credits', 'modula-best-grid-gallery'))));
}

/***/ }),

/***/ "./apps/general-settings/ai-settings/settings-form/languages.js":
/*!**********************************************************************!*\
  !*** ./apps/general-settings/ai-settings/settings-form/languages.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   LANGUAGES: () => (/* binding */ LANGUAGES)
/* harmony export */ });
const LANGUAGES = [{
  value: 'ab',
  label: 'Abkhaz'
}, {
  value: 'ace',
  label: 'Acehnese'
}, {
  value: 'ach',
  label: 'Acholi'
}, {
  value: 'af',
  label: 'Afrikaans'
}, {
  value: 'sq',
  label: 'Albanian'
}, {
  value: 'alz',
  label: 'Alur'
}, {
  value: 'am',
  label: 'Amharic'
}, {
  value: 'ar',
  label: 'Arabic'
}, {
  value: 'hy',
  label: 'Armenian'
}, {
  value: 'as',
  label: 'Assamese'
}, {
  value: 'awa',
  label: 'Awadhi'
}, {
  value: 'ay',
  label: 'Aymara'
}, {
  value: 'az',
  label: 'Azerbaijani'
}, {
  value: 'ban',
  label: 'Balinese'
}, {
  value: 'bm',
  label: 'Bambara'
}, {
  value: 'ba',
  label: 'Bashkir'
}, {
  value: 'eu',
  label: 'Basque'
}, {
  value: 'btx',
  label: 'Batak Karo'
}, {
  value: 'bts',
  label: 'Batak Simalungun'
}, {
  value: 'bbc',
  label: 'Batak Toba'
}, {
  value: 'be',
  label: 'Belarusian'
}, {
  value: 'bem',
  label: 'Bemba'
}, {
  value: 'bn',
  label: 'Bengali'
}, {
  value: 'bew',
  label: 'Betawi'
}, {
  value: 'bho',
  label: 'Bhojpuri'
}, {
  value: 'bik',
  label: 'Bikol'
}, {
  value: 'bs',
  label: 'Bosnian'
}, {
  value: 'br',
  label: 'Breton'
}, {
  value: 'bg',
  label: 'Bulgarian'
}, {
  value: 'bua',
  label: 'Buryat'
}, {
  value: 'yue',
  label: 'Cantonese'
}, {
  value: 'ca',
  label: 'Catalan'
}, {
  value: 'ceb',
  label: 'Cebuano'
}, {
  value: 'ny',
  label: 'Chichewa'
}, {
  value: 'zh',
  label: 'Chinese (Simplified)'
}, {
  value: 'zh-TW',
  label: 'Chinese (Traditional)'
}, {
  value: 'cv',
  label: 'Chuvash'
}, {
  value: 'co',
  label: 'Corsican'
}, {
  value: 'crh',
  label: 'Crimean Tatar'
}, {
  value: 'hr',
  label: 'Croatian'
}, {
  value: 'cs',
  label: 'Czech'
}, {
  value: 'da',
  label: 'Danish'
}, {
  value: 'dv',
  label: 'Dhivehi'
}, {
  value: 'din',
  label: 'Dinka'
}, {
  value: 'doi',
  label: 'Dogri'
}, {
  value: 'dov',
  label: 'Dombe'
}, {
  value: 'nl',
  label: 'Dutch'
}, {
  value: 'dz',
  label: 'Dzongkha'
}, {
  value: 'en',
  label: 'English'
}, {
  value: 'eo',
  label: 'Esperanto'
}, {
  value: 'et',
  label: 'Estonian'
}, {
  value: 'ee',
  label: 'Ewe'
}, {
  value: 'fj',
  label: 'Fijian'
}, {
  value: 'tl',
  label: 'Filipino'
}, {
  value: 'fi',
  label: 'Finnish'
}, {
  value: 'fr',
  label: 'French'
}, {
  value: 'fy',
  label: 'Frisian'
}, {
  value: 'ff',
  label: 'Fulani'
}, {
  value: 'gaa',
  label: 'Ga'
}, {
  value: 'gl',
  label: 'Galician'
}, {
  value: 'ka',
  label: 'Georgian'
}, {
  value: 'de',
  label: 'German'
}, {
  value: 'el',
  label: 'Greek'
}, {
  value: 'gn',
  label: 'Guarani'
}, {
  value: 'gu',
  label: 'Gujarati'
}, {
  value: 'ht',
  label: 'Haitian Creole'
}, {
  value: 'cnh',
  label: 'Hakha Chin'
}, {
  value: 'ha',
  label: 'Hausa'
}, {
  value: 'haw',
  label: 'Hawaiian'
}, {
  value: 'iw',
  label: 'Hebrew'
}, {
  value: 'hil',
  label: 'Hiligaynon'
}, {
  value: 'hi',
  label: 'Hindi'
}, {
  value: 'hmn',
  label: 'Hmong'
}, {
  value: 'hu',
  label: 'Hungarian'
}, {
  value: 'hrx',
  label: 'Hunsrik'
}, {
  value: 'is',
  label: 'Icelandic'
}, {
  value: 'ig',
  label: 'Igbo'
}, {
  value: 'ilo',
  label: 'Ilocano'
}, {
  value: 'id',
  label: 'Indonesian'
}, {
  value: 'ga',
  label: 'Irish'
}, {
  value: 'it',
  label: 'Italian'
}, {
  value: 'ja',
  label: 'Japanese'
}, {
  value: 'jw',
  label: 'Javanese'
}, {
  value: 'kn',
  label: 'Kannada'
}, {
  value: 'pam',
  label: 'Kapampangan'
}, {
  value: 'kk',
  label: 'Kazakh'
}, {
  value: 'km',
  label: 'Khmer'
}, {
  value: 'cgg',
  label: 'Kiga'
}, {
  value: 'rw',
  label: 'Kinyarwanda'
}, {
  value: 'ktu',
  label: 'Kituba'
}, {
  value: 'gom',
  label: 'Konkani'
}, {
  value: 'ko',
  label: 'Korean'
}, {
  value: 'kri',
  label: 'Krio'
}, {
  value: 'ku',
  label: 'Kurdish (Kurmanji)'
}, {
  value: 'ckb',
  label: 'Kurdish (Sorani)'
}, {
  value: 'ky',
  label: 'Kyrgyz'
}, {
  value: 'lo',
  label: 'Lao'
}, {
  value: 'ltg',
  label: 'Latgalian'
}, {
  value: 'la',
  label: 'Latin'
}, {
  value: 'lv',
  label: 'Latvian'
}, {
  value: 'lij',
  label: 'Ligurian'
}, {
  value: 'li',
  label: 'Limburgish'
}, {
  value: 'ln',
  label: 'Lingala'
}, {
  value: 'lt',
  label: 'Lithuanian'
}, {
  value: 'lmo',
  label: 'Lombard'
}, {
  value: 'lg',
  label: 'Luganda'
}, {
  value: 'luo',
  label: 'Luo'
}, {
  value: 'lb',
  label: 'Luxembourgish'
}, {
  value: 'mk',
  label: 'Macedonian'
}, {
  value: 'mai',
  label: 'Maithili'
}, {
  value: 'mak',
  label: 'Makassar'
}, {
  value: 'mg',
  label: 'Malagasy'
}, {
  value: 'ms',
  label: 'Malay'
}, {
  value: 'ms-Arab',
  label: 'Malay (Jawi)'
}, {
  value: 'ml',
  label: 'Malayalam'
}, {
  value: 'mt',
  label: 'Maltese'
}, {
  value: 'mi',
  label: 'Maori'
}, {
  value: 'mr',
  label: 'Marathi'
}, {
  value: 'chm',
  label: 'Meadow Mari'
}, {
  value: 'mni-Mtei',
  label: 'Meiteilon (Manipuri)'
}, {
  value: 'min',
  label: 'Minang'
}, {
  value: 'lus',
  label: 'Mizo'
}, {
  value: 'mn',
  label: 'Mongolian'
}, {
  value: 'my',
  label: 'Myanmar (Burmese)'
}, {
  value: 'nr',
  label: 'Ndebele (South)'
}, {
  value: 'new',
  label: 'Nepalbhasa (Newari)'
}, {
  value: 'ne',
  label: 'Nepali'
}, {
  value: 'no',
  label: 'Norwegian'
}, {
  value: 'nus',
  label: 'Nuer'
}, {
  value: 'oc',
  label: 'Occitan'
}, {
  value: 'or',
  label: 'Odia (Oriya)'
}, {
  value: 'om',
  label: 'Oromo'
}, {
  value: 'pag',
  label: 'Pangasinan'
}, {
  value: 'pap',
  label: 'Papiamento'
}, {
  value: 'ps',
  label: 'Pashto'
}, {
  value: 'fa',
  label: 'Persian'
}, {
  value: 'pl',
  label: 'Polish'
}, {
  value: 'pt',
  label: 'Portuguese (Brazil)'
}, {
  value: 'pa',
  label: 'Punjabi (Gurmukhi)'
}, {
  value: 'pa-Arab',
  label: 'Punjabi (Shahmukhi)'
}, {
  value: 'qu',
  label: 'Quechua'
}, {
  value: 'rom',
  label: 'Romani'
}, {
  value: 'ro',
  label: 'Romanian'
}, {
  value: 'rn',
  label: 'Rundi'
}, {
  value: 'ru',
  label: 'Russian'
}, {
  value: 'sm',
  label: 'Samoan'
}, {
  value: 'sg',
  label: 'Sango'
}, {
  value: 'sa',
  label: 'Sanskrit'
}, {
  value: 'gd',
  label: 'Scots Gaelic'
}, {
  value: 'nso',
  label: 'Sepedi'
}, {
  value: 'sr',
  label: 'Serbian'
}, {
  value: 'st',
  label: 'Sesotho'
}, {
  value: 'crs',
  label: 'Seychellois Creole'
}, {
  value: 'shn',
  label: 'Shan'
}, {
  value: 'sn',
  label: 'Shona'
}, {
  value: 'scn',
  label: 'Sicilian'
}, {
  value: 'szl',
  label: 'Silesian'
}, {
  value: 'sd',
  label: 'Sindhi'
}, {
  value: 'si',
  label: 'Sinhala'
}, {
  value: 'sk',
  label: 'Slovak'
}, {
  value: 'sl',
  label: 'Slovenian'
}, {
  value: 'so',
  label: 'Somali'
}, {
  value: 'es',
  label: 'Spanish'
}, {
  value: 'su',
  label: 'Sundanese'
}, {
  value: 'sw',
  label: 'Swahili'
}, {
  value: 'ss',
  label: 'Swati'
}, {
  value: 'sv',
  label: 'Swedish'
}, {
  value: 'tg',
  label: 'Tajik'
}, {
  value: 'ta',
  label: 'Tamil'
}, {
  value: 'tt',
  label: 'Tatar'
}, {
  value: 'te',
  label: 'Telugu'
}, {
  value: 'tet',
  label: 'Tetum'
}, {
  value: 'th',
  label: 'Thai'
}, {
  value: 'ti',
  label: 'Tigrinya'
}, {
  value: 'ts',
  label: 'Tsonga'
}, {
  value: 'tn',
  label: 'Tswana'
}, {
  value: 'tr',
  label: 'Turkish'
}, {
  value: 'tk',
  label: 'Turkmen'
}, {
  value: 'ak',
  label: 'Twi'
}, {
  value: 'uk',
  label: 'Ukrainian'
}, {
  value: 'ur',
  label: 'Urdu'
}, {
  value: 'ug',
  label: 'Uyghur'
}, {
  value: 'uz',
  label: 'Uzbek'
}, {
  value: 'vi',
  label: 'Vietnamese'
}, {
  value: 'cy',
  label: 'Welsh'
}, {
  value: 'xh',
  label: 'Xhosa'
}, {
  value: 'yi',
  label: 'Yiddish'
}, {
  value: 'yo',
  label: 'Yoruba'
}, {
  value: 'yua',
  label: 'Yucatec Maya'
}, {
  value: 'zu',
  label: 'Zulu'
}, {
  value: 'he',
  label: 'Hebrew'
}, {
  value: 'jv',
  label: 'Javanese'
}, {
  value: 'zh-CN',
  label: 'Chinese (Simplified)'
}];

/***/ }),

/***/ "./apps/general-settings/context/actions.js":
/*!**************************************************!*\
  !*** ./apps/general-settings/context/actions.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   setActiveTab: () => (/* binding */ setActiveTab),
/* harmony export */   setLoggedIn: () => (/* binding */ setLoggedIn),
/* harmony export */   setOptions: () => (/* binding */ setOptions),
/* harmony export */   toggleAdvancedRegistration: () => (/* binding */ toggleAdvancedRegistration)
/* harmony export */ });
/* harmony import */ var _reducer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./reducer */ "./apps/general-settings/context/reducer.js");

const setActiveTab = value => ({
  type: _reducer__WEBPACK_IMPORTED_MODULE_0__.actionTypes.SET_ACTIVE_TAB,
  payload: value
});
const setOptions = value => ({
  type: _reducer__WEBPACK_IMPORTED_MODULE_0__.actionTypes.SET_OPTIONS,
  payload: value
});
const toggleAdvancedRegistration = value => ({
  type: _reducer__WEBPACK_IMPORTED_MODULE_0__.actionTypes.TOGGLE_ADVANCED_REGISTRATION,
  payload: value
});
const setLoggedIn = value => ({
  type: _reducer__WEBPACK_IMPORTED_MODULE_0__.actionTypes.SET_LOGGED_IN,
  payload: value
});

/***/ }),

/***/ "./apps/general-settings/context/initial-state.js":
/*!********************************************************!*\
  !*** ./apps/general-settings/context/initial-state.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initialState: () => (/* binding */ initialState)
/* harmony export */ });
const initialState = activeTab => ({
  api_key: '',
  isAdvancedRegistration: false,
  isLoggedIn: false,
  activeTab: activeTab || false,
  options: {}
});

/***/ }),

/***/ "./apps/general-settings/context/reducer.js":
/*!**************************************************!*\
  !*** ./apps/general-settings/context/reducer.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   actionTypes: () => (/* binding */ actionTypes),
/* harmony export */   reducer: () => (/* binding */ reducer)
/* harmony export */ });
const actionTypes = {
  SET_ACTIVE_TAB: 'SET_ACTIVE_TAB',
  SET_OPTIONS: 'SET_OPTIONS',
  UPDATE_SETTINGS: 'UPDATE_SETTINGS',
  TOGGLE_ADVANCED_REGISTRATION: 'TOGGLE_ADVANCED_REGISTRATION',
  SET_LOGGED_IN: 'SET_LOGGED_IN'
};
const reducer = (state, action) => {
  switch (action.type) {
    case actionTypes.SET_ACTIVE_TAB:
      return {
        ...state,
        activeTab: action.payload
      };
    case actionTypes.SET_OPTIONS:
      return {
        ...state,
        options: action.payload
      };
    case actionTypes.UPDATE_SETTINGS:
      return {
        ...state,
        settings: action.payload
      };
    case actionTypes.TOGGLE_ADVANCED_REGISTRATION:
      return {
        ...state,
        isAdvancedRegistration: action.payload
      };
    case actionTypes.SET_LOGGED_IN:
      return {
        ...state,
        isLoggedIn: action.payload
      };
    default:
      return state;
  }
};

/***/ }),

/***/ "./apps/general-settings/context/settings-context.jsx":
/*!************************************************************!*\
  !*** ./apps/general-settings/context/settings-context.jsx ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   SettingsContext: () => (/* binding */ SettingsContext),
/* harmony export */   SettingsProvider: () => (/* binding */ SettingsProvider)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _reducer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./reducer */ "./apps/general-settings/context/reducer.js");
/* harmony import */ var _initial_state__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./initial-state */ "./apps/general-settings/context/initial-state.js");




const SettingsContext = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createContext)(_initial_state__WEBPACK_IMPORTED_MODULE_3__.initialState);
const SettingsProvider = ({
  children,
  activeTab
}) => {
  const [state, dispatch] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useReducer)(_reducer__WEBPACK_IMPORTED_MODULE_2__.reducer, _initial_state__WEBPACK_IMPORTED_MODULE_3__.initialState, initial => ({
    ...initial,
    activeTab
  }));
  const contextValue = {
    state,
    dispatch
  };
  return /*#__PURE__*/React.createElement(SettingsContext.Provider, {
    value: contextValue
  }, children);
};

/***/ }),

/***/ "./apps/general-settings/context/useStateContext.js":
/*!**********************************************************!*\
  !*** ./apps/general-settings/context/useStateContext.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _settings_context__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./settings-context */ "./apps/general-settings/context/settings-context.jsx");


const useStateContext = () => {
  const context = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_settings_context__WEBPACK_IMPORTED_MODULE_1__.SettingsContext);
  if (context === undefined) {
    throw new Error('useStateContext must be used within a SettingsProvider');
  }
  return context;
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (useStateContext);

/***/ }),

/***/ "./apps/general-settings/fields/ButtonField.jsx":
/*!******************************************************!*\
  !*** ./apps/general-settings/fields/ButtonField.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ButtonField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _query_useApiCall__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../query/useApiCall */ "./apps/general-settings/query/useApiCall.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);




function ButtonField({
  field,
  className,
  variant = 'primary'
}) {
  const [loading, setLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.useState)(false);
  const doApiCall = (0,_query_useApiCall__WEBPACK_IMPORTED_MODULE_2__.useApiCall)();
  const handleClick = async () => {
    setLoading(true);
    if (field.api && field.api?.path) {
      await doApiCall(field.api.path, field.api.method || 'POST', field.api.data || {});
    }
    setLoading(false);
  };
  return /*#__PURE__*/React.createElement("div", {
    className: `modula_field_wrapp ${className || ''}`
  }, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label"
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
    id: field.id || '',
    href: field.href,
    variant: variant,
    className: `modula_field_button ${className || ''}`,
    onClick: handleClick,
    disabled: loading
  }, field.text), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/ComboField.jsx":
/*!*****************************************************!*\
  !*** ./apps/general-settings/fields/ComboField.jsx ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ComboField: () => (/* binding */ ComboField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _FieldRenderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../FieldRenderer */ "./apps/general-settings/FieldRenderer.jsx");
/* harmony import */ var _ButtonField__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ButtonField */ "./apps/general-settings/fields/ButtonField.jsx");



function ComboField({
  option,
  field,
  form,
  handleChange,
  className,
  evaluateConditions
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.fields.map((item, index) => {
    const isVisible = evaluateConditions(item.conditions);
    if (item.type === 'button') {
      return /*#__PURE__*/React.createElement(_ButtonField__WEBPACK_IMPORTED_MODULE_2__["default"], {
        key: index,
        field: item,
        disabled: !isVisible
      });
    }
    return /*#__PURE__*/React.createElement("div", {
      key: `${item.name}-wrapper`,
      className: `modula_field_wrapp ${className || ''} ${!isVisible ? 'modula-disabled' : ''}`
    }, /*#__PURE__*/React.createElement(form.Field, {
      name: option ? `${option}.${item.name}` : item.name
    }, fieldState => /*#__PURE__*/React.createElement(_FieldRenderer__WEBPACK_IMPORTED_MODULE_1__["default"], {
      field: item,
      fieldState: fieldState,
      handleChange: handleChange,
      disabled: !isVisible
    })));
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/ImageSelectField.jsx":
/*!***********************************************************!*\
  !*** ./apps/general-settings/fields/ImageSelectField.jsx ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ImageSelector)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);



function ImageSelector({
  fieldState,
  field,
  handleChange
}) {
  const [imageSrc, setImageSrc] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(field.src || null);
  const openMediaLibrary = () => {
    const mediaFrame = wp.media({
      title: 'Select an image pentru fundal',
      button: {
        text: 'Folosește această imagine'
      },
      multiple: false
    });
    mediaFrame.on('select', () => {
      const selection = mediaFrame.state().get('selection').first().toJSON();
      const attachmentId = selection.id;
      const attachmentSrc = selection.url;
      handleChange(attachmentId);
      setImageSrc(attachmentSrc);
    });
    mediaFrame.open();
  };
  const removeImage = () => {
    handleChange(null);
    setImageSrc(null);
  };
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement("div", {
    className: "modula_image_holder"
  }, /*#__PURE__*/React.createElement("div", {
    className: "modula_image"
  }, imageSrc && /*#__PURE__*/React.createElement("img", {
    src: imageSrc,
    alt: "Selected",
    width: 200
  }), !imageSrc && /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    isPrimary: true,
    onClick: openMediaLibrary
  }, "Set watermark image"), imageSrc && /*#__PURE__*/React.createElement("div", {
    className: "modula_image_buttons"
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    isSecondary: true,
    onClick: openMediaLibrary
  }, "Replace"), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    isDestructive: true,
    onClick: removeImage
  }, "Remove")))), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/ImportCheckboxGroupField.jsx":
/*!*******************************************************************!*\
  !*** ./apps/general-settings/fields/ImportCheckboxGroupField.jsx ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ImportCheckboxGroupField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ImportCheckboxGroupField.module.scss */ "./apps/general-settings/fields/ImportCheckboxGroupField.module.scss");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _query_useAjaxCall__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../query/useAjaxCall */ "./apps/general-settings/query/useAjaxCall.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _context_useStateContext__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../context/useStateContext */ "./apps/general-settings/context/useStateContext.js");







function ImportCheckboxGroupField({
  fieldState,
  field,
  handleChange,
  className
}) {
  const {
    options,
    name
  } = field;
  const selectedValues = fieldState.state.value || [];
  const [loading, setLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false);
  const [importResults, setImportResults] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)({});
  const {
    state
  } = (0,_context_useStateContext__WEBPACK_IMPORTED_MODULE_6__["default"])();
  const doAjaxCall = (0,_query_useAjaxCall__WEBPACK_IMPORTED_MODULE_4__.useAjaxCall)();
  const source = state.options?.gallery_source || 'core';
  const deleteSource = state.options?.gallery_delete_source || 'keep';
  const isSelected = value => selectedValues.includes(value);
  const toggleCheckbox = value => {
    if (isSelected(value)) {
      handleChange(selectedValues.filter(v => v !== value));
    } else {
      handleChange([...selectedValues, value]);
    }
  };
  const handleClick = async () => {
    setLoading(true);
    const importedGalleries = [];
    for (const id of selectedValues) {
      const data = {
        action: 'modula_ajax_import_images',
        id,
        nonce: field.nonce || false,
        chunk: 0,
        source
      };
      const response = await doAjaxCall(data);
      const importData = {
        action: 'modula_importer_' + source + '_gallery_import',
        id,
        nonce: field.nonce,
        clean: deleteSource,
        gallery_title: id,
        attachments: response.attachments,
        source
      };
      const importedGallery = await doAjaxCall(importData, true);
      setImportResults(prev => ({
        ...prev,
        [id]: {
          success: importedGallery.success,
          message: importedGallery.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Unknown response', 'modula-best-grid-gallery')
        }
      }));
      if (importedGallery.success) {
        importedGalleries[id] = importedGallery.modula_gallery_id;
      }
    }
    if (importedGalleries.length > 0) {
      const updateData = {
        action: 'modula_importer_' + source + '_gallery_imported_update',
        nonce: field.nonce,
        clean: deleteSource,
        galleries: importedGalleries,
        source
      };
      doAjaxCall(updateData);
    }
    setLoading(false);
  };
  const selectAll = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useCallback)(() => {
    const allValues = options.map(opt => opt.value);
    handleChange(allValues);
  }, [options, handleChange]);
  const deselectAll = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useCallback)(() => {
    handleChange([]);
  }, [handleChange]);
  return /*#__PURE__*/React.createElement("div", {
    className: `${_ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].modulaCheckboxGroupWrap} ${className || ''}`
  }, /*#__PURE__*/React.createElement("div", {
    className: _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].modulaCheckboxGroup
  }, /*#__PURE__*/React.createElement("div", {
    className: _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].modulaCheckboxGroupControls
  }, /*#__PURE__*/React.createElement("button", {
    type: "button",
    onClick: selectAll,
    className: _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].controlButton
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Select All', 'modula-best-grid-gallery')), /*#__PURE__*/React.createElement("button", {
    type: "button",
    onClick: deselectAll,
    className: _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].controlButton
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Deselect All', 'modula-best-grid-gallery'))), /*#__PURE__*/React.createElement("div", {
    className: _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].modulaCheckboxGroupOptions
  }, options.map(option =>
  /*#__PURE__*/
  /* eslint-disable jsx-a11y/label-has-associated-control */
  React.createElement("label", {
    key: option.value,
    className: _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].checkboxOption
  }, /*#__PURE__*/React.createElement("input", {
    type: "checkbox",
    name: `${name}[]`,
    value: option.value,
    checked: isSelected(option.value),
    onChange: () => toggleCheckbox(option.value)
  }), /*#__PURE__*/React.createElement("span", {
    dangerouslySetInnerHTML: {
      __html: option.label
    }
  }), importResults[option.value] && /*#__PURE__*/React.createElement("span", {
    className: importResults[option.value].success ? _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].modulaCheckboxGroupSuccess : _ImportCheckboxGroupField_module_scss__WEBPACK_IMPORTED_MODULE_2__["default"].modulaCheckboxGroupFail,
    dangerouslySetInnerHTML: {
      __html: importResults[option.value].message
    }
  }))))), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Button, {
    variant: "primary",
    className: `modula_field_button ${className || ''}`,
    onClick: handleClick,
    disabled: loading
  }, loading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Migrating…', 'modula-best-grid-gallery') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Migrate', 'modula-best-grid-gallery')));
}

/***/ }),

/***/ "./apps/general-settings/fields/NumberField.jsx":
/*!******************************************************!*\
  !*** ./apps/general-settings/fields/NumberField.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ NumberField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function NumberField({
  fieldState,
  field,
  handleChange,
  className
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextControl, {
    type: "number",
    className: `modula_input_text ${className || ''}`,
    min: field.min,
    max: field.max,
    value: fieldState.state.value,
    onChange: val => handleChange(val)
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/Paragraph.jsx":
/*!****************************************************!*\
  !*** ./apps/general-settings/fields/Paragraph.jsx ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Paragraph)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

function Paragraph({
  field,
  className
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: `modula_field_wrapp ${className || ''}`
  }, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label"
  }, field.label), field.value && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.value
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/RadioField.jsx":
/*!*****************************************************!*\
  !*** ./apps/general-settings/fields/RadioField.jsx ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ RadioField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function RadioField({
  fieldState,
  field,
  handleChange,
  className
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.RadioControl, {
    className: `modula_input_radio ${className || ''}`,
    selected: fieldState.state.value,
    options: field.options.map(option => ({
      label: option,
      value: option
    })),
    onChange: val => handleChange(val)
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/RadioGroupField.jsx":
/*!**********************************************************!*\
  !*** ./apps/general-settings/fields/RadioGroupField.jsx ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ RadioGroupField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./radioGroupField.module.scss */ "./apps/general-settings/fields/radioGroupField.module.scss");


function RadioGroupField({
  fieldState,
  field,
  handleChange,
  className
}) {
  const {
    options,
    name
  } = field;
  return /*#__PURE__*/React.createElement("div", {
    className: `${_radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroup} ${className || ''}`
  }, options.map(option => /*#__PURE__*/React.createElement("div", {
    key: `${option.value}-${option.label}`,
    className: _radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroupOption
  }, /*#__PURE__*/React.createElement("input", {
    type: "radio",
    id: option.value,
    name: name,
    value: option.value,
    checked: fieldState.state.value === option.value,
    onChange: e => handleChange(e.target.value),
    className: _radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroupInput
  }), /*#__PURE__*/React.createElement("label", {
    className: `${_radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroupLabel} ${fieldState.state.value === option.value ? _radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroupLabelChecked : ''}`,
    htmlFor: option.value
  }, option.image && '' !== option.image && /*#__PURE__*/React.createElement("img", {
    className: _radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroupImage,
    src: option.image,
    alt: option.name
  }), /*#__PURE__*/React.createElement("p", {
    className: _radioGroupField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaImageRadioGroupText
  }, option.name)))));
}

/***/ }),

/***/ "./apps/general-settings/fields/RangeSelect.jsx":
/*!******************************************************!*\
  !*** ./apps/general-settings/fields/RangeSelect.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ TextField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function TextField({
  fieldState,
  field,
  handleChange,
  className
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.RangeControl, {
    className: `modula_input_range ${className || ''}`,
    initialPosition: fieldState.state.value,
    value: fieldState.state.value,
    onChange: val => handleChange(val),
    max: field?.max || 100,
    min: field?.min || 0
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/RoleField.jsx":
/*!****************************************************!*\
  !*** ./apps/general-settings/fields/RoleField.jsx ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   RoleField: () => (/* binding */ RoleField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _ToggleField__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ToggleField */ "./apps/general-settings/fields/ToggleField.jsx");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _RoleField_module_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./RoleField.module.scss */ "./apps/general-settings/fields/RoleField.module.scss");





function RoleField({
  option,
  mainField,
  form,
  handleChange
}) {
  const [enabled, setEnabled] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(mainField.default);
  const activeToggle = form.store.state.values?.activeToggle || 'gallery';
  const onMainToggleChange = (fieldState, fieldName, val) => {
    setEnabled(val);

    // set each child-field value based on parent.
    mainField.fields.forEach(field => {
      const fullFieldName = option ? `${option}.${field.name}` : field.name;
      form.setFieldValue(fullFieldName, val);
    });
    handleChange(fieldState, fieldName, val);
  };
  if (mainField.group && mainField.group !== activeToggle) {
    return null;
  }
  return /*#__PURE__*/React.createElement("div", {
    className: "modula_roles_field_wrapper"
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Card, {
    className: `static-class ${_RoleField_module_scss__WEBPACK_IMPORTED_MODULE_4__["default"].modulaRoleFieldCard}`
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CardHeader, {
    className: `static-class-head ${_RoleField_module_scss__WEBPACK_IMPORTED_MODULE_4__["default"].modulaRoleFieldCardHead}`
  }, /*#__PURE__*/React.createElement(form.Field, {
    key: `${mainField.name}-field`,
    name: option ? `${option}.${mainField.name}` : mainField.name
  }, fieldState => /*#__PURE__*/React.createElement(_ToggleField__WEBPACK_IMPORTED_MODULE_2__["default"], {
    fieldState: fieldState,
    field: mainField,
    className: _RoleField_module_scss__WEBPACK_IMPORTED_MODULE_4__["default"].modulaRoleHeadToggle,
    handleChange: val => onMainToggleChange(fieldState, mainField.name, val)
  }))), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CardBody, {
    className: `static-class-body ${_RoleField_module_scss__WEBPACK_IMPORTED_MODULE_4__["default"].modulaRoleFieldCardBody}`
  }, mainField.fields.map(field => {
    return /*#__PURE__*/React.createElement("div", {
      key: `${field.name}-wrapper`,
      className: "modula_role_field_wrapp"
    }, /*#__PURE__*/React.createElement(form.Field, {
      key: `${field.name}-field`,
      name: option ? `${option}.${field.name}` : field.name
    }, fieldState => /*#__PURE__*/React.createElement(_ToggleField__WEBPACK_IMPORTED_MODULE_2__["default"], {
      fieldState: fieldState,
      field: field,
      className: _RoleField_module_scss__WEBPACK_IMPORTED_MODULE_4__["default"].modulaRoleBodyToggle,
      handleChange: val => handleChange(fieldState, field.name, val),
      disabled: !enabled
    })));
  }))));
}

/***/ }),

/***/ "./apps/general-settings/fields/SelectField.jsx":
/*!******************************************************!*\
  !*** ./apps/general-settings/fields/SelectField.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SelectField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function SelectField({
  fieldState,
  field,
  handleChange,
  className,
  disabled
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SelectControl, {
    className: `modula_input_select ${className || ''}`,
    value: fieldState.state.value,
    options: field.options.map(option => ({
      label: option.label,
      value: option.value
    })),
    onChange: val => handleChange(val),
    disabled: disabled
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/TextField.jsx":
/*!****************************************************!*\
  !*** ./apps/general-settings/fields/TextField.jsx ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ TextField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function TextField({
  fieldState,
  field,
  handleChange,
  className,
  disabled = false
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextControl, {
    type: field.inputType || 'text',
    className: `modula_input_text ${className || ''}`,
    value: fieldState.state.value || '',
    placeholder: field.placeholder,
    onChange: val => handleChange(val),
    disabled: disabled
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/TextareaField.jsx":
/*!********************************************************!*\
  !*** ./apps/general-settings/fields/TextareaField.jsx ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ TextareaField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


function TextareaField({
  fieldState,
  field,
  handleChange,
  className
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, field.label && field.label.trim() !== '' && /*#__PURE__*/React.createElement("span", {
    className: "modula_input_label",
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextareaControl, {
    className: `modula_input_text ${className || ''}`,
    value: fieldState.state.value,
    onChange: val => handleChange(val)
  }), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/ToggleField.jsx":
/*!******************************************************!*\
  !*** ./apps/general-settings/fields/ToggleField.jsx ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ToggleField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./toggleField.module.scss */ "./apps/general-settings/fields/toggleField.module.scss");


function ToggleField({
  fieldState,
  field,
  handleChange,
  className,
  disabled
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: `${_toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggle} ${className || ''} ${disabled ? _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleDisabled : ''}`
  }, /*#__PURE__*/React.createElement("label", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleLabel,
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement("input", {
    id: field.name,
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleInput,
    type: "checkbox",
    name: `modula-settings[${field.name}]`,
    value: "1",
    checked: fieldState.state.value,
    onChange: e => handleChange(e.target.checked),
    disabled: disabled ? 'disabled' : ''
  }), /*#__PURE__*/React.createElement("div", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleItems
  }, /*#__PURE__*/React.createElement("span", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleTrack
  }), /*#__PURE__*/React.createElement("span", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleThumb
  }), /*#__PURE__*/React.createElement("svg", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleOff,
    width: "6",
    height: "6",
    "aria-hidden": "true",
    role: "img",
    focusable: "false",
    viewBox: "0 0 6 6"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"
  })), /*#__PURE__*/React.createElement("svg", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleOn,
    width: "2",
    height: "6",
    "aria-hidden": "true",
    role: "img",
    focusable: "false",
    viewBox: "0 0 2 6"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M0 0h2v6H0z"
  })))), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/fields/ToggleOptionsField.jsx":
/*!*************************************************************!*\
  !*** ./apps/general-settings/fields/ToggleOptionsField.jsx ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ToggleOptionsField)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./toggleField.module.scss */ "./apps/general-settings/fields/toggleField.module.scss");


function ToggleOptionsField({
  fieldState,
  field,
  handleChange,
  trueValue = 'enabled',
  falseValue = 'disabled',
  className,
  disabled = false
}) {
  const isChecked = fieldState.state.value === trueValue;
  const handleToggle = checked => {
    handleChange(checked ? trueValue : falseValue);
  };
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: `${_toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggle} ${className || ''}`
  }, /*#__PURE__*/React.createElement("label", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleLabel,
    htmlFor: field.name
  }, field.label), /*#__PURE__*/React.createElement("input", {
    id: field.name,
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleInput,
    type: "checkbox",
    name: `modula-settings[${field.name}]`,
    value: trueValue,
    checked: isChecked,
    onChange: e => handleToggle(e.target.checked),
    disabled: disabled ? 'disabled' : ''
  }), /*#__PURE__*/React.createElement("div", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleItems
  }, /*#__PURE__*/React.createElement("span", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleTrack
  }), /*#__PURE__*/React.createElement("span", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleThumb
  }), /*#__PURE__*/React.createElement("svg", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleOff,
    width: "6",
    height: "6",
    "aria-hidden": "true",
    role: "img",
    focusable: "false",
    viewBox: "0 0 6 6"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"
  })), /*#__PURE__*/React.createElement("svg", {
    className: _toggleField_module_scss__WEBPACK_IMPORTED_MODULE_1__["default"].modulaToggleOn,
    width: "2",
    height: "6",
    "aria-hidden": "true",
    role: "img",
    focusable: "false",
    viewBox: "0 0 2 6"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M0 0h2v6H0z"
  })))), field.description && /*#__PURE__*/React.createElement("p", {
    className: "modula_input_description",
    dangerouslySetInnerHTML: {
      __html: field.description
    }
  }));
}

/***/ }),

/***/ "./apps/general-settings/query/client.js":
/*!***********************************************!*\
  !*** ./apps/general-settings/query/client.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   queryClient: () => (/* binding */ queryClient)
/* harmony export */ });
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/query-core/build/modern/queryClient.js");

const queryClient = new _tanstack_react_query__WEBPACK_IMPORTED_MODULE_0__.QueryClient();

/***/ }),

/***/ "./apps/general-settings/query/useAjaxCall.js":
/*!****************************************************!*\
  !*** ./apps/general-settings/query/useAjaxCall.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useAjaxCall: () => (/* binding */ useAjaxCall)
/* harmony export */ });
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js");

const useAjaxCall = () => {
  const queryClient = (0,_tanstack_react_query__WEBPACK_IMPORTED_MODULE_0__.useQueryClient)();
  const appendFormData = (formData, key, value) => {
    if (Array.isArray(value)) {
      if (typeof value[0] === 'object') {
        value.forEach((obj, index) => {
          Object.entries(obj).forEach(([propKey, propValue]) => {
            formData.append(`${key}[${index}][${propKey}]`, propValue);
          });
        });
      } else {
        value.forEach((item, index) => {
          formData.append(`${key}[${index}]`, item);
        });
      }
    } else {
      formData.append(key, value);
    }
  };
  const doAjaxCall = async (data = {}, invalidate = false) => {
    const formData = new FormData();
    Object.entries(data).forEach(([key, value]) => {
      appendFormData(formData, key, value);
    });
    try {
      const response = await fetch(window.ajaxurl, {
        method: 'POST',
        credentials: 'same-origin',
        body: formData
      });
      const result = await response.json();
      if (invalidate) {
        await queryClient.invalidateQueries({
          queryKey: ['settings-tabs-query']
        });
      }
      return result;
    } catch (error) {
      console.error('AJAX call failed:', error);
      throw error;
    }
  };
  return doAjaxCall;
};

/***/ }),

/***/ "./apps/general-settings/query/useApiCall.js":
/*!***************************************************!*\
  !*** ./apps/general-settings/query/useApiCall.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useApiCall: () => (/* binding */ useApiCall)
/* harmony export */ });
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js");


const useApiCall = () => {
  const queryClient = (0,_tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__.useQueryClient)();
  const doApiCall = async (path, method, data = false) => {
    try {
      const response = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
        path,
        method,
        data: {
          ...data
        }
      });
      await queryClient.invalidateQueries({
        queryKey: ['settings-tabs-query']
      });
      return response;
    } catch (error) {
      console.error('Error on api call:', error);
      throw error;
    }
  };
  return doApiCall;
};

/***/ }),

/***/ "./apps/general-settings/query/useSettingsMutation.js":
/*!************************************************************!*\
  !*** ./apps/general-settings/query/useSettingsMutation.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useSettingsMutation: () => (/* binding */ useSettingsMutation)
/* harmony export */ });
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js");
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/useMutation.js");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);


const useSettingsMutation = () => {
  const queryClient = (0,_tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__.useQueryClient)();
  const saveSettings = async vars => {
    return await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
      path: `/modula-best-grid-gallery/v1/general-settings`,
      method: 'POST',
      data: vars
    });
  };
  const settingsMutation = (0,_tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__.useMutation)({
    mutationFn: async data => {
      const result = await saveSettings(data);
      return result;
    },
    onSuccess: async () => {
      await Promise.all([queryClient.invalidateQueries({
        queryKey: ['settings-tabs-query']
      }), queryClient.invalidateQueries({
        queryKey: ['ai-settings-query']
      })]);
    }
  });
  return settingsMutation;
};

/***/ }),

/***/ "./apps/general-settings/query/useSettingsQuery.js":
/*!*********************************************************!*\
  !*** ./apps/general-settings/query/useSettingsQuery.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useSettingsQuery: () => (/* binding */ useSettingsQuery)
/* harmony export */ });
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/useQuery.js");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);


const useSettingsQuery = () => {
  const settings = (0,_tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__.useQuery)({
    queryKey: ['ai-settings-query'],
    retry: 1,
    queryFn: async () => {
      const data = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
        path: `/modula-ai-image-descriptor/v1/ai-settings`,
        method: 'GET'
      });
      return data;
    }
  });
  return settings;
};

/***/ }),

/***/ "./apps/general-settings/query/useTabsQuery.js":
/*!*****************************************************!*\
  !*** ./apps/general-settings/query/useTabsQuery.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useTabsQuery: () => (/* binding */ useTabsQuery)
/* harmony export */ });
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/useQuery.js");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);


const useTabsQuery = () => {
  const settings = (0,_tanstack_react_query__WEBPACK_IMPORTED_MODULE_1__.useQuery)({
    queryKey: ['settings-tabs-query'],
    retry: 1,
    queryFn: async () => {
      const data = await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
        path: `/modula-best-grid-gallery/v1/general-settings-tabs`,
        method: 'GET'
      });
      return data;
    }
  });
  return settings;
};

/***/ }),

/***/ "./apps/general-settings/ai-settings/settings-form/claim-credits.module.css":
/*!**********************************************************************************!*\
  !*** ./apps/general-settings/ai-settings/settings-form/claim-credits.module.css ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// extracted by mini-css-extract-plugin
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({"modula-best-grid-gallery":"eUb5ii7N7uoX5Zaegq13","container":"oCQCrDElmdDm07U8O0g_","description":"sAqm0q094Cmj3Fff3kKY","buttonContainer":"Ebw3DweCDnwFHPwEje3i"});

/***/ }),

/***/ "./apps/general-settings/fields/ImportCheckboxGroupField.module.scss":
/*!***************************************************************************!*\
  !*** ./apps/general-settings/fields/ImportCheckboxGroupField.module.scss ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// extracted by mini-css-extract-plugin
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({"modulaCheckboxGroupWrap":"G26WUtzESwRrAfjEdxrw","modulaCheckboxGroup":"Vh7dzBQ1lP8kfFpbtTFA","modulaCheckboxGroupControls":"SSQybBDIV8OAYj8bMjq7","controlButton":"x7O4CFe0bXBoA7IOHFIA","modulaCheckboxGroupOptions":"X9neYpywiG08remH3GVO","checkboxOption":"PURtjyCwA86PlrCJ8i45","modulaCheckboxGroupFail":"G5RwVxLhuOlxNHIqolLA"});

/***/ }),

/***/ "./apps/general-settings/fields/RoleField.module.scss":
/*!************************************************************!*\
  !*** ./apps/general-settings/fields/RoleField.module.scss ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// extracted by mini-css-extract-plugin
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({"modulaRoleFieldCard":"Lm1A08wPHM8GclLe7ph0","modulaRoleFieldCardHead":"Gw7t03RR8QEoNJUYqT6N","modulaRoleHeadToggle":"W7HbF5OVv_JVIMby349Q","modulaRoleFieldCardBody":"T7OEHZLL87xK0wy3BWIx","modulaRoleBodyToggle":"SBWqcPmdFFcRVweI3OSD"});

/***/ }),

/***/ "./apps/general-settings/fields/radioGroupField.module.scss":
/*!******************************************************************!*\
  !*** ./apps/general-settings/fields/radioGroupField.module.scss ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// extracted by mini-css-extract-plugin
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({"modulaImageRadioGroup":"qHFQ_sMuRCESwqNiQ3H4","modulaImageRadioGroupOption":"BldaZoqoOO8Ltl6oiD7a","modulaImageRadioGroupInput":"FR6T4lX8aHa3wJv74boX","modulaImageRadioGroupLabel":"WecsCrgF1I2MiXOSQ8tg","modulaImageRadioGroupLabelChecked":"sncYWGhQxuTrdFEDBJQv"});

/***/ }),

/***/ "./apps/general-settings/fields/toggleField.module.scss":
/*!**************************************************************!*\
  !*** ./apps/general-settings/fields/toggleField.module.scss ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// extracted by mini-css-extract-plugin
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({"modulaToggle":"ayHyBmgI1XDhnl1heGk8","modulaToggleItems":"jwF1q6xwR3gX7xymuDjs","modulaToggleLabel":"JzFje6adbcI1Uf6oZNtX","modulaToggleInput":"Ju3CWaetLeVOIM4vnCez","modulaToggleTrack":"ymwGun3xUsypmF3_dP8W","modulaToggleThumb":"K99mNKZv0YyHfD1xnZVR","modulaToggleOff":"wKYFix8m95ObH9dRYsi8","modulaToggleOn":"Nisw6vcFV43jSBVD42eB"});

/***/ }),

/***/ "./apps/general-settings/index.scss":
/*!******************************************!*\
  !*** ./apps/general-settings/index.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/react/cjs/react-jsx-runtime.development.js":
/*!*****************************************************************!*\
  !*** ./node_modules/react/cjs/react-jsx-runtime.development.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

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

var didWarnAboutKeySpread = {};
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

    {
      if (hasOwnProperty.call(props, 'key')) {
        var componentName = getComponentNameFromType(type);
        var keys = Object.keys(props).filter(function (k) {
          return k !== 'key';
        });
        var beforeExample = keys.length > 0 ? '{key: someKey, ' + keys.join(': ..., ') + ': ...}' : '{key: someKey}';

        if (!didWarnAboutKeySpread[componentName + beforeExample]) {
          var afterExample = keys.length > 0 ? '{' + keys.join(': ..., ') + ': ...}' : '{}';

          error('A props object containing a "key" prop is being spread into JSX:\n' + '  let props = %s;\n' + '  <%s {...props} />\n' + 'React keys must be passed directly to JSX without using spread:\n' + '  let props = %s;\n' + '  <%s key={someKey} {...props} />', beforeExample, componentName, afterExample, componentName);

          didWarnAboutKeySpread[componentName + beforeExample] = true;
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
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



if (false) {} else {
  module.exports = __webpack_require__(/*! ./cjs/react-jsx-runtime.development.js */ "./node_modules/react/cjs/react-jsx-runtime.development.js");
}


/***/ }),

/***/ "./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim.development.js":
/*!**********************************************************************************************!*\
  !*** ./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim.development.js ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

/**
 * @license React
 * use-sync-external-store-shim.development.js
 *
 * Copyright (c) Meta Platforms, Inc. and affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */


 true &&
  (function () {
    function is(x, y) {
      return (x === y && (0 !== x || 1 / x === 1 / y)) || (x !== x && y !== y);
    }
    function useSyncExternalStore$2(subscribe, getSnapshot) {
      didWarnOld18Alpha ||
        void 0 === React.startTransition ||
        ((didWarnOld18Alpha = !0),
        console.error(
          "You are using an outdated, pre-release alpha of React 18 that does not support useSyncExternalStore. The use-sync-external-store shim will not work correctly. Upgrade to a newer pre-release."
        ));
      var value = getSnapshot();
      if (!didWarnUncachedGetSnapshot) {
        var cachedValue = getSnapshot();
        objectIs(value, cachedValue) ||
          (console.error(
            "The result of getSnapshot should be cached to avoid an infinite loop"
          ),
          (didWarnUncachedGetSnapshot = !0));
      }
      cachedValue = useState({
        inst: { value: value, getSnapshot: getSnapshot }
      });
      var inst = cachedValue[0].inst,
        forceUpdate = cachedValue[1];
      useLayoutEffect(
        function () {
          inst.value = value;
          inst.getSnapshot = getSnapshot;
          checkIfSnapshotChanged(inst) && forceUpdate({ inst: inst });
        },
        [subscribe, value, getSnapshot]
      );
      useEffect(
        function () {
          checkIfSnapshotChanged(inst) && forceUpdate({ inst: inst });
          return subscribe(function () {
            checkIfSnapshotChanged(inst) && forceUpdate({ inst: inst });
          });
        },
        [subscribe]
      );
      useDebugValue(value);
      return value;
    }
    function checkIfSnapshotChanged(inst) {
      var latestGetSnapshot = inst.getSnapshot;
      inst = inst.value;
      try {
        var nextValue = latestGetSnapshot();
        return !objectIs(inst, nextValue);
      } catch (error) {
        return !0;
      }
    }
    function useSyncExternalStore$1(subscribe, getSnapshot) {
      return getSnapshot();
    }
    "undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ &&
      "function" ===
        typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart &&
      __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart(Error());
    var React = __webpack_require__(/*! react */ "react"),
      objectIs = "function" === typeof Object.is ? Object.is : is,
      useState = React.useState,
      useEffect = React.useEffect,
      useLayoutEffect = React.useLayoutEffect,
      useDebugValue = React.useDebugValue,
      didWarnOld18Alpha = !1,
      didWarnUncachedGetSnapshot = !1,
      shim =
        "undefined" === typeof window ||
        "undefined" === typeof window.document ||
        "undefined" === typeof window.document.createElement
          ? useSyncExternalStore$1
          : useSyncExternalStore$2;
    exports.useSyncExternalStore =
      void 0 !== React.useSyncExternalStore ? React.useSyncExternalStore : shim;
    "undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ &&
      "function" ===
        typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop &&
      __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop(Error());
  })();


/***/ }),

/***/ "./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim/with-selector.development.js":
/*!************************************************************************************************************!*\
  !*** ./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim/with-selector.development.js ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

/**
 * @license React
 * use-sync-external-store-shim/with-selector.development.js
 *
 * Copyright (c) Meta Platforms, Inc. and affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */


 true &&
  (function () {
    function is(x, y) {
      return (x === y && (0 !== x || 1 / x === 1 / y)) || (x !== x && y !== y);
    }
    "undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ &&
      "function" ===
        typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart &&
      __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart(Error());
    var React = __webpack_require__(/*! react */ "react"),
      shim = __webpack_require__(/*! use-sync-external-store/shim */ "./node_modules/use-sync-external-store/shim/index.js"),
      objectIs = "function" === typeof Object.is ? Object.is : is,
      useSyncExternalStore = shim.useSyncExternalStore,
      useRef = React.useRef,
      useEffect = React.useEffect,
      useMemo = React.useMemo,
      useDebugValue = React.useDebugValue;
    exports.useSyncExternalStoreWithSelector = function (
      subscribe,
      getSnapshot,
      getServerSnapshot,
      selector,
      isEqual
    ) {
      var instRef = useRef(null);
      if (null === instRef.current) {
        var inst = { hasValue: !1, value: null };
        instRef.current = inst;
      } else inst = instRef.current;
      instRef = useMemo(
        function () {
          function memoizedSelector(nextSnapshot) {
            if (!hasMemo) {
              hasMemo = !0;
              memoizedSnapshot = nextSnapshot;
              nextSnapshot = selector(nextSnapshot);
              if (void 0 !== isEqual && inst.hasValue) {
                var currentSelection = inst.value;
                if (isEqual(currentSelection, nextSnapshot))
                  return (memoizedSelection = currentSelection);
              }
              return (memoizedSelection = nextSnapshot);
            }
            currentSelection = memoizedSelection;
            if (objectIs(memoizedSnapshot, nextSnapshot))
              return currentSelection;
            var nextSelection = selector(nextSnapshot);
            if (void 0 !== isEqual && isEqual(currentSelection, nextSelection))
              return (memoizedSnapshot = nextSnapshot), currentSelection;
            memoizedSnapshot = nextSnapshot;
            return (memoizedSelection = nextSelection);
          }
          var hasMemo = !1,
            memoizedSnapshot,
            memoizedSelection,
            maybeGetServerSnapshot =
              void 0 === getServerSnapshot ? null : getServerSnapshot;
          return [
            function () {
              return memoizedSelector(getSnapshot());
            },
            null === maybeGetServerSnapshot
              ? void 0
              : function () {
                  return memoizedSelector(maybeGetServerSnapshot());
                }
          ];
        },
        [getSnapshot, getServerSnapshot, selector, isEqual]
      );
      var value = useSyncExternalStore(subscribe, instRef[0], instRef[1]);
      useEffect(
        function () {
          inst.hasValue = !0;
          inst.value = value;
        },
        [value]
      );
      useDebugValue(value);
      return value;
    };
    "undefined" !== typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ &&
      "function" ===
        typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop &&
      __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop(Error());
  })();


/***/ }),

/***/ "./node_modules/use-sync-external-store/shim/index.js":
/*!************************************************************!*\
  !*** ./node_modules/use-sync-external-store/shim/index.js ***!
  \************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



if (false) {} else {
  module.exports = __webpack_require__(/*! ../cjs/use-sync-external-store-shim.development.js */ "./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim.development.js");
}


/***/ }),

/***/ "./node_modules/use-sync-external-store/shim/with-selector.js":
/*!********************************************************************!*\
  !*** ./node_modules/use-sync-external-store/shim/with-selector.js ***!
  \********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



if (false) {} else {
  module.exports = __webpack_require__(/*! ../cjs/use-sync-external-store-shim/with-selector.development.js */ "./node_modules/use-sync-external-store/cjs/use-sync-external-store-shim/with-selector.development.js");
}


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

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

/***/ "@wordpress/primitives":
/*!************************************!*\
  !*** external ["wp","primitives"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["primitives"];

/***/ }),

/***/ "./node_modules/@tanstack/form-core/dist/esm/FieldApi.js":
/*!***************************************************************!*\
  !*** ./node_modules/@tanstack/form-core/dist/esm/FieldApi.js ***!
  \***************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   FieldApi: () => (/* binding */ FieldApi)
/* harmony export */ });
/* harmony import */ var _tanstack_store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/store */ "./node_modules/@tanstack/store/dist/esm/scheduler.js");
/* harmony import */ var _tanstack_store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/store */ "./node_modules/@tanstack/store/dist/esm/derived.js");
/* harmony import */ var _standardSchemaValidator_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./standardSchemaValidator.js */ "./node_modules/@tanstack/form-core/dist/esm/standardSchemaValidator.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/form-core/dist/esm/utils.js");



class FieldApi {
  /**
   * Initializes a new `FieldApi` instance.
   */
  constructor(opts) {
    this.options = {};
    this.mount = () => {
      var _a, _b;
      const cleanup = this.store.mount();
      const info = this.getInfo();
      info.instance = this;
      this.update(this.options);
      const { onMount } = this.options.validators || {};
      if (onMount) {
        const error = this.runValidator({
          validate: onMount,
          value: {
            value: this.state.value,
            fieldApi: this,
            validationSource: "field"
          },
          type: "validate"
        });
        if (error) {
          this.setMeta((prev) => ({
            ...prev,
            // eslint-disable-next-line @typescript-eslint/no-unnecessary-condition
            errorMap: { ...prev == null ? void 0 : prev.errorMap, onMount: error }
          }));
        }
      }
      (_b = (_a = this.options.listeners) == null ? void 0 : _a.onMount) == null ? void 0 : _b.call(_a, {
        value: this.state.value,
        fieldApi: this
      });
      return cleanup;
    };
    this.update = (opts2) => {
      if (this.state.value === void 0) {
        const formDefault = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getBy)(opts2.form.options.defaultValues, opts2.name);
        if (opts2.defaultValue !== void 0) {
          this.setValue(opts2.defaultValue, {
            dontUpdateMeta: true
          });
        } else if (formDefault !== void 0) {
          this.setValue(formDefault, {
            dontUpdateMeta: true
          });
        }
      }
      if (this.form.getFieldMeta(this.name) === void 0) {
        this.setMeta(this.state.meta);
      }
      this.options = opts2;
      this.name = opts2.name;
    };
    this.getValue = () => {
      return this.form.getFieldValue(this.name);
    };
    this.setValue = (updater, options) => {
      var _a, _b;
      this.form.setFieldValue(this.name, updater, options);
      (_b = (_a = this.options.listeners) == null ? void 0 : _a.onChange) == null ? void 0 : _b.call(_a, {
        value: this.state.value,
        fieldApi: this
      });
      this.validate("change");
    };
    this.getMeta = () => this.store.state.meta;
    this.setMeta = (updater) => this.form.setFieldMeta(this.name, updater);
    this.getInfo = () => this.form.getFieldInfo(this.name);
    this.pushValue = (value, opts2) => this.form.pushFieldValue(this.name, value, opts2);
    this.insertValue = (index, value, opts2) => this.form.insertFieldValue(this.name, index, value, opts2);
    this.replaceValue = (index, value, opts2) => this.form.replaceFieldValue(this.name, index, value, opts2);
    this.removeValue = (index, opts2) => this.form.removeFieldValue(this.name, index, opts2);
    this.swapValues = (aIndex, bIndex, opts2) => this.form.swapFieldValues(this.name, aIndex, bIndex, opts2);
    this.moveValue = (aIndex, bIndex, opts2) => this.form.moveFieldValues(this.name, aIndex, bIndex, opts2);
    this.getLinkedFields = (cause) => {
      const fields = Object.values(this.form.fieldInfo);
      const linkedFields = [];
      for (const field of fields) {
        if (!field.instance) continue;
        const { onChangeListenTo, onBlurListenTo } = field.instance.options.validators || {};
        if (cause === "change" && (onChangeListenTo == null ? void 0 : onChangeListenTo.includes(this.name))) {
          linkedFields.push(field.instance);
        }
        if (cause === "blur" && (onBlurListenTo == null ? void 0 : onBlurListenTo.includes(this.name))) {
          linkedFields.push(field.instance);
        }
      }
      return linkedFields;
    };
    this.validateSync = (cause, errorFromForm) => {
      const validates = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getSyncValidatorArray)(cause, this.options);
      const linkedFields = this.getLinkedFields(cause);
      const linkedFieldValidates = linkedFields.reduce(
        (acc, field) => {
          const fieldValidates = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getSyncValidatorArray)(cause, field.options);
          fieldValidates.forEach((validate) => {
            validate.field = field;
          });
          return acc.concat(fieldValidates);
        },
        []
      );
      let hasErrored = false;
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_1__.batch)(() => {
        const validateFieldFn = (field, validateObj) => {
          const errorMapKey = getErrorMapKey(validateObj.cause);
          const error = (
            /*
              If `validateObj.validate` is `undefined`, then the field doesn't have
              a validator for this event, but there still could be an error that
              needs to be cleaned up related to the current event left by the
              form's validator.
            */
            validateObj.validate ? normalizeError(
              field.runValidator({
                validate: validateObj.validate,
                value: {
                  value: field.store.state.value,
                  validationSource: "field",
                  fieldApi: field
                },
                type: "validate"
              })
            ) : errorFromForm[errorMapKey]
          );
          if (field.state.meta.errorMap[errorMapKey] !== error) {
            field.setMeta((prev) => ({
              ...prev,
              errorMap: {
                ...prev.errorMap,
                [getErrorMapKey(validateObj.cause)]: (
                  // Prefer the error message from the field validators if they exist
                  error ? error : errorFromForm[errorMapKey]
                )
              }
            }));
          }
          if (error || errorFromForm[errorMapKey]) {
            hasErrored = true;
          }
        };
        for (const validateObj of validates) {
          validateFieldFn(this, validateObj);
        }
        for (const fieldValitateObj of linkedFieldValidates) {
          if (!fieldValitateObj.validate) continue;
          validateFieldFn(fieldValitateObj.field, fieldValitateObj);
        }
      });
      const submitErrKey = getErrorMapKey("submit");
      if (this.state.meta.errorMap[submitErrKey] && cause !== "submit" && !hasErrored) {
        this.setMeta((prev) => ({
          ...prev,
          errorMap: {
            ...prev.errorMap,
            [submitErrKey]: void 0
          }
        }));
      }
      return { hasErrored };
    };
    this.validateAsync = async (cause, formValidationResultPromise) => {
      const validates = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getAsyncValidatorArray)(cause, this.options);
      const asyncFormValidationResults = await formValidationResultPromise;
      const linkedFields = this.getLinkedFields(cause);
      const linkedFieldValidates = linkedFields.reduce(
        (acc, field) => {
          const fieldValidates = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getAsyncValidatorArray)(cause, field.options);
          fieldValidates.forEach((validate) => {
            validate.field = field;
          });
          return acc.concat(fieldValidates);
        },
        []
      );
      if (!this.state.meta.isValidating) {
        this.setMeta((prev) => ({ ...prev, isValidating: true }));
      }
      for (const linkedField of linkedFields) {
        linkedField.setMeta((prev) => ({ ...prev, isValidating: true }));
      }
      const validatesPromises = [];
      const linkedPromises = [];
      const validateFieldAsyncFn = (field, validateObj, promises) => {
        const errorMapKey = getErrorMapKey(validateObj.cause);
        const fieldValidatorMeta = field.getInfo().validationMetaMap[errorMapKey];
        fieldValidatorMeta == null ? void 0 : fieldValidatorMeta.lastAbortController.abort();
        const controller = new AbortController();
        this.getInfo().validationMetaMap[errorMapKey] = {
          lastAbortController: controller
        };
        promises.push(
          new Promise(async (resolve) => {
            var _a;
            let rawError;
            try {
              rawError = await new Promise((rawResolve, rawReject) => {
                if (this.timeoutIds[validateObj.cause]) {
                  clearTimeout(this.timeoutIds[validateObj.cause]);
                }
                this.timeoutIds[validateObj.cause] = setTimeout(async () => {
                  if (controller.signal.aborted) return rawResolve(void 0);
                  try {
                    rawResolve(
                      await this.runValidator({
                        validate: validateObj.validate,
                        value: {
                          value: field.store.state.value,
                          fieldApi: field,
                          signal: controller.signal,
                          validationSource: "field"
                        },
                        type: "validateAsync"
                      })
                    );
                  } catch (e) {
                    rawReject(e);
                  }
                }, validateObj.debounceMs);
              });
            } catch (e) {
              rawError = e;
            }
            if (controller.signal.aborted) return resolve(void 0);
            const error = normalizeError(rawError);
            const fieldErrorFromForm = (_a = asyncFormValidationResults[this.name]) == null ? void 0 : _a[errorMapKey];
            const fieldError = error || fieldErrorFromForm;
            field.setMeta((prev) => {
              return {
                ...prev,
                errorMap: {
                  // eslint-disable-next-line @typescript-eslint/no-unnecessary-condition
                  ...prev == null ? void 0 : prev.errorMap,
                  [errorMapKey]: fieldError
                }
              };
            });
            resolve(fieldError);
          })
        );
      };
      for (const validateObj of validates) {
        if (!validateObj.validate) continue;
        validateFieldAsyncFn(this, validateObj, validatesPromises);
      }
      for (const fieldValitateObj of linkedFieldValidates) {
        if (!fieldValitateObj.validate) continue;
        validateFieldAsyncFn(
          fieldValitateObj.field,
          fieldValitateObj,
          linkedPromises
        );
      }
      let results = [];
      if (validatesPromises.length || linkedPromises.length) {
        results = await Promise.all(validatesPromises);
        await Promise.all(linkedPromises);
      }
      this.setMeta((prev) => ({ ...prev, isValidating: false }));
      for (const linkedField of linkedFields) {
        linkedField.setMeta((prev) => ({ ...prev, isValidating: false }));
      }
      return results.filter(Boolean);
    };
    this.validate = (cause) => {
      var _a;
      if (!this.state.meta.isTouched) return [];
      const { fieldsErrorMap } = this.form.validateSync(cause);
      const { hasErrored } = this.validateSync(
        cause,
        fieldsErrorMap[this.name] ?? {}
      );
      if (hasErrored && !this.options.asyncAlways) {
        (_a = this.getInfo().validationMetaMap[getErrorMapKey(cause)]) == null ? void 0 : _a.lastAbortController.abort();
        return this.state.meta.errors;
      }
      const formValidationResultPromise = this.form.validateAsync(cause);
      return this.validateAsync(cause, formValidationResultPromise);
    };
    this.handleChange = (updater) => {
      this.setValue(updater);
    };
    this.handleBlur = () => {
      var _a, _b;
      const prevTouched = this.state.meta.isTouched;
      if (!prevTouched) {
        this.setMeta((prev) => ({ ...prev, isTouched: true }));
        this.validate("change");
      }
      if (!this.state.meta.isBlurred) {
        this.setMeta((prev) => ({ ...prev, isBlurred: true }));
      }
      this.validate("blur");
      (_b = (_a = this.options.listeners) == null ? void 0 : _a.onBlur) == null ? void 0 : _b.call(_a, {
        value: this.state.value,
        fieldApi: this
      });
    };
    this.form = opts.form;
    this.name = opts.name;
    this.timeoutIds = {};
    if (opts.defaultValue !== void 0) {
      this.form.setFieldValue(this.name, opts.defaultValue, {
        dontUpdateMeta: true
      });
    }
    this.store = new _tanstack_store__WEBPACK_IMPORTED_MODULE_2__.Derived({
      deps: [this.form.store],
      fn: () => {
        const value = this.form.getFieldValue(this.name);
        const meta = this.form.getFieldMeta(this.name) ?? {
          isValidating: false,
          isTouched: false,
          isBlurred: false,
          isDirty: false,
          isPristine: true,
          errors: [],
          errorMap: {},
          ...opts.defaultMeta
        };
        return {
          value,
          meta
        };
      }
    });
    this.options = opts;
  }
  /**
   * The current field state.
   */
  get state() {
    return this.store.state;
  }
  /**
   * @private
   */
  runValidator(props) {
    const adapters = [
      this.form.options.validatorAdapter,
      this.options.validatorAdapter
    ];
    for (const adapter of adapters) {
      if (adapter && (typeof props.validate !== "function" || "~standard" in props.validate)) {
        return adapter()[props.type](
          props.value,
          props.validate
        );
      }
    }
    if ((0,_standardSchemaValidator_js__WEBPACK_IMPORTED_MODULE_3__.isStandardSchemaValidator)(props.validate)) {
      return (0,_standardSchemaValidator_js__WEBPACK_IMPORTED_MODULE_3__.standardSchemaValidator)()()[props.type](
        props.value,
        props.validate
      );
    }
    return props.validate(props.value);
  }
  /**
   * Updates the field's errorMap
   */
  setErrorMap(errorMap) {
    this.setMeta((prev) => ({
      ...prev,
      errorMap: {
        ...prev.errorMap,
        ...errorMap
      }
    }));
  }
}
function normalizeError(rawError) {
  if (rawError) {
    if (typeof rawError !== "string") {
      return "Invalid Form Values";
    }
    return rawError;
  }
  return void 0;
}
function getErrorMapKey(cause) {
  switch (cause) {
    case "submit":
      return "onSubmit";
    case "blur":
      return "onBlur";
    case "mount":
      return "onMount";
    case "server":
      return "onServer";
    case "change":
    default:
      return "onChange";
  }
}

//# sourceMappingURL=FieldApi.js.map


/***/ }),

/***/ "./node_modules/@tanstack/form-core/dist/esm/FormApi.js":
/*!**************************************************************!*\
  !*** ./node_modules/@tanstack/form-core/dist/esm/FormApi.js ***!
  \**************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   FormApi: () => (/* binding */ FormApi)
/* harmony export */ });
/* harmony import */ var _tanstack_store__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @tanstack/store */ "./node_modules/@tanstack/store/dist/esm/scheduler.js");
/* harmony import */ var _tanstack_store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/store */ "./node_modules/@tanstack/store/dist/esm/store.js");
/* harmony import */ var _tanstack_store__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @tanstack/store */ "./node_modules/@tanstack/store/dist/esm/derived.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/form-core/dist/esm/utils.js");
/* harmony import */ var _standardSchemaValidator_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./standardSchemaValidator.js */ "./node_modules/@tanstack/form-core/dist/esm/standardSchemaValidator.js");



function getDefaultFormState(defaultState) {
  return {
    values: defaultState.values ?? {},
    errorMap: defaultState.errorMap ?? {},
    fieldMetaBase: defaultState.fieldMetaBase ?? {},
    isSubmitted: defaultState.isSubmitted ?? false,
    isSubmitting: defaultState.isSubmitting ?? false,
    isValidating: defaultState.isValidating ?? false,
    submissionAttempts: defaultState.submissionAttempts ?? 0,
    validationMetaMap: defaultState.validationMetaMap ?? {
      onChange: void 0,
      onBlur: void 0,
      onSubmit: void 0,
      onMount: void 0,
      onServer: void 0
    }
  };
}
const isFormValidationError = (error) => {
  return typeof error === "object";
};
class FormApi {
  /**
   * Constructs a new `FormApi` instance with the given form options.
   */
  constructor(opts) {
    var _a;
    this.options = {};
    this.fieldInfo = {};
    this.prevTransformArray = [];
    this.mount = () => {
      const cleanupFieldMetaDerived = this.fieldMetaDerived.mount();
      const cleanupStoreDerived = this.store.mount();
      const cleanup = () => {
        cleanupFieldMetaDerived();
        cleanupStoreDerived();
      };
      const { onMount } = this.options.validators || {};
      if (!onMount) return cleanup;
      this.validateSync("mount");
      return cleanup;
    };
    this.update = (options) => {
      if (!options) return;
      const oldOptions = this.options;
      this.options = options;
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
        const shouldUpdateValues = options.defaultValues && options.defaultValues !== oldOptions.defaultValues && !this.state.isTouched;
        const shouldUpdateState = options.defaultState !== oldOptions.defaultState && !this.state.isTouched;
        this.baseStore.setState(
          () => getDefaultFormState(
            Object.assign(
              {},
              this.state,
              shouldUpdateState ? options.defaultState : {},
              shouldUpdateValues ? {
                values: options.defaultValues
              } : {}
            )
          )
        );
      });
    };
    this.reset = (values, opts2) => {
      const { fieldMeta: currentFieldMeta } = this.state;
      const fieldMetaBase = this.resetFieldMeta(currentFieldMeta);
      if (values && !(opts2 == null ? void 0 : opts2.keepDefaultValues)) {
        this.options = {
          ...this.options,
          defaultValues: values
        };
      }
      this.baseStore.setState(
        () => {
          var _a2;
          return getDefaultFormState({
            ...this.options.defaultState,
            values: values ?? this.options.defaultValues ?? ((_a2 = this.options.defaultState) == null ? void 0 : _a2.values),
            fieldMetaBase
          });
        }
      );
    };
    this.validateAllFields = async (cause) => {
      const fieldValidationPromises = [];
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
        void Object.values(this.fieldInfo).forEach((field) => {
          if (!field.instance) return;
          const fieldInstance = field.instance;
          fieldValidationPromises.push(
            // Remember, `validate` is either a sync operation or a promise
            Promise.resolve().then(() => fieldInstance.validate(cause))
          );
          if (!field.instance.state.meta.isTouched) {
            field.instance.setMeta((prev) => ({ ...prev, isTouched: true }));
          }
        });
      });
      const fieldErrorMapMap = await Promise.all(fieldValidationPromises);
      return fieldErrorMapMap.flat();
    };
    this.validateArrayFieldsStartingFrom = async (field, index, cause) => {
      const currentValue = this.getFieldValue(field);
      const lastIndex = Array.isArray(currentValue) ? Math.max(currentValue.length - 1, 0) : null;
      const fieldKeysToValidate = [`${field}[${index}]`];
      for (let i = index + 1; i <= (lastIndex ?? 0); i++) {
        fieldKeysToValidate.push(`${field}[${i}]`);
      }
      const fieldsToValidate = Object.keys(this.fieldInfo).filter(
        (fieldKey) => fieldKeysToValidate.some((key) => fieldKey.startsWith(key))
      );
      const fieldValidationPromises = [];
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
        fieldsToValidate.forEach((nestedField) => {
          fieldValidationPromises.push(
            Promise.resolve().then(() => this.validateField(nestedField, cause))
          );
        });
      });
      const fieldErrorMapMap = await Promise.all(fieldValidationPromises);
      return fieldErrorMapMap.flat();
    };
    this.validateField = (field, cause) => {
      var _a2;
      const fieldInstance = (_a2 = this.fieldInfo[field]) == null ? void 0 : _a2.instance;
      if (!fieldInstance) return [];
      if (!fieldInstance.state.meta.isTouched) {
        fieldInstance.setMeta((prev) => ({ ...prev, isTouched: true }));
      }
      return fieldInstance.validate(cause);
    };
    this.validateSync = (cause) => {
      const validates = (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.getSyncValidatorArray)(cause, this.options);
      let hasErrored = false;
      const fieldsErrorMap = {};
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
        for (const validateObj of validates) {
          if (!validateObj.validate) continue;
          const rawError = this.runValidator({
            validate: validateObj.validate,
            value: {
              value: this.state.values,
              formApi: this,
              validationSource: "form"
            },
            type: "validate"
          });
          const { formError, fieldErrors } = normalizeError(rawError);
          const errorMapKey = getErrorMapKey(validateObj.cause);
          if (fieldErrors) {
            for (const [field, fieldError] of Object.entries(fieldErrors)) {
              const oldErrorMap = fieldsErrorMap[field] || {};
              const newErrorMap = {
                ...oldErrorMap,
                [errorMapKey]: fieldError
              };
              fieldsErrorMap[field] = newErrorMap;
              const fieldMeta = this.getFieldMeta(field);
              if (fieldMeta && fieldMeta.errorMap[errorMapKey] !== fieldError) {
                this.setFieldMeta(field, (prev) => ({
                  ...prev,
                  errorMap: {
                    ...prev.errorMap,
                    [errorMapKey]: fieldError
                  }
                }));
              }
            }
          }
          if (this.state.errorMap[errorMapKey] !== formError) {
            this.baseStore.setState((prev) => ({
              ...prev,
              errorMap: {
                ...prev.errorMap,
                [errorMapKey]: formError
              }
            }));
          }
          if (formError || fieldErrors) {
            hasErrored = true;
          }
        }
      });
      const submitErrKey = getErrorMapKey("submit");
      if (this.state.errorMap[submitErrKey] && cause !== "submit" && !hasErrored) {
        this.baseStore.setState((prev) => ({
          ...prev,
          errorMap: {
            ...prev.errorMap,
            [submitErrKey]: void 0
          }
        }));
      }
      return { hasErrored, fieldsErrorMap };
    };
    this.validateAsync = async (cause) => {
      const validates = (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.getAsyncValidatorArray)(cause, this.options);
      if (!this.state.isFormValidating) {
        this.baseStore.setState((prev) => ({ ...prev, isFormValidating: true }));
      }
      const promises = [];
      let fieldErrors;
      for (const validateObj of validates) {
        if (!validateObj.validate) continue;
        const key = getErrorMapKey(validateObj.cause);
        const fieldValidatorMeta = this.state.validationMetaMap[key];
        fieldValidatorMeta == null ? void 0 : fieldValidatorMeta.lastAbortController.abort();
        const controller = new AbortController();
        this.state.validationMetaMap[key] = {
          lastAbortController: controller
        };
        promises.push(
          new Promise(async (resolve) => {
            let rawError;
            try {
              rawError = await new Promise((rawResolve, rawReject) => {
                setTimeout(async () => {
                  if (controller.signal.aborted) return rawResolve(void 0);
                  try {
                    rawResolve(
                      await this.runValidator({
                        validate: validateObj.validate,
                        value: {
                          value: this.state.values,
                          formApi: this,
                          validationSource: "form",
                          signal: controller.signal
                        },
                        type: "validateAsync"
                      })
                    );
                  } catch (e) {
                    rawReject(e);
                  }
                }, validateObj.debounceMs);
              });
            } catch (e) {
              rawError = e;
            }
            const { formError, fieldErrors: fieldErrorsFromNormalizeError } = normalizeError(rawError);
            if (fieldErrorsFromNormalizeError) {
              fieldErrors = fieldErrors ? { ...fieldErrors, ...fieldErrorsFromNormalizeError } : fieldErrorsFromNormalizeError;
            }
            const errorMapKey = getErrorMapKey(validateObj.cause);
            if (fieldErrors) {
              for (const [field, fieldError] of Object.entries(fieldErrors)) {
                const fieldMeta = this.getFieldMeta(field);
                if (fieldMeta && fieldMeta.errorMap[errorMapKey] !== fieldError) {
                  this.setFieldMeta(field, (prev) => ({
                    ...prev,
                    errorMap: {
                      ...prev.errorMap,
                      [errorMapKey]: fieldError
                    }
                  }));
                }
              }
            }
            this.baseStore.setState((prev) => ({
              ...prev,
              errorMap: {
                ...prev.errorMap,
                [errorMapKey]: formError
              }
            }));
            resolve(fieldErrors ? { fieldErrors, errorMapKey } : void 0);
          })
        );
      }
      let results = [];
      const fieldsErrorMap = {};
      if (promises.length) {
        results = await Promise.all(promises);
        for (const fieldValidationResult of results) {
          if (fieldValidationResult == null ? void 0 : fieldValidationResult.fieldErrors) {
            const { errorMapKey } = fieldValidationResult;
            for (const [field, fieldError] of Object.entries(
              fieldValidationResult.fieldErrors
            )) {
              const oldErrorMap = fieldsErrorMap[field] || {};
              const newErrorMap = {
                ...oldErrorMap,
                [errorMapKey]: fieldError
              };
              fieldsErrorMap[field] = newErrorMap;
            }
          }
        }
      }
      this.baseStore.setState((prev) => ({
        ...prev,
        isFormValidating: false
      }));
      return fieldsErrorMap;
    };
    this.validate = (cause) => {
      const { hasErrored, fieldsErrorMap } = this.validateSync(cause);
      if (hasErrored && !this.options.asyncAlways) {
        return fieldsErrorMap;
      }
      return this.validateAsync(cause);
    };
    this.handleSubmit = async () => {
      var _a2, _b, _c, _d;
      this.baseStore.setState((old) => ({
        ...old,
        // Submission attempts mark the form as not submitted
        isSubmitted: false,
        // Count submission attempts
        submissionAttempts: old.submissionAttempts + 1
      }));
      if (!this.state.canSubmit) return;
      this.baseStore.setState((d) => ({ ...d, isSubmitting: true }));
      const done = () => {
        this.baseStore.setState((prev) => ({ ...prev, isSubmitting: false }));
      };
      await this.validateAllFields("submit");
      if (!this.state.isValid) {
        done();
        (_b = (_a2 = this.options).onSubmitInvalid) == null ? void 0 : _b.call(_a2, {
          value: this.state.values,
          formApi: this
        });
        return;
      }
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
        void Object.values(this.fieldInfo).forEach((field) => {
          var _a3, _b2, _c2;
          (_c2 = (_b2 = (_a3 = field.instance) == null ? void 0 : _a3.options.listeners) == null ? void 0 : _b2.onSubmit) == null ? void 0 : _c2.call(_b2, {
            value: field.instance.state.value,
            fieldApi: field.instance
          });
        });
      });
      try {
        await ((_d = (_c = this.options).onSubmit) == null ? void 0 : _d.call(_c, { value: this.state.values, formApi: this }));
        (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
          this.baseStore.setState((prev) => ({ ...prev, isSubmitted: true }));
          done();
        });
      } catch (err) {
        done();
        throw err;
      }
    };
    this.getFieldValue = (field) => (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.getBy)(this.state.values, field);
    this.getFieldMeta = (field) => {
      return this.state.fieldMeta[field];
    };
    this.getFieldInfo = (field) => {
      var _a2;
      return (_a2 = this.fieldInfo)[field] || (_a2[field] = {
        instance: null,
        validationMetaMap: {
          onChange: void 0,
          onBlur: void 0,
          onSubmit: void 0,
          onMount: void 0,
          onServer: void 0
        }
      });
    };
    this.setFieldMeta = (field, updater) => {
      this.baseStore.setState((prev) => {
        return {
          ...prev,
          fieldMetaBase: {
            ...prev.fieldMetaBase,
            [field]: (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.functionalUpdate)(
              updater,
              prev.fieldMetaBase[field]
            )
          }
        };
      });
    };
    this.resetFieldMeta = (fieldMeta) => {
      return Object.keys(fieldMeta).reduce(
        (acc, key) => {
          const fieldKey = key;
          acc[fieldKey] = {
            isValidating: false,
            isTouched: false,
            isBlurred: false,
            isDirty: false,
            isPristine: true,
            errors: [],
            errorMap: {}
          };
          return acc;
        },
        {}
      );
    };
    this.setFieldValue = (field, updater, opts2) => {
      const dontUpdateMeta = (opts2 == null ? void 0 : opts2.dontUpdateMeta) ?? false;
      (0,_tanstack_store__WEBPACK_IMPORTED_MODULE_0__.batch)(() => {
        if (!dontUpdateMeta) {
          this.setFieldMeta(field, (prev) => ({
            ...prev,
            isTouched: true,
            isDirty: true,
            errorMap: {
              // eslint-disable-next-line @typescript-eslint/no-unnecessary-condition
              ...prev == null ? void 0 : prev.errorMap,
              onMount: void 0
            }
          }));
        }
        this.baseStore.setState((prev) => {
          return {
            ...prev,
            values: (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.setBy)(prev.values, field, updater)
          };
        });
      });
    };
    this.deleteField = (field) => {
      this.baseStore.setState((prev) => {
        const newState = { ...prev };
        newState.values = (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.deleteBy)(newState.values, field);
        delete newState.fieldMetaBase[field];
        return newState;
      });
      delete this.fieldInfo[field];
    };
    this.pushFieldValue = (field, value, opts2) => {
      this.setFieldValue(
        field,
        (prev) => [...Array.isArray(prev) ? prev : [], value],
        opts2
      );
      this.validateField(field, "change");
    };
    this.insertFieldValue = async (field, index, value, opts2) => {
      this.setFieldValue(
        field,
        (prev) => {
          return [
            ...prev.slice(0, index),
            value,
            ...prev.slice(index)
          ];
        },
        opts2
      );
      await this.validateField(field, "change");
    };
    this.replaceFieldValue = async (field, index, value, opts2) => {
      this.setFieldValue(
        field,
        (prev) => {
          return prev.map(
            (d, i) => i === index ? value : d
          );
        },
        opts2
      );
      await this.validateField(field, "change");
      await this.validateArrayFieldsStartingFrom(field, index, "change");
    };
    this.removeFieldValue = async (field, index, opts2) => {
      const fieldValue = this.getFieldValue(field);
      const lastIndex = Array.isArray(fieldValue) ? Math.max(fieldValue.length - 1, 0) : null;
      this.setFieldValue(
        field,
        (prev) => {
          return prev.filter(
            (_d, i) => i !== index
          );
        },
        opts2
      );
      if (lastIndex !== null) {
        const start = `${field}[${lastIndex}]`;
        const fieldsToDelete = Object.keys(this.fieldInfo).filter(
          (f) => f.startsWith(start)
        );
        fieldsToDelete.forEach((f) => this.deleteField(f));
      }
      await this.validateField(field, "change");
      await this.validateArrayFieldsStartingFrom(field, index, "change");
    };
    this.swapFieldValues = (field, index1, index2, opts2) => {
      this.setFieldValue(
        field,
        (prev) => {
          const prev1 = prev[index1];
          const prev2 = prev[index2];
          return (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.setBy)((0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.setBy)(prev, `${index1}`, prev2), `${index2}`, prev1);
        },
        opts2
      );
      this.validateField(field, "change");
      this.validateField(`${field}[${index1}]`, "change");
      this.validateField(`${field}[${index2}]`, "change");
    };
    this.moveFieldValues = (field, index1, index2, opts2) => {
      this.setFieldValue(
        field,
        (prev) => {
          prev.splice(index2, 0, prev.splice(index1, 1)[0]);
          return prev;
        },
        opts2
      );
      this.validateField(field, "change");
      this.validateField(`${field}[${index1}]`, "change");
      this.validateField(`${field}[${index2}]`, "change");
    };
    this.baseStore = new _tanstack_store__WEBPACK_IMPORTED_MODULE_2__.Store(
      getDefaultFormState({
        ...opts == null ? void 0 : opts.defaultState,
        values: (opts == null ? void 0 : opts.defaultValues) ?? ((_a = opts == null ? void 0 : opts.defaultState) == null ? void 0 : _a.values),
        isFormValid: true
      })
    );
    this.fieldMetaDerived = new _tanstack_store__WEBPACK_IMPORTED_MODULE_3__.Derived({
      deps: [this.baseStore],
      fn: ({ prevDepVals, currDepVals, prevVal: _prevVal }) => {
        const prevVal = _prevVal;
        const prevBaseStore = prevDepVals == null ? void 0 : prevDepVals[0];
        const currBaseStore = currDepVals[0];
        const fieldMeta = {};
        for (const fieldName of Object.keys(
          currBaseStore.fieldMetaBase
        )) {
          const currBaseVal = currBaseStore.fieldMetaBase[fieldName];
          const prevBaseVal = prevBaseStore == null ? void 0 : prevBaseStore.fieldMetaBase[fieldName];
          const prevFieldInfo = prevVal == null ? void 0 : prevVal[fieldName];
          let fieldErrors = prevFieldInfo == null ? void 0 : prevFieldInfo.errors;
          if (!prevBaseVal || currBaseVal.errorMap !== prevBaseVal.errorMap) {
            fieldErrors = Object.values(currBaseVal.errorMap ?? {}).filter(
              (val) => val !== void 0
            );
          }
          const isFieldPristine = !currBaseVal.isDirty;
          if (prevFieldInfo && prevFieldInfo.isPristine === isFieldPristine && prevFieldInfo.errors === fieldErrors && currBaseVal === prevBaseVal) {
            fieldMeta[fieldName] = prevFieldInfo;
            continue;
          }
          fieldMeta[fieldName] = {
            ...currBaseVal,
            errors: fieldErrors,
            isPristine: isFieldPristine
          };
        }
        return fieldMeta;
      }
    });
    this.store = new _tanstack_store__WEBPACK_IMPORTED_MODULE_3__.Derived({
      deps: [this.baseStore, this.fieldMetaDerived],
      fn: ({ prevDepVals, currDepVals, prevVal: _prevVal }) => {
        var _a2, _b, _c, _d;
        const prevVal = _prevVal;
        const prevBaseStore = prevDepVals == null ? void 0 : prevDepVals[0];
        const currBaseStore = currDepVals[0];
        const fieldMetaValues = Object.values(currBaseStore.fieldMetaBase);
        const isFieldsValidating = fieldMetaValues.some(
          (field) => field == null ? void 0 : field.isValidating
        );
        const isFieldsValid = !fieldMetaValues.some(
          (field) => (field == null ? void 0 : field.errorMap) && (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.isNonEmptyArray)(Object.values(field.errorMap).filter(Boolean))
        );
        const isTouched = fieldMetaValues.some((field) => field == null ? void 0 : field.isTouched);
        const isBlurred = fieldMetaValues.some((field) => field == null ? void 0 : field.isBlurred);
        const shouldInvalidateOnMount = (
          // eslint-disable-next-line @typescript-eslint/no-unnecessary-condition
          isTouched && ((_a2 = currBaseStore == null ? void 0 : currBaseStore.errorMap) == null ? void 0 : _a2.onMount)
        );
        const isDirty = fieldMetaValues.some((field) => field == null ? void 0 : field.isDirty);
        const isPristine = !isDirty;
        const hasOnMountError = Boolean(
          // eslint-disable-next-line @typescript-eslint/no-unnecessary-condition
          ((_b = currBaseStore.errorMap) == null ? void 0 : _b.onMount) || // eslint-disable-next-line @typescript-eslint/no-unnecessary-condition
          fieldMetaValues.some((f) => {
            var _a3;
            return (_a3 = f == null ? void 0 : f.errorMap) == null ? void 0 : _a3.onMount;
          })
        );
        const isValidating = !!isFieldsValidating;
        let errors = (prevVal == null ? void 0 : prevVal.errors) ?? [];
        if (!prevBaseStore || currBaseStore.errorMap !== prevBaseStore.errorMap) {
          errors = Object.values(currBaseStore.errorMap).reduce(
            (prev, curr) => {
              if (curr === void 0) return prev;
              if (typeof curr === "string") {
                prev.push(curr);
                return prev;
              } else if (curr && isFormValidationError(curr)) {
                prev.push(curr.form);
                return prev;
              }
              return prev;
            },
            []
          );
        }
        const isFormValid = errors.length === 0;
        const isValid = isFieldsValid && isFormValid;
        const canSubmit = currBaseStore.submissionAttempts === 0 && !isTouched && !hasOnMountError || !isValidating && !currBaseStore.isSubmitting && isValid;
        let errorMap = currBaseStore.errorMap;
        if (shouldInvalidateOnMount) {
          errors = errors.filter(
            (err) => err !== currBaseStore.errorMap.onMount
          );
          errorMap = Object.assign(errorMap, { onMount: void 0 });
        }
        let state = {
          ...currBaseStore,
          errorMap,
          fieldMeta: this.fieldMetaDerived.state,
          errors,
          isFieldsValidating,
          isFieldsValid,
          isFormValid,
          isValid,
          canSubmit,
          isTouched,
          isBlurred,
          isPristine,
          isDirty
        };
        const transformArray = ((_c = this.options.transform) == null ? void 0 : _c.deps) ?? [];
        const shouldTransform = transformArray.length !== this.prevTransformArray.length || transformArray.some((val, i) => val !== this.prevTransformArray[i]);
        if (shouldTransform) {
          const newObj = Object.assign({}, this, { state });
          (_d = this.options.transform) == null ? void 0 : _d.fn(newObj);
          state = newObj.state;
          this.prevTransformArray = transformArray;
        }
        return state;
      }
    });
    this.update(opts || {});
  }
  get state() {
    return this.store.state;
  }
  /**
   * @private
   */
  runValidator(props) {
    const adapter = this.options.validatorAdapter;
    if (adapter && (typeof props.validate !== "function" || "~standard" in props.validate)) {
      return adapter()[props.type](props.value, props.validate);
    }
    if ((0,_standardSchemaValidator_js__WEBPACK_IMPORTED_MODULE_4__.isStandardSchemaValidator)(props.validate)) {
      return (0,_standardSchemaValidator_js__WEBPACK_IMPORTED_MODULE_4__.standardSchemaValidator)()()[props.type](
        props.value,
        props.validate
      );
    }
    return props.validate(props.value);
  }
  /**
   * Updates the form's errorMap
   */
  setErrorMap(errorMap) {
    this.baseStore.setState((prev) => ({
      ...prev,
      errorMap: {
        ...prev.errorMap,
        ...errorMap
      }
    }));
  }
}
function normalizeError(rawError) {
  if (rawError) {
    if (typeof rawError === "object") {
      const formError = normalizeError(rawError.form).formError;
      const fieldErrors = rawError.fields;
      return { formError, fieldErrors };
    }
    if (typeof rawError !== "string") {
      return { formError: "Invalid Form Values" };
    }
    return { formError: rawError };
  }
  return { formError: void 0 };
}
function getErrorMapKey(cause) {
  switch (cause) {
    case "submit":
      return "onSubmit";
    case "blur":
      return "onBlur";
    case "mount":
      return "onMount";
    case "server":
      return "onServer";
    case "change":
    default:
      return "onChange";
  }
}

//# sourceMappingURL=FormApi.js.map


/***/ }),

/***/ "./node_modules/@tanstack/form-core/dist/esm/standardSchemaValidator.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@tanstack/form-core/dist/esm/standardSchemaValidator.js ***!
  \******************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   isStandardSchemaValidator: () => (/* binding */ isStandardSchemaValidator),
/* harmony export */   standardSchemaValidator: () => (/* binding */ standardSchemaValidator)
/* harmony export */ });
function prefixSchemaToErrors(issues, transformErrors) {
  const schema = /* @__PURE__ */ new Map();
  for (const issue of issues) {
    const path = [...issue.path ?? []].map((segment) => {
      const normalizedSegment = typeof segment === "object" ? segment.key : segment;
      return typeof normalizedSegment === "number" ? `[${normalizedSegment}]` : normalizedSegment;
    }).join(".").replace(/\.\[/g, "[");
    schema.set(path, (schema.get(path) ?? []).concat(issue));
  }
  const transformedSchema = {};
  schema.forEach((value, key) => {
    transformedSchema[key] = transformErrors(value);
  });
  return transformedSchema;
}
function defaultFormTransformer(transformErrors) {
  return (issues) => ({
    form: transformErrors(issues),
    fields: prefixSchemaToErrors(issues, transformErrors)
  });
}
const standardSchemaValidator = (params = {}) => () => {
  const transformFieldErrors = params.transformErrors ?? ((issues) => issues.map((issue) => issue.message).join(", "));
  const getTransformStrategy = (validationSource) => validationSource === "form" ? defaultFormTransformer(transformFieldErrors) : transformFieldErrors;
  return {
    validate({ value, validationSource }, fn) {
      const result = fn["~standard"].validate(value);
      if (result instanceof Promise) {
        throw new Error("async function passed to sync validator");
      }
      if (!result.issues) return;
      const transformer = getTransformStrategy(validationSource);
      return transformer(result.issues);
    },
    async validateAsync({ value, validationSource }, fn) {
      const result = await fn["~standard"].validate(value);
      if (!result.issues) return;
      const transformer = getTransformStrategy(validationSource);
      return transformer(result.issues);
    }
  };
};
const isStandardSchemaValidator = (validator) => !!validator && "~standard" in validator;

//# sourceMappingURL=standardSchemaValidator.js.map


/***/ }),

/***/ "./node_modules/@tanstack/form-core/dist/esm/utils.js":
/*!************************************************************!*\
  !*** ./node_modules/@tanstack/form-core/dist/esm/utils.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   deleteBy: () => (/* binding */ deleteBy),
/* harmony export */   functionalUpdate: () => (/* binding */ functionalUpdate),
/* harmony export */   getAsyncValidatorArray: () => (/* binding */ getAsyncValidatorArray),
/* harmony export */   getBy: () => (/* binding */ getBy),
/* harmony export */   getSyncValidatorArray: () => (/* binding */ getSyncValidatorArray),
/* harmony export */   isNonEmptyArray: () => (/* binding */ isNonEmptyArray),
/* harmony export */   makePathArray: () => (/* binding */ makePathArray),
/* harmony export */   setBy: () => (/* binding */ setBy)
/* harmony export */ });
function functionalUpdate(updater, input) {
  return typeof updater === "function" ? updater(input) : updater;
}
function getBy(obj, path) {
  const pathObj = makePathArray(path);
  return pathObj.reduce((current, pathPart) => {
    if (current === null) return null;
    if (typeof current !== "undefined") {
      return current[pathPart];
    }
    return void 0;
  }, obj);
}
function setBy(obj, _path, updater) {
  const path = makePathArray(_path);
  function doSet(parent) {
    if (!path.length) {
      return functionalUpdate(updater, parent);
    }
    const key = path.shift();
    if (typeof key === "string" || typeof key === "number" && !Array.isArray(parent)) {
      if (typeof parent === "object") {
        if (parent === null) {
          parent = {};
        }
        return {
          ...parent,
          [key]: doSet(parent[key])
        };
      }
      return {
        [key]: doSet()
      };
    }
    if (Array.isArray(parent) && typeof key === "number") {
      const prefix = parent.slice(0, key);
      return [
        ...prefix.length ? prefix : new Array(key),
        doSet(parent[key]),
        ...parent.slice(key + 1)
      ];
    }
    return [...new Array(key), doSet()];
  }
  return doSet(obj);
}
function deleteBy(obj, _path) {
  const path = makePathArray(_path);
  function doDelete(parent) {
    if (!parent) return;
    if (path.length === 1) {
      const finalPath = path[0];
      if (Array.isArray(parent) && typeof finalPath === "number") {
        return parent.filter((_, i) => i !== finalPath);
      }
      const { [finalPath]: remove, ...rest } = parent;
      return rest;
    }
    const key = path.shift();
    if (typeof key === "string") {
      if (typeof parent === "object") {
        return {
          ...parent,
          [key]: doDelete(parent[key])
        };
      }
    }
    if (typeof key === "number") {
      if (Array.isArray(parent)) {
        if (key >= parent.length) {
          return parent;
        }
        const prefix = parent.slice(0, key);
        return [
          ...prefix.length ? prefix : new Array(key),
          doDelete(parent[key]),
          ...parent.slice(key + 1)
        ];
      }
    }
    throw new Error("It seems we have created an infinite loop in deleteBy. ");
  }
  return doDelete(obj);
}
const reFindNumbers0 = /^(\d*)$/gm;
const reFindNumbers1 = /\.(\d*)\./gm;
const reFindNumbers2 = /^(\d*)\./gm;
const reFindNumbers3 = /\.(\d*$)/gm;
const reFindMultiplePeriods = /\.{2,}/gm;
const intPrefix = "__int__";
const intReplace = `${intPrefix}$1`;
function makePathArray(str) {
  if (Array.isArray(str)) {
    return [...str];
  }
  if (typeof str !== "string") {
    throw new Error("Path must be a string.");
  }
  return str.replaceAll("[", ".").replaceAll("]", "").replace(reFindNumbers0, intReplace).replace(reFindNumbers1, `.${intReplace}.`).replace(reFindNumbers2, `${intReplace}.`).replace(reFindNumbers3, `.${intReplace}`).replace(reFindMultiplePeriods, ".").split(".").map((d) => {
    if (d.indexOf(intPrefix) === 0) {
      return parseInt(d.substring(intPrefix.length), 10);
    }
    return d;
  });
}
function isNonEmptyArray(obj) {
  return !(Array.isArray(obj) && obj.length === 0);
}
function getAsyncValidatorArray(cause, options) {
  const { asyncDebounceMs } = options;
  const {
    onChangeAsync,
    onBlurAsync,
    onSubmitAsync,
    onBlurAsyncDebounceMs,
    onChangeAsyncDebounceMs
  } = options.validators || {};
  const defaultDebounceMs = asyncDebounceMs ?? 0;
  const changeValidator = {
    cause: "change",
    validate: onChangeAsync,
    debounceMs: onChangeAsyncDebounceMs ?? defaultDebounceMs
  };
  const blurValidator = {
    cause: "blur",
    validate: onBlurAsync,
    debounceMs: onBlurAsyncDebounceMs ?? defaultDebounceMs
  };
  const submitValidator = {
    cause: "submit",
    validate: onSubmitAsync,
    debounceMs: 0
  };
  const noopValidator = (validator) => ({ ...validator, debounceMs: 0 });
  switch (cause) {
    case "submit":
      return [
        noopValidator(changeValidator),
        noopValidator(blurValidator),
        submitValidator
      ];
    case "blur":
      return [blurValidator];
    case "change":
      return [changeValidator];
    case "server":
    default:
      return [];
  }
}
function getSyncValidatorArray(cause, options) {
  const { onChange, onBlur, onSubmit, onMount } = options.validators || {};
  const changeValidator = { cause: "change", validate: onChange };
  const blurValidator = { cause: "blur", validate: onBlur };
  const submitValidator = { cause: "submit", validate: onSubmit };
  const mountValidator = { cause: "mount", validate: onMount };
  const serverValidator = {
    cause: "server",
    validate: () => void 0
  };
  switch (cause) {
    case "mount":
      return [mountValidator];
    case "submit":
      return [
        changeValidator,
        blurValidator,
        submitValidator,
        serverValidator
      ];
    case "server":
      return [serverValidator];
    case "blur":
      return [blurValidator, serverValidator];
    case "change":
    default:
      return [changeValidator, serverValidator];
  }
}

//# sourceMappingURL=utils.js.map


/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/focusManager.js":
/*!************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/focusManager.js ***!
  \************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   FocusManager: () => (/* binding */ FocusManager),
/* harmony export */   focusManager: () => (/* binding */ focusManager)
/* harmony export */ });
/* harmony import */ var _subscribable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./subscribable.js */ "./node_modules/@tanstack/query-core/build/modern/subscribable.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/focusManager.ts


var FocusManager = class extends _subscribable_js__WEBPACK_IMPORTED_MODULE_0__.Subscribable {
  #focused;
  #cleanup;
  #setup;
  constructor() {
    super();
    this.#setup = (onFocus) => {
      if (!_utils_js__WEBPACK_IMPORTED_MODULE_1__.isServer && window.addEventListener) {
        const listener = () => onFocus();
        window.addEventListener("visibilitychange", listener, false);
        return () => {
          window.removeEventListener("visibilitychange", listener);
        };
      }
      return;
    };
  }
  onSubscribe() {
    if (!this.#cleanup) {
      this.setEventListener(this.#setup);
    }
  }
  onUnsubscribe() {
    if (!this.hasListeners()) {
      this.#cleanup?.();
      this.#cleanup = void 0;
    }
  }
  setEventListener(setup) {
    this.#setup = setup;
    this.#cleanup?.();
    this.#cleanup = setup((focused) => {
      if (typeof focused === "boolean") {
        this.setFocused(focused);
      } else {
        this.onFocus();
      }
    });
  }
  setFocused(focused) {
    const changed = this.#focused !== focused;
    if (changed) {
      this.#focused = focused;
      this.onFocus();
    }
  }
  onFocus() {
    const isFocused = this.isFocused();
    this.listeners.forEach((listener) => {
      listener(isFocused);
    });
  }
  isFocused() {
    if (typeof this.#focused === "boolean") {
      return this.#focused;
    }
    return globalThis.document?.visibilityState !== "hidden";
  }
};
var focusManager = new FocusManager();

//# sourceMappingURL=focusManager.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/infiniteQueryBehavior.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/infiniteQueryBehavior.js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   hasNextPage: () => (/* binding */ hasNextPage),
/* harmony export */   hasPreviousPage: () => (/* binding */ hasPreviousPage),
/* harmony export */   infiniteQueryBehavior: () => (/* binding */ infiniteQueryBehavior)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/infiniteQueryBehavior.ts

function infiniteQueryBehavior(pages) {
  return {
    onFetch: (context, query) => {
      const options = context.options;
      const direction = context.fetchOptions?.meta?.fetchMore?.direction;
      const oldPages = context.state.data?.pages || [];
      const oldPageParams = context.state.data?.pageParams || [];
      let result = { pages: [], pageParams: [] };
      let currentPage = 0;
      const fetchFn = async () => {
        let cancelled = false;
        const addSignalProperty = (object) => {
          Object.defineProperty(object, "signal", {
            enumerable: true,
            get: () => {
              if (context.signal.aborted) {
                cancelled = true;
              } else {
                context.signal.addEventListener("abort", () => {
                  cancelled = true;
                });
              }
              return context.signal;
            }
          });
        };
        const queryFn = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.ensureQueryFn)(context.options, context.fetchOptions);
        const fetchPage = async (data, param, previous) => {
          if (cancelled) {
            return Promise.reject();
          }
          if (param == null && data.pages.length) {
            return Promise.resolve(data);
          }
          const queryFnContext = {
            queryKey: context.queryKey,
            pageParam: param,
            direction: previous ? "backward" : "forward",
            meta: context.options.meta
          };
          addSignalProperty(queryFnContext);
          const page = await queryFn(
            queryFnContext
          );
          const { maxPages } = context.options;
          const addTo = previous ? _utils_js__WEBPACK_IMPORTED_MODULE_0__.addToStart : _utils_js__WEBPACK_IMPORTED_MODULE_0__.addToEnd;
          return {
            pages: addTo(data.pages, page, maxPages),
            pageParams: addTo(data.pageParams, param, maxPages)
          };
        };
        if (direction && oldPages.length) {
          const previous = direction === "backward";
          const pageParamFn = previous ? getPreviousPageParam : getNextPageParam;
          const oldData = {
            pages: oldPages,
            pageParams: oldPageParams
          };
          const param = pageParamFn(options, oldData);
          result = await fetchPage(oldData, param, previous);
        } else {
          const remainingPages = pages ?? oldPages.length;
          do {
            const param = currentPage === 0 ? oldPageParams[0] ?? options.initialPageParam : getNextPageParam(options, result);
            if (currentPage > 0 && param == null) {
              break;
            }
            result = await fetchPage(result, param);
            currentPage++;
          } while (currentPage < remainingPages);
        }
        return result;
      };
      if (context.options.persister) {
        context.fetchFn = () => {
          return context.options.persister?.(
            fetchFn,
            {
              queryKey: context.queryKey,
              meta: context.options.meta,
              signal: context.signal
            },
            query
          );
        };
      } else {
        context.fetchFn = fetchFn;
      }
    }
  };
}
function getNextPageParam(options, { pages, pageParams }) {
  const lastIndex = pages.length - 1;
  return pages.length > 0 ? options.getNextPageParam(
    pages[lastIndex],
    pages,
    pageParams[lastIndex],
    pageParams
  ) : void 0;
}
function getPreviousPageParam(options, { pages, pageParams }) {
  return pages.length > 0 ? options.getPreviousPageParam?.(pages[0], pages, pageParams[0], pageParams) : void 0;
}
function hasNextPage(options, data) {
  if (!data)
    return false;
  return getNextPageParam(options, data) != null;
}
function hasPreviousPage(options, data) {
  if (!data || !options.getPreviousPageParam)
    return false;
  return getPreviousPageParam(options, data) != null;
}

//# sourceMappingURL=infiniteQueryBehavior.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/mutation.js":
/*!********************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/mutation.js ***!
  \********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Mutation: () => (/* binding */ Mutation),
/* harmony export */   getDefaultState: () => (/* binding */ getDefaultState)
/* harmony export */ });
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _removable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./removable.js */ "./node_modules/@tanstack/query-core/build/modern/removable.js");
/* harmony import */ var _retryer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./retryer.js */ "./node_modules/@tanstack/query-core/build/modern/retryer.js");
// src/mutation.ts



var Mutation = class extends _removable_js__WEBPACK_IMPORTED_MODULE_0__.Removable {
  #observers;
  #mutationCache;
  #retryer;
  constructor(config) {
    super();
    this.mutationId = config.mutationId;
    this.#mutationCache = config.mutationCache;
    this.#observers = [];
    this.state = config.state || getDefaultState();
    this.setOptions(config.options);
    this.scheduleGc();
  }
  setOptions(options) {
    this.options = options;
    this.updateGcTime(this.options.gcTime);
  }
  get meta() {
    return this.options.meta;
  }
  addObserver(observer) {
    if (!this.#observers.includes(observer)) {
      this.#observers.push(observer);
      this.clearGcTimeout();
      this.#mutationCache.notify({
        type: "observerAdded",
        mutation: this,
        observer
      });
    }
  }
  removeObserver(observer) {
    this.#observers = this.#observers.filter((x) => x !== observer);
    this.scheduleGc();
    this.#mutationCache.notify({
      type: "observerRemoved",
      mutation: this,
      observer
    });
  }
  optionalRemove() {
    if (!this.#observers.length) {
      if (this.state.status === "pending") {
        this.scheduleGc();
      } else {
        this.#mutationCache.remove(this);
      }
    }
  }
  continue() {
    return this.#retryer?.continue() ?? // continuing a mutation assumes that variables are set, mutation must have been dehydrated before
    this.execute(this.state.variables);
  }
  async execute(variables) {
    this.#retryer = (0,_retryer_js__WEBPACK_IMPORTED_MODULE_1__.createRetryer)({
      fn: () => {
        if (!this.options.mutationFn) {
          return Promise.reject(new Error("No mutationFn found"));
        }
        return this.options.mutationFn(variables);
      },
      onFail: (failureCount, error) => {
        this.#dispatch({ type: "failed", failureCount, error });
      },
      onPause: () => {
        this.#dispatch({ type: "pause" });
      },
      onContinue: () => {
        this.#dispatch({ type: "continue" });
      },
      retry: this.options.retry ?? 0,
      retryDelay: this.options.retryDelay,
      networkMode: this.options.networkMode,
      canRun: () => this.#mutationCache.canRun(this)
    });
    const restored = this.state.status === "pending";
    const isPaused = !this.#retryer.canStart();
    try {
      if (!restored) {
        this.#dispatch({ type: "pending", variables, isPaused });
        await this.#mutationCache.config.onMutate?.(
          variables,
          this
        );
        const context = await this.options.onMutate?.(variables);
        if (context !== this.state.context) {
          this.#dispatch({
            type: "pending",
            context,
            variables,
            isPaused
          });
        }
      }
      const data = await this.#retryer.start();
      await this.#mutationCache.config.onSuccess?.(
        data,
        variables,
        this.state.context,
        this
      );
      await this.options.onSuccess?.(data, variables, this.state.context);
      await this.#mutationCache.config.onSettled?.(
        data,
        null,
        this.state.variables,
        this.state.context,
        this
      );
      await this.options.onSettled?.(data, null, variables, this.state.context);
      this.#dispatch({ type: "success", data });
      return data;
    } catch (error) {
      try {
        await this.#mutationCache.config.onError?.(
          error,
          variables,
          this.state.context,
          this
        );
        await this.options.onError?.(
          error,
          variables,
          this.state.context
        );
        await this.#mutationCache.config.onSettled?.(
          void 0,
          error,
          this.state.variables,
          this.state.context,
          this
        );
        await this.options.onSettled?.(
          void 0,
          error,
          variables,
          this.state.context
        );
        throw error;
      } finally {
        this.#dispatch({ type: "error", error });
      }
    } finally {
      this.#mutationCache.runNext(this);
    }
  }
  #dispatch(action) {
    const reducer = (state) => {
      switch (action.type) {
        case "failed":
          return {
            ...state,
            failureCount: action.failureCount,
            failureReason: action.error
          };
        case "pause":
          return {
            ...state,
            isPaused: true
          };
        case "continue":
          return {
            ...state,
            isPaused: false
          };
        case "pending":
          return {
            ...state,
            context: action.context,
            data: void 0,
            failureCount: 0,
            failureReason: null,
            error: null,
            isPaused: action.isPaused,
            status: "pending",
            variables: action.variables,
            submittedAt: Date.now()
          };
        case "success":
          return {
            ...state,
            data: action.data,
            failureCount: 0,
            failureReason: null,
            error: null,
            status: "success",
            isPaused: false
          };
        case "error":
          return {
            ...state,
            data: void 0,
            error: action.error,
            failureCount: state.failureCount + 1,
            failureReason: action.error,
            isPaused: false,
            status: "error"
          };
      }
    };
    this.state = reducer(this.state);
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_2__.notifyManager.batch(() => {
      this.#observers.forEach((observer) => {
        observer.onMutationUpdate(action);
      });
      this.#mutationCache.notify({
        mutation: this,
        type: "updated",
        action
      });
    });
  }
};
function getDefaultState() {
  return {
    context: void 0,
    data: void 0,
    error: null,
    failureCount: 0,
    failureReason: null,
    isPaused: false,
    status: "idle",
    variables: void 0,
    submittedAt: 0
  };
}

//# sourceMappingURL=mutation.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/mutationCache.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/mutationCache.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   MutationCache: () => (/* binding */ MutationCache)
/* harmony export */ });
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _mutation_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./mutation.js */ "./node_modules/@tanstack/query-core/build/modern/mutation.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
/* harmony import */ var _subscribable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./subscribable.js */ "./node_modules/@tanstack/query-core/build/modern/subscribable.js");
// src/mutationCache.ts




var MutationCache = class extends _subscribable_js__WEBPACK_IMPORTED_MODULE_0__.Subscribable {
  constructor(config = {}) {
    super();
    this.config = config;
    this.#mutations = /* @__PURE__ */ new Set();
    this.#scopes = /* @__PURE__ */ new Map();
    this.#mutationId = 0;
  }
  #mutations;
  #scopes;
  #mutationId;
  build(client, options, state) {
    const mutation = new _mutation_js__WEBPACK_IMPORTED_MODULE_1__.Mutation({
      mutationCache: this,
      mutationId: ++this.#mutationId,
      options: client.defaultMutationOptions(options),
      state
    });
    this.add(mutation);
    return mutation;
  }
  add(mutation) {
    this.#mutations.add(mutation);
    const scope = scopeFor(mutation);
    if (typeof scope === "string") {
      const scopedMutations = this.#scopes.get(scope);
      if (scopedMutations) {
        scopedMutations.push(mutation);
      } else {
        this.#scopes.set(scope, [mutation]);
      }
    }
    this.notify({ type: "added", mutation });
  }
  remove(mutation) {
    if (this.#mutations.delete(mutation)) {
      const scope = scopeFor(mutation);
      if (typeof scope === "string") {
        const scopedMutations = this.#scopes.get(scope);
        if (scopedMutations) {
          if (scopedMutations.length > 1) {
            const index = scopedMutations.indexOf(mutation);
            if (index !== -1) {
              scopedMutations.splice(index, 1);
            }
          } else if (scopedMutations[0] === mutation) {
            this.#scopes.delete(scope);
          }
        }
      }
    }
    this.notify({ type: "removed", mutation });
  }
  canRun(mutation) {
    const scope = scopeFor(mutation);
    if (typeof scope === "string") {
      const mutationsWithSameScope = this.#scopes.get(scope);
      const firstPendingMutation = mutationsWithSameScope?.find(
        (m) => m.state.status === "pending"
      );
      return !firstPendingMutation || firstPendingMutation === mutation;
    } else {
      return true;
    }
  }
  runNext(mutation) {
    const scope = scopeFor(mutation);
    if (typeof scope === "string") {
      const foundMutation = this.#scopes.get(scope)?.find((m) => m !== mutation && m.state.isPaused);
      return foundMutation?.continue() ?? Promise.resolve();
    } else {
      return Promise.resolve();
    }
  }
  clear() {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_2__.notifyManager.batch(() => {
      this.#mutations.forEach((mutation) => {
        this.notify({ type: "removed", mutation });
      });
      this.#mutations.clear();
      this.#scopes.clear();
    });
  }
  getAll() {
    return Array.from(this.#mutations);
  }
  find(filters) {
    const defaultedFilters = { exact: true, ...filters };
    return this.getAll().find(
      (mutation) => (0,_utils_js__WEBPACK_IMPORTED_MODULE_3__.matchMutation)(defaultedFilters, mutation)
    );
  }
  findAll(filters = {}) {
    return this.getAll().filter((mutation) => (0,_utils_js__WEBPACK_IMPORTED_MODULE_3__.matchMutation)(filters, mutation));
  }
  notify(event) {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_2__.notifyManager.batch(() => {
      this.listeners.forEach((listener) => {
        listener(event);
      });
    });
  }
  resumePausedMutations() {
    const pausedMutations = this.getAll().filter((x) => x.state.isPaused);
    return _notifyManager_js__WEBPACK_IMPORTED_MODULE_2__.notifyManager.batch(
      () => Promise.all(
        pausedMutations.map((mutation) => mutation.continue().catch(_utils_js__WEBPACK_IMPORTED_MODULE_3__.noop))
      )
    );
  }
};
function scopeFor(mutation) {
  return mutation.options.scope?.id;
}

//# sourceMappingURL=mutationCache.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/mutationObserver.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/mutationObserver.js ***!
  \****************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   MutationObserver: () => (/* binding */ MutationObserver)
/* harmony export */ });
/* harmony import */ var _mutation_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./mutation.js */ "./node_modules/@tanstack/query-core/build/modern/mutation.js");
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _subscribable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./subscribable.js */ "./node_modules/@tanstack/query-core/build/modern/subscribable.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/mutationObserver.ts




var MutationObserver = class extends _subscribable_js__WEBPACK_IMPORTED_MODULE_0__.Subscribable {
  #client;
  #currentResult = void 0;
  #currentMutation;
  #mutateOptions;
  constructor(client, options) {
    super();
    this.#client = client;
    this.setOptions(options);
    this.bindMethods();
    this.#updateResult();
  }
  bindMethods() {
    this.mutate = this.mutate.bind(this);
    this.reset = this.reset.bind(this);
  }
  setOptions(options) {
    const prevOptions = this.options;
    this.options = this.#client.defaultMutationOptions(options);
    if (!(0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.shallowEqualObjects)(this.options, prevOptions)) {
      this.#client.getMutationCache().notify({
        type: "observerOptionsUpdated",
        mutation: this.#currentMutation,
        observer: this
      });
    }
    if (prevOptions?.mutationKey && this.options.mutationKey && (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.hashKey)(prevOptions.mutationKey) !== (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.hashKey)(this.options.mutationKey)) {
      this.reset();
    } else if (this.#currentMutation?.state.status === "pending") {
      this.#currentMutation.setOptions(this.options);
    }
  }
  onUnsubscribe() {
    if (!this.hasListeners()) {
      this.#currentMutation?.removeObserver(this);
    }
  }
  onMutationUpdate(action) {
    this.#updateResult();
    this.#notify(action);
  }
  getCurrentResult() {
    return this.#currentResult;
  }
  reset() {
    this.#currentMutation?.removeObserver(this);
    this.#currentMutation = void 0;
    this.#updateResult();
    this.#notify();
  }
  mutate(variables, options) {
    this.#mutateOptions = options;
    this.#currentMutation?.removeObserver(this);
    this.#currentMutation = this.#client.getMutationCache().build(this.#client, this.options);
    this.#currentMutation.addObserver(this);
    return this.#currentMutation.execute(variables);
  }
  #updateResult() {
    const state = this.#currentMutation?.state ?? (0,_mutation_js__WEBPACK_IMPORTED_MODULE_2__.getDefaultState)();
    this.#currentResult = {
      ...state,
      isPending: state.status === "pending",
      isSuccess: state.status === "success",
      isError: state.status === "error",
      isIdle: state.status === "idle",
      mutate: this.mutate,
      reset: this.reset
    };
  }
  #notify(action) {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batch(() => {
      if (this.#mutateOptions && this.hasListeners()) {
        const variables = this.#currentResult.variables;
        const context = this.#currentResult.context;
        if (action?.type === "success") {
          this.#mutateOptions.onSuccess?.(action.data, variables, context);
          this.#mutateOptions.onSettled?.(action.data, null, variables, context);
        } else if (action?.type === "error") {
          this.#mutateOptions.onError?.(action.error, variables, context);
          this.#mutateOptions.onSettled?.(
            void 0,
            action.error,
            variables,
            context
          );
        }
      }
      this.listeners.forEach((listener) => {
        listener(this.#currentResult);
      });
    });
  }
};

//# sourceMappingURL=mutationObserver.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/notifyManager.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   createNotifyManager: () => (/* binding */ createNotifyManager),
/* harmony export */   notifyManager: () => (/* binding */ notifyManager)
/* harmony export */ });
// src/notifyManager.ts
function createNotifyManager() {
  let queue = [];
  let transactions = 0;
  let notifyFn = (callback) => {
    callback();
  };
  let batchNotifyFn = (callback) => {
    callback();
  };
  let scheduleFn = (cb) => setTimeout(cb, 0);
  const schedule = (callback) => {
    if (transactions) {
      queue.push(callback);
    } else {
      scheduleFn(() => {
        notifyFn(callback);
      });
    }
  };
  const flush = () => {
    const originalQueue = queue;
    queue = [];
    if (originalQueue.length) {
      scheduleFn(() => {
        batchNotifyFn(() => {
          originalQueue.forEach((callback) => {
            notifyFn(callback);
          });
        });
      });
    }
  };
  return {
    batch: (callback) => {
      let result;
      transactions++;
      try {
        result = callback();
      } finally {
        transactions--;
        if (!transactions) {
          flush();
        }
      }
      return result;
    },
    /**
     * All calls to the wrapped function will be batched.
     */
    batchCalls: (callback) => {
      return (...args) => {
        schedule(() => {
          callback(...args);
        });
      };
    },
    schedule,
    /**
     * Use this method to set a custom notify function.
     * This can be used to for example wrap notifications with `React.act` while running tests.
     */
    setNotifyFunction: (fn) => {
      notifyFn = fn;
    },
    /**
     * Use this method to set a custom function to batch notifications together into a single tick.
     * By default React Query will use the batch function provided by ReactDOM or React Native.
     */
    setBatchNotifyFunction: (fn) => {
      batchNotifyFn = fn;
    },
    setScheduler: (fn) => {
      scheduleFn = fn;
    }
  };
}
var notifyManager = createNotifyManager();

//# sourceMappingURL=notifyManager.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/onlineManager.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/onlineManager.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   OnlineManager: () => (/* binding */ OnlineManager),
/* harmony export */   onlineManager: () => (/* binding */ onlineManager)
/* harmony export */ });
/* harmony import */ var _subscribable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./subscribable.js */ "./node_modules/@tanstack/query-core/build/modern/subscribable.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/onlineManager.ts


var OnlineManager = class extends _subscribable_js__WEBPACK_IMPORTED_MODULE_0__.Subscribable {
  #online = true;
  #cleanup;
  #setup;
  constructor() {
    super();
    this.#setup = (onOnline) => {
      if (!_utils_js__WEBPACK_IMPORTED_MODULE_1__.isServer && window.addEventListener) {
        const onlineListener = () => onOnline(true);
        const offlineListener = () => onOnline(false);
        window.addEventListener("online", onlineListener, false);
        window.addEventListener("offline", offlineListener, false);
        return () => {
          window.removeEventListener("online", onlineListener);
          window.removeEventListener("offline", offlineListener);
        };
      }
      return;
    };
  }
  onSubscribe() {
    if (!this.#cleanup) {
      this.setEventListener(this.#setup);
    }
  }
  onUnsubscribe() {
    if (!this.hasListeners()) {
      this.#cleanup?.();
      this.#cleanup = void 0;
    }
  }
  setEventListener(setup) {
    this.#setup = setup;
    this.#cleanup?.();
    this.#cleanup = setup(this.setOnline.bind(this));
  }
  setOnline(online) {
    const changed = this.#online !== online;
    if (changed) {
      this.#online = online;
      this.listeners.forEach((listener) => {
        listener(online);
      });
    }
  }
  isOnline() {
    return this.#online;
  }
};
var onlineManager = new OnlineManager();

//# sourceMappingURL=onlineManager.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/query.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/query.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Query: () => (/* binding */ Query),
/* harmony export */   fetchState: () => (/* binding */ fetchState)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _retryer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./retryer.js */ "./node_modules/@tanstack/query-core/build/modern/retryer.js");
/* harmony import */ var _removable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./removable.js */ "./node_modules/@tanstack/query-core/build/modern/removable.js");
// src/query.ts




var Query = class extends _removable_js__WEBPACK_IMPORTED_MODULE_0__.Removable {
  #initialState;
  #revertState;
  #cache;
  #retryer;
  #defaultOptions;
  #abortSignalConsumed;
  constructor(config) {
    super();
    this.#abortSignalConsumed = false;
    this.#defaultOptions = config.defaultOptions;
    this.setOptions(config.options);
    this.observers = [];
    this.#cache = config.cache;
    this.queryKey = config.queryKey;
    this.queryHash = config.queryHash;
    this.#initialState = getDefaultState(this.options);
    this.state = config.state ?? this.#initialState;
    this.scheduleGc();
  }
  get meta() {
    return this.options.meta;
  }
  get promise() {
    return this.#retryer?.promise;
  }
  setOptions(options) {
    this.options = { ...this.#defaultOptions, ...options };
    this.updateGcTime(this.options.gcTime);
  }
  optionalRemove() {
    if (!this.observers.length && this.state.fetchStatus === "idle") {
      this.#cache.remove(this);
    }
  }
  setData(newData, options) {
    const data = (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.replaceData)(this.state.data, newData, this.options);
    this.#dispatch({
      data,
      type: "success",
      dataUpdatedAt: options?.updatedAt,
      manual: options?.manual
    });
    return data;
  }
  setState(state, setStateOptions) {
    this.#dispatch({ type: "setState", state, setStateOptions });
  }
  cancel(options) {
    const promise = this.#retryer?.promise;
    this.#retryer?.cancel(options);
    return promise ? promise.then(_utils_js__WEBPACK_IMPORTED_MODULE_1__.noop).catch(_utils_js__WEBPACK_IMPORTED_MODULE_1__.noop) : Promise.resolve();
  }
  destroy() {
    super.destroy();
    this.cancel({ silent: true });
  }
  reset() {
    this.destroy();
    this.setState(this.#initialState);
  }
  isActive() {
    return this.observers.some(
      (observer) => (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.resolveEnabled)(observer.options.enabled, this) !== false
    );
  }
  isDisabled() {
    if (this.getObserversCount() > 0) {
      return !this.isActive();
    }
    return this.options.queryFn === _utils_js__WEBPACK_IMPORTED_MODULE_1__.skipToken || this.state.dataUpdateCount + this.state.errorUpdateCount === 0;
  }
  isStale() {
    if (this.state.isInvalidated) {
      return true;
    }
    if (this.getObserversCount() > 0) {
      return this.observers.some(
        (observer) => observer.getCurrentResult().isStale
      );
    }
    return this.state.data === void 0;
  }
  isStaleByTime(staleTime = 0) {
    return this.state.isInvalidated || this.state.data === void 0 || !(0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.timeUntilStale)(this.state.dataUpdatedAt, staleTime);
  }
  onFocus() {
    const observer = this.observers.find((x) => x.shouldFetchOnWindowFocus());
    observer?.refetch({ cancelRefetch: false });
    this.#retryer?.continue();
  }
  onOnline() {
    const observer = this.observers.find((x) => x.shouldFetchOnReconnect());
    observer?.refetch({ cancelRefetch: false });
    this.#retryer?.continue();
  }
  addObserver(observer) {
    if (!this.observers.includes(observer)) {
      this.observers.push(observer);
      this.clearGcTimeout();
      this.#cache.notify({ type: "observerAdded", query: this, observer });
    }
  }
  removeObserver(observer) {
    if (this.observers.includes(observer)) {
      this.observers = this.observers.filter((x) => x !== observer);
      if (!this.observers.length) {
        if (this.#retryer) {
          if (this.#abortSignalConsumed) {
            this.#retryer.cancel({ revert: true });
          } else {
            this.#retryer.cancelRetry();
          }
        }
        this.scheduleGc();
      }
      this.#cache.notify({ type: "observerRemoved", query: this, observer });
    }
  }
  getObserversCount() {
    return this.observers.length;
  }
  invalidate() {
    if (!this.state.isInvalidated) {
      this.#dispatch({ type: "invalidate" });
    }
  }
  fetch(options, fetchOptions) {
    if (this.state.fetchStatus !== "idle") {
      if (this.state.data !== void 0 && fetchOptions?.cancelRefetch) {
        this.cancel({ silent: true });
      } else if (this.#retryer) {
        this.#retryer.continueRetry();
        return this.#retryer.promise;
      }
    }
    if (options) {
      this.setOptions(options);
    }
    if (!this.options.queryFn) {
      const observer = this.observers.find((x) => x.options.queryFn);
      if (observer) {
        this.setOptions(observer.options);
      }
    }
    if (true) {
      if (!Array.isArray(this.options.queryKey)) {
        console.error(
          `As of v4, queryKey needs to be an Array. If you are using a string like 'repoData', please change it to an Array, e.g. ['repoData']`
        );
      }
    }
    const abortController = new AbortController();
    const addSignalProperty = (object) => {
      Object.defineProperty(object, "signal", {
        enumerable: true,
        get: () => {
          this.#abortSignalConsumed = true;
          return abortController.signal;
        }
      });
    };
    const fetchFn = () => {
      const queryFn = (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.ensureQueryFn)(this.options, fetchOptions);
      const queryFnContext = {
        queryKey: this.queryKey,
        meta: this.meta
      };
      addSignalProperty(queryFnContext);
      this.#abortSignalConsumed = false;
      if (this.options.persister) {
        return this.options.persister(
          queryFn,
          queryFnContext,
          this
        );
      }
      return queryFn(queryFnContext);
    };
    const context = {
      fetchOptions,
      options: this.options,
      queryKey: this.queryKey,
      state: this.state,
      fetchFn
    };
    addSignalProperty(context);
    this.options.behavior?.onFetch(
      context,
      this
    );
    this.#revertState = this.state;
    if (this.state.fetchStatus === "idle" || this.state.fetchMeta !== context.fetchOptions?.meta) {
      this.#dispatch({ type: "fetch", meta: context.fetchOptions?.meta });
    }
    const onError = (error) => {
      if (!((0,_retryer_js__WEBPACK_IMPORTED_MODULE_2__.isCancelledError)(error) && error.silent)) {
        this.#dispatch({
          type: "error",
          error
        });
      }
      if (!(0,_retryer_js__WEBPACK_IMPORTED_MODULE_2__.isCancelledError)(error)) {
        this.#cache.config.onError?.(
          error,
          this
        );
        this.#cache.config.onSettled?.(
          this.state.data,
          error,
          this
        );
      }
      this.scheduleGc();
    };
    this.#retryer = (0,_retryer_js__WEBPACK_IMPORTED_MODULE_2__.createRetryer)({
      initialPromise: fetchOptions?.initialPromise,
      fn: context.fetchFn,
      abort: abortController.abort.bind(abortController),
      onSuccess: (data) => {
        if (data === void 0) {
          if (true) {
            console.error(
              `Query data cannot be undefined. Please make sure to return a value other than undefined from your query function. Affected query key: ${this.queryHash}`
            );
          }
          onError(new Error(`${this.queryHash} data is undefined`));
          return;
        }
        try {
          this.setData(data);
        } catch (error) {
          onError(error);
          return;
        }
        this.#cache.config.onSuccess?.(data, this);
        this.#cache.config.onSettled?.(
          data,
          this.state.error,
          this
        );
        this.scheduleGc();
      },
      onError,
      onFail: (failureCount, error) => {
        this.#dispatch({ type: "failed", failureCount, error });
      },
      onPause: () => {
        this.#dispatch({ type: "pause" });
      },
      onContinue: () => {
        this.#dispatch({ type: "continue" });
      },
      retry: context.options.retry,
      retryDelay: context.options.retryDelay,
      networkMode: context.options.networkMode,
      canRun: () => true
    });
    return this.#retryer.start();
  }
  #dispatch(action) {
    const reducer = (state) => {
      switch (action.type) {
        case "failed":
          return {
            ...state,
            fetchFailureCount: action.failureCount,
            fetchFailureReason: action.error
          };
        case "pause":
          return {
            ...state,
            fetchStatus: "paused"
          };
        case "continue":
          return {
            ...state,
            fetchStatus: "fetching"
          };
        case "fetch":
          return {
            ...state,
            ...fetchState(state.data, this.options),
            fetchMeta: action.meta ?? null
          };
        case "success":
          return {
            ...state,
            data: action.data,
            dataUpdateCount: state.dataUpdateCount + 1,
            dataUpdatedAt: action.dataUpdatedAt ?? Date.now(),
            error: null,
            isInvalidated: false,
            status: "success",
            ...!action.manual && {
              fetchStatus: "idle",
              fetchFailureCount: 0,
              fetchFailureReason: null
            }
          };
        case "error":
          const error = action.error;
          if ((0,_retryer_js__WEBPACK_IMPORTED_MODULE_2__.isCancelledError)(error) && error.revert && this.#revertState) {
            return { ...this.#revertState, fetchStatus: "idle" };
          }
          return {
            ...state,
            error,
            errorUpdateCount: state.errorUpdateCount + 1,
            errorUpdatedAt: Date.now(),
            fetchFailureCount: state.fetchFailureCount + 1,
            fetchFailureReason: error,
            fetchStatus: "idle",
            status: "error"
          };
        case "invalidate":
          return {
            ...state,
            isInvalidated: true
          };
        case "setState":
          return {
            ...state,
            ...action.state
          };
      }
    };
    this.state = reducer(this.state);
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batch(() => {
      this.observers.forEach((observer) => {
        observer.onQueryUpdate();
      });
      this.#cache.notify({ query: this, type: "updated", action });
    });
  }
};
function fetchState(data, options) {
  return {
    fetchFailureCount: 0,
    fetchFailureReason: null,
    fetchStatus: (0,_retryer_js__WEBPACK_IMPORTED_MODULE_2__.canFetch)(options.networkMode) ? "fetching" : "paused",
    ...data === void 0 && {
      error: null,
      status: "pending"
    }
  };
}
function getDefaultState(options) {
  const data = typeof options.initialData === "function" ? options.initialData() : options.initialData;
  const hasData = data !== void 0;
  const initialDataUpdatedAt = hasData ? typeof options.initialDataUpdatedAt === "function" ? options.initialDataUpdatedAt() : options.initialDataUpdatedAt : 0;
  return {
    data,
    dataUpdateCount: 0,
    dataUpdatedAt: hasData ? initialDataUpdatedAt ?? Date.now() : 0,
    error: null,
    errorUpdateCount: 0,
    errorUpdatedAt: 0,
    fetchFailureCount: 0,
    fetchFailureReason: null,
    fetchMeta: null,
    isInvalidated: false,
    status: hasData ? "success" : "pending",
    fetchStatus: "idle"
  };
}

//# sourceMappingURL=query.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/queryCache.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/queryCache.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   QueryCache: () => (/* binding */ QueryCache)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
/* harmony import */ var _query_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./query.js */ "./node_modules/@tanstack/query-core/build/modern/query.js");
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _subscribable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./subscribable.js */ "./node_modules/@tanstack/query-core/build/modern/subscribable.js");
// src/queryCache.ts




var QueryCache = class extends _subscribable_js__WEBPACK_IMPORTED_MODULE_0__.Subscribable {
  constructor(config = {}) {
    super();
    this.config = config;
    this.#queries = /* @__PURE__ */ new Map();
  }
  #queries;
  build(client, options, state) {
    const queryKey = options.queryKey;
    const queryHash = options.queryHash ?? (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.hashQueryKeyByOptions)(queryKey, options);
    let query = this.get(queryHash);
    if (!query) {
      query = new _query_js__WEBPACK_IMPORTED_MODULE_2__.Query({
        cache: this,
        queryKey,
        queryHash,
        options: client.defaultQueryOptions(options),
        state,
        defaultOptions: client.getQueryDefaults(queryKey)
      });
      this.add(query);
    }
    return query;
  }
  add(query) {
    if (!this.#queries.has(query.queryHash)) {
      this.#queries.set(query.queryHash, query);
      this.notify({
        type: "added",
        query
      });
    }
  }
  remove(query) {
    const queryInMap = this.#queries.get(query.queryHash);
    if (queryInMap) {
      query.destroy();
      if (queryInMap === query) {
        this.#queries.delete(query.queryHash);
      }
      this.notify({ type: "removed", query });
    }
  }
  clear() {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batch(() => {
      this.getAll().forEach((query) => {
        this.remove(query);
      });
    });
  }
  get(queryHash) {
    return this.#queries.get(queryHash);
  }
  getAll() {
    return [...this.#queries.values()];
  }
  find(filters) {
    const defaultedFilters = { exact: true, ...filters };
    return this.getAll().find(
      (query) => (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.matchQuery)(defaultedFilters, query)
    );
  }
  findAll(filters = {}) {
    const queries = this.getAll();
    return Object.keys(filters).length > 0 ? queries.filter((query) => (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.matchQuery)(filters, query)) : queries;
  }
  notify(event) {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batch(() => {
      this.listeners.forEach((listener) => {
        listener(event);
      });
    });
  }
  onFocus() {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batch(() => {
      this.getAll().forEach((query) => {
        query.onFocus();
      });
    });
  }
  onOnline() {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batch(() => {
      this.getAll().forEach((query) => {
        query.onOnline();
      });
    });
  }
};

//# sourceMappingURL=queryCache.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/queryClient.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/queryClient.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   QueryClient: () => (/* binding */ QueryClient)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
/* harmony import */ var _queryCache_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./queryCache.js */ "./node_modules/@tanstack/query-core/build/modern/queryCache.js");
/* harmony import */ var _mutationCache_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./mutationCache.js */ "./node_modules/@tanstack/query-core/build/modern/mutationCache.js");
/* harmony import */ var _focusManager_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./focusManager.js */ "./node_modules/@tanstack/query-core/build/modern/focusManager.js");
/* harmony import */ var _onlineManager_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./onlineManager.js */ "./node_modules/@tanstack/query-core/build/modern/onlineManager.js");
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _infiniteQueryBehavior_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./infiniteQueryBehavior.js */ "./node_modules/@tanstack/query-core/build/modern/infiniteQueryBehavior.js");
// src/queryClient.ts







var QueryClient = class {
  #queryCache;
  #mutationCache;
  #defaultOptions;
  #queryDefaults;
  #mutationDefaults;
  #mountCount;
  #unsubscribeFocus;
  #unsubscribeOnline;
  constructor(config = {}) {
    this.#queryCache = config.queryCache || new _queryCache_js__WEBPACK_IMPORTED_MODULE_0__.QueryCache();
    this.#mutationCache = config.mutationCache || new _mutationCache_js__WEBPACK_IMPORTED_MODULE_1__.MutationCache();
    this.#defaultOptions = config.defaultOptions || {};
    this.#queryDefaults = /* @__PURE__ */ new Map();
    this.#mutationDefaults = /* @__PURE__ */ new Map();
    this.#mountCount = 0;
  }
  mount() {
    this.#mountCount++;
    if (this.#mountCount !== 1)
      return;
    this.#unsubscribeFocus = _focusManager_js__WEBPACK_IMPORTED_MODULE_2__.focusManager.subscribe(async (focused) => {
      if (focused) {
        await this.resumePausedMutations();
        this.#queryCache.onFocus();
      }
    });
    this.#unsubscribeOnline = _onlineManager_js__WEBPACK_IMPORTED_MODULE_3__.onlineManager.subscribe(async (online) => {
      if (online) {
        await this.resumePausedMutations();
        this.#queryCache.onOnline();
      }
    });
  }
  unmount() {
    this.#mountCount--;
    if (this.#mountCount !== 0)
      return;
    this.#unsubscribeFocus?.();
    this.#unsubscribeFocus = void 0;
    this.#unsubscribeOnline?.();
    this.#unsubscribeOnline = void 0;
  }
  isFetching(filters) {
    return this.#queryCache.findAll({ ...filters, fetchStatus: "fetching" }).length;
  }
  isMutating(filters) {
    return this.#mutationCache.findAll({ ...filters, status: "pending" }).length;
  }
  getQueryData(queryKey) {
    const options = this.defaultQueryOptions({ queryKey });
    return this.#queryCache.get(options.queryHash)?.state.data;
  }
  ensureQueryData(options) {
    const defaultedOptions = this.defaultQueryOptions(options);
    const query = this.#queryCache.build(this, defaultedOptions);
    const cachedData = query.state.data;
    if (cachedData === void 0) {
      return this.fetchQuery(options);
    }
    if (options.revalidateIfStale && query.isStaleByTime((0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.resolveStaleTime)(defaultedOptions.staleTime, query))) {
      void this.prefetchQuery(defaultedOptions);
    }
    return Promise.resolve(cachedData);
  }
  getQueriesData(filters) {
    return this.#queryCache.findAll(filters).map(({ queryKey, state }) => {
      const data = state.data;
      return [queryKey, data];
    });
  }
  setQueryData(queryKey, updater, options) {
    const defaultedOptions = this.defaultQueryOptions({ queryKey });
    const query = this.#queryCache.get(
      defaultedOptions.queryHash
    );
    const prevData = query?.state.data;
    const data = (0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.functionalUpdate)(updater, prevData);
    if (data === void 0) {
      return void 0;
    }
    return this.#queryCache.build(this, defaultedOptions).setData(data, { ...options, manual: true });
  }
  setQueriesData(filters, updater, options) {
    return _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(
      () => this.#queryCache.findAll(filters).map(({ queryKey }) => [
        queryKey,
        this.setQueryData(queryKey, updater, options)
      ])
    );
  }
  getQueryState(queryKey) {
    const options = this.defaultQueryOptions({ queryKey });
    return this.#queryCache.get(
      options.queryHash
    )?.state;
  }
  removeQueries(filters) {
    const queryCache = this.#queryCache;
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(() => {
      queryCache.findAll(filters).forEach((query) => {
        queryCache.remove(query);
      });
    });
  }
  resetQueries(filters, options) {
    const queryCache = this.#queryCache;
    const refetchFilters = {
      type: "active",
      ...filters
    };
    return _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(() => {
      queryCache.findAll(filters).forEach((query) => {
        query.reset();
      });
      return this.refetchQueries(refetchFilters, options);
    });
  }
  cancelQueries(filters, cancelOptions = {}) {
    const defaultedCancelOptions = { revert: true, ...cancelOptions };
    const promises = _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(
      () => this.#queryCache.findAll(filters).map((query) => query.cancel(defaultedCancelOptions))
    );
    return Promise.all(promises).then(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop).catch(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop);
  }
  invalidateQueries(filters, options = {}) {
    return _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(() => {
      this.#queryCache.findAll(filters).forEach((query) => {
        query.invalidate();
      });
      if (filters?.refetchType === "none") {
        return Promise.resolve();
      }
      const refetchFilters = {
        ...filters,
        type: filters?.refetchType ?? filters?.type ?? "active"
      };
      return this.refetchQueries(refetchFilters, options);
    });
  }
  refetchQueries(filters, options = {}) {
    const fetchOptions = {
      ...options,
      cancelRefetch: options.cancelRefetch ?? true
    };
    const promises = _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(
      () => this.#queryCache.findAll(filters).filter((query) => !query.isDisabled()).map((query) => {
        let promise = query.fetch(void 0, fetchOptions);
        if (!fetchOptions.throwOnError) {
          promise = promise.catch(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop);
        }
        return query.state.fetchStatus === "paused" ? Promise.resolve() : promise;
      })
    );
    return Promise.all(promises).then(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop);
  }
  fetchQuery(options) {
    const defaultedOptions = this.defaultQueryOptions(options);
    if (defaultedOptions.retry === void 0) {
      defaultedOptions.retry = false;
    }
    const query = this.#queryCache.build(this, defaultedOptions);
    return query.isStaleByTime(
      (0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.resolveStaleTime)(defaultedOptions.staleTime, query)
    ) ? query.fetch(defaultedOptions) : Promise.resolve(query.state.data);
  }
  prefetchQuery(options) {
    return this.fetchQuery(options).then(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop).catch(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop);
  }
  fetchInfiniteQuery(options) {
    options.behavior = (0,_infiniteQueryBehavior_js__WEBPACK_IMPORTED_MODULE_6__.infiniteQueryBehavior)(options.pages);
    return this.fetchQuery(options);
  }
  prefetchInfiniteQuery(options) {
    return this.fetchInfiniteQuery(options).then(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop).catch(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop);
  }
  ensureInfiniteQueryData(options) {
    options.behavior = (0,_infiniteQueryBehavior_js__WEBPACK_IMPORTED_MODULE_6__.infiniteQueryBehavior)(options.pages);
    return this.ensureQueryData(options);
  }
  resumePausedMutations() {
    if (_onlineManager_js__WEBPACK_IMPORTED_MODULE_3__.onlineManager.isOnline()) {
      return this.#mutationCache.resumePausedMutations();
    }
    return Promise.resolve();
  }
  getQueryCache() {
    return this.#queryCache;
  }
  getMutationCache() {
    return this.#mutationCache;
  }
  getDefaultOptions() {
    return this.#defaultOptions;
  }
  setDefaultOptions(options) {
    this.#defaultOptions = options;
  }
  setQueryDefaults(queryKey, options) {
    this.#queryDefaults.set((0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.hashKey)(queryKey), {
      queryKey,
      defaultOptions: options
    });
  }
  getQueryDefaults(queryKey) {
    const defaults = [...this.#queryDefaults.values()];
    const result = {};
    defaults.forEach((queryDefault) => {
      if ((0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.partialMatchKey)(queryKey, queryDefault.queryKey)) {
        Object.assign(result, queryDefault.defaultOptions);
      }
    });
    return result;
  }
  setMutationDefaults(mutationKey, options) {
    this.#mutationDefaults.set((0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.hashKey)(mutationKey), {
      mutationKey,
      defaultOptions: options
    });
  }
  getMutationDefaults(mutationKey) {
    const defaults = [...this.#mutationDefaults.values()];
    let result = {};
    defaults.forEach((queryDefault) => {
      if ((0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.partialMatchKey)(mutationKey, queryDefault.mutationKey)) {
        result = { ...result, ...queryDefault.defaultOptions };
      }
    });
    return result;
  }
  defaultQueryOptions(options) {
    if (options._defaulted) {
      return options;
    }
    const defaultedOptions = {
      ...this.#defaultOptions.queries,
      ...this.getQueryDefaults(options.queryKey),
      ...options,
      _defaulted: true
    };
    if (!defaultedOptions.queryHash) {
      defaultedOptions.queryHash = (0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.hashQueryKeyByOptions)(
        defaultedOptions.queryKey,
        defaultedOptions
      );
    }
    if (defaultedOptions.refetchOnReconnect === void 0) {
      defaultedOptions.refetchOnReconnect = defaultedOptions.networkMode !== "always";
    }
    if (defaultedOptions.throwOnError === void 0) {
      defaultedOptions.throwOnError = !!defaultedOptions.suspense;
    }
    if (!defaultedOptions.networkMode && defaultedOptions.persister) {
      defaultedOptions.networkMode = "offlineFirst";
    }
    if (defaultedOptions.queryFn === _utils_js__WEBPACK_IMPORTED_MODULE_4__.skipToken) {
      defaultedOptions.enabled = false;
    }
    return defaultedOptions;
  }
  defaultMutationOptions(options) {
    if (options?._defaulted) {
      return options;
    }
    return {
      ...this.#defaultOptions.mutations,
      ...options?.mutationKey && this.getMutationDefaults(options.mutationKey),
      ...options,
      _defaulted: true
    };
  }
  clear() {
    this.#queryCache.clear();
    this.#mutationCache.clear();
  }
};

//# sourceMappingURL=queryClient.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/queryObserver.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/queryObserver.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   QueryObserver: () => (/* binding */ QueryObserver)
/* harmony export */ });
/* harmony import */ var _focusManager_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./focusManager.js */ "./node_modules/@tanstack/query-core/build/modern/focusManager.js");
/* harmony import */ var _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./notifyManager.js */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _query_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./query.js */ "./node_modules/@tanstack/query-core/build/modern/query.js");
/* harmony import */ var _subscribable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./subscribable.js */ "./node_modules/@tanstack/query-core/build/modern/subscribable.js");
/* harmony import */ var _thenable_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./thenable.js */ "./node_modules/@tanstack/query-core/build/modern/thenable.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/queryObserver.ts






var QueryObserver = class extends _subscribable_js__WEBPACK_IMPORTED_MODULE_0__.Subscribable {
  constructor(client, options) {
    super();
    this.options = options;
    this.#client = client;
    this.#selectError = null;
    this.#currentThenable = (0,_thenable_js__WEBPACK_IMPORTED_MODULE_1__.pendingThenable)();
    if (!this.options.experimental_prefetchInRender) {
      this.#currentThenable.reject(
        new Error("experimental_prefetchInRender feature flag is not enabled")
      );
    }
    this.bindMethods();
    this.setOptions(options);
  }
  #client;
  #currentQuery = void 0;
  #currentQueryInitialState = void 0;
  #currentResult = void 0;
  #currentResultState;
  #currentResultOptions;
  #currentThenable;
  #selectError;
  #selectFn;
  #selectResult;
  // This property keeps track of the last query with defined data.
  // It will be used to pass the previous data and query to the placeholder function between renders.
  #lastQueryWithDefinedData;
  #staleTimeoutId;
  #refetchIntervalId;
  #currentRefetchInterval;
  #trackedProps = /* @__PURE__ */ new Set();
  bindMethods() {
    this.refetch = this.refetch.bind(this);
  }
  onSubscribe() {
    if (this.listeners.size === 1) {
      this.#currentQuery.addObserver(this);
      if (shouldFetchOnMount(this.#currentQuery, this.options)) {
        this.#executeFetch();
      } else {
        this.updateResult();
      }
      this.#updateTimers();
    }
  }
  onUnsubscribe() {
    if (!this.hasListeners()) {
      this.destroy();
    }
  }
  shouldFetchOnReconnect() {
    return shouldFetchOn(
      this.#currentQuery,
      this.options,
      this.options.refetchOnReconnect
    );
  }
  shouldFetchOnWindowFocus() {
    return shouldFetchOn(
      this.#currentQuery,
      this.options,
      this.options.refetchOnWindowFocus
    );
  }
  destroy() {
    this.listeners = /* @__PURE__ */ new Set();
    this.#clearStaleTimeout();
    this.#clearRefetchInterval();
    this.#currentQuery.removeObserver(this);
  }
  setOptions(options, notifyOptions) {
    const prevOptions = this.options;
    const prevQuery = this.#currentQuery;
    this.options = this.#client.defaultQueryOptions(options);
    if (this.options.enabled !== void 0 && typeof this.options.enabled !== "boolean" && typeof this.options.enabled !== "function" && typeof (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(this.options.enabled, this.#currentQuery) !== "boolean") {
      throw new Error(
        "Expected enabled to be a boolean or a callback that returns a boolean"
      );
    }
    this.#updateQuery();
    this.#currentQuery.setOptions(this.options);
    if (prevOptions._defaulted && !(0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.shallowEqualObjects)(this.options, prevOptions)) {
      this.#client.getQueryCache().notify({
        type: "observerOptionsUpdated",
        query: this.#currentQuery,
        observer: this
      });
    }
    const mounted = this.hasListeners();
    if (mounted && shouldFetchOptionally(
      this.#currentQuery,
      prevQuery,
      this.options,
      prevOptions
    )) {
      this.#executeFetch();
    }
    this.updateResult(notifyOptions);
    if (mounted && (this.#currentQuery !== prevQuery || (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(this.options.enabled, this.#currentQuery) !== (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(prevOptions.enabled, this.#currentQuery) || (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveStaleTime)(this.options.staleTime, this.#currentQuery) !== (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveStaleTime)(prevOptions.staleTime, this.#currentQuery))) {
      this.#updateStaleTimeout();
    }
    const nextRefetchInterval = this.#computeRefetchInterval();
    if (mounted && (this.#currentQuery !== prevQuery || (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(this.options.enabled, this.#currentQuery) !== (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(prevOptions.enabled, this.#currentQuery) || nextRefetchInterval !== this.#currentRefetchInterval)) {
      this.#updateRefetchInterval(nextRefetchInterval);
    }
  }
  getOptimisticResult(options) {
    const query = this.#client.getQueryCache().build(this.#client, options);
    const result = this.createResult(query, options);
    if (shouldAssignObserverCurrentProperties(this, result)) {
      this.#currentResult = result;
      this.#currentResultOptions = this.options;
      this.#currentResultState = this.#currentQuery.state;
    }
    return result;
  }
  getCurrentResult() {
    return this.#currentResult;
  }
  trackResult(result, onPropTracked) {
    const trackedResult = {};
    Object.keys(result).forEach((key) => {
      Object.defineProperty(trackedResult, key, {
        configurable: false,
        enumerable: true,
        get: () => {
          this.trackProp(key);
          onPropTracked?.(key);
          return result[key];
        }
      });
    });
    return trackedResult;
  }
  trackProp(key) {
    this.#trackedProps.add(key);
  }
  getCurrentQuery() {
    return this.#currentQuery;
  }
  refetch({ ...options } = {}) {
    return this.fetch({
      ...options
    });
  }
  fetchOptimistic(options) {
    const defaultedOptions = this.#client.defaultQueryOptions(options);
    const query = this.#client.getQueryCache().build(this.#client, defaultedOptions);
    return query.fetch().then(() => this.createResult(query, defaultedOptions));
  }
  fetch(fetchOptions) {
    return this.#executeFetch({
      ...fetchOptions,
      cancelRefetch: fetchOptions.cancelRefetch ?? true
    }).then(() => {
      this.updateResult();
      return this.#currentResult;
    });
  }
  #executeFetch(fetchOptions) {
    this.#updateQuery();
    let promise = this.#currentQuery.fetch(
      this.options,
      fetchOptions
    );
    if (!fetchOptions?.throwOnError) {
      promise = promise.catch(_utils_js__WEBPACK_IMPORTED_MODULE_2__.noop);
    }
    return promise;
  }
  #updateStaleTimeout() {
    this.#clearStaleTimeout();
    const staleTime = (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveStaleTime)(
      this.options.staleTime,
      this.#currentQuery
    );
    if (_utils_js__WEBPACK_IMPORTED_MODULE_2__.isServer || this.#currentResult.isStale || !(0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.isValidTimeout)(staleTime)) {
      return;
    }
    const time = (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.timeUntilStale)(this.#currentResult.dataUpdatedAt, staleTime);
    const timeout = time + 1;
    this.#staleTimeoutId = setTimeout(() => {
      if (!this.#currentResult.isStale) {
        this.updateResult();
      }
    }, timeout);
  }
  #computeRefetchInterval() {
    return (typeof this.options.refetchInterval === "function" ? this.options.refetchInterval(this.#currentQuery) : this.options.refetchInterval) ?? false;
  }
  #updateRefetchInterval(nextInterval) {
    this.#clearRefetchInterval();
    this.#currentRefetchInterval = nextInterval;
    if (_utils_js__WEBPACK_IMPORTED_MODULE_2__.isServer || (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(this.options.enabled, this.#currentQuery) === false || !(0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.isValidTimeout)(this.#currentRefetchInterval) || this.#currentRefetchInterval === 0) {
      return;
    }
    this.#refetchIntervalId = setInterval(() => {
      if (this.options.refetchIntervalInBackground || _focusManager_js__WEBPACK_IMPORTED_MODULE_3__.focusManager.isFocused()) {
        this.#executeFetch();
      }
    }, this.#currentRefetchInterval);
  }
  #updateTimers() {
    this.#updateStaleTimeout();
    this.#updateRefetchInterval(this.#computeRefetchInterval());
  }
  #clearStaleTimeout() {
    if (this.#staleTimeoutId) {
      clearTimeout(this.#staleTimeoutId);
      this.#staleTimeoutId = void 0;
    }
  }
  #clearRefetchInterval() {
    if (this.#refetchIntervalId) {
      clearInterval(this.#refetchIntervalId);
      this.#refetchIntervalId = void 0;
    }
  }
  createResult(query, options) {
    const prevQuery = this.#currentQuery;
    const prevOptions = this.options;
    const prevResult = this.#currentResult;
    const prevResultState = this.#currentResultState;
    const prevResultOptions = this.#currentResultOptions;
    const queryChange = query !== prevQuery;
    const queryInitialState = queryChange ? query.state : this.#currentQueryInitialState;
    const { state } = query;
    let newState = { ...state };
    let isPlaceholderData = false;
    let data;
    if (options._optimisticResults) {
      const mounted = this.hasListeners();
      const fetchOnMount = !mounted && shouldFetchOnMount(query, options);
      const fetchOptionally = mounted && shouldFetchOptionally(query, prevQuery, options, prevOptions);
      if (fetchOnMount || fetchOptionally) {
        newState = {
          ...newState,
          ...(0,_query_js__WEBPACK_IMPORTED_MODULE_4__.fetchState)(state.data, query.options)
        };
      }
      if (options._optimisticResults === "isRestoring") {
        newState.fetchStatus = "idle";
      }
    }
    let { error, errorUpdatedAt, status } = newState;
    if (options.select && newState.data !== void 0) {
      if (prevResult && newState.data === prevResultState?.data && options.select === this.#selectFn) {
        data = this.#selectResult;
      } else {
        try {
          this.#selectFn = options.select;
          data = options.select(newState.data);
          data = (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.replaceData)(prevResult?.data, data, options);
          this.#selectResult = data;
          this.#selectError = null;
        } catch (selectError) {
          this.#selectError = selectError;
        }
      }
    } else {
      data = newState.data;
    }
    if (options.placeholderData !== void 0 && data === void 0 && status === "pending") {
      let placeholderData;
      if (prevResult?.isPlaceholderData && options.placeholderData === prevResultOptions?.placeholderData) {
        placeholderData = prevResult.data;
      } else {
        placeholderData = typeof options.placeholderData === "function" ? options.placeholderData(
          this.#lastQueryWithDefinedData?.state.data,
          this.#lastQueryWithDefinedData
        ) : options.placeholderData;
        if (options.select && placeholderData !== void 0) {
          try {
            placeholderData = options.select(placeholderData);
            this.#selectError = null;
          } catch (selectError) {
            this.#selectError = selectError;
          }
        }
      }
      if (placeholderData !== void 0) {
        status = "success";
        data = (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.replaceData)(
          prevResult?.data,
          placeholderData,
          options
        );
        isPlaceholderData = true;
      }
    }
    if (this.#selectError) {
      error = this.#selectError;
      data = this.#selectResult;
      errorUpdatedAt = Date.now();
      status = "error";
    }
    const isFetching = newState.fetchStatus === "fetching";
    const isPending = status === "pending";
    const isError = status === "error";
    const isLoading = isPending && isFetching;
    const hasData = data !== void 0;
    const result = {
      status,
      fetchStatus: newState.fetchStatus,
      isPending,
      isSuccess: status === "success",
      isError,
      isInitialLoading: isLoading,
      isLoading,
      data,
      dataUpdatedAt: newState.dataUpdatedAt,
      error,
      errorUpdatedAt,
      failureCount: newState.fetchFailureCount,
      failureReason: newState.fetchFailureReason,
      errorUpdateCount: newState.errorUpdateCount,
      isFetched: newState.dataUpdateCount > 0 || newState.errorUpdateCount > 0,
      isFetchedAfterMount: newState.dataUpdateCount > queryInitialState.dataUpdateCount || newState.errorUpdateCount > queryInitialState.errorUpdateCount,
      isFetching,
      isRefetching: isFetching && !isPending,
      isLoadingError: isError && !hasData,
      isPaused: newState.fetchStatus === "paused",
      isPlaceholderData,
      isRefetchError: isError && hasData,
      isStale: isStale(query, options),
      refetch: this.refetch,
      promise: this.#currentThenable
    };
    const nextResult = result;
    if (this.options.experimental_prefetchInRender) {
      const finalizeThenableIfPossible = (thenable) => {
        if (nextResult.status === "error") {
          thenable.reject(nextResult.error);
        } else if (nextResult.data !== void 0) {
          thenable.resolve(nextResult.data);
        }
      };
      const recreateThenable = () => {
        const pending = this.#currentThenable = nextResult.promise = (0,_thenable_js__WEBPACK_IMPORTED_MODULE_1__.pendingThenable)();
        finalizeThenableIfPossible(pending);
      };
      const prevThenable = this.#currentThenable;
      switch (prevThenable.status) {
        case "pending":
          if (query.queryHash === prevQuery.queryHash) {
            finalizeThenableIfPossible(prevThenable);
          }
          break;
        case "fulfilled":
          if (nextResult.status === "error" || nextResult.data !== prevThenable.value) {
            recreateThenable();
          }
          break;
        case "rejected":
          if (nextResult.status !== "error" || nextResult.error !== prevThenable.reason) {
            recreateThenable();
          }
          break;
      }
    }
    return nextResult;
  }
  updateResult(notifyOptions) {
    const prevResult = this.#currentResult;
    const nextResult = this.createResult(this.#currentQuery, this.options);
    this.#currentResultState = this.#currentQuery.state;
    this.#currentResultOptions = this.options;
    if (this.#currentResultState.data !== void 0) {
      this.#lastQueryWithDefinedData = this.#currentQuery;
    }
    if ((0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.shallowEqualObjects)(nextResult, prevResult)) {
      return;
    }
    this.#currentResult = nextResult;
    const defaultNotifyOptions = {};
    const shouldNotifyListeners = () => {
      if (!prevResult) {
        return true;
      }
      const { notifyOnChangeProps } = this.options;
      const notifyOnChangePropsValue = typeof notifyOnChangeProps === "function" ? notifyOnChangeProps() : notifyOnChangeProps;
      if (notifyOnChangePropsValue === "all" || !notifyOnChangePropsValue && !this.#trackedProps.size) {
        return true;
      }
      const includedProps = new Set(
        notifyOnChangePropsValue ?? this.#trackedProps
      );
      if (this.options.throwOnError) {
        includedProps.add("error");
      }
      return Object.keys(this.#currentResult).some((key) => {
        const typedKey = key;
        const changed = this.#currentResult[typedKey] !== prevResult[typedKey];
        return changed && includedProps.has(typedKey);
      });
    };
    if (notifyOptions?.listeners !== false && shouldNotifyListeners()) {
      defaultNotifyOptions.listeners = true;
    }
    this.#notify({ ...defaultNotifyOptions, ...notifyOptions });
  }
  #updateQuery() {
    const query = this.#client.getQueryCache().build(this.#client, this.options);
    if (query === this.#currentQuery) {
      return;
    }
    const prevQuery = this.#currentQuery;
    this.#currentQuery = query;
    this.#currentQueryInitialState = query.state;
    if (this.hasListeners()) {
      prevQuery?.removeObserver(this);
      query.addObserver(this);
    }
  }
  onQueryUpdate() {
    this.updateResult();
    if (this.hasListeners()) {
      this.#updateTimers();
    }
  }
  #notify(notifyOptions) {
    _notifyManager_js__WEBPACK_IMPORTED_MODULE_5__.notifyManager.batch(() => {
      if (notifyOptions.listeners) {
        this.listeners.forEach((listener) => {
          listener(this.#currentResult);
        });
      }
      this.#client.getQueryCache().notify({
        query: this.#currentQuery,
        type: "observerResultsUpdated"
      });
    });
  }
};
function shouldLoadOnMount(query, options) {
  return (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(options.enabled, query) !== false && query.state.data === void 0 && !(query.state.status === "error" && options.retryOnMount === false);
}
function shouldFetchOnMount(query, options) {
  return shouldLoadOnMount(query, options) || query.state.data !== void 0 && shouldFetchOn(query, options, options.refetchOnMount);
}
function shouldFetchOn(query, options, field) {
  if ((0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(options.enabled, query) !== false) {
    const value = typeof field === "function" ? field(query) : field;
    return value === "always" || value !== false && isStale(query, options);
  }
  return false;
}
function shouldFetchOptionally(query, prevQuery, options, prevOptions) {
  return (query !== prevQuery || (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(prevOptions.enabled, query) === false) && (!options.suspense || query.state.status !== "error") && isStale(query, options);
}
function isStale(query, options) {
  return (0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveEnabled)(options.enabled, query) !== false && query.isStaleByTime((0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.resolveStaleTime)(options.staleTime, query));
}
function shouldAssignObserverCurrentProperties(observer, optimisticResult) {
  if (!(0,_utils_js__WEBPACK_IMPORTED_MODULE_2__.shallowEqualObjects)(observer.getCurrentResult(), optimisticResult)) {
    return true;
  }
  return false;
}

//# sourceMappingURL=queryObserver.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/removable.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/removable.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Removable: () => (/* binding */ Removable)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/removable.ts

var Removable = class {
  #gcTimeout;
  destroy() {
    this.clearGcTimeout();
  }
  scheduleGc() {
    this.clearGcTimeout();
    if ((0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.isValidTimeout)(this.gcTime)) {
      this.#gcTimeout = setTimeout(() => {
        this.optionalRemove();
      }, this.gcTime);
    }
  }
  updateGcTime(newGcTime) {
    this.gcTime = Math.max(
      this.gcTime || 0,
      newGcTime ?? (_utils_js__WEBPACK_IMPORTED_MODULE_0__.isServer ? Infinity : 5 * 60 * 1e3)
    );
  }
  clearGcTimeout() {
    if (this.#gcTimeout) {
      clearTimeout(this.#gcTimeout);
      this.#gcTimeout = void 0;
    }
  }
};

//# sourceMappingURL=removable.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/retryer.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/retryer.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   CancelledError: () => (/* binding */ CancelledError),
/* harmony export */   canFetch: () => (/* binding */ canFetch),
/* harmony export */   createRetryer: () => (/* binding */ createRetryer),
/* harmony export */   isCancelledError: () => (/* binding */ isCancelledError)
/* harmony export */ });
/* harmony import */ var _focusManager_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./focusManager.js */ "./node_modules/@tanstack/query-core/build/modern/focusManager.js");
/* harmony import */ var _onlineManager_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./onlineManager.js */ "./node_modules/@tanstack/query-core/build/modern/onlineManager.js");
/* harmony import */ var _thenable_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./thenable.js */ "./node_modules/@tanstack/query-core/build/modern/thenable.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
// src/retryer.ts




function defaultRetryDelay(failureCount) {
  return Math.min(1e3 * 2 ** failureCount, 3e4);
}
function canFetch(networkMode) {
  return (networkMode ?? "online") === "online" ? _onlineManager_js__WEBPACK_IMPORTED_MODULE_0__.onlineManager.isOnline() : true;
}
var CancelledError = class extends Error {
  constructor(options) {
    super("CancelledError");
    this.revert = options?.revert;
    this.silent = options?.silent;
  }
};
function isCancelledError(value) {
  return value instanceof CancelledError;
}
function createRetryer(config) {
  let isRetryCancelled = false;
  let failureCount = 0;
  let isResolved = false;
  let continueFn;
  const thenable = (0,_thenable_js__WEBPACK_IMPORTED_MODULE_1__.pendingThenable)();
  const cancel = (cancelOptions) => {
    if (!isResolved) {
      reject(new CancelledError(cancelOptions));
      config.abort?.();
    }
  };
  const cancelRetry = () => {
    isRetryCancelled = true;
  };
  const continueRetry = () => {
    isRetryCancelled = false;
  };
  const canContinue = () => _focusManager_js__WEBPACK_IMPORTED_MODULE_2__.focusManager.isFocused() && (config.networkMode === "always" || _onlineManager_js__WEBPACK_IMPORTED_MODULE_0__.onlineManager.isOnline()) && config.canRun();
  const canStart = () => canFetch(config.networkMode) && config.canRun();
  const resolve = (value) => {
    if (!isResolved) {
      isResolved = true;
      config.onSuccess?.(value);
      continueFn?.();
      thenable.resolve(value);
    }
  };
  const reject = (value) => {
    if (!isResolved) {
      isResolved = true;
      config.onError?.(value);
      continueFn?.();
      thenable.reject(value);
    }
  };
  const pause = () => {
    return new Promise((continueResolve) => {
      continueFn = (value) => {
        if (isResolved || canContinue()) {
          continueResolve(value);
        }
      };
      config.onPause?.();
    }).then(() => {
      continueFn = void 0;
      if (!isResolved) {
        config.onContinue?.();
      }
    });
  };
  const run = () => {
    if (isResolved) {
      return;
    }
    let promiseOrValue;
    const initialPromise = failureCount === 0 ? config.initialPromise : void 0;
    try {
      promiseOrValue = initialPromise ?? config.fn();
    } catch (error) {
      promiseOrValue = Promise.reject(error);
    }
    Promise.resolve(promiseOrValue).then(resolve).catch((error) => {
      if (isResolved) {
        return;
      }
      const retry = config.retry ?? (_utils_js__WEBPACK_IMPORTED_MODULE_3__.isServer ? 0 : 3);
      const retryDelay = config.retryDelay ?? defaultRetryDelay;
      const delay = typeof retryDelay === "function" ? retryDelay(failureCount, error) : retryDelay;
      const shouldRetry = retry === true || typeof retry === "number" && failureCount < retry || typeof retry === "function" && retry(failureCount, error);
      if (isRetryCancelled || !shouldRetry) {
        reject(error);
        return;
      }
      failureCount++;
      config.onFail?.(failureCount, error);
      (0,_utils_js__WEBPACK_IMPORTED_MODULE_3__.sleep)(delay).then(() => {
        return canContinue() ? void 0 : pause();
      }).then(() => {
        if (isRetryCancelled) {
          reject(error);
        } else {
          run();
        }
      });
    });
  };
  return {
    promise: thenable,
    cancel,
    continue: () => {
      continueFn?.();
      return thenable;
    },
    cancelRetry,
    continueRetry,
    canStart,
    start: () => {
      if (canStart()) {
        run();
      } else {
        pause().then(run);
      }
      return thenable;
    }
  };
}

//# sourceMappingURL=retryer.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/subscribable.js":
/*!************************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/subscribable.js ***!
  \************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Subscribable: () => (/* binding */ Subscribable)
/* harmony export */ });
// src/subscribable.ts
var Subscribable = class {
  constructor() {
    this.listeners = /* @__PURE__ */ new Set();
    this.subscribe = this.subscribe.bind(this);
  }
  subscribe(listener) {
    this.listeners.add(listener);
    this.onSubscribe();
    return () => {
      this.listeners.delete(listener);
      this.onUnsubscribe();
    };
  }
  hasListeners() {
    return this.listeners.size > 0;
  }
  onSubscribe() {
  }
  onUnsubscribe() {
  }
};

//# sourceMappingURL=subscribable.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/thenable.js":
/*!********************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/thenable.js ***!
  \********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   pendingThenable: () => (/* binding */ pendingThenable)
/* harmony export */ });
// src/thenable.ts
function pendingThenable() {
  let resolve;
  let reject;
  const thenable = new Promise((_resolve, _reject) => {
    resolve = _resolve;
    reject = _reject;
  });
  thenable.status = "pending";
  thenable.catch(() => {
  });
  function finalize(data) {
    Object.assign(thenable, data);
    delete thenable.resolve;
    delete thenable.reject;
  }
  thenable.resolve = (value) => {
    finalize({
      status: "fulfilled",
      value
    });
    resolve(value);
  };
  thenable.reject = (reason) => {
    finalize({
      status: "rejected",
      reason
    });
    reject(reason);
  };
  return thenable;
}

//# sourceMappingURL=thenable.js.map

/***/ }),

/***/ "./node_modules/@tanstack/query-core/build/modern/utils.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@tanstack/query-core/build/modern/utils.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   addToEnd: () => (/* binding */ addToEnd),
/* harmony export */   addToStart: () => (/* binding */ addToStart),
/* harmony export */   ensureQueryFn: () => (/* binding */ ensureQueryFn),
/* harmony export */   functionalUpdate: () => (/* binding */ functionalUpdate),
/* harmony export */   hashKey: () => (/* binding */ hashKey),
/* harmony export */   hashQueryKeyByOptions: () => (/* binding */ hashQueryKeyByOptions),
/* harmony export */   isPlainArray: () => (/* binding */ isPlainArray),
/* harmony export */   isPlainObject: () => (/* binding */ isPlainObject),
/* harmony export */   isServer: () => (/* binding */ isServer),
/* harmony export */   isValidTimeout: () => (/* binding */ isValidTimeout),
/* harmony export */   keepPreviousData: () => (/* binding */ keepPreviousData),
/* harmony export */   matchMutation: () => (/* binding */ matchMutation),
/* harmony export */   matchQuery: () => (/* binding */ matchQuery),
/* harmony export */   noop: () => (/* binding */ noop),
/* harmony export */   partialMatchKey: () => (/* binding */ partialMatchKey),
/* harmony export */   replaceData: () => (/* binding */ replaceData),
/* harmony export */   replaceEqualDeep: () => (/* binding */ replaceEqualDeep),
/* harmony export */   resolveEnabled: () => (/* binding */ resolveEnabled),
/* harmony export */   resolveStaleTime: () => (/* binding */ resolveStaleTime),
/* harmony export */   shallowEqualObjects: () => (/* binding */ shallowEqualObjects),
/* harmony export */   skipToken: () => (/* binding */ skipToken),
/* harmony export */   sleep: () => (/* binding */ sleep),
/* harmony export */   timeUntilStale: () => (/* binding */ timeUntilStale)
/* harmony export */ });
// src/utils.ts
var isServer = typeof window === "undefined" || "Deno" in globalThis;
function noop() {
}
function functionalUpdate(updater, input) {
  return typeof updater === "function" ? updater(input) : updater;
}
function isValidTimeout(value) {
  return typeof value === "number" && value >= 0 && value !== Infinity;
}
function timeUntilStale(updatedAt, staleTime) {
  return Math.max(updatedAt + (staleTime || 0) - Date.now(), 0);
}
function resolveStaleTime(staleTime, query) {
  return typeof staleTime === "function" ? staleTime(query) : staleTime;
}
function resolveEnabled(enabled, query) {
  return typeof enabled === "function" ? enabled(query) : enabled;
}
function matchQuery(filters, query) {
  const {
    type = "all",
    exact,
    fetchStatus,
    predicate,
    queryKey,
    stale
  } = filters;
  if (queryKey) {
    if (exact) {
      if (query.queryHash !== hashQueryKeyByOptions(queryKey, query.options)) {
        return false;
      }
    } else if (!partialMatchKey(query.queryKey, queryKey)) {
      return false;
    }
  }
  if (type !== "all") {
    const isActive = query.isActive();
    if (type === "active" && !isActive) {
      return false;
    }
    if (type === "inactive" && isActive) {
      return false;
    }
  }
  if (typeof stale === "boolean" && query.isStale() !== stale) {
    return false;
  }
  if (fetchStatus && fetchStatus !== query.state.fetchStatus) {
    return false;
  }
  if (predicate && !predicate(query)) {
    return false;
  }
  return true;
}
function matchMutation(filters, mutation) {
  const { exact, status, predicate, mutationKey } = filters;
  if (mutationKey) {
    if (!mutation.options.mutationKey) {
      return false;
    }
    if (exact) {
      if (hashKey(mutation.options.mutationKey) !== hashKey(mutationKey)) {
        return false;
      }
    } else if (!partialMatchKey(mutation.options.mutationKey, mutationKey)) {
      return false;
    }
  }
  if (status && mutation.state.status !== status) {
    return false;
  }
  if (predicate && !predicate(mutation)) {
    return false;
  }
  return true;
}
function hashQueryKeyByOptions(queryKey, options) {
  const hashFn = options?.queryKeyHashFn || hashKey;
  return hashFn(queryKey);
}
function hashKey(queryKey) {
  return JSON.stringify(
    queryKey,
    (_, val) => isPlainObject(val) ? Object.keys(val).sort().reduce((result, key) => {
      result[key] = val[key];
      return result;
    }, {}) : val
  );
}
function partialMatchKey(a, b) {
  if (a === b) {
    return true;
  }
  if (typeof a !== typeof b) {
    return false;
  }
  if (a && b && typeof a === "object" && typeof b === "object") {
    return !Object.keys(b).some((key) => !partialMatchKey(a[key], b[key]));
  }
  return false;
}
function replaceEqualDeep(a, b) {
  if (a === b) {
    return a;
  }
  const array = isPlainArray(a) && isPlainArray(b);
  if (array || isPlainObject(a) && isPlainObject(b)) {
    const aItems = array ? a : Object.keys(a);
    const aSize = aItems.length;
    const bItems = array ? b : Object.keys(b);
    const bSize = bItems.length;
    const copy = array ? [] : {};
    let equalItems = 0;
    for (let i = 0; i < bSize; i++) {
      const key = array ? i : bItems[i];
      if ((!array && aItems.includes(key) || array) && a[key] === void 0 && b[key] === void 0) {
        copy[key] = void 0;
        equalItems++;
      } else {
        copy[key] = replaceEqualDeep(a[key], b[key]);
        if (copy[key] === a[key] && a[key] !== void 0) {
          equalItems++;
        }
      }
    }
    return aSize === bSize && equalItems === aSize ? a : copy;
  }
  return b;
}
function shallowEqualObjects(a, b) {
  if (!b || Object.keys(a).length !== Object.keys(b).length) {
    return false;
  }
  for (const key in a) {
    if (a[key] !== b[key]) {
      return false;
    }
  }
  return true;
}
function isPlainArray(value) {
  return Array.isArray(value) && value.length === Object.keys(value).length;
}
function isPlainObject(o) {
  if (!hasObjectPrototype(o)) {
    return false;
  }
  const ctor = o.constructor;
  if (ctor === void 0) {
    return true;
  }
  const prot = ctor.prototype;
  if (!hasObjectPrototype(prot)) {
    return false;
  }
  if (!prot.hasOwnProperty("isPrototypeOf")) {
    return false;
  }
  if (Object.getPrototypeOf(o) !== Object.prototype) {
    return false;
  }
  return true;
}
function hasObjectPrototype(o) {
  return Object.prototype.toString.call(o) === "[object Object]";
}
function sleep(timeout) {
  return new Promise((resolve) => {
    setTimeout(resolve, timeout);
  });
}
function replaceData(prevData, data, options) {
  if (typeof options.structuralSharing === "function") {
    return options.structuralSharing(prevData, data);
  } else if (options.structuralSharing !== false) {
    if (true) {
      try {
        return replaceEqualDeep(prevData, data);
      } catch (error) {
        console.error(
          `Structural sharing requires data to be JSON serializable. To fix this, turn off structuralSharing or return JSON-serializable data from your queryFn. [${options.queryHash}]: ${error}`
        );
      }
    }
    return replaceEqualDeep(prevData, data);
  }
  return data;
}
function keepPreviousData(previousData) {
  return previousData;
}
function addToEnd(items, item, max = 0) {
  const newItems = [...items, item];
  return max && newItems.length > max ? newItems.slice(1) : newItems;
}
function addToStart(items, item, max = 0) {
  const newItems = [item, ...items];
  return max && newItems.length > max ? newItems.slice(0, -1) : newItems;
}
var skipToken = Symbol();
function ensureQueryFn(options, fetchOptions) {
  if (true) {
    if (options.queryFn === skipToken) {
      console.error(
        `Attempted to invoke queryFn when set to skipToken. This is likely a configuration error. Query hash: '${options.queryHash}'`
      );
    }
  }
  if (!options.queryFn && fetchOptions?.initialPromise) {
    return () => fetchOptions.initialPromise;
  }
  if (!options.queryFn || options.queryFn === skipToken) {
    return () => Promise.reject(new Error(`Missing queryFn: '${options.queryHash}'`));
  }
  return options.queryFn;
}

//# sourceMappingURL=utils.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-form/dist/esm/useField.js":
/*!****************************************************************!*\
  !*** ./node_modules/@tanstack/react-form/dist/esm/useField.js ***!
  \****************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Field: () => (/* binding */ Field),
/* harmony export */   useField: () => (/* binding */ useField)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var _tanstack_react_store__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @tanstack/react-store */ "./node_modules/@tanstack/react-form/node_modules/@tanstack/react-store/dist/esm/index.js");
/* harmony import */ var _tanstack_form_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/form-core */ "./node_modules/@tanstack/form-core/dist/esm/FieldApi.js");
/* harmony import */ var _tanstack_form_core__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @tanstack/form-core */ "./node_modules/@tanstack/form-core/dist/esm/utils.js");
/* harmony import */ var _useIsomorphicLayoutEffect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./useIsomorphicLayoutEffect.js */ "./node_modules/@tanstack/react-form/dist/esm/useIsomorphicLayoutEffect.js");





function useField(opts) {
  const [fieldApi] = (0,react__WEBPACK_IMPORTED_MODULE_1__.useState)(() => {
    const api = new _tanstack_form_core__WEBPACK_IMPORTED_MODULE_2__.FieldApi({
      ...opts,
      form: opts.form,
      name: opts.name
    });
    const extendedApi = api;
    extendedApi.Field = Field;
    return extendedApi;
  });
  (0,_useIsomorphicLayoutEffect_js__WEBPACK_IMPORTED_MODULE_3__.useIsomorphicLayoutEffect)(fieldApi.mount, [fieldApi]);
  (0,_useIsomorphicLayoutEffect_js__WEBPACK_IMPORTED_MODULE_3__.useIsomorphicLayoutEffect)(() => {
    fieldApi.update(opts);
  });
  (0,_tanstack_react_store__WEBPACK_IMPORTED_MODULE_4__.useStore)(
    fieldApi.store,
    opts.mode === "array" ? (state) => {
      return [state.meta, Object.keys(state.value ?? []).length];
    } : void 0
  );
  return fieldApi;
}
const Field = ({
  children,
  ...fieldOptions
}) => {
  const fieldApi = useField(fieldOptions);
  const jsxToDisplay = (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(
    () => (0,_tanstack_form_core__WEBPACK_IMPORTED_MODULE_5__.functionalUpdate)(children, fieldApi),
    /**
     * The reason this exists is to fix an issue with the React Compiler.
     * Namely, functionalUpdate is memoized where it checks for `fieldApi`, which is a static type.
     * This means that when `state.value` changes, it does not trigger a re-render. The useMemo explicitly fixes this problem
     */
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [children, fieldApi, fieldApi.state.value, fieldApi.state.meta]
  );
  return /* @__PURE__ */ (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.Fragment, { children: jsxToDisplay });
};

//# sourceMappingURL=useField.js.map


/***/ }),

/***/ "./node_modules/@tanstack/react-form/dist/esm/useForm.js":
/*!***************************************************************!*\
  !*** ./node_modules/@tanstack/react-form/dist/esm/useForm.js ***!
  \***************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useForm: () => (/* binding */ useForm)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
/* harmony import */ var _tanstack_form_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @tanstack/form-core */ "./node_modules/@tanstack/form-core/dist/esm/utils.js");
/* harmony import */ var _tanstack_form_core__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @tanstack/form-core */ "./node_modules/@tanstack/form-core/dist/esm/FormApi.js");
/* harmony import */ var _tanstack_react_store__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/react-store */ "./node_modules/@tanstack/react-form/node_modules/@tanstack/react-store/dist/esm/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var _useField_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./useField.js */ "./node_modules/@tanstack/react-form/dist/esm/useField.js");
/* harmony import */ var _useIsomorphicLayoutEffect_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./useIsomorphicLayoutEffect.js */ "./node_modules/@tanstack/react-form/dist/esm/useIsomorphicLayoutEffect.js");






function LocalSubscribe({
  form,
  selector,
  children
}) {
  const data = (0,_tanstack_react_store__WEBPACK_IMPORTED_MODULE_2__.useStore)(form.store, selector);
  return (0,_tanstack_form_core__WEBPACK_IMPORTED_MODULE_3__.functionalUpdate)(children, data);
}
function useForm(opts) {
  const [formApi] = (0,react__WEBPACK_IMPORTED_MODULE_1__.useState)(() => {
    const api = new _tanstack_form_core__WEBPACK_IMPORTED_MODULE_4__.FormApi(opts);
    const extendedApi = api;
    extendedApi.Field = function APIField(props) {
      return /* @__PURE__ */ (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(_useField_js__WEBPACK_IMPORTED_MODULE_5__.Field, { ...props, form: api });
    };
    extendedApi.Subscribe = (props) => {
      return /* @__PURE__ */ (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)(
        LocalSubscribe,
        {
          form: api,
          selector: props.selector,
          children: props.children
        }
      );
    };
    return extendedApi;
  });
  (0,_useIsomorphicLayoutEffect_js__WEBPACK_IMPORTED_MODULE_6__.useIsomorphicLayoutEffect)(formApi.mount, []);
  (0,_tanstack_react_store__WEBPACK_IMPORTED_MODULE_2__.useStore)(formApi.store, (state) => state.isSubmitting);
  (0,_useIsomorphicLayoutEffect_js__WEBPACK_IMPORTED_MODULE_6__.useIsomorphicLayoutEffect)(() => {
    formApi.update(opts);
  });
  return formApi;
}

//# sourceMappingURL=useForm.js.map


/***/ }),

/***/ "./node_modules/@tanstack/react-form/dist/esm/useIsomorphicLayoutEffect.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@tanstack/react-form/dist/esm/useIsomorphicLayoutEffect.js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useIsomorphicLayoutEffect: () => (/* binding */ useIsomorphicLayoutEffect)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");

const useIsomorphicLayoutEffect = typeof window !== "undefined" ? react__WEBPACK_IMPORTED_MODULE_0__.useLayoutEffect : react__WEBPACK_IMPORTED_MODULE_0__.useEffect;

//# sourceMappingURL=useIsomorphicLayoutEffect.js.map


/***/ }),

/***/ "./node_modules/@tanstack/react-form/node_modules/@tanstack/react-store/dist/esm/index.js":
/*!************************************************************************************************!*\
  !*** ./node_modules/@tanstack/react-form/node_modules/@tanstack/react-store/dist/esm/index.js ***!
  \************************************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Derived: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.Derived),
/* harmony export */   Effect: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.Effect),
/* harmony export */   Store: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.Store),
/* harmony export */   __depsThatHaveWrittenThisTick: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.__depsThatHaveWrittenThisTick),
/* harmony export */   __derivedToStore: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.__derivedToStore),
/* harmony export */   __flush: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.__flush),
/* harmony export */   __storeToDerived: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.__storeToDerived),
/* harmony export */   batch: () => (/* reexport safe */ _tanstack_store__WEBPACK_IMPORTED_MODULE_1__.batch),
/* harmony export */   shallow: () => (/* binding */ shallow),
/* harmony export */   useStore: () => (/* binding */ useStore)
/* harmony export */ });
/* harmony import */ var use_sync_external_store_shim_with_selector_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! use-sync-external-store/shim/with-selector.js */ "./node_modules/use-sync-external-store/shim/with-selector.js");
/* harmony import */ var _tanstack_store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/store */ "./node_modules/@tanstack/store/dist/esm/index.js");


function useStore(store, selector = (d) => d) {
  const slice = (0,use_sync_external_store_shim_with_selector_js__WEBPACK_IMPORTED_MODULE_0__.useSyncExternalStoreWithSelector)(
    store.subscribe,
    () => store.state,
    () => store.state,
    selector,
    shallow
  );
  return slice;
}
function shallow(objA, objB) {
  if (Object.is(objA, objB)) {
    return true;
  }
  if (typeof objA !== "object" || objA === null || typeof objB !== "object" || objB === null) {
    return false;
  }
  if (objA instanceof Map && objB instanceof Map) {
    if (objA.size !== objB.size) return false;
    for (const [k, v] of objA) {
      if (!objB.has(k) || !Object.is(v, objB.get(k))) return false;
    }
    return true;
  }
  if (objA instanceof Set && objB instanceof Set) {
    if (objA.size !== objB.size) return false;
    for (const v of objA) {
      if (!objB.has(v)) return false;
    }
    return true;
  }
  const keysA = Object.keys(objA);
  if (keysA.length !== Object.keys(objB).length) {
    return false;
  }
  for (let i = 0; i < keysA.length; i++) {
    if (!Object.prototype.hasOwnProperty.call(objB, keysA[i]) || !Object.is(objA[keysA[i]], objB[keysA[i]])) {
      return false;
    }
  }
  return true;
}

//# sourceMappingURL=index.js.map


/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js":
/*!********************************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js ***!
  \********************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   QueryClientContext: () => (/* binding */ QueryClientContext),
/* harmony export */   QueryClientProvider: () => (/* binding */ QueryClientProvider),
/* harmony export */   useQueryClient: () => (/* binding */ useQueryClient)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
"use client";

// src/QueryClientProvider.tsx


var QueryClientContext = react__WEBPACK_IMPORTED_MODULE_0__.createContext(
  void 0
);
var useQueryClient = (queryClient) => {
  const client = react__WEBPACK_IMPORTED_MODULE_0__.useContext(QueryClientContext);
  if (queryClient) {
    return queryClient;
  }
  if (!client) {
    throw new Error("No QueryClient set, use QueryClientProvider to set one");
  }
  return client;
};
var QueryClientProvider = ({
  client,
  children
}) => {
  react__WEBPACK_IMPORTED_MODULE_0__.useEffect(() => {
    client.mount();
    return () => {
      client.unmount();
    };
  }, [client]);
  return /* @__PURE__ */ (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(QueryClientContext.Provider, { value: client, children });
};

//# sourceMappingURL=QueryClientProvider.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/QueryErrorResetBoundary.js":
/*!************************************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/QueryErrorResetBoundary.js ***!
  \************************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   QueryErrorResetBoundary: () => (/* binding */ QueryErrorResetBoundary),
/* harmony export */   useQueryErrorResetBoundary: () => (/* binding */ useQueryErrorResetBoundary)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
"use client";

// src/QueryErrorResetBoundary.tsx


function createValue() {
  let isReset = false;
  return {
    clearReset: () => {
      isReset = false;
    },
    reset: () => {
      isReset = true;
    },
    isReset: () => {
      return isReset;
    }
  };
}
var QueryErrorResetBoundaryContext = react__WEBPACK_IMPORTED_MODULE_0__.createContext(createValue());
var useQueryErrorResetBoundary = () => react__WEBPACK_IMPORTED_MODULE_0__.useContext(QueryErrorResetBoundaryContext);
var QueryErrorResetBoundary = ({
  children
}) => {
  const [value] = react__WEBPACK_IMPORTED_MODULE_0__.useState(() => createValue());
  return /* @__PURE__ */ (0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(QueryErrorResetBoundaryContext.Provider, { value, children: typeof children === "function" ? children(value) : children });
};

//# sourceMappingURL=QueryErrorResetBoundary.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/errorBoundaryUtils.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/errorBoundaryUtils.js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ensurePreventErrorBoundaryRetry: () => (/* binding */ ensurePreventErrorBoundaryRetry),
/* harmony export */   getHasError: () => (/* binding */ getHasError),
/* harmony export */   useClearResetErrorBoundary: () => (/* binding */ useClearResetErrorBoundary)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/react-query/build/modern/utils.js");
"use client";

// src/errorBoundaryUtils.ts


var ensurePreventErrorBoundaryRetry = (options, errorResetBoundary) => {
  if (options.suspense || options.throwOnError || options.experimental_prefetchInRender) {
    if (!errorResetBoundary.isReset()) {
      options.retryOnMount = false;
    }
  }
};
var useClearResetErrorBoundary = (errorResetBoundary) => {
  react__WEBPACK_IMPORTED_MODULE_0__.useEffect(() => {
    errorResetBoundary.clearReset();
  }, [errorResetBoundary]);
};
var getHasError = ({
  result,
  errorResetBoundary,
  throwOnError,
  query
}) => {
  return result.isError && !errorResetBoundary.isReset() && !result.isFetching && query && (0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.shouldThrowError)(throwOnError, [result.error, query]);
};

//# sourceMappingURL=errorBoundaryUtils.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/isRestoring.js":
/*!************************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/isRestoring.js ***!
  \************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   IsRestoringProvider: () => (/* binding */ IsRestoringProvider),
/* harmony export */   useIsRestoring: () => (/* binding */ useIsRestoring)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
"use client";

// src/isRestoring.ts

var IsRestoringContext = react__WEBPACK_IMPORTED_MODULE_0__.createContext(false);
var useIsRestoring = () => react__WEBPACK_IMPORTED_MODULE_0__.useContext(IsRestoringContext);
var IsRestoringProvider = IsRestoringContext.Provider;

//# sourceMappingURL=isRestoring.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/suspense.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/suspense.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   defaultThrowOnError: () => (/* binding */ defaultThrowOnError),
/* harmony export */   ensureSuspenseTimers: () => (/* binding */ ensureSuspenseTimers),
/* harmony export */   fetchOptimistic: () => (/* binding */ fetchOptimistic),
/* harmony export */   shouldSuspend: () => (/* binding */ shouldSuspend),
/* harmony export */   willFetch: () => (/* binding */ willFetch)
/* harmony export */ });
// src/suspense.ts
var defaultThrowOnError = (_error, query) => query.state.data === void 0;
var ensureSuspenseTimers = (defaultedOptions) => {
  const originalStaleTime = defaultedOptions.staleTime;
  if (defaultedOptions.suspense) {
    defaultedOptions.staleTime = typeof originalStaleTime === "function" ? (...args) => Math.max(originalStaleTime(...args), 1e3) : Math.max(originalStaleTime ?? 1e3, 1e3);
    if (typeof defaultedOptions.gcTime === "number") {
      defaultedOptions.gcTime = Math.max(defaultedOptions.gcTime, 1e3);
    }
  }
};
var willFetch = (result, isRestoring) => result.isLoading && result.isFetching && !isRestoring;
var shouldSuspend = (defaultedOptions, result) => defaultedOptions?.suspense && result.isPending;
var fetchOptimistic = (defaultedOptions, observer, errorResetBoundary) => observer.fetchOptimistic(defaultedOptions).catch(() => {
  errorResetBoundary.clearReset();
});

//# sourceMappingURL=suspense.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/useBaseQuery.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/useBaseQuery.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useBaseQuery: () => (/* binding */ useBaseQuery)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var _tanstack_query_core__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @tanstack/query-core */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _tanstack_query_core__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @tanstack/query-core */ "./node_modules/@tanstack/query-core/build/modern/utils.js");
/* harmony import */ var _QueryClientProvider_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./QueryClientProvider.js */ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js");
/* harmony import */ var _QueryErrorResetBoundary_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./QueryErrorResetBoundary.js */ "./node_modules/@tanstack/react-query/build/modern/QueryErrorResetBoundary.js");
/* harmony import */ var _errorBoundaryUtils_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./errorBoundaryUtils.js */ "./node_modules/@tanstack/react-query/build/modern/errorBoundaryUtils.js");
/* harmony import */ var _isRestoring_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isRestoring.js */ "./node_modules/@tanstack/react-query/build/modern/isRestoring.js");
/* harmony import */ var _suspense_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./suspense.js */ "./node_modules/@tanstack/react-query/build/modern/suspense.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/react-query/build/modern/utils.js");
"use client";

// src/useBaseQuery.ts








function useBaseQuery(options, Observer, queryClient) {
  if (true) {
    if (typeof options !== "object" || Array.isArray(options)) {
      throw new Error(
        'Bad argument type. Starting with v5, only the "Object" form is allowed when calling query related functions. Please use the error stack to find the culprit call. More info here: https://tanstack.com/query/latest/docs/react/guides/migrating-to-v5#supports-a-single-signature-one-object'
      );
    }
  }
  const client = (0,_QueryClientProvider_js__WEBPACK_IMPORTED_MODULE_1__.useQueryClient)(queryClient);
  const isRestoring = (0,_isRestoring_js__WEBPACK_IMPORTED_MODULE_2__.useIsRestoring)();
  const errorResetBoundary = (0,_QueryErrorResetBoundary_js__WEBPACK_IMPORTED_MODULE_3__.useQueryErrorResetBoundary)();
  const defaultedOptions = client.defaultQueryOptions(options);
  client.getDefaultOptions().queries?._experimental_beforeQuery?.(
    defaultedOptions
  );
  defaultedOptions._optimisticResults = isRestoring ? "isRestoring" : "optimistic";
  (0,_suspense_js__WEBPACK_IMPORTED_MODULE_4__.ensureSuspenseTimers)(defaultedOptions);
  (0,_errorBoundaryUtils_js__WEBPACK_IMPORTED_MODULE_5__.ensurePreventErrorBoundaryRetry)(defaultedOptions, errorResetBoundary);
  (0,_errorBoundaryUtils_js__WEBPACK_IMPORTED_MODULE_5__.useClearResetErrorBoundary)(errorResetBoundary);
  const isNewCacheEntry = !client.getQueryCache().get(defaultedOptions.queryHash);
  const [observer] = react__WEBPACK_IMPORTED_MODULE_0__.useState(
    () => new Observer(
      client,
      defaultedOptions
    )
  );
  const result = observer.getOptimisticResult(defaultedOptions);
  const shouldSubscribe = !isRestoring && options.subscribed !== false;
  react__WEBPACK_IMPORTED_MODULE_0__.useSyncExternalStore(
    react__WEBPACK_IMPORTED_MODULE_0__.useCallback(
      (onStoreChange) => {
        const unsubscribe = shouldSubscribe ? observer.subscribe(_tanstack_query_core__WEBPACK_IMPORTED_MODULE_6__.notifyManager.batchCalls(onStoreChange)) : _utils_js__WEBPACK_IMPORTED_MODULE_7__.noop;
        observer.updateResult();
        return unsubscribe;
      },
      [observer, shouldSubscribe]
    ),
    () => observer.getCurrentResult(),
    () => observer.getCurrentResult()
  );
  react__WEBPACK_IMPORTED_MODULE_0__.useEffect(() => {
    observer.setOptions(defaultedOptions, { listeners: false });
  }, [defaultedOptions, observer]);
  if ((0,_suspense_js__WEBPACK_IMPORTED_MODULE_4__.shouldSuspend)(defaultedOptions, result)) {
    throw (0,_suspense_js__WEBPACK_IMPORTED_MODULE_4__.fetchOptimistic)(defaultedOptions, observer, errorResetBoundary);
  }
  if ((0,_errorBoundaryUtils_js__WEBPACK_IMPORTED_MODULE_5__.getHasError)({
    result,
    errorResetBoundary,
    throwOnError: defaultedOptions.throwOnError,
    query: client.getQueryCache().get(defaultedOptions.queryHash)
  })) {
    throw result.error;
  }
  ;
  client.getDefaultOptions().queries?._experimental_afterQuery?.(
    defaultedOptions,
    result
  );
  if (defaultedOptions.experimental_prefetchInRender && !_tanstack_query_core__WEBPACK_IMPORTED_MODULE_8__.isServer && (0,_suspense_js__WEBPACK_IMPORTED_MODULE_4__.willFetch)(result, isRestoring)) {
    const promise = isNewCacheEntry ? (
      // Fetch immediately on render in order to ensure `.promise` is resolved even if the component is unmounted
      (0,_suspense_js__WEBPACK_IMPORTED_MODULE_4__.fetchOptimistic)(defaultedOptions, observer, errorResetBoundary)
    ) : (
      // subscribe to the "cache promise" so that we can finalize the currentThenable once data comes in
      client.getQueryCache().get(defaultedOptions.queryHash)?.promise
    );
    promise?.catch(_utils_js__WEBPACK_IMPORTED_MODULE_7__.noop).finally(() => {
      observer.updateResult();
    });
  }
  return !defaultedOptions.notifyOnChangeProps ? observer.trackResult(result) : result;
}

//# sourceMappingURL=useBaseQuery.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/useMutation.js":
/*!************************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/useMutation.js ***!
  \************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useMutation: () => (/* binding */ useMutation)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var _tanstack_query_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/query-core */ "./node_modules/@tanstack/query-core/build/modern/mutationObserver.js");
/* harmony import */ var _tanstack_query_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @tanstack/query-core */ "./node_modules/@tanstack/query-core/build/modern/notifyManager.js");
/* harmony import */ var _QueryClientProvider_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./QueryClientProvider.js */ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./utils.js */ "./node_modules/@tanstack/react-query/build/modern/utils.js");
"use client";

// src/useMutation.ts




function useMutation(options, queryClient) {
  const client = (0,_QueryClientProvider_js__WEBPACK_IMPORTED_MODULE_1__.useQueryClient)(queryClient);
  const [observer] = react__WEBPACK_IMPORTED_MODULE_0__.useState(
    () => new _tanstack_query_core__WEBPACK_IMPORTED_MODULE_2__.MutationObserver(
      client,
      options
    )
  );
  react__WEBPACK_IMPORTED_MODULE_0__.useEffect(() => {
    observer.setOptions(options);
  }, [observer, options]);
  const result = react__WEBPACK_IMPORTED_MODULE_0__.useSyncExternalStore(
    react__WEBPACK_IMPORTED_MODULE_0__.useCallback(
      (onStoreChange) => observer.subscribe(_tanstack_query_core__WEBPACK_IMPORTED_MODULE_3__.notifyManager.batchCalls(onStoreChange)),
      [observer]
    ),
    () => observer.getCurrentResult(),
    () => observer.getCurrentResult()
  );
  const mutate = react__WEBPACK_IMPORTED_MODULE_0__.useCallback(
    (variables, mutateOptions) => {
      observer.mutate(variables, mutateOptions).catch(_utils_js__WEBPACK_IMPORTED_MODULE_4__.noop);
    },
    [observer]
  );
  if (result.error && (0,_utils_js__WEBPACK_IMPORTED_MODULE_4__.shouldThrowError)(observer.options.throwOnError, [result.error])) {
    throw result.error;
  }
  return { ...result, mutate, mutateAsync: result.mutate };
}

//# sourceMappingURL=useMutation.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/useQuery.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/useQuery.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   useQuery: () => (/* binding */ useQuery)
/* harmony export */ });
/* harmony import */ var _tanstack_query_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/query-core */ "./node_modules/@tanstack/query-core/build/modern/queryObserver.js");
/* harmony import */ var _useBaseQuery_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./useBaseQuery.js */ "./node_modules/@tanstack/react-query/build/modern/useBaseQuery.js");
"use client";

// src/useQuery.ts


function useQuery(options, queryClient) {
  return (0,_useBaseQuery_js__WEBPACK_IMPORTED_MODULE_0__.useBaseQuery)(options, _tanstack_query_core__WEBPACK_IMPORTED_MODULE_1__.QueryObserver, queryClient);
}

//# sourceMappingURL=useQuery.js.map

/***/ }),

/***/ "./node_modules/@tanstack/react-query/build/modern/utils.js":
/*!******************************************************************!*\
  !*** ./node_modules/@tanstack/react-query/build/modern/utils.js ***!
  \******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   noop: () => (/* binding */ noop),
/* harmony export */   shouldThrowError: () => (/* binding */ shouldThrowError)
/* harmony export */ });
// src/utils.ts
function shouldThrowError(throwError, params) {
  if (typeof throwError === "function") {
    return throwError(...params);
  }
  return !!throwError;
}
function noop() {
}

//# sourceMappingURL=utils.js.map

/***/ }),

/***/ "./node_modules/@tanstack/store/dist/esm/derived.js":
/*!**********************************************************!*\
  !*** ./node_modules/@tanstack/store/dist/esm/derived.js ***!
  \**********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Derived: () => (/* binding */ Derived)
/* harmony export */ });
/* harmony import */ var _store_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./store.js */ "./node_modules/@tanstack/store/dist/esm/store.js");
/* harmony import */ var _scheduler_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scheduler.js */ "./node_modules/@tanstack/store/dist/esm/scheduler.js");


class Derived {
  constructor(options) {
    this.listeners = /* @__PURE__ */ new Set();
    this._subscriptions = [];
    this.lastSeenDepValues = [];
    this.getDepVals = () => {
      const prevDepVals = [];
      const currDepVals = [];
      for (const dep of this.options.deps) {
        prevDepVals.push(dep.prevState);
        currDepVals.push(dep.state);
      }
      this.lastSeenDepValues = currDepVals;
      return {
        prevDepVals,
        currDepVals,
        prevVal: this.prevState ?? void 0
      };
    };
    this.recompute = () => {
      var _a, _b;
      this.prevState = this.state;
      const { prevDepVals, currDepVals, prevVal } = this.getDepVals();
      this.state = this.options.fn({
        prevDepVals,
        currDepVals,
        prevVal
      });
      (_b = (_a = this.options).onUpdate) == null ? void 0 : _b.call(_a);
    };
    this.checkIfRecalculationNeededDeeply = () => {
      for (const dep of this.options.deps) {
        if (dep instanceof Derived) {
          dep.checkIfRecalculationNeededDeeply();
        }
      }
      let shouldRecompute = false;
      const lastSeenDepValues = this.lastSeenDepValues;
      const { currDepVals } = this.getDepVals();
      for (let i = 0; i < currDepVals.length; i++) {
        if (currDepVals[i] !== lastSeenDepValues[i]) {
          shouldRecompute = true;
          break;
        }
      }
      if (shouldRecompute) {
        this.recompute();
      }
    };
    this.mount = () => {
      this.registerOnGraph();
      this.checkIfRecalculationNeededDeeply();
      return () => {
        this.unregisterFromGraph();
        for (const cleanup of this._subscriptions) {
          cleanup();
        }
      };
    };
    this.subscribe = (listener) => {
      var _a, _b;
      this.listeners.add(listener);
      const unsub = (_b = (_a = this.options).onSubscribe) == null ? void 0 : _b.call(_a, listener, this);
      return () => {
        this.listeners.delete(listener);
        unsub == null ? void 0 : unsub();
      };
    };
    this.options = options;
    this.state = options.fn({
      prevDepVals: void 0,
      prevVal: void 0,
      currDepVals: this.getDepVals().currDepVals
    });
  }
  registerOnGraph(deps = this.options.deps) {
    for (const dep of deps) {
      if (dep instanceof Derived) {
        dep.registerOnGraph();
        this.registerOnGraph(dep.options.deps);
      } else if (dep instanceof _store_js__WEBPACK_IMPORTED_MODULE_0__.Store) {
        let relatedLinkedDerivedVals = _scheduler_js__WEBPACK_IMPORTED_MODULE_1__.__storeToDerived.get(dep);
        if (!relatedLinkedDerivedVals) {
          relatedLinkedDerivedVals = /* @__PURE__ */ new Set();
          _scheduler_js__WEBPACK_IMPORTED_MODULE_1__.__storeToDerived.set(dep, relatedLinkedDerivedVals);
        }
        relatedLinkedDerivedVals.add(this);
        let relatedStores = _scheduler_js__WEBPACK_IMPORTED_MODULE_1__.__derivedToStore.get(this);
        if (!relatedStores) {
          relatedStores = /* @__PURE__ */ new Set();
          _scheduler_js__WEBPACK_IMPORTED_MODULE_1__.__derivedToStore.set(this, relatedStores);
        }
        relatedStores.add(dep);
      }
    }
  }
  unregisterFromGraph(deps = this.options.deps) {
    for (const dep of deps) {
      if (dep instanceof Derived) {
        this.unregisterFromGraph(dep.options.deps);
      } else if (dep instanceof _store_js__WEBPACK_IMPORTED_MODULE_0__.Store) {
        const relatedLinkedDerivedVals = _scheduler_js__WEBPACK_IMPORTED_MODULE_1__.__storeToDerived.get(dep);
        if (relatedLinkedDerivedVals) {
          relatedLinkedDerivedVals.delete(this);
        }
        const relatedStores = _scheduler_js__WEBPACK_IMPORTED_MODULE_1__.__derivedToStore.get(this);
        if (relatedStores) {
          relatedStores.delete(dep);
        }
      }
    }
  }
}

//# sourceMappingURL=derived.js.map


/***/ }),

/***/ "./node_modules/@tanstack/store/dist/esm/effect.js":
/*!*********************************************************!*\
  !*** ./node_modules/@tanstack/store/dist/esm/effect.js ***!
  \*********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Effect: () => (/* binding */ Effect)
/* harmony export */ });
/* harmony import */ var _derived_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./derived.js */ "./node_modules/@tanstack/store/dist/esm/derived.js");

class Effect {
  constructor(opts) {
    const { eager, fn, ...derivedProps } = opts;
    this._derived = new _derived_js__WEBPACK_IMPORTED_MODULE_0__.Derived({
      ...derivedProps,
      fn: () => {
      },
      onUpdate() {
        fn();
      }
    });
    if (eager) {
      fn();
    }
  }
  mount() {
    return this._derived.mount();
  }
}

//# sourceMappingURL=effect.js.map


/***/ }),

/***/ "./node_modules/@tanstack/store/dist/esm/index.js":
/*!********************************************************!*\
  !*** ./node_modules/@tanstack/store/dist/esm/index.js ***!
  \********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Derived: () => (/* reexport safe */ _derived_js__WEBPACK_IMPORTED_MODULE_0__.Derived),
/* harmony export */   Effect: () => (/* reexport safe */ _effect_js__WEBPACK_IMPORTED_MODULE_1__.Effect),
/* harmony export */   Store: () => (/* reexport safe */ _store_js__WEBPACK_IMPORTED_MODULE_2__.Store),
/* harmony export */   __depsThatHaveWrittenThisTick: () => (/* reexport safe */ _scheduler_js__WEBPACK_IMPORTED_MODULE_3__.__depsThatHaveWrittenThisTick),
/* harmony export */   __derivedToStore: () => (/* reexport safe */ _scheduler_js__WEBPACK_IMPORTED_MODULE_3__.__derivedToStore),
/* harmony export */   __flush: () => (/* reexport safe */ _scheduler_js__WEBPACK_IMPORTED_MODULE_3__.__flush),
/* harmony export */   __storeToDerived: () => (/* reexport safe */ _scheduler_js__WEBPACK_IMPORTED_MODULE_3__.__storeToDerived),
/* harmony export */   batch: () => (/* reexport safe */ _scheduler_js__WEBPACK_IMPORTED_MODULE_3__.batch)
/* harmony export */ });
/* harmony import */ var _derived_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./derived.js */ "./node_modules/@tanstack/store/dist/esm/derived.js");
/* harmony import */ var _effect_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./effect.js */ "./node_modules/@tanstack/store/dist/esm/effect.js");
/* harmony import */ var _store_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./store.js */ "./node_modules/@tanstack/store/dist/esm/store.js");
/* harmony import */ var _scheduler_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./scheduler.js */ "./node_modules/@tanstack/store/dist/esm/scheduler.js");





//# sourceMappingURL=index.js.map


/***/ }),

/***/ "./node_modules/@tanstack/store/dist/esm/scheduler.js":
/*!************************************************************!*\
  !*** ./node_modules/@tanstack/store/dist/esm/scheduler.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __depsThatHaveWrittenThisTick: () => (/* binding */ __depsThatHaveWrittenThisTick),
/* harmony export */   __derivedToStore: () => (/* binding */ __derivedToStore),
/* harmony export */   __flush: () => (/* binding */ __flush),
/* harmony export */   __storeToDerived: () => (/* binding */ __storeToDerived),
/* harmony export */   batch: () => (/* binding */ batch)
/* harmony export */ });
/* harmony import */ var _derived_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./derived.js */ "./node_modules/@tanstack/store/dist/esm/derived.js");

const __storeToDerived = /* @__PURE__ */ new WeakMap();
const __derivedToStore = /* @__PURE__ */ new WeakMap();
const __depsThatHaveWrittenThisTick = {
  current: []
};
let __isFlushing = false;
let __batchDepth = 0;
const __pendingUpdates = /* @__PURE__ */ new Set();
const __initialBatchValues = /* @__PURE__ */ new Map();
function __flush_internals(relatedVals) {
  const sorted = Array.from(relatedVals).sort((a, b) => {
    if (a instanceof _derived_js__WEBPACK_IMPORTED_MODULE_0__.Derived && a.options.deps.includes(b)) return 1;
    if (b instanceof _derived_js__WEBPACK_IMPORTED_MODULE_0__.Derived && b.options.deps.includes(a)) return -1;
    return 0;
  });
  for (const derived of sorted) {
    if (__depsThatHaveWrittenThisTick.current.includes(derived)) {
      continue;
    }
    __depsThatHaveWrittenThisTick.current.push(derived);
    derived.recompute();
    const stores = __derivedToStore.get(derived);
    if (stores) {
      for (const store of stores) {
        const relatedLinkedDerivedVals = __storeToDerived.get(store);
        if (!relatedLinkedDerivedVals) continue;
        __flush_internals(relatedLinkedDerivedVals);
      }
    }
  }
}
function __notifyListeners(store) {
  store.listeners.forEach(
    (listener) => listener({
      prevVal: store.prevState,
      currentVal: store.state
    })
  );
}
function __notifyDerivedListeners(derived) {
  derived.listeners.forEach(
    (listener) => listener({
      prevVal: derived.prevState,
      currentVal: derived.state
    })
  );
}
function __flush(store) {
  if (__batchDepth > 0 && !__initialBatchValues.has(store)) {
    __initialBatchValues.set(store, store.prevState);
  }
  __pendingUpdates.add(store);
  if (__batchDepth > 0) return;
  if (__isFlushing) return;
  try {
    __isFlushing = true;
    while (__pendingUpdates.size > 0) {
      const stores = Array.from(__pendingUpdates);
      __pendingUpdates.clear();
      for (const store2 of stores) {
        const prevState = __initialBatchValues.get(store2) ?? store2.prevState;
        store2.prevState = prevState;
        __notifyListeners(store2);
      }
      for (const store2 of stores) {
        const derivedVals = __storeToDerived.get(store2);
        if (!derivedVals) continue;
        __depsThatHaveWrittenThisTick.current.push(store2);
        __flush_internals(derivedVals);
      }
      for (const store2 of stores) {
        const derivedVals = __storeToDerived.get(store2);
        if (!derivedVals) continue;
        for (const derived of derivedVals) {
          __notifyDerivedListeners(derived);
        }
      }
    }
  } finally {
    __isFlushing = false;
    __depsThatHaveWrittenThisTick.current = [];
    __initialBatchValues.clear();
  }
}
function batch(fn) {
  __batchDepth++;
  try {
    fn();
  } finally {
    __batchDepth--;
    if (__batchDepth === 0) {
      const pendingUpdateToFlush = Array.from(__pendingUpdates)[0];
      if (pendingUpdateToFlush) {
        __flush(pendingUpdateToFlush);
      }
    }
  }
}

//# sourceMappingURL=scheduler.js.map


/***/ }),

/***/ "./node_modules/@tanstack/store/dist/esm/store.js":
/*!********************************************************!*\
  !*** ./node_modules/@tanstack/store/dist/esm/store.js ***!
  \********************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   Store: () => (/* binding */ Store)
/* harmony export */ });
/* harmony import */ var _scheduler_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scheduler.js */ "./node_modules/@tanstack/store/dist/esm/scheduler.js");

class Store {
  constructor(initialState, options) {
    this.listeners = /* @__PURE__ */ new Set();
    this.subscribe = (listener) => {
      var _a, _b;
      this.listeners.add(listener);
      const unsub = (_b = (_a = this.options) == null ? void 0 : _a.onSubscribe) == null ? void 0 : _b.call(_a, listener, this);
      return () => {
        this.listeners.delete(listener);
        unsub == null ? void 0 : unsub();
      };
    };
    this.setState = (updater) => {
      var _a, _b, _c;
      this.prevState = this.state;
      this.state = ((_a = this.options) == null ? void 0 : _a.updateFn) ? this.options.updateFn(this.prevState)(updater) : updater(this.prevState);
      (_c = (_b = this.options) == null ? void 0 : _b.onUpdate) == null ? void 0 : _c.call(_b);
      (0,_scheduler_js__WEBPACK_IMPORTED_MODULE_0__.__flush)(this);
    };
    this.prevState = initialState;
    this.state = initialState;
    this.options = options;
  }
}

//# sourceMappingURL=store.js.map


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
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!****************************************!*\
  !*** ./apps/general-settings/index.js ***!
  \****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _SettingsPage__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SettingsPage */ "./apps/general-settings/SettingsPage.jsx");
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/modern/QueryClientProvider.js");
/* harmony import */ var _query_client__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./query/client */ "./apps/general-settings/query/client.js");
/* harmony import */ var _context_settings_context__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./context/settings-context */ "./apps/general-settings/context/settings-context.jsx");
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./index.scss */ "./apps/general-settings/index.scss");







document.addEventListener('DOMContentLoaded', () => {
  const settings = document.getElementById('modula-settings-app');
  if (!settings) {
    return;
  }
  const activeTab = settings?.dataset?.tab;
  const root = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createRoot)(settings);
  root.render(/*#__PURE__*/React.createElement(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_6__.QueryClientProvider, {
    client: _query_client__WEBPACK_IMPORTED_MODULE_3__.queryClient
  }, /*#__PURE__*/React.createElement(_context_settings_context__WEBPACK_IMPORTED_MODULE_4__.SettingsProvider, {
    activeTab: activeTab
  }, /*#__PURE__*/React.createElement(_SettingsPage__WEBPACK_IMPORTED_MODULE_2__["default"], null))));
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map