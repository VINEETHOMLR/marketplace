
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
      <?=isset( $category[ 'category_id' ] ) ? 'Edit Category' : 'Add New Category'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="category_form" method="post" action="<?=$this->base?>leftmenu/admin_foodcategory/update" enctype="multipart/form-data" >
    <?php
    if( isset( $category[ 'category_id' ] )  && trim( $category[ 'category_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"category_id\" value=\"{$category[ 'category_id' ]}\">";
		//echo $category[ 'category_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="category_name">Category Title </label>
            <input type="text" name="category_title"  id="category_title" value="<?=isset( $category[ 'category_title' ] ) ? $category[ 'category_title' ]: ''?>" class="form-control" id="category_title" placeholder="Enter category title" required>
          </div>
          
          <div class="form-group">
            <label for="category_name">Category Title(English) </label>
            <input type="text" name="category_title_english"  id="category_title_english" value="<?=isset( $category[ 'category_title_english' ] ) ? $category[ 'category_title_english' ]: ''?>" class="form-control"  placeholder="Enter category title(english)" required>
          </div>
          

          
          
          <div class="form-group">
            <label for="category_status">Status</label>
            <select class="form-control" id="category_status" name="category_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $category[ 'category_status' ] ) && $category[ 'category_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="category_image">Category Image</label>
            
            <?php
            if( isset( $category[ 'category_image' ] )  && trim( $category[ 'category_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"category_image\" value=\"{$category[ 'category_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/foodcategory/{$category[ 'category_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="category_image" name="category_image"  data-error="Please upload an image for the message" <?=isset( $category[ 'category_image' ] )  && trim( $category[ 'category_image' ] ) != '' ? '' : ''?>>
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
