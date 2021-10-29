<?php
$classf		=	$this->router->fetch_class();
$methodf	=	$this->router->fetch_method();
$base		=	$this->base;
include('packages/admin_packages.php');
$cssl	=	$files['common'];
$module	=	array();
if(isset($files["{$classf}/{$methodf}"]))
{
	$module	=	$files["{$classf}/{$methodf}"];
	foreach( $module as $cssv )
	{
		if(isset($css[$cssv]))
		{
			$cssl	=	array_merge($cssl , $css[$cssv]);
		}
		
	}
	
}

//echo '<pre>';print_r($cssl);echo '</pre>';exit;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php  include( 'includes/fav.php' );?>
<title>
<?=$this->project_name?>
<?=isset( $page_title  ) ? ' | ' .$page_title : ' | LOGIN'?>
</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<?php
	if(!empty($cssl))
	foreach($cssl as $file)
	{
		echo "\n\t\t\t";
		?>
<link rel="stylesheet" href="<?=$file?>" type="text/css" />
<?php
	 } echo "\n\t";
	
	
	?>
</head>
<body class="hold-transition login-page">
<?php
$this->view($content);
?>
</section>
<!-- /.content -->
</div>
<div class="control-sidebar-bg"></div>
</div>
<script type="application/javascript" src="<?=$this->base?>js/downloads/jquery-3.1.1.min.js" ></script>
<script type="application/javascript" src="<?=$this->base?>js/downloads/bootstrap.min.js" ></script>
<script type="application/javascript" src="<?=$this->base?>scripts/admin/dist/mv_form_init.js" ></script>
</body>
</html>