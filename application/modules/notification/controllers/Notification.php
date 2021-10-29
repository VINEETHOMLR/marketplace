<?php
class Notification extends MX_Controller {

		public function __construct()
		{
			parent::__construct();
			$this->load->model(array(  'Notification_model' ));
		}
		
		public function json()
		{
			$where[ 'user_id' ]	=	$this->user[ 'id' ];
			$where[ 'notification_status' ]	=	NotificationStatus::PENDING;
			$notifications	=	$this->Notification_model->get_list( $this->user[ 'id' ] , array(NotificationStatus::PENDING,NotificationStatus::READ,NotificationStatus::DONE) , NULL , 10 , NULL , NULL , NULL  );
			$data[ 'count' ] = $this->Notification_model->get_count( $this->user[ 'id' ] , array(NotificationStatus::PENDING ) );
			$display[ 'notifications' ] = $notifications;
			$data[ 'display' ] = $this->load->view( 'menu_display' , $display , TRUE );
			echo json_encode( $data );
			
		}
		
		public function countn( $user_id = NULL )
		{
			$user_id = $user_id == NULL ? $this->user['id'] : $user_id;
			$where[ 'user_id' ]	=	$user_id;
			$where[ 'notification_status' ]	=	NotificationStatus::PENDING;
			echo $this->Notification_model->countn( $where );
		}
		
		public function create( $user_id , $notification_description , $notification_link =  '' , $notification_type = NotificationTypes::NOTFICATION )
		{
			$data[ 'user_id' ]	=	$user_id;
			$data[ 'notification_status' ]	=	NotificationStatus::PENDING;
			$data[ 'notification_type' ]	=	$notification_type;
			$data[ 'notification_description' ]	=	$notification_description;
			$data[ 'notification_link	' ]	=	($notification_link);
			$data[ 'notification_join_date	' ]	=	$this->dbnow;
			$this->Notification_model->add( $data );
		}
		
		public function notifications_block( $notification_status = array()   , $notification_type = NotificationTypes::NOTFICATION , $limit = 5 , $start = 0 )
		{
			
			$rows	=	$this->Notification_model->get_list( $this->user[ 'id' ] ,$notification_status ,  $notification_type  , $limit , $start );
			$data[ 'notifications' ]	=	$rows;
			$this->load->view('notifications_block' , $data);
			
		}
		
		public function read( $notification_id , $notification_link )
		{
			$where[ 'notification_link' ]	=	$notification_link;
			$where[ 'user_id' ]	=	$this->user[ 'id' ];
			$data[ 'notification_status' ]	=	NotificationStatus::READ;
			$this->Notification_model->update( $data , $where );
			redirect(base64_url_decode($notification_link));
		}

		public function remove(  $notification_link , $user_id )
		{
			$where[ 'notification_link' ]	=	$notification_link;
			$where[ 'user_id' ]	=	$user_id;
			$this->Notification_model->delete( $where );
		}
		
		public function elist()
		{
			$rows	=	$this->Notification_model->get_list( $this->user[ 'id' ] ,NULL ,  NotificationTypes::NOTFICATION );
			//echo "<pre>";print_r($rows);exit();
			$data[ 'rows' ] = $rows;
			$data[ 'content' ] = 'elist';
			$this->load->view( 'public/page' , $data );
		}
		
}