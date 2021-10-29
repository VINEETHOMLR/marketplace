<?php
class Admin_website extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Website_model' ) );
    }
	

	public function form( $website_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/website/form';
		$data[ 'website' ]	=	array();
		if( $website_id != NULL )
		{
			$data[ 'website' ]	=	$this->Website_model->get( $website_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/website/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $website_id )
	{
		$where[ 'website_id' ]  = $website_id;
		$this->Website_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'website_uri',
			'table' => 'mv_destination_cinema',
			'id' => 'website_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$website_id	=	$_POST[ 'website_id' ];

		
		$data[ 'website_title' ]	=	$_POST[ 'website_title' ];
		$data[ 'website_description' ]	=	$_POST[ 'website_description' ];
		$data[ 'website_url' ]	=	$_POST[ 'website_url' ];
		$data[ 'website_status' ]	=	$_POST[ 'website_status'];
		
		

		
		

		$website_id	=	isset($_POST[ 'website_id' ])?$_POST['website_id']:0;
		

        $file_name=rand(5,15).'website'.time();
		$uploaded	=false;
		$image_identiy	=	'website_image';
		$upload_path = 'assets/uploads/website/';
		
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
				$this->delete_file($uplowebsite_path.$last_image);	
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
		    
		    $type = pathinfo($upload_path.$data['website_image'], PATHINFO_EXTENSION);
            $website_image_data = file_get_contents($upload_path.$data['website_image']);
            $website_image_data = 'data:image/' . $type . ';base64,' . base64_encode($website_image_data);
            $data['website_image_data']=$website_image_data;
            
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
		    

		

		if( $website_id == NULL )
		{
			$data[ 'website_dateadded' ]	=	$this->dbnow;	
			$data[ 'website_dateupdated' ]	=	$this->dbnow;	
			$website_id	=	$this->Website_model->add( $data );
			$cinema = "New cinema added !";
		}
		else
		{
			$where[ 'website_id' ]	=	$website_id;
			$data[ 'website_dateupdated' ]	=	$this->dbnow;
			$this->Website_model->update( $data , $where );
			$cinema = "website updated !";
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
			$msg['msg']		=	$cinema;
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_website/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'website_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Website_model->update( $data , $where ) )
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
		$website_status	=	$this->input->post( 'website_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Website_model->get_list(  $website_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Website_model->get_count(  $website_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	
	
}