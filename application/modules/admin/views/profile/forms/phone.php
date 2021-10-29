<?php
$base	=	base_url();
$form_pre	=	'phone_change_'.time();

?>

<div id="otp_res"></div><br/>
<div class="row margin_5" id="phonenochange_wrap" >
    <div class="col-md-2">
      <div class="group group1">
        <input type="text" class=" material visited  "  disabled readonly="readonly" value="+91" name=""   >
        <span class="highlight"></span> <span class="bar"></span> </div>
    </div>
    <div class="col-md-8">
      <div class="group group1">
        <input type="text" class=" material  validate[required,custom[onlyNumber],minSize[10],maxSize[10]] " value="" name=""    id="phone">
        <span class="highlight"></span> <span class="bar"></span>
        <label>New Mobile no</label>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="col-md-8">
      <a href="javascript:void(0)" onclick="send_otp()"  class="btn_1" >Submit </a>
    </div>
</div>
<!-- End row -->
<form class=" " method="post" action="<?=$base.'user/profile/update_phone'?>" id="<?=$form_pre?>"  >
<div class="row margin_5 " id="otpform_wrap" style="display:none;">
  
    <div class="col-md-8">
      <div class="group group1">
        <input type="text" class=" material  validate[required,custom[onlyNumber]] " value="" name="otp"   >
        <span class="highlight"></span> <span class="bar"></span>
        <label>Enter the OTP</label>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="col-md-5">
       <a href="javascript:void(0)" onclick="send_otp()"  class="btn_1" >Resend</a>
    </div>
    <div class="col-md-4 col-md-offset-3" >
    <div id="<?=$form_pre?>_res"></div>
     <button class="btn_full ladda-button" data-style="expand-right" type="submit" id="<?=$form_pre?>_submit_button" name="submit" value="1"  >Register</button>
    </div>
</div>
</form>
<script>

function showOtpForm()
{
	$('#phonenochange_wrap').hide();
	$('#otpform_wrap').show();
}
function showPhoneForm()
{
	$('#phonenochange_wrap').hide();
	$('#otpform_wrap').show();
}

error=0;
var <?=$form_pre?>_loader	=	Ladda.create( document.querySelector( '#<?=$form_pre?>_submit_button' ) );
var options = { 
        beforeSubmit:  <?=$form_pre?>_validation,
		success:   check_result_<?=$form_pre?>  // post-submit callback 
    }; 

$('#<?=$form_pre?>').ajaxForm(options); 

function <?=$form_pre?>_validation()
{
	 if( $("#<?=$form_pre?>").validationEngine('validate') )
	{
		show_<?=$form_pre?>_loader();
		return true;
	}
	else
	{
		return false;
	}
}

function show_<?=$form_pre?>_loader(){
	<?=$form_pre?>_loader.start();
	}
function reset_<?=$form_pre?>_loader(msg){
	$('#<?=$form_pre?>_res').html(msg);
	<?=$form_pre?>_loader.stop();
	}
function check_result_<?=$form_pre?>(responseText, statusText, xhr, $form){
	//$('#<?=$form_pre?>_res').html(responseText);return;
	try {
	msg=jQuery.parseJSON(responseText);
	} catch (e) {
	
	window.location.reload();
	}
	
	$('#<?=$form_pre?>_res').html(msg.msg);
	if(msg.res=='1'){
		 $('#pre_otp').hide(); $('#post_otp').show();
		 if(msg.redir)
		 {
			 window.location	=	msg.redir;
		 }
		 else
		 {
			window.location.reload();
			
		 }	
		
		 }else reset_<?=$form_pre?>_loader(msg.msg);
	
	}

function send_otp()
{
	
	var mob	=	$('#phone').val();
	$('#otp_res').html('sending otp to 91'+mob+'....');
	var request=$.ajax({
		type: "POST",
		url: '<?=base_url()?>user/profile/send_otp/'+mob,
		data: '',
		cache: true,
		success:function(responseText){
			msg=jQuery.parseJSON(responseText);
			console.log(msg);
			$('#otp_res').html(msg.msg);
			if(msg.res == 1) showOtpForm();
			},
		});
}


$(document).ready(function(){
	$("#<?=$form_pre?>").validationEngine({promptPosition : "bottomRight", scroll: false});
	});
</script> 
