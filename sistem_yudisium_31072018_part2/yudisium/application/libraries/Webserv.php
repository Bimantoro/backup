<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Webserv {
	
	function web_post($module="",$postdata=array()){
		$CI =& get_instance();
		$username = 'admin';
		$password = '1234';
		 
		$CI->load->library('curl');
		 
		$CI->curl->create('http://service2.uin-suka.ac.id/servweb/index.php/universitas/'.$module);
	   
		$CI->curl->http_login($username, $password);
		
		$CI->curl->post($postdata);
		$result = json_decode($CI->curl->execute());
	  return $result;
	}	
	
	function bkd_post($module="",$postdata=array()){
		$CI =& get_instance();
		$username = 'admin';
		$password = '1234';
		 
		$CI->load->library('curl');
		 
		$CI->curl->create('http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/'.$module);
	   
		$CI->curl->http_login($username, $password);
		
		$CI->curl->post($postdata);
		$result = json_decode($CI->curl->execute());
	  return $result;
	}
}