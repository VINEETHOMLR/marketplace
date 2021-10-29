<?php
class Admin_user extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			Modules::run( 'login/check_authority' ,array( 'is_admin' ) );
			
		}

		public function list_json( $user_id = NULL )
	    {
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$staff_status	=	$this->input->post( 'staff_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$staff_search	=	$this->input->post( 'search' );
    $staff_type = $this->input->post( 'staff_type' );
		
		$records[ 'rows' ]	=	$this->Staff_model->get_list(  $staff_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $staff_search , $user_id ,$staff_type);
		$records[ 'total' ]	=	$this->Staff_model->get_count(  $staff_status ,  $date_from ,  $date_to  , $staff_search , $user_id,$staff_type);
		echo json_encode( $records );
		
	  }


		public function update_password()
        {
    	$change = $this->ion_auth->change_password_employee('email',$this->input->post('email'),$this->input->post('new'));
    	session_start();
    	if($change)
    	{

    		
    		$_SESSION['staffmsg'] = "Password changed successfully";
  

    	}
    	else
    	{
    		$_SESSION['staffmsg'] = "Error occured.Please try again";
    	}

    	header('Location:'.$this->base.'staff/admin_staff/manage');
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
			
			$astrologer_registration	=	$grouped_in == UserGroups::STAFF ? TRUE : FALSE;
			$log_status	=	LoginStatus::ACTIVE;
			
			$additional_data = array(
				'first_name' => $user[ 'first_name' ],
				'log_status' => $log_status,
				'join_date'	=> $this->dbnow,
				//'uri'=>$user['uri'],
				//'phone'=> isset( $user[ 'phone' ] ) ? $user[ 'phone' ] : '',
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
				$group = array(UserGroups::STAFF); 
			}
			
			return $user_id	 =	$this->ion_auth->register($email, $password, $email, $additional_data, $group);
		
		}
		
		
}
