<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta extends CI_Controller {

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
		$data['title']="Data Peserta";
		$data['json_url_peserta'] =site_url('admin/peserta/menu_json');
		$data['json_url_prodi'] =site_url('admin/peserta/ajax_get_prodi');
		$data['fakultas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		$data['main_view']="admin/peserta/data_peserta";
		$this->load->view('admin/content',$data);
   }



	
	function menu_json(){

		$prodi = $this->input->post('prodi');
		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_data_peserta_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($prodi)
		 	));

		if(!empty($data)){
				echo json_encode($data);
		}else{
			echo '0';
		}
    }

    function ajax_get_prodi(){
    	$fak = $this->input->post('fak');

    	$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_prodi_by_fak',
		 	'POST',
		 	array(
		 		'api_search' => array($fak)
		 	));

    	if(!empty($data)){
    		echo json_encode($data);
    	}else{
			echo '0';
		}
    }

	// function add_prodi(){
	// 	if($_POST==null){
	// 		$data['title']="Input Data prodi";
	// 		$data['main_view']="admin/prodi/menu_form";

	// 		$data['fakultas'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_fakultas',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));

	// 	 	$data['jenjang'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_jenjang',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));

	// 		$this->load->view('admin/content',$data);
	// 	}else{
	// 		$kd_prodi 	= $this->input->post('kode');
	// 		$kd_fak 	= $this->input->post('fak');
	// 		$nm_prodi 	= $this->input->post('nama');
	// 		$jenjang 	= $this->input->post('jenjang');
		

	// 		$data = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/in_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($kd_prodi, $kd_fak, $nm_prodi, $jenjang)
	// 	 	));

	// 		if($data){
	// 			$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
	// 			redirect('admin/prodi');
	// 		}else{
	// 			$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
	// 			redirect('admin/prodi');
	// 		}
	// 	}	
	// }
	// function edit($id=""){
	// 	if($_POST==NULL) {

	// 		$data['fakultas'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_fakultas',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));

	// 	 	$data['jenjang'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_jenjang',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));
		 	
	// 		$data['prodi'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($id)
	// 	 	));


	// 		$data['title']="Edit Data prodi";
	// 		$data['main_view']="admin/prodi/edit_prodi";
	// 		$this->load->view('admin/content',$data);
	// 	}else{	
	// 		$kd_prodi	= $this->input->post('kode');
	// 		$nm_prodi	= $this->input->post('nama');
	// 		$jenjang	= $this->input->post('jenjang');

	// 		$data = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/up_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($kd_prodi, $nm_prodi, $jenjang)
	// 	 	));

	// 		if($data){
	// 			$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
	// 			redirect('admin/prodi');
	// 		}else{
	// 			$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
	// 			redirect('admin/prodi');
	// 		}
	// 	}			
	// }

	// function delete($id=""){

	// 	$data = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/del_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($id)
	// 	 	));

	// 	if($data){
	// 		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
	// 		redirect('admin/prodi');
	// 	}else{
	// 		$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
	// 		redirect('admin/prodi');
	// 	}

	// }
	
}
 
/* End of file pengumuman.php */
