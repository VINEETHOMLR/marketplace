
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Token List</h3>
   <!--  <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Category</a> -->
  </div>
  <div class="box-body">
  	<div class="row">
      
      
      <div class="col-md-4">
        <div class="form-group">
          <select class="form-control js-table-loader-filter" data-filter-key="token_status">
            <option value="">--Select Status --</option>
            <?php
                    foreach( CommonStatus::getDropDown() as $k => $v )
					{
						echo "<option value=\"$k\" >{$v}</option>";
					}
					?>
          </select>
        </div>
      </div>

     
      

	 
	  
    </div>
    <div id="js-table-table"></div>
  </div>
</div>

<script>
var tableConfig = {
    "columns": [{
			title: '#',
			align : 'center',
			formatter : function(value , row , index){
					   return index + 1;
				}
		},
		{
			field: 'token_value',
			title: 'Token',
		},
		
		{
			field: 'token_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.token_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.token_id,
						name : 'token_status',
						url: "<?=$this->base?>token/admin_token/change_status",
						title: "Change Status",
						source: <?=json_encode(CommonStatus::xEditArray())?>,
						ajaxOptions: {
								type: 'post',
								dataType: 'json',
							},
						
						};
				var frmt = $('<a>',{
					//html : 'superuser',
					href : '#',
					'data-xeditableoptions' : JSON.stringify(xEditableOptions),
					class : "x-editable"
					});
				return frmt.prop('outerHTML');
				//return '<a href="#" class="x-editable" data-xeditableoptions = "'+JSON.stringify(xEditableOptions)+'">superuser</a>';
			}
		},
	



    ],

    "uniqueId" : "token_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "token/admin_token/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 10,
    "pageList": "[5 , 10 , 15 , 20 , 50 ]",
    "dataField": "rows",
    "sidePagination": "server",
    "refresh" : {
        silent: true
    },
};





var actions = {
	delete : {
		url : base + "token/admin_token/remove/",
	},
	/*add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "category/admin_categories/form/",
		
	},
	edit : {
		url : base + "category/admin_categories/form/",
		modal : '#add-new-modal'
	}*/
};





</script>