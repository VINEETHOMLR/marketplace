
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: '#cinema_description',
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
      <?=isset( $cinema[ 'cinema_id' ] ) ? 'Edit Cinema' : 'Add New Cinema'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="cinema_form" method="post" action="<?=$this->base?>leftmenu/admin_cinema/update" enctype="multipart/form-data" >
    <?php
    if( isset( $cinema[ 'cinema_id' ] )  && trim( $cinema[ 'cinema_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"cinema_id\" value=\"{$cinema[ 'cinema_id' ]}\">";
		//echo $cinema[ 'cinema_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="cinema_name">Cinema Title </label>
            <input type="text" name="cinema_title" value="<?=isset( $cinema[ 'cinema_title' ] ) ? $cinema[ 'cinema_title' ]: ''?>" class="form-control" id="cinema_title" placeholder="Enter newspaper title" required>
          </div>
          
          <div class="form-group">
            <label for="cinema_name">Cinema Title(English) </label>
            <input type="text" name="cinema_title_english" value="<?=isset( $cinema[ 'cinema_title_english' ] ) ? $cinema[ 'cinema_title_english' ]: ''?>" class="form-control" id="cinema_title_english" placeholder="Enter cinema title(english)" required>
          </div>

          <div class="form-group">
            <label for="cinema_name">Cinema Book Url </label>
            <input type="text" name="cinema_book_url" value="<?=isset( $cinema[ 'cinema_book_url' ] ) ? $cinema[ 'cinema_book_url' ]: ''?>" class="form-control" id="cinema_url" placeholder="Enter cinema book url" required>
          </div>

          
          
          <div class="form-group">
            <label for="cinema_status">Status</label>
            <select class="form-control" id="cinema_status" name="cinema_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $cinema[ 'cinema_status' ] ) && $cinema[ 'cinema_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="cinema_image">Cinema Image</label>
            
            <?php
            if( isset( $cinema[ 'cinema_image' ] )  && trim( $cinema[ 'cinema_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"cinema_image\" value=\"{$cinema[ 'cinema_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/cinema/{$cinema[ 'cinema_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="cinema_image" name="cinema_image"  data-error="Please upload an image for the message" <?=isset( $cinema[ 'cinema_image' ] )  && trim( $cinema[ 'cinema_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>

            
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Description</label>
            <textarea name="cinema_description" id="cinema_description" class="form-control tinymce" ><?=isset( $cinema[ 'cinema_description' ] ) ? $cinema[ 'cinema_description' ]: ''?></textarea>
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
