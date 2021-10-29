<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonials_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_testimonials';
		$this->primary_key	=	'testimonial_id';
		$this->primary_column	=	'testimonial_name';
	}
	
	public function get_list(  $testimonial_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $testimonial_user_type = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $testimonial_status != NULL )
		{
	   		$this->db->where( 'testimonial.testimonial_status' , $testimonial_status );
	    }
		
		if( $testimonial_user_type != NULL )
		{
	   		$this->db->where( 'testimonial.testimonial_user_type' , $testimonial_user_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("testimonial.testimonial_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" testimonial.* " )
		->order_by('testimonial.testimonial_id DESC')
		->group_by( 'testimonial.testimonial_id' )
		->get( $this->_table.' testimonial ')
		->result_array();
	}
	
	public function get_count(  $testimonial_status = NULL   , $date_from =NULL , $date_to = NULL  , $testimonial_user_type = NULL  )
	{
		
		
		if( $testimonial_status != NULL )
		{
	   		$this->db->where( 'testimonial.testimonial_status' , $testimonial_status );
	    }
		
		if( $testimonial_user_type != NULL )
		{
	   		$this->db->where( 'testimonial.testimonial_user_type' , $testimonial_user_type );
	    }
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("testimonial.testimonial_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" testimonial.*  " )
		->order_by('testimonial.testimonial_id DESC')
		->group_by( 'testimonial.testimonial_id' )
		->get($this->_table.' testimonial ')
		->num_rows();
	}
	
	public function status_validator( )
	{
		$exclude	=	array( VacancyStatus::HOLD );
		
		$this->db->set('testimonial.testimonial_status', VacancyStatus::RUNNING )
		->where( 'testimonial.testimonial_start_date <=' , $this->dbnow )
		->where( 'testimonial.testimonial_end_date >=' , $this->dbnow )
		->where_not_in( 'testimonial.testimonial_status ' , $exclude )
		->update( $this->_table.' testimonial ' );
		
		$this->db->set('testimonial.testimonial_status', VacancyStatus::EXPIRED )
		->where( 'DATE(DATE_ADD(testimonial.testimonial_end_date, INTERVAL 1 DAY)) <' , $this->dbnow )
		->where_not_in( 'testimonial.testimonial_status ' , $exclude )
		->update( $this->_table.' testimonial ' );
		
		
	}


	public function get_testimonials()
	{
		return $this->db
		->select('testimonials.*')
		->where('testimonials.testimonial_status',CommonStatus::ACTIVE)
		->get( $this->_table.' testimonials' )
		->result_array();

	}
	
	
       
}