<?php
class Widgets extends MX_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function astrologer_details_left(   $astrologer  )
	{
		$data[ 'astrologer' ]	=	$astrologer;		
		$this->load->view( 'astrologer_details_left' , $data );
	}
	
	
}