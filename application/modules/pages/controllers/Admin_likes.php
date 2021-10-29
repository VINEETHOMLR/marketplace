<?php
class Admin_likes extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
		$this->load->model( array( 'Admin_likes_model' ) );
    }
	
	public function list_json()
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		
		$search	=	$this->input->post( 'search' );
		
		$user_id	=	NULL;
		
		
		
		$records[ 'rows' ]	=	$this->Admin_likes_model->get_list(   $limit ,  $offset  ,  $date_from ,  $date_to ,  $search  );
		$records[ 'total' ]	=	$this->Admin_likes_model->get_count(  $date_from ,  $date_to  ,  $search   );
		echo json_encode( $records );

		
	}
	
	public function manage()
	{
		$data[ 'content' ] = 'admin/like/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'image_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Admin_likes_model->update( $data , $where ) )
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
	
	private function remove_image( $id )
	{
		$image	=	$this->Admin_likes_model->get( $id );
		if( trim( $image[ 'image_name' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/post/orginal/'.$image[ 'image_name' ] );
			$this->delete_file( 'assets/uploads/post/resized/'.$image[ 'image_name' ] );
		}
		
		return $this->Admin_likes_model->delete( $id );
	}
	
	
	public function delete($image_id )
	{
		//$image_id	=	$this->input->post( 'id' );
		if( $this->remove_image( $image_id ) )
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
		$image_id	=	$this->input->post( 'id' );
		
		foreach( $image_id as $id )
		{
			$this->remove_image( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
		
		echo json_encode($msg);
	}
	
	
	
	
}