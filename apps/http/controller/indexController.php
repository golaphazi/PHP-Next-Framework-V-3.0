<?php
use DBApps\NX_db as NX_db;

class indexController Extends NX_db{
	public function __construct(){
		parent::__construct();
		$this->userId   = $this->session->get_session('userId', 0);
		$this->userLogin   = $this->session->get_session('userLogin');
		$this->login = $this->model('registration/login');
	}
	
	public function indexAction(){
		$data = array();
		//$this->set_title('Welcome ');
		//$this->set_keyword('Welcome ');
		//$this->set_description('');
		if($this->userId > 0 AND strlen($this->userLogin) > 2){
			parent::template('hot_author/header', $data);
		}else{
			parent::template('hot_author/header_login', $data);
		}
		
		parent::view('hot/index', $data);
		
		parent::template('hot_author/footer', $data);
	}
	
	
}
?>
