<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Events_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_events';
		$this->primary_key	=	'blog_id';
		$this->primary_column	=	'blog_name';
	}
	
	public function get_list(  $blog_status = NULL , $limit = NULL , $start = NULL  , $date_from =NULL , $date_to = NULL  , $blog_search = NULL , $user_id = NULL )
	{
		
		
		if( $limit != '' && $start != '' )
		{
	   		$this->db->limit( $limit , $start );
	    }
		else if( $limit != '' )
		{
			$this->db->limit( $limit );
		}
		
		if( $blog_status != NULL )
		{
	   		$this->db->where( 'blog.blog_status' , $blog_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'blog.user_id' , $user_id );
	    }
		
		if( $blog_search != NULL )
		{
	   		$this->db->like( 'blog.blog_description' , $blog_search );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("blog.blog_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		
		
		return $this->db->select(" blog.* , seo.* , user.* " )
		->join( 'mv_seo seo', 'seo.content_ref_id = blog.blog_id AND content_type = '.ContentTypes::BLOG , 'left' )
		->join( 'mv_users user', 'user.id = blog.user_id' , 'inner' )
		->order_by('blog.blog_id DESC')
		->group_by( 'blog.blog_id' )
		->get( $this->_table.' blog ' )
		->result_array();
	}
	
	public function get_count(  $blog_status = NULL   , $date_from =NULL , $date_to = NULL  , $blog_search = NULL  , $user_id = NULL )
	{
		
		
		if( $blog_status != NULL )
		{
	   		$this->db->where( 'blog.blog_status' , $blog_status );
	    }
		
		if( $user_id != NULL )
		{
	   		$this->db->where( 'blog.user_id' , $user_id );
	    }
		
		if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
	   		$date_from	=	date("Y-m-d H:i:s", $date_from);
			$date_to	=	date("Y-m-d H:i:s", $date_to);
			$this->db
			->group_start()
			->where("blog.blog_join_date BETWEEN '$date_from' AND '$date_to' ")
			->group_end();
	    }
		if( $blog_search != NULL )
		{
	   		$this->db->like( 'blog.blog_description' , $blog_search );
	    }
		
		return $this->db->select(" blog.*  " )
		->order_by('blog.blog_id DESC')
		->group_by( 'blog.blog_id' )
		->get($this->_table.' blog ')
		->num_rows();
	}
	
	public function get_blog( $blog_id )
	{
		return $this->db
		->select( "blog.*  , user.*  " )
		->join( 'mv_users user', 'user.id = blog.user_id' , 'inner' )
		//->join( 'mv_blog_to_tag btog' , 'blog.blog_id = blog.blog_id' , 'left'  )
		//->join( 'mv_blog_tags tags' , 'blog.tag_id = tags.tag_id' , 'left'  )
		->where( 'blog.blog_id' , $blog_id )
		->get( $this->_table.' blog' )
		->row_array();
	}
	
		public function home_events( )
	{
		
		$this->db->where( 'blog.blog_status' , CommonStatus::ACTIVE );
		$this->db->where( 'blog.home_dis_order >' , 0 );
		
		$select = " blog.*   ";
		
		return $this->db->select( $select )
		//->join( 'mv_product_categories category', 'category.category_id = product.category_id ', 'left' )
		->order_by('blog.home_dis_order ASC')
		->group_by( 'blog.blog_id' )
		->get( $this->_table.' blog ')
		->result_array();
	}
       
}