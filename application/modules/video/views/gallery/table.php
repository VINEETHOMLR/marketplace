<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Product Categories</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Gallery</a>
  </div>
  <div class="box-body">
    <div id="js-table-table"></div>
  </div>
</div>
<div id="add-new-modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  id="add-new-template">
    <form class="" method="post" action="<?=$this->base?>img/admin_gallery/update">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Gallery</h4>
        </div>
        <div class="modal-body">
          <div  >
            <input type="hidden" name="gallery_id"  value="{{record.gallery_id}}" >
            <div class="row form-group">
              <div class="col-md-4 ">Product Gallery<span class="text-danger">*</span> </div>
              <div class="col-md-8">
                <input type="text" name="gallery_name"  value="{{record.gallery_name}}" class="form-control"  placeholder="Enter Gallery Name"  required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success ladd_button pull-right"  >Submit</button>
        </div>
      </div>
    </form>
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
        title: 'Gallery',
        width : '60%',
        formatter : function(value , row){
		
			var main_image = row.main_image || 'default.png';
			return  [
				'<div class="pad innerAll inner-2x">',
				'<div class="attachment-block clearfix">',
						'<img class="attachment-img" src="'+base+'assets/uploads/images/'+main_image+'" alt="Gallery Image">',
						'<div class="attachment-pushed">',
						  '<h4 class="attachment-heading"><a href="">'+row.gallery_name+'</a></h4>',
						  '<div class="attachment-text">',
						  'Images Count: '+row.image_count,
						  '<br/>Created On: '+row.gallery_join_date,
							'</div>',
						'</div>',
					  '</div>',
					  '</div>'
				].join( '' );
			}
		},
		{
			field: 'gallery_status',
			title: 'Gallery Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.gallery_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.gallery_id,
						name : 'gallery_status',
						url: "<?=$this->base?>img/admin_gallery/change_status",
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

    "uniqueId" : "gallery_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "img/gallery/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 10,
    "pageList": "[5 , 10 , 15 , 20 , 50 ]",
    "dataField": "rows",
    "sidePagination": "server",
    "refresh" : {
        silent: true
    },
	detailView : true,
    detailFormatter : function(index, row, element) {
		
		var images = '';
		
		$.each( row.images , function(i,v){
			var class_name = v.image_is_main  ==1 ? 'bg-primary':'';
			images +=['<div class="well-sm col-md-2 '+class_name+'">',
			'<img class="img-responsive" src="'+base+'assets/uploads/images/'+v.image_name+'">',
			'</div>'
			].join('');
			})
		
        return [
        '<div class="innerAll inner-2x">',
		'<div class=" ">',
        images,
        '</div></div>'
        ].join('');


    }
};





var actions = {
	delete : {
		url : base + "img/admin_gallery/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		url : base + 'img/admin_gallery/form/'
		
	},
	edit : {
		url : base + "img/admin_gallery/update/",
		modal : '#add-new-modal',
		url : base +  'img/admin_gallery/form/'
	}
};


</script>