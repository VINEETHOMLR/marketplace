<?php
class Admin_history extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'History_model' ) );
    }
	

	public function form( $history_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/history/form';
		$data[ 'history' ]	=	array();
		if( $history_id != NULL )
		{
			$data[ 'history' ]	=	$this->History_model->get( $history_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/history/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $history_id )
	{
		$where[ 'history_id' ]  = $history_id;
		$this->History_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'history_uri',
			'table' => 'mv_history',
			'id' => 'history_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$history_id	=	$_POST[ 'history_id' ];

		
		$data[ 'history_title' ]	=	$_POST[ 'history_title' ];
		$data[ 'history_description' ]	=	$_POST[ 'history_description' ];
		$data[ 'history_map' ]	=	$_POST[ 'history_map' ];
		$data[ 'history_status' ]	=	$_POST[ 'history_status'];
		
		

		
		

		$history_id	=	isset($_POST[ 'history_id' ])?$_POST['history_id']:0;
		$data[ 'history_title_english' ]	=	$_POST[ 'history_title_english' ];
		$data[ 'history_uri' ]	=	$this->get_uri( $data['history_title_english'] , $history_id );
		

        $file_name=rand(5,15).'history'.time();
		$uploaded	=false;
		$image_identiy	=	'history_image';
		$upload_path = 'assets/uploads/history/';
		
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
				$this->delete_file($uplohistory_path.$last_image);	
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
		    
		    $type = pathinfo($upload_path.$data['history_image'], PATHINFO_EXTENSION);
            $history_image_data = file_get_contents($upload_path.$data['history_image']);
            $history_image_data = 'data:image/' . $type . ';base64,' . base64_encode($history_image_data);
            $data['history_image_data']=$history_image_data;
            
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
		    

		

		if( $history_id == NULL )
		{
			$data[ 'history_dateadded' ]	=	$this->dbnow;	
			$data[ 'history_dateupdated' ]	=	$this->dbnow;	
			$history_id	=	$this->History_model->add( $data );
			$cinema = "New cinema added !";
		}
		else
		{
			$where[ 'history_id' ]	=	$history_id;
			$data[ 'history_dateupdated' ]	=	$this->dbnow;
			$this->History_model->update( $data , $where );
			$cinema = "History updated !";
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
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_history/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'history_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->History_model->update( $data , $where ) )
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
		$history_status	=	$this->input->post( 'history_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->History_model->get_list(  $history_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->History_model->get_count(  $history_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	
	
}