<?php
namespace NX\Cookie\InterfaceApps;
interface NX_Cookie_interface{
	
	public function set_cookie($element, $file='',$time='');
	
	public function get_cookie($element='', $set ='');
	
	public function unset_cookie($element);
	
}
?>