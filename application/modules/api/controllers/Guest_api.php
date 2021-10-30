<?php
require(APPPATH.'/libraries/REST_Controller.php');
 //class Login extends MX_Controller{
/*header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
*/
class Guest_api extends REST_Controller{
    
    public function __construct()
    {
       parent::__construct();
       $this->load->model(array('category/Category_model','subcategory/Subcategory_model','store/Store_model','product/Product_category_model','product/Product_model','product/Product_color_model','product/Product_images','User_token'));

       
    }

    public function sendotp_post(){

     if($_SERVER['REQUEST_METHOD']=='POST')
       {
              $phone = isset($_POST['phone']) ? $_POST['phone'] :'';

         if(empty($phone)) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Please Enter Phone Number to Proceed');
              $this->response($response);  
           }
         if(!is_numeric($phone)) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Invalid Phone Number');
              $this->response($response);  
           }

              $checkPhn = $this->User_token->check_phone($phone); 

         if(!empty($checkPhn)) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Phone Number is already in Use');
              $this->response($response);  
           }
              $otp      =  rand(1000,9999);
              $sendOtp = $this->User_token->check_otp($phone,$otp);

         if($sendOtp) 
           {
              $response = array('code'=>'OK','message'=>'Successfully Sent OTP');
              $this->response($response);  
           } else {

              $response = array('code'=>'E_ERROR','message'=>'OTP Send Failed');
              $this->response($response); 
           }

              $response = array('code'=>'E_ERROR','message'=>'Something Went Wrong...');
              $this->response($response); 

       } else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response);
       }
    }

    public function verifyotp_post(){

     if($_SERVER['REQUEST_METHOD']=='POST')
       {
            $phone = isset($_POST['phone']) ? $_POST['phone'] :'';
            $otp = isset($_POST['otp']) ? $_POST['otp'] :'';

          if(empty($phone)) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Please Enter Phone Number to Proceed');
              $this->response($response);  
           }
          if(!is_numeric($phone)) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Invalid Phone Number');
              $this->response($response);  
           }
          if(!is_numeric($otp)) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Please Enter OTP to Proceed');
              $this->response($response);  
           }
          if(!is_numeric($otp)||strlen($otp)!=4) 
           {
              $response = array('code'=>'E_ERROR','message'=>'Invalid OTP');
              $this->response($response);  
           }

           $verifyOtp = $this->User_token->verify_otp($phone,$otp);
           if(!$verifyOtp && $otp == '1234') {
               
               $response = array('code'=>'OK','message'=>'Successfully Verified OTP');
               $this->response($response);
               die();
           } 


          if($verifyOtp)
           {

              $msg  = $verifyOtp == '1' ? 'Successfully Verified OTP' : 'OTP Expired.Please try again' ;
              $code = $verifyOtp == '1' ? 'OK' : 'E_ERROR' ;
              $response = array('code'=>$code,'message'=>$msg);
              $this->response($response); 
           } 

           $response = array('code'=>'E_ERROR','message'=>'Invalid OTP.Please enter the correct OTP');
           $this->response($response);
       }
   }

   



    public function category_get()
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


    public function storelist_get()
    {

      if($_SERVER['REQUEST_METHOD']=='GET')
      {

        $category = isset($_GET['category']) ? $_GET['category'] :"";  
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] :"";

        if ($category == "") {
            $response = array('code'=>'E_ERROR','message'=>'Category Needed');
            $this->response($response); 
        } 


        $storeList = $this->Store_model->get_list(1,NULL,NULL,NULL,NULL,$keyword,NULL,$category); 

        if(!empty($storeList)) {
            foreach($storeList as $k=>$v) {

                $offerCount = $this->Product_model-> get_count(1,NULL , NULL  ,NULL  , NULL,NULL,$v['store_id'],1);
                 
                $storeList[$k]['offer_count'] =$offerCount; 
                $storeList[$k]['store_logo'] =!empty($v['store_logo']) ? base_url().'assets/uploads/store/'.$v['store_logo']:base_url().'assets/uploads/store/default.png'; 
            }
            $data  = array('storeList'=>$storeList,'count'=>count($storeList));
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
    
    public function home_post()
    {
      if($_SERVER['REQUEST_METHOD']=='POST')
      {

          $keyword = isset($_POST['keyword']) ? $_POST['keyword'] :""; 
          $category_id = isset($_POST['category_id']) ? $_POST['category_id'] :""; 
          $storeList = [];
          $storeList = $this->Store_model->get_list(1,NULL,NULL,NULL,NULL,$keyword,NULL,$category_id); 
          

          if(!empty($storeList)) {
            foreach($storeList as $k=>$v) {

                $offerCount = $this->Product_model-> get_count(1,NULL , NULL  ,NULL  , NULL,NULL,$v['store_id'],1);
                 
                $storeList[$k]['offer_count'] =$offerCount; 
                $storeList[$k]['store_logo'] =!empty($v['store_logo']) ? base_url().'assets/uploads/store/'.$v['store_logo']:base_url().'assets/uploads/store/default.png'; 
            }
            
        } 

        //get category
        $categoryList = [];
        $categoryList = $this->Category_model->get_list(1,3);
        if(!empty($categoryList)) {
            
            foreach($categoryList as $k=>$v) {

            $categoryList[$k]['category_image'] =!empty($v['category_image']) ? base_url().'assets/uploads/category/'.$v['category_image'] : '';
            
            }
        }
        $data  = array('storeList'=>$storeList,'categoryList'=>$categoryList);
        $response = array('code'=>'OK','message'=>'List','data'=>$data);
        $this->response($response);


      }else{

          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response); 
      }
      
    }



   /* public function productlist_get()
    {

      if($_SERVER['REQUEST_METHOD']=='GET')
      {
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] :'';   //men,women  
        $product_category = isset($_GET['product_category']) ? $_GET['product_category'] :''; 
        $store_id = isset($_GET['store_id']) ? $_GET['store_id'] :''; 
        if ($store_id == "") {

            $response = array('code'=>'E_ERROR','message'=>'StoreId Needed');
            $this->response($response);
        }
        
       
        
        $request = $_GET;
        $this->Product_model->addlog(json_encode($request,true));

        $productCategoryList = $this->Product_category_model->get_list( 1 , NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL,NULL,$category_id);
        
        
        $product_category ='';

        $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id);
        if(!empty($productList)) {
            foreach($productList as $k=>$v) {
                $productList[$k]['product_image'] =!empty($v['product_image']) ? base_url().'assets/uploads/product/'.$v['product_image']:base_url().'assets/uploads/product/default.png';
                $colorList = $this->Product_color_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$v['product_id']);
                $productList[$k]['product_color'] =  $colorList; 
                

            }
        }
        
        $storDetails = $this->Store_model->get_store_single($store_id);
        $storDetails['store_logo'] =!empty($storDetails['store_logo']) ? base_url().'assets/uploads/store/'.$storDetails['store_logo']:base_url().'assets/uploads/store/default.png';


        $data  = array('storeDeatils'=>$storDetails,'productCategoryList'=>$productCategoryList,'productCategoryListCount'=>count($productCategoryList),'productList'=>$productList,'productListCount'=>count($productList));
        
        $this->Product_model->addlog(json_encode($data,true));
        
        $response = array('code'=>'OK','message'=>'List','data'=>$data);
        $this->response($response);





      }else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response);   
      }

    } */
    
    
    public function productlist_get()
    {

      if($_SERVER['REQUEST_METHOD']=='GET')
      {
        $request = $_GET;
        $this->Product_model->addlog(json_encode($request,true));  
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] :'';  
        $product_category = isset($_GET['product_category']) ? $_GET['product_category'] :''; 
        $store_id = isset($_GET['store_id']) ? $_GET['store_id'] :''; 
        if ($store_id == "") {

            $response = array('code'=>'E_ERROR','message'=>'StoreId Needed');
            $this->response($response);
        }

       
        $this->Store_model->updateCount($store_id);
        //if category id is null,find out the categories related with this store

        
       
        $productList = [];
        $categoryList = [];

        if(empty($category_id) && empty($product_category)) {

          

            $category  = $this->Store_model->getCategory($store_id);
            $parent_category = explode(',',$category['store_category']);
            foreach(explode(',',$category['store_category']) as $k=>$v){
            
                $categoryDetails = $this->Category_model->get_category_single($v,1); 
                $categoryList[] = array('category_id' => $categoryDetails['category_id'],
                                      'category_name' => $categoryDetails['category_name']

                                   );  

            }

          $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id,NULL,$parent_category);
       


        }

        $subcategoryList = [];

      
        if(!empty($category_id) && empty($product_category)) {
            
            
           
            $subcategory = $this->Subcategory_model->get_list( 1 ,NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL ,$category_id);
            foreach($subcategory as $k=>$v) {
            
                $subcategoryList[] = array(
                                           
                                           'subcategory_name' => $v['product_category_name'],
                                           'subcategory_id'   => $v['product_category_id'],
                                           'category_id'   => $v['parent_category']
                                    );    

            }

            $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id,NULL,$category_id);

            
        }

        if(!empty($category_id) && !empty($product_category)) {
        
        
          
          $subcategory = $this->Subcategory_model->get_list( 1 ,NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL ,$category_id);
            foreach($subcategory as $k=>$v) {
            
                $subcategoryList[] = array(
                                           
                                           'subcategory_name' => $v['product_category_name'],
                                           'subcategory_id'   => $v['product_category_id'],
                                           'category_id'   => $v['parent_category']
                                    );    

            }
          $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id,NULL,$category_id);

        }

       

        
        if(!empty($productList)) {
            foreach($productList as $k=>$v) {


                //variants
                $variants = $v['variant_option_id'];
                $variationsList = $this->Product_images->get_product_variants($variants);
                $images = $this->Product_images->get_images_api($v['product_id']);




                foreach($images as $k2=>$v2){
                    
                    
                        $images[$k2]['image_name'] = base_url().'assets/uploads/product/'.$v2['image_name'];
                    
                }


               
                $productList[$k]['product_image'] =!empty($images) ? $images[0]['image_name']:base_url().'assets/uploads/product/default.png';
                unset($images[0]);
                $productList[$k]['images'] = $images;
                //$productList[$k]['product_image'] =!empty($v['product_image']) ? base_url().'assets/uploads/product/'.$v['product_image']:base_url().'assets/uploads/product/default.png';
                $colorList = $this->Product_color_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$v['product_id']);
                $productList[$k]['product_color'] =  $colorList; 
                $productList[$k]['variant_option_id'] =  $variationsList; 
                

            }
        }
        
        $storDetails = $this->Store_model->get_store_single($store_id);
        $storDetails['store_logo'] =!empty($storDetails['store_logo']) ? base_url().'assets/uploads/store/'.$storDetails['store_logo']:base_url().'assets/uploads/store/default.png';


       /* $data  = array('storeDeatils'=>$storDetails,'productCategoryList'=>$productCategoryList,'productCategoryListCount'=>count($productCategoryList),'productList'=>$productList,'productListCount'=>count($productList));*/


        $data  = array('storeDeatils'=>$storDetails,'categoryList'=>$categoryList,'categoryListCount'=>count($categoryList),'subcategoryList'=>$subcategoryList,'subcategoryListCount'=>count($subcategoryList),'productList'=>$productList,'productListCount'=>count($productList));

        $this->Product_model->addlog(json_encode($data,true));

        $response = array('code'=>'OK','message'=>'List','data'=>$data);
        $this->response($response);





      }else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response);   
      }

    }
    
    
    
    
    public function productlist2_get()
    {
      
        

      if($_SERVER['REQUEST_METHOD']=='GET')
      {
        $request = $_GET;
        $this->Product_model->addlog(json_encode($request,true));  
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] :'';  
        $product_category = isset($_GET['product_category']) ? $_GET['product_category'] :''; 
        $store_id = isset($_GET['store_id']) ? $_GET['store_id'] :''; 
        if ($store_id == "") {

            $response = array('code'=>'E_ERROR','message'=>'StoreId Needed');
            $this->response($response);
        }

       
        $this->Store_model->updateCount($store_id);
        //if category id is null,find out the categories related with this store

        
       
        $productList = [];
        $categoryList = [];

        if(empty($category_id) && empty($product_category)) {

          

            $category  = $this->Store_model->getCategory($store_id);
            $parent_category = explode(',',$category['store_category']);
            foreach(explode(',',$category['store_category']) as $k=>$v){
            
                $categoryDetails = $this->Category_model->get_category_single($v,1); 
                $categoryList[] = array('category_id' => $categoryDetails['category_id'],
                                      'category_name' => $categoryDetails['category_name']

                                   );  

            }

          $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id,NULL,$parent_category);
       


        }

        $subcategoryList = [];

      
        if(!empty($category_id) && empty($product_category)) {
            
            
           
            $subcategory = $this->Subcategory_model->get_list( 1 ,NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL ,$category_id);
            foreach($subcategory as $k=>$v) {
            
                $subcategoryList[] = array(
                                           
                                           'subcategory_name' => $v['product_category_name'],
                                           'subcategory_id'   => $v['product_category_id'],
                                           'category_id'   => $v['parent_category']
                                    );    

            }

            $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id,NULL,$category_id);

            
        }

        if(!empty($category_id) && !empty($product_category)) {
        
        
          
          $subcategory = $this->Subcategory_model->get_list( 1 ,NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL ,$category_id);
            foreach($subcategory as $k=>$v) {
            
                $subcategoryList[] = array(
                                           
                                           'subcategory_name' => $v['product_category_name'],
                                           'subcategory_id'   => $v['product_category_id'],
                                           'category_id'   => $v['parent_category']
                                    );    

            }
          $productList = $this->Product_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$product_category,$store_id,NULL,$category_id);

        }

       

        
        if(!empty($productList)) {
            foreach($productList as $k=>$v) {
                $images = $this->Product_images->get_images($v['product_id']);
                
                foreach($images as $k2=>$v2){
                    $images[$k2]['image_name'] = base_url().'assets/uploads/product/'.$v2['image_name'];
                }
                $productList[$k]['product_image'] =!empty($images) ? $images[0]['image_name']:base_url().'assets/uploads/product/default.png';
                unset($images[0]);
                $productList[$k]['images'] = $images;
                //$productList[$k]['product_image'] =!empty($v['product_image']) ? base_url().'assets/uploads/product/'.$v['product_image']:base_url().'assets/uploads/product/default.png';
                $colorList = $this->Product_color_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$v['product_id']);
                $productList[$k]['product_color'] =  $colorList; 
                

            }
        }
        
        $storDetails = $this->Store_model->get_store_single($store_id);
        $storDetails['store_logo'] =!empty($storDetails['store_logo']) ? base_url().'assets/uploads/store/'.$storDetails['store_logo']:base_url().'assets/uploads/store/default.png';


       /* $data  = array('storeDeatils'=>$storDetails,'productCategoryList'=>$productCategoryList,'productCategoryListCount'=>count($productCategoryList),'productList'=>$productList,'productListCount'=>count($productList));*/


        $data  = array('storeDeatils'=>$storDetails,'categoryList'=>$categoryList,'categoryListCount'=>count($categoryList),'subcategoryList'=>$subcategoryList,'subcategoryListCount'=>count($subcategoryList),'productList'=>$productList,'productListCount'=>count($productList));

        $this->Product_model->addlog(json_encode($data,true));

        $response = array('code'=>'OK','message'=>'List','data'=>$data);
        $this->response($response);





      }else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response);   
      }

    }


function productDetails_get()
    {
      if($_SERVER['REQUEST_METHOD']=='GET')
      {
        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] :''; 
        if ($product_id == "") {

            $response = array('code'=>'E_ERROR','message'=>'Productid Needed');
            $this->response($response);
        }



        $details = $this->Product_model->get_product_single($product_id );
        if(!empty($details)) {
            $finalArray =[];
            //$details['product_image'] = !empty($details['product_image']) ? base_url().'assets/uploads/product/'.$details['product_image'] : base_url().'assets/uploads/product/default.jpeg' ;
            $images = $this->Product_images->get_images_api($details['product_id']);
           
                foreach($images as $k=>$v){
                    $images[$k]['image_name'] = base_url().'assets/uploads/product/'.$v['image_name'];
                }
                 
            $details['product_image'] = !empty($images) ? $images[0]['image_name'] : base_url().'assets/uploads/product/default.jpeg' ;
            //unset($images[0]);
            //echo "<pre>";
            //print_r($images);exit;
            $details['images'] = $images;

            /*echo "<pre>";
            print_r($details);exit;*/
            /*if(!empty($details['product_size'])) {
                $sizeArray = explode(',',$details['product_size']);

                $fullArray = SizeList::getDropDown();
                
                
                foreach($sizeArray as $k=>$v){

                  foreach($fullArray as $k2=>$v2) {
                      if($v==$k2) {
                          $finalArray[]=array('size_id'=>$v,'size_text'=>$v2);
                      }
                  }

                  
          
                }


                //print_r();

              
            }*/


            if(!empty($details['variant_option_id'])) {
              



                $fullArray = $this->Product_images->get_product_variants($details['variant_option_id']);

             
                $finalArray = [];
                foreach($fullArray as $k=>$v){

                  
                      
                          $finalArray[]=array('size_id'=>$v['id'],'size_text'=>$v['option_name']);
                    
              

                  
          
                }


                //print_r();

              
            }

            


            $details['offer_percentage'] = '';
            if($details['product_is_offer']==1) {

                $percentage = $details['product_offer_price']/$details['product_price'];
                $percentage = $percentage*100;
                $details['offer_percentage'] = number_format($percentage,2).'% OFF';
            }


            $details['product_size'] = $finalArray;
            
            //color details
            $colorList =[];
            $colorList = $this->Product_color_model->get_list( 1 ,NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL,NULL,NULL,$product_id);
            $details['colorList'] = $colorList;
           
            //product varaint
            
            $variants = [];
            $variant_id = explode(',', $details['product_variant_id']);
            $variants = $this->Product_model->get_variant_list($variant_id);
            
            // $variant_option = [];
            // $variant_option_id = explode(',', $details['variant_option_id']);
            // $variant_option = $this->Product_model->get_variant_options_list($variant_option_id);
            // echo '<pre>'; print_r($variants); exit;
            
            $variantdata = [];
            foreach($variants as $k => $variant)
            {
                $variant_option_id = explode(',', $details['variant_option_id']);
                $variant_option = $this->Product_model->get_variant_options_list($variant_option_id, $variant['id']);
                // echo '<pre>'; print_r($variant_option); exit;
                $variantdata[$k] = $variant;
                $variantdata[$k]['variant_options'] = $variant_option;
            }
            
            $response = array('code'=>'OK','message'=>'Product Details','details'=>$details);

            $this->response($response);

            


        } else{
          $response = array('code'=>'E_ERROR','message'=>'No Data Found');
          $this->response($response);  
        }
        

      } else{
          $response = array('code'=>'E_ERROR','message'=>'Invalid request');
          $this->response($response);  
      }

    } 
    
    public function productImages(){
        echo $product_id = $_GET['product_id'];
    }
    
    public function offerList_get(){

      if($_SERVER['REQUEST_METHOD']=='GET')
      {

        //get stores with offer
        $storeList = [];
        $storeList = $this->Product_model->getstoreswithoffer();

        $offerList = [];

        foreach($storeList as $k=>$v){

            $offers = $this->Product_model->offerList($v['product_store_id']);
            $storeDetails = $this->Store_model->get_store_single($v['product_store_id']);
            $offerCount = count($offers);
            $offerCountText = $offerCount.' running offers';
            $storeName = $storeDetails['store_name'];
            $storeAddress = $storeDetails['store_address_line'];
            $storeOfferTagText = $storeDetails['store_offer_text'];
            $storeImage = !empty($storeDetails['store_logo']) ? base_url().'assets/uploads/store/'.$storeDetails['store_logo']:base_url().'assets/uploads/store/default.png';
            $offerList[] = array('offerCount'=>$offerCountText,
                                'storeName'=>$storeName,
                                'storeImage'=>$storeImage,
                                'storeAddress'=>$storeAddress,
                                'storeOfferTagText'=>$storeOfferTagText,
                                'offerEndsText'=>'Offer end in 3 days'
                               );

        
        
        }
        $response = array('code'=>'OK','message'=>'Offer List','list'=>$offerList);

        $this->response($response);

       


      }else{

          $response = array('code'=>'E_ERROR','message'=>'Invalid request');
          $this->response($response);  
      }

    }
  
    public function productImageDetail_get()
    {
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $color_id = $_GET['color_id'];
           $images = $this->Product_images->productImageDetail($color_id);
          $imageList = explode(',', $images['image_name']);
           $response = array('code'=>'OK','message'=>'Product Image Color List','imagedetail'=>$images, 'imageList' => $imageList);

            $this->response($response);
        }
        else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
          $this->response($response);   
        }
    }

    public function productImage_get(){
        $images = $this->Product_images->get_product_images($_GET['product_id']);
        $imgarry = array();
        foreach($images as $k => $v){
            if($v['image_name'] != ""){
                $imgs = explode(",",$v['image_name']);
                foreach($imgs as $v){
                    $imgarry[] = $v;
                }
            }
        }
        $response = array('code'=>'OK', 'imageList' => $imgarry);
        $this->response($response);
    }
}
?>
