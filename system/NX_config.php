<?php
namespace configApps\apps;
use databaseApps\apps as database;
class NX_config Extends database\NX_database{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_request_url(){
		return $_SERVER['REQUEST_URI'];
	}
	
	public function get_php_url(){
		return $_SERVER['PHP_SELF'];
	}
	
	public function get_base_url(){
		if(strlen($this->data_config['base_url']) > 5){
			return $this->data_config['base_url'];
		}else{
			return (!empty($_SERVER['HTTPS'])? 'https' : 'http'). '://' . $_SERVER['HTTP_HOST'].'/'.parent::get_base_name().'/';
		}
	}
	
	public function script_url(){
		if(strlen($this->data_config['script_url_name']) > 1){
			echo  '<script> var '.$this->data_config['script_url_name'].' = "'.$this->get_base_url().'"</script>';
		}else{
			echo  '<script> var script_url = "'.$this->get_base_url().'"</script>';
		}
	}
	
}
?>