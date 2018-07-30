<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

	function dict($str="",$lang=""){
		$CI =& get_instance();
		$lang=$CI->page_lib->lang(); 
		if($lang=='id'){
				return $str;
		}else{	
		$trans=$CI->db->get_where('kamus',array('kata'=>$str))->row();
		$ar_str=array(
		'Beranda'=>'Home',
		'profil'=>'profile',
		'pendaftaran'=>'admission',
		'pelayanan'=>'services',
		'direktori'=>'directories',
		'berita'=>'news',
		'liputan'=>'news',
		'agenda'=>'events',
		'pengumuman'=>'announcements',
		'aturku'=>'article',
		'selengkapnya'=>'more',
		'lainnya'=>'Others',
		'fakultas'=>'faculty',
		'Info Jurusan / Program Studi'=>'Department Information'
		);
		return $trans->terjemahan;
		}
	}
	if ( ! function_exists('get_prodi')){
	function get_prodi(){
		$d=explode('.',str_replace('http://','',base_url()));
		
		//$dom="pmi";
		$dom=$d[0];
		$url='http://www.uin-suka.ac.id/index.php/service/get_prodi/'.$dom;
		$data=file_get_contents($url);
		$data=json_decode($data);
		foreach($data as $d){ 
			$kd_prodi=$d->kd_prodi;
		}
		return $kd_prodi;	
	}
}
if ( ! function_exists('get_nm_prodi')){
	function get_nm_prodi(){
		$d=explode('.',str_replace('http://','',base_url()));
		
		//$dom="pmi";
		$dom=$d[0];
		$url='http://www.uin-suka.ac.id/index.php/service/get_prodi/'.$dom;
		$data=file_get_contents($url);
		$data=json_decode($data);
		foreach($data as $d){ 
			$nm_prodi=$d->nm_prodi;
		}
		return $nm_prodi;	
	}
}

   function aasort(&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}
function format_nip($str){
		return substr($str,0,8).' '.substr($str,8,6).' '.substr($str,14,1).' '.substr($str,15,3);
	}
function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}