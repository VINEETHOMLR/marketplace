<?php
class Admin_order extends MX_Controller
{
    
    public function __construct()
    {
        parent::__construct();
		//Modules::run( 'login/check_authority' , array( 'is_admin'  ) );
		$this->load->model( array( 'Order_model','Order_details_model','customer/Customer_model','product/Product_model' ,'customer/Address_model','user/User_model','order/payment_log','order/Order_status_log') );
    }

    public function list_json( $user_id = NULL )
	{
		$limit	=	$this->input->post( 'limit' );
		$offset	=	$this->input->post( 'offset' );
		$order_status	=	$this->input->post( 'order_status' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		$order_search	=	$this->input->post( 'search' );
		$store_id       =   $this->input->post( 'store_id' );

		//if(Modules::run( 'login/is_storeadmin' ) || Modules::run( 'login/is_storestaff' )){
		if(Modules::run( 'login/is_storeadmin' ) ){
		    $userData  = $this->User_model->getUserData($this->user['id']);	
		    $store_id = $userData['store_id'];
		} 


		$rows =	$this->Order_model->get_list(  $order_status ,  $limit ,  $offset  ,  $date_from ,  $date_to  , $order_search , $user_id ,$store_id);
		if(!empty($rows)) {

			foreach($rows as $k=>$v){
                $customerDetails = $this->Customer_model->getCustomerData($v['customer_id']);
                $rows[$k]['customer_name'] = $customerDetails['customer_first_name'].' '.$customerDetails['customer_last_name'];
                $rows[$k]['customer_phone'] = $customerDetails['customer_phone'];
			}

		}

		$records['rows'] = $rows;



		$records[ 'total' ]	=	$this->Order_model->get_count(  $order_status ,  $date_from ,  $date_to  , $order_search , $user_id ,$store_id);
		echo json_encode( $records );
		
	}
	
	public function form( $order_id= NULL )
	{
		$data[ 'content' ] = 'order/form';
		$data[ 'order' ]	=	array();
		if( $order_id != NULL )
		{
			$data[ 'order' ]	=	$this->Order_model->get_order_single( $order_id );

			$orderDetails = $this->Order_details_model->getOrderDetails($order_id);
		    if(!empty($orderDetails)) {
                foreach($orderDetails as $k=>$v){

                	$productDetails = $this->Product_model->get_product_single($v['product_id']);
                	$orderDetails[$k]['product_name'] = $productDetails['product_name'];
                	$orderDetails[$k]['product_code'] = $productDetails['product_code'];
                	$orderDetails[$k]['product_image'] = !empty($productDetails['product_image']) ? $this->base.'assets/uploads/product/'.$productDetails['product_image'] : "";

                }
		    }
		    $data['orderDetails'] = $orderDetails;
		    $data['customerAddress'] = $this->Address_model->getAddressData($data['order']['customer_id']);

			
		}










		
		
		$this->load->view( 'admin/page' , $data );
	}
	
	
	public function manage()
	{
		$role = 'SUPERADMIN';
		if(Modules::run( 'login/is_storeadmin' ) ){
		    
		    $role = 'STOREADMIN';
		} 
		$data['role'] = $role;
		$data[ 'content' ] = 'order/table';
		$this->load->view( 'admin/page' , $data );
	}
	
	
	
	public function update( )
	{
		
		$data[ 'order_name' ]	=	$this->input->post( 'order_name' );
		
		
		$data[ 'order_status' ]	=	$this->input->post( 'order_status' ) ? $this->input->post( 'order_status' ) : commonStatus::HOLD;
		
		
		
		$order_id	=	$this->input->post( 'order_id' );
		$file_name = substr( url_title($data[ 'order_name' ], 'dash', true) , 0 , 99 );			
		$uploaded	=false;
		$image_identiy	=	'order_image';
		$upload_path = 'assets/uploads/order/';
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
		if( $order_id == NULL )
		{
			//$data[ 'order_join_date' ]	=	$this->dbnow;	
			//$data[ 'order_update_date' ]	=	$this->dbnow;	
			$order_id	=	$this->Order_model->add( $data );
		}
		else
		{
			$where[ 'order_id' ]	=	$order_id;
			//$data[ 'order_update_date' ]	=	$this->dbnow;
			$this->Order_model->update( $data , $where );
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
			$msg['msg']		=	'<span class="text-success">order list successfully updated .</span>';
			$msg[ 'red' ]	=	$this->base.'/order/admin_order/manage';
		}
		$this->session->set_flashdata('msg', $msg );
		echo json_encode( $msg );
		
	}
	
	public function change_status( )
	{
		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'order_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Order_model->update( $data , $where ) )
		{
			$data = [];
			$data['order_id']  =  $record_id;
			$data['status']    =  $record_status;
			$data['updated_by']   = $this->user['id'];
			$data['created_time'] = $this->dbnow;
			$this->Order_status_log->add($data);
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

	public function change_payment_status()
	{

		$record_id	=	$this->input->post( 'pk' );
		$record_status	=	$this->input->post( 'value' );
		$field	=	$this->input->post( 'name' );
		$where[ 'order_id' ]	=	$record_id;
		$data[ $field ]	=	$record_status;
		if( $this->Order_model->update( $data , $where ) )
		{
			$data = [];
			$data['order_id']     = $record_id;
			$data['status']       = $record_status;
			$data['updated_by']   = $this->user['id'];
			$data['created_date'] = $this->dbnow;
			$this->payment_log->add($data);
			$msg['res']		=	1;
			$msg['msg']		=	'Paymant Status Changed';
			
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
		$portfolio	=	$this->Order_model->get( $id );
		if( trim( $portfolio[ 'order_image' ] ) != '' )
		{
			$this->delete_file( 'assets/uploads/clients/'.$portfolio[ 'order_image' ] );
		}
		
		return $this->Order_model->delete( $id );
		
	}
	
	
	public function remove( $order_id )
	{
		//$order_id	=	$this->input->post( 'id' );
		if( $this->remove_client( $order_id ) )
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
		$order_id	=	$this->input->post( 'id' );
		
		foreach( $order_id as $id )
		{
			$this->remove_blog( $id );
		}
		
		$msg['res']		=	1;
		$msg['msg']		=	'<span class="text-success">Portfolio Deleted .</span>';
		
		echo json_encode($msg);
	}
	public function getlist()
	{
		return $this->Order_model->get_list(1);
	}


	
	
	
}