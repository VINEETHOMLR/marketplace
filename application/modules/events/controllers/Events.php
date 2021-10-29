<?php
class Events extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Events_model' ) );
    }
	
	public function form( $blog_id= NULL )
	{
		$data[ 'content' ] = 'admin/form';
		$data[ 'blog' ]	=	array();
		if( $blog_id != NULL )
		{
			$data[ 'blog' ]	=	$this->Events_model->get_blog( $blog_id );
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
			'table' => 'mv_events',
			'id' => 'blog_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $blog_id );
	}
	
	public function update( )
	{
		//echo '<pre>';print_r( $_FILES );exit;
		$data[ 'blog_name' ]	=	$this->input->post( 'blog_name' );
		$data[ 'blog_description' ]	=	$this->input->post( 'blog_description' );
		//echo '<pre>';print_r($data[ 'blog_description' ]);exit;
		$data[ 'blog_time' ]	=	$this->input->post( 'blog_time' );
		$data[ 'blog_location' ]	=	$this->input->post( 'blog_location' );
		$data[ 'blog_status' ]	=	$this->input->post( 'blog_status' ) ? $this->input->post( 'blog_status' ) : blogStatus::HOLD;
		$data[ 'user_id' ]	=	$this->user[ 'id' ];
		//$blog_tags	=	explode( ',' , $this->input->post( 'blog_tags' ) );
		$blog_id	=	$this->input->post( 'blog_id' );
		$data[ 'blog_uri' ]	=	$this->get_uri( $data[ 'blog_name' ] , $blog_id );
		
		
		$file_name = substr( url_title($data[ 'blog_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'blog_image';
		$upload_path = 'assets/uploads/blog/';
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
		if( $blog_id == NULL )
		{
			$data[ 'blog_join_date' ]	=	$this->dbnow;	
			$blog_id	=	$this->Events_model->add( $data );
		}
		else
		{
			$where[ 'blog_id' ]	=	$blog_id;
			$this->Events_model->update( $data , $where );
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
			$msg['msg']		=	'<span class="text-success">Events list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'events/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'blog_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Events_model->update( $data , $where ) )
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
	
	private function remove_blog( $id )
	{
		$blog	=	$this->Events_model->get( $id );
		if( trim( $blog[ 'blog_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/blog/'.$blog[ 'blog_image' ] );
		}
		
		return $this->Events_model->delete( $id );
		
	}
	
	
	public function remove( $blog_id )
	{
		//$blog_id	=	$this->input->post( 'id' );
		if( $this->remove_blog( $blog_id ) )
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
	
	public function list_json( )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$blog_status	=	$this->input->post( 'blog_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$blog_search	=	$this->input->post( 'blog_description' );
		
		$records[ 'rows' ]	=	$this->Events_model->get_list(  $blog_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $blog_search );
		$records[ 'total' ]	=	$this->Events_model->get_count(  $blog_status ,  $date_from ,  $date_to  , $blog_search   );
		echo json_encode( $records );
		
	}
	
}