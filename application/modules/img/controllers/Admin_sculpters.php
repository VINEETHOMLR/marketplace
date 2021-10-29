<?php
class Admin_sculpters extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
    }
	
	
	public function form()
	{
		$data[ 'content' ] = 'sculpters/form';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function manage()
	{
		$data[ 'content' ]	=	'admin/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $gallery_id )
	{
		Modules::run( 'img/clear' , $gallery_id ,  imageType::SCULPTERS  );
		$where[ 'gallery_id' ]  = $gallery_id;
		$this->Gallery_model->delete( $where );
	}
	
	public function update()
	{
		
		Modules::run( 'img/update' , 0 ,  imageType::SCULPTERS  );
		
		$msg['res']		=	1;
		$msg['msg']		=	'Logos updated.';
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'gallery_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Gallery_model->update( $data , $where ) )
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