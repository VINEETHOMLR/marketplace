<?php
class Admin_user extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' ,array(  'is_admin' ) );
		$this->load->model( array( 'User_model' ) );
		$this->logginedUser = $this->user[ 'id' ];
    }
	
	public function list_json()
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$grouped_in	=	$this->input->post( 'grouped_in' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$student_search	=	$this->input->post( 'search' );
		$log_status	=	$this->input->post( 'log_status' );
		$grouped_in	=	$this->input->post( 'grouped_in' );
		$store_id	=	$this->input->post( 'store_id' );

		if(Modules::run( 'login/is_storeadmin' ) ){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    $store_id = $userData['store_id'];
		} 
		
		
		$records[ 'rows' ]	=	$this->User_model->get_list(  $grouped_in ,  $limit ,  $offset  ,  $date_from ,  $date_to , $log_status ,  $student_search,$store_id);
		$records[ 'total' ]	=	$this->User_model->get_count(  $grouped_in ,  $date_from ,  $date_to ,  $log_status ,$student_search,$store_id);
		//echo $this->db->last_query();
		echo json_encode( $records );
		
	}
	
	public function manage( $grouped_in = NULL )
	{
		
		$data[ 'content' ] = 'admin/table';
		$data[ 'grouped_in' ]	=	$grouped_in != NULL ? $grouped_in : 2;
		$this->load->view( 'admin/page' , $data );
	}
	public function form($id=NUll)
	{
		$data[ 'content' ] = 'admin/form';

		$data['user'] = array();

		if ($id != NULL) {
           $data['user'] = $this->User_model->getUserData($id);
		}
		/*echo "<pre>";
		print_r($data);exit;*/
		//echo "test"; exit;
		$this->load->view( 'admin/page' , $data );
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

			$password = $user['password'];
         
            unset($user['confirm_password']);
            unset($user['password']);

		
			$astrologer_registration	=	$grouped_in == UserGroups::ADMIN ? TRUE : FALSE;
			$log_status	=	LoginStatus::ACTIVE;
			
			$additional_data = array(
				'first_name' => $user[ 'first_name' ],
				'last_name' => $user[ 'last_name' ],
				'log_status' => $log_status,
				'join_date'	=> $this->dbnow,
				'store_id'	=> $user['store_id'],
				//'uri'=>$user['uri'],
				'phone'=> isset( $user[ 'phone' ] ) ? $user[ 'phone' ] : '',
				'email'=> isset( $user[ 'email' ] ) ? $user[ 'email' ] : '',
				'active'=>1,
				
				);





			
			/*if( $this->check_email( $user[ 'email' ] ) )
			{
				$res[ 'msg' ]	=	'<span class="text-danger">Email Id already registered. </span>';
				$res[ 'res' ]	=	2;
				echo json_encode( $res );
				die();
			}*/



								
			if($grouped_in != NULL)
			{
				$group = array($grouped_in); 
			}
			else
			{
				$group = array(UserGroups::ADMIN); 
			}


			
			return $user_id	 =	$this->ion_auth->register($email, $password, $email, $additional_data, $group);
		
		}


		public function check_email( $email , $ajax = NULL , $user_id = NULL )
		{
			$this->load->model( 'userdetails/User_model' );
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
		
	

	public function update( )
	{
		$id = $this->input->post('id');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');

        if(Modules::run( 'login/is_storeadmin' )){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    $data['store_id'] = $userData['store_id'];
		}else {
		    $data['store_id'] = $this->input->post('store_id');	
		} 


        
       /* if($id == NULL) {
            $data['password'] = $this->input->post('password');
            $data['confirm_password'] = $this->input->post('confirm_password');
            $this->create_user($data,$this->input->post('user_role'));
        }*/
        

		
		
		if( $id == NULL )
		{
			$data['password'] = $this->input->post('password');
            $data['confirm_password'] = $this->input->post('confirm_password');
            $this->create_user($data,$this->input->post('user_role'));
			//$res	=	$this->User_model->add( $data );
			$res	=	true;
		}
		else
		{
			$where[ 'id' ]	=	$id;
			$res	=	$this->User_model->update( $data , $where );
		}
		
		if( $res )
		{
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">User list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/user/admin_user/manage';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->User_model->update( $data , $where ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'Status changed .';
			
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again';
		}
		
		echo json_encode($msg);
	}
	
	
	private function remove_user( $id )
	{
		
		return $this->ion_auth->delete_user($id);
		
	}
	
	private function delete_files($path)
	{
		if (!file_exists($path))
		{
			return true;
		}
		else
		{
			return unlink($path);
		}
	}

	public function delete( $id )
	{
		if( $this->remove_user( $id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">User Deleted .</span>';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		
		echo json_encode($msg);
	}
	
	public function delete_multiple()
	{
		$course_id	=	$this->input->post( 'id' );
		foreach( $course_id as $id )
		{
			$this->remove_user( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Users Deleted .</span>';
		echo json_encode($msg);
	}
	



	public function force_login($id)
	{
		$user	=	$this->ion_auth->user( $id )->row_array();
		if($this->ion_auth->force_login($user[ 'email' ]))
		{
			redirect(base_url().'login');
		}
		else
		{
			redirect(base_url().'notice');
		}
		
	}
	
	
	
}