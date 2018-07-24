<?php
namespace NX\Url\InterfaceApps;
interface NX_Url_interface{
	
	public function redirect($uri = '', $method = 'auto', $code = NULL);
	public function url_title($str, $separator = '-', $lowercase = FALSE);
	public function mailto($email, $title = '', $attributes = '');
	public function anchor($uri = '', $title = '', $attributes = '');
	public function anchor_popup($uri = '', $title = '', $attributes = FALSE);
	
	public function page_redirect($uri = '');
	
	public function page_go($no = '');
	public function page_back();
	public function reload();
}
?>