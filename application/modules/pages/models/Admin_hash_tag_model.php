<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_hash_tag_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_hash_tags';
		$this->primary_key	=	'hash_tags_id';
		$this->primary_column	=	'hash_tags_title';
	}
	
	public function get_list(  $hash_tags_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $hash_tags_user_type = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $hash_tags_status != NULL )
		{
	   		$this->db->where( 'hash_tags.hash_tags_status' , $hash_tags_status );
	    }
		
		if( $hash_tags_user_type != NULL )
		{
	   		$this->db->where( 'hash_tags.hash_tags_user_type' , $hash_tags_user_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("hash_tags.hash_tags_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" hash_tags.*,users.id as userid ,users.username" )
		->join('mv_users users','users.id=hash_tags.hash_tags_user_id')
		->order_by('hash_tags.hash_tags_id DESC')
		->group_by( 'hash_tags.hash_tags_id' )
		->get( $this->_table.' hash_tags ')
		->result_array();
	}
	
	public function get_count(  $hash_tags_status = NULL   , $date_from =NULL , $date_to = NULL  , $hash_tags_user_type = NULL  )
	{
		
		
		if( $hash_tags_status != NULL )
		{
	   		$this->db->where( 'hash_tags.hash_tags_status' , $hash_tags_status );
	    }
		
		if( $hash_tags_user_type != NULL )
		{
	   		$this->db->where( 'hash_tags.hash_tags_user_type' , $hash_tags_user_type );
	    }
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("hash_tags.hash_tags_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" hash_tags.* ,users.id as userid" )
		->join('mv_users users','users.id=hash_tags.hash_tags_user_id')
		->order_by('hash_tags.hash_tags_id DESC')
		->group_by( 'hash_tags.hash_tags_id' )
		->get($this->_table.' hash_tags ')
		->num_rows();
	}
	
	public function status_validator( )
	{
		$exclude	=	array( VacancyStatus::HOLD );
		
		$this->db->set('hash_tags.hash_tags_status', VacancyStatus::RUNNING )
		->where( 'hash_tags.hash_tags_start_date <=' , $this->dbnow )
		->where( 'hash_tags.hash_tags_end_date >=' , $this->dbnow )
		->where_not_in( 'hash_tags.hash_tags_status ' , $exclude )
		->update( $this->_table.' hash_tags ' );
		
		$this->db->set('hash_tags.hash_tags_status', VacancyStatus::EXPIRED )
		->where( 'DATE(DATE_ADD(hash_tags.hash_tags_end_date, INTERVAL 1 DAY)) <' , $this->dbnow )
		->where_not_in( 'hash_tags.hash_tags_status ' , $exclude )
		->update( $this->_table.' hash_tags ' );
		
		
	}


	
	
	
       
}