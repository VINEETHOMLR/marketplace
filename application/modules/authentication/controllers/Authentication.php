<?php
class Authentication extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Authentication_model' ) );
    }
	
	public function form( $authentication_id= NULL )
	{
		$data[ 'content' ] = 'admin/form';
		$data[ 'authentication' ]	=	array();
		if( $authentication_id != NULL )
		{
			$data[ 'authentication' ]	=	$this->Authentication_model->get( $authentication_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'admin/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	private function get_uri( $title , $blog_id = NULL )
	{
		$config = array(
			'field' => 'blog_uri',
			'table' => 'mv_blogs',
			'id' => 'blog_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $blog_id );
	}
	
	public function update( )
	{
		//echo $this->input->post('tags');die();
		//echo '<pre>';print_r( $_FILES );exit;
		$data[ 'authentication_key' ]	=	$this->input->post( 'authentication_key' );
		$authentication_id	=	$this->input->post( 'authentication_id' );
		$data[ 'authentication_status' ]=CommonStatus::ACTIVE;	
		
		$this->db->trans_begin();
		if( $authentication_id == NULL )
		{
			$data[ 'date_of_join' ]	=	$this->dbnow;	
			$authentication_id	=	$this->Authentication_model->add( $data );
		}
		else
		{
			$where[ 'authentication_id' ]	=	$authentication_id;
			$this->Authentication_model->update( $data , $where );
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
			$msg['msg']		=	'<span class="text-success">Key successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/manage-authentication';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'authentication_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Authentication_model->update( $data , $where ) )
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
	
	private function remove_authentication( $id )
	{
		$authentication	=	$this->Authentication_model->get( $id );
		
		
		return $this->Authentication_model->delete( $id );
		
	}
	
	
	public function remove( $authentication_id )
	{
		//$blog_id	=	$this->input->post( 'id' );
		if( $this->remove_authentication( $authentication_id ) )
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
		$blog_id	=	$this->input->post( 'id' );
		
		foreach( $blog_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
		
		echo json_encode($msg);
	}

	public function get_tags()
	{ 
		$this->load->model('Tag_model');
		$tags=$this->Tag_model->get_tags();
		return json_encode($tags);

	}
	
	
	
}