
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Category Listed</h3>
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
        field: 'category_name',
        title: 'Service',
        width : '20%',
        formatter : function(value , row){
		
		var client_image = row.client_image || 'default.png';
		return  [
            '<div class="pad innerAll inner-2x">',
            '<div class="attachment-block clearfix">',
                    '<img class="attachment-img" src="'+base+'assets/uploads/category/'+row.category_image+'" alt="Article Image">',
                    '<div class="attachment-pushed">',
                      '<h4 class="attachment-heading"><a href="">'+row.category_name+'</a></h4>',
                      
                    '</div>',
                  '</div>',
                  '</div>'
            ].join( '' );
        }
    },
    
    {
			field: 'category_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.category_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.category_id,
						name : 'category_status',
						url: "<?=$this->base?>category/admin_category/change_status",
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

    "uniqueId" : "category_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "category/admin_category/list_json",
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
		url : base + "category/admin_category/form/",
	},
	edit : {
		url : base + "category/admin_category/form/",
		modal : '#add-new-modal'
	}
};

</script> 
