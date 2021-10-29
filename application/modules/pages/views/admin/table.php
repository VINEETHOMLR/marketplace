<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Pages Listed</h3>
   <!-- <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Page</a>-->
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
var tableConfig = {
    "columns": [
    {
        field: 'page_name',
        title: 'Page',
        width : '80%',
        formatter : function(value , row){
		
		var page_img = row.page_image || 'default.png';
		
		if( row.page_cms_flag != 1 )
		
		return '<h4 class="attachment-heading">'+row.page_name+'</h4>';
		
		return  [
            '<div class="pad innerAll inner-2x">',
            '<div class="attachment-block clearfix">',
			       
                    '<img class="attachment-img" src="'+base+'assets/uploads/pages/'+page_img+'" alt="Article Image">',
					
                    '<div class="attachment-pushed">',
                      '<h4 class="attachment-heading"><a href="">'+row.page_name+'</a></h4>',
                      '<div class="attachment-text">',
					  '<a href="'+base+'pages/admin_pages/form/'+row.page_id+'" class="pull-right">',
					  '<i class="fa fa-2x fa-pencil-square-o"></i></a>',
                        
                     '</div>',
                    '</div>',
                  '</div>',
                  '</div>'
            ].join( '' );
        }
    },
 /*{
      field: 'page_status',
      title: 'page Status',
      align : 'center',
      formatter : function(value , row){
        var xEditableOptions  = {
            value : row.page_status,
            defaultValue : "Not active",
            type : "select",
            pk: row.page_id,
            name : 'page_status',
            url: "<?=$this->base?>pages/admin_pages/change_status",
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
*/

    {
			title: 'Seo',
			align : 'center',
			formatter : function(value , row){
				row[ 'content_type' ] = '<?=ContentTypes::PAGE?>';
				row[ 'content_ref_id' ] = row.page_id;
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

    "uniqueId" : "page_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "pages/admin_pages/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 10,
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
			row.page_cms,
			'</div>'
            ].join( '' );
		
        return [
        '<div class="innerAll inner-2x">',
		'<div class="row"><div class="col-md-4">',
        row.page_cms,
        '</div>'
        ].join('');


    },
	



};




var actions = {
  add : {
    selector : '#add_new',
    template : '#add-new-template',
    modal : '#add-new-modal',
    hbs : '#add-item-template',
    url : base + "pages/admin_pages/form/",
  },
   /* edit : {
    url : base + "pages/admin_pages/form/",
    modal : '#add-new-modal'
  },*/
  delete : {
    url : base + "packages/admin_categories/remove/",
  },
};

</script> 
