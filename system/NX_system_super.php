<?php
namespace systemApps\apps;
use abstractApps\apps as abstaractApps;
class NX_system_super Extends abstaractApps\NX_abstract{
	public $massage, $app_url;
	
	public function __construct(){
		
	}
	
	/**=============
	==== Cache clear for every page
	===============**/
	
	public function get_refress(){
		if (file_exists($this->page_load)){
			$fh 			= fopen($this->page_load, 'r');
			$contentData 	= fread($fh, filesize($this->page_load));
			ftruncate($fh,100);
			fclose($fh);	
			clearstatcache();
			return $this->page_load;
		}
	}
	
	
	/**=============
	==== Index file upload every folder
	===============**/
	
	public function upload_index_file(){
		$upload = explode("/", $this->page_load);
		$upload_size = sizeof($upload);
		$romove = $upload[$upload_size-1];
		$path = str_replace($romove,"", $this->page_load);
		$url = 'system/index.html';
		$name = basename($url);
		if (!file_exists($path.'index.html')){
			file_put_contents("$path/$name", file_get_contents($url));
		}
		return true;
	}
	
	/**=============
	==== Show error massage
	===============**/
	
	public function show_massage(){
		echo '<h1 style="color:red; font-size:15px;text-align:center;margin:10% auto; padding:10px; border:1px solid #ccc; background:#eeeeee; border-radius:5px;"> '.$this->massage.' not found</h1>';		   
		die();
	}
	
	
	/**=============
	==== File check Yes / No
	===============**/
	
	public function get_file_check(){
		if (file_exists($this->page_load)){
			$this->get_refress();
			$this->upload_index_file();
			return true;
		}else{
			return false;
		}				
	}
	
	
	/**=============
	==== Load page 
	===============**/
	
	public function get_page_load(){
		if ($this->get_file_check()){
			return include $this->page_load;
		}else{
			$this->massage = $this->page_load;
			return $this->show_massage();
		}	
	}
	
	
	/**=============
	==== Auto loader 
	===============**/
	
	
	public function auto_load(){
		spl_autoload_register(function($class_name){
			$this->class_name = ''.$class_name.'';
			if(array_key_exists($this->class_name, $this->load_auto)){
				$this->page_load = ''.$this->load_auto[$this->class_name].'';			
				if(strlen($this->page_load) > 2){
					if($this->get_file_check()){
						$this->upload_index_file();
						require( $this->page_load);
					}else{
						$this->massage = $this->page_load;
						return $this->show_massage();
					}
				}
			}
		});
	}
}


use systemApps\apps as SystemApp;
/*call object for this class*/
$system = new SystemApp\NX_system_super();

$auto = clone $system;
$auto->page_load = __DIR__ .'/NX_autoload/autoload.php';
$system->load_auto = $auto->get_page_load();

$system->auto_load();

use configApps\apps as configApps;
$config = new configApps\NX_config();

/*config router*/

use routerApps\apps as routerApps;
$router = new routerApps\NX_router();


?>
