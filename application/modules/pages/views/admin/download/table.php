<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Downloads</h3>
    <!--<a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Category</a>-->
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
<form class="" method="post" action="<?=$this->base?>pages/admin_category/update">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Category</h4>
    </div>
    <div class="modal-body">
      <input type="hidden" name="id" value="{{record.image_id}}">
      <input type="hidden" name="last_image" value="{{record.image_image}}">
      <div class="row form-group"> 
        <div class="col-md-4 ">Display picture 270*320px </div>
        <div class="col-md-8">
          <div class="img-preview"><img width="150" 
      src="{{{base}}}assets/uploads/category/{{#if  record.image_image}}{{record.image_image}}{{else}}default.png{{/if}}" 
      class="img-responsive pad" ></div>
          <input type="file" id="image_image" name="image_image" placeholder="Change image" />
          <div class="help-block">Maximum file size of 2 MB ( jpg | png | jpeg ) allowded.</div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-4 ">Category Name </div>
        <div class="col-md-8">
          <input type="text" name="image_title"  value="{{record.image_title}}" class="form-control"  placeholder="Enter  category title" required >
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
			title: 'Post Title',
			width : '20%',
			formatter : function(value , row){
			
			var post_image = row.image_name || 'default.png';
			return  [
				'<span>'+row.image_title+'</span>',
						
				].join( '' );
			}
		},
		{
			title: 'Created By',
			width : '20%',
			formatter : function(value , row){
			
			
			return  [
				'<span>'+row.first_name+'</span>'

				].join( '' );
			}
		},
		{
			title: 'Category',
			width : '20%',
			formatter : function(value , row){
			
			
			return  [
				'<span>'+row.image_category_title+'</span>'

				].join( '' );
			}
		},
		
		{
			title: 'Downloads',
			width : '20%',
			formatter : function(value , row){
			
			
			return  [
				'<span>'+row.image_no_of_downloads+'</span>'

				].join( '' );
			}
		},
		
		
	



    ],

    "uniqueId" : "image_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "pages/admin_downloads/list_json",
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
/*	delete : {
		url : base + "pages/admin_posts/delete/",
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
	}*/
};


</script>