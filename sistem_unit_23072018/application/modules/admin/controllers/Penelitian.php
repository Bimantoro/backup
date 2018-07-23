<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penelitian extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		$this->load->library(array('Datatables'));
		$this->load->library('S00_lib_api');
		$this->load->helper('ckeditor');
		$this->load->model('admin/page_model');
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
	 	$this->db->where(array('kode_unit' => $this->session->userdata('kode_unit'), 'url' => 'penelitian'));
   		$data['status'] = $this->db->get('menu')->num_rows();

		$data['title']="Penelitian";
		$data['json_url']=site_url('admin/penelitian/menu_json');
		$data['main_view']="admin/penelitian/data_penelitian";
		$this->load->view('admin/content',$data);
   }
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_penelitian as id_penelitian, m1.judul_penelitian as judul_penelitian, m1.jenis_penelitian as jenis_penelitian, m1.tahun as tahun,CONCAT(substring(m1.url,1,30),'...') as url, m1.tgl_posting as tgl_posting")
        ->add_column('action', '$1','m1.id_penelitian')
        ->from("penelitian as m1")->where('kode_unit', $kode_unit);
        $this->db->order_by("id_penelitian", "desc");
        echo $this->datatables->generate();
    }
	function add_penelitian(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Input Penelitian";
			$data['main_view']="admin/penelitian/menu_form";
			$this->load->view('admin/content',$data);
			
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$judul_penelitian=$this->input->post('judul_penelitian');
			$jenis_penelitian=$this->input->post('jenis_penelitian');
			$kode_bahasa=$this->input->post('bahasa');
			$url=$this->input->post('url');
			$tahun=$this->input->post('tahun');
			$temp_tgl_posting = $this->input->post('tanggal_post');
			$petugas = $this->session->userdata('username');
			$anggota1=$this->input->post('anggota1');
			$anggota2=$this->input->post('anggota2');
			$anggota3=$this->input->post('anggota3');
			$utama1=$this->input->post('utama1');
			$utama2=$this->input->post('utama2');
			$peneliti = $utama1.$utama2;
			if ($peneliti == '') {
				$this->session->set_flashdata('error', '<b>Peneliti Utama</b>tidak boleh kosong!');
				redirect('admin/penelitian/add_penelitian');
			}
			$alamat = substr($url, 0,12);
			// if($alamat != 'https://www.'){
			// 	$this->session->set_flashdata('error', 'URL yang Anda masukkan salah! Gunakan "https://www.(URL Anda)"');
			// 	redirect('admin/penelitian/add_penelitian');
			// }
			if($temp_tgl_posting != ''){
				// conver tanggal : 			
				$tmp_t = explode('/',$temp_tgl_posting);
				$tmp_abc = $tmp_t[0];
				$tmp_t[0] = $tmp_t[2];
				$tmp_t[2] = $tmp_abc;

				$tmp_t = implode('-', $tmp_t);
				$curr_time = date('H:i:s');

				$tgl_posting = $tmp_t.' '.$curr_time;
			}else{
				$tgl_posting = date('Y-m-d H:i:s');
			}
						$data=array(
						'kode_unit'=>$kode_unit,
						'kode_bahasa'=>$kode_bahasa,
						'judul_penelitian'=>$judul_penelitian,
						'jenis_penelitian'=>$jenis_penelitian,
						'tahun'=>$tahun,
						'url'=>$url,
						'petugas'=>$petugas,
						'tgl_posting'=>$tgl_posting,
						'peneliti_utama'=>$peneliti
						/* 'menu_order'=>$mo->cur_order */
						);
			$qi=$this->db->insert('penelitian',$data);
			$id_penelitian = $this->db->query("select max(id_penelitian) as id from penelitian")->result();

			$a1 = explode('<$>', $anggota1);
			$x= count($a1);
			for ($i=0; $i <$x; $i++) { 
				if(!empty($a1[$i])){
					$data = array(
						'id_penelitian'=>$id_penelitian[0]->id,
						'anggota'=>$a1[$i],
						'status'=>'dosen/staf'
					);
					$this->db->insert('peneliti',$data);
				}
			}
			$a2 = explode('<$>', $anggota2);
			$x2= count($a2);
			for ($i=0; $i <$x2; $i++) { 
				if(!empty($a2[$i])){
					$data = array(
						'id_penelitian'=>$id_penelitian[0]->id,
						'anggota'=>$a2[$i],
						'status'=>'mhs'
					);
					$this->db->insert('peneliti',$data);
				}
			}
			
			$a3 = explode(';', $anggota3);
			$x3= count($a3);
			for ($i=0; $i <$x3; $i++) { 
				if(!empty($a3[$i])){
					$data = array(
						'id_penelitian'=>$id_penelitian[0]->id,
						'anggota'=>$a3[$i],
						'status'=>'lain'
					);
					$this->db->insert('peneliti',$data);
				}
			}
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/penelitian');
			}

		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['penelitian'] = $this->page_model->get_penelitian($id);
			$anggota1 = $this->page_model->get_peneliti($id);
			$data['title']="Edit penelitian";
			$data['main_view']="admin/penelitian/edit_penelitian";
			$temp=array();
			$temp2=array();
			$temp3=array();
			$utama1=array();
			$utama2=array();
			$peneliti_utama = $data['penelitian'][0]->peneliti_utama;
			
			if (strlen($data['penelitian'][0]->peneliti_utama)==18) {
				$api_url 	= URL_API_SIMPEG1.'simpeg_mix/data_search';
				$parameter 	= array('api_kode' => 2001, 'api_subkode' => 3, 'api_search' => array($peneliti_utama));
				$data_staff = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
				if (!empty($peneliti_utama)) {
					$utama1[$peneliti_utama]=$data_staff[0]['NM_PGW_F'].' ('.$peneliti_utama.')';
				}
			}else{
				$data_mhss = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_mahasiswa/data_search', 'POST', 
				array('api_kode'=>26000, 'api_subkode' => 7, 'api_search' => array($peneliti_utama)));
				if (!empty($peneliti_utama)) {
					$utama2[$peneliti_utama]=ucwords(strtolower($data_mhss[0]['NAMA'])).' ('.$peneliti_utama.')';
				}
			}
			foreach ($anggota1 as $ag) {
				if ($ag['status']=='dosen/staf') {
					$api_url 	= URL_API_SIMPEG1.'simpeg_mix/data_search';
					$parameter 	= array('api_kode' => 2001, 'api_subkode' => 3, 'api_search' => array($ag['anggota']));
					$data_staff = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
					if (!empty($ag['anggota'])) {
						$temp[$ag['anggota']]=$data_staff[0]['NM_PGW_F'].' ('.$ag['anggota'].')';
					}
				}else if($ag['status']=='mhs'){
						$data_mhss = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_mahasiswa/data_search', 'POST', 
						array('api_kode'=>26000, 'api_subkode' => 7, 'api_search' => array($ag['anggota'])));
						if (!empty($ag['anggota'])) {
							$temp2[$ag['anggota']]=ucwords(strtolower($data_mhss[0]['NAMA'])).' ('.$ag['anggota'].')';
						}
				}else{
					$temp3[] = $ag['anggota'];
				}
			}
			$data['utama1']=$utama1;
			$data['utama2']=$utama2;
			$data['anggota1']=$temp;
			$data['anggota2']=$temp2;
			$data['anggota3']=implode('; ', $temp3);
			$this->load->view('admin/content',$data);
		}else{	
			$kode_unit = $this->session->userdata('kode_unit');
			$judul_penelitian=$this->input->post('judul_penelitian');
			$jenis_penelitian=$this->input->post('jenis_penelitian');
			$kode_bahasa=$this->input->post('bahasa');
			$url=$this->input->post('url');
			$tahun=$this->input->post('tahun');
			$temp_tgl_posting = $this->input->post('tanggal_post');
			$petugas = $this->session->userdata('username');
			$anggota1=$this->input->post('anggota1');
			$anggota2=$this->input->post('anggota2');
			$anggota3=$this->input->post('anggota3');
			$utama1=$this->input->post('utama1');
			$utama2=$this->input->post('utama2');
			$peneliti = $utama1.$utama2;
			if ($peneliti == '') {
				$this->session->set_flashdata('error', '<b>Peneliti Utama</b> tidak boleh kosong!');
				redirect('admin/penelitian/edit/'.$id);
			}
			// $alamat = substr($url, 0,12);
			// if($alamat != 'https://www.'){
			// 	$this->session->set_flashdata('error', 'URL yang Anda masukkan salah! Gunakan "https://www.(URL Anda)"');
			// 	redirect('admin/penelitian/edit/'.$id);
			// }
			if($temp_tgl_posting != ''){
				// conver tanggal : 			
				$tmp_t = explode('/',$temp_tgl_posting);
				$tmp_abc = $tmp_t[0];
				$tmp_t[0] = $tmp_t[2];
				$tmp_t[2] = $tmp_abc;

				$tmp_t = implode('-', $tmp_t);
				$curr_time = date('H:i:s');

				$tgl_posting = $tmp_t.' '.$curr_time;
			}else{
				$tgl_posting = date('Y-m-d H:i:s');
			}

			$data2=array(
				'kode_unit'=>$kode_unit,
				'kode_bahasa'=>$kode_bahasa,
				'judul_penelitian'=>$judul_penelitian,
				'jenis_penelitian'=>$jenis_penelitian,
				'tahun'=>$tahun,
				'url'=>$url,
				'petugas'=>$petugas,
				'tgl_posting'=>$tgl_posting,
				'peneliti_utama'=>$peneliti

				/* 'menu_order'=>$mo->cur_order */
			);

			$this->db->where('id_penelitian',$id)->delete('peneliti');

			$a1 = explode('<$>', $anggota1);
			$x= count($a1);
			for ($i=0; $i <$x; $i++) { 
				if(!empty($a1[$i])){
					$data = array(
						'id_penelitian'=>$id,
						'anggota'=>$a1[$i],
						'status'=>'dosen/staf'
					);
					$this->db->insert('peneliti',$data);
				}
			}
			$a2 = explode('<$>', $anggota2);
			$x2= count($a2);
			for ($i=0; $i <$x2; $i++) { 
				if(!empty($a2[$i])){
					$data = array(
						'id_penelitian'=>$id,
						'anggota'=>$a2[$i],
						'status'=>'mhs'
					);
					$this->db->insert('peneliti',$data);
				}
			}
			
			$a3 = explode(';', $anggota3);
			$x3= count($a3);
			for ($i=0; $i <$x3; $i++) { 
				if(!empty($a3[$i])){
					$data = array(
						'id_penelitian'=>$id,
						'anggota'=>$a3[$i],
						'status'=>'lain'
					);
					$this->db->insert('peneliti',$data);
				}
			}

			if($this->db->where('id_penelitian',$id)->update('penelitian',$data2)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/penelitian/index');
			}
		}			
	}
	function delete($id=""){
		$this->db->where('id_penelitian',$id)->delete('penelitian');
		$this->db->where('id_penelitian',$id)->delete('peneliti');
		//unlink(base_url().'/media/gambar/'.$id);
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
		redirect('admin/penelitian/index');
	}
	
	function get_dosen(){
		if(ISSET($_GET['q'])){
			$q = strtoupper(str_replace("'", "''",  $_GET['q']));
			$tot = count(str_split($q));
			if($tot > 1){
				$api_url 	= URL_API_SIMPEG1.'simpeg_mix/data_search';
				$parameter 	= array('api_kode' => 2001, 'api_subkode' => 3, 'api_search' => array($q));
				$data = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);	
				/*$url = 'tnde_public'; #simpeg_mix/data_search, 2001/3, api_search = array(kata_search);
				$parameter = array('api_kode' => 4004, 'api_subkode' => 2, 'api_search' => array($q));
				$data = $this->mdl_skripsi->get_api_surat($url.'/tnde_pegawai/get_pegawai', 'json', 'POST', $parameter);*/
				$new_data = array();
				foreach ($data as $dt){
					$new_data[] = array('id' =>	$dt->KD_PGW, 
										'name'	=>	$dt->NM_PGW_F.' ('.$dt->KD_PGW.')');
				}
				echo json_encode($new_data);
			}
		}
	}
	
	function get_mhs(){
		if(ISSET($_GET['q'])){
			$q = strtoupper(str_replace("'", "''", $_GET['q']));
			$tot = count(str_split($q));
			if($tot > 1){
				$api_url 	= URL_API_SIA.'sia_mahasiswa/data_search';
				$parameter 	= array('api_kode' => 26000, 'api_subkode' => 2, 'api_search' => array($q));
				$data = $this->s00_lib_api->get_api_jsob($api_url,'POST',$parameter);	
				/*$url = 'tnde_public'; #simpeg_mix/data_search, 2001/3, api_search = array(kata_search);
				$parameter = array('api_kode' => 4004, 'api_subkode' => 2, 'api_search' => array($q));
				$data = $this->mdl_skripsi->get_api_surat($url.'/tnde_pegawai/get_pegawai', 'json', 'POST', $parameter);*/
				$new_data = array();
				foreach ($data as $dt){
					$new_data[] = array('id' =>	$dt->NIM, 'name'	=>	$dt->NAMA.' ('.$dt->NIM.')');
				}
				echo json_encode($new_data);
			}
		}
	}
}
 
/* End of file agenda.php */
