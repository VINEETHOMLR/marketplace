<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Food_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_food';
		$this->primary_key	=	'food_id';
		$this->primary_column	=	'food_title';
	}
	
	public function get_list(  $food_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'food.food_status' , CommonStatus::ACTIVE );
		}
		else if( $food_status != NULL )
		{
	   		$this->db->where( 'food.food_status' , $food_status );
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
			->where("food.food_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" food.*,category.category_title,subcategory.subcategory_title" )
		->join('mv_foodcategory category','category.category_id=food.food_category')
		->join('mv_foodsubcategory subcategory','subcategory.subcategory_id=food.food_subcategory')
		->order_by('food.food_id ASC')
		->group_by( 'food.food_id' )
		->get( $this->_table.' food ')
		->result_array();
	}
	
	public function get_count(  $food_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'food.food_status' , CommonStatus::ACTIVE );
		}
		else if( $food_status != NULL )
		{
	   		$this->db->where( 'food.food_status' , $food_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("food.food_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" food.*  " )
		->order_by('food.food_id DESC')
		//->group_by( 'food.food_id' )
		->get($this->_table.' food ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subfood.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subfood.food_id' , $cat_id );
		}
		return $this->db->select(" subfood.*" )
		->group_by( 'subfood.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'food.food_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" food.*  " )
		
		->group_by( 'food.food_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'food.food_status' , CommonStatus::ACTIVE );
		$this->db->where( 'food.food_uri' , $where );
		//$this->db->where( 'food.home_dis_order >' , 0 );
		
		//$select = " food.*  ";
		return $this->db->select(" food.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'food.food_id = product.food_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'food.food_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}