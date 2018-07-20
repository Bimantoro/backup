<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Berita extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->library('pagination');
		$this->load->library('page_lib');
		$this->load->library('breadcrumb');
		$this->load->model('web/page_model');
		$this->load->helper('page');
		 $this->lang=$this->page_lib->lang();
	}
 
   public function index($uri=0,$th="",$bl=""){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Berita',$this->lang)), '/');
		(int)$limit=5;
		$data['berita'] = $this->page_model->generate_index_berita($limit,(int)$uri,array('tahun'=>$th,'bulan'=>$bl));
		$data['sidebar']=array('search_sidebar', 'arsip_berita_sidebar');
		$data['main_view']="web/berita/arsip_view";				
		$this->load->view('web/content',$data);
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("berita",array('id_berita'=>$id));
		$berita = $get_data->row();
		if($get_data->num_rows()>0){
		 	$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Berita',$this->lang)), site_url($this->lang.'/berita'));
			$this->breadcrumb->append_crumb(substr($berita->judul,0,130).' ...', '/');
			$data['title']=$berita->judul;
			$data['gambar'] = $berita->foto;
			$data['folder'] = "gambar";
			$this->page_model->page_counter($id,'berita');
			
			$data['d'] = $this->db->get_where('berita',array('id_berita'=>$id))->row();
			$arr_filter=array();
			$arr_filter=related_text($berita->judul);	
			$filter	="id_berita <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			//$data['rec']=$this->db->query("SELECT id_berita,judul,tgl_posting from berita WHERE ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			//$data['pop']=$this->db->query("SELECT id_berita,judul,tgl_posting from berita ORDER BY counter desc LIMIT 0,5")->result();

			$data['rec']=$this->page_model->get_berita_terkait($filter, 0, 5);
			$data['pop']=$this->page_model->get_berita_terpopuler(0, 5);
			$data['lang']=$this->lang;

			$data['sidebar']=array('search_sidebar', 'arsip_berita_sidebar');
			$data['main_view']="web/berita/detail_berita";				
			$this->load->view('web/content',$data);
			
				
		}else{
	      	redirect(base_url());
		}
   }
   function feed(){  
        $data['feed_name'] = ucfirst(dict('Berita',$this->lang));  
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
