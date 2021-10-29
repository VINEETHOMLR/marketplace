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
class="box-title"><?=isset( $customer[ 'customer_id' ] ) ? 'Edit Staff' : 'Add
New staff'?> </h3> </div> <!-- /.box-header -->  <!-- form start --> <form
role="form" class="mvform" id="customer_form" method="post"
action="<?=$this->base?>staff/admin_staff/update"
enctype="multipart/form-data" > <?php if( isset( $customer[ 'customer_id' ] ) 
&& trim( $customer[ 'customer_id' ] ) != '' ) { echo "<input type=\"hidden\"
name=\"customer_id\" value=\"{$customer[ 'customer_id' ]}\">"; } ?>
    
    <div class="box-body">
      <div class="row">


        <div class="col-md-4">
          <div class="form-group">
            <label for="customer_title">Firstname</label>
            <input type="text" name="customer_first_name" value="<?=isset( $customer[ 'customer_first_name' ] ) ? $customer[ 'customer_first_name' ]: ''?>" class="form-control" id="customer_first_name" placeholder="Enter first name" required>
          </div>

          <div class="form-group">
            <label for="customer_title">Last Name</label>
            <input type="text" name="customer_last_name" id="customer_last_name" value="<?=isset( $customer[ 'customer_last_name' ] ) ? $customer[ 'customer_last_name' ]: ''?>" class="form-control  "   placeholder="Enter last name" required>
          </div>


         
        <div class="form-group">
                    <label for="customer_status">Company</label>
                    <select class="form-control" id="customer_company" name="customer_company">
                      <?php
                      foreach( $companyList as $k => $v )
                      {
                            $selected = isset( $customer[ 'customer_company' ] ) && $customer[ 'customer_company' ] == $v['company_id'] ? 'selected' : '';
                      ?>
                      <option value="<?= $v['company_id']?>"><?= $v['company_name']?> </option>
                      <?php       
                         
                      }
                      ?>
                    </select>
                  </div>
       



          
         <!--  <div class="form-group">
            <label for="customer_image">Service Image</label>
            
            <?php
            if( isset( $customer[ 'customer_image' ] )  && trim( $customer[ 'customer_image' ] ) != '' )
        			{
        				echo "<input type=\"hidden\" name=\"customer_image_last\" value=\"{$customer[ 'customer_image' ]}\">";
        				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/service/{$customer[ 'customer_image' ]}\" class=\"img-responsive pad\" ></div>";
        			}
        			?>
            
            <input type="file" id="customer_image" name="customer_image"  data-error="Please upload an image for the portfolio" <?=isset( $customer[ 'customer_image' ] )  && trim( $customer[ 'customer_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          </div> -->
        
          

          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
				<div class="form-group">
                    <label for="customer_status">Status</label>
                    <select class="form-control" id="customer_status" name="customer_status">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $customer[ 'customer_status' ] ) && $customer[ 'customer_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
				<?php 
		  }
		  ?>
          
          
        </div>




        <div class="col-md-4">


          <?php
          if( Modules::run( 'login/is_admin' ) )
           {
        ?>
        <div class="form-group">
                    <label for="customer_status">User Type</label>
                    <select class="form-control" id="customer_type" name="customer_type">
                      <?php
                      foreach( staffType::getDropDown() as $k => $v )
                      {
                            $selected = isset( $customer[ 'customer_type' ] ) && $customer[ 'customer_type' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
        <?php 
         }
      ?>




          <div class="form-group">
            <label for="customer_title">Email</label>
            <input type="text" name="customer_email" value="<?=isset( $customer[ 'customer_email' ] ) ? $customer[ 'customer_email' ]: ''?>" class="form-control" id="customer_email" placeholder="Enter email" autocomplete="off"  required >
            <span></span>
          </div>

          <div class="form-group">
            <label for="customer_title">Phone</label>
            <input type="text" name="customer_phone" id="customer_phone" value="<?=isset( $customer[ 'customer_phone' ] ) ? $customer[ 'customer_phone' ]: ''?>" class="form-control  "   placeholder="Enter phone" required>
            <span></span>
          </div>


          <div class="form-group">
            <label for="customer_title">Username</label>
            <input type="text" name="customer_username" id="customer_username" value="<?=isset( $customer[ 'customer_username' ] ) ? $customer[ 'customer_username' ]: ''?>" class="form-control  "   placeholder="Enter username" required>
            <span></span>
          </div>


         



          
          

          
          
          
          
        </div>


        <div class="col-md-4">
          <div class="form-group">
            <label for="customer_title">Password</label>
            <input type="text" name="customer_password" value="" class="form-control" id="customer_password" placeholder="Enter Password" ><span></span>
          </div>

          <div class="form-group">
            <label for="customer_title">Confirm Password</label>
            <input type="text" name="confirm_customer_password" id="confirm_customer_password" value="" class="form-control  "   placeholder="Retype Password" >
            <span></span>
          </div>


          
        
          

          
          
        </div>





        
        
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="button" class="btn btn-primary pull-right">Save</button>
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


$("#customer_email").keyup(function(){
  
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



$("#customer_phone").keyup(function(){
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


$("#customer_username").keyup(function(){
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





$("#confirm_customer_password").keyup(function(){ 


  $(this).next("span").html(""); 
if($(this).val()!=$('#customer_password').val()) {
  
     $(this).next("span").html("<font color='red'>Passwords should be same</font>"); 
} else {
  $(this).next("span").html(""); 
}

});

$(".btn").click(function(){
if(checkbutton()) {
    $("#customer_form").submit();
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
if($('#customer_first_name').val()=="" || $('#customer_last_name').val()=="" || $('#customer_email').val()=="" || $('#customer_mobile').val()=="" || $('#customer_username').val()=="" ) {
   error=1;
}

if($('#customer_password').val()!=$('#confirm_customer_password').val()) {
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
