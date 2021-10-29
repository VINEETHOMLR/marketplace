<?php
class Myreport_widget extends MX_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function booking_details_left( $bookings , $astrologer , $service_rate )
	{
		$data[ 'bookings' ]	=	$bookings;
		$data[ 'astrologer' ]	=	$astrologer;
		$data[ 'service_rate' ]	=	$service_rate;
		
		$this->load->view( 'myreport/booking_details_left' , $data );
	}
	
	
}