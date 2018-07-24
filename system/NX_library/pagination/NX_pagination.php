<?php
namespace NX\Pagination\Apps;
use NX\Pagination\InterfaceApps\NX_Pagination_interface AS NX_Pagination_interface;

class NX_Pagination Implements NX_Pagination_interface{
	
   private $pagination = ''; 
   public $css_link = 'system/NX_library/pagination/style/pagination.css'; 
	
   public function create_link(){
	  return $this->pagination;
   }
	
	public function initialize(array $pagiData){
       $offset_name = 'page';
       $offset = 1;
       $limit = 0;
       $total_count = 0;
	   if(array_key_exists('offset_name', $pagiData)){
			$offset_name =   $pagiData['offset_name'];
	   }

	  if(array_key_exists('offset', $pagiData)){
		$offset =   $pagiData['offset'];
	  }  
	  
	  if(array_key_exists('limit', $pagiData)){
		$limit =   $pagiData['limit'];
	  } 
	  if(array_key_exists('total_count', $pagiData)){
		$total_count =   $pagiData['total_count'];
	  } 
	  
	  
	 $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';   
	 if(array_key_exists('url', $pagiData)){
		$url =   $pagiData['url'];
	  }
	 $exp = explode('?', $url);
	 $expCount = sizeof($exp);
	 
	 if($expCount > 1){
		$setUrl = explode('?'.$offset_name.'=', $url);
		if(sizeof($setUrl) > 1){
			$athchUrl = $setUrl[0].'?'.$offset_name.'=';
		}else{
			$setUrl = explode('&'.$offset_name.'=', $url);
			$athchUrl = $setUrl[0].'&'.$offset_name.'=';
			
		}	
	 }else{
		$athchUrl = $url.'?'.$offset_name.'=';
	 }
		
	 $avg = ceil($total_count/$limit);	
	 
	 $ulClass = 'pagination';
	 if(array_key_exists('ul_class', $pagiData)){
		$ulClass =   $pagiData['ul_class'];
	 }
	 
	 $liClass = 'page-item';
	 if(array_key_exists('li_class', $pagiData)){
		$liClass =   $pagiData['li_class'];
	 }
	 
	 $aClass = 'page-link';
	 if(array_key_exists('a_class', $pagiData)){
		$aClass =   $pagiData['a_class'];
	 }
	 
	 $activeClass = 'active';
	 if(array_key_exists('active_class', $pagiData)){
		$activeClass =   $pagiData['active_class'];
	 }
	 
	 $preText = 'Prev';
	 if(array_key_exists('pre_text', $pagiData)){
		$preText =   $pagiData['pre_text'];
	 }
	 
	 $nextText = 'Next';
	 if(array_key_exists('next_text', $pagiData)){
		$nextText =   $pagiData['next_text'];
	 }
	 
	 $pagination = '';
	 $css = $this->css_link;
	 if(array_key_exists('css_link', $pagiData)){
		$css = $pagiData['css_link'];
	 }
	 $pagination .= '<link rel="stylesheet" href="'.$css.'" type="text/css">';
	 
	 $pagination .= '<ul class="'.$ulClass.'">';
		if($offset != 1){
			$pagination .= '<li class="'.$liClass.'"> <a class="'.$aClass.'" href="'.$athchUrl.''.($offset-1).'">'.$preText.'</a></li>';
		}
		
		$pag = 1;
		for($m = 1; $m <= $avg; $m++){
			$active = '';
			if($offset == $m){
				$active = $activeClass;
			}
			
			$start = $offset - 7;
			$end = $offset + 7;
			
			if(($start <= $m AND $end >= $m)){			
				$pagination .= '<li class="'.$liClass.' '.$active.'"><a class="'.$aClass.'" href="'.$athchUrl.''.$m.'">'.$m.'</a></li>';
				$pag++;
			}
		}
		
		if($offset != $avg){
			$pagination .= '<li class="'.$liClass.'"><a class="'.$aClass.'" href="'.$athchUrl.''.($offset+1).'">'.$nextText.'</a></li>';
		}
		
	 $pagination .= '</ul>';
         if($total_count > 0){
             $this->pagination = $pagination;
         }else{
             $this->pagination = '';
         }
         
	 
	 $setOffset = ($offset -1) * $limit;
	 return $setOffset;
   }
}
?>