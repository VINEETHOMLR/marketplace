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
    <h3 class="box-title"><?=isset( $washer[ 'washer_id' ] ) ? 'Edit Washer' : 'Add New Washer'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="washer_form" method="post" action="<?=$this->base?>Washer/admin_Washer/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $washer[ 'washer_id' ] )  && trim( $washer[ 'washer_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"washer_id\" value=\"{$washer[ 'washer_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="washer_title">Washer  Name</label>
            <label for="washer_title" class="form-control"><?=isset( $washer[ 'washer_first_name' ] ) ? $washer[ 'washer_first_name' ].' '.$washer[ 'washer_last_name' ]: ''?></label>
            
          </div>

          <div class="form-group">
            <label for="washer_title">Washer  Phone</label>
            <label for="washer_title" class="form-control"><?=isset( $washer[ 'washer_phone' ] ) ? $washer[ 'washer_phone' ]: ''?></label>

          </div>
          <div class="form-group">
            <label for="washer_title">Washer  Email</label>
            <label for="washer_title" class="form-control"><?=isset( $washer[ 'washer_email' ] ) ? $washer[ 'washer_email' ]: ''?></label>

          </div>
          <div class="form-group">
            <label for="washer_title">Washer  Sex</label>
            <label for="washer_title" class="form-control"><?= $washer[ 'washer_sex' ]==1 ? 'Male': 'Female'?></label>

          </div>
          <div class="form-group">
            <label for="washer_title">Washer  DOB</label>
            <label for="washer_title" class="form-control"><?=isset( $washer[ 'washer_dob' ] ) ? date("d-m-Y", strtotime($washer[ 'washer_dob' ])): ''?></label>

          </div>

          
          
        
          

          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
				<div class="form-group">
                    <label for="washer_status">Status</label>
                    <select class="form-control" id="washer_status" name="washer_status" disabled="true">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $washer[ 'washer_status' ] ) && $washer[ 'washer_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
				<?php 
		  }
		  ?>

      <div class="form-group">
            <label for="washer_image">Washer Image</label>
            
            <?php
            if(count($images)>0)
              {

               // echo "<pre>";
               // print_r($images);exit;
                foreach($images as $k=>$v)
                {
                  echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/washer/{$v[ 'image_name' ]}\" class=\"img-responsive pad\" ></div>";
                }
                
              }
              ?>
            
        
          </div>
          
          
        </div>
        
        
      </div>
    </div>
    <!-- /.box-body -->
    <?php if($washer['washer_status']==2){?>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Approve</button>
    </div>
  <?php } ?>
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
