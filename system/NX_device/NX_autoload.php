<?php
namespace autoload\apps;
class NX_autoload{
	public $access;
	public $autoload;
	public $load;
	public function  __construct(array $load, $sys){
		$this->access = $sys;
		if(is_array($load) AND sizeof($load) > 1){
			$this->load = $load;
			$this->access->class_name = $this->autoload;
			$this->access->page_load = $this->load['NX_database'];
			
		}
		
	}
	
}

?>