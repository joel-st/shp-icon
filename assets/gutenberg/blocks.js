/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./.build/assets/gutenberg/icon/block.jsx":
/*!************************************************!*\
  !*** ./.build/assets/gutenberg/icon/block.jsx ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _icon_jsx__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./icon.jsx */ "./.build/assets/gutenberg/icon/icon.jsx");
/* harmony import */ var _store_jsx__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./store.jsx */ "./.build/assets/gutenberg/icon/store.jsx");








var blockName = "shp-icon/icon";
/* harmony default export */ __webpack_exports__["default"] = ((0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__.registerBlockType)(blockName, {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__._x)("SVG Icon", "SVG icon block title", "shp-icon"),
  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Use your SVG icons as Gutenberg block", "shp-icon"),
  icon: _icon_jsx__WEBPACK_IMPORTED_MODULE_6__["default"],
  category: "embed",
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Icons"), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("SVG")],
  supports: {
    align: false,
    anchor: true
  },
  attributes: {
    icon: {
      type: "string",
      default: null
    },
    color: {
      type: "string",
      default: "inherit"
    },
    backgroundColor: {
      type: "string",
      default: "transparent"
    },
    align: {
      type: "string",
      default: "normal"
    },
    anchor: {
      type: "string",
      default: ""
    }
  },
  edit: function edit(props) {
    var _props$attributes = props.attributes,
      icon = _props$attributes.icon,
      color = _props$attributes.color,
      backgroundColor = _props$attributes.backgroundColor,
      attributes = props.attributes,
      setAttributes = props.setAttributes;
    var iconList = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(function (select) {
      return select("shp-icon/icon-list").getEntries();
    });
    if (!iconList.length) {
      return /*#__PURE__*/React.createElement("div", {
        className: "components-placeholder"
      }, /*#__PURE__*/React.createElement("div", {
        className: "components-placeholder__fieldset"
      }, /*#__PURE__*/React.createElement("div", {
        className: "components-spinner"
      })));
    }
    var hasCurrentColor = false;
    if (icon) {
      var index = iconList.findIndex(function (x) {
        return x.filename === icon;
      });
      if (-1 !== index && -1 !== iconList[index]["svg"].toLowerCase().search("currentcolor")) {
        hasCurrentColor = true;
      }
    }
    return [/*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.InspectorControls, {
      className: "shp-icon-controls"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__._x)("Icon Collection", "SVG icon block panel title", "shp-icon"),
      initialOpen: true
    }, /*#__PURE__*/React.createElement("div", {
      className: "shp-icon-controls__icon-list"
    }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.RadioControl, {
      selected: icon,
      options: iconList.map(function (icon) {
        return {
          label: /*#__PURE__*/React.createElement("i", {
            className: "shp-icon",
            dangerouslySetInnerHTML: {
              __html: icon.svg
            }
          }),
          value: icon.filename
        };
      }),
      onChange: function onChange(icon) {
        setAttributes({
          icon: icon
        });
      }
    }))), /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.PanelColorSettings, {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__._x)("Color Settings", "SVG icon block PanelColorSettings label", "shp-icon"),
      colorSettings: [{
        value: color,
        onChange: function onChange(color) {
          if (typeof color !== "undefined") {
            setAttributes({
              color: color
            });
          } else {
            setAttributes({
              color: "inherit"
            });
          }
        },
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__._x)("Color", "SVG icon block colorSettings label", "shp-icon")
      }, {
        value: backgroundColor,
        onChange: function onChange(backgroundColor) {
          if (typeof backgroundColor !== "undefined") {
            setAttributes({
              backgroundColor: backgroundColor
            });
          } else {
            setAttributes({
              backgroundColor: "transparent"
            });
          }
        },
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__._x)("Background Color", "SVG icon block colorSettings label", "shp-icon")
      }]
    }, !hasCurrentColor && /*#__PURE__*/React.createElement("i", {
      style: {
        color: "red"
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__._x)("The color feature only works with SVG’s using currentColor. No currentColor value found in the selected SVG.", "SVG icon block colorSettings notice", "shp-icon")))), /*#__PURE__*/React.createElement((_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_1___default()), {
      block: blockName,
      attributes: attributes
    })];
  }
}));

/***/ }),

/***/ "./.build/assets/gutenberg/icon/icon.jsx":
/*!***********************************************!*\
  !*** ./.build/assets/gutenberg/icon/icon.jsx ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// wanna use dashicon icons?
// do: export default ( 'lock' );

var _wp$components = wp.components,
  Path = _wp$components.Path,
  SVG = _wp$components.SVG;
/* harmony default export */ __webpack_exports__["default"] = (/*#__PURE__*/React.createElement(SVG, {
  width: "32",
  height: "30",
  viewBox: "0 0 32 30",
  xmlns: "http://www.w3.org/2000/svg",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, /*#__PURE__*/React.createElement(Path, {
  d: "M15.9999087,15.1219512 C16.3563467,15.1219512 16.6821997,15.320913 16.8416408,15.6359024 L16.8416408,15.6359024 L23.4291507,28.6548107 C23.6220875,29.036784 23.5270282,29.4994942 23.1986281,29.776902 C22.8702279,30.0543098 22.3928509,30.0751508 22.0409691,29.8274424 L22.0409691,29.8274424 L15.9999087,25.5638661 L9.95837776,29.8274424 C9.60649597,30.0751508 9.12911892,30.0543098 8.80071877,29.776902 C8.47231863,29.4994942 8.37725938,29.036784 8.57019618,28.6548107 L8.57019618,28.6548107 L15.1581766,15.6359024 C15.3176177,15.320913 15.6434707,15.1219512 15.9999087,15.1219512 Z M15.9999087,18.1312319 L11.9483008,26.1378605 L15.4527534,23.6643842 C15.7799902,23.4334226 16.2195919,23.4334226 16.5468287,23.6643842 L16.5468287,23.6643842 L20.0515166,26.1378605 L15.9999087,18.1312319 Z M17.8821888,0.000261344084 C18.4019661,0.000261344084 18.8233289,0.419808629 18.8233289,0.937346434 L18.8233289,0.937346434 L18.8233289,1.87443152 L26.3524493,1.87443152 C26.4051018,1.87475782 26.4576351,1.87945957 26.5095021,1.8884878 C26.9052316,0.759035914 27.9744849,0.00182881521 29.1758695,0.000261344084 C30.6136854,-1.0658141e-14 31.8220607,1.07561748 31.9822416,2.49832664 C32.1424225,3.92103581 31.2032421,5.23637091 29.8010568,5.55310584 C28.3988715,5.86984077 26.981585,5.0868001 26.5095021,3.73454543 C26.4576351,3.74357366 26.4051018,3.7482754 26.3524493,3.7486017 L26.3524493,3.7486017 L24.1172417,3.7486017 C26.9969229,5.64829417 28.8458222,8.75506315 29.1363416,12.1823675 L29.1363416,12.1823675 L30.1170095,12.1823675 C30.6367868,12.1823675 31.0581496,12.6019148 31.0581496,13.1194526 L31.0581496,13.1194526 L31.0581496,16.867793 C31.0581496,17.3853308 30.6367868,17.804878 30.1170095,17.804878 L30.1170095,17.804878 L26.3524493,17.804878 C25.832672,17.804878 25.4113093,17.3853308 25.4113093,16.867793 L25.4113093,16.867793 L25.4113093,13.1194526 C25.4113093,12.6019148 25.832672,12.1823675 26.3524493,12.1823675 L26.3524493,12.1823675 L27.2465324,12.1823675 C26.7928672,7.75096009 23.2739119,4.24716649 18.8233289,3.79545596 L18.8233289,3.79545596 L18.8233289,4.68568679 C18.8233289,5.2032246 18.4019661,5.62277188 17.8821888,5.62277188 L17.8821888,5.62277188 L14.1176286,5.62277188 C13.5978513,5.62277188 13.1764885,5.2032246 13.1764885,4.68568679 L13.1764885,4.68568679 L13.1764885,3.79545596 C8.72590548,4.24716649 5.20695022,7.75096009 4.75328504,12.1823675 L4.75328504,12.1823675 L5.64736809,12.1823675 C6.16714539,12.1823675 6.58850815,12.6019148 6.58850815,13.1194526 L6.58850815,13.1194526 L6.58850815,16.867793 C6.58850815,17.3853308 6.16714539,17.804878 5.64736809,17.804878 L5.64736809,17.804878 L1.88280787,17.804878 C1.36303057,17.804878 0.941667812,17.3853308 0.941667812,16.867793 L0.941667812,16.867793 L0.941667812,13.1194526 C0.941667812,12.6019148 1.36303057,12.1823675 1.88280787,12.1823675 L1.88280787,12.1823675 L2.86382873,12.1823675 C3.15426653,8.75512637 5.00302871,5.64836938 7.88257572,3.7486017 L7.88257572,3.7486017 L5.64736809,3.7486017 C5.59471557,3.7482754 5.54218228,3.74357366 5.49031534,3.73454543 C5.03789344,5.0304823 3.71205093,5.81195983 2.35334793,5.58353542 C0.994644933,5.35511102 -1.77635684e-15,4.18351441 -1.77635684e-15,2.81151661 C-1.77635684e-15,1.43951882 0.994644933,0.267922207 2.35334793,0.0394978022 C3.71205093,-0.188926603 5.03789344,0.592550929 5.49031534,1.8884878 C5.54218228,1.87945957 5.59471557,1.87475782 5.64736809,1.87443152 L5.64736809,1.87443152 L13.1764885,1.87443152 L13.1764885,0.937346434 C13.1764885,0.419808629 13.5978513,0.000261344084 14.1176286,0.000261344084 L14.1176286,0.000261344084 Z M4.70622803,14.0565377 L2.82394792,14.0565377 L2.82394792,15.9307079 L4.70622803,15.9307079 L4.70622803,14.0565377 Z M29.1758695,14.0565377 L27.2935894,14.0565377 L27.2935894,15.9307079 L29.1758695,15.9307079 L29.1758695,14.0565377 Z M2.82394792,1.87443152 C2.30417062,1.87443152 1.88280787,2.29397881 1.88280787,2.81151661 C1.88280787,3.32905442 2.30417062,3.7486017 2.82394792,3.7486017 C3.34348334,3.74802072 3.76450449,3.32881358 3.76508798,2.81151661 C3.76508798,2.29397881 3.34372522,1.87443152 2.82394792,1.87443152 Z M16.9410488,1.87443152 L15.0587686,1.87443152 L15.0587686,3.7486017 L16.9410488,3.7486017 L16.9410488,1.87443152 Z M29.1758695,1.87443152 C28.6560922,1.87443152 28.2347294,2.29397881 28.2347294,2.81151661 C28.2347294,3.32905442 28.6560922,3.7486017 29.1758695,3.7486017 C29.6954049,3.74802072 30.116426,3.32881358 30.1170095,2.81151661 C30.1170095,2.29397881 29.6956468,1.87443152 29.1758695,1.87443152 Z"
})));

/***/ }),

/***/ "./.build/assets/gutenberg/icon/store.jsx":
/*!************************************************!*\
  !*** ./.build/assets/gutenberg/icon/store.jsx ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/regenerator */ "@babel/runtime/regenerator");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3__);


function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }



// Some default values
var DEFAULT_STATE = {
  entries: false
};
var DEFAULT_ACTION = {};
var store = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.createReduxStore)("shp-icon/icon-list", {
  reducer: function reducer() {
    var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : DEFAULT_STATE;
    var action = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : DEFAULT_ACTION;
    switch (action.type) {
      case "GET_ENTRIES":
        return _objectSpread(_objectSpread({}, state), {}, {
          entries: action.entries
        });
      default:
        return state;
    }
  },
  actions: {
    setState: function setState(entries) {
      return {
        type: "GET_ENTRIES",
        entries: entries
      };
    },
    fetchFromAPI: function fetchFromAPI(path) {
      return {
        type: "FETCH_FROM_API",
        path: path
      };
    }
  },
  selectors: {
    getEntries: function getEntries(state) {
      return state.entries || [];
    }
  },
  controls: {
    FETCH_FROM_API: function FETCH_FROM_API(action) {
      return _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3___default()({
        path: action.path
      }).then(function (data) {
        return data;
      });
    }
  },
  resolvers: {
    getEntries: /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1___default().mark(function getEntries() {
      var path, entries;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_1___default().wrap(function getEntries$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            path = "/shp-icon/v1/icons/";
            _context.next = 3;
            return store.actions.fetchFromAPI(path);
          case 3:
            entries = _context.sent;
            return _context.abrupt("return", store.actions.setState(entries));
          case 5:
          case "end":
            return _context.stop();
        }
      }, getEntries);
    })
  }
});
(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.register)(store);

/***/ }),

/***/ "@babel/runtime/regenerator":
/*!*************************************!*\
  !*** external "regeneratorRuntime" ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["regeneratorRuntime"];

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["wp"]["apiFetch"];

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

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/server-side-render":
/*!******************************************!*\
  !*** external ["wp","serverSideRender"] ***!
  \******************************************/
/***/ (function(module) {

module.exports = window["wp"]["serverSideRender"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
/* harmony import */ var _toPropertyKey_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./toPropertyKey.js */ "./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js");

function _defineProperty(e, r, t) {
  return (r = (0,_toPropertyKey_js__WEBPACK_IMPORTED_MODULE_0__["default"])(r)) in e ? Object.defineProperty(e, r, {
    value: t,
    enumerable: !0,
    configurable: !0,
    writable: !0
  }) : e[r] = t, e;
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toPrimitive.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toPrimitive.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ toPrimitive; }
/* harmony export */ });
/* harmony import */ var _typeof_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/esm/typeof.js");

function toPrimitive(t, r) {
  if ("object" != (0,_typeof_js__WEBPACK_IMPORTED_MODULE_0__["default"])(t) || !t) return t;
  var e = t[Symbol.toPrimitive];
  if (void 0 !== e) {
    var i = e.call(t, r || "default");
    if ("object" != (0,_typeof_js__WEBPACK_IMPORTED_MODULE_0__["default"])(i)) return i;
    throw new TypeError("@@toPrimitive must return a primitive value.");
  }
  return ("string" === r ? String : Number)(t);
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toPropertyKey.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ toPropertyKey; }
/* harmony export */ });
/* harmony import */ var _typeof_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/esm/typeof.js");
/* harmony import */ var _toPrimitive_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./toPrimitive.js */ "./node_modules/@babel/runtime/helpers/esm/toPrimitive.js");


function toPropertyKey(t) {
  var i = (0,_toPrimitive_js__WEBPACK_IMPORTED_MODULE_1__["default"])(t, "string");
  return "symbol" == (0,_typeof_js__WEBPACK_IMPORTED_MODULE_0__["default"])(i) ? i : i + "";
}


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/typeof.js":
/*!***********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/typeof.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _typeof; }
/* harmony export */ });
function _typeof(o) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
    return typeof o;
  } : function (o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  }, _typeof(o);
}


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
/************************************************************************/
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./.build/assets/gutenberg/blocks.js ***!
  \*******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _icon_block_jsx__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./icon/block.jsx */ "./.build/assets/gutenberg/icon/block.jsx");


/******/ })()
;