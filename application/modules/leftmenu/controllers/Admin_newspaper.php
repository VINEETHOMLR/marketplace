<?php
class Admin_newspaper extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Newspaper_model' ) );
    }
	

	public function form( $newspaper_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/newspaper/form';
		$data[ 'newspaper' ]	=	array();
		if( $newspaper_id != NULL )
		{
			$data[ 'newspaper' ]	=	$this->Newspaper_model->get( $newspaper_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/newspaper/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $newspaper_id )
	{
		$where[ 'newspaper_id' ]  = $newspaper_id;
		$this->Newspaper_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'newspaper_uri',
			'table' => 'mv_newspaper',
			'id' => 'newspaper_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$newspaper_id	=	$_POST[ 'newspaper_id' ];

		
		$data[ 'newspaper_title' ]	=	$_POST[ 'newspaper_title' ];
		$data[ 'newspaper_status' ]	=	$_POST[ 'newspaper_status'];
		$data[ 'newspaper_url' ]	=	$_POST[ 'newspaper_url'];
		

		
		

		$newspaper_id	=	isset($_POST[ 'newspaper_id' ])?$_POST['newspaper_id']:0;
		$data[ 'newspaper_title_english' ]	=	$_POST[ 'newspaper_title_english' ];
		$data[ 'newspaper_uri' ]	=	$this->get_uri( $data['newspaper_title_english'] , $newspaper_id );
		

        $file_name=rand(5,15).'newspaper'.time();
		$uploaded	=false;
		$image_identiy	=	'newspaper_image';
		$upload_path = 'assets/uploads/newspaper/';
		
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
				$this->delete_file($uplonewspaper_path.$last_image);	
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
			
			
			
		    $type = pathinfo($upload_path.$data['newspaper_image'], PATHINFO_EXTENSION);
            $newspaper_image_data = file_get_contents($upload_path.$data['newspaper_image']);
            $newspaper_image_data = 'data:image/' . $type . ';base64,' . base64_encode($newspaper_image_data);
            $data['newspaper_image_data']=$newspaper_image_data;
            
            
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
		    

		

		if( $newspaper_id == NULL )
		{
			$data[ 'newspaper_dateadded' ]	=	$this->dbnow;	
			$data[ 'newspaper_dateupdated' ]	=	$this->dbnow;	
			$newspaper_id	=	$this->Newspaper_model->add( $data );
			$newspaper = "New newspaper added !";
		}
		else
		{
			$where[ 'newspaper_id' ]	=	$newspaper_id;
			$data[ 'newspaper_dateupdated' ]	=	$this->dbnow;
			$this->Newspaper_model->update( $data , $where );
			$newspaper = "newspaper updated !";
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
			$msg['msg']		=	$newspaper;
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_newspaper/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'newspaper_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Newspaper_model->update( $data , $where ) )
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