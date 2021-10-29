<?php
class Admin_store extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Store_model','user/User_model'  ) );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$store_status	=	$this->input->post( 'store_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$store_search	=	$this->input->post( 'search' );
		$store_category	=	$this->input->post( 'store_category' );
		
		$records[ 'rows' ]	=	$this->Store_model->get_list(  $store_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $store_search , $user_id,$store_category );
		$records[ 'total' ]	=	$this->Store_model->get_count(  $store_status ,  $date_from ,  $date_to  , $store_search , $user_id,$store_category );
		echo json_encode( $records );
		
	}
	
	public function form( $store_id= NULL )
	{
		$data[ 'content' ] = 'store/form';
		$data[ 'store' ]	=	array();
		if( $store_id != NULL )
		{
			$data[ 'store' ]	=	$this->Store_model->get_store_single( $store_id );
		}

		//echo '<pre>';print_r($data[ 'portfolio' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function store( $store_id= NULL )
	{

		if(Modules::run( 'login/is_storeadmin' ) || Modules::run( 'login/is_storestaff' )){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    $store_id = $userData['store_id'];
		} 



		$data[ 'content' ] = 'store/form';
		$data[ 'store' ]	=	array();
		if( $store_id != NULL )
		{
			$data[ 'store' ]	=	$this->Store_model->get_store_single( $store_id );
		}
		$data['role'] = 'STOREADMIN';

		

		//echo '<pre>';print_r($data[ 'portfolio' ]);exit;
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		
		$data[ 'content' ] = 'store/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function update( )
	{
		
		$data[ 'store_name' ]	=	$this->input->post( 'store_name' );
		$data[ 'store_address_line' ]	=	$this->input->post( 'store_address_line' );
		$data[ 'store_offer_text' ]	=	$this->input->post( 'store_offer_text' );
		$data[ 'store_status' ]	=	$this->input->post( 'store_status' ) ? $this->input->post( 'store_status' ) : commonStatus::HOLD;
		$data[ 'return_policy' ]	=	!empty($this->input->post( 'return_policy' )) ? $this->input->post( 'return_policy' ) :"";
		
		
		
		$store_id	=	$this->input->post( 'store_id' );
		$file_name = substr( url_title($data[ 'store_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'store_logo';
		$upload_path = 'assets/uploads/store/';
		//echo '<pre>';print_r($_FILES);exit;
		if( isset( $_FILES[ $image_identiy ] ) && $_FILES[ $image_identiy ]['tmp_name']!=NULL && $uploaded = $this->do_upload( $image_identiy , $upload_path , $file_name ) )
		{
			$data[ $image_identiy ]	=	$uploaded;
			$last_image	=	$this->input->post( $image_identiy."_last" );
			if(  isset( $last_image ) && trim( $last_image ) != '' ){
				$this->delete_file($upload_path.$last_image);	
			}
		}

		$data['store_category'] = implode(",",$this->input->post( 'store_category'));

        if(Modules::run( 'login/is_storeadmin' )){
		    
		    $role = 'STOREADMIN';
		} else{
			$role = 'SUPERADMIN';
		}
			

		
		$this->db->trans_begin();
		if( $store_id == NULL )
		{
			$data[ 'store_created' ]	=	time();	
			$data[ 'store_updated' ]	=	time();	
			$store_id	=	$this->Store_model->add( $data );
		}
		else
		{
			$where[ 'store_id' ]	=	$store_id;
			$data[ 'store_updated' ]	=	time();
			$this->Store_model->update( $data , $where );
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
			$msg['msg']		=	'<span class="text-success">store list successfully updated .</span>';
			if($role == 'SUPERADMIN') {
                
                $msg[ 'red' ]	=	$this->base.'/store/admin_store/manage';
			}else{
				$msg[ 'red' ]	=	$this->base.'/store/admin_store/store';
			}
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'store_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Store_model->update( $data , $where ) )
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
		$portfolio	=	$this->Store_model->get( $id );
		if( trim( $portfolio[ 'store_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'store_image' ] );
		}
		
		return $this->Store_model->delete( $id );
		
	}
	
	
	public function remove( $store_id )
	{
		//$store_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $store_id ) )
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
		$store_id	=	$this->input->post( 'id' );
		
		foreach( $store_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Portfolio Deleted .</span>';
		
		echo json_encode($msg);
	}
   
    public function getstoreList()
    {
        $data = $this->Store_model->get_list();
    	return $data;
    }


	
	
	
}