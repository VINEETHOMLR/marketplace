<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authentican_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_authentication';
		$this->primary_key	=	'authentication_id';
		$this->primary_column	=	'authentication_key';
	}
	
	public function get_list(  $authentication_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $authentication_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $authentication_status != NULL )
		{
	   		$this->db->where( 'authentication.authentication_status' , $authentication_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'authentication.user_id' , $user_id );
	    }
		
		if( $authentication_search != NULL )
		{
	   		$this->db->like( 'authentication.authentication_description' , $authentication_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("authentication.authentication_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" authentication.* , user.* " )
		
		->join( 'mv_users user', 'user.id = authentication.user_id' , 'inner' )
		->order_by('authentication.authentication_id DESC')
		->group_by( 'authentication.authentication_id' )
		->get( $this->_table.' authentication ' )
		->result_array();
	}
	
	public function get_count(  $authentication_status = NULL   , $date_from =NULL , $date_to = NULL  , $authentication_search = NULL  , $user_id = NULL )
	{
		
		
		if( $authentication_status != NULL )
		{
	   		$this->db->where( 'authentication.authentication_status' , $authentication_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'authentication.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("authentication.authentication_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if( $authentication_search != NULL )
		{
	   		$this->db->like( 'authentication.authentication_description' , $authentication_search );
	    }
		
		return $this->db->select(" authentication.*  " )
		->order_by('authentication.authentication_id DESC')
		->group_by( 'authentication.authentication_id' )
		->get($this->_table.' authentication ')
		->num_rows();
	}
	
	public function get_authentication( $authentication_id )
	{
		return $this->db
		->select( "authentication.*  , GROUP_CONCAT(distinct tags.tag_name) AS authentication_tags , user.*  " )
		->join( 'mv_users user', 'user.id = authentication.user_id' , 'inner' )
		->join( 'mv_authentication_to_tag btog' , 'btog.authentication_id = authentication.authentication_id' , 'left'  )
		->join( 'mv_authentication_tags tags' , 'btog.tag_id = tags.tag_id' , 'left'  )
		->where( 'authentication.authentication_id' , $authentication_id )
		->get( $this->_table.' authentication' )
		->row_array();
	}
	
	
       
}