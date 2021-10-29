<style>
.typeahead {
	z-index: 1051;
}
.bootstrap-tagsinput {
	width: 100%;
	border-radius: 0px;
}
</style>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
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
 });</script>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?=isset( $blog[ 'blog_id' ] ) ? 'Edit Blog' : 'Add New Blog'?></h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="blog_form" method="post" action="<?=$this->base?>blog/blog/update" enctype="multipart/form-data"  accept-encoding="utf-8">
  	<?php
    if( isset( $blog[ 'blog_id' ] )  && trim( $blog[ 'blog_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"blog_id\" value=\"{$blog[ 'blog_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="blog_name">Blog  Title</label>
            <input type="text" name="blog_name" value="<?=isset( $blog[ 'blog_name' ] ) ? $blog[ 'blog_name' ]: ''?>" class="form-control" id="blog_name" placeholder="Enter Blog  Title" required>
          </div>
          <div class="form-group">
            <label for="blog_image">Blog Image</label>
            
            <?php
            if( isset( $blog[ 'blog_image' ] )  && trim( $blog[ 'blog_image' ] ) != '' )
			{
				echo "<input type=\"hidden\" name=\"blog_image_last\" value=\"{$blog[ 'blog_image' ]}\">";
				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/blog/{$blog[ 'blog_image' ]}\" class=\"img-responsive pad\" ></div>";
			}
			?>
            
            <input type="file" id="blog_image" name="blog_image"  data-error="Please upload an image for the blog" <?=isset( $blog[ 'blog_image' ] )  && trim( $blog[ 'blog_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          </div>
          <div class="form-group hide">
            <label for="blog_tags">Blog  Tags</label>
            <input type="text" value="<?=isset( $blog[ 'blog_tags' ] ) ? $blog[ 'blog_tags' ]: ''?>"  name="blog_tags" class="form-control" id="blog_tags" placeholder="Enter Blog Tags"  >
            <p class="help-block ">hit enter on each new tag</p>
          </div>
          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
				<div class="form-group">
                    <label for="blog_status">Status</label>
                    <select class="form-control" id="blog_status" name="blog_status">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $blog[ 'blog_status' ] ) && $blog[ 'blog_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
				<?php 
		  }
		  ?>
          
          
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Blog</label>
            <textarea name="blog_description" class="form-control tinymce" ><?=isset( $blog[ 'blog_description' ] ) ? $blog[ 'blog_description' ]: ''?></textarea>
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
<script>
  places=<?= Modules::run('blog/blog/get_tags')?>
  console.log(places);
</script>
