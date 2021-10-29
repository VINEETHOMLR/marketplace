<?php
class Widgets extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
    }
	
	public function top_destinations()
	{
	    $this->load->model('destination/Categories_model');
	    $data['destinations']=$this->Categories_model->categorylist(4);
	    $this->load->view( 'widgets/home_top_destinations',$data);
	    	
	}
	public function home_cars()
	{
		$this->load->model('cars/Cars_model');
	    $data['cars']=$this->Cars_model->car_list(3);
	    $this->load->view( 'widgets/home_cars',$data);
	}

	public function home_tours()
	{
		$this->load->model('tour/Tours_model');
	    $rows=$this->Tours_model->get_tours(6,NULL);
	    foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'tour_id' ],  imageType::TOUR  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ $k ][ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ $k ][ 'main_image' ]	=	$main_image;
			$rows[ $k ][ 'image_count' ]	=	sizeof($images);
		}
		
		
		$data[ 'tours' ]	=	$rows;


	    $this->load->view( 'widgets/home_tours',$data);
	}
	public function featured_tours()
	{
		$this->load->model('tour/Tours_model');
	    $rows=$this->Tours_model->get_tours(4,NULL);
	    foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'tour_id' ],  imageType::TOUR  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ $k ][ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ $k ][ 'main_image' ]	=	$main_image;
			$rows[ $k ][ 'image_count' ]	=	sizeof($images);
		}
		
		
		$data[ 'tours' ]	=	$rows;


	    $this->load->view( 'widgets/featured_tours',$data);
	}
	public function relatedpackages()
	{
		$this->load->model('tour/Tours_model');
	    $rows=$this->Tours_model->get_tours(3,NULL);
	    foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'tour_id' ],  imageType::TOUR  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ $k ][ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ $k ][ 'main_image' ]	=	$main_image;
			$rows[ $k ][ 'image_count' ]	=	sizeof($images);
		}
		
		
		$data[ 'tours' ]	=	$rows;


	    $this->load->view( 'widgets/relatedpackages',$data);
	}


	public function testimonials()
	{
		
		
        $this->load->model('Testimonials_model');
        $data['testimonials']=$this->Testimonials_model->get_testimonials();
        $this->load->view( 'widgets/testimonials',$data);
	}
	public function home_hotels()
	{
		$this->load->model('hotels/Hotels_model');
	    $rows=$this->Hotels_model->get_hotels(4);
	    foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'hotel_id' ],  imageType::HOTEL  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ $k ][ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ $k ][ 'main_image' ]	=	$main_image;
			$rows[ $k ][ 'image_count' ]	=	sizeof($images);
		}
		
		
		$data[ 'hotels' ]	=	$rows;


	    $this->load->view( 'widgets/home_hotels',$data);
	}
	public function relatedhotels()
	{
		$this->load->model('hotels/Hotels_model');
	    $rows=$this->Hotels_model->get_hotels(4);
	    foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'hotel_id' ],  imageType::HOTEL  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ $k ][ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ $k ][ 'main_image' ]	=	$main_image;
			$rows[ $k ][ 'image_count' ]	=	sizeof($images);
		}
		
		
		$data[ 'hotels' ]	=	$rows;


	    $this->load->view( 'widgets/relatedhotels',$data);
	}
	public function clients()
	{
		
		

        $this->load->model('clients/Clients_model');
        $data['clients']=$this->Clients_model->get_brands();
        $this->load->view( 'widgets/brands',$data);
	}

	public function contactus()
	{
		
		


		
		$this->load->view( 'widgets/contactus');
	}
	public function pagesbanner()
	{
		
		

        
        $this->load->view( 'widgets/pagesbanner');
	}
	
	public function social_media()
	{
		$this->load->model('Admin/Social_media_model');
		return $this->Social_media_model->get_social_media($status=NULL);
	}


	public function categories()
	{
		$this->load->model('packages/Categories_model');
		return $this->Categories_model->home_categorylist( );
	}
	public function get_social_media()
	{
		$this->load->model('admin/Social_media_model');
		$data['socialmedias']=$this->Social_media_model->get_social_media(SocialmediaStatus::ACTIVE);
		return $data['socialmedias'];


   }
  
	 public function team()
	{
		
		

        $this->load->model('Testimonials_model');
        $data['team']=$this->Testimonials_model->get_testimonials();
        $this->load->view( 'widgets/team',$data);
	}

}