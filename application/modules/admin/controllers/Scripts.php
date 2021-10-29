<?php
class Scripts extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
    }

	public function index()
	{
		$this->load->model( 'pages/Scripts_model' );
		$data[ 'script' ]	= $this->Scripts_model->get( 1 );

		$data[ 'content' ]	=	'scripts';
		//echo '<pre>';print_r($data);exit;
		$this->load->view( 'admin/page' , $data );
	}
		
	public function update()
	{
		$this->load->model( 'pages/Scripts_model' );
		$data[ 'script' ]	= base64_url_encode( $this->input->post( 'script' ) );
		
		$data[ 'headerscript' ]	= base64_url_encode( $this->input->post( 'headerscript' ) );
		$data[ 'script_status' ]	= ( $this->input->post( 'script_status' ) );
		$where[ 'script_id' ]	=	1;
		$this->Scripts_model->update( $data , $where );
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Success</span>';
		echo json_encode($msg);
	}
		
	
	
}