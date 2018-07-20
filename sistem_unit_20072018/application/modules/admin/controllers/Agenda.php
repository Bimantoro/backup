<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda extends CI_Controller {

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
		$data['title']="Agenda";
		$data['json_url']=site_url('admin/agenda/menu_json');
		$data['main_view']="admin/agenda/data_agenda";
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
        $this->datatables->select("m1.id_agenda id_agenda,m1.nama_agenda nama_agenda,concat(substring(m1.deskripsi,1, 30),'...') as deskripsi,m1.tempat tempat,m1.tgl_mulai tgl_mulai, m1.tgl_selesai tgl_selesai,m1.tgl_posting tgl_posting")
        ->add_column('action', '$1','m1.id_agenda')
        ->from("agenda as m1")->where('kode_unit', $kode_unit);
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_agenda(){
		if($_POST==null){
			$data=$this->data;
			$ruang=$this->page_model->get_api('simar_general/cari_ruang', 'json', 'POST', array('api_kode'=>1001, 'api_subkode'=>2));
			//$ruang = null;
			$data['ruang'] = $ruang;
			$data['title']="Input Agenda";
			/* $data['parent']=$this->db->get_where('menu',array('parent'=>0))->result(); */
			$data['main_view']="admin/agenda/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$nama_agenda=$this->input->post('nama_agenda');
			/* $url=$this->input->post('url'); */
			$bahasa=$this->input->post('bahasa');
			/* $parent=$this->input->post('parent'); */
			$deskripsi=$this->input->post('deskripsi');
			$ruang1= $this->input->post('ruang');
			$tempat=$this->input->post('tempat');
			$tgm=$this->input->post('tgl_mulai');
			$tgs=$this->input->post('tgl_selesai');
			$tgp=$this->input->post('tgl_posting');
			$jp = $this->input->post('jam_posting');
			$jm = $this->input->post('jam_mulai');
			$js = $this->input->post('jam_selesai');


			$tmp_tgm = explode('/', $tgm);
			$tmp_tgs = explode('/', $tgs);
			

			$tmp_ = $tmp_tgm[0];
			$tmp_tgm[0] = $tmp_tgm[2];
			$tmp_tgm[2] = $tmp_;

			$tgm = implode('-', $tmp_tgm);

			$tgl_mulai = $tgm.' '.$jm.':00';

			$tmp_ = $tmp_tgs[0];
			$tmp_tgs[0] = $tmp_tgs[2];
			$tmp_tgs[2] = $tmp_;

			$tgs = implode('-', $tmp_tgs);

			$tgl_selesai = $tgs.' '.$js.':00';

			if($tgp != null || $tgp != ''){
					$tmp_tgp = explode('/', $tgp);
				$tmp_ = $tmp_tgp[0];
				$tmp_tgp[0] = $tmp_tgp[2];
				$tmp_tgp[2] = $tmp_;

				$tgp = implode('-', $tmp_tgp);

				$tgl_posting = $tgp.' '.date('H:i:s');
			}else{
				$tgl_posting = date('Y-m-d H:i:s');
			}
			



			// $tgl_mulai= date(''.$tgm.' '.$jm.'');
			// $tgl_selesai= date(''.$tgs.' '.$js.'');
			// $tgl_posting= date(''.$tgp.' '.$jp.'');
			// $tgl_posting= date($tgl_posting);
			// $tgl_mulai= date($tgl_mulai);
			// $tgl_selesai= date($tgl_selesai);
			$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['nama_file']['name'];
			move_uploaded_file($_FILES["nama_file"]["tmp_name"],"./media/gambar/".$filename);
			$data=array(
						'kode_unit'=>$kode_unit,
						'nama_agenda'=>$nama_agenda,
						'kode_bahasa'=>$bahasa,
						'deskripsi'=>$deskripsi,
						'kode_ruang'=>$ruang1,
						'tempat'=>$tempat,
						'tgl_mulai'=>$tgl_mulai,
						'tgl_selesai'=>$tgl_selesai,
						'lampiran'=>$filename,
						'tgl_posting'=>$tgl_posting,
						// 'tgl_posting'=>date('Y-m-d H:i:s'),
						);
			$qi=$this->db->insert('agenda',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/agenda');
			}
		}	
	}
	function edit($id){
		if($_POST==NULL) {
			$data['p'] = $this->page_model->get_agenda($id);
			$ruang=$this->page_model->get_api('simar_general/cari_ruang', 'json', 'POST', 
			array('api_kode'=>1001, 'api_subkode'=>2));
			$data['ruang'] = $ruang;
			$data['title']="Edit Agenda";
			$data['main_view']="admin/agenda/edit_agenda";
			$this->load->view('admin/content',$data);
		}else{
				$kode_unit = $this->session->userdata('kode_unit');
				$nama_agenda = $this->input->post('nama_agenda');
				$deskripsi = $this->input->post('deskripsi');
				$kode_bahasa= $this->input->post('bahasa');
				$ruang1= $this->input->post('ruang');
				$tempat=$this->input->post('tempat');
				$tgm=$this->input->post('tgl_mulai');
				$tgs=$this->input->post('tgl_selesai');
				$tgp=$this->input->post('tgl_posting');
				$jp = $this->input->post('jam_posting');
				$jm = $this->input->post('jam_mulai');
				$js = $this->input->post('jam_selesai');
				$tgl_mulai= date(''.$tgm.' '.$jm.'');
				$tgl_selesai= date(''.$tgs.' '.$js.'');
				$tgl_posting= date(''.$tgp.' '.$jp.'');
				$tgl_posting= date($tgl_posting);
				$tgl_mulai= date($tgl_mulai);
				$tgl_selesai= date($tgl_selesai);
				$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['nama_file']['name'];
				move_uploaded_file($_FILES["nama_file"]["tmp_name"],"./media/gambar/".$filename);
					
				if($filename != null){
				$data = array(
				  'kode_unit'=>$kode_unit,
						'nama_agenda'=>$nama_agenda,
						'kode_bahasa'=>$kode_bahasa,
						'deskripsi'=>$deskripsi,
						'kode_ruang'=>$ruang1,
						//'tempat'=>$tempat,
						'tgl_mulai'=>$tgl_mulai,
						'tgl_selesai'=>$tgl_selesai,
						'lampiran'=>$filename,
						'tgl_posting'=>$tgl_posting,
						// 'tgl_posting'=>date('Y-m-d H:i:s')
				);
				}else{
				$data = array(
				  'kode_unit'=>$kode_unit,
						'nama_agenda'=>$nama_agenda,
						'kode_bahasa'=>$kode_bahasa,
						'deskripsi'=>$deskripsi,
						'kode_ruang'=>$ruang1,
						//'tempat'=>$tempat,
						'tgl_mulai'=>$tgl_mulai,
						'tgl_selesai'=>$tgl_selesai,
						// 'tgl_posting'=>date('Y-m-d H:i:s')
				);
				}
					
			if($this->db->where('id_agenda',$id)->update('agenda',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/agenda/index');
			}
		}			
	}
	function delete($id=""){
		$this->db->where('id_agenda',$id)->delete('agenda');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/agenda/index');
	}
   function feed(){  
        $data['feed_name'] = 'Agenda';  
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
