<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gelombang extends CI_Controller {

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
		$data['title']="Master Data Gelombang";
		$data['json_url']=site_url('admin/gelombang/menu_json');
		$data['main_view']="admin/gelombang/data_gelombang";
		$this->load->view('admin/content',$data);
   }
 
	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_gelombang',
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
	function add_gelombang(){
		if($_POST==null){
			$data['title']="Input Data Gelombang";
			$data['main_view']="admin/gelombang/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kd_gelombang 	= $this->input->post('kode');
			$nm_gelombang 	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_master_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_gelombang, $nm_gelombang)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/gelombang');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/gelombang');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['gelombang'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data Gelombang";
			$data['main_view']="admin/gelombang/edit_gelombang";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_gelombang	= $this->input->post('kode');
			$nm_gelombang	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_master_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_gelombang, $nm_gelombang)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/gelombang');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/gelombang');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_master_gelombang',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/gelombang');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/gelombang');
		}

	}
	
}
 
/* End of file pengumuman.php */
