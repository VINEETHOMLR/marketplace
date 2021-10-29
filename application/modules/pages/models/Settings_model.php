<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings_model extends MY_Model {
	
	public function __construct()
	{
		$this->_table	=	'mv_settings';
		$this->primary_key	=	'settings_id';
		$this->primary_column	=	'';
	}
	
}