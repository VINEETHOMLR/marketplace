<?php 

$categoryList=Modules::run('category/admin_category/getlist');

$statusList=json_decode(CommonStatus::xEditArray(),true);



?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Stores Listed</h3>
     <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New store</a>
  </div>
  <div class="box-body">
  	<div class="row text-right pad " style="clear: both;">
      <div class="col-md-2">
      <input type="text" class="form-control js-table-loader-search" data-search-key="search" placeholder="Name" > 
      </div>
      <div class="col-md-2">
         <select class="js-table-loader-filter form-control" data-filter-key="store_category">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($categoryList as $key => $value) { ?>
         
          <option value="<?= $value['category_id']?>"><?= $value['category_name']?></option>
         
       <?php }
        ?>
          
        </select>
      </div> 

      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="store_status">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($statusList as $key => $value) { ?>
         
          <option value="<?= $value['value']?>"><?= $value['text']?></option>
         
       <?php }
        ?>
          
        </select>
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
        field: 'store_name',
        title: 'store',
        width : '60%',
        formatter : function(value , row){
		
		var client_image = row.client_image || 'default.png';
		return  [
            '<div class="pad innerAll inner-2x">',
            '<div class="attachment-block clearfix">',
                    '<img class="attachment-img" src="'+base+'assets/uploads/store/'+row.store_logo+'" alt="Article Image">',
                    '<div class="attachment-pushed">',
                      '<h4 class="attachment-heading"><a href="">'+row.store_name+'</a></h4>',
                      
                    '</div>',
                  '</div>',
                  '</div>'
            ].join( '' );
        }
    },
      {
        field: 'click_count',
        title: 'Total Click',
        width : '10%',
       
    },
    {
			field: 'store_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.store_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.store_id,
						name : 'store_status',
						url: "<?=$this->base?>store/admin_store/change_status",
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

    "uniqueId" : "store_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "store/admin_store/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 20,
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
		url : base + "store/admin_store/remove/",
	},*/
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "store/admin_store/form/",
	},
	edit : {
		url : base + "store/admin_store/form/",
		modal : '#add-new-modal'
	}
};

</script> 
