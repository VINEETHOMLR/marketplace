<?php
class Img extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( array( 'Images_model' ) );
	}
	
	public function clear( $image_ref_id= NULL , $image_content_type= NULL   )
	{
		$where[ 'image_ref_id' ]	=	$image_ref_id;
		$where[ 'image_content_type' ]	=	$image_content_type;
		$images	=	$this->Images_model->get_many($where);
		$upload_path = 'assets/uploads/images/';
		foreach( $images as $v )
		{
			if( trim($v[ 'image_name' ]) != '' )
			{
				$this->delete_file($upload_path.$v[ 'image_name' ]);
			}
		}
		
		$this->Images_model->delete($where);
	}
	
	public function update( $image_ref_id= NULL , $image_content_type= NULL , $delete_ids = array(), $duplicate = NULL )
	{
		if( $image_ref_id == NULL ||  $image_content_type == NULL )
		{
			//return;
		}
		//echo $duplicate; echo "a"; exit;
		$upload_path = 'assets/uploads/images/';
		$delete_ids	=	$this->input->post(  'image_delete_id');
		foreach($delete_ids as $key => $v)
		{
			if( !$v ) continue;
			$image_id	=	$this->input->post( "image_id_{$key}" );
			
			$last_image	=	$this->input->post( "image_last_{$key}" );
			if( trim($last_image) != '' )
			{
				$this->delete_file($upload_path.$last_image);
			}
			$where_del[ 'image_id' ]	=	$v;
			$this->Images_model->delete( $where_del );
		}
			
		
		$uploaded	=	array();
		
		if( $this->input->post(  'image_id') )
		foreach($this->input->post(  'image_id') as $k => $v )
		{
			if(  $v!=NULL && $v!=0 && !in_array( $v , $delete_ids	)  )
			{
				$key	=	$k;
				$uploaded[$key][ 'image_id' ]	=	$this->input->post( "image_id_{$key}" );
				$uploaded[$key][ 'image_name' ]	=	$this->input->post( "image_last_{$key}" );
				$uploaded[$key][ 'image_content_type' ]	=	$image_content_type;
				$uploaded[$key][ 'image_ref_id' ]	=	$image_ref_id;
				$uploaded[$key][ 'image_alt_text' ]	=	$this->input->post( "image_alt_{$key}" );
				$uploaded[$key][ 'image_is_main' ]	=	$this->input->post( "main_image" ) == $key ? 1 :0;
			}
			
		}
		
		
		foreach( $_FILES as $k => $v )
		{
			if( $v['tmp_name']!=NULL && $upload_res	= $this->do_upload( $k ,$upload_path ) )
			{
				$key	=	explode( '_' , $k);
				$key	=	end($key);
				
				$last_image	=	$this->input->post( "image_last_{$key}" );
				
				if( trim($last_image) != '' )
				{
					$this->delete_file($upload_path.$last_image);
				}
				
				$uploaded[$key][ 'image_id' ]	=	$this->input->post( "image_id_{$key}" );
				$uploaded[$key][ 'image_name' ]	=	$upload_res;
				$uploaded[$key][ 'image_content_type' ]	=	$image_content_type;
				$uploaded[$key][ 'image_ref_id' ]	=	$image_ref_id;
				$uploaded[$key][ 'image_alt_text' ]	=	$this->input->post( "image_alt_{$key}" );
				$uploaded[$key][ 'image_is_main' ]	=	$this->input->post( "main_image" ) == $key ? 1 :0;
			}


		}
		//echo '<pre>';print_r($uploaded);exit;
		foreach( $uploaded as $v )
		{
			if($duplicate!=NULL && $v[ 'image_name' ]!=NULL)
			{
				$v[ 'image_id' ]= NULL;
				$this->Images_model->add($v);
			}
			else if( $v[ 'image_id' ] > 0 )
			{
				$where[ 'image_id' ]	=	$v[ 'image_id' ];
				$this->Images_model->update($v , $where);
			}
			else
			{
				$this->Images_model->add($v);
			}
		}
		
	}
	
	public function update1( $image_ref_id= NULL , $image_content_type= NULL ,  $duplicate = NULL )
	{
		echo $duplicate; echo "a"; exit;
		$upload_path = 'assets/uploads/images/';
	}
	public function list_json( $image_ref_id= NULL , $image_content_type= NULL , $nojson=FALSE  )
	{
		if( $this->input->post( 'image_ref_id' ) != NULL )
		{
			$image_ref_id	=	$this->input->post( 'image_ref_id' );
		}
		
		if( $this->input->post( 'image_content_type' ) != NULL )
		{
			$image_content_type	=	$this->input->post( 'image_content_type' );
		}
		
		$image_status	=	$this->input->post( 'image_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$data[ 'rows' ] = $this->Images_model->get_list(  $image_ref_id , $image_content_type , $image_status  );
		$data[ 'total' ] = $this->Images_model->get_count(  $image_ref_id , $image_content_type , $image_status  );
		if( $nojson )
		return $data;
		else
		echo json_encode( $data );
	}
	public function update2($product_id=NULL,$type=NULL,$file=NULL,$uri=NULL){

   
       if(count($_FILES['pic']['name']) > 0)
			{
				
		foreach($_FILES['pic']['name'] as $k=>$v)
			{
		$tmpFilePath = $_FILES['pic']['tmp_name'][$k];
 		if($tmpFilePath != "")
 			{
 			
 	 	$shortname = $_FILES['pic']['name'][$k];
 	 	$ext = pathinfo($shortname, PATHINFO_EXTENSION);	
     	$filePath = "assets/uploads/destination/" .$uri.$k.time().'.'.$ext;
     	
     	if(move_uploaded_file($tmpFilePath, $filePath))
     		{

     			 
	     	$data[ 'image_status' ]	=	CommonStatus::ACTIVE;
	     	$data['image_content_type']=$type;
	     	$data['image_ref_id']=$product_id;
	     	//$data['image_alt_text']=$this->projectName;
	     	$data[ 'image_join_date' ]	=	$this->dbnow;	
	     	$data['image_is_main']=$k==0?1:0;
	     	$data[ 'image_name' ]	=	$uri.$k.time().'.'.$ext;
	     	$this->Images_model->add( $data );
	     	
     	


	     	$config="";
			$this->load->library('image_lib');
			$config['image_library']  = 'gd2';
			$config['source_image']   = $filePath;
		    // $config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width']          = 1600;
			$config['height']         = 700;
			$config['new_image']      = $filePath;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

     
              }

              }

              }


    }


}


public function update3($hotel_id=NULL,$type=NULL,$file=NULL,$uri=NULL){

   
       if(count($_FILES['pic']['name']) > 0)
			{
				
		foreach($_FILES['pic']['name'] as $k=>$v)
			{
		$tmpFilePath = $_FILES['pic']['tmp_name'][$k];
 		if($tmpFilePath != "")
 			{
 			
 	 	$shortname = $_FILES['pic']['name'][$k];
 	 	$ext = pathinfo($shortname, PATHINFO_EXTENSION);	
     	$filePath = "assets/uploads/hotel/" .$uri.$k.time().'.'.$ext;
     	
     	if(move_uploaded_file($tmpFilePath, $filePath))
     		{

     			 
	     	$data[ 'image_status' ]	=	CommonStatus::ACTIVE;
	     	$data['image_content_type']=$type;
	     	$data['image_ref_id']=$hotel_id;
	     	//$data['image_alt_text']=$this->projectName;
	     	$data[ 'image_join_date' ]	=	$this->dbnow;	
	     	$data['image_is_main']=$k==0?1:0;
	     	$data[ 'image_name' ]	=	$uri.$k.time().'.'.$ext;
	     	$this->Images_model->add( $data );
	     	
     	


	     	$config="";
			$this->load->library('image_lib');
			$config['image_library']  = 'gd2';
			$config['source_image']   = $filePath;
		    // $config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width']          = 1600;
			$config['height']         = 700;
			$config['new_image']      = $filePath;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

              }

              }

              }


    }


}

public function update4($tour_id=NULL,$type=NULL,$file=NULL,$uri=NULL){

   
       if(count($_FILES['pic']['name']) > 0)
			{
				
		foreach($_FILES['pic']['name'] as $k=>$v)
			{
		$tmpFilePath = $_FILES['pic']['tmp_name'][$k];
 		if($tmpFilePath != "")
 			{
 			
 	 	$shortname = $_FILES['pic']['name'][$k];
 	 	$ext = pathinfo($shortname, PATHINFO_EXTENSION);	
     	$filePath = "assets/uploads/tour/" .$uri.$k.time().'.'.$ext;
     	
     	if(move_uploaded_file($tmpFilePath, $filePath))
     		{

     			 
	     	$data[ 'image_status' ]	=	CommonStatus::ACTIVE;
	     	$data['image_content_type']=$type;
	     	$data['image_ref_id']=$tour_id;
	     	//$data['image_alt_text']=$this->projectName;
	     	$data[ 'image_join_date' ]	=	$this->dbnow;	
	     	$data['image_is_main']=$k==0?1:0;
	     	$data[ 'image_name' ]	=	$uri.$k.time().'.'.$ext;
	     	$this->Images_model->add( $data );
	     	
     	


	     	$config="";
			$this->load->library('image_lib');
			$config['image_library']  = 'gd2';
			$config['source_image']   = $filePath;
		    // $config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width']          = 1600;
			$config['height']         = 700;
			$config['new_image']      = $filePath;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

              }

              }

              }


    }


}
	
	
	
}