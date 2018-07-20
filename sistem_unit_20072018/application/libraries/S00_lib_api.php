<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
	Author		: Wihikan Mawi Wijna
	Created		: 11:51 04 Juni 2013 

	s00			: sia "kamar" 00, (s00, s01, s02, ..., s99)
	lib			: ct = controller, vw = view, mdl = model, lib = library
	api			: unique name {sesuai fungsi utama controller/view/model/library ini}
*/
class S00_lib_api {
	
	function convert_var_to_array($param){
		$hasil = array();
		foreach($param as $p_ => $v_){ if (substr($p_, 0, 3) == 'var'){ $hasil[] = $v_; }}
		return $hasil;
	}

	function is_api_ok(){
		$hasil = $this->get_api_json('http://service.uin-suka.ac.id/servsiasuper/index.php/sia_public/sia_sistem/database_error');
		if($hasil == false){ return array('status' => true); } else { return array('status' => false, 'err' => $hasil); } 
	}

	function parse_session($parameter){
		$CI =& get_instance();
		$param = $parameter;
		#$param['api_serv'] = 'a3IxNXR1NVw9LSFA';
		foreach ($param as $key => $value){
				if (is_array($param[$key])){
					$param[$key] = $this->parse_session($param[$key]);
				} else {
					preg_match('/<session.*?>(.*?)<\/session>/', $value, $matches);
					if(!empty($matches)){ $param[$key] = $CI->session->userdata($matches[1]); }
				}
			}
		#$param['akserv'] = $_SERVER['SERVER_NAME'];
		return $param;
	}
	
	function get_api_smtpendek($nim = '1000'){
		$CI =& get_instance();
		$nim = trim($nim);
		$api_url = 'http://service.uin-suka.ac.id/servsibayar/index.php/data/d_bayar_lain/bayar_lain_sp/nim/'.$nim.'/format/json';
		$hasil = $CI->curl->simple_get($api_url);
		return json_decode($hasil, true);
		/*
		$log_u	= "sia";
		$log_p	= "ais";
		$api_url= 'http://service.uin-suka.ac.id/servsibayar/index.php/data/d_bayar_lain/bayar_lain_sp/nim/'.$nim.'/format/json';
		$context = stream_context_create(array(
			'http' => array(
				'header'  => "Authorization: Basic " . base64_encode("$log_u:$log_p")
			)
		));
		$hasil 	= file_get_contents($api_url, false, $context);
		return json_decode($hasil,true);
		*/
	}
	
	function get_api_bayarkkn($nim = '1000'){
		$log_u	= "kkn";
		$log_p	= "kkn532";
		$api_url= "http://service.uin-suka.ac.id/servsibayar/index.php/data/d_bayar_lain/bayar_lain_by_nim_kd/nim/$nim/kd/100/format/json";
		$context = stream_context_create(array(
			'http' => array(
				'header'  => "Authorization: Basic " . base64_encode("$log_u:$log_p")
			)
		));
		$hasil 	= file_get_contents($api_url, false, $context);
		return json_decode($hasil,true);
	} 
	
	function get_api_simple($url, $parameter, $output='json', $postorget='POST'){
		$CI =& get_instance();
		$api_url = $url.'/'.$output;
		$hasil = null;
		
		//edit parameter
		//$parameter = { '51000_1', 'api_kodeprodi', 'api_kodeta'}
		$parameter_ = array();
		$i = 0; foreach ($parameter as $p){
			if ($i == 0){
				$pieces = explode("_", $p);
				$parameter_['api_kode'] = (int)$pieces[0];
				$parameter_['api_subkode'] = (int)$pieces[1];
			} else {
				$parameter_[$p] = $CI->input->post($p);
			}
			$i++;
		}
		
		$parameter_ = $this->parse_session($parameter_);
		
		$CI->curl->option('HTTPHEADER', array('HeaderName: '.$this->encrypt001(__FILE__)));
				
		if ($postorget == 'POST'){
			#$this->curl->post($parameter);
			$hasil = $CI->curl->simple_post($api_url,$parameter_);
		} else {
			$hasil = $CI->curl->simple_get($api_url);
		}
		return json_decode($hasil, true);
	}

function get_api($api_url, $postorget='GET', $parameter = array()){
		$CI =& get_instance();
		$hasil = null;
		$parameter = $this->parse_session($parameter);
		
		$CI->curl->option('HTTPHEADER', array('HeaderName: '.$this->encrypt001("diamankan")));
				
		if ($postorget == 'POST'){
			$hasil = $CI->curl->simple_post($api_url,$parameter);
		} else {
			$hasil = $CI->curl->simple_get($api_url);
		}
		return $hasil;
	}
	
	function get_api_json($api_url, $postorget='GET', $parameter = array()){
		$CI =& get_instance();
		$hasil = null;
		$parameter = $this->parse_session($parameter);
		
		$CI->curl->option('HTTPHEADER', array('HeaderName: '.$this->encrypt001("udinsia")));
		
		if ($postorget == 'POST'){
			$hasil = $CI->curl->simple_post($api_url,$parameter);
		} else {
			$hasil = $CI->curl->simple_get($api_url);
		}
				
		return json_decode($hasil, true);
	}

	function get_api_bayar($api_url, $postorget='GET', $parameter = array()){
		$CI =& get_instance();
		$username = $CI->config->item('bayar_name');
		$password = $CI->config->item('bayar_pass');
		$context = stream_context_create(array(
			'http' => array(
				'header'  => "Authorization: Basic " . base64_encode("$username:$password")
			)
		));
		$hasil = @file_get_contents($api_url,false,$context);
		return json_decode($hasil,true);
	}
	
	function get_api_jsob($api_url, $postorget='GET', $parameter = array()){
		$CI =& get_instance();
		$hasil = null;
		$parameter = $this->parse_session($parameter);
		
		$CI->curl->option('HTTPHEADER', array('HeaderName: '.$this->encrypt001("udinsia")));
					
		if ($postorget == 'POST'){
			$hasil = $CI->curl->simple_post($api_url,$parameter);
		} else {
			$hasil = $CI->curl->simple_get($api_url);
		}
				
		return json_decode($hasil, false);
	}
	
	function get_apiX($url, $output='json', $postorget='GET', $parameter){
		$api_url = 'http://10.0.8.105/apisia/index.php/sia_public/sia_public3/'.$url.'/format/'.$output;
		$hasil = null;
		
		$builder = http_build_query($parameter,'','&');
		
		$opts = array('http' =>
				array(
				'method'  => $postorget,
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $builder
				)
			);
		$hasil = false;
		$hasil = file_get_contents($api_url, false, stream_context_create($opts));
		$hasil = json_decode($hasil, true);
		return $hasil;
	}

	function get_apiO($url, $method, $method2, $parameter){
		$json_url = 'http://10.0.8.105/apisia/index.php/'.$url;
		
		$method_ = '/format/'.$method;
		$builder = http_build_query($parameter,'','&');
		
		$opts = array('http' =>
				array(
				'method'  => $method2,
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $builder
				)
			);
		$hasil = false;
		$hasil = file_get_contents($json_url.$method_, false, stream_context_create($opts));
		$hasil = json_decode($hasil, true);
		return $hasil;
	}


	function get_api2($url, $output='json', $postorget='GET', $parameter){
		$api_url = 'http://10.0.8.105/apisia/index.php/sia_mhs_public/sia_mahasiswa/'.$url;
		$hasil = null;
		
		if ($postorget == 'POST'){
			#$this->curl->post($parameter);
			$hasil = $this->curl->simple_post($api_url,$parameter);
		} else {
			$hasil = $this->curl->simple_get($api_url);
		}
		$hasil = json_decode($hasil, true);
		return $hasil;
	}
	
	function encrypt001($kata = ''){
		$CI =& get_instance();
		$CI->load->library('s00_lib_siaenc');
		return $CI->s00_lib_siaenc->encrypt($kata);
	}
	
	
	function decrypt001($kata = ''){
		$CI =& get_instance();
		$CI->config->set_item('encryption_key', $CI->config->item('api_key'));
		return $CI->encrypt->decode($kata);
	}

}