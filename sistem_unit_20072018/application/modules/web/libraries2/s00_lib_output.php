<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
	Author		: Wihikan Mawi Wijna
	Created		: 13:13 31/05/2013 

	s00			: sia "kamar" 00, (s00, s01, s02, ..., s99)
	lib			: ct = controller, vw = view, mdl = model, lib = library
	output		: unique name {sesuai fungsi utama controller/view/model/library ini}
*/
class S00_lib_output {
	
	function output_display($category = 'main', $data_ = array()){
		$CI =& get_instance();
		
		#$CI->load->library('02_mahasiswa/s02_lib_menu','','sb_menu2');
		#echo $CI->s02_lib_menu->hei();
		
		#$data_['sia_919191_category'] = $category;
		if(!isset($data_['app_category'])){
			$pieces = explode('/', $category);
			if (isset($pieces[0])) { $data_['app_category'] = $pieces[0]; } #.'/'.$pieces[1]; $pieces[0].'/'.$pieces[1];
			if (isset($pieces[1])) { $data_['app_subcategory'] = $pieces[1]; }
			#$data_['submenu_02mhs_2013'] = $CI->sb_menu2->pack_menu();
		}
		$CI->load->view('s00_vw_all',array('in_cat' => $category, 'in_data' => $data_));
	}
	
	function output_error($category = 'main', $data_ = array()){
		$CI =& get_instance();
		$data_['sia_919191_category'] = $category;
		$CI->load->view('s00_vw_all',array('data' => $data_));
	}
	

	function output_blank($category = 'main', $data_ = array()){
		print_r($data_);
	}
	
	function output_info_mhs(){
		$CI =& get_instance();
		$data1 = array();
		
		$data1['log_portal']	= $CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_procedure', 
								'POST', array('api_kode'=>101001, 'api_subkode' => 2, 
								'api_datapost' => array($CI->session->userdata('id_user'))));
				
		if($CI->session->userdata('status') == 'wali'){
			
			$data1['log_wali']= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 
									'POST', array('api_kode'=>101001, 'api_subkode' => 1, 
									'api_search' => array($CI->session->userdata('id_user').'w')));
			
			$data1['log_portal']['data'][':log_ip'] 		= $data1['log_wali'][0]['LOG_IPWEB_PREV'];
			$data1['log_portal']['data'][':log_tgl'] 		= $data1['log_wali'][0]['LOG_TGL_PREV_F'];
			$data1['log_portal']['data'][':log_count'] 	= $data1['log_wali'][0]['LOG_COUNT'];
			
			#print_r($data1); die();
		} 
		
		$CI->load->view('00_share/def/a00_vw_info_mhs', array('data' => $data1));
	}
	
	function output_info_dsn(){
		$CI =& get_instance();
		$data1 = array();
		
		$data1['log_portal']	= $CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_procedure', 
								'POST', array('api_kode'=>101001, 'api_subkode' => 3, 
								'api_datapost' => array($CI->session->userdata('id_user'))));
		
		$CI->load->view('00_share/def/a00_vw_info_dsn', array('data' => $data1));
	}
	
	function output_crumbs($data = array(), $output = true, $id = 'crumbs'){
		#<ul id="crumbs"><li><a href="http://alumni.uin-suka.ac.id/">Beranda</a></li><li>Peserta Wisuda</li></ul>
		$hasil 	= '<ul id="'.$id.'">';
		foreach($data as $d){ foreach($d as $k1 => $v1){
			if ($v1 != ''){
				$hasil .= '<li>'.anchor($v1, $k1, 'title="'.$k1.'"').'</li>';
			} else {
				$hasil .= '<li>'.$k1.'</li>';
			}
		}}
		$hasil 	.= '</ul>';
		#echo $hasil;
		if($output){ echo $hasil; } else { return $hasil; }
	}
	
	function output_frontpage_mhs($datax = array()){
		//$data1 = array('app_text','app_name','app_url')
		
		if(!isset($datax['app_text'])){ $datax['app_text'] = ''; }
		if(!isset($datax['app_name'])){ $datax['app_name'] = 'Aplikasi SIA'; }
		if(!isset($datax['app_url'])){ $datax['app_url'] = ''; }
				
		$CI =& get_instance();
		$data = array();
		
		$data['datax'] 		= $datax;
		$data['crumbs']		= array(array($datax['app_name'] => $datax['app_url']));
		
		#$this->arr_crumbs;
		
		$data['log_portal']	= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 
								'POST', array('api_kode'=>101001, 'api_subkode' => 1, 
								'api_search' => array($CI->session->userdata('id_user'))));
		
		$data['pengumuman1']= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_pengumuman/data_search', 
								'POST', array('api_kode'=>88001, 'api_subkode' => 5, 'api_search' => array('MHS')));
		
		$data['url_d1'] 	= 	$CI->s00_lib_sh_menu->build_url_var('v0b0', '%LINK%', 'informasi');
				
		$CI->load->view('00_share/def/a00_vw_pengumuman2013_muka01', array('data' => $data));
	}
	
	function output_frontpage_dsn($datax = array()){
		//$data1 = array('app_text','app_name','app_url')
		
		if(!isset($datax['app_text'])){ $datax['app_text'] = ''; }
		if(!isset($datax['app_name'])){ $datax['app_name'] = 'Aplikasi SIA'; }
		if(!isset($datax['app_url'])){ $datax['app_url'] = ''; }
				
		$CI =& get_instance();
		$data = array();
		
		$data['datax'] 		= $datax;
		$data['crumbs']		= array(array($datax['app_name'] => $datax['app_url']));
		
		#$this->arr_crumbs;
		
		$data['log_portal']	= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 
								'POST', array('api_kode'=>101001, 'api_subkode' => 1, 
								'api_search' => array($CI->session->userdata('id_user'))));
		
		$data['pengumuman1']= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_pengumuman/data_search', 
								'POST', array('api_kode'=>88001, 'api_subkode' => 5, 'api_search' => array('DSN')));
		
		$data['url_d1'] 	= 	$CI->s00_lib_sh_menu->build_url_var('v0b0', '%LINK%', 'informasi');
				
		$CI->load->view('00_share/def/a00_vw_pengumuman2013_muka03', array('data' => $data));
	}
	
	function output_frontpage_wali($datax = array()){
		//$data1 = array('app_text','app_name','app_url')
		
		if(!isset($datax['app_text'])){ $datax['app_text'] = ''; }
		if(!isset($datax['app_name'])){ $datax['app_name'] = 'Aplikasi SIA'; }
		if(!isset($datax['app_url'])){ $datax['app_url'] = ''; }
				
		$CI =& get_instance();
		$data = array();
		
		$data['datax'] 		= $datax;
		$data['crumbs']		= array(array($datax['app_name'] => $datax['app_url']));
		
		#$this->arr_crumbs;
		
		$data['log_portal']	= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 
								'POST', array('api_kode'=>101001, 'api_subkode' => 1, 
								'api_search' => array($CI->session->userdata('id_user').'w')));
		
		$data['pengumuman1']= 	$CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_pengumuman/data_search', 
								'POST', array('api_kode'=>88001, 'api_subkode' => 5, 'api_search' => array('WLI')));
		
		$data['url_d1'] 	= 	$CI->s00_lib_sh_menu->build_url_var('v0b0', '%LINK%', 'informasi');
				
		$CI->load->view('00_share/def/a00_vw_pengumuman2013_muka02', array('data' => $data));
	}
}
