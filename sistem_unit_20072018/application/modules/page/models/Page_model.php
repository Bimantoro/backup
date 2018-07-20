<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
	  
	public function get_feed_berita($limit=10){
		return $w = $this->db->query("select * from berita order by id_berita DESC limit 0, ".$limit."");
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
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from berita");
		$config['base_url'] = site_url('page/berita/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from berita order by id_berita DESC limit ".$offset.", ".$limit."");
	}
		 
	public function get_arsip_liputan($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from liputan");
		$config['base_url'] = site_url('page/liputan/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from liputan order by id_liputan DESC limit ".$offset.", ".$limit."");
	}
	
	public function get_arsip_agenda($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from agenda");
		$config['base_url'] = site_url('page/agenda/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from agenda order by id_agenda DESC limit ".$offset.", ".$limit."");
	}
	 
	function get_arsip_dokumen($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from dokumen");
		$config['base_url'] = site_url('page/dokumen/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from dokumen order by id_dokumen DESC limit ".$offset.", ".$limit."");
	}
	 
	function get_arsip_pengumuman($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from pengumuman");
		$config['base_url'] = site_url('page/pengumuman/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from pengumuman order by id_pengumuman DESC limit ".$offset.", ".$limit."");
	}
	 
	function get_arsip_kolom($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from kolom");
		$config['base_url'] = site_url('page/kolom/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from kolom order by id_kolom DESC limit ".$offset.", ".$limit."");
	}
	 
	function get_arsip_ukm($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from ukm");
		$config['base_url'] = site_url('page/ukm/index/');
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
		return $w = $this->db->query("SELECT * FROM kolom where id_kolom='".$id."'");	}
	public function get_detail_ukm($id=0){
		return $w = $this->db->query("SELECT * FROM ukm where id_ukm='".$id."'");	}
		
	function get_prodi(){
		$query=$this->db->get('prodi');
		return $query->result();
	}	
		
	function get_side_menu(){
		$query=$this->db->get('side_menu');
		return $query->result();
	}	
		
	function select_fasilitas(){
		$query=$this->db->get('fasilitas');
		return $query->result();
	}	
		
	function get_agenda(){
	$hari=date('Y-m-d');
		$query=$this->db->query("SELECT * FROM agenda where tgl_mulai > '".$hari."'order by id_agenda desc limit 0,5");
		return $query->result();
	}	
	
	function get_pengumuman(){
		$query=$this->db->query("SELECT * FROM pengumuman order by id_pengumuman desc limit 0,5");
		return $query->result();
	}	
	
	function get_recent_news(){
		$query=$this->db->query("SELECT * FROM berita order by id_berita desc limit 0,1");
		return $query->result();
	}	
	
	function get_recent_agenda(){
		$query=$this->db->query("SELECT * FROM agenda
	WHERE tgl_mulai BETWEEN '".date('Y-m-d')."' and '2100-01-01' ORDER BY tgl_mulai asc LIMIT 0,5");
		return $query->result();
	}	
	
	function get_recent_column(){
		$query=$this->db->query("SELECT * FROM kolom order by id_kolom desc limit 0,1");
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
	function get_unit($id){
		$q = "SELECT * FROM unit WHERE id_unit='$id'";
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
		$config['base_url'] = site_url('page/gallery/album/');
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
		
		$tot_hal = $this->db->query("select count(*) total from (
			SELECT id_berita as id, judul as judul, tanggal as tanggal, jam as jam, 'Berita' as tipe FROM berita WHERE judul like '%".$cari."%' or isi_berita like '%".$cari."%'
			UNION ALL 
			SELECT id_agenda as id, nama_agenda as judul, tgl_posting as tanggal, jam_posting as jam, 'Agenda' as tipe FROM agenda WHERE nama_agenda like '%".$cari."%' or topik like '%".$cari."%'
			UNION ALL
			SELECT id_pengumuman as id, judul as judul, tgl_posting as tanggal,jam_posting as jam, 'Pengumuman' as tipe  FROM pengumuman WHERE judul like '%".$cari."%'
			ORDER BY tanggal desc, jam desc
			) as search")->result();
		
		foreach($tot_hal as $t){}
		
		$config['base_url'] = site_url('page/search/');
		$config['total_rows'] = $t->total;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("
			SELECT id_berita as id, judul as judul, tanggal as tanggal, jam as jam, counter, 'Berita' as tipe FROM berita WHERE judul like '%".$cari."%' or isi_berita like '%".$cari."%'
			UNION ALL 
			SELECT id_agenda as id, nama_agenda as judul, tgl_posting as tanggal, jam_posting as jam, counter, 'Agenda' as tipe FROM agenda WHERE nama_agenda like '%".$cari."%' or topik like '%".$cari."%'
			UNION ALL
			SELECT id_pengumuman as id, judul as judul, tgl_posting as tanggal,jam_posting as jam, counter, 'Pengumuman' as tipe  FROM pengumuman WHERE judul like '%".$cari."%'
			ORDER BY tanggal desc, jam desc
			LIMIT ".$offset.", ".$limit."");
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
}
