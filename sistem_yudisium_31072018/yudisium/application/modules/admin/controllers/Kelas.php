<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelas extends CI_Controller {

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
		$data['title']="Master Data kelas";
		$data['json_url']=site_url('admin/kelas/menu_json');
		$data['main_view']="admin/kelas/data_kelas";
		$this->load->view('admin/content',$data);
   }
 
	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_kelas',
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
	function add_kelas(){
		if($_POST==null){
			$data['title']="Input Data kelas";
			$data['main_view']="admin/kelas/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kd_kelas 	= $this->input->post('kode');
			$nm_kelas 	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_kelas, $nm_kelas)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/kelas');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/kelas');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['kelas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data kelas";
			$data['main_view']="admin/kelas/edit_kelas";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_kelas	= $this->input->post('kode');
			$nm_kelas	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_kelas, $nm_kelas)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/kelas');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/kelas');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/kelas');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/kelas');
		}

	}
	
}
 
/* End of file pengumuman.php */
