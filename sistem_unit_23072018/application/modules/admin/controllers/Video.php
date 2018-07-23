<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {
public $data 	= 	array();
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
   		$this->db->where(array('kode_unit' => $this->session->userdata('kode_unit'), 'url' => 'video'));
   		$data['status'] = $this->db->get('menu')->num_rows();
		$data['title']="Video";
		$data['json_url']=site_url('admin/video/menu_json');
		$data['main_view']="admin/video/data_video";
		$this->load->view('admin/content',$data);
   }
 
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
       	 $this->datatables->select("m1.id_video as id_video, m1.judul as judul, substring(m1.ringkasan,1,130) as ringkasan, m1.isi as isi, m1.url as url, m1.tgl_posting as tgl_posting")
        ->add_column('action', '$1','m1.id_video')
        ->from("video as m1")->where('kode_unit', $kode_unit);
        echo $this->datatables->generate();
    }
	function add_video(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Input Video";
			$data['main_view']="admin/video/menu_form";
			$this->load->view('admin/content',$data);
			
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$judul=$this->input->post('judul');
			$kode_bahasa=$this->input->post('bahasa');
			$ringkasan=htmlentities($this->input->post('ringkasan'));
			$isi=htmlentities($this->input->post('isi'));
			$url=$this->input->post('url');
			$temp_tgl_posting = $this->input->post('tanggal_post');
			parse_str( parse_url( $url, PHP_URL_QUERY ), $kd_url );
			if(empty($kd_url)){
				$this->session->set_flashdata('error', 'URL yang Anda masukkan salah!');
				redirect('admin/video/add_video');
			}
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
						'judul'=>$judul,
						'ringkasan'=>$ringkasan,
						'isi'=>$isi,
						'url'=>$url,
						'kode_bahasa'=>$kode_bahasa,
						'tgl_posting'=>$tgl_posting,
						/* 'menu_order'=>$mo->cur_order */
						);
			$qi=$this->db->insert('video',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/video');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data = $this->data;
			$data['video'] = $this->page_model->get_video2($id);
			$data['title']="Edit Video";
			$data['main_view']="admin/video/edit_video";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit = $this->session->userdata('kode_unit');
				$judul=$this->input->post('judul');
				$bahasa=$this->input->post('bahasa');
				$ringkasan=htmlentities($this->input->post('ringkasan'));
				$isi=htmlentities($this->input->post('isi'));
				$url=$this->input->post('url');
				$tgl_posting = date('Y-m-d h:i:s');
				parse_str( parse_url( $url, PHP_URL_QUERY ), $kd_url );
				if(empty($kd_url)){
					$this->session->set_flashdata('error', 'URL yang Anda masukkan salah!');
					redirect('admin/video/edit/'.$id);
				}
				$data = array(
				  		'kode_unit'=>$kode_unit,
						'judul'=>$judul,
						'ringkasan'=>$ringkasan,
						'isi'=>$isi,
						'url'=>$url,
						'kode_bahasa'=>$bahasa,
						'tgl_posting'=>$tgl_posting,
				);
				
			if($this->db->where('id_video',$id)->update('video',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/video/index');
			}
		}			
	}
	function delete($id=""){
		$this->db->where('id_video',$id)->delete('video');
		//unlink(base_url().'/media/gambar/'.$id);
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
		redirect('admin/video/index');
	}
 
}
 
/* End of file video.php */
