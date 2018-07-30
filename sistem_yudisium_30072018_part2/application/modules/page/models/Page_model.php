<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
	function validate(){
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('membership');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}
	 public function get_session_unit(){
		$d=explode('.',str_replace('http://','',base_url()));
		$dom=$d[0];
		$query = $this->db->get_where('unit', array('subdomain'=>$dom))->row();
		return $query->kode_unit;
	}
	public function get_feed_berita($limit=0){
		return $w = $this->db->query("select * from berita order by id_berita ");
	}  
	
	
	public function daftar_berita($limit=1,$offset=0){
		return $w = $this->db->query("select * from berita order by id_berita DESC limit ".$offset.",".$limit."" )->result();
	}  
	
	function get_berita($id)
	{
		$q = $this->db->query("select * from berita where id_berita='".$id."'");
		return $q->result();
	}
	function get_slide($id)
	{
		$q = $this->db->query("select * from slide_2016 where id_slide='".$id."'");
		return $q->result();
	}
	function get_liputan($id)
	{
		$q = $this->db->query("select * from liputan where id_liputan='".$id."'");
		return $q->result();
	}
	function get_kolom($id)
	{
		$q = $this->db->query("select * from kolom where id_kolom='".$id."'");
		return $q->result();
	}
	function get_pengumuman2($id)
	{
		$q = $this->db->query("select * from pengumuman where id_pengumuman='".$id."'");
		return $q->result();
	}
	function get_dokumen($id)
	{
		$q = $this->db->query("select * from dokumen where id_dokumen='".$id."'");
		return $q->result();
	}

	// FAUZI 2018-06-08 START
	function get_album($id)
	{
		$q = $this->db->query("select * from album where id_album='".$id."'");
		return $q->result();
	}
	// FAUZI 2018-06-08 END

	function get_menu($id)
	{
		$q = $this->db->query("select * from menu where id_menu='".$id."'");
		return $q->result();
	}

	function get_video2($id){
		$q = $this->db->query("select * from video where id_video='".$id."'");
		return $q->result();
	}
	function get_penelitian($id){
		$q = $this->db->query("select * from penelitian where id_penelitian='".$id."'");
		return $q->result();
	}
	function get_peneliti($id){
		$q = $this->db->query("select * from peneliti where id_penelitian='".$id."'");
		return $q->result_array();
	}
	
	function get_page2($id)
	{
		$q = $this->db->query("select * from page where id_page='".$id."'");
		return $q->result();
	}
	function get_pusat_studi($id)
	{
		$q = $this->db->query("select * from pusat_studi where id_pusat_studi='".$id."'");
		return $q->result();
	}
	function get_laboratorium($id)
	{
		$q = $this->db->query("select * from laboratorium where id_lab='".$id."'");
		return $q->result();
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
	function get_api($url, $output='json', $postorget='GET', $parameter){ 
	//$api_url = 'http://service.uin-suka.ac.id/servsiasuper/index.php/simar_public/'.$url.'/'.$output; 
		$api_url = 'http://service2.uin-suka.ac.id/servaset/simar_public/'.$url.'/'.$output; 
		$hasil = null; 
		if ($postorget == 'POST'){
		$hasil = $this->curl->simple_post($api_url, $parameter); 
		} else { 
		$hasil = $this->curl->simple_get($api_url); 
		} 
		return json_decode($hasil, TRUE); 
	}
	public function generate_index_berita($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from berita");
		$config['base_url'] = site_url('id/berita/index/');
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
		$config['base_url'] = site_url('id/liputan/index/');
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
		$config['base_url'] = site_url('id/agenda/index/');
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
	 
	function get_arsip_pengumuman($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from pengumuman");
		$config['base_url'] = site_url('id/pengumuman/index/');
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = ' << ';
		$config['last_link'] = ' >> ';
		$config['next_link'] = ' > ';
		$config['prev_link'] = ' < ';
		$this->pagination->initialize($config);

		return $w = $this->db->query("select * from pengumuman WHERE kode_unit='".$this->get_session_unit()."' AND kode_bahasa='".$this->page_lib->lang()."' order by id_pengumuman DESC limit ".$offset.", ".$limit."");
	}
	 
	function get_arsip_kolom($limit,$offset,$filter=array()){
		$page=$offset;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
	
		$tot_hal = $this->db->query("select * from kolom");
		$config['base_url'] = site_url('id/kolom/index/');
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
		
	function get_fakultas(){
		$lang=$this->page_lib->lang();
		$query=$this->db->get_where('fakultas',array('kode_bahasa'=>$lang));
		return $query->result();
	}	
		
function get_agenda($id)
	{
		$q = $this->db->query("select * from agenda where id_agenda='".$id."'");
		return $q->row();
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
		return  $this->db->get("unit")->result();
	}

	function get_user($id){
		$sql = "SELECT * FROM user WHERE username ='$id'";
		$q 	 = $this->db->query($sql);

		return $q->result();
	}
	
	function get_page($id){
		$q = "SELECT * FROM page WHERE id_page='$id'";
        $query = $this->db->query($q);
        return $query->result();
    
	}
	function get_unit2($id){
		$q = "SELECT * FROM unit WHERE id_unit='$id'";
        $query = $this->db->query($q);
        return $query->result();
    
	}

	function get_unit($id){
		$q = "SELECT * FROM unit WHERE kode_unit='$id'";
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

	public function get_side_menu_id($id){
		return $q = $this->db->query("SELECT * FROM side_menu WHERE id_menu = '$id'")->row_array();
	}
	
}
