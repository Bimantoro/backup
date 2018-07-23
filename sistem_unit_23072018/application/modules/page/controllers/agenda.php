<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agenda extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('text_manipulation');
		$this->load->helper('format_tanggal');
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Agenda', '/');
		$limit=10;
		$data['agenda'] = $this->page_model->get_arsip_agenda($limit,$uri);
		$data['content']="page/agenda/arsip_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
		
		
   }
 
   public function detail($id=0){
      $get_data = $this->db->get_where("agenda",array('id_agenda'=>$id));
      $agenda = $get_data->row();
	  if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Agenda', site_url('page/agenda'));
			$this->breadcrumb->append_crumb(substr($agenda->nama_agenda,0,130).' ...', '/');
			$data['title']=$agenda->nama_agenda;
			$this->page_model->page_counter($id,'agenda');
		
			$data['agenda'] = $this->page_model->get_detail_agenda($id);
			
			$arr_filter=array();
			$arr_filter=related_text($agenda->nama_agenda);	
			$filter	="WHERE id_agenda <> '".$id."' AND  (nama_agenda LIKE '%".rtrim(implode("%' OR nama_agenda LIKE '%",$arr_filter)," OR nama_agenda LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_agenda,nama_agenda,tgl_posting,jam_posting from agenda ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_agenda,nama_agenda,tgl_posting,jam_posting from agenda ORDER BY counter desc LIMIT 0,5")->result();
		
			$data['content']="page/agenda/detail_view";
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
			
      }else{
	      	redirect(base_url());
      }
    }
   function feed(){  
        $data['feed_name'] = 'Agenda';  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/agenda/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['agenda'] = $this->page_model->get_feed_agenda(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('agenda/rss_agenda', $data);  
    }   
 
}
 
/* End of file agenda.php */
