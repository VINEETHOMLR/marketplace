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
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(21);


/***/ },
/* 1 */,
/* 2 */
/***/ function(module, exports) {

	/*
		MIT License http://www.opensource.org/licenses/mit-license.php
		Author Tobias Koppers @sokra
	*/
	module.exports = function(src) {
		if (typeof execScript !== "undefined")
			execScript(src);
		else
			eval.call(null, src);
	}


/***/ },
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */,
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	__webpack_require__(22);
	__webpack_require__(24);
	$.trumbowyg.svgPath = base + 'scripts/downloads/trumbowyg/ui/icons.svg';
	$(document).find('textarea.trumbowyg').trumbowyg({
	       autogrow: true,
	       resetCss: true,
	       removeformatPasted: true,
	       btns: [['formatting'], 'btnGrp-semantic', ['link'], 'btnGrp-justify', 'btnGrp-lists', ['removeformat'], ['fullscreen']]
	});

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	__webpack_require__(2)(__webpack_require__(23))

/***/ },
/* 23 */
/***/ function(module, exports) {

	module.exports = "/** Trumbowyg v2.1.0 - A lightweight WYSIWYG editor - alex-d.github.io/Trumbowyg - License MIT - Author : Alexandre Demode (Alex-D) / alex-d.fr */\njQuery.trumbowyg={langs:{en:{viewHTML:\"View HTML\",undo:\"Undo\",redo:\"Redo\",formatting:\"Formatting\",p:\"Paragraph\",blockquote:\"Quote\",code:\"Code\",header:\"Header\",bold:\"Bold\",italic:\"Italic\",strikethrough:\"Stroke\",underline:\"Underline\",strong:\"Strong\",em:\"Emphasis\",del:\"Deleted\",superscript:\"Superscript\",subscript:\"Subscript\",unorderedList:\"Unordered list\",orderedList:\"Ordered list\",insertImage:\"Insert Image\",link:\"Link\",createLink:\"Insert link\",unlink:\"Remove link\",justifyLeft:\"Align Left\",justifyCenter:\"Align Center\",justifyRight:\"Align Right\",justifyFull:\"Align Justify\",horizontalRule:\"Insert horizontal rule\",removeformat:\"Remove format\",fullscreen:\"Fullscreen\",close:\"Close\",submit:\"Confirm\",reset:\"Cancel\",required:\"Required\",description:\"Description\",title:\"Title\",text:\"Text\",target:\"Target\"}},plugins:{},svgPath:null},function(e,t,n,a){\"use strict\";a.fn.trumbowyg=function(e,t){var n=\"trumbowyg\";if(e===Object(e)||!e)return this.each(function(){a(this).data(n)||a(this).data(n,new o(this,e))});if(1===this.length)try{var r=a(this).data(n);switch(e){case\"execCmd\":return r.execCmd(t.cmd,t.param,t.forceCss);case\"openModal\":return r.openModal(t.title,t.content);case\"closeModal\":return r.closeModal();case\"openModalInsert\":return r.openModalInsert(t.title,t.fields,t.callback);case\"saveRange\":return r.saveRange();case\"getRange\":return r.range;case\"getRangeText\":return r.getRangeText();case\"restoreRange\":return r.restoreRange();case\"enable\":return r.toggleDisable(!1);case\"disable\":return r.toggleDisable(!0);case\"destroy\":return r.destroy();case\"empty\":return r.empty();case\"html\":return r.html(t)}}catch(i){}return!1};var o=function(e,o){var r=this,i=\"trumbowyg-icons\";r.doc=e.ownerDocument||n,r.$ta=a(e),r.$c=a(e),o=o||{},null!=o.lang||null!=a.trumbowyg.langs[o.lang]?r.lang=a.extend(!0,{},a.trumbowyg.langs.en,a.trumbowyg.langs[o.lang]):r.lang=a.trumbowyg.langs.en;var s=null!=a.trumbowyg.svgPath?a.trumbowyg.svgPath:o.svgPath;if(r.hasSvg=s!==!1,r.svgPath=r.doc.querySelector(\"base\")?t.location:\"\",0===a(\"#\"+i,r.doc).length&&s!==!1){if(null==s)try{throw new Error}catch(l){var d=l.stack.split(\"\\n\");for(var c in d)if(d[c].match(/http[s]?:\\/\\//)){s=d[Number(c)].match(/((http[s]?:\\/\\/.+\\/)([^\\/]+\\.js)):/)[1].split(\"/\"),s.pop(),s=s.join(\"/\")+\"/ui/icons.svg\";break}}var u=r.doc.createElement(\"div\");u.id=i,r.doc.body.insertBefore(u,r.doc.body.childNodes[0]),a.get(s,function(e){u.innerHTML=(new XMLSerializer).serializeToString(e.documentElement)})}var g=r.lang.header,f=function(){return(t.chrome||t.Intl&&Intl.v8BreakIterator)&&\"CSS\"in t};r.btnsDef={viewHTML:{fn:\"toggle\"},undo:{isSupported:f,key:\"Z\"},redo:{isSupported:f,key:\"Y\"},p:{fn:\"formatBlock\"},blockquote:{fn:\"formatBlock\"},h1:{fn:\"formatBlock\",title:g+\" 1\"},h2:{fn:\"formatBlock\",title:g+\" 2\"},h3:{fn:\"formatBlock\",title:g+\" 3\"},h4:{fn:\"formatBlock\",title:g+\" 4\"},subscript:{tag:\"sub\"},superscript:{tag:\"sup\"},bold:{key:\"B\"},italic:{key:\"I\"},underline:{tag:\"u\"},strikethrough:{tag:\"strike\"},strong:{fn:\"bold\",key:\"B\"},em:{fn:\"italic\",key:\"I\"},del:{fn:\"strikethrough\"},createLink:{key:\"K\",tag:\"a\"},unlink:{},insertImage:{},justifyLeft:{tag:\"left\",forceCss:!0},justifyCenter:{tag:\"center\",forceCss:!0},justifyRight:{tag:\"right\",forceCss:!0},justifyFull:{tag:\"justify\",forceCss:!0},unorderedList:{fn:\"insertUnorderedList\",tag:\"ul\"},orderedList:{fn:\"insertOrderedList\",tag:\"ol\"},horizontalRule:{fn:\"insertHorizontalRule\"},removeformat:{},fullscreen:{\"class\":\"trumbowyg-not-disable\"},close:{fn:\"destroy\",\"class\":\"trumbowyg-not-disable\"},formatting:{dropdown:[\"p\",\"blockquote\",\"h1\",\"h2\",\"h3\",\"h4\"],ico:\"p\"},link:{dropdown:[\"createLink\",\"unlink\"]}},r.o=a.extend(!0,{},{lang:\"en\",fixedBtnPane:!1,fixedFullWidth:!1,autogrow:!1,prefix:\"trumbowyg-\",semantic:!0,resetCss:!1,removeformatPasted:!1,tagsToRemove:[],btnsGrps:{design:[\"bold\",\"italic\",\"underline\",\"strikethrough\"],semantic:[\"strong\",\"em\",\"del\"],justify:[\"justifyLeft\",\"justifyCenter\",\"justifyRight\",\"justifyFull\"],lists:[\"unorderedList\",\"orderedList\"]},btns:[[\"viewHTML\"],[\"undo\",\"redo\"],[\"formatting\"],\"btnGrp-semantic\",[\"superscript\",\"subscript\"],[\"link\"],[\"insertImage\"],\"btnGrp-justify\",\"btnGrp-lists\",[\"horizontalRule\"],[\"removeformat\"],[\"fullscreen\"]],btnsDef:{},inlineElementsSelector:\"a,abbr,acronym,b,caption,cite,code,col,dfn,dir,dt,dd,em,font,hr,i,kbd,li,q,span,strikeout,strong,sub,sup,u\",pasteHandlers:[],imgDblClickHandler:function(){var e=a(this),t=e.attr(\"src\"),n=\"(Base64)\";return 0===t.indexOf(\"data:image\")&&(t=n),r.openModalInsert(r.lang.insertImage,{url:{label:\"URL\",value:t,required:!0},alt:{label:r.lang.description,value:e.attr(\"alt\")}},function(t){return t.src!==n&&e.attr({src:t.src}),e.attr({alt:t.alt}),!0}),!1},plugins:{}},o),r.disabled=r.o.disabled||\"TEXTAREA\"===e.nodeName&&e.disabled,o.btns?r.o.btns=o.btns:r.o.semantic||(r.o.btns[4]=\"btnGrp-design\"),a.each(r.o.btnsDef,function(e,t){r.addBtnDef(e,t)}),r.keys=[],r.tagToButton={},r.tagHandlers=[],r.pasteHandlers=[].concat(r.o.pasteHandlers),r.init()};o.prototype={init:function(){var e=this;e.height=e.$ta.height(),e.initPlugins(),e.doc.execCommand(\"enableObjectResizing\",!1,!1),e.doc.execCommand(\"defaultParagraphSeparator\",!1,\"p\"),e.buildEditor(),e.buildBtnPane(),e.fixedBtnPaneEvents(),e.buildOverlay(),setTimeout(function(){e.disabled&&e.toggleDisable(!0),e.$c.trigger(\"tbwinit\")})},addBtnDef:function(e,t){this.btnsDef[e]=t},buildEditor:function(){var e=this,n=e.o.prefix,o=\"\";e.$box=a(\"<div/>\",{\"class\":n+\"box \"+n+\"editor-visible \"+n+e.o.lang+\" trumbowyg\"}),e.isTextarea=e.$ta.is(\"textarea\"),e.isTextarea?(o=e.$ta.val(),e.$ed=a(\"<div/>\"),e.$box.insertAfter(e.$ta).append(e.$ed,e.$ta)):(e.$ed=e.$ta,o=e.$ed.html(),e.$ta=a(\"<textarea/>\",{name:e.$ta.attr(\"id\"),height:e.height}).val(o),e.$box.insertAfter(e.$ed).append(e.$ta,e.$ed),e.syncCode()),e.$ta.addClass(n+\"textarea\").attr(\"tabindex\",-1),e.$ed.addClass(n+\"editor\").attr({contenteditable:!0,dir:e.lang._dir||\"ltr\"}).html(o),e.o.tabindex&&e.$ed.attr(\"tabindex\",e.o.tabindex),e.$c.is(\"[placeholder]\")&&e.$ed.attr(\"placeholder\",e.$c.attr(\"placeholder\")),e.o.resetCss&&e.$ed.addClass(n+\"reset-css\"),e.o.autogrow||e.$ta.add(e.$ed).css({height:e.height}),e.semanticCode(),e._ctrl=!1,e.$ed.on(\"dblclick\",\"img\",e.o.imgDblClickHandler).on(\"keydown\",function(t){if(e._composition=229===t.which,t.ctrlKey){e._ctrl=!0;var n=e.keys[String.fromCharCode(t.which).toUpperCase()];try{return e.execCmd(n.fn,n.param),!1}catch(a){}}}).on(\"keyup\",function(t){t.which>=37&&t.which<=40||(!t.ctrlKey||89!==t.which&&90!==t.which?e._ctrl||17===t.which||e._composition||(e.semanticCode(!1,13===t.which),e.$c.trigger(\"tbwchange\")):e.$c.trigger(\"tbwchange\"),setTimeout(function(){e._ctrl=!1},200))}).on(\"mouseup keydown keyup\",function(){e.updateButtonPaneStatus()}).on(\"focus blur\",function(t){e.$c.trigger(\"tbw\"+t.type),\"blur\"===t.type&&a(\".\"+n+\"active-button\",e.$btnPane).removeClass(n+\"active-button \"+n+\"active\")}).on(\"cut\",function(){e.$c.trigger(\"tbwchange\")}).on(\"paste\",function(n){if(e.o.removeformatPasted){n.preventDefault();try{var o=t.clipboardData.getData(\"Text\");try{e.doc.selection.createRange().pasteHTML(o)}catch(r){e.doc.getSelection().getRangeAt(0).insertNode(e.doc.createTextNode(o))}}catch(i){e.execCmd(\"insertText\",(n.originalEvent||n).clipboardData.getData(\"text/plain\"))}}a.each(e.pasteHandlers,function(e,t){t(n)}),setTimeout(function(){e.o.semantic?e.semanticCode(!1,!0):e.syncCode(),e.$c.trigger(\"tbwpaste\",n)},0)}),e.$ta.on(\"keyup paste\",function(){e.$c.trigger(\"tbwchange\")}),a(e.doc).on(\"keydown\",function(t){return 27===t.which?(e.closeModal(),!1):void 0})},buildBtnPane:function(){var e=this,t=e.o.prefix,n=e.$btnPane=a(\"<div/>\",{\"class\":t+\"button-pane\"});a.each(e.o.btns,function(o,r){try{var i=r.split(\"btnGrp-\");null!=i[1]&&(r=e.o.btnsGrps[i[1]])}catch(s){}a.isArray(r)||(r=[r]);var l=a(\"<div/>\",{\"class\":t+\"button-group \"+(r.indexOf(\"fullscreen\")>=0?t+\"right\":\"\")});a.each(r,function(t,n){try{var a;e.isSupportedBtn(n)&&(a=e.buildBtn(n)),l.append(a)}catch(o){}}),n.append(l)}),e.$box.prepend(n)},buildBtn:function(e){var t=this,n=t.o.prefix,o=t.btnsDef[e],r=o.dropdown,i=t.lang[e]||e,s=a(\"<button/>\",{type:\"button\",\"class\":n+e+\"-button \"+(o[\"class\"]||\"\"),html:t.hasSvg?'<svg><use xlink:href=\"'+t.svgPath+\"#\"+n+(o.ico||e).replace(/([A-Z]+)/g,\"-$1\").toLowerCase()+'\"/></svg>':\"\",title:(o.title||o.text||i)+(o.key?\" (Ctrl + \"+o.key+\")\":\"\"),tabindex:-1,mousedown:function(){return(!r||a(\".\"+e+\"-\"+n+\"dropdown\",t.$box).is(\":hidden\"))&&a(\"body\",t.doc).trigger(\"mousedown\"),!t.$btnPane.hasClass(n+\"disable\")||a(this).hasClass(n+\"active\")||a(this).hasClass(n+\"not-disable\")?(t.execCmd((r?\"dropdown\":!1)||o.fn||e,o.param||e,o.forceCss||!1),!1):!1}});if(r){s.addClass(n+\"open-dropdown\");var l=n+\"dropdown\",d=a(\"<div/>\",{\"class\":l+\"-\"+e+\" \"+l+\" \"+n+\"fixed-top\",\"data-dropdown\":e});a.each(r,function(e,n){t.btnsDef[n]&&t.isSupportedBtn(n)&&d.append(t.buildSubBtn(n))}),t.$box.append(d.hide())}else o.key&&(t.keys[o.key]={fn:o.fn||e,param:o.param||e});return r||(t.tagToButton[(o.tag||e).toLowerCase()]=e),s},buildSubBtn:function(e){var t=this,n=t.o.prefix,o=t.btnsDef[e];return o.key&&(t.keys[o.key]={fn:o.fn||e,param:o.param||e}),t.tagToButton[(o.tag||e).toLowerCase()]=e,a(\"<button/>\",{type:\"button\",\"class\":n+e+\"-dropdown-button\"+(o.ico?\" \"+n+o.ico+\"-button\":\"\"),html:t.hasSvg?'<svg><use xlink:href=\"'+t.svgPath+\"#\"+n+(o.ico||e).replace(/([A-Z]+)/g,\"-$1\").toLowerCase()+'\"/></svg>'+(o.text||o.title||t.lang[e]||e):\"\",title:o.key?\" (Ctrl + \"+o.key+\")\":null,style:o.style||null,mousedown:function(){return a(\"body\",t.doc).trigger(\"mousedown\"),t.execCmd(o.fn||e,o.param||e,o.forceCss||!1),!1}})},isSupportedBtn:function(e){try{return this.btnsDef[e].isSupported()}catch(t){}return!0},buildOverlay:function(){var e=this;return e.$overlay=a(\"<div/>\",{\"class\":e.o.prefix+\"overlay\"}).css({top:e.$btnPane.outerHeight(),height:e.$ed.outerHeight()+1+\"px\"}).appendTo(e.$box),e.$overlay},showOverlay:function(){var e=this;a(t).trigger(\"scroll\"),e.$overlay.fadeIn(200),e.$box.addClass(e.o.prefix+\"box-blur\")},hideOverlay:function(){var e=this;e.$overlay.fadeOut(50),e.$box.removeClass(e.o.prefix+\"box-blur\")},fixedBtnPaneEvents:function(){var e=this,n=e.o.fixedFullWidth,o=e.$box;e.o.fixedBtnPane&&(e.isFixed=!1,a(t).on(\"scroll resize\",function(){if(o){e.syncCode();var r=a(t).scrollTop(),i=o.offset().top+1,s=e.$btnPane,l=s.outerHeight()-2;r-i>0&&r-i-e.height<0?(e.isFixed||(e.isFixed=!0,s.css({position:\"fixed\",top:0,left:n?\"0\":\"auto\",zIndex:7}),a([e.$ta,e.$ed]).css({marginTop:s.height()})),s.css({width:n?\"100%\":o.width()-1+\"px\"}),a(\".\"+e.o.prefix+\"fixed-top\",o).css({position:n?\"fixed\":\"absolute\",top:n?l:l+(r-i)+\"px\",zIndex:15})):e.isFixed&&(e.isFixed=!1,s.removeAttr(\"style\"),a([e.$ta,e.$ed]).css({marginTop:0}),a(\".\"+e.o.prefix+\"fixed-top\",o).css({position:\"absolute\",top:l}))}}))},toggleDisable:function(e){var t=this,n=t.o.prefix;t.disabled=e,e?t.$ta.attr(\"disabled\",!0):t.$ta.removeAttr(\"disabled\"),t.$box.toggleClass(n+\"disabled\",e),t.$ed.attr(\"contenteditable\",!e)},destroy:function(){var e=this,t=e.o.prefix,n=e.height;e.isTextarea?e.$box.after(e.$ta.css({height:n}).val(e.html()).removeClass(t+\"textarea\").show()):e.$box.after(e.$ed.css({height:n}).removeClass(t+\"editor\").removeAttr(\"contenteditable\").html(e.html()).show()),e.$ed.off(\"dblclick\",\"img\"),e.destroyPlugins(),e.$box.remove(),e.$c.removeData(\"trumbowyg\"),a(\"body\").removeClass(t+\"body-fullscreen\")},empty:function(){this.$ta.val(\"\"),this.syncCode(!0)},toggle:function(){var e=this,t=e.o.prefix;e.semanticCode(!1,!0),setTimeout(function(){e.doc.activeElement.blur(),e.$box.toggleClass(t+\"editor-hidden \"+t+\"editor-visible\"),e.$btnPane.toggleClass(t+\"disable\"),a(\".\"+t+\"viewHTML-button\",e.$btnPane).toggleClass(t+\"active\"),e.$box.hasClass(t+\"editor-visible\")?e.$ta.attr(\"tabindex\",-1):e.$ta.removeAttr(\"tabindex\")},0)},dropdown:function(e){var n=this,o=n.doc,r=n.o.prefix,i=a(\"[data-dropdown=\"+e+\"]\",n.$box),s=a(\".\"+r+e+\"-button\",n.$btnPane),l=i.is(\":hidden\");if(a(\"body\",o).trigger(\"mousedown\"),l){var d=s.offset().left;s.addClass(r+\"active\"),i.css({position:\"absolute\",top:s.offset().top-n.$btnPane.offset().top+s.outerHeight(),left:n.o.fixedFullWidth&&n.isFixed?d+\"px\":d-n.$btnPane.offset().left+\"px\"}).show(),a(t).trigger(\"scroll\"),a(\"body\",o).on(\"mousedown\",function(){a(\".\"+r+\"dropdown\",o).hide(),a(\".\"+r+\"active\",o).removeClass(r+\"active\"),a(\"body\",o).off(\"mousedown\")})}},html:function(e){var t=this;return null!=e?(t.$ta.val(e),t.syncCode(!0),t):t.$ta.val()},syncTextarea:function(){var e=this;e.$ta.val(e.$ed.text().trim().length>0||e.$ed.find(\"hr,img,embed,input\").length>0?e.$ed.html():\"\")},syncCode:function(e){var t=this;!e&&t.$ed.is(\":visible\")?t.syncTextarea():t.$ed.html(t.$ta.val()),t.o.autogrow&&(t.height=t.$ed.height(),t.height!==t.$ta.css(\"height\")&&(t.$ta.css({height:t.height}),t.$c.trigger(\"tbwresize\")))},semanticCode:function(e,t){var n=this;if(n.saveRange(),n.syncCode(e),a(n.o.tagsToRemove.join(\",\"),n.$ed).remove(),n.o.semantic){if(n.semanticTag(\"b\",\"strong\"),n.semanticTag(\"i\",\"em\"),n.semanticTag(\"strike\",\"del\"),t){var o=n.o.inlineElementsSelector,r=\":not(\"+o+\")\";n.$ed.contents().filter(function(){return 3===this.nodeType&&this.nodeValue.trim().length>0}).wrap(\"<span data-tbw/>\");var i=function(e){if(0!==e.length){var t=e.nextUntil(r).andSelf().wrapAll(\"<p/>\").parent(),n=t.nextAll(o).first();t.next(\"br\").remove(),i(n)}};i(n.$ed.children(o).first()),n.semanticTag(\"div\",\"p\",!0),n.$ed.find(\"p\").filter(function(){return n.range&&this===n.range.startContainer?!1:0===a(this).text().trim().length&&0===a(this).children().not(\"br,span\").length}).contents().unwrap(),a(\"[data-tbw]\",n.$ed).contents().unwrap(),n.$ed.find(\"p:empty\").remove()}n.restoreRange(),n.syncTextarea()}},semanticTag:function(e,t,n){a(e,this.$ed).each(function(){var e=a(this);e.wrap(\"<\"+t+\"/>\"),n&&a.each(e.prop(\"attributes\"),function(){e.parent().attr(this.name,this.value)}),e.contents().unwrap()})},createLink:function(){for(var e,t,n,o=this,r=o.doc.getSelection(),i=r.focusNode;[\"A\",\"DIV\"].indexOf(i.nodeName)<0;)i=i.parentNode;if(i&&\"A\"===i.nodeName){var s=a(i);e=s.attr(\"href\"),t=s.attr(\"title\"),n=s.attr(\"target\");var l=o.doc.createRange();l.selectNode(i),r.addRange(l)}o.saveRange(),o.openModalInsert(o.lang.createLink,{url:{label:\"URL\",required:!0,value:e},title:{label:o.lang.title,value:t},text:{label:o.lang.text,value:o.getRangeText()},target:{label:o.lang.target,value:n}},function(e){var t=a(['<a href=\"',e.url,'\">',e.text,\"</a>\"].join(\"\"));return e.title.length>0&&t.attr(\"title\",e.title),e.target.length>0&&t.attr(\"target\",e.target),o.range.deleteContents(),o.range.insertNode(t[0]),!0})},unlink:function(){var e=this,t=e.doc.getSelection(),n=t.focusNode;if(t.isCollapsed){for(;[\"A\",\"DIV\"].indexOf(n.nodeName)<0;)n=n.parentNode;if(n&&\"A\"===n.nodeName){var a=e.doc.createRange();a.selectNode(n),t.addRange(a)}}e.execCmd(\"unlink\",void 0,void 0,!0)},insertImage:function(){var e=this;e.saveRange(),e.openModalInsert(e.lang.insertImage,{url:{label:\"URL\",required:!0},alt:{label:e.lang.description,value:e.getRangeText()}},function(t){return e.execCmd(\"insertImage\",t.url),a('img[src=\"'+t.url+'\"]:not([alt])',e.$box).attr(\"alt\",t.alt),!0})},fullscreen:function(){var e,n=this,o=n.o.prefix,r=o+\"fullscreen\";n.$box.toggleClass(r),e=n.$box.hasClass(r),a(\"body\").toggleClass(o+\"body-fullscreen\",e),a(t).trigger(\"scroll\"),n.$c.trigger(\"tbw\"+(e?\"open\":\"close\")+\"fullscreen\")},execCmd:function(t,n,a,o){var r=this;o=!!o||\"\",\"dropdown\"!==t&&r.$ed.focus(),r.doc.execCommand(\"styleWithCSS\",!1,a||!1);try{r[t+o](n)}catch(i){try{t(n)}catch(s){\"insertHorizontalRule\"===t?n=void 0:\"formatBlock\"!==t||-1===e.userAgent.indexOf(\"MSIE\")&&-1===e.appVersion.indexOf(\"Trident/\")||(n=\"<\"+n+\">\"),r.doc.execCommand(t,!1,n),r.syncCode(),r.semanticCode(!1,!0)}\"dropdown\"!==t&&(r.updateButtonPaneStatus(),r.$c.trigger(\"tbwchange\"))}},openModal:function(e,n){var o=this,r=o.o.prefix;if(a(\".\"+r+\"modal-box\",o.$box).length>0)return!1;o.saveRange(),o.showOverlay(),o.$btnPane.addClass(r+\"disable\");var i=a(\"<div/>\",{\"class\":r+\"modal \"+r+\"fixed-top\"}).css({top:o.$btnPane.height()}).appendTo(o.$box);o.$overlay.one(\"click\",function(){return i.trigger(\"tbwcancel\"),!1});var s=a(\"<form/>\",{action:\"\",html:n}).on(\"submit\",function(){return i.trigger(\"tbwconfirm\"),!1}).on(\"reset\",function(){return i.trigger(\"tbwcancel\"),!1}),l=a(\"<div/>\",{\"class\":r+\"modal-box\",html:s}).css({top:\"-\"+o.$btnPane.outerHeight()+\"px\",opacity:0}).appendTo(i).animate({top:0,opacity:1},100);return a(\"<span/>\",{text:e,\"class\":r+\"modal-title\"}).prependTo(l),i.height(l.outerHeight()+10),a(\"input:first\",l).focus(),o.buildModalBtn(\"submit\",l),o.buildModalBtn(\"reset\",l),a(t).trigger(\"scroll\"),i},buildModalBtn:function(e,t){var n=this,o=n.o.prefix;return a(\"<button/>\",{\"class\":o+\"modal-button \"+o+\"modal-\"+e,type:e,text:n.lang[e]||e}).appendTo(a(\"form\",t))},closeModal:function(){var e=this,t=e.o.prefix;e.$btnPane.removeClass(t+\"disable\"),e.$overlay.off();var n=a(\".\"+t+\"modal-box\",e.$box);n.animate({top:\"-\"+n.height()},100,function(){n.parent().remove(),e.hideOverlay()}),e.restoreRange()},openModalInsert:function(e,t,n){var o=this,r=o.o.prefix,i=o.lang,s=\"\",l=\"tbwconfirm\";return a.each(t,function(e,t){var n=t.label,a=t.name||e;s+='<label><input type=\"'+(t.type||\"text\")+'\" name=\"'+a+'\" value=\"'+(t.value||\"\").replace(/\"/g,\"&quot;\")+'\"><span class=\"'+r+'input-infos\"><span>'+(n?i[n]?i[n]:n:i[e]?i[e]:e)+\"</span></span></label>\"}),o.openModal(e,s).on(l,function(){var e=a(\"form\",a(this)),r=!0,i={};a.each(t,function(t,n){var s=a('input[name=\"'+t+'\"]',e);i[t]=a.trim(s.val()),n.required&&\"\"===i[t]?(r=!1,o.addErrorOnModalField(s,o.lang.required)):n.pattern&&!n.pattern.test(i[t])&&(r=!1,o.addErrorOnModalField(s,n.patternError))}),r&&(o.restoreRange(),n(i,t)&&(o.syncCode(),o.$c.trigger(\"tbwchange\"),o.closeModal(),a(this).off(l)))}).one(\"tbwcancel\",function(){a(this).off(l),o.closeModal()})},addErrorOnModalField:function(e,t){var n=this.o.prefix,o=e.parent();e.on(\"change keyup\",function(){o.removeClass(n+\"input-error\")}),o.addClass(n+\"input-error\").find(\"input+span\").append(a(\"<span/>\",{\"class\":n+\"msg-error\",text:t}))},saveRange:function(){var e=this,t=e.doc.getSelection();if(e.range=null,t.rangeCount){var n,a=e.range=t.getRangeAt(0),o=e.doc.createRange();o.selectNodeContents(e.$ed[0]),o.setEnd(a.startContainer,a.startOffset),n=(o+\"\").length,e.metaRange={start:n,end:n+(a+\"\").length}}},restoreRange:function(){var e,t=this,n=t.metaRange,a=t.range,o=t.doc.getSelection();if(a){if(n&&n.start!==n.end){var r,i=0,s=[t.$ed[0]],l=!1,d=!1;for(e=t.doc.createRange();!d&&(r=s.pop());)if(3===r.nodeType){var c=i+r.length;!l&&n.start>=i&&n.start<=c&&(e.setStart(r,n.start-i),l=!0),l&&n.end>=i&&n.end<=c&&(e.setEnd(r,n.end-i),d=!0),i=c}else for(var u=r.childNodes,g=u.length;g>0;)g-=1,s.push(u[g])}o.removeAllRanges(),o.addRange(e||a)}},getRangeText:function(){return this.range+\"\"},updateButtonPaneStatus:function(){var e=this,t=e.o.prefix,n=e.getTagsRecursive(e.doc.getSelection().focusNode.parentNode),o=t+\"active-button \"+t+\"active\";a(\".\"+t+\"active-button\",e.$btnPane).removeClass(o),a.each(n,function(n,r){var i=e.tagToButton[r.toLowerCase()],s=a(\".\"+t+i+\"-button\",e.$btnPane);if(s.length>0)s.addClass(o);else try{s=a(\".\"+t+\"dropdown .\"+t+i+\"-dropdown-button\",e.$box);var l=s.parent().data(\"dropdown\");a(\".\"+t+l+\"-button\",e.$box).addClass(o)}catch(d){}})},getTagsRecursive:function(e,t){var n=this;t=t||[];var o=e.tagName;return\"DIV\"===o?t:(\"P\"===o&&\"\"!==e.style.textAlign&&t.push(e.style.textAlign),a.each(n.tagHandlers,function(a,o){t=t.concat(o(e,n))}),t.push(o),n.getTagsRecursive(e.parentNode,t))},initPlugins:function(){var e=this;e.loadedPlugins=[],a.each(a.trumbowyg.plugins,function(t,n){(!n.shouldInit||n.shouldInit(e))&&(n.init(e),n.tagHandler&&e.tagHandlers.push(n.tagHandler),e.loadedPlugins.push(n))})},destroyPlugins:function(){a.each(this.loadedPlugins,function(e,t){t.destroy&&t.destroy()})}}}(navigator,window,document,jQuery);"

/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	// style-loader: Adds some css to the DOM by adding a <style> tag

	// load the styles
	var content = __webpack_require__(25);
	if(typeof content === 'string') content = [[module.id, content, '']];
	// add the styles to the DOM
	var update = __webpack_require__(26)(content, {});
	if(content.locals) module.exports = content.locals;
	// Hot Module Replacement
	if(false) {
		// When the styles change, update the <style> tags
		if(!content.locals) {
			module.hot.accept("!!./../../../../scripts/node_modules/raw-loader/index.js!!./trumbowyg.min.css", function() {
				var newContent = require("!!./../../../../scripts/node_modules/raw-loader/index.js!!./trumbowyg.min.css");
				if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
				update(newContent);
			});
		}
		// When the module is disposed, remove the <style> tags
		module.hot.dispose(function() { update(); });
	}

/***/ },
/* 25 */
/***/ function(module, exports) {

	module.exports = "/** Trumbowyg v2.1.0 - A lightweight WYSIWYG editor - alex-d.github.io/Trumbowyg - License MIT - Author : Alexandre Demode (Alex-D) / alex-d.fr */\n#trumbowyg-icons,#trumbowyg-icons svg{height:0;width:0}#trumbowyg-icons{overflow:hidden;visibility:hidden}.trumbowyg-box *,.trumbowyg-box ::after,.trumbowyg-box ::before{box-sizing:border-box}.trumbowyg-box svg{width:17px;height:100%;fill:#222}.trumbowyg-box,.trumbowyg-editor{display:block;position:relative;border:1px solid #DDD;width:100%;min-height:300px;margin:17px auto}.trumbowyg-box .trumbowyg-editor{margin:0 auto}.trumbowyg-box.trumbowyg-fullscreen{background:#FEFEFE;border:none!important}.trumbowyg-editor,.trumbowyg-textarea{position:relative;box-sizing:border-box;padding:20px;min-height:300px;width:100%;border-style:none;resize:none;outline:0;overflow:auto}.trumbowyg-box-blur .trumbowyg-editor *,.trumbowyg-box-blur .trumbowyg-editor::before{color:transparent!important;text-shadow:0 0 7px #333}@media screen and (min-width:0 \\0){.trumbowyg-box-blur .trumbowyg-editor *,.trumbowyg-box-blur .trumbowyg-editor::before{color:rgba(200,200,200,.6)!important}}@supports (-ms-accelerator:true){.trumbowyg-box-blur .trumbowyg-editor *,.trumbowyg-box-blur .trumbowyg-editor::before{color:rgba(200,200,200,.6)!important}}.trumbowyg-box-blur .trumbowyg-editor hr,.trumbowyg-box-blur .trumbowyg-editor img{opacity:.2}.trumbowyg-textarea{position:relative;display:block;overflow:auto;border:none;white-space:normal;font-size:14px;font-family:Inconsolata,Consolas,Courier,\"Courier New\",sans-serif;line-height:18px}.trumbowyg-box.trumbowyg-editor-visible .trumbowyg-textarea{height:1px!important;width:25%;min-height:0!important;padding:0!important;background:0 0;opacity:0!important}.trumbowyg-box.trumbowyg-editor-hidden .trumbowyg-textarea{display:block}.trumbowyg-box.trumbowyg-editor-hidden .trumbowyg-editor{display:none}.trumbowyg-box.trumbowyg-disabled .trumbowyg-textarea{opacity:.8;background:0 0}.trumbowyg-editor[contenteditable=true]:empty::before{content:attr(placeholder);color:#999;pointer-events:none}.trumbowyg-button-pane{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row wrap;-ms-flex-flow:row wrap;flex-flow:row wrap;width:100%;min-height:36px;background:#ecf0f1;border-bottom:1px solid #d7e0e2;margin:0;padding:0 5px;list-style-type:none;line-height:10px;-webkit-backface-visibility:hidden;backface-visibility:hidden}.trumbowyg-button-pane::after{content:\" \";display:block;position:absolute;top:36px;left:0;right:0;width:100%;height:1px;background:#d7e0e2}.trumbowyg-button-pane .trumbowyg-button-group{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row wrap;-ms-flex-flow:row wrap;flex-flow:row wrap}.trumbowyg-button-pane .trumbowyg-button-group .trumbowyg-fullscreen-button svg{color:transparent}.trumbowyg-button-pane .trumbowyg-button-group:not(:empty)+.trumbowyg-button-group::before{content:\" \";display:block;width:1px;background:#d7e0e2;margin:0 5px;height:35px}.trumbowyg-button-pane button{display:block;position:relative;width:35px;height:35px;padding:1px 6px!important;margin-bottom:1px;overflow:hidden;border:none;cursor:pointer;background:0 0;-webkit-transition:background-color 150ms,opacity 150ms;transition:background-color 150ms,opacity 150ms}.trumbowyg-button-pane.trumbowyg-disable button:not(.trumbowyg-not-disable):not(.trumbowyg-active),.trumbowyg-disabled .trumbowyg-button-pane button:not(.trumbowyg-not-disable):not(.trumbowyg-viewHTML-button){opacity:.2;cursor:default}.trumbowyg-button-pane.trumbowyg-disable .trumbowyg-button-group::before,.trumbowyg-disabled .trumbowyg-button-pane .trumbowyg-button-group::before{background:#e3e9eb}.trumbowyg-button-pane button.trumbowyg-active,.trumbowyg-button-pane button:not(.trumbowyg-disable):focus,.trumbowyg-button-pane button:not(.trumbowyg-disable):hover{background-color:#FFF;outline:0}.trumbowyg-button-pane .trumbowyg-open-dropdown::after{display:block;content:\" \";position:absolute;top:25px;right:3px;height:0;width:0;border:3px solid transparent;border-top-color:#555}.trumbowyg-button-pane .trumbowyg-right{margin-left:auto}.trumbowyg-button-pane .trumbowyg-right::before{display:none!important}.trumbowyg-dropdown{width:200px;border:1px solid #ecf0f1;padding:5px 0;border-top:none;background:#FFF;margin-left:-1px;box-shadow:rgba(0,0,0,.1) 0 2px 3px}.trumbowyg-dropdown button{display:block;width:100%;height:35px;line-height:35px;text-decoration:none;background:#FFF;padding:0 10px;color:#333!important;border:none;cursor:pointer;text-align:left;font-size:15px;-webkit-transition:all 150ms;transition:all 150ms}.trumbowyg-dropdown button:focus,.trumbowyg-dropdown button:hover{background:#ecf0f1}.trumbowyg-dropdown button svg{float:left;margin-right:14px}.trumbowyg-modal{position:absolute;top:0;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%);max-width:520px;width:100%;height:350px;z-index:11;overflow:hidden;-webkit-backface-visibility:hidden;backface-visibility:hidden}.trumbowyg-modal-box{position:absolute;top:0;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%);max-width:500px;width:calc(100% - 20px);padding-bottom:45px;z-index:1;background-color:#FFF;text-align:center;font-size:14px;box-shadow:rgba(0,0,0,.2) 0 2px 3px;-webkit-backface-visibility:hidden;backface-visibility:hidden}.trumbowyg-modal-box .trumbowyg-modal-title{font-size:24px;font-weight:700;margin:0 0 20px;padding:15px 0 13px;display:block;border-bottom:1px solid #EEE;color:#333;background:#fbfcfc}.trumbowyg-modal-box .trumbowyg-progress{width:100%;height:3px;position:absolute;top:58px}.trumbowyg-modal-box .trumbowyg-progress .trumbowyg-progress-bar{background:#2BC06A;height:100%;-webkit-transition:width 150ms linear;transition:width 150ms linear}.trumbowyg-modal-box label{display:block;position:relative;margin:15px 12px;height:27px;line-height:27px;overflow:hidden}.trumbowyg-modal-box label .trumbowyg-input-infos{display:block;text-align:left;height:25px;line-height:25px;-webkit-transition:all 150ms;transition:all 150ms}.trumbowyg-modal-box label .trumbowyg-input-infos span{display:block;color:#69878f;background-color:#fbfcfc;border:1px solid #DEDEDE;padding:0 7px;width:150px}.trumbowyg-modal-box label .trumbowyg-input-infos span.trumbowyg-msg-error{color:#e74c3c}.trumbowyg-modal-box label.trumbowyg-input-error input,.trumbowyg-modal-box label.trumbowyg-input-error textarea{border:1px solid #e74c3c}.trumbowyg-modal-box label.trumbowyg-input-error .trumbowyg-input-infos{margin-top:-27px}.trumbowyg-modal-box label input{position:absolute;top:0;right:0;height:27px;line-height:27px;border:1px solid #DEDEDE;background:#fff;font-size:14px;max-width:330px;width:70%;padding:0 7px;-webkit-transition:all 150ms;transition:all 150ms}.trumbowyg-modal-box label input:focus,.trumbowyg-modal-box label input:hover{outline:0;border:1px solid #95a5a6}.trumbowyg-modal-box label input:focus{background:#fbfcfc}.trumbowyg-modal-box .error{margin-top:25px;display:block;color:red}.trumbowyg-modal-box .trumbowyg-modal-button{position:absolute;bottom:10px;right:0;text-decoration:none;color:#FFF;display:block;width:100px;height:35px;line-height:33px;margin:0 10px;background-color:#333;border:none;cursor:pointer;font-family:\"Trebuchet MS\",Helvetica,Verdana,sans-serif;font-size:16px;-webkit-transition:all 150ms;transition:all 150ms}.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit{right:110px;background:#2bc06a}.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit:focus,.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit:hover{background:#40d47e;outline:0}.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit:active{background:#25a25a}.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset{color:#555;background:#e6e6e6}.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset:focus,.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset:hover{background:#fbfbfb;outline:0}.trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset:active{background:#d5d5d5}.trumbowyg-overlay{position:absolute;background-color:rgba(255,255,255,.5);width:100%;left:0;display:none;z-index:10}body.trumbowyg-body-fullscreen{overflow:hidden}.trumbowyg-fullscreen{position:fixed;top:0;left:0;width:100%;height:100%;margin:0;padding:0;z-index:99999}.trumbowyg-fullscreen .trumbowyg-editor,.trumbowyg-fullscreen.trumbowyg-box{border:none}.trumbowyg-fullscreen .trumbowyg-editor,.trumbowyg-fullscreen .trumbowyg-textarea{height:calc(100% - 37px)!important;overflow:auto}.trumbowyg-fullscreen .trumbowyg-overlay{height:100%!important}.trumbowyg-fullscreen .trumbowyg-button-group .trumbowyg-fullscreen-button svg{color:#222;fill:transparent}.trumbowyg-editor embed,.trumbowyg-editor img,.trumbowyg-editor object,.trumbowyg-editor video{max-width:100%}.trumbowyg-editor img,.trumbowyg-editor video{height:auto}.trumbowyg-editor img{cursor:move}.trumbowyg-editor.trumbowyg-reset-css{background:#FEFEFE!important;font-family:\"Trebuchet MS\",Helvetica,Verdana,sans-serif!important;font-size:14px!important;line-height:1.45em!important;white-space:normal!important;color:#333}.trumbowyg-editor.trumbowyg-reset-css a{color:#15c!important;text-decoration:underline!important}.trumbowyg-editor.trumbowyg-reset-css blockquote,.trumbowyg-editor.trumbowyg-reset-css div,.trumbowyg-editor.trumbowyg-reset-css ol,.trumbowyg-editor.trumbowyg-reset-css p,.trumbowyg-editor.trumbowyg-reset-css ul{box-shadow:none!important;background:0 0!important;margin:0 0 15px!important;line-height:1.4em!important;font-family:\"Trebuchet MS\",Helvetica,Verdana,sans-serif!important;font-size:14px!important;border:none}.trumbowyg-editor.trumbowyg-reset-css hr,.trumbowyg-editor.trumbowyg-reset-css iframe,.trumbowyg-editor.trumbowyg-reset-css object{margin-bottom:15px!important}.trumbowyg-editor.trumbowyg-reset-css blockquote{margin-left:32px!important;font-style:italic!important;color:#555}.trumbowyg-editor.trumbowyg-reset-css ol,.trumbowyg-editor.trumbowyg-reset-css ul{padding-left:20px!important}.trumbowyg-editor.trumbowyg-reset-css ol ol,.trumbowyg-editor.trumbowyg-reset-css ol ul,.trumbowyg-editor.trumbowyg-reset-css ul ol,.trumbowyg-editor.trumbowyg-reset-css ul ul{border:none;margin:2px!important;padding:0 0 0 24px!important}.trumbowyg-editor.trumbowyg-reset-css hr{display:block;height:1px;border:none;border-top:1px solid #CCC}.trumbowyg-editor.trumbowyg-reset-css h1,.trumbowyg-editor.trumbowyg-reset-css h2,.trumbowyg-editor.trumbowyg-reset-css h3,.trumbowyg-editor.trumbowyg-reset-css h4{color:#111;background:0 0;margin:0!important;padding:0!important;font-weight:700}.trumbowyg-editor.trumbowyg-reset-css h1{font-size:32px!important;line-height:38px!important;margin-bottom:20px!important}.trumbowyg-editor.trumbowyg-reset-css h2{font-size:26px!important;line-height:34px!important;margin-bottom:15px!important}.trumbowyg-editor.trumbowyg-reset-css h3{font-size:22px!important;line-height:28px!important;margin-bottom:7px!important}.trumbowyg-editor.trumbowyg-reset-css h4{font-size:16px!important;line-height:22px!important;margin-bottom:7px!important}.trumbowyg-dark .trumbowyg-textarea{background:#111;color:#ddd}.trumbowyg-dark .trumbowyg-box{border:1px solid #343434}.trumbowyg-dark .trumbowyg-box.trumbowyg-fullscreen{background:#111}.trumbowyg-dark .trumbowyg-box.trumbowyg-box-blur .trumbowyg-editor *,.trumbowyg-dark .trumbowyg-box.trumbowyg-box-blur .trumbowyg-editor::before{text-shadow:0 0 7px #ccc}@media screen and (min-width:0 \\0){.trumbowyg-dark .trumbowyg-box.trumbowyg-box-blur .trumbowyg-editor *,.trumbowyg-dark .trumbowyg-box.trumbowyg-box-blur .trumbowyg-editor::before{color:rgba(20,20,20,.6)!important}}@supports (-ms-accelerator:true){.trumbowyg-dark .trumbowyg-box.trumbowyg-box-blur .trumbowyg-editor *,.trumbowyg-dark .trumbowyg-box.trumbowyg-box-blur .trumbowyg-editor::before{color:rgba(20,20,20,.6)!important}}.trumbowyg-dark .trumbowyg-box svg{fill:#ecf0f1;color:#ecf0f1}.trumbowyg-dark .trumbowyg-button-pane{background-color:#222;border-bottom-color:#343434}.trumbowyg-dark .trumbowyg-button-pane::after{background:#343434}.trumbowyg-dark .trumbowyg-button-pane .trumbowyg-button-group:not(:empty)::before{background-color:#343434}.trumbowyg-dark .trumbowyg-button-pane .trumbowyg-button-group:not(:empty) .trumbowyg-fullscreen-button svg{color:transparent}.trumbowyg-dark .trumbowyg-button-pane.trumbowyg-disable .trumbowyg-button-group::before{background-color:#2a2a2a}.trumbowyg-dark .trumbowyg-button-pane button.trumbowyg-active,.trumbowyg-dark .trumbowyg-button-pane button:not(.trumbowyg-disable):focus,.trumbowyg-dark .trumbowyg-button-pane button:not(.trumbowyg-disable):hover{background-color:#333}.trumbowyg-dark .trumbowyg-button-pane .trumbowyg-open-dropdown::after{border-top-color:#fff}.trumbowyg-dark .trumbowyg-fullscreen .trumbowyg-button-group .trumbowyg-fullscreen-button svg{color:#ecf0f1;fill:transparent}.trumbowyg-dark .trumbowyg-dropdown{border-color:#222;background:#333;box-shadow:rgba(0,0,0,.3) 0 2px 3px}.trumbowyg-dark .trumbowyg-dropdown button{background:#333;color:#fff!important}.trumbowyg-dark .trumbowyg-dropdown button:focus,.trumbowyg-dark .trumbowyg-dropdown button:hover{background:#222}.trumbowyg-dark .trumbowyg-modal-box{background-color:#222}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-title{border-bottom:1px solid #555;color:#fff;background:#3c3c3c}.trumbowyg-dark .trumbowyg-modal-box label{display:block;position:relative;margin:15px 12px;height:27px;line-height:27px;overflow:hidden}.trumbowyg-dark .trumbowyg-modal-box label .trumbowyg-input-infos span{color:#eee;background-color:#2f2f2f;border-color:#222}.trumbowyg-dark .trumbowyg-modal-box label .trumbowyg-input-infos span.trumbowyg-msg-error{color:#e74c3c}.trumbowyg-dark .trumbowyg-modal-box label.trumbowyg-input-error input,.trumbowyg-dark .trumbowyg-modal-box label.trumbowyg-input-error textarea{border-color:#e74c3c}.trumbowyg-dark .trumbowyg-modal-box label input{border-color:#222;color:#eee;background:#333}.trumbowyg-dark .trumbowyg-modal-box label input:focus,.trumbowyg-dark .trumbowyg-modal-box label input:hover{border-color:#626262}.trumbowyg-dark .trumbowyg-modal-box label input:focus{background-color:#2f2f2f}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit{background:#1b7943}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit:focus,.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit:hover{background:#25a25a}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-submit:active{background:#176437}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset{background:#333;color:#ccc}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset:focus,.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset:hover{background:#444}.trumbowyg-dark .trumbowyg-modal-box .trumbowyg-modal-button.trumbowyg-modal-reset:active{background:#111}.trumbowyg-dark .trumbowyg-overlay{background-color:rgba(15,15,15,.6)}"

/***/ },
/* 26 */
/***/ function(module, exports, __webpack_require__) {

	/*
		MIT License http://www.opensource.org/licenses/mit-license.php
		Author Tobias Koppers @sokra
	*/
	var stylesInDom = {},
		memoize = function(fn) {
			var memo;
			return function () {
				if (typeof memo === "undefined") memo = fn.apply(this, arguments);
				return memo;
			};
		},
		isOldIE = memoize(function() {
			return /msie [6-9]\b/.test(window.navigator.userAgent.toLowerCase());
		}),
		getHeadElement = memoize(function () {
			return document.head || document.getElementsByTagName("head")[0];
		}),
		singletonElement = null,
		singletonCounter = 0,
		styleElementsInsertedAtTop = [];

	module.exports = function(list, options) {
		if(false) {
			if(typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
		}

		options = options || {};
		// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
		// tags it will allow on a page
		if (typeof options.singleton === "undefined") options.singleton = isOldIE();

		// By default, add <style> tags to the bottom of <head>.
		if (typeof options.insertAt === "undefined") options.insertAt = "bottom";

		var styles = listToStyles(list);
		addStylesToDom(styles, options);

		return function update(newList) {
			var mayRemove = [];
			for(var i = 0; i < styles.length; i++) {
				var item = styles[i];
				var domStyle = stylesInDom[item.id];
				domStyle.refs--;
				mayRemove.push(domStyle);
			}
			if(newList) {
				var newStyles = listToStyles(newList);
				addStylesToDom(newStyles, options);
			}
			for(var i = 0; i < mayRemove.length; i++) {
				var domStyle = mayRemove[i];
				if(domStyle.refs === 0) {
					for(var j = 0; j < domStyle.parts.length; j++)
						domStyle.parts[j]();
					delete stylesInDom[domStyle.id];
				}
			}
		};
	}

	function addStylesToDom(styles, options) {
		for(var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];
			if(domStyle) {
				domStyle.refs++;
				for(var j = 0; j < domStyle.parts.length; j++) {
					domStyle.parts[j](item.parts[j]);
				}
				for(; j < item.parts.length; j++) {
					domStyle.parts.push(addStyle(item.parts[j], options));
				}
			} else {
				var parts = [];
				for(var j = 0; j < item.parts.length; j++) {
					parts.push(addStyle(item.parts[j], options));
				}
				stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
			}
		}
	}

	function listToStyles(list) {
		var styles = [];
		var newStyles = {};
		for(var i = 0; i < list.length; i++) {
			var item = list[i];
			var id = item[0];
			var css = item[1];
			var media = item[2];
			var sourceMap = item[3];
			var part = {css: css, media: media, sourceMap: sourceMap};
			if(!newStyles[id])
				styles.push(newStyles[id] = {id: id, parts: [part]});
			else
				newStyles[id].parts.push(part);
		}
		return styles;
	}

	function insertStyleElement(options, styleElement) {
		var head = getHeadElement();
		var lastStyleElementInsertedAtTop = styleElementsInsertedAtTop[styleElementsInsertedAtTop.length - 1];
		if (options.insertAt === "top") {
			if(!lastStyleElementInsertedAtTop) {
				head.insertBefore(styleElement, head.firstChild);
			} else if(lastStyleElementInsertedAtTop.nextSibling) {
				head.insertBefore(styleElement, lastStyleElementInsertedAtTop.nextSibling);
			} else {
				head.appendChild(styleElement);
			}
			styleElementsInsertedAtTop.push(styleElement);
		} else if (options.insertAt === "bottom") {
			head.appendChild(styleElement);
		} else {
			throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
		}
	}

	function removeStyleElement(styleElement) {
		styleElement.parentNode.removeChild(styleElement);
		var idx = styleElementsInsertedAtTop.indexOf(styleElement);
		if(idx >= 0) {
			styleElementsInsertedAtTop.splice(idx, 1);
		}
	}

	function createStyleElement(options) {
		var styleElement = document.createElement("style");
		styleElement.type = "text/css";
		insertStyleElement(options, styleElement);
		return styleElement;
	}

	function createLinkElement(options) {
		var linkElement = document.createElement("link");
		linkElement.rel = "stylesheet";
		insertStyleElement(options, linkElement);
		return linkElement;
	}

	function addStyle(obj, options) {
		var styleElement, update, remove;

		if (options.singleton) {
			var styleIndex = singletonCounter++;
			styleElement = singletonElement || (singletonElement = createStyleElement(options));
			update = applyToSingletonTag.bind(null, styleElement, styleIndex, false);
			remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true);
		} else if(obj.sourceMap &&
			typeof URL === "function" &&
			typeof URL.createObjectURL === "function" &&
			typeof URL.revokeObjectURL === "function" &&
			typeof Blob === "function" &&
			typeof btoa === "function") {
			styleElement = createLinkElement(options);
			update = updateLink.bind(null, styleElement);
			remove = function() {
				removeStyleElement(styleElement);
				if(styleElement.href)
					URL.revokeObjectURL(styleElement.href);
			};
		} else {
			styleElement = createStyleElement(options);
			update = applyToTag.bind(null, styleElement);
			remove = function() {
				removeStyleElement(styleElement);
			};
		}

		update(obj);

		return function updateStyle(newObj) {
			if(newObj) {
				if(newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap)
					return;
				update(obj = newObj);
			} else {
				remove();
			}
		};
	}

	var replaceText = (function () {
		var textStore = [];

		return function (index, replacement) {
			textStore[index] = replacement;
			return textStore.filter(Boolean).join('\n');
		};
	})();

	function applyToSingletonTag(styleElement, index, remove, obj) {
		var css = remove ? "" : obj.css;

		if (styleElement.styleSheet) {
			styleElement.styleSheet.cssText = replaceText(index, css);
		} else {
			var cssNode = document.createTextNode(css);
			var childNodes = styleElement.childNodes;
			if (childNodes[index]) styleElement.removeChild(childNodes[index]);
			if (childNodes.length) {
				styleElement.insertBefore(cssNode, childNodes[index]);
			} else {
				styleElement.appendChild(cssNode);
			}
		}
	}

	function applyToTag(styleElement, obj) {
		var css = obj.css;
		var media = obj.media;

		if(media) {
			styleElement.setAttribute("media", media)
		}

		if(styleElement.styleSheet) {
			styleElement.styleSheet.cssText = css;
		} else {
			while(styleElement.firstChild) {
				styleElement.removeChild(styleElement.firstChild);
			}
			styleElement.appendChild(document.createTextNode(css));
		}
	}

	function updateLink(linkElement, obj) {
		var css = obj.css;
		var sourceMap = obj.sourceMap;

		if(sourceMap) {
			// http://stackoverflow.com/a/26603875
			css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
		}

		var blob = new Blob([css], { type: "text/css" });

		var oldSrc = linkElement.href;

		linkElement.href = URL.createObjectURL(blob);

		if(oldSrc)
			URL.revokeObjectURL(oldSrc);
	}


/***/ }
/******/ ]);