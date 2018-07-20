<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		$this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		$this->load->model('admin/page_model');
		is_logged_in();
	}
 
   public function index($uri=0){
   		$this->db->where(array('kode_unit' => $this->session->userdata('kode_unit'), 'url' => 'album'));
   		$data['status'] = $this->db->get('menu')->num_rows();

		$data['title']="Album";
		$data['json_url']=site_url('admin/album/menu_json');
		$data['main_view']="admin/album/data_album";
		$this->load->view('admin/content',$data);
   }

	function menu_json(){
		$kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("id_album, judul, tgl_posting")
	        ->add_column('action', '$1', 'id_album')
	        ->from("album")->where('kode_unit', $kode_unit);
        $this->db->order_by("tgl_posting", "desc");
        echo $this->datatables->generate();

    }

	function add_album(){
		if($_POST==null){
			$data['title']="Input Album";
			$data['parent']=$this->db->get_where('menu',array('parent'=>0))->result();
			$data['main_view']="admin/album/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$judul_album = $this->input->post('judul_album');
			$kode_bahasa = $this->input->post('kode_bahasa');
			$ringkasan = htmlentities($this->input->post('ringkasan'));
			$tanggal_post = $this->input->post('tanggal_post');

			if($tanggal_post != ''){
				$tmp_t = explode('/',$tanggal_post);
				$tmp_abc = $tmp_t[0];
				$tmp_t[0] = $tmp_t[2];
				$tmp_t[2] = $tmp_abc;

				$tmp_t = implode('-', $tmp_t);
				$curr_time = date('H:i:s');

				$tgl_posting = $tmp_t.' '.$curr_time;
			}else{
				$tgl_posting = date('Y-m-d H:i:s');
			}
			
			$data = array(
						'kode_unit' => $kode_unit,
						'kode_bahasa' => $kode_bahasa,
						'judul' => $judul_album,
						'ringkasan' => $ringkasan,
						'tgl_posting' => $tgl_posting,
						'counter' => 0
					);
			$qi = $this->db->insert('album', $data);
			if($qi){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));				
				redirect('admin/album');
			}
		}	
	}
 
	function edit($id=""){
		if($_POST==NULL) {
			$data['album'] = $this->page_model->get_album($id);
			$data['title']="Edit Album";
			$data['main_view']="admin/album/edit_album";
			$this->load->view('admin/content',$data);
		}else{	
			$kode_bahasa = $this->input->post('kode_bahasa');
			$judul = $this->input->post('judul');
			$ringkasan = $this->input->post('ringkasan');
				
			$data = array(
			  'kode_bahasa' => $kode_bahasa,
			  'judul' => $judul,
			  'ringkasan' => $ringkasan
			);
					
			if($this->db->where('id_album', $id)->update('album', $data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/album');
			}
			else {
				$this->session->set_flashdata('msg', array('danger', 'Data gagal diperbaharui'));
				redirect('admin/album');
			}
		}			
	}

	function delete($id=""){
		$this->db->where('id_album', $id)->delete('foto');
		$this->db->where('id_album', $id)->delete('album');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
		redirect('admin/album');
	}
 
}