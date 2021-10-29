<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_posts_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_post_images';
		$this->primary_key	=	'image_id';
		$this->primary_column	=	'image_user_id';
	}
	
	public function get_list(  $image_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL , $image_user_type = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $image_status != NULL )
		{
	   		$this->db->where( 'image.image_status' , $image_status );
	    }
		
		if( $image_user_type != NULL )
		{
	   		$this->db->where( 'image.image_user_type' , $image_user_type );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("image.date_of_join BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" image.*,category.image_category_title,user.first_name " )
		->join('mv_image_category category','category.image_category_id=image.image_category_id')
		->join('mv_users user','user.id=image.image_user_id')
		->order_by('image.image_id DESC')
		->group_by( 'image.image_id' )
		->get( $this->_table.' image ')
		->result_array();
	}
	
	public function get_count(  $image_status = NULL   , $date_from =NULL , $date_to = NULL  , $image_user_type = NULL  )
	{
		
		
		if( $image_status != NULL )
		{
	   		$this->db->where( 'image.image_status' , $image_status );
	    }
		
		if( $image_user_type != NULL )
		{
	   		$this->db->where( 'image.image_user_type' , $image_user_type );
	    }
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("image.date_of_join BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" image.*  " )
		->order_by('image.image_id DESC')
		->group_by( 'image.image_id' )
		->get($this->_table.' image ')
		->num_rows();
	}
	
	public function status_validator( )
	{
		$exclude	=	array( VacancyStatus::HOLD );
		
		$this->db->set('image.image_status', VacancyStatus::RUNNING )
		->where( 'image.image_start_date <=' , $this->dbnow )
		->where( 'image.image_end_date >=' , $this->dbnow )
		->where_not_in( 'image.image_status ' , $exclude )
		->update( $this->_table.' image ' );
		
		$this->db->set('image.image_status', VacancyStatus::EXPIRED )
		->where( 'DATE(DATE_ADD(image.image_end_date, INTERVAL 1 DAY)) <' , $this->dbnow )
		->where_not_in( 'image.image_status ' , $exclude )
		->update( $this->_table.' image ' );
		
		
	}


	public function get_images()
	{
		return $this->db
		->select('images.*')
		->where('images.image_status',CommonStatus::ACTIVE)
		->get( $this->_table.' images' )
		->result_array();

	}
	
	
       
}