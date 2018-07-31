<?php

class Yud_public extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('yudisium/yud_basic', 'mdl_00');
		$this->yud = $this->load->database('yudisium2', TRUE);
	}
	
	function index(){
		echo "testing";
	}

	function test($format = 'json'){
		$q = $this->mdl_00->test();
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER JALUR

	function in_master_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_jalur($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_jalur($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_jalur($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_jalur($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_jalur($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_jalur();
		$this->sia_api_lib_format->output($q, $format);
	}

	function get_available_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_available_jalur($api_search[0]);
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER UJIAN

	function in_master_ujian($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_ujian($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_ujian($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_ujian($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_ujian($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_ujian($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_ujian($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_ujian($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_ujian($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_ujian();
		$this->sia_api_lib_format->output($q, $format);
	}

	function get_available_ujian($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_available_ujian($api_search[0], $api_search[1], $api_search[2]);
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER KELAS

	function in_master_kelas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_kelas($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_kelas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_kelas($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_kelas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_kelas($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_kelas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_kelas($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_kelas($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_kelas();

		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER JENJANG

	function in_master_jenjang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_jenjang($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_jenjang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_jenjang($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_jenjang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_jenjang($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_jenjang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_jenjang($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_jenjang($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_jenjang();
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER FAKULTAS

	function in_master_fakultas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_fakultas($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_fakultas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_fakultas($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_fakultas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_fakultas($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_fakultas($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_fakultas($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_fakultas($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_fakultas();
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER PRODI

	function in_master_prodi($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_prodi($api_search[0], $api_search[1], $api_search[2], $api_search[3]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_prodi($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_prodi($api_search[0], $api_search[1], $api_search[2]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_prodi($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_prodi($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_prodi($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_prodi($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_prodi_by_fak($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_prodi_by_fak($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_prodi_fak_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_prodi_fak_jalur($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_prodi_multifak_jalur($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_prodi_multifak_jalur($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_prodi($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_prodi();
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER AKUN

	function in_data_akun($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_data_akun($api_search[0], $api_search[1], $api_search[2]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_data_akun($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_data_akun($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_data_akun($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_data_akun($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_data_akun($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_data_akun($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_data_akun($format = 'json'){
		$q 			= $this->mdl_00->get_all_data_akun();
		$this->sia_api_lib_format->output($q, $format);
	}

	//MASTER GELOMBANG

	function in_master_gelombang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_master_gelombang($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_master_gelombang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_master_gelombang($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_master_gelombang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_master_gelombang($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_master_gelombang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_master_gelombang($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_master_gelombang($format = 'json'){
		$q 			= $this->mdl_00->get_all_master_gelombang();
		$this->sia_api_lib_format->output($q, $format);
	}


	function get_available_gelombang($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_available_gelombang($api_search[0], $api_search[1]);
		$this->sia_api_lib_format->output($q, $format);
	}

	//CONFIG BOBOT

	function in_cfg_bobot($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			 = $this->mdl_00->in_cfg_bobot($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_cfg_bobot($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_cfg_bobot($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function del_cfg_bobot($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->del_cfg_bobot($api_search[0], $api_search[1], $api_search[2], $api_search[3]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_cfg_bobot($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_cfg_bobot($api_search[0], $api_search[1], $api_search[2], $api_search[3]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_all_cfg_bobot($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_all_cfg_bobot();

		$this->sia_api_lib_format->output($q, $format);
	}

	//CONFIG PILIHAN

	function in_cfg_pilihan($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->in_cfg_pilihan($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4], $api_search[5], $api_search[6], $api_search[7], $api_search[8], $api_search[9], $api_search[10]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_cfg_pilihan($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q = $this->mdl_00->up_cfg_pilihan($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4], $api_search[5], $api_search[6], $api_search[7], $api_search[8], $api_search[9], $api_search[10]);
		$this->sia_api_lib_format->output($q, $format);

	}

	function del_cfg_pilihan($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q = $this->mdl_00->del_cfg_pilihan($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4]);
		$this->sia_api_lib_format->output($q, $format);
	}

	function get_cfg_pilihan($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q = $this->mdl_00->get_cfg_pilihan($api_search[0], $api_search[1], $api_search[2]);
		$this->sia_api_lib_format->output($q, $format);

	}

	function get_all_cfg_pilihan($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_all_cfg_pilihan();

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_cfg_pilihan_by_date($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_cfg_pilihan_by_date($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);

	}

	function get_cfg_pilihan_current($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_cfg_pilihan_by_date();

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_cfg_pilihan_aktif($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_cfg_pilihan_aktif($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}



	function get_data_peserta_prodi($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_data_peserta_prodi($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_data_peserta_prodi2($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_data_peserta_prodi2($api_search[0], $api_search[1], $api_search[2]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_data_yudisium($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_data_yudisium($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_data_yudisium2($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_data_yudisium2($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4], $api_search[5]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_status_diterima($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_status_diterima($api_search[0], $api_search[1]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function up_status_diterima_prodi($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->up_status_diterima_prodi($api_search[0], $api_search[1], $api_search[2], $api_search[3]);

		$this->sia_api_lib_format->output($q, $format);
	}
	

	function get_detail_nilai_ujian($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_detail_nilai_ujian($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}

	function get_rekapitulasi_diterima($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_rekapitulasi_diterima($api_search[0]);

		$this->sia_api_lib_format->output($q, $format);
	}


	function get_data_peserta_diterima($format = 'json'){
		$api_search = $this->input->post('api_search');
		$q 			= $this->mdl_00->get_data_peserta_diterima($api_search[0], $api_search[1], $api_search[2], $api_search[3], $api_search[4]);

		$this->sia_api_lib_format->output($q, $format);
	}


	
	
}