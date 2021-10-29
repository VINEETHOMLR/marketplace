<div id="seoFormModalTemplate">
<div class="modal modal-info" id="seoFormModal">
  <div class="modal-dialog">
    <div class="modal-content" id="" >
      <form class="mvform" method="post" action="<?=$this->base?>seo/update"  >
        {{hidden "seo_id" record.seo_id}}
        {{hidden "content_type" record.content_type}}
        {{hidden "content_ref_id" record.content_ref_id}}
        {{hidden "seo_id" record.seo_id}}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Seo Details</h4>
        </div>
        <div class="modal-body">
          <div class="widget-body innerAll inner-2x">
            <div class="row form-group">
              <div class="col-md-4 "> Page Title<span class="text-danger">*</span> </div>
              <div class="col-md-8"> {{input "seo_title" record.seo_title class="form-control validate[required]"  placeholder="Enter Page Title"  }} </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4 "> Page Keywords<span class="text-danger">*</span> </div>
              <div class="col-md-8"> {{textarea "seo_keywords" record.seo_keywords class="form-control validate[required]"  placeholder="Enter Page Keywords" }} </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4 "> Page Description<span class="text-danger">*</span> </div>
              <div class="col-md-8"> {{textarea "seo_description" record.seo_description class="form-control validate[required]"  placeholder="Enter Page Description" }} </div>
            </div>
            <div style="clear:both"></div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mvform_result"></div>
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><span class="ladda-label">Close</span></button>
          <button type="submit" class="btn btn-outline ladda-button" data-style="expand-right" ><span class="ladda-label">Save</span></button>
        </div>
      </form>
    </div>
    
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
</div>