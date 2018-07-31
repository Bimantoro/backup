<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Foto extends CI_Controller {
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
   public function index($id_album){
		$data['title']="Foto";
		$data['json_url']=site_url('admin/foto/menu_json/'.$id_album.'');
		$data['main_view']="admin/foto/data_foto";

		$this->load->view('admin/content',$data);
   }
   public function daftar($id_album){
		$data['title']="Foto";
		$data['json_url']=site_url('admin/foto/menu_json/'.$id_album.'');
		$data['main_view']="admin/foto/data_foto";
		$data['id_album'] = $id_album;
		$this->load->view('admin/content',$data);
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("foto",array('id_foto'=>$id));
		$berita = $get_data->row();
		if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('Berita', site_url('page/berita'));
			$this->breadcrumb->append_crumb(substr($berita->judul,0,130).' ...', '/');
			$data['title']=$berita->judul;
			$this->page_model->page_counter($id,'berita');
			
			$data['berita'] = $this->page_model->generate_detail_berita($id);
			
			$arr_filter=array();
			$arr_filter=related_text($berita->judul);	
			$filter	="WHERE id_berita <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			// $data['rec']=$this->db->query("SELECT id_berita,judul,tanggal,jam from berita ".$filter." ORDER BY tanggal desc LIMIT 0,5")->result();
			// $data['pop']=$this->db->query("SELECT id_berita,judul,tanggal,jam from berita ORDER BY counter desc LIMIT 0,5")->result();

			$data['rec']=$this->page_model->get_berita_terkait($filter, 0, 5);
			$data['pop']=$this->page_model->get_berita_terpopuler(0, 5);

			// print_r($data['pop']);
			// die();
			
	
			$data['content']="page/berita/detail_view";
				
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
				
		}else{
	      	redirect(base_url());
		}
   }
   function menu_json($id_album){

		$this->datatables->select("foto.id_foto as id_foto, foto.nama_file as nama_file, album.judul as judul, foto.id_album id_album")
        ->add_column('action', '$1','id_foto')
        ->join('album', 'foto.id_album = album.id_album')
        ->from("foto")->where('foto.id_album', $id_album);

        $this->db->order_by("id_foto", "desc");
        echo $this->datatables->generate();
    }
	function add_foto($id_album){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Input Foto";
			$data['main_view']="admin/foto/menu_form";
			$this->load->view('admin/content',$data);
			
		}else{
			$this->load->library('upload');
			$total = count($_FILES['upload']['name']);

			for($i=0;$i<$total;$i++){
				$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
				$kode_unit = $this->session->userdata('kode_unit');
				echo "<pre>";
				print_r($kode_unit);
				echo "<pre>";
				if($tmpFilePath!=''){
					$newFilePath = "./media/foto/".$kode_unit.'_'.date('Ymd')."_".$id_album."_".$_FILES['upload']['name'][$i];
					if(move_uploaded_file($tmpFilePath, $newFilePath)) {
						$data=array(
						'id_album'=>$id_album,
						'nama_file'=>$kode_unit.'_'.date('Ymd')."_".$id_album."_".$_FILES['upload']['name'][$i],
						);
						$qi=$this->db->insert('foto',$data);
						if($qi){
							$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
						}
				    }
				}
			}
			//die();
			redirect('admin/foto/daftar/'.$id_album);
		}	
	}
	private function set_upload_options()
		{   
		    //upload an image options
		    $config = array();
		    $config['upload_path'] = './media/foto/';
		    $config['allowed_types'] = 'jpeg|jpg|png';
		    $config['max_size']      = '0';
		    $config['overwrite']     = FALSE;
		    return $config;
		}
	function edit($id){
		if($_POST==NULL) {
			$data=$this->data;
			$data['berita']=$this->page_model->get_berita($id);
			$data['title']="Edit Berita";
			$data['main_view']="admin/berita/edit_berita";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit = $this->session->userdata('kode_unit');
				$judul= $this->input->post('judul');
				$kode_bahasa = $this->input->post('bahasa');
				$deskripsi_foto = $this->input->post('deskripsi_foto');
				//$ringkasan = htmlentities($this->input->post('ringkasan'));
				$isi = htmlentities($this->input->post('isi'));
				if(($_FILES["photo"]["type"] == "image/jpeg") or ($_FILES["photo"]["type"] == "image/pjpeg")){
					$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['photo']['name'];
					$vdir_upload = "./media/gambar/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["photo"]["tmp_name"],"./media/gambar/" .$filename);
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
				'kode_unit'=>$kode_unit,
				  'judul'=>$judul,
				  'isi'=>$isi,
				  //'ringkasan'=>$ringkasan,
				  'foto'=>$photo,
				  'deskripsi_foto'=>$deskripsi_foto,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>date('Y-m-d H:i:s')
				);
				}else{
				$data = array(
				'kode_unit'=>$kode_unit,
				  'judul'=>$judul,
				  'isi'=>$isi,
				  //'ringkasan'=>$ringkasan,
				  'deskripsi_foto'=>$deskripsi_foto,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>date('Y-m-d H:i:s')
				);
				}
						
			if($this->db->where('id_berita',$id)->update('berita',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/berita/index');
			};
		}			
	}
	function delete(){
		$id_album = $this->uri->segment('4');
		$id = $this->uri->segment('5');
		$this->db->where('id_foto',$id)->delete('foto');
		
		//unlink(base_url().'/media/gambar/'.$id);
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/foto/daftar/'.$id_album);
	}
   function feed(){  
        $data['feed_name'] = 'Berita';  
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
