<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_token extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_token_customer';
		$this->primary_key	=	'token_id';
	}

	public function disable_token($userId)
	{
        $data=array('token_status'=>0);
		//$this->db->set('token_status','0',false);
		$this->db->where('token_user_id',$userId);
		$this->db->update('mv_token_customer',$data);

	}

	public function get_token_status($token)
	{

		$count= $this->db->select("count(*) as count" )
	       ->where('token.token_value',$token)
	       ->where('token.token_status',1)
	      ->get($this->_table.' token')
	      ->row_array();
	    return $count;

	}

	public function check_token($token,$userId)
	{

		$count= $this->db->select("count(*) as count" )
	       ->where('token.token_value',$token)
	       ->where('token.token_status',1)
	       ->where('token.token_user_id',$userId)
	      ->get($this->_table.' token')
	      ->row_array();
	      
	    $count = $count['count'];
	    if($count==1)
	    {
            return TRUE;
	    }
	    else{
	    	return FALSE;
	    }
	   

	}


	public function get_prodcuts()
	{
		  return $this->db->select("products.*" )
	      ->where('products.product_status',CommonStatus::ACTIVE)
	      ->order_by('products.product_sort_order','ASC')
	      ->get($this->_table.' products')
	      ->result_array();
	}


	


	// public function check_token($token)
	// {
		
	// 	$count= $this->db->select("count(*) as count" )
	//        ->where('token.token_value',$token)
	//       ->get($this->_table.' token')
	//       ->row_array();

	//     if($count['count']==0)
	//     {
 //           return TRUE;
	//     } 
	//     else{
	//     	return FALSE;
	//     } 

	// }

	
	
	
	
       
}