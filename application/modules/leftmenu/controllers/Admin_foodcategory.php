<?php
class Admin_foodcategory extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Foodcategory_model' ) );
    }
	

	public function form( $category_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/foodcategory/form';
		$data[ 'category' ]	=	array();
		if( $category_id != NULL )
		{
			$data[ 'category' ]	=	$this->Foodcategory_model->get( $category_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/foodcategory/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $category_id )
	{
		$where[ 'category_id' ]  = $category_id;
		$this->Foodcategory_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'category_uri',
			'table' => 'mv_foodcategory',
			'id' => 'category_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$category_id	=	$_POST[ 'category_id' ];

		
		$data[ 'category_title' ]	=	$_POST[ 'category_title' ];
		$data[ 'category_status' ]	=	$_POST[ 'category_status'];
		

		
		

		$category_id	=	isset($_POST[ 'category_id' ])?$_POST['category_id']:0;
		$data[ 'category_title_english' ]	=	$_POST[ 'category_title_english' ];
		$data[ 'category_uri' ]	=	$this->get_uri( $data['category_title_english'] , $category_id );
		

        $file_name=rand(5,15).'foodcategory'.time();
		$uploaded	=false;
		$image_identiy	=	'category_image';
		$upload_path = 'assets/uploads/foodcategory/';
		
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL  )
		{
			
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			if( $file_name != NULL )
			{
				$config[ 'file_name' ] = $file_name;
			}
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload($image_identiy))
			{
				$msg['res']		=	2;
				$msg['msg']		=	$this->upload->display_errors();
				echo json_encode( $msg );
				die();
			}
			else
			{
				$upload_data = ($this->upload->data());
				$uploaded =  $upload_data['file_name'];
			
			}
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($uplocategory_path.$last_image);	
			}
			list($width, $height, $type, $attr) = getimagesize($upload_path.$data[$image_identiy]);
            $aspect = $width / $height;
            $newWidth = 1000;
            $newHeight = $newWidth / $aspect;
			$config="";
		    $this->load->library('image_lib');
		    $config['image_library']  = 'gd2';
		    $config['source_image']   = $upload_path.$data[$image_identiy];       
		    // $config['create_thumb']   = TRUE;
		    $config['maintain_ratio'] = FALSE;
		    $config['width']          = $newWidth;
		    $config['height']         = $newHeight;
		    $config['new_image']      = $upload_path.$data[$image_identiy]; 
		                
		    $this->image_lib->initialize($config);
		    $this->image_lib->resize();
		    
		    $type = pathinfo($upload_path.$data['category_image'], PATHINFO_EXTENSION);
            $category_image_data = file_get_contents($upload_path.$data['category_image']);
            $category_image_data = 'data:image/' . $type . ';base64,' . base64_encode($category_image_data);
            $data['category_image_data']=$category_image_data;
            
            
            //fb share image creation
            $config="";
				
			$this->load->library('image_lib');
			$config['image_library']  = 'gd2';
			$config['source_image']   = $upload_path.$data[$image_identiy];       
			// $config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width']          = 150;
			$config['height']         = 150;
			$config['new_image']      = $upload_path.'fb/'.$data[$image_identiy];  
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
		}
		//echo '<pre>';print_r($data);exit;
		    $this->db->trans_begin();
		    

		

		if( $category_id == NULL )
		{
			$data[ 'category_dateadded' ]	=	$this->dbnow;	
			$data[ 'category_dateupdated' ]	=	$this->dbnow;	
			$category_id	=	$this->Foodcategory_model->add( $data );
			$health = "New health added !";
		}
		else
		{
			$where[ 'category_id' ]	=	$category_id;
			$data[ 'category_dateupdated' ]	=	$this->dbnow;
			$this->Foodcategory_model->update( $data , $where );
			$health = "health updated !";
		}

	    
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'Something went wrong Please try again !';
		}
		else
		{
			$this->db->trans_commit();
			$msg['res']		=	1;
			$msg['msg']		=	$health;
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_foodcategory/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'category_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Foodcategory_model->update( $data , $where ) )
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

	function get_categories()
	{
		return $this->Foodcategory_model->category_list();

	}
	
	
	
}