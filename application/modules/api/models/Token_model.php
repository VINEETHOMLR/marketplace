<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Token_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_token';
		$this->primary_key	=	'token_id';
	}


	public function get_prodcuts()
	{
		  return $this->db->select("products.*" )
	      ->where('products.product_status',CommonStatus::ACTIVE)
	      ->order_by('products.product_sort_order','ASC')
	      ->get($this->_table.' products')
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

	public function check_valid_token($token,$userId)
	{

		$count= $this->db->select("count(*) as count" )
	       ->where('token.token_value',$token)
	       ->where('token.token_user_id',$userId)
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

	
	
	
	
       
}