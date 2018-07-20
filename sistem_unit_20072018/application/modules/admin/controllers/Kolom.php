<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kolom extends CI_Controller {

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
		$data['title']="Kolom";
		$data['json_url']=site_url('admin/kolom/menu_json');
		$data['main_view']="admin/kolom/data_kolom";
		$this->load->view('admin/content',$data);
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("kolom",array('id_kolom'=>$id));
		$berita = $get_data->row();
		if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Berita', site_url('page/kolom'));
			$this->breadcrumb->append_crumb(substr($berita->judul,0,130).' ...', '/');
			$data['title']=$berita->judul;
			$this->page_model->page_counter($id,'kolom');
			
			$data['kolom'] = $this->page_model->generate_detail_berita($id);
			
			$arr_filter=array();
			$arr_filter=related_text($berita->judul);	
			$filter	="WHERE id_kolom <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_berita,judul,tanggal,jam from berita ".$filter." ORDER BY tanggal desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_berita,judul,tanggal,jam from berita ORDER BY counter desc LIMIT 0,5")->result();
			
	
			$data['content']="page/kolom/detail_view";
				
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
				
		}else{
	      	redirect(base_url());
		}
   }
   function menu_json(){
	    $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_kolom id_kolom,m1.judul judul,m1.isi isi,concat(substring(m1.ringkasan,1, 30),'...') as ringkasan, m1.tgl_posting tgl_posting")
        ->add_column('action', '$1','m1.id_kolom')
        ->from("kolom as m1")->where('kode_unit', $kode_unit);

        $this->db->order_by("id_kolom", "desc");
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_kolom(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Input Kolom";
			$data['main_view']="admin/kolom/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$kode_bahasa = $this->input->post('bahasa');
			$judul=$this->input->post('judul');
			$bahasa=$this->input->post('bahasa');
			$ringkasan=htmlentities($this->input->post('ringkasan'));
			$isi=htmlentities($this->input->post('isi'));
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
			$data=array(
						'kode_unit'=>$kode_unit,
						'judul'=>$judul,
						'kode_bahasa'=>$bahasa,
						'isi'=>$isi,
						'ringkasan'=>$ringkasan,
						'tgl_posting'=>$tgl_posting,
						);
			$qi=$this->db->insert('kolom',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/kolom');
			}
		}	
	}
	function edit($id){
		if($_POST==NULL) {
			$data=$this->data;
			$data['kolom']=$this->page_model->get_kolom($id);
			$data['title']="Edit Kolom";
			$data['main_view']="admin/kolom/edit_kolom";
			$this->load->view('admin/content',$data);
		}else{	
				$judul= $this->input->post('judul');
				$kode_bahasa = $this->input->post('bahasa');
				// $deskripsi_foto = $this->input->post('deskripsi_foto');
				$ringkasan = htmlentities($this->input->post('ringkasan'));
				$isi = htmlentities($this->input->post('isi'));
				/*if(($_FILES["photo"]["type"] == "image/png") or ($_FILES["photo"]["type"] == "image/jpeg") or ($_FILES["photo"]["type"] == "image/pjpeg")){
					$filename=$_FILES['photo']['name'];
					$vdir_upload = "./files/berita/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["photo"]["tmp_name"],"./media/news/" . $_FILES["photo"]["name"]);
					$im_src = imagecreatefromjpeg($vfile_upload);
					$src_width = imageSX($im_src);
					$src_height = imageSY($im_src);
					$dst_width = 550;
					$dst_height = ($dst_width/$src_width)*$src_height;
					$im = imagecreatetruecolor($dst_width,$dst_height);
					imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
					$photo= $filename;
					imagejpeg($im,$vdir_upload .$photo);
				}
				if($photo !=null){
				$data = array(
				  'judul'=>$judul,
				  'isi'=>$isi,
				  'ringkasan'=>$ringkasan,
				  'foto'=>$photo,
				  'deskripsi_foto'=>$deskripsi_foto,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>date('Y-m-d H:i:s')
				);
				}else{*/
				$data = array(
				  'judul'=>$judul,
				  'isi'=>$isi,
				  'ringkasan'=>$ringkasan,
				  // 'deskripsi_foto'=>$deskripsi_foto,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>date('Y-m-d H:i:s')
				);
				/*}*/
						
			if($this->db->where('id_kolom',$id)->update('kolom',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/kolom/index');
			};
		}			
	}
	function delete($id=""){
		$this->db->where('id_kolom',$id)->delete('kolom');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
		redirect('admin/kolom/index');
	}
   function feed(){  
        $data['feed_name'] = 'Kolom';  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/berita/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['berita'] = $this->page_model->get_feed_berita(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('berita/rss_berita', $data);  
    }   

}
 
/* End of file berita.php */
