<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		/* 
		$this->load->library('Kerjasama_serv');
		$this->load->library('Webserv');
		$this->load->library('Breadcrumb2');
        $this->load->helper('file'); */
		$this->load->library('Kerjasama_serv');
		$this->load->library('Webserv');
		$this->load->library('S00_lib_api');
		$this->api 		= $this->s00_lib_api;
		$this->load->helper('page');
		$this->load->helper('format_tanggal');
		$this->load->model('web/page_model');
		$this->lang = $this->page_lib->lang();
	}

	function index()	{
		$data['berita1'] = $this->page_model->daftar_berita();

		$d=explode('.',str_replace('http://','',base_url()));
		$dom=$d[0];
		//$dom=$this->session->userdata('subdomain');
		$if = $this->db->get_where('unit',array('subdomain'=>$dom, 'kode_bahasa' => $this->lang))->row();
		if(empty($if)){
			$if = $this->db->get_where('unit',array('subdomain'=>$dom, 'kode_bahasa' => 'id'))->row();
			if(empty($if)){
				$if = $this->db->get_where('unit',array('subdomain'=>$dom))->row();
			}
		}
		$off = 1;
		if ($if->status_slider_bar==1) {
			$off = 0;
		}
		$data['berita2'] = $this->page_model->daftar_berita(4,$off);
		
		$data['statusslide'] = $this->page_model->cek_status_slider();
		$data['statusslide'] = 1;
		$data['agenda'] = $this->page_model->daftar_agenda_aktif(2,0);
		$data['pengumuman'] = $this->page_model->daftar_pengumuman(5,0);
		$data['kolom'] = $this->page_model->daftar_kolom(2,0);
		$data['liputan'] = $this->page_model->daftar_liputan(2,0);
		//$data['unit'] = $this->page_model->daftar_nama_side_unit();
		$data['slide'] = $this->page_model->daftar_slide();
		//$data['side'] = $this->page_model->daftar_side_menu();
		$data['side'] = $this->page_model->daftar_side_menu();

		$jml_side = count($data['side']);
		if($jml_side > 0){
			$data['status_sidemenu'] = 1;
		}else{
			$data['status_sidemenu'] = 0;
		}

		$temps = $this->page_model->status_slider_unit($this->lang);
		if(empty($temps)){
			$temps = $this->page_model->status_slider_unit('id');
			if(empty($temps)){
				$temps = $this->page_model->status_slider_unit();
			}
		}
		$data['status_slider'] = $temps['status_slider_bar'];

		/*echo "<pre>";
		print_r($data['unit']);
		echo "<pre>";
		die();*/
		$data['main_view']="web/stars";
		$this->load->view('web/content2',$data);
		/* $this->load->view('page/header',$data);
		$this->load->view('page/home');
		$this->load->view('page/footer'); */

	}
	function laboratorium($id=0){
		$get_data = $this->db->get_where("laboratorium",array('id_lab'=>$id));
		$lab = $get_data->row();
		if($get_data->num_rows()>0){
		 	$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb(substr($lab->nama_lab,0,130).'', '/');
			$data['title']=$lab->nama_lab;
			//$this->page_model->page_counter($id,'berita');
			
			$data['d'] = $this->db->get_where('laboratorium',array('id_lab'=>$id))->row();
			/* $arr_filter=array();
			$arr_filter=related_text($lab->nama_lab);	
			$filter	="WHERE id_berita <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_berita,judul,tgl_posting from berita ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_berita,judul,tgl_posting from berita ORDER BY counter desc LIMIT 0,5")->result();
			$data['sidebar']=array('search_sidebar', 'arsip_berita_sidebar'); */
			$data['main_view']="web/laboratorium/unit_view";				
			$this->load->view('web/content',$data);
			
				
		}else{
	      	redirect(base_url());
		}
	}
	
	function index5()	{
		/* $data['fakultas'] = $this->page_model->get_fakultas();
		$data['pengumuman'] = $this->page_model->get_pengumuman(1,4);
		$data['kolom'] = $this->page_model->get_recent_column();
		$data['berita'] = $this->page_model->get_recent_news();
		$data['berita2'] = $this->page_model->get_recent_news(1,4);
		$data['agenda'] = $this->page_model->get_recent_agenda(1,4);
		 */
		 
		$data['main_view']="page/stars";
       $this->load->view('page/content',$data);
		/* $this->load->view('page/header',$data);
		$this->load->view('page/home');
		$this->load->view('page/footer'); */
	}
	
	function akademik($id=''){
		if($id=='kalender'){
			$menu="Kalender Akademik";
		}else if($id=='pedoman'){
			$menu="Pedoman Akademik";
		}
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb($menu, '/');
		$url='http://www.uin-suka.ac.id/index.php/service/document/'.$id;
		$data=file_get_contents($url);
		$data=json_decode($data);	
		$data['doc']=$data;
		/* $this->load->view('page/header',$data);
		$this->load->view('page/bg_breadcumb');
		$this->load->view('page/left-side');
		$this->load->view('page/prodi/document_view');
		$this->load->view('page/right-side');
		$this->load->view('page/footer'); */
		$data['main_view']="web/prodi/document_view";				
		$this->load->view('web/content',$data);
	}
	function kurikulum(){
		header("Cache-Control: no cache");
		$lang = $this->page_lib->lang();
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $lang)), base_url($lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Kurikulum', $lang)), '/');
		
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$kurikulum = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST',
		array('api_kode'=>38000, 'api_subkode' => 7,
		'api_search' => array($kd_prodi))); 
		$data['kurikulum']=$kurikulum;
	//	print_r($kurikulum);
		$kd_kur_prodi="";
		if($_POST==null){
			if($kurikulum){
				foreach($kurikulum as $kur){
					if($kur['STATUS']=='AKTIF'){
						$dk[]=array('kode_kurikulum'=>$kur['KD_KUR'],'nama_kurikulum'=>$kur['NM_KUR']);	
						$kd_kur_prodi=$kur['KD_KUR'];
					}			
				}
			}
		}else{
			$kd_kur_prodi=$this->input->post('kurikulum');
		}
		$mk=$this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST',
		array('api_kode'=>40000, 'api_subkode' => 15,'api_search' => array($kd_kur_prodi))); 
		$mk=json_decode(json_encode($mk,false));
	//	print_r($mk);
		$armk=array();
		if($mk){
			foreach($mk as $m){
			
			//	$this->db->query("INSERT into mata_kuliah(kd_mk,kd_kurikulum,kd_prodi,nm_mk,sks) VALUES('".$m->KD_MK."','".$m->KD_KUR."','".$m->KD_PRODI."','".str_replace("'","''",$m->NM_MK)."','".$m->SKS_MK."')");
				$armk[$m->SEMESTER_PAKET][]=(object)array('kd_kur'=>$m->KD_KUR,'kd_mk'=>$m->KD_MK,'nm_mk'=>$m->NM_MK,'semester_paket'=>$m->SEMESTER_PAKET,'sks_mk'=>$m->SKS_MK,'jenis_mk'=>$m->NM_JENIS_MK);	
			}
		}
		//print_r($armk);
		$data['armk']=$armk;
		$data['kd_kur']=$kd_kur_prodi;
		$data['main_view']="web/prodi/kurikulum_view";				
		$this->load->view('web/content',$data);
	}

	function mata_kuliah($kd_kur="",$kd_mk=""){
		$lang = $this->lang;
		if($kd_mk){			
			$kd_prodi=get_prodi();
			$this->load->library('s00_lib_api');
			$mk = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST', 
			array('api_kode'=>40000, 'api_subkode' => 17, 'api_search' => 
			array($kd_prodi, $kd_kur, $kd_mk))); 
			$nm_mk=$mk[0]['NM_MK'];
			$mk=json_decode(json_encode($mk,false));
			$data['mk']=$mk;
			$nim="";
			$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $lang)), base_url($lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Kurikulum', $lang)), site_url($lang.'/page/kurikulum'));
			$this->breadcrumb->append_crumb($nm_mk, '/');
			$mkps = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST',
			array('api_kode'=>41000, 'api_subkode' => 4,
			'api_search' => array($kd_prodi, $kd_kur, $kd_mk, $nim))); 
			$mkps=json_decode(json_encode($mkps,false));
			$data['mkps']=$mkps;
			
			$mks = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST',
			array('api_kode'=>42000, 'api_subkode' => 6,
			'api_search' => array($kd_prodi, $kd_kur, $kd_mk)));
			$mks=json_decode(json_encode($mks,false));
			$data['mks']=$mks;
			
			$mkk = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_penawaran/data_search', 'POST',
			array('api_kode'=>59000, 'api_subkode' => 6,
			'api_search' => array($kd_prodi, $kd_kur, $kd_mk))); 
			$mkk=json_decode(json_encode($mkk,false));
			$data['mkk']=$mkk;
			$data['main_view']="web/prodi/mata_kuliah_view";				
			$this->load->view('web/content',$data);

		}else{
			redirect('page/dosen');
		}	
	}
	function jadwal_kuliah(){
		header("Cache-Control: no cache");
		$lang = $this->page_lib->lang();

		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $lang)), base_url($lang));
		$this->breadcrumb->append_crumb(ucwords(dict('Jadwal Kuliah', $lang)), '/');
		
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
		array('api_kode'=>50000, 'api_subkode'=>2));
		$taa=$tasmt_sekarang['data'];
		$cta=$taa[':hasil1'];
		$sm=$taa[':hasil3'];
		$data['cta']=$taa[':hasil1'];
		$data['tad']=$taa[':hasil2'];
		$ta=$this->input->post('ta');
		if($ta==null)$ta=$taa[':hasil1'];
		$data['ta']=$ta;		
		$smt=$this->input->post('smt');
		if($smt==null)$smt=$taa[':hasil3'];
		$data['smt']=$smt;
		$jadwal = $this->s00_lib_api->get_api(URL_API_SIA.'sia_penawaran/data_search', 'POST', 
				array('api_kode'=>58000, 'api_subkode' => 39, 
				'api_search' =>array($ta, $smt, $kd_prodi)));
		$jadwal=json_decode($jadwal);
		//echo"<!--";
	//	print_r($jadwal);
	//	echo"-->";
		$arj=array();
		foreach($jadwal as $d){
		$kds=explode('+',$d->TIM_AJAR);
			/* $this->db->query(
			"INSERT INTO kelas(kd_kelas, kd_prodi, kd_ta, kd_semester, kd_kurikulum, kd_mk, jml_mhs,kelas,kd_dosen)
			VALUES ('".$d->KD_KELAS."','".$d->KD_PRODI."','".$d->KD_TA."','".$d->KD_SMT."','".$d->KD_KUR."','".$d->KD_MK."','".$d->TERISI."','".$d->KELAS_PARAREL."','".$kds[0]."');"
			); */
			$arw=explode(" ",$d->JADWAL1);
			$jam=$arw[1];
			$ruang=$arw[4];
			$arj[$d->KD_HARI][]=array('kd_mk'=>$d->KD_MK,'mk'=>$d->NM_MK,'jam'=>$jam,'ruang'=>$ruang,'kelas'=>$d->KELAS_PARAREL,'tim_ajar'=>$d->TIM_AJAR);
		}
		// $arj[8]=$arj['1'];
		// unset($arj['1']);
		ksort($arj);
		
		
		//print_r($arj);
		$data['arj']=$arj;
		$data['main_view']="web/prodi/jadwal_view";				
		$this->load->view('web/content',$data);
		
	}
	function jadwal_ujian(){

		header("Cache-Control: no cache");
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucwords(dict('Jadwal Ujian', $this->lang)), '/');
		
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
		array('api_kode'=>50000, 'api_subkode'=>2));
		$taa=$tasmt_sekarang['data'];
		$cta=$taa[':hasil1'];
		$sm=$taa[':hasil3'];
		$data['cta']=$taa[':hasil1'];
		$data['tad']=$taa[':hasil2'];
		
		$ta=$this->input->post('ta');
		if($ta==null)$ta=$taa[':hasil1'];
		$data['ta']=$ta;		
		$smt=$this->input->post('smt');
		if($smt==null)$smt=$taa[':hasil3'];
		$data['smt']=$smt;
		$ju=$this->input->post('ju');
		if($ju==null)$ju=1;
		$data['ju']=$ju;
		
		$jadwal = $this->s00_lib_api->get_api(URL_API_SIA.'sia_absensi/data_search', 'POST', 
				array('api_kode'=>75000, 'api_subkode' => 10, 
				'api_search' =>array($ta, $smt, $kd_prodi,$ju)));
		$jadwal=json_decode($jadwal);
	//	print_r($jadwal);
	$arj=array();
		foreach($jadwal as $d){
			$arw=explode(" ",$d->JADWAL1);
			$jam=$d->JAM_MULAI.' s.d '.$d->JAM_SELESAI;
			$arr=explode('#',$d->NO_RUANG);
			$ar_ruang=array();
			foreach($arr as $ar){
				$arn=explode('$',$ar);
				@$ar_ruang[]=$arn['1'];
			}	
			$ruang=implode('<br>',$ar_ruang);
			
			$artgl=explode(" ",$d->TGL_F);
			if($artgl[0]!=null){
				$tgl=mysql_date2($artgl[0]);
				$arj[$tgl][]=array('kd_mk'=>$d->KD_MK,'mk'=>$d->NM_MK,'jam'=>$jam,'ruang'=>$ruang,'kelas'=>$d->KELAS_PARAREL,'tim_ajar'=>$d->TIM_AJAR);
			}else{
				$tgl="";
			}	
		}
		ksort($arj);
		$data['arj']=$arj;
	//	$data['uts']=$jadwal;
	//	print_r($arj);
		$data['main_view']="web/prodi/jadwal_ujian_view";				
		$this->load->view('web/content',$data);
	}
	function kalender($id=''){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucwords(dict('Kalender Akademik', $this->lang)), '/');
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
		array('api_kode'=>50000, 'api_subkode'=>2));
		$taa=$tasmt_sekarang['data'];
		$cta=$taa[':hasil1'];
		$sm=$taa[':hasil3'];
		$data['cta']=$taa[':hasil1'];
		$data['tad']=$tad=$taa[':hasil2'];
		$ta=$this->input->post('ta');
		if($ta==null)$ta=$taa[':hasil1'];
		$data['ta']=$ta;		
		$smt=$this->input->post('smt');
		if($smt==null)$smt=$taa[':hasil3'];
		$data['smt']=$smt;
		
		$data['kalender']=$kalender = $this->s00_lib_api->get_api(URL_API_SIA.'sia_master/data_search', 'POST', 
				array('api_kode'=>16001, 'api_subkode' => 2, 
				'api_search' =>array($ta, $smt, $kd_prodi)));
		$data['kalender']=json_decode($kalender);	
		$dk=array();
		
				$arr_smt = array( 1 => 'Gasal', 2=> 'Genap', 3 => 'Pendek');
		foreach($data['kalender'] as $k){
			if($k->T_SPP_BYR_1_F!=null and $k->T_SPP_BYR_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran biaya pendidikan","tgl_mulai"=>$k->T_SPP_BYR_1_F,"tgl_selesai"=>$k->T_SPP_BYR_2_F);
			}
			if($k->T_KRS_ISI_1_F!=null and $k->T_KRS_ISI_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pengisian KRS","tgl_mulai"=>$k->T_KRS_ISI_1_F,"tgl_selesai"=>$k->T_KRS_ISI_2_F);
			}
			if($k->T_KRS_REV_1_F!=null and $k->T_KRS_REV_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Revisi KRS","tgl_mulai"=>$k->T_KRS_REV_1_F,"tgl_selesai"=>$k->T_KRS_REV_2_F);
			}
			if($k->T_KRS_DSN_1_F!=null and $k->T_KRS_DSN_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Konsultasi dengan Dosen Penasihat Akademik (DPA) ","tgl_mulai"=>$k->T_KRS_DSN_1_F,"tgl_selesai"=>$k->T_KRS_DSN_2_F);
			}
			if($k->T_MKB_BYR_1_F!=null and $k->T_MKB_BYR_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran mata kuliah berbayar","tgl_mulai"=>$k->T_MKB_BYR_1_F,"tgl_selesai"=>$k->T_MKB_BYR_2_F);
			}
			if($k->T_SMT_AKT_1_F!=null and $k->T_SMT_AKT_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Awal dan akhir semester","tgl_mulai"=>$k->T_SMT_AKT_1_F,"tgl_selesai"=>$k->T_SMT_AKT_2_F);
			}
			if($k->T_SMT_UTS_1_F!=null and $k->T_SMT_UTS_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Ujian Tengah Semester (UTS)","tgl_mulai"=>$k->T_SMT_UTS_1_F,"tgl_selesai"=>$k->T_SMT_UTS_2_F);
			}
			if($k->T_SMT_UAS_1_F!=null and $k->T_SMT_UAS_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Ujian Akhir Semester (UAS)","tgl_mulai"=>$k->T_SMT_UAS_1_F,"tgl_selesai"=>$k->T_SMT_UAS_2_F);
			}
			if($k->T_SMT_IKD_1_F!=null and $k->T_SMT_IKD_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pengisian kuisioner Indekx Kinerja Dosen","tgl_mulai"=>$k->T_SMT_IKD_1_F,"tgl_selesai"=>$k->T_SMT_IKD_2_F);
			}
			if($k->T_KKN_PE1_1_F!=null and $k->T_KKN_PE1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pra Pendaftaran KKN Periode I Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_PE1_1_F,"tgl_selesai"=>$k->T_KKN_PE1_2_F);
			}
			if($k->T_KKN_BR1_1_F!=null and $k->T_KKN_BR1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran KKN Periode I Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_BR1_1_F,"tgl_selesai"=>$k->T_KKN_BR1_2_F);
			}
			if($k->T_KKN_DF1_1_F!=null and $k->T_KKN_DF1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran KKN Periode I Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_DF1_1_F,"tgl_selesai"=>$k->T_KKN_DF1_2_F);
			}
			if($k->T_KKN_KG1_1_F!=null and $k->T_KKN_KG1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan KKN Periode I Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_KG1_1_F,"tgl_selesai"=>$k->T_KKN_KG1_2_F);
			}
			if($k->T_KKN_PE2_1_F!=null and $k->T_KKN_PE2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pra Pendaftaran KKN Periode II Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_PE2_1_F,"tgl_selesai"=>$k->T_KKN_PE2_2_F);
			}
			if($k->T_KKN_BR2_1_F!=null and $k->T_KKN_BR2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran KKN Periode II Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_BR2_1_F,"tgl_selesai"=>$k->T_KKN_BR2_2_F);
			}
			if($k->T_KKN_DF2_1_F!=null and $k->T_KKN_DF2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran KKN Periode II Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_DF2_1_F,"tgl_selesai"=>$k->T_KKN_DF2_2_F);
			}
			if($k->T_KKN_KG2_1_F!=null and $k->T_KKN_KG2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan KKN Periode II Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_KG2_1_F,"tgl_selesai"=>$k->T_KKN_KG2_2_F);
			}
			if($k->T_KKN_PE3_1_F!=null and $k->T_KKN_PE3_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pra Pendaftaran KKN Periode III Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_PE3_1_F,"tgl_selesai"=>$k->T_KKN_PE3_2_F);
			}
			if($k->T_KKN_BR3_1_F!=null and $k->T_KKN_BR3_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran KKN Periode III Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_BR3_1_F,"tgl_selesai"=>$k->T_KKN_BR3_2_F);
			}
			if($k->T_KKN_DF3_1_F!=null and $k->T_KKN_DF3_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran KKN Periode III Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_DF3_1_F,"tgl_selesai"=>$k->T_KKN_DF3_2_F);
			}
			if($k->T_KKN_KG3_1_F!=null and $k->T_KKN_KG3_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan KKN Periode III Semester ".$arr_smt[$smt]." TA ".$tad,"tgl_mulai"=>$k->T_KKN_KG3_1_F,"tgl_selesai"=>$k->T_KKN_KG3_2_F);
			}
			if($k->T_UED_DF1_1_F!=null and $k->T_UED_DF1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran User Education","tgl_mulai"=>$k->T_UED_DF1_1_F,"tgl_selesai"=>$k->T_UED_DF1_2_F);
			}
			if($k->T_UED_KG1_1_F!=null and $k->T_UED_KG1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan User Education","tgl_mulai"=>$k->T_UED_KG1_1_F,"tgl_selesai"=>$k->T_UED_KG1_2_F);
			}
			if($k->T_UED_UN1_1_F!=null and $k->T_UED_UN1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Ujian User Education","tgl_mulai"=>$k->T_UED_UN1_1_F,"tgl_selesai"=>$k->T_UED_UN1_2_F);
			}
			if($k->T_ICT_DF1_1_F!=null and $k->T_ICT_DF1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran Training ICT","tgl_mulai"=>$k->T_ICT_DF1_1_F,"tgl_selesai"=>$k->T_ICT_DF1_2_F);
			}
			if($k->T_ICT_KG1_1_F!=null and $k->T_ICT_KG1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan Training ICT","tgl_mulai"=>$k->T_ICT_KG1_1_F,"tgl_selesai"=>$k->T_ICT_KG1_2_F);
			}
			if($k->T_ICT_UN1_1_F!=null and $k->T_ICT_UN1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Ujian Training ICT","tgl_mulai"=>$k->T_ICT_UN1_1_F,"tgl_selesai"=>$k->T_ICT_UN1_2_F);
			}
			if($k->T_YSD_MQ1_1_F!=null and $k->T_YSD_MQ1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan ujian tugas akhir untuk wisuda periode I TA ".$tad,"tgl_mulai"=>$k->T_YSD_MQ1_1_F,"tgl_selesai"=>$k->T_YSD_MQ1_2_F);
			}
			if($k->T_YSD_DF1_1_F!=null and $k->T_YSD_DF1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>" Yudisium untuk wisuda periode I TA ".$tad,"tgl_mulai"=>$k->T_YSD_DF1_1_F,"tgl_selesai"=>$k->T_YSD_DF1_2_F);
			}
			if($k->T_WSD_BR1_1_F!=null and $k->T_WSD_BR1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran biaya pendaftaran wisuda periode I TA ".$tad,"tgl_mulai"=>$k->T_WSD_BR1_1_F,"tgl_selesai"=>$k->T_WSD_BR1_2_F);
			}
			if($k->T_WSD_DF1_1_F!=null and $k->T_WSD_DF1_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran wisuda periode I TA ".$tad,"tgl_mulai"=>$k->T_WSD_DF1_1_F,"tgl_selesai"=>$k->T_WSD_DF1_2_F);
			}
			if($k->T_YSD_MQ2_1_F!=null and $k->T_YSD_MQ2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pelaksanaan ujian tugas akhir untuk wisuda periode II TA ".$tad,"tgl_mulai"=>$k->T_YSD_MQ2_1_F,"tgl_selesai"=>$k->T_YSD_MQ2_2_F);
			}
			if($k->T_YSD_DF2_1_F!=null and $k->T_YSD_DF2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>" Yudisium untuk wisuda periode II TA ".$tad,"tgl_mulai"=>$k->T_YSD_DF2_1_F,"tgl_selesai"=>$k->T_YSD_DF2_2_F);
			}
			if($k->T_WSD_BR2_1_F!=null and $k->T_WSD_BR2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pembayaran biaya pendaftaran wisuda periode II TA ".$tad,"tgl_mulai"=>$k->T_WSD_BR2_1_F,"tgl_selesai"=>$k->T_WSD_BR2_2_F);
			}
			if($k->T_WSD_DF2_1_F!=null and $k->T_WSD_DF2_1_F!='01-01-1900 00:00:00'){
				$dk[]=(object)array("kegiatan"=>"Pendaftaran wisuda periode II TA ".$tad,"tgl_mulai"=>$k->T_WSD_DF2_1_F,"tgl_selesai"=>$k->T_WSD_DF2_2_F);
			}
		}
		$data['dk']=$dk;
		$data['main_view']="web/prodi/kalender_view";				
		$this->load->view('web/content',$data);
	}
	function index3()
	{
		$data['fakultas'] = $this->page_model->get_fakultas();
		$data['pengumuman'] = $this->page_model->get_pengumuman(1,3);
		$data['kolom'] = $this->page_model->get_recent_column();
		$data['liputan'] = $this->page_model->get_recent_liputan();
		$data['berita'] = $this->page_model->get_recent_news(0,1);
		$data['berita2'] = $this->page_model->get_recent_news(1,3);
		$data['agenda'] = $this->page_model->get_recent_agenda(1,3);
		
		$this->load->view('page/header3',$data);
		$this->load->view('page/home3');
		$this->load->view('page/footer3');
	}

	function tes()
	{
		
		$this->load->view('page/tes');
	}


	function universitas($id=0){
		$this->load->model('page_model');
		$data['page'] = $this->page_model->get_page($id);
		if( !$data ){
			return false;
		}else{
			$data_page = $this->db->get_where("page",array('id_page'=>$id));
		    $page = $data_page->row();
			if($data_page->num_rows()>0){
				$this->breadcrumb->append_crumb('Beranda', base_url());;
				$this->breadcrumb->append_crumb($page->title, '/');
				
				$data['page'] = $this->page_model->get_page($id);
	
			$data['content']="page/universitas/detail_view";				
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
			}
		}			
	}
	function identity($id=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Corporate Identity', '/');
	
		$data['content']="page/universitas/identity_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	function bendera($id=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Bendera & Busana', '/');
	
		$data['content']="page/universitas/bendera_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	function statuta($id=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Dasar Hukum', '/');
		$data['id_album'] = $id;
		$data['pictures'] = array_slice(array_diff(scandir('./media/identity'), array('.', '..', '.tmb','.quarantine')),0,40);
	
		$data['content']="page/universitas/statuta_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	function organisasi($id=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Manajemen & Organisasi', '/');
		$data['id_album'] = $id;
		$data['pictures'] = array_slice(array_diff(scandir('./media/organisasi'), array('.', '..', '.tmb','.quarantine')),0,40);
			
		$data['content']="page/universitas/organisasi_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	function kerjasama(){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Kerjasama', '/');
		$data['tahun'] =$th= $this->kerjasama_serv->kerjasama_post('kerjasama/tahun_get');
		$data['institusi'] = $this->kerjasama_serv->kerjasama_post('kerjasama/jenis_institusi');
		$data['asal_institusi'] = $this->kerjasama_serv->kerjasama_post('kerjasama/asal_institusi_get');
		$data['lingkup_kerjasama'] = $this->kerjasama_serv->kerjasama_post('kerjasama/lingkup_kerjasama_get');
		//print_r($data['asal_institusi']);
		if($_POST==null){			
			$postdata['TAHUN']=$data['ts']=$th[0]->TAHUN;
			$postdata['INSTITUSI']=$data['is']="";
			$postdata['ASAL_INSTITUSI']=$data['ais']="";
			$postdata['LINGKUP_KERJASAMA']=$data['lks']="";
		}else{
			$postdata['TAHUN']=$data['ts']=$this->input->post('tahun');
			$postdata['INSTITUSI']=$data['is']=$this->input->post('institusi');
			$postdata['ASAL_INSTITUSI']=$data['ais']=$this->input->post('asal_institusi');
			$postdata['LINGKUP_KERJASAMA']=$data['lks']=$this->input->post('lingkup_kerjasama');
		}	
		$data['kerjasama'] = $this->kerjasama_serv->kerjasama_post('kerjasama/kerjasama_post',$postdata);
		$parameter = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array());
			$ck=$this->api->get_api_json(URL_API_SIMPEG1.'simpeg_mix/data_view', 'POST',$parameter);
			$arr_ck=array();
			foreach($ck as $c){
				$arr_ck[$c['UNIT_ID']]=array('NAMA_UNIT'=>$c['UNIT_NAMA']);
			}
			$data['ck']=$arr_ck;
		$data['content']="page/universitas/kerjasama_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	
	function data_fakta(){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Data & Fakta', '/');
		$data['lembaga'] = $this->kerjasama_serv->akreditasi_post('akreditasi/get_lembaga');
		if($_POST==null){			
			$postdata['LEMBAGA']=$data['is']="01";
		}else{
			$postdata['LEMBAGA']=$data['is']=$this->input->post('lembaga');
		}	
		$data['akreditasi'] = $this->kerjasama_serv->akreditasi_post('akreditasi/akreditasi_list',$postdata);
	//	print_r($data['akreditasi']);
		$parameter = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array());
			$ck=$this->api->get_api_json(URL_API_SIMPEG1.'simpeg_mix/data_view', 'POST',$parameter);
			$arr_ck=array();
			foreach($ck as $c){
				$arr_ck[$c['UNIT_ID']]=array('NAMA_UNIT'=>$c['UNIT_NAMA']);
			}
			$data['ck']=$arr_ck;
		$data['content']="page/universitas/data_fakta_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	
	function mou($id=''){
		$postdata=array('ID_KERJASAMA'=>$id);
		$data=$this->kerjasama_serv->kerjasama_post('kerjasama/sertifikat',$postdata);
		$file_isi = $data->file;
		$file_nama = $data->nama_file;
		$header=get_mime_by_extension(str_replace(' ','',$file_nama));
		if($file_nama){
			header("Content-Type: ".$header);
			flush();
			echo base64_decode($file_isi);
			exit; 
		}else{
			echo "Thanks for landing captain!";
		}
	}
	
	function sertifikat($id=''){
		$this->load->helper('file');
		$postdata=array('KODE_UNIT'=>$id);
		$data=$this->kerjasama_serv->akreditasi_post('akreditasi/sertifikat',$postdata);
		$file_isi = $data->file;
		$file_nama = $data->nama_file;
		$mime = get_mime_by_extension($file_nama);
		if($file_nama){
			header("Content-Type: ".$mime);
			flush();
			echo base64_decode($file_isi);
			exit;
		}else{
			echo "Thanks for landing captain!";
		}
	}
	
	function cv_dosen($id=''){
		
        $this->load->helper('file');
		$data= $this->webserv->bkd_post('bkd_dosen/cv_dosen/'.$id);
		$file_isi = $data->FILE_CV;
		$file_nama = $data->NAMA_FILE_CV;
		echo $header=get_mime_by_extension($file_nama);
		if($file_nama){
			header("Content-Type: ".$header);
			flush();
			echo base64_decode($file_isi);
			exit; 
		}else{
			echo "Thanks for landing captain!";
		}
	}
	
	
	function dosen2(){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Dosen',$this->lang)), '/');
		$data['ap']=$prodi=$this->input->post('prodi');
		$postdata=array('KODE_PRODI'=>$prodi);
		$data['prodi'] = $this->kerjasama_serv->akreditasi_post('dosen/prodi_list');
		$data['dosen']=$this->kerjasama_serv->akreditasi_post('dosen/dosen_list',$postdata);	
		//print_r($data['dosen']);
		/*$data['content']="page/universitas/dosen_view";	
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');*/
		$data['main_view']="web/prodi/dosen_view";				
		$this->load->view('web/content',$data);
	}

	function dosen(){

		header("Cache-Control: no cache");
		//session_cache_limiter("private_no_expire");
		$lang=$this->page_lib->lang();
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url($lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Dosen',$lang)), '/');
		if($_POST==null){
			$opt=0;
		}else{
			$opt=$this->input->post('asal_dosen');
		}
		
		$data['asal_dosen']=$opt;
		$jd=$this->input->post('jenis_dosen');
		$sd=$this->input->post('status_dosen');

		if($jd==null)$jd=0;
		if($sd==null)$sd=0;

		$kd_prodi=get_prodi();

		$this->load->library('s00_lib_api');
		
		$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
		array('api_kode'=>50000, 'api_subkode'=>2));
		$taa=$tasmt_sekarang['data'];
		$kd_ta=$taa[':hasil1'];
		$kd_smt=$taa[':hasil3'];
		
		$dosen= $this->api->get_api_json(URL_API_SIA.'sia_penawaran/data_search',
									 'POST',
									 array('api_kode'=>58002, 'api_subkode' => 9, 'api_search' => array($kd_prodi, $opt, $sd)));

		$data['jd']=$jd;
		$data['sd']=$sd;
		$data['dosen']=$dosen;
		$data['main_view']="web/prodi/dosen_view";				
		$this->load->view('web/content',$data);	
	}
	
	function dosen_old(){
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Dosen', '/');
		if($_POST==null){
			$opt=0;
		}else{
			$opt=$this->input->post('asal_dosen');
		}
		
		$data['asal_dosen']=$opt;
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		
		$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
		array('api_kode'=>50000, 'api_subkode'=>2));
		$taa=$tasmt_sekarang['data'];
		$kd_ta=$taa[':hasil1'];
		$kd_smt=$taa[':hasil3'];
		
		$dosen = $this->s00_lib_api->get_api(URL_API_SIA.'sia_penawaran/data_search', 'POST', 
				array('api_kode'=>58002 , 'api_subkode' => 7, 
				'api_search' =>array($kd_prodi,$opt)));
		$dosen=json_decode($dosen);
		$ard=array();
		$ardlb_aktif = array();
		$ardlb = array();
		$ardlb_nonaktif = array();
		$ardpns_aktif = array();
		$ardpns = array();
		$ardpns_nonaktif = array();
		//print_r($dosen);
		if(!empty($dosen)){
			foreach($dosen as $d){
				if($d->KD_DOSEN!=null){
					if(strlen($d->KD_DOSEN)==18 and substr($d->KD_DOSEN,15,1)==0){
						$ardpns[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);					
						$dosen_aktif = $this->s00_lib_api->get_api(URL_API_SIA.'sia_penawaran/data_search', 'POST', 
						array('api_kode'=>58000 , 'api_subkode' => 34, 
						'api_search' =>array($kd_ta, $kd_smt, $d->KD_DOSEN)));
						if(count(json_decode($dosen_aktif))>0){
							$ardpns_aktif[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);
						}else{
							$ardpns_nonaktif[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);
						}
					}else{
						$ardlb[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);					
						$dosen_aktif = $this->s00_lib_api->get_api(URL_API_SIA.'sia_penawaran/data_search', 'POST', 
						array('api_kode'=>58000 , 'api_subkode' => 34, 
						'api_search' =>array($kd_ta, $kd_smt, $d->KD_DOSEN)));
						if(count(json_decode($dosen_aktif))>0){
							$ardlb_aktif[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);
						}else{
							$ardlb_nonaktif[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);
						}
					}
					
					
					$ard[]=(object)array('kd_dosen'=>$d->KD_DOSEN,'nm_dosen'=>$d->NM_DOSEN_F);
				}
			}
		}
		/*  $dosen_aktif = $this->s00_lib_api->get_api(URL_API_SIA.'sia_penawaran/data_search', 'POST', 
					array('api_kode'=>58000 , 'api_subkode' => 34, 
					'api_search' =>array(2014, 1, '197710122006041002')));
		 echo count(json_decode($dosen_aktif)); */
	//	print_r($ardpns_aktif);
		$jd=$this->input->post('jenis_dosen');
		$sd=$this->input->post('status_dosen');
		if($jd==null)$jd=0;
		if($sd==null)$sd=0;
		$adosen=array($ardpns,$ardlb,$ard);
		$sdosen=$adosen[$jd];
		$ad_status[0]=array($ardpns_aktif,$ardpns_nonaktif,$sdosen);
		$ad_status[1]=array($ardlb_aktif,$ardlb_nonaktif,$sdosen);

		if($jd == 2){
			if($sd == 2){
				$dosen = $ard;
			}else if($sd == 0){
				$dosen = array_merge($ardpns_aktif, $ardlb_aktif);
			}else{
				$dosen = array_merge($ardpns_nonaktif, $ardlb_nonaktif);
			}
			
		}else{
			$dosen=$ad_status[$jd][$sd];
		}
		
		$data['jd']=$jd;
		$data['sd']=$sd;
		//print_r($ard);
		$data['dosen']=$dosen;
		$data['main_view']="web/prodi/dosen_view";				
		$this->load->view('web/content',$data);	
	}
	
	function detil_dosen($kd_dosen="",$history=""){
		$lang=$this->page_lib->lang();
		$this->load->library('s00_lib_api');
		$data['prodi'] = $this->kerjasama_serv->akreditasi_post('dosen/prodi_list');
		$dosen=$this->s00_lib_api->get_api_json(URL_API_SIA.'sia_dosen/data_search', 'POST', 
			array('api_kode'=>20000, 'api_subkode' => 16, 'api_search' => array($kd_dosen)));
		//	print_r($dosen);die();
		if($dosen){
			$kd_prodi=$dosen[0]['KD_PRODI'];
			$data['dosen']=$dosen;
			$data['kd_dosen']=$kd_dosen;
			$ta=null;
			$smt=null;
			$data['foto']= $this->tf_encode('FOTOMASUK#'.$kd_dosen.'#QL:100#WM:1#SZ:200');
			
			$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
			array('api_kode'=>50000, 'api_subkode'=>2));
			$taa=$tasmt_sekarang['data'];
			$cta=$taa[':hasil1'];
			$sm=$taa[':hasil3'];
			$data['cta']=$taa[':hasil1'];
			$data['tad']=$taa[':hasil2'];
			$ta=$taa[':hasil1'];
			$smt=$taa[':hasil3'];
			
			$ta=$this->input->post('ta');
			if($ta==null)$ta=$taa[':hasil1'];
			$data['ta']=$ta;		
			$smt=$this->input->post('smt');
			if($smt==null)$smt=$taa[':hasil3'];
			$data['smt']=$smt;		
			
			$nm_dosen=$dosen[0]['NM_DOSEN_F'];
			$nip=$dosen[0]['NIP'];
			$data['nidn']=$dosen[0]['NIDN'];
			$data['nm_dosen']=$nm_dosen;
			$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url($lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Dosen',$lang)), site_url($lang.'/page/dosen'));
			$this->breadcrumb->append_crumb($nm_dosen, '/');
			
			$URL_API_BKD = 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/';
			$email=json_decode(file_get_contents("http://service.uin-suka.ac.id/servad/adgetuserdetils.php?aud=7f304662ebfee3g82f2e810aa8fbc24j25&src=".$nip),true);
			$data['email']=str_replace(".","[dot]",str_replace("@","[at]",$email[0][427][0]['EMAIL']));
			
			$parameter = array('api_kode' => 1122, 'api_subkode' => 13, 'api_search' => array(date('d/m/Y'), $kd_dosen));
			$jf = $this->page_model->api_simpeg('simpeg_mix/data_search', 'json', 'POST', $parameter);
			if($jf){
			$data['jf']=$jf[0];			
			}
			$api_url 	= $URL_API_BKD.'bkd_beban_kerja/publikasi';
			$parameter  = array('api_kode' => 9900, 'api_subkode' => 2, 'api_search' => array($kd_dosen));
			$publikasi = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
			$data['publikasi']=$publikasi;
			#print_r($publikasi);
			$api_url 	= $URL_API_BKD.'bkd_dosen/biografi_dosen/'.$kd_dosen;
			$biografi = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
			$data['bio']=$biografi;
		//	print_r($biografi);
			$api_url 	= $URL_API_BKD.'bkd_beban_kerja/pendidikan';
			$parameter  = array('api_kode' => 1000, 'api_subkode' => 1, 'api_search' => array($kd_dosen));
			$pendidikan = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
			$data['pendidikan']=$pendidikan;
			
			$api_url 	= $URL_API_BKD.'bkd_beban_kerja/kegiatan_akademik';
			$parameter  = array('api_kode' => 1000, 'api_subkode' => 1, 'api_search' => array($kd_dosen));
			$data['kegiatan_akademik'] = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
			
			$api_url 	= $URL_API_BKD.'bkd_beban_kerja/kegiatan_akademik';
			$parameter  = array('api_kode' => 2000, 'api_subkode' => 1, 'api_search' => array($kd_dosen));
			$data['narasumber'] = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
		//	print_r($data['narasumber']);die();
			$api_url 	= $URL_API_BKD.'bkd_beban_kerja/get_data_haki';
			$parameter  = array('api_search' => array($kd_dosen));
			$data['haki'] = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);	
			
			//print_r($pendidikan);
			switch ($history) {
				case "mengajar":
					$mk= $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_penawaran/data_search', 'POST',
					array('api_kode'=>58000, 'api_subkode' =>36 , 'api_search' => array( $kd_prodi, $kd_dosen)));
					$mk=json_decode(json_encode($mk,false));
					//print_r($mk);
					$amk=array();
					foreach($mk as $m){
						$amk[$m->KD_TA][$m->KD_SMT][]=(object)array('sks'=>$m->SKS,'kd_kur'=>$m->KD_KUR,'jenis_mk'=>$m->NM_JENIS_MK,'kd_mk'=>$m->KD_MK,'mk'=>$m->NM_MK,'jadwal'=>$m->JADWAL1,'kelas'=>$m->KELAS_PARAREL,'tim_ajar'=>$m->TIM_AJAR);
					}
					
					if(!empty($amk[$ta][$smt])){	
						$data['amk']=$amk[$ta][$smt];		
					}else{
						$data['amk']=1;
					}
					break;
			  case "penelitian":
					# KODE PENELITIAN = 'B', PENGABDIAN MASYARAKAT = 'C', PENUNJANG = 'D'
					
					$api_url 	= 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/bkd_beban_kerja/bebankerja';
					$parameter  = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array('B',$kd_dosen));
					$penelitian = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
					$data['penelitian']=$penelitian;
					#print_r($penelitian);
					if(empty($penelitian)){
						$data['pel'] = 1;
					}
				break;
			  case "pengabdian":
					$api_url 	= 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/bkd_beban_kerja/bebankerja';
					$parameter  = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array('C',$kd_dosen));
					$pengabdian = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
					#print_r($pengabdian);
					$data['pengabdian']=$pengabdian;
					if(empty($pengabdian)){
						$data['ampm'] = 1;
					}

				break;
			  case "tugas":
					$api_url 	= 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/bkd_beban_kerja/bebankerja';
					$parameter  = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array('D',$kd_dosen));
					$tugas = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
					//print_r($tugas);
					$arr_tugas=array();
					
					if(!empty($tugas)){
						foreach($tugas as $t){
							if(!isset($arr_tugas[$t['JENIS_KEGIATAN']])) {
								$arr_tugas[$t['JENIS_KEGIATAN']]=array('JENIS_KEGIATAN'=>$t['JENIS_KEGIATAN'],'TA_MULAI'=>$t['KD_TA'],'TA_SELESAI'=>$t['KD_TA']);
							}else{
								if($arr_tugas[$t['JENIS_KEGIATAN']]['TA_MULAI']<=$t['KD_TA']){
									$ta_mulai=$arr_tugas[$t['JENIS_KEGIATAN']]['TA_MULAI'];
									$ta_selesai=$t['KD_TA'];
								}else{
									$ta_mulai=$t['KD_TA'];
									$ta_selesai=$arr_tugas[$t['JENIS_KEGIATAN']]['TA_MULAI'];
								}
								$arr_tugas[$t['JENIS_KEGIATAN']]=array('JENIS_KEGIATAN'=>$t['JENIS_KEGIATAN'],'TA_MULAI'=>$ta_mulai,'TA_SELESAI'=>$ta_selesai);
							}
						}
					}	
					$data['tugas']=$arr_tugas;
					if(empty($arr_tugas)){	
						$data['tug']=1;
					}
				break;
			}
			 
			
		
		
		
			//	print_r($amk);	
		$data['rside']="page/right_side_2";
		$data['main_view']="web/prodi/detil_dosen_view";				
		$this->load->view('web/content',$data);
		}else{
			redirect('page/dosen');
		}	
	}
	function prodi($id=0){
		$lang = $this->page_lib->lang();
		$this->load->model('page_model');
		$data['page'] = $this->page_model->get_page($id);
		if( !$data ){
			return false;
		}else{
			$data_page = $this->db->get_where("page",array('id_page'=>$id));
		    $page = $data_page->row();
			if($data_page->num_rows()>0){
				$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url());
				$this->breadcrumb->append_crumb($page->title, '/');
				
				$data['page'] = $this->page_model->get_page($id);

				/* $this->load->view('page/header',$data);
				$this->load->view('page/bg_breadcumb');
				$this->load->view('page/left-side');
				$this->load->view('page/prodi/detail_view');
				$this->load->view('page/right-side');
				$this->load->view('page/footer'); */
				// print_r($data['page']);
				// die();
				$data['main_view']="web/prodi/detail_view";				
				$this->load->view('web/content',$data);
			}
		}			
	}
	function unit($id=0){
		$this->prodi($id);
				
	}
	function pedoman_akademik($id=0){
		$lang = $this->page_lib->lang();
		$this->load->model('page_model');
		$data['dokumen'] = $this->page_model->get_dokumen($id);
		if( !$data ){
			return false;
		}else{
			$data_page = $this->db->get_where("dokumen",array('id_dokumen'=>$id));
		    $page = $data_page->row();
			if($data_page->num_rows()>0){
				$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url($lang));
				$this->breadcrumb->append_crumb(ucwords(dict($page->nama_dokumen, $lang)), '/');
				
				$data['dokumen'] = $this->page_model->get_dokumen($id);
				$data['main_view']="web/pedoman/detail_view";				
				$this->load->view('web/content',$data);
			}
		}			
	}
	function download($id=0){
		$get_data = $this->db->get_where("dokumen",array('id_dokumen'=>$id));
		$p = $get_data->row();
		$this->output_file("./media/dokumen/".$p->nama_file,''.$p->nama_file.''); 
		
	}
	function profil($id=0,$text_url=""){
		$lang = $this->page_lib->lang();
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$tanggal=date('d/m/Y');
			switch ($id) {
				case "1":
					$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url($lang));
					$this->breadcrumb->append_crumb(ucfirst(dict('Profil',$lang)), '/');					
					$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
					array('api_kode'=>50000, 'api_subkode'=>2));
					$taa=$tasmt_sekarang['data'];
					$ta=$taa[':hasil1'];
					$smt=$taa[':hasil3'];
					$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 'POST',
					array('api_kode'=>101006, 'api_subkode' => 1,
					'api_search' => array($tanggal,$kd_prodi))); 
					$profil2 = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 'POST',
					array('api_kode'=>101010, 'api_subkode' => 1,
					'api_search' => array($tanggal,$kd_prodi))); 
					$profil3 = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_master/data_search', 'POST',
					array('api_kode'=>19002, 'api_subkode' => 2,
					'api_search' => array($tanggal,$kd_prodi))); 
					$nilai = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_master/data_search', 'POST',
					array('api_kode'=>61001, 'api_subkode' => 2,
					'api_search' => array($ta,$smt,$kd_prodi))); 
					//print_r($profil4);
					$arr_bahasa=array('INA'=>'Bahasa Indonesia');
					$data['bahasa']=$arr_bahasa[$profil3[0]['KD_BAHASA']];
					$data['nilai']=$nilai;
					$data['profil']=$profil;
					$data['profil2']=$profil2;
					$data['main_view']="web/profil/profil";				
					$this->load->view('web/content',$data);
					break;
				case "2":
					$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url($lang));
					$this->breadcrumb->append_crumb("Visi - Misi - Tujuan", '/');
					$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 'POST',
					array('api_kode'=>101010, 'api_subkode' => 1,
					'api_search' => array($tanggal,$kd_prodi))); 
					$data['profil']=$profil;
					$data['main_view']="web/profil/visi";				
					$this->load->view('web/content',$data);
					break;
			  case "3":
					$this->breadcrumb->append_crumb('Beranda', base_url());;
					$this->breadcrumb->append_crumb("Kompetensi & Capaian", '/');
					$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST',
					array('api_kode'=>38001, 'api_subkode' => 3,
					'api_search' => array($tanggal,$kd_prodi))); 
					$data['profil']=$profil;
					$data['main_view']="web/profil/kompetensi";				
					$this->load->view('web/content',$data);
				
				break;
			  case "4":
					$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$lang)), base_url($lang));
					$this->breadcrumb->append_crumb("Pedoman Akademik", '/');
					$data['doc']=site_url('page/pedoman');
					$data['main_view']="web/profil/pedoman";				
					$this->load->view('web/content',$data);
				break;
			}
		/*	
		$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 'POST',
		array('api_kode'=>101010, 'api_subkode' => 1,
		'api_search' => array($tanggal,$kd_prodi))); 
		$data['profil']=$profil;
		print_r($data['profil']);*/
	}
	function profil2(){
		/* $this->page_model->page_counter($id,'dokumen'); */
		
		$get_data = $this->db->get_where("dokumen",array('id_dokumen'=>2));
		$p = $get_data->row();
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Pedoman Akademik', '/');
		/* $this->breadcrumb->append_crumb(substr($p->judul,0,130).' ...', '/');
		$data['title']=$p->judul; */
		
		/* $arr_filter=array();
		$arr_filter=related_text($p->judul);	
		$filter	="WHERE id_pengumuman <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
		$data['rec']=$this->db->query("SELECT id_pengumuman,judul,tgl_posting,jam_posting from pengumuman ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
		$data['pop']=$this->db->query("SELECT id_pengumuman,judul,tgl_posting,jam_posting from pengumuman ORDER BY counter desc LIMIT 0,5")->result(); */
			
		$data['dokumen']=$get_data->result();		
		if($get_data->num_rows()>0){
			
				$arf=explode(".",$p->nama_file);
				$ext= strtolower(end($arf));
				$arr_ext=array('pdf','jpg');
				if(in_array($ext,$arr_ext)){
					$data['ext']=$ext;
				}
				$data['filetype']=$ext;	
				$data['main_view']="web/profil/pedoman";				
				$this->load->view('web/content',$data);
				//$this->output_file("./media/pengumuman/".$data->nama_file,''.$data->nama_file.''); 
				
		}else{
			redirect(base_url());
		}
	}
	function tf_encode($kd_kelas){ $hasil = ''; #return $kd_kelas;
		$str 	= 'sng3bAdac5UEmQzv2YBTH8CVh7jXpRo0etfOK4MINSlwFZ6iL9kPD1JWyuqGxr#-.:/';
		$arr_e = array();  $arr_e1 = array(); $arr_r = array(); $arr_r1 = array();
		for($j = 0; $j < strlen($str); $j++){
			$j_ = $j; if ($j_ < 10) { $j_ = '0'.$j_; }
			$arr_e1[$j] = substr($str,$j,1);
			$arr_e[$j_] = substr($str,$j,1);
			$arr_r1[substr($str,$j,1)] = $j;
			$arr_r[substr($str,$j,1)] = $j_;
		}
		
		$total = 0;
		for($i = 0; $i < strlen($kd_kelas); $i++){
			$total = (int)substr($kd_kelas,$i,1) + $total; 
		} $u = fmod($total,10);
		
		$kd_enc = $arr_e1[$u];
		for($i = 0; $i < strlen($kd_kelas); $i++){
			$k = ($arr_r1[substr($kd_kelas,$i,1)]+$u); if($k < 10) { $k = '0'.$k; }
			$kd_enc .= ''.$k.rand(0,9); 
		} return $kd_enc;
	}
		
	function fakultas(){
		
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Fakultas', '/');
		$data['fakultas'] = $this->page_model->get_fakultas();

		$data['content']="page/universitas/fakultas_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	
	function pusat_studi($id=0){
		$this->load->model('page_model');
		$data['page'] = $this->page_model->get_pusat_studi($id);
		
		if( !$data ){
			return false;
		}else{
			$data_page = $this->db->get_where("pusat_studi",array('id_pusat_studi'=>$id));
		    $page = $data_page->row();
			
			if($data_page->num_rows()>0){
				$this->breadcrumb->append_crumb('Beranda', base_url());;
				$this->breadcrumb->append_crumb($page->nama_pusat_studi, '/');
				
				$data['page'] = $this->page_model->get_pusat_studi($id);
				$data['main_view']="web/prodi/unit_view";				
				$this->load->view('web/content',$data);
			}
		}			
	}

	function bagian($id=0){
		$this->load->model('page_model');
		$data['page'] = $this->page_model->get_bagian($id);
		if( !$data ){
			return false;
		}else{
			$data_page = $this->db->get_where("bagian",array('id_bagian'=>$id));
		    $page = $data_page->row();
			
			if($data_page->num_rows()>0){
				$this->breadcrumb->append_crumb('Beranda', base_url());;
				$this->breadcrumb->append_crumb($page->nama_bagian, '/');
				
				$data['page'] = $this->page_model->get_bagian($id);
				
				$data['content']="page/universitas/bagian_view";				
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
			}
		}			
	}
	
	function admisi($id=0){
		$this->universitas($id);
	}
	
	function arsip_pengumuman_json(){
		$th_pengumuman=$this->db->query("SELECT year(tgl_posting) tahun, count(id_pengumuman) jml from pengumuman group by tahun order by tahun desc")->result();
		$i=0;
		foreach($th_pengumuman as $tb){
		++$i;
			$bl_pengumuman=$this->db->query("SELECT month(tgl_posting) bulan, count(id_pengumuman) jml from pengumuman where year(tgl_posting)='".$tb->tahun."' group by bulan order by bulan desc ")->result();
			$bulan=array();
			foreach($bl_pengumuman as $bb){
				$bulan[]=array('title'=>bulan($bb->bulan).' ('.$bb->jml.')',
						"isFolder"=> true, 
						"isLazy"=> true,
						"key"=> $tb->tahun."/".$bb->bulan);
			}
			if($i==1){
				$exp=true;
			}else{
				$exp=false;
			}	
			
			$data[] = array(
						'title'=> $tb->tahun.' ('.$tb->jml.')',
						"isFolder"=> true, 
						'expanded'=> $exp,
						'children' => $bulan
					);
			}
			
	  header("Expires: Wed, 01 Jan 2020 00:00:00 GMT" );   
	  header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT");   
	  header("Cache-Control: no-cache, must-revalidate" );   
	  header("Pragma: no-cache" );  
	  header("Content-type: text/x-json");  
		echo json_encode($data,true);		
	}

	
	function pengumuman_bulan_json($tahun='',$bulan=''){
		$pengumuman=$this->db->query("SELECT id_pengumuman,judul,nama_file,url from pengumuman where year(tgl_posting)='".$tahun."' and month(tgl_posting)='".$bulan."'")->result();
		$i=0;
		foreach($pengumuman as $b){
				$url =site_url('page/pengumuman/detail/'.$b->id_pengumuman.'/'.url_title(strtolower($b->judul)));
			
			$data[] = array(
						'title'=> "<a target='_blank' href='".$url."' title='".$b->judul."'>".$b->judul."</a>",
						
					);
			}
  header("Expires: Wed, 01 Jan 2020 00:00:00 GMT" );   
  header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT");   
  header("Cache-Control: no-cache, must-revalidate" );   
  header("Pragma: no-cache" );  
  header("Content-type: text/x-json");  
		echo json_encode($data,true);
	}
		
	function arsip_berita_json(){
		$th_berita=$this->db->query("SELECT year(tanggal) tahun, count(id_berita) jml from berita group by tahun order by tahun desc")->result();
		$i=0;
		foreach($th_berita as $tb){
		++$i;
			$bl_berita=$this->db->query("SELECT month(tanggal) bulan, count(id_berita) jml from berita where year(tanggal)='".$tb->tahun."' group by bulan order by bulan desc ")->result();
			$bulan=array();
			foreach($bl_berita as $bb){
				$bulan[]=array('title'=>bulan($bb->bulan).' ('.$bb->jml.')',
						"isFolder"=> true, 
						"isLazy"=> true,
						"key"=> $tb->tahun."/".$bb->bulan);
			}
			if($i==1){
				$exp=true;
			}else{
				$exp=false;
			}	
			
			$data[] = array(
						'title'=> $tb->tahun.' ('.$tb->jml.')',
						"isFolder"=> true, 
						'expanded'=> $exp,
						'children' => $bulan
					);
			}
		echo json_encode($data,true);		
	}
	function arsip_berita_json2(){
		$th_berita=$this->db->query("SELECT year(tanggal) tahun, count(id_berita) jml from berita group by tahun order by tahun desc")->result();
		$i=0;
		foreach($th_berita as $tb){
		++$i;
			$bl_berita=$this->db->query("SELECT month(tanggal) bulan, count(id_berita) jml from berita where year(tanggal)='".$tb->tahun."' group by bulan order by bulan desc ")->result();
			$bulan=array();
			foreach($bl_berita as $bb){
				$bulan[]=array('text'=>bulan($bb->bulan).' ('.$bb->jml.')');
			}
			if($i==1){
				$exp=true;
			}else{
				$exp=false;
			}	
			
			$data[] = array(
						'text'=> $tb->tahun.' ('.$tb->jml.')',
						'expanded'=> true,
						'children' => $bulan
					);
			}
		echo json_encode($data,true);		
	}
	
	function berita_bulan_json($tahun='',$bulan=''){
		$berita=$this->db->query("SELECT id_berita,judul from berita where year(tanggal)='".$tahun."' and month(tanggal)='".$bulan."'")->result();
		$i=0;
		foreach($berita as $b){
			$data[] = array(
						'title'=> "<a target='_self' href='".site_url('page/berita/detail/'.$b->id_berita)."' title='".$b->judul."'>".$b->judul."</a>",
						
					);
			}
		echo json_encode($data,true);
	}
		
	function arsip_liputan_json(){
		$th_liputan=$this->db->query("SELECT year(tanggal) tahun, count(id_liputan) jml from liputan group by tahun order by tahun desc")->result();
		$i=0;
		foreach($th_liputan as $tb){
		++$i;
			$bl_liputan=$this->db->query("SELECT month(tanggal) bulan, count(id_liputan) jml from liputan where year(tanggal)='".$tb->tahun."' group by bulan order by bulan desc ")->result();
			$bulan=array();
			foreach($bl_liputan as $bb){
				$bulan[]=array('title'=>bulan($bb->bulan).' ('.$bb->jml.')',
						"isFolder"=> true, 
						"isLazy"=> true,
						"key"=> $tb->tahun."/".$bb->bulan);
			}
			if($i==1){
				$exp=true;
			}else{
				$exp=false;
			}	
			
			$data[] = array(
						'title'=> $tb->tahun.' ('.$tb->jml.')',
						"isFolder"=> true, 
						'expanded'=> $exp,
						'children' => $bulan
					);
			}
		echo json_encode($data,true);		
	}
	
	function liputan_bulan_json($tahun='',$bulan=''){
		$liputan=$this->db->query("SELECT id_liputan,judul from liputan where year(tanggal)='".$tahun."' and month(tanggal)='".$bulan."'")->result();
		$i=0;
		foreach($liputan as $b){
			$data[] = array(
						'title'=> "<a target='_self' href='".site_url('page/liputan/detail/'.$b->id_liputan)."' title='".$b->judul."'>".$b->judul."</a>",
						
					);
			}
		echo json_encode($data,true);
	}
		
	function arsip_kolom_json(){
		$th_kolom=$this->db->query("SELECT year(tanggal) tahun, count(id_kolom) jml from kolom group by tahun order by tahun desc")->result();
		$i=0;
		foreach($th_kolom as $tb){
		++$i;
			$bl_kolom=$this->db->query("SELECT month(tanggal) bulan, count(id_kolom) jml from kolom where year(tanggal)='".$tb->tahun."' group by bulan order by bulan desc ")->result();
			$bulan=array();
			foreach($bl_kolom as $bb){
				$bulan[]=array('title'=>bulan($bb->bulan).' ('.$bb->jml.')',
						"isFolder"=> true, 
						"isLazy"=> true,
						"key"=> $tb->tahun."/".$bb->bulan);
			}
			if($i==1){
				$exp=true;
			}else{
				$exp=false;
			}	
			
			$data[] = array(
						'title'=> $tb->tahun.' ('.$tb->jml.')',
						"isFolder"=> true, 
						'expanded'=> $exp,
						'children' => $bulan
					);
			}
		echo json_encode($data,true);		
	}
	
	function kolom_bulan_json($tahun='',$bulan=''){
		$kolom=$this->db->query("SELECT id_kolom,tentang judul from kolom where year(tanggal)='".$tahun."' and month(tanggal)='".$bulan."'")->result();
		$i=0;
		foreach($kolom as $b){
			$data[] = array(
						'title'=> "<a target='_self' href='".site_url('page/kolom/detail/'.$b->id_kolom)."' title='".$b->judul."'>".$b->judul."</a>",
						
					);
			}
		echo json_encode($data,true);
	}
		
	function arsip_agenda_json(){
		$th_agenda=$this->db->query("SELECT year(tgl_posting) tahun, count(id_agenda) jml from agenda group by tahun order by tahun desc")->result();
		$i=0;
		foreach($th_agenda as $tb){
		++$i;
			$bl_agenda=$this->db->query("SELECT month(tgl_posting) bulan, count(id_agenda) jml from agenda where year(tgl_posting)='".$tb->tahun."' group by bulan order by bulan desc ")->result();
			$bulan=array();
			foreach($bl_agenda as $bb){
				$bulan[]=array('title'=>bulan($bb->bulan).' ('.$bb->jml.')',
						"isFolder"=> true, 
						"isLazy"=> true,
						"key"=> $tb->tahun."/".$bb->bulan);
			}
			if($i==1){
				$exp=true;
			}else{
				$exp=false;
			}	
			
			$data[] = array(
						'title'=> $tb->tahun.' ('.$tb->jml.')',
						"isFolder"=> true, 
						'expanded'=> $exp,
						'children' => $bulan
					);
			}
		echo json_encode($data,true);		
	}
	
	function agenda_bulan_json($tahun='',$bulan=''){
		$agenda=$this->db->query("SELECT id_agenda,nama_agenda judul from agenda where year(tgl_posting)='".$tahun."' and month(tgl_posting)='".$bulan."'")->result();
		$i=0;
		foreach($agenda as $b){
			$data[] = array(
						'title'=> "<a target='_self' href='".site_url('page/agenda/detail/'.$b->id_agenda)."' title='".$b->judul."'>".$b->judul."</a>",
						
					);
			}
		echo json_encode($data,true);
	}
	
	function penelitian($id){
		$this->universitas($id);
	}
	
   public function search($uri=0){
		$this->load->library('pagination');
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Pencarian', '/');
		   if(isset($_SESSION['site_limit_berita_slider'])){
			$limit=$_SESSION['site_limit_berita_slider'];
			}else{
			$limit=10;
			}
			if($_POST!=null){
				$cari=$this->input->post('cari');
				$this->session->set_userdata('cari',$cari);
			}else{
				$cari= $this->session->userdata('cari');
			}
			$data['cari'] = $this->page_model->search($limit,$uri,$cari);

		$data['main_view']="web/search_view";				
		$this->load->view('web/content',$data);
   }
   

}
