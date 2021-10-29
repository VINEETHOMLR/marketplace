<?php
$image	=	$astrologer[ 'image' ]?$astrologer[ 'image' ]:'default';
$pending_badge	=	'<span class="pull-right badge bg-danger"><i class=" fa  fa-exclamation"></i></span>';
$active_badge	=	'<span class="pull-right badge bg-success"><i class="fa  fa-check"></i></span>';
?>
<div class="row">
    <div class="col-md-4"><img class="  img-responsive  " src="<?=$this->base?>assets/uploads/users/<?=$image?>" alt="User profile picture">
    </div>
    <div class="col-md-8"><h3 class="box-title text-warning"><?=$astrologer[ 'first_name' ]?></h3>
    
    <p><i class="fa fa-envelope-o"></i>
          <?=$astrologer[ 'email' ]?>
          <?=$astrologer[ 'email_ver_status' ] == 1 ? $active_badge : $pending_badge?>
          </p>
    <p><i class="fa fa-phone"></i>
          <?=$astrologer[ 'phone' ]?>
          <?=$astrologer[ 'phone_ver_status' ] == 1 ? $active_badge : $pending_badge?>
          </p>
          <p><i class="fa  fa-map-marker"></i>
          <?=$astrologer[ 'city' ]?>
    </div>