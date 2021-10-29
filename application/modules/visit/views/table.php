
<?php 

$companyList =Modules::run('staff/admin_staff/getCompanyList');




?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="box">
  <div class="box-header with-border">

     <h3 class="box-title">Visit Listed</h3>
     <!-- <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New </a> -->
  </div>
  <div class="box-body">
  	 <div class="row text-right pad " style="clear: both;">
      <div class="col-md-2">
       <input type="text" class="form-control js-table-loader-search" data-search-key="search" id="datepicker" placeholder="Visitor name / phone" > 
      </div>
      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="visit_company_id" id="company">
        <option value="">COMPANY</option>
       
        <?php
        foreach ($companyList as $key => $value) { ?>
         
          <option value="<?= $value['company_id']?>"><?= $value['company_name']?></option>
         
       <?php }
        ?>
          
        </select>
      </div> 

      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="visit_who_to_meet" id="visit_who_to_meet">
        <option value="">STAFF</option>
       
        
          
        </select>
        <!-- <input type="text" class="js-table-loader-search" id="datepicker" data-search-key="startdate"> -->
      </div>

      <div class="col-md-2">
        <select class="js-table-loader-filter form-control" data-filter-key="visit_added_by" id="visit_added_by">
        <option value="">ADDED BY</option>
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
<style type="text/css">
  #ui-datepicker-div button.ui-datepicker-current {display: none;}
</style>

<script>
  $("#datepicker").datepicker({
            showOn: 'focus',
            showButtonPanel: true,
            closeText: 'Clear', // Text to show for "close" button
            onClose: function () {
                var event = arguments.callee.caller.caller.arguments[0];
                // If "Clear" gets clicked, then really clear it

                if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                    $(this).val('');
                }
            }
    });
var statusOptions	=	<?=json_encode( CommonStatus::getDropDown() )?>;
var tableConfig = {
    "columns": [
    {
        field: 'visit_fullname',
        title: 'Visitor',
        width : '20%',
       
    },

    {
        field: 'visit_mobile',
        title: 'Phone',
        width : '10%',
       
    },
    {
        field: 'staffname',
        title: 'To meet',
        width : '20%',
       
    },
    {
        field: 'visit_no_of_visitors',
        title: 'No of visitors',
        width : '20%',
       
    },
    {
        field: 'visit_checkin_date',
        title: 'Checkin Date',
        width : '20%',
       
    },
    {
        field: 'visit_checkin_time',
        title: 'Checkin Time',
        width : '20%',
       
    },

    {
        field: 'visit_checkout_date',
        title: 'Checkout Date',
        width : '20%',
       
    },
    {
        field: 'visit_checkout_time',
        title: 'Checkout Time',
        width : '20%',
       
    },

   /* {
        field: 'added_by',
        title: 'Added By',
        width : '20%',
       
    },*/
     
   /* {
			field: 'visit_status',
			title: 'Status',
			align : 'center',
			formatter : function(value , row){
				var xEditableOptions	=	{
						value : row.visit_status,
						defaultValue : "Not active",
						type : "select",
						pk: row.visit_id,
						name : 'visit_status',
						url: "<?=$this->base?>visit/admin_visit/change_status",
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
		},*/
	
    ],

    "uniqueId" : "visit_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "visit/admin_visit/list_json",
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
		url : base + "visit/admin_visit/form/",
	},
	edit : {
		url : base + "visit/admin_visit/form/",
		modal : '#add-new-modal'
	}
};

</script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
  $("#company").change(function(){
  if($(this).val()!="") {
      $.ajax({
        url: base+'staff/admin_staff/getStaffList',
        type: "post",
        data: {'company_id':$(this).val()} ,
        success: function (response) {

          response = JSON.parse(response);

          $('#visit_who_to_meet').html('');
          $('#visit_who_to_meet').html(response.staff);

          $('#visit_added_by').html('');
          $('#visit_added_by').html(response.guard);

           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
  }
});
</script>
