<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Akreditasi_serv {
	function akreditasi_post($module="",$postdata=array()){
		$CI =& get_instance();
		$username = 'admin';
		$password = '1234';
		$CI->load->library('curl');
		$CI->curl->create('http://service.uin-suka.ac.id/servakreditasi/index.php/akreditasi/'.$module);
	   $CI->curl->http_login($username, $password);
		
		$CI->curl->post($postdata);
		$result = json_decode($CI->curl->execute());
	  return $result;
	}
}