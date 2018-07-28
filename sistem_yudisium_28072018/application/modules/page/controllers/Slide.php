<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slide extends CI_Controller {
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
		$data['title']="Slide";
		$data['json_url']=site_url('admin/slide/menu_json');
		$data['main_view']="admin/slide/data_slide";
		$this->load->view('admin/content',$data);
   }
 
   public function detail($id=0){
		$get_data = $this->db->get_where("slide",array('id_slide'=>$id));
		$slide = $get_data->row();
		if($get_data->num_rows()>0){
			$this->breadcrumb->append_crumb('Beranda', base_url());
			$this->breadcrumb->append_crumb('slide', site_url('page/slide'));
			$this->breadcrumb->append_crumb(substr($slide->judul,0,130).' ...', '/');
			$data['title']=$slide->judul;
			$this->page_model->page_counter($id,'slide');
			
			$data['slide'] = $this->page_model->generate_detail_slide($id);
			
			$arr_filter=array();
			$arr_filter=related_text($slide->judul);	
			$filter	="WHERE id_slide <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_slide,judul,tanggal,jam from slide ".$filter." ORDER BY tanggal desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_slide,judul,tanggal,jam from slide ORDER BY counter desc LIMIT 0,5")->result();
			
	
			$data['content']="page/slide/detail_view";
				
			$this->load->view('page/header',$data);
			$this->load->view('page/content');
			$this->load->view('page/footer');
				
		}else{
	      	redirect(base_url());
		}
   }
   function menu_json(){
	   $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_slide as id_slide,m1.picture as picture,m1.background as background,m1.tgl_mulai as tgl_mulai,m1.tgl_selesai as tgl_selesai, m1.url as url, m1.kode_bahasa as kode_bahasa")
        ->add_column('action', '$1','m1.id_slide')
        ->from("slide_2016 as m1")->where('kode_unit', $kode_unit);
		/* ->join('slide as m2','m1.id_slide=m2.id_slide'); */
        echo $this->datatables->generate();
    }
	function add_slide(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Input slide";
			$data['main_view']="admin/slide/menu_form";
			$this->load->view('admin/content',$data);
			//$this->load->view('admin/slide/menu_isian',$data);
			
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			
			$background=$this->input->post('background');
			$bahasa=$this->input->post('bahasa');
			$tgl_mulai=$this->input->post('tgl_mulai');
			$tgl_selesai=$this->input->post('tgl_selesai');
			$url = $this->input->post('url');

			$temp_tgl_mulai = explode('/', $tgl_mulai);
			$temp_tgl_mulai_ = $temp_tgl_mulai[0];
			$temp_tgl_mulai[0] = $temp_tgl_mulai[1];
			$temp_tgl_mulai[1] = $temp_tgl_mulai_;

			$tgl_mulai = implode('/', $temp_tgl_mulai);

			//echo $tgl_mulai; die();

			$temp_tgl_selesai = explode('/', $tgl_selesai);
			$temp_tgl_selesai_ = $temp_tgl_selesai[0];
			$temp_tgl_selesai[0] = $temp_tgl_selesai[1];
			$temp_tgl_selesai[1] = $temp_tgl_selesai_;

			$tgl_selesai = implode('/', $temp_tgl_selesai);

			$time = strtotime($tgl_mulai);
			$tgl_mulai = date('Y-m-d', $time);

			$time = strtotime($tgl_selesai);
			$tgl_selesai = date('Y-m-d', $time);
			
			if( ($_FILES["picture"]["type"] == "image/jpeg") or ($_FILES["picture"]["type"] == "image/jpg")){
					$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['picture']['name'];
					$vdir_upload = "./media/slide/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["picture"]["tmp_name"],"./media/slide/" .$filename);
					$im_src = imagecreatefromjpeg($vfile_upload);
					$src_width = imageSX($im_src);
					$src_height = imageSY($im_src);
					echo $src_width;
					echo $src_height;
					
					if($src_width == 1170 AND $src_height >=480 AND $src_height < 490){
						$data=array(
						'kode_unit'=>$kode_unit,
						'picture'=>$filename,
						'kode_bahasa'=>$bahasa,
						'background'=>$background,
						'tgl_mulai'=>$tgl_mulai,
						'tgl_selesai'=>$tgl_selesai,
						'url'=>$url,
						/* 'menu_order'=>$mo->cur_order */
						);
						$qi=$this->db->insert('slide_2016',$data);
						if($qi){
							$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
							redirect('admin/slide');
						}else{
							echo "Gagal menyimpan";
						}
					}else{
						$this->session->set_flashdata('msg', array('danger', 'Error, Gunakan ukuran file 1170 x 487 pixel'));
						redirect('admin/slide');
					}
				}else{
						$this->session->set_flashdata('msg', array('danger', 'Error, Silahkan upload file gambar dengan ekstensi jpg'));
						redirect('admin/slide');
					}
			/* $mo=$this->db->query("SELECT COALESCE(MAX(menu_order),0)+1 cur_order FROM menu WHERE parent='".$parent."'")->row(); */
			
		}	
	}
	function edit($id){
		if($_POST==NULL) {
			$data=$this->data;
			$data['slide']=$this->page_model->get_slide($id);
			$data['title']="Edit slide";
			$data['main_view']="admin/slide/edit_slide";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit = $this->session->userdata('kode_unit');
				$background=$this->input->post('background');
				$bahasa=$this->input->post('bahasa');
				$tgl_mulai=$this->input->post('tgl_mulai');
				$tgl_selesai=$this->input->post('tgl_selesai');
				$url = $this->input->post('url');
				if(($_FILES["picture"]["type"] == "image/jpeg") or ($_FILES["picture"]["type"] == "image/pjpeg")){
					$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['picture']['name'];
					$vdir_upload = "./media/gambar/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["picture"]["tmp_name"],"./media/gambar/" .$filename);
					$im_src = imagecreatefromjpeg($vfile_upload);
					$src_width = imageSX($im_src);
					$src_height = imageSY($im_src);
					$dst_width = 550;
					$dst_height = ($dst_width/$src_width)*$src_height;
					$im = imagecreatetruecolor($dst_width,$dst_height);
					imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
					$picture= $filename;
					imagejpeg($im,$vdir_upload .$picture);
				}
				if($picture !=null){
				$data = array(
				  'kode_unit'=>$kode_unit,
				  'picture'=>$picture,
				  'background'=>$background,
				  'kode_bahasa'=>$bahasa,
				  'tgl_mulai'=>$tgl_mulai,
				  'tgl_selesai'=>$tgl_selesai,
				  'url'=>$url
				);
				}else{
				$data = array(
				'kode_unit'=>$kode_unit,
				  'background'=>$background,
				  'kode_bahasa'=>$bahasa,
				  'tgl_mulai'=>$tgl_mulai,
				  'tgl_selesai'=>$tgl_selesai,
				  'url'=>$url
				);
				}
						
			if($this->db->where('id_slide',$id)->update('slide_2016',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/slide/index');
			};
		}			
	}
	function delete($id=""){
		$this->db->where('id_slide',$id)->delete('slide_2016');
		
		//unlink(base_url().'/media/gambar/'.$id);
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/slide/index');
	}
   function feed(){  
        $data['feed_name'] = 'slide';  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/slide/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['slide'] = $this->page_model->get_feed_slide(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('slide/rss_slide', $data);  
    }   

}
 
/* End of file slide.php */
