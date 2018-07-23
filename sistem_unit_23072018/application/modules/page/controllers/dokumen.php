<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dokumen extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Dokumen Akademik', '/');
		$limit=20;
		$data['dokumen'] = $this->page_model->get_arsip_dokumen($limit,$uri);

		
				$data['content']="page/dokumen/arsip_view";				
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
		
   }

 
}
 
/* End of file dokumen.php */
