
Dropzone.options.mydropzone = {
// url does not has to be written if we have wrote action in the form tag but i have mentioned here just for convenience sake 
         // url: 'upload.php', 
         //  uploadMultiple: true,
         //    cursor: pointer;
    //position: relative;
   // z-index: 21;
        removedfile: function(file) {
        var id = file.id; 
        var name=file.name;

        $.ajax({
        type: 'POST',
        url: base+'tour/tours/remove_image',
        data: {'id': id,'name':name},
        sucess: function(data)
        {
         
        }
        });
        var _ref;
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
          addRemoveLinks: true,
          autoProcessQueue: false, // this is important as you dont want form to be submitted unless you have clicked the submit button
          autoDiscover: false,
          maxFilesize: 50, // MB
          parallelUploads: 50,
          maxFiles: 10,
            
          uploadMultiple: true,
          paramName: 'pic', // this is optional Like this one will get accessed in php by writing $_FILE['pic'] // if you dont specify it then bydefault it taked 'file' as paramName eg: $_FILE['file'] 
          previewsContainer: '#dropzonePreview', // we specify on which div id we must show the files
          clickable: true, // this tells that the dropzone will not be clickable . we have to do it because v dont want the whole form to be clickable 
          accept: function(file, done) {
           // console.log("uploaded");
            done();
          },
         error: function(file, msg){
           // alert(msg);
          },
          success:function(file, response) {
              
          var myDropzone = this;
       
          var response=$.parseJSON( response );

           
            if(response.res==1){

            $('#mydropzone').find('input:text, input:password, select, textarea').val('');
            $('#mydropzone').find('input:radio, input:checkbox').prop('checked', false);
            //swal("Thank You !", "Ad posted Successfully", "success");
       window.location.href = response.red;
         //   $('#dropzonePreview').empty();
          //  myDropzone.removeAllFiles();
            
        
        }
        
    },
         
          init: function() {

             var myDropzone = this;
             var tour_id=$('#tour_id').val();
              $.ajax({
              url: base+'tour/tours/get_images',
              type: "post",
              dataType:'json',
              data:{'tour_id':tour_id},
             
              success: function (data) {
               
                $.each(data, function(key,value){
                 
                var mockFile = { name: value.name, size: value.size,id:value.image_id,status: Dropzone.ADDED,
                accepted: true ,url:base+"assets/uploads/tour/"+value.name};
                 
                 
                myDropzone.options.addedfile.call(myDropzone, mockFile);
 
                myDropzone.options.thumbnail.call(myDropzone, mockFile, base+"assets/uploads/tour/"+value.name);

               
                myDropzone.files.push(mockFile);
               
                myDropzone.emit("complete", mockFile);
                
               
            });

              },
              error: function(jqXHR, textStatus, errorThrown) {
                 
              }


          });

            //now we will submit the form when the button is clicked
            $("#sbmtbtn").on('click',function(e) {
             
                   $.each(myDropzone.files, function(i, file) {
              
                        file.status = Dropzone.QUEUED
                        
                    });

              if (myDropzone.getQueuedFiles().length > 0) {e.preventDefault();
             
               myDropzone.processQueue(); 
                                   
    
} 
                  });


           
          }




        };
     


		