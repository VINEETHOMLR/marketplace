<?php
$base = base_url();
?>

<div  style="width:580px;border:1px solid #CCC; ">
  <div  style="background-color:#eee;border-bottom: 1px solid #CCC;;padding: 20px;"> <img src="<?=$this->base?>themes/public/img/logo.png"   alt="<?php echo $this->project_name
?> - logo"></div>
  <div style="line-height:1.6;text-align:left;color:#222;background-color:#fff;padding:15px; font-size:10pt;">
    <div style="font-family:verdana,\'droid sans\',\'lucida sans\',sans-serif;">
      <?php

if (isset($greet)) echo '<div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold;">' . $greet . '</div>';

if (isset($intro)) echo '<div style="padding:5px;">' . $intro . '</div>';
?>
      <div style="padding:5px;">
        <?php

if (isset($table) && sizeof($table) > 1)
{
	echo '<table style="border:none;width:540px;color:#333;font-size:10pt;line-height:1.5;" cellpadding="3" cellspacing="0"><tbody> ';
	foreach($table as $k => $v)
	{
		echo ' <tr><td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb;">' . $k . '</td><td style="width:350px;border-bottom:1px solid #ebebeb;">' . $v . '</td></tr>';
	}

	echo '</tbody></table>';
}

if (isset($content)) echo '<div style="padding:5px;">' . $content . '</div>';
?>
      </div>
    </div>
    <div style="padding:5px;"> Team <a href="<?php echo $base
?>" target="_blank" style="outline:none;text-decoration: none;">jeevatours.in!.</a></div>
    <br/>
    <br/>
    <br/>
    <div style="padding:8px;background:#ebebeb;font-size:12px;color:#6f6f6f;"> Please do not reply directly to this e-mail. 
      
      This e-mail was sent from a notification-only address that cannot accept incoming e-mail.
      
      If you have questions or need assistance, please revert back to us at <b>info@jeevatours.in</b> </div>
  </div>
</div>
