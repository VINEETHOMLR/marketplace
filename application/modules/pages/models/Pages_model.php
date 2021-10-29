<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_pages';
		$this->primary_key	=	'page_id';
		$this->primary_column	=	'page_name';
	}
	
	public function get_list(  $page_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $page_status != NULL )
		{
	   		$this->db->where( 'page.page_status' , $page_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("page.page_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" page.* , seo.* " )
		->join( 'mv_seo seo', 'seo.content_ref_id = page.page_id AND content_type = '.ContentTypes::PAGE , 'left' )
		->order_by('page.page_id ASC')
		->group_by( 'page.page_id' )
		->get( $this->_table.' page ')
		->result_array();
	}
	
	public function get_count(  $page_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if( $page_status != NULL )
		{
	   		$this->db->where( 'page.page_status' , $page_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("page.page_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" page.*  " )
		->order_by('page.page_id DESC')
		//->group_by( 'page.page_id' )
		->get($this->_table.' page ')
		->num_rows();
	}


   public function get_page_single($page_id)
   {
         return $this->db
         ->select('page.*')
         ->where('page.page_id',$page_id)
         ->where('page.page_status',CommonStatus::ACTIVE)
         ->get($this->_table.' page ')
         ->row_array();
   }

   public function tour_categories()
   {
   	    $this->db->where( 'category.category_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" category.*  " )
		
		->group_by( 'category.category_id' )
		->get( 'mv_tour_categories category ')
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
		//->join( 'mv_product_categories category', 'category.category_id = product.category_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'category.category_id' )
		->get( 'mv_tour_categories category ')
		->row_array();
	}


	
	
	
	
       
}