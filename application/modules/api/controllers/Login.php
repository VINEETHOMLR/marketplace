<?php
//require(APPPATH.'/libraries/REST_Controller.php');
 //class Login extends MX_Controller{
/*header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
*/
class Login extends REST_Controller{
//class Login extends MX_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Register_model','User_token', 'Cart_model', 'product/Product_model', 'product/Product_images'));

       
    }


    public function loginuser_post(){
      
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = isset($_POST['email'])?$_POST['email']:"";
      
        $password = isset($_POST['password'])?$_POST['password']:"";
        $device_id = isset($_POST['device_id'])?$_POST['device_id']:"";
     
        if($username==''){
             $response=array('message'=>'Email mandatory','code'=>'E_ERROR');
             $this->response($response);
          }
         
          if($password==''){
             $response=array('message'=>'Password mandatory','code'=>'E_ERROR');
             $this->response($response);
          }

         /* if($device_id=='')
          {
             $response=array('message'=>'Deviceid mandatory','code'=>'E_ERROR');
             $this->response($response);
            
          }*/

          $details = [];
          $details = $this->Register_model->loginuser($username,md5($password));
      //    if(count($details)!=0)
          if(!empty($details)) {
            $data = array();
            $data['customer_device_id'] = $device_id;
            $where['customer_id'] = $details['customer_id'];
            $this->Register_model->update($data,$where);
            $data=array();
            $where = array();
            $data['token_user_id'] = $details['customer_id'];
            $data['token_value'] =base64_encode($details['customer_first_name'].$details['customer_id'].time());
            $data['token_status'] =1;
            $this->User_token->disable_token($details['customer_id']);
            $this->User_token->add($data);

            $userdetails = $this->Register_model->get_user($details['customer_id']);
            
            $profileimage  = base_url().'assets/uploads/users/default.png';
            $profileimage = !empty($userdetails['customer_profile_pic']) ? base_url().'assets/uploads/customer/'.$userdetails['customer_profile_pic'] :$profileimage;
            
            $additionaldatas =array('userId'=>$details['customer_id'],'token'=>$data['token_value'],'first_name'=>$userdetails['customer_first_name'],'last_name'=>$userdetails['customer_last_name'],'email'=>$userdetails['customer_email'],'profile_pic'=>$profileimage);

            //cart list
            $stores = [];
            $stores = $this->Cart_model->getcartstores($details['customer_id'],'1');
            $storeCount = !empty($stores) ? count($stores) : "0";
            $productCount = '0';
            $cartList = [];

         
            $deliveryCharges = 0;
            $subTotal = 0;
            $totalAmount = 0;

            if(!empty($stores)) {
                $sizeList = SizeList::getDropDown();
                $listArray = [];
                foreach($stores as $k=>$v){
                    $list = [];
                    $list = $this->Cart_model->get_list(1, NULL , NULL  ,NULL , NULL  ,NULL , $details['customer_id'],$v['cart_store_id']);
                    $list2=[];

                    foreach($list as $key=>$value){                        
                        //productCount
                        $productCount = $productCount+$value['cart_count'];
                        
                        $product_id = $value['cart_product_id'];
                        $productDetails = $this->Product_model->get($product_id);
                        $price = $productDetails['product_price'];
                        $offerPrice = '0';
                        $calculationPrice = 0;
                        
                        if($productDetails['product_is_offer'] == 1){

                            $offerPrice =  $productDetails['product_offer_price']; 
                            $calculationPrice = $offerPrice;
                              
                        }else{
                            $calculationPrice = $price;    
                        }
                        
                        $totalPrice = $calculationPrice * $value['cart_count'];

                        $subTotal = $subTotal + $totalPrice;
                        
                        $images = $this->Product_images->get_images($productDetails['product_id']);
                        foreach($images as $k=>$v1){
                            $images[$k]['image_name'] = base_url().'assets/uploads/product/'.$v1['image_name'];
                        }
                        $product_image = !empty($images) ? $images[0]['image_name'] : base_url().'assets/uploads/product/default.jpeg' ;
                        //unset($images[0]);

                        $store_logo = base_url().'assets/uploads/store/default.png';
                        $store_logo = ($v['store_logo']!="")?base_url().'assets/uploads/store/'.$v['store_logo']:$store_logo;
                        $listArray[] = array(
                                       'store_id'=>$v['cart_store_id'],
                                       'store_name'=>$v['store_name'],
                                       'store_logo'=>$store_logo,
                                       'cart_id'=>$value['cart_id'],
                                       'product_id'=>$value['cart_product_id'],
                                       'product_name'=>$value['product_name'],
                                       'cart_store_id'=>$value['cart_store_id'],
                                       'cart_user_id'=>$value['cart_user_id'],
                                       'cart_count'=>$value['cart_count'],
                                       'selected_color'=>$value['cart_selected_color'],
                                       'selected_size'=>$value['cart_selected_size'],
                                       'product_image'=>$product_image,
                                       'images'=>$images,
                                       'price'=>$price,
                                       'offerprice'=>$offerPrice,
                                       'is_offer'=>$productDetails['product_is_offer'] == 1 ? 'true':'false'
                        );
                    }
                }
                $cartList = $listArray;
            }
            $totalAmount = $subTotal + $deliveryCharges;

            //$additionaldatas =array('userId'=>$details['customer_id'],'token'=>$data['token_value']);
            $response=array('message'=>'Successfully logined','code'=>'OK','data'=>($additionaldatas),'cartList'=>$cartList,'totalAmount'=>(string)$totalAmount,'deliveryCharges'=>(string)$deliveryCharges,'subTotal'=>(string)$subTotal,'storeCount'=>(string)$storeCount,'itemCount'=>(string)$productCount);
            $this->response($response);
           
          }else{
                $response=array('message'=>'Invalid Credentials','code'=>'E_ERROR');
                $this->response($response); 
          }
    }else{
          $response=array('message'=>'invalid request','code'=>'E_ERROR');
          $this->response($response);
    }
  }


    function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    function logout_post()
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
              $response =array('code'=>'E_AUTHORIZED','message'=>'Session xpired');
              $this->response($response);
          }
          else{
            $this->User_token->disable_token($userId);
            $response =array('code'=>'OK','message'=>'Logout successfully');
            $this->response($response);
          }

      }else{

          $response=array('message'=>'Invalidrequest','code'=>'E_ERROR');
          $this->response($response);
      }

    }


    function forgotpassword_post()
    {

       if($_SERVER['REQUEST_METHOD']=='POST')
       { 
        $customer_email  = isset($_POST['email'])?$_POST['email']:""; 
        $customer_phone  = isset($_POST['phone'])?$_POST['phone']:""; 
        if($customer_email=='')
        {
             $response =array('code'=>'E_ERROR','message'=>'Email needed');
             $this->response($response);
        }
        if($customer_phone=='')
        {
             $response =array('code'=>'E_ERROR','message'=>'Phone needed');
             $this->response($response);
        }

        //check user with email and phone
        $details = $this->Register_model->get_user_detail($customer_email,$customer_phone);
        if(!empty($details)) {

        $newpassword = $this->generate_password(10); 

        $data =array();
        $where = array();
        $data['customer_password'] = md5($newpassword);     
        $where['customer_id'] = $details['customer_id'];     
        $this->Register_model->update($data,$where);
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.programmingly.com',
            'smtp_port' => 587,
            'smtp_user' => 'washmate@programmingly.com',
            'smtp_pass' => 'washmate',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1',
            'wordwrap' => TRUE,
            'newline' => "\r\n",
            'MIME-Version'=>'1.0; charset=utf-8',
            'Content-type'=>'text/html'
        );
        $this->load->library('email', $config);



        $from = 'washmate@programmingly.com';
        $to = $details['customer_email'];
        $subject = 'Forgotpassword';
        $message = 'Hi '.$details['customer_first_name'].', your password successfully reset.Your new password is '.$newpassword.'. Thankyou';
        
        // support@foldedco.com with "User (name) (email) has requested a limit increase

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            $response =array('code'=>'OK','message'=>'Success');
            $this->response($response);
    
        } else {
            
            $response =array('code'=>'E_ERROR','message'=>'Something went wrong');
            $this->response($response);
        }


        } else {

            $response =array('code'=>'E_ERROR','message'=>'No user found');
            $this->response($response);  
        }
      } else {
          
          $response=array('message'=>'Invalidrequest','code'=>'E_ERROR');
          $this->response($response);  
      }

       


    }


    function generate_password($length = 20){
      $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
                '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

      $str = '';
      $max = strlen($chars) - 1;

      for ($i=0; $i < $length; $i++)
        $str .= $chars[mt_rand(0, $max)];

      return $str;
}


   

    





   
  
}
?>