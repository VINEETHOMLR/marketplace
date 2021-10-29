
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: '#message_description',
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
      <?=isset( $message[ 'message_id' ] ) ? 'Edit Message' : 'Add New Message'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="message_form" method="post" action="<?=$this->base?>leftmenu/admin_message/update" enctype="multipart/form-data" >
    <?php
    if( isset( $message[ 'message_id' ] )  && trim( $message[ 'message_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"message_id\" value=\"{$message[ 'message_id' ]}\">";
		//echo $message[ 'message_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">

        <div class="form-group">
            <label for="message_username">Name </label>
            <input type="text" name="message_username" value="<?=isset( $message[ 'message_username' ] ) ? $message[ 'message_username' ]: ''?>" class="form-control" id="message_username" placeholder="Enter username" >
          </div>

          <div class="form-group">
            <label for="message_phone">Phone </label>
            <input type="text" name="message_phone" value="<?=isset( $message[ 'message_phone' ] ) ? $message[ 'message_phone' ]: ''?>" class="form-control" id="message_phone" placeholder="Enter phone" >
          </div>

          <div class="form-group">
            <label for="message_name">Message Title </label>
            <input type="text" name="message_title" value="<?=isset( $message[ 'message_title' ] ) ? $message[ 'message_title' ]: ''?>" class="form-control" id="message_title" placeholder="Enter message title" required>
          </div>
          
          <div class="form-group">
            <label for="message_name">Message Title(English) </label>
            <input type="text" name="message_title_english" value="<?=isset( $message[ 'message_title_english' ] ) ? $message[ 'message_title_english' ]: ''?>" class="form-control" id="message_title_english" placeholder="Enter message title(english)" required>
          </div>

          
          
          
          <div class="form-group">
            <label for="message_status">Status</label>
            <select class="form-control" id="message_status" name="message_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $message[ 'message_status' ] ) && $message[ 'message_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="message_image">Message Image</label>
            
            <?php
            if( isset( $message[ 'message_image' ] )  && trim( $message[ 'message_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"message_image\" value=\"{$message[ 'message_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/message/{$message[ 'message_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="message_image" name="message_image"  data-error="Please upload an image for the message" <?=isset( $message[ 'message_image' ] )  && trim( $message[ 'message_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Message</label>
            <textarea name="message_description" id="message_description" class="form-control tinymce" ><?=isset( $message[ 'message_description' ] ) ? $message[ 'message_description' ]: ''?></textarea>
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
