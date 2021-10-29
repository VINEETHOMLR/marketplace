<?php 
   
   $storeList=Modules::run('store/admin_store/getstoreList');
   $orderStatusList=json_decode(OrderStatus::xEditArray(),true);
/*
   echo "<pre>";
   print_r($orderStatusList);exit;*/

?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Order Listed</h3>
    <!-- <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Category</a>  -->
  </div>
  <div class="box-body">
  	<div class="row text-right pad " style="clear: both;">

        <div class="col-md-2">
      <input type="text" class="form-control js-table-loader-search" data-search-key="search" placeholder="OrderId" > 
      </div>
        <?php
          if( Modules::run( 'login/is_admin' ) )
      {
        ?>

      <div class="col-md-2">
         <select class="js-table-loader-filter form-control" data-filter-key="store_id">
        <option value="">STORE</option>
       
        <?php
        foreach ($storeList as $key => $value) { ?>
         
          <option value="<?= $value['store_id']?>"><?= $value['store_name']?></option>
         
       <?php }
        ?>
          
        </select>
      </div>

      <?php } ?> 
    <div class="col-md-2">
         <select class="js-table-loader-filter form-control" data-filter-key="order_status">
        <option value="">Status</option>
       
        <?php
        foreach ($orderStatusList as $k => $v) { ?>
         
          <option value="<?= $v['value']?>"><?= $v['text']?></option>
         
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
var role = '<?= $role ?>';
var statusOptions	=	<?=json_encode( CommonStatus::getDropDown() )?>;
var tableConfig = {
    "columns": [
    {
        field: 'order_id',
        title: 'OrderId',
        width : '20%',
       
    },

    {
        field: 'customer_name',
        title: 'Customer Name',
        width : '20%',
       
    },
    {
        field: 'customer_phone',
        title: 'Customer Phone',
        width : '20%',
        formatter : function(value , row){
          if(role == 'STOREADMIN') {
              return "-";
          }else{
            return row.customer_phone;
          }
        }
       
    },
    {
        field: 'grand_total',
        title: 'Total(Rs)',
        width : '20%',
       
    },
    {
			field: 'order_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.order_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.order_id,
						name : 'order_status',
						url: "<?=$this->base?>order/admin_order/change_status",
						title: "Change Status",
						source: <?=json_encode(OrderStatus::xEditArray())?>,
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
      field: 'payment_status',
      title: 'Payment Status',
      align : 'center',
      formatter : function(value , row){
        var xEditableOptions  = {
            value : row.payment_status,
            defaultValue : "Not active",
            type : "select",
            pk: row.order_id,
            name : 'payment_status',
            url: "<?=$this->base?>order/admin_order/change_payment_status",
            title: "Change Payment Status",
            source: <?=json_encode(PaymentStatus::xEditArray())?>,
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

    "uniqueId" : "order_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "order/admin_order/list_json",
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
		url : base + "order/admin_order/form/",
	},
	edit : {
		url : base + "order/admin_product/form/",
		modal : '#add-new-modal'
	}
};

</script> 
