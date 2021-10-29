<?php
class Admin_profile extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->posted=$this->input->post(NULL, TRUE);
			if( ! Modules::run('login/is_logged') )
			{
				redirect( base_url().'login' );
			}
			$this->load->model('user/User_model');
		}
		
		public function index()
		{
			$data['content']	=	'profile/profile';
			//$this->load->model('Social_media_model');
			//$data['social']=$this->Social_media_model->get_social_media($status=NULL);
			//$this->load->model('Contact_details_model');
            //$data['contactdetails']=$this->Contact_details_model->get(1);
		//	echo "<pre>";
		//	print_r($data['social']);die();
			$this->load->view( 'admin/page' , $data );
		}
		
		public function update()
		{
			if( ! $this->input->post( 'first_name' ) )
			{
				die();	
			}
			$data[ 'first_name' ]	=	$this->input->post( 'first_name' );
			$data[ 'last_name' ]	=	$this->input->post( 'last_name' );
			$data[ 'email' ]	=	$this->input->post( 'email' );
			$data[ 'phone' ]	=	$this->input->post( 'phone' );
			
			if( Modules::run( 'login/is_admin' ) )
			{
				$user_id	=	$this->input->post( 'id' );
				$last_image	=	$this->input->post( 'user_last_image' );
			}
			else
			{
				$user_id	=	$this->user['id'];
				$last_image	=	$this->user['image'];
			}
			
			
			$where['id']	=	$user_id;
			if( Modules::run( 'user/registration/check_email' , $data[ 'email' ] , NULL , $user_id ) > 0 )
			{
				$res[ 'msg' ]	=	'<span class="text-danger">Email Id already registered. </span>';
				$res[ 'res' ]	=	2;
				echo json_encode( $res );
				die();
			}
			
			$file_name = substr( url_title($data[ 'first_name' ].$user_id, 'dash', true) , 0 , 99 );			
			$uploaded	=false;
			$image_identiy	=	'image';
			$upload_path = 'assets/uploads/users/';
			//echo '<pre>';print_r($_FILES);exit;
			if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
			{
				list($width, $height, $type, $attr) = getimagesize($_FILES[$image_identiy]['tmp_name']);
				$dimension_crop	=	$width < $height ? $width : $height;
				$dimension_resize	=	$dimension_crop < 300 ? $dimension_crop : 300;
				$this->resize_image( $upload_path.$uploaded , $dimension_resize );
				$this->crop_image( $upload_path.$uploaded , $dimension_crop );
				
				$data[ $image_identiy ]	=	$uploaded;
				$last_image	=	$this->input->post( $image_identiy."_last" );
				if(  isset( $last_image ) && trim( $last_image ) != '' ){
					$this->delete_file($upload_path.$last_image);	
				}
			}
			
			
			
			if( $this->User_model->update( $data , $where ) )
			{
				$res['res']	=	1;
				$res['msg']	=	'<span class="text-success">Profile Updated . </span>';
			}
			else
			{
				$res['res']	=	2;
				$res['msg']	=	'<span class="text-warning">Something went wrong .</span>';
			}
			echo json_encode($res);
		}
		
		
		public function update_social(){



			 $this->load->model('Social_media_model');
			 $ids=$this->input->post('id');
	         $social_ids=$this->input->post('social_id');	
	         $social_links=$this->input->post('social_link');	
	         $soial_statuss=$this->input->post('social_status');
             
             foreach($social_ids as $k=>$v){
             if($v!=0)	
             {
               $result="";	
               $id=$ids[$k];
               
               $data['social_id']=$v;
               $data['social_link']=$social_links[$k];
               $data['social_status']=$soial_statuss[$k];
             
               if($id!=NULL)
               {
               $where['id']=$id;
               
               if($this->Social_media_model->update($data,$where))
               {
               	$result=1;
               }
               else
               {
                $result=2;
               }

               }
               else
               {
               if($this->Social_media_model->add($data))
               {
               	$result=1;
               }
               else
               {
               	$result=2;
               }
               }
               
                
             }
             }

             if($result==1)
             {
              $res['res']	=	1;
			  $res['msg']	=	'<span class="text-success">Social Media  updated . </span>';	
             }
             else
             {
              $res['res']	=	2;
			  $res['msg']	=	'<span class="text-success">Something went wrong. </span>';	
             }
             echo  json_encode($res);


             
		}
		function get_social_media()
	{
		$this->load->model('Social_media_model');
		$data['socialmedias']=$this->Social_media_model->get_social_media(SocialmediaStatus::ACTIVE);
		return $data['socialmedias'];

		


     

   }	
   
   function update_contact()
   {
   	
   	
   $this->load->model('Contact_details_model');	
   $contact_id=$this->input->post('contact_id')?$this->input->post('contact_id'):0;
   $data['contact_address']=$this->input->post('contact_address');
   $data['contact_email']=json_encode($this->input->post('contact_email'));
   $data['contact_phone']=json_encode($this->input->post('contact_phone'));
  
   if($contact_id==0)
   {
   $res=$this->Contact_details_model->add($data);

   }
   else{
   $where['contact_id']	=$contact_id;
   $res=$this->Contact_details_model->update($data , $where);
  
   }


       if( $res )
		{
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'Contact Details  updated';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again';
		}
		echo json_encode( $msg );


   }
		
		
}