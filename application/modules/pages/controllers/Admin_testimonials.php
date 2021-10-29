<?php
class Admin_testimonials extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
		$this->load->model( array( 'Testimonials_model' ) );
    }
	
	public function list_json()
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$testimonial_status	=	$this->input->post( 'testimonial_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$testimonial_experiance	=	$this->input->post( 'testimonial_experiance' );
		$course_id	=	$this->input->post( 'course_id' );
		$search	=	$this->input->post( 'search' );
		
		$user_id	=	NULL;
		
		if( Modules::run( 'login/is_company' ) )
		{
			$user_id	=	$this->user[ 'id' ];
		}
		
		$records[ 'rows' ]	=	$this->Testimonials_model->get_list(  $testimonial_status ,  $limit ,  $offset  ,  $date_from ,  $date_to , $testimonial_experiance , $course_id , $search , $user_id  );
		$records[ 'total' ]	=	$this->Testimonials_model->get_count(  $testimonial_status ,  $date_from ,  $date_to  , $testimonial_experiance , $course_id  , $search  , $user_id );
		echo json_encode( $records );
		
	}
	
	public function manage()
	{
		$data[ 'content' ] = 'admin/testimonials';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function update( )
	{
		
		$data[ 'testimonial_name' ]	=	$this->input->post( 'testimonial_name' );
		$data[ 'testimonial_description' ]	=	$this->input->post( 'testimonial_description' );
		$data[ 'testimonial_user_type' ]	=	$this->input->post( 'testimonial_user_type' );
		$data[ 'testimonial_position' ]	=	$this->input->post( 'testimonial_position' );
		
		$k = 'testimonial_user_image';
		$upload_path =  'assets/uploads/users';
			
		$file_name = substr( url_title($data[ 'testimonial_name' ].'_', 'dash', true) , 0 , 99 );			
		if( sizeof( $_FILES ) && $_FILES[ $k ]['tmp_name']!=NULL && $uploaded=$this->do_upload( $k, $upload_path , $file_name ))
		{	


            $config="";
		    $this->load->library('image_lib');
		    $config['image_library']  = 'gd2';
		    $config['source_image']   =$upload_path.'/'.$uploaded;
	        // $config['create_thumb']   = TRUE;
		    $config['maintain_ratio'] = FALSE;
		    $config['width']          = 153;
		    $config['height']         = 183;
		    $config['new_image']      = $upload_path.'/'.$uploaded;
		    $this->image_lib->initialize($config);
		    $this->image_lib->resize();

			/*list($width, $height, $type, $attr) = getimagesize($_FILES[$k]['tmp_name']);
			$dimension_crop	=	$width < $height ? $width : $height;
			$dimension_resize	=	$dimension_crop < 300 ? $dimension_crop : 300;
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_path.'/'.$uploaded;
			//$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width']     = $dimension_crop;
			//$config['height']    = $dimension_crop;
			$this->load->library('image_lib');
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			$this->image_lib->crop();
			
			$config['width']     = $dimension_resize;
			$config['height']    = $dimension_resize;
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
*/
			$data['testimonial_user_image']=$uploaded;
			$last_image	=	$this->input->post( 'last_image' );
			if( trim( $last_image )!= '' )
			{
				$this->delete_file($upload_path.'/'.$last_image);	
			}
									
																
		}
		
		
		
		$testimonial_id	=	$this->input->post( 'id' );
		$res	=	FALSE;
		if( $testimonial_id == NULL )
		{
			$data[ 'testimonial_status' ]	=	CommonStatus::HOLD;
			$res	=	$this->Testimonials_model->add( $data );
		}
		else
		{
			$where[ 'testimonial_id' ]	=	$testimonial_id;
			$res	=	$this->Testimonials_model->update( $data , $where );
		}
		
		if( $res )
		{
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'Testimonial updated';
		}
		else
		{
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again';
		}
		
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'testimonial_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Testimonials_model->update( $data , $where ) )
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
	
	private function remove_testimonial( $id )
	{
		$testimonial	=	$this->Testimonials_model->get( $id );
		if( trim( $testimonial[ 'testimonial_user_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/users/'.$testimonial[ 'testimonial_user_image' ] );
		}
		
		return $this->Testimonials_model->delete( $id );
	}
	
	
	public function delete($testimonial_id )
	{
		//$testimonial_id	=	$this->input->post( 'id' );
		if( $this->remove_testimonial( $testimonial_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Testimonial Deleted .</span>';
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
		$testimonial_id	=	$this->input->post( 'id' );
		
		foreach( $testimonial_id as $id )
		{
			$this->remove_testimonial( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
		
		echo json_encode($msg);
	}
	
	
	
	
}