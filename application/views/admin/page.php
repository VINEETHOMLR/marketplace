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

//echo "{$classf}/{$methodf}";
$jsmod = isset( $modules["{$classf}/{$methodf}"] ) ? $modules["{$classf}/{$methodf}"] : false;

/*echo "hello";
echo "<pre>";
print_r($jsmod);exit;*/


//echo '<pre>';print_r($modules["{$classf}/{$methodf}"]);echo '</pre>';exit;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php  include( 'includes/fav.php' );?>
<title>
<?=$this->project_name?>
| ADMIN</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
<body class="skin-blue sidebar-mini">
<div class="wrapper"> 
  <script>
 var base = '<?=$this->base?>';
 </script>
  <?php
  include('includes/header.php');
  include('includes/left_menu.php');
  ?>
  <div class="content-wrapper" style="min-height: 900px;"> 
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>&nbsp; </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">
          <?=ucfirst( strtolower( str_replace( '_' , ' ' , $this->router->fetch_class() ) ) )?>
        </li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div id="noty_msg"></div>
      <?php
		$this->view($content);
		?>
    </section>
  </div>
</div>
<script>
var noty_msg = false;

var grouped_in	=	'<?=isset( $this->user[ 'id' ] ) ? $this->ion_auth->get_users_groups()->row()->id : ''?>';
</script>
<?php
$msg	=	$this->session->flashdata('msg');
if( $msg )
{
?>
<script>
noty_msg = <?=isset($msg[ 'msg' ]) ? json_encode( $msg[ 'msg' ] ) :'' ?>;
</script>
<?php 
}
?>
<?php
$jssl	=	$jsfiles['common'];
if(isset($files["{$classf}/{$methodf}"]))
{
	$module	=	$files["{$classf}/{$methodf}"];
	foreach( $module as $cssv )
	{
		if(isset($js[$cssv]))
		{
			$jssl	=	array_merge($cssl , $css[$cssv]);
		}
		
	}
	
}

if(!empty($jssl))
foreach($jssl as $file)
{
	echo "";
	?>
<script  type="application/javascript"  src="<?=$file?>"></script>
<?php
 } echo "\n\t";
if($jsmod )
{

	
	
	foreach($jsmod as $v )
	{ 
		$file	=	filter_var($v, FILTER_VALIDATE_URL) ? $v : $this->base.'scripts/admin/dist/'.$v.'.js';
		echo "<script src=\"$file\"></script> \n";
	}
}

?>
</body>
</html>
