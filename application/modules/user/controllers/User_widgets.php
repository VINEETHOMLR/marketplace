<?php
class User_widgets extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->posted=$this->input->post(NULL, TRUE);
			Modules::run('login/check_authority' , array( 'is_user' , 'is_astrologer' ));
			$this->load->model('User_model');
		}
		
		public function left_menu()
		{
			$this->load->view( 'widgets/left_menu' );
		}
		
}