

<div id="videoUploaderWrap" class="col-md-12	">
<?php
foreach ($videos as $key => $v) {
	?>
	<div class="col-md-4  uploaderWrap " style="border: 1px solid #ccc;">
	   <div class=" well-sm no-shadow">
	      <div style="height:20px" class="delete-img-wrap  "><a href="#" class="pull-right text-danger delete-img"><i class="fa fa-trash"></i></a></div>
	      <div class="img-preview">
	      <img src="<?=$this->base?>assets/uploads/images/default.png" class="img-responsive"></div>
	      <input class="form-control videosrc" placeholder="youtube video url" name="videos[][video_name]"  value="<?=$v[ 'video_name' ]?>">
	      <input class="form-control hide"  placeholder="Video alt text" name="videos[][video_alt_text]" value="<?=$v[ 'video_alt_text' ]?>">
	   </div>
	</div>
	<?php
}

?>
<div id="videoUploaderTemplate" class="hide">
<div class="col-md-4  uploaderWrap "  style="border: 1px solid #ccc;">
	   <div class=" well-sm no-shadow">
	      <div style="height:20px" class="delete-img-wrap  "><a href="#" class="pull-right text-danger delete-img"><i class="fa fa-trash"></i></a></div>
	      <div class="img-preview">
	      <img src="<?=$this->base?>assets/uploads/images/default.png" class="img-responsive"></div>
	      <input class="form-control videosrc" placeholder="youtube video url" name="videos[][video_name] value="">
	      <input class="form-control hide" placeholder="Video alt text" name="videos[][video_alt_text]" value="">
	   </div>
	</div>
</div>
</div>
<div style="clear: both;"></div>
<a class="btn btn-succes clearFix pull-right" id="addVideo"><i class="fa  fa-plus-circle"></i> Add More Video(s)</a>
<div style="clear: both;"></div>