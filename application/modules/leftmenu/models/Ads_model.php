<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ads_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_ads';
		$this->primary_key	=	'ad_id';
		$this->primary_column	=	'ad_title';
	}
	
	public function get_list(  $ad_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'ad.ad_status' , CommonStatus::ACTIVE );
		}
		else if( $ad_status != NULL )
		{
	   		$this->db->where( 'ad.ad_status' , $ad_status );
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
			->where("ad.ad_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" ad.*  " )
		
		->order_by('ad.ad_id ASC')
		->group_by( 'ad.ad_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}
	
	public function get_count(  $ad_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'ad.ad_status' , CommonStatus::ACTIVE );
		}
		else if( $ad_status != NULL )
		{
	   		$this->db->where( 'ad.ad_status' , $ad_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("ad.ad_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" ad.*  " )
		->order_by('ad.ad_id DESC')
		//->group_by( 'ad.ad_id' )
		->get($this->_table.' ad ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subad.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subad.ad_id' , $cat_id );
		}
		return $this->db->select(" subad.*" )
		->group_by( 'subad.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'ad.ad_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" ad.*  " )
		
		->group_by( 'ad.ad_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'ad.ad_status' , CommonStatus::ACTIVE );
		$this->db->where( 'ad.ad_uri' , $where );
		//$this->db->where( 'ad.home_dis_order >' , 0 );
		
		//$select = " ad.*  ";
		return $this->db->select(" ad.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'ad.ad_id = product.ad_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'ad.ad_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}