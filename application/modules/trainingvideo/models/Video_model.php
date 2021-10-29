<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Video_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_training_videos';
		$this->primary_key	=	'video_id';
		$this->primary_column	=	'video_url';
	}
	
	public function get_list($video_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$video_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($video_status != NULL )
		{
	   		$this->db->where( 'video.video_status' ,$video_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'video.user_id' , $user_id );
	    }
		
		if($video_search != NULL )
		{
	   		$this->db->like( 'video.video_first_name' ,$video_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("video.video_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" video.*  " )
		
		->order_by('video.video_id DESC')
		->group_by( 'video.video_id' )
		->get( $this->_table.' video ' )
		->result_array();
	}
	
	public function get_count($video_status = NULL   , $date_from =NULL , $date_to = NULL  ,$video_search = NULL  , $user_id = NULL )
	{
		
		
		if($video_status != NULL )
		{
	   		$this->db->where( 'video.video_status' ,$video_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'video.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("video.video_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($video_search != NULL )
		{
	   		$this->db->like( 'video.video_name' ,$video_search );
	    }
		
		return $this->db->select(" video.*  " )
		->order_by('video.video_id DESC')
		->group_by( 'video.video_id' )
		->get($this->_table.' video ')
		->num_rows();
	}
	public function get_details($video_id )
	{
		return $this->db
		->select( "video.* " )
		
		->where( 'video.video_id' ,$video_id )
		->get( $this->_table.' video' )
		->row_array();
	}
	
	
	public function get_images($video_id)
	{
		return $this->db
		->select( "*" )
		
		->where( 'image.image_video_id' ,$video_id)
		->get( 'mv_video_images image' )
		->result_array();
	}

	
       
}