
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
      <?=isset( $newspaper[ 'newspaper_id' ] ) ? 'Edit Newspaper' : 'Add New Newspaper'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="newspaper_form" method="post" action="<?=$this->base?>leftmenu/admin_newspaper/update" enctype="multipart/form-data" >
    <?php
    if( isset( $newspaper[ 'newspaper_id' ] )  && trim( $newspaper[ 'newspaper_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"newspaper_id\" value=\"{$newspaper[ 'newspaper_id' ]}\">";
		//echo $newspaper[ 'newspaper_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="newspaper_name">Newspaper Title </label>
            <input type="text" name="newspaper_title" value="<?=isset( $newspaper[ 'newspaper_title' ] ) ? $newspaper[ 'newspaper_title' ]: ''?>" class="form-control" id="newspaper_title" placeholder="Enter newspaper title" required>
          </div>
          <div class="form-group">
            <label for="newspaper_name">Newspaper Title (english)</label>
            <input type="text" name="newspaper_title_english" value="<?=isset( $newspaper[ 'newspaper_title_english' ] ) ? $newspaper[ 'newspaper_title_english' ]: ''?>" class="form-control" id="newspaper_title_english" placeholder="Enter newspaper title(english)" required>
          </div>
          <div class="form-group">
            <label for="newspaper_name">Newspaper Url </label>
            <input type="text" name="newspaper_url" value="<?=isset( $newspaper[ 'newspaper_url' ] ) ? $newspaper[ 'newspaper_url' ]: ''?>" class="form-control" id="newspaper_url" placeholder="Enter newspaper url" required>
          </div>

          
          
          <div class="form-group">
            <label for="newspaper_status">Status</label>
            <select class="form-control" id="newspaper_status" name="newspaper_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $newspaper[ 'newspaper_status' ] ) && $newspaper[ 'newspaper_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="newspaper_image">Health Image</label>
            
            <?php
            if( isset( $newspaper[ 'newspaper_image' ] )  && trim( $newspaper[ 'newspaper_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"newspaper_image\" value=\"{$newspaper[ 'newspaper_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/newspaper/{$newspaper[ 'newspaper_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="newspaper_image" name="newspaper_image"  data-error="Please upload an image for the message" <?=isset( $newspaper[ 'newspaper_image' ] )  && trim( $newspaper[ 'newspaper_image' ] ) != '' ? '' : ''?>>
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
