<?php 

$categoryList=Modules::run('category/admin_category/getlist');

$readOnly = $role == 'STOREADMIN' ? 'readOnly' : "";
$disabled = $role == 'STOREADMIN' ? 'disabled' : "";







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
    <h3 class="box-title"><?=isset( $store[ 'store_id' ] ) ? 'Edit store' : 'Add New store'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="store_form" method="post" action="<?=$this->base?>store/admin_store/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $store[ 'store_id' ] )  && trim( $store[ 'store_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"store_id\" value=\"{$store[ 'store_id' ]}\">";
	}
	?>


    
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">

          <?php if(!empty($store[ 'store_id' ] )) { ?>

          <div class="form-group">
            <label for="store_title">Total Clicks</label>
            <input type="text"  value="<?=isset( $store[ 'click_count' ] ) ? $store[ 'click_count' ]: ''?>" class="form-control" id="store_title" placeholder="Enter store  Title" readOnly required >
          </div>
        <?php } ?>

          <div class="form-group">
            <label for="store_title">Store  Name</label>
            <input type="text" name="store_name" value="<?=isset( $store[ 'store_name' ] ) ? $store[ 'store_name' ]: ''?>" class="form-control" id="store_title" placeholder="Enter store  Title" <?= $readOnly ?> required >
          </div>


         

          <div class="form-group">
                    <label for="store_status">Category</label>
                    <select class="form-control" id="store_category" name="store_category[]" multiple >
                      <?php
                      $category = $store['store_category'];
                      $category = explode(',',$category);
                      
                      foreach( $categoryList as $k => $v )
                      {
                        $selected="";
                        $selected  = in_array($v['category_id'],$category) ? 'selected':''; 
                        ?>
                        <option value="<?= $v['category_id']?>" <?= $selected ?> <?= $disabled ?>><?= $v['category_name']?></option>
                        <?php
                          
                      }
                      ?>
                    </select>
          </div>

      


          <div class="form-group">
            <label for="store_title">Address Line (show in app)</label>
            <input type="text" name="store_address_line" value="<?=isset( $store[ 'store_address_line' ] ) ? $store[ 'store_address_line' ]: ''?>" class="form-control" id="store_address_line" placeholder="Enter address line" <?= $readOnly ?> required>
          </div>


          <div class="form-group">
            <label for="store_title">Offer tag(show in app)</label>
            <input type="text" name="store_offer_text" value="<?=isset( $store[ 'store_offer_text' ] ) ? $store[ 'store_offer_text' ]: ''?>" class="form-control" id="store_offer_text" placeholder="Enter offer tag">
          </div>



          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
				<div class="form-group">
                    <label for="store_status">Status</label>
                    <select class="form-control" id="store_status" name="store_status">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $store[ 'store_status' ] ) && $store[ 'store_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
				<?php 
		  }
		  ?>


   

          
          
          
        </div>

         <?php
          if( Modules::run( 'login/is_admin' ) )
      {
        ?>

        <div class="col-md-4">
          <div class="form-group">
            <label for="product_title">Return/Exchange Policy</label>  
          
            
           
            <textarea class="form-control" <?= $readOnly ?> name="return_policy"> <?= isset($store['return_policy']) ? $store['return_policy'] :''?></textarea> 
          </div>
        </div> 
      <?php } ?>

         <div class="col-md-4">
          <div class="form-group">
            <label for="store_image">Store Image</label>
            
            <?php
            if( isset( $store[ 'store_logo' ] )  && trim( $store[ 'store_logo' ] ) != '' )
              {
                echo "<input type=\"hidden\" name=\"store_image_last\" value=\"{$store[ 'store_logo' ]}\">";
                echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/store/{$store[ 'store_logo' ]}\" class=\"img-responsive pad\" ></div>";
              }
              ?>
            <?php
                if( Modules::run( 'login/is_admin' ) )
            {
              ?>
            <input type="file" id="store_logo" <?= $readOnly ?> name="store_logo"  data-error="Please upload an image for the portfolio" <?=isset( $store[ 'store_logo' ] )  && trim( $store[ 'store_logo' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          <?php } ?>
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
<script type="text/javascript">
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
