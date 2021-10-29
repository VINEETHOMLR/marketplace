<?php
class Admin_notification extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Notification_model','token/Token_model','pages/Settings_model') );
    }
	

	public function form( $notification_id= NULL )
	{
		$data[ 'content' ] = 'form';
		
		$this->load->view( 'admin/page' , $data );
	}
	
	public function update()
	{
		$title=	$_POST[ 'notification_title'];
		$message=	$_POST[ 'notification_message'];
		$data[ 'request_time' ]	=	$this->dbnow;

		$device_id = $this->Token_model->get_list2(1);

    	$device = array_map (function($value){
		    return $value['token_value'];
		} , $device_id);




		$fields = array("registration_ids" => $device,            // for multiple devices 
        "notification" => array( 
        "title" => $title, 
        "body" => $message,
        "message"=>$message,
        //'icon'=>'https://www.example.com/images/icon.png'
	    ),
	        "data"=>array(
	        "name"=>"",
	        'image'=>''
	        ) 
	    ); 

	    $data['notification_request']  = json_encode($fields);
	    $api=$this->Settings_model->get( 1 );


	   	
		


		
		
		$this->db->trans_begin();
        $notification_id	=	$this->Notification_model->add( $data );
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key =$api['api_key'];
        

        $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
        );

        $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	    $result = curl_exec($ch);

	    /*if ($result === FALSE) {
	        die('FCM Send Error: ' . curl_error($ch));
	    }*/
	    curl_close($ch);

	    $data=array();
	    $data['notification_response'] = $result;
	    $data['response_time'] = $this->dbnow;
	    $where['notification_id'] = $notification_id;
	    $this->Notification_model->update($data,$where);



		







	    
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again !';
		}
		else
		{
			$this->db->trans_commit();
			$msg['res']		=	1;
			$msg['msg']		=	$message;
			$msg[ 'red' ]	=	$this->base.'notifications/admin_notification/form';
		}
		echo json_encode( $msg );
	}
	
	
	
	
}