<?php
class User_profile extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->posted=$this->input->post(NULL, TRUE);
			if( ! Modules::run('login/is_logged') )
			{
				redirect( base_url().'login' );
			}
			$this->load->model('User_model');
		}
		
		public function index()
		{
			$data['content']	=	'profile/profile';
			$this->load->view( 'public/page' , $data );
		}
		
		public function update()
		{
			
			if( ! $this->input->post( 'first_name' ) )
			{
				$res[ 'msg' ]	=	'<span class="text-danger">Please add your first name. </span>';
				$res[ 'res' ]	=	2;
				echo json_encode( $res );
				die();
			}
			$data[ 'first_name' ]	=	$this->input->post( 'first_name' );
			$data[ 'last_name' ]	=	$this->input->post( 'last_name' );
			$data[ 'email' ]	=	$this->input->post( 'email' );
			$data[ 'phone' ]	=	$this->input->post( 'phone' );
			$phone_change	=	false;
			if( trim($data[ 'phone' ])!=$this->user[ 'phone' ] )
			{
				$phone_change	=	true;
				$data[ 'phone_ver_status' ]	=	0;
			}
			if( trim($data[ 'email' ])!=$this->user[ 'email' ] )
			{
				$data[ 'email_ver_status' ]	=	0;
			}
			$this->db->trans_begin();
			
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
			
			$this->User_model->update( $data , $where );
			
			if( $phone_change && Modules::run( 'login/is_astrologer' )  )
			{
				$this->load->model( array( 'astrologer/Astrologer_service_model' ) );
				$awhere[ 'user_id' ]	=	$this->user[ 'id' ];
				$awhere[ 'service_id' ]	=	Services::PHONE_CALLING;
				$adata	=	$awhere;
				$adata[ 'service_status' ] = CommonStatus::HOLD;
				if( $this->Astrologer_service_model->get( $awhere ) )
				{
					$this->Astrologer_service_model->update( $adata , $awhere );
				}
			}
			
			
			
			if ($this->db->trans_status() !== FALSE)
			{
				$this->db->trans_commit();
				$res['res']	=	1;
				$res['msg']	=	'<span class="text-success">Profile Updated . </span>';
				$data[ 'msg' ]	=	'Your Profile Updated successfully  .';
				$data[ 'head' ]	=	'Success';
				$data[ 'type' ]	=	'success';
				$this->session->set_flashdata( 'msg' , $data );
			}
			else
			{
				$this->db->trans_rollback();
				$res['res']	=	2;
				$res['msg']	=	'<span class="text-warning">Something went wrong .</span>';
			}
			echo json_encode($res);
		}
		
		public function update_dp()
		{
			$k = 'image';
			$upload_path =  'assets/uploads/users/';
				
			$file_name = substr( url_title($this->user[ 'first_name' ].time(), 'dash', true) , 0 , 99 );			
			if( sizeof( $_FILES ) && $_FILES[ $k ]['tmp_name']!=NULL && $uploaded=$this->do_upload( $k, $upload_path , $file_name ))
			{													
				list($width, $height, $type, $attr) = getimagesize($_FILES[$k]['tmp_name']);
				$dimension_crop	=	$width < $height ? $width : $height;
				$dimension_resize	=	$dimension_crop < 300 ? $dimension_crop : 300;
				$this->resize_image( $upload_path.$uploaded , $dimension_resize );
				$this->crop_image( $upload_path.$uploaded , $dimension_crop );
				$data['image']	=	$uploaded;
				$last_image		=	$this->user[ 'image' ];
				if( trim( $last_image )!= '' )
				{
					$this->delete_file($upload_path.$last_image);	
				}
				$where[ 'id' ]	=	$this->user[ 'id' ];
				$this->User_model->update( $data , $where );
				$res['res']	=	1;
				$res['msg']	=	'<span class="text-success">Profile Picture Updated . </span>';				
																	
			}
			else
			{
				$res['res']	=	2;
				$res['msg']	=	'<span class="text-warning">Something went wrong .</span>';
			}
			echo json_encode($res);
		}
		
		
		
		
}