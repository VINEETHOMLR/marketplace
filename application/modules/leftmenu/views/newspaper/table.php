<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Newspaper</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Newspaper</a>
  </div>
  <div class="box-body">
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
			field: 'newspaper_title',
			title: 'Title',
		},
		
		{
			field: 'newspaper_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.newspaper_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.newspaper_id,
						name : 'newspaper_status',
						url: "<?=$this->base?>leftmenu/admin_newspaper/change_status",
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

    "uniqueId" : "newspaper_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "leftmenu/newspapers/list_json",
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
		url : base + "leftmenu/admin_newspaper/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "leftmenu/admin_newspaper/form/",
		
	},
	edit : {
		url : base + "leftmenu/admin_newspaper/form/",
		modal : '#add-new-modal'
	}
};





</script>