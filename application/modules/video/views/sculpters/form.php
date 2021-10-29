<?php
$imageOptions	=	array(
'image_content_type' => imageType::SCULPTERS,
'image_ref_id'=> 0,
'wrapClass' => 'col-md-3',
'perRow' => 4,
'initialCount' =>  8,
);
?>
<style>
.select_main_radio{display:none}
</style>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Sculptures And 3D drawings</h3>
  </div>
  <div class="alert alert-info">
  Select Images with png | jpg | jpeg and maximum size of 2 mb.
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform"  method="post" action="<?=$this->base?>img/admin_sculpters/update" enctype="multipart/form-data" >
  
    <div class="box-body">
      
      <div class="row">
      <div class="form-group col-md-12 imageUploader" data-options=<?=json_encode($imageOptions)?> >
      </div>
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save Changes</button>
    </div>
  </form>
</div>