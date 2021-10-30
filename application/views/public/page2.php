<?php
$classf   = $this->router->fetch_class();
$methodf  = $this->router->fetch_method();
$base   = $this->base;
$theme_base   = $this->base.'themes/public/';
$themeFile  = 'themes/public/';
include('packages/public_packages.php');
$cssl= array();
$module = array();
if(isset($files["{$classf}/{$methodf}"]))
{
  $module = $files["{$classf}/{$methodf}"];
  foreach( $module as $cssv )
  {
    if(isset($css[$cssv]))
    {
      $cssl = array_merge($cssl , $css[$cssv]);
    }
    
  }
  
}
$cssl = array_merge($cssl ,$files['common']);




//echo '<pre>';print_r($jsmod);echo '</pre>';exit;
?>

<!DOCTYPE HTML>
<html class="no-js" lang="">
<head>
<title>
<?=isset($meta[ 'title' ]) && $meta[ 'title' ] ? $meta[ 'title' ] : $this->project_name?>
</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="Riolabz">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="application-name" content="&nbsp;" />
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />
 <?php  include( 'includes/fav.php' );?>

<?php
if( isset($meta[ 'tag' ]) && sizeof($meta[ 'tag' ]) )
foreach( $meta[ 'tag' ] as $k1 => $v1 )
{
  foreach( $v1 as $k => $v )
  {
    ?>
<meta <?=$k1?>="<?=$k?>" content="<?=$v?>" />
<?php
  }
}
?>
<?php
if(!empty($cssl))
foreach($cssl as $file)
{
  ?>
  <link rel="stylesheet" href="<?=$file?>" type="text/css" />
  <?php
} echo "\n\t";
?>

<?php 

//echo Modules::run( 'pages/headerscript' );
?>
</head>
<body >
   
 
  
  <?php

  $this->view($content);
  //include( 'includes/footer.php' );
  ?>

<?php
$jssl = $jsfiles['common'];
$module = array();
if(isset($files["{$classf}/{$methodf}"]))
{
  $module = $files["{$classf}/{$methodf}"];
  foreach( $module as $cssv )
  {
    if(isset($js[$cssv]))
    {
      $jssl = array_merge($jssl , $js[$cssv]);
    }
    
  }
  
}
//echo '<pre>';print_r($jssl);exit;
if(!empty($jssl))
foreach($jssl as $file)
{
  echo "";
  ?>
    <script src="<?=$file?>"></script>
    <?php
 } echo "\n\t";

//echo Modules::run( 'pages/scripts' );
?>


</body>
</html>
