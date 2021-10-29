<div class="body-content clearfix">
   <div class="bg-color2">
      <div class="container">
         <div class="col-md-3 col-sm-3">
            <?=Modules::run( 'user/user_widgets/left_menu' )?>
         </div>
         <div class="col-md-9 col-sm-9">
              <div class="block-section box-side-account">
                <h3 class="no-margin-top">Notifications</h3>
                <hr/>
                <?php
                if( !$rows )
                {
                  echo '<div class="alert alert-warning alert-dismissible fade in text-center">No notifications</div>';
                }
                foreach ($rows as $key => $v) {
                  $link = $this->base."notification/read/{$v[ 'notification_id' ]}/{$v[ 'notification_link' ]}";
                  ?>
                  <div class="alert <?=$v[ 'notification_status' ]==NotificationStatus::PENDING ? 'alert-success' :'alert-warning' ?> alert-dismissible fade in" role="alert">
                  <div class="row">
                  <div class="col-md-10"> <?=$v[ 'notification_description' ]?></div>
                  <div class="col-md-2"><a href="<?=$link?>" class="btn btn-xs btn-danger btn-theme"> View </a><br/>
                  <small><?=time_elapsed_string($v[ 'notification_join_date' ])?></small>
                  </div>
                  </div>
                  
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
      </div>
   </div>
</div>
