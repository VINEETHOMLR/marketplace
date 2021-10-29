<?php
class Healths extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Health_model' ) );
    }
	
	public function list_json()
	{
		$health_status	=	$this->input->post( 'health_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Health_model->get_list(  $health_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Health_model->get_count(  $health_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	public function dropdown()
	{
		//return $this->Health_model->get_list();
		return  $this->Health_model->dropdown();
	}
	public function dropdown1()
	{
		return $this->Health_model->get_list();
	}	
	public function dropdown_public()
	{
		$cats =  $this->Health_model->get_list();
		$dropdown =array();
		foreach ($cats  as $key => $v) {
			$dropdown[ $v[ 'health_id' ] ] = $v[ 'health_name' ];
		}
		//echo "pre" print_r($dropdown); exit;
		return $dropdown;
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		$sub_dropdown =  $this->Health_model->sub_dropdown();
		$result = array();
		foreach ($sub_dropdown as $key => $value) {
			$result[ $value['health_id'] ][] = $value;
		}

		//echo '<pre>';print_r($result);exit;
		return $result;
	}	
		
}