
$(document).ready(function(){
   //directory section
	$('#directory_category_id').on('change', function() {
   
$.ajax({
        type: "POST",
        url: base+'category/admin_subcategories/get_subcategories_json',
        data: {'category_id':$(this).val()} ,
        success: function (response) {
           // you will get response from your php page (what you echo or print)                 
          
          var response=$.parseJSON(response);
          var row="";

          console.log(response);

          if(response.status==1)
          {    
               
               row+='<option>Select</option>';
               for(var i=0;i<response.list.length;i++)
               {
               row+='<option value='+response.list[i].subcategory_id+'>'+response.list[i].subcategory_title_english+'</option>';
               }
               $('#directory_subcategory_id').html("");
               $('#directory_subcategory_id').append(row);

               row="";
               row+='<option>Select</option>';
               $('#directory_subcategorylevel3_id').html("");
               $('#directory_subcategorylevel3_id').append(row);



               
               
          }
          else
          {
            row+='<option>Select</option>';
            $('#directory_subcategory_id').html("");
            $('#directory_subcategory_id').append(row);
          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });


    });
  //directory section

  $('#directory_subcategory_id').on('change', function() {

      $.ajax({
        type: "POST",
        url: base+'category/admin_subcategorieslevel3/get_subcategorieslevel3_json',
        data: {'subcategory_id':$(this).val(),'category_id':$('#directory_category_id').val()} ,
        success: function (response) {
           // you will get response from your php page (what you echo or print)                 
          
          var response=$.parseJSON(response);
          var row="";

          console.log(response);

          if(response.status==1)
          {    
               
               row+='<option>Select</option>';
               for(var i=0;i<response.list.length;i++)
               {
               row+='<option value='+response.list[i].subcategorylevel3_id+'>'+response.list[i].subcategorylevel3_title+'</option>';
               }
               $('#directory_subcategorylevel3_id').html("");
               $('#directory_subcategorylevel3_id').append(row);
               



               
               
          }
          else
          {
            row+='<option>Select</option>';
            $('#directory_subcategorylevel3_id').html("");
            $('#directory_subcategorylevel3_id').append(row);

          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });
 

  });



  //category section

  $('#category_id').on('change', function() {

      $.ajax({
        type: "POST",
        url: base+'category/admin_subcategories/get_subcategories_json',
        data: {'category_id':$(this).val()} ,
        success: function (response) {
           // you will get response from your php page (what you echo or print)                 
          
          var response=$.parseJSON(response);
          var row="";

         // console.log(response);

          if(response.status==1)
          {    
               
               row+='<option>Select</option>';
               for(var i=0;i<response.list.length;i++)
               {
               row+='<option value='+response.list[i].subcategory_id+'>'+response.list[i].subcategory_title+'</option>';
               }
               $('#subcategorylevel3_subcategory_id').html("");
               $('#subcategorylevel3_subcategory_id').append(row);
               



               
               
          }
          else
          {
            row+='<option>Select</option>';
            $('#subcategorylevel3_subcategory_id').html("");
            $('#subcategorylevel3_subcategory_id').append(row);

          }

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });
 

  });


    


});


 