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
    <h3 class="box-title"><?=isset( $blog[ 'blog_id' ] ) ? 'Edit Event' : 'Add New Event'?> 900*600px</h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform " id="blog_form" method="post" action="<?=$this->base?>events/events/update" enctype="multipart/form-data" >
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
            <label for="blog_name">Event  Title</label>
            <input type="text" name="blog_name" value="<?=isset( $blog[ 'blog_name' ] ) ? $blog[ 'blog_name' ]: ''?>" class="form-control" id="blog_name" placeholder="Enter Event  Title" required>
          </div>
          <div class="form-group">
            <label for="blog_image">Event Image</label>
            
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
            <label for="blog_tags">Event  Tags</label>
            <input type="text" value="<?=isset( $blog[ 'blog_tags' ] ) ? $blog[ 'blog_tags' ]: ''?>"  name="blog_tags" class="form-control" id="blog_tags" placeholder="Enter Event Tags"  >
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
          <div class="form-group">
            <label for="blog_name">Event  Location</label>
            <input type="text" name="blog_location" value="<?=isset( $blog[ 'blog_location' ] ) ? $blog[ 'blog_location' ]: ''?>" class="form-control" id="blog_location" placeholder="Enter Event  Location" required>
          </div>
          <div class="form-group">
            <label for="blog_name">Event  Time</label>
            <input type="text" name="blog_time" value="<?=isset( $blog[ 'blog_time' ] ) ? $blog[ 'blog_time' ]: ''?>" class="form-control" id="blog_time" placeholder="Enter Event  Time" required>
          </div>
          
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Event</label>
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
