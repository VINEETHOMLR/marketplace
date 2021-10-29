<?php
$base	=	base_url();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GarvityInc | CRM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=$base?>themes/crm/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?=$base?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$base?>themes/crm/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=$base?>themes/crm/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.2.0 -->
  <script src="<?=$base?>themes/crm/plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <?php
  if(!empty($css))
foreach($css as $file)
{
	echo "\n\t\t\t";
	?><link rel="stylesheet" href="<?=$base.$file?>" type="text/css" /><?php
 } echo "\n\t";

if(!empty($js))
foreach($js as $v)
{
	if($v['position']=='top')
	{
		echo "\n\t\t\t";
		?><script src="<?=$base.$v['file']?>"></script><?php
	}
	
 } 
?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">