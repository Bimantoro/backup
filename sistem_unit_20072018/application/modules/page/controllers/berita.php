<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class berita extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Berita', '/');
		$limit=10;
		$data['berita'] = $this->page_model->generate_index_berita($limit,$uri);
		$data['content']="page/berita/arsip_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("berita",array('id_berita'=>$id));
		$berita = $get_data->row();
		if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Berita', site_url('page/berita'));
			$this->breadcrumb->append_crumb(substr($berita->judul,0,130).' ...', '/');
			$data['title']=$berita->judul;
			$this->page_model->page_counter($id,'berita');
			
			$data['berita'] = $this->page_model->generate_detail_berita($id);
			
			$arr_filter=array();
			$arr_filter=related_text($berita->judul);	
			$filter	="WHERE id_berita <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_berita,judul,tanggal,jam from berita ".$filter." ORDER BY tanggal desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_berita,judul,tanggal,jam from berita ORDER BY counter desc LIMIT 0,5")->result();
			
	
			$data['content']="page/berita/detail_view";
				
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
				
		}else{
	      	redirect(base_url());
		}
   }
   function feed(){  
        $data['feed_name'] = 'Berita';  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/berita/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['berita'] = $this->page_model->get_feed_berita(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('berita/rss_berita', $data);  
    }   

}
 
/* End of file berita.php */
