<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ujian extends CI_Controller {

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
		$data['title']="Master Data Ujian";
		$data['json_url']=site_url('admin/ujian/menu_json');
		$data['main_view']="admin/ujian/data_ujian";
		$this->load->view('admin/content',$data);
   }
 
	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_ujian',
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
	function add_ujian(){
		if($_POST==null){
			$data['title']="Input Data Ujian";
			$data['main_view']="admin/ujian/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kd_ujian 	= $this->input->post('kode');
			$nm_ujian 	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_master_ujian',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_ujian, $nm_ujian)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/ujian');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/ujian');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['ujian'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_ujian',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data Ujian";
			$data['main_view']="admin/ujian/edit_ujian";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_ujian	= $this->input->post('kode');
			$nm_ujian	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_master_ujian',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_ujian, $nm_ujian)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/ujian');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/ujian');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_master_ujian',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/ujian');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/ujian');
		}

	}
	
}
 
/* End of file pengumuman.php */
