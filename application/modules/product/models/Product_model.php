<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_product';
		$this->primary_key	=	'product_id';
		$this->primary_column	=	'product_name';
	}
	
	public function get_list( $product_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$product_search = NULL , $user_id = NULL,$product_category=NULL,$store=NULL,$product_is_offer=NULL ,$product_parent_category = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($product_status != NULL )
		{
	   		$this->db->where( 'product.product_status' ,$product_status );
	    }

	    if($product_is_offer != NULL )
		{
	   		$this->db->where( 'product.product_is_offer' ,$product_is_offer );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'product.user_id' , $user_id );
	    }
		
		if($product_search != NULL )
		{
	   		$this->db->like( 'product.product_name' ,$product_search );
	   		$this->db->or_like( 'store.store_name' ,$product_search );
	    }

	    if($product_category != NULL )
		{
	   		$this->db->where_in('product.product_category_id' ,$product_category );
	    }

	    if($product_parent_category != NULL )
		{
	   		$this->db->where_in('product.product_parent_category' ,$product_parent_category );
	    }
	    if($store != NULL )
		{
	   		$this->db->where('product.product_store_id' ,$store );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("product.product_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }


	    
		
		
		return $this->db->select(" product.*,product_category.product_category_name,store.store_name" )
		->join('mv_product_category product_category','product.product_category_id=product_category.product_category_id', 'left')
		->join('mv_store store','product.product_store_id=store.store_id', 'left')
		->order_by('product.product_id DESC')
		->group_by( 'product.product_id' )
		->get( $this->_table.' product ' )
		->result_array();
	}
	
	public function get_count( $product_status = NULL   , $date_from =NULL , $date_to = NULL  ,$product_search = NULL  , $user_id = NULL,$product_category=NULL,$store=NULL,$is_offer=NULL,$product_is_offer=NULL )
	{
		
		
		if($product_status != NULL )
		{
	   		$this->db->where( 'product.product_status' ,$product_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'product.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("product.product_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($product_search != NULL )
		{
	   		$this->db->like( 'product.product_name' ,$product_search );
	   		$this->db->or_like( 'store.store_name' ,$product_search );
	    }
	     if($product_is_offer != NULL )
		{
	   		$this->db->where( 'product.product_is_offer' ,$product_is_offer );
	    }
	    if($product_category != NULL )
		{
	   		$this->db->where('product.product_category_id' ,$product_category );
	    }

	    if($is_offer != NULL )
		{
	   		$this->db->where('product.product_is_offer' ,$is_offer );
	    }

	    if($store != NULL )
		{
	   		$this->db->where('product.product_store_id' ,$store );
	    }
		
		return $this->db->select(" product.*,product_category.product_category_name,store.store_name" )
		->join('mv_product_category product_category','product.product_category_id=product_category.product_category_id', 'left')
		->join('mv_store store','product.product_store_id=store.store_id', 'left')
		->order_by('product.product_id DESC')
		->group_by( 'product.product_id' )
		->get($this->_table.' product ')
		->num_rows();
	}
	public function get_product_single($product_id )
	{
		return $this->db
		->select( "product.* " )
		
		->where( 'product.product_id' ,$product_id )
		->get( $this->_table.' product' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "product.* " )
		
		->where( 'product.product_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}
	
	
	public function getstoreswithoffer()
	{
		$this->db->distinct();
		return $this->db
		->select('product.product_store_id' )
		
		->where( 'product.product_status' ,1)
		->where( 'product.product_is_offer' ,1)
		->get( $this->_table.' product' )
		->result_array();

	}


	public function offerList($storeid)
	{
		
		return $this->db
		->select('product.*' )
		
		->where( 'product.product_status' ,1)
		->where( 'product.product_is_offer' ,1)
		->where( 'product.product_store_id' ,$storeid)
		->get( $this->_table.' product' )
		->result_array();

	}
	
	public function addlog($request){
	    
	    
	    $data = array(
        'request'=>$request
       
    );

    $this->db->insert('product_log',$data);
	    
	}
	
	public function checkCodeIsAvailable($store_id,$product_code,$product_id)
	{
        if($product_id!="") {
            $this->db->where('product.product_id <>',$product_id);
        }
		return $this->db
		->select('product.*' )
		
		->where( 'product.product_store_id' ,$store_id)
		->where( 'product.product_code' ,$product_code)
		->get( $this->_table.' product' )
		->num_rows();

	}
    public function get_variant($category_id)
	{
	    $this->db->select("*" );
	    $this->db->where( 'cat_id',$category_id );
		$query = $this->db->get('mv_category_variant');
		return $query->result_array();
	}
	
	public function get_variant_list($variant_id)
	{
	    $this->db->select("*" );
	    $this->db->where_in('id',$variant_id );
		$query = $this->db->get('mv_category_variant');
		return $query->result_array();
	}
	
	public function get_variant_options_list($variant_option_id, $variant_id)
	{
	    $this->db->select("*" );
	    $this->db->where_in('id',$variant_option_id );
	    $this->db->where('variant_id',$variant_id);
		$query = $this->db->get('mv_variant_option');
		return $query->result_array();
	}
	
	public function get_variant_options($variant_id)
	{
	    $this->db->select("*" );
	    $this->db->where_in('variant_id',$variant_id );
		$query = $this->db->get('mv_variant_option');
		return $query->result_array();
	}
       
}