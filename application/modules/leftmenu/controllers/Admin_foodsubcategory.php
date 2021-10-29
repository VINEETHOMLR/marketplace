<?php
class Admin_foodsubcategory extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Foodsubcategory_model' ) );
    }
	
	public function list_json()
	{
		$subcategory_status	=	$this->input->post( 'subcategory_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Foodsubcategory_model->get_list(  $subcategory_status , $limit , $start , $date_from   , $date_to );
		
		$data[ 'total' ] = $this->Foodsubcategory_model->get_count(  $subcategory_status , $date_from   , $date_to );
		echo json_encode( $data );
	}

	public function form( $subcategory_id= NULL )
	{
		$data[ 'content' ] = 'leftmenu/foodsubcategory/form';
		$data[ 'subcategory' ]	=	array();
		if( $subcategory_id != NULL )
		{
			$data[ 'subcategory' ]	=	$this->Foodsubcategory_model->get( $subcategory_id );
		}
		//echo '<pre>';print_r($data[ 'blog' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	public function manage()
	{
		
		$data[ 'content' ]	=	'leftmenu/foodsubcategory/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	public function remove( $subcategory_id )
	{
		$where[ 'subcategory_id' ]  = $subcategory_id;
		$this->Foodsubcategory_model->delete( $where );
	}
	private function get_uri( $title , $id = NULL )
	{
		$config = array(
			'field' => 'subcategory_uri',
			'table' => 'mv_foodsubcategory',
			'id' => 'subcategory_id',
		);
		$this->load->library('slug', $config);
		return $uri	=	$this->slug->create_uri(array( 'title' => $title ), $id );
	}
	public function update()
	{
		//$subcategory_id	=	$_POST[ 'subcategory_id' ];

		
		$data[ 'subcategory_title' ]	=	$_POST[ 'subcategory_title' ];
		$data[ 'subcategory_status' ]	=	$_POST[ 'subcategory_status'];
		$data[ 'subcategory_category_id' ]	=	$_POST[ 'subcategory_category_id'];
		

		
		

		$subcategory_id	=	isset($_POST[ 'subcategory_id' ])?$_POST['subcategory_id']:0;
		$data[ 'subcategory_title_english' ]	=	$_POST[ 'subcategory_title_english' ];
		$data[ 'subcategory_uri' ]	=	$this->get_uri( $data['subcategory_title_english'] , $subcategory_id );
		

        $file_name=rand(5,15).'foodsubcategory'.time();
		$uploaded	=false;
		$image_identiy	=	'subcategory_image';
		$upload_path = 'assets/uploads/foodsubcategory/';
		
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
				$this->delete_file($uplosubcategory_path.$last_image);	
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
		    
		    $type = pathinfo($upload_path.$data['subcategory_image'], PATHINFO_EXTENSION);
            $subcategory_image_data = file_get_contents($upload_path.$data['subcategory_image']);
            $subcategory_image_data = 'data:image/' . $type . ';base64,' . base64_encode($subcategory_image_data);
            $data['subcategory_image_data']=$subcategory_image_data;
            
            
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
		    

		

		if( $subcategory_id == NULL )
		{
			$data[ 'subcategory_dateadded' ]	=	$this->dbnow;	
			$data[ 'subcategory_dateupdated' ]	=	$this->dbnow;	
			$subcategory_id	=	$this->Foodsubcategory_model->add( $data );
			$health = "New Subcategory added !";
		}
		else
		{
			$where[ 'subcategory_id' ]	=	$subcategory_id;
			$data[ 'subcategory_dateupdated' ]	=	$this->dbnow;
			$this->Foodsubcategory_model->update( $data , $where );
			$health = "Subcategory updated !";
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
			$msg[ 'red' ]	=	$this->base.'leftmenu/admin_foodsubcategory/manage';
		}
		echo json_encode( $msg );
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'subcategory_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Foodsubcategory_model->update( $data , $where ) )
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
	function get_subcategories()
	{
		return $this->Foodsubcategory_model->subcategory_list();

	}
	
	
}