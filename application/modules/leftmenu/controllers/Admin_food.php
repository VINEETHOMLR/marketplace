<?php
class Admin_food extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Food_model' ) );
    }
	

	public function form( $food_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/food/form';
		$data[ 'food' ]	=	array();
		if( $food_id != NULL )
		{
			$data[ 'food' ]	=	$this->Food_model->get( $food_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/food/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $food_id )
	{
		$where[ 'food_id' ]  = $food_id;
		$this->Food_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'food_uri',
			'table' => 'mv_food',
			'id' => 'food_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$food_id	=	$_POST[ 'food_id' ];

		
		$data[ 'food_title' ]	=	$_POST[ 'food_title' ];
		$data[ 'food_status' ]	=	$_POST[ 'food_status'];
		$data[ 'food_description' ]	=	$_POST[ 'food_description' ];
		$data[ 'food_category' ]	=	$_POST[ 'food_category' ];
		$data[ 'food_subcategory' ]	=	$_POST[ 'food_subcategory' ];
		

		
		

		$food_id	=	isset($_POST[ 'food_id' ])?$_POST['food_id']:0;
		$data[ 'food_title_english' ]	=	$_POST[ 'food_title_english' ];
		$data[ 'food_uri' ]	=	$this->get_uri( $data['food_title_english'] , $food_id );
		

        $file_name=rand(5,15).'food'.time();
		$uploaded	=false;
		$image_identiy	=	'food_image';
		$upload_path = 'assets/uploads/food/';
		
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL  )
		{
			
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			if( $file_name != NULL )
			{
				$config[ 'file_name' ] = $file_name;
			}
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload($image_identiy))
			{
				$msg['res']		=	2;
				$msg['msg']		=	$this->upload->display_errors();
				echo json_encode( $msg );
				die();
			}
			else
			{
				$upload_data = ($this->upload->data());
				$uploaded =  $upload_data['file_name'];
			
			}
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($uplofood_path.$last_image);	
			}
			list($width, $height, $type, $attr) = getimagesize($upload_path.$data[$image_identiy]);
            $aspect = $width / $height;
            $newWidth = 1000;
            $newHeight = $newWidth / $aspect;
			$config="";
		    $this->load->library('image_lib');
		    $config['image_library']  = 'gd2';
		    $config['source_image']   = $upload_path.$data[$image_identiy];       
		    // $config['create_thumb']   = TRUE;
		    $config['maintain_ratio'] = FALSE;
		    $config['width']          = $newWidth;
		    $config['height']         = $newHeight;
		    $config['new_image']      = $upload_path.$data[$image_identiy]; 
		                
		    $this->image_lib->initialize($config);
		    $this->image_lib->resize();
		    
		    $type = pathinfo($upload_path.$data['food_image'], PATHINFO_EXTENSION);
            $food_image_data = file_get_contents($upload_path.$data['food_image']);
            $food_image_data = 'data:image/' . $type . ';base64,' . base64_encode($food_image_data);
            $data['food_image_data']=$food_image_data;
            
            //fb share image creation
            $config="";
				
			$this->load->library('image_lib');
			$config['image_library']  = 'gd2';
			$config['source_image']   = $upload_path.$data[$image_identiy];       
			// $config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width']          = 150;
			$config['height']         = 150;
			$config['new_image']      = $upload_path.'fb/'.$data[$image_identiy];  
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
            
            
		}
		//echo '<pre>';print_r($data);exit;
		    $this->db->trans_begin();
		    


		if( $food_id == NULL )
		{
			$data[ 'food_dateadded' ]	=	$this->dbnow;	
			$data[ 'food_dateupdated' ]	=	$this->dbnow;	
			$food_id	=	$this->Food_model->add( $data );
			$health = "New health added !";
		}
		else
		{
			$where[ 'food_id' ]	=	$food_id;
			$data[ 'food_dateupdated' ]	=	$this->dbnow;
			$this->Food_model->update( $data , $where );
			$health = "Food updated !";
		}

	    
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again !';
		}
		else
		{
			$this->db->trans_commit();
			$msg['res']		=	1;
			$msg['msg']		=	$health;
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_food/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'food_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Food_model->update( $data , $where ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'Status changed .';
			
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again.';
		}
		
		echo json_encode($msg);
	}
	public function list_json()
	{
		$food_status	=	$this->input->post( 'food_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Food_model->get_list(  $food_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Food_model->get_count(  $food_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	
}