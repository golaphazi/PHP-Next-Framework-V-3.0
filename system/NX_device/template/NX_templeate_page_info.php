<?php
namespace NX_trait\templeate\NX_Page_info;
use systemApps\apps as superAppRouter;	
trait NX_templeate_page_info{
	
	/*
	***************** Page title 
	*/
	private $title_page = '';
	private $title_keyword = '';
	private $dis_page = '';
	private $icon_page = '';
	private $site_name_page = '';
	private $site_url_page = '';
	private $info;
	
	private function get_info(){
		$this->info = include('configration/page_info.php');
		
		return $this->info;
	}
	
	public function set_title($data=''){
		$this->title_page = $data;
		if(strlen(trim($data)) > 1){
			$this->title_page = $data;
		}else{
			$this->get_info();
			if(array_key_exists("title", $this->info)){
				$this->title_page = $this->info['title'];
			}
		}
		
		return $this->title_page;
	}
	
	public function get_title(){
		$this->set_title($this->title_page);
		return $this->title_page;
	}	
	
	public function set_keyword($data=''){
		$this->title_keyword = $data;
		if(strlen(trim($data)) > 1){
			$this->title_keyword = $data;
		}else{
			$this->get_info();
			if(array_key_exists("keyword", $this->info)){
				$this->title_keyword = $this->info['keyword'];
			}
		}
		
		return $this->title_keyword;
	}
	
	public function get_keyword(){
		$this->set_keyword($this->title_keyword);
		return $this->title_keyword;
	}	
	
	
	public function set_description($data=''){
		$this->dis_page = $data;
		if(strlen(trim($data)) > 1){
			$this->dis_page = $data;
		}else{
			$this->get_info();
			if(array_key_exists("description", $this->info)){
				$this->dis_page = $this->info['description'];
			}
		}
		
		return $this->dis_page;
	}
	
	public function get_description($data=''){
		$this->set_description($this->dis_page);
		return $this->dis_page;
	}


	public function set_icon($data=''){
		$this->icon_page = $data;
		if(strlen(trim($data)) > 1){
			$this->icon_page = $data;
		}else{
			$this->get_info();
			if(array_key_exists("icon", $this->info)){
				$this->icon_page = $this->info['icon'];
			}
		}
		return $this->icon_page;
	}
	
	public function get_icon($data=''){
		$this->set_icon($this->icon_page);
		return $this->icon_page;
	}	
	
	public function set_site_name($data=''){
		$this->site_name_page = $data;
		if(strlen(trim($data)) > 1){
			$this->site_name_page = $data;
		}else{
			$this->get_info();
			if(array_key_exists("site_name", $this->info)){
				$this->site_name_page = $this->info['site_name'];
			}
		}
		return $this->site_name_page;
	}
	
	public function get_site_name($data=''){
		$this->set_site_name($this->site_name_page);
		return $this->site_name_page;
	}
	
	public function set_site_url($data=''){
		$this->site_url_page = $data;
		if(strlen(trim($data)) > 1){
			$this->site_url_page = $data;
		}else{
			$this->get_info();
			if(array_key_exists("url", $this->info)){
				$this->site_url_page = $this->info['url'];
			}
		}
		return $this->site_url_page;
	}
	
	public function get_site_url($data=''){
		$this->set_site_url($this->site_url_page);
		return $this->site_url_page;
	}
	
}
?>