<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_gallery';
		$this->primary_key	=	'gallery_id';
	}
	
	public function get_list( $gallery_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $gallery_search = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		
		if( $gallery_status != NULL )
		{
	   		$this->db->where( 'images.gallery_status' , $gallery_status );
	    }
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("images.gallery_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		return $this->db->select(" images.*  " )
		->order_by('images.gallery_id DESC')
		->group_by( 'images.gallery_id' )
		->get( $this->_table.' images ')
		->result_array();
	}
	
	public function get_count(   $gallery_status = NULL   , $date_from =NULL , $date_to = NULL  , $gallery_search = NULL )
	{
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("images.gallery_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		return $this->db->select(" images.*  " )
		->order_by('images.gallery_id DESC')
		->group_by( 'images.gallery_id' )
		->get( $this->_table.' images ')
		->num_rows();
	}
	
	public function add_images(  $images = array() )
	{
		if( !sizeof($images) ) return;
		$sql = "INSERT INTO {$this->_table} ( gallery_name , gallery_content_type , gallery_ref_id , gallery_alt_text , gallery_is_main ) values ";
		foreach($images as $row)
		{
			$valuesArr[] = "(  '".trim($row['gallery_name' ])."' , '".trim($row['gallery_content_type' ])."' , '".trim($row['gallery_ref_id' ])."' , '".trim($row['gallery_alt_text' ])."' , '".trim($row['gallery_is_main' ])."'  )";
		}
		$sql .= implode(',', $valuesArr);
		$this->db->query( $sql );
	}
	
}