<?php
class Foodcategories extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->model( array( 'Foodcategory_model' ) );
    }
	
	public function list_json()
	{
		$category_status	=	$this->input->post( 'category_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Foodcategory_model->get_list(  $category_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Foodcategory_model->get_count(  $category_status , $date_from   , $date_to );
		echo json_encode( $data );
	}
	
	public function dropdown()
	{
		//return $this->Foodcategory_model->get_list();
		return  $this->Foodcategory_model->dropdown();
	}
	public function dropdown1()
	{
		return $this->Foodcategory_model->get_list();
	}	
	public function dropdown_public()
	{
		$cats =  $this->Foodcategory_model->get_list();
		$dropdown =array();
		foreach ($cats  as $key => $v) {
			$dropdown[ $v[ 'category_id' ] ] = $v[ 'category_name' ];
		}
		//echo "pre" print_r($dropdown); exit;
		return $dropdown;
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		$sub_dropdown =  $this->Foodcategory_model->sub_dropdown();
		$result = array();
		foreach ($sub_dropdown as $key => $value) {
			$result[ $value['category_id'] ][] = $value;
		}

		//echo '<pre>';print_r($result);exit;
		return $result;
	}	
		
}