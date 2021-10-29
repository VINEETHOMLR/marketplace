<style>
.typeahead {
	z-index: 1051;
}
.bootstrap-tagsinput {
	width: 100%;
	border-radius: 0px;
}
.trumbowyg-box{
  
}
</style>
<script>
  var base='<?= $this->base?>';
</script>

<div class="box box-primary"> <div class="box-header with-border"> <h3
class="box-title"><?=isset( $visitdata[ 'visit_id' ] ) ? 'Visit Details' : 'Visit Details'?> </h3> </div> <!-- /.box-header -->  <!-- form start --> <form
role="form" class="mvform" id="visit_form" method="post"
action="<?=$this->base?>staff/admin_staff/update"
enctype="multipart/form-data" > <?php if( isset( $visitdata[ 'visit_id' ] ) 
&& trim( $visitdata[ 'visit_id' ] ) != '' ) { echo "<input type=\"hidden\"
name=\"visit_id\" value=\"{$visitdata[ 'visit_id' ]}\">"; } ?>
    
    <div class="box-body">
      <div class="row">


        <div class="col-md-4">
          <div class="form-group">
            <label for="visit_title">Vistor Name</label>
            <input type="text" name="visit_fullname" value="<?=isset( $visitdata[ 'visit_fullname' ] ) ? $visitdata[ 'visit_fullname' ]: ''?>" class="form-control" id="visit_fullname" placeholder="Enter first name" required>
          </div>

          <div class="form-group">
            <label for="visit_title">Company Name</label>
            <input type="text" name="visit_companyname" id="visit_companyname" value="<?=isset( $visitdata[ 'visit_companyname' ] ) ? $visitdata[ 'visit_companyname' ]: ''?>" class="form-control  "   placeholder="Enter last name" required>
          </div>

          <div class="form-group">
            <label for="visit_title">Proof ID</label>
            <input type="text" name="visit_drivingid" id="visit_drivingid" value="<?=isset( $visitdata[ 'visit_drivingid' ] ) ? $visitdata[ 'visit_drivingid' ]: ''?>" class="form-control  "   placeholder="Enter last name" required>
          </div>

          <div class="form-group">
            <label for="visit_title">Mobile</label>
            <input type="text" name="visit_mobile" id="visit_mobile" value="<?=isset( $visitdata[ 'visit_mobile' ] ) ? $visitdata[ 'visit_mobile' ]: ''?>" class="form-control  "   placeholder="Enter last name" required>
          </div>

          <div class="form-group">
            <label for="visit_title">To meet</label>
            <input type="text" name="who_to_meet" id="who_to_meet" value="<?=isset( $visitdata[ 'who_to_meet' ] ) ? $visitdata[ 'who_to_meet' ]: ''?>" class="form-control  "   placeholder="Enter last name" required>
          </div>

          <div class="form-group">
            <label for="customer_image">Visitor's Proof</label>
            
            <?php
            if( isset( $visitdata[ 'visit_image' ] )  && trim( $visitdata[ 'visit_image' ] ) != '' )
              {
                echo "<input type=\"hidden\" name=\"customer_image_last\" value=\"{$visitdata[ 'visit_image' ]}\">";
                echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/visitor/{$visitdata[ 'visit_image' ]}\" class=\"img-responsive pad\" ></div>";
              }
              ?>
            
            <!-- <input type="file" id="customer_image" name="customer_image"  data-error="Please upload an image for the portfolio" <?=isset( $customer[ 'customer_image' ] )  && trim( $customer[ 'customer_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p> -->
          </div>




          
         
        
          

       
          
          
        </div>




        <div class="col-md-4">


         <div class="form-group">
            <label for="visit_title">Purpose</label>
            <textarea class="form-control"><?=isset( $visitdata[ 'visit_purpose' ] ) ? $visitdata[ 'visit_purpose' ]: ''?></textarea>
           
          </div>




          <div class="form-group">
            <label for="visit_title">No.of visitors</label>
            <input type="text" name="visit_email" value="<?=isset( $visitdata[ 'visit_no_of_visitors' ] ) ? $visitdata[ 'visit_no_of_visitors' ]: ''?>" class="form-control" id="visit_no_of_visitors" placeholder="Enter email" autocomplete="off"  required >
            <span></span>
          </div>

          <div class="form-group">
            <label for="visit_title">Checkin Date</label>
            <input type="text" name="visit_checkin_date" id="visit_checkin_date" value="<?=isset( $visitdata[ 'visit_checkin_date' ] ) ? date('d-m-Y',strtotime($visitdata[ 'visit_checkin_date' ])): ''?>" class="form-control  "   placeholder="Enter phone" required>

            <span></span>
          </div>
           <div class="form-group">
            <label for="visit_title">Checkin Time</label>
            <input type="text" name="visit_checkin_time" id="visit_checkin_time" value="<?=isset( $visitdata[ 'visit_checkin_time' ] ) ? $visitdata[ 'visit_checkin_time' ]: ''?>" class="form-control  "   placeholder="Enter phone" required>
            
            <span></span>
          </div>



          <div class="form-group">
            <label for="visit_title">Checkout Date</label>
            <input type="text" name="visit_checkout_date" id="visit_checkout_date" value="<?=isset( $visitdata[ 'visit_checkout_date' ] ) ? date('d-m-Y',strtotime($visitdata[ 'visit_checkout_date' ])): ''?>" class="form-control  "   placeholder="Enter phone" required>

            <span></span>
          </div>


         



          
          

          
          
          
          
        </div>


        <div class="col-md-4">
          
         <div class="form-group">
            <label for="visit_title">Checkout Time</label>
            <input type="text" name="visit_checkout_time" id="visit_checkin_time" value="<?=isset( $visitdata[ 'visit_checkout_time' ] ) ? $visitdata[ 'visit_checkout_time' ]: ''?>" class="form-control  "   placeholder="Enter phone" required>
            
            <span></span>
          </div> 


          <?php if(!empty($covisitorsList)){?>

          <div class="form-group">
            <label for="visit_title">Covisitors</label>
            <!-- <table border=1>
              <tr>
                <th>Name</th>
                <th>Id</th>
              </tr>
            </table> -->
            <table class="table">
    <thead>
      <tr>
        <th>Sl no</th>
        <th>Name</th>
        <th>Proof Id</th>
       
      </tr>
    </thead>
    <tbody>
      <?php foreach($covisitorsList as $k=>$v){?>
      <tr>
        <td><?= $k+1?></td>
        <td><?= $v['covisitor_name']?></td>
        <td><?= $v['covisitor_driving_id']?></td>
       
      </tr>
    <?php } ?>
      
    </tbody>
  </table>
          </div> 
        <?php } ?>


        

         


          
        
          

          
          
        </div>





        
        
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
     <!--  <button type="button" class="btn btn-primary pull-right">Save</button> -->
    </div>
  </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  var error=0;
  var emailError=0;
  var phoneError=0;
  var usernameError=0;
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


$("#visit_email").keyup(function(){
  
  var input=$(this);
  $(this).next("span").html(""); 

  if($(this).val()!="") {
      $.ajax({
        url: base+'staff/admin_staff/checkemail',
        type: "post",
        data: {'email':$(this).val()} ,
        success: function (response) {

          response = JSON.parse(response);
            //console.log(response);
          input.next("span").html(response.message); 
          //console.log(response.status);
          if (response.status == 'ERROR') {
              emailError = 1;
          } else {
              emailError = 0;  
          }
          //checkbutton();




           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
  }

 

});



$("#visit_phone").keyup(function(){
  console.log(error);
  var input=$(this);
  $(this).next("span").html(""); 

  if($(this).val()!="") {
      $.ajax({
        url: base+'staff/admin_staff/checkphone',
        type: "post",
        data: {'phone':$(this).val()} ,
        success: function (response) {

          response = JSON.parse(response);
           // console.log(response);
          input.next("span").html(response.message); 
          if (response.status == 'ERROR') {
           // console.log("hai");
              phoneError = 1;
          } else {
              phoneError = 0;  
          }
          //checkbutton();




           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
  }

 

});


$("#visit_username").keyup(function(){
  console.log(error);
  var input=$(this);
  $(this).next("span").html(""); 

  if($(this).val()!="") {
      $.ajax({
        url: base+'staff/admin_staff/checkusername',
        type: "post",
        data: {'username':$(this).val()} ,
        success: function (response) {

          response = JSON.parse(response);
            //console.log(response);
          input.next("span").html(response.message); 
          if (response.status == 'ERROR') {
            //console.log("hai");
              usernameError = 1;
          } else {
              usernameError = 0;  
          }
          //checkbutton();




           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
  }

 

});





$("#confirm_visit_password").keyup(function(){ 


  $(this).next("span").html(""); 
if($(this).val()!=$('#visit_password').val()) {
  
     $(this).next("span").html("<font color='red'>Passwords should be same</font>"); 
} else {
  $(this).next("span").html(""); 
}

});

$(".btn").click(function(){
if(checkbutton()) {
    $("#visit_form").submit();
} else {
  alert("Clear the errors and fill all the required values");
}

});




function checkbutton()
{
  // if() {

  // }
//   $('form :input').filter(function() {
//     if(this.value=="")
//     error=1;
// });
error=0;
if($('#visit_first_name').val()=="" || $('#visit_last_name').val()=="" || $('#visit_email').val()=="" || $('#visit_mobile').val()=="" || $('#visit_username').val()=="" ) {
   error=1;
}

if($('#visit_password').val()!=$('#confirm_visit_password').val()) {
    error=1;    
}








  if(error==0 && emailError== 0 && phoneError==0 && usernameError==0) {
    //console.log("no error");
     // $('.btn').attr('disabled', false);
     return true;
  } else {
     // $('.btn').attr('disabled', true);  
     return false;
  }
}





/* $.ajax({
        url: "test.php",
        type: "post",
        data: values ,
        success: function (response) {

           // You will get response from your PHP page (what you echo or print)
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });*/
</script>
