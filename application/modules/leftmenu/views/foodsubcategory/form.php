<?php 
$categories=Modules::run('leftmenu/foodcategories/dropdown');


?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>/*tinymce.init({
  selector: 'textarea',
  height: 200,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ],
setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
 });*/</script>
 <script>
  
var uri="<?= $this->uri->segment(2); ?>";
//alert(uri);
</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
      <?=isset( $subcategory[ 'subcategory_id' ] ) ? 'Edit Subategory' : 'Add New Subategory'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="subcategory_form" method="post" action="<?=$this->base?>leftmenu/admin_foodsubcategory/update" enctype="multipart/form-data" >
    <?php
    if( isset( $subcategory[ 'subcategory_id' ] )  && trim( $subcategory[ 'subcategory_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"subcategory_id\" value=\"{$subcategory[ 'subcategory_id' ]}\">";
		//echo $subcategory[ 'subcategory_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="subcategory_name">Subategory Title </label>
            <input type="text" name="subcategory_title" value="<?=isset( $subcategory[ 'subcategory_title' ] ) ? $subcategory[ 'subcategory_title' ]: ''?>" class="form-control" id="subcategory_title" placeholder="Enter category title" required>
          </div>
          
          <div class="form-group">
            <label for="subcategory_name">Subategory Title(English) </label>
            <input type="text" name="subcategory_title_english" value="<?=isset( $subcategory[ 'subcategory_title_english' ] ) ? $subcategory[ 'subcategory_title_english' ]: ''?>" class="form-control" id="subcategory_title_english" placeholder="Enter subcategory title(English)" required>
          </div>
          
          <div class="form-group">
            <label for="subcategory_status">Category</label>
            <select class="form-control" id="subcategory_status" name="subcategory_category_id">
              <?php
                      foreach( $categories as $k => $v )
                      {
                            $selected = isset( $subcategory[ 'subcategory_category_id' ] ) && $subcategory[ 'subcategory_category_id' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          
          
          <div class="form-group">
            <label for="subcategory_status">Status</label>
            <select class="form-control" id="subcategory_status" name="subcategory_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $subcategory[ 'subcategory_status' ] ) && $subcategory[ 'subcategory_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="subcategory_image">Subategory Image</label>
            
            <?php
            if( isset( $subcategory[ 'subcategory_image' ] )  && trim( $subcategory[ 'subcategory_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"subcategory_image\" value=\"{$subcategory[ 'subcategory_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/foodsubcategory/{$subcategory[ 'subcategory_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="subcategory_image" name="subcategory_image"  data-error="Please upload an image for the message" <?=isset( $subcategory[ 'subcategory_image' ] )  && trim( $subcategory[ 'subcategory_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
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
