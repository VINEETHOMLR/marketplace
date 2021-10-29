'use strict'
$.noConflict();
var $ = jQuery;
function showPreview(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
        	

        	if( ! $(input).closest( 'div' ).find( '.js-img-preview' ).length ){
        		$( '<div>' , { class : 'js-img-preview' } ).insertBefore( $(input) );
        	}

        	var $img = $( '<img>' , {
        		src : e.target.result,
        		class : 'img-responsive pad',
                
        	} );
        	$(input).closest( 'div' ).find( '.js-img-preview' ).html( $img );
        }

        reader.readAsDataURL(input.files[0]);
    }
}



jQuery( 'input:file.js-preview-file' ).on( 'change' ,function(){
    showPreview( this );
});


jQuery( document ).ready(function( $ ) {
    var starRatingElms  =   $( '.star-rating' );
    if( starRatingElms.length )
    {
        starRatingElms.each(function(i , el){
            var $this   =   $(el);
            var rating=    $this.data('rating-config');
            $this.rating(rating);
        });
    }

});

function loadNotifications()
{
	$.ajax({
			method : 'post',
			url : base + 'notification/json',
			dataType: 'json',
			success :  function(response) {
				$( '#notifications' ).html(response.display)
			}
		});
}

loadNotifications();