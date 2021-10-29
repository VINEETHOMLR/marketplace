<?php
class Admin_product extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Product_model' ,'Product_category_model','Product_color_model','user/User_model','category/Category_model','store/Store_model','product/Product_images') );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$product_status	=	$this->input->post( 'product_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$product_search	=	$this->input->post( 'search' );
		$product_category_id	=	$this->input->post( 'product_category_id' );
		$product_store_id	=	$this->input->post( 'product_store_id' );
		$product_is_offer	=	$this->input->post( 'product_is_offer' );

		//if(Modules::run( 'login/is_storeadmin' ) || Modules::run( 'login/is_storestaff' )){
		if(Modules::run( 'login/is_storeadmin' ) ){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    $product_store_id = $userData['store_id'];
		} 

		
		//$records[ 'rows' ]	=	$this->Product_model->get_list(  $product_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $product_search , $user_id ,$product_category_id,$product_store_id,$product_is_offer);
		$rows =	$this->Product_model->get_list(  $product_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $product_search , $user_id ,$product_category_id,$product_store_id,$product_is_offer);
		foreach($rows as $k=>$v){


            
            $files=$this->Product_images->get_images($v['product_id']);
            if(!empty($files)) {
                $rows[$k]['product_image'] = $files[0]['image_name'];
            }
		}

		$records[ 'rows' ]	= $rows;
		$records[ 'total' ]	=	$this->Product_model->get_count(  $product_status ,  $date_from ,  $date_to  , $product_search , $user_id,$product_category_id,$product_store_id,$product_is_offer);
		echo json_encode( $records );
		
	}
	
	public function form( $product_id= NULL )
	{
		$data[ 'content' ] = 'product/form';
		$data[ 'product' ]	=	array();
		$data['colorList']  =   array();
		$data['imageList'] = array();
		if( $product_id != NULL )
		{
			$product = $this->Product_model->get_product_single( $product_id );
			$data[ 'product' ]	=	$product;
			$data['colorList']  =   $this->Product_color_model->get_list( 1 , NULL ,NULL  ,NULL , NULL  ,NULL , NULL,NULL,NULL,$product_id );
			$parent_category = $product['product_parent_category'];
			$variant = explode(',', $product['product_variant_id']);
			$data['sucategoryList'] =  $this->Product_category_model->get_list( 1 , NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL,NULL,$parent_category);
			$data['storeList'] = $this->Store_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$parent_category); 
			$data['imageList'] = $this->Product_images->get_product_images($product_id);
			$data['variantList'] = $this->Product_model->get_variant($parent_category);
			$data['variantOptionList'] = $this->Product_model->get_variant_options($variant);
			//$data['productColorImageList'] =  $this->Product_color_model->get_color_images($product_id);
// 			echo '<pre>'; print_r($data['variantOptionList']); exit;
		}






		

		if(!Modules::run( 'login/is_admin' )){
			//get storeId
			$userData  = $this->User_model->getUserData($this->user['id']);	
		    $product_store_id = $userData['store_id'];
            //get the categories registerd
            $categories = $this->Store_model->getCategory($product_store_id);
            $data['parentCatgeoryList'] = $this->Category_model->getCategoryFromStore(explode(',',$categories['store_category']));
            $data['role'] = 'STOREADMIN';
            $data['store_id'] = $product_store_id;
            
            //echo $categories;
		}else{

		    $data['role']   = 'SUPERADMIN';	
		}
        $data['storeList']  = $this->Store_model->get_list();
        $data['product_id'] = $product_id;




		

		
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'product/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function update( )
	{


        $productArray = array();
        /*if(isset($_POST['product_details']['product_images']) && count($_POST['product_details']['product_images']) > 0){
            $i = 0;
			foreach($_POST['product_details']['product_images'] as $k => $v){
			    foreach($v as $k1 => $value)
			    {
			        $image_parts = explode(";base64,", $value);
    				$image_type_aux = explode("image/", $image_parts[0]);
    				$image_type = $image_type_aux[1];
    				$image_base64 = base64_decode($image_parts[1]);
    				$upload_path = 'assets/uploads/product/';
    				$image_name =  uniqid() . '.jpg';
    				$file = $upload_path . $image_name;
    				
    				file_put_contents($file, $image_base64);
    				$productArray[$i]['image_name'][] = $image_name;
			    }
			    $i++;
			}
			// $colorArray = array_unique($this->input->post( 'product_color' ));
		}*/


		$data[ 'product_name' ]	=	$this->input->post( 'product_name' );
		$data[ 'product_price' ]	=	$this->input->post( 'product_price' );
		$data[ 'product_category_id' ]	=	$this->input->post( 'product_category_id' );
		$data[ 'product_parent_category' ]	=	$this->input->post( 'product_parent_category' );
		$data[ 'product_description' ]	=	$this->input->post( 'product_description' );
		$data[ 'is_return' ]	=	$this->input->post( 'is_return' );
		$data[ 'return_policy' ]	=	$this->input->post( 'return_policy' );
		$data[ 'product_code' ]	=	$this->input->post( 'product_code' );
		$data[ 'product_variant_id' ]	=	implode(',', $this->input->post( 'product_variant_id' ));
		$data[ 'variant_option_id' ]	=	implode(',', $this->input->post( 'variant_option_id' ));
        if(Modules::run( 'login/is_storeadmin' ) ){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    
		    $data[ 'product_store_id' ]	=	$userData['store_id'];
		} else {
		    $data[ 'product_store_id' ]	=	$this->input->post( 'product_store_id' );	
		}
		

		$data[ 'product_is_offer' ]	=	$this->input->post( 'product_is_offer' );
		$data['product_size'] = implode(",",$this->input->post( 'product_size'));
		if($this->input->post( 'product_is_offer' )==1){
            $data[ 'product_offer_price' ]	=	$this->input->post( 'product_offer_price' );
		}

		$colorArray = array();
		if(isset($_POST['color_img']) && count($_POST['color_img']) > 0){
			foreach($_POST['color_img'] as $value){
				$image_parts = explode(";base64,", $value);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];
				$image_base64 = base64_decode($image_parts[1]);
				$upload_path = 'assets/uploads/product/';
				$file = $upload_path . uniqid() . '-color.png';
				
				file_put_contents($file, $image_base64);
				$colorArray[] = $file;
			}
			// $colorArray = array_unique($this->input->post( 'product_color' ));
		}
		
		
		$data[ 'product_status' ]	=	$this->input->post( 'product_status' ) ? $this->input->post( 'product_status' ) : commonStatus::HOLD;
		
		
		
		$product_id	=	$this->input->post( 'product_id' );
		$file_name = substr( url_title($data[ 'product_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'product_image';
		$upload_path = 'assets/uploads/product/';
		//echo '<pre>';print_r($_FILES);exit;
		/*if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
		}



*/      


// 		$images=[];
//         $upload_path = 'assets/uploads/product/';
        
//         if(count($_FILES['product_img']['name']) > 0)
// 		{
				
// 		    foreach($_FILES['product_img']['name'] as $k=>$v)
// 		    {
// 		        foreach($v as $k1=>$v1)
// 		        {
// 		            $tmpFilePath = $_FILES['product_img']['tmp_name'][$k][$k1];   
// 		            if($tmpFilePath != "")
//  		            {
//  	                    $shortname = $_FILES['product_img']['name'][$k][$k1];
//  	 	                $ext = pathinfo($shortname, PATHINFO_EXTENSION);
//  	 	                // $images[$k]['image_name'][] = $k.$k1.time().'.'.$ext;
//      	                $filePath = $upload_path.$k.$k1.time().'.'.$ext;
//      	                if(move_uploaded_file($tmpFilePath, $filePath))
//      	                {
//      		                $images[$k]['image_name'][] = $k.$k1.time().'.'.$ext;	
//      	                }  
//                     }
// 		        }
//             }
//         }
//         if(count($_FILES['pic']['name']) > 0)
// 		{
				
// 		foreach($_FILES['pic']['name'] as $k=>$v)
// 		{
// 		$tmpFilePath = $_FILES['pic']['tmp_name'][$k];
//  		if($tmpFilePath != "")
//  		{
 			
//  	    $shortname = $_FILES['pic']['name'][$k];
//  	 	$ext = pathinfo($shortname, PATHINFO_EXTENSION);	
//      	$filePath = $upload_path .$k.time().'.'.$ext;
     	
//      	if(move_uploaded_file($tmpFilePath, $filePath))
//      	{
     		
     		    
//      		    $images[] = array('image_name'=>$k.time().'.'.$ext);	
     		

     		


//      	}  
//         }	
//         }
//         }

		




		$this->db->trans_begin();
		if( $product_id == NULL )
		{
			$data[ 'product_created_date' ]	=	time();	
			$data[ 'product_updated_date' ]	=	time();	
			$product_id	=	$this->Product_model->add( $data );
		 
			  
			 
			$image_data = array();
			if(!empty($colorArray)) {
                foreach($colorArray as $k=>$v) {

                	$colorcodeArray = explode('/',$v);
                	$data =array();
                    $data['product_id'] = $product_id;
                    $data['color_code'] = $colorcodeArray[3];  
                    $data['color_status'] = 1; 
                    $color_id = $this->Product_color_model->add($data); 
                    /*if(!empty($productArray[$k]))
                    {
                        $image_data[$k]['product_id'] = $product_id;
                        $image_data[$k]['color_id'] = $color_id;
                        $image_data[$k]['image_name'] = implode(',', $productArray[$k]['image_name']);
                        $image_data[$k]['price'] = $_POST['product_details']['price'][$k];
                    }*/
                }
			}


			if(!empty($_FILES['product_imgs'])) {

			

				foreach($_FILES['product_imgs']['name'] as $k=>$v){
				     

				    $tmpFilePath = $_FILES['product_imgs']['tmp_name'][$k];    
				    $shortname = $_FILES['product_imgs']['name'][$k];
  	 	            $ext = pathinfo($shortname, PATHINFO_EXTENSION);	
      	            $filePath = $upload_path .$k.time().'.'.$ext;	

      	            if(move_uploaded_file($tmpFilePath, $filePath))
      	            {
     		
      		             $images[] = array('image_name'=>$k.time().'.'.$ext,'product_id'=>$product_id);	
     		
      	            } 
				}

				

			}


			


			if(!empty($images)) {
                $this->db->insert_batch('mv_product_images', $images); 
			}
		}
		else
		{
			$where[ 'product_id' ]	=	$product_id;
			$data[ 'product_updated_date' ]	=	time();	
			$this->Product_model->update( $data , $where );
			if(isset($_POST['product_images']) && count($_POST['product_images']) > 0)
    	    {
    	        foreach($_POST['product_images'] as $k => $v)
    	        {
    	            $p_imagesdata  = array();
    	            $p_imagesdata = $this->Product_images->get_product_image($k);
    	            $updateProductArray = explode(',', $p_imagesdata['image_name']);
    	            foreach($v as $value)
    	            {
    	                $image_parts = explode(";base64,", $value);
        				$image_type_aux = explode("image/", $image_parts[0]);
        				$image_type = $image_type_aux[1];
        				$image_base64 = base64_decode($image_parts[1]);
        				$upload_path = 'assets/uploads/product/';
        				$image_name =  uniqid() . '.jpg';
        				$file = $upload_path . $image_name;
        				
        				file_put_contents($file, $image_base64);
        				$updateProductArray[] = $image_name;
    	            }
    	            
    	            $where = array();
    	            $imagedata['image_name'] = implode(',', $updateProductArray);
    	            $where[ 'images_id' ]	=	$k;
    	            $this->Product_images->update( $imagedata , $where );
    	        }
    	    }
    	    
    	  /*  if(isset($_POST['price']) && count($_POST['price']) > 0)
    	    {
    	        foreach($_POST['price'] as $k => $price)
    	        {
    	            $where = array();
    	            $pricedata['price'] = $price;
    	            $where[ 'images_id' ]	=	$k;
    	            $this->Product_images->update( $pricedata , $where );
    	        }
    	    }*/
    	    
// 			$where = array();
// 			$where['product_id'] = $product_id;
// 			$this->Product_color_model->delete($where);
            $image_data = array();
			if(!empty($colorArray)) {
                foreach($colorArray as $k=>$v) {
                    $data =array();
                    $colorcodeArray = explode('/',$v);
                    $data['product_id'] = $product_id;
                    $data['color_code'] = $colorcodeArray['3'];  
                    $data['color_status'] = 1; 
                    // $this->Product_color_model->add($data); 
                    $color_id = $this->Product_color_model->add($data); 
                    /*if(!empty($productArray[$k]))
                    {
                        $image_data[$k]['product_id'] = $product_id;
                        $image_data[$k]['color_id'] = $color_id;
                        $image_data[$k]['image_name'] = implode(',', $productArray[$k]['image_name']);
                        $image_data[$k]['price'] = $_POST['product_details']['price'][$k];
                    }*/
                }
			}


			if(!empty($_FILES['product_imgs'])) {

			

				foreach($_FILES['product_imgs']['name'] as $k=>$v){
				     

				    $tmpFilePath = $_FILES['product_imgs']['tmp_name'][$k];    
				    $shortname = $_FILES['product_imgs']['name'][$k];
  	 	            $ext = pathinfo($shortname, PATHINFO_EXTENSION);	
      	            $filePath = $upload_path .$k.time().'.'.$ext;	

      	            if(move_uploaded_file($tmpFilePath, $filePath))
      	            {
     		
      		             $images[] = array('image_name'=>$k.time().'.'.$ext,'product_id'=>$product_id);	
     		
      	            } 
				}

				

			}
			
			if(!empty($images)) {
                $this->db->insert_batch('mv_product_images', $images); 
			}

			//image section
// 			if(!empty($images)) {

//                 foreach($images as $k=>$v){
//                     $images[$k]['product_id'] = $product_id;
//                 }

                

//                 $this->db->insert_batch('mv_product_images', $images); 

                
// 			}

		}

		

		
	
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		else
		{
			$this->db->trans_commit();
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Product list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/product/admin_product/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	
	
	public function updatebkp2( )
	{


		
		$data[ 'product_name' ]	=	$this->input->post( 'product_name' );
		$data[ 'product_price' ]	=	$this->input->post( 'product_price' );
		$data[ 'product_category_id' ]	=	$this->input->post( 'product_category_id' );
		$data[ 'product_parent_category' ]	=	$this->input->post( 'product_parent_category' );
		$data[ 'product_description' ]	=	$this->input->post( 'product_description' );
		$data[ 'is_return' ]	=	$this->input->post( 'is_return' );
		$data[ 'return_policy' ]	=	$this->input->post( 'return_policy' );
		$data[ 'product_code' ]	=	$this->input->post( 'product_code' );

        if(Modules::run( 'login/is_storeadmin' )){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    
		    $data[ 'product_store_id' ]	=	$userData['store_id'];
		} else {
		    $data[ 'product_store_id' ]	=	$this->input->post( 'product_store_id' );	
		}
		

		$data[ 'product_is_offer' ]	=	$this->input->post( 'product_is_offer' );
		$data['product_size'] = implode(",",$this->input->post( 'product_size'));
		if($this->input->post( 'product_is_offer' )==1){
            $data[ 'product_offer_price' ]	=	$this->input->post( 'product_offer_price' );
		}
        $colorArray = array();
        if(!empty($this->input->post( 'product_color' ))) {
            $colorArray = array_unique($this->input->post( 'product_color' ));
        }
		

		
		
		$data[ 'product_status' ]	=	$this->input->post( 'product_status' ) ? $this->input->post( 'product_status' ) : commonStatus::HOLD;
		
		
		
		$product_id	=	$this->input->post( 'product_id' );
		$file_name = substr( url_title($data[ 'product_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'product_image';
		$upload_path = 'assets/uploads/product/';
		//echo '<pre>';print_r($_FILES);exit;
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
			
		
                    $this->load->library('image_lib');
                    $config = array();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/uploads/product/'.$uploaded;
                    $config['new_image'] = './assets/uploads/product/'.$uploaded;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['master_dim']= 'width';
                    $config['quality']  = '50';
                    $config['width'] = 500;
                    $config['height']= 1024;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
		}
		
		

		
		
		
		$this->db->trans_begin();
		if( $product_id == NULL )
		{
			$data[ 'product_created_date' ]	=	time();	
			$data[ 'product_updated_date' ]	=	time();	
			$product_id	=	$this->Product_model->add( $data );
			
			if(!empty($colorArray)) {
                foreach($colorArray as $k=>$v) {
                    $data =array();
                    $data['product_id'] = $product_id;
                    $data['color_code'] = $v;  
                    $data['color_status'] = 1; 
                    $this->Product_color_model->add($data); 
                }
			}

		}
		else
		{
			$where[ 'product_id' ]	=	$product_id;
			$data[ 'product_updated_date' ]	=	time();	
			$this->Product_model->update( $data , $where );
			$where = array();
			$where['product_id'] = $product_id;
			$this->Product_color_model->delete($where);
			if(!empty($colorArray)) {
                foreach($colorArray as $k=>$v) {
                    $data =array();
                    $data['product_id'] = $product_id;
                    $data['color_code'] = $v;  
                    $data['color_status'] = 1; 
                    $this->Product_color_model->add($data); 
                }
			}

		}

		

		
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		else
		{
			$this->db->trans_commit();
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Product list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/product/admin_product/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	
	public function updatebkp( )
	{
		
		$data[ 'product_name' ]	=	$this->input->post( 'product_name' );
		$data[ 'product_price' ]	=	$this->input->post( 'product_price' );
		$data[ 'product_category_id' ]	=	$this->input->post( 'product_category_id' );
		$data[ 'product_parent_category' ]	=	$this->input->post( 'product_parent_category' );
		$data[ 'product_description' ]	=	$this->input->post( 'product_description' );
		$data[ 'is_return' ]	=	$this->input->post( 'is_return' );
		$data[ 'return_policy' ]	=	$this->input->post( 'return_policy' );
		$data[ 'product_code' ]	=	$this->input->post( 'product_code' );

        if(Modules::run( 'login/is_storeadmin' )){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    
		    $data[ 'product_store_id' ]	=	$userData['store_id'];
		} else {
		    $data[ 'product_store_id' ]	=	$this->input->post( 'product_store_id' );	
		}
		

		$data[ 'product_is_offer' ]	=	$this->input->post( 'product_is_offer' );
		$data['product_size'] = implode(",",$this->input->post( 'product_size'));
		if($this->input->post( 'product_is_offer' )==1){
            $data[ 'product_offer_price' ]	=	$this->input->post( 'product_offer_price' );
		}
        $colorArray = array();
        if(!empty($this->input->post( 'product_color' ))) {
            $colorArray = array_unique($this->input->post( 'product_color' ));
        }
		

		
		
		$data[ 'product_status' ]	=	$this->input->post( 'product_status' ) ? $this->input->post( 'product_status' ) : commonStatus::HOLD;
		
		
		
		$product_id	=	$this->input->post( 'product_id' );
		$file_name = substr( url_title($data[ 'product_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'product_image';
		$upload_path = 'assets/uploads/product/';
		//echo '<pre>';print_r($_FILES);exit;
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
		}

		
		
		
		$this->db->trans_begin();
		if( $product_id == NULL )
		{
			$data[ 'product_created_date' ]	=	time();	
			$data[ 'product_updated_date' ]	=	time();	
			$product_id	=	$this->Product_model->add( $data );
			
			if(!empty($colorArray)) {
                foreach($colorArray as $k=>$v) {
                    $data =array();
                    $data['product_id'] = $product_id;
                    $data['color_code'] = $v;  
                    $data['color_status'] = 1; 
                    $this->Product_color_model->add($data); 
                }
			}

		}
		else
		{
			$where[ 'product_id' ]	=	$product_id;
			$data[ 'product_updated_date' ]	=	time();	
			$this->Product_model->update( $data , $where );
			$where = array();
			$where['product_id'] = $product_id;
			$this->Product_color_model->delete($where);
			if(!empty($colorArray)) {
                foreach($colorArray as $k=>$v) {
                    $data =array();
                    $data['product_id'] = $product_id;
                    $data['color_code'] = $v;  
                    $data['color_status'] = 1; 
                    $this->Product_color_model->add($data); 
                }
			}

		}

		

		
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$msg['res']		=	2;
			$msg['msg']		=	'<span class="text-warning">Something went wrong Please try again</span>';
		}
		else
		{
			$this->db->trans_commit();
			$msg[ 'type' ]	=	'success';
			$msg[ 'head' ]	=	'Sucess';
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Product list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/product/admin_product/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'product_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Product_model->update( $data , $where ) )
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
	
	private function remove_client( $id )
	{
		$portfolio	=	$this->Product_model->get( $id );
		if( trim( $portfolio[ 'product_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'product_image' ] );
		}
		
		return $this->Product_model->delete( $id );
		
	}
	
	
	public function remove( $product_id )
	{
		//$product_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $product_id ) )
		{
			$msg['res']		=	1;
			$msg['msg']		=	'<span class="text-success">Client Deleted .</span>';
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
		$product_id	=	$this->input->post( 'id' );
		
		foreach( $product_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Portfolio Deleted .</span>';
		
		echo json_encode($msg);
	}
	public function getproductcategory()
	{
		return $this->Product_category_model->get_list(1);
	}


	public function getparentcategory()
	{
		return $this->Category_model->get_list(1);
	}

	public function getSubcatgoryList()
	{
		$parent_category = $_POST['parent_category'];
		$list = $this->Product_category_model->get_list( 1 , NULL ,NULL  ,NULL ,NULL  ,NULL ,NULL,NULL,$parent_category);
		$selectHtml = '<option value="0">Select</option>';

		if(!empty($list)) {
            foreach($list as $k=>$v) {
            	$selectHtml =$selectHtml."<option value='".$v['product_category_id']."'>".$v['product_category_name']."</option>";
            	
            }
		}

		echo $selectHtml;

		
       
	}


	public function getStorelist()
	{
       $category = $_POST['category'];
       $storeList = $this->Store_model->get_list(1,NULL,NULL,NULL,NULL,NULL,NULL,$category); 
       $selectHtml = '<option value="0">Select</option>';
       if(!empty($storeList)) {
            foreach($storeList as $k=>$v) {
            	$selectHtml =$selectHtml."<option value='".$v['store_id']."'>".$v['store_name']."</option>";
            	
            }
		}

		echo $selectHtml;


	}
	
	public function checkProductCode()
	{
		$product_id = $_POST['product_id'];
		$product_code = $_POST['product_code'];
		$product_store_id = $_POST['product_store_id'];
		$count = $this->Product_model->checkCodeIsAvailable($product_store_id,$product_code,$product_id);
		$msg = "";
		$status ='true';
		$data = [];

		if($count > 0) {
            $msg = "<font color='red'>Code ".$product_code." already used</font>";
            $status = 'false';
		}
		$data['message'] = $msg;
		$data['status'] = $status;
		echo json_encode($data);
	}
	
	public function get_images(){
	
    	$storeFolder='assets/uploads/product';
    	
    	$product_id=$this->input->post('product_id');
        $files=$this->Product_images->get_images($product_id);

       foreach($files as $k=>$v){
             
             $result[]=array('name'=>$v['image_name'],'product_id'=>$v['product_id'],'id'=>$v['images_id']); 
        }

      
	
    
      

    
	    header('Content-type: text/json');              //3
	    header('Content-type: application/json');
	    echo json_encode($result);


}


public function remove_image(){
	
        $filename=$this->input->post('name');
        $product_id=$this->input->post('product_id');
        $id=$this->input->post('id');
        $this->load->helper("url");

        

        //unlink('assets/uploads/product/'.$filename);
        $where['images_id']=$id;
        $this->Product_images->delete($where);
        $storeFolder='assets/uploads/product';
    	
    	$files=$this->Product_images->get_images($product_id);

        foreach($files as $k=>$v){
             
             $result[]=array('name'=>$v['image_name'],'product_id'=>$v['product_id'],'id'=>$v['images_id']); 
        }
        
    
      

    
	    header('Content-type: text/json');              //3
	    header('Content-type: application/json');
	    echo json_encode($result);



      







    }

public function setimages()
{

	$rows = $this->Product_model->get_list();
    
    $images = [];
	foreach($rows as $k=>$v){
    
        $images[] = array('product_id'=>$v['product_id'],'image_name'=>$v['product_image']);    

	}

	$this->db->insert_batch('mv_product_images', $images); 
	



}  

public function getVariant()
{
    $parent_category = $_POST['parent_category'];
	$list = $this->Product_model->get_variant($parent_category);
	$selectHtml = '<option value="0">Select</option>';

	if(!empty($list)) {
        foreach($list as $k=>$v) {
        	$selectHtml =$selectHtml."<option value='".$v['id']."'>".$v['varient_name']."</option>";
        	
        }
	}

	echo $selectHtml;
}

public function getVariantOptions()
{
    $variant_id = $_POST['variant_id'];
    // echo '<pre>'; print_r($variant_id); exit;
	$list = $this->Product_model->get_variant_options($variant_id);
	$selectHtml = '<option value="0">Select</option>';
	if(!empty($list) && $variant_id[0] != 0) {
        foreach($list as $k=>$v) {
        	$selectHtml =$selectHtml."<option value='".$v['id']."'>".$v['option_name']."</option>";
        	
        }
	}

	echo $selectHtml;
}
	
	
	
}
