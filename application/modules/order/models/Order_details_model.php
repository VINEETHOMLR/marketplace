<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_details_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_order_details';
		$this->primary_key	=	'order_details_id';
		$this->primary_column	=	'order_id';
	}
	
	public function get_list( $category_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$category_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($category_status != NULL )
		{
	   		$this->db->where( 'category.category_status' ,$category_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'category.user_id' , $user_id );
	    }
		
		if($category_search != NULL )
		{
	   		$this->db->like( 'category.category_name' ,$category_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("category.category_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" category.*  " )
		
		->order_by('category.category_id DESC')
		->group_by( 'category.category_id' )
		->get( $this->_table.' category ' )
		->result_array();
	}
	
	public function get_count( $category_status = NULL   , $date_from =NULL , $date_to = NULL  ,$category_search = NULL  , $user_id = NULL )
	{
		
		
		if($category_status != NULL )
		{
	   		$this->db->where( 'category.category_status' ,$category_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'category.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("category.category_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($category_search != NULL )
		{
	   		$this->db->like( 'category.category_name' ,$category_search );
	    }
		
		return $this->db->select(" category.*  " )
		->order_by('category.category_id DESC')
		->group_by( 'category.category_id' )
		->get($this->_table.' category ')
		->num_rows();
	}
	public function get_category_single($category_id,$status = NULL)
	{
		if($status) {
            $this->db->where( 'category.category_status' ,$status );
		}
		return $this->db
		->select( "category.* " )
		
		->where( 'category.category_id' ,$category_id )
		->get( $this->_table.' category' )
		->row_array();
	}
	
	
	

	function getOrderDetails($orderId,$product_id=''){
		

		if( $orderId != NULL )
		{
	   		$this->db->where( 'orderDetails.order_id' , $orderId );
	    }
	    if( $product_id != NULL )
		{
	   		$this->db->where( 'orderDetails.product_id' , $product_id );
	    }

        return $this->db
		->select( "orderDetails.* " )
		
		//->where( 'orderDetails.category_status' ,1)
		->get( $this->_table.' orderDetails' )
		->result_array();
	}


	function orderDetails($order_details_id=''){
        
        if( $order_details_id != NULL )
		{
	   		$this->db->where( 'orderDetails.order_details_id' , $order_details_id );
	    }
        return $this->db
		->select( "orderDetails.* " )
		
		//->where( 'orderDetails.category_status' ,1)
		->get( $this->_table.' orderDetails' )
		->row_array();
	}


	
       
}
