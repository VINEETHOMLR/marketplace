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
        var product_id=file.product_id;
       

       $.ajax({
        type: 'POST',
        url: base+'product/admin_product/remove_image',
        data: {'id': id,'name':name,'product_id':product_id},
        sucess: function(data)
        {
        
         

                $.each(data, function(key,value){
                 
                var mockFile = { name: value.name, size: value.size,id:value.id,product_id:value.product_id,status: Dropzone.ADDED,
                accepted: true ,url:base+"assets/uploads/products/"+value.name};
                 
                 
                myDropzone.options.addedfile.call(myDropzone, mockFile);
 
                myDropzone.options.thumbnail.call(myDropzone, mockFile, base+"assets/uploads/products/"+value.name);

               
                //myDropzone.options.addedFile.call(myDropzone, mockFile);
               // myDropzone.emit("addedfile", mockFile);
              // myDropzone.emit( "addedfile", mockFile );
             // myDropzone.emit( "accept", mockFile );
                myDropzone.files.push(mockFile);
                //myDropzone.files.push("addedfile",mockFile);
                myDropzone.emit("complete", mockFile);
                
               
            });

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

          // console.log(response.res);
          //  console.log(response.red);
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
            var product_id=$('#product_id').val();
            if(product_id!=null){

            
              $.ajax({
              url: base+'product/admin_product/get_images',
              type: "post",
              data:{'product_id':product_id},
              dataType:'json',
             
              success: function (data) {
               
                

                $.each(data, function(key,value){
                 
                var mockFile = { name: value.name, size: value.size,id:value.id,product_id:value.product_id,status: Dropzone.ADDED,
                accepted: true ,url:base+"assets/uploads/product/"+value.name};
                 
                 
                myDropzone.options.addedfile.call(myDropzone, mockFile);
 
                myDropzone.options.thumbnail.call(myDropzone, mockFile, base+"assets/uploads/product/"+value.name);

               
                //myDropzone.options.addedFile.call(myDropzone, mockFile);
               // myDropzone.emit("addedfile", mockFile);
              // myDropzone.emit( "addedfile", mockFile );
             // myDropzone.emit( "accept", mockFile );
                myDropzone.files.push(mockFile);
                //myDropzone.files.push("addedfile",mockFile);
                myDropzone.emit("complete", mockFile);
                
               
            });

              },
              error: function(jqXHR, textStatus, errorThrown) {
                 
              }


          });
            }




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
       /* Dropzone.prototype.requeueFiles = function(files){
    for (var i = 0, l = files.length, file; i < l; i++){
        file = files[i];
        file.status = Dropzone.ADDED;
        file.upload.progress = 0;
        file.upload.bytesSent = 0;
    }
}*/


		