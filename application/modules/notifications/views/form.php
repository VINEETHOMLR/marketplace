
<script>
  
var uri="<?= $this->uri->segment(2); ?>";
//alert(uri);
</script>
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
    <h3 class="box-title">
      <?=isset( $notification[ 'notification_id' ] ) ? 'Edit Category' : 'Add New Notificaton'?>
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="notification_form" method="post" action="<?=$this->base?>notifications/admin_notification/update" enctype="multipart/form-data" >
    <?php
    if( isset( $notification[ 'notification_id' ] )  && trim( $notification[ 'notification_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"notification_id\" value=\"{$notification[ 'notification_id' ]}\">";
		//echo $notification[ 'notification_id' ];
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <!-- <div class="form-group">
            <label for="notification_name">Category Name </label>
            <input type="text" name="notification_title" value="<?=isset( $notification[ 'notification_title' ] ) ? $notification[ 'notification_title' ]: ''?>" class="form-control" id="notification_title" placeholder="Enter Category  Name" required>
          </div> -->
          <div class="form-group">
            <label for="notification_name">Title </label>
            <input type="text" name="notification_title" value="<?=isset( $notification[ 'notification_title' ] ) ? $notification[ 'notification_title' ]: ''?>" class="form-control" id="notification_title" placeholder="Enter title" required>
          </div>

          <div class="form-group">
            <label for="notification_name">Message </label>
            <input type="text" name="notification_message" value="<?=isset( $notification[ 'notification_message' ] ) ? $notification[ 'notification_message' ]: ''?>" class="form-control" id="notification_message" placeholder="Enter message" required>
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
