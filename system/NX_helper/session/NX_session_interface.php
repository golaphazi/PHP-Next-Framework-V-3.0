<?php
namespace NX\Session\InterfaceApps;
interface NX_Session_interface{
	
	public function set_session($element, $name='');
	
	public function unset_Session($element);
	
	public function get_session($element='', $set ='');
	
	public function sessionDestroy();
	
}
?>