<?php
namespace NX\Editor\Apps;
//use DBApps\NX_db as NX_db;
Class NX_Editor{
	
	/**** Editor ID Set***/
	public $NX_id = 'NX_id';
	
	/**** Editor class Set***/
	public $NX_class = 'NX_class';
	
	
	/**** Editor width Set***/
	public $NX_width = '700px';
	
	/**** Editor height Set***/
	public $NX_height = '300px';
	
	/**** Editor background color set Set***/
	public $NX_background = '#f5f5f5';
	public $NX_border = '#b7b6b6';
	
	/*****Editor body color****/
	public $NX_body_color = '#fff';
	
	
	/**** Default css set ***/
	private $NX_default_css = 'author/NX_editor/nextEditor';
	
	/**** Basic css set ***/
	private $NX_basic_css = 'author/NX_editor/nextEditorBasic';
	
	/**** Font css set ***/
	private $NX_font_css = 'author/NX_editor/nextEditorFont';
	
	
	/**** Default script set ***/
	private $NX_default_script = 'author/NX_editor/nextEditor';
	
	/**** Basic script set ***/
	private $NX_basic_script = 'author/NX_editor/nextEditorBasic';
	
	private $NX_normal_script = 'author/NX_editor/nextEditorNormal';
	
	/**** Font script set ***/
	private $NX_font_script = 'author/NX_editor/nextEditorFont';
	
	private $NX_math_script = 'author/NX_editor/nextEditorMath';
	
	
	/**** Default view set ***/
	private $NX_default_view = 'author/NX_editor/NX_editor';
	
	/**** Default basic set ***/
	private $NX_basic_view = 'author/NX_editor/NX_editor_basic';
	
	private $NX_normal_view = 'author/NX_editor/NX_editor_normal';
	
	/**** Default basic_font set ***/
	private $NX_basic_font_view = 'author/NX_editor/NX_editor_font';
	
	/**** Default math set ***/
	private $NX_basic_math_view = 'author/NX_editor/NX_editor_math';
	
	/**** Dynamic set css***/
	public $NX_css = array('');
	
	
	/**** Dynamic set script***/
	public $NX_script = array('');
	
	
	/**** Dynamic set script***/
	public $NX_type = 'default'; //font, basic, default, math
	
	
	/**** Dynamic set script***/
	public $NX_posittion = 'Top'; /*Top, Bottom*/
	
	
	/**Setup font **/
	public $NX_fonts = array('Arial', 'Tahoma', 'Monospace', 'Times New Roman', 'Consolas', 'Sans-Serif', 'Calibri');
	
	/*Set default font size*/
	public $NX_default_font_size = 0;
	
	/*Set default font family*/
	public $NX_default_font_family = 'Tahoma';
	
	/**Setup font size start**/
	private $NX_fonts_size_start = '1';
	
	/**Setup font size start**/
	private $NX_fonts_size_end = '9';
	
	/*Font header set*/
	private $headerFont = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
	
	private $NX_default_font_header = '';
	
	/**** Load db system***/
	public function __construct(){
		//parent::__construct();
	}
	
	/***Css set editor for default css**/
	public function NX_css_set(){
		
		return $this->NX_default_css;
	}
	
	/***Scirpt set editor for default Scirpt**/
	public function NX_script_set(){
		
		if($this->NX_type == 'basic'){
			return $this->NX_basic_script;
		}else if($this->NX_type == 'font'){
			return $this->NX_font_script;
		}else if($this->NX_type == 'normal'){
			return $this->NX_normal_script;
		}else if($this->NX_type == 'math'){
			return $this->NX_math_script;
		}else{
			return $this->NX_default_script;
		}
		
	}
	
	/***View  set editor for default View file**/
	public function NX_view_set(){
		if($this->NX_type == 'basic'){
			return $this->NX_basic_view;
		}else if($this->NX_type == 'normal'){
			return $this->NX_normal_view;
		}else if($this->NX_type == 'font'){
			return $this->NX_basic_font_view;
		}else if($this->NX_type == 'math'){
			return $this->NX_basic_math_view;
		}else{
			return $this->NX_default_view;
		}
		
	}
	
	
	public function viewEditor(){
		//$this->view($this->NX_view_set());
		include('system/NX_library/editor/view/'.$this->NX_view_set().'View.php');
	}

	/*Basic system method*/
	
	public function NX_font_basic(){
		$button = array();
		$button['<div class="eN aaA aaB"> </div>'] = array('id' => 'boldButton', 'title' => 'Bold', 'type' => 'button');
		$button['<div class="e3 aaA aaB"> </div>'] = array('id' => 'italicButton', 'title' => 'Italic', 'type' => 'button');
		$button['<div class="fu  aaA aaB"> </div>'] = array('id' => 'underlineButton', 'title' => 'Underline', 'type' => 'button');
		
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	/*First Button items for default items_default*/
	public function NX_font_math(){
		$button = array();
		$button['X<sup>2</sup>'] = array('id' => 'supButton', 'title' => 'Super script', 'type' => 'button');
		$button['X<sub>2</sub>'] = array('id' => 'subButton', 'title' => 'Sub script', 'type' => 'button');
		$button['<s>abc</s>'] = array('id' => 'strikeButton', 'title' => 'Strike Through', 'type' => 'button');
		
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
		
	}
	
	
	/*Align system method*/
	
	public function NX_align(){
		$button = array();
		$button['<div class="e4 aaA aaB"> </div>'] = array('id' => 'leftButton', 'title' => 'Left Align', 'type' => 'button');
		$button['<div class="eP aaA aaB"> </div>'] = array('id' => 'centerButton', 'title' => 'Center Align', 'type' => 'button');
		$button['<div class="fc aaA aaB"> </div>'] = array('id' => 'rightButton', 'title' => 'Right Align', 'type' => 'button');
		
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	
	/*Align system method*/
	
	public function NX_list(){
		$button = array();
		$button['<div class="e6 aaA aaB"> </div>'] = array('id' => 'orderedListButton', 'title' => 'Number List', 'type' => 'button');
		$button['<div class="eO aaA aaB"> </div>'] = array('id' => 'unorderedListButton', 'title' => 'Bulleted List', 'type' => 'button');
		
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	/*Align system method*/
	
	public function NX_undo(){
		$button = array();
		$button['&larr;'] = array('id' => 'undoButton', 'title' => 'Undo the previous action', 'type' => 'button', 'class' => 'right_icon undo');
		$button['&rarr;'] = array('id' => 'redoButton', 'title' => 'Redo', 'type' => 'button', 'class' => 'right_icon redo');
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	
	/*For font size method*/
	
	public function NX_font_size(){
		$fontSize = '';
		$fontSize .= '<select id="fontSizeChanger"><option value="1">Size</option>';
		
		for($font = $this->NX_fonts_size_start; $font < $this->NX_fonts_size_end; $font++){
			if($this->NX_default_font_size == $font){
				$fontSize .= '<option value="'.$font.'" selected>'.$font.'</option>';
			}else{
				$fontSize .= '<option value="'.$font.'">'.$font.'</option>';
			}
			
		}
		$fontSize .= '</select>';
		return $fontSize;
	}
	
	public function NX_font_family(){
		$fontFamily = '';
		$fontFamily .= '<select id="fontChanger">';
		foreach($this->NX_fonts AS $famiy){
			if($this->NX_default_font_family == $famiy){
				$fontFamily .= '<option value="'.$famiy.'" selected>'.$famiy.'</option>';
			}else{
				$fontFamily .= '<option value="'.$famiy.'">'.$famiy.'</option>';
			}
			
		}
		$fontFamily .= '</select>';
		return $fontFamily;
	}
	
	/*Font Header*/
	
	public function NX_font_header(){
		$fontHeader = '';
		$fontHeader .= '<select id="headingChanger"> <option>Heading</option>';
		foreach($this->headerFont AS $heade){
			if($this->NX_default_font_header == $heade){
				$fontHeader .= '<option value="'.$heade.'" selected>'.$heade.'</option>';
			}else{
				$fontHeader .= '<option value="'.$heade.'">'.$heade.'</option>';
			}
			
		}
		$fontHeader .= '</select>';
		return $fontHeader;
	}	
	
	/*Font Color set*/
	/*public function NX_font_colors($type='all'){
		
		$button = array();
		$button['<div class="eS aaA aaB"> </div><div class="arrow_link"></div>'] = array('id' => 'fontColorButton', 'title' => 'Font Color', 'type' => 'button');
		if($type == 'all'){
			$button['<div class="eS aaA aaB"> </div>'] = array('id' => 'highlightButton', 'title' => 'Highlight Text', 'type' => 'button');
		}
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	*/
	
	public function NX_font_colors($type='all'){
		$colors ='';
		$colorItem = array();
		$colorItem['fontColorButton'] = array('type' => 'color', 'class' => 'fontCOlor_hidden', 'title' => 'Font Color');
		if($type == 'all'){
			$colorItem['highlightButton'] = array('type' => 'color', 'title' => 'Highlight Text');
		}
		foreach($colorItem AS $id=>$valueArray):
			$colors .='<input id="'.$id.'"'; 
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$colors .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$colors .=' /> <span class="eS aaA aaB color_image"> </span>';
		endforeach;
		return $colors;
	}

	public function NX_imageSet($type='all'){
		$imagesItem = array();
		
		$imagesItem['<div class="eIm aaA aaB"> </div>'] = array('id' => 'imageButton', 'title' => 'Insert Image', 'type' => 'button');
		if($type == 'all'){
			$imagesItem['<div class="a1 aaA aMZ"> </div>'] = array('id' => 'fileButton', 'title' => 'File Upload', 'type' => 'button');
		}
		$button_re = '';
		foreach($imagesItem AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	public function NX_link(){
		$button = array();
		$button['<div class="e5 aaA aaB"> </div>'] = array('id' => 'linkButton', 'title' => 'Create Link', 'type' => 'button');
		$button['<div class="e5 aaA aaB clink-cross"> </div>'] = array('id' => 'unLinkButton', 'title' => 'Remove Link', 'type' => 'button');
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	public function NX_plus_mius(){
		$button = array();
		$button['<i class="fa fa-plus"></i>'] = array('id' => 'increaseButton', 'title' => 'Increase Font Size', 'type' => 'button');
		$button['<i class="fa fa-minus"></i>'] = array('id' => 'idecreaseButton', 'title' => 'Decrease Font Size', 'type' => 'button');
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	public function NX_paragraph_delete(){
		$button = array();
		$button['<b">P</b>'] = array('id' => 'paragraphButton', 'title' => 'Paragraph', 'type' => 'button');
		$button['<i class="fa fa-trash"></i>'] = array('id' => 'deleteButton', 'title' => 'Delete', 'type' => 'button');
		$button_re = '';
		foreach($button AS $id=>$valueArray):
			$button_re .='<button ';
			if(is_array($valueArray) AND sizeof($valueArray) > 0){
				foreach($valueArray AS $keyColor=>$keyValue):
					$button_re .= $keyColor.'="'.$keyValue.'" ';
				endforeach;
			}
			$button_re .=' /> '.$id.' </button>';
		endforeach;
		
		return $button_re;
	}
	
	
}
?>