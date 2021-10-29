<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Testimonials</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Testimonial</a>
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
<form class="" method="post" action="<?=$this->base?>pages/admin_testimonials/update">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Testimonials</h4>
    </div>
    <div class="modal-body">
      <input type="hidden" name="id" value="{{record.testimonial_id}}">
      <input type="hidden" name="last_image" value="{{record.testimonial_user_image}}">
      <div class="row form-group"> 
        <div class="col-md-4 ">Display picture 90*90px </div>
        <div class="col-md-8">
          <div class="img-preview"><img width="150" 
      src="{{{base}}}assets/uploads/users/{{#if  record.testimonial_user_image}}{{record.testimonial_user_image}}{{else}}default.png{{/if}}" 
      class="img-responsive pad" ></div>
          <input type="file" id="testimonial_user_image" name="testimonial_user_image" placeholder="Change image" />
          <div class="help-block">Maximum file size of 2 MB ( jpg | png | jpeg ) allowded.</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 ">User name </div>
        <div class="col-md-8">
          <input type="text" name="testimonial_name"  value="{{record.testimonial_name}}" class="form-control"  placeholder="Enter User Name" required >
        </div>
      </div>
      <div class="row form-group hide">
        <div class="col-md-4 "> User Type <span class="text-danger">*</span> </div>
        <div class="col-md-8"> {{{select options.UserGroups 'testimonial_user_type' record.testimonial_user_type }}} </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 "> Testimonial <span class="text-danger">*</span> </div>
        <div class="col-md-8">
          <textarea name="testimonial_description" class="form-control"  placeholder="Enter Testimonial"  required>{{record.testimonial_description}}</textarea>
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
			title: 'Testimonial',
			width : '60%',
			formatter : function(value , row){
			
			var blog_img = row.testimonial_user_image || 'default.png';
			return  [
				'<div class="pad innerAll inner-2x">',
				'<div class="attachment-block clearfix">',
						'<img class="attachment-img" src="'+base+'assets/uploads/users/'+blog_img+'" alt="Article Image">',
						'<div class="attachment-pushed">',
						  '<h4 class="attachment-heading"><a href="">'+row.testimonial_name+'</a></h4>',
						  '<div class="attachment-text">',
							row.testimonial_description,
						 ' </div>',
						'</div>',
					  '</div>',
					  '</div>'
				].join( '' );
			}
		},
		{
			field: 'testimonial_status',
			title: 'Testimonial Status',
			align : 'center',
			formatter : function(value , row){
				console.log('row.testimonial_status',row)
				var xEditableOptions	=	{
						value : row.testimonial_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.testimonial_id,
						name : 'testimonial_status',
						url: "<?=$this->base?>pages/admin_testimonials/change_status",
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

    "uniqueId" : "testimonial_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "pages/admin_testimonials/list_json",
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
		url : base + "pages/admin_testimonials/delete/",
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