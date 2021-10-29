<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Health_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_health';
		$this->primary_key	=	'health_id';
		$this->primary_column	=	'health_title';
	}
	
	public function get_list(  $health_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'health.health_status' , CommonStatus::ACTIVE );
		}
		else if( $health_status != NULL )
		{
	   		$this->db->where( 'health.health_status' , $health_status );
	    }
		
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
			->where("health.health_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" health.*  " )
		
		->order_by('health.health_id ASC')
		->group_by( 'health.health_id' )
		->get( $this->_table.' health ')
		->result_array();
	}
	
	public function get_count(  $health_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'health.health_status' , CommonStatus::ACTIVE );
		}
		else if( $health_status != NULL )
		{
	   		$this->db->where( 'health.health_status' , $health_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("health.health_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" health.*  " )
		->order_by('health.health_id DESC')
		//->group_by( 'health.health_id' )
		->get($this->_table.' health ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subhealth.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subhealth.health_id' , $cat_id );
		}
		return $this->db->select(" subhealth.*" )
		->group_by( 'subhealth.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'health.health_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" health.*  " )
		
		->group_by( 'health.health_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'health.health_status' , CommonStatus::ACTIVE );
		$this->db->where( 'health.health_uri' , $where );
		//$this->db->where( 'health.home_dis_order >' , 0 );
		
		//$select = " health.*  ";
		return $this->db->select(" health.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'health.health_id = product.health_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'health.health_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}