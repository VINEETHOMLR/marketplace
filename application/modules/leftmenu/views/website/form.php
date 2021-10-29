
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
      <?=isset( $website[ 'website_id' ] ) ? 'Edit Website' : 'Add New Website'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="website_form" method="post" action="<?=$this->base?>leftmenu/admin_website/update" enctype="multipart/form-data" >
    <?php
    if( isset( $website[ 'website_id' ] )  && trim( $website[ 'website_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"website_id\" value=\"{$website[ 'website_id' ]}\">";
		//echo $website[ 'website_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="website_name">Title </label>
            <input type="text" name="website_title" value="<?=isset( $website[ 'website_title' ] ) ? $website[ 'website_title' ]: ''?>" class="form-control" id="website_title" placeholder="Enter  title" required>
          </div>

          <div class="form-group">
            <label for="website_name">Url </label>
            <input type="text" name="website_url" value="<?=isset( $website[ 'website_url' ] ) ? $website[ 'website_url' ]: ''?>" class="form-control" id="website_url" placeholder="Enter url" required>
          </div>

          
          
          <div class="form-group">
            <label for="website_status">Status</label>
            <select class="form-control" id="website_status" name="website_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $website[ 'website_status' ] ) && $website[ 'website_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="website_image">Image</label>
            
            <?php
            if( isset( $website[ 'website_image' ] )  && trim( $website[ 'website_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"website_image\" value=\"{$website[ 'website_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/website/{$website[ 'website_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="website_image" name="website_image"  data-error="Please upload an image for the message" <?=isset( $website[ 'website_image' ] )  && trim( $website[ 'website_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>

            
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Description</label>
            <textarea name="website_description" id="website_description" class="form-control tinymce" ><?=isset( $website[ 'website_description' ] ) ? $website[ 'website_description' ]: ''?></textarea>
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
