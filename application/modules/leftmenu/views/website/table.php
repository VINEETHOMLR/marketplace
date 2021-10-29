<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Website</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Website</a>
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
			field: 'website_title',
			title: 'Title',
		},
		
		{
			field: 'website_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.website_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.website_id,
						name : 'website_status',
						url: "<?=$this->base?>leftmenu/admin_website/change_status",
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

    "uniqueId" : "website_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "leftmenu/admin_website/list_json",
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
		url : base + "leftmenu/admin_website/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "leftmenu/admin_website/form/",
		
	},
	edit : {
		url : base + "leftmenu/admin_website/form/",
		modal : '#add-new-modal'
	}
};





</script>