<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class liputan extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Liputan', '/');
		$limit=10;
		$data['liputan'] = $this->page_model->get_arsip_liputan($limit,$uri);

		$data['content']="page/liputan/arsip_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
   }
 
   public function detail($id=0)   {
      $get_data = $this->db->get_where("liputan",array('id_liputan'=>$id));
      $liputan = $get_data->row();
	  if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Liputan', site_url('page/liputan'));
			$this->breadcrumb->append_crumb(substr($liputan->judul,0,130).' ...', '/');
			$data['title']=$liputan->judul;
			$this->page_model->page_counter($id,'liputan');
			$data['liputan'] = $this->page_model->get_detail_liputan($id);

			$arr_filter=array();
			$arr_filter=related_text($liputan->judul);	
			$filter	="WHERE id_liputan <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_liputan,judul,tanggal,jam from liputan ".$filter." ORDER BY tanggal desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_liputan,judul,tanggal,jam from liputan ORDER BY counter desc LIMIT 0,5")->result();
		$data['content']="page/liputan/detail_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
      }else{
	      	redirect(base_url());
      }
   }
 
}
 
/* End of file liputan.php */
