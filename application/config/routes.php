<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;




$route[ 'service/(:any)' ]	=	'pages/service/$1';
$route['events'] = 'pages/events/';
$route[ 'event/(:any)' ]	=	'pages/event/$1';
$route['contact-us'] = 'pages/contact/';
$route['request-a-callback'] = 'pages/call_back/';
$route[ 'blog-form' ]	=	'blog/form';
$route[ 'blog-form/(:any)' ]	=	'blog/form/$1';
$route[ 'event-form' ]	=	'events/form';
$route[ 'event-form/(:any)' ]	=	'events/form/$1';
$route[ 'about-us' ]	=	'pages/who_we_are';
$route[ 'services/specialized-products' ] = 'pages/specialized_products';
$route[ 'terms-and-services' ] = 'pages/pages/pages_static/7';
$route[ 'privacy-policy' ] = 'pages/pages/pages_static/6';
$route[ 'home' ] = 'pages/home';
$route[ 'aboutus' ] = 'pages/aboutus';

$route[ 'destinations' ] = 'pages/destinations';
$route[ 'destinations/(:any)' ] = 'pages/destinationsdetail/$1';
$route[ 'destination/(:any)' ] = 'pages/destination/$1';

$route[ 'tours' ] = 'pages/tours';
$route[ 'tours/(:any)' ] = 'pages/toursdetail/$1';

$route[ 'tour/(:any)' ] = 'pages/tour/$1';


$route[ 'hotels' ] = 'pages/hotels';
$route[ 'hotels/(:any)' ] = 'pages/hoteldetail/$1';

$route[ 'cars' ] = 'pages/cars';
$route[ 'cars/(:any)' ] = 'pages/cardetail/$1';

$route[ 'contact' ] = 'pages/contactus';

$route[ 'product-detail/(:any)' ] = 'pages/productdetail/$1';
$route[ 'contactus' ] = 'pages/contactus';
$route[ 'how-it-works' ] = 'pages/howitworks';
$route[ 'manage-blogs' ]	=	'blog/manage';
$route[ 'manage-category' ]	=	'blog/category/manage';
$route[ 'category-form/(:any)' ]	=	'blog/category/form/$1';

//news
$route[ 'news-form' ]	=	'news/news/form';
$route[ 'news-form/(:any)' ]	=	'news/form/$1';
$route[ 'manage-category' ]	=	'news/category/manage';
$route[ 'category-form/(:any)' ]	=	'news/category/form/$1';

//authentication
$route[ 'authentication-form' ]	=	'authentication/form';
$route[ 'authentication-form/(:any)' ]	=	'authentication/form/$1';
$route[ 'manage-authentication' ]	=	'authentication/manage';
//product
$route[ 'product-form' ]	=	'packages/admin_products/form';
$route[ 'product-form/(:any)' ]	=	'packages/admin_products/form/$1';
$route[ 'manage-product' ]	=	'packages/admin_products/manage';

//Destination
$route[ 'destination-categories-form' ]	=	'destination/admin_categories/form';
$route[ 'destination-categories-form/(:any)' ]	=	'destination/admin_categories/form/$1';
$route[ 'manage-destination-categories' ]	=	'destination/admin_categories/manage';

$route[ 'forgot-password' ] = 'user/password/forgot_form';
$route[ 'privacy-policy' ]  = 'pages/privacypolicy';
$route[ 'terms-and-condition' ]  = 'pages/termsandcondition';