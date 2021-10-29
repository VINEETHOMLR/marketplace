<?php
class Admin_astrologer_testbookings extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			Modules::run( 'login/check_authority' ,array( 'is_admin' ) );
			$this->load->model( 'Admin_astrologer_model' );
			$this->load->config( 'enums_extra' );
		}
		
		public function manage()
		{
			$data[ 'content' ] = 'astrologer/table/testbookings';
			$this->load->view( 'admin/index' , $data );
		}
		
		public function list_json()
		{
			$limit	=	$this->input->post( 'limit' );
			$offset	=	$this->input->post( 'offset' );
			$service_status	=	$this->input->post( 'service_status' );
			$astrologer_search	=	$this->input->post( 'astrologer_search' );
			$date_from	=	$this->input->post( 'date_from' );
			$date_to	=	$this->input->post( 'date_to' );
			
			$user_id	=	NULL;
			if( ! Modules::run( 'login/is_admin' ) )
			{
				$user_id = $this->user[ 'id' ];
			}
			
			$rows	=	$this->Admin_astrologer_model->get_list(  $service_status ,  $limit ,  $offset  ,  $date_from ,  $date_to , $astrologer_search  );
			$records[ 'rows' ]	=	array();
			foreach( $rows as $v )
			{
				$astrologer_id	=	$v[ 'user_id' ];
				$v[ 'astrologer_card' ]	=	Modules::run( 'admin/admin_astrologer/astrologer_card' , $v );
				$v[ 'astrologer_about' ]=	Modules::run( 'admin/admin_astrologer/about' , $astrologer_id );
				$records[ 'rows' ][]	=	$v;
			}
			
			$records[ 'total' ]	=	$this->Admin_astrologer_model->get_count(  $service_status ,  $date_from ,  $date_to , $astrologer_search  );
			echo json_encode( $records );
			
		}
		
		
			
}
