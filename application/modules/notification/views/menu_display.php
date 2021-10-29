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
  $class = $v[ 'notification_status' ]  ==  NotificationStatus::READ ? 'read' : '';
?>
  <div class="notification-menu-item clearfix <?=$class?>">
   <a href="<?=$this->base?>notification/read/<?=( $v[ 'notification_id' ] )?>/<?=( $v[ 'notification_link' ] )?>">
    <p style=" " class="mb0">
     <?=$v[ 'notification_description' ]?>
    </p>
    <div class="text-right clearfix">
    <small class=""><?=time_elapsed_string($v[ 'notification_join_date' ])?></small>
    </div>
    </a>
  </div>
<?php
}
?>
