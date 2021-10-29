require( '../../js/downloads/trumbowyg/trumbowyg.min.js' );
require( '../../js/downloads/trumbowyg/ui/trumbowyg.min.css' );
$.trumbowyg.svgPath = base + 'scripts/downloads/trumbowyg/ui/icons.svg';
$(document).find('textarea.trumbowyg').trumbowyg({
	autogrow: true,
	resetCss: true,
	removeformatPasted: true,
	btns: [
        ['formatting'],
        'btnGrp-semantic',
        ['link'],
        'btnGrp-justify',
        'btnGrp-lists',
        ['removeformat'],
        ['fullscreen']
    ]
});
