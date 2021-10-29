<?php
class Video extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( array( 'Video_model' ) );
	}
	
	
	public function list_json()
	{
		
		$video_status	=	$this->input->post( 'video_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$rows = $this->Video_model->get_list(   $video_status  );
		
		$data[ 'rows' ]	=	$rows;
		
		$data[ 'total' ] = $this->Video_model->get_count(  $video_status  );
		echo json_encode( $data );
	}
	
	public function videolist($video_ref_id= NULL , $video_content_type= NULL ,  $video_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL)
	{
		return $this->Video_model->get_list(   $video_ref_id , $video_content_type ,  $video_status , $limit  , $start , $date_from , $date_to    );
	}

	public function display($video_ref_id= NULL , $video_content_type= NULL ,  $video_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL)
	{
		$data[ 'videos' ] = $this->_list(   $video_ref_id , $video_content_type ,  $video_status , $limit  , $start , $date_from , $date_to    );
		$this->load->view( 'display' , $data );
	}
	
}