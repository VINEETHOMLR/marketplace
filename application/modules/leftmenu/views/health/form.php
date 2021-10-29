
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: '#health_description',
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
      <?=isset( $health[ 'health_id' ] ) ? 'Edit Health' : 'Add New Health'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="health_form" method="post" action="<?=$this->base?>leftmenu/admin_health/update" enctype="multipart/form-data" >
    <?php
    if( isset( $health[ 'health_id' ] )  && trim( $health[ 'health_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"health_id\" value=\"{$health[ 'health_id' ]}\">";
		//echo $health[ 'health_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="health_name">Health Title </label>
            <input type="text" name="health_title" value="<?=isset( $health[ 'health_title' ] ) ? $health[ 'health_title' ]: ''?>" class="form-control" id="health_title" placeholder="Enter health title" required>
          </div>
          
          <div class="form-group">
            <label for="health_name">Health Title(English) </label>
            <input type="text" name="health_title_english" value="<?=isset( $health[ 'health_title_english' ] ) ? $health[ 'health_title_english' ]: ''?>" class="form-control" id="health_title_english" placeholder="Enter health title(english)" required>
          </div>

          
          
          
          <div class="form-group">
            <label for="health_status">Status</label>
            <select class="form-control" id="health_status" name="health_status">
              <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $health[ 'health_status' ] ) && $health[ 'health_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
            </select>
          </div>
          <div class="form-group">
            <label for="health_image">Health Image</label>
            
            <?php
            if( isset( $health[ 'health_image' ] )  && trim( $health[ 'health_image' ] ) != '' )
      {
        echo "<input type=\"hidden\" name=\"health_image\" value=\"{$health[ 'health_image' ]}\">";
        echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/health/{$health[ 'health_image' ]}\" class=\"img-responsive pad\" ></div>";
      }
      ?>
            
            <input type="file" id="health_image" name="health_image"  data-error="Please upload an image for the message" <?=isset( $health[ 'health_image' ] )  && trim( $health[ 'health_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Description</label>
            <textarea name="health_description" id="health_description" class="form-control tinymce" ><?=isset( $health[ 'health_description' ] ) ? $health[ 'health_description' ]: ''?></textarea>
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
