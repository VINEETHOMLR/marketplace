<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Staff_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_customer';
		$this->primary_key	=	'customer_id';
		$this->primary_column	=	'customer_first_name';
	}
	
	public function get_list( $staff_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$staff_search = NULL , $user_id = NULL ,$staff_type = NULL ,$company_id=NULL)
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($staff_status != NULL )
		{
	   		$this->db->where( 'staff.customer_status' ,$staff_status );
	    }
	    if($staff_type != NULL )
		{
	   		$this->db->where( 'staff.customer_type' ,$staff_type );
	    }

	    if($company_id != NULL )
		{
	   		$this->db->where( 'staff.customer_company' ,$company_id );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'staff.user_id' , $user_id );
	    }
		
		if($staff_search != NULL )
		{
	   		$this->db->like( 'staff.customer_first_name' ,$staff_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("staff.customer_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" staff.* ,CONCAT(staff.customer_first_name,' ',staff.customer_last_name) as staff_name" )
		
		->order_by('staff.customer_id DESC')
		->group_by( 'staff.customer_id' )
		->get( $this->_table.' staff ' )
		->result_array();
	}
	
	public function get_count( $staff_status = NULL   , $date_from =NULL , $date_to = NULL  ,$staff_search = NULL  , $user_id = NULL ,$staff_type = NULL,$company_id=NULL)
	{
		
		
		if($staff_status != NULL )
		{
	   		$this->db->where( 'staff.customer_status' ,$staff_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'staff.user_id' , $user_id );
	    }

	    if($company_id != NULL )
		{
	   		$this->db->where( 'staff.customer_company' ,$company_id );
	    }


	    if($staff_type != NULL )
		{
	   		$this->db->where( 'staff.customer_type' ,$staff_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("staff.customer_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($staff_search != NULL )
		{
	   		$this->db->like( 'staff.customer_first_name' ,$staff_search );
	    }
		
		return $this->db->select(" staff.*  " )
		->order_by('staff.customer_id DESC')
		->group_by( 'staff.customer_id' )
		->get($this->_table.' staff ')
		->num_rows();
	}
	public function get_customer_single($staff_id )
	{
		return $this->db
		->select( "staff.* " )
		
		->where( 'staff.customer_id' ,$staff_id )
		->get( $this->_table.' staff' )
		->row_array();
	}
	
	
	

	
       
}