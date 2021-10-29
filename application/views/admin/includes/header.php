<?php
$base	=	$this->base;
$user_image	=	trim( $this->user[ 'image' ] ) ? $this->user[ 'image' ] : 'default.png';
?>
<header class="main-header">
  
  <!-- Logo -->
  
  <a href="javscript:void(0)" class="logo"> 
  <!-- mini logo for sidebar mini 50x50 pixels --> 
  <span class="logo-mini"><?=$this->project_name?></span> 
  <!-- logo for regular state and mobile devices --> 
  <span class="logo-lg"><?=$this->project_name?></span> </a> 
  
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top"> 
    <!-- Sidebar toggle button--> 
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a> 
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?=$base?>assets/uploads/users/<?=$user_image?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?=$this->user[ 'first_name' ].' '.$this->user[ 'last_name' ]?></span> </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header"> <img src="<?=$base?>assets/uploads/users/<?=$user_image?>" class="img-circle" alt="User Image">
              <p> <?=$this->user[ 'first_name' ].' '.$this->user[ 'last_name' ]?>  <small><?=$this->project_name?> <?=$this->ion_auth->get_users_groups()->row()->name?></small> </p>
            </li>
            <!-- Menu Body -->
            
            <!-- Menu Footer-->
            <li class="user-footer">
              <!--<div class="pull-left"> <a href="<?=base_url().'user/profile'?>" class="btn btn-default btn-flat">Profile</a> </div>-->
              <div class="pull-right"> <a href="<?=base_url().'login/logout'?>" class="btn btn-default btn-flat">Sign out</a> </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        
      </ul>
    </div>
  </nav>
</header>
