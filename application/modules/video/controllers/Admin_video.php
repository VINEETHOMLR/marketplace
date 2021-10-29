<?php
class Admin_video extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( array( 'Video_model' ) );
	}
	
	public function form(  $video_content_type , $video_ref_id = NULL )
	{
		$where[ 'video_content_type' ] = $video_content_type;
		$where[ 'video_ref_id' ]	=	$video_ref_id;
		$data[ 'videos' ] = $this->Video_model->get_many($where);
		$data['content'] = 'form';
		$this->load->view( 'form' , $data );
	}
	
	public function update(  $video_content_type , $video_ref_id , $videos = array() )
	{

		$where[ 'video_content_type' ] = $video_content_type;
		$where[ 'video_ref_id' ]	=	$video_ref_id;
		$this->Video_model->delete(  $where  );
		$datas = array();
		foreach ($videos as $key => $value) {
			if(trim($value[ 'video_name' ])==''){
				continue;
			}
			$data = $where;
			$data[ 'video_name' ] = $value['video_name'];
			//$data[ 'video_alt_text' ] = $value['video_alt_text'];
			$datas[] = $data;
		}
		//echo '<pre>';print_r($datas);echo '</pre>';
		$this->Video_model->add_batch(  $datas  );
	}
	
	public function clear(  $video_content_type , $video_ref_id){
		$where[ 'video_content_type' ] = $video_content_type;
		$where[ 'video_ref_id' ]	=	$video_ref_id;
		$this->Video_model->delete(  $where  );
	}

	public function list_json()
	{
		
		$video_status	=	$this->input->post( 'video_status' );
		$limit	=	$this->input->post( 'limit' );
		$start	=	$this->input->post( 'offset' );
		$date_from	=	$this->input->post( 'date_from' );
		$date_to	=	$this->input->post( 'date_to' );
		
		$rows = $this->Video_model->get_list(   $video_status  );
		
		foreach( $rows as $k => $v )
		{
			$vieos	=	Modules::run( 'img/list_json' , $v[ 'video_id' ],  vieoType::GALLERY  , TRUE );
			$vieos	=	$vieos[ 'rows' ];
			$rows[ $k ][ 'vieos' ]	=	$vieos;
			
			$main_vieo	=	sizeof($vieos)?$vieos[0]['vieo_name']:'default.png';
			foreach($vieos as $ki => $vi)
			{
				if( $vi[ 'vieo_is_main' ] == 1 ) $main_vieo	=	$vi[ 'vieo_name' ];
			}
			$rows[ $k ][ 'main_vieo' ]	=	$main_vieo;
			$rows[ $k ][ 'vieo_count' ]	=	sizeof($vieos);
		}
		
		
		$data[ 'rows' ]	=	$rows;
		
		$data[ 'total' ] = $this->Video_model->get_count(  $video_status  );
		echo json_encode( $data );
	}
	
	
	
}