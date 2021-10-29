<?php
require(APPPATH.'/libraries/REST_Controller.php');
 //class Login extends MX_Controller{
/*header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
*/
class Visit extends REST_Controller{
    
    public function __construct()
    {
       parent::__construct();
       $this->load->model(array('User_token','visit/Visit_model','Register_model','visit/Covisitor_model'));

       
    }

  

    


  public function addvisit_post()
  {

      if($_SERVER['REQUEST_METHOD']=='POST')
      {


       
       $headers = apache_request_headers();
       $token = $headers['Authorization'];
       $userId  = isset($_POST['userId'])?$_POST['userId']:"";
       $visit_fullname  = isset($_POST['visit_fullname'])?$_POST['visit_fullname']:"";
       $visit_companyname  = isset($_POST['visit_companyname'])?$_POST['visit_companyname']:""; //company name of the visitor
       $visit_drivingid = isset($_POST['visitor_id'])?$_POST['visitor_id']:""; //driving or anyother driving 
       $visit_mobile = isset($_POST['visit_mobile'])?$_POST['visit_mobile']:"";
       $visit_purpose = isset($_POST['visit_purpose'])?$_POST['visit_purpose']:"";
       $visit_who_to_meet = isset($_POST['visit_who_to_meet'])?$_POST['visit_who_to_meet']:"";// this willbe id
       $visit_no_of_visitors = isset($_POST['visit_no_of_visitors'])?$_POST['visit_no_of_visitors']:"0";// 
       $visit_date = isset($_POST['visit_date'])?$_POST['visit_date']:"";// 
       $visit_time = isset($_POST['visit_time'])?$_POST['visit_time']:"";// 
       $visit_company_id = isset($_POST['visit_company_id'])?$_POST['visit_company_id']:"";// 
       $visit_image = !empty($_FILES['visit_image']) ? $_FILES['visit_image'] : "";
       $covisitors = !empty($_POST['covisitors']) ? json_decode($_POST['covisitors'],true) : array();

      


       if($visit_no_of_visitors > 1 && count($covisitors) == 0) {

           $response =array('code'=>'E_ERROR','message'=>'Covisitors details needed');
           $this->response($response);
       }

       
       if(!$this->User_token->check_token($token,$userId))
       {
          $response =array('code'=>'E_AUTHORIZED','message'=>'Session Expired');
          $this->response($response);
       }
       if($userId=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'UserId needed');
         $this->response($response);
       }
      
       if($visit_fullname=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Fullname of visitor needed');
         $this->response($response);
       }
       if($visit_companyname=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Visitor Company name needed');
         $this->response($response);
       }

       
       if($visit_drivingid=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Visitor id needed');
         $this->response($response);
       }
       if($visit_mobile=='')
       {

            $response =array('code'=>'E_ERROR','message'=>'Visitor mobile needed');
            $this->response($response); 
       }
 
       if($visit_purpose=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Visit purpose Needed');
         $this->response($response);
       }
       if($visit_who_to_meet=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Who to meet needed');
         $this->response($response);
       }
       if($visit_no_of_visitors=="0" || $visit_no_of_visitors<0)
       {
         $response =array('code'=>'E_ERROR','message'=>'Number of visitors needed');
         $this->response($response);
       }

       if($visit_date=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Visit date needed');
         $this->response($response);
       }

       if($visit_time=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Visit time needed');
         $this->response($response);
       }

       if($visit_company_id=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Company id needed');
         $this->response($response);
       }

       if($visit_image=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Image needed');
         $this->response($response);
       }



       $data['visit_added_by'] = $userId;
       $data['visit_fullname'] =$visit_fullname;
       $data['visit_companyname'] =$visit_companyname;
       $data['visit_drivingid'] =$visit_drivingid;
       $data['visit_mobile'] =$visit_mobile;
       $data['visit_purpose'] =$visit_purpose;
       $data['visit_who_to_meet'] =$visit_who_to_meet;
       $data['visit_no_of_visitors'] =$visit_no_of_visitors;
       $data['visit_checkin_date'] = date('Y-m-d',strtotime($visit_date)); 
       $data['visit_checkin_time'] =$visit_time;
       $data['visit_company_id'] =$visit_company_id;
       $data['visit_created'] = time();
       $data['visit_updated'] = time();
       $data['visit_status'] = 1;


       if(!empty($visit_image))
           {

               $upload_path = 'assets/uploads/visitor/';
               $extension=array("jpeg","jpg","png","gif");
               $error =array();

               $file_name=$visit_image["name"];
               $file_tmp=$visit_image["tmp_name"];
               $ext=pathinfo($file_name,PATHINFO_EXTENSION);
       

             if(!file_exists($upload_path."/".$file_name)) {
                        move_uploaded_file($file_tmp=$visit_image["tmp_name"],$upload_path."/".$file_name);
                        $filename = $file_name;
              }
              else {
                        
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                move_uploaded_file($file_tmp=$visit_image["tmp_name"],$upload_path."/".$newFileName);
                $filename = $newFileName;

             
             }
             $data['visit_image'] = $filename;

           }




       if($visit_id=$this->Visit_model->add($data))
       {
         $data =array();

         if(count($covisitors)>0) {
             foreach ($covisitors as $k=>$v) {
                $data['covisitor_name'] = $v['covisitor_name'];
                $data['covisitor_visit_id'] = $visit_id;
                $data['covisitor_driving_id'] = $v['covisitor_driving_id'];
                $this->Covisitor_model->add($data);
             }
         } 
         
         $response = array('code'=>'OK','message'=>'Visit added successfuly');
         $this->response($response);

       }
       else{
        $response = array('code'=>'E_ERROR','message'=>'Something went wrong');
        $this->response($response);
       }

     }else{
         $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
        $this->response($response);
     }


  }


  public function editvisit_post()
  {

      if($_SERVER['REQUEST_METHOD']=='POST')
      {


       $headers = apache_request_headers();
       $token = $headers['Authorization'];
       $userId  = isset($_POST['userId'])?$_POST['userId']:"";
       $visit_id = isset($_POST['visit_id'])?$_POST['visit_id']:"";
       $visit_fullname  = isset($_POST['visit_fullname'])?$_POST['visit_fullname']:"";
       $visit_companyname  = isset($_POST['visit_companyname'])?$_POST['visit_companyname']:""; //company name of the visitor
       $visit_drivingid = isset($_POST['visitor_id'])?$_POST['visitor_id']:""; //driving or anyother driving 
       $visit_mobile = isset($_POST['visit_mobile'])?$_POST['visit_mobile']:"";
       $visit_purpose = isset($_POST['visit_purpose'])?$_POST['visit_purpose']:"";
       $visit_who_to_meet = isset($_POST['visit_who_to_meet'])?$_POST['visit_who_to_meet']:"";// this willbe id
       $visit_no_of_visitors = isset($_POST['visit_no_of_visitors'])?$_POST['visit_no_of_visitors']:"0";// 
       $visit_date = isset($_POST['visit_date'])?$_POST['visit_date']:"";// 
       $visit_time = isset($_POST['visit_time'])?$_POST['visit_time']:"";// 
       $visit_company_id = isset($_POST['visit_company_id'])?$_POST['visit_company_id']:"";// 
       $visit_image = !empty($_FILES['visit_image']) ? $_FILES['visit_image'] : "";

       $covisitors = !empty($_POST['covisitors']) ? json_decode($_POST['covisitors'],true) : array();

       if(!$this->User_token->check_token($token,$userId))
       {
          $response =array('code'=>'E_AUTHORIZED','message'=>'Session Expired');
          $this->response($response);
       }
       if($visit_id=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Visitid needed');
         $this->response($response);
       }
       if($userId=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'UserId needed');
         $this->response($response);
       }
      
       if($visit_fullname=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Fullname of visitor needed');
         $this->response($response);
       }
       if($visit_companyname=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Visitor Company name needed');
         $this->response($response);
       }

       
       if($visit_drivingid=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'Visitor id needed');
         $this->response($response);
       }
       if($visit_mobile=='')
       {

            $response =array('code'=>'E_ERROR','message'=>'Visitor mobile needed');
            $this->response($response); 
       }
 
       if($visit_purpose=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Visit purpose Needed');
         $this->response($response);
       }
       if($visit_who_to_meet=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Who to meet needed');
         $this->response($response);
       }
       if($visit_no_of_visitors=="0" || $visit_no_of_visitors<0)
       {
         $response =array('code'=>'E_ERROR','message'=>'Number of visitors needed');
         $this->response($response);
       }

       if($visit_no_of_visitors > 1 && count($covisitors) == 0) {

           $response =array('code'=>'E_ERROR','message'=>'Covisitors details needed');
           $this->response($response);
       }

       if($visit_date=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Visit date needed');
         $this->response($response);
       }

       if($visit_time=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Visit time needed');
         $this->response($response);
       }

       if($visit_company_id=="")
       {
         $response =array('code'=>'E_ERROR','message'=>'Company id needed');
         $this->response($response);
       }

      



       $data['visit_added_by'] = $userId;
       $data['visit_fullname'] =$visit_fullname;
       $data['visit_companyname'] =$visit_companyname;
       $data['visit_drivingid'] =$visit_drivingid;
       $data['visit_mobile'] =$visit_mobile;
       $data['visit_purpose'] =$visit_purpose;
       $data['visit_who_to_meet'] =$visit_who_to_meet;
       $data['visit_no_of_visitors'] =$visit_no_of_visitors;
       $data['visit_checkin_date'] = date('Y-m-d',strtotime($visit_date)); 
       $data['visit_checkin_time'] =$visit_time;
       $data['visit_company_id'] =$visit_company_id;
       $data['visit_updated'] = time();
       $data['visit_status'] = 1;


       if(!empty($visit_image))
           {

               $upload_path = 'assets/uploads/visitor/';
               $extension=array("jpeg","jpg","png","gif");
               $error =array();

               $file_name=$visit_image["name"];
               $file_tmp=$visit_image["tmp_name"];
               $ext=pathinfo($file_name,PATHINFO_EXTENSION);
       

             if(!file_exists($upload_path."/".$file_name)) {
                        move_uploaded_file($file_tmp=$visit_image["tmp_name"],$upload_path."/".$file_name);
                        $filename = $file_name;
              }
              else {
                        
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                move_uploaded_file($file_tmp=$visit_image["tmp_name"],$upload_path."/".$newFileName);
                $filename = $newFileName;

             
             }
             $data['visit_image'] = $filename;

           }

       $where['visit_id'] = $visit_id; 


       if($this->Visit_model->update($data,$where))
       {
         $where =array();
         $where['covisitor_visit_id'] = $visit_id; 
         $this->Covisitor_model->delete($where);

         $data =array();

         if(count($covisitors)>0) {
             foreach ($covisitors as $k=>$v) {
                $data['covisitor_name'] = $v['covisitor_name'];
                $data['covisitor_visit_id'] = $visit_id;
                $data['covisitor_driving_id'] = $v['covisitor_driving_id'];
                $this->Covisitor_model->add($data);
             }
         }



         $response = array('code'=>'OK','message'=>'Visit edited successfuly');
         $this->response($response);

       }
       else{
        $response = array('code'=>'E_ERROR','message'=>'Something went wrong');
        $this->response($response);
       }

     }else{
         $response = array('code'=>'E_ERROR','message'=>'Invalid Request');
        $this->response($response);
     }


  }


  

  public function getvisitdetails_get()
  {

    if($_SERVER['REQUEST_METHOD']=='GET')
      {
       $headers = apache_request_headers();
       $token = $headers['Authorization'];
      // echo $_POST['userId'];exit;
       $userId  = isset($_GET['userId'])?$_GET['userId']:"";
       $visit_id  = isset($_GET['visit_id'])?$_GET['visit_id']:"";
       if(!$this->User_token->check_token($token,$userId))
       {
          $response =array('code'=>'E_AUTHORIZED','message'=>'Invalid Request');
          $this->response($response);
       }
       if($userId=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'UserId needed');
         $this->response($response);
       }

       if($visit_id=='')
       {
         $response =array('code'=>'E_ERROR','message'=>'ID needed');
         $this->response($response);
       }
       if($details = $this->Visit_model->details($visit_id)) {



           $visitCount = $this->Visit_model->getvisitcount($details['visit_fullname'],$details['visit_checkin_date']);
           $visitCount =  !empty($visitCount['visitCount']) ? $visitCount['visitCount'] :'0';
           $details['visitCount'] = $visitCount;

           $details['visit_checkin_date'] = !empty($details['visit_checkin_date']) ? date('d-m-Y',strtotime($details['visit_checkin_date'])) : '-';
           $details['visit_checkout_date'] = !empty($details['visit_checkout_date']) ? date('d-m-Y',strtotime($details['visit_checkout_date'])) : '';
           $details['visit_checkout_time'] = !empty($details['visit_checkout_time']) ? date('d-m-Y',strtotime($details['visit_checkout_time'])) : '';
           $details['visit_image'] = !empty($details['visit_image']) ? base_url().'assets/uploads/visitor/'.$details['visit_image'] :'';

           $covisitor_list = $this->Covisitor_model->getcovisitors($visit_id);
           $details['co_visitor_list'] = !empty($covisitor_list) ? $covisitor_list : array();

         
           $response = array('code'=>'OK','message'=>'Success','data'=>$details);
           $this->response($response);
       } else{

           $response = array('code'=>'OK','message'=>'Something went wrong');
           $this->response($response); 
       }


       


     } else {
         $response = array('code'=>'OK','message'=>'Invalid Request');
         $this->response($response); 
     }

  }


  public function getemployee_get()
  {

    if($_SERVER['REQUEST_METHOD']=='GET')
      {
          $headers = apache_request_headers();
          $token = $headers['Authorization'];
          $userId  = isset($_GET['userId'])?$_GET['userId']:""; 
          $keyword = isset($_GET['keyword']) ? $_GET['keyword']:""; 
          $company_id = isset($_GET['company_id']) ? $_GET['company_id']:""; 
          if(!$this->User_token->check_token($token,$userId))
          {
              $response =array('code'=>'E_AUTHORIZED','message'=>'Session Expired');
              $this->response($response);
          }
          if($userId=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'UserId needed');
             $this->response($response);
          }

          if($company_id=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'Companyid needed');
             $this->response($response);
          }

          if($keyword) {
               $list = $this->Register_model->searchemployee($keyword,$company_id);
               $data  = array('list'=>$list,'count'=>count($list));
               $response = array('code'=>'OK','message'=>'List','data'=>$data);
               $this->response($response);
               
          }



      } else {
          $response = array('code'=>'E_ERROR','message'=>'Invalid request');
          $this->response($response);  
      }

  }


  public function getvisitlist_get()
  {

      if($_SERVER['REQUEST_METHOD']=='GET')
      {

          $headers = apache_request_headers();
          $token = $headers['Authorization'];
          $userId  = isset($_GET['userId'])?$_GET['userId']:""; 
          $company_id = isset($_GET['company_id']) ? $_GET['company_id']:""; 
          $user_type = isset($_GET['user_type']) ? $_GET['user_type']:""; 
          $search = isset($_GET['search']) ? $_GET['search']:"";
          if(!$this->User_token->check_token($token,$userId))
          {
              $response =array('code'=>'E_AUTHORIZED','message'=>'Session Expired');
              $this->response($response);
          }
          if($userId=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'UserId needed');
             $this->response($response);
          }

          if($company_id=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'Companyid needed');
             $this->response($response);
          }

          if($user_type=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'Usertype needed');
             $this->response($response);
          }

          


             
             
               if($search == "") {
                   $dates = $this->Visit_model->getdatesgroup($company_id,$user_type,$userId);
                   $listarray = array(); 

                  
                   if(!empty($dates)) {
                       foreach ($dates as $k=>$v) {

                           $list = $this->Visit_model->getvisit_list($company_id,$user_type,$userId,$v['visit_checkin_date'],$search);
                           $date = date('d-m-Y',strtotime($v['visit_checkin_date']))==date('d-m-Y') ? 'Today' : date('d-m-Y',strtotime($v['visit_checkin_date']));
                           $listarray [$k]['date'] =$date;
                           $listarray [$k]['list'] =($list);
                           
                       }

                      
                   $response = array('code'=>'OK','type'=>'WITHOUTSEARCH','message'=>'List','data'=>$listarray);
                  
                       
                   }
               } else {
                   $list = $this->Visit_model->getvisit_list($company_id,$user_type,$userId,NULL,$search); 
                   $response = array('code'=>'OK','type'=>'SEARCH','message'=>'List','data'=>$list);
                   
                   
               }

               $this->response($response);
         
           


          

          







      } else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid request');
          $this->response($response);      
      }  

  }


  public function addcheckout_post() 
  {

      if($_SERVER['REQUEST_METHOD']=='POST')
      {

          $headers = apache_request_headers();
          $token = $headers['Authorization'];
          $userId  = isset($_POST['userId'])?$_POST['userId']:""; 
          $visit_id = isset($_POST['visit_id']) ? $_POST['visit_id']:""; 
          $visit_checkout_date = isset($_POST['visit_checkout_date']) ? $_POST['visit_checkout_date']:""; 
          $visit_checkout_time = isset($_POST['visit_checkout_time']) ? $_POST['visit_checkout_time']:"";
          if(!$this->User_token->check_token($token,$userId))
          {
              $response =array('code'=>'E_AUTHORIZED','message'=>'Session Expired');
              $this->response($response);
          }
          if($userId=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'UserId needed');
             $this->response($response);
          }

          if($visit_id=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'Visitid needed');
             $this->response($response);
          }

          if($visit_checkout_date=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'Checkout date needed');
             $this->response($response);
          }

          if($visit_checkout_time=='')
          {
             $response =array('code'=>'E_ERROR','message'=>'Checkout time needed');
             $this->response($response);
          } 

          $data['visit_checkout_date']  = date('Y-m-d',strtotime($visit_checkout_date));
          $data['visit_checkout_time']  = $visit_checkout_time;
          $data['visit_updated']  = time();
          $where['visit_id'] = $visit_id;
          if($this->Visit_model->update($data,$where)) {
            $response =array('code'=>'OK','message'=>'Successfully added');
          } else {
            $response =array('code'=>'E_ERROR','message'=>'Something went wrong');
          }
            $this->response($response); 

      } else {

          $response = array('code'=>'E_ERROR','message'=>'Invalid request');
          $this->response($response);      
      }  

  }

 

  

 

   





   


    


  


   
  
}
?>