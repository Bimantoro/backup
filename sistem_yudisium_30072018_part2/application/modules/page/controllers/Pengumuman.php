<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengumuman extends CI_Controller {

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
		$data['title']="Pengumuman";
		$data['json_url']=site_url('admin/pengumuman/menu_json');
		$data['main_view']="admin/pengumuman/data_pengumuman";
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
	
	function download($id=0){
		$get_data = $this->db->get_where("pengumuman",array('id_pengumuman'=>$id));
		$p = $get_data->row();
		$this->output_file("./media/pengumuman/".$p->nama_file,''.$p->nama_file.''); 
		
	}
	
	function menu_json(){
		 $kode_unit = $this->session->userdata('kode_unit');
        $this->datatables->select("m1.id_pengumuman as id_pengumuman,m1.nama_pengumuman as nama_pengumuman,m1.nama_file as nama_file,m1.url as url,m1.tgl_posting as tgl_posting")
        ->add_column('action', '$1','m1.id_pengumuman')
        ->from("pengumuman as m1")->where('kode_unit', $kode_unit);
		/* ->join('berita as m2','m1.id_berita=m2.id_berita'); */
        
        echo $this->datatables->generate();
    }
	function add_pengumuman(){
		if($_POST==null){
			$data['title']="Input Pengumuman";
			$data['main_view']="admin/pengumuman/menu_form";
			$this->load->view('admin/content',$data);
		}else{
			$kode_unit = $this->session->userdata('kode_unit');
			$nama_pengumuman=$this->input->post('nama_pengumuman');
			$url=$this->input->post('url');
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
			
			if($_FILES['nama_file']['name']==null){
				$filename = '';
			}else{
				$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['nama_file']['name'];
			}

			
			move_uploaded_file($_FILES["nama_file"]["tmp_name"],"./media/gambar/".$filename);
			$data=array(
						'kode_unit'=>$kode_unit,
						'nama_pengumuman'=>$nama_pengumuman,
						'url'=>$url,
						'kode_bahasa'=>$bahasa,
						'nama_file'=>$filename,
						'tgl_posting'=>$tgl_posting
						);
			$qi=$this->db->insert('pengumuman',$data);
			if($qi){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil disimpan'));
				redirect('admin/pengumuman');
			}
		}	
	}
	function edit($id=""){
		if($_POST==NULL) {
			$data['pengumuman'] = $this->page_model->get_pengumuman2($id);
			$data['title']="Edit Pengumuman";
			$data['main_view']="admin/pengumuman/edit_pengumuman";
			$this->load->view('admin/content',$data);
		}else{	
				$nama_pengumuman = $this->input->post('nama_pengumuman');
				$url= $this->input->post('url');
				$kode_bahasa= $this->input->post('bahasa');
				$tgl_posting = date('Y-m-d h:i:s');
				$filename=$kode_unit.'_'.date('Ymd')."_".$_FILES['nama_file']['name'];
				move_uploaded_file($_FILES["photo"]["tmp_name"],"./media/gambar/".$filename);
					
				if($filename != null){
				$data = array(
				  'nama_pengumuman'=>$nama_pengumuman,
				  'url'=>$url,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>$tgl_posting,
				  'nama_file'=>$filename
				);
				}else{
				$data = array(
				  'nama_pengumuman'=>$nama_pengumuman,
				  'url'=>$url,
				  'kode_bahasa'=>$kode_bahasa,
				  'tgl_posting'=>$tgl_posting,
				  'nama_file'=>$filename
				);
				}
					
			if($this->db->where('id_pengumuman',$id)->update('pengumuman',$data)){
				$this->session->set_flashdata('msg', array('success', 'Data berhasil diperbaharui'));
				redirect('admin/pengumuman/index');
			}
		}			
	}
	function delete($id=""){
		$this->db->where('id_pengumuman',$id)->delete('pengumuman');
		$this->session->set_flashdata('msg', array('success', 'Data berhasil dihapus'));
				redirect('admin/pengumuman/index');
	}
   function feed(){  
		$data['feed_name'] = 'Pengumuman';  
		$data['encoding'] = 'utf-8';  
		$data['feed_url'] = site_url('page/pengumuman/feed');
		$data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
		$data['page_language'] = 'en-en';  
		$data['pengumuman'] = $this->page_model->get_feed_pengumuman(10);      
		header("Content-Type: application/rss+xml");  
		$this->load->view('pengumuman/rss_pengumuman', $data);  
	}
		
		
	function output_file($file, $name, $mime_type=''){
	 /*
	 This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
	 */
	 
	 //Check the file premission
	 if(!is_readable($file)) die('File not found or inaccessible!');
	 
	 $size = filesize($file);
	 $name = rawurldecode($name);
	 
	 /* Figure out the MIME type | Check in array */
	 $known_mime_types=array(
		"pdf" => "application/pdf",
		"txt" => "text/plain",
		"html" => "text/html",
		"htm" => "text/html",
		"exe" => "application/octet-stream",
		"zip" => "application/zip",
		"doc" => "application/msword",
		"xls" => "application/vnd.ms-excel",
		"ppt" => "application/vnd.ms-powerpoint",
		"gif" => "image/gif",
		"png" => "image/png",
		"jpeg"=> "image/jpg",
		"jpg" =>  "image/jpg",
		"php" => "text/plain"
	 );
	 
	 if($mime_type==''){
		 $file_extension = strtolower(substr(strrchr($file,"."),1));
		 if(array_key_exists($file_extension, $known_mime_types)){
			$mime_type=$known_mime_types[$file_extension];
		 } else {
			$mime_type="application/force-download";
		 };
	 };
	 
	 //turn off output buffering to decrease cpu usage
	 @ob_end_clean(); 
	 
	 // required for IE, otherwise Content-Disposition may be ignored
	 if(ini_get('zlib.output_compression'))
	  ini_set('zlib.output_compression', 'Off');
	 
	 header('Content-Type: ' . $mime_type);
	 header('Content-Disposition: attachment; filename="'.$name.'"');
	 header("Content-Transfer-Encoding: binary");
	 header('Accept-Ranges: bytes');
	 
	 /* The three lines below basically make the 
		download non-cacheable */
	 header("Cache-control: private");
	 header('Pragma: private');
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 
	 // multipart-download and download resuming support
	 if(isset($_SERVER['HTTP_RANGE']))
	 {
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
		list($range) = explode(",",$range,2);
		list($range, $range_end) = explode("-", $range);
		$range=intval($range);
		if(!$range_end) {
			$range_end=$size-1;
		} else {
			$range_end=intval($range_end);
		}
		/*
		------------------------------------------------------------------------------------------------------
		//This application is developed by www.webinfopedia.com
		//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
		------------------------------------------------------------------------------------------------------
		*/
		$new_length = $range_end-$range+1;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range-$range_end/$size");
	 } else {
		$new_length=$size;
		header("Content-Length: ".$size);
	 }
	 
	 /* Will output the file itself */
	 $chunksize = 1*(1024*1024); //you may want to change this
	 $bytes_send = 0;
	 if ($file = fopen($file, 'r'))
	 {
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);
	 
		while(!feof($file) && 
			(!connection_aborted()) && 
			($bytes_send<$new_length)
			  )
		{
			$buffer = fread($file, $chunksize);
			print($buffer); //echo($buffer); // can also possible
			flush();
			$bytes_send += strlen($buffer);
		}
	 fclose($file);
	 } else
	 //If no permissiion
	 die('Error - can not open file.');
	 //die
	die();
	}


	
}
 
/* End of file pengumuman.php */
