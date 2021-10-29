<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_notifications';
		$this->primary_key	=	'notification_id';
		$this->primary_column	=	'user_id';
	}
	
	public function get_list(  $user_id = NULL , $notification_status = NULL , $notification_type = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL   ,   $group_by = NULL )
	{
		
		
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
			->where("user.user_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if (is_array($notification_status) or ($notification_status instanceof Traversable))
		{
			$i	=	0;
			$this->db->group_start();
			foreach( $notification_status as $v )
			{
				$i++;
				$where = $i > 1 ? 'or_where' : 'where';
				$this->db->$where( 'notification.notification_status' , $v );
			}
			$this->db->group_end();
		}
		else
		if( $notification_status != NULL )
		{
			$this->db->where( 'notification.notification_status' , $notification_status );
		}
		if( $user_id != NULL )
		{
			$this->db->where( 'notification.user_id' , $user_id );
		}
		
		
		
		if( $group_by != NULL )
		{
			$this->db->group_by( 'notification.'.$group_by );
		}
		else
		{
			$this->db->group_by( 'notification.notification_id' );
		}
		
		
		return $this->db->select(' notification.* ' )
		->from( $this->_table.' notification ')
		->order_by( 'notification.notification_status ASC , notification.notification_id DESC ' )
		//->order_by( 'notification.notification_status DESC' )
		->get()->result_array();
	}
	
	public function get_count(  $user_id = NULL , $notification_status = NULL , $notification_type = NULL ,  $date_from =NULL , $date_to = NULL   ,   $group_by = NULL )
	{
		
		
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("user.user_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if (is_array($notification_status) or ($notification_status instanceof Traversable))
		{
			$i	=	0;
			$this->db->group_start();
			foreach( $notification_status as $v )
			{
				$i++;
				$where = $i > 1 ? 'or_where' : 'where';
				$this->db->$where( 'notification.notification_status' , $v );
			}
			$this->db->group_end();
		}
		else
		if( $notification_status != NULL )
		{
			$this->db->where( 'notification.notification_status' , $notification_status );
		}
		if( $user_id != NULL )
		{
			$this->db->where( 'notification.user_id' , $user_id );
		}
		
		
		
		if( $group_by != NULL )
		{
			$this->db->group_by( 'notification.'.$group_by );
		}
		else
		{
			$this->db->group_by( 'notification.notification_id' );
		}
		
		
		return $this->db->select(' notification.* ' )
		->get($this->_table.' notification ')
		->num_rows();
	}
	
	
	
	
}