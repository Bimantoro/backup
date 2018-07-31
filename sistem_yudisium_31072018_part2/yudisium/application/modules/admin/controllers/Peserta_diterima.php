<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_diterima extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		// $this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		// $this->load->model('admin/page_model');
		is_logged_in();
		$this->data['ckeditor'] = array(
			'id' 	=> 	'isi1',
			'path'	=>	'asset/ckeditor',
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"100%",	//Setting a custom width
				'height' 	=> 	'300px',	//Setting a custom height
			),	
		);
	}
 
   public function index($uri=0){
		$data['title']="Data Peserta Diterima";
		$data['json_url_peserta'] =site_url('admin/peserta_diterima/menu_json');
		$data['json_url_prodi'] =site_url('admin/peserta_diterima/ajax_get_prodi2');
		$data['json_url_kelas'] =site_url('admin/peserta_diterima/ajax_get_kelas');
		$data['json_url_pilihan'] =site_url('admin/peserta_diterima/ajax_current_pilihan');
		$data['fakultas'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_fakultas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		$data['jalur'] = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		$data['level']= $this->session->userdata('level');
		$data['akses_fakultas'] = $this->session->userdata('kd_fak');

		$data['main_view']="admin/peserta_diterima/data_peserta_diterima";
		$this->load->view('admin/content',$data);
   }

    function ajax_get_kelas(){
   		$jalur = $this->input->post('jalur');

   		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

   		if(!empty($data)){
   			echo json_encode($data);
   		}else{
   			echo '0';
   		}

   }

   function ajax_get_prodi2(){
   		$fak = $this->input->post('fak');
   		$jalur = $this->input->post('jalur');

   		// $fak = '6';
   		// $jalur = '82';

   		if($this->session->userdata('level') == 'Y000' || $this->session->userdata('level') == 'Y002'){
   			$data = $this->s00_lib_api->get_api_json(
				URL_API_YUD.'yud_public/get_master_prodi_fak_jalur',
			 	'POST',
			 	array(
			 		'api_search' => array($fak, $jalur)
			 	));
   		}else{

   			$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_prodi_multifak_jalur',
		 	'POST',
		 	array(
		 		'api_search' => array($this->session->userdata('kd_fak'), $jalur)
		 	));
   		}

   		if(!empty($data)){
				echo json_encode($data);
		}else{
			echo '0';
		}
   }

    function ajax_current_pilihan(){
   		$jalur = $this->input->post('jalur');

   		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_cfg_pilihan_aktif',
		 	'POST',
		 	array(
		 		'api_search' => array($jalur)
		 	));

   		if(!empty($data)){
   			echo json_encode($data);
   		}else{
   			echo '0';
   		}

   }

	
	function menu_json(){

		$prodi = $this->input->post('prodi');
		$kelas = $this->input->post('kelas');
		$tahun = $this->input->post('tahun');
		$jalur = $this->input->post('jalur');
		$gelombang = $this->input->post('gelombang');

		$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_data_peserta_diterima',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $gelombang, $jalur, $kelas, $prodi)
		 	));

		if(!empty($data)){
				echo json_encode($data);
		}else{
			echo '0';
		}
    }

    function ajax_get_prodi(){
    	$fak = $this->input->post('fak');

    	$data = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_prodi_by_fak',
		 	'POST',
		 	array(
		 		'api_search' => array($fak)
		 	));

    	if(!empty($data)){
    		echo json_encode($data);
    	}else{
			echo '0';
		}
    }

    function cetak_sk_yudisium($tahun, $gelombang, $jalur, $prodi){
    	$curr_pilihan = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gelombang)
		 	));

    	print_r($curr_pilihan);

    	if(!empty($curr_pilihan)){



    		$temp_prodi = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($prodi)
		 	));

		 	$data['prodi'] = $temp_prodi['nama_prodi'];
		 	$temp_master_kelas = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		 	$temp_peserta = array();
		 	$max_per_page = 18;

		 	foreach ($temp_master_kelas as $k) {
		 		$temp_p = $this->s00_lib_api->get_api_json(
					URL_API_YUD.'yud_public/get_data_peserta_diterima',
				 	'POST',
				 	array(
				 		'api_search' => array($tahun, $gelombang, $jalur, $k['kode_kelas'], $prodi)
				 	));
		 		if(!empty($temp_p)){
		 			// $temp_peserta[$k['kode_kelas']] = $temp_p;
		 			$temp_peserta[$k['kode_kelas']] = array_chunk($temp_p, $max_per_page);
		 		}
		 	}

		 	$data['peserta'] = $temp_peserta;



		 	$ttd = array();
		 	$ttd['tempat'] = $curr_pilihan['tempat_yudisium'].', '.$this->tgl_id(date('d/m/Y', strtotime($curr_pilihan['tgl_yudisium'])));
		 	$ttd['ketua'] = $curr_pilihan['ketua_yudisium'];

		 	$data['ttd'] = $ttd;

		 	$html = $this->load->view('admin/peserta_diterima/cetak_peserta_pdf', $data, true );

		 	$this->load->library('pdf');

			$this->pdf->SetSubject('Surat Keputusan Dewan Yudisium');
			$this->pdf->SetKeywords('Yudisium, SK, PDF, UIN');
			// $this->pdf->setPrintHeader(false);
			//$this->pdf->setPrintFooter(false);
			
			$this->pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
			$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			// set font yang digunakan

			$nomor = $curr_pilihan['no_yudisium'];
			$tanggal = $this->tgl_id(date('d/m/Y'), strtotime($curr_pilihan['no_yudisium']));
			$nm_jalur = $curr_pilihan['nama_jalur'];

			$this->pdf->InfoYudisium($nomor, $tanggal, $tahun, $gelombang, $nm_jalur);
			$this->pdf->SetFont('', '', 12);
			$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			// set margins
			$this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			// get the current page break margin
			// menambahkan halaman (harus digunakan minimal 1 kali)
			$this->pdf->AddPage('P', 'A4');
			// -- set new background ---
			$this->pdf->writeHTML($html, true, false, true, false, '');
 			$this->pdf->lastPage();
 			//nama file pdf
 			$namafile = 'SK_Yudisium_'.$tahun.'_Gelombang_'.$gelombang.'_'.$nm_jalur.'_'.$temp_prodi['nama_prodi'].'.pdf';
 			ob_end_clean();
			$this->pdf->Output($namafile, 'I');

		 	// echo '<pre>';
		 	// print_r($data);
		 	// echo '</pre>';


    	}else{
    		$this->index();
    	}
    }


    function cetak_sk_yudisium2($tahun, $gelombang, $jalur, $prodi){
    	$curr_pilihan = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_cfg_pilihan',
		 	'POST',
		 	array(
		 		'api_search' => array($tahun, $jalur, $gelombang)
		 	));

    	print_r($curr_pilihan);

    	if(!empty($curr_pilihan)){
    		$header   = array();
    		$header[] = "Lampiran";
    		$header[] = "Surat keputusan Dewan Yudisium";
    		$header[] = "Nomor ".$curr_pilihan['no_yudisium']." tanggal ". $this->tgl_id(date('d/m/Y', strtotime($curr_pilihan['tgl_yudisium'])));
    		$header[] = "Tentang Penerimaan Mahasiswa Baru UIN Sunan Kalijaga Yogyakarta";
    		$header[] = "Jalur ".$curr_pilihan['nama_jalur']." Gelombang ".$curr_pilihan['kode_gelombang']." Tahun ".$curr_pilihan['tahun'];

    		$data['header'] = $header;

    		$max_per_page = 10;

    		$temp_prodi = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_master_prodi',
		 	'POST',
		 	array(
		 		'api_search' => array($prodi)
		 	));

		 	$data['prodi'] = $temp_prodi['nama_prodi'];
		 	$temp_master_kelas = $this->s00_lib_api->get_api_json(
			URL_API_YUD.'yud_public/get_all_master_kelas',
		 	'POST',
		 	array(
		 		'api_search' => array()
		 	));

		 	$temp_peserta = array();

		 	foreach ($temp_master_kelas as $k) {
		 		$temp_p = $this->s00_lib_api->get_api_json(
					URL_API_YUD.'yud_public/get_data_peserta_diterima',
				 	'POST',
				 	array(
				 		'api_search' => array($tahun, $gelombang, $jalur, $k['kode_kelas'], $prodi)
				 	));
		 		if(!empty($temp_p)){
		 			$temp_peserta[$k['kode_kelas']] = array_chunk($temp_p, $max_per_page);
		 			// $temp_peserta[$k['kode_kelas']] = $temp_p;
		 		}
		 	}

		 	$data['peserta'] = $temp_peserta;



		 	$ttd = array();
		 	$ttd['tempat'] = 'Sleman, '.$this->tgl_id(date('d/m/Y', strtotime($curr_pilihan['tgl_yudisium'])));
		 	$ttd['ketua'] = $curr_pilihan['ketua_yudisium'];

		 	$data['ttd'] = $ttd;

		 	$html = $this->load->view('admin/peserta_diterima/cetak_pdf', $data, true );

		 	echo '<pre>';
		 	print_r($data);
		 	echo '</pre>';


    	}else{
    		$this->index();
    	}
    }

    function tgl_id($tgl){
    	$month = array('1' => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    	$tgl = explode('/', $tgl);
    	$tgl[1] = $month[(int) $tgl[1]];
    	$tgl = implode(' ', $tgl);
    	return $tgl;
    }

	// function add_prodi(){
	// 	if($_POST==null){
	// 		$data['title']="Input Data prodi";
	// 		$data['main_view']="admin/prodi/menu_form";

	// 		$data['fakultas'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_fakultas',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));

	// 	 	$data['jenjang'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_jenjang',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));

	// 		$this->load->view('admin/content',$data);
	// 	}else{
	// 		$kd_prodi 	= $this->input->post('kode');
	// 		$kd_fak 	= $this->input->post('fak');
	// 		$nm_prodi 	= $this->input->post('nama');
	// 		$jenjang 	= $this->input->post('jenjang');
		

	// 		$data = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/in_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($kd_prodi, $kd_fak, $nm_prodi, $jenjang)
	// 	 	));

	// 		if($data){
	// 			$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
	// 			redirect('admin/prodi');
	// 		}else{
	// 			$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
	// 			redirect('admin/prodi');
	// 		}
	// 	}	
	// }
	// function edit($id=""){
	// 	if($_POST==NULL) {

	// 		$data['fakultas'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_fakultas',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));

	// 	 	$data['jenjang'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_all_master_jenjang',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array()
	// 	 	));
		 	
	// 		$data['prodi'] = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/get_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($id)
	// 	 	));


	// 		$data['title']="Edit Data prodi";
	// 		$data['main_view']="admin/prodi/edit_prodi";
	// 		$this->load->view('admin/content',$data);
	// 	}else{	
	// 		$kd_prodi	= $this->input->post('kode');
	// 		$nm_prodi	= $this->input->post('nama');
	// 		$jenjang	= $this->input->post('jenjang');

	// 		$data = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/up_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($kd_prodi, $nm_prodi, $jenjang)
	// 	 	));

	// 		if($data){
	// 			$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
	// 			redirect('admin/prodi');
	// 		}else{
	// 			$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
	// 			redirect('admin/prodi');
	// 		}
	// 	}			
	// }

	// function delete($id=""){

	// 	$data = $this->s00_lib_api->get_api_json(
	// 		URL_API_YUD.'yud_public/del_master_prodi',
	// 	 	'POST',
	// 	 	array(
	// 	 		'api_search' => array($id)
	// 	 	));

	// 	if($data){
	// 		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
	// 		redirect('admin/prodi');
	// 	}else{
	// 		$this->session->set_flashdata('msg', array('danger', 'Data gagal dihapus'));
	// 		redirect('admin/prodi');
	// 	}

	// }
	
}
 
/* End of file pengumuman.php */
