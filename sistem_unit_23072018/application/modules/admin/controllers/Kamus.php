<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kamus extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		$this->load->library(array('Datatables'));
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
		$data['title']="Master Kamus Kata";
		$data['json_url']=site_url('admin/kamus/menu_json');
		$data['main_view']="admin/kamus/data_kamus";
		$this->load->view('admin/content',$data);
   }
 
	
	function menu_json(){
        $this->datatables->select("id_kamus as id, m1.kata as kata, m1.kode_bahasa as kode, m1.terjemahan as terjemahan")
        ->add_column('action', '$1','id')
        ->from("kamus as m1");
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_kamus(){
		if($_POST==null){
			$data['title']="Input Data Kamus";
			$data['main_view']="admin/kamus/menu_form";
			$data['units'] = $this->page_model->get_units();
			$this->load->view('admin/content',$data);
		}else{
			$id 			= $this->input->post('kata');
			$opt 			= $this->input->post('opt');
			$terjemahan	 	= $this->input->post('terjemahan');

			$status = $this->page_model->cek_kamus(strtolower($id), $opt);
			if(empty($status)){
				$data = array(
					'kata' => strtolower($id),
					'kode_bahasa' => $opt,
					'terjemahan' => strtolower($terjemahan)
				);

				$q = $this->db->insert('kamus', $data);
				if($q){
					$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
					redirect('admin/kamus');
				}else{
					$this->session->set_flashdata('msg', array('danger', 'Data Gagal disimpan'));
					redirect('admin/kamus');
				}
			}else{
				$this->session->set_flashdata('msg', array('danger', "Kata '".$id."' sudah tersimpan sebelumnya !"));
					redirect('admin/kamus');
			}

			

		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['kamus'] = $this->page_model->get_kamus($id);
			$data['title']="Edit Data Kamus";
			$data['main_view']="admin/kamus/edit_kamus";
			$this->load->view('admin/content',$data);
		}else{

			$kode 			= $this->input->post('kode'); 		
			$old_id 		= $this->input->post('oldkata');
			$old_opt 		= $this->input->post('oldopt');

			$id 			= $this->input->post('kata');
			$opt 			= $this->input->post('opt');
			$terjemahan	 	= $this->input->post('terjemahan');

			$status = $this->page_model->cek_kamus(strtolower($id), $opt);
			if($old_id == $id || empty($status)){
				$data = array(
					'kata' => strtolower($id),
					'kode_bahasa' => $opt,
					'terjemahan' => strtolower($terjemahan)
				);
						
				if($this->db->where('id_kamus',$kode)->update('kamus',$data)){
					$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
					redirect('admin/kamus/index');
				}else{
					$this->session->set_flashdata('msg', array('alert', 'Data gagal diperbaharui'));
					redirect('admin/kamus/index');
				}
			}else{
				$this->session->set_flashdata('msg', array('danger', "Kata '".$id."' sudah tersimpan sebelumnya !"));
					redirect('admin/kamus');
			}

			
		}			
	}

	function delete($id=""){
		$q = $this->db->where('id_kamus', $id)->delete('kamus'); 
		if($q){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/kamus/index');
		}else{
			$this->session->set_flashdata('msg', array('alert', 'Data gagal dihapus'));
				redirect('admin/kamus/index');
		}
		
	}
	
}
 
/* End of file pengumuman.php */
