<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends CI_Controller {

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
		$data['title']="Pengaturan Data akun";
		$data['json_url']=site_url('admin/akun/menu_json');
		$data['main_view']="admin/akun/data_akun";
		$this->load->view('admin/content',$data);
   }



	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_data_akun',
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
	function add_akun(){
		if($_POST==null){
			$data['title']="Input Data akun";
			$data['main_view']="admin/akun/menu_form";

			$data['fakultas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

			$this->load->view('admin/content',$data);
		}else{
			$kd_akun 	= $this->input->post('id');
			$kd_fak 	= $this->input->post('fak');
			$nm_akun 	= $this->input->post('level');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_data_akun',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_akun, $kd_fak, $nm_akun)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/akun');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/akun');
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
		 	
			$data['akun'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_data_akun',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data akun";
			$data['main_view']="admin/akun/edit_akun";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_akun 	= $this->input->post('id');
			$kd_fak 	= $this->input->post('fak');
			$nm_akun 	= $this->input->post('level');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_data_akun',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_akun, $nm_akun)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/akun');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/akun');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_data_akun', 	
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/akun');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/akun');
		}

	}
	
}
 
/* End of file pengumuman.php */
