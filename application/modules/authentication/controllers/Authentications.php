<?php
class Authentications extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Authentication_model' ) );
    }
	
	public function single( $blog_id )
	{
		$this->load->model( 'seo/Seo_model' );
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , $this->Seo_model->get_seo( $blog_id , ContentTypes::BLOG ) , 1 );
		$data[ 'blog' ]	=	$this->Blog_model->get_blog( $blog_id );
		//echo '<pre>';print_r($data[ 'meta' ]);exit;
		$data[ 'recent' ]	=	$this->Blog_model->get_list( CommonStatus::ACTIVE , 5 );
		$data[ 'content' ]	=	'single';
		$this->load->view( 'user/page' , $data );
	}
	
	public function multiple()
	{
		$this->load->model( 'seo/Seo_model' );
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , $this->Seo_model->get_seo( 3 , ContentTypes::PAGE ) , ContentTypes::PAGE );
		$data[ 'blogs' ]	=	$this->Blog_model->get_list( CommonStatus::ACTIVE );
		$data[ 'content' ]	=	'multiple';
		$this->load->view( 'user/page' , $data );
	}
	
	public function react()
	{
		$data[ 'content' ]	=	'react';
		$this->load->view( 'public/page' , $data );
	}
	
	public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$authentication_status	=	$this->input->post( 'authentication_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$authentication_search	=	$this->input->post( 'authentication_description' );
		
		$records[ 'rows' ]	=	$this->Authentication_model->get_list(  $authentication_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $authentication_search , $user_id );
		$records[ 'total' ]	=	$this->Authentication_model->get_count(  $authentication_status ,  $date_from ,  $date_to  , $authentication_search , $user_id );
		echo json_encode( $records );
		
	}
	
	
}