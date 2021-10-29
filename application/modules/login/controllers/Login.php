<?php
class Login extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}

	public function form($red = NULL)
	{
		$data['red'] = $red;
		$data[ 'content' ]	=	'form';
		$this->load->view('form', $data);
	}

	public function check_authority($roles, $strict = false)
	{
		$authorized = false;
		foreach($roles as $role)
		{
			if ($this->$role(NULL, $strict))
			{
				$authorized = true;
			}
		}

		if (!$authorized)
		{
			redirect($this->base . 'login');
			exit;
		}
	}

	public function index($red = NULL)
	{

		$this->session->keep_flashdata('msg');
		//echo '<pre>';print_r($this->ion_auth->get_users_groups($this->user[ 'id' ])->result());exit;
		if ($this->ion_auth->logged_in())
		{

			if (trim($red) != '')
			{

				redirect(base64_url_decode($red));
			}
			else
			if ($this->ion_auth->in_group('Admin'))
			{
				redirect(base_url() . 'admin');
			}
			else
			if ($this->ion_auth->in_group('Storeadmin'))
			{
				redirect(base_url() . 'admin');
			}
			else
			if ($this->ion_auth->in_group('Storestaff'))
			{
				redirect(base_url() . 'admin');
			}
			
		}
		else
		{
			$data['red'] = $red;
			$data[ 'content' ]	=	'admin_form';
			$this->load->view('admin/login', $data);
		}
	}

	public function is_logged($json = NULL , $redirect = FALSE)
	{
		if (!($this->ion_auth->logged_in()))
		{
			if ($json == NULL)
			{
				if( $redirect )
				{
					redirect($this->base . 'login');
					exit;
				}
				else
				{
					return false;
				}
			}
			else
			{
				$res['res'] = 2;
				$res['msg'] = '<span class="text-warning">Not logged in</span>';
				echo json_encode($res);
			}
		}
		else
		{
			if ($json == NULL)
			{
				return true;
			}
			else
			{
				$res['res'] = 1;
				$res['msg'] = '<span class="text-success">Logged in</span>';
				echo json_encode($res);
			}
		}
	}

	
	public function is_admin($ajax = NULL)
	{
		$result = FALSE;
		$groups = array(
			UserGroups::ADMIN
		);
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group($groups))
		{
			$result = TRUE;
		}

		if ($result)
		{
			if ($ajax == NULL)
			{
				return true;
			}
			else
			{
				$res['res'] = 1;
				$res['msg'] = '<span class="text-success">Logged in</span>';
				echo json_encode($res);
			}
		}
		else
		{
			if ($ajax == NULL)
			{
				return false;
			}
			else
			{
				$res['res'] = 2;
				$res['msg'] = '<span class="text-warning">Not logged in</span>';
				echo json_encode($res);
			}
		}
	}

	public function is_storeadmin($ajax = NULL)
	{
		$result = FALSE;
		$groups = array(
			UserGroups::STOREADMIN
		);
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group($groups))
		{
			$result = TRUE;
		}

		if ($result)
		{
			if ($ajax == NULL)
			{
				return true;
			}
			else
			{
				$res['res'] = 1;
				$res['msg'] = '<span class="text-success">Logged in</span>';
				echo json_encode($res);
			}
		}
		else
		{
			if ($ajax == NULL)
			{
				return false;
			}
			else
			{
				$res['res'] = 2;
				$res['msg'] = '<span class="text-warning">Not logged in</span>';
				echo json_encode($res);
			}
		}
	}

	public function is_storestaff($ajax = NULL)
	{
		$result = FALSE;
		$groups = array(
			UserGroups::STORESTAFF
		);
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group($groups))
		{
			$result = TRUE;
		}

		if ($result)
		{
			if ($ajax == NULL)
			{
				return true;
			}
			else
			{
				$res['res'] = 1;
				$res['msg'] = '<span class="text-success">Logged in</span>';
				echo json_encode($res);
			}
		}
		else
		{
			if ($ajax == NULL)
			{
				return false;
			}
			else
			{
				$res['res'] = 2;
				$res['msg'] = '<span class="text-warning">Not logged in</span>';
				echo json_encode($res);
			}
		}
	}


	public function authorize($noajax = NULL)
	{
		$authorize = 2;
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$remeber = $this->input->post('remeber');
		$red = $this->input->post('red') != NULL ? trim($this->input->post('red')) : FALSE;

	//	$this->ion_auth->login($email, $password, $remeber);
		if (!$this->ion_auth->login($email, $password,true))
		{
			$msg = '<p  class="text-small text-danger">Email or password is incorrect.</p>';
		}
		else
		{
			$authorize = 1;
			$msg = '<p  class="text-small text-success">Logged In.</p>';
			$user = (array)$this->ion_auth->user()->row();
			//echo '<pre>';print_r($user);exit;
			if( $user[ 'log_status' ] != 1 )
			{
				$this->ion_auth->logout();
				$data[ 'msg' ]	=	'Your account verification is on process .<br/>You could login after verification.';
				$data[ 'head' ]	=	'Account not verfied yet !';
				$data[ 'type' ]	=	'info';
				$this->session->set_flashdata( 'notice' , $data );
				//$result['red']		=	$this->base.'pages/notice';
				$result['res']		=	2;
				$result['msg']		=	'<span class="text-orange">Your account verification is on 
				process .<br/> Admin will approve  soon.</span>';
				echo json_encode($result);
				die();
			}
			
			
		}

		if ($noajax != NULL)
		{
			if ($red)
			{
				$red = base64_url_decode($red);
				redirect( $red );
			}
			else
			{
				redirect(base_url() . 'login');
			}

			die();
		}
		else
		{
			$res['res'] = $authorize;
			$res['msg'] = $msg;
			if ($red)
			{
				$res['red'] = base64_url_decode($red);
			}
			else
			{
				$res['red'] = base_url() . 'login';
			}

			echo json_encode($res);
			die();
		}
	}

	public function logout()
	{
		if ($this->ion_auth->logged_in())
		{
			$this->ion_auth->logout();
		}

		redirect(base_url() , 'refresh');
	}
}