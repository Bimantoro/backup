<?php

class Gallery extends CI_Controller {
  public $data= array();
	 function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
		$this->load->library('pagination');
		$this->load->model('page/page_model');
	}
	function album($uri=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Galeri', '/');
	 	$limit=10;
		$data['album'] = $this->page_model->select_album($limit,$uri)->result();
			
		$data['content']="page/gallery/album_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');
	}
	
	function pictures($id=0){
		$this->breadcrumb->append_crumb('Beranda', base_url());
		$this->breadcrumb->append_crumb('Galeri', site_url('page/gallery/album'));
		$this->breadcrumb->append_crumb('Album', '/');
		$data['id_album'] = $id;
		$data['pictures'] = array_slice(array_diff(scandir('./media/gallery/'.$id), array('.', '..', '.tmb','.quarantine')),0,40);

		$data['content']="page/gallery/pictures_view";
		$this->load->view('page/header',$data);
		$this->load->view('page/content');
		$this->load->view('page/footer');	
	}
	
	
	
}

