<?php
namespace NX\Session\OS\InterfaceApps;
interface NX_OS_info_interface{
	
	public function get_mac();
	public function get_ip();
	public function get_ip_info($ip='');
	public function get_latitude($ip='');
	public function get_longitude($ip='');
	public function iptocountry($ip='');
	public function get_country($ip='');
	public function get_OS();
	public function get_broswer();
	public function set_user_agent();
	public function set_user_broswer();
	public function getUserAgent();
	
	
}
?>