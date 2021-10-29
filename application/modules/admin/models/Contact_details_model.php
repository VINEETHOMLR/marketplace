<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_details_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_contact_details';
		$this->primary_key	=	'contact_id';
		$this->primary_column	=	'contact_address';
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