<?php
    $base = $this->base;
    $user_image = trim( $this->user[ 'image' ] ) ? $this->user[ 'image' ] : 'default.png';
?>
<form class="form-horizontal mvform" method="post" action="<?=$base.'admin/admin_profile/update_social'?>" enctype="multipart/form-data" >
  <input type="hidden" name="id" value="<?=$this->user[ 'id' ]?>" >
  <div class="col-md-12"><button class="btn btn-success mb10 pull-right" data-style="expand-right" type="button" id="addnew">Add New</button></div>
  <div id="socialsettings">
    <?php foreach($social as $k=>$v){?>
    
    <div class="col-md-4">
      <div class="form-group ma0">
        
        <select class="form-control mb10" name="social_id[]">
          <option value="0">Select</option>
          <?php foreach(Socialmedia::getdropDown() as $k2=>$v2){?>
          <option value="<?= $k2?>" <?php if($k2==$v['social_id']) { echo "selected";}?> ><?= $v2?></option>
          <?php   }?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group ma0 mb10">
        <input type="text" class=" form-control " value="<?= $v['social_link']?>" name="social_link[]" placeholder="Social media link" >
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group ma0 mb10">
        <select class="form-control" name="social_status[]">
          <option value="0">Select</option>
          <?php foreach(SocialmediaStatus::getdropDown() as $k3=>$v3){?>
          <option value="<?= $k3?>" <?php if($k3==$v['social_status']) { echo "selected";}?>><?= $v3?></option>
          <?php   }?>
          
        </select>
      </div>
      <input type="hidden" value="<?= $v['id']?>" name="id[]">
    </div>
    <?php } ?>
  </div>
  <div class="form-group">
    <div class="col-md-4">
      <button class="btn btn-success ladda-button ml15" data-style="expand-right" type="submit"    >Submit</button>      
    </div>
  </div>
</form>
<script>
var socialmedia='<?php echo json_encode(Socialmedia::getdropDown());?>'  ;
var status='<?php echo json_encode(SocialmediaStatus::getdropDown());?>'  ;
</script>
<style>
.ma0 {
    margin: 0 !important;
}
  .mb10 {
    margin-bottom: 10px !important;
}
.ml15 {
    margin-left: 15px !important;
}
</style>