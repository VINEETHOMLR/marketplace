<?php
class Password extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->posted=$this->input->post(NULL, TRUE);
			$this->load->model('User_model');
		}
		
		
		public function forgot_form()
		{
			$data['content']	=	'password/forgot_form';
			//$this->load->view( 'password/forgot_form' , $data );
			$this->load->view('admin/login', $data);
		}
		
		public function change_form()
		{
			if( ! Modules::run( 'login/is_member' ) )
			{
				redirect(base_url().'login');
			}
			$data['content']	=	'password/change_form';
			$this->load->view( 'dashboard' , $data );
		}
		
		
		public function change_password()
    	{
			
			if( trim( $this->input->post('new') ) != trim( $this->input->post('re') ) )
			{
				$msg['res']		=	2;
				$msg['msg']		=	'Passwords do not match please retry.';
				echo json_encode($msg);
				die();
			}
			$change = $this->ion_auth->change_password($this->input->post('email'), $this->input->post('old'), $this->input->post('new'));
			if ($change)
			{ 
				$msg['res']		=	1;
				$msg['msg']		=	'<span class="text-success">Your password successfully reset.</span>';
				$data[ 'msg' ]	=	'Your password reset successfully  .';
				$data[ 'head' ]	=	'Success';
				$data[ 'type' ]	=	'success';
				$this->session->set_flashdata( 'msg' , $data );
				
			}
			else
			{
				$msg['res']		=	2;
				$msg['msg']		=	'<span class="text-danger">The current password you have provided is incorrect, Kindly renter the details .</span>';
			}
			
			echo json_encode($msg);
			
		}
		
		
		public function create_password()
		{
			$email				=	NULL;
			$phone				=	FALSE;
			$identity			=	$this->input->post('identity');
			$where['phone']		=	$identity;
			$where2['email']	=	$identity;
			$email				=	$this->User_model->set_where($where)->get_column('email');
			
			if( $email )
			{
				//identity used is phone number
				$this->send_verification_otp($identity);
				$res['res']		=	1;
				$res['msg']		=	'OTP to reset password send to your mobile  phone ';
				echo json_encode($res);
			}
			else if( $email				=	$this->User_model->set_where($where2)->get_column('email') )
			{
				//idntity used is email
				$this->send_verification_email( $email );
				$data[ 'msg' ]	=	'An email has been sent .Please check your inbox .';
				$data[ 'head' ]	=	'Email Sent';
				$data[ 'type' ]	=	'success';
				$this->session->set_flashdata( 'notice' , $data );
				$res[ 'redir' ]=	base_url()."pages/notice";
				$res['res']		=	2;
				$res['msg']		=	'An email has been sent to your Email Id.';
				echo json_encode($res);
			}
			else
			{
				$res['res']		=	2;
				$res['msg']		=	'<span class="text-danger">No matching data found. Please retry.</span>';
				echo json_encode($res);
			}
			
			
		}
		
		
		public function reset_password_code( $code )
		{
			$reset = $this->ion_auth->forgotten_password_complete($code);
			if ($reset ) 
			{  //if the reset worked then send them to the login page
				
				$data['identity']	=	$reset['identity'];
				$data['old']		=	$reset['new_password'];
				$data['content']	=	'password/last_form';
				$this->load->view('admin/login', $data);
			}
			else 
			{ //if the reset didnt work then send them back to the forgot password page
				$data[ 'msg' ]	=	'Your password reset token expired. Please try again .';
				$data[ 'head' ]	=	'Token expired';
				$data[ 'type' ]	=	'danger';
				$this->session->set_flashdata( 'notice' , $data );
				//redirect(base_url()."pages/notice", 'refresh');
			}
		}
		
		public function hard_reset(  )
		{
			if( ! Modules::run( 'login/is_admin' ) )
			{
				die();
			}
			$email	=	$this->input->get( 'email' );
			redirect( $this->generate_rseset_link($email) ); 
		}
		
		private function generate_rseset_link($email)
		{
			$forgotten = $this->ion_auth->forgotten_password($email);
			return base_url().'user/password/reset_password_code/'.$forgotten['forgotten_password_code'];
		}
		
		
		
		public function send_verification_email( $email )
		{
			$where['email']	=	$email;
			$user			=	$this->User_model->set_where($where)->get();
			//echo '<pre>';print_r($user);exit;
			$reset_link		=	$this->generate_rseset_link($email);
		    //Modules::run( 'mails/forgot_password' ,$user , $reset_link );
		    Modules::run( 'notification/notification_process/forgot_password' , $user , $reset_link );
		}
		
		
}