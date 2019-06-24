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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/libs/metisMenu.js":
/*!****************************************!*\
  !*** ./resources/js/libs/metisMenu.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*
 * metismenu - v1.1.3
 * Easy menu jQuery plugin for Twitter Bootstrap 3
 * https://github.com/onokumus/metisMenu
 *
 * Made by Osman Nuri Okumus
 * Under MIT License
 */
;

(function ($, window, document, undefined) {
  var pluginName = "metisMenu",
      defaults = {
    toggle: true,
    doubleTapToGo: false
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  }

  Plugin.prototype = {
    init: function init() {
      var $this = this.element,
          $toggle = this.settings.toggle,
          obj = this;

      if (this.isIE() <= 9) {
        $this.find("li.active").has("ul").children("ul").collapse("show");
        $this.find("li").not(".active").has("ul").children("ul").collapse("hide");
      } else {
        $this.find("li.active").has("ul").children("ul").addClass("collapse in");
        $this.find("li").not(".active").has("ul").children("ul").addClass("collapse");
      } //add the "doubleTapToGo" class to active items if needed


      if (obj.settings.doubleTapToGo) {
        $this.find("li.active").has("ul").children("a").addClass("doubleTapToGo");
      }

      $this.find("li").has("ul").children("a").on("click" + "." + pluginName, function (e) {
        e.preventDefault(); //Do we need to enable the double tap

        if (obj.settings.doubleTapToGo) {
          //if we hit a second time on the link and the href is valid, navigate to that url
          if (obj.doubleTapToGo($(this)) && $(this).attr("href") !== "#" && $(this).attr("href") !== "") {
            e.stopPropagation();
            document.location = $(this).attr("href");
            return;
          }
        }

        $(this).parent("li").toggleClass("active").children("ul").collapse("toggle");

        if ($toggle) {
          $(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide");
        }
      });
    },
    isIE: function isIE() {
      //https://gist.github.com/padolsey/527683
      var undef,
          v = 3,
          div = document.createElement("div"),
          all = div.getElementsByTagName("i");

      while (div.innerHTML = "<!--[if gt IE " + ++v + "]><i></i><![endif]-->", all[0]) {
        return v > 4 ? v : undef;
      }
    },
    //Enable the link on the second click.
    doubleTapToGo: function doubleTapToGo(elem) {
      var $this = this.element; //if the class "doubleTapToGo" exists, remove it and return

      if (elem.hasClass("doubleTapToGo")) {
        elem.removeClass("doubleTapToGo");
        return true;
      } //does not exists, add a new class and return false


      if (elem.parent().children("ul").length) {
        //first remove all other class
        $this.find(".doubleTapToGo").removeClass("doubleTapToGo"); //add the class on the current element

        elem.addClass("doubleTapToGo");
        return false;
      }
    },
    remove: function remove() {
      this.element.off("." + pluginName);
      this.element.removeData(pluginName);
    }
  };

  $.fn[pluginName] = function (options) {
    this.each(function () {
      var el = $(this);

      if (el.data(pluginName)) {
        el.data(pluginName).remove();
      }

      el.data(pluginName, new Plugin(this, options));
    });
    return this;
  };
})(jQuery, window, document);

/***/ }),

/***/ 3:
/*!**********************************************!*\
  !*** multi ./resources/js/libs/metisMenu.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/psalter/Code/codehacking/resources/js/libs/metisMenu.js */"./resources/js/libs/metisMenu.js");


/***/ })

/******/ });