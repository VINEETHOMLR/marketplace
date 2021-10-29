<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_downloads_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_download';
		$this->primary_key	=	'download_id';
		$this->primary_column	=	'download_image_id';
	}
	
	public function get_list(   $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
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
		
		
		return $this->db->select(" image.* ,user.first_name,category.image_category_title" )
		
		->order_by('image.image_no_of_downloads DESC')
		->join('mv_users user','user.id=image.image_user_id')
		->join('mv_image_category category','category.image_category_id=image.image_category_id')
		->get( 'mv_post_images image ')
		->result_array();
	}
	
	public function get_count(   $date_from =NULL , $date_to = NULL )
	{
		
		
		
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
		->order_by('image.image_no_of_downloads DESC')
		//->group_by( 'image.image_id' )
		->get( 'mv_post_images image ')
		->num_rows();
	}
	
	

	
	
       
}