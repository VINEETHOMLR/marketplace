<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class History_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_history';
		$this->primary_key	=	'history_id';
		$this->primary_column	=	'history_title';
	}
	
	public function get_list(  $history_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'history.history_status' , CommonStatus::ACTIVE );
		}
		else if( $history_status != NULL )
		{
	   		$this->db->where( 'history.history_status' , $history_status );
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
			->where("history.history_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" history.*" )
		
		->order_by('history.history_id ASC')
		->group_by( 'history.history_id' )
		->get( $this->_table.' history ')
		->result_array();
	}
	
	public function get_count(  $history_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'history.history_status' , CommonStatus::ACTIVE );
		}
		else if( $history_status != NULL )
		{
	   		$this->db->where( 'history.history_status' , $history_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("history.history_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" history.*  " )
		->order_by('history.history_id DESC')
		//->group_by( 'history.history_id' )
		->get($this->_table.' history ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subhistory.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subhistory.history_id' , $cat_id );
		}
		return $this->db->select(" subhistory.*" )
		->group_by( 'subhistory.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'history.history_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" history.*  " )
		
		->group_by( 'history.history_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'history.history_status' , CommonStatus::ACTIVE );
		$this->db->where( 'history.history_uri' , $where );
		//$this->db->where( 'history.home_dis_order >' , 0 );
		
		//$select = " history.*  ";
		return $this->db->select(" history.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'history.history_id = product.history_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'history.history_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}