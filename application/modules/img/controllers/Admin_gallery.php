<?php
class Admin_gallery extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Gallery_model' ) );
    }
	
	
	public function form( $gallery_id= NULL )
	{
		$data[ 'content' ] = 'gallery/form';
		$data[ 'gallery' ]	=	array();
		if( $gallery_id != NULL )
		{
			$data[ 'gallery' ]	=	$this->Gallery_model->get( $gallery_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	public function manage()
	{
		$data[ 'content' ]	=	'gallery/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $gallery_id )
	{
		Modules::run( 'img/clear' , $gallery_id ,  imageType::GALLERY  );
		Modules::run('video/admin_video/clear' , videoType::GALLERY , $gallery_id);
		$where[ 'gallery_id' ]  = $gallery_id;
		$this->Gallery_model->delete( $where );
	}
	
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'gallery_uri',
			'table' => 'mv_gallery',
			'id' => 'gallery_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	
	public function update()
	{
		$data[ 'gallery_name' ]	=	$this->input->post( 'gallery_name' );
		$gallery_id	=	$this->input->post( 'gallery_id' );
		$data[ 'gallery_uri' ]	=	$this->get_uri( $data[ 'gallery_name' ] , $gallery_id );
		$this->db->trans_begin();
		if( $gallery_id == NULL )
		{
			$data[ 'gallery_join_date' ]	=	$this->dbnow;	
			$gallery_id	=	$this->Gallery_model->add( $data );
			$message = "New category added !";
		}
		else
		{
			$where[ 'gallery_id' ]	=	$gallery_id;
			$this->Gallery_model->update( $data , $where );
			$message = "Category updated !";
		}
		Modules::run( 'img/update' , $gallery_id ,  imageType::GALLERY  );

		Modules::run( 'video/admin_video/update' , videoType::GALLERY , $gallery_id , $this->input->post( 'videos' ));
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
			$msg['msg']		=	$message;
			$msg['red']		=	$this->base.'img/admin_gallery/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'gallery_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Gallery_model->update( $data , $where ) )
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