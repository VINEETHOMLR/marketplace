
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: '#history_description',
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
      <?=isset( $history[ 'history_id' ] ) ? 'Edit History' : 'Add New History'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="history_form" method="post" action="<?=$this->base?>leftmenu/admin_history/update" enctype="multipart/form-data" >
    <?php
    if( isset( $history[ 'history_id' ] )  && trim( $history[ 'history_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"history_id\" value=\"{$history[ 'history_id' ]}\">";
		//echo $history[ 'history_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="history_name">Title </label>
            <input type="text" name="history_title" value="<?=isset( $history[ 'history_title' ] ) ? $history[ 'history_title' ]: ''?>" class="form-control" id="history_title" placeholder="Enter history title" required>
          </div>
          
          
          <div class="form-group">
            <label for="history_name">Title(english) </label>
            <input type="text" name="history_title_english" value="<?=isset( $history[ 'history_title_english' ] ) ? $history[ 'history_title_english' ]: ''?>" class="form-control" id="history_title_english" placeholder="Enter history title(English)" required>
          </div>

          <div class="form-group">
            <label for="history_name">Map </label>
            <input type="text" name="history_map" value="<?=isset( $history[ 'history_map' ] ) ? $history[ 'history_map' ]: ''?>" class="form-control" id="history_url" placeholder="Enter map" required>
          </div>

          
          
          <div class="form-group">
            <label for="history_status">Status</label>
            <select class="form-control" id="history_status" name="history_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $history[ 'history_status' ] ) && $history[ 'history_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="history_image">Image</label>
            
            <?php
            if( isset( $history[ 'history_image' ] )  && trim( $history[ 'history_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"history_image\" value=\"{$history[ 'history_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/history/{$history[ 'history_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="history_image" name="history_image"  data-error="Please upload an image for the message" <?=isset( $history[ 'history_image' ] )  && trim( $history[ 'history_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>

            
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Description</label>
            <textarea name="history_description" id="history_description" class="form-control tinymce" ><?=isset( $history[ 'history_description' ] ) ? $history[ 'history_description' ]: ''?></textarea>
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
