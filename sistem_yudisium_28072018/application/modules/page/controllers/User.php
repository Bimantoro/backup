<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
		$data['title']="Master User";
		$data['json_url']=site_url('admin/user/menu_json');
		$data['main_view']="admin/user/data_user";
		$this->load->view('admin/content',$data);
   }
 
	
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.username username, m1.kode_unit kode_unit, m2.nama_unit nama_unit, m1.level level")
        ->add_column('action', '$1','m1.username')
        ->from("user as m1")->join('unit as m2', 'm1.kode_unit=m2.kode_unit');
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_user(){
		if($_POST==null){
			$data['title']="Input Data User";
			$data['main_view']="admin/user/menu_form";
			$data['units'] = $this->page_model->get_units();
			$this->load->view('admin/content',$data);
		}else{
			$username 	= $this->input->post('username');
			$kode_unit 	= $this->input->post('kode_unit');
			$level 	 	= $this->input->post('level');
		
			$data=array(
						'username'=>$username,
						'kode_unit'=>$kode_unit,
						'level'=>$level
						);

			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';

			// die();
			$qi=$this->db->insert('user',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/user');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['user'] = $this->page_model->get_user($id);
			$data['units'] = $this->page_model->get_units();
			$data['title']="Edit Data User";
			$data['main_view']="admin/user/edit_user";
			$this->load->view('admin/content',$data);
		}else{	
				$username 	= $this->input->post('username');
				$kode_unit 	= $this->input->post('kode_unit');
				$level 	 	= $this->input->post('level');
			
				$data=array(
							'username'=>$username,
							'kode_unit'=>$kode_unit,
							'level'=>$level
							);
					
			if($this->db->where('username',$username)->update('user',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/user/index');
			}
		}			
	}

	function delete($id=""){
		$this->db->where('username',$id)->delete('user');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/user/index');
	}
	
}
 
/* End of file pengumuman.php */
