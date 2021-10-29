<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newspaper_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_newspaper';
		$this->primary_key	=	'newspaper_id';
		$this->primary_column	=	'newspaper_title';
	}
	
	public function get_list(  $newspaper_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'newspaper.newspaper_status' , CommonStatus::ACTIVE );
		}
		else if( $newspaper_status != NULL )
		{
	   		$this->db->where( 'newspaper.newspaper_status' , $newspaper_status );
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
			->where("newspaper.newspaper_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" newspaper.*  " )
		
		->order_by('newspaper.newspaper_id ASC')
		->group_by( 'newspaper.newspaper_id' )
		->get( $this->_table.' newspaper ')
		->result_array();
	}
	
	public function get_count(  $newspaper_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'newspaper.newspaper_status' , CommonStatus::ACTIVE );
		}
		else if( $newspaper_status != NULL )
		{
	   		$this->db->where( 'newspaper.newspaper_status' , $newspaper_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("newspaper.newspaper_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" newspaper.*  " )
		->order_by('newspaper.newspaper_id DESC')
		//->group_by( 'newspaper.newspaper_id' )
		->get($this->_table.' newspaper ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subnewspaper.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subnewspaper.newspaper_id' , $cat_id );
		}
		return $this->db->select(" subnewspaper.*" )
		->group_by( 'subnewspaper.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'newspaper.newspaper_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" newspaper.*  " )
		
		->group_by( 'newspaper.newspaper_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'newspaper.newspaper_status' , CommonStatus::ACTIVE );
		$this->db->where( 'newspaper.newspaper_uri' , $where );
		//$this->db->where( 'newspaper.home_dis_order >' , 0 );
		
		//$select = " newspaper.*  ";
		return $this->db->select(" newspaper.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'newspaper.newspaper_id = product.newspaper_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'newspaper.newspaper_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}