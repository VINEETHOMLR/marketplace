<style>
.typeahead {
	z-index: 1051;
}
.bootstrap-tagsinput {
	width: 100%;
	border-radius: 0px;
}
.trumbowyg-box{
  
}
</style>
<script>
  var base='<?= $this->base?>';
</script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  var uploadurl=base+'blog/blog/tinymce_upload';
  
  tinymce.init({
  selector: 'textarea',
  height: 100,
  theme: 'modern',
 // plugins:'code image',
  plugins: [
    'advlist autolink lists  image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc code image'
  ],
   toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image code',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',

  //toolbar:'undo redo | image code',
  
setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }

 });</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?=isset( $service[ 'service_id' ] ) ? 'Edit Service' : 'Add New Service'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="service_form" method="post" action="<?=$this->base?>service/admin_service/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $service[ 'service_id' ] )  && trim( $service[ 'service_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"service_id\" value=\"{$service[ 'service_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="service_title">Service  Title</label>
            <input type="text" name="service_name" value="<?=isset( $service[ 'service_name' ] ) ? $service[ 'service_name' ]: ''?>" class="form-control" id="service_title" placeholder="Enter service  Title" required>
          </div>

          <div class="form-group">
            <label for="service_title">Service  Rate</label>
            <input type="text" name="service_rate" value="<?=isset( $service[ 'service_rate' ] ) ? $service[ 'service_rate' ]: ''?>" class="form-control  " id="" onkeypress="return isNumber(event)"  placeholder="Enter service  Rate" required>
          </div>

          
          <div class="form-group">
            <label for="service_image">Service Image</label>
            
            <?php
            if( isset( $service[ 'service_image' ] )  && trim( $service[ 'service_image' ] ) != '' )
        			{
        				echo "<input type=\"hidden\" name=\"service_image_last\" value=\"{$service[ 'service_image' ]}\">";
        				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/service/{$service[ 'service_image' ]}\" class=\"img-responsive pad\" ></div>";
        			}
        			?>
            
            <input type="file" id="service_image" name="service_image"  data-error="Please upload an image for the portfolio" <?=isset( $service[ 'service_image' ] )  && trim( $service[ 'service_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          </div>
        
          

          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
				<div class="form-group">
                    <label for="service_status">Status</label>
                    <select class="form-control" id="service_status" name="service_status">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $service[ 'service_status' ] ) && $service[ 'service_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
				<?php 
		  }
		  ?>
          
          
        </div>
        
        
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>
<script type="text/javascript">
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
