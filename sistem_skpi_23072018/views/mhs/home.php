<?php
	$arr1 = array(	'app_text' 	=> 'Surat Keterangan Pendamping Ijazah', 
					'app_name' 	=> echo $string_skpi[0].' Mahasiswa', 
					'app_url'	=> 'skpi/skpi_mhs/');

	$this->s00_lib_output->output_frontpage_mhs($arr1);
?>