<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_users';
		$this->primary_key	=	'id';
	}
	
	public function check_email( $email , $user_id = NULL )
	{
		if( $user_id != NULL )
		{
	   		$this->db->where( 'users.id!=' , $user_id );
	    }
		
		return $this->db->select(" users.* " )
		->where( 'users.email' , $email )
		->get('mv_users users ')
		->num_rows();
	}
	
	
	public function get_list(  $grouped_in = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $log_status = NULL , $student_search = NULL ,$store_id=NULL)
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $grouped_in != NULL )
		{
	   		$this->db->where( 'group.group_id' , $grouped_in );
	    }
		
		if( $log_status != NULL )
		{
	   		$this->db->where( 'user.active' , $log_status );
	    }


	    if( $store_id != NULL )
		{
	   		$this->db->where( 'user.store_id' , $store_id );
	    }
		
		if( $student_search != NULL )
		{
	   		$this->db->like( 'user.first_name' , $student_search );
	   		$this->db->or_like( 'user.last_name' , $student_search );
			$this->db->or_like( 'user.phone' , $student_search );
			
			/*if( Modules::run( 'login/is_admin' ) )
			{
				$this->db->or_like( 'user.email' , $student_search );
				$this->db->or_like( 'user.phone' , $student_search );
			}*/
	    }
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("user.user_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		//$this->db->where_not_in( 'group.group_id' , UserGroups::ADMIN );
		return $this->db->select(" user.*,CASE WHEN group.group_id='1' THEN 'ADMIN' WHEN group.group_id='2' THEN 'STORE ADMIN' ELSE 'STORESTAFF' END as userRole,CONCAT(user.first_name,' ',user.last_name) as name" )
		->join( 'mv_users_groups group', 'group.user_id = user.id ' , 'left' )
		//->join( 'mv_authentication authentication', 'authentication.authentication_id = user.authentication_id ' , 'left' )
		->order_by('user.id DESC')
		->group_by( 'user.id' )
		->get( $this->_table.' user ')
		->result_array();
	}
	


	public function userlist()
	{
		$this->db->where_not_in( 'group.group_id' , UserGroups::ADMIN );
		return $this->db->select(" user.email  " )
		->join( 'mv_users_groups group', 'group.user_id = user.id ' , 'left' )
		->order_by('user.id DESC')
		->group_by( 'user.id' )
		->get( $this->_table.' user ')
		->result_array();
	}
	public function get_count(  $grouped_in = NULL   , $date_from =NULL , $date_to = NULL  , $log_status = NULL  , $student_search = NULL,$store_id=NULL )
	{
		
		
		if( $grouped_in != NULL )
		{
	   		$this->db->where( 'group.group_id' , $grouped_in );
	    }
		
		if( $log_status != NULL )
		{
	   		$this->db->where( 'user.active' , $log_status );
	    }

	    if( $store_id != NULL )
		{
	   		$this->db->where( 'user.store_id' , $store_id );
	    }
		
		
		if( $student_search != NULL )
		{
	   		$this->db->like( 'user.first_name' , $student_search );
	   		$this->db->or_like( 'user.last_name' , $student_search );
			$this->db->or_like( 'user.phone' , $student_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("user.user_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		//$this->db->where_not_in( 'group.group_id' , UserGroups::ADMIN );
		return $this->db->select(" user.*  " )
		->join( 'mv_users_groups group', 'group.user_id = user.id ' , 'left' )
		->order_by('user.id DESC')
		->group_by( 'user.id' )
		->get($this->_table.' user ')
		->num_rows();
	}


	public function getUserData($id)
	{
        return $this->db->select(" user.*,group.group_id as user_role" )
		->join( 'mv_users_groups group', 'group.user_id = user.id ' , 'left' )
		->where('user.id',$id)
		->get($this->_table.' user ')
		->row_array();

	}
       
}