
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: '#about_description',
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
      <?=isset( $about[ 'about_id' ] ) ? 'Edit About' : 'Add New About'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="about_form" method="post" action="<?=$this->base?>leftmenu/admin_about/update" enctype="multipart/form-data" >
    <?php
    if( isset( $about[ 'about_id' ] )  && trim( $about[ 'about_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"about_id\" value=\"{$about[ 'about_id' ]}\">";
		//echo $about[ 'about_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="about_name">Title </label>
            <input type="text" name="about_title" value="<?=isset( $about[ 'about_title' ] ) ? $about[ 'about_title' ]: ''?>" class="form-control" id="about_title" placeholder="Enter about title" required>
          </div>

          

          
          
          
          

            
          
        
         
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="exampleInputFile">Description</label>
            <textarea name="about_description" id="about_description" class="form-control tinymce" ><?=isset( $about[ 'about_description' ] ) ? $about[ 'about_description' ]: ''?></textarea>
          </div>


          <div class="form-group">
            <label for="exampleInputFile">ഇവിടെ ടൈപ്പ് ചെയ്തു മുകളിൽ പേസ്റ്റ് ചെയുക </label>
            <textarea id="about_description2" class="form-control tinymce" ></textarea>
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
