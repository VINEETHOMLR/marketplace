<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Website_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_website';
		$this->primary_key	=	'website_id';
		$this->primary_column	=	'website_title';
	}
	
	public function get_list(  $website_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'website.website_status' , CommonStatus::ACTIVE );
		}
		else if( $website_status != NULL )
		{
	   		$this->db->where( 'website.website_status' , $website_status );
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
			->where("website.website_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" website.*" )
		
		->order_by('website.website_id ASC')
		->group_by( 'website.website_id' )
		->get( $this->_table.' website ')
		->result_array();
	}
	
	public function get_count(  $website_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'website.website_status' , CommonStatus::ACTIVE );
		}
		else if( $website_status != NULL )
		{
	   		$this->db->where( 'website.website_status' , $website_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("website.website_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" website.*  " )
		->order_by('website.website_id DESC')
		//->group_by( 'website.website_id' )
		->get($this->_table.' website ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subwebsite.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subwebsite.website_id' , $cat_id );
		}
		return $this->db->select(" subwebsite.*" )
		->group_by( 'subwebsite.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'website.website_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" website.*  " )
		
		->group_by( 'website.website_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'website.website_status' , CommonStatus::ACTIVE );
		$this->db->where( 'website.website_uri' , $where );
		//$this->db->where( 'website.home_dis_order >' , 0 );
		
		//$select = " website.*  ";
		return $this->db->select(" website.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'website.website_id = product.website_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'website.website_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}