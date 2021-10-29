<?php
$base	=	$this->base;
?>

<form class="form-horizontal mvform" method="post" action="<?=$base.'user/password/change_password'?>"  >
  <input type="hidden" name="email" value="<?=$this->user[ 'email' ]?>" >
  
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Current Password</label>
    <div class="col-sm-10">
      <input type="password"  class=" form-control  validate[required,minSize[6]] " name="old"   required>
    </div>
  </div>
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label"> New Password</label>
    <div class="col-sm-10">
      <input type="password" class=" form-control  validate[minSize[6]] "  name="new" id="newpassword"   required>
    </div>
  </div>
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label"> Confirm Password</label>
    <div class="col-sm-10">
      <input type="password" class=" form-control  validate[minSize[6],equals[newpassword]] "  name="re"   required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button class="btn btn-danger  ladda-button" data-style="expand-right" type="submit"   >Submit</button>
    </div>
  </div>
</form>
