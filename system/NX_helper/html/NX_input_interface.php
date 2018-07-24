<?php
namespace NX\Input\InterfaceApps;
interface NX_Input_interface{
		
		public function input(array $element);
		public function select(array $data);
		public function radio(array $element);
		public function checkbox(array $element);
		public function radio_check(array $element, $type);
		
	
}
?>