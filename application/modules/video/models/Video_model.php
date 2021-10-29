<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Video_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_videos';
		$this->primary_key	=	'video_id';
	}
	
	public function get_list($video_ref_id= NULL , $video_content_type= NULL ,  $video_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $video_ref_id != NULL )
		{
	   		$this->db->where( 'videos.video_ref_id' , $video_ref_id );
	    }
		
		if( $video_content_type != NULL )
		{
	   		$this->db->where( 'videos.video_content_type' , $video_content_type );
	    }
		
		if( $video_status != NULL )
		{
	   		$this->db->where( 'videos.video_status' , $video_status );
	    }
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("videos.video_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		return $this->db->select(" videos.*  " )
		->order_by('videos.video_id DESC')
		->group_by( 'videos.video_id' )
		->get( $this->_table.' videos ')
		->result_array();
	}
	
	public function get_count(  $video_ref_id= NULL , $video_content_type= NULL, $video_status = NULL   , $date_from =NULL , $date_to = NULL  , $log_status = NULL  , $log_status  = NULL , $student_search = NULL )
	{
		
		
		if( $video_ref_id != NULL )
		{
	   		$this->db->where( 'videos.video_ref_id' , $video_ref_id );
	    }
		
		if( $video_content_type != NULL )
		{
	   		$this->db->where( 'videos.video_content_type' , $video_content_type );
	    }
		
		if( $video_status != NULL )
		{
	   		$this->db->where( 'videos.video_status' , $log_status );
	    }
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("videos.video_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		return $this->db->select(" videos.*  " )
		->order_by('videos.video_id ASC')
		->order_by('videos.video_is_main DESC')
		->group_by( 'videos.video_id' )
		->get( $this->_table.' videos ')
		->num_rows();
	}
	

	public function home_videos( )
	{
		
		//$this->db->where( 'videos.video_status' , 0);
		
		
		return $this->db->select(" videos.*  " )
		
		->get( $this->_table.' videos ')
		->result_array();
	}
	public function add_videos(  $videos = array() )
	{
		if( !sizeof($videos) ) return;
		$sql = "INSERT INTO {$this->_table} ( video_name , video_content_type , video_ref_id , video_alt_text , video_is_main ) values ";
		foreach($videos as $row)
		{
			$valuesArr[] = "(  '".trim($row['video_name' ])."' , '".trim($row['video_content_type' ])."' , '".trim($row['video_ref_id' ])."' , '".trim($row['video_alt_text' ])."' , '".trim($row['video_is_main' ])."'  )";
		}
		$sql .= implode(',', $valuesArr);
		$this->db->query( $sql );
	}
	
}