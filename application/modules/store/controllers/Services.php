<?php
class Clients extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Clients_model' ) );
    }
	
	public function single( $client_id )
	{
		$this->load->model( 'seo/Seo_model' );
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , $this->Seo_model->get_seo( $client_id , ContentTypes::BLOG ) , 1 );
		$data[ 'blog' ]	=	$this->Clients_model->get_blog( $client_id );
		//echo '<pre>';print_r($data[ 'meta' ]);exit;
		$data[ 'recent' ]	=	$this->Clients_model->get_list( CommonStatus::ACTIVE , 5 );
		$data[ 'content' ]	=	'single';
		$this->load->view( 'user/page' , $data );
	}
	
	public function multiple()
	{
		$this->load->model( 'seo/Seo_model' );
		$data[ 'meta' ]	=	Modules::run( 'seo/meta/get_tags' , $this->Seo_model->get_seo( 3 , ContentTypes::PAGE ) , ContentTypes::PAGE );
		$data[ 'blogs' ]	=	$this->Clients_model->get_list( CommonStatus::ACTIVE );
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
		$client_status	=	$this->input->post( 'client_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$client_search	=	$this->input->post( 'search' );
		
		$records[ 'rows' ]	=	$this->Clients_model->get_list(  $client_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $client_search , $user_id );
		$records[ 'total' ]	=	$this->Clients_model->get_count(  $client_status ,  $date_from ,  $date_to  , $client_search , $user_id );
		echo json_encode( $records );
		
	}
	
	
}