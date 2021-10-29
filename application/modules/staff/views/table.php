
<?php 

$staffstatus=json_decode(CommonStatus::xEditArray(),true);
$stafftype=json_decode(StaffType::xEditArray(),true);



?>
<div class="box">
  <div class="box-header with-border">

     <h3 class="box-title">Staffs & Guards Listed</h3>
     <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New </a>
  </div>
  <div class="box-body">
  	 <div class="row text-right pad " style="clear: both;">
      <div class="col-md-2">
      <input type="text" class="form-control js-table-loader-search" data-search-key="search" placeholder="Name" > 
      </div>
      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="staff_status">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($staffstatus as $key => $value) { ?>
         
          <option value="<?= $value['value']?>"><?= $value['text']?></option>
         
       <?php }
        ?>
          
        </select>
      </div> 

      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="staff_type">
        <option value="">SHOW ALL </option>
       
        <?php
        foreach ($stafftype as $key => $value) { ?>
         
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
        field: 'staff_name',
        title: 'Name',
        width : '20%',
       
    },
    {
      field: 'customer_type',
      title: 'Type',
      align : 'center',
      formatter : function(value , row){
        var xEditableOptions  = {
            value : row.customer_type,
            defaultValue : "Not active",
            type : "select",
            pk: row.customer_id,
            name : 'customer_type',
            url: "<?=$this->base?>staff/admin_staff/change_status",
            title: "Change Type",
            source: <?=json_encode(StaffType::xEditArray())?>,
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
			field: 'customer_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.customer_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.customer_id,
						name : 'customer_status',
						url: "<?=$this->base?>staff/admin_staff/change_status",
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

    "uniqueId" : "customer_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "staff/admin_staff/list_json",
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
		url : base + "staff/admin_staff/form/",
	},
	edit : {
		url : base + "staff/admin_staff/form/",
		modal : '#add-new-modal'
	}
};

</script> 
