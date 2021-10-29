<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_color_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_product_color';
		$this->primary_key	=	'color_id';
		$this->primary_column	=	'product_id';
	}
	
	public function get_list( $color_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  ,$product_search = NULL , $user_id = NULL,$product_category=NULL,$store=NULL,$product_id=NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if($color_status != NULL )
		{
	   		$this->db->where( 'color.color_status' ,$color_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'color.user_id' , $user_id );
	    }
		
		if($product_search != NULL )
		{
	   		$this->db->like( 'color.product_name' ,$product_search );
	    }

	    if($product_id != NULL )
		{
	   		$this->db->where('color.product_id' ,$product_id );
	    }
	    if($store != NULL )
		{
	   		$this->db->where('color.product_store_id' ,$store );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("color.product_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }


	    $colors = $this->db->select(" color.*  " )
		->order_by('color.color_id DESC')
		->group_by( 'color.color_id' )
		->get( $this->_table.' color ' )
		->result_array();
		
		$finalaar = array();
		foreach($colors as $k => $v){
		    $colorsimgs = $this->db->select(" mv_product_images.*  " )
		        ->where('mv_product_images.product_id' ,$v['product_id'] )
		        ->where('mv_product_images.color_id' ,$v['color_id'] )
        		->get( ' mv_product_images ' )
        		->result_array();
             
	        $imgs = array();
	        foreach($colorsimgs as $kk => $vv){
	            $img = explode(",",$vv['image_name']);
	            foreach($img as $iv){
	                $imgs[] = base_url().'assets/uploads/product/'.$iv;
	            }
	        }
		    
		  //  echo "<pre>"; print_r($colorsimgs); exit;
		    
		    $finalaar[] = array(
		            'color_id' => $v['color_id'],
		            'product_id' => $v['product_id'],
		            'color_code' => base_url().'assets/uploads/product/'.$v['color_code'],
		            'color_status' => $v['color_status'],
		           // 'product_images' => $imgs
		        );
		}
		
		return $finalaar;
	}
	
	public function get_count( $color_status = NULL   , $date_from =NULL , $date_to = NULL  ,$product_search = NULL  , $user_id = NULL,$product_category=NULL,$store=NULL ,$product_id=NULL)
	{
		
		
		if($color_status != NULL )
		{
	   		$this->db->where( 'color.color_status' ,$color_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'color.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("color.product_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if($product_search != NULL )
		{
	   		$this->db->like( 'color.product_name' ,$product_search );
	    }
	    if($product_id != NULL )
		{
	   		$this->db->where('color.product_id' ,$product_id );
	    }

	    if($store != NULL )
		{
	   		$this->db->where('color.product_store_id' ,$store );
	    }
		
		return $this->db->select(" color.*  " )
		->order_by('color.color_id DESC')
		->group_by( 'color.color_id' )
		->get($this->_table.' color ')
		->num_rows();
	}
	public function get_product_single($product_id )
	{
		return $this->db
		->select( "color.* " )
		
		->where( 'color.product_id' ,$product_id )
		->get( $this->_table.' product' )
		->row_array();
	}
	
	
	public function get_clients( )
	{
		return $this->db
		->select( "color.* " )
		
		->where( 'color.product_status' ,1)
		->get( $this->_table.' clients' )
		->result_array();
	}
	public function get_color_images($product_id){

	    return $this->db
		->select( "color.* " )
		
		->where( 'color.product_id' ,$product_id )
		->where( 'color.status' ,'1' )
		->get( $this->_table.' product' )
		->row_array();	
	}

	
       
}