<?php
class Admin_astrologer extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			Modules::run( 'login/check_authority' ,array( 'is_admin' ) );
			$this->load->model( 'Admin_astrologer_model' );
			$this->load->config( 'enums_extra' );
		}
		
		public function astrologer_card( $astrologer )
		{
			$data[ 'astrologer' ]	=	$astrologer;
			return $this->load->view( 'user/card' , $data , TRUE );
		}
		
		
		public function list_json()
		{
			$limit	=	$this->input->post( 'limit' );
			$offset	=	$this->input->post( 'offset' );
			$service_status	=	$this->input->post( 'service_status' );
			$date_from	=	$this->input->post( 'date_from' );
			$date_to	=	$this->input->post( 'date_to' );
			
			$user_id	=	NULL;
			if( ! Modules::run( 'login/is_admin' ) )
			{
				$user_id = $this->user[ 'id' ];
			}
			
			$rows	=	$this->Admin_astrologer_model->get_list(  $service_status ,  $limit ,  $offset  ,  $date_from ,  $date_to , $user_id  );
			$records[ 'rows' ]	=	$rows;
			$records[ 'total' ]	=	$this->Admin_astrologer_model->get_count(  $service_status ,  $date_from ,  $date_to , $user_id  );
			echo json_encode( $records );
			
		}
		
		
		
		public function about( $astrologer_id )
		{
			$this->load->model( array( 'astrologer/Astrologer_education_model' ) );
			$where[ 'user_id' ]	=	$astrologer_id;
			$data[ 'education' ]	=	$this->Astrologer_education_model->get_many( $where );
			$data[ 'astrologer' ]	=	$this->Admin_astrologer_model->get( $astrologer_id );
			return $this->load->view( 'astrologer/about' , $data , TRUE );
		}	
		
		public function proofs( $astrologer_id )
		{
			$this->load->model( array( 'astrologer/Astrologer_proof_model' ) );
			$data[ 'proofs' ]	=	$this->process_proofs($this->Astrologer_proof_model->get_many( array( 'user_id' => $astrologer_id ) ));
			return $this->load->view( 'astrologer/proofs' , $data , TRUE );
		}	
		
		private function process_proofs( $proofs )
		{
			$astrologer_proofs	=	$this->config->item('astrologer_proofs');
			$proccessed	=	array();
			foreach( $proofs as $v )
			{
				$proccessed[ $v[ 'proof_ref_id' ] ]	=	$v;
				$proccessed[ $v[ 'proof_ref_id' ] ][ 'proof_text' ]	=	$astrologer_proofs[ array_search($v[ 'proof_ref_id' ], array_column($astrologer_proofs, 'proof_ref_id')) ][ 'proof_text' ];
			}
			
			return $proccessed;
		}
			
}
