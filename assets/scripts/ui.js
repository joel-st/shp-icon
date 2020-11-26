window["wp"] = window["wp"] || {}; window["wp"]["i18n"] =
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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["i18n"]; }());

/***/ }),
/* 1 */,
/* 2 */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-svgforeignobject-setclasses !*/
!function (e, n, s) {
  function o(e) {
    var n = f.className,
        s = Modernizr._config.classPrefix || "";

    if (c && (n = n.baseVal), Modernizr._config.enableJSClass) {
      var o = new RegExp("(^|\\s)" + s + "no-js(\\s|$)");
      n = n.replace(o, "$1" + s + "js$2");
    }

    Modernizr._config.enableClasses && (n += " " + s + e.join(" " + s), c ? f.className.baseVal = n : f.className = n);
  }

  function t(e, n) {
    return _typeof(e) === n;
  }

  function a() {
    var e, n, s, o, a, l, f;

    for (var c in r) {
      if (r.hasOwnProperty(c)) {
        if (e = [], n = r[c], n.name && (e.push(n.name.toLowerCase()), n.options && n.options.aliases && n.options.aliases.length)) for (s = 0; s < n.options.aliases.length; s++) {
          e.push(n.options.aliases[s].toLowerCase());
        }

        for (o = t(n.fn, "function") ? n.fn() : n.fn, a = 0; a < e.length; a++) {
          l = e[a], f = l.split("."), 1 === f.length ? Modernizr[f[0]] = o : (!Modernizr[f[0]] || Modernizr[f[0]] instanceof Boolean || (Modernizr[f[0]] = new Boolean(Modernizr[f[0]])), Modernizr[f[0]][f[1]] = o), i.push((o ? "" : "no-") + f.join("-"));
        }
      }
    }
  }

  var i = [],
      r = [],
      l = {
    _version: "3.6.0",
    _config: {
      classPrefix: "",
      enableClasses: !0,
      enableJSClass: !0,
      usePrefixes: !0
    },
    _q: [],
    on: function on(e, n) {
      var s = this;
      setTimeout(function () {
        n(s[e]);
      }, 0);
    },
    addTest: function addTest(e, n, s) {
      r.push({
        name: e,
        fn: n,
        options: s
      });
    },
    addAsyncTest: function addAsyncTest(e) {
      r.push({
        name: null,
        fn: e
      });
    }
  },
      Modernizr = function Modernizr() {};

  Modernizr.prototype = l, Modernizr = new Modernizr();
  var f = n.documentElement,
      c = "svg" === f.nodeName.toLowerCase(),
      u = {}.toString;
  Modernizr.addTest("svgforeignobject", function () {
    return !!n.createElementNS && /SVGForeignObject/.test(u.call(n.createElementNS("http://www.w3.org/2000/svg", "foreignObject")));
  }), a(), o(i), delete l.addTest, delete l.addAsyncTest;

  for (var d = 0; d < Modernizr._q.length; d++) {
    Modernizr._q[d]();
  }

  e.Modernizr = Modernizr;
}(window, document);

/***/ }),
/* 3 */,
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"window":["wp","i18n"]}
var external_window_wp_i18n_ = __webpack_require__(0);

// EXTERNAL MODULE: ./.build/assets/scripts/modernizr-svgforeignobject.js
var modernizr_svgforeignobject = __webpack_require__(2);

// CONCATENATED MODULE: ./.build/assets/scripts/ui/ie-polyfill.js
function iePolyfill() {
  //only IE has no support for svgforeignobject
  if (!Modernizr.svgforeignobject) {
    var iconBlocks = document.querySelectorAll('.shp-icon--block');

    if (iconBlocks.length) {
      // IE 11 compatible loop => https://developer.mozilla.org/en-US/docs/Web/API/NodeList
      Array.prototype.forEach.call(iconBlocks, function (iconBlock) {
        var icon = iconBlock.getElementsByTagName("svg");

        if (icon) {
          icon = icon[0];
          var viewBox = icon.getAttribute('viewBox') ? icon.getAttribute('viewBox').split(' ').length === 4 ? icon.getAttribute('viewBox').split(' ').map(Number) : false : false;
          var parentWidth = iconBlock.clientWidth;
          var fontSize = window.getComputedStyle(iconBlock, null).getPropertyValue('font-size');
          fontSize = parseFloat(fontSize) ? parseFloat(fontSize) : false;

          if (viewBox && parentWidth && fontSize) {
            var viewBoxWidth = viewBox[2];
            var viewBoxHeight = viewBox[3];
            var width = parentWidth / fontSize;
            var height = parentWidth * viewBoxHeight / viewBoxWidth / fontSize;
            icon.style.cssText = icon.style.cssText + 'width:' + width + 'em;height:' + height + 'em;';
          }
        }
      });
    }
  }
}
// CONCATENATED MODULE: ./.build/assets/scripts/ui/index.js
/**
 * Scripts for WordPress FrontEnd
 */



iePolyfill();

/***/ })
/******/ ]);