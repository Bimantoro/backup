<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Skpi_prodi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->api = $this->s00_lib_api;
		$this->output69 = $this->s00_lib_output;

		$this->session->set_userdata('app', 'skpi_02');
		$this->load->library('skpi_lib_basic','','lib_basic');

		$this->lib_basic->auto_update_label();

		$who = $this->lib_basic->cek_allowed('SKPI2#SKPI3#SKPI4');
		if(!$who){
			if($this->session->userdata('id_user') == 'PKSI100'){
				$array = array(
					'skpi_lvl' => 'prodi/all'
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

					$this->validasi_prodi($who);
					
				}
			}
		}
	}

	function validasi_prodi($who)
	{
		foreach ($who as $key => $value) {
			$lvl = substr($value, -1);
			switch ($lvl) {
				case 2:
					# full akses document + bahasa ::
						$array = array(
							'skpi_lvl' => 'prodi/all'
						);
						
						$this->session->set_userdata( $array );
					break;

				case 3:
					# hanya dokumen saja
						$array = array(
							'skpi_lvl' => 'prodi/dokumen'
						);
						
						$this->session->set_userdata( $array );
					break;

				case 4:
					# hanya bahasa saja
						$array = array(
							'skpi_lvl' => 'prodi/bahasa'
						);
						
						$this->session->set_userdata( $array );
					break;
				
				default:
					# tidak termasuk
						redirect(base_url());
					break;
			}
		}
	}

	function index()
	{
		$data['string_skpi'] = $this->lib_basic->skpi();
		$this->output69->output_display('prodi/home', $data);
	}

	function list_mhs()
	{
		redirect(base_url('skpi/skpi_prodi/list_verifikasi_mhs'));

		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$data['status_label'] = $this->lib_basic->cek_label_aktif();

		$lvl_petugas = $this->session->userdata('skpi_lvl');
		$lvl_petugas = explode('/', $lvl_petugas);
		$data['lvl_petugas'] = $lvl_petugas[1]; // 'all';

		$fakultas = $this->lib_basic->get_univ('fak');

		$akses = $this->lib_basic->akses_prodi();
		$fak   = $akses['fak'];
		$prod  = $akses['prodi'];

		$i=0;
		$data['ls_kd_fak'] = array();
		$data['ls_nm_fak'] = array();
		foreach ($fakultas as $key) {
			for ($i=0; $i < count($fak); $i++) { 
				if($key['KD_FAK'] == $fak[$i]){
					$data['ls_kd_fak'][$i] = $key['KD_FAK'];
					$data['ls_nm_fak'][$i] = $key['NM_FAK'];
					$i++;
				}
			}
		}

		if(count($fak)==1){
			$_POST['kd_fak'] = $fak[0];
		}

		if(count($prod)==1){
				$_POST['kd_prodi'] = $prod[0];
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
					if($status_skpi!='BELUM'){
						$sts = 0;
						for ($j=0; $j < count($prod); $j++) {
							if($key['KD_PRODI'] == $prod[$j]){
								$sts++;
							}						
						}

						if($sts>0){
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
								for ($i=0; $i < count($prod); $i++) { 
									if($key['KD_PRODI'] == $prod[$i]){
											$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
											$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
											$i++;
									}
								}
							}

							$data['kd_prodi'] = $KD_PRODI;
						
							$angkatan = $this->lib_basic->get_tahun_angkatan();
							$i = 0;
							foreach ($angkatan as $key) {
								$data['ls_angkatan'][$i] = $key['ANGKATAN'];
								$i++;
							}

							$data['angkatan']= $ANGKATAN;
						
							$i++;
						}
					}
					
				}
			}
			$data['mhs'] = $temp;
			$data['nim'] = $nim;

		}else{
				//elsenya disini
			if(isset($_POST['kd_fak'])){
				$data['kd_fak'] = $_POST['kd_fak'];

				if(isset($_POST['angkatan'])){
						$data['angkatan']= $_POST['angkatan'];

						//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);

					}else{
						//$data['angkatan'] = date('Y');
					}



				$prodi = $this->lib_basic->get_univ('prod', $data['kd_fak']);
				$data['ls_kd_prodi'] = array();
				$data['ls_nm_prodi'] = array();
				// $data['ls_angkatan'] = $this->lib_basic->get_list_tahun();
				$i=0;
				foreach ($prodi as $key) {
					for ($i=0; $i < count($prod); $i++) { 
						if($key['KD_PRODI'] == $prod[$i]){
							$data['ls_kd_prodi'][$i] = $key['KD_PRODI'];
							$data['ls_nm_prodi'][$i] = $key['NM_PRODI_J'];
							$i++;
						}
					}					
				}

				if(count($prod)==1){
					$_POST['kd_prodi'] = $prod[0];
				}

				if(isset($_POST['kd_prodi'])){
					// $data['kd_prodi'] = $_POST['kd_prodi'];
					

					// if(isset($_POST['angkatan'])){
					// 	$data['angkatan']= $_POST['angkatan'];

					// 	//$data['mhs'] = $this->lib_basic->get_univ('mhs', $data['kd_prodi'], $data['angkatan']);

					// }else{
					// 	$data['angkatan'] = date('Y');
					// }

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

		$this->output69->output_display('prodi/list_mhs_d', $data);
	}

	function list_verifikasi_mhs()
	{		
		$data['status_label'] = $this->lib_basic->cek_label_aktif();
		$data['string_skpi']  = $this->lib_basic->skpi();
		$this->output69->output_display('prodi/list_verifikasi_mhs_d', $data);
	}




	//ini baru


	function konversi_bulan($angka){
		$bulan = array(
			1 => 'Januari',
			'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'			
		);

		return $bulan[$angka];
	}

	function get_tanggal_daftar_verifikasi(){

		$akses = $this->lib_basic->akses_prodi();
		$akses_prodi = $akses['prodi'];

		if($this->session->userdata('id_user') == 'PKSI100'){
			$akses_prodi = array('22607');
		}

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

	function cumacoba(){
		$data = $this->lib_basic->get_data_mhs('12640009');
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	function get_data_verifikasi_mhs_by_nim(){
		$nim = $this->input->post('nim');
		$akses = $this->lib_basic->akses_prodi();
		$akses_prodi = $akses['prodi'];
		// $nim = '13651060';

		if($this->session->userdata('id_user') == 'PKSI100'){
			$akses_prodi = array('22607');
		}

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

					$tmp_ket 		= explode('#', $s['keterangan']);
					$temp['BATAL']  = 0;
					if(count($tmp_ket) > 1 && $tmp_ket[0] == 'BATAL_DAFTAR'){
						$temp['BATAL'] = 1;
					}

					$temp['BULAN'] = $tmp[1];
					$temp['TAHUN'] = $tmp[0];

					
					$temp['NAMA'] 	= $mhs[0]['NAMA'];
					$temp['PRODI'] 	= $mhs[0]['NM_PRODI'];
					$data_skpi[]	= $temp;
				}
				
			}
			
		}

		//
		//print_r($data_skpi);
		echo json_encode($data_skpi);
	}

	function get_all_data_verifikasi_mahasiswa(){
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$data_skpi = array();

		$akses = $this->lib_basic->akses_prodi();
		$akses_prodi = $akses['prodi'];

		if($this->session->userdata('id_user') == 'PKSI100'){
			$akses_prodi = array('22607');
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
			}
		}

		

		echo json_encode($data_skpi);
	
	}

	//ini baru





	function verifikasi_data_mhs($code = ''){


		header("Cache-Control: no cache");
		session_cache_limiter("private_no_expire");

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_prodi/list_mhs','refresh');
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
		
		$this->output69->output_display('prodi/verifikasi_data_mhs_d', $data);	
	}

	function verifikasi_data_cp(){
		$nim = $this->session->userdata('nim_mhs');
		$mhs = $this->lib_basic->get_data_mhs($nim);

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_prodi/list_mhs','refresh');
		}

		if(isset($_POST['sv_capaian'])){

			if(!isset($_POST['capaian'])){
				$this->lib_basic->delete_cp('nim', $nim);
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_cp');
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

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_cp');

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
			
			$this->output69->output_display('prodi/verifikasi_data_cp_d', $data);
		}else{
			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_mhs');
		}			
	}

	function verifikasi_data_prestasi(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_prodi/list_mhs','refresh');
		}

		$nim = $this->session->userdata('nim_mhs');

		$psn = $this->session->flashdata('pesan');
		$jenis =$this->session->flashdata('jenis');

		$sts_skpi = $this->lib_basic->status_skpi_mhs($nim);

		if($sts_skpi){
			redirect(base_url().'skpi/skpi_prodi/verifikasi_penulisan');
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
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
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

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
		}

		//update validasi organisasi :
		if(isset($_POST['sv_organisasi'])){
			$temp_organisasi = $_POST['organisasi'];
			$skpi_organisasi = $this->lib_basic->cek_organisasi($nim);

			if(!isset($_POST['organisasi'])){
				$this->lib_basic->delete_organisasi('nim', $nim);
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
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

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
		}

		//update validasi sertifikasi :
		if(isset($_POST['sv_sertifikasi'])){
			$temp_sertifikasi = $_POST['sertifikasi'];
			$skpi_sertifikasi = $this->lib_basic->cek_sertifikasi($nim);

			if(!isset($_POST['sertifikasi'])){
				$this->lib_basic->delete_sertifikasi('nim', $nim);
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
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

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
		}

		//update validasi magang :
		if(isset($_POST['sv_magang'])){
			$temp_magang = $_POST['magang'];
			$skpi_magang = $this->lib_basic->cek_magang($nim);

			if(!isset($_POST['magang'])){
				$this->lib_basic->delete_magang('nim', $nim);
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
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

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
		}

		//update validasi karakter :
		if(isset($_POST['sv_karakter'])){
			$temp_karakter = $_POST['karakter'];
			$skpi_karakter = $this->lib_basic->cek_karakter($nim);

			if(!isset($_POST['karakter'])){
				$this->lib_basic->delete_karakter('nim', $nim);
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
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

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
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

			$this->output69->output_display('prodi/verifikasi_data_prestasi_d', $data);
		}else{
			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_mhs');
		}
	}

	function verifikasi_penulisan(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_prodi/list_mhs','refresh');
		}

		$lvl_petugas = $this->session->userdata('skpi_lvl');
		$lvl_petugas = explode('/', $lvl_petugas);
		$data['lvl_petugas'] = $lvl_petugas[1]; //'all';

		if(isset($_POST['btn_valid'])){
			$nim = $_POST['btn_valid'];
			$array = array(
				'nim_mhs' => $nim
			);
			
			$this->session->set_userdata( $array );
		}

		$psn = $this->session->flashdata('pesan');
		$jenis =$this->session->flashdata('jenis');

		if($psn!='' || $psn!=NULL || $psn){
			$msg_name = 'pesan_'.$jenis;
			$data[$msg_name] = $psn;
		}

		//INI NANTI DAPET LANGSUNG DARI LIST MHS NIMNYA JUGA BISA
		//KALAU LANGSUNG KESINI BERARTI DIA KHUSUS BAHASA SAJA

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
							//$skpimhs = $this->lib_basic->get_skpi_mhs($nim);
							//$unused_label = $skpimhs['unused_label'];
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
			
			$this->output69->output_display('prodi/verifikasi_penulisan_prestasi_d', $data);
		}else{
			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_mhs');
		}
	}

	function verifikasi_detail_penulisan($id_riwayat='', $jenis=''){
		if(isset($_POST['sv_saran'])){
			$data_update = array('kd_kegiatan' => $_POST['id_k'], 'saran' => $_POST['saran'], 'status' => $_POST['status_data']);
			$test = $this->lib_basic->update_kegiatan($_POST['id_k'], $data_update);
			if($test){
				//echo "sukses";
				redirect(base_url().'skpi/skpi_prodi/verifikasi_penulisan');
			}else{
				//echo "gagal";
				redirect(base_url().'skpi/skpi_prodi/verifikasi_penulisan');
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
			redirect(base_url().'skpi/skpi_prodi/verifikasi_penulisan');
		}

		$this->output69->output_display('prodi/verifikasi_detail_penulisan_d', $data);
	}

	function verifikasi_akhir(){

		$status_label= $this->lib_basic->cek_label_aktif();
		if($status_label==0){
			redirect('skpi/skpi_prodi/list_mhs','refresh');
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
			redirect(base_url().'skpi/skpi_prodi/list_mhs');
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


			$this->output69->output_display('prodi/verifikasi_akhir_d', $data);
		}else{

			redirect(base_url().'skpi/skpi_prodi/verifikasi_data_mhs');
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
				redirect(base_url().'skpi/skpi_prodi/verifikasi_penulisan');
			}else{
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
			}
			

		}else{
			$this->session->set_flashdata('pesan', 'File Bukti '.$jenis.' Tidak Ditemukan !');
			$this->session->set_flashdata('jenis', $jenis);
			if($page=='X0X'){
				redirect(base_url().'skpi/skpi_prodi/verifikasi_penulisan');
			}else{
				redirect(base_url().'skpi/skpi_prodi/verifikasi_data_prestasi');
			}
		}


	}

	function cetak_skpi($nim = '0X0X0'){

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

				$data['logo'] = $this->lib_basic->get_logo_uin();

				$html = $this->load->view('prodi/skpi_pdf_d', $data, true );

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
			redirect(base_url().'skpi/skpi_prodi/skpi_mhs');
		}

		
	}

	function list_pembatalan_pendaftaran_skpi(){
		$data['status_label'] = $this->lib_basic->cek_label_aktif();
		$data['string_skpi']  = $this->lib_basic->skpi();
		$this->output69->output_display('prodi/v_list_pembatalan_pendaftaran_skpi_d', $data);
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

	function testing()
	{
		$kd_unit = 'UA000248';
		$data = $this->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/index.php/simpeg_public/simpeg_mix/data_search',
					'POST',
					array(
						'api_kode'		=> 1901,
						'api_subkode'	=> 4,
						'api_search'	=> array(date('d/m/Y'), $kd_unit)
					)
			);

		$datax = $this->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/simpeg_public/simpeg_mix/data_view',
					'POST',
					array(
						'api_kode'		=> 1001,
						'api_subkode'	=> 3,
					)
			);



		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}