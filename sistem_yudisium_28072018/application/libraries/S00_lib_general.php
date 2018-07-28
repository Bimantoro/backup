<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
	Author		: Wihikan Mawi Wijna
	Created		: 11:39 11 Juni 2013 

	s00			: sia "kamar" 00, (s00, s01, s02, ..., s99)
	lib			: ct = controller, vw = view, mdl = model, lib = library
	general		: unique name {sesuai fungsi utama controller/view/model/library ini}
*/
class S00_lib_general {
	
	public function __construct(){
        $CI =& get_instance();
		$CI->load->library('00_share/s00_lib_sh_menu');
		
		#$CI->load->library('02_mahasiswa/s02_lib_menu','','sb_menu2');
		$CI->load->library('03_dosen/s03_lib_menu','','sb_menu3');
		#$CI->load->library('04_staff/s04_lib_menu','','sb_menu4');
		#$CI->load->library('05_wali/s05_lib_menu','','sb_menu5');
	}
	
	function _is_contain_true($arr){
		$CI =& get_instance();
		$hasil = false;
		$akses = $CI->session->userdata('jabatan');
		foreach($arr as $arr_){ if (preg_match('/'.$arr_.'/',$akses)) { $hasil = true; break; }}	
		return $hasil;
	}
	
	function _is_contain_true2($arr){
		$CI =& get_instance();
		$hasil = 'NO';
		$akses = $CI->session->userdata('jabatan');
		foreach($arr as $arr_){ if (preg_match('/'.$arr_.'/',$akses)) { $hasil = 'YA'; break; }}	
		return $hasil;
	}
	
	function _is_contain_false($arr){
		$CI =& get_instance();
		$hasil = true;
		$akses = $CI->session->userdata('jabatan');
		foreach($arr as $arr_){ if (preg_match('/'.$arr_.'/',$akses)) { $hasil = false; break; }}	
		return $hasil;
	}
	
	
	
	
	//
}