<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Seo_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_seo';
		$this->primary_key	=	'seo_id';
	}
	
	public function get_seo( $content_ref_id , $content_type, $seo_status = NULL )
	{
		if( $seo_status != NULL )
		{
			$this->db->where( 'seo_status' , $seo_status ) ;
		}
		return $this->db->select( '*' )
		->where( 'content_ref_id' , $content_ref_id ) 
		->where( 'content_type' , $content_type )
		->get( $this->_table ) 
		->row_array();
	}
	
}