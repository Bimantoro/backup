<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fakultas extends CI_Controller {

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

		// if($this->session->userdata('level') != 'Y000'){
		// 	redirect(base_url('admin/main/dash'));
		// }
	}
 
   public function index($uri=0){
		$data['title']="Master Data Fakultas";
		$data['json_url']=site_url('admin/fakultas/menu_json');
		$data['main_view']="admin/fakultas/data_fakultas";
		$this->load->view('admin/content',$data);
   }



	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
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
	function add_fakultas(){
		if($_POST==null){
			$data['title']="Input Data fakultas";
			$data['main_view']="admin/fakultas/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kd_fakultas 	= $this->input->post('kode');
			$nm_fakultas 	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_fakultas, $nm_fakultas)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/fakultas');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/fakultas');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['fakultas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data fakultas";
			$data['main_view']="admin/fakultas/edit_fakultas";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_fakultas	= $this->input->post('kode');
			$nm_fakultas	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_fakultas, $nm_fakultas)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/fakultas');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/fakultas');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/fakultas');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/fakultas');
		}

	}
	
}
 
/* End of file pengumuman.php */
