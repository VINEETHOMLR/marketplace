<?php
class Admin_pages extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
		$this->load->model( array( 'Pages_model' ) );
    }
	
	public function form( $page_id= NULL )
	{
		$data[ 'content' ] = 'admin/form';
		$data[ 'page' ]	=	array();
		if( $page_id != NULL )
		{
			$data[ 'page' ]	=	$this->Pages_model->get( $page_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	public function list_json()
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$page_status	=	$this->input->post( 'page_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		
		$records[ 'rows' ]	=	$this->Pages_model->get_list(  $page_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  );
		$records[ 'total' ]	=	$this->Pages_model->get_count(  $page_status ,  $date_from ,  $date_to  );
		echo json_encode( $records );
		
	}
	
	public function manage()
	{

		$data[ 'content' ] = 'admin/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function update( )
	{
		
		$data[ 'page_name' ]	=	$this->input->post( 'page_name' );
		$data[ 'page_cms' ]	=	$this->input->post( 'page_cms' );
		//$data[ 'link' ]	=	$this->input->post( 'link' );
		$data[ 'page_breadcrumb' ]	=	$this->input->post( 'page_breadcrumb' );
		$data[ 'page_cms2' ]	=	$this->input->post( 'page_cms2' );
		$file_name	=	$data[ 'page_name' ];
		$uploaded	=false;
		$image_identiy	=	'page_image';
		$upload_path = 'assets/uploads/pages/';
		//echo '<pre>';print_r($_FILES);exit;
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
		}
		
		$page_id	=	$this->input->post( 'page_id' );
		$res	=	FALSE;
		if( $page_id == NULL )
		{
			$res	=	$this->Pages_model->add( $data );
		}
		else
		{
			$where[ 'page_id' ]	=	$page_id;
			$res	=	$this->Pages_model->update( $data , $where );
		}
		
		if( $res )
		{
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Category list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'pages/admin_pages/manage';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{


		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'page_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		$record_id	=	$this->input->post( 'id' );
		$record_status	=	$this->input->post( 'status' );
		
		
		 //echo "test";exit;


		if( $this->Pages_model->update( $data , $where ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Status changed .</span>';
			
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		
		echo json_encode($msg);
	}
	
	
	public function delete()
	{
		$page_id	=	$this->input->post( 'id' );
		if( $this->Pages_model->delete( $page_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
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
		$page_id	=	$this->input->post( 'id' );
		
		if( $this->Pages_model->delete_many( 'page_id' , $page_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		
		echo json_encode($msg);
	}
	
	public function scripts()
	{
		$this->load->model( 'Scripts_model' );
		$data[ 'script' ]	= $this->Scripts_model->get( 1 );
		$data[ 'content' ]	=	'admin/scripts';
		//echo '<pre>';print_r($data);exit;
		$this->load->view( 'admin/index' , $data );
	}
		
	public function update_script()
	{
		$this->load->model( 'Scripts_model' );
		$data[ 'script' ]	= base64_encode( $this->input->post( 'script' ) );
		$data[ 'script_status' ]	= ( $this->input->post( 'script_status' ) );
		$where[ 'script_id' ]	=	1;
		$this->Scripts_model->update( $data , $where );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success</span>';
		echo json_encode($msg);
	}
		
	
	
}
?>