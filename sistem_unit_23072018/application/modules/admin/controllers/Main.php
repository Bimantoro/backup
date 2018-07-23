<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->helper('auth');
		$this->load->library(array('Datatables'));
		$this->load->helper('ckeditor');
		$this->load->model('admin/page_model');
		$this->load->helper('format_tanggal');
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
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)		{
			redirect('login');
			die();		
			
		}		
	}
	function menu()	{		 
		$data['title']="Menu";
		$data['json_url']=site_url('admin/main/menu_json');
		$data['main_view']="admin/main/data_menu";
		$this->load->view('admin/content',$data);
	}
	function dash()
	{
		
		$data['title']="Dashboard";
		//$data['json_url']=site_url('admin/main/menu_json');
		$data['main_view']="admin/dash/dash";
		$this->load->view('admin/content',$data);
	}
	function page()	{		 
		$data['title']="Halaman";
		$data['json_url']=site_url('admin/main/menu_json_page');
		$data['main_view']="admin/page/data_page";
		$this->load->view('admin/content',$data);
	}
	function pusatstudi()	{		 
		$data['title']="Pusat Studi";
		$data['json_url']=site_url('admin/main/menu_json_pusatstudi');
		$data['main_view']="admin/pusatstudi/data_pusatstudi";
		$this->load->view('admin/content',$data);
	}
	function laboratorium()	{		 
		$data['title']="Laboratorium";
		$data['json_url']=site_url('admin/main/menu_json_laboratorium');
		$data['main_view']="admin/laboratorium/data_laboratorium";
		$this->load->view('admin/content',$data);
	}
    function index() {
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Berita', '/');
		$data['main_view']="transaction/penjualan/data_penjualan";
		$data['json_url']=site_url('transaction/penjualan/penjualan_json');
        $this->load->view('master/header',$data);
		$this->load->view('breadcumb');
        $this->load->view('master/home');
        $this->load->view('master/footer');
    }
	
    function detail($id=0) {
		$data['jual']=$this->transaction_model->get_penjualan($id)->result();
		$data['barang']=$this->transaction_model->select_detail_penjualan($id)->result();
		$data['main_view']="transaction/penjualan/detail_penjualan";
        $this->load->view('master/header',$data);
        $this->load->view('master/home');
        $this->load->view('master/footer');
    }
	
    function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_menu as id_menu,m1.nama_menu as nama_menu,m1.url as url,m1.jenis_url as jenis_url,m1.target as target, m2.nama_menu as parent")
        ->add_column('action', '$1','m1.id_menu')
        ->from("menu as m1")
		->join('menu as m2','m1.parent=m2.id_menu','left')->where('m1.kode_unit', $kode_unit);
        $this->db->order_by("id_menu", "desc");
        echo $this->datatables->generate();
    }
	function menu_json_page(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_page as id_page,m1.title as title,m1.foto as foto,m1.content as content, m1.kode_bahasa as kode_bahasa")
        ->add_column('action', '$1','m1.id_page')
        ->from("page as m1")->where('kode_unit', $kode_unit);
		/* ->join('page as m2','m1.parent=m2.id_menu'); */
        echo $this->datatables->generate();
    }
	function menu_json_pusatstudi(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_pusat_studi id_pusat_studi,m1.nama_pusat_studi nama_pusat_studi,m1.deskripsi deskripsi,m1.menu_url menu_url,m1.kode_bahasa kode_bahasa")
        ->add_column('action', '$1','m1.id_pusat_studi')
        ->from("pusat_studi as m1")->where('kode_unit', $kode_unit);
		/* ->join('pusat_studi as m2','m1.parent=m2.id_menu'); */
        
        echo $this->datatables->generate();
    }
	function menu_json_laboratorium(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_lab id_lab,m1.nama_lab nama_lab,m1.deskripsi deskripsi,m1.menu_url menu_url,m1.kode_bahasa kode_bahasa, m1.foto foto")
        ->add_column('action', '$1','m1.lab')
        ->from("laboratorium as m1")->where('kode_unit', $kode_unit);
		/* ->join('pusat_studi as m2','m1.parent=m2.id_menu'); */
        
        echo $this->datatables->generate();
    }
	function picture($pic=""){
		$data['pic']=$pic;
		 $this->load->view('master/modal_header',$data);
		 $this->load->view('master/picture_view');
	}
	function set_kode_penjualan($kd=""){
		$data=$this->master_model->get_last_penjualan($kd)->result();
		foreach($data as $d){
			$kode=$d->kode+1;
		}
		$i=0;
		for($i=strlen($kode);$i<4;$i++){
		$kode="0".$kode;
		}
		$kode=$kd.$kode;
		return $kode;
	}
	function add_menu(){
		if($_POST==null){
			$kode_unit = $this->session->userdata('kode_unit');
			$data['title']="Menu";
			$data['parent']=$this->db->get_where('menu',array('parent'=>0, 'kode_unit'=>$kode_unit))->result();
			$data['main_view']="admin/main/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$nama_menu=$this->input->post('nama_menu');
			$url=$this->input->post('url');
			$bahasa=$this->input->post('bahasa');
			$parent=$this->input->post('parent');
			$target=$this->input->post('target');
			$jenis_url=$this->input->post('jenis_url');
			$mega_menu=$this->input->post('mega_content');
			$sub_menu=$this->input->post('sub_mega_content');
			
			$mo=$this->db->query("SELECT COALESCE(MAX(menu_order),0)+1 cur_order FROM menu WHERE parent='".$parent."'")->row();
			
			// FAUZI 29-06-18 START
			$mega_menu = (!empty($mega_menu))? $mega_menu:'No';
			$sub_menu = (!empty($sub_menu))? $sub_menu:0;
			if ($sub_menu != 0) {
				$mo = $this->db->query("SELECT COALESCE(MAX(menu_order),0)+1 cur_order FROM menu WHERE sub_mega_content='".$sub_menu."'")->row();
			}
			// FAUZI 29-06-18 END

			// FAUZI 02-07-18 START
			$url = (!empty($url))? $url:"page";
			// FAUZI 02-07-18 END

			if($jenis_url == 'Eksternal'){
				if($url == filter_var($url, FILTER_VALIDATE_URL)){
					$data=array(
						'kode_unit'=>$kode_unit,
						'nama_menu'=>$nama_menu,
						'url'=>$url,
						'kode_bahasa'=>$bahasa,
						'parent'=>$parent,
						'target'=>$target,
						'mega_content'=>$mega_menu,
						'sub_mega_content'=>$sub_menu,
						'jenis_url'=>$jenis_url,
						'menu_order'=>$mo->cur_order,
						'status'=>1
						);

						$qi=$this->db->insert('menu',$data);
						if($qi){
							$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
							redirect('admin/main/menu');
						}
				}else{
					$this->session->set_flashdata('msg', array('danger', 'Tidak dapat menambahkan menu, Link URL yang diinputkan tidak sesuai.'));
				redirect('admin/main/menu');
				}
			}else{
				$data=array(
						'kode_unit'=>$kode_unit,
						'nama_menu'=>$nama_menu,
						'url'=>$url,
						'kode_bahasa'=>$bahasa,
						'parent'=>$parent,
						'target'=>$target,
						'mega_content'=>$mega_menu,
						'sub_mega_content'=>$sub_menu,
						'jenis_url'=>$jenis_url,
						'menu_order'=>$mo->cur_order,
						'status'=>1
						);

				$qi=$this->db->insert('menu',$data);
				if($qi){
					$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
					redirect('admin/main/menu');
				}
			}
			
		}	
	}

	// FAUZI 29-06-18 START
	function cek_mega(){
		$id_menu = $this->input->post('id_menu');
		$true_mc = $this->db->select('mega_content')
			->from('menu')
			->where(array('id_menu' => $id_menu))
			->get()
			->row_array();
		if ($true_mc['mega_content'] == 'Yes') {
			echo '
			<div class="form-group">
				<label class="col-md-3 control-label">Mega Konten</label>
				<div class="col-md-2">			
					<select class="form-control mb-md" name="mega_content" id="mega_content">
						<option value="Yes">Ya</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Sub Menu</label>
				<div class="col-md-2">			
					<select class="form-control mb-md" name="sub_mega_content" id="sub_mega_content">
						<option value="0"> - </option>';
			$sub_mega = $this->db->select('*')
				->from('menu')
				->where(array(
					'parent' => $id_menu,
					'sub_mega_content' => 0 ))
				->get()
				->result();
			foreach ($sub_mega as $sm) {
				echo '<option value="'.$sm->id_menu.'">'.$sm->nama_menu.'</option>';
			}
			echo '	</select>
				</div>
			</div>
			';
		} else {
			echo '
			<div class="form-group">
				<label class="col-md-3 control-label">Mega Konten</label>
				<div class="col-md-2">			
					<select class="form-control mb-md" name="mega_content" id="mega_content">
						<option value="No">Tidak</option>
					</select>
				</div>
			</div>
			';
		}
	}
	// FAUZI 29-06-18 END

	function add_halaman(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Halaman";
			$data['main_view']="admin/page/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$title=$this->input->post('title');
			$content=$this->input->post('content');
			$bahasa=$this->input->post('bahasa');
			
			if(($_FILES["photo"]["type"] == "image/png") or ($_FILES["photo"]["type"] == "image/jpeg") or ($_FILES["photo"]["type"] == "image/pjpeg")){
					$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['photo']['name'];
					$vdir_upload = "./media/gambar/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["photo"]["tmp_name"],"./media/gambar/" .$filename);
					$im_src = imagecreatefromjpeg($vfile_upload);
					$src_width = imageSX($im_src);
					$src_height = imageSY($im_src);
					if($src_width > 550){
						$dst_width = 550;
						$dst_height = ($dst_width/$src_width)*$src_height;
						$im = imagecreatetruecolor($dst_width,$dst_height);
					}else{
						$im = imagecreatetruecolor($src_width,$src_height);
					}
					imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
					$photo=$filename;
					imagejpeg($im,$vdir_upload .$photo);

					$im_src = getimagesize($vfile_upload);
					$src_width = $im_src[0];
					$src_height = $im_src[1];
				}
			$data=array(
						'kode_unit'=>$kode_unit,
						'title'=>$title,
						'foto'=>$photo,
						'content'=>$content,
						'kode_bahasa'=>$bahasa,
						);
			$qi=$this->db->insert('page',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/main/page');
			}
		}	
	}
	function add_pusatstudi(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Pusat Studi";
			$data['main_view']="admin/pusatstudi/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$nama_pusat_studi=$this->input->post('nama_pusat_studi');
			$deskripsi=$this->input->post('deskripsi');
			$bahasa=$this->input->post('bahasa');
			$data=array(
						'kode_unit'=>$kode_unit,
						'nama_pusat_studi'=>$nama_pusat_studi,
						'kode_bahasa'=>$bahasa,
						'deskripsi'=>$deskripsi,
						);
			$qi=$this->db->insert('pusat_studi',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/main/pusatstudi');
			}
		}	
	}
	function add_laboratorium(){
		if($_POST==null){
			$data=$this->data;
			$data['title']="Laboratorium";
			$data['main_view']="admin/laboratorium/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$nama_lab=$this->input->post('nama_lab');
			$deskripsi=$this->input->post('deskripsi');
			$bahasa=$this->input->post('bahasa');
			if(($_FILES["photo"]["type"] == "image/png") or ($_FILES["photo"]["type"] == "image/jpeg") or ($_FILES["photo"]["type"] == "image/pjpeg")){
					$filename=date('Ymd')."_".$_FILES['photo']['name'];
					$vdir_upload = "./media/gambar/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["photo"]["tmp_name"],"./media/gambar/" .$filename);
					$im_src = imagecreatefromjpeg($vfile_upload);
					$src_width = imageSX($im_src);
					$src_height = imageSY($im_src);
					if($src_width > 550){
						$dst_width = 550;
						$dst_height = ($dst_width/$src_width)*$src_height;
						$im = imagecreatetruecolor($dst_width,$dst_height);
					}else{
						$im = imagecreatetruecolor($src_width,$src_height);
					}
					imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
					$photo=$filename;
					imagejpeg($im,$vdir_upload .$photo);
				}
			$data=array(
						'kode_unit'=>$kode_unit,
						'nama_lab'=>$nama_lab,
						'kode_bahasa'=>$bahasa,
						'foto'=>$photo,
						'deskripsi'=>$deskripsi
						);
			$qi=$this->db->insert('laboratorium',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/main/laboratorium');
			}
		}	
	}
	function edit($id){
		if($_POST==NULL) {
			$data=$this->data;
			 $kode_unit = $this->session->userdata('kode_unit');
			 $id_menu = $this->uri->segment(4);
			$data['menu']=$this->page_model->get_menu($id);
			$data['title']="Edit Menu";
			$data['parent']=$this->db->get_where('menu',array('parent'=>0, 'kode_unit'=>$kode_unit))->result();
			$data['target']=$this->page_model->get_target_menu($id_menu);
			$data['jenisurl']=$this->page_model->get_jenisurl_menu($id_menu);
			//$data['jenisurl'] = $this->db->group_by('jenis_url')->get_where('menu',array('kode_unit'=>$kode_unit))->result();
			//$data['target']=$this->db->group_by('target')->get_where('menu',array('kode_unit'=>$kode_unit))->result();
			//$data['jenisurl'] = $this->db->group_by('jenis_url')->get_where('menu',array('kode_unit'=>$kode_unit))->result();

			//$data['target']=$this->db->get_where('menu',array('kode_unit'=>$kode_unit))->result();
			//$data['jenisurl'] = $this->db->get_where('menu',array('kode_unit'=>$kode_unit))->result();
			$data['main_view']="admin/main/edit_menu";
			$this->load->view('admin/content',$data);
		}else{	
			$kode_unit = $this->session->userdata('kode_unit');
				$nama_menu= $this->input->post('nama_menu');
				$kode_bahasa = $this->input->post('bahasa');
				$url = $this->input->post('url');
				$parent = $this->input->post('parent');
				$target = $this->input->post('target');
				$jenis_url = $this->input->post('jenis_url');
				/*echo $kode_unit."<br>";
				echo $nama_menu."<br>";
				echo $kode_bahasa."<br>";
				echo $url."<br>";
				echo $parent."<br>";
				echo $target."<br>";
				echo $jenis_url."<br>";
				die();*/

				if($jenis_url == 'Eksternal'){
					if($url == filter_var($url, FILTER_VALIDATE_URL)){
						if(!empty($url)){
							$data = array(
							  'kode_unit'=>$kode_unit,
							  'nama_menu'=>$nama_menu,
							  'kode_bahasa'=>$kode_bahasa,
							  'url'=>$url,
							  'parent'=>$parent,
							  'target'=>$target,
							  'jenis_url'=>$jenis_url,
							);
						}else{
							$data = array(
							  'kode_unit'=>$kode_unit,
							  'nama_menu'=>$nama_menu,
							  'kode_bahasa'=>$kode_bahasa,
							  /*'url'=>$url,*/
							  'parent'=>$parent,
							  'target'=>$target,
							  'jenis_url'=>$jenis_url,
						);
						}
							
						if($this->db->where('id_menu',$id)->update('menu',$data)){
							$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
							redirect('admin/main/menu/index');
						};
					}else{
						$this->session->set_flashdata('msg', array('danger', 'Tidak dapat memperbaharui menu, Link URL yang diinputkan tidak sesuai.'));
						redirect('admin/main/menu');
					}
				}else{
					if(!empty($url)){
						$data = array(
						  'kode_unit'=>$kode_unit,
						  'nama_menu'=>$nama_menu,
						  'kode_bahasa'=>$kode_bahasa,
						  'url'=>$url,
						  // 'parent'=>$parent,
						  'target'=>$target,
						  'jenis_url'=>$jenis_url,
						);
					}else{
						$data = array(
						  'kode_unit'=>$kode_unit,
						  'nama_menu'=>$nama_menu,
						  'kode_bahasa'=>$kode_bahasa,
						  /*'url'=>$url,*/
						  // 'parent'=>$parent,
						  'target'=>$target,
						  'jenis_url'=>$jenis_url,
					);
					}
						
					if($this->db->where('id_menu',$id)->update('menu',$data)){
						$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
						redirect('admin/main/menu/index');
					};
				}
		}			
	}
	function edit_page($id){
		if($_POST==NULL) {
			$data=$this->data;
			$data['page']=$this->page_model->get_page2($id);
			$data['title']="Edit Halaman";
			$data['main_view']="admin/page/edit_page";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit = $this->session->userdata('kode_unit');
				$data['page']=$this->page_model->get_page2($id);
				$title= $this->input->post('title');
				$kode_bahasa = $this->input->post('bahasa');
				$content = $this->input->post('content');
				if(($_FILES["photo"]["type"] == "image/png") or ($_FILES["photo"]["type"] == "image/jpeg") or ($_FILES["photo"]["type"] == "image/pjpeg")){
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
					  'title'=>$title,
					  'foto'=>$photo,
					  'kode_bahasa'=>$kode_bahasa,
					  'content'=>$content,
					  );
					  
				}else{
					  $data = array(
					  'kode_unit'=>$kode_unit,
					  'title'=>$title,
					  'kode_bahasa'=>$kode_bahasa,
					  'content'=>$content,
					);
				}
					
			if($this->db->where('id_page',$id)->update('page',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/main/page');
			};
		}			
	}
	function edit_laboratorium($id){
		if($_POST==NULL) {
			$data=$this->data;
			$data['laboratorium']=$this->page_model->get_laboratorium($id);
			$data['title']="Edit Laboratorium";
			$data['main_view']="admin/laboratorium/edit_laboratorium";
			$this->load->view('admin/content',$data);
		}else{	
				$kode_unit = $this->session->userdata('kode_unit');
				$nama_lab= $this->input->post('nama_lab');
				$kode_bahasa = $this->input->post('bahasa');
				$deskripsi = $this->input->post('deskripsi');
				if(($_FILES["photo"]["type"] == "image/png") or ($_FILES["photo"]["type"] == "image/jpeg") or ($_FILES["photo"]["type"] == "image/pjpeg")){
					$filename=date('Ymd')."_".$_FILES['photo']['name'];
					$vdir_upload = "./media/gambar/";
					$vfile_upload = $vdir_upload . $filename;
					move_uploaded_file($_FILES["photo"]["tmp_name"],"./media/gambar/" .$filename);
					$im_src = imagecreatefromjpeg($vfile_upload);
					$src_width = imageSX($im_src);
					$src_height = imageSY($im_src);
					if($src_width > 550){
						$dst_width = 550;
						$dst_height = ($dst_width/$src_width)*$src_height;
						$im = imagecreatetruecolor($dst_width,$dst_height);
					}else{
						$im = imagecreatetruecolor($src_width,$src_height);
					}
					imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
					$photo=$filename;
					imagejpeg($im,$vdir_upload .$photo);
				}
				if($photo !=null){
				$data = array(
				'kode_unit'=>$kode_unit,
				  'nama_lab'=>$nama_lab,
				  'foto'=>$photo,
				  'kode_bahasa'=>$kode_bahasa,
				  'deskripsi'=>$deskripsi
				);
				}else{
				$data = array(
				'kode_unit'=>$kode_unit,
				  'nama_lab'=>$nama_lab,
				  'kode_bahasa'=>$kode_bahasa,
				  'deskripsi'=>$deskripsi,
				);
				}
			if($this->db->where('id_lab',$id)->update('laboratorium',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/main/laboratorium/index');
			};
		}			
	}
	function delete($id=""){
		$this->db->where('id_menu',$id)->delete('menu');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/main/menu/');
	}
	function delete_page($id=""){
		$this->db->where('id_page',$id)->delete('page');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/main/page/');
	}
	function delete_pusatstudi($id=""){
		$this->db->where('id_pusat_studi',$id)->delete('pusat_studi');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/main/pusatstudi/');
	}
	function delete_laboratorium($id=""){
		$this->db->where('id_lab',$id)->delete('laboratorium');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/main/laboratorium/');
	}
	function nota_jual($id=0){
		$data['jual']=$this->transaction_model->get_penjualan($id)->result();
		$data['barang']=$this->transaction_model->select_detail_penjualan($id)->result();
		$data['title']="INVOICE";
        $this->load->view('transaction/penjualan/nota_jual',$data);
   
		
    }

   public function search($uri=0){
		$this->load->library('pagination');
		$data['title']="Pencarian";
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Pencarian', '/');
		   if(isset($_SESSION['site_limit_berita_slider'])){
			$limit=$_SESSION['site_limit_berita_slider'];
			}else{
			$limit=10;
			}
			if($_POST!=null){
				$cari=$this->input->post('cari');
				$this->session->set_userdata('cari',$cari);
			}else{
				$cari= $this->session->userdata('cari');
			}
			$data['cari'] = $this->page_model->search($limit,$uri,$cari);

		$data['main_view']="admin/search_view";				
		$this->load->view('admin/content',$data);
   }
	//TONI EFENDI 11/7/2018 <START>
   public function get_data_page(){
   		$kode_unit = $this->input->post('kode_unit');
		$d = explode('.',str_replace('http://','',base_url()));
   		if ($kode_unit == 0 && $d[0] == 'prodi') {
   			$kode_unit = '00';
   		}
   		$data['page'] = $this->page_model->get_data_page($kode_unit);
   		echo json_encode($data['page']);
   }
   public function get_data_page_by_id(){
   		$id_page = $this->input->post('id_page');
   		$data['page'] = $this->page_model->get_data_page_by_id($id_page);
   		echo json_encode($data['page']);
   }
   //TONI EFENDI 11/7/2018 <END>
}

/* End of file penjualan.php */
/* Location: ./application/modules/transaction/controllers/penjualan.php */
