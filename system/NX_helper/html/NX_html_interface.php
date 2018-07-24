<?php
namespace NX\Html\InterfaceApps;
interface NX_Html_interface{
		
		public function label(array $element);
		
		public function button(array $element);
		
		public function dataList(array $element);
		
		public function html_add($element='');
		
		public function html_remove($element='');
		
		public function html_view($element='');
}
?>