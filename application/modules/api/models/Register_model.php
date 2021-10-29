<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_customer';
		$this->primary_key	=	'customer_id';
	}


	function check_email($email)
	{
         $count= $this->db->select("count(*) as count" )
	       ->where('customer.customer_email',$email)
	      ->get($this->_table.' customer')
	      ->row_array();
	      return $count;
	}


	public function searchemployee($keyword,$company_id)
	{
	    return $this->db->select("customer_id,customer_first_name,customer_last_name")
		->like('customer_first_name', $keyword)
		->or_like('customer_last_name', $keyword)
		->where('customer_type', 1)
		->where('customer_status', 1)
		->where('customer_company',$company_id)
		->get($this->_table.' customer')
		->result_array();	
	}



	


	public function check_token($token)
	{
		
		$count= $this->db->select("count(*) as count" )
	       ->where('token.token_value',$token)
	      ->get($this->_table.' token')
	      ->row_array();

	    if($count['count']==0)
	    {
           return TRUE;
	    } 
	    else{
	    	return FALSE;
	    } 

	}

	function check_phone($phone)
	{
        $count= $this->db->select("count(*) as count" )
	       ->where('customer.customer_phone',$phone)
	      ->get($this->_table.' customer')
	      ->row_array();
	      return $count;
	}

	function check_username($username)
	{
        $count= $this->db->select("count(*) as count" )
	       ->where('customer.customer_username',$username)
	      ->get($this->_table.' customer')
	      ->row_array();
	      return $count;
	}

	function check_license($license)
	{
        $count= $this->db->select("count(*) as count" )
	       ->where('customer.customer_license',$license)
	      ->get($this->_table.' customer')
	      ->row_array();
	      return $count;
	}
	

	function loginuser($username,$password)
	{
		
        $count=$this->db->select("*" )
		//->where('customer_email', $username)
		->where('customer_email', $username)
		->where('customer_password', $password)
		//->or_where('customer_phone', $username)
		 ->get($this->_table.' customer')
		->row_array();
	    return $count;


	}

	function checkregistered($id)
	{

		$count= $this->db->select("count(*) as count" )
	       ->where('customer.customer_social_id',$id)
	      ->get($this->_table.' customer')
	      ->row_array();
	      return $count;

	}
	function get_user_details($social_id)
	{

		 return $this->db->select("*" )
		->where('customer_social_id', $social_id)
		->get($this->_table.' customer')
		->row_array();
	    

	}
	function social_media_login($id,$type){
       
        $count= $this->db->select("*" )
	       ->where('customer.customer_register_type',$type)
	       ->where('customer.customer_social_id',$id)
	      ->get($this->_table.' customer')
	      ->row_array();
	      return $count;
	}

	function get_user($userId)
	{

		return $this->db->select("*" )
		->where('customer_id', $userId)
		->where('customer_status', 1)
		->get($this->_table.' customer')
		->row_array();

	}


	function get_user_detail($email,$phone)
	{
       return $this->db->select("*" )
		->where('customer_email', $email)
		->where('customer_phone', $phone)
		->where('customer_status', 1)
		->get($this->_table.' customer')
		->row_array();
	}
	
	function get_user_email($email)
	{
       return $this->db->select("*" )
		->where('customer_email', $email)
		//->where('customer_phone', $phone)
		->where('customer_status', 1)
		->get($this->_table.' customer')
		->row_array();
	}

	
	
	
	
       
}