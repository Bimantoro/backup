<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prodi extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('auth');
		$this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		$this->load->model('admin/page_model');
		$this->load->library('s00_lib_api');
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
		$data['title']="Master Unit";
		$data['json_url']=site_url('admin/prodi/menu_json');
		$data['main_view']="admin/prodi/data_prodi";
		$this->load->view('admin/content',$data);
   }
 
	// public function detail($id=0){
	// 	$this->page_model->page_counter($id,'pengumuman');
		
		
	// 	$get_data = $this->db->get_where("pengumuman",array('id_pengumuman'=>$id));
	// 	$p = $get_data->row();
	// 	$this->breadcrumb->append_crumb('Beranda', base_url());
	// 	$this->breadcrumb->append_crumb('Pengumuman', site_url('page/pengumuman'));
	// 	$this->breadcrumb->append_crumb(substr($p->judul,0,130).' ...', '/');
	// 	$data['title']=$p->judul;
		
	// 		$arr_filter=array();
	// 		$arr_filter=related_text($p->judul);	
	// 		$filter	="WHERE id_pengumuman <> '".$id."' AND  (judul LIKE '%".rtrim(implode("%' OR judul LIKE '%",$arr_filter)," OR judul LIKE '%")."%')";
	// 		$data['rec']=$this->db->query("SELECT id_pengumuman,judul,tgl_posting,jam_posting from pengumuman ".$filter." ORDER BY tgl_posting desc LIMIT 0,5")->result();
	// 		$data['pop']=$this->db->query("SELECT id_pengumuman,judul,tgl_posting,jam_posting from pengumuman ORDER BY counter desc LIMIT 0,5")->result();
			
	// 	$data['pengumuman']=$get_data->result();		
	// 	if($get_data->num_rows()>0){
	// 		set_time_limit(0); 
	// 		if($p->url!=null){
	// 			redirect($data->url);
	// 		}else{
	// 			$arf=explode(".",$p->nama_file);
	// 			$ext= strtolower(end($arf));
	// 			$arr_ext=array('pdf','jpg');
	// 			if(in_array($ext,$arr_ext)){
	// 				$data['ext']=$ext;
	// 			}
	// 				$data['filetype']=$ext;
	// 			$data['content']="page/pengumuman/detail_view";
	// 			$this->load->view('page/header',$data);
	// 			$this->load->view('page/content');
	// 			$this->load->view('page/footer');
				
	// 			//$this->output_file("./media/pengumuman/".$data->nama_file,''.$data->nama_file.''); 
	// 		}	
	// 	}else{
	// 		redirect(base_url());
	// 	}
	// }
	
	
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("id, kode_unit, nama_unit, subdomain, telp, email, nama_sidebar_unit, status_slider_bar")
        ->add_column('action', '$1','id')
        ->from("unit");

        // $this->datatables->select("m1.kode_unit kode_unit, m1.nama_unit nama_unit, m1.subdomain subdomain, m1.telp telp, m1.email email, m1.nama_sidebar_unit nama_sidebar_unit, m1.status_slider_bar status_slider_bar")
        // ->add_column('action', '$1','m1.kode_unit')
        // ->from("unit as m1");
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_prodi(){
		if($_POST==null){
			$data['title']="Input Data Unit";
			$data['main_view']="admin/prodi/menu_form";

			$parameter = array(	'api_kode' => 17000,'api_subkode' => 1,'api_search'=> array());
			$fak= $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_master/data_view','POST',$parameter);
			$prd = array();
			$fk  = array();
			if($fak){
				foreach ($fak as $f) {

					$fk[] = array(
						'KD_FAK' 	 => $f['KD_FAK'],
						'NM_FAK'	 => $f['NM_FAK'],
						'ALAMAT' 	 => $f['ALAMAT'],
						'TELP' 		 => $f['TELP'],
						'EMAIL'		 => $f['EMAIL']
					);
					

					$parameter = array(	'api_kode' => 19000,'api_subkode' => 6,'api_search'=> array($f['KD_FAK']));
					$prodi = $this->s00_lib_api->get_api_json(URL_API_SIA.'sia_master/data_search','POST',$parameter);

					if($prodi){
						foreach ($prodi as $p) {
							$prd[$f['KD_FAK']][] = array(
										'KD_PRODI' 	 => $p['KD_PRODI'],
										'KD_JURUSAN' => $p['KD_JURUSAN'],
										'NM_PRODI'	 => $p['NM_PRODI_J'],
										'ALAMAT' 	 => $p['ALAMAT'],
										'TELP' 		 => $p['TELP'],
										'EMAIL'		 => $p['EMAIL']
							);
						}
					}

				}
			}


			if(isset($prd)){
				$data['prodi'] = $prd;
			}

			if(isset($fk)){
				$data['fakultas'] = $fk;
			}

			$data['add_data'] = true;
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

			//ini untuk social media
			$social 	= array(
				'facebook' 	=> $this->input->post('facebook'),
				'twitter'  	=> $this->input->post('twitter'),
				'instagram' => $this->input->post('instagram'),
				'youtube' 	=> $this->input->post('youtube')
			);

			$status 	= 1;
			$temp_u 	= $this->page_model->cek_unit_by_subdomain($subdomain);

			if(!empty($temp_u)){
				foreach ($temp_u as $u) {
					if($u['kode_unit'] != $kode_unit){
						$status = 0;
					}
				}
			}
			

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

			if($status == 1){

				//cek apakah ada kemungkinan duplicate primary key ?
				$c_pk = $this->db->get_where('unit', array('kode_unit' => $kode_unit, 'kode_bahasa' => $bahasa, 'subdomain' => $subdomain))->result_array();
				if(empty($c_pk)){
					//simpan data :
					$qi=$this->db->insert('unit',$data);
					if($qi){

						//ini nanti get last id dulu :
						$last_inserted = $this->page_model->get_last_insert_unit($kode_unit, $bahasa, $subdomain);
						if(!empty($last_inserted)){
							//insert data media sosial
							foreach ($social as $k => $s) {
								if($s != ''){
									$tmp_i = array(
										'id_unit' 	=> $last_inserted['id'],
										'jenis'		=> $k,
										'url' 		=> $s 
									);

									$qs = $this->db->insert('sosial_media', $tmp_i);
								}
							}
						}

						$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
						redirect('admin/prodi');
					}else{
						$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan'));
						redirect('admin/prodi');
					}
				}else{
					$this->session->set_flashdata('msg', array('danger', 'Data gagal disimpan ( terjadi duplikasi data ! )'));
						redirect('admin/prodi');
				}

				

			}else{
				//simpan gagal, dikarenakan terdapat subdomain yang digunakan untuk lebih dari satu unit
				$this->session->set_flashdata('msg', array('danger', "Subdomain '".$subdomain."' sudah digunakan untuk unit lain !" ));
				redirect('admin/prodi');
			}

			
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			// $data['prodi'] = $this->page_model->get_unit($id); //ini by kode unit
			$data['prodi'] = $this->page_model->get_unit_by_id($id);

			$social = array(
				'facebook' 	=> '',
				'twitter'	=> '',
				'instagram' => '',
				'youtube' 	=> ''
			);

			$tmp_social = $this->page_model->get_social_media($id);

			foreach ($tmp_social as $s) {
				$social[$s->jenis] = $s->url;
			}

			$data['social'] = $social;

			$data['title']="Edit Data Unit";
			$data['main_view']="admin/prodi/edit_prodi";
			$this->load->view('admin/content',$data);
		}else{	
				$id 		= $this->input->post('id');
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

				//ini untuk social media
				$social 	= array(
					'facebook' 	=> $this->input->post('facebook'),
					'twitter'  	=> $this->input->post('twitter'),
					'instagram' => $this->input->post('instagram'),
					'youtube' 	=> $this->input->post('youtube')
				);
				
				$data=array(
							'id' => $id,
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
					
			if($this->db->where('id',$id)->update('unit',$data)){

				foreach ($social as $k => $s) {
					if($s != ''){

						$tmp_sc = $this->db->get_where('sosial_media', array('id_unit' => $id, 'jenis' => $k))->row_array();
						if(empty($tmp_sc)){							
							$tmp_i = array(
								'id_unit' 	=> $id,
								'jenis'		=> $k,
								'url' 		=> $s 
							);

							$qs = $this->db->insert('sosial_media', $tmp_i);
						}else{
							$tmp_u = array('url' => $s);
							$id_sc = $tmp_sc['id'];
							$this->db->where('id',$id_sc)->update('sosial_media',$tmp_u);
							//$qu = $this->db->where('id' => $tmp_sc['id'])->update('sosial_media', $tmp_u);
						}

					}else{
						$this->db->where(array('id_unit' => $id, 'jenis' => $k))->delete('sosial_media');
					}
				}

				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/prodi/index');
			}
		}			
	}

	function delete($id=""){
		$this->db->where('id',$id)->delete('unit');
		$this->db->where('id_unit', $id)->delete('sosial_media');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/prodi/index');
	}

	function cek_http(){
		echo '<pre>';
		print_r($this->agent->referrer());
		echo '<pre>';
	}
	
}
 
/* End of file pengumuman.php */
