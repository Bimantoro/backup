<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prodi extends CI_Controller {

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
		$data['title']="Master Program Studi";
		$data['json_url']=site_url('admin/prodi/menu_json');
		$data['main_view']="admin/prodi/data_prodi";
		$this->load->view('admin/content',$data);
   }
 
	public function detail($id=0){
		$this->page_model->page_counter($id,'pengumuman');
		
		
		$get_data = $this->db->get_where("pengumuman",array('id_pengumuman'=>$id));
		$p = $get_data->row();
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Pengumuman', site_url('page/pengumuman'));
		$this->breadcrumb->append_crumb(substr($p->judul,0,130).' ...', '/');
		$data['title']=$p->judul;
		
			$arr_filter=array();
			$arr_filter=related_text($p->judul);	
			$filter	="WHERE id_pengumuman <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
			$data['rec']=$this->db->query("SELECT id_pengumuman,judul,tgl_posting,jam_posting from pengumuman ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
			$data['pop']=$this->db->query("SELECT id_pengumuman,judul,tgl_posting,jam_posting from pengumuman ORDER BY counter desc LIMIT 0,5")->result();
			
		$data['pengumuman']=$get_data->result();		
		if($get_data->num_rows()>0){
			set_time_limit(0); 
			if($p->url!=null){
				redirect($data->url);
			}else{
				$arf=explode(".",$p->nama_file);
				$ext= strtolower(end($arf));
				$arr_ext=array('pdf','jpg');
				if(in_array($ext,$arr_ext)){
					$data['ext']=$ext;
				}
					$data['filetype']=$ext;
				$data['content']="page/pengumuman/detail_view";
				$this->load->view('page/header',$data);
				$this->load->view('page/content');
				$this->load->view('page/footer');
				
				//$this->output_file("./media/pengumuman/".$data->nama_file,''.$data->nama_file.''); 
			}	
		}else{
			redirect(base_url());
		}
	}
	
	
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.kode_unit kode_unit, m1.nama_unit nama_unit, m1.subdomain subdomain, m1.telp telp, m1.email email, m1.nama_sidebar_unit nama_sidebar_unit, m1.status_slider_bar status_slider_bar")
        ->add_column('action', '$1','m1.kode_unit')
        ->from("unit as m1");
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_prodi(){
		if($_POST==null){
			$data['title']="Input Data Unit";
			$data['main_view']="admin/prodi/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit 	= $this->input->post('kode_unit');
			$nama_unit 	= $this->input->post('nama_unit');
			$subdomain 	= $this->input->post('subdomain');
			$kode_prodi	= $this->input->post('kode_prodi');
			$bahasa 	= $this->input->post('bahasa');
			$alamat 	= $this->input->post('alamat');
			$email  	= $this->input->post('email');
			$telp   	= $this->input->post('telp');
			$sidebar 	= $this->input->post('sidebar');
			$slider  	= $this->input->post('slider');
			
			$data=array(
						'kode_unit'=>$kode_unit,
						'kode_bahasa'=>$bahasa,
						'kode_prodi'=>$kode_prodi,
						'nama_unit'=>$nama_unit,
						'subdomain'=>$subdomain,
						'alamat'=>$alamat,
						'telp'=>$telp,
						'email'=>$email,
						'nama_sidebar_unit'=>$sidebar,
						'status_slider_bar'=>$slider
						);

			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';

			// die();
			$qi=$this->db->insert('unit',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/prodi');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['prodi'] = $this->page_model->get_unit($id);
			$data['title']="Edit Data Unit";
			$data['main_view']="admin/prodi/edit_prodi";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit 	= $this->input->post('kode_unit');
				$nama_unit 	= $this->input->post('nama_unit');
				$subdomain 	= $this->input->post('subdomain');
				$kode_prodi	= $this->input->post('kode_prodi');
				$bahasa 	= $this->input->post('bahasa');
				$alamat 	= $this->input->post('alamat');
				$email  	= $this->input->post('email');
				$telp   	= $this->input->post('telp');
				$sidebar 	= $this->input->post('sidebar');
				$slider  	= $this->input->post('slider');
				
				$data=array(
							'kode_unit'=>$kode_unit,
							'kode_bahasa'=>$bahasa,
							'kode_prodi'=>$kode_prodi,
							'nama_unit'=>$nama_unit,
							'subdomain'=>$subdomain,
							'alamat'=>$alamat,
							'telp'=>$telp,
							'email'=>$email,
							'nama_sidebar_unit'=>$sidebar,
							'status_slider_bar'=>$slider
							);
					
			if($this->db->where('kode_unit',$kode_unit)->update('unit',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/prodi/index');
			}
		}			
	}

	function delete($id=""){
		$this->db->where('kode_unit',$id)->delete('unit');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/prodi/index');
	}
	
}
 
/* End of file pengumuman.php */
