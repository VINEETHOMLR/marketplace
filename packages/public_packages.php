<?php
$theme_url	=	$this->base.'themes/public/';
$scripts	=	$this->base.'scripts/';
$files['common']	=	array(
//	'//www.tinymce.com/css/codepen.min.css',
	            $theme_url.'css/flaticon/flaticon.css',
				$theme_url.'css/bootstrap.min.css',
				$theme_url.'css/megamenu-style.css',
				$theme_url.'css/animate.css',
				$theme_url.'css/owl.carousel.min.css',
				$theme_url.'css/owl.theme.default.min.css',
				$theme_url.'css/style.css',
				/*$theme_url.'css/font-awesome.min.css',
				$theme_url.'css/custom.css',
				$theme_url.'css/owl.carousel.css',
				$theme_url.'css/owl.theme.css',
				$theme_url.'css/animate.css',
				$theme_url.'css/index.css',
				$theme_url.'css/layout.css',
				$theme_url.'css/responsive-finance.css',
				$theme_url.'css/jquery.beefup.css',*/
				'https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,600,700,800'

			//	$this->base.'content.css'

				
							
				);



$jsfiles['common']	=	array( 
				
				'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
				'https://use.fontawesome.com/026a5aa630.js',
				$theme_url.'js/bootstrap.min.js',
				
                $theme_url.'js/wow.js',
				$theme_url.'js/megamenu.js',


				
				
				
				
				);


$css['customall']=array($theme_url.'css/custom-all.css');
$css['quickview']=array($theme_url.'css/quickview-all.css');
$css['mix']=array($theme_url.'css/mix.css');
$css['contact']=array($theme_url.'css/contacts.css');






$css[ 'lightslider' ]	=	array( 
				$theme_url.'css/lightslider.css',
				$theme_url.'css/lightgallery.css',
				$theme_url.'css/responsive-tabs.css',
				
				
				

			
				);

$js['proper']=array('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
$js['courosel']=array($theme_url.'js/owl.carousel.js');
$js[ 'lightslider' ]	=	array(

				$theme_url.'js/lightslider.js',
				$theme_url.'js/jquery.responsiveTabs.js'
				
			
			);
$js[ 'popup' ] = array(
					$theme_url.'plugin/popup/js/pop_up.js',
					$theme_url.'plugin/popup/js/pop_up_func.js',
					);

$css[ 'popup' ] = array(
					$theme_url.'plugin/popup/css/pop_up.css',
					);
$js[ 'packagedetails' ] = array(
					$theme_url.'js/packagedetails.js',
					);
$js[ 'bs_leftnavi' ] = array(
					$theme_url.'js/bs_leftnavi.js', 
					);

$js[ 'stellar' ]	=	array( 
				$theme_url.'js/jquery.stellar.min.js',
				$theme_url.'js/waypoints.min.js',
				);
$css[ 'datetime' ] = array(
					$theme_url.'css/date_time_picker.css', 
					);				
$js[ 'datetime' ]	=	array( 
				$theme_url.'js/bootstrap-datepicker.js',
				$theme_url.'js/bootstrap-timepicker.js',
				);

$js[ 'theme_scripts' ]	=	array($theme_url.'js/theme-scripts.js',
				$theme_url.'js/scripts.js',);

$css[ 'swal' ]	=	array( $this->base.'js/downloads/sweetalert/sweetalert.css', );
$js[ 'swal' ]	=	array($this->base.'js/downloads/sweetalert/sweetalert.min.js',);
$js[ 'jquery_form' ]	=	array($this->base.'js/downloads/jquery.form.min.js',);
$js[ 'magnific-popup' ]	=	array($theme_url.'js/jquery.magnific-popup.js',
				);


$css[ 'magnific-popup' ]	=	array( 
				$theme_url.'css/magnific-popup.css'
				
				);
$js[ 'addthis' ]	=	array('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5858c0f445726d05');			


/*------------------------------------------------------------------------------------------------*/	
//$files["pages/home"]	=	array( 'layerslider', 'swal'  , 'jquery_form' , $this->base.'js/contact.js'  );
$files["pages/product"]	=	array( 'flexslider' , 'theme_scripts', 'addthis' );
$files["pages/products"]	=	array( 'bs_leftnavi' );
$files["pages/packagedetails"]	=	array( 'datetime', 'popup' , 'addthis', 'layerslider','packagedetails', 'trumbowyg_init','mv_form_init' , 'swal'  , 'jquery_form' , $this->base.'js/contact.js');
$files["pages/project"]	=	array( 'flexslider' , 'theme_scripts', 'addthis' );
$files["pages/contact"]	=	array( 'swal'  , 'jquery_form' , $this->base.'js/contact.js' );
$files["pages/call_back"]	=	array( 'swal'  , 'jquery_form' , $this->base.'js/contact.js' );
$files[ 'pages/gallery' ]	=	array(  'theme_scripts', 'magnific-popup' );
$files[ 'pages/blog' ]         =array(  'layerslider', 'addthis' );
$files[ 'pages/blogs' ]         =array(  'layerslider', 'addthis' );
$files[ 'pages/events' ]         =array(  'addthis' );
$files[ 'pages/service' ]         =array(  'addthis' );

/*------------------------------------------------------------------------------------------------*/	
/*$css[ 'pages/home' ] = array(
					$this->base.'js/downloads/sweetalert/sweetalert.css',
					);*/
$js[ 'contact' ]	=	array( 
				$this->base.'js/contact.js'
				
				);
				$js[ 'destination' ]	=	array( 
				$this->base.'scripts/admin/dist/destination.js'
				
				);


//$files["pages/home"]	=	array( 'swal'  , 'jquery_form' ,'contactjs' );
$files["pages/contactus"]	=	array( 'contact','swal'  , 'jquery_form' ,$this->base.'js/contact.js' );

$files["pages/howitworks"]	=	array( 'mix','swal'  , 'jquery_form' ,'contact'  );
$files["pages/pages_static"]	=	array( 'mix' );
//$files["pages/howitworks"]	=	array( 'howitworks' );
$files["pages/home"]	=	array( 'proper','courosel' );
$files["pages/destinationsdetail"]	=	array( 'lightslider','destination');
$files["pages/toursdetail"]	=	array( 'proper','courosel','lightslider','conatct','swal','jquery_form','destination');
$files["pages/hoteldetail"]	=	array( 'lightslider','destination','courosel' );
$files["pages/cardetail"]	=	array( 'lightslider' ,'contact','swal','jquery_form','courosel');





