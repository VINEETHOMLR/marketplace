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
    <h3 class="box-title"><?=isset( $category[ 'category_id' ] ) ? 'Edit category' : 'Add New category'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="category_form" method="post" action="<?=$this->base?>category/admin_category/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $category[ 'category_id' ] )  && trim( $category[ 'category_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"category_id\" value=\"{$category[ 'category_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="category_title">Category  Title</label>
            <input type="text" name="category_name" value="<?=isset( $category[ 'category_name' ] ) ? $category[ 'category_name' ]: ''?>" class="form-control" id="category_title" placeholder="Enter category  Title" required>
          </div>

         

          
          <div class="form-group">
            <label for="category_image">category Image</label>
            
            <?php
            if( isset( $category[ 'category_image' ] )  && trim( $category[ 'category_image' ] ) != '' )
        			{
        				echo "<input type=\"hidden\" name=\"category_image_last\" value=\"{$category[ 'category_image' ]}\">";
        				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/category/{$category[ 'category_image' ]}\" class=\"img-responsive pad\" ></div>";
        			}
        			?>
            
            <input type="file" id="category_image" name="category_image"  data-error="Please upload an image for the portfolio" <?=isset( $category[ 'category_image' ] )  && trim( $category[ 'category_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          </div>
        
          

          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
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
				<?php 
		  }
		  ?>
          
          
        </div>
        
        
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>

