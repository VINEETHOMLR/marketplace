<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"> API Settings </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="form-horizontal mvform" id="blog_form" method="post" action="<?=$this->base?>admin/admin_settings/update" enctype="multipart/form-data" >
    <input type="hidden" name="settings_id" value="<?=$settings[ 'settings_id' ]?>" >
    <div class="box-body">
     <div class="form-group">
        <label  class="col-sm-2 control-label">API KEY </label>
        <div class="col-sm-10">
          <input type="text" name="api_key" value="<?= $settings[ 'api_key' ]?>" class="form-control" required>
        </div>
      </div>

      
    

      
     
      
      <hr/>
      
      
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>
