<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_service';
		$this->primary_key	=	'service_id';
		$this->primary_column	=	'service_name';
	}
	
	public function get_list( $service_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$service_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($service_status != NULL )
		{
	   		$this->db->where( 'service.service_status' ,$service_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'service.user_id' , $user_id );
	    }
		
		if($service_search != NULL )
		{
	   		$this->db->like( 'service.service_name' ,$service_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("service.service_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" service.*  " )
		
		->order_by('service.service_id DESC')
		->group_by( 'service.service_id' )
		->get( $this->_table.' service ' )
		->result_array();
	}
	
	public function get_count( $service_status = NULL   , $date_from =NULL , $date_to = NULL  ,$service_search = NULL  , $user_id = NULL )
	{
		
		
		if($service_status != NULL )
		{
	   		$this->db->where( 'service.service_status' ,$service_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'service.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("service.service_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($service_search != NULL )
		{
	   		$this->db->like( 'service.service_name' ,$service_search );
	    }
		
		return $this->db->select(" service.*  " )
		->order_by('service.service_id DESC')
		->group_by( 'service.service_id' )
		->get($this->_table.' service ')
		->num_rows();
	}
	public function get_service_single($service_id )
	{
		return $this->db
		->select( "service.* " )
		
		->where( 'service.service_id' ,$service_id )
		->get( $this->_table.' service' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "service.* " )
		
		->where( 'service.service_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}

	
       
}