<?php
class Admin_hash_tag extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
		$this->load->model( array( 'Admin_hash_tag_model' ) );
    }
	
	public function list_json()
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$hash_tag_status	=	$this->input->post( 'hash_tag_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		
		$search	=	$this->input->post( 'search' );
		
		$user_id	=	NULL;
		
		
		
		$records[ 'rows' ]	=	$this->Admin_hash_tag_model->get_list(  $hash_tag_status ,  $limit ,  $offset  ,  $date_from ,  $date_to ,  $search  );
		$records[ 'total' ]	=	$this->Admin_hash_tag_model->get_count(  $hash_tag_status ,  $date_from ,  $date_to  ,  $search   );
		echo json_encode( $records );
		
	}
	
	public function manage()
	{
		$data[ 'content' ] = 'admin/hashtag';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function update( )
	{
		
		$data[ 'hash_tags_title' ]	=	$this->input->post( 'hash_tags_title' );
		$data[ 'hash_tags_user_id' ]	=	$this->user['id'];
		
		
		
		
		$hash_tag_id	=	$this->input->post( 'id' );
		$res	=	FALSE;
		if( $hash_tag_id == NULL )
		{
			$data[ 'hash_tags_status' ]	=	CommonStatus::HOLD;
			$data['date_of_join']=$this->dbnow;
			$data['date_of_update']=$this->dbnow;
			$res	=	$this->Admin_hash_tag_model->add( $data );
		}
		else
		{
			$where[ 'hash_tags_id' ]	=	$hash_tag_id;
			$data['date_of_update']=$this->dbnow;
			$res	=	$this->Admin_hash_tag_model->update( $data , $where );
		}
		
		if( $res )
		{
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'Hash Tag updated';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again';
		}
		
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'hash_tags_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Admin_hash_tag_model->update( $data , $where ) )
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
	
	private function remove_hash_tag( $id )
	{
		$hash_tag	=	$this->Admin_hash_tag_model->get( $id );
		if( trim( $hash_tag[ 'hash_tag_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/category/'.$hash_tag[ 'hash_tag_image' ] );
		}
		
		return $this->Admin_hash_tag_model->delete( $id );
	}
	
	
	public function delete($hash_tag_id )
	{
		//$hash_tag_id	=	$this->input->post( 'id' );
		if( $this->remove_hash_tag( $hash_tag_id ) )
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
		$hash_tag_id	=	$this->input->post( 'id' );
		
		foreach( $hash_tag_id as $id )
		{
			$this->remove_hash_tag( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
		
		echo json_encode($msg);
	}

	
	
	
	
	
}