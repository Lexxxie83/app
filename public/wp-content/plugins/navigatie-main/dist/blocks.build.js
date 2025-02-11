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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!**************************!*\
  !*** external "wp.i18n" ***!
  \**************************/
/*! dynamic exports provided */
/*! exports used: __ */
/***/ (function(module, exports) {

module.exports = wp.i18n;

/***/ }),
/* 1 */
/*!***********************!*\
  !*** ./src/blocks.js ***!
  \***********************/
/*! exports provided: registerIndrukwekkendBlocks */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"registerIndrukwekkendBlocks\", function() { return registerIndrukwekkendBlocks; });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_blocks__ = __webpack_require__(/*! @wordpress/blocks */ 2);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_blocks___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__wordpress_blocks__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__navigatie__ = __webpack_require__(/*! ./navigatie */ 3);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__socialmedia__ = __webpack_require__(/*! ./socialmedia */ 7);\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\n/* eslint-disable no-console */\n/**\n * Gutenberg Blocks\n *\n * All blocks related JavaScript files should be imported here.\n * You can create a new block folder in this dir and include code\n * for that block here as well.\n *\n * All blocks should be included here since this is the file that\n * Webpack is compiling as the input file.\n */\n\n/**\n * WordPress dependencies\n */\n\n\n/**\n * Internal dependencies\n * Hier kan een extra blok toegevoegd worden, die moet hieronder geregistreerd worden.\n */\n\n// import * as faq from './faq';\n\n\n\n/**\n * Function to register an individual block.\n *\n * @param {Object} block The block to be registered.\n *\n */\nvar registerBlock = function registerBlock(block) {\n  if (!block) {\n    return;\n  }\n  var metadata = block.metadata,\n      settings = block.settings,\n      name = block.name;\n\n  if (metadata) {\n    Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_blocks__[\"unstable__bootstrapServerSideBlockDefinitions\"])(_defineProperty({}, name, metadata));\n  }\n  Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_blocks__[\"registerBlockType\"])(name, settings);\n};\n\n/**\n * Function to register core blocks provided by the block editor.\n * test\n */\nvar registerIndrukwekkendBlocks = function registerIndrukwekkendBlocks() {\n  [\n  // Common blocks are grouped at the top to prioritize their display\n  // in various contexts — like the inserter and auto-complete components.\n  // faq,\n  __WEBPACK_IMPORTED_MODULE_1__navigatie__, __WEBPACK_IMPORTED_MODULE_2__socialmedia__].forEach(registerBlock);\n};\n\nregisterIndrukwekkendBlocks();//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9ibG9ja3MuanM/N2I1YiJdLCJzb3VyY2VzQ29udGVudCI6WyJmdW5jdGlvbiBfZGVmaW5lUHJvcGVydHkob2JqLCBrZXksIHZhbHVlKSB7IGlmIChrZXkgaW4gb2JqKSB7IE9iamVjdC5kZWZpbmVQcm9wZXJ0eShvYmosIGtleSwgeyB2YWx1ZTogdmFsdWUsIGVudW1lcmFibGU6IHRydWUsIGNvbmZpZ3VyYWJsZTogdHJ1ZSwgd3JpdGFibGU6IHRydWUgfSk7IH0gZWxzZSB7IG9ialtrZXldID0gdmFsdWU7IH0gcmV0dXJuIG9iajsgfVxuXG4vKiBlc2xpbnQtZGlzYWJsZSBuby1jb25zb2xlICovXG4vKipcbiAqIEd1dGVuYmVyZyBCbG9ja3NcbiAqXG4gKiBBbGwgYmxvY2tzIHJlbGF0ZWQgSmF2YVNjcmlwdCBmaWxlcyBzaG91bGQgYmUgaW1wb3J0ZWQgaGVyZS5cbiAqIFlvdSBjYW4gY3JlYXRlIGEgbmV3IGJsb2NrIGZvbGRlciBpbiB0aGlzIGRpciBhbmQgaW5jbHVkZSBjb2RlXG4gKiBmb3IgdGhhdCBibG9jayBoZXJlIGFzIHdlbGwuXG4gKlxuICogQWxsIGJsb2NrcyBzaG91bGQgYmUgaW5jbHVkZWQgaGVyZSBzaW5jZSB0aGlzIGlzIHRoZSBmaWxlIHRoYXRcbiAqIFdlYnBhY2sgaXMgY29tcGlsaW5nIGFzIHRoZSBpbnB1dCBmaWxlLlxuICovXG5cbi8qKlxuICogV29yZFByZXNzIGRlcGVuZGVuY2llc1xuICovXG5pbXBvcnQgeyByZWdpc3RlckJsb2NrVHlwZSwgdW5zdGFibGVfX2Jvb3RzdHJhcFNlcnZlclNpZGVCbG9ja0RlZmluaXRpb25zIH0gZnJvbSAvLyBlc2xpbnQtZGlzYWJsZS1saW5lIGNhbWVsY2FzZVxuJ0B3b3JkcHJlc3MvYmxvY2tzJztcblxuLyoqXG4gKiBJbnRlcm5hbCBkZXBlbmRlbmNpZXNcbiAqIEhpZXIga2FuIGVlbiBleHRyYSBibG9rIHRvZWdldm9lZ2Qgd29yZGVuLCBkaWUgbW9ldCBoaWVyb25kZXIgZ2VyZWdpc3RyZWVyZCB3b3JkZW4uXG4gKi9cblxuLy8gaW1wb3J0ICogYXMgZmFxIGZyb20gJy4vZmFxJztcbmltcG9ydCAqIGFzIG5hdmlnYXRpZSBmcm9tICcuL25hdmlnYXRpZSc7XG5pbXBvcnQgKiBhcyBzb2NpYWxtZWRpYSBmcm9tICcuL3NvY2lhbG1lZGlhJztcblxuLyoqXG4gKiBGdW5jdGlvbiB0byByZWdpc3RlciBhbiBpbmRpdmlkdWFsIGJsb2NrLlxuICpcbiAqIEBwYXJhbSB7T2JqZWN0fSBibG9jayBUaGUgYmxvY2sgdG8gYmUgcmVnaXN0ZXJlZC5cbiAqXG4gKi9cbnZhciByZWdpc3RlckJsb2NrID0gZnVuY3Rpb24gcmVnaXN0ZXJCbG9jayhibG9jaykge1xuICBpZiAoIWJsb2NrKSB7XG4gICAgcmV0dXJuO1xuICB9XG4gIHZhciBtZXRhZGF0YSA9IGJsb2NrLm1ldGFkYXRhLFxuICAgICAgc2V0dGluZ3MgPSBibG9jay5zZXR0aW5ncyxcbiAgICAgIG5hbWUgPSBibG9jay5uYW1lO1xuXG4gIGlmIChtZXRhZGF0YSkge1xuICAgIHVuc3RhYmxlX19ib290c3RyYXBTZXJ2ZXJTaWRlQmxvY2tEZWZpbml0aW9ucyhfZGVmaW5lUHJvcGVydHkoe30sIG5hbWUsIG1ldGFkYXRhKSk7XG4gIH1cbiAgcmVnaXN0ZXJCbG9ja1R5cGUobmFtZSwgc2V0dGluZ3MpO1xufTtcblxuLyoqXG4gKiBGdW5jdGlvbiB0byByZWdpc3RlciBjb3JlIGJsb2NrcyBwcm92aWRlZCBieSB0aGUgYmxvY2sgZWRpdG9yLlxuICogdGVzdFxuICovXG5leHBvcnQgdmFyIHJlZ2lzdGVySW5kcnVrd2Vra2VuZEJsb2NrcyA9IGZ1bmN0aW9uIHJlZ2lzdGVySW5kcnVrd2Vra2VuZEJsb2NrcygpIHtcbiAgW1xuICAvLyBDb21tb24gYmxvY2tzIGFyZSBncm91cGVkIGF0IHRoZSB0b3AgdG8gcHJpb3JpdGl6ZSB0aGVpciBkaXNwbGF5XG4gIC8vIGluIHZhcmlvdXMgY29udGV4dHMg4oCUIGxpa2UgdGhlIGluc2VydGVyIGFuZCBhdXRvLWNvbXBsZXRlIGNvbXBvbmVudHMuXG4gIC8vIGZhcSxcbiAgbmF2aWdhdGllLCBzb2NpYWxtZWRpYV0uZm9yRWFjaChyZWdpc3RlckJsb2NrKTtcbn07XG5cbnJlZ2lzdGVySW5kcnVrd2Vra2VuZEJsb2NrcygpO1xuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vc3JjL2Jsb2Nrcy5qc1xuLy8gbW9kdWxlIGlkID0gMVxuLy8gbW9kdWxlIGNodW5rcyA9IDAiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///1\n");

/***/ }),
/* 2 */
/*!****************************!*\
  !*** external "wp.blocks" ***!
  \****************************/
/*! dynamic exports provided */
/*! exports used: registerBlockType, unstable__bootstrapServerSideBlockDefinitions */
/***/ (function(module, exports) {

module.exports = wp.blocks;

/***/ }),
/* 3 */
/*!********************************!*\
  !*** ./src/navigatie/index.js ***!
  \********************************/
/*! exports provided: name, settings */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"name\", function() { return name; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"settings\", function() { return settings; });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__ = __webpack_require__(/*! @wordpress/i18n */ 0);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__editor_scss__ = __webpack_require__(/*! ./editor.scss */ 4);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__editor_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__editor_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__style_scss__ = __webpack_require__(/*! ./style.scss */ 5);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__style_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__edit__ = __webpack_require__(/*! ./edit */ 6);\n/**\n * BLOCK: indrukwekkend-blocks\n *\n * Registering a basic block with Gutenberg.\n */\n\n/**\n * WordPress dependencies\n */\n\n\n//  Import CSS.\n\n\n/**\n * Internal dependencies\n */\n\n\nvar name = 'indrukwekkend/navigatie';\n\nvar settings = {\n\ttitle: Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__[\"__\"])('navigatie'),\n\ticon: 'format-chat',\n\tcategory: 'indrukwekkend',\n\tkeywords: [Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__[\"__\"])('navigatie'), Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__[\"__\"])('post')],\n\tsupports: {\n\t\talign: ['wide', 'full'],\n\t\thtml: false\n\t},\n\tedit: __WEBPACK_IMPORTED_MODULE_3__edit__[\"a\" /* default */]\n\t//Collapse,\n};//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9uYXZpZ2F0aWUvaW5kZXguanM/NzY2ZiJdLCJzb3VyY2VzQ29udGVudCI6WyIvKipcbiAqIEJMT0NLOiBpbmRydWt3ZWtrZW5kLWJsb2Nrc1xuICpcbiAqIFJlZ2lzdGVyaW5nIGEgYmFzaWMgYmxvY2sgd2l0aCBHdXRlbmJlcmcuXG4gKi9cblxuLyoqXG4gKiBXb3JkUHJlc3MgZGVwZW5kZW5jaWVzXG4gKi9cbmltcG9ydCB7IF9fIH0gZnJvbSAnQHdvcmRwcmVzcy9pMThuJztcblxuLy8gIEltcG9ydCBDU1MuXG5pbXBvcnQgJy4vZWRpdG9yLnNjc3MnO1xuaW1wb3J0ICcuL3N0eWxlLnNjc3MnO1xuLyoqXG4gKiBJbnRlcm5hbCBkZXBlbmRlbmNpZXNcbiAqL1xuaW1wb3J0IGVkaXQgZnJvbSAnLi9lZGl0JztcblxuZXhwb3J0IHZhciBuYW1lID0gJ2luZHJ1a3dla2tlbmQvbmF2aWdhdGllJztcblxuZXhwb3J0IHZhciBzZXR0aW5ncyA9IHtcblx0dGl0bGU6IF9fKCduYXZpZ2F0aWUnKSxcblx0aWNvbjogJ2Zvcm1hdC1jaGF0Jyxcblx0Y2F0ZWdvcnk6ICdpbmRydWt3ZWtrZW5kJyxcblx0a2V5d29yZHM6IFtfXygnbmF2aWdhdGllJyksIF9fKCdwb3N0JyldLFxuXHRzdXBwb3J0czoge1xuXHRcdGFsaWduOiBbJ3dpZGUnLCAnZnVsbCddLFxuXHRcdGh0bWw6IGZhbHNlXG5cdH0sXG5cdGVkaXQ6IGVkaXRcblx0Ly9Db2xsYXBzZSxcbn07XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvbmF2aWdhdGllL2luZGV4LmpzXG4vLyBtb2R1bGUgaWQgPSAzXG4vLyBtb2R1bGUgY2h1bmtzID0gMCJdLCJtYXBwaW5ncyI6IkFBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///3\n");

/***/ }),
/* 4 */
/*!***********************************!*\
  !*** ./src/navigatie/editor.scss ***!
  \***********************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9uYXZpZ2F0aWUvZWRpdG9yLnNjc3M/ZmEyZSJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpblxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vc3JjL25hdmlnYXRpZS9lZGl0b3Iuc2Nzc1xuLy8gbW9kdWxlIGlkID0gNFxuLy8gbW9kdWxlIGNodW5rcyA9IDAiXSwibWFwcGluZ3MiOiJBQUFBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///4\n");

/***/ }),
/* 5 */
/*!**********************************!*\
  !*** ./src/navigatie/style.scss ***!
  \**********************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9uYXZpZ2F0aWUvc3R5bGUuc2Nzcz85NzgwIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luXG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvbmF2aWdhdGllL3N0eWxlLnNjc3Ncbi8vIG1vZHVsZSBpZCA9IDVcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///5\n");

/***/ }),
/* 6 */
/*!*******************************!*\
  !*** ./src/navigatie/edit.js ***!
  \*******************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("/* harmony export (immutable) */ __webpack_exports__[\"a\"] = navigatie;\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__ = __webpack_require__(/*! @wordpress/i18n */ 0);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__);\n/**\n * External dependencies\n */\n\n/**\n* WordPress dependencies\n*/\n\n\nfunction navigatie(_ref) {\n\tvar attributes = _ref.attributes,\n\t    setAttributes = _ref.setAttributes,\n\t    className = _ref.className;\n\n\n\treturn [wp.element.createElement(\n\t\t'div',\n\t\t{\n\t\t\tclassName: 'navigatie'\n\t\t},\n\t\twp.element.createElement(\n\t\t\t'span',\n\t\t\t{ clasName: 'text' },\n\t\t\t'Menu'\n\t\t)\n\t)];\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNi5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9uYXZpZ2F0aWUvZWRpdC5qcz8yOWJiIl0sInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogRXh0ZXJuYWwgZGVwZW5kZW5jaWVzXG4gKi9cblxuLyoqXG4qIFdvcmRQcmVzcyBkZXBlbmRlbmNpZXNcbiovXG5pbXBvcnQgeyBfXyB9IGZyb20gJ0B3b3JkcHJlc3MvaTE4bic7XG5cbmV4cG9ydCBkZWZhdWx0IGZ1bmN0aW9uIG5hdmlnYXRpZShfcmVmKSB7XG5cdHZhciBhdHRyaWJ1dGVzID0gX3JlZi5hdHRyaWJ1dGVzLFxuXHQgICAgc2V0QXR0cmlidXRlcyA9IF9yZWYuc2V0QXR0cmlidXRlcyxcblx0ICAgIGNsYXNzTmFtZSA9IF9yZWYuY2xhc3NOYW1lO1xuXG5cblx0cmV0dXJuIFt3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXG5cdFx0J2RpdicsXG5cdFx0e1xuXHRcdFx0Y2xhc3NOYW1lOiAnbmF2aWdhdGllJ1xuXHRcdH0sXG5cdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdFx0J3NwYW4nLFxuXHRcdFx0eyBjbGFzTmFtZTogJ3RleHQnIH0sXG5cdFx0XHQnTWVudSdcblx0XHQpXG5cdCldO1xufVxuXG5cbi8vLy8vLy8vLy8vLy8vLy8vL1xuLy8gV0VCUEFDSyBGT09URVJcbi8vIC4vc3JjL25hdmlnYXRpZS9lZGl0LmpzXG4vLyBtb2R1bGUgaWQgPSA2XG4vLyBtb2R1bGUgY2h1bmtzID0gMCJdLCJtYXBwaW5ncyI6IkFBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///6\n");

/***/ }),
/* 7 */
/*!**********************************!*\
  !*** ./src/socialmedia/index.js ***!
  \**********************************/
/*! exports provided: name, settings */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("Object.defineProperty(__webpack_exports__, \"__esModule\", { value: true });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"name\", function() { return name; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"settings\", function() { return settings; });\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__ = __webpack_require__(/*! @wordpress/i18n */ 0);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__editor_scss__ = __webpack_require__(/*! ./editor.scss */ 8);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__editor_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__editor_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__style_scss__ = __webpack_require__(/*! ./style.scss */ 9);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__style_scss__);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__edit__ = __webpack_require__(/*! ./edit */ 10);\n/**\n * BLOCK: indrukwekkend-blocks\n *\n * Registering a basic block with Gutenberg.\n */\n\n/**\n * WordPress dependencies\n */\n\n\n//  Import CSS.\n\n\n/**\n * Internal dependencies\n */\n\n\nvar name = 'indrukwekkend/socialmedia';\n\nvar settings = {\n\ttitle: Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__[\"__\"])('socialmedia'),\n\ticon: 'share',\n\tcategory: 'indrukwekkend',\n\tkeywords: [Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__[\"__\"])('socialmedia'), Object(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__[\"__\"])('post')],\n\tsupports: {\n\t\thtml: false\n\t},\n\tedit: __WEBPACK_IMPORTED_MODULE_3__edit__[\"a\" /* default */]\n\t//Collapse,\n};//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9zb2NpYWxtZWRpYS9pbmRleC5qcz9kMGU0Il0sInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogQkxPQ0s6IGluZHJ1a3dla2tlbmQtYmxvY2tzXG4gKlxuICogUmVnaXN0ZXJpbmcgYSBiYXNpYyBibG9jayB3aXRoIEd1dGVuYmVyZy5cbiAqL1xuXG4vKipcbiAqIFdvcmRQcmVzcyBkZXBlbmRlbmNpZXNcbiAqL1xuaW1wb3J0IHsgX18gfSBmcm9tICdAd29yZHByZXNzL2kxOG4nO1xuXG4vLyAgSW1wb3J0IENTUy5cbmltcG9ydCAnLi9lZGl0b3Iuc2Nzcyc7XG5pbXBvcnQgJy4vc3R5bGUuc2Nzcyc7XG4vKipcbiAqIEludGVybmFsIGRlcGVuZGVuY2llc1xuICovXG5pbXBvcnQgZWRpdCBmcm9tICcuL2VkaXQnO1xuXG5leHBvcnQgdmFyIG5hbWUgPSAnaW5kcnVrd2Vra2VuZC9zb2NpYWxtZWRpYSc7XG5cbmV4cG9ydCB2YXIgc2V0dGluZ3MgPSB7XG5cdHRpdGxlOiBfXygnc29jaWFsbWVkaWEnKSxcblx0aWNvbjogJ3NoYXJlJyxcblx0Y2F0ZWdvcnk6ICdpbmRydWt3ZWtrZW5kJyxcblx0a2V5d29yZHM6IFtfXygnc29jaWFsbWVkaWEnKSwgX18oJ3Bvc3QnKV0sXG5cdHN1cHBvcnRzOiB7XG5cdFx0aHRtbDogZmFsc2Vcblx0fSxcblx0ZWRpdDogZWRpdFxuXHQvL0NvbGxhcHNlLFxufTtcblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3NyYy9zb2NpYWxtZWRpYS9pbmRleC5qc1xuLy8gbW9kdWxlIGlkID0gN1xuLy8gbW9kdWxlIGNodW5rcyA9IDAiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///7\n");

/***/ }),
/* 8 */
/*!*************************************!*\
  !*** ./src/socialmedia/editor.scss ***!
  \*************************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiOC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9zb2NpYWxtZWRpYS9lZGl0b3Iuc2Nzcz80NTBlIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luXG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvc29jaWFsbWVkaWEvZWRpdG9yLnNjc3Ncbi8vIG1vZHVsZSBpZCA9IDhcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///8\n");

/***/ }),
/* 9 */
/*!************************************!*\
  !*** ./src/socialmedia/style.scss ***!
  \************************************/
/*! dynamic exports provided */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiOS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9zb2NpYWxtZWRpYS9zdHlsZS5zY3NzP2I2NTciXSwic291cmNlc0NvbnRlbnQiOlsiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW5cblxuXG4vLy8vLy8vLy8vLy8vLy8vLy9cbi8vIFdFQlBBQ0sgRk9PVEVSXG4vLyAuL3NyYy9zb2NpYWxtZWRpYS9zdHlsZS5zY3NzXG4vLyBtb2R1bGUgaWQgPSA5XG4vLyBtb2R1bGUgY2h1bmtzID0gMCJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///9\n");

/***/ }),
/* 10 */
/*!*********************************!*\
  !*** ./src/socialmedia/edit.js ***!
  \*********************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("/* harmony export (immutable) */ __webpack_exports__[\"a\"] = navigatie;\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__ = __webpack_require__(/*! @wordpress/i18n */ 0);\n/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__wordpress_i18n___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__wordpress_i18n__);\n/**\n * External dependencies\n */\n\n/**\n* WordPress dependencies\n*/\n\n\nfunction navigatie(_ref) {\n\tvar attributes = _ref.attributes,\n\t    setAttributes = _ref.setAttributes,\n\t    className = _ref.className;\n\n\n\treturn [wp.element.createElement(\n\t\t'div',\n\t\t{\n\t\t\tclassName: 'navigatie'\n\t\t},\n\t\twp.element.createElement(\n\t\t\t'span',\n\t\t\t{ clasName: 'text' },\n\t\t\t'Social Icons'\n\t\t)\n\t)];\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMTAuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9zcmMvc29jaWFsbWVkaWEvZWRpdC5qcz8wMWUwIl0sInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogRXh0ZXJuYWwgZGVwZW5kZW5jaWVzXG4gKi9cblxuLyoqXG4qIFdvcmRQcmVzcyBkZXBlbmRlbmNpZXNcbiovXG5pbXBvcnQgeyBfXyB9IGZyb20gJ0B3b3JkcHJlc3MvaTE4bic7XG5cbmV4cG9ydCBkZWZhdWx0IGZ1bmN0aW9uIG5hdmlnYXRpZShfcmVmKSB7XG5cdHZhciBhdHRyaWJ1dGVzID0gX3JlZi5hdHRyaWJ1dGVzLFxuXHQgICAgc2V0QXR0cmlidXRlcyA9IF9yZWYuc2V0QXR0cmlidXRlcyxcblx0ICAgIGNsYXNzTmFtZSA9IF9yZWYuY2xhc3NOYW1lO1xuXG5cblx0cmV0dXJuIFt3cC5lbGVtZW50LmNyZWF0ZUVsZW1lbnQoXG5cdFx0J2RpdicsXG5cdFx0e1xuXHRcdFx0Y2xhc3NOYW1lOiAnbmF2aWdhdGllJ1xuXHRcdH0sXG5cdFx0d3AuZWxlbWVudC5jcmVhdGVFbGVtZW50KFxuXHRcdFx0J3NwYW4nLFxuXHRcdFx0eyBjbGFzTmFtZTogJ3RleHQnIH0sXG5cdFx0XHQnU29jaWFsIEljb25zJ1xuXHRcdClcblx0KV07XG59XG5cblxuLy8vLy8vLy8vLy8vLy8vLy8vXG4vLyBXRUJQQUNLIEZPT1RFUlxuLy8gLi9zcmMvc29jaWFsbWVkaWEvZWRpdC5qc1xuLy8gbW9kdWxlIGlkID0gMTBcbi8vIG1vZHVsZSBjaHVua3MgPSAwIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///10\n");

/***/ })
/******/ ]);