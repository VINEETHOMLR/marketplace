<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tag_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_blog_tags';
		$this->primary_key	=	'tag_id';
	}
	
	public function addtags( $tags )
	{
		
		$datas	=	array();
		foreach( $tags as $tag )
		{
			$data	=	array( 'tag_name' => $tag );
			$sql = $this->db->insert_string( $this->_table , $data) . ' ON DUPLICATE KEY UPDATE tag_id = tag_id';
			$this->db->query($sql);
		}
		
	}
	
	public function add_blog_to_tag( $blog_id , $tags )
	{
		$this->addtags( $tags );
		$tag_ids	=	$this->db->select( 'tag_id' )
		->where_in( 'tag_name' , $tags )
		->get( $this->_table )
		->result_array();
		$datas = array();
		foreach( $tag_ids as $tag_id )
		{
			$data[ 'tag_id' ]	=	$tag_id[ 'tag_id' ];
			$data[ 'blog_id' ]	=	$blog_id;
			$datas[]	=	$data;
		}
		$this->db->insert_batch( 'mv_blog_to_tag' , $datas ); 
		
		
		
	}
	
	
}