<?php
class Admin extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			//Modules::run( 'login/check_authority' ,array( 'is_admin' ) );
			
		}
		
		public function index()
		{
			redirect( $this->base.'product/admin_product/manage' );
		}
		
		
}
