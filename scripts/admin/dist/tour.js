
$(document).ready(function(){
   
$("#addnew").click(function(){

$.ajax({
        url: base+'pages/ajax_hotels',
        type: "post",
        
        success: function (response) {
           // you will get response from your php page (what you echo or print)                 
        console.log(response);
        $('#newrow').append(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });		 
   
  });
});