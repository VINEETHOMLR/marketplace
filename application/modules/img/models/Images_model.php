<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Images_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_images';
		$this->primary_key	=	'image_id';
	}
	
	public function get_list($image_ref_id= NULL , $image_content_type= NULL ,  $image_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $image_ref_id != NULL )
		{
	   		$this->db->where( 'images.image_ref_id' , $image_ref_id );
	    }
		
		if( $image_content_type != NULL )
		{
	   		$this->db->where( 'images.image_content_type' , $image_content_type );
	    }
		
		if( $image_status != NULL )
		{
	   		$this->db->where( 'images.image_status' , $image_status );
	    }
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("images.image_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		return $this->db->select(" images.*  " )
		->order_by('images.image_id DESC')
		->group_by( 'images.image_id' )
		->get( $this->_table.' images ')
		->result_array();
	}
	
	public function get_count(  $image_ref_id= NULL , $image_content_type= NULL, $image_status = NULL   , $date_from =NULL , $date_to = NULL  , $log_status = NULL  , $log_status  = NULL , $student_search = NULL )
	{
		
		
		if( $image_ref_id != NULL )
		{
	   		$this->db->where( 'images.image_ref_id' , $image_ref_id );
	    }
		
		if( $image_content_type != NULL )
		{
	   		$this->db->where( 'images.image_content_type' , $image_content_type );
	    }
		
		if( $image_status != NULL )
		{
	   		$this->db->where( 'images.image_status' , $log_status );
	    }
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("images.image_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		return $this->db->select(" images.*  " )
		->order_by('images.image_id ASC')
		->order_by('images.image_is_main DESC')
		->group_by( 'images.image_id' )
		->get( $this->_table.' images ')
		->num_rows();
	}
	
	public function add_images(  $images = array() )
	{
		if( !sizeof($images) ) return;
		$sql = "INSERT INTO {$this->_table} ( image_name , image_content_type , image_ref_id , image_alt_text , image_is_main ) values ";
		foreach($images as $row)
		{
			$valuesArr[] = "(  '".trim($row['image_name' ])."' , '".trim($row['image_content_type' ])."' , '".trim($row['image_ref_id' ])."' , '".trim($row['image_alt_text' ])."' , '".trim($row['image_is_main' ])."'  )";
		}
		$sql .= implode(',', $valuesArr);
		$this->db->query( $sql );
	}
	
}