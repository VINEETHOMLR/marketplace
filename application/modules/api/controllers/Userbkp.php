<?php
require(APPPATH.'/libraries/REST_Controller.php');
 //class Login extends MX_Controller{
/*header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
*/
class User extends REST_Controller{
    
    public function __construct()
    {
       parent::__construct();
       $this->load->model(array('category/Category_model','store/Store_model','product/Product_category_model','product/Product_model','product/Product_color_model','Cart_model','customer/Address_model','customer/Customer_model','User_token'));

       
    }

     public function addtocartbkp_post()
    {
     
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $userId = isset($_POST['userId']) ? $_POST['userId'] :'';
            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $product_id = isset($_POST['product_id']) ? $_POST['product_id'] :'';
            $store_id = isset($_POST['store_id']) ? $_POST['store_id']:'';
            $selected_color_id = isset($_POST['selected_color_id']) ? $_POST['selected_color_id']:'';
            $selected_size_id = isset($_POST['selected_size_id']) ? $_POST['selected_size_id']:'';
            $count = !empty($_POST['count']) ? $_POST['count']:1;
            $is_add = !empty($_POST['is_add']) ? $_POST['is_add']:0;
            $is_delete = !empty($_POST['is_delete']) ? $_POST['is_delete']:0;
            $is_change_count = !empty($_POST['is_change_count']) ? $_POST['is_change_count']:0;
            $is_empty_cart = !empty($_POST['is_empty_cart']) ? $_POST['is_empty_cart']:0;
            $cart_id = !empty($_POST['cart_id']) ? $_POST['cart_id']:"";
            $is_increase = !empty($_POST['is_increase']) ? $_POST['is_increase']:"0";
            $is_decrease = !empty($_POST['is_decrease']) ? $_POST['is_decrease']:"0";

            if($userId == "") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
            $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
            $this->response($response);
            }
            $message = "Cart list";

            if($is_add) {

                if($product_id=="") {
                $response = array('code'=>'E_ERROR','message'=>'ProductId needed');
                $this->response($response); 
                }
                if($store_id=="") {
                    $response = array('code'=>'E_ERROR','message'=>'StoreId needed');
                    $this->response($response); 
                }
                if($selected_color_id=="") {
                    $response = array('code'=>'E_ERROR','message'=>'ColorId needed');
                    $this->response($response); 
                }
                if($selected_size_id=="") {
                    $response = array('code'=>'E_ERROR','message'=>'Size needed');
                    $this->response($response); 
                }

            }

            

            if($is_delete!="" || $is_change_count!="") {

              if($cart_id=="") {
                  $response = array('code'=>'E_ERROR','message'=>'CartId needed');
                  $this->response($response);
              }

            }

            $data = [];
            $where = [];
            if($is_add==1) {

                $data['cart_store_id'] = $store_id;
                $data['cart_user_id'] = $userId;
                $data['cart_product_id'] = $product_id;
                $data['cart_status'] = 1;
                $data['cart_count'] = $count;
                $data['cart_created'] = date('Y-m-d H:i:s');
                $data['cart_updated'] = date('Y-m-d H:i:s');
                $data['cart_selected_size'] = $selected_size_id;
                $data['cart_selected_color'] = $selected_color_id;
                if($this->Cart_model->add($data)){
                    $message = "Successfully addedd product";
                }
            }


            if($is_change_count==1) {

               if($count==0) {
                   $response = array('code'=>'E_ERROR','message'=>'Count needed');
                   $this->response($response);
               } 
              
                
                $data['cart_count'] = $count;
                //$data['cart_created'] = date('Y-m-d H:i:s');
                $data['cart_updated'] = date('Y-m-d H:i:s');
                
                $where['cart_id'] = $cart_id;
                if($this->Cart_model->update($data,$where)){
                    $message = "Successfully changed count";
                }

            }

            if($is_delete==1) {

               
              
                
                $data['cart_status'] = 2;
                //$data['cart_created'] = date('Y-m-d H:i:s');
                $data['cart_updated'] = date('Y-m-d H:i:s');
                
                $where['cart_id'] = $cart_id;
                if($this->Cart_model->update($data,$where)){
                    $message = "Successfully removed product";
                }

            }


            if($is_empty_cart == 1) { //delete all

                $where = [];
                $data = [];
                $data['cart_status'] = 2;
                $where['cart_user_id'] = $userId;
                if($this->Cart_model->update($data,$where)){
                    $message = "Empty cart";
                }


            }

            if($is_increase == 1) {

                $cartDetails = $this->Cart_model->get($cart_id);

                $cartCount = !empty($cartDetails['cart_count']) ? $cartDetails['cart_count'] : "0";
                $cartCount = $cartCount + 1;

                $data = [];
                $where['cart_id'] = $cart_id;
                $data['cart_count'] = $cartCount;
                if($this->Cart_model->update($data,$where)){
                    $message = 'Successfully changed count';
                }


                

            }


            if($is_decrease == 1) {

                $cartDetails = $this->Cart_model->get($cart_id);

                $cartCount = !empty($cartDetails['cart_count']) ? $cartDetails['cart_count'] : "0";
                $cartCount = $cartCount - 1;
                if($cartCount <=0) {
                    $cartCount = 0;
                }

                $data = [];
                $where['cart_id'] = $cart_id;
                $data['cart_count'] = $cartCount;
                if($this->Cart_model->update($data,$where)){
                    $message = 'Successfully changed count';
                }


                

            }

            
            



          

            //cart list

            $stores = [];
            $stores = $this->Cart_model->getcartstores($userId);
            $storeCount = !empty($stores) ? count($stores) : "0";
            $productCount = '0';
            
           
            $cartList = [];

         
            $deliveryCharges = 0;
            $subTotal = 0;
            $totalAmount = 0;

            if(!empty($stores)) {
                //$sizeList = SizeList::getDropDown();
                foreach($stores as $k=>$v){
                    
                    $list = $this->Cart_model->get_list(1, NULL , NULL  ,NULL , NULL  ,NULL , $userId,$v['cart_store_id']);
                    
                  
                    $list2=[];
                    $listArray = [];



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
                        
                        $listArray[] = array(
                                       'cart_id'=>$value['cart_id'],
                                       'product_id'=>$value['cart_product_id'],
                                       'product_name'=>$value['product_name'],
                                       'cart_store_id'=>$value['cart_store_id'],
                                       'cart_user_id'=>$value['cart_user_id'],
                                       'cart_count'=>$value['cart_count'],
                                       'selected_color'=>$value['cart_selected_color'],
                                       'selected_size'=>$value['cart_selected_size'],
                                       'product_image'=>base_url().'assets/uploads/product/'.$value['product_image'],
                                       'price'=>$price,
                                       'offerprice'=>$offerPrice,
                                       'is_offer'=>$productDetails['product_is_offer'] == 1 ? 'true':'false'
                        );
                    }
                    $store_logo = base_url().'assets/uploads/store/default.png';
                    $store_logo = $v['store_logo']!="" ? base_url().'assets/uploads/store/'.$v['store_logo'] : $store_logo;
                    $cartList[]=array('store_id'=>$v['cart_store_id'],'store_name'=>$v['store_name'],'store_logo'=>$store_logo,'list'=>$listArray);

                }
            }


            
            $totalAmount = $subTotal + $deliveryCharges;
            $response = array('status'=>'OK','message'=>$message,'cartList'=>$cartList,'totalAmount'=>(string)$totalAmount,'deliveryCharges'=>(string)$deliveryCharges,'subTotal'=>(string)$subTotal,'storeCount'=>(string)$storeCount,'itemCount'=>(string)$productCount);
            $this->response($response);
           








        }else{
            $response = array('status'=>'E_ERROR','message'=>'Invalid request');
            $this->response($response);
        } 


    }
    
    
    
     public function addtocart_post()
    {
     
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $userId = isset($_POST['userId']) ? $_POST['userId'] :'';
            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $product_id = isset($_POST['product_id']) ? $_POST['product_id'] :'';
            $store_id = isset($_POST['store_id']) ? $_POST['store_id']:'';
            $selected_color_id = isset($_POST['selected_color_id']) ? $_POST['selected_color_id']:'';
            $selected_size_id = isset($_POST['selected_size_id']) ? $_POST['selected_size_id']:'';
            $count = !empty($_POST['count']) ? $_POST['count']:1;
            $is_add = !empty($_POST['is_add']) ? $_POST['is_add']:0;
            $is_delete = !empty($_POST['is_delete']) ? $_POST['is_delete']:0;
            $is_change_count = !empty($_POST['is_change_count']) ? $_POST['is_change_count']:0;
            $is_empty_cart = !empty($_POST['is_empty_cart']) ? $_POST['is_empty_cart']:0;
            $cart_id = !empty($_POST['cart_id']) ? $_POST['cart_id']:"";
            $is_increase = !empty($_POST['is_increase']) ? $_POST['is_increase']:"0";
            $is_decrease = !empty($_POST['is_decrease']) ? $_POST['is_decrease']:"0";

            if($userId == "") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
            $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
            $this->response($response);
            }
            $message = "Cart list";

            if($is_add) {

                if($product_id=="") {
                $response = array('code'=>'E_ERROR','message'=>'ProductId needed');
                $this->response($response); 
                }
                if($store_id=="") {
                    $response = array('code'=>'E_ERROR','message'=>'StoreId needed');
                    $this->response($response); 
                }
                if($selected_color_id=="") {
                    $response = array('code'=>'E_ERROR','message'=>'ColorId needed');
                    $this->response($response); 
                }
                if($selected_size_id=="") {
                    $response = array('code'=>'E_ERROR','message'=>'Size needed');
                    $this->response($response); 
                }

            }

            

            if($is_delete!="" || $is_change_count!="") {

              if($cart_id=="") {
                  $response = array('code'=>'E_ERROR','message'=>'CartId needed');
                  $this->response($response);
              }

            }

            $data = [];
            $where = [];
            if($is_add==1) {

                $data['cart_store_id'] = $store_id;
                $data['cart_user_id'] = $userId;
                $data['cart_product_id'] = $product_id;
                $data['cart_status'] = 1;
                $data['cart_count'] = $count;
                $data['cart_created'] = date('Y-m-d H:i:s');
                $data['cart_updated'] = date('Y-m-d H:i:s');
                $data['cart_selected_size'] = $selected_size_id;
                $data['cart_selected_color'] = $selected_color_id;
                if($this->Cart_model->add($data)){
                    $message = "Successfully addedd product";
                }
            }


            if($is_change_count==1) {

               if($count==0) {
                   $response = array('code'=>'E_ERROR','message'=>'Count needed');
                   $this->response($response);
               } 
              
                
                $data['cart_count'] = $count;
                //$data['cart_created'] = date('Y-m-d H:i:s');
                $data['cart_updated'] = date('Y-m-d H:i:s');
                
                $where['cart_id'] = $cart_id;
                if($this->Cart_model->update($data,$where)){
                    $message = "Successfully changed count";
                }

            }

            if($is_delete==1) {

               
              
                
                $data['cart_status'] = 2;
                //$data['cart_created'] = date('Y-m-d H:i:s');
                $data['cart_updated'] = date('Y-m-d H:i:s');
                
                $where['cart_id'] = $cart_id;
                if($this->Cart_model->update($data,$where)){
                    $message = "Successfully removed product";
                }

            }


            if($is_empty_cart == 1) { //delete all

                $where = [];
                $data = [];
                $data['cart_status'] = 2;
                $where['cart_user_id'] = $userId;
                if($this->Cart_model->update($data,$where)){
                    $message = "Empty cart";
                }


            }

            if($is_increase == 1) {

                $cartDetails = $this->Cart_model->get($cart_id);

                $cartCount = !empty($cartDetails['cart_count']) ? $cartDetails['cart_count'] : "0";
                $cartCount = $cartCount + 1;

                $data = [];
                $where['cart_id'] = $cart_id;
                $data['cart_count'] = $cartCount;
                if($this->Cart_model->update($data,$where)){
                    $message = 'Successfully changed count';
                }


                

            }


            if($is_decrease == 1) {

                $cartDetails = $this->Cart_model->get($cart_id);

                $cartCount = !empty($cartDetails['cart_count']) ? $cartDetails['cart_count'] : "0";
                $cartCount = $cartCount - 1;
                if($cartCount <=0) {
                    $cartCount = 0;
                }

                $data = [];
                $where['cart_id'] = $cart_id;
                $data['cart_count'] = $cartCount;
                if($this->Cart_model->update($data,$where)){
                    $message = 'Successfully changed count';
                }


                

            }

            
            



          

            //cart list

            $stores = [];
            $stores = $this->Cart_model->getcartstores($userId);
            $storeCount = !empty($stores) ? count($stores) : "0";
            $productCount = '0';
            $cartList = [];

         
            $deliveryCharges = 0;
            $subTotal = 0;
            $totalAmount = 0;

            if(!empty($stores)) {
                $sizeList = SizeList::getDropDown();
                foreach($stores as $k=>$v){
                    $list = [];
                    $list = $this->Cart_model->get_list(1, NULL , NULL  ,NULL , NULL  ,NULL , $userId,$v['cart_store_id']);
                    $list2=[];
                    $listArray = [];



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
                        
                        $listArray[] = array(
                                       'cart_id'=>$value['cart_id'],
                                       'product_id'=>$value['cart_product_id'],
                                       'product_name'=>$value['product_name'],
                                       'cart_store_id'=>$value['cart_store_id'],
                                       'cart_user_id'=>$value['cart_user_id'],
                                       'cart_count'=>$value['cart_count'],
                                       'selected_color'=>$value['cart_selected_color'],
                                       'selected_size'=>$value['cart_selected_size'],
                                       'product_image'=>base_url().'assets/uploads/product/'.$value['product_image'],
                                       'price'=>$price,
                                       'offerprice'=>$offerPrice,
                                       'is_offer'=>$productDetails['product_is_offer'] == 1 ? 'true':'false'
                        );
                    }
                    $store_logo = base_url().'assets/uploads/store/default.png';
                    $store_logo = $v['store_logo']!="" ? base_url().'assets/uploads/store/'.$v['store_logo'] : $store_logo;
                    $cartList[]=array('store_id'=>$v['cart_store_id'],'store_name'=>$v['store_name'],'store_logo'=>$store_logo,'list'=>$listArray);

                }
            }


            
            $totalAmount = $subTotal + $deliveryCharges;
            $response = array('status'=>'OK','message'=>$message,'cartList'=>$cartList,'totalAmount'=>(string)$totalAmount,'deliveryCharges'=>(string)$deliveryCharges,'subTotal'=>(string)$subTotal,'storeCount'=>(string)$storeCount,'itemCount'=>(string)$productCount);
            $this->response($response);
           








        }else{
            $response = array('status'=>'E_ERROR','message'=>'Invalid request');
            $this->response($response);
        } 


    }



   /* public function category_get()
    {

      if($_SERVER['REQUEST_METHOD']=='GET')
      {

        $categoryList = $this->Category_model->get_list(1);
        if(!empty($categoryList)) {
            foreach ($categoryList as $k=>$v) {
                $categoryList[$k]['category_image'] =!empty($v['category_image']) ? base_url().'assets/uploads/category/'.$v['category_image'] : ''; 
            }
            $data  = array('categoryList'=>$categoryList,'count'=>count($categoryList));
            $response = array('code'=>'OK','message'=>'List','data'=>$data);
            $this->response($response);    
        } else {
             $response = array('code'=>'E_ERROR','message'=>'No data found');
             $this->response($response);  
        }

      } else {
          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response);
      }

    }
*/

 public function getCustomerDetails_post()
    {
       
       
        if ( $_SERVER['REQUEST_METHOD']=='POST' ) {

            
            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $userId  = isset($_POST['userId']) ? $_POST['userId'] :'';
            $phone   = isset($_POST['phone']) ? $_POST['phone'] :'';
            $address   = isset($_POST['address']) ? $_POST['address'] :'';
            $pincode   = isset($_POST['pincode']) ? $_POST['pincode'] :'';
            $landmark   = isset($_POST['landmark']) ? $_POST['landmark'] :'';

            if($userId=="") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
                $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
                $this->response($response);
            }
            
            $data = [];
            $where = [];
            if($phone) {
                
                $data['customer_phone'] = $phone;
                $where['customer_id']   = $userId;
                $this->Customer_model->update($data,$where);
            }
            
            if(!empty($address)) {

                if(empty($pincode)) {
                    
                    $response = array('code'=>'E_ERROR','message'=>'Pincode mandatory');
                    $this->response($response);
                }
                //$addressDetails = [];
                $addressDetails = $this->Address_model->getAddressData($userId);
                

                if(empty($addressDetails)) { //need to add new address 
                    $data = [];
                    $where = [];
                    $data['user_id']   =   $userId;
                    $data['address']   =   $address;
                    $data['landmark']   =   $landmark;
                    $data['pincode']   =   $pincode;
                    $this->Address_model->add($data);
                }else{
                    $data = [];
                    $where = [];
                    $where['user_id']   =   $userId;
                    $data['address']   =   $address;
                    $data['landmark']   =   $landmark;
                    $data['pincode']   =   $pincode;
                    $this->Address_model->update($data,$where);    
                }


            }

            
            $userDetails = $this->Customer_model->getCustomerData($userId);
            $addressDetails = $this->Address_model->getAddressData($userId);
            
            $profile_pic = !empty($userDetails['customer_profile_pic']) ? base_url().'assets/uploads/customer/'.$userDetails['customer_profile_pic'] : base_url().'assets/uploads/customer/default.png';

            $customer_first_name = !empty($userDetails['customer_first_name']) ? $userDetails['customer_first_name'] : "";
            $customer_last_name  = !empty($userDetails['customer_last_name']) ? $userDetails['customer_last_name'] : "";
            $customer_phone      = !empty($userDetails['customer_phone']) ? $userDetails['customer_phone'] : "";
            $customer_email      = !empty($userDetails['customer_email']) ? $userDetails['customer_email'] : "";
            $customer_address    = !empty($addressDetails['address']) ? $addressDetails['address'] : "";
            $customer_pincode    = !empty($addressDetails['pincode']) ? $addressDetails['pincode'] : "";
            $customer_landmark    = !empty($addressDetails['landmark']) ? $addressDetails['landmark'] : "";


            $customerdetails = array(
                                     'customer_name'     => $customer_first_name.' '.$customer_last_name,
                                     'customer_profile_pic' => $profile_pic,
                                     'customer_email'    => $customer_email,
                                     'customer_phone'    => $customer_phone,
                                     'customer_address'  => $customer_address,
                                     'customer_pincode'  => $customer_pincode,
                                     'customer_landmark' => $customer_landmark,


                                      );

           
            $response = array('code'=>'OK','message'=>'Customer Details','customerDetails'=>$customerdetails);
            $this->response($response); 

            

        }else{

            $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
            $this->response($response);   

        }
      

    }

   

  

    




 

  

 

 
  
}
?>