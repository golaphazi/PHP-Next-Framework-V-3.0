<?php
namespace routerApps\apps;
use databaseApps\apps as database;
use systemApps\apps as superAppRouter;	
class NX_router Extends database\NX_database{
	public $router;
	private $controller;
	private $className;
	private $method;
	private $folder;
	private $appUrl;
	private $other_data = '';
	
	public function __construct(){
		
		$obj = new superAppRouter\NX_system_super();
		$obj->page_load = 'configration/router.php';
		$obj->get_page_load();
		$config = $obj->get_page_load();
		if(is_array($config) AND sizeof($config) > 0){
			$this->controller = $config;
		}	
		
		parent::__construct();
	}
	
	public function controller(){
		
		$control = explode('/', $this->router);
		if(in_array(parent::get_base_name(), $control)){
			
			$items = array_flip($control);
			unset($items[ parent::get_base_name() ]);
			$control_su = array_flip($items);
			
		}else{
			$control_su = $control;
		}
		
		$m = 0;
		if(array_key_exists('default_controller', $this->controller)){
			$con = $this->controller['default_controller'];
		}else{
			$con = 'index';
		}
		
		if(is_array($control_su) AND sizeof($control_su) > 1){
			foreach($control_su AS $value){
				if(strlen($value) > 1 AND $m == 0 ):
					if(array_key_exists($value, $this->controller)){
						$con = $this->controller[$value];
						unset($items[ $value ]);
						$control_su = array_flip($items);
						$m = 1;
					}else{
						if(array_key_exists('default_NX_url', $this->controller)){
							if(strlen($this->controller['default_NX_url']) > 5){
								$con = $this->controller['default_NX_url'];
							}
						}
					}
				endif;
			}
			
		}
		$this->other_data = array_filter($control_su);
		return $this->showController($con);
	}
	
	private function showController($con = 'index'){
		
		$folder = '';
		$control = explode('@', $con);
		if(is_array($control) AND sizeof($control) > 0){
			if(sizeof($control) > 0){
				$methodCheck = $control[0];	
				$checkClass = explode('/', $methodCheck);
				if(is_array($checkClass) AND sizeof($checkClass) > 0){
					$className = $checkClass[sizeof($checkClass) - 1];
					
					/*check folder name*/
					if(in_array($className, $checkClass)){			
						$items = array_flip($checkClass);
						unset($items[ $className ]);
						$folder = implode('/', array_flip($items));	
						
					}
				}else{
					$className = $methodCheck;
				}
				
			}else{
				if(array_key_exists('default_controller', $this->controller)){
					$className = $this->controller['default_controller'];
				}else{
					$className = 'index';
				}
			}
			
			if(sizeof($control) > 1){
				$functionCheck = $control[1];
				$checkMethod =  explode('/', $functionCheck);
				
				if(is_array($checkMethod) AND sizeof($checkMethod) > 0){
					$method = $checkMethod[0];
					if(sizeof($checkMethod) > 1){
						
						if(in_array($method, $checkMethod)){			
							$items = array_flip($checkMethod);
							unset($items[ $method ]);
							$this->other_data = array_filter(array_merge($items, $this->other_data));				
						}
					}
				}else{
					$method = $functionCheck;
				}
				
			}else{
				if(array_key_exists('default_method', $this->controller)){
					$method = $this->controller['default_method'];
				}else{
					$method = 'index';
				}
			}
			
		}else{
			$className = $this->controller['default_controller'];
			if(array_key_exists('default_controller', $this->controller)){
				$className = $this->controller['default_controller'];
			}else{
				$className = 'index';
			}
			
			if(array_key_exists('default_method', $this->controller)){
				$method = $this->controller['default_method'];
			}else{
				$method = 'index';
			}
			
		}
		
		$this->folder = $folder;
		$this->className = $className.'Controller';
		$this->method = $method.'Action';
		
		$appUrl = 'apps/http/controller/'.ltrim($this->folder, '/').'/'.$this->className.'.php';
		$this->appUrl = $appUrl;

		$this->pageLoadController();
		if($this->checkClass()){
			if($this->checkMethod()){
				$cl = $this->className;
				$method_name = $this->method;
				$page = new $cl ();
				$page->$method_name (array_values($this->other_data));
			}else{
				$this->mass = 'This method : '.$this->method.' is wrong in '.$this->className.' Controller...';
				echo parent::show_error();
			}
			
		}else{
			$this->mass = 'This controller : '.$this->className.' is wrong...';
			echo parent::show_error();
			
		}
		
	}
	
	
	private function pageLoadController(){
		/*call object for this class*/
		$system = new superAppRouter\NX_system_super();
		$system->page_load = $this->appUrl;
		if (file_exists($system->page_load)){
			$system->get_refress();
			$system->upload_index_file();
			return include $system->page_load;
		}else{
			$system->massage = $system->page_load;
			return $system->show_massage();
			
		}
		
	}
	
	private function checkClass(){
		
		if(class_exists($this->className)){
			return true;
		}else{
			return false;
		}
		
	}
	
	private function checkMethod(){
		if(method_exists($this->className,$this->method)){
			return true;
		}else{
			return false;
		}
	}
}

?>