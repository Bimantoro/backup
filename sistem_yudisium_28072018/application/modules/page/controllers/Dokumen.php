<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dokumen extends CI_Controller {

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
 	$this->db->where(array('kode_unit' => $this->session->userdata('kode_unit'), 'url' => 'dokumen'));
   		$data['status'] = $this->db->get('menu')->num_rows();

		$data['title']="Dokumen";
		$data['json_url']=site_url('admin/dokumen/menu_json');
		$data['main_view']="admin/dokumen/data_dokumen";
		$this->load->view('admin/content',$data);
   }
 
   public function detail($id=0){
      $get_data = $this->db->get_where("agenda",array('id_agenda'=>$id));
      $agenda = $get_data->row();
	  if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Agenda', site_url('page/agenda'));
			$this->breadcrumb->append_crumb(substr($agenda->nama_agenda,0,130).' ...', '/');
			$data['title']=$agenda->nama_agenda;
			$this->page_model->page_counter($id,'agenda');
		
			$data['agenda'] = $this->page_model->get_detail_agenda($id);
				$arf=explode(".",$agenda->lampiran);
				$ext= strtolower(end($arf));
				$arr_ext=array('pdf','jpg','png');
				if(in_array($ext,$arr_ext)){
					$data['ext']=$ext;
				}
					$data['filetype']=$ext;
			
			
			$arr_filter=array();
			$arr_filter=related_text($agenda->nama_agenda);	
			$filter	="WHERE id_agenda <> '".$id."' AND  (nama_agenda LIKE '%".rtrim(implode("%' OR nama_agenda LIKE '%",$arr_filter)," OR nama_agenda LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_agenda,nama_agenda,tgl_posting,post_jam from agenda ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_agenda,nama_agenda,tgl_posting,post_jam from agenda ORDER BY counter desc LIMIT 0,5")->result();
		
			$data['content']="page/agenda/detail_view";
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
			
      }else{
	      	redirect(base_url());
      }
    }
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_dokumen as id_dokumen,m1.nama_dokumen as nama_dokumen,m1.tahun as tahun,m1.nama_file as nama_file, m1.tgl_posting as tgl_posting")
        ->add_column('action', '$1','m1.id_dokumen')
        ->from("dokumen as m1")->where('kode_unit', $kode_unit);
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_dokumen(){
		if($_POST==null){
			$data['title']="Input Dokumen";
			$data['parent']=$this->db->get_where('menu',array('parent'=>0))->result();
			$data['main_view']="admin/dokumen/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$nama_dokumen=$this->input->post('nama_dokumen');
			$tahun=$this->input->post('tahun');
			$bahasa=$this->input->post('bahasa');
			$temp_tgl_posting = $this->input->post('tanggal_post');

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
			
			$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['nama_file']['name'];
			if ($_FILES['nama_file']['size']==0) {
				$this->session->set_flashdata('error','File tidak boleh kosong atau lebih dari 2 MB!');
				redirect('admin/dokumen/add_dokumen');
			}else{
			move_uploaded_file($_FILES["nama_file"]["tmp_name"],"./media/dokumen_akademik/".$filename);
			$data=array(
						'kode_unit'=>$kode_unit,
						'nama_dokumen'=>$nama_dokumen,
						'kode_bahasa'=>$bahasa,
						'tahun'=>$tahun,
						'nama_file'=>$filename,
						'tgl_posting'=>$tgl_posting
						);
			$qi=$this->db->insert('dokumen',$data);
			if($qi){				
				redirect('admin/dokumen');
			}
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['dokumen'] = $this->page_model->get_dokumen($id);
			$data['title']="Edit Dokumen";
			$data['main_view']="admin/dokumen/edit_dokumen";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit = $this->session->userdata('kode_unit');
				$nama_dokumen = $this->input->post('nama_dokumen');
				$tahun= $this->input->post('tahun');
				$kode_bahasa= $this->input->post('bahasa');
				$tgl_posting = date('Y-m-d h:i:s')
				;$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['nama_file']['name'];
				move_uploaded_file($_FILES["nama_file"]["tmp_name"],"./media/dokumen_akademik/".$filename);
					
				if($filename != null){
				$data = array(
				  'kode_unit'=>$kode_unit,
				  'nama_dokumen'=>$nama_dokumen,
				  'tahun'=>$tahun,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>$tgl_posting,
				  'nama_file'=>$filename
				);
				}else{
				$data = array(
				  'kode_unit'=>$kode_unit,
				  'nama_dokumen'=>$nama_dokumen,
				  'tahun'=>$tahun,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>$tgl_posting,
				  'nama_file'=>$filename
				);
				}
					
			if($this->db->where('id_dokumen',$id)->update('dokumen',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/dokumen/index');
			}
		}			
	}
	function delete($id=""){
		$this->db->where('id_dokumen',$id)->delete('dokumen');
		//unlink(base_url().'/media/gambar/'.$id);
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
		redirect('admin/dokumen/index');
	}
   function feed(){  
        $data['feed_name'] = 'Dokumen';  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/agenda/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['agenda'] = $this->page_model->get_feed_agenda(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('agenda/rss_agenda', $data);  
    }   
 
}
 
/* End of file agenda.php */
