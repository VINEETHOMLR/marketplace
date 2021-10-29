<?php
class Admin_health extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Health_model' ) );
    }
	

	public function form( $health_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/health/form';
		$data[ 'health' ]	=	array();
		if( $health_id != NULL )
		{
			$data[ 'health' ]	=	$this->Health_model->get( $health_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/health/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $health_id )
	{
		$where[ 'health_id' ]  = $health_id;
		$this->Health_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'health_uri',
			'table' => 'mv_health',
			'id' => 'health_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$health_id	=	$_POST[ 'health_id' ];

		
		$data[ 'health_title' ]	=	$_POST[ 'health_title' ];
		$data[ 'health_status' ]	=	$_POST[ 'health_status'];
		$data[ 'health_description' ]	=	$_POST[ 'health_description'];

		
		

		$health_id	=	isset($_POST[ 'health_id' ])?$_POST['health_id']:0;
		$data[ 'health_title_english' ]	=	$_POST[ 'health_title_english' ];
		$data[ 'health_uri' ]	=	$this->get_uri( $data['health_title_english'] , $health_id );
		

        $file_name=rand(5,15).'health'.time();
		$uplohealthed	=false;
		$image_identiy	=	'health_image';
		$upload_path = 'assets/uploads/health/';
		
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
				$this->delete_file($uplohealth_path.$last_image);	
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
		    
		    $type = pathinfo($upload_path.$data['health_image'], PATHINFO_EXTENSION);
            $health_image_data = file_get_contents($upload_path.$data['health_image']);
            $health_image_data = 'data:image/' . $type . ';base64,' . base64_encode($health_image_data);
            $data['health_image_data']=$health_image_data;
            
            
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
		    

		

		if( $health_id == NULL )
		{
			$data[ 'health_dateadded' ]	=	$this->dbnow;	
			$data[ 'health_dateupdated' ]	=	$this->dbnow;	
			$health_id	=	$this->Health_model->add( $data );
			$health = "New health added !";
		}
		else
		{
			$where[ 'health_id' ]	=	$health_id;
			$data[ 'health_dateupdated' ]	=	$this->dbnow;
			$this->Health_model->update( $data , $where );
			$health = "health updated !";
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
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_health/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'health_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Health_model->update( $data , $where ) )
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
	
	
	
}