<?php 
$categories=Modules::run('leftmenu/Admin_foodcategory/get_categories');
$subcategories=Modules::run('leftmenu/Admin_foodsubcategory/get_subcategories');


?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: '#food_description',
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
 });</script>
 <script>
  
var uri="<?= $this->uri->segment(2); ?>";
//alert(uri);
</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
      <?=isset( $food[ 'food_id' ] ) ? 'Edit Food' : 'Add New Food'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="food_form" method="post" action="<?=$this->base?>leftmenu/admin_food/update" enctype="multipart/form-data" >
    <?php
    if( isset( $food[ 'food_id' ] )  && trim( $food[ 'food_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"food_id\" value=\"{$food[ 'food_id' ]}\">";
		//echo $food[ 'food_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="food_name">Food Title </label>
            <input type="text" name="food_title" value="<?=isset( $food[ 'food_title' ] ) ? $food[ 'food_title' ]: ''?>" class="form-control" id="food_title" placeholder="Enter category title" required>
          </div>
          
          
          <div class="form-group">
            <label for="food_name">Food Title(English) </label>
            <input type="text" name="food_title_english" value="<?=isset( $food[ 'food_title_english' ] ) ? $food[ 'food_title_english' ]: ''?>" class="form-control" id="food_title_english" placeholder="Enter food title(english)" required>
          </div>
          
          <div class="form-group">
            <label for="food_status">Category</label>
            <select class="form-control" id="food_status" name="food_category">
              <?php
                      foreach( $categories as $k => $v )
                      {?>
                            <option value='<?= $v['category_id']?>' <?php  if($food['food_category']==$v['category_id']){ echo "selected";}?>><?= $v['category_title']?></option>
                      <?php }
                      ?>
            </select>
          </div>

          <div class="form-group">
            <label for="food_status">Subategory</label>
            <select class="form-control" id="food_subcategory" name="food_subcategory">
              <?php
                      foreach( $subcategories as $k => $v )
                      {?>
                            <option value='<?= $v['subcategory_id']?>' <?php  if($food['food_subcategory']==$v['subcategory_id']){ echo "selected";}?>><?= $v['subcategory_title']?></option>
                      <?php }
                      ?>
            </select>
          </div>

         

          
          
          <div class="form-group">
            <label for="food_status">Status</label>
            <select class="form-control" id="food_status" name="food_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $food[ 'food_status' ] ) && $food[ 'food_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="food_image">Food Image</label>
            
            <?php
            if( isset( $food[ 'food_image' ] )  && trim( $food[ 'food_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"food_image\" value=\"{$food[ 'food_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/food/{$food[ 'food_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="food_image" name="food_image"  data-error="Please upload an image for the message" <?=isset( $food[ 'food_image' ] )  && trim( $food[ 'food_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Description</label>
            <textarea name="food_description" id="food_description" class="form-control tinymce" ><?=isset( $food[ 'food_description' ] ) ? $food[ 'food_description' ]: ''?></textarea>
          </div>
        </div>
        
        <div class="col-md-8">
          
          
        	
          <div class="form-group">
            <label for="exampleInputFile">English to  malayalam(ഇവിടെ മലയാളം ടൈപ്പ് ചെയ്തു മുകളിൽ പേസ്റ്റ് ചെയുക )</label>
            <textarea  id="eng_mal" class="form-control tinymce" >
            </textarea>
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
