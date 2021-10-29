<?php
class Meta extends MX_Controller {

        public function __construct()
		{
			parent::__construct();
			$this->load->model( array( 'Seo_model' ) );
		}
		
		public function get_tags( $data , $id , $content_type )
		{
			
			if( !isset( $data[ 'seo_title' ] ) )
			{
				if( $seo_db	=	$this->Seo_model->get_seo( $id , $content_type ) )
				{
					$data = array_merge( $seo_db , $data );
					
				}
				
			}
			//echo $this->db->last_query();
			//echo '<pre>';print_r($seo_db);echo '</pre>';exit;
			$active_seo	=	 isset( $data[ 'seo_status' ] ) && $data[ 'seo_status' ] == CommonStatus::HOLD ? false : true;
			
			$meta	=	array();
			
			
			
			
			if( $content_type == ContentTypes::BLOG  )
			{
				
				$meta[ 'title' ]=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( $data[ 'blog_name' ]));
				$image	=	$this->base.'assets/uploads/blog/'.$data[ 'blog_image' ];
				$link	=	$this->base.'blog/'.$data[ 'blog_uri' ];
				$meta[ 'tag' ][ 'property' ][ 'fb:app_id' ]= 1049955668414642;
				$meta[ 'tag' ][ 'name' ][ 'og:url' ]=	$link;
				$meta[ 'tag' ][ 'name' ][ 'og:type' ]	=	'article';
				$meta[ 'tag' ][ 'name' ][ 'og:title' ]	=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( $data[ 'blog_name' ]));
				$meta[ 'tag' ][ 'name' ][ 'og:description' ]	=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( substr($data[ 'blog_description' ], 0 , 100) ));
				$meta[ 'tag' ][ 'name' ][ 'og:site_name' ]	=	'Ageless.com';
				$meta[ 'tag' ][ 'name' ][ 'og:image' ]	=	$image;
			}
			
			if( $content_type == ContentTypes::PROJECT  )
			{
				
				$meta[ 'title' ]=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( $data[ 'project_name' ]));
				$image	=	$this->base.'assets/uploads/images/'.$data[ 'main_image' ];
				$link	=	$this->base.'blog/'.$data[ 'project_uri' ];
				$meta[ 'tag' ][ 'property' ][ 'fb:app_id' ]= 1049955668414642;
				$meta[ 'tag' ][ 'name' ][ 'og:url' ]=	$link;
				$meta[ 'tag' ][ 'name' ][ 'og:type' ]	=	'article';
				$meta[ 'tag' ][ 'name' ][ 'og:title' ]	=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( $data[ 'project_name' ]));
				$meta[ 'tag' ][ 'name' ][ 'og:description' ]	=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( substr($data[ 'project_description' ], 0 , 100) ));
				$meta[ 'tag' ][ 'name' ][ 'og:site_name' ]	=	'Ageless.com';
				$meta[ 'tag' ][ 'name' ][ 'og:image' ]	=	$image;
			}
			
			if( $content_type == ContentTypes::PRODUCT  )
			{
				
				$meta[ 'title' ]=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( $data[ 'product_name' ]));
				$image	=	$this->base.'assets/uploads/images/'.$data[ 'main_image' ];
				$link	=	$this->base.'blog/'.$data[ 'product_uri' ];
				$meta[ 'tag' ][ 'property' ][ 'fb:app_id' ]= 1049955668414642;
				$meta[ 'tag' ][ 'name' ][ 'og:url' ]=	$link;
				$meta[ 'tag' ][ 'name' ][ 'og:type' ]	=	'article';
				$meta[ 'tag' ][ 'name' ][ 'og:title' ]	=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( $data[ 'product_name' ]));
				$meta[ 'tag' ][ 'name' ][ 'og:description' ]	=	preg_replace('/[^A-Za-z0-9\ -]/', '',  strip_tags( substr($data[ 'product_description' ], 0 , 100) ));
				$meta[ 'tag' ][ 'name' ][ 'og:site_name' ]	=	'Ageless.com';
				$meta[ 'tag' ][ 'name' ][ 'og:image' ]	=	$image;
			}
			
			if($active_seo)
			{
				$meta[ 'title' ] =	 isset($data[ 'seo_title' ])?$data[ 'seo_title' ]:'';
				$meta[ 'tag' ][ 'name' ][ 'description' ]=isset($data[ 'seo_description' ])?$data[ 'seo_description' ]:'';
				$meta[ 'tag' ][ 'name' ][ 'keywords' ]	=	 isset($data[ 'seo_keywords' ])?$data[ 'seo_keywords' ]:'';
			}

			//echo '<pre>';print_r($meta);echo '</pre>';exit;
			return $meta;
			
			
		}
		
		
}