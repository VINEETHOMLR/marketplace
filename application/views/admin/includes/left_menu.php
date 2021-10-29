<?php
$base	=	base_url();
$class_key	=	$classf;
$method_key	=	$methodf;
/*-----------------------------admin menu------------------------------------------------*/

$menus[]	=	array(
				'text' => 'Category',
				'icon' => '  fa-users ',
				'href' => 'category/admin_category/manage',
				'key'=>'admin_category_manage'
				);

$menus[]	=	array(
				'text' => 'Subcategory',
				'icon' => '  fa-users ',
				'href' => 'subcategory/admin_subcategory/manage',
				'key'=>'admin_subcategory_manage'
				);


$menus[]	=	array(
				'text' => 'Store',
				'icon' => '  fa-users ',
				'href' => 'store/admin_store/manage',
				'key'=>'admin_store_manage'
				);


$menus[]	=	array(
				'text' => 'Product',
				'icon' => '  fa-users ',
				'href' => 'product/admin_product/manage',
				'key'=>'admin_product_manage'
				);

$menus[]	=	array(
				'text' => 'Users',
				'icon' => '  fa-users ',
				'href' => 'user/admin_user/manage',
				'key'=>'admin_user_manage'
				);

$storeadmin_menus[]	=	array(
				'text' => 'Store',
				'icon' => '  fa-users ',
				'href' => 'store/admin_store/store',
				'key'=>'admin_store_store'
				);

$storeadmin_menus[]	=	array(
				'text' => 'Order',
				'icon' => '  fa-users ',
				'href' => 'order/admin_order/manage',
				'key'=>'admin_order_manage'
				);

$storeadmin_menus[]	=	array(
				'text' => 'Product',
				'icon' => '  fa-users ',
				'href' => 'product/admin_product/manage',
				'key'=>'admin_product_manage'
				);
/*$storeadmin_menus[]	=	array(
				'text' => 'Users',
				'icon' => '  fa-users ',
				'href' => 'user/admin_user/manage',
				'key'=>'admin_user_manage'
				);*/

$storestaff_menus[]	=	array(
				'text' => 'Product',
				'icon' => '  fa-users ',
				'href' => 'product/admin_product/manage',
				'key'=>'admin_product_manage'
				);

$menus[]	=	array(
				'text' => 'Order',
				'icon' => '  fa-users ',
				'href' => 'order/admin_order/manage',
				'key'=>'admin_order_manage'
				);

/*$menus[]	=	array(
				'text' => 'Visit',
				'icon' => '  fa-users ',
				'href' => 'visit/admin_visit/manage',
				'key'=>'admin_visit_manage'
				);

$menus[]	=	array(
				'text' => 'Users',
				'icon' => '  fa-users ',
				'href' => 'user/admin_user/manage',
				'key'=>'admin_user_manage'
				);



$manager_menus[]	=	array(
				'text' => 'Visit',
				'icon' => '  fa-users ',
				'href' => 'visit/admin_visit/manage',
				'key'=>'admin_visit_manage'
				);


$manager_menus[]	=	array(
				'text' => 'Staffs',
				'icon' => '  fa-users ',
				'href' => 'staff/admin_staff/manage',
				'key'=>'admin_staff_manage'
				);*/


	/*$menus[]	=	array(
					'text' => 'Washer',
					'icon' => '  fa-users ',
					'href' => 'washer/admin_washer/manage',
					'key'=>'admin_washer_manage'
					);*/

/*$menus[]	=	array(
				'text' => 'Token List',
				'icon' => '  fa-users ',
				'href' => 'token/admin_token/manage',
				'key'=>'admin_token_manage'
				);
$menus[]	=	array(
				'text' => 'Notification',
				'icon' => '  fa-users ',
				'href' => 'notifications/admin_notification/form',
				'key'=>'admin_notification_form'
				);*/
/*$menus[]	=	array(
				'text' => 'Users',
				'icon' => '  fa-users ',
				'href' => 'user/admin_user/manage',
				'key'=>'admin_user_manage'
				);*/
/*$menus[]	=	array(
				'text' => 'SEO',
				'icon' => '  fa-clone ',
				'href' => 'pages/admin_pages/manage',
				'key'=>'admin_pages_manage'
				);*/
/*$category[]	=	array(
				'text' => 'Categories',
				'icon' => '  fa-users ',
				'href' => 'category/admin_categories/manage',
				'key'=>'admin_categories_manage'
				);
$category[]	=	array(
				'text' => 'Subcategory',
				'icon' => '  fa-users ',
				'href' => 'category/admin_subcategories/manage',
				'key'=>'admin_subcategories_manage'
				);*/
/*$category[]	=	array(
				'text' => 'Subcategory 3rd level',
				'icon' => '  fa-users ',
				'href' => 'category/admin_subcategorieslevel3/manage',
				'key'=>'admin_subcategorieslevel3_manage'
				);*/

/*$menus[]	=	array(
				'text' => 'Category',
				'icon' => 'fa-object-group',
				'submenu' =>$category
				);
$menus[]	=	array(
				'text' => 'News',
				'icon' => 'fa-list',
				'href' => 'news/news/manage',
				'key'=>'news_manage'
				);
$menus[]	=	array(
				'text' => 'Ads',
				'icon' => 'fa-list',
				'href' => 'ads/admin_ads/manage',
				'key'=>'admin_ads_manage'
				);
$menus[]	=	array(
				'text' => 'Gallery',
				'icon' => 'fa-list',
				'href' => 'gallerry/admin_gallerry/manage',
				'key'=>'admin_gallerry_manage'
				);*/
/*$menus[]	=	array(
				'text' => 'Panchayath/Muncipality',
				'icon' => 'fa-list',
				'href' => 'panchayath/admin_panchayath/manage',
				'key'=>'admin_panchayath_manage'
				);
*/
/*$menus[]	=	array(
				'text' => 'Directory',
				'icon' => 'fa-list',
				'href' => 'directory/admin_directories/manage',
				'key'=>'admin_directories_manage'
				);	
				*/
/*$menus[]	=	array(
				'text' => 'Feedback',
				'icon' => 'fa-list',
				'href' => 'feedback/admin_feedback/manage',
				'key'=>'admin_feedback_manage'
				);		

$subemenu_left[]	=	array(
				'text' => 'Messages',
				'icon' => 'fa-plus',
				'href' => 'leftmenu/admin_message/manage',
				'key'=>'admin_message_manage'
				);
$subemenu_left[]	=	array(
				'text' => 'History',
				'icon' => 'fa-plus',
				'href' => 'leftmenu/admin_history/manage',
				'key'=>'admin_history_manage'
				);
$subemenu_left[]	=	array(
				'text' => 'Website',
				'icon' => 'fa-plus',
				'href' => 'leftmenu/admin_website/manage',
				'key'=>'admin_website_manage'
				);
$subemenu_left[]	=	array(
				'text' => 'Health',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_health/manage',
				'key'=>'admin_health_manage'
				);
$subemenu_left[]	=	array(
				'text' => 'Newspaper',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_newspaper/manage',
				'key'=>'admin_newspaper_manage'
				);
$subemenu_left[]	=	array(
				'text' => 'Cinema',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_cinema/manage',
				'key'=>'admin_cinema_manage'
				);	
$subemenu_left[]	=	array(
				'text' => 'Food ',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_food/manage',
				'key'=>'admin_food_manage'
				);						
$subemenu_left[]	=	array(
				'text' => 'Food Category',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_foodcategory/manage',
				'key'=>'admin_foodcategorty_manage'
				);								
							
$subemenu_left[]	=	array(
				'text' => 'Food SubCategory',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_foodsubcategory/manage',
				'key'=>'admin_foodsubcategorty_manage'
				);	

$subemenu_left[]	=	array(
				'text' => 'About us',
				'icon' => 'fa-list',
				'href' => 'leftmenu/admin_about/form',
				'key'=>'admin_about_form'
				);*/


/*$menus[]	=	array(
				'text' => 'Left Menu',
				'icon' => 'fa-object-group',
				'submenu' =>$subemenu_left
				);						
*/
							
				


/*$tours[]	=	array(
				'text' => 'Tour Categories',
				'icon' => '  fa-users ',
				'href' => 'tour/admin_categories/manage',
				'key'=>'admin_categories_manage'
				);
$tours[]	=	array(
				'text' => 'Tours',
				'icon' => '  fa-users ',
				'href' => 'tour/admin_tours/manage',
				'key'=>'admin_tours_manage'
				);
$menus[]	=	array(
				'text' => 'Tour',
				'icon' => 'fa-object-group',
				'submenu' =>$tours
				);*/


/*$hotel[]	=	array(
				'text' => 'Hotel- Amenities',
				'icon' => '  fa-users ',
				'href' => 'amenities/admin_amenities/manage',
				'key'=>'admin_amenities_manage'
				);
$hotel[]	=	array(
				'text' => 'Hotels',
				'icon' => '  fa-users ',
				'href' => 'hotels/admin_hotels/manage',
				'key'=>'admin_hotels_manage'
				);
$menus[]	=	array(
				'text' => 'Hotel',
				'icon' => 'fa-object-group',
				'submenu' =>$hotel
				);*/
/*$menus[]	=	array(
				'text' => 'Car- Amenities',
				'icon' => '  fa-users ',
				'href' => 'caramenities/admin_amenities/manage',
				'key'=>'admin_amenities_manage'
				);*/
/*$menus[]	=	array(
				'text' => 'Cars',
				'icon' => '  fa-users ',
				'href' => 'cars/admin_cars/manage',
				'key'=>'admin_cars_manage'
				);
$menus[]	=	array(
				'text' => 'Testimonials',
				'icon' => '  fa-comments ',
				'href' => 'pages/admin_testimonials/manage',
				'key'=>'admin_testimonials_manage'
				);*/
/*$menus[]	=	array(
				'text' => 'Scripts',
				'icon' => ' fa-user ',
				'href' => 'admin/scripts',
				'key'=>'admin_scripts'
				);*/

/*$subemenu_authentication[]	=	array(
				'text' => 'Add New',
				'icon' => 'fa-plus',
				'href' => 'authentication-form',
				'key'=>'authentication_form'
				);
$subemenu_authentication[]	=	array(
				'text' => 'List All',
				'icon' => 'fa-list',
				'href' => 'manage-authentication',
				'key'=>'authentication_manage'
				);

$menus[]	=	array(
				'text' => 'Authentication Keys',
				'icon' => 'fa-object-group',
				'submenu' =>$subemenu_authentication
				);*/
/*$subemenu_product[]	=	array(
				'text' => 'Add New',
				'icon' => 'fa-plus',
				'href' => 'product-form',
				'key'=>'authentication_form'
				);
$subemenu_product[]	=	array(
				'text' => 'List All',
				'icon' => 'fa-list',
				'href' => 'manage-product',
				'key'=>'authentication_manage'
				);

$menus[]	=	array(
				'text' => 'Products',
				'icon' => 'fa-object-group',
				'submenu' =>$subemenu_product
				);*/







/*$menus[]	=	array(
				'text' => 'Clients',
				'icon' => '  fa-users ',
				'href' => 'clients/clients/manage',
				'key'=>'clients_manage'
				);
$menus[]	=	array(
				'text' => 'Scripts',
				'icon' => ' fa-user ',
				'href' => 'admin/scripts',
				'key'=>'admin_scripts'
				);
$subemenu_blog[]	=	array(
				'text' => 'Add New',
				'icon' => 'fa-plus',
				'href' => 'blog-form',
				'key'=>'blog_form'
				);
$subemenu_blog[]	=	array(
				'text' => 'Add Category',
				'icon' => 'fa-plus',
				'href' => 'blog/category/form',
				'key'=>'category_form'
				);
$subemenu_blog[]	=	array(
				'text' => 'List All Category',
				'icon' => 'fa-list',
				'href' => 'manage-category',
				'key'=>'category_manage'
				);
$subemenu_blog[]	=	array(
				'text' => 'List All',
				'icon' => 'fa-list',
				'href' => 'manage-blogs',
				'key'=>'blog_manage'
				);


$menus[]	=	array(
				'text' => 'Blogs',
				'icon' => 'fa-object-group',
				'submenu' =>$subemenu_blog
				);



$subemenu_news[]	=	array(
				'text' => 'Add New',
				'icon' => 'fa-plus',
				'href' => 'news-form',
				'key'=>'news_form'
				);
$subemenu_news[]	=	array(
				'text' => 'Add Category',
				'icon' => 'fa-plus',
				'href' => 'news/category/form',
				'key'=>'category_form'
				);
$subemenu_news[]	=	array(
				'text' => 'List All Category',
				'icon' => 'fa-list',
				'href' => 'manage-category',
				'key'=>'category_manage'
				);
$subemenu_news[]	=	array(
				'text' => 'List All',
				'icon' => 'fa-list',
				'href' => 'manage-news',
				'key'=>'news_manage'
				);


$menus[]	=	array(
				'text' => 'News',
				'icon' => 'fa-object-group',
				'submenu' =>$subemenu_news
				);*/


/*$menus[]	=	array(
				'text' => 'Slider',
				'icon' => ' fa-picture-o ',
				'href' => 'slider/manage',
				'key'=>'admin_testimonials_manage'
				);
$menus[]	=	array(
				'text' => 'Booking form',
				'icon' => '  fa-file-word-o ',
				'href' => 'bookform/manage',
				'key'=>'bookform'
				);*/
			
				/*$menus[]	=	array(
				'text' => 'Clients',
				'icon' => '  fa-users ',
				'href' => 'clients/clients/manage',
				'key'=>'clients_manage'
				);*/
$menus[]	=	array(
				'text' => 'Profile',
				'icon' => ' fa-user-plus ',
				'href' => 'admin/admin_profile',
				'key'=>'admin_profile_index'
				);
$storeadmin_menus[]	=	array(
				'text' => 'Profile',
				'icon' => ' fa-user-plus ',
				'href' => 'admin/admin_profile',
				'key'=>'admin_profile_index'
				);
$storestaff_menus[]	=	array(
				'text' => 'Profile',
				'icon' => ' fa-user-plus ',
				'href' => 'admin/admin_profile',
				'key'=>'admin_profile_index'
				);

/*$menus[]	=	array(
				'text' => 'Settings',
				'icon' => ' fa-gear ',
				'href' => 'admin/admin_settings',
				'key'=>'admin_settings_index'
				);
*/





/*$subemenu_blog[]	=	array(
				'text' => 'Add New',
				'icon' => 'fa-plus',
				'href' => 'blog-form',
				'key'=>'blog_form'
				);
$subemenu_blog[]	=	array(
				'text' => 'List All',
				'icon' => 'fa-list',
				'href' => 'manage-blogs',
				'key'=>'blog_manage'
				);

$menus[]	=	array(
				'text' => 'Blogs',
				'icon' => 'fa-object-group',
				'submenu' =>$subemenu_blog
				);

$subemenu_events[]	=	array(
				'text' => 'Add New',
				'icon' => 'fa-plus',
				'href' => 'events/form',
				'key'=>'events_form'
				);
$subemenu_events[]	=	array(
				'text' => 'List All',
				'icon' => 'fa-list',
				'href' => 'events/manage',
				'key'=>'events_manage'
				);


$menus[]	=	array(
				'text' => 'EVENTS',
				'icon' => ' fa-flag-o',
				'submenu' =>$subemenu_events
				);*/


$menu[ 'Admin' ]	=	$menus;
$menu[ 'Storeadmin' ]	=	$storeadmin_menus;
$menu[ 'Storestaff' ]	=	$storestaff_menus;


$user_image	=	trim( $this->user[ 'image' ] ) ? $this->user[ 'image' ] : 'default.png';


$menus	=	$menu[ $this->ion_auth->get_users_groups()->row()->name ];

?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  
  <section class="sidebar">
    <!-- Sidebar user panel -->
    
    <div class="user-panel">
      <div class="pull-left image"> <img src="<?=$base?>assets/uploads/users/<?=$user_image?>" class="img-circle" alt="User Image"> </div>
      <div class="pull-left info">
        <p>
          <?=$this->user[ 'first_name' ].' '.$this->user[ 'last_name' ]?>
        </p>
        <?=$this->ion_auth->get_users_groups()->row()->name?>
      </div>
    </div>
    
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <?php
      foreach($menus as $v)
	{
		$has_sub_menu	=	isset($v['submenu']) && sizeof($v['submenu']) > 0 ? 1 : 0 ;
		$open_class		=	$has_sub_menu && isset($v['keyp']) && $class_key == $v['keyp'] ? 'opened' : '';
		$active_class	=	!$has_sub_menu && isset($v['keyp']) && ($class_key == $v['keyp'] || $class_key.'_'.$method_key == $v['keyp']) ? 'active' : '';
		$href			=	!$has_sub_menu && isset( $v['href'] ) &&  $v['href'] != '' ? $base.$v['href'] : 'javascript:void(0)' ;
		
		$key	=	$class_key.'_'.$method_key ;
		if( ! $has_sub_menu )
		{
			$active_class	=	 $key == $v['key'] ? 'active' : '';
			?>
      <li class="<?=$active_class?>"> <a href="<?=$href?>"> <i class="fa <?=$v[ 'icon' ]?>"></i> <span>
        <?=$v[ 'text' ]?>
        </span> </a> </li>
      <?php
		}
		else
		{
			$open_class		= 	in_array( $key , array_column( $v[ 'submenu' ] , 'key')) ? TRUE : FALSE ;
			//echo $key.in_array( $key , array_column( $v[ 'submenu' ] , 'key'));
			?>
      <li class="treeview <?=$open_class ? 'active' : ''?>"> <a href="javascript:void(0)"> <i class="fa <?=$v[ 'icon' ]?>"></i> <span>
        <?=$v[ 'text' ]?>
        </span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <?php
            foreach( $v[ 'submenu' ] as $v2 )
			{
				$active_class	=	 $key == $v2['key'] ? 'active' : '';
				?>
          <li class="<?=$active_class?>"> <a href="<?=$this->base.$v2['href']?>"> <i class="fa <?=$v2[ 'icon' ]?>"></i> <span>
            <?=$v2[ 'text' ]?>
            </span> </a> </li>
          <?php
			}
			?>
        </ul>
      </li>
      <?php
		}
		
	}
	  
	  ?>
    </ul>
    
    <!-- /.sidebar --> 
    <!--left menu here--> 
  </section>
</aside>
