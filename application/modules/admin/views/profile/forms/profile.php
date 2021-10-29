<?php
$base	=	$this->base;
$user_image	=	trim( $this->user[ 'image' ] ) ? $this->user[ 'image' ] : 'default.png';

//$readonly = Modules::run( 'login/is_admin' )==true ? '' : 'readonly';
$readonly = "";

?>

<form class="form-horizontal mvform" method="post" action="<?=$base.'admin/admin_profile/update'?>" id="user-profile-form"  enctype="multipart/form-data" >
	<input type="hidden" name="id" value="<?=$this->user[ 'id' ]?>" >
    
    <?php
	if( isset( $this->user[ 'image' ] )  && trim( $this->user[ 'image' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"image_last\" value=\"{$this->user[ 'image' ]}\">";
	}
	
	?>
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Profile Picture</label>
    <div class="col-sm-10">
      <div class="img-preview"><img src="<?=$this->base?>assets/uploads/users/<?=$user_image?>" class="img-responsive pad" width="300" ></div>
      <input type="file" id="image" name="image" placeholder="Change image" />
      <div class="help-block">Maximum file size of 2 MB ( jpg | png | jpeg ) allowded.</div>
    </div>
  </div>
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">First Name</label>
    <div class="col-sm-10">
      <input type="text" class=" form-control validate[required]   " value="<?=$this->user['first_name']?>" name="first_name" required <?= $readonly ?>>
    </div>
  </div>
  <div class="form-group  ">
    <label for=" " class="col-sm-2 control-label">Last Name</label>
    <div class="col-sm-10">
      <input type="text" class=" form-control   " value="<?=$this->user['last_name']?>" name="last_name"  <?= $readonly ?>>
    </div>
  </div>
  
  
  
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="text" class=" form-control   " value="<?=$this->user['email']?>" name="email"  <?= $readonly ?> required>
    </div>
  </div>
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Phone</label>
    <div class="col-sm-10">
      <input type="text" class=" form-control   " value="<?=$this->user['phone']?>" name="phone" <?= $readonly ?>  >
    </div>
  </div>
  
  
  
  
  
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button class="btn btn-success  ladda-button" data-style="expand-right" type="submit"    >Submit</button>
    </div>
  </div>
</form>
