/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(8);


/***/ },

/***/ 8:
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _imageUploader = __webpack_require__(9);

	var _imageUploader2 = _interopRequireDefault(_imageUploader);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var $ = jQuery;


	$('.imageUploader').each(function (i, e) {
		new _imageUploader2.default($(e), {});
	});

/***/ },

/***/ 9:
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
		value: true
	});

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

	var $ = jQuery;

	var imageWrap = function imageWrap(record, count, wrapClass) {
		_classCallCheck(this, imageWrap);

		_initialiseProps.call(this);

		this.record = record;
		this.count = count;
		this.isDeleted = false;
		this.elm;
		this.wrapClass = wrapClass;
		this.createUploadDiv();
		return this.elm;
	};

	var _initialiseProps = function _initialiseProps() {
		var _this2 = this;

		this.createUploadDiv = function () {
			var record = _this2.record;
			var image_id = record.image_id || 0;
			var image = record.image_name || 'default.png';
			var image_last = record.image_name || '';
			var image_alt_text = record.image_alt_text || '';
			var image_is_main = record.image_is_main == 1 ? 'checked' : '';
			var wrapClass = _this2.wrapClass || 'col-md-4 ';
			var imageDiv = ['<div  class="' + wrapClass + ' uploaderWrap" style="border: 1px solid #ccc;" >', '<div class=" well-sm no-shadow">', '<div style="height:20px" class="delete-img-wrap  "></div>', '<div class="img-preview">', '<img src="' + base + 'assets/uploads/images/' + image + '" class="img-responsive"></div>', '<input type="file" name="image_' + _this2.count + '">', '<input type="hidden"  name="image_delete_id[' + _this2.count + ']" value="" >', '<input type="hidden"  name="image_id[' + _this2.count + ']" value="' + image_id + '" >', '<input type="hidden"  name="image_id_' + _this2.count + '" value="' + image_id + '" >', '<input type="hidden"  name="image_last_' + _this2.count + '" value="' + image_last + '" >', '<input class="form-control" placeholder="image alt text"  name="image_alt_' + _this2.count + '" value="' + image_alt_text + '" >', '<div class="radio select_main_radio"> <label>', '<input type="radio" name="main_image"   value="' + _this2.count + '" ' + image_is_main + ' >', 'select as main image </label></div>', '</div></div>'].join('');
			var $imageDiv = $(imageDiv);

			if (image_id) {
				var deleteButton = $('<a>', {
					html: '<i class="fa fa-trash"></i>',
					href: '#',
					class: "pull-right text-danger delete-img"
				});
				$imageDiv.find('.delete-img-wrap').html(deleteButton);
			}
			if (record.image_is_main == 1) {
				$imageDiv.addClass('bg-info');
			}
			_this2.elm = $imageDiv;
			_this2.bindEvents();
		};

		this.bindEvents = function () {
			var $imageDiv = _this2.elm;
			$imageDiv.find('.delete-img').on('click', function (e) {
				e.preventDefault();
				var $this = $(e.currentTarget);

				if (!_this2.isDeleted) {
					_this2.removeImg();
				} else {
					_this2.undoRemove();
				}
			});

			$imageDiv.find('input:file').on('change', function (e) {
				_this2.showPreview(e.currentTarget);
			});

			$imageDiv.find('input:radio').on('click', function (e) {
				$(document).find('div.uploaderWrap').removeClass('bg-info');
				_this2.elm.addClass('bg-info');
			});
		};

		this.removeImg = function () {
			_this2.isDeleted = true;
			_this2.elm.find('input[name*="image_delete_id"]').val(_this2.record.image_id);
			_this2.elm.find('.delete-img').html('<i class="fa fa-undo text-info"></i>');
			_this2.elm.addClass('bg-danger');
		};

		this.undoRemove = function () {
			_this2.isDeleted = false;
			_this2.elm.find('input[name*="image_delete_id"]').val('');
			_this2.elm.find('.delete-img').html('<i class="fa fa-trash"></i>');
			_this2.elm.removeClass('bg-danger');
		};

		this.showPreview = function (input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					if (!$(input).closest('div').find('.img-preview').length) {
						$('<div>', { class: 'img-preview' }).insertBefore($(input));
					}
					var $img = $('<img>', {
						src: e.target.result,
						class: 'img-responsive'

					});
					$(input).closest('div').find('.img-preview').html($img);
				};

				reader.readAsDataURL(input.files[0]);
			}
		};
	};

	var imageUploader = function imageUploader(elm) {
		var _this = this;

		_classCallCheck(this, imageUploader);

		this.init = function () {
			_this.imageUploaderDiv = $('<div>', {
				class: 'col-md-12	'
			});
			_this.loadFromServer();
			_this.addUploadDivButton = $('<a>', {
				class: 'btn btn-succes clearFix pull-right',
				html: '<i class="fa  fa-plus-circle"></i> Add More Image(s)',
				click: _this.createUploadDiv
			});
			_this.elm.append(_this.imageUploaderDiv);
			_this.elm.append(_this.addUploadDivButton);
		};

		this.loadFromServer = function () {
			_this.imageUploaderDiv.html('<div class="text-center innerAll inner-2x"><i class="fa fa-spin fa-gear"></i> loading....</div>');
			var data = {
				image_ref_id: _this.options.image_ref_id,
				image_content_type: _this.options.image_content_type
			};
			$.ajax({
				url: base + 'img/list_json',
				data: data,
				type: 'post',
				dataType: 'json',
				success: function success(result) {
					_this.imageUploaderDiv.html('');
					$.each(result.rows, function (index, value) {
						_this.createUploadDiv(value);
					});
					if (typeof _this.options.initialCount != "undefined") {
						for (var j = _this.count; j <= _this.options.initialCount; j++) {
							_this.createUploadDiv({ record: {} });
						}
					}
				}
			});
		};

		this.createUploadDiv = function (record) {

			//this.bindEvents( $imageDiv );
			_this.imageUploaderDiv.append(new imageWrap(record, _this.count, _this.options.wrapClass));
			var perRow = _this.options.perRow || 3;
			if (_this.count % parseInt(perRow, 10) == 0) {
				_this.imageUploaderDiv.append($('<div style="clear:both"></div>'));
			}
			_this.count++;
		};

		this.elm = elm;
		this.options = elm.data('options');
		this.count = 1;
		this.init();
	};

	exports.default = imageUploader;

/***/ }

/******/ });