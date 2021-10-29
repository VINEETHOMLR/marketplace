<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Covisitor_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_covisitor';
		$this->primary_key	=	'covisitor_id';
	}

	public function get_list(  $post_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $post_user_type = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $post_status != NULL )
		{
	   		$this->db->where( 'post.post_status' , $post_status );
	    }
		
		if( $post_user_type != NULL )
		{
	   		$this->db->where( 'post.post_user_type' , $post_user_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("post.post_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" post.post_id,post.post_place,post.post_latitude,post.post_longitude,post.post_rating,post.post_waiting_time,post.post_created_time,customer.customer_first_name,customer.customer_last_name,customer.customer_profile_pic" )
		->join('mv_customer customer','post.post_customer_id=customer.customer_id')
		//->post_by('post.post_id DESC')
		//->group_by( 'post.post_id' )
		->get( $this->_table.' post ')
		->result_array();
	}

	public function getcovisitors($visit_id){ //for api

		return $this->db->select("covisitor.covisitor_name,covisitor.covisitor_driving_id" )
		//return $this->db->select("comment.*" )
		  ->where('covisitor.covisitor_visit_id',$visit_id)
	       ->get($this->_table.' covisitor')
	      ->result_array();
	    
	}


	

	

	



	

	
	
	
	
       
}