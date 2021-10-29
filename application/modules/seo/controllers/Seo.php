<?php
class Seo extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			Modules::run( 'login/check_authority' , array( 'is_admin' ) );
			$this->load->model( array( 'Seo_model' ) );
		}
		
		public function form_modal()
		{
			$this->load->view( 'form_modal' );
		}
		
		public function update()
		{
			$data[ 'content_type' ]	=	$this->input->post( 'content_type' );
			$data[ 'content_ref_id' ]	=	$this->input->post( 'content_ref_id' );
			$data[ 'seo_title' ]	=	$this->input->post( 'seo_title' );
			$data[ 'seo_keywords' ]	=	$this->input->post( 'seo_keywords' );
			$data[ 'seo_description' ]	=	$this->input->post( 'seo_description' );
			
			$where[ 'content_type' ] = $data[ 'content_type' ];
			$where[ 'content_ref_id' ] = $data[ 'content_ref_id' ];
			
			if( ! $this->Seo_model->get( $where ) )
			{
				$data[ 'seo_status' ]	=	CommonStatus::ACTIVE;
				$data[ 'seo_id' ]	=	$this->Seo_model->add( $data );
			}
			else
			{
				$this->Seo_model->update( $data , $where );
			}
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$msg['res']		=	2;
				$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
				
			}
			else
			{
				$this->db->trans_commit();
				$msg['res']		=	1;
				$msg['msg']		=	'<span class="text-success"> Seo updated successfully !</span>';
				
			}
			$msg[ 'record' ]	=	$data;
			echo json_encode( $msg );
		
		}
		
		public function change_status( )
		{
			$record_id	=	$this->input->post( 'pk' );
			$record_status	=	$this->input->post( 'value' );
			$field	=	$this->input->post( 'name' );
			$where[ 'seo_id' ]	=	$record_id;
			$data[ $field ]	=	$record_status;
			if( $this->Seo_model->update( $data , $where ) )
			{
				$msg['res']		=	1;
				$msg['msg']		=	'Status changed .';
				
			}
			else
			{
				$msg['res']		=	2;
				$msg['msg']		=	'Something went wrong Please try again.';
			}
			
			echo json_encode($msg);
		}

		
		
		
		
		
}