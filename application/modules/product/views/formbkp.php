<?php 

if(Modules::run( 'login/is_admin' )){
$parentCatgeoryList = Modules::run('product/admin_product/getparentcategory');
}


$categoryList=Modules::run('product/admin_product/getproductcategory');
//$storeList=Modules::run('store/admin_store/getstoreList');

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

 });</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?=isset( $product[ 'product_id' ] ) ? 'Edit product' : 'Add New product'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="product_form" method="post" action="<?=$this->base?>product/admin_product/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $product[ 'product_id' ] )  && trim( $product[ 'product_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"product_id\" value=\"{$product[ 'product_id' ]}\">";
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


<?php //echo //echo "<pre>";print_r($product);echo "<pre>";
//print_r($parentCatgeoryList);?>


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
                      <?php if(isset($product['product_id'])) {
                      foreach( $storeList as $k => $v )
                      {
                            $selected = isset( $product[ 'product_store_id' ] ) && $product[ 'product_store_id' ] == $v['store_id'] ? 'selected' : '';
                      ?>
                      <option value="<?= $v['store_id']?>" <?= $selected ?>><?=$v['store_name']?></option>
                      <?php  
                      } } else{ ?>
                      <option value="0">Select</option> 
                      <?php }
                      ?>
                    </select>
          </div>
        <?php } ?>

          
          <div class="form-group">
            <label for="product_image">Product Image</label>
            
            <?php
            if( isset( $product[ 'product_image' ] )  && trim( $product[ 'product_image' ] ) != '' )
        			{
        				echo "<input type=\"hidden\" name=\"product_image_last\" value=\"{$product[ 'product_image' ]}\">";
        				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/product/{$product[ 'product_image' ]}\" class=\"img-responsive pad\" ></div>";
        			}
        			?>
            
            <input type="file" id="product_image" name="product_image"  data-error="Please upload an image for the portfolio" <?=isset( $product[ 'product_image' ] )  && trim( $product[ 'product_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          </div>

          <div class="form-group">
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
        
 

        
          

          
        
				<div class="form-group">
                    <label for="product_status">Status</label>
                    <select class="form-control" id="product_status" name="product_status">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $product[ 'product_status' ] ) && $product[ 'product_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
        </div>
				
          
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="product_title">Product Color</label>  <span id="addColor">ADD</span>
            <?php 
                $count = count($colorList);
            ?>
            <span id="colorList">
            <?php if($count==0) {?>  
            <input type="color" id="color_1" name="product_color[]" value="#ff0000" class="form-control" > <span id="1" class="delete">Delete</span>
           
          <?php } else {
               foreach($colorList as $k=>$v){ ?>
                   <input type="color" id="color_<?= $k+1?>" name="product_color[]" value="<?= $v['color_code']?>" class="form-control" > <span id="<?= $k+1?>" class="delete">Delete</span>
           
               <?php }   
          }?>
           </span>
          </div>


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

          
        
          
        </div>
        
        
      </div>



    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
 
  var count = '<?= $count ?>';
  var base ='<?=$this->base?>';
  var role = '<?= $role ?>';
  
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).ready(function(){
  $("#addColor").click(function(){
    count = parseInt(count) + 1;
    html ="";
    html ='<input type="color" id="color_'+count+'" name="product_color[]" value="#ff0000" class="form-control" > <span class="delete" id="'+count+'"">Delete</span>';
    $('#colorList').append(html);
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

  });


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
    } else {
      
        $('#product_offer_price_div').hide();  
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
