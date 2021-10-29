<?php
function replace_contacts($str)
{
	$emailFound=0;$phoneFound=0;
	$patternEmail="/([\s]*)([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*([ ]+|)@([ ]+|)([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,}))([\s]*)/i"; 
	$patternPhone='/\+?[0-9][0-9()\w-\s+]{4,20}[0-9]/';
	$str = preg_replace($patternEmail,' **** ',$str);
	$str = preg_replace($patternPhone,' **** ',$str);
	return $str;
}

function date_readable( $date , $strtotime_fomated = FALSE )
{
	if( !$strtotime_fomated ) $date = strtotime($date);
	return date("jS F Y", $date);
}

function date_time_readable( $date , $strtotime_fomated = FALSE )
{
	if( !$strtotime_fomated ) $date = strtotime($date);
	return date("jS F Y , h:i A", $date);
}


function time_readable( $time  )
{
	return date("h:i A", strtotime($time));
}

function base64_url_encode($string) 
{
	$data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}

function base64_url_decode($string) 
{
	$data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function random_password( $length = 8 ,$number_only=NULL ) 
{
		//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$chars = "abcdefghijklmnopqrstuvwxyz01234567890123456789";
		if($number_only!=NULL)
		{
			$chars = "01234567890123456789";
		}
		
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
}

function time_elapsed_string($datetime, $full = false) 
{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
	
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
	
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function dbnow()
{
	return date("Y-m-d H:i:s", time());
}
function get_social_icon_array($social_id){
	$iconarray=array('1'=>'fa fa-facebook','2'=>'fa fa-twitter','3'=>'fa fa-linkedin','4'=>'fa fa-google-plus','5'=>'fa fa-pinterest');
	$b = $iconarray[$social_id];
    return $b; 


}