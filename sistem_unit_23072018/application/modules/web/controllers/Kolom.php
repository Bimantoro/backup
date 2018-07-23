<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kolom extends CI_Controller {

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
		$this->breadcrumb->append_crumb(ucfirst(dict('Kolom',$this->lang)), '/');
		   if(isset($_SESSION['site_limit_kolom_slider'])){
			$limit=$_SESSION['site_limit_kolom_slider'];
			}else{
			$limit=10;
			}
			  $data['kolom'] = $this->page_model->get_arsip_kolom($limit,(int)$uri,array('tahun'=>$th,'bulan'=>$bl));
		$data['sidebar']=array('search_sidebar','arsip_kolom_sidebar');
		$data['main_view']="web/kolom/arsip_view";				
		$this->load->view('web/content',$data);
   }
 
   public function detail($id=0){
   	$this->page_model->page_counter($id,'kolom');
      $get_data = $this->db->get_where("kolom",array('id_kolom'=>$id));
		$kolom = $get_data->row();
		if($get_data->num_rows()>0){
		 	$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Kolom',$this->lang)), site_url($this->lang.'/kolom'));
			$this->breadcrumb->append_crumb(substr($kolom->judul,0,130).' ...', '/');
			$data['title']=$kolom->judul;
			//$this->page_model->page_counter($id,'berita');
			
			$data['d'] = $this->db->get_where('kolom',array('id_kolom'=>$id))->row();
			$arr_filter=array();
			$arr_filter=related_text($kolom->judul);	
			$filter	="id_kolom <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			//$data['rec']=$this->db->query("SELECT id_kolom,judul,tgl_posting from kolom WHERE ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			//$data['pop']=$this->db->query("SELECT id_kolom,judul,tgl_posting from kolom ORDER BY counter desc LIMIT 0,5")->result();

			$data['rec'] = $this->page_model->get_kolom_terkait($filter, 0, 5);
			$data['pop'] = $this->page_model->get_kolom_terpopuler( 0, 5);

			$data['lang'] = $this->lang;

			$data['sidebar']=array('search_sidebar','arsip_kolom_sidebar');
			$data['main_view']="web/kolom/detail_kolom";				
			$this->load->view('web/content',$data);
				
		}else{
	      	redirect(base_url());
		}
   }
   
   function feed(){  
        $data['feed_name'] = ucfirst(dict('Kolom',$this->lang));  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/kolom/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['kolom'] = $this->page_model->get_feed_kolom(10);     
        header("Content-Type: application/rss+xml");       
        $this->load->view('kolom/rss_kolom', $data);  
    }   
 
}
 
/* End of file kolom.php */
