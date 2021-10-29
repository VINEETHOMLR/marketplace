require( '../../js/downloads/trumbowyg/trumbowyg.min.js' );
require( '../../js/downloads/trumbowyg/ui/trumbowyg.min.css' );

require( '../../js/downloads/typeahead/bootstrap3-typeahead.min.js' );
require( '../../js/downloads/bootstrap-tagsinput/bootstrap-tagsinput.js' );
require( '../../js/downloads/bootstrap-tagsinput/bootstrap-tagsinput.css' );
import mvForm from '../plugins/mvForm'
import _ from 'lodash'

var Bloodhound = require('bloodhound-js');

$.trumbowyg.svgPath = base + 'scripts/downloads/trumbowyg/ui/icons.svg';

var $blog_form	= $( '#blog_form' );
new mvForm( $blog_form  , { } );
//mvform( $blog_form  , { } );

$blog_form.find('textarea').trumbowyg({
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



var elt = $('#blog_tags');

$.get( base + 'blog/tags/list_json' , function( data ){
	
	elt.tagsinput({
	  typeahead: {
	    //source: ( _.pluck(data,'tag_name') )
	  }
	});

} , 'json' );


function showPreview(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
        	

        	if( ! $(input).closest( 'div' ).find( '.img-preview' ).length ){
        		$( '<div>' , { class : 'img-preview' } ).insertBefore( $(input) );
        	}

        	var $img = $( '<img>' , {
        		src : e.target.result,
        		class : 'img-responsive pad',
                
        	} );
        	$(input).closest( 'div' ).find( '.img-preview' ).html( $img );
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$blog_form.find( 'input:file' ).on( 'change' ,function(){
	showPreview( this );
});


