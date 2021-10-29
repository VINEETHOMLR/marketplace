<?php
class Pages_dynamic extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( 'Pages_model' );
    }

    public function display( $id )
    {
    	$page = $this->Pages_model->get( $id );
        $data[ 'meta' ] =   Modules::run( 'seo/meta/get_tags' , array() , $id  , ContentTypes::PAGE );
    	$data[ 'page' ] = $page;
    	$data[ 'content' ] = 'page_dynamic';
    	$this->load->view( 'public/page' , $data );
    }

     public function popup( $id=16 )
    {
        $page = $this->Pages_model->get( $id );
       
        $data[ 'page' ] = $page;
        //$data[ 'content' ] = 'page_dynamic';
       // $this->load->view( 'public/page' , $data );

       
        $this->load->view( 'widgets/popup' , $data );
    }

     public function about( $id=4 )
    {
        $page = $this->Pages_model->get( $id );
       
        $data[ 'page' ] = $page;
        //$data[ 'content' ] = 'page_dynamic';
       // $this->load->view( 'public/page' , $data );

       
        $this->load->view( 'widgets/about' , $data );
    }
}