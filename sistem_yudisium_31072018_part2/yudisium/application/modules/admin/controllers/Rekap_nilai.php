<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_nilai extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		// $this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		// $this->load->model('admin/page_model');
		is_logged_in();
		$this->data['ckeditor'] = array(
			'id' 	=> 	'isi1',
			'path'	=>	'asset/ckeditor',
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"100%",	//Setting a custom width
				'height' 	=> 	'300px',	//Setting a custom height
			),	
		);
	}
 
   public function index($uri=0){
		$data['title']="Informasi Rekapitulasi Nilai Ujian";
		$data['json_url']=site_url('admin/rekap_nilai/get_rekap_nilai');
		$data['jalur'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));
		$data['main_view']="admin/rekap_nilai/data_rekap_nilai";
		$this->load->view('admin/content',$data);
   }




    function get_rekap_nilai(){
    	$jalur = $this->input->post('jalur');
    	// $jalur = '82';

    	$aktif = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_cfg_pilihan_aktif',
		 	'POST',
		 	array(
		 		'api_search' => array($jalur)
		 	));

    	if(!empty($aktif)){
    		$tahun = $aktif[0]['tahun'];
    		$gel   = $aktif[0]['kode_gelombang'];

    		$nilai = $this->s00_lib_api->get_api_json(
				URL_API_YUD.'yud_public/get_rekap_nilai_ujian',
			 	'POST',
			 	array(
			 		'api_search' => array($tahun, $gel, $jalur)
			 	));
    		if(!empty($nilai)){
    			echo json_encode($nilai);
    		}else{
    			echo '0';
    		}
    	}else{
    		echo '0';
    	}

    }

    function get_rekapitulasi(){
    	$fakultas = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));


    	$rekap = array();

    	$akses  = $this->session->userdata('level');
    	$kd_fak = $this->session->userdata('kd_fak');
    	if($akses == 'Y000' || $akses == 'Y002'){
    		foreach ($fakultas as $f) {
    			$temp = $this->s00_lib_api->get_api_json(
				URL_API_YUD.'yud_public/get_rekapitulasi_diterima',
			 	'POST',
			 	array(
			 		'api_search' => array($f['kode_fakultas'])
			 	));

    			$rekap[$f['kode_fakultas']]['nama_fakultas'] = $f['nama_fakultas'];
			 	$rekap[$f['kode_fakultas']][] = $temp;
    		}
    	}else{
    		foreach ($fakultas as $f) {
    			foreach ($kd_fak as $ff => $kk) {
    				if($f['kode_fakultas'] == $kk){
	    				$temp = $this->s00_lib_api->get_api_json(
						URL_API_YUD.'yud_public/get_rekapitulasi_diterima',
					 	'POST',
					 	array(
					 		'api_search' => array($f['kode_fakultas'])
					 	));

					 	$rekap[$f['kode_fakultas']]['nama_fakultas'] = $f['nama_fakultas'];
					 	$rekap[$f['kode_fakultas']][] = $temp;
		    		}
    			}
    		}
    	}
    	

    	return $rekap;
    }
	
}
 
/* End of file pengumuman.php */
