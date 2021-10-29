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
    <header class="wow fadeInDown" id="header">
      <?php include ('includes/nav.php') ?>
    </header>
 
  
  <?php

  $this->view($content);
  include( 'includes/footer.php' );
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
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
}),

$(window).scroll(function() {
if ($(this).scrollTop()) {
$('#toTop').fadeIn();
} else {
$('#toTop').fadeOut();
}
});
$("#toTop").click(function () {
$("html, body").animate({scrollTop: 0}, 1000);
});
</script>
<script>
$(window).scroll(function() {
var scroll = $(window).scrollTop();
if (scroll <= 100) {
    $("#header").removeClass("nav-scroll");
}
else{
$("#header").addClass("nav-scroll");
}
});
</script>
<script>
wow = new WOW(
{
    animateClass: 'animated',
    offset:       50,
    callback:     function(box) {
    console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
}
}
);
wow.init();
</script>
   
   <script>
      $(document).ready(function() {

    $('.car-carousel').owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    responsiveClass: true,
    responsive: {
    0: {
    items: 1,
    nav: false,
    dots:false
    },
    600: {
    items: 2,
    nav: false
    },
    1000: {
    items: 3,
    nav: false,
    loop: false,
    margin: 20,
    dots:false
    }
    }
    })
    })
    $(document).ready(function() {
    $('.testimonial-slider').owlCarousel({
    loop: true,
    touchDrag: false,
    margin: 10,
    autoplay: true,
    animateOut: 'fadeOut',
    responsiveClass: true,
    responsive: {
    0: {
    items: 1,
    nav: false,
    dots:false
    },
    600: {
    items: 1,
    nav: false,
    dots:false
    },
    1000: {
    items: 1,
    nav: false,
    loop: false,
    margin: 20,
    dots:false
    }
    }
    })
    })
    $(document).ready(function() {
    $('.hotel-slider').owlCarousel({
    loop: true,
    touchDrag: false,
    margin: 0,
    autoplay: true,
    animateOut: 'fadeOut',
    responsiveClass: true,
    responsive: {
    0: {
    items: 1,
    nav: false,
    dots:false
    },
    480: {
    items: 2,
    nav: false
    },
    600: {
    items: 3,
    nav: false
    },
    1000: {
    items: 4,
    nav: false,
    loop: false,
    margin: 0,
    dots:false
    }
    }
    })
    })
    $(document).ready(function() {
    $('.partners-slider').owlCarousel({
    loop: true,
    touchDrag: false,
    margin: 20,
    autoplay: true,
    animateOut: 'fadeOut',
    responsiveClass: true,
    responsive: {
    0: {
    items: 1,
    nav: false,
    dots:false
    },
    480: {
    items: 2,
    nav: false
    },
    600: {
    items: 3,
    nav: false
    },
    1000: {
    items: 4,
    nav: false,
    loop: false,
    margin: 20,
    dots:false
    }
    }
    })
    })
    </script>
<script>
 
  $(document).ready(function() {
    setNavigation();
    

  });

  function setNavigation(){
    var path=window.location;
    
    $( ".menu a" ).each(function(  ) {
  var href=$(this).attr('href');
 if(path==href){
  
   $('.menu.active').removeClass('active');
$(this).closest('li').addClass('active');
 }
});
    
  }

</script>

</body>
</html>
