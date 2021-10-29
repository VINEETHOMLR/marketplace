<?php
class Newspapers extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Newspaper_model' ) );
    }
	
	public function list_json()
	{
		$newspaper_status	=	$this->input->post( 'newspaper_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Newspaper_model->get_list(  $newspaper_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Newspaper_model->get_count(  $newspaper_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	public function dropdown()
	{
		//return $this->Newspaper_model->get_list();
		return  $this->Newspaper_model->dropdown();
	}
	public function dropdown1()
	{
		return $this->Newspaper_model->get_list();
	}	
	public function dropdown_public()
	{
		$cats =  $this->Newspaper_model->get_list();
		$dropdown =array();
		foreach ($cats  as $key => $v) {
			$dropdown[ $v[ 'newspaper_id' ] ] = $v[ 'newspaper_name' ];
		}
		//echo "pre" print_r($dropdown); exit;
		return $dropdown;
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		$sub_dropdown =  $this->Newspaper_model->sub_dropdown();
		$result = array();
		foreach ($sub_dropdown as $key => $value) {
			$result[ $value['newspaper_id'] ][] = $value;
		}

		//echo '<pre>';print_r($result);exit;
		return $result;
	}	
		
}