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
       $this->load->model(array('category/Category_model','store/Store_model','product/Product_category_model','product/Product_model','product/Product_color_model','Cart_model','customer/Address_model','customer/Customer_model','User_token','order/Order_model','order/Order_details_model','order/Order_status_log','product/Product_images'));

       
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
                if($cartCount == 0) {

                    $message = 'Cant change count';

                }else{
                   $data = [];
                   $where['cart_id'] = $cart_id;
                   $data['cart_count'] = $cartCount;
                   if($this->Cart_model->update($data,$where)){
                      $message = 'Successfully changed count';
                   }    
                }
                


                

            }

            
            



          

            //cart list

            $stores = [];
            $stores = $this->Cart_model->getcartstores($userId,'1');
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
                        
                        $images = $this->Product_images->get_images_api($productDetails['product_id']);
                        foreach($images as $k=>$v){
                            $images[$k]['image_name'] = base_url().'assets/uploads/product/'.$v['image_name'];
                        }
                        $product_image = !empty($images) ? $images[0]['image_name'] : base_url().'assets/uploads/product/default.jpeg' ;
                        //unset($images[0]);
                        
                        
                        $listArray[] = array(
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


                    //store details 

                    $store_logo = base_url().'assets/uploads/store/default.png';
                    $storDetails = $this->Store_model->get_store_single($value['cart_store_id']);
                    
                   
                     $store_logo = $storDetails['store_logo']!="" ? base_url().'assets/uploads/store/'.$storDetails['store_logo'] : $store_logo;
                    $cartList[]=array('store_id'=>$value['cart_store_id'],'store_name'=>$storDetails['store_name'],'store_logo'=>$store_logo,'list'=>$listArray);

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
            $customer_landmark   = !empty($addressDetails['landmark']) ? $addressDetails['landmark'] : "";


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

    public function placeorder_post()
    {

        if ( $_SERVER['REQUEST_METHOD']=='POST' ) {



            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $userId  = isset($_POST['userId']) ? $_POST['userId'] :'';
            if($userId=="") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
                $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
                $this->response($response);
            }

            
            $stores = [];
            $cartList1 = [];
            $cartList1 = $this->Cart_model->get_list(1, NULL , NULL  ,NULL , NULL  ,NULL , $userId,'');

            $stores = $this->Cart_model->getcartstores($userId);
            $cartList = [];

         
            $deliveryCharges = 0;
            $tax = 10 ;
            

            if(!empty($cartList1)) {
                $sizeList = SizeList::getDropDown();
                foreach($stores as $k=>$v){
                    $list = $this->Cart_model->get_list(1, NULL , NULL  ,NULL , NULL  ,NULL , $userId,$v['cart_store_id']);
                    $list2=[];
                    $listArray = [];
                    $subTotal = 0;
                    $totalAmount = 0;



                    foreach($list as $key=>$value){
                        $userId = $value['cart_user_id'];
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
                                       'price'=>$price,
                                       'offerprice'=>$offerPrice,
                                       'is_offer'=>$productDetails['product_is_offer'] == 1 ? 'true':'false'
                        );
                    }

                    $GrandTotal = $subTotal+$tax+$deliveryCharges;
                    
                    $cartList[]=array('store_id'=>$v['cart_store_id'],'list'=>$listArray,'userId'=>$userId,'subtotal'=>$subTotal,'tax'=>$tax,'deliveryCharges'=>$deliveryCharges,'GrandTotal'=>$GrandTotal);

                }
            }


        


            if(!empty($cartList1)) {

                foreach($cartList as $k=>$v){
                    $data = [];
                    $data['customer_id'] = $v['userId'];
                    $data['store_id'] = $v['store_id'];
                    $data['sub_total'] = $v['subtotal'];
                    $data['tax'] = $v['tax'];
                    $data['delivery_charges'] = $v['deliveryCharges'];
                    $data['grand_total'] = $v['GrandTotal'];
                    $data['order_status'] = '0';
                    $data['created_date'] = date('Y-m-d H:i:s');
                    $data['payment_status'] = '0';
                    $orderId = $this->Order_model->add($data);
                    
                    $data = []; 
                    foreach($v['list'] as $k2=>$v2){
                        $price = $v2['is_offer'] == 'true' ? $v2['offerprice'] : $v2['price']; 
                        $data['order_id'] = $orderId;
                        $data['store_id'] = $v2['cart_store_id'];
                        $data['product_id'] = $v2['product_id'];
                        $data['product_count'] = $v2['cart_count'];
                        $data['price'] = $price;
                        $data['total_price'] = $price * $v2['cart_count'];
                        $data['orginal_price'] = $v2['price'];
                        $data['orginal_price'] = $v2['price'];
                        $data['is_offer'] = $v2['is_offer'] == 'true' ? '1' : '0';
                        $data['date_created'] = date('Y-m-d H:i:s');
                        $data['product_size'] = $v2['selected_size'];
                        $data['product_color'] = $v2['selected_color'];
                        
                       if($this->Order_details_model->add($data)){
                            $data = [];
                            $where = [];
                            $data['cart_status'] = '3';
                            $where['cart_id'] = $v2['cart_id'];
                            $this->Cart_model->update($data,$where);
                        }else{

                            $response = array('code'=>'E_ERROR','message'=>'Something went wrong');
                            $this->response($response);     
                        }
                    }

                    $data = [];
                    $where = [];
                    $data['order_status'] = '1';
                    $data['payment_status'] = '0';
                    $data['updated_date'] = date('Y-m-d H:i:s');
                    $where['order_id'] = $orderId;
                    $this->Order_model->update($data,$where);

                    
                }

               
                $response = array('code'=>'OK','message'=>'Successfully placed your order');
                $this->response($response); 

            }else{

                $response = array('code'=>'E_ERROR','message'=>'Your cart is empty');
                $this->response($response);     
            }


            


        }else{

            $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
            $this->response($response);    
        }




    }


    public function orderHistory_get()
    {

        if ( $_SERVER['REQUEST_METHOD']=='GET' ) {

            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $userId  = isset($_GET['userId']) ? $_GET['userId'] :'';

            if($userId=="") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
                $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
                $this->response($response);
            }



            $orderList = [];
            $storeList = [];
            $orderList = $this->Order_model->getOrderList([1,2,3,4],$userId,'');

 
            $storeList = $this->Order_model->getorderstores($userId);

           
            $orderFinalList = [];
            $fullArray = [];

            if(!empty($orderList) && !empty($storeList)) {

                foreach($storeList as $k=>$v){


                    $order = [];
                    $order = $this->Order_model->getOrderList([1,2,3,4],$userId,$v['store_id']);

                    

                    $storeName = $v['store_name'];
                    $storeImage = !empty($v['store_logo']) ? $v['store_logo'] : 'default.png';

                    foreach($order as $k2=>$v2){
                        $orderId = $v2['order_id'];
                        $orderDetails = $this->Order_details_model->getOrderDetails($orderId);
                        $productList = [];
                        foreach($orderDetails as $k3=>$v3){
                            $productDetails = $this->Product_model->get_product_single($v3['product_id']);
                            $images = $this->Product_images->get_images($productDetails['product_id']);
                            foreach($images as $imagek=>$imagev){
                                $images[$imagek]['image_name'] = base_url().'assets/uploads/product/'.$imagev['image_name'];
                            }
                            $product_image = !empty($images) ? $images[0]['image_name'] : base_url().'assets/uploads/product/default.jpeg' ;
                            //unset($images[0]);
                            //$productImage   = !empty($productDetails['product_image']) ? base_url().'assets/uploads/product/'.$productDetails['product_image'] : "";
                            $offerPirce = $v3['is_offer']=='1' ? $v3['price'] : '0';
                            $productList[] = array(
                                                   'product_id'=> $v3['product_id'],
                                                   'product_name'=>$productDetails['product_name'],
                                                   'product_image'=>$productImage,
                                                   'images'=>$images,
                                                   'order_id'  => $v3['order_id'],
                                                   'color'     => $v3['product_color'],
                                                   'size'      => $v3['product_size'],
                                                   'is_offer'  => $v3['is_offer'],
                                                   'price'     =>$v3['orginal_price'],
                                                   'offerPrice'=>$offerPirce


                            );
                        }
                        $status_text = 'Pending';
                        if($v2['order_status'] == '1') {
                            $status_text = "Order Placed";
                        }else if($v2['order_status'] == '2') {
                            $status_text = "Order Packed";
                        }else if($v2['order_status'] == '3') {
                            $status_text = "Courier Agent Collected";
                        }else if($v2['order_status'] == '4') {
                            $status_text = "Outfor Delivery";
                        }else if($v2['order_status'] == '5') {
                            $status_text = "Delivered";
                        }
                        $orderFinalList[$k2] =array(
                                                  'order_id'=>$v2['order_id'],
                                                  'customer_id'=>$v2['customer_id'],
                                                  'product'    =>$productList

                                                   ); 
                    }

                    $fullArray[$k]=array('orderId'=>$orderId,'status'=>$status_text,'storeName'=>$storeName,'storeImage'=>base_url().'assets/uploads/store/'.$storeImage,'list'=>$orderFinalList);

                }

            }


            //past orders

            $orderList = [];
            $storeList = [];
            $orderList = $this->Order_model->getOrderList([5],$userId,'');

 
            $storeList = $this->Order_model->getorderstores($userId,[5]);



           
            $orderFinalList = [];
            $fullArray2 = [];

            if(!empty($orderList) && !empty($storeList)) {

                foreach($storeList as $k=>$v){
                     



                    $order = [];
                    $order = $this->Order_model->getOrderList([5],$userId,$v['store_id']);

                    

                    $storeName = $v['store_name'];
                    $storeImage = !empty($v['store_logo']) ? $v['store_logo'] : 'default.png';

                    foreach($order as $k2=>$v2){
                        $orderId = $v2['order_id'];
                        $orderDetails = $this->Order_details_model->getOrderDetails($orderId);
                        $productList = [];
                        foreach($orderDetails as $k3=>$v3){
                            $productDetails = $this->Product_model->get_product_single($v3['product_id']);
                            //$productImage   = !empty($productDetails['product_image']) ? base_url().'assets/uploads/product/'.$productDetails['product_image'] : "";
                             $images = $this->Product_images->get_images($productDetails['product_id']);
                            foreach($images as $imagek=>$imagev){
                                $images[$imagek]['image_name'] = base_url().'assets/uploads/product/'.$imagev['image_name'];
                            }
                            $product_image = !empty($images) ? $images[0]['image_name'] : base_url().'assets/uploads/product/default.jpeg' ;
                           // unset($images[0]);
                            $offerPirce = $v3['is_offer']=='1' ? $v3['price'] : '0';
                            $return_text = "";
                            if($v3['is_return'] == '1') {
                                $return_text = "Return requested";
                            } elseif($v3['is_return'] == '2') {

                                $return_text = "Return request accepted";
                            }
                            $productList[] = array(
                                                   'order_details_id'=>$v3['order_details_id'],
                                                   'product_id'=> $v3['product_id'],
                                                   'product_name'=>$productDetails['product_name'],
                                                   'product_image'=>$productImage,
                                                   'images'=>$images,
                                                   'order_id'  => $v3['order_id'],
                                                   'color'     => $v3['product_color'],
                                                   'size'      => $v3['product_size'],
                                                   'is_offer'  => $v3['is_offer'],
                                                   'price'     =>$v3['orginal_price'],
                                                   'offerPrice'=>$offerPirce,
                                                   'can_return' =>$productDetails['is_return']=='1' ? 'true' :'false',
                                                   'return_policy' =>$productDetails['return_policy'],
                                                   'reason'    =>$v3['reason'],
                                                   'return_status' => $return_text


                            );
                        }
                        $status_text = 'Pending';
                        if($v2['order_status'] == '1') {
                            $status_text = "Order Placed";
                        }else if($v2['order_status'] == '2') {
                            $status_text = "Order Packed";
                        }else if($v2['order_status'] == '3') {
                            $status_text = "Courier Agent Collected";
                        }else if($v2['order_status'] == '4') {
                            $status_text = "Outfor Delivery";
                        }else if($v2['order_status'] == '5') {
                            $status_text = "Delivered";
                        }
                        $orderFinalList[$k2] =array(
                                                  'order_id'=>$v2['order_id'],
                                                  'customer_id'=>$v2['customer_id'],
                                                  'product'    =>$productList

                                                   ); 
                    }

                    $fullArray2[$k]=array('orderId'=>$orderId,'status'=>$status_text,'storeName'=>$storeName,'storeImage'=>base_url().'assets/uploads/store/'.$storeImage,'list'=>$orderFinalList);

                }

            }


            $response = array('code'=>'OK','currentOrderList'=>$fullArray,'pastOrderList'=>$fullArray2);
            $this->response($response); 


        }else{

            $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
            $this->response($response);     
        }

    }

    public function cancelOrder_post()
    {


        if ( $_SERVER['REQUEST_METHOD']=='POST' ) {

            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $userId  = isset($_POST['userId']) ? $_POST['userId'] :'';
            $orderId  = isset($_POST['orderId']) ? $_POST['orderId'] :'';
            if($userId=="") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
                $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
                $this->response($response);
            }
            $orderDetails = [];
            $orderDetails = $this->Order_model->get_order_single($orderId);
            if(empty($orderDetails)) {
                
                $response = array('code'=>'E_ERROR','message'=>'Invalid Order');
                $this->response($response);
            }
            if($orderDetails['order_status']=='5') {
                $response = array('code'=>'E_ERROR','message'=>'Order already delivered');
                $this->response($response);
            }

            $data = [];
            $data['order_status'] = '6';
            $where = [];
            $where['order_id'] = $orderId;

            if($this->Order_model->update($data,$where)){
                $data  = [];
                $data['order_id']  =  $orderId;
                $data['status']    =  '6';
                $data['updated_by']   = '0';
                $data['created_time'] = date('Y-m-d H:i:s');
                $this->Order_status_log->add($data);

            }



            

        }    else{

            $response = array('code'=>'E_ERROR','message'=>'Invalid requuest');
            $this->response($response);    
        }

       

    }


    public function returnproduct_post()
    {



         if ( $_SERVER['REQUEST_METHOD']=='POST' ) {


            

            $headers = apache_request_headers();
            $token   = !empty($headers['Authorization']) ? $headers['Authorization'] :"";
            $userId  = isset($_POST['userId']) ? $_POST['userId'] :'';
            $order_id  = isset($_POST['order_id']) ? $_POST['order_id'] :'';
            $order_details_id  = isset($_POST['order_details_id']) ? $_POST['order_details_id'] :'';
            $product_id  = isset($_POST['product_id']) ? $_POST['product_id'] :'';
            $reason  = isset($_POST['reason']) ? $_POST['reason'] :'';
            if($userId=="") {
                $response = array('code'=>'E_ERROR','message'=>'UserId needed');
                $this->response($response); 
            }
            if(!$this->User_token->check_token($token,$userId))
            {
                $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
                $this->response($response);
            }
            if($order_id == "") {
                
                $response = array('code'=>'E_ERROR','message'=>'Orderid needed');
                $this->response($response); 
            }
            if($order_details_id == "") {
                
                $response = array('code'=>'E_ERROR','message'=>'Orderdetailsid needed');
                $this->response($response); 
            }
            if($product_id == "") {
                
                $response = array('code'=>'E_ERROR','message'=>'Productid needed');
                $this->response($response); 
            }
            if($reason == "") {
                
                $response = array('code'=>'E_ERROR','message'=>'Reason needed');
                $this->response($response); 
            }
            $order = [];
            $order = $this->Order_model->get_order_single($order_id);
            if(empty($order)) {
                
                $response = array('code'=>'E_ERROR','message'=>'Invalid Order');
                $this->response($response);
            }

            $orderDetails = $this->Order_details_model->orderDetails($order_details_id);

            if($orderDetails['is_return'] == '1') {
                
                $response = array('code'=>'E_ERROR','message'=>'Already requested');
                $this->response($response);
            }

            $status = '5';
            $orderLogDetails = [];
            $orderLogDetails = $this->Order_status_log->getOrderLogSingle($order_id,$status);
            if(empty($orderLogDetails)){
                
                $response = array('code'=>'E_ERROR','message'=>'Order not delivered yet');
                $this->response($response); 
            }

            $deliveryTime = !empty($orderLogDetails['created_time']) ? $orderLogDetails['created_time'] :"";

            if(empty($deliveryTime)) {

                $response = array('code'=>'E_ERROR','message'=>'Order not delivered yet');
                $this->response($response);
            }


            $to_time = strtotime(date('Y-m-d H:i:s'));
            $from_time = strtotime($deliveryTime);
            $minutes = round(($to_time - $from_time) / 60,2);
            $hours = $minutes/60;
            $hours = 5;
            if($hours > '24') {
                
                $response = array('code'=>'E_ERROR','message'=>'Exchange/return not allowed.Time exceeded');
                $this->response($response);
            }

            //ALTER TABLE `mv_order_details` ADD `is_return` INT NOT NULL DEFAULT '0' COMMENT '0-not return ,1- return requested' AFTER `product_color`, ADD `reason` TEXT NOT NULL AFTER `is_return`;
            //ALTER TABLE `mv_order_details` ADD `requested_time` DATETIME NOT NULL AFTER `reason`;

            $data = [];
            $data['is_return'] = '1';
            $data['reason']    = $reason;
            $data['requested_time']    = date('Y-m-d H:i:s');
            $where = [];
            $where['order_id'] = $order_id;
            $where['product_id'] = $product_id;
            if($this->Order_details_model->update($data,$where)){

                $response = array('code'=>'OK','message'=>'Return/exchange requested successfully');
                $this->response($response);     
            }else{
                $response = array('code'=>'E_ERROR','message'=>'Something went wrong');
                $this->response($response);    
            }












         }else{

            $response = array('code'=>'E_ERROR','message'=>'Invalid requuest');
            $this->response($response);    
        }

    }


   

  

    




 

  

 

 
  
}
?>
