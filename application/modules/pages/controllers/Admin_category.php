<?php
class Admin_category extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin' ) );
		$this->load->model( array( 'Admin_category_model' ) );
    }
	
	public function list_json()
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$image_category_status	=	$this->input->post( 'image_category_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		
		$search	=	$this->input->post( 'search' );
		
		$user_id	=	NULL;
		
		
		
		$records[ 'rows' ]	=	$this->Admin_category_model->get_list(  $image_category_status ,  $limit ,  $offset  ,  $date_from ,  $date_to ,  $search  );
		$records[ 'total' ]	=	$this->Admin_category_model->get_count(  $image_category_status ,  $date_from ,  $date_to  ,  $search   );
		echo json_encode( $records );
		
	}
	
	public function manage()
	{
		$data[ 'content' ] = 'admin/category';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function update( )
	{
		
		$data[ 'image_category_title' ]	=	$this->input->post( 'image_category_title' );
		
		
		
		$k = 'image_category_image';
		$upload_path =  'assets/uploads/category/original';

		$file_name = substr( url_title($data[ 'image_category_title' ].'_', 'dash', true) , 0 , 99 );			
		if( sizeof( $_FILES ) && $_FILES[ $k ]['tmp_name']!=NULL && $uploaded=$this->do_upload( $k, $upload_path , $file_name ))
		{	


            $config="";
		    $this->load->library('image_lib');
		    $config['image_library']  = 'gd2';
		    $config['source_image']   =$upload_path.'/'.$uploaded;
	        // $config['create_thumb']   = TRUE;
		    $config['maintain_ratio'] = FALSE;
		    $config['width']          = 270;
		    $config['height']         = 320;
		    $config['new_image']      = 'assets/uploads/category/resized/'.$uploaded;
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
			$data['image_category_image_original']=$this->base.$upload_path.'/'.$uploaded;
			$data['image_category_image_resized']=$this->base.'assets/uploads/category/resized/'.$uploaded;
			/*$last_image	=	$this->input->post( 'last_image' );
			if( trim( $last_image )!= '' )
			{
				$this->delete_file($upload_path.'/'.$last_image);	
			}*/
									
																
		}
		
		
		//echo "<pre>";
		//print_r($data);die();
		$image_category_id	=	$this->input->post( 'id' );
		$res	=	FALSE;
		if( $image_category_id == NULL )
		{
			$data[ 'image_category_status' ]	=	CommonStatus::HOLD;
			$data['date_of_join']=$this->dbnow;
			$data['date_of_update']=$this->dbnow;
			$res	=	$this->Admin_category_model->add( $data );
		}
		else
		{
			$where[ 'image_category_id' ]	=	$image_category_id;
			$data['date_of_update']=$this->dbnow;
			$res	=	$this->Admin_category_model->update( $data , $where );
		}
		
		if( $res )
		{
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'image_category updated';
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
		$where[ 'image_category_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Admin_category_model->update( $data , $where ) )
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
	
	private function remove_image_category( $id )
	{
		$image_category	=	$this->Admin_category_model->get( $id );
		if( trim( $image_category[ 'image_category_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/category/'.$image_category[ 'image_category_image' ] );
		}
		
		return $this->Admin_category_model->delete( $id );
	}
	
	
	public function delete($image_category_id )
	{
		//$image_category_id	=	$this->input->post( 'id' );
		if( $this->remove_image_category( $image_category_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
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
		$image_category_id	=	$this->input->post( 'id' );
		
		foreach( $image_category_id as $id )
		{
			$this->remove_image_category( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Category Deleted .</span>';
		
		echo json_encode($msg);
	}
	
	
	
	
}