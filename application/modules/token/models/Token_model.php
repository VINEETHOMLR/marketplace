<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Token_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_token';
		$this->primary_key	=	'token_id';
		$this->primary_column	=	'token_status';
	}
	
	public function get_list(  $token_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $search = NULL  )
	{
		if( $token_status != NULL )
		{
	   		$this->db->where( 'token.token_status' , $token_status );
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
			->where("token.token_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" token.*  " )
		
		->order_by('token.token_id DESC')
		->group_by( 'token.token_id' )
		->get( $this->_table.' token ')
		->result_array();
	}
	
	public function get_count(  $token_status = NULL   , $date_from =NULL , $date_to = NULL  , $search = NULL)
	{
		
		
		if( $token_status != NULL )
		{
	   		$this->db->where( 'token.token_status' , $token_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("token.token_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
	    
	   
		
		
		
		return $this->db->select(" token.*  " )
		->order_by('token.token_id DESC')
		//->group_by( 'token.token_id' )
		->get($this->_table.' token ')
		->num_rows();
	}


	public function get_list2(  $token_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $search = NULL  )
	{
		if( $token_status != NULL )
		{
	   		$this->db->where( 'token.token_status' , $token_status );
	    }
		
		
		return $this->db->select(" token.token_value  " )
		
		->order_by('token.token_id DESC')
		->group_by( 'token.token_id' )
		->get( $this->_table.' token ')
		->result_array();
	}

	
}