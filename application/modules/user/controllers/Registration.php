<?php
class Registration extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->posted=$this->input->post(NULL, TRUE);
			
		}
		
		public function index( $red	= NULL , $group = NULL )
		{
			if( Modules::run( 'login/is_logged' ) )
			{
				redirect( $this->base.'login' );
				exit;
			}
			$data['group']		=	$group;
			$data['red']		=	$red;
			$data['content']	=	'registration/form';
			$this->load->view('public/page',$data);
		}
		
		public function form( $red = NULL )
		{
			if( Modules::run( 'login/is_logged' ) )
			{
				redirect( $this->base.'login' );
				exit;
			}
			$data['red']		=	$red!=NULL ?  $red : NULL ;
			$data['content']	=	'registration/form';
			$this->load->view('registration/form',$data);
		}
		
		public function register(  )
		{
			//echo '<pre>';print_r($this->posted);echo '</pre>';
			if( Modules::run( 'login/is_logged' ) )
			{
				redirect( $this->base.'login' );
				exit;
			}
			$data[ 'first_name' ]	=	$this->input->post( 'first_name' );
			$data[ 'email' ]	=	$this->input->post( 'email' );
			$data[ 'phone' ]	=	$this->input->post( 'phone' );
			$data[ 'password' ]	=	$this->input->post( 'password' );
			
			if (  $this->form_validation->run('user/registration/register') == FALSE )
			{
				$errors = validation_errors();
				echo json_encode(array('res'=>2,'msg'=>$errors));
				die();
			}
			
			$user_id = $this->create_user( $data , $this->input->post( 'grouped_in' ) );
			
			$astrologer_registration	=	$this->input->post( 'grouped_in' ) == UserGroups::ASTROLOGER ? TRUE : FALSE;
			
			
			if( ! $user_id )
			{
				$res[ 'msg' ]	=	'<span class="text-danger">Something went wrong . Please try again.</span>';
				$res[ 'res' ]	=	2;
			}
			else
			{
				Modules::run( 'mails/user_registration' , $data );
				$res[ 'msg' ]	=	'<span class="text-success">Success !</span>';
				$res[ 'res' ]	=	1;
				$data[ 'head' ]	=	'Thank You !';
				$data[ 'type' ]	=	'success';
				$data[ 'msg' ]	=	'You have succesfully registered with '.$this->project_name.'.<br/> You could login to your dashboard when admin approves your login.';
				$this->session->set_flashdata( 'notice' , $data );
				$this->ion_auth->login( $data[ 'email' ] , $data[ 'password' ]	);
				if( $astrologer_registration )
				{
					Modules::run( 'astrologer/astrologer_account/create' );
				}
				
				
				$res['red']	=	base_url()."login";
			}
			
			echo json_encode( $res );
			
			
		}
		
		
		public function create_user( $user , $grouped_in )
		{
			
			
			foreach($user as $k => $v)
			{
				$$k=$v;
			}
			
			//$this->form_validation->set_data($user);
			if (  $this->form_validation->run('user/registration/register') == FALSE )
			{
				$errors = validation_errors();
				echo json_encode(array('res'=>2,'msg'=>$errors));
				die();
			}
			
			$astrologer_registration	=	$grouped_in == UserGroups::ASTROLOGER ? TRUE : FALSE;
			$log_status	=	LoginStatus::ACTIVE;
			
			$additional_data = array(
				'first_name' => $user[ 'first_name' ],
				'log_status' => $log_status,
				'join_date'	=> $this->dbnow,
				'phone'=> isset( $user[ 'phone' ] ) ? $user[ 'phone' ] : '',
				'active'=>1,
				);
			
			if( $this->check_email( $user[ 'email' ] ) )
			{
				$res[ 'msg' ]	=	'<span class="text-danger">Email Id already registered. </span>';
				$res[ 'res' ]	=	2;
				echo json_encode( $res );
				die();
			}
								
			if($grouped_in != NULL)
			{
				$group = array($grouped_in); 
			}
			else
			{
				$group = array(UserGroups::USER); 
			}
			
			return $user_id	 =	$this->ion_auth->register($email, $password, $email, $additional_data, $group);
		
		}
		
		public function check_email( $email , $ajax = NULL , $user_id = NULL )
		{
			$this->load->model( 'User_model' );
			if( $user_id == NULL )
			$user_id	=	$this->user[ 'id' ] != NULL ? $this->user[ 'id' ] : NULL;
			$check_email		=	$this->User_model->check_email( $email , $user_id );
			if( $ajax == NULL )
			{
				return $check_email;
			}
			else
			{
				if( $check_email )
				{
					$res[ 'msg' ]	=	'<span class="text-danger">Email Id already registered. </span>';
					$res[ 'res' ]	=	2;
				}
				else
				{
					$res[ 'msg' ]	=	'<span class="text-success">Email Id valid.</span>';
					$res[ 'res' ]	=	1;
				}
				
				echo json_encode( $res );
			}
			
			
		}
		
		
		
		

}