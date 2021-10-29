<?php
class Cinemas extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Cinema_model' ) );
    }
	
	public function list_json()
	{
		$cinema_status	=	$this->input->post( 'cinema_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Cinema_model->get_list(  $cinema_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Cinema_model->get_count(  $cinema_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	public function dropdown()
	{
		//return $this->Cinema_model->get_list();
		return  $this->Cinema_model->dropdown();
	}
	public function dropdown1()
	{
		return $this->Cinema_model->get_list();
	}	
	public function dropdown_public()
	{
		$cats =  $this->Cinema_model->get_list();
		$dropdown =array();
		foreach ($cats  as $key => $v) {
			$dropdown[ $v[ 'cinema_id' ] ] = $v[ 'cinema_name' ];
		}
		//echo "pre" print_r($dropdown); exit;
		return $dropdown;
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		$sub_dropdown =  $this->Cinema_model->sub_dropdown();
		$result = array();
		foreach ($sub_dropdown as $key => $value) {
			$result[ $value['cinema_id'] ][] = $value;
		}

		//echo '<pre>';print_r($result);exit;
		return $result;
	}	
		
}