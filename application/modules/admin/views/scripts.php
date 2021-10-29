<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?=$this->project_name?> Scripts</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form class="mvform" action="<?=$this->base?>admin/scripts/update" method="post" >
            <div class="row form-group">
            <div class="col-md-4 "> Header Script <span class="text-danger">*</span> </div>
            <div class="col-md-8">
              <textarea class="form-control" rows="4" name="headerscript" required><?=isset( $script[ 'headerscript' ] ) ? base64_url_decode( $script[ 'headerscript' ] ) : '' ?>
</textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4 "> Footer Script <span class="text-danger">*</span> </div>
            <div class="col-md-8">
              <textarea class="form-control" rows="4" name="script" required><?=isset( $script[ 'script' ] ) ? base64_url_decode( $script[ 'script' ] ) : '' ?>
</textarea>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4 ">Status</div>
            <div class="col-md-8">
              <select name="script_status" class="from-control" >
                <option value="1" <?=$script[ 'script_status' ] == 1 ? 'selected' : ''?>  >ACTIVE</option>
                <option value="2" <?=$script[ 'script_status' ] == 2 ? 'selected' : ''?> >HOLD</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-4 "></div>
            <div class="col-md-8">
              <button type="submit" class="btn btn-suceess ladda-button" data-style="expand-right" >Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
