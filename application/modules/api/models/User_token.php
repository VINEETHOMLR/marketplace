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

	public function check_phone($phone)
	{
		  return $this->db->select("*" )
	      ->where('customer_phone',$phone)
	      ->get('mv_customer')
	      ->result_array();
	}

	public function check_otp($phone,$otp)
	{
		  $checkOtp = $this->db->select("*" )
	      ->where('phone',$phone)
	      ->get('mv_otp')
	      ->result_array();

          $time = time();
          $arr = ['phone'=>$phone,'otp'=>$otp,'created_at'=>$time];

	      if(!empty($checkOtp)) 
           {
              $this->db->where('phone',$phone);
		      $this->db->update('mv_otp',$arr);
		      return true;

           } else {
     
		      $this->db->insert('mv_otp',$arr);
		      return true;
           }
           return false;
	}


	public function verify_otp($phone,$otp)
	{
		  $result = $this->db->select("*" )
	      ->where('phone',$phone)
	      ->where('otp',$otp)
	      ->get('mv_otp')
	      ->row_array();

          if($result)
          {
          	$time2 = strtotime("+3 minutes", $result['created_at']);
          	if(time()<=$time2) 
          	 {
                return 1;
          	 } else {
                return 2;
          	 }   
          }
          return false;
	}


	public function getPreviousOtp($phone){
        
        return $this->db->select("*" )
	      ->where('phone',$phone)
	      ->get('mv_otp')
	      ->row_array();
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