<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_category_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_image_category';
		$this->primary_key	=	'image_category_id';
		$this->primary_column	=	'image_category_title';
	}
	
	public function get_list(  $image_category_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $image_category_user_type = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $image_category_status != NULL )
		{
	   		$this->db->where( 'image_category.image_category_status' , $image_category_status );
	    }
		
		if( $image_category_user_type != NULL )
		{
	   		$this->db->where( 'image_category.image_category_user_type' , $image_category_user_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("image_category.image_category_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" image_category.* " )
		->order_by('image_category.image_category_id DESC')
		->group_by( 'image_category.image_category_id' )
		->get( $this->_table.' image_category ')
		->result_array();
	}
	
	public function get_count(  $image_category_status = NULL   , $date_from =NULL , $date_to = NULL  , $image_category_user_type = NULL  )
	{
		
		
		if( $image_category_status != NULL )
		{
	   		$this->db->where( 'image_category.image_category_status' , $image_category_status );
	    }
		
		if( $image_category_user_type != NULL )
		{
	   		$this->db->where( 'image_category.image_category_user_type' , $image_category_user_type );
	    }
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("image_category.image_category_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" image_category.*  " )
		->order_by('image_category.image_category_id DESC')
		->group_by( 'image_category.image_category_id' )
		->get($this->_table.' image_category ')
		->num_rows();
	}
	
	public function status_validator( )
	{
		$exclude	=	array( VacancyStatus::HOLD );
		
		$this->db->set('image_category.image_category_status', VacancyStatus::RUNNING )
		->where( 'image_category.image_category_start_date <=' , $this->dbnow )
		->where( 'image_category.image_category_end_date >=' , $this->dbnow )
		->where_not_in( 'image_category.image_category_status ' , $exclude )
		->update( $this->_table.' image_category ' );
		
		$this->db->set('image_category.image_category_status', VacancyStatus::EXPIRED )
		->where( 'DATE(DATE_ADD(image_category.image_category_end_date, INTERVAL 1 DAY)) <' , $this->dbnow )
		->where_not_in( 'image_category.image_category_status ' , $exclude )
		->update( $this->_table.' image_category ' );
		
		
	}


	public function get_image_categorys()
	{
		return $this->db
		->select('image_categorys.*')
		->where('image_categorys.image_category_status',CommonStatus::ACTIVE)
		->get( $this->_table.' image_categorys' )
		->result_array();

	}
	
	
       
}