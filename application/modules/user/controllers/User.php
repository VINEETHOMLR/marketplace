<?php
class user extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->posted=$this->input->post(NULL, TRUE);
			$this->load->model( 'User_model' );
			
		}
		
		
		public function user_details_json( $user_id )
		{
			echo json_encode( $this->User_model->get( $user_id ) );
		}
		
		
}