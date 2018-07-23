<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dokumen extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->library('pagination');
		//$this->load->library('breadcrumb');
		$this->load->model('web/page_model');
		$this->load->helper('page');
		$this->lang = $this->page_lib->lang();
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Dokumen', $this->lang)), '/');
		$limit=20;
		$data['dokumen'] = $this->page_model->get_arsip_dokumen($limit,$uri);

		/* $this->load->view('page/header',$data);
		$this->load->view('page/bg_breadcumb');
		$this->load->view('page/left-side');
		$this->load->view('page/dokumen/arsip_view');
		$this->load->view('page/right-side');
		$this->load->view('page/footer'); */
		$data['main_view']="web/dokumen/arsip_view";
		$this->load->view('web/content',$data);
   }
 
   public function detail($id=0)
   {
      $data_dokumen = $this->db->get_where("Dokumen",array('id_dokumen'=>$id));
      $dokumen = $data_dokumen->row();
	  if($data_dokumen->num_rows()>0){
			$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Dokumen', $this->lang)), site_url('page/dokumen'));
			$this->breadcrumb->append_crumb($dokumen->tentang, '/');
			
			$data['dokumen'] = $this->page_model->get_detail_dokumen($id);
/* 
			$this->load->view('page/header',$data);
			$this->load->view('page/bg_breadcumb');
			$this->load->view('page/left-side');
			$this->load->view('page/dokumen/detail_view');
			$this->load->view('page/right-side');
			$this->load->view('page/footer'); */
			$data['main_view']="web/dokumen/detail_view";				
			$this->load->view('web/content',$data);
      }
      else
      {
	      	redirect(base_url());
      }
   }
 
}
 
/* End of file dokumen.php */
