<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekapitulasi extends CI_Controller {

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
		$data['title']="Informasi Jumlah Peserta Diterima";
		$data['json_url']=site_url('admin/rekaputilasi/menu_json');
		$data['rekapitulasi'] = $this->get_rekapitulasi();
		$data['main_view']="admin/rekapitulasi/data_rekapitulasi";
		$this->load->view('admin/content',$data);
   }



	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_rekapitulasi_diterima',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		if(!empty($data)){
				echo json_encode($data);
		}else{
			echo '0';
		}

		
        
        //echo $this->datatables->generate();
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
    	if($akses == 'Y000'){
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

	function add_prodi(){
		if($_POST==null){
			$data['title']="Input Data prodi";
			$data['main_view']="admin/prodi/menu_form";

			$data['fakultas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		 	$data['jenjang'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_jenjang',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

			$this->load->view('admin/content',$data);
		}else{
			$kd_prodi 	= $this->input->post('kode');
			$kd_fak 	= $this->input->post('fak');
			$nm_prodi 	= $this->input->post('nama');
			$jenjang 	= $this->input->post('jenjang');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_master_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_prodi, $kd_fak, $nm_prodi, $jenjang)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/prodi');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/prodi');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {

			$data['fakultas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		 	$data['jenjang'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_jenjang',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));
		 	
			$data['prodi'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data prodi";
			$data['main_view']="admin/prodi/edit_prodi";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_prodi	= $this->input->post('kode');
			$nm_prodi	= $this->input->post('nama');
			$jenjang	= $this->input->post('jenjang');

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_master_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_prodi, $nm_prodi, $jenjang)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/prodi');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/prodi');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_master_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/prodi');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/prodi');
		}

	}
	
}
 
/* End of file pengumuman.php */
