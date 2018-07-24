<?php
namespace databaseApps\apps;
use databaseApps\apps\NX_databaseAbstract as NX_databaseAbstract;
use systemApps\apps as superAppRouter;
class NX_database Extends NX_databaseAbstract{
	public $mass;
	protected function __construct(){
		$obj = new superAppRouter\NX_system_super();
		
		/*Database configration*/
		$obj->page_load = 'configration/database.php';
		$obj->get_page_load();
		$config = $obj->get_page_load();
		if(is_array($config) AND sizeof($config) > 0){
			$this->db_config = $config;
		}	
		
		/*config page*/
		$obj_con = clone $obj;
		$obj_con->page_load = 'configration/config.php';
		$obj_con->get_page_load();
		$config_data = $obj_con->get_page_load();
		if(is_array($config_data) AND sizeof($config_data) > 0){
			$this->data_config = $config_data;
		}	
		
		
	}
	
	protected function get_host(){
		if(array_key_exists('host', $this->db_config)){
			return $this->db_config['host'];
		}else{
			return 'localhost';
		}
	}
	
	protected function get_host_user(){
		if(array_key_exists('user', $this->db_config)){
			return $this->db_config['user'];
		}else{
			return 'root';
		}
	}
	
	protected function get_host_password(){
		if(array_key_exists('password', $this->db_config)){
			return $this->db_config['password'];
		}else{
			return '';
		}
	}
	
	protected function get_database(){
		if(array_key_exists('database', $this->db_config)){
			return $this->db_config['database'];
		}else{
			return '';
		}
	}
	
	protected function get_host_port(){
		if(array_key_exists('port', $this->db_config)){
			return $this->db_config['port'];
		}else{
			return '';
		}
	}
	
	protected function get_base_name(){
		if(array_key_exists('base', $this->data_config)){
			return rtrim($this->data_config['base'], '/');
		}else{
			return '';
		}
	}
	
	protected function get_driver(){
		if(array_key_exists('driver', $this->db_config)){
			return $this->db_config['driver'];
		}else{
			return 'pdo';
		}
	}
	
	protected function get_server(){
		if(array_key_exists('server', $this->db_config)){
			return $this->db_config['server'];
		}else{
			return 'phpmyadmin';
		}
	}
	
	protected function use_database(){
		if(array_key_exists('db_set', $this->data_config)){
			return $this->data_config['db_set'];
		}else{
			return 'Yes';
		}
	}
	
	protected function show_error(){
		echo '<h1 style="color:red; font-size:15px;text-align:center;margin:10% auto; padding:10px; border:1px solid #ccc; background:#eeeeee; border-radius:5px;"> '.$this->mass.'</h1>';		   
		die();
	}
	
}

?>