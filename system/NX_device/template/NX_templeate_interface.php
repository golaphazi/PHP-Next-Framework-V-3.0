<?php
namespace NX_trait\templeate\NX_Interface;
trait NX_templeate_interface{
	private $load_model = ''; private $load_css = ''; private $load_script = ''; private $load_library = '';
	
	/***********
	***************** Load header file 
	************/
	
	public function template($page='', $data=array()){
		if(strlen($page) > 0){
			$page = trim($page, '/');
			$base = 'public/template/'.$page.'.php';
			$this->super->page_load = $base;
			if ($this->super->get_file_check()){
				 if(is_array($data) AND sizeof($data) > 0){
					foreach($data AS $key=>$value){
						$$key = $data[$key];
					}
				}
				 include $base;
			}else{
				 $this->super->massage = $base;
				 return $this->super->show_massage();
			}
		}
	}
	
	/*
	***************** Load view file 
	*/
	public function view($page='', $data=array()){
		if(strlen(trim($page)) > 0){
			$page = trim($page, '/');
			$base = 'public/view/'.$page.'View.php';
			$this->view_page->page_load = $base;
			if ($this->view_page->get_file_check()){
				 if(is_array($data) AND sizeof($data) > 0){
					foreach($data AS $key=>$value){
						$$key = $data[$key];
					}
				}
				 include $base;
			 }else{
				 $this->view_page->massage = $base;
				 return $this->view_page->show_massage();
			}
		}
	}
	
	/*
	***************** Load model file 
	*/
	private function model_page(){
		$page = trim($this->load_model, '/');
		$base = 'apps/http/model/'.$page.'Model.php';
		$this->load_page->page_load = $base;
		if($this->load_page->get_file_check()){
			 require_once( $base);
			 $expde 	= explode("/", $page);
			 $count 	= sizeof($expde);
			 $class 	= $expde[$count-1].'Model';
			 if(class_exists($class)){
				return new $class;				
			}else{
				$this->load_page->massage = $class. ' this model class is invalid';
				return $this->load_page->show_massage();
			}
		 }else{
			 $this->load_page->massage = $base;
			 return $this->load_page->show_massage();
		}
	}
	
	public function model($page=''){
		if(is_array($page) AND sizeof($page) > 0){
			foreach($page AS $load){
				if(strlen($load) > 0){
					$this->load_model = trim($load);
					return $this->model_page();
				}
			}
		}else{
			$this->load_model = $page;
			return $this->model_page();	
		}
	}
	
	/*
	**************** Load library load for every  
	*/
	
	private function library_page(){
		
		$page = trim($this->load_library, '/');
		$base = 'apps/library/'.$page.'/'.$page.'Library.php';
		$this->load_page->page_load = $base;
		if($this->load_page->get_file_check()){
			 require_once( $base);
			 $expde 	= explode("/", $page);
			 $count 	= sizeof($expde);
			 $class 	= $expde[$count-1];
			 if(class_exists($class)){
				return new $class;				
			}else{
				$this->load_page->massage = $class. ' this Library class is invalid';
				return $this->load_page->show_massage();
			}
		 }else{
			 $this->load_page->massage = $base;
			 return $this->load_page->show_massage();
		}
		
	}
	
	public function library($page=''){
		if(is_array($page) AND sizeof($page) > 0){
			foreach($page AS $load){
				if(strlen($load) > 0){
					$this->load_library = $load;
					return $this->library_page();
				}
			}
		}else{
			$this->load_library = $page;
			return $this->library_page();	
		}
	}
	
	/*
	***************** Load css file 
	*/
	private function css_page(){
		$page = trim($this->load_css, '/');
		$base = 'public/css/'.$page.'.css';
		$this->load_page->page_load = $base;
		if ($this->load_page->get_file_check()){
			 return '<link rel="stylesheet" type="text/css" href="'.$this->config->get_base_url().''.$base.'"/>';
		 }else{
			 $this->load_page->massage = $base;
			 return $this->load_page->show_massage();
		}
	}
	
	public function css($css=''){
		$css_show ='';
		if(is_array($css) AND sizeof($css) > 0){
			foreach($css AS $load){
				if(strlen($load) > 0){
					$this->load_css = trim($load);
					$css_show .= $this->css_page();
				}
			}
		}else{
			$this->load_css = $css;
			$css_show .= $this->css_page();	
		}
		return $css_show;
	}
	
	/*
	***************** Load script file 
	*/
	private function script_page(){
		$page = trim($this->load_script, '/');
		$base = 'public/script/'.$page.'.js';
		$this->load_page->page_load = $base;
		if ($this->load_page->get_file_check()){
			 return '<script type="text/javascript" src="'.$this->config->get_base_url().''.$base.'"></script>';
		 }else{
			 $this->load_page->massage = $base;
			 return $this->load_page->show_massage();
		}
	}
	
	public function script($script=''){
		$script_show = '';
		if(is_array($script) AND sizeof($script) > 0){
			foreach($script AS $load){
				if(strlen($load) > 0){
					$this->load_script = trim($load);
					$script_show .= $this->script_page();
				}
			}
		}else{
			$this->load_script = $script;
			$script_show .= $this->script_page();	
		}
		return $script_show;
	}
	
		
		
	
}
?>