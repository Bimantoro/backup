<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		/* 
		$this->load->library('Kerjasama_serv');
		$this->load->library('Webserv');
		$this->load->library('S00_lib_api');
		$this->api 		= $this->s00_lib_api;
		$this->load->library('Breadcrumb2');
        $this->load->helper('file'); */
		$this->load->helper('format_tanggal');
		$this->load->model('page/page_model');
	}

	function index()	{
		/* $data['fakultas'] = $this->page_model->get_fakultas();
		$data['pengumuman'] = $this->page_model->get_pengumuman(1,4);
		$data['kolom'] = $this->page_model->get_recent_column();
		$data['berita2'] = $this->page_model->get_recent_news(1,4);
		$data['agenda'] = $this->page_model->get_recent_agenda(1,4);
		 */
		 
		$data['berita1'] = $this->page_model->daftar_berita();
		$data['main_view']="page/stars";
		$this->load->view('page/content2',$data);
		/* $this->load->view('page/header',$data);
		$this->load->view('page/home');
		$this->load->view('page/footer'); */
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
	
	function index2()
	
	{
		$data['fakultas'] = $this->page_model->get_fakultas();
		$data['pengumuman'] = $this->page_model->get_pengumuman(1,3);
		$data['kolom'] = $this->page_model->get_recent_column();
		$data['liputan'] = $this->page_model->get_recent_liputan();
		$data['berita'] = $this->page_model->get_recent_news();
		$data['berita2'] = $this->page_model->get_recent_news(1,4);
		$data['agenda'] = $this->page_model->get_recent_agenda();
		
		$this->load->view('page/header2',$data);
		$this->load->view('page/home2');
		$this->load->view('page/footer');
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
		$this->breadcrumb->append_crumb('Beranda', base_url());;
		$this->breadcrumb->append_crumb('Dosen', '/');
		$data['ap']=$prodi=$this->input->post('prodi');
		$postdata=array('KODE_PRODI'=>$prodi);
		$data['prodi'] = $this->kerjasama_serv->akreditasi_post('dosen/prodi_list');
		$data['dosen']=$this->kerjasama_serv->akreditasi_post('dosen/dosen_list',$postdata);	
		//print_r($data['dosen']);
		$data['content']="page/universitas/dosen_view";	
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	
	function dosen($param="",$value=""){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Dosen', '/');
		
		if($param=='index'){
			$postdata=array('NAMA'=>$value);
			$data['dosen']=$this->kerjasama_serv->akreditasi_post('dosen/dosen_nama_list',$postdata);	
		}
		$data['prodi'] = $this->kerjasama_serv->akreditasi_post('dosen/prodi_list');
		if($_POST !=null){
			if(	$this->input->post('telusur')!=null){
				$data['ap']=$prodi=$this->input->post('prodi');
				$data['jd']=$jenis_dosen=$this->input->post('jenis_dosen');
				$data['ad']=$asal_dosen=$this->input->post('asal_dosen');
				$data['sd']=$status_dosen=$this->input->post('status_dosen');
				$postdata=array('KODE_PRODI'=>$prodi,'JENIS_DOSEN'=>$jenis_dosen,'ASAL_DOSEN'=>$asal_dosen,'STATUS_DOSEN'=>$status_dosen);
				$data['dosen']=$this->kerjasama_serv->akreditasi_post('dosen/dosen_list',$postdata);	
			}
			if(	$this->input->post('cari')!=null){
				$data['cari']=$cari=$this->input->post('cari');
				$postdata=array('CARI'=>$cari);
				$data['dosen']=$this->kerjasama_serv->akreditasi_post('dosen/dosen_nama_list',$postdata);	
			}			
		}
		$data['rside']="page/right_side1";				
		$data['content']="page/universitas/dosen_view";				
		$this->load->view('page/header3',$data);
		$this->load->view('page/content3');
		$this->load->view('page/footer3');
	}
	
	function detil_dosen($kd_dosen="",$history=""){
		
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
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Dosen', site_url('page/dosen'));
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
				break;
			  case "pengabdian":
					$api_url 	= 'http://service.uin-suka.ac.id/servbkd/index.php/bkd_public/bkd_beban_kerja/bebankerja';
					$parameter  = array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array('C',$kd_dosen));
					$pengabdian = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
					#print_r($pengabdian);
					$data['pengabdian']=$pengabdian;
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
			$data['content']="page/universitas/detil_dosen_view";
			$this->load->view('page/header3',$data);
			$this->load->view('page/content3');
			$this->load->view('page/footer3');	
		
		
		
		
		}else{
			redirect('page/dosen');
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
				
				$data['page'] = $this->page_model->get_unit($id);
				
				$data['content']="page/universitas/unit_view";				
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
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

		$data['content']="page/search_view";				
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
   }

}
