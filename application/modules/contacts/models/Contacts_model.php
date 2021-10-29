<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contacts_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_contacts';
		$this->primary_key	=	'contact_id';
		$this->primary_column	=	'contact_name';
	}
	
	public function get_list(  $contact_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $search = NULL , $contact_type = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $contact_status != NULL )
		{
	   		$this->db->where( 'contact.contact_status' , $contact_status );
	    }
		if( $contact_type != NULL )
		{
	   		$this->db->where( 'contact.contact_type' , $contact_type );
	    }
		
		
		if( $search != NULL )
		{
	   		$this->db->like( 'contact.contact_name' , $search );
			$this->db->or_like( 'contact.contact_email' , $search );
			$this->db->or_like( 'contact.contact_phone' , $search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("contact.contact_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" contact.* " )
		->order_by('contact.contact_id DESC')
		->group_by( 'contact.contact_id' )
		->get( $this->_table.' contact ')
		->result_array();
	}
	
	public function get_list_from_ids( $ids	=	array() )
	{
		return $this->db->select(" contact.* " )
		->where_in('contact_id',  $ids )
		->order_by('contact.contact_id ASC')
		->group_by( 'contact.contact_id' )
		->get( $this->_table.' contact ')
		->result_array();
	}
	
	public function get_count(  $contact_status = NULL   , $date_from =NULL , $date_to = NULL , $search = NULL , $contact_type = NULL  )
	{
		
		
		if( $contact_status != NULL )
		{
	   		$this->db->where( 'contact.contact_status' , $contact_status );
	    }
		
		if( $contact_type != NULL )
		{
	   		$this->db->where( 'contact.contact_type' , $contact_type );
	    }
		
		
		if( $search != NULL )
		{
	   		$this->db->like( 'contact.contact_name' , $search );
			$this->db->or_like( 'contact.contact_email' , $search );
			$this->db->or_like( 'contact.contact_phone' , $search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("contact.contact_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" contact.*  " )
		->order_by('contact.contact_id DESC')
		//->group_by( 'contact.contact_id' )
		->get($this->_table.' contact ')
		->num_rows();
	}

	
}