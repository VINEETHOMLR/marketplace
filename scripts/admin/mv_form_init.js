'use strict'
import mvForm from '../plugins/mvForm'

$(document).find('.mvform').each( function(){
        let  $formt = $(this);
        $formt.removeClass( 'mvform' );
        new mvForm( $formt , $formt.data('ajaxFormOptions') || {} );
 });