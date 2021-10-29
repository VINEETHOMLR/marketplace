<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_post_images';
		$this->primary_key	=	'image_id';
		$this->primary_column	=	'image_user_id';
	}
	
	public function get_posts($date_from,$date_to)
	{
		
        
        if( $date_from != '' && $date_to != '' && $date_from != 0 && $date_to != 0 )
		{
			
	   		/*//echo $date_from	=	date("Y-m-d H:i:s", $date_from);
	   		$date_from	=	date("Y-m-d", strtotime($date_from));
			$date_to	=	date("Y-m-d", strtotime($date_to));
			$this->db
			->group_start()
			->where("image.date_of_join BETWEEN '$date_from' AND '$date_to' ")
			->group_end();*/
			$this->db->where('DATE_FORMAT(date_of_join,"%Y-%m-%d")>=', $date_from);
			$this->db->where('DATE_FORMAT(date_of_join,"%Y-%m-%d")<=', $date_to);
	    }
        return $this->db
	    ->select('image.*')
		->where('image.image_status',CommonStatus::ACTIVE)

		->order_by('image.image_no_of_views','DESC')
		->get( $this->_table.' image' )
		->result_array();
       

	}

    

       
}