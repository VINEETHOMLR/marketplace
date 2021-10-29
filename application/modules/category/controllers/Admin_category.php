<?php
class Admin_category extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Category_model' ) );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$category_status	=	$this->input->post( 'category_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$category_search	=	$this->input->post( 'search' );
		
		$records[ 'rows' ]	=	$this->Category_model->get_list(  $category_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $category_search , $user_id );
		$records[ 'total' ]	=	$this->Category_model->get_count(  $category_status ,  $date_from ,  $date_to  , $category_search , $user_id );
		echo json_encode( $records );
		
	}
	
	public function form( $category_id= NULL )
	{
		$data[ 'content' ] = 'category/form';
		$data[ 'category' ]	=	array();
		if( $category_id != NULL )
		{
			$data[ 'category' ]	=	$this->Category_model->get_category_single( $category_id );
			
			$this->db->select("*");
			$this->db->from("mv_category_variant");
			$this->db->where("cat_id",$category_id);
			$query  = $this->db->get();
			$carvar = $query->result();
			$categoryvar = array();
			if(!empty($carvar)){
    			foreach($carvar as $k => $v){
    			    
    			    $this->db->select("*");
        			$this->db->from("mv_variant_option");
        			$this->db->where("variant_id",$v->id);
        			$query1  = $this->db->get();
        			$carvaropt = $query1->result();
        			$varientoptt = array();
    			    if(!empty($carvaropt)){
    			        foreach($carvaropt as $kk => $vv){
    			            $varientoptt[] = $vv;
    			        }
    			    }
    			    $v->options = $varientoptt;
    			    $categoryvar[$v->id] = $v;
    			 //   
    			}
			}
			$data['varient'] = $categoryvar;
			
		}

// 		echo '<pre>';print_r($categoryvar);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'category/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function update( )
	{
	   // echo "<pre>"; print_r($_POST); exit;
		$data[ 'category_name' ]	=	$this->input->post( 'category_name' );
		
		
		$data[ 'category_status' ]	=	$this->input->post( 'category_status' ) ? $this->input->post( 'category_status' ) : commonStatus::HOLD;
		
		
		
		$category_id	=	$this->input->post( 'category_id' );
		$file_name = substr( url_title($data[ 'category_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'category_image';
		$upload_path = 'assets/uploads/category/';
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
		if( $category_id == NULL )
		{
			//$data[ 'category_join_date' ]	=	$this->dbnow;	
			//$data[ 'category_update_date' ]	=	$this->dbnow;	
			$category_id	=	$this->Category_model->add( $data );
			
			if(isset($_POST['variant'])){
			    foreach($_POST['variant'] as $k => $v){
			        $varid = 0;
			        foreach($v as $kk => $vv){
			            if($kk == "name"){
    			            $varientarr = array(
    			                    'cat_id' => $category_id,
    			                    'varient_name' => $vv,
    			                );
			                 $varres = $this->db->insert('mv_category_variant',$varientarr);
			                 $varid = $this->db->insert_id();

			            }else{
        			        if(isset($v) && count($v) > 0){
        			             $varientarr = array(
    			                    'variant_id' => $varid,
    			                    'option_name' => $vv,
    			                );
			                    $varres = $this->db->insert('mv_variant_option',$varientarr);
        			        }
			            }
			        }
			    }
			}
		}
		else
		{
			$where[ 'category_id' ]	=	$category_id;
			//$data[ 'category_update_date' ]	=	$this->dbnow;
			$this->Category_model->update( $data , $where );
			
			if(isset($_POST['variant'])){
			    foreach($_POST['variant'] as $k => $v){
			        if(!is_numeric($k)){
    			        $varid = 0;
    			        foreach($v as $kk => $vv){
    			            if($kk == "name"){
        			            $varientarr = array(
        			                    'cat_id' => $category_id,
        			                    'varient_name' => $vv,
        			                );
    			                 $varres = $this->db->insert('mv_category_variant',$varientarr);
    			                 $varid = $this->db->insert_id();
    
    			            }else{
            			        if(isset($v) && count($v) > 0){
            			             $varientarr = array(
        			                    'variant_id' => $varid,
        			                    'option_name' => $vv,
        			                );
    			                    $varres = $this->db->insert('mv_variant_option',$varientarr);
            			        }
    			            }
    			        }
			        }else{
			            foreach($v as $kk => $vv){
    			            if($kk == "name"){
        			            $varientarr = array(
        			                    'varient_name' => $vv,
        			                );
    			                 $varres = $this->db->update('mv_category_variant',$varientarr,array($k));
    
    			            }else{
    			                if(isset($vv)){
                			        if(is_numeric($kk)){
                			            $varientarr = array(
            			                    'variant_id' => $k,
            			                    'option_name' => $vv,
            			                );
        			                   $varres = $this->db->update('mv_variant_option',$varientarr,array("id"=>$kk));
        			                   
                			        }else{
                			             $varientarr = array(
            			                    'variant_id' => $k,
            			                    'option_name' => $vv,
            			                );
        			                    $varres = $this->db->insert('mv_variant_option',$varientarr);
                			        }
    			                }
    			            }
    			        }
			        }
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
			$msg['msg']		=	'<span class="text-success">Category list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/category/admin_category/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'category_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Category_model->update( $data , $where ) )
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
		$portfolio	=	$this->Category_model->get( $id );
		if( trim( $portfolio[ 'category_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'category_image' ] );
		}
		
		return $this->Category_model->delete( $id );
		
	}
	
	
	public function remove( $category_id )
	{
		//$category_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $category_id ) )
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
		$category_id	=	$this->input->post( 'id' );
		
		foreach( $category_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Portfolio Deleted .</span>';
		
		echo json_encode($msg);
	}
	public function getlist()
	{
		return $this->Category_model->get_list(1);
	}


	
	
	
}