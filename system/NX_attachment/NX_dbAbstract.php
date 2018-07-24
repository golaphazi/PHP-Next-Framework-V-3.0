<?php
namespace NX\driver\selector;
Abstract Class NX_dbAbstract{
	
	abstract public function select_sub($sub = array());
	
	abstract public function select();
	
	abstract public function from();
	
	abstract public function where($where = array());
	
	abstract public function order($order = array());
	
	abstract public function limit($limit = array());
	
	abstract public function group($group = array());
	
	abstract public function having($having = array());
	
	abstract public function having_sub($sub = array());
	
	abstract public function query();
	
	abstract public function fetch();
	
	abstract public function fetch_once();
	
	abstract public function result();
	
	abstract public function result_once();
	
}
?>