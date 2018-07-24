<?php
namespace databaseApps\apps;
Abstract class NX_databaseAbstract{
	
	public  $db_config, $data_config;
	
	abstract protected function get_host();
	
	abstract protected function get_host_user();
	
	abstract protected function get_host_port();
	
	abstract protected function get_host_password();
	
	abstract protected function get_base_name();
	
	abstract protected function get_database();
	
	abstract protected function get_driver();
	
	abstract protected function get_server();
	
	abstract protected function use_database();
	
	abstract protected function show_error();
	
}
?>