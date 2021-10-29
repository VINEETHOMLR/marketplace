<div class="box box-default collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Contacts Selected
      <?=sizeof( $contacts )?>
    </h3>
    <div class="box-tools pull-right">
      <button type="button" id="contactsShowButton" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> </button>
    </div>
    <!-- /.box-tools --> 
  </div>
  <!-- /.box-header -->
  <div class="box-body" style="display: none;">
    <div id="js-table-table"></div>
  </div>
  <!-- /.box-body --> 
</div>
<div class="box box-info" id="composeBox">
  <div class="box-header with-border">
    <h3 class="box-title">Create Email</h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <div class="box-body">
    <div class="form-group">
      <label for="subject" class="col-sm-2 control-label">Subject</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="subject" placeholder="Email subject">
      </div>
    </div>
    <br/>
    <div class="form-group">
      <label for="greeting" class="col-sm-2 control-label">Greeting</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="greeting" placeholder="Ex : Hello dear {name} ,">
        <p class="help-block">Use <strong>{name}</strong> where you want to show user name , <br/>
          Ex : Hello dear {name} , </p>
      </div>
    </div>
    <div class="form-group">
      <label for="content" class="col-sm-2 control-label">Mail Content</label>
      <div class="col-sm-10">
        <textarea id="content" class="trumbowyg"></textarea>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-info pull-right" id="sendMail">Send Mail</button>
  </div>
  <!-- /.box-footer --> 
</div>
<div class="box box-solid" id="progessBox" style="display:none">
  <div class="box-header with-border">
    <h3 class="box-title">Send mail result</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="progress" id="progress">
    </div>
    <div id="mailResult"></div>
  </div>
  <!-- /.box-body --> 
</div>
<script>
var contacts	=	<?=json_encode($contacts)?>;
</script> 
<script>
var tableConfig = {
	"data" : contacts,
    "columns": [{
			title: '#',
			align : 'center',
			formatter : function(value , row , index){
					return index + 1;
				}
		},
		{
			field: 'contact_name',
			title: 'Name',
		},
		{
			field: 'contact_email',
			title: 'Email',
			
		},
	



    ],

    "uniqueId" : "contact_id",
    "classes": "table table-hover",
    
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 5,
    "pageList": "[5 , 10 , 15 , 20 , 50 ]",

};



console.log(tableConfig);

var actions = {
	
};


</script> 
