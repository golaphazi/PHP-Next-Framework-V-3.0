<?php
namespace NX\Html\Apps;
use NX\From\InterfaceApps\NX_From_interface AS NX_From_interface;
use NX\Input\InterfaceApps\NX_Input_interface AS NX_Input_interface;
use NX\Html\InterfaceApps\NX_Html_interface AS NX_Html_interface;

class htmlApps Implements NX_From_interface, NX_Input_interface, NX_Html_interface{
	
	private $result ='';
	private $label_for ='';
	private $element ='';
	/*===============
	* Connect Interface for From and Input Interface.............
	*================*/
	
	/**
	==================== Start Input Interface ===============
	**/
	public function input(array $element= array()){
			$this->result = '';
			if(is_array($element) AND sizeof($element) > 0){
				
				/**================
				** View label data
				===================**/
				if(array_key_exists('label', $element)){
					$this->label_for = 'label';
					
					if(is_array($element['label']) AND sizeof($element['label']) > 0){
						
						$this->result .= '<label ';
						
						$label_array = $element['label'];
						unset($label_array['data']);
						
						foreach($label_array AS $key=>$label_val):
							$this->result .= $key. '= "'.$label_val.'" ';
						endforeach;
						
						$this->result .= ' >';
						
						if(array_key_exists('data', $element['label'])){
							$this->result .= $element['label']['data'];
						}else{
							$this->result .= 'Label name:  please key insert "data" => value';
						}
						$this->result .= '</label>';
					}else{
						if(array_key_exists('id', $element)){
							$this->label_for = $element['id'];
						}
						$this->result .= '<label for="'.$this->label_for.'"> '.$element['label'].' </label>';
					}
					
					unset($element['label']);
				}
				
				/**================
				* View other input data
				===================**/
				$this->result .= '<input ';
				
				foreach($element AS $attr=>$value):
					
					$this->result .= $attr. '= "'.$value.'" ';
					
				endforeach;
				
				$this->result .= ' />';
			}
			
		return $this->result;
		}
	
	public function select(array $element= array()){		
			$optionData = '';
						
			if(is_array($element) AND sizeof($element) > 0){
				$optionData .= '<select ';
				foreach($element AS $key=>$main){
					if(!is_array($main) AND strtolower($key) != 'selected'){
						$optionData .= ' '.$key.' = "'.$main.'"';
					}else{
						$optionData .= '';
					}					
				}
				$optionData .= '>';
				if(array_key_exists('option', $element) AND is_array($element['option'])){
					foreach($element['option'] AS $option=>$value){
						if(is_array($value)){
							$optionData .= '<option value="'.$option.'" '.$value[1].'="'.$value[1].'"> '.$value[0].' </option>';
						}else if(array_key_exists('selected', $element)){
							if($element['selected'] == $option){
								$optionData .= '<option value="'.$option.'" selected="selected"> '.$value.' </option>';
							}else{
								$optionData .= '<option value="'.$option.'"> '.$value.' </option>';
							}
						}else{
							$optionData .= '<option value="'.$option.'"> '.$value.' </option>';
						}
					}
				}
				$optionData .= '</select>';
				
			}else{
				$optionData = '';
			}
			return $optionData;
		}
		
	public function radio(array $element= array()){
		$this->result = '';
		if(is_array($element) AND sizeof($element) > 0){
			$this->result = $this->radio_check($element,'radio');
		}
		return $this->result;
	}
		
	public function checkbox(array $element= array()){
		$this->result = '';
		if(is_array($element) AND sizeof($element) > 0){
			$this->result = $this->radio_check($element,'checkbox');
		}
		return $this->result;
	}
	
	public function radio_check(array $element= array(), $type){
	   $this->result = '';
	   $this->element = $element;
	   unset($this->element['checked']);
	   
	   $this->result .= '<input type="'.$type.'"';
	   
		   foreach($this->element AS $attr=>$value):
		   
				if(array_key_exists('checked', $element)){
					if($value == $element['checked']){
						$this->result .= 'checked="checked"';
					}
				}
				$this->result .= $attr. '= "'.$value.'" ';
				
		   endforeach;
		$this->result .= ' >';
	   return $this->result;
	}
	
	/**
	==================== Start Html Interface ===============
	**/
	
	public function label(array $element= array()){
		$this->result = '';
		$this->element = $element;
		unset($this->element['data']);
		if(is_array($this->element) AND sizeof($this->element) > 0){
			$this->result .= '<label ';
			foreach($this->element AS $attr=>$value){
				$this->result .= $attr. '= "'.$value.'" ';
			}
			$this->result .= '> ';
			if(array_key_exists('data', $element)){
				$this->result .= $element['data'];
			}
			$this->result .= ' </label>';
		}
		return $this->result;
	}
	
	public function button(array $element= array()){
		$this->result = '';
		$this->element = $element;
		unset($this->element['data']);
		if(is_array($this->element) AND sizeof($this->element) > 0):
			
		$this->result .= '<button ';
			foreach($this->element AS $attr=>$value):
				$this->result .= $attr. '= "'.$value.'" ';
			endforeach;
			$this->result .= '> ';
			if(array_key_exists('data', $element)){
				$this->result .= $element['data'];
			}
			$this->result .= ' </button>';
		endif;
		return $this->result;
	}
	
	public function dataList(array $element= array(), $refID=''){
		$this->result = '';
		if(is_array($element) AND sizeof($element) > 0){
			$this->result .= '<datalist id="'.$refID.'"> <select>';
			foreach($element AS $dataValue){
				$this->result .='<option value="'.$dataValue.'">';
			}
			$this->result .= ' </select></datalist>';
		}
		return $this->result;
	}
	
	public function html_add($element=''){
		if(strlen($element) > 0){
			return html_entity_decode($element);
			//return htmlspecialchars($element);
		}
	}
	
	public function html_remove($element=''){
		if(strlen($element) > 0){
			return strip_tags(html_entity_decode($element));
		}
	}
	
	public function html_view($element=''){
		if(strlen($element) > 0){
			return htmlspecialchars_decode($element);
		}
	}
	
	/**
	==================== Start Form Interface ===============
	**/
	public function form_start(array $element= array()){
		$this->result = '';
		$this->element = $element;
		unset($this->element['action']);
		
		if(is_array($this->element) AND sizeof($this->element) > 0){
			$this->result .= '<form ';
			if(array_key_exists('action', $element)){
				$this->result .= ' action="'.htmlspecialchars($element['action']).'"';
			}
			foreach($this->element as $attr=>$value){
				$this->result .= $attr. '= "'.$value.'" ';
			}
			$this->result .= ' >';
		}
		return $this->result;
	}
	
	public function form_close(){
		return '</form>';
	}

	public function get($name, $value='', $tag = false){
		$name = trim($name);
		if(strlen($name) > 0){
			$data = isset($_GET[$name]) ? $_GET[$name] : $value;
			if(is_array($data)){
				return $data;
			}else{
				return trim($data);
			}
		}
	}
	
	public function post($name, $value='', $tag = false){
		$name = trim($name);
		if(strlen($name) > 0){
			$data = isset($_POST[$name]) ? $_POST[$name] : $value;
			if(is_array($data)){
				return $data;
			}else{
				if($tag == true){
					return $this->html_remove(trim($data));
				}else{
					return trim($data);
				}
			}
		}
	}
	
	public function request($name, $value='', $tag = false){
		$name = trim($name);
		if(strlen($name) > 0){
			$data = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $value;
			if(is_array($data)){
				return $data;
			}else{
				if($tag == true){
					return $this->html_remove(trim($data));
				}else{
					return trim($data);
				}
			}
		}
	}
	
	public function server($name, $value='', $tag = false){
		$name = trim($name);
		if(strlen($name) > 0){
			$data = isset($_SERVER[$name]) ? $_SERVER[$name] : $value;
			if(is_array($data)){
				return $data;
			}else{
				if($tag == true){
					return $this->html_remove(trim($data));
				}else{
					return trim($data);
				}
			}
		}
	}
	
	
}


?>