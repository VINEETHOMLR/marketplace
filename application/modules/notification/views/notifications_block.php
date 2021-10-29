
<?php
if( !sizeof($notifications) )
{
	?>
  <div class="booking-item booking-item-small ">
  <div class="text-info text-center">No notifications for you . </div>
  </div>
	<?php
}

foreach( $notifications as $v )
{
	$class = $v[ 'notification_status' ]	==	NotificationStatus::READ ? ' bg-gray' : ' bg-white';
	$text	=	$v[ 'notification_type' ] = NotificationTypes::NOTFICATION ? 'View' : 'Respond Now';
?>
<div class="">
  <div class="row border-gray <?=$class?> box mb10 ">
    <div class="col-xs-9">
      <p><?=$v[ 'notification_description' ]?></p>
    </div>
    <div class="col-xs-3 text-right">
      <p class="mt10">
        <a href="<?=$this->base?>notification/read/<?=( $v[ 'notification_id' ] )?>/<?=( $v[ 'notification_link' ] )?>" class="btn btn-success btn-sm"><?=$text?></a>
        <div class="pull-right"> <small><?=time_elapsed_string($v[ 'notification_join_date' ])?></small></div>
      </p>
    </div>
  </div>
</div>
  

<?php
}
?>

