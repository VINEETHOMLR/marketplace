<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Servicerates_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_washrate';
		$this->primary_key	=	'washrate_id';
		$this->primary_column	=	'washrate_name';
	}
	
	public function get_list($washrate_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$washrate_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($washrate_status != NULL )
		{
	   		$this->db->where( 'washrate.washrate_status' ,$washrate_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'washrate.user_id' , $user_id );
	    }
		
		if($washrate_search != NULL )
		{
	   		$this->db->like( 'washrate.washrate_name' ,$washrate_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("washrate.washrate_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" washrate.*  " )
		
		->order_by('washrate.washrate_id DESC')
		->group_by( 'washrate.washrate_id' )
		->get( $this->_table.' washrate ' )
		->result_array();
	}
	
	public function get_count($washrate_status = NULL   , $date_from =NULL , $date_to = NULL  ,$washrate_search = NULL  , $user_id = NULL )
	{
		
		
		if($washrate_status != NULL )
		{
	   		$this->db->where( 'washrate.washrate_status' ,$washrate_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'washrate.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("washrate.washrate_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($washrate_search != NULL )
		{
	   		$this->db->like( 'washrate.washrate_name' ,$washrate_search );
	    }
		
		return $this->db->select(" washrate.*  " )
		->order_by('washrate.washrate_id DESC')
		->group_by( 'washrate.washrate_id' )
		->get($this->_table.' service ')
		->num_rows();
	}
	public function get_washrate_single($washrate_id )
	{
		return $this->db
		->select( "washrate.* " )
		
		->where( 'washrate.washrate_id' ,$washrate_id )
		->get( $this->_table.' service' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "washrate.* " )
		
		->where( 'washrate.washrate_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}

	
       
}