<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Page_lib {
	
	function lang(){
		$CI =& get_instance();
		$lang=$CI->uri->segment(1);
		if($lang){
			if($lang=='v2016')$lang='id';
			return $lang;
			
		}else{
			return 'id';	
		}	
	}	
	
}