<?php
$imageOptions	=	array(
'initialCount' =>  3,
'image_content_type' => imageType::GALLERY,
'image_ref_id'=> isset( $gallery[ 'gallery_id' ] ) ? $gallery[ 'gallery_id' ] : 0
);
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?=isset( $gallery[ 'gallery_id' ] ) ? 'Edit Gallery' : 'Add New Gallery'?></h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="gallery_form" method="post" action="<?=$this->base?>img/admin_gallery/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $gallery[ 'gallery_id' ] )  && trim( $gallery[ 'gallery_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"gallery_id\" value=\"{$gallery[ 'gallery_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
      <div class="form-group col-md-12">
            <label for="gallery_name">Gallery  Title</label>
            <input type="text" name="gallery_name" value="<?=isset( $gallery[ 'gallery_name' ] ) ? $gallery[ 'gallery_name' ]: ''?>" class="form-control" id="gallery_name" placeholder="Enter Gallery  Title" required>
          </div>
          </div>
      <div class="row">
      <div class="form-group col-md-12 imageUploader" data-options=<?=json_encode($imageOptions)?> >
      </div>
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>