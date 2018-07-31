<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pilihan extends CI_Controller {

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

		// if($this->session->userdata('level') != 'Y000' || $this->session->userdata('level') != 'Y002'){
		// 	redirect(base_url('admin/main/dash'));
		// }
	}
 
   public function index($uri=0){
		$data['title']="Pengaturan Pilihan";
		$data['json_url']=site_url('admin/pilihan/menu_json');
		$data['main_view']="admin/pilihan/data_pilihan";
		$this->load->view('admin/content',$data);
   }

	
 	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		if(!empty($data)){
			$temp_data = array();
			foreach ($data as $d) {
				$curr_date = date('Y-m-d');
				if($d['tgl_mulai'] <= $curr_date && $d['tgl_selesai'] >= $curr_date){
					$d['status'] = 'AKTIF';
				}else{
					$d['status'] = 'TIDAK AKTIF';
				}

				$temp_data[] = $d;
			}

			$data = $temp_data;
			echo json_encode($data);
		}else{
			echo '0';
		}

		
        
        //echo $this->datatables->generate();
    }
	function add_pilihan(){
		if($_POST==null){
			$data['title']="Input Pengaturan Pilihan";

			//$tmp_tahun = date('Y');
			for ($i=0; $i < 5; $i++) { 
				$data['tahun'][] = date('Y') + $i;
			}

			$data['jalur'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));


			$data['gelombang'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

			$data['kelas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));


			$data['main_view']="admin/pilihan/menu_form";
			$this->load->view('admin/content',$data);
		}else{

			$tahun 	= $this->input->post('tahun');
			$jalur 	= $this->input->post('jalur');
			$gel 	= $this->input->post('gelombang');
			$kelas 	= $this->input->post('kelas');
			$pilihan 	= $this->input->post('pilihan');
			$mulai 	= $this->input->post('mulai');
			$selesai 	= $this->input->post('selesai');
			$noyud 	= $this->input->post('noyud');
			$ketua 	= $this->input->post('ketua');
			$tglyud 	= $this->input->post('tgl_yud');
			$tempat 	= $this->input->post('tempat');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gel, $kelas, $pilihan, $mulai, $selesai, $noyud, $ketua, $tglyud, $tempat)
		 	));


			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/pilihan');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/pilihan');
			}
		}	
	}
	function edit($tahun="", $jalur = "", $gelombang = "", $kelas = "", $pilihan = ""){
		if($_POST==NULL) {
			
			for ($i=0; $i < 5; $i++) { 
				$data['tahun'][] = date('Y') + $i;
			}

			$data['jalur'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));


			$data['gelombang'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

			$data['kelas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		 	$data['pilihan'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gelombang, $kelas, $pilihan)
		 	));


			$data['title']="Edit Pengaturan Pilihan";
			$data['main_view']="admin/pilihan/edit_pilihan";
			$this->load->view('admin/content',$data);
		}else{

			$tahun 	= $this->input->post('tahun');
			$jalur 	= $this->input->post('jalur');
			$gel 	= $this->input->post('gelombang');
			$kelas 	= $this->input->post('kelas');
			$pilihan 	= $this->input->post('pilihan');
			$mulai 	= $this->input->post('mulai');
			$selesai 	= $this->input->post('selesai');
			$noyud 	= $this->input->post('noyud');
			$ketua 	= $this->input->post('ketua');
			$tglyud 	= $this->input->post('tgl_yud');
			$tempat 	= $this->input->post('tempat');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gel, $kelas, $pilihan, $mulai, $selesai, $noyud, $ketua, $tglyud, $tempat)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/pilihan');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/pilihan');
			}
		}			
	}

	function delete($tahun="", $jalur = "", $gelombang = "", $kelas = "", $pilihan = ""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gelombang, $kelas, $pilihan)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/pilihan');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/pilihan');
		}

	}
	
}
 
/* End of file pengumuman.php */
