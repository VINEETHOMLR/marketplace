<?php
class Pages extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		
		
    }
	
	public function home()
	{
		

		$data[ 'content' ]	=	'pages/home';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 1  , ContentTypes::PAGE );
		$this->load->model('Pages_model');
		$data['pagedata']=$this->Pages_model->get_page_single(1);
		
		$this->load->view( 'public/home' , $data );
		
	}

	public function destinations()
	{
		$data[ 'content' ]	=	'pages/destinations';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 3  , ContentTypes::PAGE );
		$this->load->model('destination/Destinations_model');
		$rows=$this->Destinations_model->get_destinations(NULL,NULL);
		foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'destination_id' ],  imageType::DESTINATION  , TRUE );
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
		
		
		$data[ 'destinations' ]	=	$rows;
		$data['detail']=0;
		
		$this->load->view( 'public/page' , $data );
		
	}

	public function destinationsdetail($uri)
	{
			$this->load->model('destination/Destinations_model');
			$data[ 'content' ]	=	'pages/destinationdetails';
		    $data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 3  , ContentTypes::PAGE );
			
			$rows=$this->Destinations_model->get_detail( $uri);

			$images	=	Modules::run( 'img/list_json' , $rows[ 'destination_id' ],  imageType::DESTINATION  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ 'main_image' ]	=	$main_image;
			$rows[ 'image_count' ]	=	sizeof($images);

    
			$videos	=	Modules::run( 'video/videolist' , $rows[ 'destination_id' ],  videoType::DESTINATION  , TRUE );
			

			
			$rows[ 'videos' ]	=	$videos;

            $data['detail']=$rows;
			//echo "<pre>";print_r($data['detail']);die();

			$this->load->view( 'public/page' , $data );
			

		
	}
	
	public function destination($uri)//based on category
	{
		$data[ 'content' ]	=	'pages/destinations';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 3  , ContentTypes::PAGE );
		$this->load->model('destination/Categories_model');
		$id=$this->Categories_model->get_id( $uri);
		
		
		
		$this->load->model('destination/Destinations_model');
		$rows=$this->Destinations_model->get_destinations(NULL,$id['category_id']);
		foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'destination_id' ],  imageType::DESTINATION  , TRUE );
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
		
		
		$data[ 'destinations' ]	=	$rows;
		$data['detail']=0;
		
		$this->load->view( 'public/page' , $data );
		
	}
	public function tours()
	{   
	    $data[ 'content' ]	=	'pages/tours';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 4  , ContentTypes::PAGE );
		$this->load->model('tour/Tours_model');
	    $rows=$this->Tours_model->get_tours(NULL,NULL);
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


	    $this->load->view( 'public/page',$data);
	}
	
	
	public function tour($uri)
	{   
	    $data[ 'content' ]	=	'pages/tours';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 4  , ContentTypes::PAGE );
		$this->load->model('tour/Tours_model');
		$this->load->model('Pages_model');
		$id=$this->Pages_model->get_id( $uri);
		$data['category']=$id['category_title'];
		
	    $rows=$this->Tours_model->get_tours(NULL,$id['category_id']);
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
        

	    $this->load->view( 'public/page',$data);
		
	}
	
	public function toursdetail($uri)
	{
		$data[ 'content' ]	=	'pages/tourdetail';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 4  , ContentTypes::PAGE );
		$this->load->model('tour/Tours_model');
	    $rows=$this->Tours_model->detail($uri);

		
			$images	=	Modules::run( 'img/list_json' , $rows[ 'tour_id' ],  imageType::TOUR  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ 'main_image' ]	=	$main_image;
			$rows[ 'image_count' ]	=	sizeof($images);
		
		
		
		

		$tour_Itinerary=json_decode($rows['tour_Itinerary']);
		//echo "<pre>";
		//print_r($tour_Itinerary);
        $Itinerary=array();
		foreach($tour_Itinerary as $k=>$v)
		{
          // echo "<pre>";
           //print_r($v->hotel);

           $this->load->model('hotels/Hotels_model');
           $hotel=$this->Hotels_model->hotel_details($v->hotel);
           $images=$this->Hotels_model->images($v->hotel);
          // echo "<pre>";
          // print_r($images);
          // print_r($hotel['hotel_title']);
           $hotels=array('title'=>$v->title,'description'=>$v->description,'name'=>$hotel['hotel_title'],'uri'=>$hotel['hotel_uri'],'images'=>$images);
          // $Itinerary[$k]=$hotels;
           $rows['itenery'][$k]=$hotels;

		}
		
       $data[ 'tours' ]	=	$rows;
       
	   $this->load->view( 'public/page',$data);
	}
	
	public function hotels()
	{
		$data[ 'content' ]	=	'pages/hotels';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 6  , ContentTypes::PAGE );
		$this->load->model('hotels/Hotels_model');
	    $rows=$this->Hotels_model->get_hotels(NULL);
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


	   $this->load->view( 'public/page',$data);
	}
	
	public function hoteldetail($uri)
	{     
			$data[ 'content' ]	=	'pages/hoteldetail';
			$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 6  , ContentTypes::PAGE );
			$this->load->model('hotels/Hotels_model');
			$rows=$this->Hotels_model->details($uri);
			
			$amenities=json_decode($rows['hotel_amenities']);
			$this->load->model('amenities/Amenities_model');
			foreach($amenities as $k=>$v)
			{   
				$amenities[$k]=$this->Amenities_model->get_details($v);
			}
			$rows['amenities']=$amenities;
			
		
			$images	=	Modules::run( 'img/list_json' , $rows[ 'hotel_id' ],  imageType::HOTEL  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ 'main_image' ]	=	$main_image;
			$rows[ 'image_count' ]	=	sizeof($images);
		
		
		
		     $data[ 'hotels' ]	=	$rows;
			 
			 

	        $this->load->view( 'public/page',$data);
	}
	
	
	public function cars()
	{   
	    $data[ 'content' ]	=	'pages/cars';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 7  , ContentTypes::PAGE );
		$this->load->model('cars/Cars_model');
	    $data['cars']=$this->Cars_model->car_list(NULL);
	    $this->load->view( 'public/page',$data);
	}
	
	public function cardetail($uri)
	{   
	    $data[ 'content' ]	=	'pages/cardetails';
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 7  , ContentTypes::PAGE );
		$this->load->model('cars/Cars_model');
	    $data['cars']=$this->Cars_model->get_details($uri);
		$data['car']=$this->Cars_model->car_list(6);
	    $this->load->view( 'public/page',$data);
	}
	
	
	
	
	
	
	


	public function contactus()
	{

		$data[ 'content' ]	=	'pages/contactus';

		
	

		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , 5  , ContentTypes::PAGE );
		
		
		$this->load->view( 'public/page' , $data );
	}

	public function pages_static($page_id)
	{



		$data[ 'content' ]	=	'pages/static';

		
	

		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , array() , $page_id  , ContentTypes::PAGE );
		$this->load->model('Pages_model');
		$data['pagedata']=$this->Pages_model->get_page_single($page_id);
		//echo '<pre>';print_r($data[ 'meta' ]);exit;
		$this->load->view( 'public/page' , $data );
	}

	
	
	
	
	
	
	

	
	public function send_message()
	{
		

        
		$data[ 'form_packagename' ]	=	$this->input->post( 'form_packagename' );
		$data[ 'form_hotelname' ]	=	$this->input->post( 'form_hotelname' );
		$data[ 'form_vehicle' ]	=	$this->input->post( 'form_vehicle' );
		$data[ 'form_food' ]	=	$this->input->post( 'form_food' );
		$data[ 'form_budget' ]	=	$this->input->post( 'form_budget' );
		$data[ 'form_startdate' ]	=	$this->input->post( 'form_startdate' );
		$data[ 'form_enddate' ]	=	$this->input->post( 'form_enddate' );
		$data[ 'form_adult' ]	=	$this->input->post( 'form_adult' );
		$data[ 'form_child' ]	=	$this->input->post( 'form_child' );
		$data[ 'form_portofarival' ]	=	$this->input->post( 'form_portofarival' );
		$data[ 'form_fname' ]	=	$this->input->post( 'form_fname' );
		$data[ 'form_lname' ]	=	$this->input->post( 'form_lname' );
		$data[ 'form_email' ]	=	$this->input->post( 'form_email' );
		$data[ 'form_phone' ]	=	$this->input->post( 'form_phone' );
		$data[ 'form_facebookid' ]	=	$this->input->post( 'form_facebookid' );
		$data[ 'form_whatsapp' ]	=	$this->input->post( 'form_whatsapp' );
		$data[ 'form_comments' ]	=	$this->input->post( 'form_comments' );


		//echo "<pre>"; print_r($data);exit;

		
		

		if ( $this->form_validation->run('pages/send_message') == FALSE)
		{
			$errors = validation_errors();
			echo json_encode(array('res'=>2,'msg'=>$errors));
			die();
		}
		
		Modules::run( 'mails/send_message' , $data );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success .</span>';
		echo json_encode($msg);
		
	}
	public function send_query()
	{
		$data[ 'first_name' ]	=	$this->input->post( 'first_name' );
		$data[ 'last_name' ]	=	$this->input->post( 'last_name' );
		$data[ 'email' ]	=	$this->input->post( 'email' );
		$data[ 'phone' ]	=	$this->input->post( 'phone' );
		$data[ 'message' ]	=	$this->input->post( 'message' );


		//echo "<pre>"; print_r($data);exit;

		
		

		if ( $this->form_validation->run('pages/send_query') == FALSE)
		{
			$errors = validation_errors();
			echo json_encode(array('res'=>2,'msg'=>$errors));
			die();
		}
		
		Modules::run( 'mails/send_query' , $data );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success .</span>';
		echo json_encode($msg);
		
	}
	public function book_now()
	{
		$data[ 'name' ]	=	$this->input->post( 'name' );
		
		$data[ 'email' ]	=	$this->input->post( 'email' );
		$data[ 'phone' ]	=	$this->input->post( 'phone' );
		$data[ 'nofopersons' ]	=	$this->input->post( 'nofopersons' );
		$data[ 'from' ]	=	$this->input->post( 'from' );
		$data[ 'to' ]	=	$this->input->post( 'to' );
		$data[ 'message' ]	=	$this->input->post( 'message' );


		//echo "<pre>"; print_r($data);exit;

		
		

		if ( $this->form_validation->run('pages/book_now') == FALSE)
		{
			$errors = validation_errors();
			echo json_encode(array('res'=>2,'msg'=>$errors));
			die();
		}
		
		Modules::run( 'mails/book_now' , $data );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success .</span>';
		echo json_encode($msg);
		
	}

	public function send_query_header()
	{
		$data[ 'name' ]	=	$this->input->post( 'name' );
		$data[ 'email' ]	=	$this->input->post( 'email' );
		$data[ 'message' ]	=	$this->input->post( 'message' );
		


		//echo "<pre>"; print_r($data);exit;

		
		

		if ( $this->form_validation->run('pages/send_query_header') == FALSE)
		{
			$errors = validation_errors();
			echo json_encode(array('res'=>2,'msg'=>$errors));
			die();
		}
		
		Modules::run( 'mails/send_query_header' , $data );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success .</span>';
		echo json_encode($msg);
		
	}
	public function free_consultation()
	{

		

		$data[ 'name' ]	=	$this->input->post( 'name' );
		$data[ 'phone' ]	=	$this->input->post( 'phone' );
		$data[ 'email' ]	=	$this->input->post( 'email' );
		$data[ 'owe' ]	=	$this->input->post( 'owe' );
		$data[ 'help' ]	=	$this->input->post( 'help' );
		$data[ 'information' ]	=	$this->input->post( 'information' );
        
       
		//echo "<pre>"; print_r($data);exit;

		
		

		if ( $this->form_validation->run('pages/free_consultation') == FALSE)
		{
			$errors = validation_errors();
			echo json_encode(array('res'=>2,'msg'=>$errors));
			die();
		}
		
		Modules::run( 'mails/send_mail_free_consultation' , $data );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success .</span>';
		echo json_encode($msg);
		
	}
		public function get_contact_details()
   {
   	$this->load->model('Admin/Contact_details_model');
   	$contactData=$this->Contact_details_model->get(1);
   	return $contactData;
   }

   public function scripts()
    {
        
        $this->load->model( 'Scripts_model' );
        $script_where[ 'script_id' ]    =   1;
        $script_where[ 'script_status' ]    =   1;
        $script =   $this->Scripts_model->set_where( $script_where )->get();
        if( sizeof( $script ) )
        {
            
            echo base64_url_decode( $script[ 'script' ] );
            
        }
        
    }
    public function headerscript()
    {
        
        $this->load->model( 'Scripts_model' );
        $script_where[ 'script_id' ]    =   1;
        $script_where[ 'script_status' ]    =   1;
        $script =   $this->Scripts_model->set_where( $script_where )->get();
   
        if( sizeof( $script ) )
        {
            
        echo base64_url_decode( $script[ 'headerscript' ] );
        }
        
    }
    
    public function destination_category_dropdown()
    {
    	 
         $this->load->model(array('destination/Categories_model'=>'category')); 
         return $this->category->categorylist(NULL);
         
    }
    public function tour_dropdown()
    {
    	 
         $this->load->model('Pages_model'); 
         return $this->Pages_model->tour_categories();
         
    }
	
	public function get_hotel($id)
	{   
	    $this->load->model('hotels/Hotels_model');
		$hoteldetal=$this->Hotels_model->hotel_details($id);
		$images=$this->Hotels_model->images($id);
		$hotel['detail']=$hoteldetal;
		$hotel['images']=$images;
		return $hotel;
		
	}
	public function ajax_hotels()
	{
		 

		$hotels=Modules::run('hotels/admin_hotels/get_hotel');
		$option="";
		$row='<div class="row add-row">';
		$row.='<div class="col-md-4">';
		$row.='<input type="text" name="title[]" class="form-control"></div>';
		$row.='<div class="col-md-4"><textarea name="description[]" class="form-control"></textarea></div>';
		$row.='<div class="col-md-4">';
		$row.='<select name="hotel[]" class="form-control">';
		foreach($hotels as $k=>$v)
		{
         $option.='<option value='.$v["hotel_id"].'>'. $v["hotel_title"].'</option>';
		}
		$row.=$option;
		$row.='</select>
                  </div>
                </div>';
        echo $row;        



	}
   
	
	
	
}