<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cinema_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_cinema';
		$this->primary_key	=	'cinema_id';
		$this->primary_column	=	'cinema_title';
	}
	
	public function get_list(  $cinema_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'cinema.cinema_status' , CommonStatus::ACTIVE );
		}
		else if( $cinema_status != NULL )
		{
	   		$this->db->where( 'cinema.cinema_status' , $cinema_status );
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
			->where("cinema.cinema_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" cinema.*  " )
		
		->order_by('cinema.cinema_id ASC')
		->group_by( 'cinema.cinema_id' )
		->get( $this->_table.' cinema ')
		->result_array();
	}
	
	public function get_count(  $cinema_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'cinema.cinema_status' , CommonStatus::ACTIVE );
		}
		else if( $cinema_status != NULL )
		{
	   		$this->db->where( 'cinema.cinema_status' , $cinema_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("cinema.cinema_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" cinema.*  " )
		->order_by('cinema.cinema_id DESC')
		//->group_by( 'cinema.cinema_id' )
		->get($this->_table.' cinema ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subcinema.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subcinema.cinema_id' , $cat_id );
		}
		return $this->db->select(" subcinema.*" )
		->group_by( 'subcinema.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'cinema.cinema_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" cinema.*  " )
		
		->group_by( 'cinema.cinema_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'cinema.cinema_status' , CommonStatus::ACTIVE );
		$this->db->where( 'cinema.cinema_uri' , $where );
		//$this->db->where( 'cinema.home_dis_order >' , 0 );
		
		//$select = " cinema.*  ";
		return $this->db->select(" cinema.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'cinema.cinema_id = product.cinema_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'cinema.cinema_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}