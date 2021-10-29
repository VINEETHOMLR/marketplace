<?php
class Mails extends MX_Controller
{
	var $admin_mail;
    var $from_name;
	var $from_email;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mv_mails');
        
        $this->load->model( array( 'pages/Settings_model' ) );
		$settings	=	$this->Settings_model->get( 1 );
		$this->from_email = $settings[ 'email_from' ];
		$this->from_name = $settings[ 'email_name' ];
		$this->admin_mail = $settings[ 'email_to' ];
		
			
    }
	
	public function send_message( $data )
	{
		$mail['greet'] = 'Hello Admin,';
		$mail['intro'] = 'You have recieved a Booking Enquiry  as : <br/>';
		
		$mail['table']['Packagename']	=	$data['form_packagename'];
		$mail['table']['Hotelname']	=	$data['form_hotelname'];
		$mail['table']['Vehicle']	=	$data['form_vehicle'];
		$mail['table']['Food']	=	$data['form_food'];
		$mail['table']['Budget']	=	$data['form_budget'];
		$mail['table']['Startdate']	=	$data['form_startdate'];
		$mail['table']['Enddate']	=	$data['form_enddate'];
		$mail['table']['Adult']	=	$data['form_adult'];
		$mail['table']['Child']	=	$data['form_child'];
		$mail['table']['Port']	=	$data['form_portofarival'];
		
		$mail['table']['FirstName']	=	$data['form_fname'];
		$mail['table']['LastName']	=	$data['form_lname'];
		$mail['table']['Email']	=	$data['form_email'];
		$mail['table']['Phone']	=	$data['form_phone'];
		$mail['table']['Facebookid']	=	$data['form_facebookid'];
		$mail['table']['Whatsapp']	=	$data['form_whatsapp'];
		$mail['table']['Comments']	=	$data['form_comments'];






        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( ADMIN_MAIL , $message , 'Recieved new Booking enquiry'  , false );
        $mail = array();
        $mail['greet'] = 'Hello '.$data['form_fname'].',';
		$mail['intro'] = 'We have received your Enquiry, will get in touch with you soon. ';
        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $data['form_email'] , $message , 'Thank You'  , false );
	}

	public function book_now( $data )

	{

		
		$mail['greet'] = 'Hello Admin,';
		$mail['intro'] = 'You have recieved a query  as : <br/>';
		
		
		$mail['table']['Name']	=	$data['name'];
		
		$mail['table']['Email']	=	$data['email'];
		
		$mail['table']['Phone']	=	$data['phone'];
		
		$mail['table']['Message']	=	$data['message'];
		



        $message       = $this->load->view('mail_template', $mail, true);
        if($this->mv_mails->mail_send( $this->admin_mail , $message , 'Recieved new query'  , false ))
        {
        	return true;
        }
        else
        {
        	return false;
        }
        
	}


	public function send_query( $data )

	{

		
		$mail['greet'] = 'Hello Admin,';
		$mail['intro'] = 'You have recieved a query  as : <br/>';
		
		
		$mail['table']['First Name']	=	$data['first_name'];
		$mail['table']['Last  Name']	=	$data['last_name'];
		$mail['table']['Email']	=	$data['email'];
		
		$mail['table']['Phone']	=	$data['phone'];
		$mail['table']['Message']	=	$data['message'];




        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->admin_mail , $message , 'Recieved new query'  , false );
        $mail = array();
        $mail['greet'] = 'Hello '.$data['first_name'].',';
		$mail['intro'] = 'We have received your Enquiry, will get in touch with you soon. ';
        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $data['email'] , $message , 'Thank You'  , false );
	}

	public function send_query_header( $data )

	{

		
		$mail['greet'] = 'Hello Admin,';
		$mail['intro'] = 'You have recieved a query  as : <br/>';
		
		
		$mail['table']['Name']	=	$data['name'];
		$mail['table']['Email']	=	$data['email'];
		$mail['table']['Message']	=	$data['message'];




        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->admin_mail , $message , 'Recieved new query'  , false );
        $mail = array();
        $mail['greet'] = 'Hello '.$data['fname'].',';
		$mail['intro'] = 'We have received your Enquiry, will get in touch with you soon. ';
        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $data['email'] , $message , 'Thank You'  , false );
	}
	
	public function request_call_back( $data )
	{
		$mail['greet'] = 'Hello Admin,';
		$mail['intro'] = 'You have recieved a new enquiry as : <br/>';
		$mail['table']['First Name']		= $data['first_name'];
		$mail['table']['Last Name']		= $data['last_name'];
		$mail['table']['Email']		= $data['email'];
		$mail['table']['Phone']	= $data['phone'];
		$mail['table']['Location']	= $data['location'];
		$mail['table']['Category']	= $data['category'];
		$mail['table']['ADDITIONAL INFORMATION']	= $data['addition_info'];
        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( ADMIN_MAIL , $message , 'New Request Call back'  , false );
	}
	
	public function send_mail_to_contact( $subject , $greet , $content , $email )
	{
		$mail['greet'] = $greet;
		$mail['intro'] = $content;
		$message       = $this->load->view('mail_template', $mail, true);
		$this->mv_mails->mail_send( $email , $message , $subject  , false );
	}
	public function send_mail_free_consultation( $data )

	{

		
		$mail['greet'] = 'Hello Admin,';
		$mail['intro'] = 'You have recieved a query  as : <br/>';
		
		
		$mail['table']['Name']	=	$data['name'];
		$mail['table']['Phone']	=	$data['phone'];
		$mail['table']['Email']	=	$data['email'];
		
		$mail['table']['How much do you owe?']	=	$data['owe'];
		$mail['table']['I need help with ']	=	$data['help'];
		$mail['table']['Information']	=	$data['information'];




        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $this->admin_mail , $message , 'Recieved new query'  , false );
        $mail = array();
        $mail['greet'] = 'Hello '.$data['fname'].',';
		$mail['intro'] = 'We have received your Enquiry, will get in touch with you soon. ';
        $message       = $this->load->view('mail_template', $mail, true);
        $this->mv_mails->mail_send( $data['email'] , $message , 'Thank You'  , false );
	}
	

}






