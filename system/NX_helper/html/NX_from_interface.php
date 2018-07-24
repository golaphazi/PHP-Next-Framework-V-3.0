<?php
namespace NX\From\InterfaceApps;
interface NX_From_interface{
	
		public function form_start(array $element);
		public function form_close();
		public function get($name, $value='');
		public function post($name, $value='');
		public function request($name, $value='');
		public function server($name, $value='');
		
		
	
}
?>