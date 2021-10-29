'use strict'
//var $ = tjq;
$(document).ready(function() { 
	$('.mvform1').ajaxForm({
		dataType : 'json',
		success : function(responseText){
			//alert();
			$('.mvresult').html('');
			if( responseText.res == 1 ){
				$(':input','.mvform')
				  .not(':button, :submit, :reset, :hidden')
				  .val('')
				  .removeAttr('checked')
				  .removeAttr('selected');
				$('.modal').modal('hide');
				swal("Thank You !", "We have received your enquiry. ", "success");
			}else{
				$('.mvresult').html(responseText.msg)
			}
		}
	})
});
