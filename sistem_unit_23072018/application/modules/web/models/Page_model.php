<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->library('page_lib');
		$this->lang=$this->page_lib->lang(); 
	}
	public function get_session_unit(){
		$d=explode('.',str_replace('http://','',base_url()));
		$dom=$d[0];
		//$dom = $this->session->userdata('subdomain');
		$query = $this->db->get_where('unit', array('subdomain'=>$dom))->row();
		return $query->kode_unit;
	}
	public function get_feed_berita($limit=0){
		return $w = $this->db->query("select * from berita order by id_berita ");
	}  
	public function daftar_slide(){
		return $w = $this->db->query("select * from slide_2016 
		WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' AND CURDATE() BETWEEN tgl_mulai AND tgl_selesai 
		 order by id_slide DESC" )->result();
	}
	
	public function daftar_berita($limit=1,$offset=0){
		return $w = $this->db->query("select * from berita WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'order by tgl_posting DESC limit ".$offset.",".$limit."" )->result();
	} 
	public function cek_status_slider(){
		return $query = $this->db->get_where('unit', array('status_slider_bar'=>'0'));
		//return $w= $this->db->query("select status_slider_bar from unit where kode_unit='".$this->get_session_unit()."'")->result();
		//$query = %this->db->get_where('unit', array('status_slider_bar'=>1))->row();
		//return $query->status_slider_bar;
	}

	public function status_slider_unit($lang = 'X0X'){
		if($lang != 'X0X'){
			return $w = $this->db->query("SELECT status_slider_bar FROM unit WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa = '".$lang."' ")->row_array();
		}else{
			return $w = $this->db->query("SELECT status_slider_bar FROM unit WHERE kode_unit='".$this->get_session_unit()."'")->row_array();
		}
	}
	
	public function daftar_pengumuman($limit=1,$offset=0){
		return $w = $this->db->query("select * from pengumuman WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' order by tgl_posting DESC limit ".$offset.",".$limit."" )->result();
		
	}  
		
	public function daftar_agenda($limit=1,$offset=0){
		return $w = $this->db->query("select * from agenda WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' order by tgl_posting DESC limit ".$offset.",".$limit."" )->result();
	}
	public function daftar_agenda_aktif(){
		$query=$this->db->query("SELECT * FROM agenda
		WHERE tgl_selesai >= '".date('Y-m-d h:i:s')."' AND kode_unit='".$this->get_session_unit()."' 
		and kode_bahasa='".$this->lang."' ORDER BY tgl_mulai asc LIMIT 0,5");
		return $query->result();
	}
	public function daftar_kolom($limit=1,$offset=0){
		return $w = $this->db->query("select * from kolom WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' order by tgl_posting DESC limit ".$offset.",".$limit."" )->result();
	}
	public function daftar_liputan($limit=1,$offset=0){
		return $w = $this->db->query("select * from liputan WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' order by tgl_posting DESC limit ".$offset.",".$limit."" )->result();
	}
	// public function daftar_side_menu($limit=1,$offset=0){
	// 	return $w = $this->db->query("select * from side_menu
	// 	WHERE kode_bahasa='".$this->lang."' 
	// 	order by menu_order" )->result();
	// }

	public function daftar_side_menu($limit=1,$offset=0){
		return $w = $this->db->query("select * from side_menu
		WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' 
		order by menu_order" )->result();
	}

	public function daftar_side_menu_lab($limit=1,$offset=0){
		return $w = $this->db->query("select * from laboratorium
		WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' " )->result();
	}
	public function daftar_nama_side_unit(){
		//return $w = $this->db->query("select * from unit WHERE kode_unit=41")->result();
		/*return $w = $this->db->query("select * from unit WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."' ")->result();*/
		//$query = "SELECT * from unit WHERE kode_unit='67' AND kode_bahasa='id'";
		$query = "SELECT * FROM unit WHERE kode_unit = '".$this->get_session_unit()."' AND kode_bahasa = '".$this->lang."'";
		$sql = $this->db->query($query);
		return $sql->row_array();
	}
	public function arsip_berita(){
		//$lang=$this->page_lib->lang(); 
		return $w = $this->db->query("select date_format(tgl_posting, '%M %Y'),month(tgl_posting) bulan, year(tgl_posting) tahun, count(id_berita) jumlah
		from berita 
		WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'
		group by year(tgl_posting), month(tgl_posting), date_format(tgl_posting, '%M %Y')
		order by year(tgl_posting) desc, month(tgl_posting)asc" )->result();
				
	}
	public function arsip_liputan(){
		//$lang=$this->page_lib->lang(); 
		return $w = $this->db->query("select date_format(tgl_posting, '%M %Y'),month(tgl_posting) bulan, year(tgl_posting) tahun, count(id_liputan) jumlah
		from liputan 
		where kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'
		group by year(tgl_posting), month(tgl_posting), date_format(tgl_posting, '%M %Y')
		order by year(tgl_posting) desc, month(tgl_posting)asc" )->result();
	}
	public function arsip_kolom(){
		//$lang=$this->page_lib->lang(); 
		return $w = $this->db->query("select date_format(tgl_posting, '%M %Y'),month(tgl_posting) bulan, year(tgl_posting) tahun, count(id_kolom) jumlah
		from kolom 
		where kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'
		group by year(tgl_posting), month(tgl_posting), date_format(tgl_posting, '%M %Y')
		order by year(tgl_posting) desc, month(tgl_posting)asc" )->result();
	}
	public function arsip_pengumuman(){
		//$lang=$this->page_lib->lang(); 
		return $w = $this->db->query("select date_format(tgl_posting, '%M %Y'),month(tgl_posting) bulan, year(tgl_posting) tahun, count(id_pengumuman) jumlah
		from pengumuman
		where kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'
		group by year(tgl_posting), month(tgl_posting), date_format(tgl_posting, '%M %Y')
		order by year(tgl_posting) desc, month(tgl_posting)asc" )->result();
	}
	public function arsip_agenda(){
		//$lang=$this->page_lib->lang(); 
		return $w = $this->db->query("select date_format(tgl_posting, '%M %Y'),month(tgl_posting) bulan, year(tgl_posting) tahun, count(id_agenda) jumlah
		from agenda
		where kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'
		group by year(tgl_posting), month(tgl_posting), date_format(tgl_posting, '%M %Y')
		order by year(tgl_posting) desc, month(tgl_posting)asc" )->result();
	}
	public function get_video($limit=10){
		return $w = $this->db->query("select * from video order by id_video DESC limit 0, ".$limit."");
	}  
	public function get_feed_pengumuman($limit=10){
		return $w = $this->db->query("select * from pengumuman order by id_pengumuman DESC limit 0, ".$limit."");
	}
	public function get_feed_agenda($limit=10){
		return $w = $this->db->query("select * from agenda order by id_agenda DESC limit 0, ".$limit."");
	}
	public function get_feed_kolom($limit=10){
		return $w = $this->db->query("select * from kolom order by id_kolom DESC limit 0, ".$limit."");
	}
	public function generate_index_berita($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from berita ".$where."");
		$config['base_url'] = site_url($this->lang.'/berita/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		return $w = $this->db->query("select * from berita ".$where." order by tgl_posting DESC limit ".$offset.", ".$limit."")->result();
	}
		 
	public function get_arsip_liputan($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from liputan ".$where."");
		$config['base_url'] = site_url($this->lang.'/liputan/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";

		return $w = $this->db->query("select * from liputan ".$where." order by id_liputan DESC limit ".$offset.", ".$limit."")->result();
	}
	
	public function get_arsip_agenda($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from agenda ".$where."");
		$config['base_url'] = site_url($this->lang.'/agenda/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";

		return $w = $this->db->query("select * from agenda ".$where." order by id_agenda DESC limit ".$offset.", ".$limit."")->result();
	}
	 
	function get_arsip_pengumuman($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from pengumuman ".$where."");
		$config['base_url'] = site_url($this->lang.'/pengumuman/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		
		return $w = $this->db->query("select * from pengumuman ".$where." order by id_pengumuman DESC limit ".$offset.", ".$limit."")->result();
	}
	 
	function get_arsip_kolom($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from kolom ".$where."");
		$config['base_url'] = site_url($this->lang.'/kolom/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";

		return $w = $this->db->query("select * from kolom ".$where." order by id_kolom DESC limit ".$offset.", ".$limit."")->result();
	}

	
	public function generate_index_video($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from video ".$where."");
		$config['base_url'] = site_url($this->lang.'/video/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		if($filter['tahun']!=null) $where.=" AND year(tgl_posting)='".$filter['tahun']."'";
		if($filter['bulan']!=null) $where.=" AND month(tgl_posting)='".$filter['bulan']."'";
		return $w = $this->db->query("select * from video ".$where." order by id_video DESC limit ".$offset.", ".$limit."")->result();
	}
	 
	function get_arsip_ukm($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from ukm ");
		$config['base_url'] = site_url('id/ukm/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from ukm order by id_ukm DESC limit ".$offset.", ".$limit."");
	}
	function get_arsip_dokumen($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from dokumen ".$where);
		$config['base_url'] = site_url($this->lang.'/dokumen/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from dokumen ".$where." order by id_dokumen DESC limit ".$offset.", ".$limit."");
	}
	#huda 2/7/18
	function get_arsip_penelitian($limit,$offset,$filter=array()){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from penelitian ".$where);
		$config['base_url'] = site_url($this->lang.'/penelitian/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from penelitian ".$where." order by id_penelitian DESC limit ".$offset.", ".$limit."");
	}
	// FAUZI 2018-06-08 START
	function get_arsip_album($limit,$offset){
		$where="WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->lang."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from album");
		$config['base_url'] = site_url($this->lang.'/album/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from album ".$where." order by id_album DESC limit ".$offset.", ".$limit."");
	}

	// FAUZI 2018-06-08 END
	//TF 2018-06-08 START
	function get_arsip_foto($limit,$offset, $id_album){
		$where="WHERE id_album='".$id_album."'";
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from foto where id_album='$id_album'");
		$config['base_url'] = site_url('web/album/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from foto  ".$where." order by id_foto DESC limit ".$offset.", ".$limit."");
	}
	public function get_judul_album($id_album){
		$query = "SELECT judul, ringkasan FROM album where id_album = '$id_album'";
		$sql = $this->db->query($query);
		return $sql->row_array();
	}
	//TF 2018-06-08 END
	public function generate_detail_berita($id=0){
		return $w = $this->db->query("SELECT * FROM berita where id_berita='".$id."'");
	}
	 
	public function get_detail_agenda($id=0){
		return $w = $this->db->query("SELECT * FROM agenda where id_agenda='".$id."'");
	}
	public function get_detail_liputan($id=0){
		return $w = $this->db->query("SELECT * FROM liputan where id_liputan='".$id."'");
	}
	public function get_detail_kolom($id=0){
		return $w = $this->db->query("SELECT * FROM kolom where id_kolom='".$id."'");
	}
	public function get_detail_ukm($id=0){
		return $w = $this->db->query("SELECT * FROM ukm where id_ukm='".$id."'");
	}
	public function get_detail_dokumen($id=0){
		return $w = $this->db->query("SELECT * FROM dokumen where id_dokumen='".$id."'");
	}	
	function get_fakultas(){
		/* $lang=$this->page_lib->lang();
		$query=$this->db->get_where('fakultas',array('kode_bahasa'=>$lang));
		return $query->result(); */
	}	
		
	function get_agenda(){
	$hari=date('Y-m-d');
		$query=$this->db->query("SELECT * FROM agenda where tgl_mulai > '".$hari."'order by id_agenda desc limit 0,5");
		return $query->result();
	}	
	
	function get_pengumuman($limit=1, $offset=0){
		$query=$this->db->query("SELECT * FROM pengumuman
		WHERE  kode_bahasa='".$this->page_lib->lang()."' 
		order by id_pengumuman desc 
		limit ".$limit." OFFSET ".$offset);
		return $query->result();
	}	
	
	function get_recent_news($offset=0,$limit=1){
		$lang=$this->page_lib->lang();
		$query=$this->db->query("SELECT * FROM berita where kode_bahasa='".$lang."' order by id_berita desc limit ".$offset.",".$limit);
		return $query->result();
	}	
	function get_recent_liputan($offset=0,$limit=1){
		$lang=$this->page_lib->lang();
		$query=$this->db->query("SELECT * FROM liputan where kode_bahasa='".$lang."' order by id_liputan desc limit ".$offset.",".$limit);
		return $query->result();
	}	
	
	function get_recent_agenda($offset=0,$limit=5){
		$query=$this->db->query("SELECT * FROM agenda
		WHERE tgl_selesai > '".date('Y-m-d')."' 
		and kode_bahasa='".$this->page_lib->lang()."' 
		ORDER BY tgl_mulai asc limit ".$offset.",".$limit);
		return $query->result();
	}	
	
	function get_recent_column(){
		$query=$this->db->query("SELECT * FROM kolom WHERE  kode_bahasa='".$this->page_lib->lang()."' order by id_kolom desc limit 0,1");
		return $query->result();
	}	
		
	function get_units(){
		return  $this->db->order_by('unit_order','asc')->get("unit")->result();
	}
	
	function get_page($id){
		$q = "SELECT * FROM page WHERE id_page='$id'";
        $query = $this->db->query($q);
        return $query->result();
    
	}
	function get_dokumen($id){
		$q = "SELECT * FROM dokumen WHERE id_dokumen='$id'";
        $query = $this->db->query($q);
        return $query->result();
	}
	function get_unit($id){
		$q = "SELECT * FROM unit WHERE kode_unit='$id'";
        $query = $this->db->query($q);
        return $query->result();
    
	}
	function get_pusat_studi($id){
		$q = "SELECT * FROM pusat_studi WHERE id_pusat_studi='$id'";
        $query = $this->db->query($q);
        return $query->result();
    
	}
	function get_laboratorium($id){
		$q = "SELECT * FROM laboratorium WHERE id_lab='$id'";
        $query = $this->db->query($q);
        return $query->result();
    
	}
	function select_bagian(){
		$q = "SELECT * FROM bagian order by bagian_order asc ";
        $query = $this->db->query($q);
        return $query->result();    
	}
	function get_bagian($id){
		$q = "SELECT * FROM bagian WHERE id_bagian='$id' ";
        $query = $this->db->query($q);
        return $query->result();    
	}
	
	public function select_album($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from album");
		$config['base_url'] = site_url('id/gallery/album/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from album order by id_album DESC limit ".$offset.", ".$limit."");
	}
	
	public function search($limit,$offset,$cari){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
		$cari=str_replace("'","''",$cari);
		$tot_hal = $this->db->query("select count(*) total from (
			SELECT id_kolom as id, judul as judul, counter, tgl_posting as tanggal, 'Kolom' as tipe FROM kolom WHERE  judul like '%".$cari."%' or isi like '%".$cari."%'
			UNION ALL
			SELECT id_berita as id, judul as judul, counter, tgl_posting as tanggal, 'Berita' as tipe FROM berita WHERE judul like '%".$cari."%' or isi like '%".$cari."%'
			UNION ALL 
			SELECT id_agenda as id, nama_agenda as judul, counter, tgl_posting as tanggal, 'Agenda' as tipe FROM agenda WHERE nama_agenda like '%".$cari."%' or deskripsi like '%".$cari."%'
			UNION ALL
			SELECT id_pengumuman as id, nama_pengumuman as judul, counter, tgl_posting as tanggal, 'Pengumuman' as tipe  FROM pengumuman WHERE nama_pengumuman like '%".$cari."%'
			ORDER BY tanggal desc
			) as search")->result();
		
		foreach($tot_hal as $t){}
		
		$config['base_url'] = site_url('id/page/search/');
		$config['total_rows'] = $t->total;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$this->pagination->initialize($config);

		return $w = $this->db->query("
			SELECT id_kolom as id, judul as judul, counter, tgl_posting as tanggal, 'Kolom' as tipe, 'external' FROM kolom WHERE  judul like '%".$cari."%' or isi like '%".$cari."%'
			UNION 
			SELECT id_berita as id, judul as judul, counter, tgl_posting as tanggal, 'Berita' as tipe, 'external' FROM berita WHERE judul like '%".$cari."%' or isi like '%".$cari."%'
			UNION
			SELECT id_agenda as id, nama_agenda as judul, counter, tgl_posting as tanggal, 'Agenda' as tipe, 'external' FROM agenda WHERE nama_agenda like '%".$cari."%' or deskripsi like '%".$cari."%' 
			UNION 
			SELECT id_pengumuman as id, nama_pengumuman as judul, counter, tgl_posting as tanggal, 'Pengumuman' as tipe, url as 'external'  FROM pengumuman WHERE nama_pengumuman like '%".$cari."%'
			ORDER BY tanggal desc
			LIMIT ".$offset.", ".$limit."");
	}
	
	function archive($limit,$offset,$cari){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
		$sql="";
		switch($cari['jenis']){
			case 'liputan':
				$sql="
				SELECT id_liputan as id, judul as judul, counter, tanggal as tanggal, jam as jam, 'liputan' as tipe, 'external' 
				FROM liputan 
				WHERE YEAR(tanggal) = '".$cari['tahun']."' AND MONTH(tanggal) = '".$cari['bulan']."' ";
				break;
			case 'berita':
				$sql="
				SELECT id_berita as id, judul as judul, counter, tanggal as tanggal, jam as jam, 'Berita' as tipe, 'external' 
				FROM berita 
				WHERE YEAR(tanggal) = '".$cari['tahun']."' AND MONTH(tanggal) = '".$cari['bulan']."' ";
				break;
			case 'agenda':
				$sql="
				SELECT id_agenda as id, nama_agenda as judul, counter, tanggal_posting as tanggal, post_jam as jam, 'Agenda' as tipe, 'external'
				FROM agenda 
				WHERE YEAR(tanggal_posting) = '".$cari['tahun']."' AND MONTH(tanggal_posting) = '".$cari['bulan']."' ";
				break;
			case 'kolom':
				$sql="
				SELECT id_kolom as id, tentang as judul, counter, tanggal as tanggal,jam as jam, 'Kolom' as tipe, 'external'
				FROM kolom 
				WHERE YEAR(tanggal) = '".$cari['tahun']."' AND MONTH(tanggal) = '".$cari['bulan']."' ";
				break;
			case 'pengumuman':
				$sql="
				SELECT id_pengumuman as id, judul as judul, counter, tgl_posting as tanggal,jam_posting as jam, 'Pengumuman' as tipe, url as 'external'  
				FROM pengumuman 
				WHERE YEAR(tgl_posting) = '".$cari['tahun']."' AND MONTH(tgl_posting) = '".$cari['bulan']."' ";
				break;
		}		
		
		$tot_hal = $this->db->query($sql)->num_rows();
		
		
		$config['base_url'] = site_url('id/page/archive/');
		$config['total_rows'] = $tot_hal;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);
		
	switch($cari['jenis']){
			case 'liputan':
				$sql="
				SELECT id_liputan as id, judul as judul, counter, tanggal as tanggal, jam as jam, 'liputan' as tipe, 'external' 
				FROM liputan 
				WHERE YEAR(tanggal) = '".$cari['tahun']."' AND MONTH(tanggal) = '".$cari['bulan']."' ";
				break;
			case 'berita':
				$sql="
				SELECT id_berita as id, judul as judul, counter, tanggal as tanggal, jam as jam, 'Berita' as tipe, 'external' 
				FROM berita 
				WHERE YEAR(tanggal) = '".$cari['tahun']."' AND MONTH(tanggal) = '".$cari['bulan']."' ";
				break;
			case 'agenda':
				$sql="
				SELECT id_agenda as id, nama_agenda as judul, counter, tanggal_posting as tanggal, post_jam as jam, 'Agenda' as tipe, 'external'
				FROM agenda 
				WHERE YEAR(tanggal_posting) = '".$cari['tahun']."' AND MONTH(tanggal_posting) = '".$cari['bulan']."' ";
				break;
			case 'kolom':
				$sql="
				SELECT id_kolom as id, tentang as judul, counter, tanggal as tanggal,jam as jam, 'Kolom' as tipe, 'external'
				FROM kolom 
				WHERE YEAR(tanggal) = '".$cari['tahun']."' AND MONTH(tanggal) = '".$cari['bulan']."' ";
				break;
			case 'pengumuman':
				$sql="
				SELECT id_pengumuman as id, judul as judul, counter, tgl_posting as tanggal,jam_posting as jam, 'Pengumuman' as tipe, url as 'external'  
				FROM pengumuman 
				WHERE YEAR(tgl_posting) = '".$cari['tahun']."' AND MONTH(tgl_posting) = '".$cari['bulan']."' ";
				break;
		}
		return $w = $this->db->query($sql."LIMIT ".$offset.", ".$limit."");
	}
	
	function page_counter($id,$table){
		switch ($table) {
		case 'berita':
			$this->db->query("UPDATE berita SET counter=counter+1 WHERE id_berita='".$id."'");
			break;
		case 'kolom':
			$this->db->query("UPDATE kolom SET counter=counter+1 WHERE id_kolom='".$id."'");
			break;
		case 'agenda':
			$this->db->query("UPDATE agenda SET counter=counter+1 WHERE id_agenda='".$id."'");
			break;
		case 'liputan':
			$this->db->query("UPDATE liputan SET counter=counter+1 WHERE id_liputan='".$id."'");
			break;
		case 'pengumuman':
			$this->db->query("UPDATE pengumuman SET counter=counter+1 WHERE id_pengumuman='".$id."'");
			break;
		}
		
	
	}
	
	function encrypt001($kata = ''){
		$this->load->library('s00_lib_siaenc');
		return $this->s00_lib_siaenc->encrypt($kata);
	}
	function api_simpeg($url, $output='json', $postorget='GET', $parameter){	
		$api_url = 'http://service2.uin-suka.ac.id/servsimpeg/simpeg_public/'.$url.'/'.$output;
		$hasil = null;
		
		$this->curl->option('HTTPHEADER', array('HeaderName: '.$this->encrypt001('dedy5u__4t')));
						
		if ($postorget == 'POST'){
			$hasil = $this->curl->simple_post($api_url, $parameter);
		} else {
			$hasil = $this->curl->simple_get($api_url);
		}
		return json_decode($hasil, TRUE);
	}

	function get_berita_terkait($filter = '', $offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_berita, judul, tgl_posting from berita where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' AND ".$filter." ORDER BY tgl_posting desc LIMIT ".$offset.", ".$limit);
		return $query->result(); 
	}

	function get_berita_terpopuler($offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_berita, judul, tgl_posting from berita where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' ORDER BY counter desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_pengumuman_terkait($filter = '', $offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_pengumuman, nama_pengumuman, tgl_posting from pengumuman where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' AND ".$filter." ORDER BY tgl_posting desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_pengumuman_terpopuler($offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_pengumuman, nama_pengumuman, tgl_posting from pengumuman where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' ORDER BY counter desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}
	
	function get_liputan_terkait($filter = '', $offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_liputan, judul, tgl_posting from liputan where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' AND ".$filter." ORDER BY tgl_posting desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_liputan_terpopuler($offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_liputan, judul, tgl_posting from liputan where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' ORDER BY counter desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_kolom_terkait($filter = '', $offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_kolom, judul, tgl_posting from kolom where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' AND ".$filter." ORDER BY tgl_posting desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_kolom_terpopuler($offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_kolom, judul, tgl_posting from kolom where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' ORDER BY counter desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_agenda_terkait($filter = '', $offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_agenda, nama_agenda, tgl_posting from agenda where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' AND ".$filter." ORDER BY tgl_posting desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_agenda_terpopuler($offset = 0, $limit = 5){
		$query=$this->db->query("SELECT id_agenda, nama_agenda, tgl_posting from agenda where kode_bahasa='".$this->lang."' AND kode_unit='".$this->get_session_unit()."' ORDER BY counter desc LIMIT ".$offset.", ".$limit);
		return $query->result();
	}

	function get_social_media($id = ''){
		return $this->db->get_where('sosial_media', array('id_unit' => $id))->result();

	}

}
