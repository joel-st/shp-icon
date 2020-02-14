/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["i18n"]; }());

/***/ }),
/* 1 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blockEditor"]; }());

/***/ }),
/* 2 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["data"]; }());

/***/ }),
/* 3 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["components"]; }());

/***/ }),
/* 4 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["serverSideRender"]; }());

/***/ }),
/* 5 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blocks"]; }());

/***/ }),
/* 6 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["apiFetch"]; }());

/***/ }),
/* 7 */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["compose"]; }());

/***/ }),
/* 8 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"this":["wp","i18n"]}
var external_this_wp_i18n_ = __webpack_require__(0);

// EXTERNAL MODULE: external {"this":["wp","serverSideRender"]}
var external_this_wp_serverSideRender_ = __webpack_require__(4);
var external_this_wp_serverSideRender_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_serverSideRender_);

// EXTERNAL MODULE: external {"this":["wp","blocks"]}
var external_this_wp_blocks_ = __webpack_require__(5);

// EXTERNAL MODULE: external {"this":["wp","apiFetch"]}
var external_this_wp_apiFetch_ = __webpack_require__(6);
var external_this_wp_apiFetch_default = /*#__PURE__*/__webpack_require__.n(external_this_wp_apiFetch_);

// EXTERNAL MODULE: external {"this":["wp","data"]}
var external_this_wp_data_ = __webpack_require__(2);

// EXTERNAL MODULE: external {"this":["wp","components"]}
var external_this_wp_components_ = __webpack_require__(3);

// EXTERNAL MODULE: external {"this":["wp","blockEditor"]}
var external_this_wp_blockEditor_ = __webpack_require__(1);

// EXTERNAL MODULE: external {"this":["wp","compose"]}
var external_this_wp_compose_ = __webpack_require__(7);

// CONCATENATED MODULE: ./.build/assets/gutenberg/icon/icon.jsx
// wanna use dashicon icons?
// do: export default ( 'lock' );
var _wp$components = wp.components,
    G = _wp$components.G,
    Path = _wp$components.Path,
    SVG = _wp$components.SVG;
/* harmony default export */ var icon_icon = (React.createElement(SVG, {
  width: "32",
  height: "30",
  viewBox: "0 0 32 30",
  xmlns: "http://www.w3.org/2000/svg",
  role: "img",
  "aria-hidden": "true",
  focusable: "false"
}, React.createElement(Path, {
  d: "M15.9999087,15.1219512 C16.3563467,15.1219512 16.6821997,15.320913 16.8416408,15.6359024 L16.8416408,15.6359024 L23.4291507,28.6548107 C23.6220875,29.036784 23.5270282,29.4994942 23.1986281,29.776902 C22.8702279,30.0543098 22.3928509,30.0751508 22.0409691,29.8274424 L22.0409691,29.8274424 L15.9999087,25.5638661 L9.95837776,29.8274424 C9.60649597,30.0751508 9.12911892,30.0543098 8.80071877,29.776902 C8.47231863,29.4994942 8.37725938,29.036784 8.57019618,28.6548107 L8.57019618,28.6548107 L15.1581766,15.6359024 C15.3176177,15.320913 15.6434707,15.1219512 15.9999087,15.1219512 Z M15.9999087,18.1312319 L11.9483008,26.1378605 L15.4527534,23.6643842 C15.7799902,23.4334226 16.2195919,23.4334226 16.5468287,23.6643842 L16.5468287,23.6643842 L20.0515166,26.1378605 L15.9999087,18.1312319 Z M17.8821888,0.000261344084 C18.4019661,0.000261344084 18.8233289,0.419808629 18.8233289,0.937346434 L18.8233289,0.937346434 L18.8233289,1.87443152 L26.3524493,1.87443152 C26.4051018,1.87475782 26.4576351,1.87945957 26.5095021,1.8884878 C26.9052316,0.759035914 27.9744849,0.00182881521 29.1758695,0.000261344084 C30.6136854,-1.0658141e-14 31.8220607,1.07561748 31.9822416,2.49832664 C32.1424225,3.92103581 31.2032421,5.23637091 29.8010568,5.55310584 C28.3988715,5.86984077 26.981585,5.0868001 26.5095021,3.73454543 C26.4576351,3.74357366 26.4051018,3.7482754 26.3524493,3.7486017 L26.3524493,3.7486017 L24.1172417,3.7486017 C26.9969229,5.64829417 28.8458222,8.75506315 29.1363416,12.1823675 L29.1363416,12.1823675 L30.1170095,12.1823675 C30.6367868,12.1823675 31.0581496,12.6019148 31.0581496,13.1194526 L31.0581496,13.1194526 L31.0581496,16.867793 C31.0581496,17.3853308 30.6367868,17.804878 30.1170095,17.804878 L30.1170095,17.804878 L26.3524493,17.804878 C25.832672,17.804878 25.4113093,17.3853308 25.4113093,16.867793 L25.4113093,16.867793 L25.4113093,13.1194526 C25.4113093,12.6019148 25.832672,12.1823675 26.3524493,12.1823675 L26.3524493,12.1823675 L27.2465324,12.1823675 C26.7928672,7.75096009 23.2739119,4.24716649 18.8233289,3.79545596 L18.8233289,3.79545596 L18.8233289,4.68568679 C18.8233289,5.2032246 18.4019661,5.62277188 17.8821888,5.62277188 L17.8821888,5.62277188 L14.1176286,5.62277188 C13.5978513,5.62277188 13.1764885,5.2032246 13.1764885,4.68568679 L13.1764885,4.68568679 L13.1764885,3.79545596 C8.72590548,4.24716649 5.20695022,7.75096009 4.75328504,12.1823675 L4.75328504,12.1823675 L5.64736809,12.1823675 C6.16714539,12.1823675 6.58850815,12.6019148 6.58850815,13.1194526 L6.58850815,13.1194526 L6.58850815,16.867793 C6.58850815,17.3853308 6.16714539,17.804878 5.64736809,17.804878 L5.64736809,17.804878 L1.88280787,17.804878 C1.36303057,17.804878 0.941667812,17.3853308 0.941667812,16.867793 L0.941667812,16.867793 L0.941667812,13.1194526 C0.941667812,12.6019148 1.36303057,12.1823675 1.88280787,12.1823675 L1.88280787,12.1823675 L2.86382873,12.1823675 C3.15426653,8.75512637 5.00302871,5.64836938 7.88257572,3.7486017 L7.88257572,3.7486017 L5.64736809,3.7486017 C5.59471557,3.7482754 5.54218228,3.74357366 5.49031534,3.73454543 C5.03789344,5.0304823 3.71205093,5.81195983 2.35334793,5.58353542 C0.994644933,5.35511102 -1.77635684e-15,4.18351441 -1.77635684e-15,2.81151661 C-1.77635684e-15,1.43951882 0.994644933,0.267922207 2.35334793,0.0394978022 C3.71205093,-0.188926603 5.03789344,0.592550929 5.49031534,1.8884878 C5.54218228,1.87945957 5.59471557,1.87475782 5.64736809,1.87443152 L5.64736809,1.87443152 L13.1764885,1.87443152 L13.1764885,0.937346434 C13.1764885,0.419808629 13.5978513,0.000261344084 14.1176286,0.000261344084 L14.1176286,0.000261344084 Z M4.70622803,14.0565377 L2.82394792,14.0565377 L2.82394792,15.9307079 L4.70622803,15.9307079 L4.70622803,14.0565377 Z M29.1758695,14.0565377 L27.2935894,14.0565377 L27.2935894,15.9307079 L29.1758695,15.9307079 L29.1758695,14.0565377 Z M2.82394792,1.87443152 C2.30417062,1.87443152 1.88280787,2.29397881 1.88280787,2.81151661 C1.88280787,3.32905442 2.30417062,3.7486017 2.82394792,3.7486017 C3.34348334,3.74802072 3.76450449,3.32881358 3.76508798,2.81151661 C3.76508798,2.29397881 3.34372522,1.87443152 2.82394792,1.87443152 Z M16.9410488,1.87443152 L15.0587686,1.87443152 L15.0587686,3.7486017 L16.9410488,3.7486017 L16.9410488,1.87443152 Z M29.1758695,1.87443152 C28.6560922,1.87443152 28.2347294,2.29397881 28.2347294,2.81151661 C28.2347294,3.32905442 28.6560922,3.7486017 29.1758695,3.7486017 C29.6954049,3.74802072 30.116426,3.32881358 30.1170095,2.81151661 C30.1170095,2.29397881 29.6956468,1.87443152 29.1758695,1.87443152 Z"
})));
// CONCATENATED MODULE: ./.build/assets/gutenberg/icon/block.jsx
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }










/**
 * Register secure block
 */

/* harmony default export */ var block = (Object(external_this_wp_blocks_["registerBlockType"])('shp-icon/icon', {
  title: Object(external_this_wp_i18n_["_x"])('SVG Icon', 'SVG icon block title', 'shp-icon'),
  description: Object(external_this_wp_i18n_["__"])('Use your SVG icons as Gutenberg block', 'shp-icon'),
  icon: icon_icon,
  category: 'embed',
  keywords: [Object(external_this_wp_i18n_["__"])('Icons'), Object(external_this_wp_i18n_["__"])('SVG')],
  supports: {
    align: true
  },
  attributes: {
    icon: {
      type: 'string',
      default: null
    },
    boxModel: {
      type: 'string',
      default: 'block'
    },
    scaleFactor: {
      type: 'number',
      default: parseFloat(shp_icon_data.scaleFactor)
    },
    topShift: {
      type: 'number',
      default: parseFloat(shp_icon_data.topShift)
    },
    color: {
      type: 'string',
      default: 'inherit'
    },
    backgroundColor: {
      type: 'string',
      default: 'transparent'
    },
    align: {
      type: 'string',
      default: 'normal'
    }
  },
  edit: Object(external_this_wp_data_["withSelect"])(function (select) {
    return {
      iconList: select('shp-icon/icon-list').recieveIcons()
    };
  })(function (props) {
    var _props$attributes = props.attributes,
        icon = _props$attributes.icon,
        boxModel = _props$attributes.boxModel,
        scaleFactor = _props$attributes.scaleFactor,
        topShift = _props$attributes.topShift,
        color = _props$attributes.color,
        backgroundColor = _props$attributes.backgroundColor,
        verticalAlignment = _props$attributes.verticalAlignment,
        attributes = props.attributes,
        iconList = props.iconList,
        className = props.className,
        setAttributes = props.setAttributes;

    if (!iconList.length) {
      return React.createElement("div", {
        className: "components-placeholder"
      }, React.createElement("div", {
        className: "components-placeholder__fieldset"
      }, React.createElement("div", {
        className: "components-spinner"
      })));
    }

    var hasCurrentColor = false;

    if (icon) {
      var index = iconList.findIndex(function (x) {
        return x.filename === icon;
      });

      if (-1 !== index && -1 !== iconList[index]['svg'].toLowerCase().search('currentcolor')) {
        hasCurrentColor = true;
      }
    }

    return [React.createElement(external_this_wp_blockEditor_["BlockControls"], null), React.createElement(external_this_wp_blockEditor_["InspectorControls"], {
      className: "shp-icon-controls"
    }, React.createElement(external_this_wp_components_["PanelBody"], {
      title: Object(external_this_wp_i18n_["_x"])('Icon Collection', 'SVG icon block panel title', 'shp-icon'),
      initialOpen: true
    }, React.createElement("div", {
      className: "shp-icon-controls__icon-list"
    }, React.createElement(external_this_wp_components_["RadioControl"], {
      selected: icon,
      options: iconList.map(function (icon) {
        return {
          label: React.createElement("i", {
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
    }))), React.createElement(external_this_wp_blockEditor_["PanelColorSettings"], {
      title: Object(external_this_wp_i18n_["_x"])('Color Settings', 'SVG icon block PanelColorSettings label', 'shp-icon'),
      colorSettings: [{
        value: color,
        onChange: function onChange(color) {
          if (typeof color !== "undefined") {
            setAttributes({
              color: color
            });
          } else {
            setAttributes({
              color: 'inherit'
            });
          }

          ;
        },
        label: Object(external_this_wp_i18n_["_x"])('Color', 'SVG icon block colorSettings label', 'shp-icon')
      }, {
        value: backgroundColor,
        onChange: function onChange(backgroundColor) {
          if (typeof backgroundColor !== "undefined") {
            setAttributes({
              backgroundColor: backgroundColor
            });
          } else {
            setAttributes({
              backgroundColor: 'transparent'
            });
          }

          ;
        },
        label: Object(external_this_wp_i18n_["_x"])('Background Color', 'SVG icon block colorSettings label', 'shp-icon')
      }]
    }, !hasCurrentColor && React.createElement("i", {
      style: {
        color: 'red'
      }
    }, Object(external_this_wp_i18n_["_x"])('The color feature only works with SVG’s using currentColor. No currentColor value found in the selected SVG.', 'SVG icon block colorSettings notice', 'shp-icon')))), React.createElement(external_this_wp_serverSideRender_default.a, {
      block: "shp-icon/icon",
      attributes: attributes
    })];
  }),
  save: function save(props) {
    return null;
  }
}));
var actions = {
  setIcons: function setIcons(icons) {
    return {
      type: 'SET_ICONS',
      icons: icons
    };
  },
  recieveIcons: function recieveIcons(path) {
    return {
      type: 'RECIEVE_ICONS',
      path: path
    };
  }
};
var store = Object(external_this_wp_data_["registerStore"])('shp-icon/icon-list', {
  reducer: function reducer() {
    var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
      icons: {}
    };
    var action = arguments.length > 1 ? arguments[1] : undefined;

    switch (action.type) {
      case 'SET_ICONS':
        return _objectSpread({}, state, {
          icons: action.icons
        });
    }

    return state;
  },
  actions: actions,
  selectors: {
    recieveIcons: function recieveIcons(state) {
      var icons = state.icons;
      return icons;
    }
  },
  controls: {
    RECIEVE_ICONS: function RECIEVE_ICONS(action) {
      return external_this_wp_apiFetch_default()({
        path: action.path
      });
    }
  },
  resolvers: {
    recieveIcons:
    /*#__PURE__*/
    regeneratorRuntime.mark(function recieveIcons(state) {
      var icons;
      return regeneratorRuntime.wrap(function recieveIcons$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return actions.recieveIcons('/shp-icon/v1/icons/');

            case 2:
              icons = _context.sent;
              return _context.abrupt("return", actions.setIcons(icons));

            case 4:
            case "end":
              return _context.stop();
          }
        }
      }, recieveIcons);
    })
  }
});
// CONCATENATED MODULE: ./.build/assets/gutenberg/blocks.js


/***/ })
/******/ ]);