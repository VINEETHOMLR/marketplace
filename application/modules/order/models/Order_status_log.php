<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_status_log extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'order_status_log';
		$this->primary_key	=	'log_id';
		$this->primary_column	=	'order_id';
	}
	
	public function get_list( $order_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$order_search = NULL , $user_id = NULL ,$store_id = NULL)
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($order_status != NULL )
		{
	   		$this->db->where( 'order.order_status' ,$order_status );
	    }

	    if($store_id != NULL )
		{
	   		$this->db->where( 'order.store_id' ,$store_id );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'order.user_id' , $user_id );
	    }
		
		if($order_search != NULL )
		{
	   		$this->db->like( 'order.order_id' ,$order_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("order.order_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" order.*  " )
		
		->order_by('order.order_id DESC')
		->group_by( 'order.order_id' )
		->get( $this->_table.' order ' )
		->result_array();
	}
	
	public function get_count( $order_status = NULL   , $date_from =NULL , $date_to = NULL  ,$order_search = NULL  , $user_id = NULL ,$store_id = NULL)
	{
		
		
		if($order_status != NULL )
		{
	   		$this->db->where( 'order.order_status' ,$order_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'order.user_id' , $user_id );
	    }
	    if($store_id != NULL )
		{
	   		$this->db->where( 'order.store_id' ,$store_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("order.order_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($order_search != NULL )
		{
	   		$this->db->like( 'order.order_id' ,$order_search );
	    }
		
		return $this->db->select(" order.*  " )
		->order_by('order.order_id DESC')
		->group_by( 'order.order_id' )
		->get($this->_table.' order ')
		->num_rows();
	}
	function getOrderList($status,$userId,$storeId){

		if(!empty($status)) {

            $this->db->where_in( 'order.order_status' ,$status );
		}
		if(!empty($storeId)) {

            $this->db->where( 'order.store_id' ,$storeId );
		}


		

		return $this->db->select(" order.*  " )
		
		->order_by('order.order_id DESC')
		->where( 'order.customer_id',$userId )
		->get( $this->_table.' order ' )
		->result_array();

	}


	public function getorderstores($user_id)
	{
		if( $user_id != NULL )
		{
	   		$this->db->where( 'order.customer_id' , $user_id );
	    }
		return $this->db->select("DISTINCT(order.store_id),store.store_name,store.store_logo" )
		->join('mv_store store','order.store_id=store.store_id')
		->where('store.store_status','1')
		//->order_by('cart.cart_id DESC')
		//->group_by( 'cart.cart_store_id' )
		->get( $this->_table.' order ' )
		->result_array();
	}



	function get_order_single($order_id){

		

		return $this->db->select(" order.*,customer.*" )
		
		->join('mv_customer customer','order.customer_id=customer.customer_id')
		->where( 'order.order_id',$order_id )
		->get( $this->_table.' order ' )
		->row_array();

	}


	function getOrderLogSingle($order_id,$status)
	{

        if(!empty($status)) {
            $this->db->where('orderlog.status',$status);
        }
		return $this->db->select(" orderlog.*" )
		
		->where( 'orderlog.order_id',$order_id )
		->get( $this->_table.' orderlog ' )
		->row_array();

	}





	
       
}
