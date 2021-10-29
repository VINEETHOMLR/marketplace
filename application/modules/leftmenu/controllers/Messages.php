<?php
class Messages extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Message_model' ) );
    }
	
	public function list_json()
	{
		$message_status	=	$this->input->post( 'message_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Message_model->get_list(  $message_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Message_model->get_count(  $message_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	public function dropdown()
	{
		//return $this->Message_model->get_list();
		return  $this->Message_model->dropdown();
	}
	public function dropdown1()
	{
		return $this->Message_model->get_list();
	}	
	public function dropdown_public()
	{
		$cats =  $this->Message_model->get_list();
		$dropdown =array();
		foreach ($cats  as $key => $v) {
			$dropdown[ $v[ 'message_id' ] ] = $v[ 'message_name' ];
		}
		//echo "pre" print_r($dropdown); exit;
		return $dropdown;
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		$sub_dropdown =  $this->Message_model->sub_dropdown();
		$result = array();
		foreach ($sub_dropdown as $key => $value) {
			$result[ $value['message_id'] ][] = $value;
		}

		//echo '<pre>';print_r($result);exit;
		return $result;
	}	
		
}