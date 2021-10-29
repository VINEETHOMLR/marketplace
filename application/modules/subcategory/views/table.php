
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Subcategory Listed</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Category</a> 
  </div>
  <div class="box-body">
  	<div class="row">
      <div class="col-md-6">
      
      </div>
      
     
    </div>
    <div id="js-table-table"></div>
  </div>
</div>
<div id="add-new-modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  id="add-new-template">
  
  </div>
</div>


<script>
var statusOptions	=	<?=json_encode( CommonStatus::getDropDown() )?>;
var tableConfig = {
    "columns": [
    {
        field: 'product_category_name',
        title: 'Name',
        width : '20%',
       
    },

    {
        field: 'category_name',
        title: 'Parent Category',
        width : '20%',
       
    },
    
    {
			field: 'product_category_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.product_category_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.product_category_id,
						name : 'product_category_status',
						url: "<?=$this->base?>subcategory/admin_subcategory/change_status",
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

    "uniqueId" : "product_category_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "subcategory/admin_subcategory/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 5,
    "pageList": "[10 , 20]",
    "dataField": "rows",
    "sidePagination": "server",
    "refresh" : {
        silent: true
    },
	detailView : false,
    detailFormatter : function(index, row, element) {
		
		
		return  [
			'<div class="pad innerAll inner-2x">',
			row.client_description,
			'</div>'
            ].join( '' );
		
        return [
        '<div class="innerAll inner-2x">',
		'<div class="row"><div class="col-md-4">',
        row.client_description,
        '</div>'
        ].join('');


    }



};







var actions = {
	/*delete : {
		url : base + "service/admin_service/remove/",
	},*/
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "subcategory/admin_subcategory/form/",
	},
	edit : {
		url : base + "subcategory/admin_subcategory/form/",
		modal : '#add-new-modal'
	}
};

</script> 
