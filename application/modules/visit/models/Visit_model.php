<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Visit_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_visit';
		$this->primary_key	=	'visit_id';
	}

	public function get_list(  $visit_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $visit_search=NULL,$visit_user_type = NULL ,$visit_visit_id=NULL ,$visit_company_id=NULL,$visit_who_to_meet=NULL,$visit_added_by=NULL)
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $visit_status != NULL )
		{
	   		$this->db->where( 'visit.visit_status' , $visit_status );
	    }
		
		/*if( $visit_user_type != NULL )
		{
	   		$this->db->where( 'visit.visit_user_type' , $visit_user_type );
	    }*/
	    if( $visit_visit_id != NULL )
		{
	   		$this->db->where( 'visit.visit_visit_id' , $visit_visit_id );
	    }

	    

	     if( $visit_added_by != NULL )
		{
	   		$this->db->where( 'visit.visit_added_by' , $visit_added_by );
	    }

	    if( $visit_company_id != NULL )
		{
	   		$this->db->where( 'visit.visit_company_id' , $visit_company_id );
	    }
	    if( $visit_who_to_meet != NULL )
		{
	   		$this->db->where( 'visit.visit_who_to_meet' , $visit_who_to_meet );
	    }

	    if($visit_search != NULL )
		{
	   		$this->db->like( 'visit.visit_fullname' ,$visit_search );
	   		$this->db->or_like( 'visit.visit_mobile' ,$visit_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("visit.visit_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select("visit.*,CONCAT(customer.customer_first_name,' ',customer.customer_last_name) as staffname" )
		->join('mv_customer customer','visit.visit_who_to_meet=customer.customer_id')
		//->join('mv_customer customer','visit.visit_added_by=customer.customer_id')
	/*	->join('mv_visit visit','visit.visit_visit_id=visit.visit_id')
		->join('mv_places places','visit.visit_place_id=places.places_id')
		->join('mv_place_to_point ptop','visit.visit_point_id=ptop.near_places_id')*/
		->order_by('visit.visit_id DESC')
		//->group_by( 'visit.visit_id' )
		->get( $this->_table.' visit ')
		->result_array();
	}

	public function get_count( $visit_status = NULL   , $date_from =NULL , $date_to = NULL  ,$visit_search = NULL  , $user_id = NULL ,$visit_type = NULL,$visit_company_id=NULL,$visit_who_to_meet=NULL,$visit_added_by=NULL)
	{
		
		
		if($visit_status != NULL )
		{
	   		$this->db->where( 'visit.visit_status' ,$visit_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'visit.user_id' , $user_id );
	    }

	    if( $visit_added_by != NULL )
		{
	   		$this->db->where( 'visit.visit_added_by' , $visit_added_by );
	    }


	    if($visit_type != NULL )
		{
	   		$this->db->where( 'visit.visit_type' ,$visit_type );
	    }
	    if( $visit_company_id != NULL )
		{
	   		$this->db->where( 'visit.visit_company_id' , $visit_company_id );
	    }
	     if( $visit_who_to_meet != NULL )
		{
	   		$this->db->where( 'visit.visit_who_to_meet' , $visit_who_to_meet );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("visit.visit_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		 if($visit_search != NULL )
		{
	   		$this->db->like( 'visit.visit_fullname' ,$visit_search );
	   		$this->db->or_like( 'visit.visit_mobile' ,$visit_search );
	    }
		
		return $this->db->select(" visit.*  " )
		->order_by('visit.visit_id DESC')
		->group_by( 'visit.visit_id' )
		->get($this->_table.' visit ')
		->num_rows();
	}




	

	public function details($visit_id)
	{

        return $this->db->select("visit.visit_id,visit.visit_fullname,visit.visit_companyname,visit.visit_drivingid,visit.visit_mobile,visit.visit_purpose,visit.visit_no_of_visitors,visit.visit_checkin_date,visit.visit_checkin_time,visit.visit_checkout_date,visit.visit_checkout_time,visit.visit_company_id,visit.visit_image,visit.visit_who_to_meet as who_to_meet_id,CONCAT(customer.customer_first_name, ' ', customer.customer_last_name) AS who_to_meet " )
	     ->join('mv_customer customer','visit.visit_who_to_meet=customer.customer_id')
	     // ->join('mv_places places','visit.visit_place_id=places.places_id')
		//->join('mv_place_to_point ptop','visit.visit_point_id=ptop.near_places_id')
	       ->where('visit_id',$visit_id)
	      ->get($this->_table.' visit')
	      ->row_array();

	}

	public function getdatesgroup($company_id,$user_type,$user_id) 
	{
		if($user_type==2) {
        
        //return $this->db->select("visit.visit_checkin_date" )
        return $this->db->select("visit.visit_checkin_date" )
	      ->where('visit_company_id',$company_id)
	      ->group_by('visit_checkin_date')
	      ->order_by('visit_checkin_date DESC')
	      ->get($this->_table.' visit')
	      ->result_array();
		}


		if($user_type==1) {
        
        //return $this->db->select("visit.visit_checkin_date" )
        return $this->db->select("visit.visit_checkin_date" )
	      ->where('visit_company_id',$company_id)
	      ->where('visit_who_to_meet',$user_id)
	      ->group_by('visit_checkin_date')
	      ->order_by('visit_checkin_date DESC')
	      ->get($this->_table.' visit')
	      ->result_array();
		}

	}


	public function getvisit_list($company_id,$user_type,$userId,$date,$search) 
	{
        
         if($user_type==2) {
         	  if ($search !=NULL) {
              $this->db->like('visit_fullname',$search);
              $this->db->or_like('visit_mobile',$search);
         	  }

         	  if ($date !=NULL) {
              $this->db->where('visit_checkin_date',$date);
              
         	  }

              return $this->db->select("visit_id,visit_fullname,visit_companyname,visit_checkin_date,visit_checkin_time,visit_checkout_date,visit_checkout_time" )
		      ->where('visit_company_id',$company_id)
		      
		      
		      ->order_by('visit_id DESC')
		      ->get($this->_table.' visit')
		      ->result_array();	
         }

         if($user_type==1) {
         	  if ($search !=NULL) {
              $this->db->like('visit_fullname',$search);
              $this->db->or_like('visit_mobile',$search);
         	  }

         	  if ($date !=NULL) {
              $this->db->where('visit_checkin_date',$date);
              
         	  }

              return $this->db->select("visit_id,visit_fullname,visit_companyname,visit_checkin_date,visit_checkin_time,visit_checkout_date,visit_checkout_time" )
		      ->where('visit_company_id',$company_id)
		      ->where('visit_who_to_meet',$userId)
		      
		      
		      ->order_by('visit_id DESC')
		      ->get($this->_table.' visit')
		      ->result_array();	
         }
		 

	}

	public function getvisitcount($visit_fullname,$visit_checkin_date)
	{

		      return $this->db->select("count(visit.visit_id) as visitCount" )
		      ->where('visit.visit_checkin_date',$visit_checkin_date)
		      ->where('visit.visit_fullname',$visit_fullname)
		      ->get($this->_table.' visit')
		      ->row_array();	

	}

	


	



	

	
	
	
	
       
}