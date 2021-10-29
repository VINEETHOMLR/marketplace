<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Scripts_model extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->_table	=	'mv_scripts';
		$this->primary_key	=	'script_id';
		$this->primary_column	=	'script';
	}
	
}