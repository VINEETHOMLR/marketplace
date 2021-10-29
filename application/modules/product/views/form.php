<?php 
   if(Modules::run( 'login/is_admin' )){
   $parentCatgeoryList = Modules::run('product/admin_product/getparentcategory');
   }
   
   
   $categoryList=Modules::run('product/admin_product/getproductcategory');
//   $storeList=Modules::run('store/admin_store/getstoreList');

   $statusList=json_decode(CommonStatus::xEditArray(),true);
   $offerList=json_decode(OfferStatus::xEditArray(),true);
   
   
   
   ?>
<style>
   .typeahead {
   z-index: 1051;
   }
   .bootstrap-tagsinput {
   width: 100%;
   border-radius: 0px;
   }
   .trumbowyg-box{
   }
   .cropped_image {
    margin-top: 10px;
}
.img-crop {
    width: 50px;
    height: 50px;
    float: left;
    margin-right: 10px;
}
</style>
<style type="text/css">
img {
  display: block;
  max-width: 100%;
}
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
.modal-lg{
  max-width: 1000px !important;
}
</style>
<script>
   var base='<?= $this->base?>';
</script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
   var uploadurl=base+'blog/blog/tinymce_upload';
   
   tinymce.init({
   selector: 'textarea',
   height: 100,
   theme: 'modern',
   // plugins:'code image',
   plugins: [
     'advlist autolink lists  image charmap print preview hr anchor pagebreak',
     'searchreplace wordcount visualblocks visualchars code fullscreen',
     'insertdatetime media nonbreaking save table contextmenu directionality',
     'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc code image'
   ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image code',
   toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
   
   //toolbar:'undo redo | image code',
   
   setup: function (editor) {
         editor.on('change', function () {
             editor.save();
         });
     }
   
   });
</script>
<div class="box box-primary">
<div class="box-header with-border">
   <h3 class="box-title"><?=isset( $product[ 'product_id' ] ) ? 'Edit product' : 'Add New product'?> </h3>
</div>
<!-- /.box-header --> 
<!-- form start -->
<form role="form" class="mvform dropzone" id="mydropzone" method="post" action="<?=$this->base?>product/admin_product/update" enctype="multipart/form-data" >
   <?php
      if( isset( $product[ 'product_id' ] )  && trim( $product[ 'product_id' ] ) != '' )
      {
      echo "<input id=\"product_id\" type=\"hidden\" name=\"product_id\" value=\"{$product[ 'product_id' ]}\">";
      
      }
      ?>
   <div class="box-body">
   <div class="row">
   <div class="col-md-4">
      <div class="form-group">
         <label for="product_title">Product Name</label>
         <input type="text" name="product_name" value="<?=isset( $product[ 'product_name' ] ) ? $product[ 'product_name' ]: ''?>" class="form-control" id="product_title" placeholder="Enter product  Title" required>
      </div>
      <div class="form-group">
         <label for="product_title">Product  Rate</label>
         <input type="text" name="product_price" value="<?=isset( $product[ 'product_price' ] ) ? $product[ 'product_price' ]: ''?>" class="form-control  " id="" onkeypress="return isNumber(event)"  placeholder="Enter product  Rate" required>
      </div>
      <div class="form-group">
         <label for="product_status">Category</label>
         <select class="form-control" id="product_parent_category" name="product_parent_category">
            <option value="0">Select</option>
            <?php
               foreach( $parentCatgeoryList as $k => $v )
               {
                     echo $selected = isset( $product[ 'product_parent_category' ] ) && $product[ 'product_parent_category' ] == $v['category_id'] ? 'selected' : '';
               ?>
            <option value="<?= $v['category_id']?>" <?= $selected ?>><?=$v['category_name']?></option>
            <?php  
               }
               ?>
         </select>
      </div>
      
      <?php if(!isset($product[ 'product_id' ]) ){ ?>
      <div class="form-group">
         <label for="product_status">Variant</label>
         <select class="form-control" id="product_variant_id" name="product_variant_id[]" multiple>
            <option value="0">Select</option>
         </select>
      </div>
      <?php } else {?>
      <div class="form-group">
         <label for="product_status">Variant</label>
         <select class="form-control" id="product_variant_id" name="product_variant_id[]" multiple>
            <?php
                $product_variant_id = explode(',',$product[ 'product_variant_id' ]);
               foreach( $variantList as $k => $v )
               {
                    $selected="";
                    $selected  = in_array($v['id'],$product_variant_id) ? 'selected':''; 
               ?>
            <option value="<?= $v['id']?>" <?= $selected ?>><?=$v['varient_name']?></option>
            <?php  
               }
               ?>
         </select>
      </div>
      <?php } ?>
      
      <?php if(!isset($product[ 'product_id' ]) ){ ?>
      <div class="form-group">
         <label for="product_status">Variant Option</label>
         <select class="form-control" id="variant_option_id" name="variant_option_id[]" multiple>
            <option value="0">Select</option>
         </select>
      </div>
      <?php } else {?>
      <div class="form-group">
         <label for="product_status">Variant Option</label>
         <select class="form-control" id="variant_option_id" name="variant_option_id[]" multiple>
            <?php
                $variant_option_id = explode(',',$product[ 'variant_option_id' ]);
               foreach( $variantOptionList as $k => $v )
               {
                    $selected="";
                    $selected  = in_array($v['id'],$variant_option_id) ? 'selected':''; 
               ?>
            <option value="<?= $v['id']?>" <?= $selected ?>><?=$v['option_name']?></option>
            <?php  
               }
               ?>
         </select>
      </div>
      <?php } ?>
      
      <?php if(!isset($product[ 'product_id' ]) ){ ?>
      <div class="form-group">
         <label for="product_status">Sub Category</label>
         <select class="form-control" id="product_category_id" name="product_category_id">
            <option value="0">Select</option>
         </select>
      </div>
      <?php } else {?>
      <div class="form-group">
         <label for="product_status">Sub Category</label>
         <select class="form-control" id="product_category_id" name="product_category_id">
            <?php
               foreach( $sucategoryList as $k => $v )
               {
                     $selected = isset( $product[ 'product_category_id' ] ) && $product[ 'product_category_id' ] == $v['product_category_id'] ? 'selected' : '';
               ?>
            <option value="<?= $v['product_category_id']?>" <?= $selected ?>><?=$v['product_category_name']?></option>
            <?php  
               }
               ?>
         </select>
      </div>
      <?php } ?>
      <?php   if(Modules::run( 'login/is_admin' )){?>
      <div class="form-group">
         <label for="product_status">Store</label>
         <select class="form-control" id="product_store_id" name="product_store_id">
             <option value="0">Select</option>
            <?php 
            // if(isset($product['product_id'])) {
               foreach( $storeList as $k => $v )
               {
                     $selected = isset( $product[ 'product_store_id' ] ) && $product[ 'product_store_id' ] == $v['store_id'] ? 'selected' : '';
               ?>
            <option value="<?= $v['store_id']?>" <?= $selected ?>><?=$v['store_name']?></option>
            <?php  
               } 
            //   } else{ ?>
            <?php //}
               ?>
         </select>
      </div>
      <?php } ?>
      <!-- <div class="form-group">
         <label for="product_status">Size</label>
         <select class="form-control" id="product_size" name="product_size[]" multiple>
            <?php
               $size = $product['product_size'];
               $size = explode(',',$size);
               
               
               
               foreach( SizeList::getDropDown() as $k => $v )
               {
                 //echo "v-".$v;
                 $selected="";
                 $selected  = in_array($k,$size) ? 'selected':''; 
                 ?>
            <option value="<?= $k?>" <?= $selected ?>><?= $v?></option>
            <?php
               }
               ?>
         </select>
      </div>
      -->
      <div class="form-group">
         <label for="product_status">Status</label>
         <select class="form-control" id="product_status" name="product_status">
         <?php
            foreach( commonStatus::getDropDown() as $k => $v )
            {
                  $selected = isset( $product[ 'product_status' ] ) && $product[ 'product_status' ] == $k ? 'selected' : '';
                  echo "<option value=\"$k\" $selected>$v</option>"; 
            }
            ?>
         </select>
      </div>
      <!--<div class="form-group">-->
      <!--   <label for="product_image">Product Images</label>-->
      <!--   <div id="dropzonePreview"></div>-->
      <!--   <div class="fallback">-->
      <!--      <input  type="file"  />-->
      <!--   </div>-->
      <!--</div>-->
      
   </div>
   <div class="col-md-4">
       
        <div class="clearfix"></div>
          <!-- <div class="form-group">
            <label for="product_title">Product Color</label>  <span id="addColor">ADD</span>
            <?php 
                $count = count($colorList);
            ?>
            <span id="colorList">
            <?php if($count==0){ ?>  
            <input type="color" id="color_1" name="product_color[]" value="#ff0000" class="form-control" > <span id="1" class="delete">Delete</span>
           
          <?php } else {
               foreach($colorList as $k=>$v){ ?>
                   <input type="color" id="color_<?= $k+1?>" name="product_color[]" value="<?= $v['color_code']?>" class="form-control" > <span id="<?= $k+1?>" class="delete">Delete</span>
           
               <?php }   
          }?>
           </span>
          </div> -->


          <div class="form-group">
            <label for="product_title">Product Description</label>  
          
            
           
            <textarea class="form-control" name="product_description"> <?= isset($product['product_description']) ? $product['product_description'] :''?></textarea> 
          </div>


          <div class="form-group">
            <label for="product_title">Product return/exchange policy</label>  
          
            
           
            <textarea class="form-control" name="return_policy"> <?= isset($product['return_policy']) ? $product['return_policy'] :''?></textarea> 
          </div>



           <div class="form-group">
                    <?php 
                        
                        $yes = !empty($product['is_return']) && $product['is_return'] == '1' ? 'checked' :'';  
                        $no =  $product['is_return'] == '0' ? 'checked' :'';  
                  

                    ?>
                    <label for="product_status" >Return /exchange </label>
                    <input type="radio" <?= $yes ?> name="is_return" value="1" >Yes<input type="radio" <?= $no ?> name="is_return" value="0">No
          </div>

          <div class="form-group" >
              <label for="product_title">Product Code</label>
              <input type="text" name="product_code" value="<?=isset( $product[ 'product_code' ] ) ? $product[ 'product_code' ]: ''?>" class="form-control  " id="product_code"   autocomplete="off" onkeyup="myFunction()" placeholder="Enter product code" required>
              <span id="codeError"></span>
          </div>
          <div class="form-group">
            <label for="product_is_offer">Offer</label>
             <select class="form-control" id="product_is_offer" name="product_is_offer">
             <?php
                /*echo "<pre>";
                print_r($offerList);exit;*/
                foreach( OfferStatus::getDropDown() as $k => $v )
                {
                      $selected = isset( $product[ 'product_is_offer' ] ) && $product[ 'product_is_offer' ] == $k ? 'selected' : '';
                      echo "<option value=\"$k\" $selected>$v</option>"; 
                }
                ?>
             </select>
        </div>
        <?php $display = isset($product['product_is_offer']) && $product['product_is_offer']==0 ? "display:none;" : '';?>
          <div class="form-group" id="product_offer_price_div" style="<?= $display?>">
             <label for="product_title">Offer  Rate</label>
             <input type="text" name="product_offer_price" value="<?=isset( $product[ 'product_offer_price' ] ) ? $product[ 'product_offer_price' ]: ''?>" class="form-control  " id="" onkeypress="return isNumber(event)"  placeholder="Enter offer  Rate" >
          </div>
          <div class="form-group" id="product_offer_date_div" style="<?= $display?>">
             <label for="product_title">Offer  End Date</label>
             <input type="text" name="product_offer_end_date" value="<?=isset( $product[ 'product_offer_end_date' ] ) ? $product[ 'product_offer_end_date' ]: ''?>" class="form-control  " id=""   placeholder="Enter offer  End Date" >
          </div>

           
    </div>
    
    
  </div>
  <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="product_title">Product Color Image</label> 
                <input type="file" id="product_color_img" name="product_color_img" accept="image/*" value="#ff0000" class="form-control" > 
                <div class="cropped_image">
                   <?php 
                    if(count($colorList) > 0){
                         foreach($colorList as $k=>$v){ 
                        ?>
                        <div class='img-crop image-color-<?= $k ?>'>
                            <img src='<?= $v['color_code'] ?>' width='50px' height='50px'> 
                            <!--<a href="javascript:;" class="remove-icon" onclick="remove_id(<?= $k ?>)"><i class="fa fa-times-circle" aria-hidden="true"></i></a>-->
                        </div>
                        <?php
                         }
                    }
                ?>
                </div>
                <br>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group" id="product_images_div">
                <label for="product_title">Product Images</label><button class="addNewImage" type="button">Add</button>
                <?php if(empty($product_id)){?> 
                <input type="file" id="product_img_0" name="product_imgs[]" accept="image/*"  class="form-control" ><img src="" style="width:50px;height:50px;display:none;" id="product_img_preview_0"> 
                <?php }else{

                  foreach($imageList as $k=>$v){?>
                    
                    <input type="file" id="product_img_<?= $k ?>" name="product_imgs[]" accept="image/*"  class="form-control" ><img src="<?= base_url().'assets/uploads/product/'.$v['image_name']?>" style="width:50px;height:50px;" id="product_img_preview_<?= $k ?>"> 

                <?php } }?> 

                <?php $productImageCount = empty($product_id) ? '0' : count($imageList) ;?> 
                
                
                <br>
            </div>
        </div>


        <div class="col-md-10" style="display:none;">
            <table class="product_img_table table table-striped" width="70%" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th width="10%" align="center">Color Code</th>
                        <th width="20%" align="center">Product Image</th>
                        <!-- <th width="20%" align="center">Price</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $c = 0;
                    if(count($imageList) > 0){
                         foreach($imageList as $k=>$v){ 
                        ?>
                        <tr>
                            <td>
                                <img src='<?= base_url().$v['color_code'] ?>' width='100px' height='100px'>
                            </td>
                            <td align="center">
                                <div class="form-group rimg">
                                    <input type="file" id="product_edit_img" name="product_img" data-coloid="<?= $v['images_id'] ?>" data-type="<?= $k ?>" accept="image/*" class="form-control">
                                </div>
                                <div class="view_img_<?= $k ?>">
                                    <?php 
                                        $images = explode(',', $v['image_name']);
                                        foreach($images as $img)
                                        {
                                    ?>
                                            <div class='img-crop'>
                                                <img src='<?= base_url() ?>assets/uploads/product/<?= $img ?>' width='50px' height='50px'>
                                            </div>
                                    <?php 
                                        }   
                                    ?>
                                </div>
                            </td>
                            <!-- <td align="center">
                                <input type="text" name="price[<?= $v['images_id'] ?>]" value="<?= $v['price'] ?>" class="form-control">
                            </td> -->
                        </tr>
                        <!--<div class='img-crop image-color-<?= $k ?>'>-->
                        <!--    <img src='<?= base_url().$v['color_code'] ?>' width='50px' height='50px'> -->
                            <!--<a href="javascript:;" class="remove-icon" onclick="remove_id(<?= $k ?>)"><i class="fa fa-times-circle" aria-hidden="true"></i></a>-->
                        <!--</div>-->
                        <?php
                            $c++;
                         }
                    }
                    ?>
                </tbody>
            </table>
        </div>
  </div>
</div>
<div class="box-footer">
         <button type="submit" class="btn btn-primary pull-right ladda-button" id="sbmtbtn">Save</button>
      </div>
</form>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-12">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" /> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
<script type="text/javascript">
   var count = '<?= $count ?>';
   var base ='<?=$this->base?>';
   var role = '<?= $role ?>';
   
   var product_image_count = '<?= $productImageCount ?>';
   function isNumber(evt) {
     evt = (evt) ? evt : window.event;
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
     }
     return true;
   }
   
   $(document).ready(function(){
   
    $( "#product_end" ).datepicker();
   
   $("#addColor").click(function(){
     count = parseInt(count) + 1;
     html ="";
     html ='<input type="color" id="color_'+count+'" name="product_color[]" value="#ff0000" class="form-control" > <span class="delete" id="'+count+'"">Delete</span>';
     $('#colorList').append(html);
   });


   $(".addNewImage").click(function(){ //add new  product image
    
       product_image_count = parseInt(product_image_count)+1;
       var html = '';
           html +='<input type="file" id="product_img_'+product_image_count+'" name="product_imgs[]" accept="image/*"  class="form-control" ><img src="" style="width:50px;height:50px;display:none;" id="product_img_preview_'+product_image_count+'"><br>';
       $('#product_images_div').append(html);    
   
   });


   
   
   $("#product_parent_category").change(function(){
    
    var product_parent_category = $(this).val();
   
   
    //alert(product_parent_category);
   // alert('<?=$this->base?>');
   
    $.ajax({
         url: base+'product/admin_product/getSubcatgoryList',
         type: "post",
         data: {'parent_category':product_parent_category} ,
         success: function (response) {
             $('#product_category_id').html("");  
             $('#product_category_id').html(response); 
             populateStore(product_parent_category); 
   
           
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
     });
   
   $.ajax({
         url: base+'product/admin_product/getVariant',
         type: "post",
         data: {'parent_category':product_parent_category} ,
         success: function (response) {
             $('#product_variant_id').html("");  
             $('#product_variant_id').html(response); 
            //  populateStore(product_parent_category); 
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
     });
   
   });
   
   $("#product_variant_id").change(function(e){
    
    var variant_id = $(e.target).val();
      $.ajax({
             url: base+'product/admin_product/getVariantOptions',
             type: "post",
             data: {'variant_id':variant_id} ,
             success: function (response) {
                 $('#variant_option_id').html("");  
                 $('#variant_option_id').html(response); 
                //  populateStore(product_parent_category); 
             },
             error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
             }
         });
   
   });
   
   
   /*
   function checkProductCode(product_code,store_id)
   {
   
   }*/
   //test();
   
   
   
   
   
   
   
   
   function populateStore(category_id)
   {
       $.ajax({
         url: base+'product/admin_product/getStorelist',
         type: "post",
         data: {'category':category_id} ,
         success: function (response) {
             $('#product_store_id').html("");  
             $('#product_store_id').html(response); 
            
   
           
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
     });
   
   }
   
   
   
   
   
   
   
   
   
   
   $(document).on('click', '.delete', function() { 
   
    var id =$(this).attr('id');
     $(this).remove();
     $('#color_'+id).remove();
    });
   
   
   
   $("#product_is_offer").change(function(){
     if ($('#product_is_offer').val()==1) {
         $('#product_offer_price_div').show();
         $('#product_offer_date_div').show();
     } else {
       
         $('#product_offer_price_div').hide();  
         $('#product_offer_date_div').hide();  
     }
   });
   
   });
   
   
</script>
<script>
   function myFunction(){
   
     var product_id = '<?= !empty($product['product_id']) ? $product['product_id'] : ""?>' ;
     var product_code = $('#product_code').val();
     if(role == 'SUPERADMIN') {
         var product_store_id = $('#product_store_id').val(); 
     }else{
         var product_store_id = '<?= $store_id ?>';    
     }
   
     if(product_code == "") {
         alert("Product code required");
         return false;
     }
   
     if(product_store_id == "0") {
         alert("Please select store");
         return false;
     }
   
   
    
   
     $.ajax({
         url: base+'product/admin_product/checkProductCode',
         type: "post",
         data: {'product_code':product_code,'product_store_id':product_store_id,'product_id':product_id} ,
         success: function (response) {
            
             $('#codeError').html("");
             var newResp = JSON.parse(response);
             if(newResp.status != 'true') {
                 
                 $('#codeError').html(newResp.message); 
                 $('#product_code').val("");   
   
             }
   
           
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
     });
   
   }
</script>
<script>

var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
  
$("body").on("change", "#product_img", function(e){
  //alert('1');
    $(".remove div.img-preview").remove();
    var type = $(this).attr('data-type');
    var files = e.target.files;
    var reader = new FileReader();
    reader.onload = function(e)
    {
        // alert(reader.result)
        $('.view_img_'+type).append("<div class='img-crop'><img src='"+reader.result+"' width='50px' height='50px'><input type='hidden' name='product_details[product_images]["+type+"][]' value='"+reader.result+"' ></div>");
    }
    reader.readAsDataURL(e.target.files[0]);
});

$("body").on("change", "#product_edit_img", function(e){//alert('2');
    $(".remove div.img-preview").remove();
    var type = $(this).attr('data-type');
    var color_id = $(this).attr('data-coloid');
    var files = e.target.files;
    var reader = new FileReader();
    reader.onload = function(e)
    {
        $('.view_img_'+type).append("<div class='img-crop'><img src='"+reader.result+"' width='50px' height='50px'><input type='hidden' name='product_images["+color_id+"][]' value='"+reader.result+"' ></div>");
    }
    reader.readAsDataURL(e.target.files[0]);
});

// function productImage(type, input)
// {
//     var reader = new FileReader();
//     reader.onload = function(e)
//     {
//         // alert(reader.result)
//         $('.view_img').append("<img src='"+reader.result+"' width='50px' height='50px'><input type='hidden' name='all_product_images[]' value='"+reader.result+"' >");
//     }
//     reader.readAsDataURL(input.target.files[0]);
// }

$("body").on("change", "#product_color_img", function(e){
  //alert('3');
   $(".img-preview").remove();
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
      $modal.addClass('in');
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
   
      cropper = new Cropper(image, {
         aspectRatio: 1,
         viewMode: 2,
         preview: '.preview'
      });  
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

var i = '<?php echo $c; ?>';
$("#crop").click(function(){
  //alert('4');
    canvas = cropper.getCroppedCanvas({
      width: 160,
      height: 160,
    });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result;  
            $(".img-preview").remove();
            $(".cropped_image").append("<div class='img-crop'><img src='"+base64data+"' width='50px' height='50px'><input type='hidden' name='color_img[]' value='"+base64data+"' ></div>");
            var html = '';
                html += '<tr>';
                html +=     '<td>';
                html +=         "<img src='"+base64data+"' width='100px' height='100px'>";
                html +=     '</td>';
                html +=     '<td align="center">';
                html +=         '<div class="form-group">';
                html +=             '<input type="file" id="product_img" name="product_img" data-type="'+i+'" accept="image/*" class="form-control">';
                html +=         '</div>';
                html +=         '<div class="view_img_'+i+'">';
                html +=         '</div>';
                html +=     '</td>';
                /*html +=     '<td align="center">';
                html +=         '<div class="form-group">';
                html +=             '<input type="text" name="product_details[price][]" class="form-control">';
                html +=         '</div>';
                html +=     '</td>';*/
                html += '</tr>';
                
                
                // html += '<div class="col-md-4">';
                // html +=     "<img src='"+base64data+"' width='100px' height='100px'>";
                // html += '</div>';
                // html += '<div class="col-md-4 view_img_'+i+'">';
                // html +=     '<div class="form-group">';
                // html +=         '<input type="file" id="product_img" name="product_img" data-type="'+i+'" accept="image/*" class="form-control">';
                // html +=     '</div>';
                // html += '</div>';
                // html += '<div class="col-md-4">';
                // html +=     '<div class="form-group">';
                // html +=         '<input type="text" name="product_details[price][]" class="form-control">';
                // html +=     '</div>';
                // html += '</div>';
                
           // $(".product_img_table tbody").append(html);
            i++;
            $modal.modal('hide');
            // $.ajax({
            //     type: "POST",
            //     dataType: "json",
            //     url: "upload.php",
            //     data: {image: base64data},
            //     success: function(data){
            //         console.log(data);
                    
            //         alert("success upload image");
            //     }
            //   });
         }
    });
})

</script>