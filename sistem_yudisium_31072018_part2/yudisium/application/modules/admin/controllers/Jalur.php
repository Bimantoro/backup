<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jalur extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		// $this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		//$this->load->model('admin/page_model');
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
		$data['title']="Master Data Jalur";
		$data['json_url']=site_url('admin/jalur/menu_json');
		$data['main_view']="admin/jalur/data_jalur";
		$this->load->view('admin/content',$data);
   }

   function testing(){
   		$data = $this->s00_lib_api->get_api_json('service.uin-suka.ac.id/servskpi/index.php/skpi/skpi_public/skpi_basic/index', 'POST', array('api_search' => array()));
   		echo $data;
   }
 
	
	function menu_json(){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'/yud_public/get_all_master_jalur',
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
	function add_jalur(){
		if($_POST==null){
			$data['title']="Input Data Jalur";
			$data['main_view']="admin/jalur/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kd_jalur 	= $this->input->post('kode');
			$nm_jalur 	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/in_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_jalur, $nm_jalur)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/jalur');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
				redirect('admin/jalur');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['jalur'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));


			$data['title']="Edit Data Jalur";
			$data['main_view']="admin/jalur/edit_jalur";
			$this->load->view('admin/content',$data);
		}else{	
			$kd_jalur 	= $this->input->post('kode');
			$nm_jalur 	= $this->input->post('nama');
		

			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/up_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array($kd_jalur, $nm_jalur)
		 	));

			if($data){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/jalur');
			}else{
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/jalur');
			}
		}			
	}

	function delete($id=""){

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/del_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array($id)
		 	));

		if($data){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
			redirect('admin/jalur');
		}else{
			$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
			redirect('admin/jalur');
		}

	}
	
}
 
/* End of file pengumuman.php */
