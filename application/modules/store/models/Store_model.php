<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Store_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_store';
		$this->primary_key	=	'store_id';
		$this->primary_column	=	'store_name';
	}
	
	public function get_list( $store_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$store_search = NULL , $user_id = NULL,$store_category=NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($store_status != NULL )
		{
	   		$this->db->where( 'store.store_status' ,$store_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'store.user_id' , $user_id );
	    }
		
		if($store_search != NULL )
		{
	   		$this->db->like( 'store.store_name' ,$store_search );
	    }

	    if($store_category != NULL )
		{
	   		$this->db->where("FIND_IN_SET(".$store_category.", store_category)");
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("store.store_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }


	    
		
		
		return $this->db->select(" store.*  " )
		
		->order_by('store.store_id DESC')
		->group_by( 'store.store_id' )
		->get( $this->_table.' store ' )
		->result_array();
	}
	
	public function get_count( $store_status = NULL   , $date_from =NULL , $date_to = NULL  ,$store_search = NULL  , $user_id = NULL,$store_category=NULL )
	{
		
		
		if($store_status != NULL )
		{
	   		$this->db->where( 'store.store_status' ,$store_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'store.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("store.store_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($store_search != NULL )
		{
	   		$this->db->like( 'store.store_name' ,$store_search );
	    }
	    if($store_category != NULL )
		{
	   		$this->db->where("FIND_IN_SET(".$store_category.", store_category)");
	    }
		
		return $this->db->select(" store.*  " )
		->order_by('store.store_id DESC')
		->group_by( 'store.store_id' )
		->get($this->_table.' store ')
		->num_rows();
	}
	public function get_store_single($store_id )
	{
		return $this->db
		->select( "store.* " )
		
		->where( 'store.store_id' ,$store_id )
		->get( $this->_table.' store' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "store.* " )
		
		->where( 'store.store_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}


	public function getCategory($storeId)
	{
       return $this->db
		->select( "store.store_category" )
		
		->where( 'store.store_status' ,1)
		->where( 'store.store_id' ,$storeId)
		->get( $this->_table.' store' )
		->row_array();
	}
	
	
	
	public function updateCount($store_id)
	{
		


        $this->db->set('click_count', 'click_count+1', FALSE);
        $this->db->where('store_id', $store_id);
        $this->db->update('mv_store');
        
        

	}

	

	
       
}
