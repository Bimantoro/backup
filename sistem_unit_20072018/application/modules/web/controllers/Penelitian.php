<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penelitian extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->helper('page');
		$this->load->library('pagination');
		$this->load->library('breadcrumb');
		$this->load->library('S00_lib_api');
		$this->load->model('web/page_model');
		$this->lang = $this->page_lib->lang();
	}
 
   public function index($uri=0){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda', $this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Penelitian', $this->lang)), '/');
		$limit=20;
		$data['penelitian'] = $this->page_model->get_arsip_penelitian($limit,$uri)->result_array();
		$penelitian = $data['penelitian'];
		$temp1 = array();
		$temp2 = array();
		$temp3 = array();
		$utama = array();
		foreach ($penelitian as $x=>$pt) {
			// print_r($pt['peneliti_utama']);
			if (strlen($pt['peneliti_utama'])==18) {
				$api_url 	= URL_API_SIMPEG1.'simpeg_mix/data_search';
				$parameter 	= array('api_kode' => 2001, 'api_subkode' => 3, 'api_search' => array($pt['peneliti_utama']));
				$data_staff = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
				if (!empty($pt['peneliti_utama'])) {
					$utama[$x] = $data_staff[0]['NM_PGW_F'];				
				}
			}else{
				$data_mhss = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_mahasiswa/data_search', 'POST', 
				array('api_kode'=>26000, 'api_subkode' => 7, 'api_search' => array($pt['peneliti_utama'])));
				if (!empty($pt['peneliti_utama'])) {
					$utama[$x]=ucwords(strtolower($data_mhss[0]['NAMA']));
				}	
			}
			$anggota = $this->db->query("select * from peneliti where id_penelitian = '".$pt['id_penelitian']."'")->result_array();
			foreach ($anggota as $z=>$ag) {
				if ($ag['status']=='dosen/staf') {
					$api_url 	= URL_API_SIMPEG1.'simpeg_mix/data_search';
					$parameter 	= array('api_kode' => 2001, 'api_subkode' => 3, 'api_search' => array($ag['anggota']));
					$data_staff = $this->s00_lib_api->get_api_json($api_url,'POST',$parameter);
					if (!empty($ag['anggota'])) {
						$temp1[$x][$z] = $data_staff[0]['NM_PGW_F'];				
					}
				}else if($ag['status']=='mhs'){
						$data_mhss = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_mahasiswa/data_search', 'POST', 
						array('api_kode'=>26000, 'api_subkode' => 7, 'api_search' => array($ag['anggota'])));
						if (!empty($ag['anggota'])) {
							$temp2[$x][$z]=ucwords(strtolower($data_mhss[0]['NAMA']));
						}
				}else{
						$temp3[$x][] = ucwords(strtolower($ag['anggota']));
					if (empty($ag['anggota'])) {
						$temp3[$x][]=[];
					}
				}
			}
		}
				
		for ($i=0; $i <count($penelitian) ; $i++) { 
			if (isset($temp1[$i]) && isset($temp2[$i]) && isset($temp3[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp1[$i]).' ;<br>'.implode(' ;<br>',$temp2[$i]).' ;<br>'.implode(' ;<br>', $temp3[$i]);
			}
			else if (isset($temp1[$i]) && isset($temp2[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp1[$i]).' ;<br>'.implode(' ;<br>',$temp2[$i]);
			}else if (isset($temp1[$i]) && isset($temp3[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp1[$i]).' ;<br>'.implode(' ;<br>',$temp3[$i]);
			}else if (isset($temp2[$i]) && isset($temp3[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp2[$i]).' ;<br>'.implode(' ;<br>',$temp3[$i]);
			}else if (isset($temp1[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp1[$i]);
			}else if (isset($temp2[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp2[$i]);
			}else if (isset($temp3[$i])) {
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ;<br> '.implode(' ;<br>',$temp3[$i]);
			}else{
				$data['penelitian'][$i]['anggota'] = '<b>'.$utama[$i].'</b> ';
			}
		}
		$data['main_view']="web/penelitian/arsip_view";
		$this->load->view('web/content',$data);
   }
 
}
 
/* End of file penelitian.php */
