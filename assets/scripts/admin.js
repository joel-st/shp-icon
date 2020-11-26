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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["i18n"]; }());

/***/ }),
/* 1 */
/***/ (function(module, exports) {

(function ($) {
  $(function () {
    var $actionToggle = $('.shp-icon-list__actions-toggle');
    $actionToggle.on('click', function () {
      $toggle = $(this);
      $item = $toggle.parent().parent();
      $actions = $item.find('.shp-icon-list__action-list');
      $icon = $item.find('.shp-icon-list__icon > svg');
      $actions.slideToggle('fast');
      $item.toggleClass('shp-icon-list__item--actions-visible');
    });
  });
})(jQuery);

/***/ }),
/* 2 */,
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXTERNAL MODULE: external {"window":["wp","i18n"]}
var external_window_wp_i18n_ = __webpack_require__(0);

// EXTERNAL MODULE: ./.build/assets/scripts/admin/icon-actions.js
var icon_actions = __webpack_require__(1);

// CONCATENATED MODULE: ./.build/assets/scripts/admin/search-icon.js


(function ($) {
  $(function () {
    var $search = $('#media-search-input');
    $search.on('input', function (event) {
      var $input = $(this);
      var value = $input.val();
      var $icons = $('.shp-icon-list__item').not('.shp-icon-list__item--no-results');
      $('.shp-icon-list__item--no-results').hide();

      if (value && value !== '') {
        value = value.replace(' ', '-').toLowerCase();
        var $results = $('svg[data-shp-icon*="' + value + '"]');
        $icons.hide();

        if ($results.length) {
          $results.parent().parent().parent().show();
        } else {
          $('.shp-icon-list__item--no-results').show();
        }
      } else {
        $icons.show();
      }
    });
  });
})(jQuery);
// CONCATENATED MODULE: ./.build/assets/scripts/admin/upload.js


(function ($) {
  $(function () {
    var $fileInput = $('#shp-icon-upload-input');
    var $form = $('#shp-icon-upload .shp-icon-upload__form');
    var $pageTitleActionElement = $('.page-title-action');

    if ($fileInput) {
      var $statusElement = $('.shp-icon-upload__status');
      $fileInput.change(function () {
        //$pageTitleActionElement.attr('disabled', 'true');
        var fileList = $fileInput[0].files;
        var uploadId = 1;
        Object.keys(fileList).forEach(function (key) {
          var $status = $('<div class="notice notice-info" data-id="' + uploadId + '"><p><b class="notice__filename">' + fileList[key]['name'] + '</b> <span>' + Object(external_window_wp_i18n_["_x"])('processing', 'Admin notice processing [Filename] if file is selected for upload', 'shp-icon') + '</span></p><div class="spinner is-active"></div></div>');
          $statusElement.append($status);
          var formData = new FormData();
          formData.append('action', shp_icon_data.action);
          formData.append('_wpnonce', shp_icon_data.ajaxNonce);
          formData.append('file', fileList[key]);
          formData.append('id', uploadId);
          $.ajax({
            type: 'POST',
            url: shp_icon_data.ajaxUrl,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function success(response) {
              console.log(response);
              var $notice = $('[data-id="' + response.id + '"]');
              $notice.removeClass('notice-info');
              $notice.find('.spinner').remove();

              if (response.upload.error) {
                $notice.addClass('notice-error');
                $notice.find('p span').html(Object(external_window_wp_i18n_["_x"])('Something went wrong while processing the file.', 'Admin notice response.upload.error returns true', 'shp-icon'));
              } else {
                $notice.addClass('notice-success');
                $notice.find('p span').html('<b>' + response.name + '</b> ' + Object(external_window_wp_i18n_["_x"])('Added successfully!', 'Admin notice [Icon] added successfully', 'shp-icon'));
                insertIcon(response.fileName);
              }
            },
            error: function error(XMLHttpRequest, textStatus, errorThrown) {
              $notice = $('[data-id="' + XMLHttpRequest.responseJSON.id + '"]');
              $notice.removeClass('notice-info');
              $notice.find('.spinner').remove();
              $notice.addClass('notice-error');
              $notice.find('p span').html(Object(external_window_wp_i18n_["_x"])('Upload failed!', 'Admin notice upload failed', 'shp-icon') + ' <i class="notice__error">' + XMLHttpRequest.responseJSON.message + '</i>');
              console.log(XMLHttpRequest);
            }
          });
          uploadId++;
        });
      });

      function insertIcon(icon) {
        $.ajax({
          type: 'POST',
          url: shp_icon_data.ajaxUrl,
          data: {
            action: 'shp_icon_push_icon',
            icon: icon
          },
          success: function success(response) {
            $('.shp-icon-list').prepend(response);
            $toggle = $($('.shp-icon-list__item')[0]).find('.shp-icon-list__actions-toggle');
            $toggle.on('click', function () {
              $item = $toggle.parent().parent();
              $actions = $item.find('.shp-icon-list__action-list');
              $icon = $item.find('.shp-icon-list__icon > svg');
              $actions.slideToggle('fast');
              $item.toggleClass('shp-icon-list__item--actions-visible');
            });
            console.log(response);
          },
          error: function error(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    }
  });
})(jQuery);
// CONCATENATED MODULE: ./.build/assets/scripts/admin/delete.js



(function ($) {
  $(function () {
    var $deleteAction = $('.shp-icon-list__action-remove');
    $deleteAction.on('click', function (event) {
      event.preventDefault();
      var $item = $(this).closest('.shp-icon-list__item');
      var fileName = $item.find('.shp-icon-list__icon svg').attr('data-shp-icon');
      var iconName = $item.find('.shp-icon-list__name').text();

      if (confirm(Object(external_window_wp_i18n_["_x"])('Confirm Deletion of', 'Confirm deletion. Confirm deletion of [IconName]', 'shp-icon') + ' ' + iconName)) {
        deleteIcon(fileName);
      }
    });
  });
})(jQuery);

function deleteIcon(icon) {
  (function ($) {
    if (icon) {
      if (!icon.includes('.svg')) {
        icon = icon + '.svg';
      }

      $.ajax({
        type: 'POST',
        url: shp_icon_data.ajaxUrl,
        data: {
          action: 'shp_icon_delete',
          file_name: icon
        },
        success: function success(response) {
          var $icon = $('[data-shp-icon="' + response.fileName.replace('.svg', '') + '"]');
          var $item = $icon.closest('.shp-icon-list__item');
          var $statusElement = $('.shp-icon-upload__status');
          var $status = $('<div class="notice notice-success"><p><b class="notice__filename">' + response.name + '</b> <span>' + Object(external_window_wp_i18n_["_x"])('deleted', 'Admin notice delete file sucessfully', 'shp-icon') + '</span></p></div>');
          $statusElement.append($status);

          if ($item) {
            $item.remove();
          }

          console.log(response);
        },
        error: function error(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    }
  })(jQuery);
}
// CONCATENATED MODULE: ./.build/assets/scripts/admin/index.js
/**
 * Scripts for WordPress Admin (not Gutenberg)
 */
 // import './toggle-upload';




 //import { iconFallback } from '../ui/icon';

/***/ })
/******/ ]);