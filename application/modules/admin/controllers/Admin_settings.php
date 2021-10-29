<?php
class Admin_settings extends MX_Controller 
{

		public function __construct()
		{
			parent::__construct();
			Modules::run( 'login/check_authority' , array( 'is_admin' ) );
			$this->load->model( array( 'pages/Settings_model' ) );
		}
		
		public function index(  )
		{
			$data[ 'settings' ]	=	$this->Settings_model->get( 1 );
			
			$data[ 'content' ]	=	'settings/form';
			$this->load->view( 'admin/page' , $data );
			
			
		}
		
		
		public function update()
		{
			$where[ 'settings_id' ]	=	1;
			$data[ 'api_key' ]	=	$this->input->post( 'api_key' );
			
			
			$this->Settings_model->update( $data , $where );
			
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Settings updated .</span>';
			$this->session->set_flashdata('msg', $msg );
			echo json_encode( $msg );
			
			
		}
		
		
		
}