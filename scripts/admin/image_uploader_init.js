'use strict'
var $ = jQuery;
import imageUploader from '../plugins/imageUploader'

$('.imageUploader').each(function(i , e ){
	new imageUploader( $(e) , {} )
});