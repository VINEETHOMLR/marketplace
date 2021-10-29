<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Social_media_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_socialmedia';
		$this->primary_key	=	'id';
		$this->primary_column	=	'social_id';
	}
	
	public function get_social_media($status)
	{
		if($status!=NULL)
		{
         $this->db->where('social.social_status',$status);
		}
		return $this->db
		->select( "social.*")
		
		
		->get( $this->_table.' social' )
		->result_array();
	}


	
	
	
	
       
}