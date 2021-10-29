<?php
$contact_type_dropdown	=	ContactTypes::getDropDown();
?>

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Contacts</h3>
    <a href="#" id="add_new" class="btn btn-xs btn-primary pull-right"   >Add New Contact</a> </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="input-group">
          <input type="text" class="form-control js-table-loader-search" data-search-key="search" placeholder="Enter name / email / phone to serach">
          <span class="input-group-addon"><i class="fa fa-search"></i></span> </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <select class="form-control js-table-loader-filter" data-filter-key="contact_type">
            <option value="">--Select Category --</option>
            <?php
			foreach( $contact_type_dropdown as $k => $v )
			{
				echo "<option value=\"$k\" >{$v}</option>";
			}
			?>
          </select>
        </div>
      </div>
    </div>
    <div class="row" style="display:none" id="selection_result">
      <div class="col-md-12"><a href="javascript:void(0)" onclick="sendMail()" class="btn btn-block btn-social btn-twitter"> <i class="fa fa-envelope-o"></i> Send a mail to Selected <span id="selection_count"></span> Contacts </a></div>
    </div>
    <div id="js-table-table"></div>
  </div>
</div>
<div id="add-new-modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  id="add-new-template"> </div>
</div>
<script id="add-item-template" type="text/x-handlebars-template">
<form class="" method="post" action="<?=$this->base?>contacts/update">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal">&times;</button>
	  <h4 class="modal-title">Update contact list</h4>
	</div>
	<div class="modal-body">
	  <div  >
            <input type="hidden" name="contact_id"  value="{{record.contact_id}}" >
            <div class="row form-group">
              <div class="col-md-4 ">Contact name<span class="text-danger">*</span> </div>
              <div class="col-md-8">
                <input type="text" name="contact_name"  value="{{record.contact_name}}" class="form-control"  placeholder="Enter Contact Name"  required>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-md-4 ">Contact email<span class="text-danger">*</span> </div>
              <div class="col-md-8">
                <input type="text" name="contact_email"  value="{{record.contact_email}}" class="form-control"  placeholder="Enter Contact Email"  required>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4 ">Contact phone<span class="text-danger">*</span> </div>
              <div class="col-md-8">
                <input type="text" name="contact_phone"  value="{{record.contact_phone}}" class="form-control"  placeholder="Enter Contact Phone"  required>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4 ">Contact description<span class="text-danger">*</span> </div>
              <div class="col-md-8">
                <input type="text" name="contact_description"  value="{{record.contact_description}}" class="form-control"  placeholder="Enter Contact Description"  required>
              </div>
            </div>
            
            <div class="row form-group">
		  <div class="col-md-4 ">Contact Type<span class="text-danger">*</span> </div>
		  <div class="col-md-8">
			 <select class="form-control" name="contact_type">
				  {{#each   contact_type_dropdown  as |value key|}}
				  <option value="{{key}}" {{#logOp ../record.contact_type '==' key}} selected {{/logOp}} > {{value}} </option>
				  {{/each  }}
					
			</select>
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
</script> 
<script>
var contactsSelected	=	{};
var selections = [];
var contact_type_dropdown = <?=json_encode($contact_type_dropdown)?>;
var tableConfig = {
    "columns": [{
			title: '#',
			field: 'state',
			align : 'center',
			width : '5%',
			checkbox : true,
			
		},
		{
        field: 'contact_name',
		clickToSelect  : true,
        title: 'Contact',
        width : '60%',
        formatter : function(value , row){
		return  [
			'<h4 class="attachment-heading"><a href="javsscript:void(0)">'+row.contact_name+'</a></h4>',
			'<div class="attachment-text">',
			'Type : '+contact_type_dropdown[row.contact_type],
			'<br/>Email : '+row.contact_email,
			'<br/>Phone : '+row.contact_phone,
            ].join( '' );
        }
    },
	



    ],

    "uniqueId" : "contact_id",
    "classes": "table table-hover",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": base + "contacts/contacts/list_json",
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 10,
    "pageList": "[5 , 10 , 15 , 20 , 50 ]",
    "dataField": "rows",
    "sidePagination": "server",
    "refresh" : {
        silent: true
    },
	maintainSelected : true,
	responseHandler : function(res){
		
			$.each(res.rows, function (i, row) {
				row.state = $.inArray(parseInt(row.contact_id, 10), selections) !== -1;
			});
			console.log(res);
			return res;
			
	},
	onCheck : function(row, $element){
		selections.push(parseInt(row.contact_id, 10));
		updateResult();
	},
	onUncheck : function(row, $element){
		var index = selections.indexOf(parseInt(row.contact_id, 10));
		if (index > -1) {
			selections.splice(index, 1);
		}
		updateResult();
	},
	onCheckAll : function(rows){
		$.each(rows, function (i, row) {
			if($.inArray(parseInt(row.contact_id, 10), selections) === -1)
			selections.push(parseInt(row.contact_id, 10));
		});
		updateResult();
	},
	onUncheckAll : function(rows){
		$.each(rows, function (i, row) {
			var index = selections.indexOf(parseInt(row.contact_id, 10));
			if (index > -1) {
				selections.splice(index, 1);
			}
		});
		updateResult();
	}
};


var formParams = {contact_type_dropdown : contact_type_dropdown};


var actions = {
	delete : {
		url : base + "contacts/remove/",
	},
	add : {
		selector : '#add_new',
		template : '#add-new-template',
		modal : '#add-new-modal',
		hbs : '#add-item-template'
		
	},
	edit : {
		modal : '#add-new-modal'
	}
};

function updateResult()
{
	var selections_length	=	selections.length;
	$( '#selection_count' ).html(selections_length);
	
	if( selections_length > 0 )
	$( '#selection_result' ).slideDown();
	else
	$( '#selection_result' ).slideUp();
	
}

function sendMail()
{
	console.log(selections);
	$.ajax({
		url : base + 'contacts/save_selected',
		//dataType : 'json',
		data : {selections:selections},
		method : 'post',
		success: function(result){
			window.location = base + 'contacts/send_mail';
			}
		});
}

</script>