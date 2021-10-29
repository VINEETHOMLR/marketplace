<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_category_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_product_category';
		$this->primary_key	=	'product_category_id';
		$this->primary_column	=	'product_category_name';
	}
	
	public function get_list( $product_category_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$product_category_search = NULL , $user_id = NULL,$product_category_category=NULL,$parent_category = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($product_category_status != NULL )
		{
	   		$this->db->where( 'product_category.product_category_status' ,$product_category_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'product_category.user_id' , $user_id );
	    }

	    if( $parent_category != NULL )
		{
	   		$this->db->where( 'product_category.parent_category' , $parent_category );
	    }


		
		if($product_category_search != NULL )
		{
	   		$this->db->like( 'product_category.product_category_name' ,$product_category_search );
	    }

	    if($product_category_category != NULL )
		{
	   		$this->db->where("FIND_IN_SET(".$product_category_category.", product_category_category)");
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("product_category.product_category_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }


	    
		
		
		return $this->db->select(" product_category.*  " )
		
		->order_by('product_category.product_category_sort_order ASC')
		->group_by( 'product_category.product_category_id' )
		->get( $this->_table.' product_category ' )
		->result_array();
	}
	
	public function get_count( $product_category_status = NULL   , $date_from =NULL , $date_to = NULL  ,$product_category_search = NULL  , $user_id = NULL,$product_category_category=NULL,$parent_category = NULL )
	{
		
		
		if($product_category_status != NULL )
		{
	   		$this->db->where( 'product_category.product_category_status' ,$product_category_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'product_category.user_id' , $user_id );
	    }

	    if( $parent_category != NULL )
		{
	   		$this->db->where( 'product_category.parent_category' , $parent_category );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("product_category.product_category_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($product_category_search != NULL )
		{
	   		$this->db->like( 'product_category.product_category_name' ,$product_category_search );
	    }
	    if($product_category_category != NULL )
		{
	   		$this->db->where("FIND_IN_SET(".$product_category_category.", product_category_category)");
	    }
		
		return $this->db->select(" product_category.*  " )
		->order_by('product_category.product_category_sort_order ASC')
		->group_by( 'product_category.product_category_id' )
		->get($this->_table.' product_category ')
		->num_rows();
	}
	public function get_product_category_single($product_category_id )
	{
		return $this->db
		->select( "product_category.* " )
		
		->where( 'product_category.product_category_id' ,$product_category_id )
		->get( $this->_table.' product_category' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "product_category.* " )
		
		->where( 'product_category.product_category_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}

	
       
}