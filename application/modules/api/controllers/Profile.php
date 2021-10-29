<?php 
class Profile extends REST_Controller{
//class Login extends MX_Controller{
    
    public function __construct()
    {
        parent::__construct();
       $this->load->model(array('Register_model','User_token','post/Post_model','post/Comment_model'));

       
    }
    
    public function postlist_get()
    {
        if($_SERVER['REQUEST_METHOD']=='GET') {

        	$headers = apache_request_headers();
	        $token = $headers['Authorization'];
	        $userId  = isset($_GET['userId'])?$_GET['userId']:"";
	        if($userId=='')
	        {
	         $response =array('code'=>'E_ERROR','message'=>'UserId needed');
	         $this->response($response);
	        }
	        if(!$this->User_token->check_token($token,$userId))
	        {
	          $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
	          $this->response($response);
	        }

	        $list = $this->Post_model->get_list(1,NULL,NULL,NULL,NULL,NULL,$userId);

	        if(count($list)>0)
	        {
	        	foreach($list as $k=>$v){
                    
                    $profileimage  = base_url().'assets/uploads/users/default.png';
                    $profileimage = !empty($v['customer_profile_pic']) ? base_url().'assets/uploads/customer/'.$v['customer_profile_pic'] :$profileimage;
                    $list[$k]['customer_profile_pic'] = $profileimage;
                    $list[$k]['post_created_time'] = date('d M',$v['post_created_time']);
	        	    	
	        	}

	        }


	       

	        $userdetails = $this->Register_model->get_user($userId);
	        $profileimage  = base_url().'assets/uploads/users/default.png';
            $profileimage = !empty($userdetails['customer_profile_pic']) ? base_url().'assets/uploads/customer/'.$userdetails['customer_profile_pic'] :$profileimage;
            $additionaldatas =array('userId'=>$userdetails['customer_id'],'first_name'=>$userdetails['customer_first_name'],'last_name'=>$userdetails['customer_last_name'],'email'=>$userdetails['customer_email'],'profile_pic'=>$profileimage,'points_earned'=>count($list),'list'=>$list);
            $response=array('message'=>'Success','code'=>'OK','data'=>$additionaldatas);
            $this->response($response);	




        } else {

            $response=array('message'=>'invalid request','code'=>'E_ERROR');
            $this->response($response);	
        }
           	

    }


    public function profiledetails_post()
    {


      if($_SERVER['REQUEST_METHOD']=='POST')
      {


	       $headers = apache_request_headers();
	       $token = $headers['Authorization'];
	       $userId  = isset($_POST['userId'])?$_POST['userId']:"";
	       if($userId=='')
	       {
	         $response =array('code'=>'E_ERROR','message'=>'UserId needed');
	         $this->response($response);
	       }
	       if(!$this->User_token->check_token($token,$userId))
	       {
	          $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
	          $this->response($response);
	       }

	       $details = $this->Register_model->get_user($userId);
	       if(count($details)!=0)
	       {
	       	 $profileimage = base_url().'assets/uploads/users/default.png';
	       	 $profileimage = isset($details['customer_profile_pic']) ? base_url().'assets/uploads/users/'.$details['customer_profile_pic'] : $profileimage;
	       	 $additionaldatas =array('userId'=>$details['customer_id'],'first_name'=>$details['customer_first_name'],'last_name'=>$details['customer_last_name'],'email'=>$details['customer_email'],'phone'=>$details['customer_phone'],'image'=>$profileimage);
             $response=array('message'=>'Success','code'=>'OK','data'=>($additionaldatas));
             $this->response($response);

	       }
	       else{
	       	 $response=array('message'=>'Invalide user','code'=>'E_ERROR');
             $this->response($response);
	       }
	       


	       


      }
      else
      {

      	  $response=array('message'=>'invalid request','code'=>'E_ERROR');
          $this->response($response);
      }

    }

    

    function updateprofile_post()
    {
    	if($_SERVER['REQUEST_METHOD']=='POST')
        { 
           $headers = apache_request_headers();
	       $token = $headers['Authorization'];
	       $userId  = isset($_POST['userId'])?$_POST['userId']:"";
	       $customer_first_name = isset($_POST['customer_first_name']) ? $_POST['customer_first_name'] : "";
	       $customer_last_name = isset($_POST['customer_last_name']) ? $_POST['customer_last_name'] : "";
	       $customer_profile_pic = !empty($_FILES['customer_profile_pic']) ? $_FILES['customer_profile_pic'] : "";
	       if($userId=='')
	       {
	         $response =array('code'=>'E_ERROR','message'=>'UserId needed');
	         $this->response($response);
	       }
	       if(!$this->User_token->check_token($token,$userId))
	       {
	          $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
	          $this->response($response);
	       }

	       if($customer_first_name=='')
	       {
	         $response =array('code'=>'E_ERROR','message'=>'Firstname needed');
	         $this->response($response);
	       }
	       if($customer_last_name=='')
	       {
	         $response =array('code'=>'E_ERROR','message'=>'Lastname needed');
	         $this->response($response);
	       }



           

           if(!empty($customer_profile_pic))
           {

	           	   $upload_path = 'assets/uploads/customer/';
		           $extension=array("jpeg","jpg","png","gif");
		           $error =array();

		           $file_name=$customer_profile_pic["name"];
		           $file_tmp=$customer_profile_pic["tmp_name"];
		           $ext=pathinfo($file_name,PATHINFO_EXTENSION);
	     

	           if(!file_exists($upload_path."/".$file_name)) {
	                      move_uploaded_file($file_tmp=$customer_profile_pic["tmp_name"],$upload_path."/".$file_name);
	                      $filename = $file_name;
	            }
	            else {
	                      
	              $filename=basename($file_name,$ext);
	              $newFileName=$filename.time().".".$ext;
	              move_uploaded_file($file_tmp=$customer_profile_pic["tmp_name"],$upload_path."/".$newFileName);
	              $filename = $newFileName;

	           
	           }
	           $data['customer_profile_pic'] = $filename;

           }
	       
                  
                  $data['customer_first_name'] = $customer_first_name;
                  $data['customer_last_name'] = $customer_last_name;
                  $data['customer_updated_time'] = time();
                  
                  $where['customer_id'] = $userId;
                  if($this->Register_model->update($data,$where)) {

                  	$userdetails = $this->Register_model->get_user($userId);
                  	$profileimage  = base_url().'assets/uploads/users/default.png';
                    $profileimage = !empty($userdetails['customer_profile_pic']) ? base_url().'assets/uploads/customer/'.$userdetails['customer_profile_pic'] :$profileimage;
                    $additionaldatas =array('userId'=>$userdetails['customer_id'],'first_name'=>$userdetails['customer_first_name'],'last_name'=>$userdetails['customer_last_name'],'email'=>$userdetails['customer_email'],'phone'=>$userdetails['customer_phone'],'profile_pic'=>$profileimage);


                  	$response=array('message'=>'Updated sucessfully','code'=>'OK','data'=>$additionaldatas);
                    $this->response($response);
                  }else {

                     $response=array('message'=>'Something went wrong','code'=>'E_ERROR');
                     $this->response($response);	
                  }


           


        }else{

        	$response=array('message'=>'invalid request','code'=>'E_ERROR');
            $this->response($response);

        }

        //ALTER TABLE `mv_customer` ADD `customer_profile_pic` VARCHAR(150) NULL AFTER `customer_social_id`;

    }



}

?>