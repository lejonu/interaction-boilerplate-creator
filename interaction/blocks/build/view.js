import * as __WEBPACK_EXTERNAL_MODULE__wordpress_interactivity_8e89b257__ from "@wordpress/interactivity";
/******/ var __webpack_modules__ = ({

/***/ "@wordpress/interactivity"
/*!*******************************************!*\
  !*** external "@wordpress/interactivity" ***!
  \*******************************************/
(module) {

module.exports = __WEBPACK_EXTERNAL_MODULE__wordpress_interactivity_8e89b257__;

/***/ }

/******/ });
/************************************************************************/
/******/ // The module cache
/******/ var __webpack_module_cache__ = {};
/******/ 
/******/ // The require function
/******/ function __webpack_require__(moduleId) {
/******/ 	// Check if module is in cache
/******/ 	var cachedModule = __webpack_module_cache__[moduleId];
/******/ 	if (cachedModule !== undefined) {
/******/ 		return cachedModule.exports;
/******/ 	}
/******/ 	// Check if module exists (development only)
/******/ 	if (__webpack_modules__[moduleId] === undefined) {
/******/ 		var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 		e.code = 'MODULE_NOT_FOUND';
/******/ 		throw e;
/******/ 	}
/******/ 	// Create a new module (and put it into the cache)
/******/ 	var module = __webpack_module_cache__[moduleId] = {
/******/ 		// no module.id needed
/******/ 		// no module.loaded needed
/******/ 		exports: {}
/******/ 	};
/******/ 
/******/ 	// Execute the module function
/******/ 	__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 
/******/ 	// Return the exports of the module
/******/ 	return module.exports;
/******/ }
/******/ 
/************************************************************************/
/******/ /* webpack/runtime/define property getters */
/******/ (() => {
/******/ 	// define getter functions for harmony exports
/******/ 	__webpack_require__.d = (exports, definition) => {
/******/ 		for(var key in definition) {
/******/ 			if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 				Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 			}
/******/ 		}
/******/ 	};
/******/ })();
/******/ 
/******/ /* webpack/runtime/hasOwnProperty shorthand */
/******/ (() => {
/******/ 	__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ })();
/******/ 
/******/ /* webpack/runtime/make namespace object */
/******/ (() => {
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = (exports) => {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/ })();
/******/ 
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   callbacks: () => (/* binding */ callbacks),
/* harmony export */   state: () => (/* binding */ state)
/* harmony export */ });
/* harmony import */ var _wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/interactivity */ "@wordpress/interactivity");

const {
  state,
  callbacks
} = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.store)('interaction-boilerplate-creator', {
  state: {
    darkTheme: false,
    isCreatingBoilerplate: false,
    hasCreatedBoilerplate: false,
    showMessage: false
  },
  actions: {
    setContextProperty: e => {
      state.showMessage = false;
      const context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      context[e.target.name] = e.target.value;
      if (e.target.name === 'project_name') {
        context.plugin_name = callbacks.normalizeName(e.target.value);
      }
      if (e.target.name === 'block_name') {
        context.plugin_block_name = callbacks.normalizeName(e.target.value);
      }
    },
    submitForm: async e => {
      e.preventDefault();
      const context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      if (context.project_name.trim().length >= 5 && callbacks.validateEmail(context.plugin_author_email)) {
        const {
          blogName,
          apiEndpoint,
          ...params
        } = context;
        state.showMessage = false;
        state.isCreatingBoilerplate = true;
        const response = await fetch(`${apiEndpoint}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': params.nonce
          },
          body: JSON.stringify({
            ...params
          })
        });
        const result = await response.json();
        context.message = result.message + ' Logged: ' + result.logged_user;
        if (result.status !== 200) {
          context.message = result.message + ' ' + result.logged_user;
          state.showMessage = true;
          state.isCreatingBoilerplate = false;
          return;
        }
        const delay = context.delayCreation * 1000;
        setTimeout(() => {
          state.isCreatingBoilerplate = false;
          state.hasCreatedBoilerplate = true;
          context.plugin_file_name = `${result.plugin_file_name}.zip`;
          context.downloadLink = result.download_link;
        }, delay);
      } else {
        context.message = 'Insufficient information. Please enter a valid project name and email address.';
        state.showMessage = true;
        state.isCreatingBoilerplate = false;
      }
    }
  },
  callbacks: {
    hideBlockType: () => {
      const context = (0,_wordpress_interactivity__WEBPACK_IMPORTED_MODULE_0__.getContext)();
      return !context.plugin_type || context.plugin_type === 'without_block';
    },
    hideForm: () => {
      return state.isCreatingBoilerplate || state.hasCreatedBoilerplate;
    },
    hideFormSubmittedCreating: () => {
      return !state.isCreatingBoilerplate || state.hasCreatedBoilerplate;
    },
    hideMessage: () => {
      return !state.showMessage;
    },
    normalizeName: name => {
      return name.normalize('NFD') // Decompose "á" into "a" + accent.
      .replace(/[\u0300-\u036f]/g, '') // Remove the diacritical accents.
      .replace(/[^a-zA-Z0-9 ]/g, '') // Remove special characters
      .replace(/\s+/g, ' ') // Remove multiple spaces
      .trim();
    },
    validateEmail: email => {
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      return emailPattern.test(email);
    }
  }
});
})();

const __webpack_exports__callbacks = __webpack_exports__.callbacks;
const __webpack_exports__state = __webpack_exports__.state;
export { __webpack_exports__callbacks as callbacks, __webpack_exports__state as state };

//# sourceMappingURL=view.js.map