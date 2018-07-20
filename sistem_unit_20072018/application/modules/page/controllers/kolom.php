<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kolom extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Kolom', '/');
		   if(isset($_SESSION['site_limit_kolom_slider'])){
			$limit=$_SESSION['site_limit_kolom_slider'];
			}else{
			$limit=10;
			}
			  $data['kolom'] = $this->page_model->get_arsip_kolom($limit,$uri);

			
		$data['content']="page/kolom/arsip_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
   }
 
   public function detail($id=0){
      $data_kolom = $this->db->get_where("kolom",array('id_kolom'=>$id));
      $kolom = $data_kolom->row();
	  if($data_kolom->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Kolom', site_url('page/kolom'));
			$this->breadcrumb->append_crumb($kolom->tentang, '/');
			$data['title']=$kolom->tentang;
			$this->page_model->page_counter($id,'kolom');
			$data['kolom'] = $this->page_model->get_detail_kolom($id);
			
			$arr_filter=array();
			$arr_filter=related_text($kolom->tentang);	
			$filter	="WHERE id_kolom <> '".$id."' AND  (tentang LIKE '%".rtrim(implode("%' OR tentang LIKE '%",$arr_filter)," OR tentang LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_kolom,tentang,tanggal,jam from kolom ".$filter." ORDER BY tanggal desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_kolom,tentang,tanggal,jam from kolom ORDER BY counter desc LIMIT 0,5")->result();
			
				$data['content']="page/kolom/detail_view";
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
      }else{
	      	redirect(base_url());
      }
   }
   
   function feed(){  
        $data['feed_name'] = 'Kolom';  
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
