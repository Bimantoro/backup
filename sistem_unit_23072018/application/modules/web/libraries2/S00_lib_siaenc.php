<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
	Author		: Wihikan Mawi Wijna
	Created		: 11:29 31 Oktober 2013 

	s00			: sia "kamar" 00, (s00, s01, s02, ..., s99)
	lib			: ct = controller, vw = view, mdl = model, lib = library
	api			: unique name {sesuai fungsi utama controller/view/model/library ini}
*/
class S00_lib_siaenc {
	public function cr0_ZIN(){ $c = '0c141fc101'; $h = 0; for($i = 0; $i < (strlen($c)/2); $i++){ $h += hexdec(substr($c,2*$i,2)); } return $h;}
	public function cr0_PV(){ $c = '643b'; $h = 0; for($i = 0; $i < (strlen($c)/2); $i++){ $h += hexdec(substr($c,2*$i,2)); } return $h;}
	public function cr0_HX($c = 'ff'){ $h = 0; for($i = 0; $i < (strlen($c)/2); $i++){ $h += hexdec(substr($c,2*$i,2)); } return $h;}
	public function cr0_z00($a){
	if($a < 0){ return $this->cr0_z02(($this->cr0_ZIN()-1), abs($a)); } else { return fmod($a, $this->cr0_ZIN()); }}
	public function cr0_z01($a, $b) { return $this->cr0_z00($this->cr0_z00($a)+$this->cr0_z00($b)); }
	public function cr0_z02($a, $b) { return $this->cr0_z00($this->cr0_z00($a)*$this->cr0_z00($b)); }
	public function cr0_z03($a, $b) { return $this->cr0_z00($this->cr0_z00($a)-$this->cr0_z00($b)); }
	public function cr0_z04($a) { if($this->cr0_z00($a) == 0){ return 0; }
		else { $a = $this->cr0_z00($a); $b = $this->cr0_ZIN(); $x = 0; $y = 1; $lx = 1; $ly = 0; $q = 0; $t1 = $t2 = 0; $t3 = 0; $i = 1;
		while($b!=0) {
		$q = floor($a/$b); $t1 = fmod($a,$b); $a = $b; $b = $t1;					
		$t2 = $x; $x = $lx-$q*$x; $lx = $t2; $t3 = $y; $y = $ly-$q*$y; $ly = $t3; $i++;
		} return $this->cr0_z00($lx);}}
	function cr0_z05($a, $b) { if($this->cr0_z00($b) == 0){ return 1; } else {	$h = 1;
			for($i = 0; $i < $this->cr0_z00($b); $i++){ $h = $this->cr0_z02($h, $a); } return $h; }}
	function cr0_h01($a){ if(strlen($a) < 2){ return '0'.$a; } else { return $a; }}
	function encrypt($msg1 = ''){ $CI =& get_instance(); $key1 = $this->cr0_HX($CI->config->item('sia_key'));
		$pk2 = $this->cr0_z05($key1,$this->cr0_PV());
		$enc	= ''; $en1 = '';
		for($j = 0; $j < strlen($msg1); $j++){ 
			$t1 = $this->cr0_z00(ord(substr($msg1,$j,1))-1);
			$r1 = mt_rand(1,$this->cr0_ZIN()-2);
			$g1 = $this->cr0_z05($key1,$r1);
			$g2 = $this->cr0_z02($t1,$this->cr0_z05($pk2,$r1));
			$enc .= strrev($this->cr0_h01(dechex($g1-1)).$this->cr0_h01(dechex($g2-1)));	
			$en1 .= "($g1,$g2) ";
		} #return array('t1' => $enc, 't2' => $en1, 't1l' => strlen($enc)); 
		return $enc; #echo $enc;
	}
	function decrypt($msg1 = ''){ $CI =& get_instance(); $key1 = $this->cr0_HX($CI->config->item('sia_key'));
		$msg1 = preg_replace("/[^0-9a-f]/", "", $msg1);
		if (fmod(strlen($msg1),4) != 0) {return md5($msg1.rand()); }
		else { $h = '';
		for($j = 0; $j < (strlen($msg1)/4); $j++){
			$t1 = $this->cr0_z05(hexdec(strrev(substr($msg1,(4*$j)+2,2)))+1,$this->cr0_PV());
			$t2 = $this->cr0_z02($this->cr0_z04($t1),hexdec(strrev(substr($msg1,(4*$j),2)))+1);
			$h .= chr($t2+1); 
		} return $h; }
	}
	
}