<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_astrologer_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_astrologers';
		$this->primary_key	=	'user_id';
		$this->primary_column	=	'astrologer_id';
	}
	
	public function get_list(  $service_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,   $astrologer_search = NULL  )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if (is_array($service_status) or ($service_status instanceof Traversable))
		{
			$i	=	0;
			foreach( $service_status as $v )
			{
				$i++;
				$where = $i > 1 ? 'or_where' : 'where';
				$this->db->$where( 'astrologer.service_status' , $v );
			}
		}
		else
		if( $service_status != NULL )
		{
			$this->db->where( 'astrologer.service_status' , $service_status );
		}
		
		
				
		if( $astrologer_search != NULL )
		{
	   		$this->db->like( 'user.first_name' , $astrologer_search );
			$this->db->or_like( 'user.email' , $astrologer_search );
			$this->db->or_like( 'user.phone' , $astrologer_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("astrologer.astrologer_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		
		return $this->db->select(" astrologer.* , user.* ,
		group_concat( CONCAT( services.service_id,'-',services.service_rate,'-',services.service_overall_rating )) as services
		" )
		->join( 'mv_users user', 'user.id = astrologer.user_id' , 'inner' )
		->join( 'mv_astrologer_services services' , 'user.id = services.user_id AND services.service_status='.CommonStatus::ACTIVE , 'left' )
		->order_by('astrologer.astrologer_id DESC')
		->group_by( 'astrologer.astrologer_id' )
		->get( $this->_table.' astrologer ' )
		->result_array();
	}
	
	public function get_count(  $service_status = NULL   , $date_from =NULL , $date_to = NULL   , $astrologer_search = NULL  )
	{
		
		
		if (is_array($service_status) or ($service_status instanceof Traversable))
		{
			$i	=	0;
			foreach( $service_status as $v )
			{
				$i++;
				$where = $i > 1 ? 'or_where' : 'where';
				$this->db->$where( 'astrologer.service_status' , $v );
			}
		}
		else
		if( $service_status != NULL )
		{
			$this->db->where( 'astrologer.service_status' , $service_status );
		}
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("astrologer.astrologer_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if( $astrologer_search != NULL )
		{
	   		$this->db->like( 'user.first_name' , $astrologer_search );
			$this->db->or_like( 'user.email' , $astrologer_search );
			$this->db->or_like( 'user.phone' , $astrologer_search );
	    }
		
		return $this->db->select(" astrologer.*  " )
		->join( 'mv_users user', 'user.id = astrologer.user_id' , 'inner' )
		->order_by('astrologer.astrologer_id DESC')
		->group_by( 'astrologer.astrologer_id' )
		->get($this->_table.' astrologer ')
		->num_rows();
	}
	
	public function get_astrologer( $astrologer_id )
	{
		$user_fields	=	array(
		'id' , 'first_name' , 'last_name' , 'image' , 'city'
		);
		array_walk($user_fields, function(&$value, $key) { $value = 'user.'.$value; });
		return $this->db
		->select( "astrologer.*   , ".implode( ',' , $user_fields )." , 
		group_concat( CONCAT( services.service_id,'-',services.service_rate,'-',services.service_overall_rating )) as services
		" )
		->join( 'mv_users user', 'user.id = astrologer.user_id' , 'inner' )
		->join( 'mv_astrologer_services services' , 'user.id = services.user_id AND services.service_status='.CommonStatus::ACTIVE , 'left' )
		->where( 'astrologer.user_id' , $astrologer_id )
		->get( $this->_table.' astrologer' )
		->row_array();
	}
	
	public function get_fee( $astrologer_id , $service_id  )
	{
		return $this->db
		->where( 'user_id' , $astrologer_id )
		->where( 'service_id' , $service_id )
		->where( 'service_status' , CommonStatus::ACTIVE )
		->from( 'mv_astrologer_services' )
		->get()->row('service_rate');
	}
	
	
       
}