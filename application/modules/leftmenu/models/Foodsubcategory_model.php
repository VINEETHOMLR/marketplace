<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Foodsubcategory_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_foodsubcategory';
		$this->primary_key	=	'subcategory_id';
		$this->primary_column	=	'subcategory_title';
	}
	
	public function get_list(  $subcategory_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subcategory.subcategory_status' , CommonStatus::ACTIVE );
		}
		else if( $subcategory_status != NULL )
		{
	   		$this->db->where( 'subcategory.subcategory_status' , $subcategory_status );
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
			->where("subcategory.subcategory_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" subcategory.*,category.category_title" )
		->join('mv_foodcategory category','category.category_id=subcategory.subcategory_category_id')
		
		->order_by('subcategory.subcategory_id ASC')
		->group_by( 'subcategory.subcategory_id' )
		->get( $this->_table.' subcategory ')
		->result_array();
	}
	
	public function get_count(  $subcategory_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subcategory.subcategory_status' , CommonStatus::ACTIVE );
		}
		else if( $subcategory_status != NULL )
		{
	   		$this->db->where( 'subcategory.subcategory_status' , $subcategory_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("subcategory.subcategory_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" subcategory.*  " )
		->order_by('subcategory.subcategory_id DESC')
		//->group_by( 'subcategory.subcategory_id' )
		->get($this->_table.' subcategory ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subsubcategory.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subsubcategory.subcategory_id' , $cat_id );
		}
		return $this->db->select(" subsubcategory.*" )
		->group_by( 'subsubcategory.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function subcategory_list()
	{
		
		$this->db->where( 'subcategory.subcategory_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" subcategory.*  " )
		
		->group_by( 'subcategory.subcategory_id' )
		->get( $this->_table.' subcategory ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'subcategory.subcategory_status' , CommonStatus::ACTIVE );
		$this->db->where( 'subcategory.subcategory_uri' , $where );
		//$this->db->where( 'subcategory.home_dis_order >' , 0 );
		
		//$select = " subcategory.*  ";
		return $this->db->select(" subcategory.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'subcategory.subcategory_id = product.subcategory_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'subcategory.subcategory_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}