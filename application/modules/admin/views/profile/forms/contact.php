<?php
$base	=	$this->base;


?>

<form class="form-horizontal mvform" method="post" action="<?=$base.'admin/admin_profile/update_contact'?>" id="user-profile-form"  enctype="multipart/form-data" >
	<input type="hidden" name="contact_id" value="<?= $contactdetails['contact_id']?>" >
  
  
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Address</label>
    <div class="col-sm-6">
        <div class="form-group">
      <textarea class=" form-control validate[required]   " name="contact_address"><?= $contactdetails['contact_address']?$contactdetails['contact_address']:''?></textarea>
    </div>
    </div>
  </div>
  
  
  
  
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Email</label>
    <input type="button" id="add_email" value="Add" class="add-btn">
    <div class="col-sm-6" id="emails">
      <?php $emails=json_decode($contactdetails['contact_email']);?>
      <?php foreach($emails as $k=>$v){


        ?>
        <div class="form-group">
      <input type="text" class=" form-control   " value="<?= $v?>" name="contact_email[]" id="email_<?= $k?>" >
    </div>
      <?php } ?>
      
    </div>
  </div>
  <div class="form-group">
    <label for=" " class="col-sm-2 control-label">Phone</label>
    <input type="button" id="add_phone" value="Add" class="add-btn">
    <div class="col-sm-6" id="phones">
      <?php $phone=json_decode($contactdetails['contact_phone']);?>
       <?php foreach($phone as $k=>$v){


        ?>      
        <div class="form-group">
      <input type="text" class=" form-control   " value="<?= $v?>" name="contact_phone[]"  id="phone_<?= $k?>" >
    </div>
      <?php } ?>
    </div>
  </div>
  
  
  
  
  
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
  <div class="form-group">
      <button class="btn btn-success  ladda-button" data-style="expand-right" type="submit"    >Submit</button>
    </div>
    </div>
  </div>
</form>


<style>
  
/* Aneesh Added CSS */
/* 27 04 2018 */
input.add-btn {
    margin: 0 0 0 10px;
    padding: 7px 30px;
    border: none;
    color: #fff;
    background-color: #398439;
    border-color: #255625;
    outline: none;
    text-transform: uppercase;
}
input.add-btn:hover {
  background: #44af44;
}
/* 27 04 2018 */
/* Aneesh Added CSS */
</style>
