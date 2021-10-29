<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tags_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_hash_tags';
		$this->primary_key	=	'hash_tags_id';
		//$this->primary_column	=	'hash_tag_id';
	}
	public function addtags( $tags )
	{
		
		$datas	=	array();
		foreach( $tags as $tag )
		{

			//$tag = str_replace(' ', '-', $tag); // Replaces all spaces with 

            //$tag=preg_replace('/[^A-Za-z0-9\-]/', '', $tag); 
            
			$data	=	array( 'hash_tags_title' => $tag );
			$sql = $this->db->insert_string( $this->_table , $data) . ' ON DUPLICATE KEY UPDATE hash_tags_id = hash_tags_id';
			$this->db->query($sql);
		}
		
	}
	
	public function add_post_to_tag( $post_id , $tags )
	{
		foreach($tags as $k=>$v)
		{
		  $v = str_replace(' ', '-', $v);	
		  $v=preg_replace('/[^A-Za-z0-9\-]/', '', $v); 
		  $tags[$k]=$v;
         
		}	
		
		
		$this->addtags( $tags );
		$tag_ids	=	$this->db->select( 'hash_tags_id' )
		->where_in( 'hash_tags_title' , $tags )
		->get( $this->_table )
		->result_array();
		$datas = array();
		foreach( $tag_ids as $tag_id )
		{
			$data[ 'hash_tag_id' ]	=	$tag_id[ 'hash_tag_id' ];
			$data[ 'post_id' ]	=	$post_id;
			$datas[]	=	$data;
		}
		$this->db->insert_batch( 'mv_image_to_hash' , $datas ); 
		
		
		
	}
	


	
	
	
       
}