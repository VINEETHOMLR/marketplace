<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cloth_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_cloth';
		$this->primary_key	=	'cloth_id';
		$this->primary_column	=	'cloth_name';
	}
	
	public function get_list($cloth_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$cloth_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($cloth_status != NULL )
		{
	   		$this->db->where( 'cloth.cloth_status' ,$cloth_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'cloth.user_id' , $user_id );
	    }
		
		if($cloth_search != NULL )
		{
	   		$this->db->like( 'cloth.cloth_name' ,$cloth_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("cloth.cloth_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" cloth.*  " )
		
		->order_by('cloth.cloth_id DESC')
		->group_by( 'cloth.cloth_id' )
		->get( $this->_table.' cloth ' )
		->result_array();
	}
	
	public function get_count($cloth_status = NULL   , $date_from =NULL , $date_to = NULL  ,$cloth_search = NULL  , $user_id = NULL )
	{
		
		
		if($cloth_status != NULL )
		{
	   		$this->db->where( 'cloth.cloth_status' ,$cloth_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'cloth.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("cloth.cloth_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($cloth_search != NULL )
		{
	   		$this->db->like( 'cloth.cloth_name' ,$cloth_search );
	    }
		
		return $this->db->select(" cloth.*  " )
		->order_by('cloth.cloth_id DESC')
		->group_by( 'cloth.cloth_id' )
		->get($this->_table.' service ')
		->num_rows();
	}
	public function get_details($cloth_id )
	{
		return $this->db
		->select( "cloth.* " )
		
		->where( 'cloth.cloth_id' ,$cloth_id )
		->get( $this->_table.' cloth' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "cloth.* " )
		
		->where( 'cloth.cloth_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}

	
       
}