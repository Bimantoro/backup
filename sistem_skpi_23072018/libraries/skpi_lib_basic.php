<?php defined('BASEPATH') OR exit('No direct script access allowed');
define('URL_API_SKPI', 'http://service.uin-suka.ac.id/servskpi/index.php/skpi_public');


class Skpi_lib_basic 
{

	function url_skpi()
	{
		return URL_API_SKPI;
	}

	function get_univ($something, $val1='', $val2='')
	{
		$CI =& get_instance();
		switch ($something) {
			case 'fak':
				$parameter = array(	'api_kode' => 17000,'api_subkode' => 1,'api_search'=> array());
				$data= $CI->api->get_api_json(URL_API_SIA.'sia_master/data_view','POST',$parameter);
				break;
			case 'prod':
				$parameter = array(	'api_kode' => 19000,'api_subkode' => 6,'api_search'=> array($val1));
				$data= $CI->api->get_api_json(URL_API_SIA.'sia_master/data_search','POST',$parameter);
				break;
			case 'mhs':
				$parameter = array(	'api_kode' => 26000,'api_subkode' => 16,'api_search'=> array($val1,$val2));
				$data= $CI->api->get_api_json(URL_API_SIA.'sia_mahasiswa/data_search','POST',$parameter);
				break;
			default:
				$data = false;
				break;
		}
		return $data;
	}



	// LIBRARY UNTUK LABEL
	//1. FUNGSI UNTUK MENGAMBIL DATA LABEL :
		function get_label($apikode, $apisubkode, $data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> $apikode,
						'api_subkode'	=> $apisubkode,
						'api_search'	=> $data
					)
			);

			return $data;		
		}

	//2. FUNGSI UNTUK MENAMBAH DATA LABEL :
		function insert_label($apikode, $apisubkode, $data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/simpan',
					'POST',
					array(
						'api_kode'		=> $apikode,
						'api_subkode'	=> $apisubkode,
						'api_search'	=> $data
					)
			);

			return $data;	
		}

	//3. FUNGSI UNTUK UPDATE DATA LABEL :
		function update_label($apikode, $apisubkode, $data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/update',
					'POST',
					array(
						'api_kode'		=> $apikode,
						'api_subkode'	=> $apisubkode,
						'api_search'	=> $data
					)
			);

			return $data;	
		}

	//4. FUNGSI UNTUK DELETE DATA LABEL :
		function delete_label($apikode, $apisubkode, $data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/hapus',
					'POST',
					array(
						'api_kode'		=> $apikode,
						'api_subkode'	=> $apisubkode,
						'api_search'	=> $data
					)
			);

			return $data;	
		}


//--------------------------------------------------------------------------------------------------

	//LIBRARY UNTUK DATA SKPI (URL_API_SKPI)

	//AMBIL DATA SKPI :
		function get_skpi_mhs($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 1,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//STATUS SKPI UNTUK LIST_DATA
		function cek_skpi($nim)
		{
			$temp = $this->get_skpi_mhs($nim);
			$data = 'BELUM';
			if($temp){
				$data = $temp['status'];
			}		

			return $data;
		}

	//CEK STATUS SKPI :
		function status_skpi_mhs($nim)
		{
			
			$CI =& get_instance();
			$data = $this->get_skpi_mhs($nim);
			if($data){
				if($data['status']==1){
					return $data['status'];
				}else{
					return false;
				}

			}else{
				return $data;	
			}
		}

	//INSERT DATA SKPI
		function insert_skpi($data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/simpan',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 1,
						'api_search'	=> array($data)
					)
			);

			return $data;
		}

	//UPDATE DATA SKPI
		function update_skpi($nim, $data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 1,
						'api_search'	=> array($nim, $data)
					)
			);

			return $data;
		}

	//AMBIL DATA CP YANG SUDAH TERSIMPAN DI DB SKPI
		function cek_cp($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 4,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//SIMPAN DATA CP KE DB SKPI
		function insert_cp($data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/simpan',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 2,
						'api_search'	=> array($data)
					)
			);

			return $data;
		} 

	//HAPUS DATA CP DARI DB SKPI
		function delete_cp($opsi, $nim, $id_riwayat='')
		{
			$CI =& get_instance();
			switch ($opsi) {
				case 'kode':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 3,
									'api_search'	=> array($nim, $id_riwayat)
								)
						);

					break;

				case 'nim':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 2,
									'api_search'	=> array($nim)
								)
						);
					break;
				
				default:
					$data = false;
					break;
			}

			return $data;
		}

	//AMBIL DATA KEGIATAN (PRESTASI) YANG TERSIMPAN DI DB SKPI
		function cek_prestasi($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 5,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//HAPUS DATA KEGIATAN (PRESTASI) DARI DB SKPI
		function delete_prestasi($opsi, $nim, $id_riwayat='')
		{
			$CI =& get_instance();
			switch ($opsi) {
				case 'kode':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 5,
									'api_search'	=> array($nim, $id_riwayat)
								)
						);

					break;

				case 'nim':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 4,
									'api_search'	=> array($nim)
								)
						);
					break;
				
				default:
					$data = false;
					break;
			}

			return $data;
		}

	//AMBIL DATA KEGIATAN (ORGANISASI) DARI DB SKPI
		function cek_organisasi($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 6,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//HAPUS DATA KEGIATAN (ORGANISASI) DARI DB SKPI
		function delete_organisasi($opsi, $nim, $id_riwayat='')
		{
			$CI =& get_instance();
			switch ($opsi) {
				case 'kode':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 7,
									'api_search'	=> array($nim, $id_riwayat)
								)
						);

					break;

				case 'nim':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 6,
									'api_search'	=> array($nim)
								)
						);
					break;
				
				default:
					$data = false;
					break;
			}

			return $data;
		}


	//AMBIL DATA KEGIATAN (SERTIFIKASI) DARI DB SKPI
		function cek_sertifikasi($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 7,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//HAPUS DATA KEGIATAN (SERTIFIKASI) DARI DB SKPI
		function delete_sertifikasi($opsi, $nim, $id_riwayat='')
		{
			$CI =& get_instance();
			switch ($opsi) {
				case 'kode':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 9,
									'api_search'	=> array($nim, $id_riwayat)
								)
						);

					break;

				case 'nim':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 8,
									'api_search'	=> array($nim)
								)
						);
					break;
				
				default:
					$data = false;
					break;
			}

			return $data;
		}

	//AMBIL DATA KEGIATAN (MAGANG) DARI DB SKPI
		function cek_magang($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 8,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//HAPUS DATA KEGIATAN (MAGANG) DARI DB SKPI
		function delete_magang($opsi, $nim, $id_riwayat='')
		{
			$CI =& get_instance();
			switch ($opsi) {
				case 'kode':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 11,
									'api_search'	=> array($nim, $id_riwayat)
								)
						);

					break;

				case 'nim':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 10,
									'api_search'	=> array($nim)
								)
						);
					break;
				
				default:
					$data = false;
					break;
			}

			return $data;
		}


	//AMBIL DATA KEGIATAN (KARAKTER) DARI DB SKPI
		function cek_karakter($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 9,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//HAPUS DATA KEGIATAN (KARAKTER) DARI DB SKPI
		function delete_karakter($opsi, $nim, $id_riwayat='')
		{
			$CI =& get_instance();
			switch ($opsi) {
				case 'kode':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 13,
									'api_search'	=> array($nim, $id_riwayat)
								)
						);

					break;

				case 'nim':
						$data = $CI->s00_lib_api->get_api_json(
								URL_API_SKPI.'/skpi_basic/hapus',
								'POST',
								array(
									'api_kode'		=> 1500,
									'api_subkode'	=> 12,
									'api_search'	=> array($nim)
								)
						);
					break;
				
				default:
					$data = false;
					break;
			}

			return $data;
		}

	//SIMPAN DATA KEGIATAN (SEMUA) KE DB SKPI
		function insert_kegiatan($data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/simpan',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 3,
						'api_search'	=> array($data)
					)
			);

			return $data;
		}

	//UPDATE DATA KEGIATAN (PRESTASI DAN ORGANISASI) DB SKPI
		function update_kegiatan($id_riwayat, $data)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 2,
						'api_search'	=> array($id_riwayat, $data)
					)
			);

			return $data;
		}




//--------------------------------------------------------------------------------------------------

	//LIBRARY UNTUK DATA DPM
	//AMBIL DATA MAHASISWA
		 function get_data_mhs($nim)
		 {
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 26000,
						'api_subkode'	=> 10,
						'api_search'	=> array($nim)
					)
			);

		 	return $data;
		}

	//AMBIL NOMOR IJAZAH MHS
		function get_nomor_ijazah($nim)
		{
			$CI =& get_instance();

			$nomor = '';

			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 30005,
						'api_subkode'	=> 6,
						'api_search'	=> array($nim)
					)
			);

			if($data){
				$nomor = $data[0]['NO_IJAZAH'];
			}
		 	return $nomor;
		}

	//GENERATE NOMOR SKPI
		function get_nomor_skpi($nim)
		{
			//CEK NOMOR IJAZAH
			$nomor 	= $this->get_nomor_ijazah($nim);
			if($nomor){
				//BIKIN SINGKATAN FAKULTAS / PASCASARJANA :
					$nama = $this->get_nama_fak($nim);
					$nama = $nama['IDN'];
					if(strtoupper($nama) == 'PASCASARJANA'){
						$NM = 'PPS';
					}else{
						$temp = str_replace('DAN', '', strtoupper($nama));
						$temp = explode(' ', $temp);
						$NM   = 'F';
						for ($i=0; $i < count($temp); $i++) { 
							$temp[$i] = substr($temp[$i], 0, 1);
							$NM = $NM.''.$temp[$i];
						}
					}

				//ambil nomor urut dan tahun
					$nomor = explode('/', $nomor);
					$temp  = count($nomor);
					$tahun = $nomor[$temp-1];
					$urut  = $nomor[$temp-2];

				//susun nomor skpi
					$no_skpi = 'SKPI/'.$NM.'/'.$urut.'/'.$tahun;
			}else{
				$no_skpi = 'NO SKPI_SEMENTARA';
			}
			

			return $no_skpi;

		}

	//AMBIL DATA UNIT
		function get_unit()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/simpeg_public/simpeg_mix/data_view',
					'POST',
					array(
						'api_kode'		=> 1001,
						'api_subkode'	=> 3,
						'api_search'	=> array()
					)
			);

			return $data;
		}

		function get_data_unit($id_unit)
		{
			$unit = $this->get_unit();
			$data = false;
			foreach ($unit as $key) {
				if($id_unit == $key['UNIT_ID']){
					$data = $key;
				}
			}

			return $data;
		}

	//AMBIL TAHUN LULUS MHS
		function get_tahun_lulus($nim)
		{
			$CI =& get_instance();
			$tahun = '';
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 30000,
						'api_subkode'	=> 2,
						'api_search'	=> array($nim)
					)
			);

			if($data){
				$tahun = date('Y', strtotime($data[0]['TGL_LULUS']));
			}

		 	return $tahun;
		}
	
	//AMBIL GELAR MHS
		function get_gelar($nim)
		{
			$CI =& get_instance();
			$gelar = '-';

			$mhs = $this->get_data_mhs($nim);
			$prodi = $this->get_data_prodi($mhs[0]['KD_PRODI']);

			if($prodi){
				$gelar = ucwords(strtolower($prodi[0]['NM_GELAR'])).' ('.$prodi[0]['SKT_GELAR'].')';
			}
			return $gelar;

		}

	//AMBIL DATA PRODI
		function get_data_prodi($kodeprodi)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_master/data_search',
					'POST',
					array(
						'api_kode'		=> 19000,
						'api_subkode'	=> 1,
						'api_search'	=> array($kodeprodi)
					)
			);

		 	return $data;
		}

	//AMBIL DATA KATEGORI CP
		function get_kategori_cp()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_master/data_view',
					'POST',
					array(
						'api_kode'		=> 61002,
						'api_subkode'	=> 1,
						'api_search'	=> array()
					)
			);

		 	return $data;
		}

	//AMBIL DATA PEMINATAN MHS
		function get_kode_peminatan($nim)
		{
			$CI =& get_instance();
			$kode = NULL;
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 38000,
						'api_subkode'	=> 2,
						'api_search'	=> array($nim)
					)
			);

			if($data){
				$kode = $data[0]['KD_PEMINATAN'];
			}

		 	return $kode;
		}

	//AMBIL DATA KURIKULUM MAHASISWA
		function get_kode_kurikulum($nim)
		{
			$CI =& get_instance();
			$kode =  NULL;
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_kurikulum/data_search',
					'POST',
					array(
						'api_kode'		=> 40001,
						'api_subkode'	=> 3,
						'api_search'	=> array($nim)
					)
			);

			if($data){
				$kode = $data[0]['KD_KUR'];
			}

		 	return $kode;
		}

	//AMBIL DATA CP
		function get_data_cp($nim)
		{
			$CI =& get_instance();

			$peminatan = $this->get_kode_peminatan($nim);
			$kurikulum = $this->get_kode_kurikulum($nim);

			$mhs = $this->get_data_mhs($nim);
			$prodi = $mhs[0]['KD_PRODI'];

			$temp = array();
			$title = array();
			$content = array();

			$kategori = $this->get_kategori_cp();
			$i=0;
			foreach ($kategori as $key) {

					//AMBIL DATA TITLE CP  (KODE, IDN, EN)
					$title[$i]['KODE'] = $key['KD_KAT_CAPAIAN'];
					$title[$i]['IDN'] = $key['NM_KAT_ID'];
					$title[$i]['EN'] = $key['NM_KAT_EN'];

					$kd_kat = $key['KD_KAT_CAPAIAN'];
					$data = $CI->s00_lib_api->get_api_json(
							URL_API_SIA.'/sia_master/data_search',
							'POST',
							array(
								'api_kode'		=> 61002,
								'api_subkode'	=> 1,
								'api_search'	=> array(
													$kd_kat,
													$peminatan,
													$prodi,
													$kurikulum,
													1
												)
							)
					);

					if($data){
						//AMBIL DATA KONTENT CP (KODE, IDN, EN)
						$j=0;
						foreach ($data as $keys) {
							$content[$title[$i]['KODE']][$j]['KODE']	= $keys['KD_CAPAIAN'];
							$content[$title[$i]['KODE']][$j]['IDN']		= $keys['ISIAN_ID'];
							$content[$title[$i]['KODE']][$j]['EN']		= $keys['ISIAN_EN'];
							$j++;
						}
					}
				
				$i++;
			}

			$capaian = array(
				'TITLE' => $title,
				'KONTEN' => $content
			);

			return $capaian;
		}


	//AMBIL DATA CP SESUAI DENGAN YANG TERSIMPAN DI DB SKPI
		function get_data_valid_cp($title, $skpi, $dpm)
		{
			$content = array();
			for ($i=0; $i < count($title); $i++) {
				$idx = 0;
				if(isset($dpm[$title[$i]['KODE']])){
					for ($j=0; $j < count($dpm[$title[$i]['KODE']]); $j++) { 						
						foreach ($skpi as $key) {
							if($dpm[$title[$i]['KODE']][$j]['KODE'] == $key['kd_cp']){
								$content[$title[$i]['KODE']][$idx] = $dpm[$title[$i]['KODE']][$j];
								$idx++;
							}
						}
					}
				}
			}

			return $content;
		}

	//MEMBUAT CHEKCLIST UNTUK CP YANG SUDAH DI SIMPAN DI DB SKPI (STATUS SKPI = 0)
		function get_data_cheklist_capaian($title, $skpi, $dpm)
		{
			$validasi = array();

			for ($i=0; $i < count($title); $i++) { 
				if(isset($dpm[$title[$i]['KODE']])){
					for ($j=0; $j < count($dpm[$title[$i]['KODE']]); $j++) { 
						$temp = 0;
						foreach ($skpi as $key) {
							if($dpm[$title[$i]['KODE']][$j]['KODE'] == $key['kd_cp']){
								$temp++;
								
							}
						}

						if($temp>0){
							$validasi[$dpm[$title[$i]['KODE']][$j]['KODE']] = 'checked';
						}else{
							$validasi[$dpm[$title[$i]['KODE']][$j]['KODE']] = '';
						}
					}
				}
			}
			
			return $validasi;

		}

	//MEMBUAT CHEKLIST UNTUK CP YANG BELUM PERNAH DILAKUKAN VERIFIKASI (DEFAULT UNTUK CP ADALAH CHEKLIST SEMUA)
		function set_checked($title, $dpm)
		{
			$validasi = array();

			for ($i=0; $i < count($title); $i++) { 
				if(isset($dpm[$title[$i]['KODE']])){
					for ($j=0; $j < count($dpm[$title[$i]['KODE']]); $j++) { 
						$validasi[$dpm[$title[$i]['KODE']][$j]['KODE']] = 'checked';
					}
				}
			}

			return $validasi;
		}

	//AMBIL DATA PRESTASI MAHASISWA
		function get_data_prestasi($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 37000,
						'api_subkode'	=> 2,
						'api_search'	=> array($nim)
					)
			);

		 	return $data;
		}

	//MEMBUAT UNCHEK KESEMUA KEGIATAN
		function set_uncheck($dpm)
		{
			$validasi = array();
			foreach ($dpm as $key) {
				$validasi[$key['ID_RIWAYAT']] = '';
			}

			return $validasi;
		}


	//AMBIL DATA ORGANISASI MAHASISWA
		function get_data_organisasi($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 36000,
						'api_subkode'	=> 2,
						'api_search'	=> array($nim)
					)
			);

		 	return $data;
		}

	//MEMBUAT CHEKLIST DATA KEGIATAN YANG SUDAH TERSIMPAN DI DB SKPI
		function get_data_checklist($skpi, $dpm)
		{
			$validasi = array();

			foreach ($dpm as $key) {
				$temp = 0;
				foreach ($skpi as $keys) {
					if($key['ID_RIWAYAT'] == $keys['kd_kegiatan']){
						$temp++;
					}
				}

				if($temp>0){
					$validasi[$key['ID_RIWAYAT']] = 'checked';
				}else{
					$validasi[$key['ID_RIWAYAT']] = '';
				}
			}

			return $validasi;
		}

	//AMBIL DATA KEGIATAN SESUAI DENGAN DB SKPI
		function get_data_valid($skpi, $dpm)
		{
			$valid = array();
			$i=0;

			foreach ($dpm as $key) {
				$temp = 0;
				foreach ($skpi as $keys) {
					if($key['ID_RIWAYAT'] == $keys['kd_kegiatan']){
						$temp++;
					}
				}

				if($temp>0){
					$valid[$i] = $key;
					$tmp = $this->cek_id_riwayat($key['ID_RIWAYAT']);
					$valid[$i]['STATUS'] = $tmp['PENULISAN'];
					$i++;
				}
			}

			return $valid;
		}

	//CEK SERTIFIKAT / DOKUMEN PELENGKAP DATA PRESTASI
		function cek_sertifikat_prestasi($nim, $id_riwayat)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 37000,
						'api_subkode'	=> 5,
						'api_search'	=> array($nim, $id_riwayat)
					)
			);

		 	return $data;
		}


	//CEK SERTIFIKAT / DOKUMEN PELENGKAP DATA KEGIATAN
		function cek_sertifikat_kegiatan($nim, $id_riwayat)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 36001,
						'api_subkode'	=> 5,
						'api_search'	=> array($nim, $id_riwayat)
					)
			);

		 	return $data;
		}

		//CEK SERTIFIKAT / DOKUMEN PELENGKAP DATA ORGANISASI
		function cek_sertifikat_organisasi($nim, $id_riwayat)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 36000,
						'api_subkode'	=> 3,
						'api_search'	=> array($nim, $id_riwayat)
					)
			);

		 	return $data;
		}



	//DOWNLOAD SERTIFIKAT / DOKUMEN PELENGKAP KEGIATAN
		function download_sertifikat($filename, $docname, $idriwayat)
		{
			//AMBIL EXTENSI FILE
			$extensi = explode('.', $filename);
			$extensi = $extensi[(count($extensi)-1)];
			$filename = $idriwayat.'.'.$extensi;

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($filename));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			ob_clean();
			flush();
			echo base64_decode($docname);
			exit;
		}

	//AMBIL NAMA FAKULTAS MAHASISWA
		function get_nama_fak($nim)
		{
			$mhs = $this->get_data_mhs($nim);
			$kode = $mhs[0]['KD_FAK'];
			$fak = $this->get_data_fakultas($kode);
			$data = array('IDN' => $fak[0]['NM_FAK'], 'EN' => $fak[0]['NM_FAK_EN']);

			return $data;
		}

	//AMBIL NAMA PRODI
		function get_nama_prodi($nim)
		{
			$mhs = $this->get_data_mhs($nim);
			$kode = $mhs[0]['KD_PRODI'];
			$prodi = $this->get_data_prodi($kode);
			$data = array('IDN' => $prodi[0]['NM_PRODI'], 'EN' => $prodi[0]['NM_PRODI_ASING']);

			return $data;
		}

	//AMBIL LEVEL KKNI
		function get_level_kkni($nim)
		{
			$mhs = $this->get_data_mhs($nim);
			$kode = $mhs[0]['KD_PRODI'];
			$prodi = $this->get_data_prodi($kode);
			$data = 'Level '.$prodi[0]['JENJANG_KKNI'];

			return $data;
		}

	//AMBIL DATA PRODI BY NIM
		function get_data_prodi_mhs($nim)
		{
			$mhs 	= $this->get_data_mhs($nim);
			$kode 	= $mhs[0]['KD_PRODI'];
			$data 	= $this->get_data_prodi($kode);

			return $data;
		}

	//MASA STUDI MAHASISWA
		function get_masa_study($nim)
		{
			$prodi = $this->get_data_prodi_mhs($nim);

			$semester = $prodi[0]['LAMA_STUDI_MAX'];
			$sks = $prodi[0]['SKS_LULUS'];

			$tahun = ($semester!='')?$semester/2:'-';
			$semester = ($semester!='')?$semester:'-';
			$sks = ($sks!='')?$sks:'-';

			//$indo = 'Paling lama '.$prodi[0]['LAMA_STUDI_MAX']/2.' tahun ('.$prodi[0]['LAMA_STUDI_MAX'].' Semester) dan lulus paling sedikit '.$prodi[0]['SKS_LULUS'].' SKS';
			//$eng  = 'No more than '.$prodi[0]['LAMA_STUDI_MAX']/2.' years ('.$prodi[0]['LAMA_STUDI_MAX'].' semesters) and passed at least '.$prodi[0]['SKS_LULUS'].' credits';
			$masastudy['IDN'] 	= 'Paling lama '.$tahun.' tahun ('.$semester.'  Semester) dan lulus paling sedikit '.$sks.' SKS';
			$masastudy['EN'] 	= 'No more than '.$tahun.' years ('.$semester.' semesters) and passed at least '.$sks.' credits';

			return $masastudy;
		}

	//AMBIL DATA KEGIATAN MHS DARI DPM
		function get_data_kegiatan($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 36001,
						'api_subkode'	=> 2,
						'api_search'	=> array($nim)
					)
			);

		 	return $data;
		}

	//AMBIL DATA SERTIFIKASI MAHASISWA
		function get_data_sertifikasi($nim)
		{
			$sertifikasi = array();
			$i=0;
			$keg 	= $this->get_data_kegiatan($nim);
			if($keg){
				foreach ($keg as $key) {
					if($key['KD_JENIS_KEGIATAN']==1 || strtoupper($key['NM_JENIS']) == 'PELATIHAN'){
						$sertifikasi[$i] = $key;
						$i++;
					}
				}
			}

			return $sertifikasi;
		}

	//AMBIL DATA MAGANG MAHASISWA
		function get_data_magang($nim)
		{
			$magang = array();
			$i=0;
			$keg 	= $this->get_data_kegiatan($nim);
			if($keg){
				foreach ($keg as $key) {
					if($key['KD_JENIS_KEGIATAN']==3 || strtoupper($key['NM_JENIS']) == 'ASISTENSI' || $key['KD_JENIS_KEGIATAN']==4 || strtoupper($key['NM_JENIS']) == 'MAGANG'){
						$magang[$i] = $key;
						$i++;
					}
				}
			}

			return $magang;
		}

	//AMBIL DATA PENDIDIKAN KARAKTER MAHASISWA
		function get_data_karakter($nim)
		{
			$karakter = array();
			$i=0;
			$keg 	= $this->get_data_kegiatan($nim);
			if($keg){
				foreach ($keg as $key) {
					if($key['KD_JENIS_KEGIATAN']==5 || $key['KD_JENIS_KEGIATAN']==2 || strtoupper($key['NM_JENIS']) == 'LAINNYA' || strtoupper($key['NM_JENIS']) == 'KEPANITIAAN'){
						$karakter[$i] = $key;
						$i++;
					}
				}
			}

			return $karakter;
		}



//--------------------------------------------------------------------------------
	//LIBRARY DARI SIA
	//INFORMASI UNIVERSITAS
		function get_data_universitas()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_master/data_search',
					'POST',
					array(
						'api_kode'		=> 16000,
						'api_subkode'	=> 1,
						'api_search'	=> array('202-004')
					)
			);

		 	return $data;
		}

	//INFORMASI FAKULTAS
		function get_data_fakultas($kode)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_master/data_search',
					'POST',
					array(
						'api_kode'		=> 17000,
						'api_subkode'	=> 1,
						'api_search'	=> array($kode)
					)
			);

		 	return $data;
		}

	//AMBIL SK UNIVERSITAS
		function get_sk_univ()
		{
			$temp = $this->get_data_universitas();
			$data = array('IDN' => $temp[0]['INFO_SK_PENDIRIAN_PT_ID'], 'EN' => $temp[0]['INFO_SK_PENDIRIAN_PT_EN']);
			return $data;
		}

	//AMBIL NAMA UNIVERSITAS
		function get_nama_univ()
		{
			$temp = $this->get_data_universitas();
			$data = array('IDN' => $temp[0]['INFO_NAMA_PT_ID'], 'EN' => $temp[0]['INFO_NAMA_PT_EN']);
			return $data;
		}

	//AMBIL DETAIL ALAMAT / CONTACT FAKULTAS
		function get_detail_contact($nim)
		{
			$mhs 	= $this->get_data_mhs($nim);
			$kode 	= $mhs[0]['KD_FAK'];
			$fak 	= $this->get_data_fakultas($kode);
			$univ 	= $this->get_data_universitas();
			$dlabel = $this->get_data_label($nim);
			$negara = $this->get_info_negara();

			//ALAMAT :
			$alamat = array(
				strtoupper($fak[0]['NM_SEBUTAN']).' '.strtoupper($fak[0]['NM_FAK']),
				strtoupper($univ[0]['INFO_NAMA_PT_ID']),
				$fak[0]['ALAMAT'],
				$dlabel[0]['FAK_NM_KAB2'].', '.ucwords(strtolower($negara[0]['NM_NEGARA']))
			);

			$hapus = array('http://','/');
			//CONTACT
			$contact = array(
				'Tel: '.$fak[0]['TELP'],
				'Fax: '.$fak[0]['FAX'],
				'Website: '.str_replace($hapus, '', $fak[0]['WEBSITE']),
				'Email: '.$fak[0]['EMAIL']
			);

			$data = array(
				'alamat' => $alamat,
				'contact' => $contact
			);

			return $data;
		}


	//INFORMASI TENTANG PENDIDIKAN TINGGI
		function get_sistem_pendidikan(){
			$CI =& get_instance();
			$temp = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_master/data_view',
					'POST',
					array(
						'api_kode'		=> 61002,
						'api_subkode'	=> 2,
						'api_search'	=> array()
					)
			);

			$i = 0;
			$sistem = array();

			foreach ($temp as $key) {
				$sistem[$i]['IDN'] = $key['NM_INFORMASI_ID'];
				$sistem[$i]['EN'] = $key['NM_INFORMASI_EN'];
				$i++;
			}

		 	return $sistem;
		}

	//INFORMASI KERANGKA KKNI
		function get_kkni($nim)
		{
			$mhs = $this->get_data_mhs($nim);
			$kode_prodi = $mhs[0]['KD_PRODI'];
			$kode_kurikulum = $this->get_kode_kurikulum($nim);
			$data = array();
			$CI =& get_instance();
			$temp = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_master/data_search',
					'POST',
					array(
						'api_kode'		=> 61002,
						'api_subkode'	=> 2,
						'api_search'	=> array($kode_kurikulum, $kode_prodi)
					)
			);
			if($temp){
				$i=0;
				foreach ($temp as $key) {
					$data[$i]['IDN'] = $key['NM_KKNI_ID'];
					$data[$i]['EN'] = $key['NM_KKNI_EN'];
					$i++;
				}
			}			

			// $data[0]['IDN'] = "Kerangka Kualifikasi Nasional Indonesia (KKNI)  adalah kerangka penjenjangan kualifikasi dan  kompetensi tenaga kerja Indonesia yang  menyandingkan, menyetarakan, dan mengintegrasikan sektor pendidikan dengan sektor pelatihan dan pengalaman kerja dalam  suatu skema pengakuan kemampuan kerja yang  disesuaikan dengan struktur di berbagai sektor  pekerjaan.";
			// $data[0]['EN'] = "The Indonesian National Qualfication Framework  is a framework denoting levels of Indonesian  workforce qualfications and competence, that  compares, equalizes, and integrates the education  and training sectors and work experience in a  scheme recognizing work competence based on the  structures of various work sectors.  ";

			// $data[1]['IDN'] = "KKNI merupakan perwujudan mutu  dan jati diri Bangsa Indonesia terkait dengan  sistem pendidikan nasional, sistem pelatihan  kerja nasional serta sistem penilaian kesetaraan  capaian pembelajaran (learning outcomes)  nasional, yang dimiliki Indonesia untuk  menghasilkan sumberdaya manusia yang  bermutu dan produktif.";
			// $data[1]['EN'] = "The Framework  is the manifestation of the quality and identity of  the Indonesian people in relations to the national  education system, national workforce training  system and national learning outcomes equality  evaluation system that Indonesia has in order to  produce qualiﬁed and productive human  resources.";

			// $data[2]['IDN'] = "Jenjang kualifikasi adalah tingkat capaian pembelajaran yang disepakati secara nasional, disusun berdasarkan ukuran hasil pendidikan dan/atau pelatihan yang diperoleh melalui pendidikan formal, nonformal atau pengalaman kerja.";
			// $data[2]['EN'] = "Qualification level is a nationally legalized learning outcomes, composed based on the assesment of the results of education and/or training activities achieved through formal education, nonformal education or working experiences.";

			return $data;
		}

	//GET INFORMASI DEKAN
		function get_dekan($nim)
		{
			$CI =& get_instance();

			$kode = $this->get_kode_ta($nim);
			$mhs = $this->get_data_mhs($nim);
			$kd_prodi = $mhs[0]['KD_PRODI'];

			if($kode){
				$kd_ta = $kode[0]['KD_TA_LULUS'];
				$kd_smt = $kode[0]['KD_SMT'];
			}else{
				$tanggal = date('d/m/Y');
				$semester = $CI->s00_lib_api->get_api_json(URL_API_SIA.'sia_krs/data_search', 'POST', array('api_kode'=>52000, 'api_subkode'=>12, 'api_search' => array($tanggal, $kd_prodi)));

				$kd_ta  = $semester[0]['KD_TA'];
				$kd_smt = $semester[0]['KD_SMT'];
			}

			
			

			//$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/index.php/simpeg_public/simpeg_mix/data_search',
					'POST',
					array(
						'api_kode'		=> 1221,
						'api_subkode'	=> 8,
						'api_search'	=> array($kd_ta, $kd_smt, 'DEKAN', $kd_prodi)
					)
			);

			return $data;

		}

	//GET TANDA TANGAN SKPI
		function tanda_tangan($nim)
		{
			//$mhs 		= $this->get_data_mhs($nim);
			//$kode 		= $mhs['KD_FAK'];
			$info_wisuda = $this->get_wisuda_mhs($nim);
			$tanggal 	 = date('d-m-Y'); 

			if($info_wisuda){
				$tgl_wisuda = explode(' ', $info_wisuda[0]['TANGGAL']);
				$tgl_wisuda = explode('/', $tgl_wisuda[0]);
				$tgl_wisuda = $tgl_wisuda[1].'/'.$tgl_wisuda[0].'/'.$tgl_wisuda[2];

				$tanggal 	= date('d-m-Y', strtotime($tgl_wisuda));
			}
		

			$fak 		= $this->get_nama_fak($nim);

			$dlabel 	= $this->get_data_label($nim);
			$dekan  	= $this->get_dekan($nim);

			//$nip 		= 0;

			$title['ALAMAT_IDN']	= ucwords(strtolower($dlabel[0]['FAK_NM_KAB2'])).', '.$this->date_indo($tanggal);
			$title['ALAMAT_EN']		= ucwords(strtolower($dlabel[0]['FAK_NM_KAB2'])).', '.date('F d, Y', strtotime($tgl_wisuda));
			$title['FAK_IDN']		= $dekan[0]['STR_NAMA'];
			$title['FAK_EN']		= ($fak['EN']=='')?'':'Dean of the Faculty of '.$fak['EN'];//'Dean of the '.$fak['EN'];

			$contact['NM_DEKAN']	=$dekan[0]['NM_PGW_F'];
			$contact['NIP']			='NIP '.$this->format_nip($dekan[0]['NIP']);
			$contact['KET']			='Employee ID Number';

			$data['title'] 		= $title;
			$data['contact']	= $contact;

			return $data;

		}

	//GET LOGO UIN
		function get_logo_uin($nim)
		{

			$info_wisuda = $this->get_wisuda_mhs($nim);

			$tgl_wisuda = explode(' ', $info_wisuda[0]['TANGGAL']);
			$tgl_wisuda = explode('/', $tgl_wisuda[0]);
			$tgl_wisuda = $tgl_wisuda[1].'/'.$tgl_wisuda[0].'/'.$tgl_wisuda[2];

			$tanggal 	= date('d/m/Y', strtotime($tgl_wisuda));
			$logo 		=  "http://static.uin-suka.ac.id/foto/unt/980/".tg_encode('UK000002#'.$tanggal.'#QL:50#WM:0#SZ:150').".jpg";
			return $logo; 
		}

	//GET DATA LABEL ?
		function get_data_label($nim)
		{
			$mhs = $this->get_data_mhs($nim);
			$prodi = $mhs[0]['KD_PRODI'];
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_sistem/data_search',
					'POST',
					array(
						'api_kode'		=> 101006,
						'api_subkode'	=> 1,
						'api_search'	=> array(date('d/m/Y') , $prodi)
					)
			);

			return $data;
		}

	//GET KOP SKPI
		function get_kop_skpi($nim)
		{
			$negara = $this->get_info_negara();
			$kementerian = $this->get_kementerian();

			$data['IDN'] = strtoupper($kementerian[0]['UNIT_NAMA'].' '.$negara[0]['NM_SEBUTAN']);
			$data['EN'] = strtoupper($kementerian[0]['UNIT_NAMA_ENG']).' OF '.strtoupper($negara[0]['NM_NEGARA_ENG']);
			return $data;
		}

	//GET KD TA $ KD SMT LULUS
		function get_kode_ta($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'/sia_mahasiswa/data_search',
					'POST',
					array(
						'api_kode'		=> 30000,
						'api_subkode'	=> 2,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

	//GET INFO KEMENTERIAN
		function get_kementerian()
		{
			// 
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/index.php/simpeg_public/simpeg_mix/data_search',
					'POST',
					array(
						'api_kode'		=> 1901,
						'api_subkode'	=> 2,
						'api_search'	=> array(date('d/m/Y'), 'UK000001')
					)
			);

			return $data;
		}

	//GET INFO NEGARA
		function get_info_negara()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SIA.'sia_sistem/data_search',
					'POST',
					array(
						'api_kode'		=> 101014,
						'api_subkode'	=> 1,
						'api_search'	=> array(date('d/m/Y'), '62')
					)
			);

			return $data;
		}

	//GET DATA PESERTA WISUDA
		function get_peserta_wisuda($prodi, $periode)
		{
			// $temp = $this->get_tahun_angkatan();
			// $jml_data = count($temp);
			// for ($i=0; $i < $jml_data; $i++) { 
			// 	$angkatan[$i] = $temp[($jml_data-1) - $i]['ANGKATAN'];
			// }

			// $index=0;
			// $peserta = array();
			// for ($i=0; $i < $jml_data; $i++) { 
			// 	$mhs = $this->get_univ('mhs', $prodi, $angkatan[$i]);
			// 	foreach ($mhs as $key) {
			// 		$nim = $key['NIM'];
			// 		$tgl_wisuda = $this->get_wisuda_mhs($nim);

			// 		$temp = explode(' ', $tgl_wisuda[0]['TANGGAL']);
			// 		$temp = explode('/', $temp[0]);
			// 		$temp =$temp[1].'/'.$temp[0].'/'.$temp[2];

			// 		$tgl_indo = $this->date_indo($temp);
			// 		$tgl_indo = explode(' ', $tgl_indo);
			// 		$tgl_indo = $tgl_indo[1].' '.$tgl_indo[2];

			// 		if(strtoupper($tgl_indo)==strtoupper($periode)){
			// 			$peserta[$index] = $key;
			// 			$index++;
			// 		}

			// 	}
			// }

			// return $peserta;

			$data_prodi = $this->get_data_prodi($prodi);
			$kd_jur = $data_prodi[0]['KD_JURUSAN'];

			$peserta = $this->peserta_wisuda($periode, $prodi, $kd_jur);
			return $peserta;
		}

	//GET DATA ACUAN WISUDA
		function get_wisuda_mhs($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service.uin-suka.ac.id/servwisuda/wisuda_public/wisuda_mhs/get',
					'POST',
					array(
						'api_kode'		=> 1001,
						'api_subkode'	=> 101,
						'api_search'	=> array($nim)
					)
			);
			
			return $data;
		}

	//GET TAHUN AKADEMIK WISUDA
		function get_tahun_wisuda()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service.uin-suka.ac.id/servwisuda/wisuda_public/wisuda_admin/get',
					'POST',
					array(
						'api_kode'		=> 9999,
						'api_subkode'	=> 20,
						'api_search'	=> array('')
					)
			);
			
			return $data;
		}

	//GET PERIODE WISUDA DARI TAHUN
		function get_periode_wisuda($ta_id)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service.uin-suka.ac.id/servwisuda/wisuda_public/wisuda_admin/get',
					'POST',
					array(
						'api_kode'		=> 9999,
						'api_subkode'	=> 33,
						'api_search'	=> array($ta_id)
					)
			);
			
			return $data;
		}

	//GET TAHUN AKADEMIK SIA
		function get_tahun_sia()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service.uin-suka.ac.id/servsiasuper/sia_public/sia_krs/data_view',
					'POST',
					array(
						'api_kode'		=> 50000,
						'api_subkode'	=> 3,
						'api_search'	=> array()
					)
			);
			
			return $data;
		}

	//GET TAHUN ANGKATAN
		function get_tahun_angkatan()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service.uin-suka.ac.id/servsiasuper/sia_public/sia_mahasiswa/data_view',
					'POST',
					array(
						'api_kode'		=> 26000,
						'api_subkode'	=> 3,
						'api_search'	=> array()
					)
			);
			
			return $data;
		}

	//GET INFO TOEC, IKLA, ICT
		function get_sertifikasi_uin($nim)
		{
			$rule 	= $this->get_pengaturan_penulisan_aktif();
			$i = 0;
			$data = array();
			if($rule){
				foreach ($rule as $key) {
					if($key['kode'] == 'ICT'){
						$ict = $this->get_ict($nim);
						if($ict){
							$ict['NAMA_IDN'] = $key['nama_idn'].' '.$key['unit_idn'];
							$ict['NAMA_EN'] = $key['nama_en'].' '.$key['unit_en'];
							$data[$i] = $ict; $i++;
						}
					} else if ($key['kode'] == 'IKLA'){
						$ikla = $this->get_ikla($nim);
						if($ikla){
							$ikla['NAMA_IDN'] = $key['nama_idn'].' '.$key['unit_idn'];
							$ikla['NAMA_EN'] = $key['nama_en'].' '.$key['unit_en'];
							$data[$i] = $ikla; $i++;
						}
					} else if ($key['kode'] == 'TOEC'){
						$toec = $this->get_toec($nim);
						if($toec){
							$toec['NAMA_IDN'] = $key['nama_idn'].' '.$key['unit_idn'];
							$toec['NAMA_EN'] = $key['nama_en'].' '.$key['unit_en'];
							$data[$i] = $toec; $i++;
						}
					}
				}
			}

			// $ict 	= $this->get_ict($nim);
			// $ikla 	= $this->get_ikla($nim);
			// $toec 	= $this->get_toec($nim);

			// $data = array();
			// $i = 0;
			// if($ict){
			// 	$data[$i] = $ict;
			// 	$i++;
			// }

			// if($ikla){
			// 	$data[$i] = $ikla;
			// 	$i++;
			// }

			// if($toec){
			// 	$data[$i] = $toec;
			// 	$i++;
			// }

		 	return $data;
		}

	//GET TOEC/IKLA

	//GET ICT
		function get_ict($nim)
		{
			// 
			$CI =& get_instance();
			$temp = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servict/index.php/ict_public/ict_sertifikasi/select_04',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 5,
						'api_search'	=> array($nim)
					)
			);

			$data = false;

			if($temp){
				$univ = $this->get_data_universitas();
				$dlabel = $this->get_data_label($nim);
				$uin  = $univ[0]['NM_SEBUTAN_S2'].' '.$univ[0]['NM_PT'].' '.$dlabel[0]['PTN_NM_KAB2'];

				$data = array(
					'ID_RIWAYAT' 	=> 'UIN'.$nim.'ICT',
					'NAMA_IDN'		=> 'ICT '.$uin,
					'NAMA_EN'		=> 'ICT '.$uin,
					'PENYELENGGARA'	=> $uin,
					'NILAI'		=> $temp['NILAI']
				);		
			}

			return $data;

		}

	//GET IKLA
		function get_ikla($nim)
		{
			$CI =& get_instance();
			$temp = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servtoec/index.php/pbba_public/toec_basic/get_jadwal',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 3,
						'api_search'	=> array('riwayat', 'sr_ar', $nim)
					)
			);

			$data = false;

			if($temp){
				$univ = $this->get_data_universitas();
				$dlabel = $this->get_data_label($nim);
				$uin  = $univ[0]['NM_SEBUTAN_S2'].' '.$univ[0]['NM_PT'].' '.$dlabel[0]['PTN_NM_KAB2'];

				$data = array(
					'ID_RIWAYAT' 	=> 'UIN'.$nim.'IKLA',
					'NAMA_IDN'		=> 'IKLA '.$uin,
					'NAMA_EN'		=> 'IKLA '.$uin,
					'PENYELENGGARA'	=> $uin,
					'NILAI'		=> $temp[0]['NIL_ANGKA']
				);		
			}


		 	return $data;
		}

	//GET TOEC
		function get_toec($nim)
		{
			$CI =& get_instance();
			$temp = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servtoec/index.php/pbba_public/toec_basic/get_jadwal',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 3,
						'api_search'	=> array('riwayat', 'sr_en', $nim)
					)
			);

			$data = false;

			if($temp){
				$univ = $this->get_data_universitas();
				$dlabel = $this->get_data_label($nim);
				$uin  = $univ[0]['NM_SEBUTAN_S2'].' '.$univ[0]['NM_PT'].' '.$dlabel[0]['PTN_NM_KAB2'];

				$data = array(
					'ID_RIWAYAT' 	=> 'UIN'.$nim.'TOEC',
					'NAMA_IDN'		=> 'TOEC '.$uin,
					'NAMA_EN'		=> 'TOEC '.$uin,
					'PENYELENGGARA'	=> $uin,
					'NILAI'		 	=> $temp[0]['NIL_ANGKA']
				);		
			}


		 	return $data;
		}




//--------------------------------------------------------------------------------

	//LIBRARY LAIN LAIN
	//KONVERSI KE TANGGAL INDONESIA
		function date_indo($tanggal='')
		{
			if($tanggal==''){
				$tanggal=date('d-m-Y');
			}

			$temp = array(
				'01' => 'Januari',
				'02' => 'Februari',
				'03' => 'Maret',
				'04' => 'April',
				'05' => 'Mei',
				'06' => 'Juni',
				'07' => 'Juli',
				'08' => 'Agustus',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'November',
				'12' => 'Desember'
			);

			$tgl = date('d-m-Y', strtotime($tanggal));
			$tgl = explode('-', $tgl);
			$tgl[1] = $temp[$tgl[1]];
			$tgl = implode(' ', $tgl);

			return $tgl; 
		}

	//KONVERSI KE FORMAT TANGGAL SISTEM
		function date_db($tanggal='')
		{
			$data = false;
			if($tanggal==''){
				$data = false;
			}else{

				$temp = array(
					'JANUARI' => '01',
					'FEBRUARI' => '02',
					'MARET' => '03',
					'APRIL' => '04',
					'MEI' => '05',
					'JUNI' => '06',
					'JULI' => '07',
					'AGUSTUS' => '08',
					'SEPTEMBER' => '09',
					'OKTOBER' => '10',
					'NOVEMBER' => '11',
					'DESEMBER' => '12',
				);

				$tgl = explode(' ', $tanggal);
				$tgl[1] = $temp[strtoupper($tgl[1])];

				$tgl = $tgl[1].'/'.$tgl[0].'/'.$tgl[2];

				$data = date('Y-m-d', strtotime($tgl));
			}

			return $data;
		}


	//CEK HAK AKSES 
	function cek_allowed($allowed)
		{
			$who = false;
			$CI =& get_instance();
			$jabatan = $CI->session->userdata('jabatan');

			$jabatan = explode('#', $jabatan);
			for ($i=0; $i < count($jabatan); $i++) { 
				$jabatan[$i] = substr($jabatan[$i], 0, 5);
			}
			$allowed = explode('#', $allowed);

			$result = array_intersect($allowed, $jabatan);

			if(count($result)>0){
				$who = $result;
			}
			
			return $who;
		}

	//HAK AKSES UNTUK FAKULTAS
		function akses_fakultas()
		{
			$CI =& get_instance();
			$akses = $this->cek_allowed('SKPI1'); //'SKPI1';
			if($akses){
				$list_unit = array();
				$index 	   = 0;
				$jabatan =  $CI->session->userdata('jabatan');  // 'SKPI1UN02006'; 'SKPI1UN02006';  //
				$jabatan = explode('#', $jabatan);
				for ($i=0; $i < count($jabatan); $i++) { 
					if(substr($jabatan[$i], 0, 5) == 'SKPI1'){
						$list_unit[$index] = str_replace('SKPI1', '', $jabatan[$i]);
						$index++;
					}
				}

				//akses unit
				// $data_unit = array();
				// for ($i=0; $i < count($list_unit); $i++) { 
				// 	$data_unit[$i] = $this->get_data_unit($list_unit[$i]);
				// }
				$kode_fak = array();
				for ($i=0; $i < count($list_unit); $i++) { 
					//$data_unit[$i] = $this->unit_to_kode($list_unit[$i]);
					$kode_fak[$i] = $this->unit_to_kode($list_unit[$i]);
				}

				//get_kode_fakultas
				// $kode_fak = array();
				// $index = 0;
				// $data_fakultas = $this->get_univ('fak');
				// foreach ($data_fakultas as $key) {
				// 	for ($i=0; $i < count($data_unit); $i++) { 
				// 		if(strtoupper($key['NM_FAK']) == strtoupper($data_unit[$i]['UNIT_NAMA_S1'])){
				// 			$kode_fak[$index] = $key['KD_FAK'];
				// 			$index++;
				// 		}
				// 	}
				// }

				return $kode_fak;				

			}else{
				return false;
			}
		}
	//HAK AKSES UNTUK PRODI / JURUSAN
		function akses_prodi()
		{
			$CI =& get_instance();
			$akses = $this->cek_allowed('SKPI2#SKPI3#SKPI4'); //true;
			if($akses){
				$list_unit = array();
				$index 	   = 0;
				$jabatan = $CI->session->userdata('jabatan'); //'SKPI2UA000009';//
				$jabatan = explode('#', $jabatan);
				$temp_akses = array('SKPI2', 'SKPI3', 'SKPI4');
				for ($i=0; $i < count($jabatan); $i++) { 
					if(substr($jabatan[$i], 0, 5) == 'SKPI2' || substr($jabatan[$i], 0, 5) == 'SKPI3' || substr($jabatan[$i], 0, 5) == 'SKPI4'){
						$list_unit[$index] = str_replace($temp_akses, '', $jabatan[$i]);
						$index++;
					}
				}

				//akses unit
				$data_unit = array();
				for ($i=0; $i < count($list_unit); $i++) { 
					$data_unit[$i] = $this->unit_to_kode($list_unit[$i]);
				}

				//get_kode_fakultas
				$kode_fak = array();
				$kode_prodi = array();
				$idx = 0;
				$index = 0;
				$data_fakultas = $this->get_univ('fak');
				foreach ($data_fakultas as $key) {
					$data_prodi = $this->get_univ('prod', $key['KD_FAK']);
					$jml_prodi = 0;
					foreach($data_prodi as $keys) {
						for ($i=0; $i < count($data_unit); $i++) { 
							if(strtoupper($keys['KD_PRODI']) == $data_unit[$i]){
									$kode_prodi[$index] = $keys['KD_PRODI'];
									$index++;
									$jml_prodi++;
							}
						}
					}

					if($jml_prodi > 0){
						$kode_fak[$idx] = $key['KD_FAK'];
						$idx++;
					}
				}
				// //*/akses unit
				// $data_unit = array();
				// for ($i=0; $i < count($list_unit); $i++) { 
				// 	$data_unit[$i] = $this->get_data_unit($list_unit[$i]);
				// }

				// //get_kode_fakultas
				// $kode_fak = array();
				// $kode_prodi = array();
				// $idx = 0;
				// $index = 0;
				// $data_fakultas = $this->get_univ('fak');
				// foreach ($data_fakultas as $key) {
				// 	$data_prodi = $this->get_univ('prod', $key['KD_FAK']);
				// 	$jml_prodi = 0;
				// 	foreach($data_prodi as $keys) {
				// 		for ($i=0; $i < count($data_unit); $i++) { 
				// 			if(strtoupper($keys['NM_PRODI']) == strtoupper($data_unit[$i]['UNIT_NAMA_S1'])){
				// 					$kode_prodi[$index] = $keys['KD_PRODI'];
				// 					$index++;
				// 					$jml_prodi++;
				// 			}
				// 		}
				// 	}

				// 	if($jml_prodi > 0){
				// 		$kode_fak[$idx] = $key['KD_FAK'];
				// 		$idx++;
				// 	}
				// }*/

				$data = array('fak' => $kode_fak, 'prodi' => $kode_prodi);

				return $data;				

			}else{
				return false;
			}
		}

	//CEK STATUS ID RIWAYAT
		function cek_id_riwayat($id_riwayat)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 10,
						'api_search'	=> array($id_riwayat)
					)
			);

			return $data;
		}

	//AI NOMER SERI
		function ai_no_seri()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 11,
						'api_search'	=> array()
					)
			);

			return $data[0]['ai'];
		}

	//SET NOMOR SERI
		function noseri()
		{
			$nomer = 'SKP00000'.$this->ai_no_seri();
			return $nomer;
		}

	//UPDATE NOMOR SERI
		function update_noseri($nim, $noseri)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 3,
						'api_search'	=> array($nim, $noseri)
					)
			);

			return $data;
		}

	//BATAL DAFTAR SKPI
		function batal_daftar_verifikasi($nim, $keterangan)
		{
			$keterangan = "BATAL_DAFTAR#".$keterangan;
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 4,
						'api_search'	=> array($nim, $keterangan)
					)
			);

			return $data;
		}

	//EVALUASI LABEL YANG DIGUNAKAN TIAP PRODI SAAT PROSES SIMPAN
		function evaluasi_label_prodi($kd_prodi, $id_l, $label) // $label = array hasil seleksi checkbox oleh admin
		{
			$sys_label = $this->get_label(1500, 4, array($id_l));
			$i=0;
			$sys_id_ld = array();
			foreach ($sys_label as $key) {
				$sys_id_ld[$i] = $key['id_ld'];
				$i++;
			}

			$unused = array_diff($sys_id_ld, $label);

			foreach($unused as $key => $value){
				//cek dulu apakah sudah ada apa belum di sistem, jika sudah ada maka do nothing; jika belum ada maka disimpan di sistem
				$temp = $this->cek_unused_label($kd_prodi, $value);
				if($temp==0){
					$tmp = $this->insert_unused_label($kd_prodi, $value);
				}
			}

			foreach($label as $key => $value){
				//cek dulu, jika data tersimpan di sistem, maka akan dihapus
				$temp = $this->cek_unused_label($kd_prodi, $value);
				if($temp==1){
					$tmp = $this->delete_unused_label($kd_prodi, $value);
				}
			}

			return null;

		}

	//GET LABEL KONTEK BASED ON KD_PRODI DAN ID_L
		function get_label_prodi($kd_prodi, $id_l)
		{
			$label = $this->get_label(1500, 4, array($id_l));
			$i = 0;
			$data = array();
			foreach ($label as $key) {
				$status_label = $this->cek_unused_label($kd_prodi, $key['id_ld']);
				if($status_label==0){ //0 adalah jika label dipakai, sedangkan 1 jika label tidak dipakai
					$key['check'] = 'checked';
				}else{
					$key['check'] = '';
				}
				$data[$i] = $key;
				$i++;
			}

			return $data;
		}

	//FUNCTION GET UNUSED LABEL PRODI BY ID LABEL
		function get_json_unused_label($kd_prodi, $id_l)
		{
			$label = $this->get_label(1500, 4, array($id_l));
			$i = 0;
			$data = array();
			foreach ($label as $key) {
				$status_label = $this->cek_unused_label($kd_prodi, $key['id_ld']);
				if($status_label==1){
					$data[$i] = $key['id_ld']; 
					$i++;
				}
			}

			$data = json_encode($data);
			return $data;
		}

	//FUNGSI UNTUK MENDAPATKAN STATUS LABEL MHS SAAT DICETAK
		function get_status_label_cetak_mhs($id_ld, $unused_label_json)
		{
			$unused = json_decode($unused_label_json);
			$status = 1;
			for ($i=0; $i < count($unused); $i++) { 
				if($unused[$i]==$id_ld){
					$status=0;
				}
			}
			return $status;
		}

	//CEK LABEL NON AKTIF ATAU TIDAK
		function cek_unused_label($kd_prodi, $id_ld)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 9,
						'api_search'	=> array($kd_prodi, $id_ld)
					)
			);

			if($data){ $value = 1; } else { $value = 0; }
			return $value;
		}

	//SIMPAN LABEL YANG TIDAK AKAN DIPAKAI TIAP PRODI
		function insert_unused_label($kd_prodi, $id_ld)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/simpan',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 3,
						'api_search'	=> array($kd_prodi, $id_ld)
					)
			);

			return $data;
		}

	//HAPUS LABEL YANG TIDAK AKAN DIPAKAI TIAP PRODI
		function delete_unused_label($kd_prodi, $id_ld)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/hapus',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 2,
						'api_search'	=> array($kd_prodi, $id_ld)
					)
			);

			return $data;
		}

	//AUTO CEK DAN UPDATE MASA BERLAKU LABEL 
		function auto_update_label()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 4,
						'api_search'	=> array()
					)
			);

			return $data;
		}

	//CEK APAKAH ADA LABEL YANG BERSTATUS AKTIF
		function cek_label_aktif()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 2,
						'api_search'	=> array()
					)
			);

			if($data){
				$temp = 1;
			}else{
				$temp = 0;
			}

			return $temp;
		}

	//AMBIL PESERTA WISUDA TIAP PRODI
		function peserta_wisuda($id_per, $kd_prodi, $kd_jur)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service.uin-suka.ac.id/servwisuda/wisuda_public/wisuda_admin/get',
					'POST',
					array(
						'api_kode'		=> 9999,
						'api_subkode'	=> 24,
						'api_search'	=> array($id_per, $kd_prodi, $kd_jur)
					)
			);

			$peserta = array();
			$i=0;
			if($data){
				foreach ($data as $key) {
					$mhs = $this->get_data_mhs($key['WIS_NIM']);
					foreach ($mhs as $keys) {
						$peserta[$i] = $keys;
						$i++;
					}
				}
			}
			return $peserta;
		}

	// TEST AMBIL KODE DARI UNIT
		function unit_to_kode($kd_unit)
		{
			$tanggal = date('d/m/Y');

			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/index.php/simpeg_public/simpeg_mix/data_search',
					'POST',
					array(
						'api_kode'		=> 1901,
						'api_subkode'	=> 4,
						'api_search'	=> array($tanggal, $kd_unit)
					)
			);

			return $data[0]['SIA_KODE'];

		}

		function test_status_skpi($nim)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 12,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

		function get_kode_penulisan($kode = null)
		{
			$CI =& get_instance();
			if($kode == null){
				$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 10,
						'api_search'	=> array()
					)
				);
			}else{
				$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 14,
						'api_search'	=> array($kode)
					)
				);
			}
			

			return $data;
		}

		function get_kode_penulisan_by_status($status)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 15,
						'api_search'	=> array($status)
					)
				);
			return $data;
		}

		function insert_kode_penulisan($kode, $keterangan, $status)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/simpan',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 4,
						'api_search'	=> array($kode, $keterangan, $status)
					)
				);
			return $data;
		}

		function insert_pengaturan_penulisan($kode, $nama_id, $nama_en, $unit_id, $unit_en, $urutan, $status)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/simpan',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 5,
						'api_search'	=> array($kode, $nama_id, $nama_en, $unit_id, $unit_en, $urutan, $status)
					)
				);
			return $data;
		}

		function update_kode_penulisan($old_kode, $kode, $keterangan, $status)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 5,
						'api_search'	=> array($old_kode, $kode, $keterangan, $status)
					)
				);
			return $data;
		}

		function update_pengaturan_penulisan($id_ps, $kode, $nama_id, $nama_en, $unit_id, $unit_en, $urutan, $status)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/update',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 6,
						'api_search'	=> array($id_ps, $kode, $nama_id, $nama_en, $unit_id, $unit_en, $urutan, $status)
					)
				);
			return $data;
		}

		function delete_kode_penulisan($old_kode)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/hapus',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 3,
						'api_search'	=> array($old_kode)
					)
				);
			return $data;
		}


		function get_pengaturan_penulisan($id_ps = null)
		{
			$CI =& get_instance();
			if($id_ps == null){
				$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 11,
						'api_search'	=> array()
					)
				);
			}else{
				$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 16,
						'api_search'	=> array($id_ps)
					)
				);
			}
			

			return $data;
		}

		function get_pengaturan_penulisan_aktif()
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_label/lihat',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 12,
						'api_search'	=> array('1')
					)
			);

			return $data;
		}

		function get_jab_fun($nip)
		{
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					'http://service2.uin-suka.ac.id/servsimpeg/simpeg_public/simpeg_mix/data_search',
					'POST',
					array(
						'api_kode'		=> 1122,
						'api_subkode'	=> 3,
						'api_search'	=> array(date('d-m-Y'),$nip,1)
					)
			);

			return $data;
		}

		function lib_testing($nim)
		{
			$nim = '13651060';
			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/cek',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 12,
						'api_search'	=> array($nim)
					)
			);

			return $data;
		}

		function hapus_skpi_mhs($nim)
		{
			$CI =& get_instance();

			$prestasi 	= $this->delete_prestasi('nim', $nim);
			$organisasi	= $this->delete_organisasi('nim', $nim);
			$sertifikasi= $this->delete_sertifikasi('nim', $nim);
			$magang 	= $this->delete_magang('nim', $nim);
			$karakter 	= $this->delete_karakter('nim', $nim);
			$cp 		= $this->delete_cp('nim', $nim);
			$data = false;
			if($prestasi && $organisasi && $sertifikasi && $magang && $karakter&& $cp){
				$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/hapus',
					'POST',
					array(
						'api_kode'		=> 1500,
						'api_subkode'	=> 14,
						'api_search'	=> array($nim)
					)
				);
			}

			return $data;			
		}


		function skpi(){
			$data = array(
				'Surat Keterangan Pendamping Ijazah',
				'Surat Ket. Pendamping Ijazah',
				'SKPI'
			);

			return $data;
		}


		function log_batal_daftar($nim, $nip, $keterangan){
			$skpi = $this->get_skpi_mhs($nim);
			$tgl_daftar = $skpi['tgl_daftar'];

			$CI =& get_instance();
			$data = $CI->s00_lib_api->get_api_json(
					URL_API_SKPI.'/skpi_basic/log_batal_daftar',
					'POST',
					array(
						'api_search'	=> array($nim, $nip, $tgl_daftar, $keterangan)
					)
			);

			return $data;


		}

		function format_nip($str = ''){
			return substr($str,0,8).' '.substr($str,8,6).' '.substr($str,14,1).' '.substr($str,15,3);
		}

		function cek_penulisan_dpm($id='', $en=''){
			$status = 1;
			if($id == '' || $id =='-' || strtoupper($id) == 'TIDAK ADA' || $id == NULL){
				if($en == '' || $en == '-' || strtoupper($en) == 'TIDAK ADA' || $en == NULL){
					//do nothing, soalnya kemungkinan mahasiswa memang tidak memiliki data untuk kelengkapan SKPI (*pengalaman pribadi :( ) 
				}else{
					$status = 0;
				}
			}else{
				//cek penulisan dalam bahasa inggris :
				if($en == '' || $en == '-' || strtoupper($en) == 'TIDAK ADA' || $en == NULL){
					$status = 0;
				}
			}

			return $status;
		}

		function cek_syarat_penulisan($nim){
			$status = 1;

			//prestasi :
			$temp = $this->get_data_prestasi($nim);
			if($temp){
				foreach ($temp as $dpm) {
					$tmp_p = $this->cek_penulisan_dpm($dpm['NM_LOMBA'], $dpm['NM_LOMBA2']);
					if($tmp_p == 0){
						$status = 0;
					}
				}
			}

			//organisasi :
			$temp = $this->get_data_organisasi($nim);
			if($temp){
				foreach ($temp as $dpm) {
					$tmp_p = $this->cek_penulisan_dpm($dpm['NM_ORGANISASI'], $dpm['NM_ORGANISASI2']);
					if($tmp_p == 0){
						$status = 0;
					}
				}
			}

			//sertifikasi :
			$temp = $this->get_data_sertifikasi($nim);
			if($temp){
				foreach ($temp as $dpm) {
					$tmp_p = $this->cek_penulisan_dpm($dpm['NM_KEGIATAN'], $dpm['NM_KEGIATAN2']);
					if($tmp_p == 0){
						$status = 0;
					}
				}
			}

			//magang :
			$temp = $this->get_data_magang($nim);
			if($temp){
				foreach ($temp as $dpm) {
					$tmp_p = $this->cek_penulisan_dpm($dpm['NM_KEGIATAN'], $dpm['NM_KEGIATAN2']);
					if($tmp_p == 0){
						$status = 0;
					}
				}
			}

			//karakter :
			$temp = $this->get_data_karakter($nim);
			if($temp){
				foreach ($temp as $dpm) {
					$tmp_p = $this->cek_penulisan_dpm($dpm['NM_KEGIATAN'], $dpm['NM_KEGIATAN2']);
					if($tmp_p == 0){
						$status = 0;
					}
				}
			}

			return $status;
		}




	
}