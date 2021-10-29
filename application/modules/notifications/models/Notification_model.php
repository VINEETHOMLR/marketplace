<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_notification';
		$this->primary_key	=	'notification_id';
		$this->primary_column	=	'notification_title';
	}
	
	public function get_list(  $notification_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $search = NULL  , $notification = NULL)
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'notification.notification_status' , CommonStatus::ACTIVE );
		}
		else if( $notification_status != NULL )
		{
	   		$this->db->where( 'notification.notification_status' , $notification_status );
	    }
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		if($notification!=NULL)
		{
           $this->db->where( 'notification.notification_id' , $notification );
		}

		if( $search != NULL )
		{
	   		$this->db->like( 'notification.notification_title_english' , $search );
	    }
		
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("notification.notification_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" notification.*  " )
		
		->order_by('notification.notification_sort_order ASC')
		->group_by( 'notification.notification_id' )
		->get( $this->_table.' notification ')
		->result_array();
	}
	
	public function get_count(  $notification_status = NULL   , $date_from =NULL , $date_to = NULL  , $search = NULL  , $notification = NULL)
	{
		
		
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'notification.notification_status' , CommonStatus::ACTIVE );
		}
		else if( $notification_status != NULL )
		{
	   		$this->db->where( 'notification.notification_status' , $notification_status );
	    }
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("notification.notification_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
	    
	    if($notification!=NULL)
		{
           $this->db->where( 'notification.notification_id' , $notification );
		}

		if( $search != NULL )
		{
	   		$this->db->like( 'notification.notification_title_english' , $search );
	    }
		
		
		return $this->db->select(" notification.*  " )
		->order_by('notification.notification_id DESC')
		//->group_by( 'notification.notification_id' )
		->get($this->_table.' notification ')
		->num_rows();
	}

	public function sub_dropdown( $cat_id = NULL )
	{
		if(  !Modules::run( 'login/is_admin' ) )
		{
			$this->db->where( 'subnotification.subcat_status' , CommonStatus::ACTIVE );
		}
		if( $cat_id != NULL )
		{
			$this->db->where( 'subnotification.notification_id' , $cat_id );
		}
		return $this->db->select(" subnotification.*" )
		->group_by( 'subnotification.subcat_id' )
		->get( ' mv_product_subcategories subnotification ')
		->result_array();
	}



	public function notificationlist($limit)
	{
		if($limit)
		{
        $this->db->limit($limit);
		}
		$this->db->where( 'notification.notification_status' , CommonStatus::ACTIVE );
		
		return $this->db->select(" notification.*  " )
		
		->group_by( 'notification.notification_id' )
		->get( $this->_table.' notification ')
		->result_array();
	}

	public function get_id( $where)
	{
		
		$this->db->where( 'notification.notification_status' , CommonStatus::ACTIVE );
		$this->db->where( 'notification.notification_uri' , $where );
		//$this->db->where( 'notification.home_dis_order >' , 0 );
		
		//$select = " notification.*  ";
		return $this->db->select(" notification.*  " )
		//return $this->db->select( $select )
		//->join( 'mv_product_categories notification', 'notification.notification_id = product.notification_id ', 'left' )
		//->order_by('product.home_dis_order ASC')
		//->group_by( 'notification.notification_id' )
		->get( $this->_table.' notification ')
		->row_array();
	}
	
}