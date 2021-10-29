<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Subcategories</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Subcategory</a>
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
			field: 'subcategory_title',
			title: 'Title',
		},
		{
			field: 'category_title',
			title: 'Category',
		},
		{
			field: 'subcategory_sort_order',
			title: 'Order',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.subcategory_sort_order,
						defaultValue : 0,
						type : "text",
						pk: row.subcategory_id,
						name : 'subcategory_sort_order',
						url: "<?=$this->base?>leftmenu/admin_foodsubcategory/change_status",
						title: "Change Order",
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
		
		{
			field: 'subcategory_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.subcategory_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.subcategory_id,
						name : 'subcategory_status',
						url: "<?=$this->base?>leftmenu/admin_foodsubcategory/change_status",
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

    "uniqueId" : "subcategory_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "leftmenu/admin_foodsubcategory/list_json",
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
		url : base + "leftmenu/admin_foodsubcategory/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "leftmenu/admin_foodsubcategory/form/",
		
	},
	edit : {
		url : base + "leftmenu/admin_foodsubcategory/form/",
		modal : '#add-new-modal'
	}
};





</script>