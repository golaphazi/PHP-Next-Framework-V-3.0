<?php
namespace DBApps;
use NX\DB_driver\apps\NX_db_driver as driver;
use systemApps\apps\NX_system_super as NX_system_super;
use configApps\apps\NX_config as NX_config;
use NX_trait\templeate\NX_templeate as NX_templeate;
use NX\Html\Apps\htmlApps AS htmlApps;
use NX\Session\Apps\NX_Session AS NX_Session;
use NX\Url\Apps\NX_Url AS NX_Url;
use NX\Country\Apps\NX_Country AS NX_Country;
use NX\Editor\Apps\NX_Editor AS NX_Editor;
use NX\Pagination\Apps\NX_Pagination AS NX_Pagination;
use NX\Upload\Apps\NX_Upload AS NX_Upload;

class NX_db Extends driver{
	
	use NX_templeate;
	
	protected $db;
	protected $db_autoload;
	protected $super;
	protected $view_page;
	protected $load_page;
	protected $config;
	protected $form;
	protected $session;
	
	protected function __construct(){
		parent::__construct();
		$this->super 	 = new NX_system_super();
		
		/*AUtoload configration*/
		$obj = clone $this->super;
		$obj->page_load = 'configration/autoload.php';
		$obj->get_page_load();
		$autoload = $obj->get_page_load();
		if(is_array($autoload) AND sizeof($autoload) > 0){
			$this->db_autoload = $autoload;
		}
		//print_r($this->db_autoload);
		if(array_key_exists('NX_helper', $this->db_autoload)){
			$nx_helper =  $this->db_autoload['NX_helper'];
			if(is_array($nx_helper) AND sizeof($nx_helper) > 0){
				foreach($nx_helper AS $value){
					if($value == 'db'){
						$this->db 		 = parent::selector();
					}else if($value == 'form'){
						$this->form 	= new htmlApps();
					}else if($value == 'session'){
						$this->session 	= new NX_Session();
					}else if($value == 'url'){
						$this->url 	= new NX_Url();
					}
				}
				
			}
		}
		
		if(array_key_exists('NX_library', $this->db_autoload)){
			$nx_library =  $this->db_autoload['NX_library'];
			if(is_array($nx_library) AND sizeof($nx_library) > 0){
				foreach($nx_library AS $value){
					if($value == 'editor'){
						$this->editor 		 = new NX_Editor();
					}else if($value == 'country'){
						$this->country 	= new NX_Country();
					}else if($value == 'pagination'){
						$this->pagination 	= new NX_Pagination();
					}else if($value == 'upload'){
						$this->upload 	= new NX_Upload();
					}
				}
				
			}
		}
		
		if(array_key_exists('model', $this->db_autoload)){
			$model =  $this->db_autoload['model'];
			if(is_array($model) AND sizeof($model) > 0){
				foreach($model AS $key=>$value){
					//$this->$key 	= $this->model($value);
				}
				
			}
		}
		
		$this->view_page = clone $this->super;
		$this->load_page = clone $this->view_page;
		$this->config 	 = new NX_config();
		
	}
	protected function db_connect(array $db_info){
		if(is_array($db_info)){
			return parent::self_db($db_info);
		}else{
			return 0;
		}
	}
	
	public function query_start(){
		return clone $this->db;
	}
	
	public function NX_helper($nx_helper=''){
		if(is_array($nx_helper)){
			foreach($nx_helper AS $value){
				if($value == 'db'){
					$this->db 		 = parent::selector();
				}else if($value == 'form'){
					$this->form 	= new htmlApps();
				}else if($value == 'session'){
					$this->session 	= new NX_Session();
				}else if($value == 'url'){
					$this->url 	= new NX_Url();
				}
			}
			
		}else{
			if($nx_helper == 'db'){
				$this->db 		 = parent::selector();
			}else if($nx_helper == 'form'){
				$this->form 	= new htmlApps();
			}else if($nx_helper == 'session'){
				$this->session 	= new NX_Session();
			}else if($nx_helper == 'url'){
				$this->url 	= new NX_Url();
			}
		}
	}
	
	public function NX_library($nx_library=''){
		if(is_array($nx_library)){
			foreach($nx_library AS $value){
				if($value == 'editor'){
					$this->editor = new NX_Editor();
				}else if($value == 'country'){
					$this->country 	= new NX_Country();
				}else if($value == 'pagination'){
					$this->pagination 	= new NX_Pagination();
				}else if($value == 'upload'){
					$this->upload 	= new NX_Upload();
				}
			}
			
		}else{
			if($nx_library == 'editor'){
				$this->editor 		 = new NX_Editor();
			}else if($nx_library == 'country'){
				$this->country 	= new NX_Country();
			}else if($nx_library == 'pagination'){
				$this->pagination 	= new NX_Pagination();
			}else if($nx_library == 'upload'){
				$this->upload 	= new NX_Upload();
			}
		}
	}
	
}
?>