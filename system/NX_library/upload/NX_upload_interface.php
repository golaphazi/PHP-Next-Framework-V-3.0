<?php
namespace NX\Upload\InterfaceApps;

interface NX_Upload_interface{
	
	//private function temp_file();
	
	public function do_upload(array $image);
	
	//private function create_image($tmpFile = '');
	
	public function create_file_random($file_name = '', $type = 'random');
	
	public function create_path($upload_path = '');
	
	public function file_ext($fileName = '');
	
	public function image_size($tmpFile = '');
	
	//private function upload_file();
	
	//private function image_crop($image = '');
	
	//private function image_upload($image = '');
	
	public function initialize(array $config);
	
	public function data();
	
	public function delete_file();
	
	public function delete_folder();
	
	
}
?>