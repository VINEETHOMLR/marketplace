
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Event List</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Event</a>
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
        title: 'Name',
        width : '60%',
        formatter : function(value , row){
		
		var blog_img = row.blog_image || 'default.png';
		return  [
            '<div class="pad innerAll inner-2x">',
            '<div class="attachment-block clearfix">',
                    '<img class="attachment-img" src="'+base+'assets/uploads/blog/'+blog_img+'" alt="Article Image">',
                    '<div class="attachment-pushed">',
                      '<h4 class="attachment-heading"><a href="">'+row.blog_name+'</a></h4>',
                      '<div class="attachment-text">',
                        row.blog_description.substring(0, 200 ),
                     ' <span class="text-danger">.....</span></div>',
                    '</div>',
                  '</div>',
                  '</div>'
            ].join( '' );
        }
    },

    {
			field: 'home_dis_order',
			title: 'Home Events',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.home_dis_order,
						defaultValue : 0,
						type : "text",
						pk: row.blog_id,
						name : 'home_dis_order',
						url: "<?=$this->base?>events/change_status",
						title: "Home - Events",
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
			field: 'blog_status',
			title: ' Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.blog_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.blog_id,
						name : 'blog_status',
						url: "<?=$this->base?>events/change_status",
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
		{
			title: 'SEO',
			align : 'center',
			formatter : function(value , row){
				row[ 'content_type' ] = '<?=ContentTypes::EVENT?>';
				row[ 'content_ref_id' ] = row.blog_id;
				var seoData	=	{record : row };
				var frmt = $('<div>',{
					html : '<i class="fa fa-gear fa-spin"></i>',
					'data-seo-options' : JSON.stringify(seoData),
					class : "mv-seo"
					});
				return frmt.prop('outerHTML');
				//return '<a href="#" class="x-editable" data-xeditableoptions = "'+JSON.stringify(xEditableOptions)+'">superuser</a>';
			}
		},
    ],

    "uniqueId" : "blog_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "events/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 5,
    "pageList": "[10 , 20]",
    "dataField": "rows",
    "sidePagination": "server",
    "refresh" : {
        silent: true
    },
	detailView : true,
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
		url : base + "events/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "events/form/",
	},
	edit : {
		url : base + "events/form/",
		modal : '#add-new-modal'
	}
};

</script> 
