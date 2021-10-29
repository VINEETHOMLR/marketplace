<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Hash Tag</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Hash Tag</a>
  </div>
  <div class="box-body">
    <div id="js-table-table"></div>
  </div>
</div>
<div id="add-new-modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  id="add-new-template">
  
  </div>
</div>

<script id="add-item-template" type="text/x-handlebars-template">
<form class="" method="post" action="<?=$this->base?>pages/admin_hash_tag/update">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Hash Tag </h4>
    </div>
    <div class="modal-body">
      <input type="hidden" name="id" value="{{record.hash_tags_id}}">
      <!--<input type="hidden" name="last_image" value="{{record.image_category_image}}">
     <div class="row form-group"> 
        <div class="col-md-4 ">Display picture 270*320px </div>
        <div class="col-md-8">
          <div class="img-preview"><img width="150" 
      src="{{{base}}}assets/uploads/category/{{#if  record.image_category_image}}{{record.image_category_image}}{{else}}default.png{{/if}}" 
      class="img-responsive pad" ></div>
          <input type="file" id="image_category_image" name="image_category_image" placeholder="Change image" />
          <div class="help-block">Maximum file size of 2 MB ( jpg | png | jpeg ) allowded.</div>
        </div>
      </div>-->


      <div class="row form-group">
        <div class="col-md-4 ">Hash Tag Title </div>
        <div class="col-md-8">
          <input type="text" name="hash_tags_title"  value="{{record.hash_tags_title}}" class="form-control"  placeholder="Enter  Hash Tag  Title" required >
        </div>
      </div>
      
      
     
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-success ladd_button pull-right"  >Submit</button>
    </div>
  </div>
</form>

</script>
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
			title: 'Name',
			width : '60%',
			formatter : function(value , row){
			
			var category_img = row.image_category_image || 'default.png';
			return  [
				'<div class="pad innerAll inner-2x">',
				'<div class="attachment-block clearfix">',
						
						'<div class="attachment-pushed">',
						  '<h4 class="attachment-heading"><a href="">'+row.hash_tags_title+'</a></h4>',
						  
						'</div>',
					  '</div>',
					  '</div>'
				].join( '' );
			}
		},
		{
			title: 'Created By',
			width : '60%',
			formatter : function(value , row){
			
			
			return  [
				
				'<span">'+row.username+'</span>',	
					 
				].join( '' );
			}
		},
		{
			field: 'hash_tags_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				console.log('row.hash_tags_status',row)
				var xEditableOptions	=	{
						value : row.hash_tags_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.hash_tags_id,
						name : 'hash_tags_status',
						url: "<?=$this->base?>pages/admin_hash_tag/change_status",
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

    "uniqueId" : "hash_tags_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "pages/admin_hash_tag/list_json",
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
		url : base + "pages/admin_hash_tag/delete/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template'
		
	},
	edit : {
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template'
	}
};


</script>