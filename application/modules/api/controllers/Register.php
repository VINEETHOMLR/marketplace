<?php
//require(APPPATH.'/libraries/REST_Controller.php');
 //class Login extends MX_Controller{
/*header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
*/
class Register extends REST_Controller{
//class Register extends MX_Controller{
    
    public function __construct()
    {
        parent::__construct();
       $this->load->model(array('Register_model','User_token'));

       
    }


    public function registeruser_post()
    {

      if($_SERVER['REQUEST_METHOD']=='POST')
      {
      
          
          $first_name = isset($_POST['first_name'])?$_POST['first_name']:"";
          $last_name = isset($_POST['last_name'])?$_POST['last_name']:"";
          $password = isset($_POST['password'])?$_POST['password']:"";
          $cpassword = isset($_POST['cpassword'])?$_POST['cpassword']:"";
          $email = isset($_POST['email'])?$_POST['email']:"";
          $customer_profile_pic = !empty($_FILES['customer_profile_pic']) ? $_FILES['customer_profile_pic'] : "";
          //$id = isset($_POST['id'])?$_POST['id']:"";
          //$phone = isset($_POST['phone'])?$_POST['phone']:"";
          //$license = isset($_POST['license'])?$_POST['license']:"";
       

         
          if($first_name=='')
          {
             $response=array('message'=>'Firstname mandatory','code'=>'E_ERROR');
             $this->response($response);
          }
          if($last_name=='')
          {
             $response=array('message'=>'Lastname mandatory','code'=>'E_ERROR');
               $this->response($response);
          }
          if($password=='')
          {
             $response=array('message'=>'Password mandatory','code'=>'E_ERROR');
             $this->response($response);
          }
          if($cpassword=='')
          {
              $response=array('message'=>'Confirm Password mandatory','code'=>'E_ERROR');
              $this->response($response);
              
          }
          if($password!=$cpassword)
          {
              $response=array('message'=>'Password must be same','code'=>'E_ERROR');
              $this->response($response);
              
          }
          
          if($email=='')
          {
              $response=array('message'=>'Email mandatory','code'=>'E_ERROR');
              $this->response($response);
              
          }
          if($email)
          {


          if(!$this->valid_email($email))
            {
             
               $response=array('message'=>'Invalid email','code'=>'E_ERROR');
               $this->response($response);
               
            }
            else{
              $email_count = $this->Register_model->check_email($email);
              $count = $email_count['count']; 
              if($count>0)
              {
                $response=array('message'=>'Email already used','code'=>'E_ERROR');
                $this->response($response);
                
                 
              }
            }
            

          }
          /*if($phone="")
          {
              $response=array('message'=>'Phone mandatory','code'=>'E_ERROR');
              $this->response($response); 
          } else {
            $count=$this->Register_model->check_phone($phone);
            if ($count>0) {
                $response=array('message'=>'Phone already in use','code'=>'E_ERROR');
                $this->response($response); 
            }
          }
          if($license="")
          {
              $response=array('message'=>'License mandatory','code'=>'E_ERROR');
              $this->response($response); 
          } else {
            $count=$this->Register_model->check_license($license);
            if ($count>0) {
                $response=array('message'=>'License already in use','code'=>'E_ERROR');
                $this->response($response); 
            }
          }*/




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



          

          
          
          $data['customer_first_name'] = $first_name;
          $data['customer_last_name'] = $last_name;
          $data['customer_email'] = $email;
          $data['customer_password'] = md5($password);
          $data['customer_created_time'] = time();
          $data['customer_updated_time'] = time();
          $data['customer_status'] = 1;
          

          if($userId=$this->Register_model->add($data))
          {

            $data=[];
            $data['token_user_id'] = $userId;
            $data['token_value'] =base64_encode($first_name.$userId.time());
            $data['token_status'] =1;
            $this->User_token->disable_token($userId);
            $this->User_token->add($data);
            $userdetails = $this->Register_model->get_user($userId);
            $profileimage  = base_url().'assets/uploads/users/default.png';

            $profileimage = !empty($userdetails['customer_profile_pic']) ? base_url().'assets/uploads/customer/'.$userdetails['customer_profile_pic'] : $profileimage;
            
            
            $additionaldatas =array('userId'=>$userId,'token'=>$data['token_value'],'first_name'=>$userdetails['customer_first_name'],'last_name'=>$userdetails['customer_last_name'],'email'=>$userdetails['customer_email'],'profile_pic'=>$profileimage);

            $response=array('message'=>'Successfully registered','code'=>'OK','data'=>($additionaldatas));
             $this->response($response);

          }
          else
          {
             $response=array('message'=>'Something went wrong','code'=>'E_ERROR');
              $this->response($response);
          }

      
     

      


      

      
    }
    else{
          $response=array('message'=>'invalid request','code'=>'E_ERROR');
          $this->response($response);
    }


     


    }
    
    
    public function forgotpassword_post()
    {

     
     

      if($_SERVER['REQUEST_METHOD']=='POST')
      {

        $email = isset($_POST['email'])?$_POST['email']:"";
        if($email=='')
        {
              $response=array('message'=>'Email id required','code'=>'E_ERROR');
              $this->response($response);
              
        }

        if($email)
          {


        if(!$this->valid_email($email))
           {
             
               $response=array('message'=>'Invalid email','code'=>'E_ERROR');
               $this->response($response);
               
            }
            
            

          }

        $details = [];
        $details = $this->Register_model->get_user_email($email);
        if(!empty($details)){
            
            $userId = $details['customer_id'];
            $password = $this->rand_string(5);  
            $data = [];
            $data['customer_password'] = md5($password);
            $where['customer_id'] = $userId;
            if($this->Register_model->update($data,$where)) {
                $message = "Hi ".$details['customer_first_name'].", your new password is  ".$password ."  Please login with this password.Thankyou";
                $this->sendEmail($email,$message);
                $response=array('message'=>'New password is sent to your email','code'=>'OK');
                $this->response($response);
            }else{

                $response=array('message'=>'Something went wrong','code'=>'E_ERROR');
                $this->response($response);
            }


        }else{

            $response=array('message'=>'No user found with this email id','code'=>'E_ERROR');
            $this->response($response);  
        } 
        




      }

     } 


    function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    
    
    function rand_string( $length ) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

    }

 public function sendEmail($email,$message)
    {
      $to = $email;
       $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.programmingly.com',
            'smtp_port' => 587,
            'smtp_user' => 'marketplace@programmingly.com',
            'smtp_pass' => 'marketplace',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1',
            'wordwrap' => TRUE,
            'newline' => "\r\n",
            'MIME-Version'=>'1.0; charset=utf-8',
            'Content-type'=>'text/html'
        );

        $this->load->library('email', $config);

        $from = 'marketplace@programmingly.com';
        //$to = 'vineethomlr@gmail.com';
        $subject = 'Forgotpassword - Marketplace';
        
        
        // support@foldedco.com with "User (name) (email) has requested a limit increase

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();  

    }



  


   
  
}
?>