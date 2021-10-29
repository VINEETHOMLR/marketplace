<?php 

$categoryList=Modules::run('product/admin_product/getproductcategory');
$storeList=Modules::run('store/admin_store/getstoreList');

$statusList=json_decode(CommonStatus::xEditArray(),true);
$offerList=json_decode(OfferStatus::xEditArray(),true);



?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Products Listed</h3>
     <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Product</a>
  </div>
  <div class="box-body">
  	<div class="row text-right pad " style="clear: both;">
      <div class="col-md-2">
      <input type="text" class="form-control js-table-loader-search" data-search-key="search" placeholder="Product/store name" > 
      </div>
      
       <?php
          if( Modules::run( 'login/is_admin' ) )
      {
        ?>

      <div class="col-md-2">
         <select class="js-table-loader-filter form-control" data-filter-key="product_store_id">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($storeList as $key => $value) { ?>
         
          <option value="<?= $value['store_id']?>"><?= $value['store_name']?></option>
         
       <?php }
        ?>
          
        </select>
      </div>

      <?php } ?> 


      <div class="col-md-2">
         <select class="js-table-loader-filter form-control" data-filter-key="product_category_id">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($categoryList as $key => $value) { ?>
         
          <option value="<?= $value['product_category_id']?>"><?= $value['product_category_name']?></option>
         
       <?php }
        ?>
          
        </select>
      </div> 

      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="product_status">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($statusList as $key => $value) { ?>
         
          <option value="<?= $value['value']?>"><?= $value['text']?></option>
         
       <?php }
        ?>
          
        </select>
      </div>


      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="product_is_offer">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($offerList as $key => $value) { ?>
         
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
        field: 'product_name',
        title: 'product',
        width : '20%',
        formatter : function(value , row){
		
		var client_image = row.client_image || 'default.png';
		var images = row.product_image.split(",");
// 		images.split(",");
		return  [
            '<div class="pad innerAll inner-2x">',
            '<div class="attachment-block clearfix">',
                    '<img class="attachment-img" src="'+base+'assets/uploads/product/'+images[0]+'" alt="Article Image">',
                    '<div class="attachment-pushed">',
                      '<h4 class="attachment-heading"><a href="">'+row.product_name+'</a></h4>',
                      
                    '</div>',
                  '</div>',
                  '</div>'
            ].join( '' );
        }
    },
    {
        field: 'product_category_name',
        title: 'Category',
        width : '20%',
        
    },
    
    {
        field: 'store_name',
        title: 'Store',
        width : '20%',
        
    },
    /*{
        field: 'product_rate',
        title: 'Rate',
        width : '20%',
        formatter : function(value , row){
		
		
		return  [
           row.product_currency+' '+row.product_rate
            ].join( '' );
        }
    },*/
    {
			field: 'product_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.product_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.product_id,
						name : 'product_status',
						url: "<?=$this->base?>product/admin_product/change_status",
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

    "uniqueId" : "product_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "product/admin_product/list_json",
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
		url : base + "product/admin_product/remove/",
	},*/
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template',
		url : base + "product/admin_product/form/",
	},
	edit : {
		url : base + "product/admin_product/form/",
		modal : '#add-new-modal'
	}
};

</script> 
