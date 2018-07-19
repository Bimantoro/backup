<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Skpi_mhs extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->api = $this->s00_lib_api;
		$this->output69 = $this->s00_lib_output;

		$this->session->set_userdata('app', 'skpi_03');
		$this->load->library('skpi_lib_basic','','lib_basic');

		$this->lib_basic->auto_update_label();

		$mhs = $this->lib_basic->get_data_mhs($this->session->userdata('id_user'));
		if($mhs){
			$this->session->set_userdata('skpi_lvl', 'mhs');
		}else{
			if($this->session->userdata('id_user') != 'PKSI100'){
				redirect(base_url());
			}
			
		}
	}

	function index()
	{
		$data['string_skpi'] = $this->lib_basic->skpi();
		$this->output69->output_display('mhs/home', $data);
	}

	function daftar_skpi()
	{
		$nim = $this->session->userdata('id_user');

		// if(strtoupper($nim) == 'PKSI100'){
		// 	$nim = '13610046';
		// }

		$data['SYARAT_DAFTAR'] = $this->get_syarat_daftar($nim);

		$mhs = $this->lib_basic->get_data_mhs($nim);

		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		if(isset($_POST['sv_daftar']) && !empty($data['SYARAT_DAFTAR']['SYARAT'])){
			$cek = $this->lib_basic->get_skpi_mhs($nim);
			if($cek){
				//do nothing
			}else{
				$no_skpi = $this->lib_basic->noseri();
				$data = array(
					'nim' => $nim,
					'no_skpi' =>$no_skpi,
					'id_l' => $id_l,
					'status' => '0',
					//'tgl_setuju' => '',
					'nip' => '',
					'unused_label' => '[]',
					'tgl_daftar' => date('Y-m-d'),
					'kd_prodi' => $mhs[0]['KD_PRODI']
					);
				$skpi = $this->lib_basic->insert_skpi($data);
				
				redirect(base_url().'skpi/skpi_mhs/daftar_skpi');				
			}

		}

		
		if($mhs[0]['J_KELAMIN']=='L'){
				$data['NAMA'] = 'sdr. '.$mhs[0]['NAMA'];
		}else{
				$data['NAMA'] = 'sdri. '.$mhs[0]['NAMA'];
		}

		$data['STS_SKPI'] = $this->lib_basic->cek_skpi($nim);

		$temp_data_skpi = $this->lib_basic->get_skpi_mhs($nim);

		$data['BATAL_DAFTAR']  = 0;
		$data['BATAL_DAFTAR_PESAN'] = 'Tidak ada Keterangan';
		if(!empty($temp_data_skpi)){
			$tmp_ket 		= explode('#', $temp_data_skpi['keterangan']);
			if(count($tmp_ket) > 1 && $tmp_ket[0] == 'BATAL_DAFTAR'){
				$data['BATAL_DAFTAR']  = 1;
				$data['BATAL_DAFTAR_PESAN']  = $tmp_ket[1];
			}
		}
		
		//print_r($tes);
		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		//PAKET AKTIVITAS, PRESTASI DAN PENGHARGAAN 
				//1. LABEL HEADER
				$KEGIATAN = array();

				$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 4));
				if($hasil){
					$KEGIATAN[0] = array(
						'idn' => $hasil['nama_idn'],
						'en'  => $hasil['nama_en'],
						'arb' => $hasil['nama_arb']
						);
				}

				$id_ld = $hasil['id_ld'];
				
				$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
				if($lbl){
					$i = 0;
					$temp = array();
					foreach ($lbl as $key) {
							$temp[$i] = array(
							'idn' => $key['nama_idn'],
							'en'  => $key['nama_en'],
							'arb' => $key['nama_arb']
							);
							$i++;
					}
				//2. LABEL DETAIL
					$KEGIATAN[1] = array($temp[0], $temp[1], $temp[2], $temp[3], $temp[4]);

				}
				//3. KONTEN
				//$skpi_prestasi = $this->lib_basic->cek_prestasi($nim);
				$dpm_prestasi = $this->lib_basic->get_data_prestasi($nim);
				$status_prestasi = false;
				$penulisan_prestasi = 1;
				$prestasi = array();
				$i=0;
				if($dpm_prestasi){
					$status_prestasi = true;
					foreach ($dpm_prestasi as $dpm) {
						$prestasi[$i] = array('IDN' => $dpm['NM_LOMBA'], 'EN' => $dpm['NM_LOMBA2']);

						//cek kebenaran penulisan
						$temp_penulisan = $this->lib_basic->cek_penulisan_dpm($dpm['NM_LOMBA'], $dpm['NM_LOMBA2']);
						if($temp_penulisan == 0){
							$penulisan_prestasi = 0;
						}

						$i++;			 			
					}
				}else{
					$prestasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_organisasi = $this->lib_basic->get_data_organisasi($nim);
				$status_organisasi = false;
				$penulisan_organisasi = 1;
				$organisasi = array();
				$i=0;
				if($dpm_organisasi){
					$status_organisasi = true;
					foreach ($dpm_organisasi as $dpm) {
			 			$organisasi[$i] = array('IDN' => $dpm['NM_ORGANISASI'], 'EN' => $dpm['NM_ORGANISASI2']); //$dpm['NM_ORGANISASI'];

			 			//cek kebenaran penulisan
						$temp_penulisan = $this->lib_basic->cek_penulisan_dpm($dpm['NM_ORGANISASI'], $dpm['NM_ORGANISASI2']);
						if($temp_penulisan == 0){
							$penulisan_organisasi = 0;
						}

		 				$i++;
		 				
			 		}
				}else{
					$organisasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);
				$uin_sertifikasi = $this->lib_basic->get_sertifikasi_uin($nim);
				$status_sertifikasi = false;
				$penulisan_sertifikasi = 1;
				$sertifikasi = array();
				$i=0;
				if($dpm_sertifikasi || $uin_sertifikasi){
					$status_sertifikasi = true;

					foreach ($uin_sertifikasi as $dpm) {
	 					$sertifikasi[$i] = array('IDN' => $dpm['NAMA_IDN'], 'EN' => $dpm['NAMA_EN']); //$dpm['NM_sertifikasi'];

	 					//cek kebenaran penulisan
						$temp_penulisan = $this->lib_basic->cek_penulisan_dpm($dpm['NAMA_IDN'], $dpm['NAMA_EN']);
						if($temp_penulisan == 0){
							$penulisan_sertifikasi = 0;
						}

	 					$i++;			 			
					}


					foreach ($dpm_sertifikasi as $dpm) {
	 					$sertifikasi[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_sertifikasi'];

	 					//cek kebenaran penulisan
						$temp_penulisan = $this->lib_basic->cek_penulisan_dpm($dpm['NM_KEGIATAN'], $dpm['NM_KEGIATAN2']);
						if($temp_penulisan == 0){
							$penulisan_sertifikasi = 0;
						}

	 					$i++;
			 		}
				}else{
					$sertifikasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_magang = $this->lib_basic->get_data_magang($nim);
				$status_magang = false;
				$penulisan_magang = 1;
				$magang = array();
				$i=0;
				if($dpm_magang){
					$status_magang = true;
					foreach ($dpm_magang as $dpm) {
	 					$magang[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_magang'];

	 					//cek kebenaran penulisan
						$temp_penulisan = $this->lib_basic->cek_penulisan_dpm($dpm['NM_KEGIATAN'], $dpm['NM_KEGIATAN2']);
						if($temp_penulisan == 0){
							$penulisan_magang = 0;
						}

	 					$i++;		 				
			 		}
				}else{
					$magang[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_karakter = $this->lib_basic->get_data_karakter($nim);
				$status_karakter = false;
				$penulisan_karakter = 1;
				$karakter = array();
				$i=0;
				if($dpm_karakter){
					$status_karakter = true;
					foreach ($dpm_karakter as $dpm) {
	 					$karakter[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_karakter'];

	 					//cek kebenaran penulisan
						$temp_penulisan = $this->lib_basic->cek_penulisan_dpm($dpm['NM_KEGIATAN'], $dpm['NM_KEGIATAN2']);
						if($temp_penulisan == 0){
							$penulisan_karakter = 0;
						}

	 					$i++;		 				
			 		}
				}else{
					$karakter[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$KEGIATAN[2] = array($prestasi, $organisasi, $sertifikasi, $magang, $karakter);
				$KEGIATAN[3] = array($penulisan_prestasi, $penulisan_organisasi, $penulisan_sertifikasi, $penulisan_magang, $penulisan_karakter);

				$data['KEGIATAN'] = $KEGIATAN;

				$data['string_skpi'] = $this->lib_basic->skpi();

				$data['LINK_DPM'] = array(
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_prestasi',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_organisasi',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_kegiatan',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_kegiatan',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_kegiatan');

				

		$this->output69->output_display('mhs/tampilan_m', $data);
	}

	function get_syarat_daftar($nim){
		//$nim = '13651060';//$this->input->post('nim');
		$periode = '2'; // 2 ini untuk tugas akhir

		$mhs = $this->lib_basic->get_data_mhs($nim);

		$kd_ta = $this->session->userdata('kd_ta');
		$kd_smt = $this->session->userdata('kd_smt');
		$kd_prodi = $mhs[0]['KD_PRODI'];

		$status_total = 1;

		$syarat = $this->api->get_api_json(
			"http://service.uin-suka.ac.id/servsiasuper/index.php/sia_public/sia_sistem/data_search",
			'POST',
			array(
				'api_kode' => 200001,
				'api_subkode' => 28,
				'api_search' => array($kd_ta, $kd_smt, $kd_prodi, 0)
			)
		);

		$daftar = $this->api->get_api_json(
					'http://service.uin-suka.ac.id/servtugasakhir/sia_skripsi_public/sia_skripsi_bimbingan/mhs_daftar',
					'POST',
					array(
						'api_kode' => 1000,
						'api_subkode' => 3,
						'api_search' => array($nim, '2')
					)
		);

		$ta = $this->api->get_api_json(
					'http://service.uin-suka.ac.id/servtugasakhir/sia_skripsi_public/sia_skripsi_bimbingan/jadwalMunaqosah',
					'POST',
					array(
						'api_kode' => 1001,
						'api_subkode' => 1,
						'api_search' => array($daftar, '2')
					)
		);

		$judul_ta = '-';
		$tgl_ta = '-';
		$nilai_ta = '-';

		if($ta){
			 $judul_ta 	=  $ta[0]['JUDUL'];
			 $tgl_ta 	=  $ta[0]['TGL_MUNA'];
			 $nilai_ta 	=  $ta[0]['NILAI'];
		}

		$sy = array();
		if($syarat){
			// echo '<pre>';
			// print_r($syarat);
			// echo '</pre>';
			$i = 0;
			
			foreach ($syarat as $s) {
				if($s['SY_JENIS'] == 'XIPK' && $s['SY_ISI'] > 0 && $s['SY_STATUS'] == 'Y'){
					$sy[$i]['TITLE'] = 'Indek Prestasi Komulatif (IPK)';
					$sy[$i]['SYARAT'] = number_format($s['SY_ISI'],2);
					$sy[$i]['NILAI'] = number_format($mhs[0]['IP_KUM'],2);
					if($s['SY_ISI'] <= $mhs[0]['IP_KUM']){ $tmp = 1;}else{ $tmp = 0; $status_total = 0;}
					$sy[$i]['STATUS'] = $tmp;
					$sy[$i]['KONTAK'] = "Petugas Fakultas";
				}
				else if($s['SY_JENIS'] == 'XJTA' && $s['SY_ISI'] == 'Y' && $s['SY_STATUS'] == 'Y'){
					$sy[$i]['TITLE'] = 'Judul Tugas Akhir';
					$sy[$i]['SYARAT'] = 'Ya';
					$sy[$i]['NILAI'] = $judul_ta;
					if($judul_ta != '-'){ $tmp = 1;}else{ $tmp = 0; $status_total = 0;}
					$sy[$i]['STATUS'] = $tmp;
					$sy[$i]['KONTAK'] = "Petugas Fakultas";
				}
				else if($s['SY_JENIS'] == 'XNTA' && $s['SY_ISI'] == 'Y' && $s['SY_STATUS'] == 'Y'){
					$sy[$i]['TITLE'] = 'Nilai Tugas Akhir';
					$sy[$i]['SYARAT'] = 'Ya';
					$sy[$i]['NILAI'] = $nilai_ta;
					if($nilai_ta != '-'){ $tmp = 1;}else{ $tmp = 0; $status_total = 0;}
					$sy[$i]['STATUS'] = $tmp;
					$sy[$i]['KONTAK'] = "Petugas Fakultas";
				}
				else if($s['SY_JENIS'] == 'XTMUN' && $s['SY_ISI'] == 'Y' && $s['SY_STATUS'] == 'Y'){
					$sy[$i]['TITLE'] = 'Tanggal Munaqasah';
					$sy[$i]['SYARAT'] = 'Ya';
					$sy[$i]['NILAI'] = $tgl_ta;
					if($tgl_ta != '-'){ $tmp = 1;}else{ $tmp = 0; $status_total = 0;}
					$sy[$i]['STATUS'] = $tmp;
					$sy[$i]['KONTAK'] = "Petugas Fakultas";
				}

				else if($s['SY_JENIS'] == 'XSTS' && $s['SY_ISI'] != '' && $s['SY_STATUS'] == 'Y'){
					$sy[$i]['TITLE'] = 'Status Mahasiswa';
					
					$temp_string = $s['SY_ISI'];
					$temp_string = str_replace('A', 'Aktif', $temp_string);
					$temp_string = str_replace('C', 'Cuti', $temp_string);
					$temp_string = str_replace('L', 'Lulus', $temp_string);
					$temp_string = str_replace('#', ' | ', $temp_string);

					$sy[$i]['SYARAT'] = $temp_string;
					$sy[$i]['NILAI'] = $mhs[0]['NM_STATUS'];

					$sts = explode('#', $s['SY_ISI']);

					$tmp = 0;
					for($x=0; $x<count($sts); $x++){
						if($sts[$x] == $mhs[0]['STATUS']){
							$tmp = 1;
						}
					}

					if($tmp != 1){
						$status_total = 0;
					}

					$sy[$i]['STATUS'] = $tmp;
					$sy[$i]['KONTAK'] = "Petugas Fakultas";
				}else if($s['SY_JENIS'] == 'XSMT' && $s['SY_ISI'] != '' && $s['SY_STATUS'] == 'Y'){
					$sy[$i]['TITLE'] = 'Semester';
					$temp_sy = explode('#', $s['SY_ISI']);
					$temp_smt = $mhs[0]['JUM_SMT'];
					sort($temp_sy);
					$sy[$i]['SYARAT'] = implode(' | ', $temp_sy);
					$sy[$i]['NILAI'] = $temp_smt;
					$temp_sts = 0;
					foreach ($temp_sy as $t_sy) {
						if($temp_smt == $t_sy){
							$temp_sts = 1;
						}
					}

					if($temp_sts != 1){
						$status_total = 0;
					}
					$sy[$i]['STATUS'] = $temp_sts;
					$sy[$i]['KONTAK'] = "Petugas Fakultas";
				}

				$i++;
			}
			// echo '<pre>';
			// print_r($sy);
			// echo '</pre>';			
		}else{
			// echo 'syarat tidak ada untuk prodi';
		}

		//tambah syarat penulisan dari dpm :
		$dpm 	 = $this->lib_basic->cek_syarat_penulisan($nim);
		$tmp_dpm = 'Lengkap';

		if($dpm == 0){
			$tmp_dpm = 'Belum Lengkap';
			$status_total = 0;
		}
		$sy[] = array(
			'TITLE' => 'Penulisan data kegiatan',
			'SYARAT' => 'Lengkap',
			'NILAI' => $tmp_dpm,
			'STATUS' => $dpm, 
			'KONTAK' => "Petugas PTIPD"
		);

		$data['SYARAT'] = $sy;
		$data['STATUS'] = $status_total;
		return $data;

	}


	function cetak_skpi()
	{
		$nim = $this->session->userdata('id_user');
		$mhs = $this->lib_basic->get_data_mhs($nim);
		$data = array();
		if($mhs){
			$data['mhs'] = $mhs[0];
			$status_skpi = $this->lib_basic->status_skpi_mhs($nim);
			if($status_skpi){
				$data['status'] = $status_skpi;
			}else{
				$data['status'] = 0;
			}
		}	

		$this->output69->output_display('mhs/tampilan_m', $data);
	}

	function cetak(){

		$nim = $this->session->userdata('id_user');
		//KOP ATAS
		//$data['KOP_KEMENTERIAN'];
		$data['KOP_SKPI'] 	 = $this->lib_basic->get_kop_skpi($nim); 
		$data['KOP_NM_UNIV'] = $this->lib_basic->get_nama_univ();

		$data['NOMOR_SKPI']  = 'NOMOR_SKPI_SEMENTARA';//$this->lib_basic->get_nomor_skpi($nim);


		//data header
		//judul (SKPI)

		$status_skpi = $this->lib_basic->status_skpi_mhs($nim);
		if($status_skpi){
			$skpi = $this->lib_basic->get_skpi_mhs($nim);
			$label = $skpi['id_l'];
			$numb_skpi = $skpi['no_skpi'];

			//get data label posisi 0 :
			$masterlabel = $this->lib_basic->get_label(1500, 8, array($label, '0', 1)); //(label aktif, posisi, urutan)
			$header = array(
					'ID'	=> $masterlabel['id_ld'],
					'IDN'	=> $masterlabel['nama_idn'],
					'EN'	=> $masterlabel['nama_en'],
					'ARB'	=> $masterlabel['nama_arb']
				);

			//header done 
			$detaillabel = $this->lib_basic->get_label(1500, 5, array($masterlabel['id_ld']));
			$detailheader = array();
			$i=0;
			foreach ($detaillabel as $key) {
				$detailheader[$i] = array(
						'ID' 	=> $key['id_ld'],
						'IDN'	=> $key['nama_idn'],
						'EN'	=> $key['nama_en'],
						'ARB'	=> $key['nama_arb']
					);
				$i++;
			}

			$mhs = $this->lib_basic->get_data_mhs($nim);
			$hasil = $this->lib_basic->get_label(1500, 8, array($label, '1', 1));
				$DATA_DIRI = array();
				if($hasil){
						$DATA_DIRI[0] = array(
							'idn' => $hasil['nama_idn'],
							'en'  => $hasil['nama_en'],
							'arb' => $hasil['nama_arb']
							);

						$id_ld = $hasil['id_ld'];

						$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
						if($lbl){
							$i = 0;
							$temp = array();
							foreach ($lbl as $key) {
									$temp[$i] = array(
									'idn' => $key['nama_idn'],
									'en'  => $key['nama_en'],
									'arb' => $key['nama_arb']
									);
									$i++;
							}
			//2. LABEL DETAIL
							$DATA_DIRI[1] = $temp;
							$data['status_data_diri'] = TRUE;
						}
					}

			//3. KONTEN
				$DATA_DIRI[2] = array 
				(
					$mhs[0]['NAMA'],
					array('IDN' => $mhs[0]['TMP_LAHIR'].', '.$this->lib_basic->date_indo($mhs[0]['TGL_LAHIR']), 'EN' => $mhs[0]['TMP_LAHIR'].', '.date('F jS Y',strtotime($mhs[0]['TGL_LAHIR']))),
					//$mhs[0]['TMP_LAHIR'].', '.$this->lib_basic->date_indo($mhs[0]['TGL_LAHIR']),
					$mhs[0]['NIM'],
					date('Y', strtotime($mhs[0]['TGL_MASUK'])),
					($this->lib_basic->get_tahun_lulus($nim)=='')?'MASIH AKTIF':$this->lib_basic->get_tahun_lulus($nim),
					($this->lib_basic->get_nomor_ijazah($nim)=='')?'-':$this->lib_basic->get_nomor_ijazah($nim),
					$this->lib_basic->get_gelar($nim)
				);

				$data['mahasiswa'] 	= $DATA_DIRI;
				$data['header'] = $header;
				$data['detailheader'] = $detailheader;
				//DATA DIRI PEMEGANG SKPI DONE


				//DATA INSTANSI PEMBERI SKPI
				$hasil = $this->lib_basic->get_label(1500, 8, array($label, '1', 2));
				$INSTANSI = array();
				if($hasil){
						$INSTANSI[0] = array(
							'idn' => $hasil['nama_idn'],
							'en'  => $hasil['nama_en'],
							'arb' => $hasil['nama_arb']
							);

						$id_ld = $hasil['id_ld'];

						$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
						if($lbl){
							$i = 0;
							$temp = array();
							foreach ($lbl as $key) {
									$temp[$i] = array(
									'idn' => $key['nama_idn'],
									'en'  => $key['nama_en'],
									'arb' => $key['nama_arb']
									);
									$i++;
							}
				//2. LABEL DETAIL
							$INSTANSI[1] = $temp;
							$data['status_instansi'] = TRUE;
						}
					}

				//3. KONTEN

					$sk = $this->lib_basic->get_sk_univ();
					$universitas = $this->lib_basic->get_nama_univ();
					$fakultas = $this->lib_basic->get_nama_fak($nim);
					$prodi = $this->lib_basic->get_nama_prodi($nim);
					$kkni = $this->lib_basic->get_level_kkni($nim);
					$masastudi = $this->lib_basic->get_masa_study($nim);

					$detail_prodi = $this->lib_basic->get_data_prodi_mhs($nim);
					$detail_prodi = $detail_prodi[0];

					$INSTANSI[2] = array 
					(
						$sk,
						$universitas,
						$fakultas,
						$prodi,
						array('IDN' => $detail_prodi['INFO_JENIS_JENJANG_ID'], 'EN' => $detail_prodi['INFO_JENIS_JENJANG_EN']),
						$kkni,
						array('IDN' => $detail_prodi['INFO_SYARAT_TERIMA_ID'], 'EN' => $detail_prodi['INFO_SYARAT_TERIMA_EN']),
						array('IDN' => $detail_prodi['INFO_BAHASA_PENGANTAR_ID'], 'EN' => $detail_prodi['INFO_BAHASA_PENGANTAR_EN']),
						array('IDN' => $detail_prodi['INFO_SIST_PENILAIAN_ID'], 'EN' => $detail_prodi['INFO_SIST_PENILAIAN_EN']),
						$masastudi,
						array('IDN' => $detail_prodi['INFO_JENJANG_LANJUT_ID'], 'EN' => $detail_prodi['INFO_JENJANG_LANJUT_EN']),
						array('IDN' => $detail_prodi['INFO_STATUS_PROFESI_ID'], 'EN' => $detail_prodi['INFO_STATUS_PROFESI_EN'])
					);

				$data['instansi'] = $INSTANSI;


				//DATA CP :
				$CAPAIAN = array();
				$hasil = $this->lib_basic->get_label(1500, 8, array($label, '1', 3));
				if($hasil){
							$CAPAIAN[0] = array(
								'idn' => $hasil['nama_idn'],
								'en'  => $hasil['nama_en'],
								'arb' => $hasil['nama_arb']
								);

							$id_ld = $hasil['id_ld'];

							$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
							if($lbl){
								foreach ($lbl as $key) {
									$CAPAIAN[0]['SUB'] = array(
										'IDN' => $key['nama_idn'],
										'EN'  => $key['nama_en']
										);
								}
							}
				}

				//2. LABEL DETAIL
				//cek cp mhs
				$CAPAIAN['status'] = true;
				$skpi_cp = $this->lib_basic->cek_cp($nim);
				if($skpi_cp){
					$cp = $this->lib_basic->get_data_cp($nim);
					if($cp){
						
						if(!$cp['KONTEN']){

							$CAPAIAN['status'] = false;

						}else{

							$CAPAIAN[1] = $cp['TITLE'];
							$CAPAIAN[2] = $this->lib_basic->get_data_valid_cp($cp['TITLE'], $skpi_cp, $cp['KONTEN']);
						}
					}

				}else{
					$CAPAIAN['status'] = false;
				}

				$data['capaian'] = $CAPAIAN;

				// DATA KEGIATAN :

				//PAKET AKTIVITAS, PRESTASI DAN PENGHARGAAN 
				//1. LABEL HEADER
				$KEGIATAN = array();

				$hasil = $this->lib_basic->get_label(1500, 8, array($label, '1', 4));
				if($hasil){
					$KEGIATAN[0] = array(
						'idn' => $hasil['nama_idn'],
						'en'  => $hasil['nama_en'],
						'arb' => $hasil['nama_arb']
						);
				}

				$id_ld = $hasil['id_ld'];
				
				$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
				if($lbl){
					$i = 0;
					$temp = array();
					foreach ($lbl as $key) {
							$temp[$i] = array(
							'idn' => $key['nama_idn'],
							'en'  => $key['nama_en'],
							'arb' => $key['nama_arb']
							);
							$i++;
					}
				//2. LABEL DETAIL
					$KEGIATAN[1] = array($temp[0], $temp[1], $temp[2], $temp[3], $temp[4]);

				}
				//3. KONTEN
				$skpi_prestasi = $this->lib_basic->cek_prestasi($nim);
				$dpm_prestasi = $this->lib_basic->get_data_prestasi($nim);
				$status_prestasi = false;
				$prestasi = array();
				$i=0;
				if($skpi_prestasi){
					$status_prestasi = true;
					foreach ($dpm_prestasi as $dpm) {
			 			$temp = 0;
			 			foreach ($skpi_prestasi as $skpi) {
			 				if($dpm['ID_RIWAYAT']==$skpi['kd_kegiatan']){
			 					$temp++;
			 				}

			 				if($temp>0){
			 					$prestasi[$i] = array('IDN' => $dpm['NM_LOMBA'], 'EN' => $dpm['NM_LOMBA2']); //$dpm['KETERANGAN'];
			 					$i++;
			 				}
			 			}
					}
				}

				$skpi_organisasi = $this->lib_basic->cek_organisasi($nim);
				$dpm_organisasi = $this->lib_basic->get_data_organisasi($nim);
				$status_organisasi = false;
				$organisasi = array();
				$i=0;
				if($skpi_organisasi){
					$status_organisasi = true;
					foreach ($dpm_organisasi as $dpm) {
			 			$temp = 0;
			 			foreach ($skpi_organisasi as $skpi) {
			 				if($dpm['ID_RIWAYAT']==$skpi['kd_kegiatan']){
			 					$temp++;
			 				}
			 			}

		 				if($temp>0){
		 					$organisasi[$i] = array('IDN' => $dpm['NM_ORGANISASI'], 'EN' => $dpm['NM_ORGANISASI2']); //$dpm['NM_ORGANISASI'];
		 					$i++;
		 				}
			 			
					}
				}

				$skpi_sertifikasi = $this->lib_basic->cek_sertifikasi($nim);
				$dpm_sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);
				$uin_sertifikasi = $this->lib_basic->get_sertifikasi_uin($nim);
				$status_sertifikasi = false;
				$sertifikasi = array();
				$i=0;
				if($skpi_sertifikasi){
					$status_sertifikasi = true;
					foreach ($uin_sertifikasi as $dpm) {
			 			$temp = 0;
			 			foreach ($skpi_sertifikasi as $skpi) {
			 				if($dpm['ID_RIWAYAT']==$skpi['kd_kegiatan']){
			 					$temp++;
			 				}
			 			}

		 				if($temp>0){
		 					$sertifikasi[$i] = array('IDN' => $dpm['NAMA_IDN'], 'EN' => $dpm['NAMA_EN']); //$dpm['NM_sertifikasi'];
		 					$i++;
		 				}			 			
					}

					foreach ($dpm_sertifikasi as $dpm) {
			 			$temp = 0;
			 			foreach ($skpi_sertifikasi as $skpi) {
			 				if($dpm['ID_RIWAYAT']==$skpi['kd_kegiatan']){
			 					$temp++;
			 				}
			 			}

		 				if($temp>0){
		 					$sertifikasi[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_sertifikasi'];
		 					$i++;
		 				}			 			
					}
				}

				$skpi_magang = $this->lib_basic->cek_magang($nim);
				$dpm_magang = $this->lib_basic->get_data_magang($nim);
				$status_magang = false;
				$magang = array();
				$i=0;
				if($skpi_magang){
					$status_magang = true;
					foreach ($dpm_magang as $dpm) {
			 			$temp = 0;
			 			foreach ($skpi_magang as $skpi) {
			 				if($dpm['ID_RIWAYAT']==$skpi['kd_kegiatan']){
			 					$temp++;
			 				}
			 			}

		 				if($temp>0){
		 					$magang[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_magang'];
		 					$i++;
		 				}
			 			
					}
				}

				$skpi_karakter = $this->lib_basic->cek_karakter($nim);
				$dpm_karakter = $this->lib_basic->get_data_karakter($nim);
				$status_karakter = false;
				$karakter = array();
				$i=0;
				if($skpi_karakter){
					$status_karakter = true;
					foreach ($dpm_karakter as $dpm) {
			 			$temp = 0;
			 			foreach ($skpi_karakter as $skpi) {
			 				if($dpm['ID_RIWAYAT']==$skpi['kd_kegiatan']){
			 					$temp++;
			 				}
			 			
			 			}

		 				if($temp>0){
		 					$karakter[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_karakter'];
		 					$i++;
		 				}
			 			
					}
				}

				$KEGIATAN[2] = array($prestasi, $organisasi, $sertifikasi, $magang, $karakter);

				$data['kegiatan']	= $KEGIATAN;


				//DATA INFORMASI SISTEM PENDIDIKAN TINGGI INDONESIA

				$SISTEM = array();
				//LABEL
				$hasil = $this->lib_basic->get_label(1500, 8, array($label, '1', 5));
				if($hasil){
							$SISTEM[0] = array(
								'idn' => $hasil['nama_idn'],
								'en'  => $hasil['nama_en'],
								'arb' => $hasil['nama_arb']
								);

							$id_ld = $hasil['id_ld'];

							$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
							if($lbl){
								foreach ($lbl as $key) {
									$SISTEM[0]['SUB'] = array(
										'IDN' => $key['nama_idn'],
										'EN'  => $key['nama_en']
										);
								}
							}


				}

				//KONTEN
				$informasi_sistem = $this->lib_basic->get_sistem_pendidikan();
				$data['sts_info_sistem'] = false;
				if($informasi_sistem){
					$data['sts_info_sistem'] = true;
					$SISTEM[1] = $informasi_sistem;
				}

				$data['info_sistem'] = $SISTEM;

				//DATA INFORMASI KERANGKA KKNI

				$KKNI = array();

				//LABEL
				$hasil = $this->lib_basic->get_label(1500, 8, array($label, '1', 6));
				if($hasil){
							$KKNI[0] = array(
								'idn' => $hasil['nama_idn'],
								'en'  => $hasil['nama_en'],
								'arb' => $hasil['nama_arb']
								);

				}

				//KONTEN
				$informasi_kkni = $this->lib_basic->get_kkni($nim);
				$data['sts_info_kkni'] = false;
				if($informasi_kkni){
					$data['sts_info_kkni'] = true;
					$KKNI[1] = $informasi_kkni;
				}

				$data['info_kkni'] = $KKNI;

				//data tanda tangan
				$data['ttd'] = $this->lib_basic->tanda_tangan($nim);

				//ending ( detail contact ) :

				//get label dulu :
				$masterlabelf = $this->lib_basic->get_label(1500, 8, array($label, '0', 2)); //(label aktif, posisi, urutan)
				$footer = array(
						'IDN'	=> $masterlabelf['nama_idn'],
						'EN'	=> $masterlabelf['nama_en'],
						'ARB'	=> $masterlabelf['nama_arb']
					);

				$data['footer'] = $footer;
				$end = $this->lib_basic->get_detail_contact($nim);
				$data['alamat'] = $end['alamat'];
				$data['contact'] = $end['contact'];

				$data['logo'] = $this->lib_basic->get_logo_uin($nim);

				$html = $this->load->view('mhs/skpi_pdf_m', $data, true );

				$this->load->library('pdf');

				$this->pdf->SetSubject('Surat Keterangan Pendamping Ijazah');
				$this->pdf->SetKeywords('SKPI, Diploma Supplement, PDF, UIN');

				$this->pdf->setPrintHeader(false);
				//$this->pdf->setPrintFooter(false);
				
				$this->pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
				$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				// set font yang digunakan

				$this->pdf->SetPemegang(ucwords(strtolower($mhs[0]['NAMA'])));

				$this->pdf->SetFont('', '', 12);

				$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set margins
				$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

				// menambahkan halaman (harus digunakan minimal 1 kali)
				$this->pdf->AddPage();

				$this->pdf->writeHTML($html, true, false, true, false, '');
	 			$this->pdf->lastPage();

	 			//nama file pdf
	 			$namafile = $nim.'_DRAFT_SKPI.pdf';

	 			ob_end_clean();
				$this->pdf->Output($namafile, 'I');

		}else{
			redirect(base_url().'skpi/skpi_mhs/daftar_skpi');
		}

		
	}

	function verifikasi_pendaftaran()
	{
		$nim = $this->session->userdata('id_user');

		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		if(isset($_POST['sv_daftar'])){
			$cek = $this->lib_basic->get_skpi_mhs($nim);
			if($cek){
				//do nothing
			}else{
				$no_skpi = $this->lib_basic->noseri();
				$data = array(
					'nim' => $nim,
					'no_skpi' =>$no_skpi,
					'id_l' => $id_l,
					'status' => '0',
					'tgl_setuju' => date('Y-m-d'),
					'nip' => '',
					'unused_label' => '[]'
					);
				$skpi = $this->lib_basic->insert_skpi($data);
			}

		}

		$mhs = $this->lib_basic->get_data_mhs($nim);
		if($mhs[0]['J_KELAMIN']=='L'){
				$data['NAMA'] = 'sdr. '.$mhs[0]['NAMA'];
		}else{
				$data['NAMA'] = 'sdri. '.$mhs[0]['NAMA'];
		}

		$data['STS_SKPI'] = $this->lib_basic->cek_skpi($nim);
		
		//print_r($tes);
		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		//PAKET AKTIVITAS, PRESTASI DAN PENGHARGAAN 
				//1. LABEL HEADER
				$KEGIATAN = array();

				$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 4));
				if($hasil){
					$KEGIATAN[0] = array(
						'idn' => $hasil['nama_idn'],
						'en'  => $hasil['nama_en'],
						'arb' => $hasil['nama_arb']
						);
				}

				$id_ld = $hasil['id_ld'];
				
				$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
				if($lbl){
					$i = 0;
					$temp = array();
					foreach ($lbl as $key) {
							$temp[$i] = array(
							'idn' => $key['nama_idn'],
							'en'  => $key['nama_en'],
							'arb' => $key['nama_arb']
							);
							$i++;
					}
				//2. LABEL DETAIL
					$KEGIATAN[1] = array($temp[0], $temp[1], $temp[2], $temp[3], $temp[4]);

				}
				//3. KONTEN
				//$skpi_prestasi = $this->lib_basic->cek_prestasi($nim);
				$dpm_prestasi = $this->lib_basic->get_data_prestasi($nim);
				$status_prestasi = false;
				$prestasi = array();
				$i=0;
				if($dpm_prestasi){
					$status_prestasi = true;
					foreach ($dpm_prestasi as $dpm) {
						$prestasi[$i] = array('IDN' => $dpm['NM_LOMBA'], 'EN' => $dpm['NM_LOMBA2']);
						$i++;			 			
					}
				}else{
					$prestasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_organisasi = $this->lib_basic->get_data_organisasi($nim);
				$status_organisasi = false;
				$organisasi = array();
				$i=0;
				if($dpm_organisasi){
					$status_organisasi = true;
					foreach ($dpm_organisasi as $dpm) {
			 			$organisasi[$i] = array('IDN' => $dpm['NM_ORGANISASI'], 'EN' => $dpm['NM_ORGANISASI2']); //$dpm['NM_ORGANISASI'];
		 				$i++;
		 				
			 		}
				}else{
					$organisasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);
				$uin_sertifikasi = $this->lib_basic->get_sertifikasi_uin($nim);
				$status_sertifikasi = false;
				$sertifikasi = array();
				$i=0;
				if($dpm_sertifikasi || $uin_sertifikasi){
					$status_sertifikasi = true;

					foreach ($uin_sertifikasi as $dpm) {
	 					$sertifikasi[$i] = array('IDN' => $dpm['NAMA_IDN'], 'EN' => $dpm['NAMA_EN']); //$dpm['NM_sertifikasi'];
	 					$i++;			 			
					}


					foreach ($dpm_sertifikasi as $dpm) {
	 					$sertifikasi[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_sertifikasi'];
	 					$i++;
			 		}
				}else{
					$sertifikasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_magang = $this->lib_basic->get_data_magang($nim);
				$status_magang = false;
				$magang = array();
				$i=0;
				if($dpm_magang){
					$status_magang = true;
					foreach ($dpm_magang as $dpm) {
	 					$magang[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_magang'];
	 					$i++;		 				
			 		}
				}else{
					$magang[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_karakter = $this->lib_basic->get_data_karakter($nim);
				$status_karakter = false;
				$karakter = array();
				$i=0;
				if($dpm_karakter){
					$status_karakter = true;
					foreach ($dpm_karakter as $dpm) {
	 					$karakter[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_karakter'];
	 					$i++;		 				
			 		}
				}else{
					$karakter[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$KEGIATAN[2] = array($prestasi, $organisasi, $sertifikasi, $magang, $karakter);

				$data['KEGIATAN'] = $KEGIATAN;

				$data['string_skpi'] = $this->lib_basic->skpi();

		$this->output69->output_display('mhs/tampilan2_m', $data);
	}

	function verifikasi_pendaftaran_test()
	{
		$nim = '13651065';//$this->session->userdata('id_user');

		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		if(isset($_POST['sv_daftar'])){
			$cek = $this->lib_basic->get_skpi_mhs($nim);
			if($cek){
				//do nothing
			}else{
				$no_skpi = $this->lib_basic->noseri();
				$data = array(
					'nim' => $nim,
					'no_skpi' =>$no_skpi,
					'id_l' => $id_l,
					'status' => '0',
					'tgl_setuju' => date('Y-m-d'),
					'nip' => '',
					'unused_label' => '[]'
					);
				$skpi = $this->lib_basic->insert_skpi($data);
			}

		}

		$mhs = $this->lib_basic->get_data_mhs($nim);
		if($mhs[0]['J_KELAMIN']=='L'){
				$data['NAMA'] = 'sdr. '.$mhs[0]['NAMA'];
		}else{
				$data['NAMA'] = 'sdri. '.$mhs[0]['NAMA'];
		}

		$data['STS_SKPI'] = $this->lib_basic->cek_skpi($nim);
		
		//print_r($tes);
		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		//PAKET AKTIVITAS, PRESTASI DAN PENGHARGAAN 
				//1. LABEL HEADER
				$KEGIATAN = array();

				$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 4));
				if($hasil){
					$KEGIATAN[0] = array(
						'idn' => $hasil['nama_idn'],
						'en'  => $hasil['nama_en'],
						'arb' => $hasil['nama_arb']
						);
				}

				$id_ld = $hasil['id_ld'];
				
				$lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
				if($lbl){
					$i = 0;
					$temp = array();
					foreach ($lbl as $key) {
							$temp[$i] = array(
							'idn' => $key['nama_idn'],
							'en'  => $key['nama_en'],
							'arb' => $key['nama_arb']
							);
							$i++;
					}
				//2. LABEL DETAIL
					$KEGIATAN[1] = array($temp[0], $temp[1], $temp[2], $temp[3], $temp[4]);

				}
				//3. KONTEN
				//$skpi_prestasi = $this->lib_basic->cek_prestasi($nim);
				$dpm_prestasi = $this->lib_basic->get_data_prestasi($nim);
				$status_prestasi = false;
				$prestasi = array();
				$i=0;
				if($dpm_prestasi){
					$status_prestasi = true;
					foreach ($dpm_prestasi as $dpm) {
						$prestasi[$i] = array('IDN' => $dpm['NM_LOMBA'], 'EN' => $dpm['NM_LOMBA2']);
						$i++;			 			
					}
				}else{
					$prestasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_organisasi = $this->lib_basic->get_data_organisasi($nim);
				$status_organisasi = false;
				$organisasi = array();
				$i=0;
				if($dpm_organisasi){
					$status_organisasi = true;
					foreach ($dpm_organisasi as $dpm) {
			 			$organisasi[$i] = array('IDN' => $dpm['NM_ORGANISASI'], 'EN' => $dpm['NM_ORGANISASI2']); //$dpm['NM_ORGANISASI'];
		 				$i++;
		 				
			 		}
				}else{
					$organisasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);
				$uin_sertifikasi = $this->lib_basic->get_sertifikasi_uin($nim);
				$status_sertifikasi = false;
				$sertifikasi = array();
				$i=0;
				if($dpm_sertifikasi || $uin_sertifikasi){
					$status_sertifikasi = true;

					foreach ($uin_sertifikasi as $dpm) {
	 					$sertifikasi[$i] = array('IDN' => $dpm['NAMA_IDN'], 'EN' => $dpm['NAMA_EN']); //$dpm['NM_sertifikasi'];
	 					$i++;			 			
					}


					foreach ($dpm_sertifikasi as $dpm) {
	 					$sertifikasi[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_sertifikasi'];
	 					$i++;
			 		}
				}else{
					$sertifikasi[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_magang = $this->lib_basic->get_data_magang($nim);
				$status_magang = false;
				$magang = array();
				$i=0;
				if($dpm_magang){
					$status_magang = true;
					foreach ($dpm_magang as $dpm) {
	 					$magang[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_magang'];
	 					$i++;		 				
			 		}
				}else{
					$magang[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$dpm_karakter = $this->lib_basic->get_data_karakter($nim);
				$status_karakter = false;
				$karakter = array();
				$i=0;
				if($dpm_karakter){
					$status_karakter = true;
					foreach ($dpm_karakter as $dpm) {
	 					$karakter[$i] = array('IDN' => $dpm['NM_KEGIATAN'], 'EN' => $dpm['NM_KEGIATAN2']); //$dpm['NM_karakter'];
	 					$i++;		 				
			 		}
				}else{
					$karakter[0] = array('IDN' => ' - ', 'EN' => ' - ');
				}

				$KEGIATAN[2] = array($prestasi, $organisasi, $sertifikasi, $magang, $karakter);

				$data['KEGIATAN'] = $KEGIATAN;

		$this->output69->output_display('mhs/tampilan2_m', $data);
	}
}