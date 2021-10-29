<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subcategory_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_product_category';
		$this->primary_key	=	'product_category_id';
		$this->primary_column	=	'product_category_name';
	}
	
	public function get_list( $category_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$category_search = NULL , $user_id = NULL ,$parent_category=NULL)
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
	   		$this->db->where( 'category.product_category_status' ,$category_status );
	    }

	    if($parent_category != NULL )
		{
	   		$this->db->where( 'category.parent_category' ,$parent_category );
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
		
		
		return $this->db->select(" category.*,parentcategory.category_name" )
		->join('mv_category parentcategory','category.parent_category=parentcategory.category_id')
		
		->order_by('category.product_category_id DESC')
		->group_by( 'category.product_category_id' )
		->get( $this->_table.' category ' )
		->result_array();
	}
	
	public function get_count( $category_status = NULL   , $date_from =NULL , $date_to = NULL  ,$category_search = NULL  , $user_id = NULL ,$parent_category=NULL)
	{
		
		
		if($category_status != NULL )
		{
	   		$this->db->where( 'category.product_category_status' ,$category_status );
	    }


	    if($parent_category != NULL )
		{
	   		$this->db->where( 'category.parent_category' ,$parent_category );
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
		
		return $this->db->select(" category.*,parentcategory.category_name" )
		->join('mv_category parentcategory','category.parent_category=parentcategory.category_id')
		->order_by('category.product_category_id DESC')
		->group_by( 'category.product_category_id' )
		->get($this->_table.' category ')
		->num_rows();
	}
	public function get_category_single($category_id )
	{
		return $this->db
		->select( "category.* " )
		
		->where( 'category.product_category_id' ,$category_id )
		->get( $this->_table.' category' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "category.* " )
		
		->where( 'category.category_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}

	
       
}