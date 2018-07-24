<?php
namespace NX\Upload\Apps;
use NX\Upload\InterfaceApps\NX_Upload_interface AS NX_Upload_interface;

class NX_Upload Implements NX_Upload_interface{
	
	private $config = array();
	
	private $image = array();
	
	private $extension = '';
	
	private $create_image = '';
	
	private $file_path 	= '';
	
	public $max_size 	= 0;
	
	public $max_width 	= 0;
	
	public $max_height 	= 0;
	
	public $percent 	= 1;
	
	public $ratio 		= false;
	
	public $center 		= true;
	
	private $file_name 	= '';
	
	private $file_temp 	= '';
	
	private $file_size 	= 0;
	
	public $allowed_types = '';
	
	public $set_error = '';
	
	public $return_data = array('');
	
	public function temp_file($tmpFile = ''){
		if(strlen($tmpFile) > 2){
			$this->file_temp = $tmpFile; 
		}else{
			if(array_key_exists('tem_file', $this->image)){
				$this->file_temp 			= $this->image['tem_file'];				
			}
		}
		return 	$this->file_temp; 
	}
	
	private function create_image($tmpFile = ''){
		$tmp = $this->temp_file($tmpFile);	
		if(strlen($tmp) > 2){
			if($this->extension == "jpg" || $this->extension == "jpeg" || $this->extension == "JPG" || $this->extension == "JPEG"){
				$this->create_image = ImageCreateFromJpeg($tmp);
			}else if($this->extension == "png" || $this->extension == "PNG"){
				$this->create_image = ImageCreateFromPng($tmp);
			}else if($this->extension == "gif" || $this->extension == "GIF"){
				$this->create_image = ImageCreateFromGif($tmp);
			}else{
				//$this->create_image = imagecreatefromstring($tmp);
				$this->create_image = $tmp;
			}
		}else{
			$this->create_image = '';
		}
		return $this->create_image;
	}
	
	public function file_ext($fileName = ''){
	    //$file = '';
		if(strlen($fileName) > 2){
			$file = $fileName; 
		}else{
			if(array_key_exists('file_name', $this->image)){
				$file 			= $this->image['file_name'];				
			}
		}
	    if(strlen($file) > 2){
			$file_exp 		= explode('.', $file);
			if(sizeof($file_exp) > 1){
				$file_count 	= sizeof($file_exp);
				//$this->extension = strtolower($file_exp[$file_count-1]); 
				$this->extension = strtolower(end($file_exp)); 
			 }else{
				 $this->extension = '';
			 }
		}else{
			$this->extension = '';
		}
	  return $this->extension;
	}
	
	public function image_size($tmpFile = ''){
		$tmp = $this->temp_file($tmpFile);
		if(strlen($tmp) > 0){
			$this->file_size = getimagesize($tmp);
		}else{
			$this->file_size = 0;
		}
		return $this->file_size;
	}
	
	public function allowed_types_file(){
		if(array_key_exists('allowed_types', $this->config)){
			$this->allowed_types = $this->config['allowed_types'];
		}
	}
	
	public function create_file_random($file_name = '', $type = 'random'){
		if(strlen($file_name) > 3){
			$this->file_name = $file_name;
		}else{
			if(array_key_exists('file_name', $this->image)){
				  $this->file_name = $this->image['file_name'];
			  }	
		}
		if($type == 'random'){
			$this->file_name = md5(strtolower(str_replace(" ", "-", trim($this->file_name))).time()).'.'.$this->extension;
		}else{
			$this->file_name = strtolower(str_replace(" ", "-", trim($this->file_name)));
		}
		return $this->file_name;
	}
	
	public function create_path($upload_path = ''){
		if(strlen($upload_path) > 3){
			$this->file_path = $upload_path;
		}else{
			if(array_key_exists('file_path', $this->config)){
				  $this->file_path = $this->config['file_path'];
			}else{
			  $this->file_path = '';
			}	
		}
			
		if( !is_dir( $this->file_path ) ){
			@mkdir($this->file_path, 0777, TRUE );
		}
		
		return $this->file_path;
	}
	
	private function upload_file(){
		$fileType = 'file';
		if(array_key_exists('upload_type', $this->config)){
			$fileType = $this->config['upload_type'];
		}
		
		$cropStatus = 'No';
		if(array_key_exists('crop_status', $this->config)){
			$cropStatus = $this->config['crop_status'];
		}
		if($fileType == 'file'){
			$status = $this->image_upload();
		}else{
			if($cropStatus == 'Yes'){
				$status = $this->image_crop();
			}else{
				$status = $this->image_upload();
			}
		}
				
		
		return $status;
	}
	
	private function image_crop($image = ''){
		if(strlen($image) > 2){
			$image = $image;
		}else{
			$image = $this->create_image;
		}
		
		$uploadType = $this->extension;
		
		list($width,$height) = $this->image_size();
	
		if(array_key_exists('max_width', $this->config)){
			$this->max_width = $this->config['max_width'];
		}
		
		if(array_key_exists('max_height', $this->config)){
			$this->max_height = $this->config['max_height'];
		}
		
		if(array_key_exists('crop_ratio', $this->config)){
			$this->ratio = $this->config['crop_ratio'];
		}
		
		if(array_key_exists('crop_center', $this->config)){
			$this->center = $this->config['crop_center'];
		}
		
		if(array_key_exists('crop_percent', $this->config)){
			$this->percent = $this->config['crop_percent'];
		}
		
		$file = $this->file_path.$this->file_name;
		
		$this->return_data = array('path' => $this->file_path, 'file_name' => $this->file_name, 'full_path' => $this->file_path.$this->file_name);
		
		if(!$this->ratio){
			if($width > $this->max_width) 
				$this->percent = $this->max_width/$width;
		}else{
			if($width >= $height){
				if($width > $this->max_width) 
				$this->percent = $this->max_width/$width;
			}else if($width < $height){
				if($height > $this->max_height) 
				$this->percent = $this->max_height/$height;
			}
		}
	
		$new_width = $width * $this->percent;
		$new_height = $height * $this->percent;
		$image_height = $new_height;
		
		if($this->max_height != 0){
			$image_height = $new_height < $this->max_height ? $new_height : $this->max_height;
		}
		$height_position = 0;
		if($this->center){
			if($new_height > $this->max_height){
				$height_position = (($new_height/2) - ($this->max_height/2));
			}
		}
		if($uploadType != 'png'){
			$image_p = imagecreatetruecolor($new_width, $image_height);
			$white = imagecolorallocate($image_p, 255, 255, 255);
			imagefilledrectangle($image_p, 0, 0, $new_width, $image_height, $white);
			imagecopyresampled($image_p, $image, 0, -$height_position, 0, 0, $new_width, $new_height, $width, $height);
		}
		
		if($uploadType == 'jpg' OR $uploadType == 'jpeg'){
			imagejpeg($image_p, $file, 100);
		}else if($uploadType == 'png'){
			$im = imagecreatetruecolor($new_width, $image_height);
			$alpha_channel = imagecolorallocatealpha($im, 0, 0, 0, 127); 
			imagecolortransparent($im, $alpha_channel); 
			imagefill($im, 0, 0, $alpha_channel); 
			imagecopy($im,$image, 0, 0, 0, 0, $new_width, $image_height); 
			imagesavealpha($im,true); 
			imagepng($im,$file,9);			
		}else if($uploadType == 'gif'){
			imagegif($image_p, $file, 100);
		}
		imagedestroy($image); 
		if($image){
			return true;
		}else{
			return false;
		}
		
	}
	
	private function image_upload($image = ''){

		$this->return_data = array('path' => $this->file_path, 'file_name' => $this->file_name, 'full_path' => $this->file_path.$this->file_name);
		if ( ! @copy($this->file_temp, $this->file_path.$this->file_name))
		{
			if ( ! @move_uploaded_file($this->file_temp, $this->file_path.$this->file_name))
			{
				$this->set_error = 'Could not upload';
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
		
	}
	
	public function initialize(array $config){
	  if(is_array($config) AND sizeof($config) > 0){
			$this->config = $config;		
	  }	
	  return $this;
	}
	
	public function do_upload(array $image){
	  if(is_array($image) AND sizeof($image) > 0){
			$this->set_error = '';
			$this->image = $image;
			if(array_key_exists('file_name', $this->image) AND array_key_exists('tem_file', $this->image)){
				
				if(strlen($this->image['file_name']) > 1){
					
					$this->file_ext();
					$temp = $this->temp_file();
					
					$type = 'random';
					if(array_key_exists('create_file', $this->config)){
						$type = $this->config['create_file'];
					}
					
					$this->create_image();
					$this->create_file_random('', $type);
					$this->create_path();
					
					$this->allowed_types_file();
					$allow = explode('|', $this->allowed_types);
					
					if(strlen($this->allowed_types) > 2 AND sizeof($allow) > 0){
						if(in_array($this->extension, $allow)){
							if($this->upload_file()){
								$this->set_error = 'Upload successfully';
								return true;
							}else{
								return false;
							}
						}else{
							$this->set_error = ''.$this->extension.' format not allowed..';
							return false;
						}
					}else{
						if($this->upload_file()){
							$this->set_error = 'Upload successfully';
							return true;
						}else{
							return false;	
						}
					}
				}else{
					$this->set_error = 'Your sent file is empty';
					return false;
				}
			}else{
				$this->set_error = 'File do not sent for upload';
				return false;
			}
	  }	
	}
	
	public function data(){
		return $this->return_data;
	}
	
	public function delete_file($file = ''){
		if(is_file($file)){
			unlink($file);
		}
	}
	
	public function delete_folder($getFolder = ''){
		if(strlen($getFolder) > 0){  
			$files = glob(''.$getFolder.'/*'); //get all file names
			foreach($files as $file){
				if(is_file($file))
				unlink($file); //delete file
			}
		}
	}
	
	/*
	public function upload($tmp, $path, $fileNameMain, $extension, $mxwidth, $mxsize=8388608, $mxheight, $center, $ratio,$type=''){
		
			if($extension=="jpg" || $extension=="jpeg" || $extension=="JPG" || $extension=="JPEG"){
				$image = ImageCreateFromJpeg($tmp);
			}else if($extension=="png" || $extension=="PNG"){
				$image = ImageCreateFromPng($tmp);
			}else if($extension=="gif" || $extension=="GIF"){
				$image = ImageCreateFromGif($tmp);
			}else{
				$image = ImageCreateFromJpeg($tmp);
			}
			
			list($width,$height)=getimagesize($tmp);
			if($type == 1){
				$file = $path.$fileNameMain.".".$extension;
			}else{
				$file = $path.$fileNameMain.".jpg";
			}
			
			
					
			$percent = 1;
			if(!$ratio){
				if($width > $mxwidth) 
					$percent = $mxwidth/$width;
			}else{
				if($width >= $height){
					if($width > $mxwidth) 
					$percent = $mxwidth/$width;
				}else if($width < $height){
					if($height > $mxheight) 
					$percent = $mxheight/$height;
				}
			}
		
			$new_width = $width * $percent;
			$new_height = $height * $percent;
			$image_height = $new_height;
			if($mxheight != NULL){
				$image_height = $new_height < $mxheight ? $new_height : $mxheight;
			}
			$height_position = 0;
			if($center){
				if($new_height > $mxheight){
					$height_position = $new_height/2 - $mxheight/2;
				}
			}
			
			$image_p = imagecreatetruecolor($new_width, $image_height);
			$white = imagecolorallocate($image_p, 255, 255, 255);
			imagefilledrectangle($image_p, 0, 0, $new_width, $image_height, $white);
			imagecopyresampled($image_p, $image, 0, -$height_position, 0, 0, $new_width, $new_height, $width, $height);
			//imagegif($image_p, $file, 100);
			imagejpeg($image_p, $file, 100);
			imagedestroy($image); 
			if($image){
				$mass = 1;
			}else{
				$mass = 0;
			}
		return $mass;				
		}
	public function uploadPng($tmp, $path, $fileNameMain, $extension, $mxwidth, $mxsize=8388608, $mxheight, $center, $ratio,$type=''){
		
			if($extension=="jpg" || $extension=="jpeg" || $extension=="JPG" || $extension=="JPEG"){
				$image = ImageCreateFromJpeg($tmp);
			}else if($extension=="png" || $extension=="PNG"){
				$image = ImageCreateFromPng($tmp);
			}else if($extension=="gif" || $extension=="GIF"){
				$image = ImageCreateFromGif($tmp);
			}else{
				$image = ImageCreateFromJpeg($tmp);
			}
			
			list($width,$height)=getimagesize($tmp);
			if($type == 1){
				$file = $path.$fileNameMain.".".$extension;
			}else{
				$file = $path.$fileNameMain.".jpg";
			}
			
			$percent = 1;
			if(!$ratio){
				if($width > $mxwidth) 
					$percent = $mxwidth/$width;
			}else{
				if($width >= $height){
					if($width > $mxwidth) 
					$percent = $mxwidth/$width;
				}else if($width < $height){
					if($height > $mxheight) 
					$percent = $mxheight/$height;
				}
			}
		
			$new_width = $width * $percent;
			$new_height = $height * $percent;
			$image_height = $new_height;
			if($mxheight != NULL){
				$image_height = $new_height < $mxheight ? $new_height : $mxheight;
			}
			$height_position = 0;
			if($center){
				if($new_height > $mxheight){
					$height_position = $new_height/2 - $mxheight/2;
				}
			}
			
			$im = imagecreatetruecolor($new_width, $image_height);
			$alpha_channel = imagecolorallocatealpha($im, 0, 0, 0, 127); 
			imagecolortransparent($im, $alpha_channel); 
			imagefill($im, 0, 0, $alpha_channel); 
			imagecopy($im,$image, 0, 0, 0, 0, $new_width, $image_height); 
			imagesavealpha($im,true); 
			imagepng($im,$file,9); 
			imagedestroy($im); 	
			if($image){
				$mass = 1;
			}else{
				$mass = 0;
			}
		return $mass;				
		}
	
	
	public function uploadWater($tmp, $path, $fileNameMain, $extension, $mxwidth, $mxsize=8388608, $mxheight, $center, $ratio,$type='',$water){
			if($extension=="jpg" || $extension=="jpeg" || $extension=="JPG" || $extension=="JPEG"){
				$image = ImageCreateFromJpeg($tmp);
			}else if($extension=="png" || $extension=="PNG"){
				$image = ImageCreateFromPng($tmp);
			}else if($extension=="gif" || $extension=="GIF"){
				$image = ImageCreateFromGif($tmp);
			}else{
				$image = ImageCreateFromJpeg($tmp);
			}
			
			list($width,$height)=getimagesize($tmp);
			if($type == 1){
				$file = $path.$fileNameMain.".".$extension;
			}else{
				$file = $path.$fileNameMain.".jpg";
			}
				$percent = 1;
			if(!$ratio){
				if($width > $mxwidth) 
					$percent = $mxwidth/$width;
			}else{
				if($width >= $height){
					if($width > $mxwidth) 
					$percent = $mxwidth/$width;
				}else if($width < $height){
					if($height > $mxheight) 
					$percent = $mxheight/$height;
				}
			}
		
			$new_width = $width * $percent;
			$new_height = $height * $percent;
			$image_height = $new_height;
			if($mxheight != NULL){
				$image_height = $new_height < $mxheight ? $new_height : $mxheight;
			}
			$height_position = 0;
			if($center){
				if($new_height > $mxheight){
					$height_position = $new_height/2 - $mxheight/2;
				}
			}
				
			$stamp = imagecreatefrompng($water);
			$im = imagecreatefromjpeg($tmp);
			if(imagesx($im)<600 || imagesy($im) <600)
			{
				return 1;
			}else{	
			$image_p = imagecreatetruecolor($new_width, $image_height);
			$white = imagecolorallocate($image_p, 255, 255, 255);
			imagefilledrectangle($image_p, 0, 0, $new_width, $image_height, $white);
			imagecopyresampled($image_p, $im, 0, -$height_position, 0, 0, $new_width, $new_height, $width, $height);
			$marge_right = 0;
			$marge_bottom = 0;
			$sx = imagesx($stamp);
			$sy = imagesy($stamp);
			imagecopy($image_p, $stamp, 0, imagesy($image_p) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
			imagejpeg($image_p,$file);
			imagedestroy($image_p);
			return SORT_LINK.'/'.$file;
		}
			
	}	
	public function watermark($imagePath){
		$image = ''.$this->host().'/application/watermark.php?image='.$imagePath.'&watermark='.$this->host().'/images/ko.png';
		return $image;
	}
	public function userWaterMark($imagePath,$wather){
		$image = ''.$this->host().'/application/watermark.php?image='.$imagePath.'&watermark='.$wather.'';
		return $image;
	}
  */
}
?>