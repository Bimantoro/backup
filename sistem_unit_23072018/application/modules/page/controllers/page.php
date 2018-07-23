<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('format_tanggal_helper');
		$this->load->helper('page_helper');
		$this->load->helper('text_manipulation_helper');
		$this->load->model('page/page_model');
	}

	function index()
	{
	$data="";
		$data['menu'] = $this->page_model->get_side_menu();
		$data['pengumuman'] = $this->page_model->get_pengumuman();
		$data['kolom'] = $this->page_model->get_recent_column();
		$data['berita'] = $this->page_model->get_recent_news();
		$data['agenda'] = $this->page_model->get_recent_agenda();
		$this->load->view('page/header',$data);
		$this->load->view('page/home');
		$this->load->view('page/footer');
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
		$data['content']="page/prodi/document_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	
	function kalender($id=''){
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Kalender Akademik', '/');
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
		$data['content']="page/prodi/kalender_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
		
	function jadwal_kuliah(){
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Jadwal Kuliah', '/');
		
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
		$arj[8]=$arj['1'];
		unset($arj['1']);
		ksort($arj);
		
		
		//print_r($arj);
		$data['arj']=$arj;
		$data['content']="page/prodi/jadwal_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
		
	}
	
	function jadwal_ujian(){
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Jadwal Kuliah', '/');
		
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
		
		$jadwal = $this->s00_lib_api->get_api(URL_API_SIA.' sia_absensi/data_search', 'POST', 
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
		$data['content']="page/prodi/jadwal_ujian_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
		
	}
	
	function dosen(){
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
		$dosen=$ad_status[$jd][$sd];
		$data['jd']=$jd;
		$data['sd']=$sd;
		//print_r($ard);
		$data['dosen']=$dosen;
		$data['content']="page/prodi/dosen_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');	
	}
	
	/* function tes_dosen(){
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$dosen = $this->s00_lib_api->get_api(URL_API_SIA.'sia_penawaran/data_search', 'POST', 
				array('api_kode'=>58002 , 'api_subkode' => 7, 
				'api_search' =>array($kd_prodi,2)));
		$dosen=json_decode($dosen);
		$ard=array();
		foreach($dosen as $d){
			echo $d->NIP.$d->NM_DOSEN_F.'<br>';
			$this->db->where(array('kd_dosen'=>$d->NIP))->update('ikd',array('nm_dosen'=>$d->NM_DOSEN_F));
		}
	} */
	
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
	
	function detil_dosen($kd_dosen="",$history=""){
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		
		 $dosen=$this->s00_lib_api->get_api_json(URL_API_SIA.'sia_dosen/data_search', 'POST', 
							array('api_kode'=>20000, 'api_subkode' => 3, 'api_search' => array($kd_dosen)));
	
		if($dosen){
			$data['dosen']=$dosen;
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
			$data['nm_dosen']=$nm_dosen;
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Dosen', site_url('page/dosen'));
			$this->breadcrumb->append_crumb($nm_dosen, '/');
		
			$email=json_decode(file_get_contents("http://service.uin-suka.ac.id/servad/adgetuserdetils.php?aud=7f304662ebfee3g82f2e810aa8fbc24j23&src=".$nip),true);
			$data['email']=str_replace(".","[dot]",str_replace("@","[at]",$email[0][427][0]['EMAIL']));
						
			$api_url 	= 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/bkd_beban_kerja/publikasi';
			$parameter  = array('api_kode' => 9900, 'api_subkode' => 2, 'api_search' => array($kd_dosen));
			$publikasi = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
			$data['publikasi']=$publikasi;
			$api_url 	= 'http://service.uin-suka.ac.id/servbkdr/index.php/bkd_public/bkd_beban_kerja/pendidikan';
			$parameter  = array('api_kode' => 1000, 'api_subkode' => 1, 'api_search' => array($kd_dosen));
			$pendidikan = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);
			$data['pendidikan']=$pendidikan;
		//	print_r($pendidikan);
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
					if(empty($penelitian)){	
						$data['pel']=1;
					}
				break;
			  case "pengabdian":
					$api_url 	= 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/bkd_beban_kerja/bebankerja';
					$parameter  = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array('C',$kd_dosen));
					$pengabdian = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
					//print_r($pengabdian);
					$data['pengabdian']=$pengabdian;
					if(!empty($pengabdian)){	
						$data['ampm']=$pengabdian;		
					}else{
						$data['ampm']=1;
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
		$data['content']="page/prodi/detil_dosen_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');	
		
		
		
		
		}else{
			redirect('page/dosen');
		}	
	}

	function mata_kuliah($kd_kur="",$kd_mk=""){
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
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Kurikulum', site_url('page/kurikulum'));
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
			$data['content']="page/prodi/mata_kuliah_view";
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');

		}else{
			redirect('page/dosen');
		}	
	}

	function kurikulum(){
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Kurikulum', '/');
		
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
		$data['content']="page/prodi/kurikulum_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');	
	}


	function prodi($id=0){
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

				$data['content']="page/prodi/detail_view";
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
			}
		}			
	}

	function profil($id=0,$text_url=""){
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
		$tanggal=date('d/m/Y');
			switch ($id) {
				case "1":
					$this->breadcrumb->append_crumb('Beranda', base_url());;
					$this->breadcrumb->append_crumb("Profil", '/');					
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
					$data['content']="page/profil/profil";
					$this->load->view('page/header',$data);
					$this->load->view('page/content');
					$this->load->view('page/footer');
					break;
				case "2":
					$this->breadcrumb->append_crumb('Beranda', base_url());;
					$this->breadcrumb->append_crumb("Visi - Misi - Tujuan", '/');
					$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 'POST',
					array('api_kode'=>101010, 'api_subkode' => 1,
					'api_search' => array($tanggal,$kd_prodi))); 
					$data['profil']=$profil;
					$data['content']="page/profil/visi";
					$this->load->view('page/header',$data);
					$this->load->view('page/content');
					$this->load->view('page/footer');
					break;
			  case "3":
					$this->breadcrumb->append_crumb('Beranda', base_url());;
					$this->breadcrumb->append_crumb("Kompetensi & Capaian", '/');
					$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_kurikulum/data_search', 'POST',
					array('api_kode'=>38001, 'api_subkode' => 3,
					'api_search' => array($tanggal,$kd_prodi))); 
					$data['profil']=$profil;
					$data['content']="page/profil/kompetensi";
					$this->load->view('page/header',$data);
					$this->load->view('page/content');
					$this->load->view('page/footer');
				
				break;
			  case "4":
					$this->breadcrumb->append_crumb('Beranda', base_url());;
					$this->breadcrumb->append_crumb("Pedoman Akademik", '/');
					$data['doc']=site_url('page/pedoman');
					$data['content']="page/profil/pedoman";
					$this->load->view('page/header',$data);
					$this->load->view('page/content');
					$this->load->view('page/footer');
				break;
			}
		/*	
		$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_sistem/data_search', 'POST',
		array('api_kode'=>101010, 'api_subkode' => 1,
		'api_search' => array($tanggal,$kd_prodi))); 
		$data['profil']=$profil;
		print_r($data['profil']);*/
	}
	
	function pedoman($id=0){
		$kd_prodi=get_prodi();
		$this->load->library('s00_lib_api');
			$tasmt_sekarang = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_procedure', 'POST',
			array('api_kode'=>50000, 'api_subkode'=>2));
			$taa=$tasmt_sekarang['data'];
			$ta=$taa[':hasil1'];
			$smt=$taa[':hasil3'];
			
			$profil = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_master/data_search', 'POST',
			array('api_kode'=>19001, 'api_subkode' => 1,
			'api_search' => array($ta, $smt, $kd_prodi, "INA"))); 
				header("Content-type: application/pdf");
				echo base64_decode($profil[0]['FILECONTENT']);
	}
	
	function unit($id=0){
		$this->load->model('page_model');
		$data['page'] = $this->page_model->get_unit($id);
		if( !$data ){
			return false;
		}else{
			$data_page = $this->db->get_where("unit",array('id_unit'=>$id));
		    $page = $data_page->row();
			
			if($data_page->num_rows()>0){
				$this->breadcrumb->append_crumb('Beranda', base_url());;
				$this->breadcrumb->append_crumb($page->nama_unit, '/');
				
				$data['content']="page/prodi/unit_view";
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
			}
		}			
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
		echo json_encode($data,true);		
	}
	
	function pengumuman_bulan_json($tahun='',$bulan=''){
		$pengumuman=$this->db->query("SELECT id_pengumuman,judul,nama_file,url from pengumuman where year(tgl_posting)='".$tahun."' and month(tgl_posting)='".$bulan."'")->result();
		$i=0;
		foreach($pengumuman as $b){
			if($b->nama_file!=null){
				$url =base_url('media/pengumuman/'.$b->nama_file);
			}else{						
				$url =$b->url;
			}
			$data[] = array(
						'title'=> "<a target='_blank' href='".$url."' title='".$b->judul."'>".$b->judul."</a>",
						
					);
			}
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
			
				$data['content']="page/search_view";
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
   }
   
}
