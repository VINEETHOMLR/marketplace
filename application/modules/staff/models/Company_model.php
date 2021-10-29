<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_company';
		$this->primary_key	=	'company_id';
		$this->primary_column	=	'company_name';
	}
	
	public function get_list( $company_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$company_search = NULL , $user_id = NULL ,$company_type = NULL)
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($company_status != NULL )
		{
	   		$this->db->where( 'company.company_status' ,$company_status );
	    }
	    if($company_type != NULL )
		{
	   		$this->db->where( 'company.company_type' ,$company_type );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'company.user_id' , $user_id );
	    }
		
		if($company_search != NULL )
		{
	   		$this->db->like( 'company.company_first_name' ,$company_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("company.company_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" company.*" )
		
		->order_by('company.company_name ASC')
		->get( $this->_table.' company ' )
		->result_array();
	}
	
	public function get_count( $company_status = NULL   , $date_from =NULL , $date_to = NULL  ,$company_search = NULL  , $user_id = NULL ,$company_type = NULL)
	{
		
		
		if($company_status != NULL )
		{
	   		$this->db->where( 'company.company_status' ,$company_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'company.user_id' , $user_id );
	    }


	    if($company_type != NULL )
		{
	   		$this->db->where( 'company.company_type' ,$company_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("company.company_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($company_search != NULL )
		{
	   		$this->db->like( 'company.company_first_name' ,$company_search );
	    }
		
		return $this->db->select(" company.*  " )
		->order_by('company.company_name ASC')
		//->group_by( 'company.company_id' )
		->get($this->_table.' company ')
		->num_rows();
	}
	public function get_company_single($company_id )
	{
		return $this->db
		->select( "company.* " )
		
		->where( 'company.company_id' ,$company_id )
		->get( $this->_table.' service' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "company.* " )
		
		->where( 'company.company_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}

	
       
}