<?php
$user_image	=	trim( $this->user[ 'image' ] ) ? $this->user[ 'image' ] : 'default.png';
?>

<div class="row"> 
  
  <!-- /.col -->
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#activity" data-toggle="tab">My Proflie</a></li>
        <li><a href="#timeline" data-toggle="tab">Update Profile</a></li>
        <?php
          if( Modules::run( 'login/is_admin' ) ||  Modules::run( 'login/is_storeadmin' ))
         {
        ?>
        <li><a href="#settings" data-toggle="tab">Change Password</a></li>
      <?php } ?>
        <!-- <li><a href="#socialmedia" data-toggle="tab">Social Media</a></li> -->
       <!--  <li><a href="#contact" data-toggle="tab">Contact Details</a></li> -->
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="activity">
          <div class=" ">
            <div class="box-body box-profile"> <img class="profile-user-img img-responsive img-circle" src="<?=$this->base?>assets/uploads/users/<?=$user_image?>" alt="User profile picture">
              <h3 class="profile-userfirst_name text-center">
                <?=$this->user[ 'first_name' ].' '.$this->user[ 'last_name' ]?>
              </h3>
              <p class="text-muted text-center">
                <?=$this->project_name?>
                <?=$this->ion_auth->get_users_groups()->row()->name?>
              </p>
              <p class="text-muted text-center"> <b>Email</b> <a class=" ">
                <?=$this->user[ 'email' ]?>
                </a></p>
              <p class="text-muted text-center"> <b>Phone</b> <a class=" ">
                <?=$this->user[ 'phone' ] ? $this->user[ 'phone' ] : '-NA-' ?>
                </a></p>
            </div>
            <!-- /.box-body --> 
          </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="timeline"> 
          <!-- The timeline --> 
          <br/>
          <?php
                include( 'forms/profile.php' );
				?>
        </div>
        <!-- /.tab-pane -->
        
        <div class="tab-pane" id="settings"> <br/>
          <?php
                include( 'forms/password.php' );
				?>
        </div>
         <!-- <div class="tab-pane" id="socialmedia"> <br/>
          <?php
                include( 'forms/socialmedia.php' );
                 ?>
                 </div> -->
        <!-- <div class="tab-pane" id="contact"> <br/>
          <?php
                include( 'forms/contact.php' );
        ?>
        </div> -->
        <!-- /.tab-pane --> 
      </div>
      <!-- /.tab-content --> 
    </div>
    <!-- /.nav-tabs-custom --> 
  </div>
  <!-- /.col --> 
</div>
<!-- /.row --> 

