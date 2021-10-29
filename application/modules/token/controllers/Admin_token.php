<?php
class Admin_token extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Token_model' ) );
    }


    public function send_notification()
    {

    	
    	$device_id = $this->Token_model->get_list2(1);

    	$arr = array_map (function($value){
		    return $value['token_value'];
		} , $device_id);
 

    	
    	
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$api_key ="AAAAXSHxoLE:APA91bGGoiFaM72sjs5sZ3lK7JhsO2jUeeqItMqLOnRYZOlxog3-9kc6muqIY65EdX7UI_PON_4Ed6pSBfMPsStCTn2K7YAcUEpaUesSRqWvIyErLTmO81gdODRaK_i6s2mxBQKLKyYD";
    	$fields = array (
        'registration_ids' => array (
                $arr
        ),
        'data' => array (
                "message" => 'ye'
        )
       );

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
	    if ($result === FALSE) {
	        die('FCM Send Error: ' . curl_error($ch));
	    }
	    curl_close($ch);
	    print_r($result);
	    return $result;




    }
	

	
	public function manage()
	{
		$data[ 'content' ]	=	'token/table';
		$this->load->view( 'admin/page' , $data );
	}


	public function list_json()
	{
		$token_status	=	$this->input->post( 'token_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$search	=	$this->input->post( 'search' );
		//$category	=	$this->input->post( 'category' );
		
		$data[ 'rows' ] = $this->Token_model->get_list(  $token_status , $limit , $start , $date_from   , $date_to,$search);
		
		$data[ 'total' ] = $this->Token_model->get_count(  $token_status , $date_from   , $date_to ,$search);
		echo json_encode( $data );
	}
	
	public function remove( $token_id )
	{
		$where[ 'token_id' ]  = $token_id;
		$this->Token_model->delete( $where );
	}
	
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'token_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Token_model->update( $data , $where ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'Status changed .';
			
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again.';
		}
		
		echo json_encode($msg);
	}
	
	
	
}