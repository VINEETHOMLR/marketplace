<?php
$theme_url	=	$this->base.'themes/admin/';
$files['common']	=	array(
				$this->base.'scripts/downloads/bootstrap-3/css/bootstrap.min.css',
				'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
				'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
				'https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda-themeless.min.css',
				$this->base.'themes/admin/dist/css/AdminLTE.min.css',
				$this->base.'themes/admin/dist/css/skins/_all-skins.min.css',
				$this->base.'js/downloads/x-editable/css/jquery-editable.css',

				//$this->base.'assets/plugins/ladda/ladda-themeless.min.css',
				//$this->base.'assets/plugins/form_validator/css/validationEngine.jquery.css',
				//$this->base.'assets/plugins/lobibox/lobibox.css'
				
				);
$jsfiles['common']	=	array( 
	            //'http://www.google.com/jsapi',

				$this->base.'scripts/admin/dist/commonJs.js',
				//'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
              //  $this->base.'scripts/admin/dist/malayalam.js',


				);	

$jsfiles['category']	=	array( 
	          
                $this->base.'scripts/admin/dist/category.js',


				);	

				
$jsfiles['bundle']=array('bundle.js');
$jsfiles['newbundle']=array('newbundle.js');
$jsfiles['tagsinput']=array('tagsinput.js');
$jsfiles['typeahead']=array('typeahead.js');
$jsfiles['blog']=array($this->base.'scripts/dist/admin/js/blog.js');							
$css[ 'bootstrap-table' ]	=	array($this->base."scripts/cli/node_modules/bootstrap-table/src/bootstrap-table.css");
/*------------------------------------------------------------------------------------------------*/	
$modules[ 'admin_pages/manage' ] = array( 'admin_pages_manage', 'mv_table_init','mv_form_init ');

/*------------------------------------------------------------------------------------------------*/	

$modules[ 'admin_logos/form' ] = array(   'mv_form_init'  , 'image_uploader_init' );
$modules[ 'admin_sculpters/form' ] = array(   'mv_form_init'  , 'image_uploader_init' );
$modules[ 'admin_media/form' ] = array(   'mv_form_init'  , 'image_uploader_init' , 'video_uploader');
$modules[ 'admin_categories/manage' ] = array( 'mv_table_init' );
$modules[ 'admin_subcategories/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_products/manage' ] = array( 'mv_table_init' );
////$modules[ 'admin_testimonials/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_pages/manage' ] = array( 'mv_table_init' );
//$modules[ 'contacts/manage' ] = array( 'mv_table_init' );
//$modules[ 'blog/manage' ] = array( 'mv_table_init' );
//$modules[ 'blog/form' ] = array( 'mv_form_init','tagsinput','typeahead','bundle','blog' );
//$modules[ 'events/manage' ] = array( 'mv_table_init' );
//$modules[ 'events/form' ] = array( 'trumbowyg_init','mv_form_init' );
//$modules[ 'slider/form' ] = array( 'trumbowyg_init','mv_form_init' );
//$modules[ 'slider/manage' ] = array( 'mv_table_init' );
//$modules[ 'bookform/form' ] = array( 'trumbowyg_init','mv_form_init' );
//$modules[ 'bookform/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_services/form' ] = array( 'trumbowyg_init','mv_form_init' , 'image_uploader_init' );
//$modules[ 'admin_pages/form' ] = array( 'trumbowyg_init','mv_form_init' );
$modules[ 'admin_profile/index' ] = array(  'mv_form_init' ,$this->base.'themes/admin/plugins/jQuery/jQuery-2.2.0.min.js',$this->base.'themes/admin/dist/js/socialmedia.js',$this->base.'scripts/admin/dist/contact_details.js');
//$modules[ 'admin_products/form' ] = array(  'trumbowyg_init', 'mv_form_init', 'image_uploader_init' );
$modules[ 'admin_categories/form' ] = array(  'trumbowyg_init','mv_form_init' , 'image_uploader_init' );
//$modules[ 'admin_projects/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_projects/form' ] = array(  'trumbowyg_init','mv_form_init' , 'image_uploader_init' , 'video_uploader');
//$modules[ 'contacts/send_mail' ] = array(  'trumbowyg_init','mv_form_init' , $this->base.'scripts/admin/dist/mail_sending.js' );
$modules[ 'admin_settings/index' ] = array( 'mv_form_init' );
//$modules[ 'clients/manage' ] = array( 'mv_form_init','mv_table_init','image_uploader_init' );
$js['dropzone']=array($this->base.'themes/public/js/dropzone.js');
$js['dropzone-custom']=array($this->base.'themes/public/js/dropzone-custom.js');
$modules[ 'clients/form' ] = array( 'mv_form_init','dropzone','dropzone-custom' );

$css[ "dropzonecss" ]=array($this->base.'themes/public/css/dropzone.css');
$files["clients/form"]=array('dropzonecss');
$modules[ 'scripts/index' ] = array(  'mv_form_init');
$modules[ 'category/manage' ] = array( 'mv_table_init');
$modules[ 'category/form' ] = array( 'mv_form_init');


$modules[ 'news/form' ] = array( 'mv_form_init');

//mobileapp
$modules[ 'admin_category/manage' ] = array( 'mv_table_init');
//$modules[ 'admin_hash_tag/manage' ] = array( 'mv_table_init');
//$modules[ 'admin_user/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_posts/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_likes/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_downloads/manage' ] = array( 'mv_table_init' );
//$modules[ 'admin_views/manage' ] = array( 'mv_table_init' );
//$modules[ 'authentication/manage' ] = array( 'mv_table_init' );
//$modules[ 'authentication/form' ] = array( 'mv_form_init');
//$modules[ 'packages/admin_products/manage' ] = array( 'mv_table_init' );
//$modules[ 'packages/admin_products/form' ] = array( 'mv_form_init');
/*$modules[ 'gallerry/admin_gallerry/manage' ] = array( 'mv_table_init');
$modules[ 'gallerry/admin_gallerry/form' ] = array( 'mv_form_init');
*/



$modules[ 'password/forgot_form' ] = array( 'mv_form_init');

$modules[ 'admin_subcategories/form' ] = array( 'mv_form_init');
$modules[ 'admin_subcategorieslevel3/form' ] = array( 'mv_form_init','category');
$modules[ 'admin_subcategorieslevel3/manage' ] = array( 'mv_table_init');
$modules[ 'news/manage' ] = array( 'mv_table_init');
$modules[ 'admin_ads/manage' ] = array( 'mv_table_init');
$modules[ 'admin_ads/form' ] = array( 'mv_form_init');
//$modules[ 'admin_panchayath/manage' ] = array( 'mv_table_init');
//$modules[ 'admin_panchayath/form' ] = array( 'mv_form_init');
/*$modules[ 'admin_directories/manage' ] = array( 'mv_table_init');
$modules[ 'admin_directories/form' ] = array( 'mv_form_init','category');
$modules[ 'admin_feedback/manage' ] = array( 'mv_table_init');*/




/*$modules[ 'admin_gallerry/form' ] = array( 'mv_form_init');
$modules[ 'admin_gallerry/manage' ] = array( 'mv_table_init');
$modules[ 'admin_token/manage' ] = array( 'mv_table_init');
$modules[ 'admin_notification/form' ] = array( 'mv_form_init');*/


//washmate
/*$modules[ 'admin_service/manage' ] = array( 'mv_table_init');
$modules[ 'admin_service/form' ] = array( 'mv_form_init');
$modules[ 'admin_washer/manage' ] = array( 'mv_table_init');
$modules[ 'admin_washer/form' ] = array( 'mv_form_init');*/

//security


$modules[ 'admin_category/manage' ] = array( 'mv_table_init');
$modules[ 'admin_category/form' ] = array( 'mv_form_init', 'image_uploader_init');


$modules[ 'admin_store/manage' ] = array( 'mv_table_init');
$modules[ 'admin_store/form' ] = array( 'mv_form_init', 'image_uploader_init');

$modules[ 'admin_product/manage' ] = array( 'mv_table_init' );
$modules[ 'admin_product/form' ] = array( 'mv_form_init','image_uploader_init','dropzone','dropzone-custom-product');


$modules[ 'admin_staff/manage' ] = array( 'mv_table_init' );
$modules[ 'admin_staff/form' ] = array( 'mv_form_init','image_uploader_init');


$modules[ 'admin_user/manage' ] = array( 'mv_table_init' );
$modules[ 'admin_user/form' ] = array( 'mv_form_init','image_uploader_init');


$modules[ 'admin_subcategory/manage' ] = array( 'mv_table_init');
$modules[ 'admin_subcategory/form' ] = array( 'mv_form_init', 'image_uploader_init');
$modules[ 'admin_order/manage' ] = array( 'mv_table_init');
$modules[ 'admin_order/form' ] = array( 'mv_form_init', 'image_uploader_init');
$modules[ 'admin_store/store' ] = array( 'mv_form_init', 'image_uploader_init');

$files["admin_product/form"]=array('dropzonecss');













