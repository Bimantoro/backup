<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ukm extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('UKM', '/');
		  
		$limit=10;
		$data['ukm'] = $this->page_model->get_arsip_ukm($limit,$uri);
	
		$data['content']="page/ukm/arsip_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
   }
 
   public function detail($id=0)
   {
      $get_data = $this->db->get_where("ukm",array('id_ukm'=>$id));
      $ret_data = $get_data->row();
	  if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('UKM', site_url('page/ukm'));
			$this->breadcrumb->append_crumb($ret_data->nama_ukm, '/');
			
			$data['ukm'] = $this->page_model->get_detail_ukm($id);
	
			$data['content']="page/ukm/detail_view";				
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
      }
      else
      {
	      	redirect(base_url());
      }
   }
 
}
 
/* End of file ukm.php */
