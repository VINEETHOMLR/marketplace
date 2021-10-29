<?php
$userGroups   =   UserGroups::getDropDown();
$userStatus   =   CommonStatus::getDropDown();
$storeList=Modules::run('store/admin_store/getstoreList');
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Users Listed</h3>
     <a href="<?=$this->base?>user/admin_user/form" id="add_new" class="btn btn-xs btn-primary pull-right" >Add New</a>
  </div>
  <div class="box-body">
  <div class="row text-right pad " style="clear: both;">
      <div class="col-md-3">
      <input type="text" class="form-control js-table-loader-search" data-search-key="search" placeholder="Name" > 
      </div>
      <div class="col-md-3">
        <select class="js-table-loader-filter form-control " data-filter-key="grouped_in">
        <option value="">SHOW ALL </option>
        <?php
          if( Modules::run( 'login/is_admin' ) )
         {
        ?>
        <?php
        foreach ($userGroups as $key => $value) {
          echo "<option value='$key'/>$value</option>";
        }
        ?>
      <?php } ?>

      <?php
          if( Modules::run( 'login/is_storeadmin' ) )
         {
        ?>
        <?php
        foreach ($userGroups as $key => $value) {
          if($key!=1){

          
          echo "<option value='$key'/>$value</option>";
        }
        }
        ?>
      <?php } ?>
          
        </select>
      </div>   

      <div class="col-md-3">
        <select class="js-table-loader-filter form-control " data-filter-key="log_status">
        <option value="">SHOW ALL </option>
        <?php
        foreach ($userStatus as $key => $value) {
          echo "<option value='$key'/>$value</option>";
        }
        ?>
          
        </select>
      </div> 

        <?php
          if( Modules::run( 'login/is_admin' ) )
         {
        ?>
       <div class="col-md-3">
        <select class="js-table-loader-filter form-control " data-filter-key="store_id">
        <option value="">SHOW ALL </option>
        <?php
        foreach ($storeList as $key => $value) {
          ?>
          <option value="<?= $value['store_id']?>"><?= $value['store_name']?></option>
          <?php 
        }
        ?>
          
        </select>
      </div>
    <?php } ?>


    </div>
    
    <div id="js-table-table"></div>
  </div>
</div>
<script>
var base  =  '<?=$this->base?>';

var regType = <?=UserGroups::STOREADMIN?>;
//var service_status  = <?=isset($service_status)?$service_status:1?>;
var queryParams = <?=json_encode( array(
    
) )?>;
var table_id = 'js-table-table';
var list_url ='<?=$this->base?>user/admin_user/list_json';
var tableConfig = {
    "columns": [
  
    {
      field: 'name',
      title: 'Name',
      width:'20%',
     
    },


    {
      field: 'userRole',
      title: 'Role',
      width:'25%'
      
    },

     {
      field: 'email',
      title: 'Email',
      width:'25%'
      
    },



   /* {
      field: 'authentication_appid',
      title: 'App Id',
      width:'25%',
      formatter : function(value , row){
        
        var astrologerDetails = '';
  
         astrologerDetails = astrologerDetails  + [
        row.authentication_appid
        ].join( '' );
  
        return astrologerDetails;
  
      }
    },*/
   /* {
      field: 'id',
      title: 'Expiry Date',
      width:'25%',
      formatter : function(value , row){
        var date = row.date_of_expiry;
       
        var astrologerDetails = '';
  
         astrologerDetails = astrologerDetails  + [
           date
        ].join( '' );
  
        return astrologerDetails;
  
      }
    },*/
    {
      field: 'id',
      title: 'Phone',
      width:'25%',
      formatter : function(value , row){
        var date = row.last_login;
        var date2 = row.created_on;
        var lastSeen    =   date ;
        var regdOn    =   date2;
        var image = row.image || 'default.png';
        var astrologerDetails = '';
  
         astrologerDetails = astrologerDetails  + [
           row.phone
        ].join( '' );
  
        return astrologerDetails;
  
      }
    },

     {
      field: 'active',
      title: 'Status',
      align : 'center',
      formatter : function(value , row){
        var xEditableOptions  = {
            value : row.active,
            defaultValue : "Not active",
            type : "select",
            pk: row.id,
            name : 'active',
            url: "<?=$this->base?>user/admin_user/change_status",
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

    "uniqueId" : "id",
    "classes": "table table-bordered table-striped table-booking-history",
    "method": "POST",
    "contentType" : "application/x-www-form-urlencoded",
    "url": list_url,
    "pagination": true,
    "pageNumber": 1,
    "pageSize": 10,
    "pageList": "[5 , 10 , 20]",
    "dataField": "rows",
    "sidePagination": "server",
    "refresh" : {
        silent: true
    },
    "queryParams" : queryParams,
 

};


var actions = {
  delete : {
    url : base + "user/admin_user/delete/",
  },
  add : {
    selector : '#add_new',
    template : '#add-new-template',
    modal : '#add-new-modal',
    hbs : '#add-item-template',
    url : base + "user/admin_user/form/",
  },
  edit : {
    url : base + "user/admin_user/form/",
    modal : '#add-new-modal'
  }
};
</script>