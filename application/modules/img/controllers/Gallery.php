<?php
class Gallery extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( array( 'Gallery_model' ) );
	}
	
	
	public function list_json()
	{
		
		$gallery_status	=	$this->input->post( 'gallery_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$rows = $this->Gallery_model->get_list(   $gallery_status  );
		
		foreach( $rows as $k => $v )
		{
			$images	=	Modules::run( 'img/list_json' , $v[ 'gallery_id' ],  imageType::GALLERY  , TRUE );
			$images	=	$images[ 'rows' ];
			$rows[ $k ][ 'images' ]	=	$images;
			
			$main_image	=	sizeof($images)?$images[0]['image_name']:'default.png';
			foreach($images as $ki => $vi)
			{
				if( $vi[ 'image_is_main' ] == 1 ) $main_image	=	$vi[ 'image_name' ];
			}
			$rows[ $k ][ 'main_image' ]	=	$main_image;
			$rows[ $k ][ 'image_count' ]	=	sizeof($images);
		}
		
		
		$data[ 'rows' ]	=	$rows;
		
		$data[ 'total' ] = $this->Gallery_model->get_count(  $gallery_status  );
		echo json_encode( $data );
	}
	
	
	
}