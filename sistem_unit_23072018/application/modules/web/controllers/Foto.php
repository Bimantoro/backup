<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Foto extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->helper('page');
		$this->load->library('pagination');
		$this->load->library('breadcrumb');
		$this->load->model('web/page_model');
		$this->lang = $this->page_lib->lang();
	}
 
   public function daftar($uri=0){
   		$id_album = $this->uri->segment(4);
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Foto', $this->lang)), '/');
		$limit=10;
		$data['album'] = $this->page_model->get_judul_album($id_album);
		$data['foto'] = $this->page_model->get_arsip_foto(9, 0, $id_album)->result_array();
		$data['main_view']="web/foto/arsip_view";
		$this->load->view('web/content',$data);
   } 
}
 
/* End of file dokumen.php */
