<?php
class Admin_visit extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		    $this->load->model( array( 'Visit_model','Covisitor_model','api/Register_model' ) );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$visit_status	=	$this->input->post( 'visit_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$visit_search	=	$this->input->post( 'search' );
        $visit_type = $this->input->post( 'visit_type' );
        $visit_company_id = $this->input->post( 'visit_company_id' );
        $visit_who_to_meet = $this->input->post( 'visit_who_to_meet' );
        $visit_added_by = $this->input->post( 'visit_added_by' );
        //echo $startdate = $this->input->post( 'startdate' );exit;
		
		$records[ 'rows' ]	=	$this->Visit_model->get_list(  $visit_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $visit_search , $user_id ,$visit_type,$visit_company_id,$visit_who_to_meet,$visit_added_by);
		$records[ 'total' ]	=	$this->Visit_model->get_count(  $visit_status ,  $date_from ,  $date_to  , $visit_search , $user_id,$visit_type,$visit_company_id,$visit_who_to_meet,$visit_added_by);
		echo json_encode( $records );
		
	}
	
	public function form( $visit_id= NULL )
	{
		$data[ 'content' ] = 'visit/form';
		$data[ 'visitdata' ]	=	array();
		if( $visit_id != NULL )
		{
			
			$detail=	$this->Visit_model->details( $visit_id );
            $covisitorsList = $this->Covisitor_model->getcovisitors($visit_id);
            $data['visitdata'] = $detail;
            $data['covisitorsList'] = !empty($covisitorsList) ? $covisitorsList :array();


		}

		// echo "<pre>";
		// print_r($data);exit;






   // $data['companyList']=$this->Company_model->get_list(1);

		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'visit/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function update( )
	{
		
		$data[ 'customer_first_name' ]	=	$this->input->post( 'customer_first_name' );
		$data[ 'customer_last_name' ]	=	$this->input->post( 'customer_last_name' );
		
		$data[ 'customer_company' ]	=	$this->input->post( 'customer_company' );
    $data[ 'customer_status' ] = $this->input->post( 'customer_status' );
    $data[ 'customer_type' ] = $this->input->post( 'customer_type' );
    $data[ 'customer_email' ] = $this->input->post( 'customer_email' );
    $data[ 'customer_phone' ] = $this->input->post( 'customer_phone' );
    $data[ 'customer_username' ] = $this->input->post( 'customer_username' );
    if($this->input->post( 'customer_password' )!="" && $this->input->post( 'confirm_customer_password')!="") {
        $data[ 'customer_password' ] = md5($this->input->post( 'customer_password'));
    }
    
    
		
		
		
		$customer_id	=	$this->input->post( 'customer_id' );
		/*$file_name = substr( url_title($data[ 'service_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'service_image';
		$upload_path = 'assets/uploads/service/';
		//echo '<pre>';print_r($_FILES);exit;
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
		}*/

		
		
		
		$this->db->trans_begin();
		if( $customer_id == NULL )
		{
			$data[ 'customer_created_time' ]	=	time();	
			$data[ 'customer_updated_time' ]	=	time();	
			$visit_id	=	$this->Visit_model->add( $data );
		}
		else
		{
			$where[ 'customer_id' ]	=	$customer_id;
			$data[ 'customer_updated_time' ] = time();
			$this->Visit_model->update( $data , $where );
		}

		

		
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		else
		{
			$this->db->trans_commit();
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">visit list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/visit/admin_visit/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'customer_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Visit_model->update( $data , $where ) )
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



  public function checkemail()
  {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $status = "ERROR";
         $message = '<font color="red">Invalid email</font>'; 
         $data =array('status'=>$status,'message'=>$message);
         echo json_encode($data,true);
         return false;
    }
    $count = $this->Register_model->check_email($email);
    if($count['count']==0) {
        $status = "OK";
        $message = '';
    }else {
        $status = "ERROR";
        $message = '<font color="red">Email already used </font>';
    }


    $data =array('status'=>$status,'message'=>$message);


    echo json_encode($data,true);

  }


  public function checkphone()
  {
    $phone = $_POST['phone'];
   
    $count = $this->Register_model->check_phone($phone);
    if($count['count']==0) {
        $status = "OK";
        $message = '';
    }else {
        $status = "ERROR";
        $message = '<font color="red">Phone already used </font>';
    }


    $data =array('status'=>$status,'message'=>$message);


    echo json_encode($data,true);

  }


  public function checkusername()
  {
    $username = $_POST['username'];
   
    $count = $this->Register_model->check_username($username);
    if($count['count']==0) {
        $status = "OK";
        $message = '';
    }else {
        $status = "ERROR";
        $message = '<font color="red">Username already used </font>';
    }


    $data =array('status'=>$status,'message'=>$message);


    echo json_encode($data,true);

  }


	
	private function remove_client( $id )
	{
		$portfolio	=	$this->Visit_model->get( $id );
		if( trim( $portfolio[ 'service_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'service_image' ] );
		}
		
		return $this->Visit_model->delete( $id );
		
	}
	
	
	public function remove( $visit_id )
	{
		//$visit_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $visit_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Client Deleted .</span>';
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
		$visit_id	=	$this->input->post( 'id' );
		
		foreach( $visit_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Portfolio Deleted .</span>';
		
		echo json_encode($msg);
	}
	public function get_tags()
	{ 
		$this->load->model('Tag_model');
		$tags=$this->Tag_model->get_tags();
		return json_encode($tags);

	}


	
	
	
}