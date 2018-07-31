<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bobot extends CI_Controller {

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
		$data['title']="Pengaturan Bobot Nilai";
		$data['json_url']=site_url('admin/bobot/menu_json');
		$data['main_view']="admin/bobot/data_bobot";
		$this->load->view('admin/content',$data);
   }

	
 	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_cfg_bobot',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		if(!empty($data)){
			$tahun 		= '0';
			$jalur 		= '0';
			$gelombang 	= '0';

			$bobot = array();
			$i = 0;
			$p = 0;
			foreach ($data as $d) {
				if($tahun == $d['tahun'] and $jalur == $d['kode_jalur'] and $gelombang == $d['kode_gelombang']){
					$bobot[$p]['bobot'][] =  array(
								'kode_ujian' => $d['kode_ujian'],
								'bobot_ujian' => $d['nama_ujian']." : ".$d['bobot']." %"
							);
				}else{

					$p = $i;

					$tahun = $d['tahun']; $jalur = $d['kode_jalur']; $gelombang = $d['kode_gelombang'];

					$bobot[$i] = array(
						'tahun' => $d['tahun'],
						'kode_jalur' => $d['kode_jalur'],
						'nama_jalur' => $d['nama_jalur'],
						'kode_gelombang' => $d['kode_gelombang'],
						'nama_gelombang' => $d['nama_gelombang'],
						'bobot' => array(array(
								'kode_ujian' => $d['kode_ujian'],
								'bobot_ujian' => $d['nama_ujian']." : ".$d['bobot']." %"
							))
					);

					$i++;
				}
			}

			echo json_encode($bobot);
		}else{
			echo '0';
		}

		
        
        //echo $this->datatables->generate();
    }
	function add_bobot(){
		if($_POST==null){
			$data['title']="Input Pengaturan Bobot";

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

			$data['ujian'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_ujian',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));


			$data['main_view']="admin/bobot/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$tahun 	= $this->input->post('tahun');
			$jalur 	= $this->input->post('jalur');
			$gel 	= $this->input->post('gelombang');
			$ujian 	= $this->input->post('ujian');
			$bobot 	= $this->input->post('bobot');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_cfg_bobot',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gel, $ujian, $bobot)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/bobot');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/bobot');
			}
		}	
	}
	function edit($tahun="", $jalur = "", $gelombang = "", $ujian = ""){
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

			$data['ujian'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_ujian',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		 	$data['bobot'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_cfg_bobot',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gelombang, $ujian)
		 	));


			$data['title']="Edit Pengaturan Bobot";
			$data['main_view']="admin/bobot/edit_bobot";
			$this->load->view('admin/content',$data);
		}else{

			$tahun 	= $this->input->post('tahun');
			$jalur 	= $this->input->post('jalur');
			$gel 	= $this->input->post('gelombang');
			$ujian 	= $this->input->post('ujian');
			$bobot 	= $this->input->post('bobot');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_cfg_bobot',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gel, $ujian, $bobot)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/bobot');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/bobot');
			}
		}			
	}

	function delete($tahun="", $jalur = "", $gelombang = "", $ujian = ""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_cfg_bobot',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gelombang, $ujian)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/bobot');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/bobot');
		}

	}

	//ini untuk ajax :
	function get_ajax_jalur_tersedia(){
		$tahun = $this->input->post('tahun');

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_available_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun)
		 	));

		if($data){
			echo json_encode($data);
		}else{
			echo '0';
		}
	}

	function get_ajax_gelombang_tersedia(){
		$tahun = $this->input->post('tahun');
		$jalur = $this->input->post('jalur');

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_available_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur)
		 	));

		if($data){
			echo json_encode($data);
		}else{
			echo '0';
		}
	}

	function get_ajax_ujian_tersedia(){

	}
	
}
 
/* End of file pengumuman.php */
