'use strict'
var $ = jQuery;

$('#category_id').on('change',function(){
	var $this	=	$(this);
	var category_id	=	$this.val();
	loadSubCatgories(category_id)
});

if($('#category_id').val()) loadSubCatgories($('#category_id').val());
if(subcategory_id)  $('#subcategory_id').val(subcategory_id);

function loadSubCatgories(category_id){
	$.each(subcategories_dropdown[category_id], function (i, item) {
		var option = $('<option>', { 
		        value: item.subcat_id,
		        text : item.subcat_name 
		    });
	    $('#subcategory_id').append(option);
		});
}

