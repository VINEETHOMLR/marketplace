<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_messages';
		$this->primary_key	=	'message_id';
		$this->primary_column	=	'message_title';
	}
	
	public function get_list(  $message_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'message.message_status' , CommonStatus::ACTIVE );
		}
		else if( $message_status != NULL )
		{
	   		$this->db->where( 'message.message_status' , $message_status );
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
			->where("message.message_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" message.*  " )
		
		->order_by('message.message_id ASC')
		->group_by( 'message.message_id' )
		->get( $this->_table.' message ')
		->result_array();
	}
	
	public function get_count(  $message_status = NULL   , $date_from =NULL , $date_to = NULL  )
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'message.message_status' , CommonStatus::ACTIVE );
		}
		else if( $message_status != NULL )
		{
	   		$this->db->where( 'message.message_status' , $message_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("message.message_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" message.*  " )
		->order_by('message.message_id DESC')
		//->group_by( 'message.message_id' )
		->get($this->_table.' message ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'submessage.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'submessage.message_id' , $cat_id );
		}
		return $this->db->select(" submessage.*" )
		->group_by( 'submessage.subcat_id' )
		->get( ' mv_product_subcategories subad ')
		->result_array();
	}



	public function adlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'message.message_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" message.*  " )
		
		->group_by( 'message.message_id' )
		->get( $this->_table.' ad ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'message.message_status' , CommonStatus::ACTIVE );
		$this->db->where( 'message.message_uri' , $where );
		//$this->db->where( 'message.home_dis_order >' , 0 );
		
		//$select = " message.*  ";
		return $this->db->select(" message.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories ad', 'message.message_id = product.message_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'message.message_id' )
		->get( $this->_table.' ad ')
		->row_array();
	}
	
}