<?php
class Admin_staff extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		    $this->load->model( array( 'Staff_model','Company_model','api/Register_model' ) );
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
	
	public function form( $staff_id= NULL )
	{
		$data[ 'content' ] = 'staff/form';
		$data[ 'customer' ]	=	array();
		if( $staff_id != NULL )
		{
			$data[ 'customer' ]	=	$this->Staff_model->get_customer_single( $staff_id );
		}

    $data['companyList']=$this->Company_model->get_list(1);

		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'staff/table';
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
			$staff_id	=	$this->Staff_model->add( $data );
		}
		else
		{
			$where[ 'customer_id' ]	=	$customer_id;
			$data[ 'customer_updated_time' ] = time();
			$this->Staff_model->update( $data , $where );
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
			$msg['msg']		=	'<span class="text-success">Staff list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/staff/admin_staff/manage';
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
		if( $this->Staff_model->update( $data , $where ) )
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


  public function getCompanyList()
  {
  	 return $this->Company_model->get_list(1);
  }


   public function getStaffList()
  {
  	 
     $company_id = $_POST['company_id']; 
  	 $list = $this->Staff_model->get_list(  1 ,  NULL ,  NULL  ,  NULL ,  NULL  , NULL , NULL ,1,$company_id);

  	
  	 $option = "<option value=''>STAFF</option>";
  	 if(!empty($list)) {
         foreach ($list as $k=>$v) {



             $option  .="<option value='".$v['customer_id']."'>".$v['customer_first_name'].' '.$v['customer_last_name']."</option>";    
         }
  	 }



     $list = array();
  	 $list = $this->Staff_model->get_list(  1 ,  NULL ,  NULL  ,  NULL ,  NULL  , NULL , NULL ,2,$company_id);
  	 $option2 = "<option value=''>ADDED BY</option>";
  	 if(!empty($list)) {
         foreach ($list as $k=>$v) {
             $option2  .="<option value=".$v['customer_id'].">".$v['customer_first_name'].' '.$v['customer_last_name']."</option>";    
         }
  	 }

  	 $data =array('staff'=>$option,'guard'=>$option2);






  	 echo json_encode($data,true);
  }


  


	
	private function remove_client( $id )
	{
		$portfolio	=	$this->Staff_model->get( $id );
		if( trim( $portfolio[ 'service_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'service_image' ] );
		}
		
		return $this->Staff_model->delete( $id );
		
	}
	
	
	public function remove( $staff_id )
	{
		//$staff_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $staff_id ) )
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
		$staff_id	=	$this->input->post( 'id' );
		
		foreach( $staff_id as $id )
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