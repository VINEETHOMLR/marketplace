<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_cart';
		$this->primary_key	=	'cart_id';
	}


	public function get_list($cart_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$cart_search = NULL , $user_id = NULL,$cart_store_id=NULL)
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($cart_status != NULL )
		{
	   		$this->db->where( 'cart.cart_status' ,$cart_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'cart.cart_user_id' , $user_id );
	    }

	    if( $cart_store_id != NULL )
		{
	   		$this->db->where( 'cart.cart_store_id' , $cart_store_id );
	    }
		
		/*if($cart_search != NULL )
		{
	   		$this->db->like( 'cart.cart_name' ,$cart_search );
	    }*/
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("cart.cart_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		//return $this->db->select(" cart.*,product.product_name,product.product_is_offer,product.product_price,product.product_offer_price,product.product_status,product.product_image,color.color_code" )
		return $this->db->select(" cart.*,product.product_name,product.product_is_offer,product.product_price,product.product_offer_price,product.product_status,product.product_image" )
		->join('mv_product product','cart.cart_product_id=product.product_id')
		//->join('mv_product_color color','cart.cart_selected_color=color.color_id')
		
		->order_by('cart.cart_id DESC')
		//->group_by( 'cart.cart_store_id' )
		->get( $this->_table.' cart ' )
		->result_array();
	}

	public function getcartstores($user_id,$cart_status=NULL)
	{
		if( $user_id != NULL )
		{
	   		$this->db->where( 'cart.cart_user_id' , $user_id );
	    }
	    if( $cart_status != NULL )
		{
	   		$this->db->where( 'cart.cart_status' , $cart_status );
	    }
		return $this->db->select("DISTINCT(cart_store_id),store.store_name,store.store_logo" )
		->join('mv_store store','cart_store_id=store.store_id')
		->where('store.store_status','1')
		//->order_by('cart.cart_id DESC')
		//->group_by( 'cart.cart_store_id' )
		->get( $this->_table.' cart ' )
		->result_array();
	}

	
	
	
	
       
}