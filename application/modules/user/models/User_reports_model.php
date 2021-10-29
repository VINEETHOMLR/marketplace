<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_reports_model extends MY_Model {

		public function __construct()
		{
			parent::__construct();
			$this->_table	=	'mv_requirment';
			$this->primary_key	=	'requirment_id';
			$this->primary_column	=	'requirment_status';
			
		}
		
}