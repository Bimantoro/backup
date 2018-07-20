<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sidemenu extends CI_Controller {

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
		$data['title']="Side Menu";
		$data['json_url']=site_url('admin/sidemenu/menu_json');
		$data['main_view']="admin/sidemenu/data_sidemenu";
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
		 //$kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select(" m1.id_menu as id_menu, m1.kode_unit as kode_unit, m2.nama_unit as nama_unit, m1.nama_menu as nama_menu, m1.url as url, m1.kode_bahasa as kode_bahasa, m1.menu_order as order")
        ->add_column('action', '$1','m1.id_menu')
        ->from("side_menu as m1")->join('unit as m2', 'm1.kode_unit=m2.kode_unit');//->where('kode_unit', $kode_unit);
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
		 $this->db->order_by("nama_unit", "asc");
		 $this->db->order_by("kode_bahasa", "desc");
		 $this->db->order_by("menu_order", "asc");
        
        echo $this->datatables->generate();
    }
	function add_sidemenu(){
		if($_POST==null){
			$data['title']="Input Informasi Side Menu";
			$data['main_view']="admin/sidemenu/menu_form";
			$data['units'] = $this->page_model->get_units();
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit  = $this->input->post('kode_unit');
			$nama_menu 	= $this->input->post('menu');
			$url 		= $this->input->post('url');
			$bahasa 	= $this->input->post('bahasa');
			$order 		= $this->input->post('order');
		
			$data=array(
						'kode_unit'=>$kode_unit,
						'kode_bahasa'=>$bahasa,
						'nama_menu'=>$nama_menu,
						'menu_order'=>$order,
						'url'=>$url
						);

			$qi=$this->db->insert('side_menu',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/sidemenu');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['sidemenu'] = $this->page_model->get_side_menu_id($id);
			$data['title']="Edit Info Side Menu";
			$data['main_view']="admin/sidemenu/edit_sidemenu";
			$this->load->view('admin/content',$data);
		}else{	
				$idmenu 	= $this->input->post('idmenu');
				$kode_unit 	= $this->session->userdata('kode_unit');
				$nama_menu 	= $this->input->post('menu');
				$url 		= $this->input->post('url');
				$bahasa 	= $this->input->post('bahasa');
				$order 		= $this->input->post('order');
				
				$data=array(
						'kode_unit'=>$kode_unit,
						'kode_bahasa'=>$bahasa,
						'nama_menu'=>$nama_menu,
						'menu_order'=>$order,
						'url'=>$url
						);

					
			if($this->db->where('id_menu',$idmenu)->update('side_menu',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/sidemenu/index');
			}
		}			
	}

	function delete($id=""){
		$q = $this->db->where('id_menu',$id)->delete('side_menu');
		if($q){
			$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/sidemenu/index');	
		}else{
			echo 'gagal'; die();
		}
		
	}

	function sync_side_prodi(){
		$q = $this->db->query("SELECT * FROM unit WHERE NOT kode_prodi=''")->result_array();
		$unit = array();
		foreach ($q as $k) {
			$s = $this->db->query("SELECT * FROM side_menu WHERE kode_unit ='".$k['kode_unit']."'")->result_array();
			if(!$s){
				$unit[] = $k;
			}
		}

		//insert data ke yang belum
		foreach ($unit as $u) {
			$kd_unit = $u['kode_unit'];
			$q = $this->db->query("INSERT INTO side_menu (kode_unit, nama_menu, url, kode_bahasa, menu_order) SELECT CONCAT('$kd_unit') as kode_unit, nama_menu, url, kode_bahasa, menu_order FROM side_menu WHERE kode_unit = '".$this->page_model->get_session_unit()."'");
		}

		redirect(site_url('admin/sidemenu'));
	}
	
}
 
/* End of file pengumuman.php */
