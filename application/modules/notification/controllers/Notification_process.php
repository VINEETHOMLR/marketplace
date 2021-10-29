<?php
class Notification_process extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(  'Notification_model' ));
		$this->load->library('mv_mails');
	}
	
	public function forgot_password($user , $reset_link)
	{
		$mail['greet'] = "Hello {$user[ 'first_name' ]} ,";
		$mail['intro'] = 'Please click on the link provided to reset your password:<br/>';
		$mail[ 'content' ]	='<a href="'.$reset_link.'">Clik to reset password</a>';
        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $user[ 'email' ] , $message , 'Reset password'  , false );
		$msg[ 'type' ]	=	'success';
		$msg['msg']		=	'<strong>Email Sent !</strong><br/>  Please check your Email to verify your email id.';
		$this->session->set_flashdata('msg', $msg );

	}

	public function send_email_ver_link( $direct = TRUE )
	{
		$this->ion_auth->deactivate($this->user[ 'id' ]);
		$this->ion_auth->activate($this->user[ 'id' ]);
		$activation_code = $this->ion_auth_model->activation_code;
		$activation_link = base64_url_encode( $this->base.'user/user_profile/check_email_ver/'.$activation_code );
		$mail['greet'] = "Hello {$this->user[ 'first_name' ]} ,";
		$mail['intro'] = 'Please click on the link provided to verify your email ID :<br/>';
		$mail[ 'content' ]	='<a href="'.$this->base.'login/index/'.$activation_link.'">Clik to verify</a>';
        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->user[ 'email' ] , $message , 'Email Verification'  , false );
		$msg[ 'type' ]	=	'success';
		$msg['msg']		=	'<strong>Email Sent !</strong><br/>  Please check your inbox to verify your email Id.';
		$this->session->set_flashdata('msg', $msg );
		if( $direct )
		redirect( $this->base.'email-verification' );
	}
	
	public function user_registration_noty( $direct = TRUE )
	{
		
		$mail['greet'] = "Hello {$this->user[ 'first_name' ]} ,";
		$mail['intro'] = 'User registartion success :<br/>';
		$mail[ 'content' ]	='Thank you !';
        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->user[ 'email' ] , $message , 'Welcome'  , false );
		$msg[ 'type' ]	=	'success';
		$msg['msg']		=	'Successfully registered.';
		$this->session->set_flashdata('msg', $msg );
		
	}	

	
	
	public function user_registration( $data )
	{
		$this->user_registration_noty( $data );
		//$this->send_email_ver_link( FALSE );
	}

	public function referral_complete( $ref_id )
	{
		$this->load->model( 'referrals/Referral_model' );
		$data = $this->Referral_model->get( $ref_id );
		$user = $this->ion_auth->user( $data[ 'user_id' ] )->row_array();
		$exp_user = $this->ion_auth->user( $data[ 'ref_exp_user_id' ] )->row_array();
		$ref_user = NULL;
		if( isset($data[ 'ref_user_id' ]) && $data[ 'ref_user_id' ] > 0 )
		{
			$ref_user = $this->ion_auth->user( $data[ 'ref_user_id' ] )->row_array();
			$this->ref_comp_ref_user( $data , $user , $exp_user , $ref_user );
		}
		
		$this->ref_comp_exp_user( $data , $user , $exp_user , $ref_user );
		$this->ref_comp_user( $data , $user , $exp_user , $ref_user );
		
	}

	public function ref_comp_ref_user( $data , $user , $exp_user , $ref_user )
	{
		$notification_link	=	base64_url_encode($this->base.'referral-box/incentives-received');
		$mail['greet'] = "Hello {$ref_user[ 'first_name' ]} ,";
		$mail['intro'] = 'One of your referrals completed :<br/>';
		$mail[ 'content' ]	= " The Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" you referred has completed by {$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]}";

        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $ref_user[ 'email' ] , $message , 'Referral completed'  , false );

        $notification_description = " The Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" you referred has  been completed by {$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]}. Please contact business owner to claim your incentive.";
        Modules::run( 'notification/create' , $ref_user[ 'id' ] , $notification_description , $notification_link );
	}

	public function ref_comp_exp_user( $data , $user , $exp_user , $ref_user )
	{
		$notification_link	=	base64_url_encode($this->base.'referral-box/myexperts');
		$mail['greet'] = "Hello {$exp_user[ 'first_name' ]} ,";
		$mail['intro'] = "You have completed the Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" ";
		if($ref_user)
		{
			$mail[ 'content' ]	=" Referrer : {$ref_user[ 'first_name' ]} {$ref_user[ 'last_name' ]}";
		}

        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $exp_user[ 'email' ] , $message , 'Referral completed'  , false );

        $notification_description = "{$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]} has completed  Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" ";;
        Modules::run( 'notification/create' , $exp_user[ 'id' ] , $notification_description , $notification_link );
	}

	public function ref_comp_user( $data , $user , $exp_user , $ref_user )
	{
		$notification_link	=	base64_url_encode($this->base.'referral/details/'.$data[ 'ref_db_id' ]);
		$mail['greet'] = "Hello {$user[ 'first_name' ]} ,";
		$mail['intro'] = "{$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]} have completed the Business/Expertise -  \"{$data[ 'ref_exp_name' ]}\" by {$exp_user[ 'first_name' ]} {$exp_user[ 'last_name' ]}";

		
        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->user[ 'email' ] , $message , 'Referral completed'  , false );

        $notification_description = "{$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]} have completed the Business/Expertise -  \"{$data[ 'ref_exp_name' ]}\" by {$exp_user[ 'first_name' ]} {$exp_user[ 'last_name' ]}";
        Modules::run( 'notification/create' , $user[ 'id' ] , $notification_description , $notification_link );
	}
	/*-------------------------------------------------*/

	public function referral_registration( $data )
	{
		$user = $this->ion_auth->user( $data[ 'user_id' ] )->row_array();
		$exp_user = $this->ion_auth->user( $data[ 'ref_exp_user_id' ] )->row_array();
		$ref_user = NULL;
		if( isset($data[ 'ref_user_id' ]) )
		{
			$ref_user = $this->ion_auth->user( $data[ 'ref_user_id' ] )->row_array();
			$this->referral_ref_user( $data , $user , $exp_user , $ref_user );
		}
		
		$this->referral_exp_user( $data , $user , $exp_user , $ref_user );
		$this->referral_user( $data , $user , $exp_user , $ref_user );
		
	}

	public function referral_ref_user( $data , $user , $exp_user , $ref_user )
	{
		$notification_link	=	base64_url_encode($this->base.'referral-box/incentives-received');
		$mail['greet'] = "Hello {$ref_user[ 'first_name' ]} ,";
		$mail['intro'] = 'One of your referrals got success :<br/>';
		$mail[ 'content' ]	= " The Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" you referred has selected by {$user[ 'first_name' ]} {$user[ 'last_name' ]}";

        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $ref_user[ 'email' ] , $message , 'Referral Success'  , false );

        $notification_description = " The Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" you referred has  been selected by {$user[ 'first_name' ]} {$user[ 'last_name' ]}";
        Modules::run( 'notification/create' , $ref_user[ 'id' ] , $notification_description , $notification_link );
	}

	public function referral_exp_user( $data , $user , $exp_user , $ref_user )
	{
		$notification_link	=	base64_url_encode($this->base.'referral-box/myexperts');
		$mail['greet'] = "Hello {$exp_user[ 'first_name' ]} ,";
		$mail['intro'] = "{$user[ 'first_name' ]} {$user[ 'last_name' ]} has Selected your  Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" ";
		if($ref_user)
		{
			$mail[ 'content' ]	=" Referrer : {$ref_user[ 'first_name' ]} {$ref_user[ 'last_name' ]}";
		}

		$table[ 'name' ] = "{$user[ 'first_name' ]} {$user[ 'last_name' ]}";
		$table[ 'email' ] = $user[ 'email' ];
		$table[ 'phone' ] = $user[ 'phone' ] ? $user[ 'phone' ] : '-NA-';
		$mail['table']	=	$table;
		
		

        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $exp_user[ 'email' ] , $message , 'Referral Success'  , false );

        $notification_description = "{$user[ 'first_name' ]} {$user[ 'last_name' ]} has Selected your  Business/Expertise - \"{$data[ 'ref_exp_name' ]}\" ";;
        Modules::run( 'notification/create' , $exp_user[ 'id' ] , $notification_description , $notification_link );
	}

	public function referral_user( $data , $user , $exp_user , $ref_user )
	{
		$notification_link	=	base64_url_encode($this->base.'referral/details/'.$data[ 'ref_db_id' ]);
		$mail['greet'] = "Hello {$user[ 'first_name' ]} ,";
		$mail['intro'] = "You have selected the Business/Expertise -  \"{$data[ 'ref_exp_name' ]}\" by {$exp_user[ 'first_name' ]} {$exp_user[ 'last_name' ]}";

		$table[ 'name' ] = "{$exp_user[ 'first_name' ]} {$exp_user[ 'last_name' ]}";
		$table[ 'email' ] = $exp_user[ 'email' ];
		$table[ 'phone' ] = $exp_user[ 'phone' ] ? $exp_user[ 'phone' ] : '-NA-';
		$mail['table']	=	$table;
		

        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->user[ 'email' ] , $message , 'Expertise Details'  , false );

        $notification_description = "You have selected the Business/Expertise -  \"{$data[ 'ref_exp_name' ]}\" by {$exp_user[ 'first_name' ]} {$exp_user[ 'last_name' ]}";
        Modules::run( 'notification/create' , $user[ 'id' ] , $notification_description , $notification_link );
	}
	
	public function team_change_status(  $user_id , $status  )
	{
		if( $status > 2 )
		{
			return;
		}
		$notification_link = $status == TeamStatus::ACCEPTED ? $this->base.'team/members' : $this->base.'team/requests';
		$notification_link	=	base64_url_encode($notification_link);
		$user = $this->ion_auth->user( $user_id )->row_array();
		$notification_description = "You have received a friend request from {$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]}";
                 $subjectemail="Member Request";
		if( $status == TeamStatus::ACCEPTED )
		{
			$notification_description = "Your Member request has been accepted {$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]}";
$subjectemail="Member Request Accepted";
		}

		$mail['greet'] = "Hello {$user[ 'first_name' ]} ,";
		$mail['intro'] = $notification_description;

        $message       = $this->load->view('mails/mail_template', $mail, true);
        $this->mv_mails->mail_send( $user[ 'email' ] , $message , $subjectemail  , false );

        Modules::run( 'notification/create' , $user[ 'id' ] , $notification_description , $notification_link );

	}


	public function expertise_add( $data )
	{

		$notification_link = $this->base.'expertise-details/'.$data[ 'exp_uri' ];
		$notification_link	=	base64_url_encode($notification_link);
		
		$notification_description = "{$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]} Added a new expertise";

		$mail['greet'] = "Hello {$user[ 'first_name' ]} ,";
		$mail['intro'] = $notification_description;
		$mail[ 'button' ][ 'text' ] = 'View expertise';
		$mail[ 'button' ][ 'link' ] =  $this->base.'expertise-details/'.$data[ 'exp_uri' ];
        $message       = $this->load->view('mails/mail_template', $mail, true);

        $list = Modules::run( 'team/brodacast_list' , TeamStatus::ACCEPTED );

        foreach ($list as $key => $user_id) {
        	$user = $this->ion_auth->user( $user_id )->row_array();
	        $this->mv_mails->mail_send( $user[ 'email' ] , $message , 'Expertise Added'  , false );
	        Modules::run( 'notification/create' , $user[ 'id' ] , $notification_description , $notification_link );
        }

        
	}

	public function message_add( $data )
	{
		$user = $this->ion_auth->user( $data[ 'reciever_id' ] )->row_array();
		$notification_link = $this->base.'comments?rxd_id='.$data[ 'user_id' ];
		$notification_link	=	base64_url_encode($notification_link);
		
		$notification_description = "{$this->user[ 'first_name' ]} {$this->user[ 'last_name' ]} send you a  message";

		$mail['greet'] = "Hello {$user[ 'first_name' ]} ,";
		$mail['intro'] = $notification_description;
		$mail[ 'button' ][ 'text' ] = 'View message';
		$mail[ 'button' ][ 'link' ] =  $this->base.'comments?rxd_id='.$data[ 'user_id' ];
        $message       = $this->load->view('mails/mail_template', $mail, true);

        $list = Modules::run( 'team/brodacast_list' , TeamStatus::ACCEPTED );
        Modules::run( 'notification/create' , $user[ 'id' ] , $notification_description , $notification_link );
        $this->mv_mails->mail_send( $user[ 'email' ] , $message , 'Message received'  , false );
	}
		
}