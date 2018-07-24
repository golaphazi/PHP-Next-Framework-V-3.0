<?php
namespace abstractApps\apps;
Abstract class NX_abstract{
	
	public $page_load;
	public $class_name;
	public $load_auto;
	
	abstract public function get_refress();
	
	abstract public function show_massage();
	
	abstract public function get_file_check();
	
	abstract public function get_page_load();
	
	abstract public function auto_load();
	
	abstract public function upload_index_file();
	
}
?>