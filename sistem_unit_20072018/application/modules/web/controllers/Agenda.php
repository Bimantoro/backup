<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agenda extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('format_tanggal');
		$this->load->helper('text_manipulation');
		$this->load->library('pagination');
		$this->load->library('page_lib');
		$this->load->library('breadcrumb');
		$this->load->model('web/page_model');
		$this->load->helper('page');
		 $this->lang=$this->page_lib->lang();
	}
 
  
    public function index($uri=0,$th="",$bl=""){
		$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
		$this->breadcrumb->append_crumb(ucfirst(dict('Agenda',$this->lang)), '/');
		$limit=10;
		$data['agenda'] = $this->page_model->get_arsip_agenda($limit,(int)$uri,array('tahun'=>$th,'bulan'=>$bl));
		$data['sidebar']=array('search_sidebar', 'arsip_agenda_sidebar');
		$data['main_view']="web/agenda/arsip_view";				
		$this->load->view('web/content',$data);
   }
 
 
   public function detail($id=0){
      $get_data = $this->db->get_where("agenda",array('id_agenda'=>$id));
		$agenda = $get_data->row();

		//print_r($agenda);
		// $kode_unit = $this->session->userdata('kode_unit');
		//$kode_unit = $this->page_model->get_session_unit();
		if($get_data->num_rows()>0){
		 	$this->breadcrumb->append_crumb(ucfirst(dict('Beranda',$this->lang)), base_url($this->lang));
			$this->breadcrumb->append_crumb(ucfirst(dict('Agenda',$this->lang)), site_url($this->lang.'/agenda'));
			$this->breadcrumb->append_crumb(substr($agenda->nama_agenda,0,130).' ...', '/');
			$data['title']=$agenda->nama_agenda;
			$data['gambar'] = $agenda->lampiran;

			$icon = array('pdf', 'zip', 'rar', 'xls', 'xlsx', 'doc', 'docx');
			$extension = explode(".", $agenda->lampiran);
			$idx = count($extension) - 1;
			if (in_array($extension[$idx], $icon)) {
				$data['icon'] = base_url('asset/images/icon/'.$extension[1].'.png');
			}
			
			$data['folder'] = "agenda";
			$this->page_model->page_counter($id,'agenda');
			
			$data['d'] = $this->db->get_where('agenda',array('id_agenda'=>$id))->row();
			$arr_filter=array();
			$arr_filter=related_text($agenda->nama_agenda);	
			$filter	="id_agenda <> '".$id."' AND  (nama_agenda LIKE '%".rtrim(implode("%' OR nama_agenda LIKE '%",$arr_filter)," OR nama_agenda LIKE '%")."%')";
			//print_r($this->session->all_userdata()); die();


			 //$data['rec']=$this->db->query("SELECT id_agenda,nama_agenda,tgl_posting from agenda WHERE ".$filter."  ORDER BY tgl_posting desc LIMIT 0,5")->result();
			 //$data['pop']=$this->db->query("SELECT id_agenda,nama_agenda,tgl_posting from agenda where kode_unit=".$kode_unit." ORDER BY counter desc LIMIT 0,5")->result();



			$data['rec']=$this->page_model->get_agenda_terkait($filter, 0, 5);
			$data['pop']=$this->page_model->get_agenda_terpopuler(0, 5);

			$data['lang'] = $this->lang;

			$data['agenda']=$get_data->result();
			if($get_data->num_rows()>0){
				set_time_limit(0); 
				/* if($p->url!=null){
					/* redirect($p->url); */
					/* header('Location: '.$p->url); */
				/* }else{  */
					
					$arf=explode(".",$agenda->lampiran);
					$ext= strtolower(end($arf));
					$arr_ext=array('pdf','jpg');
					if(in_array($ext,$arr_ext)){
						$data['ext']=$ext;
					}
					$data['filetype']=$ext;	
					$data['sidebar']=array('search_sidebar', 'arsip_agenda_sidebar');
					$data['main_view']="web/agenda/detail_agenda";				
					$this->load->view('web/content',$data);
				}
		}else{
			
	      	redirect(base_url());
		}
    }
   function feed(){  
        $data['feed_name'] = ucfirst(dict('Agenda',$this->lang));  
        $data['encoding'] = 'utf-8';  
        $data['feed_url'] = site_url('page/agenda/feed');
        $data['feed_description'] = 'UIN Sunan Kalijaga Yogyakarta';  
        $data['page_language'] = 'en-en';  
        $data['agenda'] = $this->page_model->get_feed_agenda(10);      
        header("Content-Type: application/rss+xml");  
        $this->load->view('agenda/rss_agenda', $data);  
    }

    function download($id=0){
		$get_data = $this->db->get_where("agenda",array('id_agenda'=>$id));
		$p = $get_data->row();
		$this->output_file("./media/gambar/".$p->lampiran,''.$p->lampiran.''); 
		
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
 
/* End of file agenda.php */
