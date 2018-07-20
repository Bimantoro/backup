<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Controller {

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
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Album', $this->lang)), '/');
		$limit=12;
		$data['album'] = $this->page_model->get_arsip_album($limit,$uri)->result_array();
		$data['main_view']="web/album/arsip_view";
		$this->load->view('web/content',$data);
   }
}
 
/* End of file dokumen.php */
