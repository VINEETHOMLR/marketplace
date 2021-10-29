<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Foodcategory_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_foodcategory';
		$this->primary_key	=	'category_id';
		$this->primary_column	=	'category_title';
	}
	
	public function get_list(  $category_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'category.category_status' , CommonStatus::ACTIVE );
		}
		else if( $category_status != NULL )
		{
	   		$this->db->where( 'category.category_status' , $category_status );
	    }
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
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
		
		->order_by('category.category_id ASC')
		->group_by( 'category.category_id' )
		->get( $this->_table.' category ')
		->result_array();
	}
	
	public function get_count(  $category_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'category.category_status' , CommonStatus::ACTIVE );
		}
		else if( $category_status != NULL )
		{
	   		$this->db->where( 'category.category_status' , $category_status );
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
		//->group_by( 'category.category_id' )
		->get($this->_table.' category ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subcategory.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subcategory.category_id' , $cat_id );
		}
		return $this->db->select(" subcategory.*" )
		->group_by( 'subcategory.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function category_list()
	{
		
		$this->db->where( 'category.category_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" category.*  " )
		
		->group_by( 'category.category_id' )
		->get( $this->_table.' category ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'category.category_status' , CommonStatus::ACTIVE );
		$this->db->where( 'category.category_uri' , $where );
		//$this->db->where( 'category.home_dis_order >' , 0 );
		
		//$select = " category.*  ";
		return $this->db->select(" category.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'category.category_id = product.category_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'category.category_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}