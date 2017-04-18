<?php

class DB
{
	private static $_instance = null;
	private $_config;
	private $_connection;
	private $_query;
	private $_error = false;
	private $results;
	private $_count = 0;
	
	public static function getInstance()
	{
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	private function __construct()
	{
		$this->_config = Config::get('database');
		$driver = $this->_config['driver'];
		$host = $this->_config[$driver]['host'];
		$db = $this->_config[$driver]['db'];
		$user = $this->_config[$driver]['user'];
		$pass = $this->_config[$driver]['pass'];
		$this->_connection = new PDO("{$driver}:host={$host};dbname={$db}", 'root', '');
		
	}
	private function __clone(){}
	
	public function query($sql, $params = array())
	{
		$this->_error = false;
		
		if($this->_query = $this->_connection->prepare($sql)){
		$x = 1;
		if(!empty($params)){
			foreach ($params as $param){
				$this->_query->bindValue($x, $param);
				$x++;
				}
			}
			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll($this->_config['fetch']);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}
		return $this;
	}
	
	private function action($action, $table, $where = array())
	{
		if(count($where) === 3)
		{
			$operators = array('=','<','>','<=','>=');
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			if (in_array($operator, $operators))
			{
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this->query($sql, array($value))->error())
				{
					return $this;
				}
			}
		} else {
			$sql = "{$action} FROM {$table}";
					if (!$this->query($sql)->error())
				{
					return $this;
				}
		}
		return false;
	}
	
	public function get($field, $table, $where = array())
	{
		return $this->action("SELECT {$field}", $table, $where);
	}
	
	public function find($id, $table)
	{
		return $this->action("SELECT *", $table, array('id','=', $id));
	}
	
	public function delete($table, $where = array())
	{
		return $this->action("DELETE", $table, $where);
	}
	
	public function insert($table, $fields)
	{
		$keys = implode(',',array_keys($fields));
		$fields_num = count($fields);
		$values = '';
		$x = 1;
		foreach($fields as $field)
		{
			$values .= '?';
			if($x< $fields_num)
			{
				$values .= ',';
			}
			$x++;
		}
		
		$sql = "INSERT INTO {$table} ({$keys}) VALUES({$values})";
		
		if(!$this->query($sql,$fields)->error())
		{
			return true;
		}
		return false;
	} 
	
	public function update($table, $id, $fields)
	{
		$fields_num = count($fields);
		$set = '';
		$x = 1;
		
		foreach($fields as $key => $value)
		{
		$set .= "{$key} = ?";
		if($x< $fields_num)
			{
				$set .= ',';
			}
			$x++;
		}
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if(!$this->query($sql, $fields)->error())
		{
			return true;
		}
		return false;
	}
	
	/*GETERI*/
	public function connection()
	{
		return $this ->_connection;
	}
	public function error()
	{
		return $this->_error; 
	}
	public function first()
	{
		return $this->_results[0]; 
	}
	public function results()
	{
		return $this->_results; 
	}
	public function count()
	{
		return $this->_count; 
	}
}
