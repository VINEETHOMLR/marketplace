<?php
class Admin_washer extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Washer_model' ) );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$washer_status	=	$this->input->post( 'washer_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$washer_search	=	$this->input->post( 'search' );
		
		$records[ 'rows' ]	=	$this->Washer_model->get_list(  $washer_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $washer_search , $user_id );
		$records[ 'total' ]	=	$this->Washer_model->get_count(  $washer_status ,  $date_from ,  $date_to  , $washer_search , $user_id );
		echo json_encode( $records );
		
	}
	
	public function form( $washer_id= NULL )
	{

		$data[ 'content' ] = 'washer/form';
		$data[ 'washer' ]	=	array();
		if( $washer_id != NULL )
		{
			$data[ 'washer' ]	=	$this->Washer_model->get_details( $washer_id );
			$data[ 'images' ]	=	$this->Washer_model->get_images( $washer_id );
		}

	
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'washer/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function update( )
	{
		
		$washer_id =$this->input->post('washer_id');
		$data[ 'washer_status' ]	=	commonStatus::ACTIVE;
		
		

		
		
		
		$this->db->trans_begin();
		if( $washer_id == NULL )
		{
			$data[ 'washer_join_date' ]	=	$this->dbnow;	
			$data[ 'washer_update_date' ]	=	$this->dbnow;	
			$washer_id	=	$this->Washer_model->add( $data );
		}
		else
		{
			$where[ 'washer_id' ]	=	$washer_id;
			$data[ 'washer_approved_date' ]	=	$this->dbnow;
			$data[ 'washer_approved_admin' ]	=	$this->user['id'];

			
			$this->Washer_model->update( $data , $where );
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
			$msg[ 'red' ]	=	$this->base.'/washer/admin_washer/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'washer_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Washer_model->update( $data , $where ) )
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
		$portfolio	=	$this->Washer_model->get( $id );
		if( trim( $portfolio[ 'washer_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'washer_image' ] );
		}
		
		return $this->Washer_model->delete( $id );
		
	}
	
	
	public function remove( $washer_id )
	{
		//$washer_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $washer_id ) )
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
		$washer_id	=	$this->input->post( 'id' );
		
		foreach( $washer_id as $id )
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