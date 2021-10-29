<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	public $user = false;
	public $base;
	public $dbnow;
	public $project_name = 'Marketplace';
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
		
		if ( $this->ion_auth->logged_in()  ) 
		{
			$this->user = (array)$this->ion_auth->user()->row();
		}
		$this->dbnowtime=date("H:i:s", time());
		$this->dbnow=date("Y-m-d H:i:s", time());
		$this->base	=	base_url();
		
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}
	
	
	public function do_upload($field_name ,$upload_path , $file_name=NULL ) 
	{
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		if( $file_name != NULL )
		{
			$config[ 'file_name' ] = $file_name;
		}
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload($field_name))
		{
			return false;//$this->upload->display_errors();
		}
		else
		{
			$data = ($this->upload->data());
			return  $data['file_name'];
		
		}
	}
	
	
	public function crop_image( $source_path , $width	=500 , $height = NULL ,$maintain_ratio = TRUE , $create_thumb = FALSE  )
	{
		$this->load->library('image_lib');
		$height	=	$height ? $height : $width;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $source_path;
		$config['create_thumb'] = $create_thumb;
		$config['maintain_ratio'] = $maintain_ratio;
		$config['width']     = $width;
		$config['height']    = $height;
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->crop();
	
	}
	
	public function resize_image( $source_path , $width	=500 , $height = NULL )
	{
		$this->load->library('image_lib');
		$height	=	$height ? $height : $width;
		$config['width']     = $height;
		$config['height']    = $width;
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}
	
	public function delete_file($path)
	{
		if (!file_exists($this->base.$path))
		{
			return true;
		}
		else
		{
			return unlink($path);
		}
	}
	
	public function init_pagination( $url , $total_rows , $per_page = 10 )
	{
		$this->load->library('pagination');
		$config['base_url'] = $this->base.$url;
		$config['total_rows'] = $total_rows ;
		$config['per_page'] = $per_page;
		
		$config['full_tag_open'] = '<ul class="pagination clearfix " >';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = '<li class="next">';
		$config['num_tag_open'] = '<li>';
		$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['reuse_query_string'] = TRUE;
		$config['cur_tag_open'] = "<li class='active'><span><b>";
		$config['cur_tag_close'] = "</b></span></li>";
		$this->pagination->initialize($config);
		
		return $this->pagination->create_links();
	}
	
	
}

