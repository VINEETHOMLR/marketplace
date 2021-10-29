<?php
class Admin_service extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Service_model' ) );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$service_status	=	$this->input->post( 'service_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$service_search	=	$this->input->post( 'search' );
		
		$records[ 'rows' ]	=	$this->Service_model->get_list(  $service_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $service_search , $user_id );
		$records[ 'total' ]	=	$this->Service_model->get_count(  $service_status ,  $date_from ,  $date_to  , $service_search , $user_id );
		echo json_encode( $records );
		
	}
	
	public function form( $service_id= NULL )
	{
		$data[ 'content' ] = 'service/form';
		$data[ 'service' ]	=	array();
		if( $service_id != NULL )
		{
			$data[ 'service' ]	=	$this->Service_model->get_service_single( $service_id );
		}

		//echo '<pre>';print_r($data[ 'portfolio' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'service/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function update( )
	{
		
		$data[ 'service_name' ]	=	$this->input->post( 'service_name' );
		$data[ 'service_rate' ]	=	$this->input->post( 'service_rate' );
		
		$data[ 'service_status' ]	=	$this->input->post( 'service_status' ) ? $this->input->post( 'service_status' ) : commonStatus::HOLD;
		
		
		
		$service_id	=	$this->input->post( 'service_id' );
		$file_name = substr( url_title($data[ 'service_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'service_image';
		$upload_path = 'assets/uploads/service/';
		//echo '<pre>';print_r($_FILES);exit;
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
		}

		
		
		
		$this->db->trans_begin();
		if( $service_id == NULL )
		{
			$data[ 'service_join_date' ]	=	$this->dbnow;	
			$data[ 'service_update_date' ]	=	$this->dbnow;	
			$service_id	=	$this->Service_model->add( $data );
		}
		else
		{
			$where[ 'service_id' ]	=	$service_id;
			$data[ 'service_update_date' ]	=	$this->dbnow;
			$this->Service_model->update( $data , $where );
		}

		

		
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		else
		{
			$this->db->trans_commit();
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Service list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/service/admin_service/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'service_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Service_model->update( $data , $where ) )
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
	
	private function remove_client( $id )
	{
		$portfolio	=	$this->Service_model->get( $id );
		if( trim( $portfolio[ 'service_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'service_image' ] );
		}
		
		return $this->Service_model->delete( $id );
		
	}
	
	
	public function remove( $service_id )
	{
		//$service_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $service_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Client Deleted .</span>';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		
		echo json_encode($msg);
	}
	
	public function delete_multiple()
	{
		$service_id	=	$this->input->post( 'id' );
		
		foreach( $service_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Portfolio Deleted .</span>';
		
		echo json_encode($msg);
	}
	public function get_tags()
	{ 
		$this->load->model('Tag_model');
		$tags=$this->Tag_model->get_tags();
		return json_encode($tags);

	}


	
	
	
}