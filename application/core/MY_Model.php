<?php
/**
 * A base model with a series of CRUD functions (powered by CI's query builder),
 * created by sarath ks - Riolabz
 * project MOVERSKART
 * heavily inspired from http://github.com/jamierumbelow/codeigniter-base-model
 * implimeted by extending a model and assigning database name at constructor of that model
**/
defined('BASEPATH') OR exit('No direct script access allowed');
class My_model extends CI_Model {

        public $_table;
		public $primary_key;
		public $primary_column;
		public $dbnow;
		public $dbnowtime;
		
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->dbnow = date("Y-m-d H:i:s", time());
			$this->dbnowtime=date("H:i:s", time());
			//$this->db = $this->db;
		}
		
		
		public function add( $data , $no_primary=NULL )
		{
			if( ! $res	=	$this->db->insert($this->_table, $data) )
			{
				return  false;
			}
			else if( $no_primary != NULL )
			{
				return true;
			}
			else
			{
				return $this->db->insert_id();
			}
		}
		
		public function add_many($data)
		{
			$ids = array();
			foreach ($data as $key => $row)
			{
				$ids[] = $this->insert($row);
			}
			return $ids;
		}
		
		public function add_batch($data)
		{
			if( ! sizeof( $data ) )
			{
				return true;
			}
			$this->db->insert_batch($this->_table,$data); 
		}
		
		public function update($data,$where = NULL )
		{
			if( $where != NULL )
			{
				$this->set_where($where);
			}
			
			return $this->db->update($this->_table, $data );
		}
		
		public function _update_batch( $data , $column )
		{
			if( ! sizeof( $data ) )
			{
				return true;
			}
			$this->db->update_batch( $this->_table , $data , $column ); 
		}
		
		
		public function get($where=NULL)
		{
			if($where!=NULL)
			{
				$this->set_where($where);
			}
			return  $this->db->get($this->_table)->row_array();
		}
		
		public function get_many($where=NULL)
		{
			if($where!=NULL)
			{
				$this->set_where($where);
			}
			return  $this->db->get($this->_table)->result_array();
		}
		
		public function get_column($column,$where=NULL)
		{
			if($where!=NULL)
			{
				$this->set_where($where);
			}
			
			if(is_array($column))
			{
				$this->db->select($column);
				return $this->db->get($this->_table)->result_array();
			}
			else
			{
				if( $row = $this->db->get($this->_table)->row() )
				{
					return $row->$column;
				}
				else
				{
					return false;
				}
			}
			
		}
		
		public function delete($where)
		{
			$this->set_where($where);
			return $this->db->delete($this->_table);
		}
		
		public function delete_many( $key , $where )
		{
			return $this->db
				->where_in( $key , $where )
				->delete($this->_table);
		}
		
		public function countn($where=NULL)
		{
			$this->db->from($this->_table);
			if($where!=NULL)
			{
				$this->set_where($where);
			}
			
			return $this->db->count_all_results();
		}
		
		
		
		 public function limit($limit = NULL, $offset = NULL) 
		 {
			if (is_numeric($limit) && is_numeric($offset)) 
			{
				$this->db->limit($limit, $offset);
			} 
			elseif (is_numeric($limit)) 
			{
				$this->db->limit($limit);
			}
			return $this;
		}
		
	
		public function _where($params)
		{
			if (count($params) == 1 && is_array($params[0]))
			{
				foreach ($params[0] as $field => $filter)
				{
					if (is_array($filter))
					{
						$this->db->where_in($field, $filter);
					}
					else
					{
						if (is_int($field))
						{
							$this->db->where($filter);
						}
						else
						{
							$this->db->where($field, $filter);
						}
					}
				}
			} 
			else if (count($params) == 1)
			{
				$this->db->where($params[0]);
			}
			else if(count($params) == 2)
			{
				if (is_array($params[1]))
				{
					$this->db->where_in($params[0], $params[1]);    
				}
				else
				{
					$this->db->where($params[0], $params[1]);
				}
			}
			else if(count($params) == 3)
			{
				$this->db->where($params[0], $params[1], $params[2]);
			}
			else
			{
				if (is_array($params[1]))
				{
					$this->db->where_in($params[0], $params[1]);    
				}
				else
				{
					$this->db->where($params[0], $params[1]);
				}
			}
		}
		
		
		public function order_by($criteria, $order = 'ASC')
		{
			if ( is_array($criteria) )
			{
				foreach ($criteria as $key => $value)
				{
					$this->_table->order_by($key, $value);
				}
			}
			else
			{
				$this->_table->order_by($criteria, $order);
			}
			return $this;
		}
	
		public function set_where($where)
		{
			if(!is_array($where))
			{
				$where	=	array($this->primary_key=>$where);
			}
			foreach($where as $key => $val)
			{
				$this->db->where($key, $val);
			}
			return $this;
		}
		
		public function set_select($columns)
		{
			$this->db->select($columns);
			return $this;
		}
		
		 private function _fetch_primary_key()
		{
			if($this->primary_key == NULl)
			{
				$this->primary_key = $this->db->query("SHOW KEYS FROM `".$this->_table."` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
			}
		}
		
		
		/**
     * Retrieve and generate a form_dropdown friendly array
     */
    public function dropdown( $key = NULL , $value = NULL )
    {
        
        if( $key == NULL  )
        {
            $key = $this->primary_key;
        }
		
		if( $value == NULL  )
        {
            $value = $this->primary_column;
        }
       
        $result = $this->db->select(array($key, $value))
                           ->get($this->_table)
                           ->result();
        $options = array();
		
        foreach ($result as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }
        return $options;
    }
			
		

}













/*public function get($where=NULL,$column=NULL,$sort=NULL,$limit=NULL, $start=NULL)
		{
			$this->db->limit($limit, $start);
			if($column!=NULL)
			{
				$this->db->select($column);
			}
			if($sort!=NULL)
			{
				$this->db->order_by($sort);
			}
			if($where!=NULL)
			{
				if(is_array($where) )
				{
					if(isset($where[0]) && is_array($where[0]))
					{
						foreach($where_in as $k => $v)
						{
							$db_pre1	=	$k==0?'where_in':'or_where_in';
							$this->db->$db_pre1($k, $v);//or_where_in
						}
					}
					else
					{
						$this->db->where($where);
					}
				}
				else
				{
					$this->db->where($where);
				}
				
			}
			
			return  $this->db->get($this->_table)->result_array();
		}
		*/