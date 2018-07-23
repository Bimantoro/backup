<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class liputan extends CI_Controller {

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
		$this->breadcrumb->append_crumb(ucfirst(dict('Liputan',$this->lang)), '/');
		(int)$limit=10;
		$data['liputan'] = $this->page_model->get_arsip_liputan($limit,(int)$uri,array('tahun'=>$th,'bulan'=>$bl));
		$data['sidebar']=array('search_sidebar','arsip_liputan_sidebar');
		$data['main_view']="web/liputan/arsip_view";				
		$this->load->view('web/content',$data);
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("liputan",array('id_liputan'=>$id));
		$liputan = $get_data->row();
		if($get_data->num_rows()>0){
		 	$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Liputan',$this->lang)), site_url($this->lang.'/liputan'));
			$this->breadcrumb->append_crumb(substr($liputan->judul,0,130).' ...', '/');
			$data['title']=$liputan->judul;
			$this->page_model->page_counter($id,'liputan');
			
			$data['d'] = $this->db->get_where('liputan',array('id_liputan'=>$id))->row();
			$arr_filter=array();
			$arr_filter=related_text($liputan->judul);	
			$filter	="id_liputan <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			//$data['rec']=$this->db->query("SELECT id_liputan,judul,tgl_posting from liputan WHERE ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			//$data['pop']=$this->db->query("SELECT id_liputan,judul,tgl_posting from liputan ORDER BY counter desc LIMIT 0,5")->result();

			$data['rec'] = $this->page_model->get_liputan_terkait($filter, 0, 5);
			$data['pop'] = $this->page_model->get_liputan_terpopuler( 0, 5);

			$data['lang'] = $this->lang;
			
			$data['sidebar']=array('search_sidebar','arsip_liputan_sidebar');
			$data['main_view']="web/liputan/detail_liputan";				
			$this->load->view('web/content',$data);
				
		}else{
	      	redirect(base_url());
		}
   }
   function feed(){  
        $data['feed_name'] = ucfirst(dict('Liputan',$this->lang));  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/liputan/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['liputan'] = $this->page_model->get_feed_liputan(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('liputan/rss_liputan', $data);  
    }   

}
 
/* End of file liputan.php */
