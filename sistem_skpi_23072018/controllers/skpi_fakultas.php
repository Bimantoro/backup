<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skpi_fakultas extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->api = $this->s00_lib_api;
		$this->output69 = $this->s00_lib_output;

		$this->session->set_userdata('app', 'skpi_01');
		$this->load->library('skpi_lib_basic','','lib_basic');

		$this->lib_basic->auto_update_label();

		$who = $this->lib_basic->cek_allowed('SKPI1');
		if(!$who){
			
			if($this->session->userdata('id_user') == 'PKSI100'){
				$array = array(
							'skpi_lvl' => 'fak'
						);
						
					$this->session->set_userdata( $array );
				}else{
					redirect(base_url());
				}
		}else{
			if(!$this->session->userdata('skpi_lvl')){
				if(!$who){
					redirect(base_url());
				}else{
					//$this->validasi($who);
					$array = array(
							'skpi_lvl' => 'fak'
						);
						
					$this->session->set_userdata( $array );
				}
			}
		}
		
	}

	function index()
	{		
		$data['string_skpi'] = $this->lib_basic->skpi();
		$this->output69->output_display('fakultas/home', $data);
	}

	function list_mhs()
	{
		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$fakultas = $this->lib_basic->get_univ('fak');

		$akses_fakultas = $this->lib_basic->akses_fakultas();

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		$data['ls_angkatan'] = array();
		foreach ($fakultas as $key) {
			for ($i=0; $i < count($akses_fakultas); $i++) { 
				if($key['KD_FAK'] == $akses_fakultas[$i]){
					$data['ls_kd_fak'][$i] = $key['KD_FAK'];
					$data['ls_nm_fak'][$i] = $key['NM_FAK'];
					$i++;
				}
			}			
		}

		if(count($akses_fakultas)==1){
			$_POST['kd_fak'] = $akses_fakultas[0];
		}

		if(isset($_POST['cek_nim'])){
			$nim = $_POST['nim'];
			$status_skpi = $this->lib_basic->cek_skpi($nim);
			$datamhs = $this->lib_basic->get_data_mhs($nim);
			$temp = array();
			if($datamhs){
				$i = 0;
				foreach ($datamhs as $key) {
					$akses_mhs = false;
					for ($i=0; $i < count($akses_fakultas); $i++) { 
						if($akses_fakultas[$i]==$key['KD_FAK']){
							$akses_mhs=true;
						}
					}

					if($status_skpi!='BELUM' && $akses_mhs==true){
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

		$this->output69->output_display('fakultas/list_mhs_f', $data);
	}

	function list_verifikasi_mhs()
	{		
		$data['status_label'] = $this->lib_basic->cek_label_aktif();
		$data['string_skpi']  = $this->lib_basic->skpi();
		$this->output69->output_display('fakultas/list_verifikasi_mhs_f', $data);
	}

	function konversi_bulan($angka){
		$bulan = array(
			1 => 'Januari',
			'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'			
		);

		return $bulan[$angka];
	}

	function get_tanggal_daftar_verifikasi(){

		$akses = $this->lib_basic->akses_fakultas();

		if($this->session->userdata('id_user') == 'PKSI100'){
			$akses = array('06');
		}

		$akses_prodi = array();
		foreach ($akses as $aks) {
			$l_prodi = $this->lib_basic->get_univ('prod', $aks);
			foreach ($l_prodi as $p) {
				$akses_prodi[] = $p['KD_PRODI'];
			}
		}
		//$akses_prodi = $akses['prodi'];

		$bulan = array();
		$tahun = array();
		$id_thn = 0;

		foreach ($akses_prodi as $prod) {
			$data = $this->api->get_api_json(
				"http://service.uin-suka.ac.id/servskpi/index.php/skpi_public/skpi_basic/get_tanggal_daftar",
				'POST',
				array('api_search' => array($prod))
			);

			
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
		}

		

		$data = array (
			'TAHUN' => $tahun,
			'BULAN' => $bulan
		);

		echo json_encode($data);
	}

	function get_all_data_verifikasi_mahasiswa(){
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$data_skpi = array();

		$akses = $this->lib_basic->akses_fakultas();

		if($this->session->userdata('id_user') == 'PKSI100'){
			$akses = array('06');
		}

		$akses_prodi = array();
		foreach ($akses as $aks) {
			$l_prodi = $this->lib_basic->get_univ('prod', $aks);
			foreach ($l_prodi as $p) {
				$akses_prodi[] = $p['KD_PRODI'];
			}
		}

		foreach ($akses_prodi as $prod) {
			$skpi = $this->api->get_api_json(
				"http://service.uin-suka.ac.id/servskpi/index.php/skpi_public/skpi_basic/get_data_pendaftar",
				'POST',
				array(
					'api_search' => array($tahun, $bulan, $prod)
				)
			);

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
					$data_skpi[]	= $temp;
	 			}
			}
		}		

		echo json_encode($data_skpi);
	
	}

	function get_data_verifikasi_mhs_by_nim(){
		$nim = $this->input->post('nim');
		$akses = $this->lib_basic->akses_fakultas();

		if($this->session->userdata('id_user') == 'PKSI100'){
			$akses = array('06');
		}
		
		$akses_prodi = array();
		foreach ($akses as $aks) {
			$l_prodi = $this->lib_basic->get_univ('prod', $aks);
			foreach ($l_prodi as $p) {
				$akses_prodi[] = $p['KD_PRODI'];
			}
		}
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

			$mhs = $this->lib_basic->get_data_mhs($s['nim']);
			foreach ($akses_prodi as $prod) {
				if($s['kd_prodi'] == $prod){
					$temp['NIM'] 	= $s['nim'];
					$temp['STATUS']	= $s['status'];
					$tmp  = explode('-', $s['tgl_daftar']);
					$tmp_tgl = $tmp[2].' '.ucwords(strtolower($this->konversi_bulan((int) $tmp[1]))).' '.$tmp[0];
					$temp['TGL']	= $tmp_tgl;

					$temp['BULAN'] = $tmp[1];
					$temp['TAHUN'] = $tmp[0];

					
					$temp['NAMA'] 	= $mhs[0]['NAMA'];
					$temp['PRODI'] 	= $mhs[0]['NM_PRODI'];
					$data_skpi[]	= $temp;
				}
				
			}
			
		}

		echo json_encode($data_skpi);
	}


	function cetak_skpi_mhs()
	{
		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$fakultas = $this->lib_basic->get_univ('fak');
		

		$akses_fakultas = $this->lib_basic->akses_fakultas();

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		$data['ls_angkatan'] = array();
		foreach ($fakultas as $key) {
			for ($i=0; $i < count($akses_fakultas); $i++) { 
				if($key['KD_FAK'] == $akses_fakultas[$i]){
					$data['ls_kd_fak'][$i] = $key['KD_FAK'];
					$data['ls_nm_fak'][$i] = $key['NM_FAK'];
					$i++;
				}
			}			
		}

		if(count($akses_fakultas)==1){
			$_POST['kd_fak'] = $akses_fakultas[0];
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
					$akses_mhs = false;
					for ($i=0; $i < count($akses_fakultas); $i++) { 
						if($akses_fakultas[$i]==$key['KD_FAK']){
							$akses_mhs=true;
						}
					}

					if($status_skpi=='1' && $akses_mhs==true){
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

		$this->output69->output_display('fakultas/list_cetak_f', $data);
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

				$html = $this->load->view('fakultas/skpi_pdf_f', $data, true );

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
	 			$namafile = $nim.'_SKPI.pdf';

	 			ob_end_clean();
				$this->pdf->Output($namafile, 'I');

		}else{
			redirect(base_url().'skpi/skpi_fakultas/cetak_skpi_mhs');
		}

		
	}

	function cetak_draft_skpi($nim = '0X0X0'){

		$nim = $this->input->post('nimx');
		//$noseri = $this->input->post('noseri');

		//$Update = $this->lib_basic->update_noseri($nim, $noseri);

		//KOP ATAS
		//$data['KOP_KEMENTERIAN'];
		$data['KOP_SKPI'] 	 = $this->lib_basic->get_kop_skpi($nim); 
		$data['KOP_NM_UNIV'] = $this->lib_basic->get_nama_univ();

		$data['NOMOR_SKPI']  = 'NOMOR_SKPI_SEMENTARA';//$this->lib_basic->get_nomor_skpi($nim);


		//data header
		//judul (SKPI)

		$status_skpi = $this->lib_basic->status_skpi_mhs($nim);
		$status_skpi = true;
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

				$html = $this->load->view('fakultas/skpi_pdf_f', $data, true );

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
			redirect(base_url().'skpi/skpi_fakultas/list_verifikasi_mhs');
		}

		
	}

	function testing()
	{
		$data = $this->lib_basic->get_univ('fak');
		foreach ($data as $key) {
				echo $key['NM_FAK']; echo "<br>";
				$prodi = $this->lib_basic->get_univ('prod', $key['KD_FAK']);
				foreach ($prodi as $keys) {
					echo "** ".$keys['NM_PRODI']; echo "<br>";
				}
				echo "<br>";

			}
	}

	function tester()
	{
		$data = $this->lib_basic->get_wisuda_mhs('13651060');
		echo $data[0]['TANGGAL'];
		echo "<br>";
		echo "<br>";
		echo "<br>";
		foreach ($data as $key) {
			foreach ($key as $keys => $value) {
				echo $keys.' : '.$value;
				echo "<br>";
			}
			echo "<br>";
			$temp = explode(' ', $key['TANGGAL']);
			$temp = explode('/', $temp[0]);
			$temp =$temp[1].'/'.$temp[0].'/'.$temp[2];

			$tgl_indo = $this->lib_basic->date_indo($temp);
			$tgl_indo = explode(' ', $tgl_indo);
			$tgl_indo = $tgl_indo[1].' '.$tgl_indo[2];
			echo $tgl_indo;
			echo "<br>";
		}
	}

	function halo()
	{
		$data = $this->lib_basic->testing_api_cek();
		print_r($data);
	}

	function cek()
	{
		//$data = $this->lib_basic->peserta_wisuda('303', '22607', '65');
		$data = $this->lib_basic->testing_api_cek();
		foreach ($data as $key) {
			foreach ($key as $keys => $value) {
				echo $keys.' --> '.$value; echo '<br>';

			} echo '<br>';
		}
		print_r($data);
	}

	// function testing()
	// {
		
	// 	//$this->load->library('skpi_lib_basic','','lib_basic');
	// 	$data = $this->lib_basic->get_label(1500, 1, array('status'));
	// 	if($data){
	// 		$data = json_decode($data);
	// 		print_r($data);
	// 	}else{
	// 		echo "upps";
	// 	}
	// }

	// function halo()
	// {
	// 		$data = $this->lib_basic->get_sertifikasi_uin('13651080');//('#SKPI0#SKPI1#SKPI2'); 136510601002287500 
	// 		if($data){
	// 			//echo $data[0]['FAK_NM_KAB2'];
	// 			// print_r($data);
	// 			 foreach ($data as $key) {
						
	// 			 		foreach ($key as $key1 => $value1) {
	// 			 			echo $key1.' : '.$value1; echo "<br>";
	// 			 		}
	// 			 		echo "<br>";
	// 			 	}
				
				
	// 		}else{
	// 			echo "hallo";
	// 			echo "<br>";
	// 			echo count($data);
	// 			print_r($data);
	// 		}

	// }

	function coba()
	{
		$logo = $this->lib_basic->get_tahun_wisuda();
		print_r($logo);
		foreach ($logo as $key) {
			foreach ($key as $keys => $value) {
				echo $keys.' : '.$value;
				echo "<br>";
			}
			echo "<br>";
		}
	}

	function list_cetak_skpi_mhs(){
		$data['string_skpi']  = $this->lib_basic->skpi();
		$this->output69->output_display('fakultas/v_list_cetak_skpi_mhs_f', $data);
	}

	function fill_form_fakultas(){
		$af = $this->lib_basic->akses_fakultas();
		if($this->session->userdata('id_user') == 'PKSI100'){
			$af = array('06', '04');
		}

		$fakultas = $this->lib_basic->get_univ('fak');
		$data = array();
		if($fakultas){
			foreach ($fakultas as $f) {
				foreach ($af as $k) {
					if($f['KD_FAK'] == $k){
						$temp = array('KD_FAK' => $f['KD_FAK'], 'NM_FAK' => $f['NM_FAK']);
						$data[] = $temp;
					}
				}
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

	function testing_akses_fak(){
		$d = $this->lib_basic->akses_fakultas();
		print_r($d);
	}

	function fill_peserta_wisuda_by_nim(){
		$nim = $this->input->post('nim'); // '13651060';//
		$peserta 	= $this->lib_basic->get_data_mhs($nim);
		$data 	 	= array();
		$data['MAHASISWA'] = 0;

		$af = $this->lib_basic->akses_fakultas();
		if($this->session->userdata('id_user') == 'PKSI100'){
			$af = array('06');
		}

		$akses = 0;
		if($peserta && !empty($af)){
			foreach ($af as $k) {
				if($peserta[0]['KD_FAK'] == $k){
					$akses = 1;
				}
			}
		}

		if($peserta && $akses == 1){
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
}