<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skpi_admin extends CI_Controller {

	private $judul = 'Admin SKPI UIN Sunan Kalijaga Yogyakarta';
	private $btn_back = '<button class="btn-uin btn btn-inverse btn btn-small">Kembali</button>';


	function __construct()
	{
		parent::__construct();
		$this->api = $this->s00_lib_api;
		$this->output69 = $this->s00_lib_output;

		$this->session->set_userdata('app', 'skpi_00');
		$this->load->library('skpi_lib_basic','','lib_basic');

		$this->lib_basic->auto_update_label();

		$who = $this->lib_basic->cek_allowed('SKPI0');
		if(!$this->session->userdata('skpi_lvl')){
			if(!$who){
				redirect(base_url());
			}else{
				$this->validasi($who);
			}
		}

	}


	function validasi($who){
		foreach ($who as $key => $value) {
			$lvl = substr($value, -1);
			switch ($lvl) {
				case 0:
					$lvl_adm = $this->session->userdata('jabatan');
					$lvl_adm = explode("#", $lvl_adm);
					$adm = '';
					for ($i=0; $i < count($lvl_adm); $i++) {
						if(substr($lvl_adm[$i], 0, 4) == 'SKPI'){
							$temp = substr($lvl_adm[$i], -3);
							if($temp == '000'){

								$array = array(
									'skpi_lvl' => 'root'
								);
								
								$this->session->set_userdata( $array );
								//$this->index();


							}else if($temp == '001'){

								$array = array(
									'skpi_lvl' => 'admin'
								);
								
								$this->session->set_userdata( $array );
								//$this->index();

							}else{
								$array = array(
									'skpi_lvl' => 'laporan'
								);
								
								$this->session->set_userdata( $array );
								//$this->index();

							}
						}
					}

					break;
				default:
					redirect(base_url());
					break;
			}
		}
	}

	function testing($nim = ''){

		// $test = $this->lib_basic->test_status_skpi('13651060');
		// //print_r($data);
		// // $test = $this->lib_basic->unit_to_kode('UA000009');
		// // print_r($test);
		// //foreach ($test as $key) {
		// 	foreach ($test as $keys => $value) {
		// 		echo $keys.' : '.$value;
		// 		echo '<br>';
		// 	}
		//}

		// $data = $this->api->get_api_json(
		// 	URL_API_BKD.'/bkd_beban_kerja/get_subgroup_nilai_sks',
		// 	'POST',
		// 	array('api_search' => array(42))
		// );

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		//$data = $this->lib_basic->get_jab_fun('197701032005011003');
		//$data = $this->session->userdata('status');//$this->lib_basic->get_sertifikasi_uin('13651060');
		$data = $this->lib_basic->get_data_mhs('13651060');
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		//$url = "http://service.uin-suka.ac.id/servsiasuper/index.php/sia_public/sia_sistem/data_search"

		$kd_ta = $this->session->userdata('kd_ta');
		$kd_smt = $this->session->userdata('kd_smt');
		$kd_prodi = $data[0]['KD_PRODI'];

		// echo "kd_ta : ".$kd_ta." <br>";
		// echo "kd_smt : ".$kd_smt." <br>";
		// echo "kd_prodi : ".$kd_prodi." <br>";

		$test = $this->api->get_api_json(
			"http://service.uin-suka.ac.id/servsiasuper/index.php/sia_public/sia_sistem/data_search",
			'POST',
			array(
				'api_kode' => 200001,
				'api_subkode' => 28,
				'api_search' => array($kd_ta, $kd_smt, $kd_prodi, 0)
			)
		);

		// echo '<pre>';
		// print_r($test);
		// echo '</pre>';


		//fungsi untuk dapat informasi tugas akhir mahasiswa
		// $daftar = $this->mdl_skripsi->get_api('sia_skripsi_bimbingan/mhs_daftar','json','POST', 
		// 		array('api_kode' => 1000, 'api_subkode' => 3, 'api_search' => array($nim, $periode)));
		// $data = $this->mdl_skripsi->get_api('sia_skripsi_bimbingan/jadwalMunaqosah','json','POST', 
		// 	array('api_kode' => 1001, 'api_subkode' => 1, 'api_search' => array($daftar, $periode)));

		$daftar = $this->api->get_api_json(
					'http://service.uin-suka.ac.id/servtugasakhir/sia_skripsi_public/sia_skripsi_bimbingan/mhs_daftar',
					'POST',
					array(
						'api_kode' => 1000,
						'api_subkode' => 3,
						'api_search' => array('13651060', '2')
					)

		);

		$data = $this->api->get_api_json(
					'http://service.uin-suka.ac.id/servtugasakhir/sia_skripsi_public/sia_skripsi_bimbingan/jadwalMunaqosah',
					'POST',
					array(
						'api_kode' => 1001,
						'api_subkode' => 1,
						'api_search' => array($daftar, '2')
					)

		);

		// echo '<pre>';
		// print_r($daftar);
		// echo '</pre>';

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		// $this->get_syarat_daftar();

		// $data = $this->lib_basic->get_univ('fak');
		// foreach ($data as $key ) {
		// 	//echo 'Fakultas : '.$key['NM_FAK']; echo '<br>';
		// 	$data2 = $this->lib_basic->get_univ('prod', $key['KD_FAK']);
		// 	foreach ($data2 as $keys) {
		// 		$query = "INSERT INTO JENJANG_PRODI VALUES('".$keys['KD_PRODI']."','".$keys['NM_JENIS']."');";
		// 		echo $query; echo '<br>';
		// 		//echo 'JENJG :'.$keys['NM_JENIS']; echo '<br>';
		// 		echo '<br>';
		// 	}
		// 	//echo '<br>';
		// }
		// $data = $this->lib_basic->get_data_prodi_mhs('13510007');
		// print_r($data);

		//$this->output69->output_display('admin/testing');

		// if(isset($_POST['sv_master_label'])){
		// 	echo $_POST['tgl_mulai'];
		// 	$data = $this->lib_basic->date_db($_POST['tgl_mulai']);
		// 	echo '<br>';e
		// 	echo date('d-M-Y',strtotime($data));
		// }

		// // $data = $this->lib_basic->auto_update_label();
		// // if($data){
		// // 	print_r($data);
		// // }else{
		// // 	echo "hallo";
		// // }

		// $hasil = $this->lib_basic->get_label(1500, 8, array('12', '1', 1));
		// //print_r($hasil);

		// echo '<br>';
		// echo '<br>';

		// $data = $this->lib_basic->get_data_mhs('13651060');
		// $data = $this->lib_basic->get_data_prodi($data[0]['KD_PRODI']);
		// //print_r($data);

		// echo '<br>';
		// echo '<br>';

		// $data = $this->lib_basic->get_json_unused_label('22607', '12');
		// echo $data;
		// echo '<br>';
		// echo '<br>';
		// $test = $this->lib_basic->get_status_label_cetak_mhs('28',$data);

		// echo '<br>';
		// echo '<br>';

		// echo $test;

		// echo '<br>';
		// echo '<br>';

		// $data = json_decode($data);
		// print_r($data);
			//$this->output69->output_display('admin/list_cetak');

			// $data = $this->lib_basic->status_skpi_mhs('13651060');
			// if($data){
			// 	echo "aktif";
			// }else{
			// 	echo "tidak aktif";
			// }
			// $id_ld = '23';

			// $lbl = $this->lib_basic->get_label(1500, 5, array($id_ld));
			// if($lbl){
			// 	$i = 0;
			// 	$temp = array();
			// 	foreach ($lbl as $key) {
			// 			$temp[$i] = array(
			// 			'idn' => $key['nama_idn'],
			// 			'en'  => $key['nama_en'],
			// 			'arb' => $key['nama_arb']
			// 			);
			// 			$i++;
			// 	}

			// 	for ($i=0; $i < count($temp); $i++) { 
			// 		echo $temp[$i]['idn'];
			// 		echo "<br>";
			// 	}
			// }

			// $data = $this->lib_basic->get_data_kegiatan($nim);
			//   if($data){

			//   	//print_r($data);
			  	
			// 		foreach ($data as $key) {
			// 			//echo $key['NM_FAK'];
			// 			foreach ($key as $key1 => $value1) {
			// 				echo $key1.' : '.$value1; echo "<br>";
			// 			}
			// 			echo "<br>";
			// 		}
				

			// }else{

			// 	$data = $this->lib_basic->get_univ('fak');
			// 	if($data){
					
			// 		foreach ($data as $key) {
			// 			//echo $key['NM_FAK'];
			// 			foreach ($key as $key1 => $value1) {
			// 				echo $key1.' : '.$value1; echo "<br>";
			// 			}
			// 			echo "<br>";
			// 		}

			// 	}else{
			// 		print_r($data);
			// 		echo "gagal";
			// 	}

			//}

			//cek file :
			// $nim = '13651060';
			// $id_riwayat = '136510601000962121';

			// $data = $this->lib_basic->cek_sertifikat_prestasi($nim, $id_riwayat);
			// if($data){
			// 	// echo $data;
			// 	// $this->lib_basic->download_sertifikat($data);
			// 	foreach ($data as $key) {
			// 		$docname = $key['DOC_SERTIF_LOMBA'];
			// 		$filename = $key['DOC_SERTIF_LOMBA_NAME'];
			// 	}

			// 	// echo $docname;
			// 	// echo "<br>";
			// 	// echo $filename;

			// 	//echo base64_decode($docname);

			// 	$this->lib_basic->download_sertifikat($filename, $docname);
			// }else{
			// 	echo "oh noo";
			// }

			$cek = $this->get_syarat_daftar();
			echo '<pre>';
			print_r($cek);
			echo '</pre>';

			echo number_format(3.6,2);		
	}

	function bukaksitik(){
		$data = $this->lib_basic->get_skpi_mhs('13651086');
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	function mahasiswa_daftar_skpi_testing()
	{
		// $nim = '13610046';
		$nim = '13651060';

		$hasil = $this->lib_basic->get_label(1500, 2, array());
		$id_l = $hasil['id_l']; // id label yang sedang aktif

		$data['SYARAT_DAFTAR'] = $this->get_syarat_daftar($nim);
		$mhs = $this->lib_basic->get_data_mhs($nim);

		// $_POST['sv_daftar'] = 1;

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
				// die();
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
				$penulisan_sertifikasi = 1;
				$status_sertifikasi = false;
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

				$data['LINK_DPM'] = array(
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_prestasi',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_organisasi',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_kegiatan',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_kegiatan',
					'http://akademik.uin-suka.ac.id/data_pribadi_mahasiswa/data_kegiatan');

				// $data['LINK_ISI'] = array(
				// 	'PRESTASI' => '',
				// 	'ORGANISASI' => '',
				// 	'KEGIATAN' => ''					
				// );

				// echo '<pre>';
				// print_r($data);
				// echo '</pre>';

				// die();

		$this->output69->output_display('admin/tampilan_m_admin_testing', $data);
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
		
		}else{
			// echo 'syarat tidak ada untuk prodi';

		}

		//tambah syarat penulisan dari dpm :
		$dpm 	 = $this->lib_basic->cek_syarat_penulisan($nim);
		$tmp_dpm = 'LENGKAP';

		if($dpm == 0){
			$tmp_dpm = 'BELUM LENGKAP';
			$status_total = 0;
		}
		$sy[] = array(
			'TITLE' => 'Penulisan data kegiatan',
			'SYARAT' => 'LENGKAP',
			'NILAI' => $tmp_dpm,
			'STATUS' => $dpm, 
			'KONTAK' => "Data Pribadi Mahasiswa"
		);

		// $sy[$last_id]['TITLE']  = 'Penulisan data kegiatan';
		// $sy[$last_id]['SYARAT'] = 'LENGKAP';
		// $sy[$last_id]['NILAI']	= $tmp_dpm;
		// $sy[$last_id]['STATUS']	= $dpm;


		$data['SYARAT'] = $sy;
		$data['STATUS'] = $status_total;
		return $data;

	}

	function testing_syarat(){
		$nim = '13610046';
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

		$semester = $syarat[3]['SY_ISI'];
		$semester = explode('#', $semester);
		sort($semester);


		echo '<pre>';
		print_r($syarat);
		echo '</pre>';

	}

	function index(){
		$judul = $this->lib_basic->skpi();
		$data['judul'] = 'Admin '.$judul[0].' UIN Sunan Kalijaga Yogyakarta';
		$data['string_judul'] = $this->lib_basic->skpi();
		$this->output69->output_display('admin/home', $data);
	}

	function pengaturan_label($id_l = 'X0X'){
		if($id_l=='X0X'){
			$data['judul'] = $this->judul;
			//$data['label'] = $this->lib_basic->get_label(1500, 1, array('status'));

			$temp_label = $this->lib_basic->get_label(1500, 1, array('status'));
			$temp = array();
			$i=0;
			if($temp_label){
				foreach ($temp_label as $key) {
					if($key['tgl_mulai']!=''){
						$key['tgl_mulai'] = $this->lib_basic->date_indo(date('d-m-Y', strtotime($key['tgl_mulai'])));
					}

					if($key['tgl_selesai']!=''){
						$key['tgl_selesai'] = $this->lib_basic->date_indo(date('d-m-Y', strtotime($key['tgl_selesai'])));
					}

					$temp[$i] = $key;
					$i++;

				}
			}

			$data['label'] = $temp;


		 	$data['jml_label'] = count($data['label']);
		 	$data['level'] = $this->session->userdata('skpi_lvl');
		 	$this->output69->output_display('admin/pengaturan_label', $data);
		}else{

			if(isset($_POST['sv_label'])){
				$_POST['cek'] = true;
				$label_ceklist = array();
				if(isset($_POST['status'])){
					$label_ceklist = $_POST['status'];
				}
				$evaluasi = $this->lib_basic->evaluasi_label_prodi($_POST['kd_prodi'], $id_l, $label_ceklist);
			}

			$data['master_label'] = $id_l;
			$fakultas = $this->lib_basic->get_univ('fak');		

			$i=0;
			$data['ls_kd_fak'] = array();
			$data['ls_nm_fak'] = array();
			foreach ($fakultas as $key) {
				$data['ls_kd_fak'][$i] = $key['KD_FAK'];
				$data['ls_nm_fak'][$i] = $key['NM_FAK'];
				$i++;
			}

			 if(isset($_POST['kd_fak'])){
			 	$data['kd_fak'] = $_POST['kd_fak'];

				$prodi = $this->lib_basic->get_univ('prod', $_POST['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
				$i=0;
				foreach ($prodi as $key) {
					$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
					$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
					$i++;
				}

				if(isset($_POST['kd_prodi'])){
					$data['kd_prodi'] = $_POST['kd_prodi'];
				}
			 }

			 $data['show'] = false;
			 if(isset($_POST['cek'])){
			 	$data['show'] = true;
			 	if($_POST['kd_fak']!='X0X' && $_POST['kd_prodi']!='X0X'){
			 		$data['label_prodi'] = true;
			 		$data['label_konten'] = $this->lib_basic->get_label_prodi($data['kd_prodi'], $id_l);
				}else{
					$data['label_prodi'] = false;
					$data['kd_fak'] = $_POST['kd_fak'];
					$data['kd_prodi'] = $_POST['kd_prodi'];
				}
			 }


			 $this->output69->output_display('admin/pengaturan_label_detail', $data);

			
		}
	}

	function label_skpi(){
		$level = $this->session->userdata('skpi_lvl');
		if($level=='root' || $level =='admin' || $level=='laporan' || $this->session->userdata('id_user') == 'PKSI100'){
			$data['judul'] = $this->judul;
			$data['tambah'] = anchor('skpi/skpi_admin/tambah_label', 'Tambah Label', array('class' => 'btn-uin btn btn-inverse btn btn-small'));

			$pesan = $this->session->flashdata('pesan');
			if($pesan!='' || $pesan!=NULL || $pesan){
				$data['pesan'] = $pesan;
			}

			//$data['label'] = $this->lib_basic->get_label(1500, 1, array('status'));
			$temp_label = $this->lib_basic->get_label(1500, 1, array('status'));
			$temp = array();
			$i=0;
			if($temp_label){
				foreach ($temp_label as $key) {
					if($key['tgl_mulai']!=''){
						$key['tgl_mulai'] = $this->lib_basic->date_indo(date('d-m-Y', strtotime($key['tgl_mulai'])));
					}

					if($key['tgl_selesai']!=''){
						$key['tgl_selesai'] = $this->lib_basic->date_indo(date('d-m-Y', strtotime($key['tgl_selesai'])));
					}

					$temp[$i] = $key;
					$i++;

				}
			}

			$data['label'] = $temp;

		 	$data['jml_label'] = count($data['label']);

		 	$data['level'] = $this->session->userdata('skpi_lvl');

			$this->output69->output_display('admin/master_label', $data);
		}else{
			redirect(base_url());
		}
		
	}

	function simpan_label(){

		if(isset($_POST['sv_editlabel'])){ //update done
			$id 	= $_POST['id'];
			$id_l 	= $_POST['id_l'];
			$id_md 	= $_POST['id_md'];
			$idn 	= $_POST['title_nama_idn']; 
			$en 	= $_POST['title_nama_en']; 
			$arb 	= $_POST['title_nama_arb']; 
			$urutan = $_POST['title_urutan'];
			$posisi	= $_POST['title_posisi'];

			if($id_md==''){
				$data = array (
				'id_ld' 	=> $id,
				'id_l'		=> $id_l,
				'nama_idn'	=> $idn,
				'nama_en'	=> $en,
				'nama_arb'	=> $arb,
				'posisi'	=> $posisi,
				'urut'		=> $urutan
				);
			}else{
				$data = array (
				'id_ld' 	=> $id,
				'id_l'		=> $id_l,
				'nama_idn'	=> $idn,
				'nama_en'	=> $en,
				'nama_arb'	=> $arb,
				'posisi'	=> $posisi,
				'urut'		=> $urutan,
				'ref'		=> $id_md
				);
			}

			$hasil = $this->lib_basic->update_label(1500, 1, array($id, $data));
			if($hasil){
				if($id_md==''){
					redirect('skpi/skpi_admin/tambah_label/'.$id_l,'refresh');
				}else{
					redirect('skpi/skpi_admin/tambah_label_detail/'.$id_md.'/'.$id_l,'refresh');
				}
			}else{
				echo "upps, something wrong !";
			}

		}else if(isset($_POST['sv_title'])){ //insert new label level 0 done
			$id_l 	= $_POST['id_l'];
			$idn 	= $_POST['title_nama_idn']; 
			$en 	= $_POST['title_nama_en']; 
			$arb 	= $_POST['title_nama_arb']; 
			$urutan = $_POST['title_urutan'];
			$posisi = $_POST['title_posisi'];

			if($id_l==''){
				//create data master label dulu
				$tgl_mulai = date('Y-m-d');
				$tgl_selesai = date('Y-m-d');
				$data = array
				(
					'tgl_mulai'	=> $tgl_mulai,
					'tgl_selesai'	=> $tgl_selesai,
				);

				//insert sekaligus dapat return value last_val dari ID_L
				$idl_baru = $this->lib_basic->insert_label(1500, 1, array($data));
				$data_label = array 
				(
					'id_l' => $idl_baru['id_l'],
					'nama_idn' => $idn,
					'nama_en' => $en,
					'nama_arb' => $arb,
					'urut' => $urutan,
					'posisi' => $posisi
				);

				$hasil = $this->lib_basic->insert_label(1500, 2, array($data_label));
				 if($hasil){
				 	redirect('skpi/skpi_admin/tambah_label/'.$idl_baru['id_l'],'refresh');
				 }else{
				 	echo "something wrong :(";
				 }

			}else{
				//langsung simpen menggunakan id_l yang sudah ada;
				$data_label = array 
				(
					'id_l' => $id_l,
					'nama_idn' => $idn,
					'nama_en' => $en,
					'nama_arb' => $arb,
					'urut' => $urutan,
					'posisi' => $posisi
				);

				$hasil = $this->lib_basic->insert_label(1500, 2, array($data_label));
				 if($hasil){
				 	redirect('skpi/skpi_admin/tambah_label/'.$id_l,'refresh');
				 }else{
				 	echo "something wrong :(";
				 }
			}

		}else if(isset($_POST['sv_konten'])){ //insert new label level 1 done
			
			$id_l 	= $_POST['id_l'];
			$idn 	= $_POST['konten_nama_idn']; 
			$en 	= $_POST['konten_nama_en']; 
			$arb 	= $_POST['konten_nama_arb']; 
			$urutan = $_POST['konten_urutan'];
			$posisi = $_POST['konten_posisi'];

			//$api_url = $this->api_url.'skpi_label/simpan';

			if($id_l==''){

				//nyimpan ke master label dulu :
				$tgl_mulai = date('Y-m-d');
				$tgl_selesai = date('Y-m-d');
				$data = array
				(
					'tgl_mulai'	=> $tgl_mulai,
					'tgl_selesai'	=> $tgl_selesai,
				);

				$idl_baru = $this->lib_basic->insert_label(1500, 1, array($data));
				$data_label = array 
				(
					'id_l' => $idl_baru['id_l'],
					'nama_idn' => $idn,
					'nama_en' => $en,
					'nama_arb' => $arb,
					'urut' => $urutan,
					'posisi' => $posisi
				);

				$hasil = $this->lib_basic->insert_label(1500, 2, array($data_label));

				 if($hasil){
				 	redirect('skpi/skpi_admin/tambah_label/'.$idl_baru['id_l'],'refresh');
				 }else{
				 	echo "something wrong :(";
				 }

			}else{
				//langsung simpen menggunakan id_l yang sudah ada;
				$data_label = array 
				(
					'id_l' => $id_l,
					'nama_idn' => $idn,
					'nama_en' => $en,
					'nama_arb' => $arb,
					'urut' => $urutan,
					'posisi' => $posisi
				);

				$hasil = $this->lib_basic->insert_label(1500, 2, array($data_label));

				 if($hasil){
				 	redirect('skpi/skpi_admin/tambah_label/'.$id_l,'refresh');
				 }else{
				 	echo "something wrong :(";
				 }
			} 

		}else if(isset($_POST['sv_detail_konten'])){	//insert new label level 2 done

			$id_l 	= $_POST['id_l'];
			$id_md 	= $_POST['id_md'];
			$idn 	= $_POST['detail_nama_idn']; 
			$en 	= $_POST['detail_nama_en']; 
			$arb 	= $_POST['detail_nama_arb']; 
			$urutan = $_POST['detail_urutan'];
			$posisi	= $_POST['detail_posisi'];

			$data = array (

			'id_l'		=> $id_l,
			'nama_idn'	=> $idn,
			'nama_en'	=> $en,
			'nama_arb'	=> $arb,
			'posisi'	=> $posisi,
			'urut'		=> $urutan,
			'ref'		=> $id_md
			);

			$hasil = $this->lib_basic->insert_label(1500, 2, array($data));

			 if($hasil){
			 	redirect('skpi/skpi_admin/tambah_label_detail/'.$id_md.'/'.$id_l,'refresh');
			 }else{
			 	echo "something wrong :(";
			 }

		}else if(isset($_POST['sv_master_label'])){    //update master label, keterangan dan status
			//$api_url = $this->api_url.'skpi_label/update';
			$id_l = $_POST['id_label'];
			$tanggal_sekarang = date('Y-m-d');
			$tanggal_m = $this->lib_basic->date_db($_POST['tgl_mulai']);
			$tanggal_s = $this->lib_basic->date_db($_POST['tgl_selesai']);

			if($tanggal_s < $tanggal_m){
				$tanggal_s = $tanggal_m;
			}

			if($_POST['status_label']==$_POST['status_awal']){
				if($tanggal_sekarang>=$tanggal_m && $tanggal_sekarang<=$tanggal_s){
					$data = array 
					(
						'tgl_mulai'  => date('Y-m-d',strtotime($tanggal_m)),
						'tgl_selesai'  => date('Y-m-d',strtotime($tanggal_s)),
						'keterangan' => $_POST['keterangan_label']
					);
					//$api_subkode = 3;
				}else{
					$data = array 
					(
						'tgl_mulai'  => date('Y-m-d',strtotime($tanggal_m)),
						'tgl_selesai'  => date('Y-m-d',strtotime($tanggal_s)),
						'status' => '0',
						'keterangan' => $_POST['keterangan_label']
					);
					//$api_subkode = 3;
				}

				// $data = array 
				// (
				// 	'tgl_mulai'  => date('Y-m-d',strtotime($tanggal_m)),
				// 	'tgl_selesai'  => date('Y-m-d',strtotime($tanggal_s)),
				// 	'keterangan' => $_POST['keterangan_label']
				// );
				$api_subkode = 3;

			}else{

				if($_POST['status_label']=='1'){
					
					if($tanggal_m<=$tanggal_sekarang && $tanggal_sekarang<=$tanggal_s){
						$data = array 
						(
							'tgl_mulai'	=> date('Y-m-d', strtotime($tanggal_m)),
							'tgl_selesai'	=> date('Y-m-d', strtotime($tanggal_s)),
							'status'	=> '1',
							'keterangan'	=> $_POST['keterangan_label']
						);
						$api_subkode = 2;
					}else{
						$data = array 
						(
							'tgl_mulai'  => date('Y-m-d',strtotime($tanggal_m)),
							'tgl_selesai'  => date('Y-m-d',strtotime($tanggal_s)),
							'status' => '0',
							'keterangan' => $_POST['keterangan_label']
						);
						$api_subkode = 3;
						$this->session->set_flashdata('pesan', 'Masa Berlaku Label Tidak Memenuhi Persyaratan !');
					}

					// $data = array 
					// (
					// 	'tgl_mulai'	=> date('Y-m-d'),
					// 	'status'	=> '1',
					// 	'keterangan'	=> $_POST['keterangan_label']
					// );
					// $api_subkode = 2;

				}else{
					$data = array 
					(
						'tgl_mulai'  => date('Y-m-d',strtotime($tanggal_m)),
						'tgl_selesai'  => date('Y-m-d',strtotime($tanggal_s)),
						'status' => '0',
						'keterangan' => $_POST['keterangan_label']
					);
					$api_subkode = 3;

				}
			}

			$hasil = $this->lib_basic->update_label(1500, $api_subkode, array($id_l, $data));
			if($hasil){
				redirect('skpi/skpi_admin/label_skpi','refresh');
			}else{
				echo "ups.. something wrong !";
			}

		}else{
			echo "ups.. something wrong !";
		}
	}


	function tambah_label($id_l = ''){
		$data['level'] = $this->session->userdata('skpi_lvl');
		$data['judul']	= $this->judul;
		$data['back']	= anchor('skpi/skpi_admin/label_skpi', $this->btn_back, array('class' => 'kembali'));

		$data['id_l'] = $id_l;
		
		$data['jml_label_title'] = 0;
		$data['jml_label_konten'] = 0;

		if($id_l!=''){

			//$data['label'] = $this->lib_basic->get_label(1500, 7, array($id_l));
			$temp = $this->lib_basic->get_label(1500, 7, array($id_l));
			$temp['tgl_mulai'] = $this->lib_basic->date_indo($temp['tgl_mulai']);
			$temp['tgl_selesai'] = $this->lib_basic->date_indo($temp['tgl_selesai']);
			$data['label'] = $temp;



			$data['label_title'] = $this->lib_basic->get_label(1500, 3, array($id_l));

	 		$data['jml_label_title'] = count($data['label_title']);

			$data['label_konten'] = $this->lib_basic->get_label(1500, 4, array($id_l));

	 		$data['jml_label_konten'] = count($data['label_konten']);

		}

		$this->output69->output_display('admin/tambahlabel', $data);
	}

	function tambah_label_detail($id='', $id_l=''){
		$data['level'] = $this->session->userdata('skpi_lvl');
		$data['id_md'] = $id;
		$data['id_l'] = $id_l;
		$data['judul'] = $this->judul;
		$data['back'] = anchor('skpi/skpi_admin/tambah_label/'.$id_l, $this->btn_back, array('class' => 'kembali'));

		$data['label_konten'] = $this->lib_basic->get_label(1500, 6, array($id));

		$data['label_title_detail'] = $this->lib_basic->get_label(1500, 5, array($id));

	 	$data['jml_label_detail'] = count($data['label_title_detail']);

		$this->output69->output_display('admin/tambahlabeldetail', $data);
	}

	function edit_label($id ='', $id_l = '', $id_md = ''){
		/*
			$id 		: id label yang akan diedit
			$id_l 		: id master label yang diseleksi
			$id_md		: id master branch jika tidak null berarti label berada pada posisi 2
		*/

		$data['id'] = $id;
		$data['id_l'] = $id_l;
		$data['id_md'] = $id_md;
		$data['judul'] = $this->judul;

		//generate tombol kembali
		if ($id_md=='') {
			$data['back'] = anchor('skpi/skpi_admin/tambah_label/'.$id_l, $this->btn_back, array('class' => 'kembali'));
		}else{
			$data['back'] = anchor('skpi/skpi_admin/tambah_label_detail/'.$id_md.'/'.$id_l, $this->btn_back, array('class' => 'kembali'));
		}

		//ambil data sesuai id_ld :
		$data['label'] = $this->lib_basic->get_label(1500, 6, array($id));

		$this->output69->output_display('admin/editlabel', $data);
	}

	function hapus_label($id = '', $id_l = '', $id_md = ''){
		/*
			$id 		: id label yang akan dihapus
			$id_l 		: id master label yang diseleksi
			$id_md		: id master branch jika tidak null berarti label berada pada posisi 2
		*/
		$hasil = $this->lib_basic->delete_label(1500, 1, array($id));
		if($hasil){
			if ($id_md=='') {
				redirect('skpi/skpi_admin/tambah_label/'.$id_l,'refresh');
			}else{
				redirect('skpi/skpi_admin/tambah_label_detail/'.$id_md.'/'.$id_l,'refresh');
			}
		}else{
			echo "<script>alert('Data label yang akan dihapus masih memiliki sub label, silahkan hapus sub labelnya terlebih dahulu !');</script>";
			if ($id_md=='') {
				redirect('skpi/skpi_admin/tambah_label/'.$id_l,'refresh');
			}else{
				redirect('skpi/skpi_admin/tambah_label_detail/'.$id_md.'/'.$id_l,'refresh');
			}
		}
	}

	function pengaturan_penulisan_sertifikasi($edit = null, $switch = null, $id = null ){
		$data['level'] = $this->session->userdata('skpi_lvl');
		//CEK KONDISI EDIT / UPDATE
		if($edit == 'edit'){
			if($switch == 'kode'){
				$data['kode_pen'] = $this->lib_basic->get_kode_penulisan($id);
			}else if($switch == 'pengaturan'){
				$data['pengaturan_penulisan_id'] = $this->lib_basic->get_pengaturan_penulisan($id);
			}
		}

		if(isset($_POST['sv_kode'])){
			$kode = $_POST['kode']; $keterangan = $_POST['keterangan']; $status = $_POST['status'];
			$this->lib_basic->insert_kode_penulisan($kode, $keterangan, $status);
		}

		if(isset($_POST['up_kode'])){
			$this->lib_basic->update_kode_penulisan($_POST['old_kode'], $_POST['kode'], $_POST['keterangan'], $_POST['status']);
		}

		if(isset($_POST['dt_kode'])){
			$this->lib_basic->delete_kode_penulisan($_POST['old_kode']);
		}

		if(isset($_POST['sv_pengaturan'])){
			$this->lib_basic->insert_pengaturan_penulisan(
				$_POST['kode_penulisan'],
				$_POST['nama_id'],
				$_POST['nama_en'],
				$_POST['unit_id'],
				$_POST['unit_en'],
				$_POST['urutan'],
				$_POST['status_pengaturan']
			);
		}

		if(isset($_POST['up_pengaturan'])){
			 $this->lib_basic->update_pengaturan_penulisan(
				$_POST['id_ps'],
				$_POST['kode_penulisan'],
				$_POST['nama_id'],
				$_POST['nama_en'],
				$_POST['unit_id'],
				$_POST['unit_en'],
				$_POST['urutan'],
				$_POST['status_pengaturan']
			);
		}

		//DATA KODE
		$data['kode_aktif'] = $this->lib_basic->get_kode_penulisan_by_status('1');
		$data['kode_penulisan'] = $this->lib_basic->get_kode_penulisan();
		$data['pengaturan_penulisan'] = $this->lib_basic->get_pengaturan_penulisan();


		//DATA PENGATURAN PENULISAN
		$this->output69->output_display('admin/pengaturan_penulisan_sertifikasi', $data);
	}

	function verifikasi_data_mhs($code = ''){


		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_admin/skpi_mhs','refresh');
		}

		
		$data['notif'] = '';
		$data['status'] = FALSE;
		$data['nim'] = '';
		
		if($code!=0){
			$code='';
		}

		if(isset($_POST['cek_nim']) || $code!='' || isset($_POST['btn_valid']) || isset($_POST['btn_status'])){
			//get data mhs by nim :
			if(isset($_POST['cek_nim'])){
				$nim = $_POST['nim'];
			}else if(isset($_POST['btn_valid'])){
				$nim = $_POST['btn_valid'];
			}else if(isset($_POST['btn_status'])){
				$nim = $_POST['btn_status'];
				$status = array ('status' => '0');
				$this->lib_basic->update_skpi($nim, $status);

			}else{
				$nim = $this->session->userdata('nim_mhs');
			}

			$data['nim'] = $nim;
			$mhs = $this->lib_basic->get_data_mhs($nim);
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			if($mhs && $status_skpi!='BELUM'){
					$data['sts_skpi'] = $this->lib_basic->status_skpi_mhs($nim);
					$data['mahasiswa'] = array 
					(
						$mhs[0]['NAMA'],
						$mhs[0]['TMP_LAHIR'].', '.$this->lib_basic->date_indo($mhs[0]['TGL_LAHIR']),
						$mhs[0]['NIM'],
						date('Y', strtotime($mhs[0]['TGL_MASUK'])),
						($this->lib_basic->get_tahun_lulus($nim)=='')?'MASIH AKTIF':$this->lib_basic->get_tahun_lulus($nim),
						($this->lib_basic->get_nomor_ijazah($nim)=='')?'-':$this->lib_basic->get_nomor_ijazah($nim),
						$this->lib_basic->get_gelar($nim)
					);

					if($data['sts_skpi']){
						$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
						$unused_label = $skpimhs['unused_label'];
						$id_l = $skpimhs['id_l'];
					}else{
						$hasil = $this->lib_basic->get_label(1500, 2, array());
						$id_l = $hasil['id_l'];	
					}

					$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 1));

					//menata tampilan
					if($hasil){
						$data['label_title'] = array(
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

							$data['label_detail'] = $temp;
							$data['status'] = TRUE;

							$array = array(
								'nim_mhs' => $nim
							);
							
							$this->session->set_userdata( $array );
						}
					}
						
			}else{
				$data['notif'] = 'Data Mahasiswa dengan NIM '.$nim.' Tidak Ditemukan !';
				$this->session->unset_userdata('nim_mhs');
			}
		}else{
			$this->session->unset_userdata('nim_mhs');
		}
		
		$this->output69->output_display('admin/verifikasi_data_mhs', $data);	
	}

	function verifikasi_data_cp(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_admin/skpi_mhs','refresh');
		}

		$nim = $this->session->userdata('nim_mhs');
		$mhs = $this->lib_basic->get_data_mhs($nim);


		if(isset($_POST['sv_capaian'])){

			if(!isset($_POST['capaian'])){
				$this->lib_basic->delete_cp('nim', $nim);
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_cp');
			}

			$temp_capaian = $_POST['capaian'];
			$skpi_capaian = $this->lib_basic->cek_cp($nim);

			if($skpi_capaian){

				$temp_skpi_capaian = array();
				$i=0;
				foreach ($skpi_capaian as $key) {
					$temp_skpi_capaian[$i] = $key['kd_cp'];
					$i++;
				}

				$add = array_diff($temp_capaian, $temp_skpi_capaian);
				$del = array_diff($temp_skpi_capaian, $temp_capaian);

				//tambah baru :				
				foreach ($add as $key) {
					$data_capaian = array('nim' => $nim, 'kd_cp' =>$key, 'tgl_validasi' => date('Y-m-d'), 'nip' => $this->session->userdata('id_user'));
					$this->lib_basic->insert_cp($data_capaian);
				}

				//hapus :
				foreach ($del as $key) {
					$this->lib_basic->delete_cp('kode', $nim, $key);
				}

			}else{
				for($i=0; $i<count($temp_capaian); $i++){
					$data_capaian = array('nim' => $nim, 'kd_cp' => $temp_capaian[$i], 'tgl_validasi' => date('Y-m-d'), 'nip' => $this->session->userdata('id_user'));
					$this->lib_basic->insert_cp($data_capaian);
				}
			}

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_cp');

		}


		if($mhs){
			$data['sts_skpi'] = $this->lib_basic->status_skpi_mhs($nim);
			$data['nim'] = $nim;
			$data['nama'] = $mhs[0]['NAMA'];

			if($data['sts_skpi']){
				$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
				$unused_label = $skpimhs['unused_label'];
				$id_l = $skpimhs['id_l'];
			}else{
				$hasil = $this->lib_basic->get_label(1500, 2, array());
				$id_l = $hasil['id_l'];	
			}
			
			

			$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 3));
			if($hasil){
						$data['label_title'] = array(
							'idn' => $hasil['nama_idn'],
							'en'  => $hasil['nama_en'],
							'arb' => $hasil['nama_arb']
							);

						if($data['sts_skpi']){
							$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
							$unused_label = $skpimhs['unused_label'];
							$label_mhs = $this->lib_basic->get_status_label_cetak_mhs($hasil['id_ld'], $unused_label);
							if($label_mhs==1){
								$label_prodi['status'] = 0;
							}else{
								$label_prodi['status'] = 1;
								$label_prodi['nama'] = $mhs[0]['NAMA'];
							}
						}else{
							$temp_label_prodi = $this->lib_basic->cek_unused_label($mhs[0]['KD_PRODI'], $hasil['id_ld']);
							$label_prodi['status'] = $temp_label_prodi;
							if($temp_label_prodi==1){
								$temp_prodi = $this->lib_basic->get_data_prodi($mhs[0]['KD_PRODI']);
								$label_prodi['nama'] = strtoupper($temp_prodi[0]['NM_PRODI']);
							}

							
						}

						$data['label_prodi'] = $label_prodi;
						

			}

			//cek cp mhs
			$cp = $this->lib_basic->get_data_cp($nim);
			$data['status'] = false;
			if($cp){
				$data['status'] = true;
				$data['cp_title'] = $cp['TITLE'];
				$data['cp_konten'] = $cp['KONTEN'];

				if(!$cp['KONTEN']){
					$data['status'] = false;
				}
			}

			$validasi = array();

			$skpi_cp = $this->lib_basic->cek_cp($nim);
			$sts_skpi = $this->lib_basic->status_skpi_mhs($nim);

			$data['status_skpi'] = $sts_skpi;
		
			if($skpi_cp){
				if($sts_skpi){
					$data['cp_konten'] = $this->lib_basic->get_data_valid_cp($cp['TITLE'], $skpi_cp, $cp['KONTEN']);
				}else{
					$validasi = $this->lib_basic->get_data_cheklist_capaian($cp['TITLE'], $skpi_cp, $cp['KONTEN']);
				}
				
			}else{
				$data['notice'] = true;
				if(!$sts_skpi){
					$validasi = $this->lib_basic->set_checked($cp['TITLE'], $cp['KONTEN']);
				}else{
					$data['status'] = false;
				}
				
			}

			$data['validasi'] = $validasi;
			
			$this->output69->output_display('admin/verifikasi_data_cp', $data);
		}else{
			redirect(base_url().'skpi/skpi_admin/verifikasi_data_mhs');
		}			
	}

	function verifikasi_data_prestasi(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_admin/skpi_mhs','refresh');
		}

		$nim = $this->session->userdata('nim_mhs');

		$psn = $this->session->flashdata('pesan');
		$jenis =$this->session->flashdata('jenis');

		$sts_skpi = $this->lib_basic->status_skpi_mhs($nim);

		if($sts_skpi){
			redirect(base_url().'skpi/skpi_admin/verifikasi_penulisan');
		}


		if($psn!='' || $psn!=NULL || $psn){
			$msg_name = 'pesan_'.$jenis;
			$data[$msg_name] = $psn;
		}

		//update validasi prestasi :
		if(isset($_POST['sv_prestasi'])){
			$temp_prestasi = $_POST['prestasi'];
			$skpi_prestasi = $this->lib_basic->cek_prestasi($nim);

			if(!isset($_POST['prestasi'])){
				$this->lib_basic->delete_prestasi('nim', $nim);
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}

			$saran = "Belum dilakukan verifikasi penulisan !";
			if($skpi_prestasi){
				$temp_skpi_prestasi = array();
				$i=0;
				foreach ($skpi_prestasi as $key) {
					$temp_skpi_prestasi[$i] = $key['kd_kegiatan'];
					$i++;
				}

				$add = array_diff($temp_prestasi, $temp_skpi_prestasi);
				$del = array_diff($temp_skpi_prestasi, $temp_prestasi);

				//tambah baru :

				
				foreach ($add as $key) {
					$data_prestasi = array('nim' => $nim, 'kd_kegiatan' =>$key, 'jenis' => 'PRESTASI', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_prestasi);
				}

				//hapus :
				foreach ($del as $key) {
					$this->lib_basic->delete_prestasi('kode', $nim, $key);
				}

			}else{
				for($i=0; $i<count($temp_prestasi); $i++){
					$data_prestasi = array('nim' => $nim, 'kd_kegiatan' => $temp_prestasi[$i], 'jenis' => 'PRESTASI', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_prestasi);
				}
			}

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
		}

		//update validasi organisasi :
		if(isset($_POST['sv_organisasi'])){
			$temp_organisasi = $_POST['organisasi'];
			$skpi_organisasi = $this->lib_basic->cek_organisasi($nim);

			if(!isset($_POST['organisasi'])){
				$this->lib_basic->delete_organisasi('nim', $nim);
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}

			$saran = "Belum dilakukan verifikasi penulisan !";
			if($skpi_organisasi){
				$temp_skpi_organisasi = array();
				$i=0;
				foreach ($skpi_organisasi as $key) {
					$temp_skpi_organisasi[$i] = $key['kd_kegiatan'];
					$i++;
				}

				$add = array_diff($temp_organisasi, $temp_skpi_organisasi);
				$del = array_diff($temp_skpi_organisasi, $temp_organisasi);

				//tambah baru :
				
				foreach ($add as $key) {
					$data_organisasi = array('nim' => $nim, 'kd_kegiatan' =>$key, 'jenis' => 'ORGANISASI', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_organisasi);
				}

				//hapus :
				foreach ($del as $key) {
					$this->lib_basic->delete_organisasi('kode', $nim, $key);
				}

			}else{
				for($i=0; $i<count($temp_organisasi); $i++){
					$data_organisasi = array('nim' => $nim, 'kd_kegiatan' => $temp_organisasi[$i], 'jenis' => 'ORGANISASI', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_organisasi);
				}
			}

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
		}

		//update validasi sertifikasi :
		if(isset($_POST['sv_sertifikasi'])){
			$temp_sertifikasi = $_POST['sertifikasi'];
			$skpi_sertifikasi = $this->lib_basic->cek_sertifikasi($nim);

			if(!isset($_POST['sertifikasi'])){
				$this->lib_basic->delete_sertifikasi('nim', $nim);
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}

			$saran = "Belum dilakukan verifikasi penulisan !";
			if($skpi_sertifikasi){
				$temp_skpi_sertifikasi = array();
				$i=0;
				foreach ($skpi_sertifikasi as $key) {
					$temp_skpi_sertifikasi[$i] = $key['kd_kegiatan'];
					$i++;
				}

				$add = array_diff($temp_sertifikasi, $temp_skpi_sertifikasi);
				$del = array_diff($temp_skpi_sertifikasi, $temp_sertifikasi);

				//tambah baru :
				
				foreach ($add as $key) {
					$data_sertifikasi = array('nim' => $nim, 'kd_kegiatan' =>$key, 'jenis' => 'SERTIFIKASI', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_sertifikasi);
				}

				//hapus :
				foreach ($del as $key) {
					$this->lib_basic->delete_sertifikasi('kode', $nim, $key);
				}

			}else{
				for($i=0; $i<count($temp_sertifikasi); $i++){
					$data_sertifikasi = array('nim' => $nim, 'kd_kegiatan' => $temp_sertifikasi[$i], 'jenis' => 'SERTIFIKASI', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_sertifikasi);
				}
			}

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
		}

		//update validasi magang :
		if(isset($_POST['sv_magang'])){
			$temp_magang = $_POST['magang'];
			$skpi_magang = $this->lib_basic->cek_magang($nim);

			if(!isset($_POST['magang'])){
				$this->lib_basic->delete_magang('nim', $nim);
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}

			$saran = "Belum dilakukan verifikasi penulisan !";
			if($skpi_magang){
				$temp_skpi_magang = array();
				$i=0;
				foreach ($skpi_magang as $key) {
					$temp_skpi_magang[$i] = $key['kd_kegiatan'];
					$i++;
				}

				$add = array_diff($temp_magang, $temp_skpi_magang);
				$del = array_diff($temp_skpi_magang, $temp_magang);

				//tambah baru :
				
				foreach ($add as $key) {
					$data_magang = array('nim' => $nim, 'kd_kegiatan' =>$key, 'jenis' => 'MAGANG', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_magang);
				}

				//hapus :
				foreach ($del as $key) {
					$this->lib_basic->delete_magang('kode', $nim, $key);
				}

			}else{
				for($i=0; $i<count($temp_magang); $i++){
					$data_magang = array('nim' => $nim, 'kd_kegiatan' => $temp_magang[$i], 'jenis' => 'MAGANG', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_magang);
				}
			}

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
		}

		//update validasi karakter :
		if(isset($_POST['sv_karakter'])){
			$temp_karakter = $_POST['karakter'];
			$skpi_karakter = $this->lib_basic->cek_karakter($nim);

			if(!isset($_POST['karakter'])){
				$this->lib_basic->delete_karakter('nim', $nim);
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}

			$saran = "Belum dilakukan verifikasi penulisan !";
			if($skpi_karakter){
				$temp_skpi_karakter = array();
				$i=0;
				foreach ($skpi_karakter as $key) {
					$temp_skpi_karakter[$i] = $key['kd_kegiatan'];
					$i++;
				}

				$add = array_diff($temp_karakter, $temp_skpi_karakter);
				$del = array_diff($temp_skpi_karakter, $temp_karakter);

				//tambah baru :
				
				foreach ($add as $key) {
					$data_karakter = array('nim' => $nim, 'kd_kegiatan' =>$key, 'jenis' => 'KARAKTER', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_karakter);
				}

				//hapus :
				foreach ($del as $key) {
					$this->lib_basic->delete_karakter('kode', $nim, $key);
				}

			}else{
				for($i=0; $i<count($temp_karakter); $i++){
					$data_karakter = array('nim' => $nim, 'kd_kegiatan' => $temp_karakter[$i], 'jenis' => 'KARAKTER', 'saran' => $saran);
					$this->lib_basic->insert_kegiatan($data_karakter);
				}
			}

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
		}


		$mhs = $this->lib_basic->get_data_mhs($nim);
		if($mhs){
			$data['sts_skpi'] = $sts_skpi;
			$data['nim'] = $nim;
			$data['nama'] = $mhs[0]['NAMA'];

			if($data['sts_skpi']){
				$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
				$unused_label = $skpimhs['unused_label'];
				$id_l = $skpimhs['id_l'];
			}else{
				$hasil = $this->lib_basic->get_label(1500, 2, array());
				$id_l = $hasil['id_l'];	
			}
			
			$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 4));
			if($hasil){
						$data['label_title'] = array(
							'idn' => $hasil['nama_idn'],
							'en'  => $hasil['nama_en'],
							'arb' => $hasil['nama_arb']
							);

						if($data['sts_skpi']){
							$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
							$unused_label = $skpimhs['unused_label'];
							$label_mhs = $this->lib_basic->get_status_label_cetak_mhs($hasil['id_ld'], $unused_label);
							if($label_mhs==1){
								$label_prodi['status'] = 0;
							}else{
								$label_prodi['status'] = 1;
								$label_prodi['nama'] = $mhs[0]['NAMA'];
							}
						}else{
							$temp_label_prodi = $this->lib_basic->cek_unused_label($mhs[0]['KD_PRODI'], $hasil['id_ld']);
							$label_prodi['status'] = $temp_label_prodi;
							if($temp_label_prodi==1){
								$temp_prodi = $this->lib_basic->get_data_prodi($mhs[0]['KD_PRODI']);
								$label_prodi['nama'] = strtoupper($temp_prodi[0]['NM_PRODI']);
							}

							
						}

						$data['label_prodi'] = $label_prodi;
			}

			$id_ld = $hasil['id_ld'];
			$hasil = $this->lib_basic->get_label(1500, 5, array($id_ld));
			$i=0;
			foreach ($hasil as $key) {
				$data['label_kegiatan'][$i] = $key['nama_idn'];
				$i++;
			}

			//cek prestasi mahasiswa
			$prestasi = $this->lib_basic->cek_prestasi($nim);
			$dpm_prestasi = $this->lib_basic->get_data_prestasi($nim);
			$validasi = array();
			$data['status'] = false;
			if($prestasi){
				if($dpm_prestasi){
					$data['status'] = true;
					// $data['dpm_prestasi'] = $dpm_prestasi;
					// $data['skpi_prestasi'] = $prestasi;
					
					// foreach ($dpm_prestasi as $dpm) {
					// 	$temp = 0;
					// 	foreach ($prestasi as $skpi_prestasi) {
					// 		if($dpm['ID_RIWAYAT']==$skpi_prestasi['kd_kegiatan']){
					// 			$temp++;
					// 		}
					// 	}

					// 	if($temp>0){
					// 		$validasi[$dpm['ID_RIWAYAT']] = 'checked';
					// 	}else{
					// 		$validasi[$dpm['ID_RIWAYAT']] = '';
					// 	}
					// }

					$validasi = $this->lib_basic->get_data_checklist($prestasi, $dpm_prestasi);

					// $DATA['dpm_prestasi'] = $dpm_prestasi;

				}else{
					$data['status'] = false;
				}

			}else{

				if($dpm_prestasi){
					$data['status'] = true;
					// $data['dpm_prestasi'] = $dpm_prestasi;
					//$data['skpi_prestasi'] = $prestasi;

					// foreach ($dpm_prestasi as $dpm) {

					// 	$validasi[$dpm['ID_RIWAYAT']] = '';
					$validasi = $this->lib_basic->set_uncheck($dpm_prestasi);				
					// }

				}else{
					$data['status'] = false;
				}

			}

			$data['dpm_prestasi'] = $dpm_prestasi;
			$data['prestasi_valid'] = $validasi;

			//cek organisasi :
			$organisasi = $this->lib_basic->cek_organisasi($nim);
			$dpm_organisasi = $this->lib_basic->get_data_organisasi($nim);
			$validasi = array();
			$data['status'] = false;
			if($organisasi){
				if($dpm_organisasi){
			 		$data['status'] = true;
			 		// $data['dpm_prestasi'] = $dpm_prestasi;
			 		// $data['skpi_prestasi'] = $prestasi;
					
			 		// foreach ($dpm_organisasi as $dpm) {
			 		// 	$temp = 0;
			 		// 	foreach ($organisasi as $skpi_organisasi) {
			 		// 		if($dpm['ID_RIWAYAT']==$skpi_organisasi['kd_kegiatan']){
			 		// 			$temp++;
			 		// 		}
			 		// 	}

			 		// 	if($temp>0){
			 		// 		$validasi[$dpm['ID_RIWAYAT']] = 'checked';
			 		// 	}else{
			 		// 		$validasi[$dpm['ID_RIWAYAT']] = '';
			 		// 	}
			 		// }

			 		$validasi = $this->lib_basic->get_data_checklist($organisasi, $dpm_organisasi);

			 		// $DATA['dpm_prestasi'] = $dpm_prestasi;

			 	}else{
			 		$data['status'] = false;
			 	}

			 }else{

			 	if($dpm_organisasi){
			 		$data['status'] = true;
			 		// foreach ($dpm_organisasi as $dpm) {

			 		// 	$validasi[$dpm['ID_RIWAYAT']] = '';
										
			 		// }
			 		$validasi = $this->lib_basic->set_uncheck($dpm_organisasi);	


			 	}else{
			 		$data['status'] = false;
			 	}

			 }


			$data['dpm_org'] = $dpm_organisasi;
			//$data['dpm_prestasi'] = $dpm_prestasi;			
			$data['organisasi_valid'] = $validasi;


			//data sertifikasi keahlian
			$sertifikasi = $this->lib_basic->cek_sertifikasi($nim);
			$dpm_sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);
			$uin_sertifikasi = $this->lib_basic->get_sertifikasi_uin($nim);
			$sts_sertifikasi = false;

			$data_sertifikasi = array();
			$validasi = array();
			$data_sertifikasi_uin = array();
			$validasi_uin = array();

			if($dpm_sertifikasi){
				if($sertifikasi){
					$data_sertifikasi = $dpm_sertifikasi;
					$validasi 	 = $this->lib_basic->get_data_checklist($sertifikasi, $dpm_sertifikasi);
					$sts_sertifikasi = true;
				}else{
					$data_sertifikasi = $dpm_sertifikasi;
					$validasi 	 = $this->lib_basic->set_uncheck($dpm_sertifikasi);
					$sts_sertifikasi = true;
				}
			}

			if($uin_sertifikasi){
				if($sertifikasi){
					$data_sertifikasi_uin 	= $uin_sertifikasi;
					$validasi_uin 	 		= $this->lib_basic->get_data_checklist($sertifikasi, $uin_sertifikasi);
					$sts_sertifikasi 		= true;
				}else{
					$data_sertifikasi_uin 	= $uin_sertifikasi;
					$validasi_uin 	 		= $this->lib_basic->set_uncheck($uin_sertifikasi);
					$sts_sertifikasi 		= true;
				}
			}

			$data['dpm_sertifikasi'] 	= $data_sertifikasi;
			$data['sertifikasi_valid'] 	= $validasi; 

			$data['uin_sertifikasi'] 		= $data_sertifikasi_uin;
			$data['sertifikasi_valid_uin'] 	= $validasi_uin; 



			//data magang / kerjaprakter / asistensi:
			$magang = $this->lib_basic->cek_magang($nim);
			$dpm_magang = $this->lib_basic->get_data_magang($nim);
			$sts_magang = false;

			$data_magang = array();
			$validasi = array();

			if($dpm_magang){
				if($magang){
					$data_magang = $dpm_magang;
					$validasi 	 = $this->lib_basic->get_data_checklist($magang, $dpm_magang);
					$sts_magang = true;
				}else{
					$data_magang = $dpm_magang;
					$validasi 	 = $this->lib_basic->set_uncheck($dpm_magang);
					$sts_magang = true;
				}
			}else{
				$sts_magang = false;
			}

			$data['dpm_magang'] 	= $data_magang;
			$data['magang_valid'] 	= $validasi;

			//data pendidikan karakter
			$karakter = $this->lib_basic->cek_karakter($nim);
			$dpm_karakter = $this->lib_basic->get_data_karakter($nim);
			$sts_karakter = false;

			$data_karakter = array();
			$validasi = array();

			if($dpm_karakter){
				if($karakter){
					$data_karakter = $dpm_karakter;
					$validasi 	 = $this->lib_basic->get_data_checklist($karakter, $dpm_karakter);
					$sts_karakter = true;
				}else{
					$data_karakter = $dpm_karakter;
					$validasi 	 = $this->lib_basic->set_uncheck($dpm_karakter);
					$sts_karakter = true;
				}
			}else{
				$sts_karakter = false;
			}

			$data['dpm_karakter'] 	= $data_karakter;
			$data['karakter_valid'] = $validasi; 

			$this->output69->output_display('admin/verifikasi_data_prestasi', $data);
		}else{
			redirect(base_url().'skpi/skpi_admin/verifikasi_data_mhs');
		}
	}

	function verifikasi_penulisan(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_admin/skpi_mhs','refresh');
		}

		$psn = $this->session->flashdata('pesan');
		$jenis =$this->session->flashdata('jenis');

		if($psn!='' || $psn!=NULL || $psn){
			$msg_name = 'pesan_'.$jenis;
			$data[$msg_name] = $psn;
		}


		$nim = $this->session->userdata('nim_mhs');
		$mhs = $this->lib_basic->get_data_mhs($nim);
		if($mhs){
			$data['sts_skpi'] = $this->lib_basic->status_skpi_mhs($nim);
			$data['nim'] = $nim;
			$data['nama'] = $mhs[0]['NAMA'];

			if($data['sts_skpi']){
				$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
				$unused_label = $skpimhs['unused_label'];
				$id_l = $skpimhs['id_l'];
			}else{
				$hasil = $this->lib_basic->get_label(1500, 2, array());
				$id_l = $hasil['id_l'];	
			}
			
			$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 4));
			if($hasil){
						$data['label_title'] = array(
							'idn' => $hasil['nama_idn'],
							'en'  => $hasil['nama_en'],
							'arb' => $hasil['nama_arb']
							);

						if($data['sts_skpi']){
							$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
							$unused_label = $skpimhs['unused_label'];
							$label_mhs = $this->lib_basic->get_status_label_cetak_mhs($hasil['id_ld'], $unused_label);
							if($label_mhs==1){
								$label_prodi['status'] = 0;
							}else{
								$label_prodi['status'] = 1;
								$label_prodi['nama'] = $mhs[0]['NAMA'];
							}
						}else{
							$temp_label_prodi = $this->lib_basic->cek_unused_label($mhs[0]['KD_PRODI'], $hasil['id_ld']);
							$label_prodi['status'] = $temp_label_prodi;
							if($temp_label_prodi==1){
								$temp_prodi = $this->lib_basic->get_data_prodi($mhs[0]['KD_PRODI']);
								$label_prodi['nama'] = strtoupper($temp_prodi[0]['NM_PRODI']);
							}

							
						}

						$data['label_prodi'] = $label_prodi;
			}

			$id_ld = $hasil['id_ld'];
			$hasil = $this->lib_basic->get_label(1500, 5, array($id_ld));
			$i=0;
			foreach ($hasil as $key) {
				$data['label_kegiatan'][$i] = $key['nama_idn'];
				$i++;
			}

			//data verified prestasi
			$prestasi = $this->lib_basic->cek_prestasi($nim);
			$data['status_prestasi'] = false;
			if($prestasi){
				$dpm_prestasi = $this->lib_basic->get_data_prestasi($nim);
				$data['status_prestasi'] = true;
				$data['dpm_prestasi'] = $this->lib_basic->get_data_valid($prestasi, $dpm_prestasi);
			}

			//data verified organisasi
			$organisasi = $this->lib_basic->cek_organisasi($nim);
			$data['status_organisasi'] = false;
			if($organisasi){
				$dpm_organisasi = $this->lib_basic->get_data_organisasi($nim);
				$data['status_organisasi'] = true;
				$data['dpm_org'] = $this->lib_basic->get_data_valid($organisasi, $dpm_organisasi);
			}

			//data verified sertifikasi
			$sertifikasi = $this->lib_basic->cek_sertifikasi($nim);
			$data['status_sertifikasi'] = false;
			$data['status_sertifikasi_uin'] = false;
			if($sertifikasi){
				$dpm_sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);				
				$data['dpm_sertifikasi'] = $this->lib_basic->get_data_valid($sertifikasi, $dpm_sertifikasi);
				if(count($data['dpm_sertifikasi'])>0){
					$data['status_sertifikasi'] = true;
				}

				//CODE UNTUK ICT/IKLA/TOEC DISINI
				$uin_sertifikasi = $this->lib_basic->get_sertifikasi_uin($nim);
				$data['uin_sertifikasi'] = $this->lib_basic->get_data_valid($sertifikasi, $uin_sertifikasi);
				if(count($data['uin_sertifikasi'])>0){
					$data['status_sertifikasi_uin'] = true;
				}
			}

			//data verified magang
			$magang = $this->lib_basic->cek_magang($nim);
			$data['status_magang'] = false;
			if($magang){
				$dpm_magang = $this->lib_basic->get_data_magang($nim);
				$data['status_magang'] = true;
				$data['dpm_magang'] = $this->lib_basic->get_data_valid($magang, $dpm_magang);
			}
			
			//data verified karakter
			$karakter = $this->lib_basic->cek_karakter($nim);
			$data['status_karakter'] = false;
			if($karakter){
				$dpm_karakter = $this->lib_basic->get_data_karakter($nim);
				$data['status_karakter'] = true;
				$data['dpm_karakter'] = $this->lib_basic->get_data_valid($karakter, $dpm_karakter);
			}
			
			$this->output69->output_display('admin/verifikasi_penulisan_prestasi', $data);
		}else{
			redirect(base_url().'skpi/skpi_admin/verifikasi_data_mhs');
		}
	}

	function verifikasi_detail_penulisan($id_riwayat='', $jenis=''){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_admin/skpi_mhs','refresh');
		}

		if(isset($_POST['sv_saran'])){
			$data_update = array('kd_kegiatan' => $_POST['id_k'], 'saran' => $_POST['saran'], 'status' => $_POST['status_data']);
			$test = $this->lib_basic->update_kegiatan($_POST['id_k'], $data_update);
			if($test){
				//echo "sukses";
				redirect(base_url().'skpi/skpi_admin/verifikasi_penulisan');
			}else{
				//echo "gagal";
				redirect(base_url().'skpi/skpi_admin/verifikasi_penulisan');
			}
			
		}
		
		$nim = $this->session->userdata('nim_mhs');
		$data['sts_skpi'] = $this->lib_basic->status_skpi_mhs($nim);
		$temp = array();

		if(strtoupper($jenis)=='PRESTASI'){
			$data['judul'] = 'Prestasi';
			$prestasi = $this->lib_basic->get_data_prestasi($nim);
			foreach ($prestasi as $key) {
				if($key['ID_RIWAYAT'] == $id_riwayat){
					//$data['kegiatan'] = $key;

					$temp = array(
							'NIM' => $key['NIM'],
							'ID' => $key['ID_RIWAYAT'],
							'INDONESIA' => $key['NM_LOMBA'],
							'INGGRIS' => $key['NM_LOMBA2'],
							'KETERANGAN'	=> $key['KETERANGAN']

						);

					$data['kegiatan'] = $temp;
					
				}
			}

			$prestasi_skpi = $this->lib_basic->cek_prestasi($nim);
			foreach ($prestasi_skpi as $key) {
				if($key['kd_kegiatan']==$id_riwayat){
					$data['skpi_saran'] = $key['saran'];
					$data['status_data'] = $key['status'];
					if($key['status'] == 0){
						$data['sts'] = '';
						$data['readonly'] = '';
					}else{
						$data['sts'] = 'checked';
						$data['readonly'] = 'readonly';
					}
				}
			}

			
		}else if(strtoupper($jenis)=='ORGANISASI'){
			$data['judul'] = 'Organisasi';
			$organisasi = $this->lib_basic->get_data_organisasi($nim);
			foreach ($organisasi as $key) {
				if($key['ID_RIWAYAT'] == $id_riwayat){
					//$data['kegiatan'] = $key;
					$temp = array(
							'NIM' => $key['NIM'],
							'ID' => $key['ID_RIWAYAT'],
							'INDONESIA' => $key['NM_ORGANISASI'],
							'INGGRIS'	=> $key['NM_ORGANISASI2']
						);

					$data['kegiatan'] = $temp;
				}
			}

			$organisasi_skpi = $this->lib_basic->cek_organisasi($nim);
			foreach ($organisasi_skpi as $key) {
				if($key['kd_kegiatan']==$id_riwayat){
					$data['skpi_saran'] = $key['saran'];
					$data['status_data'] = $key['status'];
					if($key['status'] == 0){
						$data['sts'] = '';
						$data['readonly'] = '';
					}else{
						$data['sts'] = 'checked';
						$data['readonly'] = 'readonly';
					}
				}
			}
		}else if(strtoupper($jenis)=='SERTIFIKASI'){
			$data['judul'] = 'Sertifikasi';
			$sertifikasi = $this->lib_basic->get_data_sertifikasi($nim);
			foreach ($sertifikasi as $key) {
				if($key['ID_RIWAYAT'] == $id_riwayat){
					//$data['kegiatan'] = $key;
					$temp = array(
							'NIM' => $key['NIM'],
							'ID' => $key['ID_RIWAYAT'],
							'INDONESIA' => $key['NM_KEGIATAN'],
							'INGGRIS'	=> $key['NM_KEGIATAN2']
						);

					$data['kegiatan'] = $temp;
				}
			}

			$sertifikasi_skpi = $this->lib_basic->cek_sertifikasi($nim);
			foreach ($sertifikasi_skpi as $key) {
				if($key['kd_kegiatan']==$id_riwayat){
					$data['skpi_saran'] = $key['saran'];
					$data['status_data'] = $key['status'];
					if($key['status'] == 0){
						$data['sts'] = '';
						$data['readonly'] = '';
					}else{
						$data['sts'] = 'checked';
						$data['readonly'] = 'readonly';
					}
				}
			}
		}else if(strtoupper($jenis)=='MAGANG'){
			$data['judul'] = 'Magang';
			$magang = $this->lib_basic->get_data_magang($nim);
			foreach ($magang as $key) {
				if($key['ID_RIWAYAT'] == $id_riwayat){
					//$data['kegiatan'] = $key;
					$temp = array(
							'NIM' => $key['NIM'],
							'ID' => $key['ID_RIWAYAT'],
							'INDONESIA' => $key['NM_KEGIATAN'],
							'INGGRIS'	=> $key['NM_KEGIATAN2']
						);

					$data['kegiatan'] = $temp;
				}
			}

			$magang_skpi = $this->lib_basic->cek_magang($nim);
			foreach ($magang_skpi as $key) {
				if($key['kd_kegiatan']==$id_riwayat){
					$data['skpi_saran'] = $key['saran'];
					$data['status_data'] = $key['status'];
					if($key['status'] == 0){
						$data['sts'] = '';
						$data['readonly'] = '';
					}else{
						$data['sts'] = 'checked';
						$data['readonly'] = 'readonly';
					}
				}
			}
		}else if(strtoupper($jenis)=='KEGIATAN'){
			$data['judul'] = 'Pendidikan Karakter';
			$karakter = $this->lib_basic->get_data_karakter($nim);
			foreach ($karakter as $key) {
				if($key['ID_RIWAYAT'] == $id_riwayat){
					//$data['kegiatan'] = $key;
					$temp = array(
							'NIM' => $key['NIM'],
							'ID' => $key['ID_RIWAYAT'],
							'INDONESIA' => $key['NM_KEGIATAN'],
							'INGGRIS'	=> $key['NM_KEGIATAN2']
						);

					$data['kegiatan'] = $temp;
				}
			}

			$karakter_skpi = $this->lib_basic->cek_karakter($nim);
			foreach ($karakter_skpi as $key) {
				if($key['kd_kegiatan']==$id_riwayat){
					$data['skpi_saran'] = $key['saran'];
					$data['status_data'] = $key['status'];
					if($key['status'] == 0){
						$data['sts'] = '';
						$data['readonly'] = '';
					}else{
						$data['sts'] = 'checked';
						$data['readonly'] = 'readonly';
					}
				}
			}
		}else{
			redirect(base_url().'skpi/skpi_admin/verifikasi_penulisan');
		}

		$this->output69->output_display('admin/verifikasi_detail_penulisan', $data);
	}

	function verifikasi_akhir(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_admin/skpi_mhs','refresh');
		}

		$nim = $this->session->userdata('nim_mhs');
		$mhs = $this->lib_basic->get_data_mhs($nim);

		$data['sts_skpi'] = $this->lib_basic->status_skpi_mhs($nim);

		if($data['sts_skpi']){
			$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
			$unused_label = $skpimhs['unused_label'];
			$id_l = $skpimhs['id_l'];
		}else{
			$hasil = $this->lib_basic->get_label(1500, 2, array());
			$id_l = $hasil['id_l'];	
		}


		$label_mhs = $this->lib_basic->get_json_unused_label($mhs[0]['KD_PRODI'], $id_l);


		if(isset($_POST['sv_validasi'])){
			$cek = $this->lib_basic->get_skpi_mhs($nim);
			if($cek){
				$status = array ('status' => '1', 'nip' => $this->session->userdata('id_user'), 'tgl_setuju' => date('Y-m-d'), 'unused_label' => $label_mhs);
				$this->lib_basic->update_skpi($nim, $status);
			}else{
				//echo "ini nanti insert data skpi baru, default nanti langung status : 1";
				$no_skpi = $this->lib_basic->noseri();
				$data = array(
					'nim' => $nim,
					'no_skpi' =>$no_skpi,
					'id_l' => $id_l,
					'status' => '1',
					'tgl_setuju' => date('Y-m-d'),
					'nip' => $this->session->userdata('id_user'),
					'unused_label' => $label_mhs
					);
				$skpi = $this->lib_basic->insert_skpi($data);
			}

			$this->session->set_flashdata('nim', $nim);
			redirect(base_url().'skpi/skpi_admin/cetak_skpi_mhs');
		}



		if($mhs){

			$data['sts_skpi'] = $this->lib_basic->status_skpi_mhs($nim);
			//AMBIL ID UNTUK LABEL YANG SAAT INI BERSTATUS AKTIF :
				// $hasil = $this->lib_basic->get_label(1500, 2, array());
				// $id_l = $hasil['id_l']; // id label yang sedang aktif

			//PAKET IDENTITAS PEMEGANG SKPI (LABEL HEADER, LABEL & KONTEN) :
			//1. LABEL HEADER :
			
				$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 1));
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
					$mhs[0]['TMP_LAHIR'].', '.$this->lib_basic->date_indo($mhs[0]['TGL_LAHIR']),
					$mhs[0]['NIM'],
					date('Y', strtotime($mhs[0]['TGL_MASUK'])),
					($this->lib_basic->get_tahun_lulus($nim)=='')?'MASIH AKTIF':$this->lib_basic->get_tahun_lulus($nim),
					($this->lib_basic->get_nomor_ijazah($nim)=='')?'-':$this->lib_basic->get_nomor_ijazah($nim),
					$this->lib_basic->get_gelar($nim)
				);

				//DATA DIRI PEMEGANG SKPI DONE

			//PAKET DATA DIRI PEMBERI SKPI
				//1. LABEL HEADER
				//2. LABEL DETAIL
				//3. KONTEN	

			//PAKET DATA  KUALIFIKASI DAN HASIL YANG DICAPAI :
				//1. LABEL HEADER
				$CAPAIAN = array();
				$hasil = $this->lib_basic->get_label(1500, 8, array($id_l, '1', 3));
				if($hasil){
							$CAPAIAN[0] = array(
								'idn' => $hasil['nama_idn'],
								'en'  => $hasil['nama_en'],
								'arb' => $hasil['nama_arb']
								);

							if($data['sts_skpi']){
								$status_label = $this->lib_basic->get_status_label_cetak_mhs($hasil['id_ld'], $unused_label);
							}else{
								$temp_label_prodi = $this->lib_basic->cek_unused_label($mhs[0]['KD_PRODI'], $hasil['id_ld']);
								if($temp_label_prodi==1){
									$status_label=0;
								}
							}

							$CAPAIAN[3] = $status_label;
							
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

					if($data['sts_skpi']){
						$status_label = $this->lib_basic->get_status_label_cetak_mhs($hasil['id_ld'], $unused_label);
					}else{
						$temp_label_prodi = $this->lib_basic->cek_unused_label($mhs[0]['KD_PRODI'], $hasil['id_ld']);
						if($temp_label_prodi==1){
							$status_label=0;
						}
					}

					$KEGIATAN[3] = $status_label;
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

				$data['mahasiswa'] 	= $DATA_DIRI;
				$data['kegiatan']	= $KEGIATAN;
				$data['capaian']	= $CAPAIAN;
				$data['status_kegiatan'] = array($status_prestasi, $status_organisasi, $status_sertifikasi, $status_magang, $status_karakter);


			$this->output69->output_display('admin/verifikasi_akhir', $data);
		}else{

			redirect(base_url().'skpi/skpi_admin/verifikasi_data_mhs');
		}	
	}

	function sertifikat_kegiatan($id_riwayat, $jenis, $page='')
	{
		$nim = $this->session->userdata('nim_mhs');
		if(strtoupper($jenis)=='PRESTASI'){
			$data = $this->lib_basic->cek_sertifikat_prestasi($nim, $id_riwayat);
			$kode = 0;
		}else if(strtoupper($jenis)=='ORGANISASI'){
			$data = $this->lib_basic->cek_sertifikat_organisasi($nim, $id_riwayat);
			$kode = 2;
		}else{
			$data = $this->lib_basic->cek_sertifikat_kegiatan($nim, $id_riwayat);
			$kode = 1;
		}
		
		if($data)
		{
			foreach ($data as $key) {
				if($kode==0){
					$docname = $key['DOC_SERTIF_LOMBA'];
					$filename = $key['DOC_SERTIF_LOMBA_NAME'];
				}else if($kode==2){
					$docname = $key['DOC_SERTIF_ORG'];
					$filename = $key['DOC_SERTIF_ORG_NAME'];
				}else{
					$docname = $key['DOC_SERTIF_KEGIATAN'];
					$filename = $key['DOC_SERTIF_KEGIATAN_NAME'];
				}
			}

			$this->lib_basic->download_sertifikat($filename, $docname, $id_riwayat);

			$this->session->set_flashdata('pesan', '');
			$this->session->set_flashdata('jenis', $jenis);
			if($page=='X0X'){
				redirect(base_url().'skpi/skpi_admin/verifikasi_penulisan');
			}else{
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}
			

		}else{
			$this->session->set_flashdata('pesan', 'File Bukti '.$jenis.' Tidak Ditemukan !');
			$this->session->set_flashdata('jenis', $jenis);
			if($page=='X0X'){
				redirect(base_url().'skpi/skpi_admin/verifikasi_penulisan');
			}else{
				redirect(base_url().'skpi/skpi_admin/verifikasi_data_prestasi');
			}
		}


	}

	function testing_sertifikat_organisasi(){
		$data = $this->lib_basic->get_data_organisasi('15620024');
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		foreach ($data as $d) {
			echo "KEGIATAN : ".$d['NM_ORGANISASI'].'<br>';
			$temp = $this->lib_basic->cek_sertifikat_organisasi('15620024', $d['ID_RIWAYAT']);
			echo '<pre>';
			print_r($temp);
			echo '</pre>';
			echo "-------------------------------------------------------------------------------<br>";
		}
	}

	function skpi_mhs(){

		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$data['status_label'] = $this->lib_basic->cek_label_aktif();

		$fakultas = $this->lib_basic->get_univ('fak');		

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		foreach ($fakultas as $key) {
			$data['ls_kd_fak'][$i] = $key['KD_FAK'];
			$data['ls_nm_fak'][$i] = $key['NM_FAK'];
			$i++;
		}

		if(isset($_POST['btn_status'])){
			$_POST['cek_nim'] = true;
			$_POST['nim'] = $_POST['btn_status'];

			$status = array ('status' => '0');
			$this->lib_basic->update_skpi($_POST['btn_status'], $status);
		}

		if(isset($_POST['cek_nim'])){
			$nim = $_POST['nim'];
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			$datamhs = $this->lib_basic->get_data_mhs($nim);
			$temp = array();
			if($datamhs){
				$i = 0;
				foreach ($datamhs as $key) {
					if($status_skpi!='BELUM'){
						$temp[$i] = array(
							'NIM' => $key['NIM'],
							'NAMA' => $key['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
						);

						$KD_FAK = $key['KD_FAK'];

						$KD_PRODI = $key['KD_PRODI'];

						$ANGKATAN = $key['ANGKATAN'];

						$data['kd_fak'] = $KD_FAK;

						$prodi = $this->lib_basic->get_univ('prod', $data['kd_fak']);
						$data['ls_kd_prodi'] = array();
						$data['ls_nm_prodi'] = array();
						$data['ls_angkatan'] = array();
						// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
						$i=0;
						foreach ($prodi as $key) {
							$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
							$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
							$i++;
						}

						$data['kd_prodi'] = $KD_PRODI;
					
						$angkatan = $this->lib_basic->get_tahun_angkatan();
						$i = 0;
						foreach ($angkatan as $key) {
							$data['ls_angkatan'][$i] = $key['ANGKATAN'];
							$i++;
						}

						$data['angkatan']= $ANGKATAN;


					}
					$i++;
				}


			}
			$data['mhs'] = $temp;
			$data['nim'] = $nim;

		}else{
				//elsenya disini

			if(isset($_POST['kd_fak'])){
				$data['kd_fak'] = $_POST['kd_fak'];

				// if(isset($_POST['angkatan'])){
				// 		$data['angkatan']= $_POST['angkatan'];

				// 		//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);

				// 	}else{
				// 		$data['angkatan'] = date('Y');
				// 	}



				$prodi = $this->lib_basic->get_univ('prod', $_POST['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				$data['ls_angkatan'] = array();
				// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
				$i=0;
				foreach ($prodi as $key) {
					$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
					$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
					$i++;
				}

				if(isset($_POST['kd_prodi'])){
					$data['kd_prodi'] = $_POST['kd_prodi'];
					
					$angkatan = $this->lib_basic->get_tahun_angkatan();
					$i = 0;
					foreach ($angkatan as $key) {
						$data['ls_angkatan'][$i] = $key['ANGKATAN'];
						$i++;
					}

					if(isset($_POST['angkatan'])){

						$data['angkatan']= $_POST['angkatan'];


						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);


						if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$tmp = array();
						$i = 0;
						foreach ($temp as $key) {
							$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
							if($status_skpi!='BELUM'){
								$tmp[$i] = array
								(
									'NIM' => $key['NIM'],
									'NAMA' => $key['NAMA'],
									'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
								);

								$i++;
							}
						}
						$data['mhs'] = $tmp;
					}





					}else{
						//$data['angkatan'] = date('Y');
						
					}
				}

			}
			
			if(isset($_POST['cek'])){
				if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
					//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$tmp = array();
					$i = 0;
					foreach ($temp as $key) {
						$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
						if($status_skpi!='BELUM'){
							$tmp[$i] = array
							(
								'NIM' => $key['NIM'],
								'NAMA' => $key['NAMA'],
								'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
							);

							$i++;
						}
					}
					$data['mhs'] = $tmp;
				}
		}

		}

		$this->output69->output_display('admin/list_mhs', $data);

	}

	function konversi_bulan($angka){
		$bulan = array(
			1 => 'Januari',
			'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
			
		);

		return $bulan[$angka];
	}

	function get_tanggal_daftar_verifikasi(){
		$data = $this->api->get_api_json(
			"http://service.uin-suka.ac.id/servskpi/index.php/skpi_public/skpi_basic/get_all_tanggal_daftar",
			'POST',
			array('api_search' => array('22607'))
		);

		$bulan = array();
		$tahun = array();
		$id_thn = 0;
		foreach ($data as $d) {
			if(!isset($bulan[$d['tahun']])){

				$tahun[$id_thn] = $d['tahun'];
				$id_thn++;
				$bulan[$d['tahun']][$d['bulan']] = array (
													'TAHUN' => $d['tahun'],
													'KD_BULAN' => $d['bulan'],
													'NM_BULAN' => $this->konversi_bulan($d['bulan'])
												);
				//$tanggal
			}else{
				$bulan[$d['tahun']][$d['bulan']] = array (
													'TAHUN' => $d['tahun'],
													'KD_BULAN' => $d['bulan'],
													'NM_BULAN' => $this->konversi_bulan($d['bulan'])
												);
			}
		}

		$data = array (
			'TAHUN' => $tahun,
			'BULAN' => $bulan
		);

		echo json_encode($data);
	}

	function cumacoba(){
		$data = $this->lib_basic->get_data_mhs('13540064');
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	function get_data_verifikasi_mhs_by_nim(){
		$nim = $this->input->post('nim');
		// $nim = '13651060';

		$s = $this->api->get_api_json(
			"http://service.uin-suka.ac.id/servskpi/index.php/skpi_public/skpi_basic/cek",
			'POST',
			array(
				'api_kode' => 1500,
				'api_subkode' => 1,
				'api_search' => array($nim)
			)
		);

		$data_skpi = array();
		if($s){
				$temp['NIM'] 	= $s['nim'];
				$temp['STATUS']	= $s['status'];
				$tmp  = explode('-', $s['tgl_daftar']);
				$tmp_tgl = $tmp[2].' '.ucwords(strtolower($this->konversi_bulan((int) $tmp[1]))).' '.$tmp[0];
				$temp['TGL']	= $tmp_tgl;

				$temp['BULAN'] = $tmp[1];
				$temp['TAHUN'] = $tmp[0];

				$tmp_ket 		= explode('#', $s['keterangan']);
				$temp['BATAL']  = 0;
				if(count($tmp_ket) > 1 && $tmp_ket[0] == 'BATAL_DAFTAR'){
					$temp['BATAL'] = 1;
				}

				$mhs = $this->lib_basic->get_data_mhs($s['nim']);
				$temp['NAMA'] 	= $mhs[0]['NAMA'];
				$temp['PRODI'] 	= $mhs[0]['NM_PRODI'];
				$data_skpi[]	= $temp;
		}

		// print_r($data_skpi);
		echo json_encode($data_skpi);
	}

	function get_all_data_verifikasi_mahasiswa(){
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		$skpi = $this->api->get_api_json(
			"http://service.uin-suka.ac.id/servskpi/index.php/skpi_public/skpi_basic/get_all_data_pendaftar",
			'POST',
			array(
				'api_search' => array($tahun, $bulan)
			)
		);

		$data_skpi = array();
		if($skpi){
			foreach ($skpi as $s) {
				$temp['NIM'] 	= $s['nim'];
				$temp['STATUS']	= $s['status'];
				$tmp  = explode('-', $s['tgl_daftar']);
				$tmp_tgl = $tmp[2].' '.ucwords(strtolower($this->konversi_bulan((int) $tmp[1]))).' '.$tmp[0];
				$temp['TGL']	= $tmp_tgl;

				$mhs = $this->lib_basic->get_data_mhs($s['nim']);
				$temp['NAMA'] 	= $mhs[0]['NAMA'];
				$temp['PRODI'] 	= $mhs[0]['NM_PRODI'];

				$tmp_ket 		= explode('#', $s['keterangan']);
				$temp['BATAL']  = 0;
				if(count($tmp_ket) > 1 && $tmp_ket[0] == 'BATAL_DAFTAR'){
					$temp['BATAL'] = 1;
				}

				$data_skpi[]	= $temp;
 			}
		}

		echo json_encode($data_skpi);
	
	}

	function cekcekcek(){
		$skpi = $this->api->get_api_json(
			"http://service.uin-suka.ac.id/servskpi/index.php/skpi_public/skpi_basic/get_all_data_pendaftar",
			'POST',
			array(
				'api_search' => array('2018', 'ALL')
			)
		);

		echo '<pre>';
		print_r($skpi);
		echo '</pre>';
	}

	function verifikasi_skpi_mhs(){

		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$data['string_skpi'] = $this->lib_basic->skpi();

		$data['status_label'] = $this->lib_basic->cek_label_aktif();

		$fakultas = $this->lib_basic->get_univ('fak');		

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		foreach ($fakultas as $key) {
			$data['ls_kd_fak'][$i] = $key['KD_FAK'];
			$data['ls_nm_fak'][$i] = $key['NM_FAK'];
			$i++;
		}

		if(isset($_POST['btn_status'])){
			$_POST['cek_nim'] = true;
			$_POST['nim'] = $_POST['btn_status'];

			$status = array ('status' => '0');
			$this->lib_basic->update_skpi($_POST['btn_status'], $status);
		}

		if(isset($_POST['cek_nim'])){
			$nim = $_POST['nim'];
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			$datamhs = $this->lib_basic->get_data_mhs($nim);
			$temp = array();
			if($datamhs){
				$i = 0;
				foreach ($datamhs as $key) {
					if($status_skpi!='BELUM'){
						$temp[$i] = array(
							'NIM' => $key['NIM'],
							'NAMA' => $key['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
						);

						$KD_FAK = $key['KD_FAK'];

						$KD_PRODI = $key['KD_PRODI'];

						$ANGKATAN = $key['ANGKATAN'];

						$data['kd_fak'] = $KD_FAK;

						$prodi = $this->lib_basic->get_univ('prod', $data['kd_fak']);
						$data['ls_kd_prodi'] = array();
						$data['ls_nm_prodi'] = array();
						$data['ls_angkatan'] = array();
						// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
						$i=0;
						foreach ($prodi as $key) {
							$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
							$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
							$i++;
						}

						$data['kd_prodi'] = $KD_PRODI;
					
						$angkatan = $this->lib_basic->get_tahun_angkatan();
						$i = 0;
						foreach ($angkatan as $key) {
							$data['ls_angkatan'][$i] = $key['ANGKATAN'];
							$i++;
						}

						$data['angkatan']= $ANGKATAN;


					}
					$i++;
				}


			}
			$data['mhs'] = $temp;
			$data['nim'] = $nim;

		}else{
				//elsenya disini

			if(isset($_POST['kd_fak'])){
				$data['kd_fak'] = $_POST['kd_fak'];

				// if(isset($_POST['angkatan'])){
				// 		$data['angkatan']= $_POST['angkatan'];

				// 		//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);

				// 	}else{
				// 		$data['angkatan'] = date('Y');
				// 	}



				$prodi = $this->lib_basic->get_univ('prod', $_POST['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				$data['ls_angkatan'] = array();
				// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
				$i=0;
				foreach ($prodi as $key) {
					$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
					$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
					$i++;
				}

				if(isset($_POST['kd_prodi'])){
					$data['kd_prodi'] = $_POST['kd_prodi'];
					
					$angkatan = $this->lib_basic->get_tahun_angkatan();
					$i = 0;
					foreach ($angkatan as $key) {
						$data['ls_angkatan'][$i] = $key['ANGKATAN'];
						$i++;
					}

					if(isset($_POST['angkatan'])){

						$data['angkatan']= $_POST['angkatan'];


						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);


						if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$tmp = array();
						$i = 0;
						foreach ($temp as $key) {
							$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
							if($status_skpi!='BELUM'){
								$tmp[$i] = array
								(
									'NIM' => $key['NIM'],
									'NAMA' => $key['NAMA'],
									'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
								);

								$i++;
							}
						}
						$data['mhs'] = $tmp;
					}





					}else{
						//$data['angkatan'] = date('Y');
						
					}
				}

			}
			
			if(isset($_POST['cek'])){
				if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
					//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$tmp = array();
					$i = 0;
					foreach ($temp as $key) {
						$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
						if($status_skpi!='BELUM'){
							$tmp[$i] = array
							(
								'NIM' => $key['NIM'],
								'NAMA' => $key['NAMA'],
								'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
							);

							$i++;
						}
					}
					$data['mhs'] = $tmp;
				}
		}

		}

		$this->output69->output_display('admin/v_list_mhs', $data);

	}

	function cetak_skpi_mhs()
	{
		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$fakultas = $this->lib_basic->get_univ('fak');
		

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		foreach ($fakultas as $key) {
			$data['ls_kd_fak'][$i] = $key['KD_FAK'];
			$data['ls_nm_fak'][$i] = $key['NM_FAK'];
			$i++;
		}

		$i=0;
		$data['tahun_ajaran'] = array();
		$ajaran = $this->lib_basic->get_tahun_wisuda();
		foreach($ajaran as $key){
			$data['tahun_ajaran'][$i] = array(
				'ta_id'  => $key['TA_ID'],
				'ajaran' => $key['TA_AJAR']
			);
			$i++;
		}

		$temp_verifikasi = $this->session->flashdata('nim');
		if($temp_verifikasi!='' || $temp_verifikasi!=NULL || $temp_verifikasi){
			$_POST['cek_nim'] = true;
			$_POST['nim'] = $temp_verifikasi;
		}

		if(isset($_POST['cek_nim'])){
			$nim = $_POST['nim'];
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			$datamhs = $this->lib_basic->get_data_mhs($nim);
			$temp = array();
			if($datamhs){
				$i = 0;
				foreach ($datamhs as $key) {
					if($status_skpi=='1'){
						$skpi = $this->lib_basic->get_skpi_mhs($nim);
						$temp[$i] = array(
							'NIM' => $key['NIM'],
							'NAMA' => $key['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM']),
							'SERI' => $skpi['no_skpi']
						);

						$KD_FAK = $key['KD_FAK'];

						$KD_PRODI = $key['KD_PRODI'];

						$ANGKATAN = $key['ANGKATAN'];

						$WISUDA = $this->lib_basic->get_wisuda_mhs($nim);
						$tgl_wisuda = $WISUDA[0]['TANGGAL'];

						$wsd = explode(' ', $tgl_wisuda);
						$wsd = explode('/', $wsd[0]);
						$wsd =$wsd[1].'/'.$wsd[0].'/'.$wsd[2];

						$tgl_indo = $this->lib_basic->date_indo($wsd);
						$tgl_indo = explode(' ', $tgl_indo);
						$tgl_indo = $tgl_indo[1].' '.$tgl_indo[2];

						for ($i=0; $i < count($data['tahun_ajaran']); $i++) { 
							$pw = $this->lib_basic->get_periode_wisuda($data['tahun_ajaran'][$i]['ta_id']);
							foreach ($pw as $keys) {
								if(strtoupper($tgl_indo)==strtoupper($keys['PER_BULAN'])){
									$data['kd_per'] = $keys['PER_ID'];
									$data['kd_ajaran'] = $data['tahun_ajaran'][$i]['ta_id'];

									$data['periode_wisuda'] = array();
									$prw = $this->lib_basic->get_periode_wisuda($data['kd_ajaran']);
										foreach ($prw as $keyx) {
											$data['periode_wisuda'][$i] = array(
												'id_per' => $keyx['PER_ID'],
												'per_bulan' => $keyx['PER_BULAN']
											);
											$i++;
										}

								}
							}
						}


						$data['kd_fak'] = $KD_FAK;

						$prodi = $this->lib_basic->get_univ('prod', $data['kd_fak']);
						$data['ls_kd_prodi'] = array();
						$data['ls_nm_prodi'] = array();
						$data['ls_angkatan'] = array();

						$i=0;
						foreach ($prodi as $key) {
							$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
							$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
							$i++;
						}

						$data['kd_prodi'] = $KD_PRODI;
					
						$angkatan = $this->lib_basic->get_tahun_angkatan();
						$i = 0;
						foreach ($angkatan as $key) {
							$data['ls_angkatan'][$i] = $key['ANGKATAN'];
							$i++;
						}

						$data['angkatan']= $ANGKATAN;


					}
					$i++;
				}


			}
			$data['mhs'] = $temp;
			$data['nim'] = $nim;

		}else{

			if(isset($_POST['kd_ajaran'])){
				// if($_POST['kd_ajaran']!='X0X'){
					$data['kd_ajaran'] = $_POST['kd_ajaran'];
					if($data['kd_ajaran']!='X0X'){
						$i=0;
						$data['periode_wisuda'] = array();
						$periode = $this->lib_basic->get_periode_wisuda($data['kd_ajaran']);
							foreach ($periode as $key) {
								$data['periode_wisuda'][$i] = array(
									'id_per' => $key['PER_ID'],
									'per_bulan' => $key['PER_BULAN']
								);
								$i++;
							}

						if(isset($_POST['kd_per'])){
							$data['kd_per'] = $_POST['kd_per'];
						}
					}
				// }
			}
			
			if(isset($_POST['kd_fak'])){
				$data['kd_fak'] = $_POST['kd_fak'];
				$prodi = $this->lib_basic->get_univ('prod', $_POST['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				$data['ls_angkatan'] = array();
				$i=0;
				foreach ($prodi as $key) {
					$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
					$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
					$i++;
				}

				if(isset($_POST['kd_prodi'])){
					$data['kd_prodi'] = $_POST['kd_prodi'];
					
					// $angkatan = $this->lib_basic->get_tahun_angkatan();
					// $i = 0;
					// foreach ($angkatan as $key) {
					// 	$data['ls_angkatan'][$i] = $key['ANGKATAN'];
					// 	$i++;
					// }

					// if(isset($_POST['angkatan'])){

					// 	$data['angkatan']= $_POST['angkatan'];

					// 	if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
					// 	$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					// 	$tmp = array();
					// 	$i = 0;
					// 	foreach ($temp as $key) {
					// 		$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
					// 		if($status_skpi!='BELUM'){
					// 			$tmp[$i] = array
					// 			(
					// 				'NIM' => $key['NIM'],
					// 				'NAMA' => $key['NAMA'],
					// 				'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
					// 			);

					// 			$i++;
					// 		}
					// 	}
					// 	$data['mhs'] = $tmp;
					// }

					// }
				}

			}


		
		if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['kd_ajaran']) && isset($data['kd_per'])){
			
			 if($data['kd_fak']!='X0X' && $data['kd_prodi']!='X0X' && $data['kd_ajaran']!='X0X' && $data['kd_per']!='X0X' ){

				// for ($i=0; $i < count($data['periode_wisuda']); $i++) { 
				// 	if($data['periode_wisuda'][$i]['id_per']==$data['kd_per']){
				// 		$bulan = $data['periode_wisuda'][$i]['per_bulan'];
				// 	}
				// }

				$temp = $this->lib_basic->get_peserta_wisuda($data['kd_prodi'], $data['kd_per']);
				$tmp = array();
				$i=0;
				foreach ($temp as $key) {
					$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
					if($status_skpi=='1'){
						$skpi = $this->lib_basic->get_skpi_mhs($key['NIM']);
						$tmp[$i] = array
						(
							'NIM' => $key['NIM'],
							'NAMA' => $key['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM']),
							'SERI' => $skpi['no_skpi']
						);

						$i++;
					}
				}
				$data['mhs'] = $tmp;
			}
		}
			
		// 	if(isset($_POST['cek'])){
		// 		if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
		// 			//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
		// 			$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
		// 			$tmp = array();
		// 			$i = 0;
		// 			foreach ($temp as $key) {
		// 				$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
		// 				if($status_skpi!='BELUM'){
		// 					$tmp[$i] = array
		// 					(
		// 						'NIM' => $key['NIM'],
		// 						'NAMA' => $key['NAMA'],
		// 						'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
		// 					);

		// 					$i++;
		// 				}
		// 			}
		// 			$data['mhs'] = $tmp;
		// 		}
		// }

		}

		$this->output69->output_display('admin/list_cetak', $data);
	}

	function status_verifikasi_skpi_mhs(){
		$data['string_skpi']  = $this->lib_basic->skpi();
		$this->output69->output_display('admin/v_list_status_verifikasi_mhs', $data);
	}

	function proses_batal_verifikasi(){
		$nim = $this->input->post('nim');
		$status = array ('status' => '0');
		$data = $this->lib_basic->update_skpi($nim, $status);
		if($data){
			echo 1;
		}else{
			echo 0;
		}
	}

	function status_skpi_mhs(){

		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$fakultas = $this->lib_basic->get_univ('fak');
		

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		foreach ($fakultas as $key) {
			$data['ls_kd_fak'][$i] = $key['KD_FAK'];
			$data['ls_nm_fak'][$i] = $key['NM_FAK'];
			$i++;
		}

		if(isset($_POST['cek_nim'])){
			$nim = $_POST['nim'];
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			$datamhs = $this->lib_basic->get_data_mhs($nim);
			$temp = array();
			if($datamhs){
				$i = 0;
				foreach ($datamhs as $key) {
					if($status_skpi=='1'){
						$temp[$i] = array(
							'NIM' => $key['NIM'],
							'NAMA' => $key['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
						);

						$KD_FAK = $key['KD_FAK'];

						$KD_PRODI = $key['KD_PRODI'];

						$ANGKATAN = $key['ANGKATAN'];

						$data['kd_fak'] = $KD_FAK;

						$prodi = $this->lib_basic->get_univ('prod', $data['kd_fak']);
						$data['ls_kd_prodi'] = array();
						$data['ls_nm_prodi'] = array();
						$data['ls_angkatan'] = array();
						// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
						$i=0;
						foreach ($prodi as $key) {
							$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
							$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
							$i++;
						}

						$data['kd_prodi'] = $KD_PRODI;
					
						$angkatan = $this->lib_basic->get_tahun_angkatan();
						$i = 0;
						foreach ($angkatan as $key) {
							$data['ls_angkatan'][$i] = $key['ANGKATAN'];
							$i++;
						}

						$data['angkatan']= $ANGKATAN;


					}
					$i++;
				}


			}
			$data['mhs'] = $temp;
			$data['nim'] = $nim;

		}else{
				//elsenya disini

			if(isset($_POST['kd_fak'])){
				$data['kd_fak'] = $_POST['kd_fak'];

				// if(isset($_POST['angkatan'])){
				// 		$data['angkatan']= $_POST['angkatan'];

				// 		//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);

				// 	}else{
				// 		$data['angkatan'] = date('Y');
				// 	}



				$prodi = $this->lib_basic->get_univ('prod', $_POST['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				$data['ls_angkatan'] = array();
				// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
				$i=0;
				foreach ($prodi as $key) {
					$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
					$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
					$i++;
				}

				if(isset($_POST['kd_prodi'])){
					$data['kd_prodi'] = $_POST['kd_prodi'];
					
					$angkatan = $this->lib_basic->get_tahun_angkatan();
					$i = 0;
					foreach ($angkatan as $key) {
						$data['ls_angkatan'][$i] = $key['ANGKATAN'];
						$i++;
					}

					if(isset($_POST['angkatan'])){

						$data['angkatan']= $_POST['angkatan'];


						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);


						if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$tmp = array();
						$i = 0;
						foreach ($temp as $key) {
							$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
							if($status_skpi=='1'){
								$tmp[$i] = array
								(
									'NIM' => $key['NIM'],
									'NAMA' => $key['NAMA'],
									'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
								);

								$i++;
							}
						}
						$data['mhs'] = $tmp;
					}





					}else{
						//$data['angkatan'] = date('Y');
						
					}
				}

			}
			
			if(isset($_POST['cek'])){
				if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
					//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$tmp = array();
					$i = 0;
					foreach ($temp as $key) {
						$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
						if($status_skpi!='BELUM'){
							$tmp[$i] = array
							(
								'NIM' => $key['NIM'],
								'NAMA' => $key['NAMA'],
								'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
							);

							$i++;
						}
					}
					$data['mhs'] = $tmp;
				}
		}

		}


		$this->output69->output_display('admin/status_skpi_mhs', $data);

	}

	function cetak_skpi($nim = '0X0X0'){

		$nim = $this->input->post('nim');
		$noseri = $this->input->post('noseri');

		$Update = $this->lib_basic->update_noseri($nim, $noseri);

		//KOP ATAS
		//$data['KOP_KEMENTERIAN'];
		$data['KOP_SKPI'] 	 = $this->lib_basic->get_kop_skpi($nim); 
		$data['KOP_NM_UNIV'] = $this->lib_basic->get_nama_univ();

		$data['NOMOR_SKPI']  = $this->lib_basic->get_nomor_skpi($nim);


		//data header
		//judul (SKPI)

		$status_skpi = $this->lib_basic->status_skpi_mhs($nim);
		if($status_skpi){
			$skpi = $this->lib_basic->get_skpi_mhs($nim);
			$label = $skpi['id_l'];
			$unused_label = $skpi['unused_label'];
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
						$DATA_DIRI[3] = $this->lib_basic->get_status_label_cetak_mhs($id_ld, $unused_label);

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

						$INSTANSI[3] = $this->lib_basic->get_status_label_cetak_mhs($id_ld, $unused_label);

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

							$CAPAIAN[3] = $this->lib_basic->get_status_label_cetak_mhs($id_ld, $unused_label);

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

				$KEGIATAN[3] = $this->lib_basic->get_status_label_cetak_mhs($id_ld, $unused_label);
				
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
							$SISTEM[3] = $this->lib_basic->get_status_label_cetak_mhs($id_ld, $unused_label);

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

							$KKNI[3] = $this->lib_basic->get_status_label_cetak_mhs($hasil['id_ld'], $unused_label);

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

				$html = $this->load->view('admin/skpi_pdf', $data, true );

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

				// get the current page break margin



				// menambahkan halaman (harus digunakan minimal 1 kali)
				$this->pdf->AddPage();

				// -- set new background ---

				$this->pdf->writeHTML($html, true, false, true, false, '');
	 			$this->pdf->lastPage();

	 			//nama file pdf
	 			$namafile = $nim.'_SKPI.pdf';

	 			ob_end_clean();
				$this->pdf->Output($namafile, 'I');

		}else{
			redirect(base_url().'skpi/skpi_admin/skpi_mhs');
		}

		
	}

	function list_pembatalan_pendaftaran_skpi(){
		$data['string_skpi']  = $this->lib_basic->skpi();
		$data['status_label'] = $this->lib_basic->cek_label_aktif();
		$this->output69->output_display('admin/v_list_pembatalan_pendaftaran_skpi', $data);
	}

	function fill_form_pembatalan(){
		$nim = $this->input->post('nim'); //'13651060';//
		$mhs = $this->lib_basic->get_data_mhs($nim);

		$skpi = $this->lib_basic->get_skpi_mhs($nim);

		$data['NIM'] 	= $nim;
		$data['NAMA']	= $mhs[0]['NAMA'];
		$data['PRODI']	= $mhs[0]['NM_PRODI'].' ('.$mhs[0]['NM_JENIS'].')';

		$tmp  = explode('-', $skpi['tgl_daftar']);
		$tmp_tgl = $tmp[2].' '.ucwords(strtolower($this->konversi_bulan((int) $tmp[1]))).' '.$tmp[0];
		$data['TGL']	= $tmp_tgl;

		echo json_encode($data);

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
	}

	function proses_batal_pendaftaran_verifikasi(){
		$nim = $this->input->post('nim');
		$keterangan = $this->input->post('ket');
		$nip = $this->session->userdata('id_user');
		$data = $this->lib_basic->batal_daftar_verifikasi($nim, $keterangan);
		if($data){
			$log = $this->lib_basic->log_batal_daftar($nim, $nip, $keterangan);
			echo 1;
		}else{
			echo 0;
		}
	}

	function proses_daftar_ulang($nim = ''){
		$nim = '13651060';// $this->session->userdata('id_user'); //

		$data = $this->lib_basic->hapus_skpi_mhs($nim);
		redirect(base_url().'skpi/skpi_admin/mahasiswa_daftar_skpi_testing');	
	}


	function list_pendaftar_verifikasi()
	{

		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		//$data['status_label'] = $this->lib_basic->cek_label_aktif();

		$fakultas = $this->lib_basic->get_univ('fak');		

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		foreach ($fakultas as $key) {
			$data['ls_kd_fak'][$i] = $key['KD_FAK'];
			$data['ls_nm_fak'][$i] = $key['NM_FAK'];
			$i++;
		}

		if(isset($_POST['btn_status'])){
			$_POST['cek_nim'] = true;
			$_POST['nim'] = $_POST['btn_status'];

			$status = array ('status' => '0');
			$this->lib_basic->update_skpi($_POST['btn_status'], $status);
		}

		if(isset($_POST['btn_batal'])){
			$nim_mhs 	= $_POST['btn_batal'];
			$temp_batal = $this->lib_basic->hapus_skpi_mhs($nim_mhs);
			$dt_mhs 	= $this->lib_basic->get_data_mhs($nim_mhs);

			$_POST['kd_fak']	= $dt_mhs[0]['KD_FAK'];
			$_POST['kd_prodi']	= $dt_mhs[0]['KD_PRODI'];
			$_POST['angkatan']	= $dt_mhs[0]['ANGKATAN'];
		}

		if(isset($_POST['cek_nim'])){
			$nim = $_POST['nim'];
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			$datamhs = $this->lib_basic->get_data_mhs($nim);
			$temp = array();
			if($datamhs){
				$i = 0;
				foreach ($datamhs as $key) {
					if($status_skpi=='0'){
						$temp[$i] = array(
							'NIM' => $key['NIM'],
							'NAMA' => $key['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
						);

						$KD_FAK = $key['KD_FAK'];

						$KD_PRODI = $key['KD_PRODI'];

						$ANGKATAN = $key['ANGKATAN'];

						$data['kd_fak'] = $KD_FAK;

						$prodi = $this->lib_basic->get_univ('prod', $data['kd_fak']);
						$data['ls_kd_prodi'] = array();
						$data['ls_nm_prodi'] = array();
						$data['ls_angkatan'] = array();
						// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
						$i=0;
						foreach ($prodi as $key) {
							$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
							$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
							$i++;
						}

						$data['kd_prodi'] = $KD_PRODI;
					
						$angkatan = $this->lib_basic->get_tahun_angkatan();
						$i = 0;
						foreach ($angkatan as $key) {
							$data['ls_angkatan'][$i] = $key['ANGKATAN'];
							$i++;
						}

						$data['angkatan']= $ANGKATAN;


					}
					$i++;
				}


			}
			$data['mhs'] = $temp;
			$data['nim'] = $nim;

		}else{
				//elsenya disini

			if(isset($_POST['kd_fak'])){
				$data['kd_fak'] = $_POST['kd_fak'];

				// if(isset($_POST['angkatan'])){
				// 		$data['angkatan']= $_POST['angkatan'];

				// 		//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);

				// 	}else{
				// 		$data['angkatan'] = date('Y');
				// 	}



				$prodi = $this->lib_basic->get_univ('prod', $_POST['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				$data['ls_angkatan'] = array();
				// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
				$i=0;
				foreach ($prodi as $key) {
					$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
					$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
					$i++;
				}

				if(isset($_POST['kd_prodi'])){
					$data['kd_prodi'] = $_POST['kd_prodi'];
					
					$angkatan = $this->lib_basic->get_tahun_angkatan();
					$i = 0;
					foreach ($angkatan as $key) {
						$data['ls_angkatan'][$i] = $key['ANGKATAN'];
						$i++;
					}

					if(isset($_POST['angkatan'])){

						$data['angkatan']= $_POST['angkatan'];


						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);


						if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
						$tmp = array();
						$i = 0;
						foreach ($temp as $key) {
							$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
							if($status_skpi=='0'){
								$tmp[$i] = array
								(
									'NIM' => $key['NIM'],
									'NAMA' => $key['NAMA'],
									'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
								);

								$i++;
							}
						}
						$data['mhs'] = $tmp;
					}





					}else{
						//$data['angkatan'] = date('Y');
						
					}
				}

			}
			
			if(isset($_POST['cek'])){
				if(isset($data['kd_fak']) && isset($data['kd_prodi']) && isset($data['angkatan'])){
					//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$temp = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);
					$tmp = array();
					$i = 0;
					foreach ($temp as $key) {
						$status_skpi = $this->lib_basic->cek_skpi($key['NIM']);
						if($status_skpi!='BELUM'){
							$tmp[$i] = array
							(
								'NIM' => $key['NIM'],
								'NAMA' => $key['NAMA'],
								'STATUS' => $this->lib_basic->status_skpi_mhs($key['NIM'])
							);

							$i++;
						}
					}
					$data['mhs'] = $tmp;
				}
		}

		}

		$this->output69->output_display('admin/list_mhs_daftar_verifikasi', $data);

	}

	function list_cetak_skpi_mhs(){
		$data['string_skpi']  = $this->lib_basic->skpi();
		$this->output69->output_display('admin/v_list_cetak_skpi_mhs', $data);
	}

	function fill_form_fakultas(){
		$fakultas = $this->lib_basic->get_univ('fak');
		$data = array();
		if($fakultas){
			foreach ($fakultas as $f) {
				$temp = array('KD_FAK' => $f['KD_FAK'], 'NM_FAK' => $f['NM_FAK']);
				$data[] = $temp;
			}
		}
		
		echo json_encode($data);
	}

	function fill_form_prodi(){
		$fakultas = $this->input->post('fak'); // '06'; //
		$prodi = $this->lib_basic->get_univ('prod', $fakultas);
		$data = array();
		if($prodi){
			foreach ($prodi as $d) {
				$temp = array('KD_PRODI' => $d['KD_PRODI'], 'NM_PRODI' => $d['NM_PRODI_J']);
				$data[] = $temp;
			}
		}
		
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		echo json_encode($data);
	}

	function testing_fill_form_prodi(){
		$prodi = $this->lib_basic->get_univ('prod', '06');

		echo URL_API_SIA;
		echo '<pre>';
		print_r($prodi);
		echo '</pre>';
	}

	function fill_form_tahunajaran(){
		$data = $this->lib_basic->get_tahun_wisuda();
		echo json_encode($data);
	}

	function fill_form_periodewisuda(){
		$ta = $this->input->post('ta'); //'88'; // 
		$data = $this->lib_basic->get_periode_wisuda($ta);
		echo json_encode($data);

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
	}

	function fill_peserta_wisuda(){
		$prodi 		= $this->input->post('prodi'); //'22607';//
		$periode 	= $this->input->post('periode'); // '303';//

		$peserta 	= $this->lib_basic->get_peserta_wisuda($prodi, $periode);
		$data 	 	= array();

		if($peserta){
			foreach ($peserta as $p) {
				$sts_skpi = $this->lib_basic->cek_skpi($p['NIM']);
				if($sts_skpi == 1){
					$skpi = $this->lib_basic->get_skpi_mhs($p['NIM']);
					$temp = array(
						'NIM' => $p['NIM'],
						'NAMA' => $p['NAMA'],
						'STATUS' => $this->lib_basic->status_skpi_mhs($p['NIM']),
						'SERI' => $skpi['no_skpi']
					);

					$data[] = $temp;
				}
			}
		}

		echo json_encode($data);
	}

	function fill_peserta_wisuda_by_nim(){
		$nim = $this->input->post('nim'); // '13651060';//
		$peserta 	= $this->lib_basic->get_data_mhs($nim);
		$data 	 	= array();
		$data['MAHASISWA'] = 0;

		if($peserta){
			$data['MAHASISWA'] = 1;
			$wisuda 	= $this->lib_basic->get_wisuda_mhs($nim);

			$tgl_wisuda = $wisuda[0]['TANGGAL'];

			$wsd = explode(' ', $tgl_wisuda);
			$wsd = explode('/', $wsd[0]);
			$wsd =$wsd[1].'/'.$wsd[0].'/'.$wsd[2];

			$tgl_indo = $this->lib_basic->date_indo($wsd);
			$tgl_indo = explode(' ', $tgl_indo);
			$tgl_indo = $tgl_indo[1].' '.$tgl_indo[2];

			

			$data['KD_PRODI'] = $peserta[0]['KD_PRODI'];
			$data['KD_FAK'] = $peserta[0]['KD_FAK'];
			$data['WISUDA'] = 0;


			$ajaran = $this->lib_basic->get_tahun_wisuda();

			if($ajaran){
				foreach ($ajaran as $a) {
					$periode = $this->lib_basic->get_periode_wisuda($a['TA_ID']);
					if($periode){
						foreach ($periode as $pr) {
							if(strtoupper($tgl_indo)==strtoupper($pr['PER_BULAN'])){
								$data['TA_ID'] = $a['TA_ID'];
								$data['PER_ID'] = $pr['PER_ID'];
								$data['WISUDA'] = 1;
							}
						}
					}
				}
			}

			$data['SKPI'] = 0;
			if($peserta){
				foreach ($peserta as $p) {
					$sts_skpi = $this->lib_basic->cek_skpi($p['NIM']);
					if($sts_skpi == 1){
						$skpi = $this->lib_basic->get_skpi_mhs($p['NIM']);
						$temp = array(
							'NIM' => $p['NIM'],
							'NAMA' => $p['NAMA'],
							'STATUS' => $this->lib_basic->status_skpi_mhs($p['NIM']),
							'SERI' => $skpi['no_skpi']
						);

						$data['PESERTA'][] = $temp;
						$data['SKPI'] = 1;
					}
				}
			}
		}
		

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		// die();

		echo json_encode($data);
	}

	function cek_data_skpi_mhs_testing(){
		$data = $this->lib_basic->get_skpi_mhs('11540044');
		$data = $this->session->all_userdata();
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	function testing_label_error(){
		$label = '1';
		$data = $this->lib_basic->get_label(1500, 8, array($label, '1', 4));
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}