
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Authentication keys  Listed</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Key</a>
  </div>
  <div class="box-body">
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
        field: 'blog_name',
        title: 'Key',
        width : '60%',
        formatter : function(value , row){
		
		var blog_img = row.blog_image || 'default.png';
		return  [
            '<div class="pad innerAll inner-2x">',
            '<div class="attachment-block clearfix">',
                    
                    '<div class="attachment-pushed">',
                      '<h4 class="attachment-heading"><a href="">'+row.authentication_key+'</a></h4>',
                     
                    '</div>',
                  '</div>',
                  '</div>'
            ].join( '' );
        }
    },
    {
			field: 'authentication_status',
			title: 'Key Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.authentication_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.authentication_id,
						name : 'authentication_status',
						url: "<?=$this->base?>authentication/change_status",
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

    "uniqueId" : "authentication_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": 'http://www.localhost/psc/authentication/authentications/list_json',
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
			row.blog_description,
			'</div>'
            ].join( '' );
		
        return [
        '<div class="innerAll inner-2x">',
		'<div class="row"><div class="col-md-4">',
        row.blog_description,
        '</div>'
        ].join('');


    }



};







var actions = {
	delete : {
		url : base + "authentication/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "authentication-form/",
	},
	edit : {
		url : base + "authentication-form/",
		modal : '#add-new-modal'
	}
};

</script> 
