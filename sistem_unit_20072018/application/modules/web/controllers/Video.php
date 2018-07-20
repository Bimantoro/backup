<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

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
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Video', $this->lang)), '/');
		(int)$limit=5;
		$data['video'] = $this->page_model->generate_index_video($limit,(int)$uri,array('tahun'=>$th,'bulan'=>$bl));
		// $data['sidebar']=array('search_sidebar', 'arsip_video_sidebar');
		$data['main_view']="web/video/arsip_view";				
		$this->load->view('web/content',$data);
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("video",array('id_video'=>$id));
		$video = $get_data->row();
		if($get_data->num_rows()>0){
		 	$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Video', $this->lang)), site_url($this->lang.'/video'));
			$this->breadcrumb->append_crumb(substr($video->judul,0,130).' ...', '/');
			$data['title']=$video->judul;
			$this->page_model->page_counter($id,'video');
			
			$data['d'] = $this->db->get_where('video',array('id_video'=>$id))->row();
			$arr_filter=array();
			$arr_filter=related_text($video->judul);	
			$filter	="id_video <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			// $data['rec']=$this->db->query("SELECT id_video,judul,tgl_posting from video WHERE ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			// $data['pop']=$this->db->query("SELECT id_video,judul,tgl_posting from video ORDER BY counter desc LIMIT 0,5")->result();

			// $data['rec']=$this->page_model->get_video_terkait($filter, 0, 5);
			// $data['pop']=$this->page_model->get_video_terpopuler(0, 5);
			$data['lang']=$this->lang;

			// $data['sidebar']=array('search_sidebar', 'arsip_video_sidebar');
			$data['main_view']="web/video/detail_video";				
			$this->load->view('web/content',$data);
			
				
		}else{
	      	redirect(base_url());
		}
   }
   function feed(){  
        $data['feed_name'] = ucfirst(dict('Video', $this->lang));  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/video/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['video'] = $this->page_model->get_feed_video(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('video/rss_video', $data);  
    }   

}
 
/* End of file video.php */
