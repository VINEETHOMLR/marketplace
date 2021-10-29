<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mv_mails extends MX_Controller {
		
		public $admin_mail;
		public $from_email;
		public $from_name;
		
        public function __construct(){
			parent::__construct();
			
			$this->load->model( array( 'pages/Settings_model' ) );
			$settings	=	$this->Settings_model->get( 1 );


			
			$config = Array(
					'protocol' => 'smtp',
					//'smtp_host' => 'localhost',
					'smtp_host' => $settings[ 'host' ],
					'smtp_port' => $settings[ 'port' ], 
					'smtp_user' => $settings[ 'email_from' ], // change it to yours
					'smtp_pass' => $settings[ 'email_password' ], // change it to yours
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'SMTPSecure' => 'tls',
					'SMTPAuth' => TRUE,
					'crlf' => "\r\n",
					'newline' => "\r\n"
					);
			$this->from_email = $settings[ 'email_from' ];
			$this->from_name = $settings[ 'email_name' ];
			$this->admin_mail = $settings[ 'email_to' ];
			
			$this->load->library('email', $config);
			$this->email->set_mailtype("html");
		}
		
	/*---------------------------------------------------------------------------------------------------------*/
		
		public function mail_send( $to , $message  ,$subjct , $cc_admin = NULL  ){
			$this->email->set_newline("\r\n");
			$this->email->from( $this->from_email  , $this->from_name ); // change it to yours
			$this->email->to("$to");// change it to yours
			$this->email->subject("$subjct");
			$this->email->message($message);
			if( $cc_admin != NULL )
			{
				$this->email->cc($this->admin_mail);
			}
			if($this->email->send())
			{
				return true;
			}
			else
			{
				return false;
			}
			
	}	
}